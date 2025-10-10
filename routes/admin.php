<?php

use App\Http\Controllers\Admin\BackOfficeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['admin.session', 'auth:admin'])->group(function () {
    Route::get('admin/back-office', [BackOfficeController::class, 'show'])->name('bo.show');
});