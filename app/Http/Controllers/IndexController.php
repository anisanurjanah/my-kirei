<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Menu;
use App\Models\Outlet;

class IndexController extends Controller
{
    public function index()
    {
        return Inertia::render('Home', [
            'outlets' => Outlet::all(),
            'menus' => Menu::latest()->get()
        ]);
    }
}
