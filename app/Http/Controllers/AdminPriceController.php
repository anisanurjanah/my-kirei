<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Price;
use Illuminate\Http\Request;

class AdminPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $menuPrice = Menu::where('id', $request->menu_id)->value('price');
        $today = now()->toDateString();

        $request->merge([
            'price_promo' => str_replace('.', '', $request->price_promo),
        ]);

        // Validated
        $validatedData = $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'price_promo' => 'required|integer|min:0|max:' . $menuPrice,
            'promo_start_date' => 'required|date|after_or_equal:date' . $today,
            'promo_end_date' => 'required|date|after:promo_start_date'
        ]);

        Price::create($validatedData);

        // Redirect to menus
        return redirect('/dashboard/menus')->with('success', 'Potongan harga berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Price $price)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Price $price)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Price $price)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Price $price)
    {
        //
    }
}
