<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use App\Models\LenderBalance;
use App\Models\Loan;
use App\Models\loan_after_approve;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LenderApi extends Controller
{
    public function changePhoneNumber(Request $request) {
        $validated = $request->validate([
            'id' => 'required',
            'phone_number' => 'required'
        ]);
        $user = Lender::find($request->id);
        $user->phone_number = $request->phone_number;
        $user->save();
        return response()->json(['message' => 'Phone Number updated successfully']);
    }
    public function changePassword(Request $request) {
        //need user to input old password then compare if it is right
        $validated = $request->validate([
            'id' => 'required',
            'current_password' => 'required',
            'new_password' => 'required'
        ]);
        $user = Lender::find($request->id);
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 400);
        }
        $user->password = Hash::make($request->new_password);
        $user->save();
        return response()->json(['message' => 'Password updated successfully']);

    }
    public function changeEmail(Request $request) {
        $validated = $request->validate([
            'id' => 'required',
            'email' => 'required'
        ]);
        $user = Lender::find($request->id);
        $user->email = $request->email;
        $user->save();
        return response()->json(['message' => 'Email updated successfully']);

    }
    public function changeName(Request $request) {
        $validated = $request->validate([
            'id' => 'required',
            'current_last_name' => 'required',
            'current_first_name' => 'required'
        ]);
        $user = Lender::find($request->id);
        $user->last_name = $request->last_name;
        $user->last_name = $request->first_name;
        $user->save();
        return response()->json(['message' => 'Name updated successfully']);
    }

    public function listLoanAccept() {
        return response()->json([

            "loan" => loan_after_approve::all()
        ]);
    }
    public function lenderAcceptLoan(Request $request) {
        $loan = Loan::find($request->id);
        $loanCopy = loan_after_approve::create([
            'amount' => $loan->request_amount,
            'duration' => $loan->request_duration,
            'reason' => $loan->request_reason,
            'interest_rate' => $loan->interest_rate,
            'BorrowerID' => $loan->BorrowerID,
            'LenderID' => Auth::guard('lender')->id(),
            'payment_date' => Carbon::now()->addDays($loan->request_duration),
        ]);

        return response()->json([
            "Lender ID" => $loanCopy->LenderID,
            "Borrower ID" => $loanCopy->BorrowerID,
            "Amount" => $loanCopy->amount,
            "Interest Rate" => $loanCopy->interest_rate,
            "Payment Date" => $loanCopy->payment_date
        ]);

    }
    public function registerLender(Request $request) {
        $randomNumber = mt_rand(100000, 999999);
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'phone_number' => 'required'
        ]);
        $user = Lender::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone_number' => $validated['phone_number'],
            'otp' => $randomNumber,
            'amount' => 0,
            'status' => 'Inactive'

        ]);

        LenderBalance::create([
            'balance'=>10000,
            'LenderID'=>$user->id,
        ]);
    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
        'lender' => $user,
        'token' => $token,
    ]);
    }

    public function loginLender(Request $request) {
        //query database : user table : field email
        $user = Lender::where('email', $request->email)->first();

        //check if the password user entered is the same as the one in db
        //and also check if user exist or not
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        return ['token' => $user->createToken('api-token')->plainTextToken];
    }
    public function listAllLender() {
        $value = Lender::all();
        return response()->json([
            'job' => $value,
        ],
            200
        );
    }
    public function logoutLender(Request $request) {
        $request->user('lender')->tokens()->delete();
        return [
            "message" => "you are logged out"
        ];
    }
    public function verifyOTPLender(Request $request) {
        $user = $request->user('lender');
        //if ($request->user()->tokens()) {
        if(!$user || !$user->currentAccessToken()) {
            return response()->json([
                'message' => 'wrong token'
            ]);
        }
        $request->validate([
            'otp' => 'required'
        ]);

        if ($user->otp === $request->otp) {
            return response()->json([

                'message' => 'otp verified'

            ]);
        } else {
            return response()->json([
                'message' => 'invalid otp'
            ]);
        }


        //return response()->json(['message' => 'otp verified']);
    }
}
