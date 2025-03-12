<?php

namespace App\Livewire;

use App\Models\Menu;
use App\Models\User;
use App\Models\Order;
use App\Models\Outlet;
use Livewire\Component;
use App\Models\Customer;

class OrderForm extends Component
{
    public $outlet_id, $customer_id, $user_id, $order_date,
    $menu_id, $quantity, $sub_total, $total_price,
    $order_status, $payment_status;

    // public $sub_total = 0;
    public $users = [];
    public $menus = [];

    protected $rules = [
        'outlet_id' => 'required|exists:outlets,id',
        'customer_id' => 'required|exists:customers,id',
        'user_id' => 'required|exists:users,id',
        'order_date' => 'required|date',
        'menu_id' => 'required|exists:menus,id',
        'quantity' => 'required|integer|min:1',
        'sub_total' => 'required|numeric|min:0',
        'total_price' => 'required|numeric|min:0',
        'order_status' => 'required|string',
        'payment_status' => 'required|string',
    ];

    // protected $listeners = ['updateSubTotal' => 'updateTotal'];

    public function mount()
    {
        $this->order_status = 'Dibatalkan';
        $this->payment_status = 'Belum Lunas';

        $firstOutlet = Outlet::first();
        if ($firstOutlet) {
            $this->outlet_id = $firstOutlet->id;
            $this->users = User::where('outlet_id', $firstOutlet->id)->get();
            $this->menus = Menu::where('outlet_id', $firstOutlet->id)->get();
        }
    }

    public function updatedOutletId($value)
    {
        $this->users = User::where('outlet_id', $value)->get()->toArray();
        $this->menus = Menu::where('outlet_id', $value)->get()->toArray();

        dd($this->users, $this->menus);

        $this->user_id = null;
        $this->menu_id = null;
        $this->quantity = 1;
        $this->sub_total = 0;
        $this->total_price = 0;
    }

    // public function updateTotal($value)
    // {
    //     $this->sub_total = $value;
    // }

    public function updatedMenuId($value)
    {
        $menu = Menu::find($value);
        if ($menu) {
            $this->sub_total = $this->quantity * $menu->price;
            $this->total_price = $this->sub_total;
        }
    }

    public function updatedQuantity()
    {
        $menu = Menu::find($this->menu_id);
        if ($menu) {
            $this->sub_total = $this->quantity * $menu->price;
            $this->total_price = $this->sub_total;
        }
    }

    public function save()
    {
        $this->validate();

        Order::create([
            'outlet_id' => $this->outlet_id,
            'customer_id' => $this->customer_id,
            'user_id' => $this->user_id,
            'order_date' => $this->order_date,
            'menu_id' => $this->menu_id,
            'quantity' => $this->quantity,
            'sub_total' => $this->sub_total,
            'total_price' => $this->total_price,
            'order_status' => $this->order_status,
            'payment_status' => $this->payment_status,
        ]);

        session()->flash('message', 'Pesanan berhasil disimpan!');
        $this->reset(['outlet_id', 'customer_id', 'user_id', 'order_date', 'menu_id', 'quantity', 'sub_total', 'total_price', 'order_status', 'payment_status']);
    }

    public function render()
    {
        return view('livewire.order-form', [
            'outlets' => Outlet::all(),
            'customers' => Customer::all(),
            'orderStatuses' => Order::ORDER_STATUSES,
            'paymentStatuses' => Order::PAYMENT_STATUSES,
        ]);
    }
}
