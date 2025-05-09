<?php

namespace App\Models;

use App\Models\User;
use App\Models\Outlet;
use App\Models\Customer;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
}

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getRouteKeyName()
    {
        return 'order_number';
    }

    const ORDER_TYPES = [
        'Dine In' => 'Dine In',
        'Take Away' => 'Take Away',
    ];

    const ORDER_STATUSES = [
        'Ditunda' => 'Ditunda',
        'Selesai' => 'Selesai',
        'Dibatalkan' => 'Dibatalkan',
        'Dalam Proses' => 'Dalam Proses'
    ];
}
