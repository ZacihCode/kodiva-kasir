<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parkir extends Model
{
    use HasFactory;

    protected $table = 'parkir';

    protected $fillable = [
        'jenis_parkir',
        'deskripsi',
        'harga',
    ];
}
