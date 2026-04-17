<?php

namespace App\Providers;

use App\Contracts\OrderListRepositoryInterface;
use App\Contracts\ProductImageServiceInterface;
use App\Contracts\ProductListRepositoryInterface;
use App\Contracts\StripePaymentMethodsResolverInterface;
use App\Contracts\StripePaymentVerifierInterface;
use App\Services\Payment\CountryBasedStripePaymentMethodsResolver;
use App\Services\Payment\StripePaymentVerifier;
use App\Models\Customer;
use App\Repositories\CachedProductRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Services\Currency\LangCurrencyService;
use App\Services\Image\ProductImageService;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
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
            StripePaymentMethodsResolverInterface::class,
            CountryBasedStripePaymentMethodsResolver::class,
        );

        $this->app->bind(
            StripePaymentVerifierInterface::class,
            StripePaymentVerifier::class,
        );

        $this->app->bind(
            ProductListRepositoryInterface::class,
            fn() => new CachedProductRepository(new ProductRepository())
        );

        $this->app->bind(
            OrderListRepositoryInterface::class,
            OrderRepository::class
        );
        LangCurrencyService::class;
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Cashier::useCustomerModel(Customer::class);

        Password::defaults(function () {
            return Password::min(12)
                ->required()
                ->mixedCase()
                ->numbers()
                ->symbols();
        });
    }
}
