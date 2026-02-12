<?php

namespace App\Http\Controllers\Auth;

use App\Models\Role;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Laravel\Fortify\Features;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\Auth\LoginRequest;

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
        if (Auth::guard('web')->attempt($credentials)) {
            $user = $request->validateCredentials('web');
            $customerRoles = Role::where('guard_name', 'web')->get();
            if($user->hasAnyRole($customerRoles)) {
                if (Features::enabled(Features::twoFactorAuthentication()) && $user->hasEnabledTwoFactorAuthentication()) {
                    $request->session()->put([
                        'login.id' => $user->getKey(),
                        'login.remember' => $request->boolean('remember'),
                    ]);

                    return to_route('two-factor.login');
                }

                Auth::guard('web')->login($user, $request->boolean('remember'));
                $request->session()->regenerate();

                return redirect()->intended(route('home', absolute: false));
            }
        }

        if (Auth::guard('admin')->attempt($credentials)) {
            $user = $request->validateCredentials('admin');
            $adminUserRoles = Role::where('guard_name', 'admin')->get();
            if($user->hasAnyRole($adminUserRoles)) {
                if (Features::enabled(Features::twoFactorAuthentication()) && $user->hasEnabledTwoFactorAuthentication()) {
                    $request->session()->put([
                        'login.id' => $user->getKey(),
                        'login.remember' => $request->boolean('remember'),
                    ]);

                    return to_route('two-factor.login');
                }

                Auth::guard('admin')->login($user, $request->boolean('remember'));
                $request->session()->regenerate();

                return redirect()->intended(route('admin.back-office.showBO', absolute: false));
            }
        }

        return redirect()->intended(route('home', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('admin')->check() ? Auth::guard('admin')->logout() : Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
