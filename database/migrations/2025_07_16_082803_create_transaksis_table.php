<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('metode_pembayaran');
            $table->integer('subtotal');
            $table->integer('diskon');
            $table->integer('parkir');
            $table->integer('total');
            $table->json('detail');
            $table->timestamps();
        });
    }
};
