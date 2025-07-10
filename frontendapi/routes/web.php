<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\LoginController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\LoanRequestController;
use PhpParser\Node\Stmt\Return_;

Route::get('/', function () {
    return view('home');
});

// sign up
Route::get('sign-up', function() {
    return view('sign-up');
});

// log in
Route::get('log-in', function() {
    return view('log-in');
});

// otp verify
Route::get('/otp-verify', function() {
    return view('otp-verify');
});
// fill extra info
Route::get('/fill-extra-info', function() {
    return view('fill-extra-info');
});


Route::get('/register', [LoginController::class, 'showRegister']);
Route::post('/register', [LoginController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/dashboard', function(){
    return view('LoginPage.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/email/verify', function(){
    return view('auth.verify-email');
}) ->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function(EmailVerificationRequest $request){
    $request->fulfill();


    return redirect('/welcome');
}) -> middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function(Request $request){
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'verification link sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::get('/admin/users', [AdminUserController::class, 'index'])->middleware('auth');

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::patch('/users/{user}/verify', [AdminUserController::class, 'verify'])->name('admin.users.verify');
    Route::patch('/users/{user}/approve', [AdminUserController::class, 'approve'])->name('admin.users.approve');
    Route::patch('/users/{user}/suspend', [AdminUserController::class, 'suspend'])->name('admin.users.suspend');
});


Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('loans', LoanController::class);
});

Route::get('requestLoan', function(){

    return view('LoanRequest.request');
}
);
Route::post('requestLoan', [LoanRequestController::class, 'requestLoan'])->name('requestLoan');
Route::get('adminLogin', function(){
    return view('admin.Login.login');
});
Route::post('adminLogin', [AdminUserController::class, 'adminLogin'] );


Route::get('displayLoan', [LoanRequestController::class, 'displayLoan']);

Route::post('admin/loan/{id}/update', [LoanRequestController::class, 'updateLoan'])->name('admin.loan.update');

Route::get('admin/{action}', function(){
});
Route::post('admin/{action}', [LoanRequestController::class, 'adminLogin']);

Route::middleware(['auth'])->group(function () {
    Route::get('/verify-otp-form', [LoginController::class, 'showOTP'])->name('otp.verify.form');
    Route::post('/verify-otp', [LoginController::class, 'verifyOTP'])->name('otp.verify');
    Route::post('/resend-otp', [LoginController::class, 'resendOtp'])->name('otp.resend');
});




