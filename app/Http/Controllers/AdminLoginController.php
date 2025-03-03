<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminLoginController extends Controller
{
    public function index() {
        return view('dashboard.login.index', [
            'title' => 'Login'
        ]);
    }
}
