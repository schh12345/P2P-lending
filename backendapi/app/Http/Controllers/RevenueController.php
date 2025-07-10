<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Revenue;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class RevenueController extends Controller
{
    /**
     * Get monthly revenue data (daily breakdown for current month)
     */
    public function getMonthlyRevenue(Request $request): JsonResponse
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        // Get daily revenue for the current month
        $revenues = Revenue::selectRaw('DAY(date) as day, SUM(amount) as total')
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        // Fill in missing days with zero values
        $daysInMonth = Carbon::now()->daysInMonth;
        $revenueByDay = collect(range(1, $daysInMonth))->map(function ($day) use ($revenues) {
            $dayData = $revenues->firstWhere('day', $day);
            return [
                'day' => $day,
                'total' => $dayData ? (float) $dayData->total : 0
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $revenueByDay,
            'period' => 'month',
            'meta' => [
                'month' => Carbon::now()->format('F Y'),
                'total_days' => $daysInMonth
            ]
        ]);
    }

    /**
     * Get yearly revenue data (monthly breakdown for current year)
     */
    public function getYearlyRevenue(Request $request): JsonResponse
    {
        $currentYear = now()->year;

        // Get monthly revenue for the current year
        $revenues = Revenue::selectRaw('MONTH(date) as month, SUM(amount) as total')
            ->whereYear('date', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Fill in missing months with zero values
        $revenueByMonth = collect(range(1, 12))->map(function ($month) use ($revenues) {
            $monthData = $revenues->firstWhere('month', $month);
            return [
                'month' => $month,
                'month_name' => Carbon::create()->month($month)->format('M'),
                'total' => $monthData ? (float) $monthData->total : 0
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $revenueByMonth,
            'period' => 'year',
            'meta' => [
                'year' => $currentYear,
                'total_months' => 12
            ]
        ]);
    }

    /**
     * Get daily revenue data (hourly breakdown for current day)
     */
    public function getDailyRevenue(Request $request): JsonResponse
    {
        $today = now()->toDateString();

        // Get hourly revenue for today
        $revenues = Revenue::selectRaw('HOUR(created_at) as hour, SUM(amount) as total')
            ->whereDate('date', $today)
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();

        // Fill in missing hours with zero values
        $revenueByHour = collect(range(0, 23))->map(function ($hour) use ($revenues) {
            $hourData = $revenues->firstWhere('hour', $hour);
            return [
                'hour' => $hour,
                'hour_label' => sprintf('%02d:00', $hour),
                'total' => $hourData ? (float) $hourData->total : 0
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $revenueByHour,
            'period' => 'day',
            'meta' => [
                'date' => Carbon::today()->format('Y-m-d'),
                'date_formatted' => Carbon::today()->format('F j, Y'),
                'total_hours' => 24
            ]
        ]);
    }

    /**
     * Get revenue data based on period parameter
     */
    public function getRevenue(Request $request): JsonResponse
    {
        $period = $request->get('period', 'month');

        switch ($period) {
            case 'day':
                return $this->getDailyRevenue($request);
            case 'year':
                return $this->getYearlyRevenue($request);
            case 'month':
            default:
                return $this->getMonthlyRevenue($request);
        }
    }

    /**
     * Get revenue statistics summary
     */
    public function getRevenueStats(Request $request): JsonResponse
    {
        $period = $request->get('period', 'month');
        $currentYear = now()->year;
        $currentMonth = now()->month;

        switch ($period) {
            case 'day':
                $totalRevenue = Revenue::whereDate('date', now()->toDateString())->sum('amount');
                $previousTotal = Revenue::whereDate('date', now()->subDay()->toDateString())->sum('amount');
                break;

            case 'year':
                $totalRevenue = Revenue::whereYear('date', $currentYear)->sum('amount');
                $previousTotal = Revenue::whereYear('date', $currentYear - 1)->sum('amount');
                break;

            case 'month':
            default:
                $totalRevenue = Revenue::whereMonth('date', $currentMonth)
                    ->whereYear('date', $currentYear)
                    ->sum('amount');
                $previousTotal = Revenue::whereMonth('date', $currentMonth - 1)
                    ->whereYear('date', $currentYear)
                    ->sum('amount');
                break;
        }

        // Calculate percentage change
        $percentageChange = 0;
        if ($previousTotal > 0) {
            $percentageChange = (($totalRevenue - $previousTotal) / $previousTotal) * 100;
        }

        return response()->json([
            'success' => true,
            'data' => [
                'total_revenue' => (float) $totalRevenue,
                'previous_period_total' => (float) $previousTotal,
                'percentage_change' => round($percentageChange, 2),
                'trend' => $percentageChange >= 0 ? 'up' : 'down'
            ],
            'period' => $period
        ]);
    }
}
