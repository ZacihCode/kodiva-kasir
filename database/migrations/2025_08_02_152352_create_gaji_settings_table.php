<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gaji_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('gaji_per_hadir')->default(50000);
            $table->integer('tunjangan_default')->default(0);
            $table->integer('potongan_default')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gaji_settings');
    }
};
