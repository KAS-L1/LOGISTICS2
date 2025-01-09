<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\Procurement\PurchaseItemController;
use App\Http\Controllers\Procurement\PurchaseRequisitionController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

// Guest Routes
Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login'); // Show Login Form
    Route::post('login', [AuthController::class, 'webLogin'])->name('web.auth.login'); // Process Login

    // Registration Routes
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register'); // Show Register Form
    Route::post('register', [AuthController::class, 'register'])->name('web.auth.register'); // Process Registration

    // Password Reset Routes
    Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request'); // Show Forgot Password Form
    Route::post('forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email'); // Send Reset Link
    Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset'); // Show Reset Password Form
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update'); // Process Reset Password
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'webLogout'])->name('logout');
});


Route::middleware(['auth', 'role:Admin|Super-Admin|Logistic'])->group(function () {

    Route::get('home', function () {
        return view('home');
    })->name('home');

    Route::get('data-analytics', function () {
        return view('dashboard.data-analytics');
    })->name('data-analytics');

    Route::get('predictive-analytics', function () {
        return view('dashboard.predictive-analytics');
    })->name('predictive-analytics');
});

// Manager routes (only accessible to users with the 'manager' role)
Route::middleware(['role:Manager'])->group(function () {

    Route::get('predictive-analytics', function () {
        return view('dashboard.predictive-analytics');
    })->name('predictive-analytics');
});




Route::get('requisitions', [PurchaseRequisitionController::class, 'index'])->name('requisitions.index');
Route::get('requisitions/{id}', [PurchaseRequisitionController::class, 'show'])->name('requisitions.show');
Route::get('requisitions/{id}/edit', [PurchaseRequisitionController::class, 'edit'])->name('requisitions.edit');
Route::delete('requisitions/{id}', [PurchaseRequisitionController::class, 'destroy'])->name('requisitions.destroy');
Route::get('requisitions/create', [PurchaseRequisitionController::class, 'create'])->name('requisitions.create');
Route::post('requisitions', [PurchaseRequisitionController::class, 'store'])->name('requisitions.store');


Route::get('/users', function () {
    return view('users.index');
});
// Route::middleware(['permission:view reports'])->group(function () {
//     Route::get('/reports', [ReportController::class, 'index']);
// });


Route::controller(UserManagementController::class)->group(function () {
    Route::get('users-profile', 'userProfilePage')->middleware('auth')->name('users-profile');
});


Route::post('/profile/update', [UserController::class, 'update'])->name('profile.update');
