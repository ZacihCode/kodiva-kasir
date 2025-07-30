<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('slip_gaji', function (Blueprint $table) {
            $table->id();
            $table->string('nama_karyawan');
            $table->string('posisi');
            $table->integer('gaji_pokok');
            $table->integer('tunjangan');
            $table->integer('potongan');
            $table->integer('total_gaji');
            $table->string('status')->default('Belum Terkirim');
            $table->string('no_wa');
            $table->timestamps();
        });
    }
};
