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

    public function verify(Request $request): BelongsToMany
    {
        if ($request->session()->has('locale')) {
            $sessionLocale = $request->session()->get('locale');
            if ($this->isValidLocale($sessionLocale)) {
                $country = Country::with('country_currency')->where('local', $sessionLocale)->first();
                $currencies = $country->currencies();
                return $currencies;
            }
        }

        $browserLocale = $request->getPreferredLanguage($this->supportedLocales);

        if ($browserLocale) {
            $country = Country::with('currencies')->where('local', $browserLocale)->first();
            $currencies = $country->currencies();
            return $currencies;
        }

        $defaultLocale = $request->getDefaultLocale();
        $country = Country::with('country_currency')->where('local', $defaultLocale)->first();
        $currencies = $country->currencies();
        return $currencies;
    }

    protected function isValidLocale(?string $locale): bool
    {
        return $locale && in_array($locale, $this->supportedLocales);
    }
}