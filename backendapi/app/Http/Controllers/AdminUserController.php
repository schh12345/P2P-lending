<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use App\Models\Lender;
use App\Models\BorrowerBalance;
use App\Models\LenderBalance;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


class AdminUserController extends Controller
{
    /**
     * Get all users (borrowers and lenders) with filters, pagination, sorting.
     */
    public function getAllUsers(Request $request): JsonResponse
    {
        try {
            $status = $request->query('status', 'all'); // Default to 'all'
            $approval_status = $request->query('approval_status');
            $role = $request->query('role', 'all'); // Default to 'all'
            $page = (int) $request->query('page', 1);
            $perPage = (int) $request->query('per_page', 10);

            // Build borrowers query
            $borrowersQuery = Borrower::select([
                'id', 'first_name', 'last_name', 'email', 'phone_number',
                'income', 'credit_score', 'status', 'approval_status', 'created_at','identity_path','employment_path',
                'employment_status',
                DB::raw('"borrower" as table_type')
            ]);

            // Build lenders query
            $lendersQuery = Lender::select([
                'id', 'first_name', 'last_name', 'email', 'phone_number', 'status', 'approval_status', 'created_at',
                DB::raw('"lender" as table_type')
            ]);

            // Apply status filter if provided (and not 'all')
            if ($status && $status !== 'all') {
                $statusLower = strtolower($status);
                switch ($statusLower) {
                    case 'pending':
                    case 'approved':
                    case 'rejected':
                        $borrowersQuery->where('approval_status', ucfirst($statusLower));
                        $lendersQuery->where('approval_status', ucfirst($statusLower));
                        break;
                    case 'active':
                    case 'inactive':
                    case 'suspended':
                        $borrowersQuery->where('status', ucfirst($statusLower));
                        $lendersQuery->where('status', ucfirst($statusLower));
                        break;
                    default:
                        // Prevent returning users for unknown status
                        $borrowersQuery->whereRaw('0 = 1');
                        $lendersQuery->whereRaw('0 = 1');
                        break;
                }
            }

            // Role-specific fetching
            if ($role === 'borrower') {
                $users = $borrowersQuery->orderBy('created_at', 'desc')->paginate($perPage, ['*'], 'page', $page);

                return response()->json([
                    'users' => $users->items(),
                    'total' => $users->total(),
                    'current_page' => $users->currentPage(),
                    'per_page' => $users->perPage(),
                    'total_pages' => $users->lastPage()
                ]);

            } elseif ($role === 'lender') {
                $users = $lendersQuery->orderBy('created_at', 'desc')->paginate($perPage, ['*'], 'page', $page);

                return response()->json([
                    'users' => $users->items(),
                    'total' => $users->total(),
                    'current_page' => $users->currentPage(),
                    'per_page' => $users->perPage(),
                    'total_pages' => $users->lastPage()
                ]);

            } else {
                // When 'all' roles is selected, merge both tables (manual pagination)
                $borrowers = $borrowersQuery->get();
                $lenders = $lendersQuery->get();

                $usersCollection = $borrowers->merge($lenders)->sortByDesc('created_at')->values();

                // Manual pagination
                $total = $usersCollection->count();
                $totalPages = ceil($total / $perPage);
                $offset = ($page - 1) * $perPage;
                $paginatedUsers = $usersCollection->slice($offset, $perPage)->values();

                return response()->json([
                    'users' => $paginatedUsers,
                    'total' => $total,
                    'current_page' => $page,
                    'per_page' => $perPage,
                    'total_pages' => $totalPages
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Error fetching users: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to fetch users',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get specific user details.
     */
    public function getUser($type, $id): JsonResponse
    {
        try {
            if ($type === 'borrower') {
                $user = Borrower::select([
                    'id', 'first_name', 'last_name', 'email', 'phone_number',
                    'income', 'credit_score', 'status', 'approval_status',
                    'created_at', 'identity_path', 'employment_path', 'employment_status',
                    \DB::raw('"borrower" as table_type')
                ])->find($id);
            } elseif ($type === 'lender') {
                $user = Lender::select([
                    'id', 'first_name', 'last_name', 'email', 'phone_number',
                    'status', 'approval_status', 'created_at',
                    \DB::raw('"lender" as table_type')
                ])->find($id);
            } else {
                return response()->json(['error' => 'Invalid user type'], 400);
            }

            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            $userData = $user->toArray();

            // Point to frontendapi for file URLs
            $frontendUrl = rtrim(config('app.frontend_url', 'http://localhost:8000'), '/') . '/';

            if (!empty($userData['identity_path']) && !str_starts_with($userData['identity_path'], 'http')) {
                $userData['identity_path'] = $frontendUrl . ltrim($userData['identity_path'], '/');
            }

            if (!empty($userData['employment_path']) && !str_starts_with($userData['employment_path'], 'http')) {
                $userData['employment_path'] = $frontendUrl . ltrim($userData['employment_path'], '/');
            }

            $userData['user_display_status'] = $userData['approval_status'] !== 'Pending'
                ? $userData['approval_status']
                : $userData['status'];

            return response()->json(['user' => $userData]);

        } catch (\Exception $e) {
            \Log::error('Failed to get user: ' . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
    }


    /**
     * Approve user.
     */
    public function approveUser($type, $id): JsonResponse
    {
        try {
            if ($type === 'borrower') {
                $user = Borrower::find($id);
            } elseif ($type === 'lender') {
                $user = Lender::find($id);
            } else {
                return response()->json(['error' => 'Invalid user type'], 400);
            }

            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            $user->status = 'Active';
            $user->approval_status = 'Approved';
            Mail::to($user->email)->send(new notifyUser());
            $user->save();

            // Create balance record if it doesn't exist
            // $this->createBalanceRecord($type, $id);

            return response()->json([
                'message' => 'User approved successfully',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->first_name . ' ' . $user->last_name,
                    'status' => $user->status,
                    'approval_status' => $user->approval_status,
                    'type' => $type
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error approving user: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to approve user'], 500);
        }
    }

    /**
     * Reject user.
     */
    public function rejectUser($type, $id): JsonResponse
    {
        try {
            if ($type === 'borrower') {
                $user = Borrower::find($id);
            } elseif ($type === 'lender') {
                $user = Lender::find($id);
            } else {
                return response()->json(['error' => 'Invalid user type'], 400);
            }

            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            $user->status = 'Suspended';
            $user->approval_status = 'Rejected';
            $user->save();

            return response()->json([
                'message' => 'User rejected successfully',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->first_name . ' ' . $user->last_name,
                    'status' => $user->status,
                    'approval_status' => $user->approval_status,
                    'type' => $type
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error rejecting user: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to reject user'], 500);
        }
    }

    /**
     * Update user - handles both route patterns.
     */
    public function updateUser(Request $request, $table_type, $id): JsonResponse
    {
        try {
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone_number' => 'required|string|max:20',
                'status' => 'required|in:Active,Suspended,Inactive',
                'approval_status' => 'nullable|in:Pending,Approved,Rejected',
            ]);

            $user = $table_type === 'lender'
                ? Lender::findOrFail($id)
                : Borrower::findOrFail($id);

            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'status' => $request->status,
                'approval_status' => $request->approval_status,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User updated successfully',
                'user' => $user
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        } catch (\Exception $e) {
            \Log::error('Update user error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'User update failed. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * Delete user - handles both route patterns.
     */
    public function deleteUser(Request $request, $type = null, $id = null): JsonResponse
    {
        try {
            // Handle both route patterns: DELETE /users/{id} and DELETE /users/{type}/{id}
            if ($type === null && $id === null) {
                // Route pattern: DELETE /users/{id} - id is in the first parameter
                $id = $request->route('id');
                $request->validate([
                    'table_type' => 'required|in:lenders,borrowers',
                ]);
                $type = $request->table_type === 'lenders' ? 'lender' : 'borrower';
            }

            if ($type === 'borrower') {
                $user = Borrower::findOrFail($id);
            } elseif ($type === 'lender') {
                $user = Lender::findOrFail($id);
            } else {
                return response()->json(['error' => 'Invalid user type'], 400);
            }

            $userName = $user->first_name . ' ' . $user->last_name;
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => "User {$userName} deleted successfully"
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        } catch (\Exception $e) {
            Log::error('Delete user error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'User deletion failed. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update user status.
     */
    public function updateUserStatus(Request $request, $type, $id): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:Pending,Approved,Suspended,Active,Inactive'
        ]);

        try {
            if ($type === 'borrower') {
                $user = Borrower::find($id);
            } elseif ($type === 'lender') {
                $user = Lender::find($id);
            } else {
                return response()->json(['error' => 'Invalid user type'], 400);
            }

            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            $user->status = $request->status;
            $user->save();

            // Create balance record if status is being set to Active
            if ($request->status === 'Active') {
                $this->createBalanceRecord($type, $id);
            }

            return response()->json([
                'message' => 'User status updated successfully',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->first_name . ' ' . $user->last_name,
                    'status' => $user->status,
                    'type' => $type
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating user status: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to update user status'], 500);
        }
    }

    /**
     * Create balance record on approval if it does not exist.
     */
    private function createBalanceRecord($type, $id): void
    {
        try {
            if ($type === 'borrower' && !BorrowerBalance::where('borrowerID', $id)->exists()) {
                BorrowerBalance::create(['borrowerID' => $id, 'balance' => 0.00]);
            } elseif ($type === 'lender' && !LenderBalance::where('LenderID', $id)->exists()) {
                LenderBalance::create(['LenderID' => $id, 'balance' => 0.00]);
            }
        } catch (\Exception $e) {
            Log::error('Create balance record error: ' . $e->getMessage());
        }
    }

    /**
     * Get user statistics for dashboard.
     */
    public function getStatistics(): JsonResponse
    {
        try {
            $borrowerStats = [
                'total' => Borrower::count(),
                'pending' => Borrower::where('status', 'Pending')->count(),
                'approved' => Borrower::where('status', 'Approved')->count(),
                'active' => Borrower::where('status', 'Active')->count(),
                'suspended' => Borrower::where('status', 'Suspended')->count(),
            ];

            $lenderStats = [
                'total' => Lender::count(),
                'pending' => Lender::where('status', 'Pending')->count(),
                'approved' => Lender::where('status', 'Approved')->count(),
                'active' => Lender::where('status', 'Active')->count(),
                'suspended' => Lender::where('status', 'Suspended')->count(),
            ];

            return response()->json([
                'borrowers' => $borrowerStats,
                'lenders' => $lenderStats,
                'total_users' => $borrowerStats['total'] + $lenderStats['total'],
                'total_pending' => $borrowerStats['pending'] + $lenderStats['pending']
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching statistics: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch statistics'], 500);
        }
    }

    /**
     * Dashboard index method (moved from DashboardController).
     */
    public function index(): JsonResponse
    {
        try {
            // Get statistics
            $stats = $this->getStatistics();
            $statsData = json_decode($stats->getContent(), true);

            // You can add more dashboard data here as needed
            $dashboardData = [
                'statistics' => $statsData,
                'recent_users' => $this->getRecentUsers(),
                // Add other dashboard data as needed
            ];

            return response()->json($dashboardData);

        } catch (\Exception $e) {
            Log::error('Error loading dashboard: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load dashboard'], 500);
        }
    }

    /**
     * Get recent users for dashboard.
     */
    private function getRecentUsers($limit = 10)
    {
        try {
            $recentBorrowers = Borrower::select([
                'id', 'first_name', 'last_name', 'email', 'status', 'approval_status', 'created_at',
                DB::raw('"borrower" as table_type')
            ])->latest()->take($limit/2)->get();

            $recentLenders = Lender::select([
                'id', 'first_name', 'last_name', 'email', 'status', 'approval_status', 'created_at',
                DB::raw('"lender" as table_type')
            ])->latest()->take($limit/2)->get();

            return $recentBorrowers->merge($recentLenders)->sortByDesc('created_at')->take($limit)->values();

        } catch (\Exception $e) {
            Log::error('Error fetching recent users: ' . $e->getMessage());
            return collect();
        }
    }

    /**
     * Bulk actions for multiple users.
     */
    public function bulkAction(Request $request): JsonResponse
    {
        $request->validate([
            'action' => 'required|in:approve,reject,delete',
            'users' => 'required|array',
            'users.*.type' => 'required|in:borrower,lender',
            'users.*.id' => 'required|integer'
        ]);

        $results = [];
        $errors = [];

        foreach ($request->users as $userData) {
            try {
                switch ($request->action) {
                    case 'approve':
                        $result = $this->approveUser($userData['type'], $userData['id']);
                        break;
                    case 'reject':
                        $result = $this->rejectUser($userData['type'], $userData['id']);
                        break;
                    case 'delete':
                        $result = $this->deleteUser(new Request(), $userData['type'], $userData['id']);
                        break;
                }

                if ($result->getStatusCode() === 200) {
                    $results[] = json_decode($result->getContent(), true);
                } else {
                    $errors[] = "Failed to {$request->action} user {$userData['type']}:{$userData['id']}";
                }
            } catch (\Exception $e) {
                $errors[] = "Error processing user {$userData['type']}:{$userData['id']}: " . $e->getMessage();
            }
        }

        return response()->json([
            'message' => 'Bulk action completed',
            'successful' => count($results),
            'failed' => count($errors),
            'results' => $results,
            'errors' => $errors
        ]);
    }

    public function getDashboardStats(Request $request): JsonResponse
    {
        try {
            // Count borrowers by status
            $borrowersCount = Borrower::where('status', 'Active')->count();

            // Count lenders by status
            $lendersCount = Lender::where('status', 'Active')->count();

            $totalActiveUsers = $borrowersCount + $lendersCount;


            $loanRequestsCount = DB::table('loan_requests')->count();

            $approvedLoansCount = DB::table('loans')->where('status', 'Active')->count();
            return response()->json([
                'success' => true,
                'data' => [
                    'activeUsers' => $totalActiveUsers,
                    'loanRequests' => $loanRequestsCount,
                    'approvedLoans' => $approvedLoansCount,
                ]
            ]);

        }
        catch (\Exception $e) {
            Log::error('Error fetching stats: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch statistics'], 500);}
    }

}
