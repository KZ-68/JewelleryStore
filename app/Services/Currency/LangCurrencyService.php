<?php

namespace App\Services\Currency;

use App\Models\Country;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;

class LangCurrencyService
{
    protected array $supportedLocales;

    public function __construct()
    {
        $this->supportedLocales = config('app.available_locales');
    }

    public function verify(Request $request): ?BelongsToMany
    {
        $locale = $this->resolveLocale($request);

        $country = Country::with('currencies')->where('local', $locale)->first();

        return $country?->currencies();
    }

    protected function resolveLocale(Request $request): string
    {
        if ($request->session()->has('locale')) {
            $sessionLocale = $request->session()->get('locale');
            if ($this->isValidLocale($sessionLocale)) {
                return $sessionLocale;
            }
        }

        $browserLocale = $request->getPreferredLanguage($this->supportedLocales);
        if ($browserLocale) {
            return $browserLocale;
        }

        return config('app.locale');
    }

    protected function isValidLocale(?string $locale): bool
    {
        return $locale && in_array($locale, $this->supportedLocales);
    }
}