<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlipGaji extends Model
{
    use HasFactory;

    protected $table = 'slip_gaji';

    protected $fillable = [
        'nama_karyawan',
        'posisi',
        'gaji_pokok',
        'tunjangan',
        'potongan',
        'total_gaji',
        'status',
        'no_wa',
    ];
}
