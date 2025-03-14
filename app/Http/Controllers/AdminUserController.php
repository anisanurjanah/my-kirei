<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.users.index', [
            'users' => User::latest()->where('username', '!=', 'administrator')->paginate(10)->withQueryString(),
            'totalUsers' => User::count(),
            'totalOutlets' => Outlet::count(),
            'totalCashiers' => User::where('role', 'kasir')->count(),
            'totalProduction' => User::where('role', 'produksi')->count(),
            'outlets' => Outlet::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.users.create', [
            'outlets' => Outlet::all(),
            'userRoles' => User::USER_ROLES
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        // Remove Phone's Strip
        $phoneNumber = preg_replace('/[^\d+]/', '', $request->phone);

        $formattedPhone = '(+62) ' . substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 4) . ' ' . substr($phoneNumber, 7);

        // Validated
        $validatedData = $request->validate([
            'outlet_id' => 'required|exists:outlets,id',
            'name' => 'required|max:32',
            'email' => 'required|email:dns',
            'phone' => 'required|min:12|max:18',
            'username' => 'required|max:16',
            'password' => 'required|max:8',
            'role' => 'required|string|in:Kasir,Produksi',
        ]);

        $validatedData['phone'] = $formattedPhone;

        User::create($validatedData);

        // Redirect to users
        return redirect('/dashboard/users')->with('success', 'Pengguna berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('dashboard.users.edit', [
            'user' => $user,
            'outlets' => Outlet::all(),
            'userRoles' => User::USER_ROLES,
            'formatted_phone' => formatPhone($user->phone)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'outlet_id' => 'required|exists:outlets,id',
            'name' => 'required|max:32',
            'email' => 'required|email:dns',
            'phone' => 'required|min:12|max:18',
            'username' => 'required|max:16',
            'password' => 'required|max:8',
            'role' => 'required|string|in:Kasir,Produksi',
        ]);

        // Format phone number
        if ($request->filled('phone')) {
            $phoneNumber = preg_replace('/[^\d+]/', '', $request->phone);
            $formattedPhone = '(+62) ' . substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 4) . ' ' . substr($phoneNumber, 7);

            $validatedData['phone'] = $formattedPhone;
        } else {
            $validatedData['phone'] = $user->phone;
        }

        // Password
        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->password);
        } else {
            unset($validatedData['password']);
        }

        $user->update($validatedData);

        // Redirect to users
        return redirect('/dashboard/users')->with('success', 'Pengguna berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);

        // Redirect to users
        return redirect('/dashboard/users')->with('success', 'Pengguna berhasil dihapus!');
    }
}
