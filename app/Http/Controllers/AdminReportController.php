<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

Carbon::setLocale('id');

class AdminReportController extends Controller
{
    public function index()
    {
        $user = Auth::guard('web')->user();
        $outletId = $user->outlet_id;

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
        $chartDataQuery = Order::select([
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total_order'),
        ])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date');

        if ($user->username !== 'administrator') {
            $chartDataQuery->where('outlet_id', $outletId);
        }

        $chartData = $chartDataQuery->get();

        $labels = $chartData->pluck('date');
        $data = $chartData->pluck('total_order');

        // Reports
        $reportQuery = Order::with('outlet')
            ->select([
                'outlet_id',
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total_order'),
                DB::raw('SUM(total_price) as total_revenue'),
            ])
            ->groupBy('outlet_id', DB::raw('DATE(created_at)'))
            ->orderByDesc('date');

        if ($user->username !== 'administrator') {
            $reportQuery->where('outlet_id', $outletId);
        }

        $reports = $reportQuery->paginate(5)->withQueryString();

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

    public function downloadPDF($outlet_code, $date)
    {
        $user = Auth::guard('web')->user();
        $ownerName = $user->name;
        $formattedDate = \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y');

        $reportData = Order::with('outlet')
            ->whereDate('created_at', $date)
            ->whereHas('outlet', function ($query) use ($outlet_code) {
                $query->where('outlet_code', $outlet_code);
            })
            ->select([
                'outlet_id',
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(total_price) as total_income'),
            ])
            ->groupBy('outlet_id', DB::raw('DATE(created_at)'))
            ->get()
            ->map(function($item) {
                return [
                    'outlet' => $item->outlet->name ?? 'Unknown Outlet',
                    'date' => $item->date,
                    'total_orders' => $item->total_orders,
                    'total_income' => $item->total_income,
                ];
            });

        if ($reportData->isEmpty()) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        // Menu items
        $orders = Order::with('orderItems.menu', 'outlet')
            ->whereDate('created_at', $date)
            ->whereHas('outlet', function ($query) use ($outlet_code) {
                $query->where('outlet_code', $outlet_code);
            })
            ->get();

        $menuSummary = [];
        foreach ($orders as $order) {
            foreach ($order->orderItems as $item) {
                $menuId = $item->menu->id;
                if (!isset($menuSummary[$menuId])) {
                    $menuSummary[$menuId] = [
                        'name' => $item->menu->name,
                        'quantity' => 0,
                        'total_price' => 0,
                    ];
                }

                $menuSummary[$menuId]['quantity'] += $item->quantity;
                $menuSummary[$menuId]['total_price'] += $item->quantity * $item->price; // asumsi price di orderItems
            }
        }

        $totalPendapatan = array_sum(array_column($menuSummary, 'total_price'));

        $pdf = Pdf::loadView('pdf.sales-report', compact(
            'reportData',
            'ownerName',
            'formattedDate',
            'menuSummary',
            'totalPendapatan'
        ))->setPaper('a4', 'portrait');

        return $pdf->stream("sales-report-{$outlet_code}-{$date}.pdf");
    }
}
