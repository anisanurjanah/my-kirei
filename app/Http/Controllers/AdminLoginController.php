<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function index() {
        return view('auth.login.index', [
            'title' => 'Login'
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            // 'email' => 'required|email:dns',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::guard('web')->user();
            if ($user->username === 'administrator') {
                return redirect()->to(secure_url("/dashboard"));
            }

            $outlet = $user->outlet->outlet_code;
            $outlet_code = strtolower($outlet);

            return redirect()->to(secure_url("/{$outlet_code}/dashboard"));
        }

        return back()->with('loginError', 'Email atau password tidak valid.');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->to(secure_url('/login'));
    }
}
