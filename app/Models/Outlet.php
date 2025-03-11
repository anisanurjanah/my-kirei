<?php

namespace App\Models;

use App\Models\Menu;
use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Outlet extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

}
