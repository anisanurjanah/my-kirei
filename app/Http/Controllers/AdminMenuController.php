<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Outlet;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\Services\SlugService;

class AdminMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.menus.index', [
            'menus' => Menu::with(['stock', 'pricePromo'])->paginate(10)->withQueryString(),
            'outlets' => Outlet::all(),
            'emptyStock' => Stock::orderBy('current_stock', 'asc')->first(),
            'bestSellingMenu' => OrderItem::select('menu_id')
                ->selectRaw('SUM(quantity) as total_sold')
                ->groupBy('menu_id')
                ->orderByDesc('total_sold')
                ->with('menu')
                ->first(),
            'soldToday' => OrderItem::whereHas('order', function ($query) {
                    $query->whereDate('created_at', Carbon::today());
                })->sum('quantity'),
            'soldThisMonth' => OrderItem::whereHas('order', function ($query) {
                    $query->whereMonth('created_at', Carbon::now()->month);
                })->sum('quantity')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(Menu $menu)
    {
        return view('dashboard.menus.show', [
            'menu' => $menu
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Menu::class, 'slug', $request->name);
        return response()->json(['slug' => $slug]);
    }
}
