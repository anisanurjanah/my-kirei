<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Outlet;
use App\Models\OrderItem;
use App\Models\Stock;
use App\Models\Price;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
// use Cviebrock\EloquentSluggable\Services\SlugService;

class AdminMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.menus.index', [
            'menus' => Menu::latest()->with(['stock', 'pricePromo'])->paginate(10)->withQueryString(),
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
        return view('dashboard.menus.create', [
            'outlets' => Outlet::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Remove Price's Dot
        $request->merge([
            'price' => str_replace('.', '', $request->price),
            'price_promo' => str_replace('.', '', $request->price_promo),
        ]);

        // Validated
        $validatedData = $request->validate([
            'name' => 'required|max:32',
            'outlet_id' => 'required|exists:outlets,id',
            'description' => 'required|max:128',
            'image' => 'required|image|file|max:1024',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'price_promo' => 'integer|min:0|max:' . $request->price,
        ]);

        // Generate Menu Slug
        $outlet = Outlet::find($request->outlet_id);

        $slug = Str::slug($outlet->name) . '-' . Str::slug($request->name);

        $existingSlugCount = Menu::where('slug', 'LIKE', "$slug%")
            ->where('outlet_id', $request->outlet_id)
            ->count();

        if($existingSlugCount > 0) {
            $slug .= '-' . ($existingSlugCount + 1);
        }

        $validatedData['slug'] = $slug;

        // Insert Image
        if($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('menu-images');
        }

        // Insert Data
        $menu = Menu::create($validatedData);

        Stock::create([
            'menu_id' => $menu->id,
            'current_stock' => $request->stock ?? 0
        ]);

        Price::create([
            'menu_id' => $menu->id,
            'price_promo' => $request->price_promo ?? 0
        ]);

        // Redirect to menus
        return redirect('/dashboard/menus')->with('success', 'Menu berhasil ditambahkan!');
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

    // public function checkSlug(Request $request)
    // {
    //     $slug = SlugService::createSlug(Menu::class, 'slug', $request->name);
    //     return response()->json(['slug' => $slug]);
    // }
}
