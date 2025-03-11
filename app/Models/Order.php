<?php

namespace App\Models;

use App\Models\User;
use App\Models\Outlet;
use App\Models\Customer;
use App\Models\OrderItem;
use Illuminate\Support\Str;
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

    public function orderItem()
    {
        return $this->hasMany(OrderItem::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->slug = static::generateSlug($order);
        });
    }

    public static function generateSlug($order)
    {
        $outletName = Str::slug($order->outlet->name);
        $orderDate = $order->order_date;
        $customerName = Str::slug($order->customer->name);

        return "{$outletName}-{$orderDate}-{$customerName}";
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    const ORDER_STATUSES = [
        'processing' => 'Diproses',
        'completed' => 'Selesai',
        'canceled' => 'Dibatalkan',
    ];

    const PAYMENT_STATUSES = [
        'paid' => 'Lunas',
        'unpaid' => 'Belum Lunas',
    ];
}
