<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\LoanRequest;

class LoanRequestController extends Controller
{
    public function getAllLoanRequests(Request $request)
{
    try {
        $status = $request->query('status');
        $amount = $request->query('amount');
        $borrowerID = $request->query('borrower_id');
        $reason = $request->query('reason');
        $borrower_firstname = $request->query('borrower_firstname');
        $borrower_lastname = $request->query('borrower_lastname');

        // Build query - Fix the column names to match your database
        $query = DB::table('loan_requests')
            ->leftJoin('borrowers', 'loan_requests.BorrowerID', '=', 'borrowers.id') // Changed borrower_id to BorrowerID
            ->select(
                'loan_requests.request_id',
                'loan_requests.BorrowerID as borrower_id', // Alias for consistency
                'loan_requests.request_duration',
                'loan_requests.request_amount',
                'loan_requests.request_reason',
                'loan_requests.status',
                'loan_requests.created_at',
                'loan_requests.updated_at',
                'borrowers.first_name as borrower_firstname',
                'borrowers.last_name as borrower_lastname',
                'borrowers.email as borrower_email',
                'borrowers.phone_number as borrower_phone',
                'borrowers.credit_score as borrower_credit_score'
            );

        // Apply filters - Update column references
        if ($status) {
            $query->where('loan_requests.status', $status);
        }

        if ($borrowerID) {
            $query->where('loan_requests.BorrowerID', $borrowerID); // Changed column name
        }

        if ($reason) {
            $query->where('loan_requests.request_reason', 'LIKE', '%' . $reason . '%');
        }

        if ($amount) {
            $query->where('loan_requests.request_amount', '=', $amount);
        }

        if ($borrower_firstname) {
            $query->where('borrowers.first_name', 'LIKE', '%' . $borrower_firstname . '%');
        }

        if ($borrower_lastname) {
            $query->where('borrowers.last_name', 'LIKE', '%' . $borrower_lastname . '%');
        }

        // Fetch stats
        $totalPending = DB::table('loan_requests')->where('status', 'Pending')->count();
        $totalApproved = DB::table('loan_requests')->where('status', 'Approved')->count();
        $totalRejected = DB::table('loan_requests')->where('status', 'Rejected')->count();
        $totalRequests = DB::table('loan_requests')->count();
        $totalApprovedAmount = DB::table('loan_requests')->where('status', 'Approved')->sum('request_amount');

        // Paginate results
        $loanRequests = $query->orderBy('loan_requests.created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Loan requests retrieved successfully',
            'data' => $loanRequests,
            'stats' => [
                'total' => $totalRequests,
                'pending' => $totalPending,
                'approved' => $totalApproved,
                'rejected' => $totalRejected,
                'total_amount' => $totalApprovedAmount,
            ],
            'filters' => [
                'borrower_id' => $borrowerID,
                'borrower_first_name' => $borrower_firstname,
                'borrower_last_name' => $borrower_lastname,
                'reason' => $reason,
                'amount' => $amount,
                'status' => $status,
            ]
        ], 200);

    } catch (\Exception $e) {
        \Log::error('Error in getAllLoanRequests: ' . $e->getMessage(), ['exception' => $e]);
        return response()->json([
            'success' => false,
            'message' => 'Failed to retrieve loan requests',
            'error' => $e->getMessage(),
        ], 500);
    }
}


    public function approveLoanRequest(Request $request, $requestID)
    {
        DB::beginTransaction();

        try {
            // Fetch the loan request by ID
            $loanRequest = DB::table('loan_requests')->where('request_id', $requestID)->first();

            if (!$loanRequest) {
                return response()->json([
                    'success' => false,
                    'message' => 'Loan request not found',
                ], 404);
            }

            // Update the loan request status to 'Approved'
            $updateData = [
                'status' => 'Approved',
                'approved_at' => now(),
                'updated_at' => now(),
            ];

            DB::table('loan_requests')->where('request_id', $requestID)->update($updateData);
            $interestRate = 5.0;
            $total =round( $loanRequest->request_amount + ($loanRequest->request_amount * $interestRate / 100) * ($loanRequest->request_duration/30), 2);

            // Insert new loan record in loans table
            $newLoanId = DB::table('loans')->insertGetId([
                'BorrowerID' => $loanRequest->BorrowerID,
                'request_id' => $loanRequest->request_id,
                'request_duration' => (int) $loanRequest->request_duration,
                'request_reason' => $loanRequest->request_reason,
                'request_amount' => $loanRequest->request_amount,
                'interest_rate' => $interestRate,
                'total' => $total,
                'status' => 'Active',
                'approved_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Retrieve the newly inserted loan data for response
            $newLoan = DB::table('loans')->where('id', $newLoanId)->first();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Loan request approved and loan created successfully',
                'data' => [
                    'request_id' => $requestID,
                    'status' => 'Approved',
                    'approved_at' => $updateData['approved_at'],
                    'loan' => $newLoan,
                ]
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            // Log the error for debugging
            \Log::error('Loan approval failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to approve loan request and create loan',
                'error' => $e->getMessage(),
            ], 500);
        }
    }



    public function rejectLoanRequest(Request $request, $requestID)
    {
        try {
            $loanRequest = DB::table('loan_requests')->where('request_id', $requestID)->first();

            if (!$loanRequest) {
                return response()->json([
                    'success' => false,
                    'message' => 'Loan request not found',
                ], 404);
            }


            $updateData = [
                'status' => 'Rejected',
                'updated_at' => now(),
            ];

            DB::table('loan_requests')->where('request_id', $requestID)->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Loan request rejected successfully',
                'data' => [
                    'request_id' => $requestID,
                    'status' => 'Rejected',
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to reject loan request',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function getActiveLoans()
    {
        try {
            $activeLoans = DB::table('loans')
                ->where('status', 'Active')
                ->orderBy('approved_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Active loans retrieved successfully',
                'data' => $activeLoans,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve active loans',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getLoanRequestById($requestId)
    {
        try {
            $request = LoanRequest::with('borrower')->where('request_id', $requestId)->firstOrFail();

            return response()->json([
                'success' => true,
                'message' => 'Loan request retrieved successfully',
                'data' => [
                    'request_id' => $request->request_id,
                    'borrower_id' => $request->BorrowerID,
                    'request_duration' => $request->request_duration,
                    'request_amount' => $request->request_amount,
                    'request_reason' => $request->request_reason,
                    'status' => $request->status,
                    'created_at' => $request->created_at,
                    'updated_at' => $request->updated_at,
                    'borrower' => [
                        'first_name' => $request->borrower->first_name ?? null,
                        'last_name' => $request->borrower->last_name ?? null,
                        'email' => $request->borrower->email ?? null,
                        'phone_number' => $request->borrower->phone_number ?? null,
                        'credit_score' => $request->borrower->credit_score ?? null,
                    ],
                ],
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve loan request',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function showLoanAfterApprove($requestID)
    {
        $loan = DB::table('loan_after_approves')
            ->join('borrowers', 'loan_after_approves.borrower_id', '=', 'borrowers.id')
            ->join('lenders', 'loan_after_approves.lender_id', '=', 'lenders.id')
            ->where('loan_after_approves.request_id', $requestID) // <-- change here
            ->select(
                'loan_after_approves.*',
                'borrowers.firstname as borrower_firstname',
                'borrowers.lastname as borrower_lastname',
                'borrowers.email as borrower_email',
                'borrowers.credit_score as borrower_credit_score',
                'lenders.firstname as lender_firstname',
                'lenders.lastname as lender_lastname',
                'lenders.email as lender_email'
            )
            ->first();

        if (!$loan) {
            return response()->json([
                'success' => false,
                'message' => 'Loan not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $loan,
        ]);
    }
    public function getLoanStatusById($id)
    {
        try {
            $loanRequest = DB::table('loan_requests')->where('request_id', $id)->first();

            if (!$loanRequest) {
                return response()->json([
                    'success' => false,
                    'message' => 'Loan request not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'request_id' => $loanRequest->request_id,
                    'status' => $loanRequest->status,
                ],
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve loan status',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function getLoanById($id)
    {
        try {
            $loan = DB::table('loans')->where('id', $id)->first();

            if (!$loan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Loan not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $loan,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve loan',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function getLoanByRequestId($requestId)
    {
        try {
            $loan = DB::table('loan_requests')->where('request_id', $requestId)->first();

            if (!$loan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Loan not found for request ID',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $loan,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve loan by request ID',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}
