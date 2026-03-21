<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Customer;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Fortify\Features;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login page.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');
        $customerModel = Customer::where('email', $request->only('email'))->first();
        $userModel = User::where('email', $request->only('email'))->first();
        $guard = 'web';

        if ($customerModel) {
            $guard = 'web';
        }
        if ($userModel) {
            $guard = 'admin';
        }

        if (Auth::guard($guard)->attempt($credentials)) {
            $user = $request->validateCredentials($guard);
            $roles = Role::where('guard_name', $guard)->get();
            if($user->hasAnyRole($roles)) {
                if (Features::enabled(Features::twoFactorAuthentication()) && $user->hasEnabledTwoFactorAuthentication()) {
                    $request->session()->put([
                        'login.id' => $user->getKey(),
                        'login.remember' => $request->boolean('remember'),
                    ]);

                    return to_route('two-factor.login');
                }

                Auth::guard($guard)->login($user, $request->boolean('remember'));
                $request->session()->regenerate();

                if ($guard === 'web') {
                    return redirect()->intended(route('home', absolute: false));
                } else {
                    return redirect()->intended((route('admin.back-office.showBO', absolute: false)));
                }
            }
        }

        return redirect()->intended(route('home', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        } else {
            Auth::guard('web')->logout();
            $request->session()->forget([
                'login.id',
                'login.remember'
            ]);
            $request->session()->regenerate();
            $request->session()->regenerateToken();
        }

        return redirect('/');
    }
}
