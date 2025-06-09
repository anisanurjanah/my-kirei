<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Menu;
use App\Models\User;
use App\Models\Order;
use App\Models\Outlet;
use App\Models\OrderItem;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

Carbon::setLocale('id');

class AdminDashboardController extends Controller
{
    public function index($outlet_code)
    {
        $user = Auth::guard('web')->user();
        $outlet = Outlet::whereRaw('LOWER(outlet_code) = ?', [strtolower($outlet_code)])->first();

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

        // Cards
        $totalOutlets = Outlet::count();
        $totalUsers = User::count() + Customer::count();
        $totalMenus = Menu::count();
        $totalOrdersToday = Order::whereDate('created_at', Carbon::today())->count();

        $todayFormatted = Carbon::now('Asia/Jakarta')->translatedFormat('l, d F Y, H:i') . ' WIB';

        // Chart data
        $labels = [];
        $data = [];
        $outlets = Outlet::all();

        foreach ($outlets as $outlet) {
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
            'totalOutlets' => $totalOutlets,
            'totalUsers' => $totalUsers,
            'totalMenus' => $totalMenus,
            'totalOrdersToday' => $totalOrdersToday,
            'todayFormatted' => $todayFormatted,
            'labels' => $labels,
            'data' => $data,
            'latestOrders' => $latestOrders
        ]);
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

        // Cards
        $totalOutlets = Outlet::count();
        $totalUsers = User::count() + Customer::count();
        $totalMenus = Menu::count();
        $totalOrdersToday = Order::whereDate('created_at', Carbon::today())->count();

        $todayFormatted = Carbon::now('Asia/Jakarta')->translatedFormat('l, d F Y, H:i') . ' WIB';

        // Chart data
        $labels = [];
        $data = [];
        $outlets = Outlet::all();

        foreach ($outlets as $outlet) {
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
            'totalOutlets' => $totalOutlets,
            'totalUsers' => $totalUsers,
            'totalMenus' => $totalMenus,
            'totalOrdersToday' => $totalOrdersToday,
            'todayFormatted' => $todayFormatted,
            'labels' => $labels,
            'data' => $data,
            'latestOrders' => $latestOrders
        ]);
    }
}
