<?php

namespace App\Models;

use App\Models\Outlet;
use App\Models\Stock;
use App\Models\Price;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    public function stock()
    {
        return $this->hasOne(Stock::class);
    }

    public function pricePromo()
    {
        return $this->hasOne(Price::class);
    }

    public function orderItem()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
