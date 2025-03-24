<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Remove Phone's Strip
        $phoneNumber = preg_replace('/[^\d+]/', '', $request->phone);

        // Validated
        $request->validate([
            'name' => 'required|max:32',
            'phone' => 'required|min:12|max:18',
        ]);

        if (Str::startsWith($phoneNumber, '62')) {
            $phoneNumber = "+{$phoneNumber}";
        } elseif (Str::startsWith($phoneNumber, '0')) {
            $phoneNumber = "+62" . substr($phoneNumber, 1);
        }

        $formattedPhone = $phoneNumber;
        // $formattedPhone = '(+62) ' . substr($phoneNumber, 2, 3) . ' ' . substr($phoneNumber, 5, 4) . ' ' . substr($phoneNumber, 9);

        // Check if phone number already exists in the database
        $existingCustomer = Customer::where('phone', $formattedPhone)->first();
        if ($existingCustomer) {
            return response()->json([
                'message' => 'Duplicate entry',
                'errors' => [
                    'phone' => ['Nomor telepon sudah terdaftar, silakan masukkan nomor lain.']
                ]
            ], 400);
        }

        // Generate username
        $username = Str::slug($request->name);

        $existingUsernameCount = Customer::where('username', 'LIKE', "$username%")
            ->count();

        if($existingUsernameCount > 0) {
            $username .= '-' . ($existingUsernameCount + 1);
        }

        // Insert data
        $customer = Customer::create([
            'name' => $request->name,
            'username' => $username,
            'phone' => $formattedPhone,
        ]);

        // Create token
        $token = $customer->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Registrasi berhasil',
            'token' => $token,
            'customer' => $customer
        ]);
    }

    public function login(Request $request, $outlet_code)
    {
        $phoneNumber = preg_replace('/[^\d+]/', '', $request->phone);

        $request->validate([
            'phone' => 'required|regex:/^(\+62|0)[0-9]{9,16}$/',
        ]);

        $customer = Customer::where('phone', $phoneNumber)->first();
        if (!$customer) {
            return response()->json(['message' => 'Nomor telepon tidak ditemukan'], 404);
        }

        $token = $customer->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'token' => $token,
            'customer' => $customer,
            'outlet_code' => $outlet_code
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Berhasil keluar']);
    }

    public function customer(Request $request)
    {
        return response()->json($request->user());
    }
}
