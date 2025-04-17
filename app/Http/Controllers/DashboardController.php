<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Outlet;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Carbon::setLocale('id');

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

        // Chart data
        $labels = [];
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels[] = $date->format('D');

            $total = Order::whereDate('created_at', $date)
                ->where('outlet_id', $outlet->id)
                ->sum('total_price');

            $data[] = $total;
        }

        return view('dashboard.index', compact('outlet', 'user', 'labels', 'data'));
    }

    public function indexAdministrator(Request $request)
    {
        $user = Auth::guard('web')->user();

        if (!$user) {
            abort(403, 'Unauthorized');
        }

        if ($user->username !== 'administrator') {
            abort(403, 'Akses tidak valid.');
        }

        // Formatted date
        $todayFormatted = Carbon::now('Asia/Jakarta')->translatedFormat('l, d F Y, H:i') . ' WIB';

        // Chart data
        $labels = [];
        $data = [];
        $outlets = Outlet::all();
        $today = Carbon::today();

        foreach ($outlets as $outlet) {
            $jumlahMenu = OrderItem::whereHas('order', function ($query) use ($today, $outlet) {
                    $query->where('outlet_id', $outlet->id)
                          ->whereDate('created_at', $today);
                })
                ->sum('quantity');

            $labels[] = $outlet->name;
            $data[] = $jumlahMenu;
        }

        return view('dashboard.index', [
            'user' => $user,
            'labels' => $labels,
            'data' => $data,
            'todayFormatted' => $todayFormatted
        ]);
    }
}
