<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'method' => 'array',
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
