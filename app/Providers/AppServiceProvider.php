<?php

namespace App\Providers;

use App\Contracts\ProductImageServiceInterface;
use App\Models\Customer;
use App\Services\Image\ProductImageService;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            ProductImageServiceInterface::class,
            ProductImageService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Cashier::useCustomerModel(Customer::class);
    }
}
