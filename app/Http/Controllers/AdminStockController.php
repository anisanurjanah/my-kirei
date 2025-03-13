<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Stock;
use Illuminate\Http\Request;

class AdminStockController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stock $stock)
    {
        // Validated
        $validatedData = $request->validate([
            'stock' => 'required|integer|min:0',
            'type' => 'required|in:add,update',
        ]);

        if ($request->type === 'add') {
            $stock->update([
                'current_stock' => $stock->current_stock + $validatedData['stock']
            ]);

            $message = 'Stok berhasil ditambahkan!';
        } else {
            $stock->update([
                'current_stock' => $validatedData['stock']
            ]);

            $message = 'Stok berhasil diperbarui!';
        }

        // Redirect to menus
        return redirect('/dashboard/menus')->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stock $stock)
    {
        $stock->update(['current_stock' => 0]);

        return redirect('/dashboard/menus')->with('success', 'Stok berhasil direset!');
    }
}
