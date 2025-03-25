<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function register(Request $request, $outlet_code)
    {
        // Remove Phone's Strip
        $phoneNumber = preg_replace('/[^\d+]/', '', $request->phone);

        $formattedPhone = '+62' . $phoneNumber;

        // Validated
        $request->validate([
            'name' => 'required|max:32',
            'phone' => 'required|min:12|max:18',
        ]);

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
            'message' => 'Successfully registered',
            'token' => $token,
            'outlet_code' => $outlet_code,
            'customer' => $customer
        ]);
    }

    public function login(Request $request, $outlet_code)
    {
        // Remove Phone's Strip
        $phoneNumber = preg_replace('/[^\d+]/', '', $request->phone);

        $formattedPhone = '+62' . $phoneNumber;

        $request->validate([
            'phone' => 'required|min:10|max:14',
        ]);

        // Check if phone number in the database
        $customer = Customer::where('phone', $formattedPhone)->first();
        if (!$customer) {
            return response()->json([
                'message' => 'Not found',
                'errors' => [
                    'phone' => ['Nomor telepon tidak terdaftar.']
                ]
            ], 400);
        }

        // Create token
        $token = $customer->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Successfully logged in',
            'token' => $token,
            'outlet_code' => $outlet_code,
            'customer' => $customer,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function customer(Request $request)
    {
        return response()->json($request->user());
    }
}
