<?php

namespace App\Http\Controllers\Api;

use App\Models\Outlet;
use App\Http\Controllers\Controller;

class OutletController extends Controller
{
    public function index()
    {
        $outlets = Outlet::all();
        return response()->json([
            'message' => 'Outlet successfully displayed',
            'outlets' => $outlets
        ]);
    }
}
