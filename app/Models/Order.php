<?php

namespace App\Models;

use App\Models\Outlet;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

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
}
