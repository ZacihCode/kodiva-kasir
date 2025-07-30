<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('parkir', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_parkir');
            $table->text('deskripsi')->nullable();
            $table->integer('harga');
            $table->timestamps();
        });
    }
};
