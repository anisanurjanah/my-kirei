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
use Illuminate\Support\Facades\Storage;
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
        $today = now()->toDateString();

        // Remove Price's Dot
        $request->merge([
            'price' => str_replace('.', '', $request->price),
            'price_promo' => str_replace('.', '', $request->price_promo),
        ]);

        // Validated
        $validatedData = $request->validate([
            'outlet_id' => 'required|exists:outlets,id',
            'name' => 'required|max:32',
            'description' => 'required|max:128',
            'image' => 'required|image|file|max:1024',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'price_promo' => 'nullable|integer|min:0|max:' . $request->price,
            'promo_start_date' => $request->price_promo ? 'required|date|after_or_equal:' . $today : 'nullable|date',
            'promo_end_date' => $request->price_promo ? 'required|date|after:promo_start_date' : 'nullable|date|after:promo_start_date',
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
            'price_promo' => $request->price_promo !== null ? $request->price_promo : null,
            'promo_start_date' => $request->price_promo ? $request->promo_start_date : null,
            'promo_end_date' => $request->price_promo ? $request->promo_end_date : null,
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
    public function edit(Menu $menu)
    {
        return view('/dashboard.menus.edit', [
            'menu' => $menu,
            'outlets' => Outlet::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        $today = now()->toDateString();

        // Remove Price's Dot
        $request->merge([
            'price' => str_replace('.', '', $request->price),
            'price_promo' => str_replace('.', '', $request->price_promo),
        ]);

        // Validated
        $validatedData = $request->validate([
            'outlet_id' => 'required|exists:outlets,id',
            'name' => 'required|max:32',
            'description' => 'required|max:128',
            'image' => 'nullable|image|file|max:1024',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'price_promo' => 'nullable|integer|min:0|max:' . $request->price,
            'promo_start_date' => $request->price_promo ? 'required|date|after_or_equal:' . $today : 'nullable|date',
            'promo_end_date' => $request->price_promo ? 'required|date|after:promo_start_date' : 'nullable|date|after:promo_start_date',
        ]);

        // Insert Image
        if($request->file('image')) {
            if($request->oldImage) {
                Storage::delete($request->oldImage);
            }

            $validatedData['image'] = $request->file('image')->store('menu-images');
        }

        // Insert Data
        $menu->update($validatedData);

        Stock::updateOrCreate(
            ['menu_id' => $menu->id],
            ['current_stock' => $request->stock ?? 0]
        );

        if ($request->price_promo === "") {
            Price::where('menu_id', $menu->id)->delete();
        } else {
            Price::updateOrCreate(
                ['menu_id' => $menu->id],
                [
                    'price_promo' => $request->price_promo,
                    'promo_start_date' => $request->promo_start_date,
                    'promo_end_date' => $request->promo_end_date
                ]
            );
        }

        // Redirect to menus
        return redirect('/dashboard/menus')->with('success', 'Menu berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        if($menu->image) {
            Storage::delete($menu->image);
        }

        Menu::destroy($menu->id);

        // Redirect to menus
        return redirect('/dashboard/menus')->with('success', 'Menu berhasil dihapus!');
    }

    // public function checkSlug(Request $request)
    // {
    //     $slug = SlugService::createSlug(Menu::class, 'slug', $request->name);
    //     return response()->json(['slug' => $slug]);
    // }
}
