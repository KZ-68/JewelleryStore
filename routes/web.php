<?php

use App\Http\Controllers\Admin\BackOfficeController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\ContactController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('/cart', [CartController::class, 'show'])->name('cart.show');

Route::get('contact', [ContactController::class, 'create'])->name('contact.create');

Route::post('contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('privacy', function () {
    return Inertia::render('web/Privacy');
})->name('privacy');

Route::group(['middleware' => ['role:admin', 'auth:admin']], function () {
    Route::get('/admin/back-office', [BackOfficeController::class, 'showBO'])->name('admin.back-office.showBO');
});

require __DIR__.'/auth.php';
require __DIR__.'/settings.php';
