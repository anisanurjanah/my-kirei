<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Outlet;
use App\Models\User;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.orders.index', [
            'orders' => Order::latest()->with(['outlet', 'customer', 'user'])->paginate(10)->withQueryString(),
            'outlets' => Outlet::all(),
            'totalOrders' => Order::count(),
            'totalTransactions' => Order::whereDate('created_at', today())->count(),
            'monthlyRevenue' => Order::whereMonth('created_at', now()->month)->sum('total_price'),
            'topOutlet' => Order::select('outlet_id')
                            ->with('outlet')
                            ->groupBy('outlet_id')
                            ->orderByRaw('COUNT(*) DESC')
                            ->first()?->outlet->name
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.orders.create', [
            'outlets' => Outlet::all(),
            'customers' => Customer::latest()->get(),
            'users' => User::all(),
            'menus' => Menu::all(),

            'orderStatuses' => Order::ORDER_STATUSES,
            'paymentStatuses' => Order::PAYMENT_STATUSES
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return view('dashboard.orders.show', [
            'order' => $order,
            'orderItems' => OrderItem::latest()->where('order_id', $order->id)->paginate(10)->withQueryString(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    public function getUsers($outletId)
    {
        $users = User::where('outlet_id', $outletId)->get();
        return response()->json($users);
    }

    public function getMenus($outletId)
    {
        $menus = Menu::where('outlet_id', $outletId)->get();
        return response()->json($menus);
    }
}
