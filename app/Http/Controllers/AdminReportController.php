<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminReportController extends Controller
{
    public function index()
    {
        $user = Auth::guard('web')->user();

        // Reports
        $reports = Order::with('outlet')
            ->select(['outlet_id',
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total_order'),
                DB::raw('SUM(total_price) as total_revenue')
            ])
            ->groupBy('outlet_id', DB::raw('DATE(created_at)'))
            ->orderByDesc('date')
            ->paginate(5)->withQueryString();

        // Cards
        $monthlyRevenue = Order::whereMonth('created_at', now()->month)
            ->sum('total_price');

        $monthlyOrderCount = Order::whereMonth('created_at', now()->month)
            ->count();

        $averageDailyRevenue = $monthlyOrderCount > 0
            ? $monthlyRevenue / now()->day
            : 0;

        $topOutlet = Order::select('outlet_id', DB::raw('COUNT(*) as order_count'))
            ->whereMonth('created_at', now()->month)
            ->groupBy('outlet_id')
            ->orderByDesc('order_count')
            ->with('outlet')
            ->first();

        // Chart
        $ordersPerDay = Order::selectRaw('DATE(created_at) as date, COUNT(*) as total')
                ->whereMonth('created_at', now()->month)
                ->groupBy('date')
                ->orderBy('date')
                ->get();

        $labels = $ordersPerDay->pluck('date')->map(fn($d) => Carbon::parse($d)->format('d M'));
        $data = $ordersPerDay->pluck('total');

        // Latest Orders
        if ($user->username === 'administrator') {
            $orders = Order::latest()->take(10)->get();
        } else {
            $orders = Order::where('outlet_id', $user->outlet_id)
                        ->latest()
                        ->take(10)
                        ->get();
        }

        return view('dashboard.reports.index', [
            'reports' => $reports,
            'outlets' => Outlet::all(),
            'orders' => $orders,
            'monthlyRevenue' => $monthlyRevenue,
            'monthlyOrderCount' => $monthlyOrderCount,
            'averageDailyRevenue' => $averageDailyRevenue,
            'topOutlet' => $topOutlet,
            'labels' => $labels,
            'data' => $data
        ]);
    }

    public function ordersByOutlet(Request $request)
    {
        $outletId = $request->outlet_id;

        $ordersPerDay = Order::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->whereMonth('created_at', now()->month)
            ->where('outlet_id', $outletId)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = $ordersPerDay->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d M'));
        $data = $ordersPerDay->pluck('total');

        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);
    }
}
