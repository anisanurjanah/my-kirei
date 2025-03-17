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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    const ORDER_STATUSES = [
        'Selesai' => 'Selesai',
        'Dibatalkan' => 'Dibatalkan',
    ];

    const PAYMENT_STATUSES = [
        'Lunas' => 'Lunas',
        'Belum Lunas' => 'Belum Lunas',
    ];
}
