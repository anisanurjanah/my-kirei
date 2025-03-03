<?php

namespace App\Models;

use App\Models\Outlet;
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
}
