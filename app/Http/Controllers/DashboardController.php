<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index($outletParam)
    {
        $user = Auth::guard('web')->user();
        $outlet = Outlet::whereRaw('LOWER(outlet_code) = ?', [strtolower($outletParam)])->first();

        if (!$user) {
            abort(403, 'Unauthorized');
        }

        if (!$outlet) {
            abort(403, 'Outlet tidak ditemukan.');
        }

        if ($user->username !== 'administrator') {
            if (!$user->outlet || $user->outlet->id !== $outlet->id) {
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
