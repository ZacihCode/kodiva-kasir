<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tanggal',
        'status',
    ];

    /**
     * Relasi ke user (satu absensi milik satu user)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
