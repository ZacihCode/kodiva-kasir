<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('diskon', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_diskon');
            $table->text('deskripsi')->nullable();
            $table->decimal('persentase', 5, 2); // contoh: 15.00 berarti 15%
            $table->timestamps();
        });
    }
};
