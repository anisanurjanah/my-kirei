<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Inertia\Inertia;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    public function index($outlet_code)
    {
        return Inertia::render('MenuPage', [
            'outlet_code' => $outlet_code,
        ]);
    }
}
