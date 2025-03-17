<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Outlet;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
            'menus' => Menu::with('pricePromo')->get(),

            'orderTypes' => Order::ORDER_TYPES,
            'orderStatuses' => Order::ORDER_STATUSES,
            'paymentStatuses' => Order::PAYMENT_STATUSES
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        // Remove Price's Dot
        $request->merge([
            'price' => array_map(function($value) {
                return (int) str_replace(['.', ','], ['', '.'], $value);
            }, $request->price),
            'sub_total' => (int) str_replace(['.', ','], ['', '.'], $request->sub_total),
            'discount' => (int) str_replace(['.', ','], ['', '.'], $request->discount),
            'total_price' => (int) str_replace(['.', ','], ['', '.'], $request->total_price),
        ]);

        // Validated
        $validatedData = $request->validate([
            'outlet_id' => 'required|exists:outlets,id',
            'customer_id' => 'required|exists:customers,id',
            'user_id' => 'required|exists:users,id',
            'order_date' => 'required|date',
            'menu_id' => 'required|array',
            'menu_id.*' => 'exists:menus,id',
            'quantity' => 'required|array',
            'quantity.*' => 'integer|min:1',
            'price' => 'required|array',
            'price.*' => 'integer|min:0',
            'sub_total' => 'required|integer|min:0',
            'discount' => 'nullable|integer|min:0',
            'total_price' => 'required|integer|min:0',
            'order_status' => 'required|string|in:Selesai,Dibatalkan',
            'payment_status' => 'required|string|in:Lunas,Belum Lunas',
        ]);

        // Generate Order Number
        $outlet = Outlet::find($request->outlet_id);
        $formattedDate = Carbon::parse($validatedData['order_date'])->format('Ymd');
        $randomNumber = mt_rand(100000, 999999);

        $orderNumber = $formattedDate . Str::slug($outlet->outlet_code) . $randomNumber;

        $validatedData['order_number'] = $orderNumber;

        // Insert Data
        $order = Order::create([
            'outlet_id' => $validatedData['outlet_id'],
            'customer_id' => $validatedData['customer_id'],
            'user_id' => $validatedData['user_id'],
            'order_number' => $validatedData['order_number'],
            'order_date' => $validatedData['order_date'],
            'sub_total' => $validatedData['sub_total'],
            'discount' => $validatedData['discount'],
            'total_price' => $validatedData['total_price'],
            'order_status' => $validatedData['order_status'],
            'payment_status' => $validatedData['payment_status'],
        ]);

        if (count($request->menu_id) !== count($request->quantity) || count($request->menu_id) !== count($request->price)) {
            return redirect()->back()->withErrors(['menu_id' => 'Data menu, quantity, dan harga tidak valid.']);
        }

        foreach ($request->menu_id as $index => $menuId) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $menuId,
                'quantity' => $request->quantity[$index],
                'price' => $request->price[$index],
            ]);
        }

        // Redirect to orders
        return redirect('/dashboard/orders')->with('success', 'Pesanan berhasil ditambahkan!');
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
        return view('dashboard.orders.edit', [
            'order' => $order,
            'outlets' => Outlet::all(),
            'customers' => Customer::latest()->get(),
            'users' => User::all(),
            'menus' => Menu::with('pricePromo')->get(),

            'orderStatuses' => Order::ORDER_STATUSES,
            'paymentStatuses' => Order::PAYMENT_STATUSES
        ]);
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
        Order::destroy($order->id);

        // Redirect to orders
        return redirect('/dashboard/orders')->with('success', 'Pesanan berhasil dihapus!');
    }

    public function getUsers($outletCode)
    {
        $outlet = Outlet::where('outlet_code', $outletCode)->first();

        if (!$outlet) {
            return response()->json(['message' => 'Outlet tidak ditemukan'], 404);
        }

        $users = User::where('outlet_id', $outlet->id)->get();
        return response()->json($users);
    }

    public function getMenus($outletCode)
    {
        $outlet = Outlet::where('outlet_code', $outletCode)->first();

        if (!$outlet) {
            return response()->json(['message' => 'Outlet tidak ditemukan'], 404);
        }

        $menus = Menu::with('pricePromo')
            ->where('outlet_id', $outlet->id)
            ->get();

        return response()->json($menus);
    }
}
