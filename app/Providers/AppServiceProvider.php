<?php

namespace App\Providers;

use App\Contracts\ProductImageServiceInterface;
use App\Contracts\ProductListRepositoryInterface;
use App\Models\Customer;
use App\Repositories\ProductRepository;
use App\Services\Currency\LangCurrencyService;
use App\Services\Image\ProductImageService;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singletonIf(
            ProductImageServiceInterface::class,
            ProductImageService::class
        );

        $this->app->bind(
            ProductListRepositoryInterface::class,
            ProductRepository::class
        );
        LangCurrencyService::class;
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Cashier::useCustomerModel(Customer::class);
    }
}
