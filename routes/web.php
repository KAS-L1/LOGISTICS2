<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\Procurement\PurchaseItemController;
use App\Http\Controllers\Procurement\PurchaseRequisitionController;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login'); // Show Login Form
    Route::post('login', [AuthController::class, 'webLogin'])->name('web.auth.login'); // Process Login
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register'); // Show Register Form
    Route::post('register', [AuthController::class, 'register'])->name('web.auth.register'); // Process Registration
    Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request'); // Forgot Password Form
    Route::post('forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email'); // Send Reset Link
    Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset'); // Reset Form
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update'); // Reset Password
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'webLogout'])->name('logout');

    // Role-Specific Routes
    Route::middleware('role:Admin|Super-Admin|Logistic')->group(function () {
        Route::view('home', 'home')->name('home');
        Route::view('data-analytics', 'dashboard.data-analytics')->name('data-analytics');
        Route::view('predictive-analytics', 'dashboard.predictive-analytics')->name('predictive-analytics');
    });

    Route::controller(UserManagementController::class)->group(function () {
        Route::get('users-profile', 'userProfilePage')->name('users-profile');
        Route::post('/profile/update', 'update')->name('profile.update');
    });

    // Purchase Requisition
    Route::prefix('requisitions')->name('requisitions.')->group(function () {
        Route::get('/', [PurchaseRequisitionController::class, 'index'])->name('index');
        Route::get('/create', [PurchaseRequisitionController::class, 'create'])->name('create');
        Route::post('/', [PurchaseRequisitionController::class, 'store'])->name('store');
        Route::get('/{id}', [PurchaseRequisitionController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [PurchaseRequisitionController::class, 'edit'])->name('edit');
        Route::delete('/{id}', [PurchaseRequisitionController::class, 'destroy'])->name('destroy');
    });
});

// API Routes
Route::prefix('api')->group(function () {
    Route::get('requisitions', [PurchaseRequisitionController::class, 'apiIndex'])->name('requisitions.api');
});

// Other Routes
Route::get('/users', fn() => view('users.index'));
