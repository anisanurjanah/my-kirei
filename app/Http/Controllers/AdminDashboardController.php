<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Outlet;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Carbon::setLocale('id');

class AdminDashboardController extends Controller
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

        // Formatted date
        $todayFormatted = Carbon::now('Asia/Jakarta')->translatedFormat('l, d F Y, H:i') . ' WIB';

        // Chart data
        $labels = [];
        $data = [];
        $outlets = Outlet::all();

        foreach ($outlets as $outlet) {
            // per Day
            // $jumlahMenu = OrderItem::whereHas('order', function ($query) use ($today, $outlet) {
            //         $query->where('outlet_id', $outlet->id)
            //               ->whereDate('created_at', $today);
            //     })
            //     ->sum('quantity');

            $jumlahMenu = OrderItem::whereHas('order', function ($query) use ($outlet) {
                $query->where('outlet_id', $outlet->id);
            })
            ->sum('quantity');

            $labels[] = $outlet->name;
            $data[] = $jumlahMenu ?? 0;
        }

        // Latest Order
        $latestOrders = Order::with('payment')->where('outlet_id', $user->outlet_id)->latest()->take(5)->get();

        return view('dashboard.index', [
            'user' => $user,
            'todayFormatted' => $todayFormatted,
            'labels' => $labels,
            'data' => $data,
            'latestOrders' => $latestOrders
        ]);
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
        // $today = Carbon::today();

        foreach ($outlets as $outlet) {
            // per Day
            // $jumlahMenu = OrderItem::whereHas('order', function ($query) use ($today, $outlet) {
            //         $query->where('outlet_id', $outlet->id)
            //               ->whereDate('created_at', $today);
            //     })
            //     ->sum('quantity');

            $jumlahMenu = OrderItem::whereHas('order', function ($query) use ($outlet) {
                $query->where('outlet_id', $outlet->id);
            })
            ->sum('quantity');

            $labels[] = $outlet->name;
            $data[] = $jumlahMenu ?? 0;
        }

        // Latest Order
        $latestOrders = Order::with('payment')->latest()->take(5)->get();

        return view('dashboard.index', [
            'user' => $user,
            'todayFormatted' => $todayFormatted,
            'labels' => $labels,
            'data' => $data,
            'latestOrders' => $latestOrders
        ]);
    }
}
