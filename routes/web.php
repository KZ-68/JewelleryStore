<?php

use App\Http\Controllers\Admin\BackOfficeController;
use App\Http\Controllers\Admin\ProductFrontController;
use App\Http\Controllers\Admin\ManufacturerFrontController;
use App\Http\Controllers\Admin\SupplierFrontController;
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

Route::get('not-found', function() {
    return Inertia::render('web/NotFound');
})->name('not-found');

Route::group(['middleware' => ['role:admin', 'auth:admin']], function () {
    Route::get('/admin/back-office', [BackOfficeController::class, 'showBO'])->name('admin.back-office.showBO');
    Route::get('/admin/back-office/manufacturers', [BackOfficeController::class, 'showManufacturers'])->name('admin.back-office.showManufacturers');
    Route::get('/admin/back-office/products', [BackOfficeController::class, 'showProducts'])->name('admin.back-office.showProducts');
    Route::get('/admin/back-office/suppliers', [BackOfficeController::class, 'showSuppliers'])->name('admin.back-office.showSuppliers');
    Route::get('/admin/back-office/products/new', [ProductFrontController::class, 'newProduct'])->name('new-product');
    Route::post('/admin/back-office/products/new', [ProductFrontController::class, 'create'])->name('new-product.create');
    Route::get('/admin/back-office/products/{slug}', [ProductFrontController::class, 'show'])->name('product-details');
    Route::post('/admin/back-office/products/{slug}', [ProductFrontController::class, 'update'])->name('product-details.update');
    Route::get('/admin/back-office/manufacturers/new', [ManufacturerFrontController::class, 'newManufacturer'])->name('new-manufacturer');
    Route::post('/admin/back-office/manufacturers/new', [ManufacturerFrontController::class, 'create'])->name('new-manufacturer.create');
    Route::get('/admin/back-office/manufacturers/{slug}', [ManufacturerFrontController::class, 'show'])->name('manufacturers-details');
    Route::post('/admin/back-office/manufacturers/{slug}', [ManufacturerFrontController::class, 'update'])->name('manufacturers-details.update');
    Route::get('/admin/back-office/suppliers/new', [SupplierFrontController::class, 'newSupplier'])->name('new-supplier');
    Route::post('/admin/back-office/suppliers/new', [SupplierFrontController::class, 'create'])->name('new-supplier.create');
    Route::get('/admin/back-office/suppliers/{slug}', [SupplierFrontController::class, 'show'])->name('suppliers-details');
    Route::post('/admin/back-office/suppliers/{slug}', [SupplierFrontController::class, 'update'])->name('suplliers-details.update');
    Route::post('/admin/back-office/manufacturers/delete', [ManufacturerFrontController::class, 'delete'])->name('delete-manufacturer');
});

require __DIR__.'/auth.php';
require __DIR__.'/settings.php';
