<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Admin\BackOfficeController;

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('/cart', [CartController::class, 'show'])->name('cart.show');

Route::get('/contact', function () {
    return Inertia::render('Contact');
})->name('contact');

Route::prefix('admin')->group(function () {
    Route::middleware('auth:admin')->group(function () {
        Route::get('back-office', [BackOfficeController::class, 'showBO'])->name('showBO');
    });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';