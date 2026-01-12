<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Web\AddressFrontController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\InvoiceFrontController;
use App\Http\Controllers\Settings\TwoFactorAuthenticationController;

Route::middleware(['role:basic', 'auth:web'])->group(function () {
    Route::redirect('settings', '/settings/profile');
    Route::get('settings/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('settings/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('settings/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('settings/password', [PasswordController::class, 'edit'])->name('password.edit');
    Route::put('settings/password', [PasswordController::class, 'update'])
        ->middleware('throttle:6,1')
        ->name('password.update');
    Route::get('settings/appearance', function () {
        return Inertia::render('settings/Appearance');
    })->name('appearance.edit');
    Route::get('settings/two-factor', [TwoFactorAuthenticationController::class, 'show'])
        ->name('two-factor.show');
    Route::get('settings/addresses', [AddressFrontController::class, 'showAddresses'])->name('addresses.showAddresses');
    Route::post('settings/addresses', [AddressFrontController::class, 'deleteAddress'])->name('addresses.deleteAddress');
    Route::get('settings/addresses/new', [AddressFrontController::class, 'newAddress'])->name('addresses.newAddress');
    Route::post('settings/addresses/new', [AddressFrontController::class, 'create'])->name('addresses.create');
    Route::get('settings/invoices', [InvoiceFrontController::class, 'showInvoices'])->name('invoices.showInvoices');
    Route::post('settings/invoices/download', [InvoiceFrontController::class, 'downloadPdf'])->name('invoices.downloadPdf');
    Route::post('settings/invoices/display', [InvoiceFrontController::class, 'displayPdf'])->name('invoices.displayPdf');
});
