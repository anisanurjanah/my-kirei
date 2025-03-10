<?php

namespace App\Livewire;

use App\Models\Menu;
use App\Models\User;
use App\Models\Outlet;
use Livewire\Component;

class OrderForm extends Component
{
    public $outlet_id;
    public $users = [];
    public $menus = [];

    public function updatedOutletId($value)
    {
        $this->users = User::where('outlet_id', $value)->get();
        $this->menus = Menu::where('outlet_id', $value)->get();
    }

    public function render()
    {
        return view('livewire.order-form', [
            'outlets' => Outlet::all()
        ]);
    }
}
