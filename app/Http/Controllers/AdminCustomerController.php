<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.customers.index', [
            'customers' => Customer::latest()->paginate(10)->withQueryString(),
            'totalCustomers' => Customer::count(),
            'totalOrders' => Order::count(),
            'newCustomers' => Customer::where('created_at', '>=', Carbon::now()->subWeek())->count(),
            'activeCustomers' => Order::where('created_at', '>=', Carbon::now()->subWeek())->distinct('customer_id')->count(),
            'avgPurchases' => Order::selectRaw('COUNT(id) / COUNT(DISTINCT customer_id) as avg_purchases')
                                ->where('created_at', '>=', Carbon::now()->subMonth())
                                ->value('avg_purchases')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Remove Phone's Strip
        $phoneNumber = preg_replace('/[^\d+]/', '', $request->phone);

        $formattedPhone = '(+62) ' . substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 4) . ' ' . substr($phoneNumber, 7);

        // Validated
        $validatedData = $request->validate([
            'name' => 'required|max:32',
            'phone' => 'required|max:20',
        ]);

        $validatedData['phone'] = $formattedPhone;

        Customer::create($validatedData);

        // Redirect to customer
        return redirect('/dashboard/customers')->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
