<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GajiSetting extends Model
{
    use HasFactory;

    protected $fillable = ['gaji_per_hadir', 'tunjangan_default', 'potongan_default'];
}
