<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    const PAYMENT_STATUSES = [
        'Lunas' => 'Lunas',
        'Belum Lunas' => 'Belum Lunas',
        'Kadaluarsa' => 'Kadaluarsa',
        'Gagal' => 'Gagal',
        'Ditunda' => 'Ditunda',
    ];
}
