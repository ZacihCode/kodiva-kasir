<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_phone',
        'metode_pembayaran',
        'subtotal',
        'diskon',
        'parkir',
        'total',
        'detail',
    ];

    protected $casts = [
        'detail' => 'array',
    ];
}
