<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Outlet;
use App\Models\Customer;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::guard('web')->user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        // Orders
        $queryOrders = Order::query();

        if ($user->username !== 'administrator') {
            $queryOrders->where('outlet_id', $user->outlet_id);
        }

        $orders = (clone $queryOrders)->with(['outlet', 'customer', 'payment'])->latest()->paginate(10)->withQueryString();
        $totalOrders = (clone $queryOrders)->count();
        $totalTransactions = (clone $queryOrders)->whereDate('created_at', today())->count();
        $dailyRevenue = (clone $queryOrders)->whereDate('created_at', now())->sum('total_price');
        $monthlyRevenue = (clone $queryOrders)->whereMonth('created_at', now()->month)->sum('total_price');

        $topOutlet = (clone $queryOrders)
            ->selectRaw('outlet_id, COUNT(*) as total_orders')
            ->with('outlet')
            ->groupBy('outlet_id')
            ->orderByDesc('total_orders')
            ->first()?->outlet->name;

        return view('dashboard.orders.index', [
            'orders' => $orders,
            'outlets' => Outlet::all(),
            'totalOrders' => $totalOrders,
            'totalTransactions' => $totalTransactions,
            'monthlyRevenue' => $monthlyRevenue,
            'dailyRevenue' => $dailyRevenue,
            'topOutlet' => $topOutlet,
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
            'menus' => Menu::with(['stock', 'pricePromo'])->get(),

            'orderTypes' => Order::ORDER_TYPES,
            'orderStatuses' => Order::ORDER_STATUSES,
            // 'paymentStatuses' => Order::PAYMENT_STATUSES
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $param1, $param2 = null)
    {
        dd($request->all());
        [$outlet_code, $order_number] = $this->parseOutletAndUnique($param1, $param2);

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
            // 'user_id' => 'required|exists:users,id',
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
            'order_type' => 'required|string|in:Dine In,Take Away',
            'order_status' => 'required|string|in:Selesai,Dibatalkan',
        ]);

        // Generate Order Number
        $outlet = Outlet::find($request->outlet_id);
        $formattedDate = Carbon::parse($validatedData['order_date'])->format('Ymd');
        $randomNumber = mt_rand(100000, 999999);

        $order_number = $formattedDate . Str::slug($outlet->outlet_code) . $randomNumber;

        $validatedData['order_number'] = $order_number;

        // Insert Data
        $order = Order::create([
            'outlet_id' => $validatedData['outlet_id'],
            'customer_id' => $validatedData['customer_id'],
            // 'user_id' => $validatedData['user_id'],
            'order_number' => $validatedData['order_number'],
            'order_date' => $validatedData['order_date'],
            'sub_total' => $validatedData['sub_total'],
            'discount' => $validatedData['discount'],
            'total_price' => $validatedData['total_price'],
            'order_type' => $validatedData['order_type'],
            'order_status' => $validatedData['order_status'],
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
        return redirect()->to(secure_url("/" . ($outlet_code ? "$outlet_code/" : "") . "dashboard/orders"))
            ->with('success', 'Pesanan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($param1, $param2 = null)
    {
        [$outlet_code, $order_number] = $this->parseOutletAndUnique($param1, $param2);

        $order = Order::with(['outlet', 'customer', 'payment'])->where('order_number', $order_number)->firstOrFail();
        $orderItems = OrderItem::latest()->with('menu')->where('order_id', $order->id);

        return view('dashboard.orders.show', [
            'order' => $order,
            'orderItems' => $orderItems,
            'outlet_code' => $outlet_code
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($param1, $param2 = null)
    {

        [$outlet_code, $order_number] = $this->parseOutletAndUnique($param1, $param2);

        $order = Order::with(['outlet', 'customer', 'payment'])->where('order_number', $order_number)->firstOrFail();

        return view('dashboard.orders.edit', [
            'order' => $order,
            'outlets' => Outlet::all(),
            'customers' => Customer::all(),
            'menus' => Menu::with('pricePromo')->get(),
            'outlet_code' => $outlet_code,
            'orderTypes' => Order::ORDER_TYPES,
            'orderStatuses' => Order::ORDER_STATUSES,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $param1, $param2 = null)
    {
        dd($request->all());

        [$outlet_code, $order_number] = $this->parseOutletAndUnique($param1, $param2);

        $order = Order::with(['orderItems', 'payment'])->where('order_number', $order_number)->firstOrFail();

        // Remove Price's Dot
        $request->merge([
            'price' => array_map(function($value) {
                return (int) str_replace(['.', ','], ['', '.'], $value);
            }, $request->price),
            'sub_total' => (int) str_replace(['.', ','], ['', '.'], $request->sub_total),
            'discount' => $request->discount ? (int) str_replace(['.', ','], ['', '.'], $request->discount) : null,
            'total_price' => (int) str_replace(['.', ','], ['', '.'], $request->total_price),
        ]);

        // Validated
        $validatedData = $request->validate([
            'outlet_id' => 'required|exists:outlets,id',
            'customer_id' => 'required|exists:customers,id',
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
            'order_type' => 'required|string|in:Dine In,Take Away',
            'order_status' => 'required|string|in:Selesai,Dibatalkan,Dalam Proses,Ditunda',
        ]);

        // Insert Data
        $order->update([
            'outlet_id' => $validatedData['outlet_id'],
            'customer_id' => $validatedData['customer_id'],
            'order_date' => $validatedData['order_date'],
            'sub_total' => $validatedData['sub_total'],
            'discount' => $validatedData['discount'],
            'total_price' => $validatedData['total_price'],
            'order_type' => $validatedData['order_type'],
            'order_status' => $validatedData['order_status'],
        ]);

        if (count($request->menu_id) !== count($request->quantity) || count($request->menu_id) !== count($request->price)) {
            return redirect()->back()->withErrors(['menu_id' => 'Data menu, quantity, dan harga tidak valid.']);
        }

        // Decrease menu stock
        if ($previousStatus !== 'Selesai' && $validatedData['order_status'] === 'Selesai') {
            foreach ($request->menu_id as $index => $menuId) {
                $menu = Menu::with('stock')->find($menuId);
                $stock = $menu?->stock;

                if ($menu && $stock) {
                    $stock->current_stock -= $request->quantity[$index];
                    if ($stock->current_stock < 0) {
                        $stock->current_stock = 0;
                    }
                    $stock->save();
                }
            }
        }

        $order->orderItems()->delete();
        foreach ($request->menu_id as $index => $menuId) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $menuId,
                'quantity' => $request->quantity[$index],
                'price' => $request->price[$index],
            ]);
        }

        // Redirect to orders
        return redirect()->to(secure_url("/" . ($outlet_code ? "$outlet_code/" : "") . "dashboard/orders"))
            ->with('success', 'Pesanan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($param1, $param2 = null)
    {
        [$outlet_code, $order_number] = $this->parseOutletAndUnique($param1, $param2);

        $order = Order::where('order_number', $order_number)->firstOrFail();
        Order::destroy($order->id);

        // Redirect to orders
        return redirect()->to(secure_url("/" . ($outlet_code ? "$outlet_code/" : "") . "dashboard/orders"))
            ->with('success', 'Pesanan berhasil dihapus!');
    }

    // public function getUsers($outletCode)
    // {
    //     $outlet = Outlet::where('outlet_code', $outletCode)->first();

    //     if (!$outlet) {
    //         return response()->json(['message' => 'Outlet tidak ditemukan'], 404);
    //     }

    //     $users = User::where('outlet_id', $outlet->id)->get();
    //     return response()->json($users);
    // }

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

    public function markAsComplete($order_number)
    {
        $order = Order::with(['orderItems.menu.stock'])->where('order_number', $order_number)->firstOrFail();

        if ($order->order_status !== 'Selesai') {
            foreach ($order->orderItems as $item) {
                $menu = $item->menu;
                $stock = $menu->stock;

                if ($menu && $stock) {
                    $stock->current_stock -= $item->quantity;
                    if ($stock->current_stock < 0) {
                        $stock->current_stock = 0;
                    }
                    $stock->save();
                }
            }

            $order->order_status = 'Selesai';
            $order->save();
        }

        return back()->with('success', 'Pesanan ditandai sebagai selesai.');
    }
}
