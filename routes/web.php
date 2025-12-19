<?php

use App\Http\Controllers\Admin\BackOfficeController;
use App\Http\Controllers\Admin\CategoryFrontController;
use App\Http\Controllers\Admin\ProductFrontController;
use App\Http\Controllers\Admin\ManufacturerFrontController;
use App\Http\Controllers\Admin\SupplierFrontController;
use App\Http\Controllers\Admin\CarrierFrontController;
use App\Http\Controllers\Admin\CustomerFrontController;
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
    Route::get('/admin/back-office/categories', [BackOfficeController::class, 'showCategories'])->name('admin.back-office.showCategories');
    Route::get('/admin/back-office/carriers', [BackOfficeController::class, 'showCarriers'])->name('admin.back-office.showCarriers');
    Route::get('/admin/back-office/customers', [BackOfficeController::class, 'showCustomers'])->name('admin.back-office.showCustomers');
    Route::get('/admin/back-office/products/new', [ProductFrontController::class, 'newProduct'])->name('new-product');
    Route::post('/admin/back-office/products/new', [ProductFrontController::class, 'create'])->name('new-product.create');
    Route::get('/admin/back-office/products/{slug}', [ProductFrontController::class, 'show'])->name('product-details');
    Route::post('/admin/back-office/products/{slug}', [ProductFrontController::class, 'update'])->name('product-details.update');
    Route::get('/admin/back-office/manufacturers/new', [ManufacturerFrontController::class, 'newManufacturer'])->name('new-manufacturer');
    Route::post('/admin/back-office/manufacturers/new', [ManufacturerFrontController::class, 'create'])->name('new-manufacturer.create');
    Route::get('/admin/back-office/manufacturers/{slug}', [ManufacturerFrontController::class, 'show'])->name('manufacturers-details');
    Route::post('/admin/back-office/manufacturers/{slug}', [ManufacturerFrontController::class, 'destroy'])->name('delete-manufacturer');
    Route::post('/admin/back-office/manufacturers', [ManufacturerFrontController::class, 'destroyBulk'])->name('delete-manufacturers');
    Route::post('/admin/back-office/manufacturers/{slug}', [ManufacturerFrontController::class, 'update'])->name('manufacturers-details.update');
    Route::get('/admin/back-office/suppliers/new', [SupplierFrontController::class, 'newSupplier'])->name('new-supplier');
    Route::post('/admin/back-office/suppliers/new', [SupplierFrontController::class, 'create'])->name('new-supplier.create');
    Route::get('/admin/back-office/suppliers/{slug}', [SupplierFrontController::class, 'show'])->name('suppliers-details');
    Route::post('/admin/back-office/suppliers/{slug}', [SupplierFrontController::class, 'update'])->name('suplliers-details.update');
    Route::get('/admin/back-office/categories/new', [CategoryFrontController::class, 'newCategory'])->name('new-category');
    Route::post('/admin/back-office/categories/new', [CategoryFrontController::class, 'create'])->name('new-category.create');
    Route::get('/admin/back-office/categories/{slug}', [CategoryFrontController::class, 'show'])->name('category-details');
    Route::post('/admin/back-office/categories/{slug}', [CategoryFrontController::class, 'destroy'])->name('delete-category');
    Route::post('/admin/back-office/categories', [CategoryFrontController::class, 'destroyBulk'])->name('delete-categories');
    Route::post('/admin/back-office/categories/{slug}', [CategoryFrontController::class, 'update'])->name('category-details.update');
    Route::get('/admin/back-office/categories/{id}/sub-categories', [CategoryFrontController::class, 'showSubCategories'])->name('admin.back-office.showSubCategories');
    Route::get('/admin/back-office/carriers/new', [CarrierFrontController::class, 'newCarrier'])->name('new-carrier');
    Route::post('/admin/back-office/carriers/new', [CarrierFrontController::class, 'create'])->name('new-carrier.create');
    Route::get('/admin/back-office/carriers/{slug}', [CarrierFrontController::class, 'show'])->name('carriers-details');
    Route::post('/admin/back-office/carriers/{slug}', [CarrierFrontController::class, 'destroy'])->name('delete-carrier');
    Route::post('/admin/back-office/carriers/{slug}', [CarrierFrontController::class, 'update'])->name('carriers-details.update');
    Route::get('/admin/back-office/customers/new', [CustomerFrontController::class, 'newCustomer'])->name('new-customer');
    Route::post('/admin/back-office/customers/new', [CustomerFrontController::class, 'create'])->name('new-customer.create');
    Route::get('/admin/back-office/customers/{slug}', [CustomerFrontController::class, 'show'])->name('customers-details');
    Route::post('/admin/back-office/customers/{slug}', [CustomerFrontController::class, 'destroy'])->name('delete-customer');
    Route::post('/admin/back-office/customers/{slug}', [CustomerFrontController::class, 'update'])->name('customers-details.update');
});

require __DIR__.'/auth.php';
require __DIR__.'/settings.php';
