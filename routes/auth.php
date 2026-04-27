<?php

use App\Http\Controllers\Auth\Admin\AdminEmailVerificationNotificationController;
use App\Http\Controllers\Auth\Admin\AdminEmailVerificationPromptController;
use App\Http\Controllers\Auth\Admin\AdminNewPasswordController;
use App\Http\Controllers\Auth\Admin\AdminPasswordResetLinkController;
use App\Http\Controllers\Auth\Admin\AdminRegisteredUserController;
use App\Http\Controllers\Auth\Admin\AdminTwoFactorChallengeController;
use App\Http\Controllers\Auth\Admin\AdminTwoFactorController;
use App\Http\Controllers\Auth\Admin\AdminVerifyEmailController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredCustomerController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Web\SellerFrontController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web.session', 'guest:web'])->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('customer-login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->name('customer-login.store');

    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');

    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('/register', [RegisteredCustomerController::class, 'create'])
        ->name('register');

    Route::post('/register', [RegisteredCustomerController::class, 'store'])
        ->name('register.store');

    Route::get('/register-seller', [SellerFrontController::class, 'registerSeller'])
        ->name('register-seller');

    Route::post('/register-seller', [SellerFrontController::class, 'store'])
        ->name('register-seller.store');
});

Route::middleware(['admin.session', 'guest:admin'])->group(function () {
    Route::get('/admin/register', [AdminRegisteredUserController::class, 'create'])
        ->name('admin-register');

    Route::post('/admin/register', [AdminRegisteredUserController::class, 'store'])
        ->name('admin-register.store');

    Route::get('/admin/login', [AuthenticatedSessionController::class, 'adminCreate'])
        ->name('admin-login.adminCreate');

    Route::post('/admin/login', [AuthenticatedSessionController::class, 'store'])
        ->name('admin-login.store');

    Route::get('/admin/forgot-password', [AdminPasswordResetLinkController::class, 'create'])
        ->name('admin-password.request');

    Route::post('/admin/forgot-password', [AdminPasswordResetLinkController::class, 'store'])
        ->name('admin-password.email');

    Route::get('/admin/reset-password/{token}', [AdminNewPasswordController::class, 'create'])
        ->name('admin-password.reset');

    Route::post('/admin/reset-password', [AdminNewPasswordController::class, 'store'])
        ->name('admin-password.store');
});

Route::middleware(['web.session', 'role:basic', 'auth:web'])->group(function () {
    Route::get('/verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('customer-logout');
});

Route::prefix('/admin')->middleware(['admin.session', 'role:admin', 'auth:admin'])->group(function () {
    Route::get('/back-office/two-factor', [AdminTwoFactorController::class, 'show'])
        ->name('admin.two-factor.show');
    Route::post('/back-office/two-factor/enable', [AdminTwoFactorController::class, 'enable'])
        ->name('admin.two-factor.enable');
    Route::post('/back-office/two-factor/disable', [AdminTwoFactorController::class, 'disable'])
        ->name('admin.two-factor.disable');
    Route::post('/back-office/two-factor/confirm', [AdminTwoFactorController::class, 'confirm'])
        ->name('admin.two-factor.confirm');
    Route::get('/back-office/two-factor/qr-code', [AdminTwoFactorController::class, 'qrCode'])
        ->name('admin.two-factor.qr-code');
    Route::get('/back-office/two-factor/secret-key', [AdminTwoFactorController::class, 'secretKey'])
        ->name('admin.two-factor.secret-key');
    Route::get('/back-office/two-factor/recovery-codes', [AdminTwoFactorController::class, 'recoveryCodes'])
        ->name('admin.two-factor.recovery-codes');
    Route::post('/back-office/two-factor/regenerate', [AdminTwoFactorController::class, 'regenerate'])
        ->name('admin.two-factor.regenerate');
});

Route::prefix('/admin')->middleware(['admin.session'])->group(function () {
    Route::get('/two-factor-challenge', [AdminTwoFactorChallengeController::class, 'show'])
        ->name('admin.two-factor.login');
    Route::post('/two-factor-challenge', [AdminTwoFactorChallengeController::class, 'store'])
        ->middleware('throttle:two-factor')
        ->name('admin.two-factor.store');
});

Route::prefix('/admin')->middleware(['admin.session', 'role:admin', 'auth:admin'])->group(function () {
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
