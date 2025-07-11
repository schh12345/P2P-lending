<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\LoanRequestController;
use App\Http\Controllers\RevenueController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminAuthController;


Route::prefix('admin')->group(function () {

    // Public (no authentication required)
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::get('/signup', [AdminAuthController::class, 'showSignupPage']);

    // Protected (authentication required)
    Route::middleware(['auth:sanctum'])->group(function () {

        Route::post('/logout', [AdminAuthController::class, 'logout']);

        // Dashboard
        Route::get('/dashboard', [AdminUserController::class, 'index']);
        Route::get('/dashboard/stats', [AdminUserController::class, 'getDashboardStats']);

        // User management routes
        Route::get('/users', [AdminUserController::class, 'getAllUsers']);
        Route::get('/userCounts', [AdminUserController::class, 'getUserCounts']);
        Route::get('/statistics', [AdminUserController::class, 'getStatistics']);
        Route::put('/users/{id}', [AdminUserController::class, 'updateUser']);
        Route::put('/users/{table_type}/{id}', [AdminUserController::class, 'updateUser']);
        Route::delete('/users/{id}', [AdminUserController::class, 'deleteUser']);

        // Admin-Actions Routes
        Route::get('/users/{type}/{id}', [AdminUserController::class, 'getUser'])->where([
            'type' => 'borrower|lender', 'id' => '[0-9]+'
        ]);
        Route::post('/users/{type}/{id}/approve', [AdminUserController::class, 'approveUser'])->where([
            'type' => 'borrower|lender', 'id' => '[0-9]+'
        ]);
        Route::post('/users/{type}/{id}/reject', [AdminUserController::class, 'rejectUser'])->where([
            'type' => 'borrower|lender', 'id' => '[0-9]+'
        ]);
        Route::patch('/users/{type}/{id}/status', [AdminUserController::class, 'updateUserStatus'])->where([
            'type' => 'borrower|lender', 'id' => '[0-9]+'
        ]);
        Route::delete('/users/{type}/{id}', [AdminUserController::class, 'deleteUser'])->where([
            'type' => 'borrower|lender', 'id' => '[0-9]+'
        ]);

        // Bulk actions
        Route::post('/users/bulk-action', [AdminUserController::class, 'bulkAction']);

        // Loan management
        Route::get('/active-loans', [LoanRequestController::class, 'getActiveLoans']);
        Route::get('/loan-after-approves/{id}', [LoanRequestController::class, 'showLoanAfterApprove']);
        Route::get('/loan-requests', [LoanRequestController::class, 'getAllLoanRequests']);
        Route::put('/loan-requests/{requestID}/approve', [LoanRequestController::class, 'approveLoanRequest']);
        Route::put('/loan-requests/{requestID}/reject', [LoanRequestController::class, 'rejectLoanRequest']);
        Route::get('/loan-requests/{id}', [LoanRequestController::class, 'getLoanRequestById']);
        Route::get('/loan-requests/{id}/status', [LoanRequestController::class, 'getLoanStatusById']);
        Route::get('/loans/{id}', [LoanRequestController::class, 'getLoanById']);
        Route::get('/loans/request/{requestId}', [LoanRequestController::class, 'getLoanByRequestId']);


        // Revenue statistics
        Route::get('/monthly-revenue', [RevenueController::class, 'getMonthlyRevenue']);
        Route::get('/yearly-revenue', [RevenueController::class, 'getYearlyRevenue']);
        Route::get('/daily-revenue', [RevenueController::class, 'getDailyRevenue']);

        // Settings
        Route::post('/upload', [ProfileController::class, 'upload']);
        Route::get('/profile', [ProfileController::class, 'getProfile']);
        Route::put('/update-profile', [ProfileController::class, 'update']);
    });
});


