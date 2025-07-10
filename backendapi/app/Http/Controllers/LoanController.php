<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LoanController extends Controller
{
    /**
     * List all loans.
     */
    public function index(): JsonResponse
    {
        $loans = Loan::all();
        return response()->json($loans, 200);
    }

    /**
     * Store a new loan.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1000',
            'interest_rate' => 'required|numeric|min:0|max:100',
            'repayment_schedule' => 'required|string',
        ]);

        $loan = Loan::create($validated);

        return response()->json([
            'message' => 'Loan created successfully.',
            'loan' => $loan
        ], 201);
    }

    /**
     * Show specific loan.
     */
    public function show($id): JsonResponse
    {
        $loan = Loan::find($id);

        if (!$loan) {
            return response()->json(['error' => 'Loan not found.'], 404);
        }

        return response()->json($loan, 200);
    }

    /**
     * Update loan data.
     */
    public function update(Request $request, Loan $loan): JsonResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,active,completed',
            'interest_rate' => 'required|numeric|min:0|max:100',
            'repayment_schedule' => 'required|string',
        ]);

        $loan->update($validated);

        return response()->json([
            'message' => 'Loan updated successfully.',
            'loan' => $loan
        ], 200);
    }

    /**
     * Delete a loan.
     */
    public function destroy(Loan $loan): JsonResponse
    {
        $loan->delete();

        return response()->json(['message' => 'Loan deleted successfully.'], 200);
    }
    /**
     * Filter loans by status.
     */

    public function filter($status): JsonResponse
    {
        $loans = Loan::where('status', $status)->get();

        return response()->json($loans, 200);
    }

    public function getActiveLoans($table_type, $id)
    {
        if ($table_type === 'borrower') {
            $loans = Loan::where('borrower_id', $id)->where('status', 'Active')->get();
        } else {
            $loans = Loan::where('lender_id', $id)->where('status', 'Active')->get();
        }

        $activeLoans = $loans->count();
        $totalAmount = $loans->sum('amount');

        return response()->json([
            'active_loans' => $activeLoans,
            'total_amount' => $totalAmount
        ]);
    }
}
