<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocaleMiddleware
{
    protected array $supportedLocales;

    public function __construct()
    {
        $this->supportedLocales = config('app.available_locales');
    }

    public function handle(Request $request, Closure $next)
    {
        $locale = $request->segment(1);

        if ($this->isValidLocale($locale)) {
            App::setLocale($locale);
            return $next($request);
        }

        if ($request->session()->has('locale')) {
            $sessionLocale = $request->session()->get('locale');
            if ($this->isValidLocale($sessionLocale)) {
                App::setLocale($sessionLocale);
                return $next($request);
            }
        }

        $browserLocale = $request->getPreferredLanguage($this->supportedLocales);
        if ($browserLocale) {
            App::setLocale($browserLocale);
            return $next($request);
        }

        // Fallback to default config locale
        App::setLocale(config('app.locale'));

        return $next($request);
    }

    protected function isValidLocale(?string $locale): bool
    {
        return $locale && in_array($locale, $this->supportedLocales);
    }
}