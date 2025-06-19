<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        $monthlyRevenueQuery = Order::whereMonth('created_at', now()->month);
        $monthlyOrderCountQuery = Order::whereMonth('created_at', now()->month);

        if ($user->username !== 'administrator') {
            $monthlyRevenueQuery->where('outlet_id', $outletId);
            $monthlyOrderCountQuery->where('outlet_id', $outletId);
        }

        $monthlyRevenue = $monthlyRevenueQuery->sum('total_price');
        $monthlyOrderCount = $monthlyOrderCountQuery->count();

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
            ->where('order_status', 'Selesai')
            ->whereHas('payment', fn ($q) => $q->where('payment_status', 'Lunas'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date');

        if ($user->username !== 'administrator') {
            $chartDataQuery->where('outlet_id', $outletId);
        }

        $chartData = $chartDataQuery->get();

        $labels = $chartData->pluck('date');
        $data = $chartData->pluck('total_order');

        // Reports
        $filter = request('filter', 'daily');

        $reportQuery = $this->buildReportQuery($filter, $user);
        $reports = $reportQuery->get();

        // Profit
        $profitQuery = $this->buildProfitQuery($filter, $user);
        $profits = $profitQuery->get()->keyBy('period');

        $reports = $reports->map(function ($report) use ($profits, $filter) {
            $report->total_profit = $profits[$report->period]->total_profit ?? 0;

            if ($filter === 'weekly') {
                $start = Carbon::parse($report->any_date)->startOfWeek(Carbon::MONDAY);
                $end = Carbon::parse($report->any_date)->endOfWeek(Carbon::SUNDAY);
                $report->formatted_date = $start->translatedFormat('d F Y') . ' - ' . $end->translatedFormat('d F Y');
            } elseif ($filter === 'monthly') {
                $report->formatted_date = Carbon::parse($report->date)->translatedFormat('F Y');
            } else {
                $report->formatted_date = Carbon::parse($report->date)->translatedFormat('l, d F Y');
            }

            $report->download_date = match($filter) {
                'weekly' => Carbon::parse($report->any_date ?? $report->date)->toDateString(),
                'monthly' => Carbon::parse($report->date)->startOfMonth()->toDateString(),
                default => Carbon::parse($report->date)->toDateString(),
            };

            return $report;
        });

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
            'data' => $data,
            'filter' => $filter,
        ]);
    }

    public function ordersByOutlet(Request $request)
    {
        $outletId = $request->outlet_id;

        $ordersPerDay = Order::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->where('order_status', 'Selesai')
            ->whereHas('payment', fn ($q) => $q->where('payment_status', 'Lunas'))
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

        $outlet = Outlet::where('outlet_code', $outlet_code)->firstOrFail();
        $outletId = $outlet->id;

        // Reports
        $filter = request('filter', 'daily');
        $filterLabel = match($filter) {
            'daily' => 'Harian',
            'weekly' => 'Mingguan',
            'monthly' => 'Bulanan',
            default => 'Harian',
        };

        // $reportQuery = $this->buildReportQuery($filter, $user);
        $reportQuery = $this->buildReportQuery($filter, $user)->where('orders.outlet_id', $outletId);
        $reportData = $reportQuery->get();

        if ($reportData->isEmpty()) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        // Profit
        // $profitQuery = $this->buildProfitQuery($filter, $user);
        $profitQuery = $this->buildProfitQuery($filter, $user)->where('orders.outlet_id', $outletId);
        $profits = $profitQuery->get()->keyBy('period');

        $reportData = $reportData->map(function ($report) use ($profits, $filter) {
            $report->total_profit = $profits[$report->period]->total_profit ?? 0;
            $report->outlet_name = $report->outlet->name;

            if ($filter === 'weekly') {
                $start = Carbon::parse($report->any_date)->startOfWeek(Carbon::MONDAY);
                $end = Carbon::parse($report->any_date)->endOfWeek(Carbon::SUNDAY);
                $report->formatted_date = $start->translatedFormat('d F Y') . ' - ' . $end->translatedFormat('d F Y');
            } elseif ($filter === 'monthly') {
                $report->formatted_date = Carbon::parse($report->date)->translatedFormat('F Y');
            } else {
                $report->formatted_date = Carbon::parse($report->date)->translatedFormat('l, d F Y');
            }

            return $report;
        });

        $selectedReport = $reportData->first(function ($report) use ($date, $filter) {
        $reportDate = Carbon::parse($report->date ?? $report->any_date);

        return match ($filter) {
            'daily' => $reportDate->toDateString() === $date,
            'weekly' => $reportDate->weekOfYear === Carbon::parse($date)->weekOfYear &&
                        $reportDate->year === Carbon::parse($date)->year,
            'monthly' => $reportDate->month === Carbon::parse($date)->month &&
                        $reportDate->year === Carbon::parse($date)->year,
            default => false,
        };
    });

        $report = $selectedReport;

        if (!$selectedReport) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        // Periode
        $start = request('start');
        $end = request('end');

        if ($start && $end) {
            $formattedDate = Carbon::parse($start)->translatedFormat('d F Y') . ' - ' . Carbon::parse($end)->translatedFormat('d M Y');
        } elseif ($start) {
            $formattedDate = 'Mulai ' . Carbon::parse($start)->translatedFormat('d F Y');
        } elseif ($end) {
            $formattedDate = 'Hingga ' . Carbon::parse($end)->translatedFormat('d F Y');
        } else {
            $rawDate = $reportData->first()->date;
            $formattedDate = $reportData->first()->formatted_date ?? '-';
        }

        // Menu items
        $orders = Order::with('orderItems.menu', 'outlet')
            ->where('order_status', 'Selesai')
            ->whereHas('payment', fn ($q) => $q->where('payment_status', 'Lunas'))
            ->when($filter === 'daily', fn ($q) => $q->whereDate('created_at', $date))
            ->when($filter === 'weekly', fn ($q) => $q->whereBetween('created_at', [
                \Carbon\Carbon::parse($date)->startOfWeek(),
                \Carbon\Carbon::parse($date)->endOfWeek()
            ]))
            ->when($filter === 'monthly', fn ($q) => $q->whereMonth('created_at', \Carbon\Carbon::parse($date)->month)
                ->whereYear('created_at', \Carbon\Carbon::parse($date)->year))
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
                $menuSummary[$menuId]['total_price'] += $item->quantity * $item->price;
            }
        }

        $total = array_sum(array_column($menuSummary, 'total_price'));

        $pdf = Pdf::loadView('pdf.sales-report', compact(
            'reportData',
            'ownerName',
            'formattedDate',
            'filterLabel',
            'menuSummary',
            'total',
            'report'
        ))->setPaper('a4', 'portrait');

        return $pdf->stream("sales-report-{$outlet_code}-{$date}.pdf");
    }

    private function buildReportQuery($filter, $user)
    {
        $start = request('start');
        $end = request('end');

        if ($start && !$end) {
            $end = $start;
        } elseif (!$start && $end) {
            $start = $end;
        }

        $query = Order::with('outlet')
            ->where('order_status', 'Selesai')
            ->whereHas('payment', fn ($q) => $q->where('payment_status', 'Lunas'));

        switch ($filter) {
            case 'weekly':
                $query->select([
                    'outlet_id',
                    DB::raw('YEARWEEK(created_at, 1) as period'),
                    DB::raw('COUNT(*) as total_order'),
                    DB::raw('SUM(total_price) as total_income'),
                    DB::raw('SUM(ppn) as total_ppn'),
                    // DB::raw('MAX(DATE(created_at)) as date'),
                    DB::raw('MIN(DATE(created_at)) as any_date'),
                    // DB::raw('MAX(DATE(created_at)) as end_date'),
                ])->groupBy('outlet_id', DB::raw('YEARWEEK(created_at, 1)'));
                break;

            case 'monthly':
                $query->select([
                    'outlet_id',
                    DB::raw("DATE_FORMAT(created_at, '%Y-%m') as period"),
                    DB::raw('COUNT(*) as total_order'),
                    DB::raw('SUM(total_price) as total_income'),
                    DB::raw('SUM(ppn) as total_ppn'),
                    DB::raw('MAX(DATE(created_at)) as date'),
                ])->groupBy('outlet_id', DB::raw("DATE_FORMAT(created_at, '%Y-%m')"));
                break;

            default:
                $query->select([
                    'outlet_id',
                    DB::raw('DATE(created_at) as period'),
                    DB::raw('COUNT(DISTINCT orders.id) as total_order'),
                    DB::raw('SUM(total_price) as total_income'),
                    DB::raw('SUM(ppn) as total_ppn'),
                    // DB::raw('DATE(created_at) as date'),
                    DB::raw('MAX(DATE(created_at)) as date'),
                ])->groupBy('outlet_id', DB::raw('DATE(created_at)'));
                break;
        }

        if ($user->username !== 'administrator') {
            $query->where('outlet_id', $user->outlet_id);
        }

        if ($start && $end) {
            $query->whereBetween('created_at', [
                Carbon::parse($start)->startOfDay(),
                Carbon::parse($end)->endOfDay()
            ]);
        }

        $orderColumn = match ($filter) {
            'weekly' => 'any_date',
            'monthly' => 'date',
            default => 'date',
        };

        return $query->orderByDesc($orderColumn);
    }

    private function buildProfitQuery($filter, $user)
    {
        $query = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('menus', 'menus.id', '=', 'order_items.menu_id')
            ->join('payments', 'payments.order_id', '=', 'orders.id')
            ->leftJoin('prices', function ($join) {
                $join->on('menus.id', '=', 'prices.menu_id')
                    ->whereColumn('prices.promo_start_date', '<=', 'orders.created_at')
                    ->whereColumn('prices.promo_end_date', '>=', 'orders.created_at');
            })
            ->where('orders.order_status', 'Selesai')
            ->where('payments.payment_status', 'Lunas');

        $select = fn($groupBy) => [
            DB::raw("$groupBy as period"),
            DB::raw('SUM((
                CASE
                    WHEN prices.price_promo IS NOT NULL AND prices.price_promo > 0
                    THEN ((menus.price - prices.price_promo) - menus.cost_price)
                    ELSE (menus.price - menus.cost_price)
                END
            ) * order_items.quantity) as total_profit')
        ];

        switch ($filter) {
            case 'weekly':
                $query->select($select('YEARWEEK(orders.created_at, 1)'))
                    ->groupBy(DB::raw('YEARWEEK(orders.created_at, 1)'));
                break;

            case 'monthly':
                $query->select($select("DATE_FORMAT(orders.created_at, '%Y-%m')"))
                    ->groupBy(DB::raw("DATE_FORMAT(orders.created_at, '%Y-%m')"));
                break;

            default:
                $query->select($select('DATE(orders.created_at)'))
                    ->groupBy(DB::raw('DATE(orders.created_at)'));
                break;
        }

        if ($user->username !== 'administrator') {
            $query->where('orders.outlet_id', $user->outlet_id);
        }

        return $query;
    }
}
