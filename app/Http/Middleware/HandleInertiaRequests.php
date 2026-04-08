<?php

namespace App\Http\Middleware;

use App\Http\Helpers\CartHelper;
use App\Models\Carrier;
use App\Models\Category;
use App\Models\ShippingRate;
use App\Services\Currency\LangCurrencyService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    public function __construct(
        private LangCurrencyService $langCurrencyService
    ) {}

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        [$message, $author] = str(Inspiring::quotes()->random())->explode('-');

        $cart = new CartHelper;
        $cartProducts = $cart->get();
        $cartProductsCount = count($cartProducts['products']);
        $defaultCarrier = Carrier::where('id', 1)->firstOrFail();
        $defaultShippingRate = ShippingRate::where('carrier_id', $defaultCarrier->id)->first();
        $langFile = lang_path( App::currentLocale() . ".json" );
        $currencies = $this->langCurrencyService->verify($request);

        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'quote' => ['message' => trim($message), 'author' => trim($author)],
            'locale' => App::currentLocale(),
            'locales' => config( 'app.available_locales' ),
            'translations' => File::exists( $langFile ) ? File::json( $langFile ) : [],
            'auth' => [
                'user' => Auth::guard('admin')->check() ? Auth::guard('admin')->user() : null,
                'customer' => Auth::guard('web')->check() ? Auth::guard('web')->user() : null,
            ],
            'sidebarOpen' => ! $request->hasCookie('sidebar_state') || $request->cookie('sidebar_state') === 'true',
            'frontCategories' => Category::with('childrenRecursive')->whereNull('parent_id')->get(),
            'cartProductsCount' => $cartProductsCount,
            'defaultShippingRatePrice' => $defaultShippingRate->price,
            'currencies' => $currencies,
        ];
    }
}
