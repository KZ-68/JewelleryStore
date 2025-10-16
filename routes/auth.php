<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredCustomerController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\Admin\AdminNewPasswordController;
use App\Http\Controllers\Auth\Admin\AdminVerifyEmailController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\Admin\AdminRegisteredUserController;
use App\Http\Controllers\Auth\Admin\AdminPasswordResetLinkController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\Admin\AdminEmailVerificationPromptController;
use App\Http\Controllers\Auth\Admin\AdminEmailVerificationNotificationController;

Route::middleware(['guest:web'])->group(function () {
    Route::get('register', [RegisteredCustomerController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredCustomerController::class, 'store'])
        ->name('register.store');

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store'])
        ->name('login.store');

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware(['guest:admin'])->group(function () {
    Route::get('admin/register', [AdminRegisteredUserController::class, 'create'])
        ->name('admin-register');

    Route::post('admin/register', [AdminRegisteredUserController::class, 'store'])
        ->name('admin-register.store');

    Route::get('admin/login', [AuthenticatedSessionController::class, 'create'])
        ->name('admin-login');

    Route::post('admin/login', [AuthenticatedSessionController::class, 'store'])
        ->name('admin-login.store');

    Route::get('admin/forgot-password', [AdminPasswordResetLinkController::class, 'create'])
        ->name('admin-password.request');

    Route::post('admin/forgot-password', [AdminPasswordResetLinkController::class, 'store'])
        ->name('admin-password.email');

    Route::get('admin/reset-password/{token}', [AdminNewPasswordController::class, 'create'])
        ->name('admin-password.reset');

    Route::post('admin/reset-password', [AdminNewPasswordController::class, 'store'])
        ->name('admin-password.store');
});

Route::middleware(['role:basic', 'auth:web'])->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

Route::prefix('admin')->middleware(['role:admin', 'auth:admin'])->group(function () {
    Route::get('/verify-email', AdminEmailVerificationPromptController::class)
        ->name('admin-verification.notice');

    Route::get('/verify-email/{id}/{hash}', AdminVerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('admin-verification.verify');

    Route::post('/email/verification-notification', [AdminEmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('admin-verification.send');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('admin-logout');
});