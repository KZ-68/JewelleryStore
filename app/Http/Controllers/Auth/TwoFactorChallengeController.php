<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;
use Laravel\Fortify\RecoveryCode;

class TwoFactorChallengeController extends Controller
{
    public function show(Request $request): Response|RedirectResponse
    {
        if (! $request->session()->has('login.id') || $request->session()->get('login.guard') !== 'admin') {
            return redirect()->route('admin-login.adminCreate', ['locale' => App::currentLocale()]);
        }

        return Inertia::render('auth/admin/AdminTwoFactorChallenge', [
            'locale' => App::currentLocale(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        if ($request->session()->get('login.guard') !== 'admin') {
            return redirect()->route('admin-login.adminCreate', ['locale' => App::currentLocale()]);
        }

        $userId  = $request->session()->pull('login.id');
        $remember = $request->session()->pull('login.remember', false);
        $request->session()->forget('login.guard');

        /** @var User|null $user */
        $user = User::find($userId);

        if (! $user) {
            return redirect()->route('admin-login.adminCreate', ['locale' => App::currentLocale()]);
        }

        if ($code = $request->input('code')) {
            /** @var TwoFactorAuthenticationProvider $provider */
            $provider = app(TwoFactorAuthenticationProvider::class);

            if (! $provider->verify(decrypt($user->two_factor_secret), $code)) {
                return back()->withErrors([
                    'code' => __('The provided two factor authentication code was invalid.'),
                ]);
            }
        } elseif ($recoveryCode = $request->input('recovery_code')) {
            $recoveryCodes = json_decode(decrypt($user->two_factor_recovery_codes), true);

            if (! in_array($recoveryCode, $recoveryCodes)) {
                return back()->withErrors([
                    'recovery_code' => __('The provided two factor recovery code was invalid.'),
                ]);
            }

            $user->forceFill([
                'two_factor_recovery_codes' => encrypt(str_replace(
                    $recoveryCode,
                    RecoveryCode::generate(),
                    $user->two_factor_recovery_codes
                )),
            ])->save();
        } else {
            return back()->withErrors([
                'code' => __('The provided two factor authentication code was invalid.'),
            ]);
        }

        Auth::guard('admin')->login($user, $remember);
        $request->session()->regenerate();

        return redirect()->intended(
            route('admin.back-office.showBO', ['locale' => App::currentLocale()], absolute: false)
        );
    }
}
