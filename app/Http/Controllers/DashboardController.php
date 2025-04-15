<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index($outlet)
    {
        $user = Auth::guard('web')->user();

        if (!$user) {
            abort(403, 'Unauthorized');
        }

        if ($user->username !== 'administrator') {
            if (!$user->outlet || $user->outlet->outlet_code !== $outlet) {
                abort(403, 'Akses outlet tidak valid.');
            }
        }

        return view('dashboard.index', compact('outlet', 'user'));
    }

    public function indexAdministrator()
    {
        $user = Auth::guard('web')->user();

        if (!$user) {
            abort(403, 'Unauthorized');
        }

        if ($user->username !== 'administrator') {
            abort(403, 'Akses tidak valid.');
        }

        return view('dashboard.index', compact('user'));
    }
}
