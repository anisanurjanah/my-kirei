<?php

namespace App\Models;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}
