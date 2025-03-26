<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Outlet;

class OutletController extends Controller
{
    public function index()
    {
        return Inertia::render('Home', [
            'outlets' => Outlet::all(),
        ]);
    }
}
