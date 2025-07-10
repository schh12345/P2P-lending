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

            $query = DB::table('loanRequest')
                ->leftJoin('borrowers', 'loanRequest.borrower_id', '=', 'borrowers.id')
                ->select(
                    'loanRequest.request_id',
                    'loanRequest.borrower_id',
                    'loanRequest.request_duration',
                    'loanRequest.request_amount',
                    'loanRequest.request_reason',
                    'loanRequest.status',
                    'loanRequest.created_at',
                    'loanRequest.updated_at',
                    'borrowers.first_name as borrower_firstname',
                    'borrowers.last_name as borrower_lastname',
                    'borrowers.email as borrower_email',
                    'borrowers.phone_number as borrower_phone',
                    'borrowers.credit_score as borrower_credit_score'
                );

            if ($status) {
                $query->where('loanRequest.status', $status);
            }

            if ($borrowerID) {
                $query->where('loanRequest.borrower_id', $borrowerID);
            }

            if ($reason) {
                $query->where('loanRequest.request_reason', 'LIKE', '%' . $reason . '%');
            }

            if ($amount) {
                $query->where('loanRequest.request_amount', '=', $amount);
            }

            $totalPending = DB::table('loanRequest')->where('status', 'Pending')->count();
            $totalApproved = DB::table('loanRequest')->where('status', 'Approved')->count();
            $totalRejected = DB::table('loanRequest')->where('status', 'Rejected')->count();
            $totalRequests = DB::table('loanRequest')->count();
            $totalAmount = DB::table('loanRequest')->sum('request_amount');
            $loanRequests = $query->orderBy('loanRequest.created_at', 'desc')
                ->paginate(10);
            $totalApprovedAmount = DB::table('loanRequest')
                ->where('status', 'Approved')
                ->sum('request_amount');

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
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve loan requests',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function approveLoanRequest(Request $request, $requestID)
    {
        try {
            $loanRequest = DB::table('loanRequest')->where("request_id", $requestID)->first();

            if (!$loanRequest) {
                return response()->json([
                    'success' => false,
                    'message' => 'Loan request not found',
                ], 404);
            }

            // Update loan request status to Approved
            $updateData = [
                'status' => 'Approved',
                'approved_at' => now(),
                'updated_at' => now(),
            ];

            DB::table('loanRequest')->where("request_id", $requestID)->update($updateData);

            // Check if a loan has already been created for this request
            $existingLoan = DB::table('loans')
                ->where('BorrowerID', $loanRequest->borrower_id)
                ->where('request_amount', $loanRequest->request_amount)
                ->where('request_duration', $loanRequest->request_duration)
                ->where('request_reason', $loanRequest->request_reason)
                ->first();

            if (!$existingLoan) {
                // Insert new loan
                $newLoanId = DB::table('loans')->insertGetId([
                    'BorrowerID' => $loanRequest->borrower_id,
                    'request_id' => $loanRequest->request_id,
                    'request_duration' => (int) $loanRequest->request_duration,
                    'request_reason' => $loanRequest->request_reason,
                    'request_amount' => $loanRequest->request_amount,
                    'interest_rate' => 5.0,
                    'status' => 'Active',
                    'approved_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $newLoan = DB::table('loans')->where('id', $newLoanId)->first();
            } else {
                $newLoan = $existingLoan;
            }

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
            $loanRequest = DB::table('loanRequest')->where('request_id', $requestID)->first();

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

            DB::table('loanRequest')->where('request_id', $requestID)->update($updateData);

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

    public function getLoanRequestById($id)
    {
        try {
            $request = LoanRequest::with('borrower')->findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Loan request retrieved successfully',
                'data' => [
                    'request_id' => $request->request_id,
                    'borrower_id' => $request->borrower_id,
                    'request_duration' => $request->request_duration,
                    'request_amount' => $request->request_amount,
                    'request_reason' => $request->request_reason,
                    'status' => $request->status,
                    'created_at' => $request->created_at,
                    'updated_at' => $request->updated_at,
                    'borrower_firstname' => $request->borrower->first_name ?? null,
                    'borrower_lastname' => $request->borrower->last_name ?? null,
                    'borrower_email' => $request->borrower->email ?? null,
                    'borrower_phone' => $request->borrower->phone_number ?? null,
                    'borrower_credit_score' => $request->borrower->credit_score ?? null,
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
            $loanRequest = DB::table('loanRequest')->where('request_id', $id)->first();

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


}
