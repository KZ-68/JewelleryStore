<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Fortify\Actions\ConfirmTwoFactorAuthentication;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;
use Laravel\Fortify\Actions\GenerateNewRecoveryCodes;
use Laravel\Fortify\Features;

class AdminTwoFactorController extends Controller
{
    private function adminUser(): User
    {
        /** @var User */
        return Auth::guard('admin')->user();
    }

    public function show(): Response
    {
        $user = $this->adminUser();

        return Inertia::render('admin/AdminTwoFactor', [
            'twoFactorEnabled'    => $user->hasEnabledTwoFactorAuthentication(),
            'requiresConfirmation' => Features::optionEnabled(Features::twoFactorAuthentication(), 'confirm'),
        ]);
    }

    public function enable(EnableTwoFactorAuthentication $enable): RedirectResponse
    {
        $enable($this->adminUser());

        return back();
    }

    public function disable(DisableTwoFactorAuthentication $disable): RedirectResponse
    {
        $disable($this->adminUser());

        return back();
    }

    public function confirm(ConfirmTwoFactorAuthentication $confirm, Request $request): RedirectResponse
    {
        $confirm($this->adminUser(), $request->input('code'));

        return back();
    }

    public function qrCode(): JsonResponse
    {
        return response()->json([
            'svg' => $this->adminUser()->twoFactorQrCodeSvg(),
        ]);
    }

    public function secretKey(): JsonResponse
    {
        return response()->json([
            'secretKey' => decrypt($this->adminUser()->two_factor_secret),
        ]);
    }

    public function recoveryCodes(): JsonResponse
    {
        return response()->json(
            json_decode(decrypt($this->adminUser()->two_factor_recovery_codes), true)
        );
    }

    public function regenerate(GenerateNewRecoveryCodes $generate): RedirectResponse
    {
        $generate($this->adminUser());

        return back();
    }
}
