<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;

class RedirectToLocaleMiddleware
{
    public function handle($request, Closure $next) : \Illuminate\Http\Response|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
    {
        $segments = $request->segments();
        $availableLocales = config('app.available_locales');
        $defaultLocale = Config::get('app.fallback_locale');

        if ($request->is('up') || $request->is('api/*') || $request->is('storage/*')) {
            return $next($request);
        }

        if (empty($segments)) {
            return redirect('/' . $defaultLocale);
        }

        if (!in_array($segments[0], $availableLocales)) {
            return redirect('/' . $defaultLocale . '/' . \ltrim(implode('/', $segments), '/'));
        }

        return $next($request);
    }
}