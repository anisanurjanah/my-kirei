<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\Outlet;
use App\Models\User;
use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\Services\SlugService;

class AdminOutletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.outlets.index', [
            'outlets' => Outlet::paginate(10)->withQueryString(),
            'totalOutlets' => Outlet::count()
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
    public function show(Outlet $outlet)
    {
        return view('dashboard.outlets.show', [
            'outlet' => $outlet,
            'menus' => Menu::latest()->where('outlet_id', $outlet->id)->paginate(5)->withQueryString(),
            'users' => User::latest()->where('outlet_id', $outlet->id)->paginate(5)->withQueryString(),
            'orders' => Order::latest()->where('outlet_id', $outlet->id)->paginate(5)->withQueryString()
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
        $slug = SlugService::createSlug(Outlet::class, 'slug', $request->name);
        return response()->json(['slug' => $slug]);
    }
}
