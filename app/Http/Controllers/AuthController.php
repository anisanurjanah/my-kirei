<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegister($outlet_code)
    {
        return Inertia::render('Auth/Register', [
            'outlet_code' => $outlet_code
        ]);
    }

    public function register(Request $request, $outlet_code)
    {
        // Phone formatting
        $phoneNumber = preg_replace('/[^\d+]/', '', $request->phone);
        $formattedPhone = '+62' . $phoneNumber;

        $request->validate([
            'name' => 'required|max:32',
            'phone' => 'required|min:12|max:18',
        ]);

        // Check if phone number already exists in the database
        $existingCustomer = Customer::where('phone', $formattedPhone)->first();
        if ($existingCustomer) {
            return redirect()->back()->with('error', 'Nomor telepon sudah terdaftar, silakan masukkan nomor lain.');
        }

        // Generate username
        $username = Str::slug($request->name);
        $existingUsernameCount = Customer::where('username', 'LIKE', "$username%")->count();
        if($existingUsernameCount > 0) {
            $username .= '-' . ($existingUsernameCount + 1);
        }

        Customer::create([
            'name' => $request->name,
            'username' => $username,
            'phone' => $formattedPhone,
        ]);

        return redirect("/{$outlet_code}/login")->with('success', 'Akun Anda berhasil didaftarkan!');
    }

    public function showLogin($outlet_code)
    {
        return Inertia::render('Auth/Login', [
            'outlet_code' => $outlet_code
        ]);
    }

    public function login(Request $request, $outlet_code)
    {
        // Phone formatting
        $phoneNumber = preg_replace('/[^\d+]/', '', $request->phone);
        $formattedPhone = '+62' . $phoneNumber;

        $request->validate([
            'phone' => 'required|min:12|max:18',
        ]);

        $customer = Customer::where('phone', $formattedPhone)->first();
        if ($customer) {
            Auth::guard('customer')->login($customer);
            $request->session()->regenerate();

            return redirect()->intended("/{$outlet_code}/menu-page")
                ->with('success', "Selamat datang di Kirei Sum,")
                ->with('customer', $customer->only(['id', 'name', 'phone']));
        }

        return redirect()->back()->with('error', 'Nomor telepon tidak terdaftar. Silakan daftarkan akun Anda untuk melanjutkan.');
    }

    public function logout(Request $request, $outlet_code)
    {
        $customer = Auth::guard('customer')->user();

        if ($customer) {
            Auth::guard('customer')->logout();

            session()->flush();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect("/{$outlet_code}/login")->with('logout_success', 'Anda berhasil keluar. Sampai jumpa!');
        }

        return redirect("/{$outlet_code}/login");
    }
}
