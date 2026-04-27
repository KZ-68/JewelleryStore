<?php
/**
 * Controller for the language switcher fonctionnality
 */

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    private const LOCALE_PATTERN = '#(https?://[^/]+)?/[a-zA-Z]{2}(/|$)#';

    /**
     * Switch the application locale, persist it in session,
     * and redirect to the equivalent page in the new locale.
     * @param \Illuminate\Http\Request $request Get the request data
     * @param string $locale Get the locale lang
     * @return \Illuminate\Http\RedirectResponse Return a redirection call from the resolved redirect url
     */
    public function switch(Request $request, string $locale): RedirectResponse
    {
        $availableLocales = config('app.available_locales');

        if (!in_array($locale, $availableLocales, true)) {
            abort(404);
        }

        Session::put('locale', $locale);
        App::setLocale($locale);

        $redirectUrl = $this->resolveRedirectUrl($request, $locale);

        return redirect($redirectUrl);
    }

    /**
     * Replace the locale segment in the referer URL,
     * falling back to the locale home page.
     * @param \Illuminate\Http\Request $request Get the request data
     * @param string $locale Get the locale lang
     * @return string Return an url pattern for replacing local in every url sended
     */
    private function resolveRedirectUrl(Request $request, string $locale): string
    {
        $referer = $request->headers->get('referer', '');

        if (!$referer) {
            return '/' . $locale;
        }

        return preg_replace(self::LOCALE_PATTERN, '$1/' . $locale . '$2', $referer)
            ?? '/' . $locale;
    }
}
