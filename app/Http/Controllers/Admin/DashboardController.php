<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the Dashboard page.
     */
    public function showDashboard(Request $request): Response
    {
        return Inertia::render('admin/Dashboard', [
            'status' => $request->session()->get('status'),
        ]);
    }

}