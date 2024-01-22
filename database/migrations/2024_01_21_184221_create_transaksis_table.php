<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id('id_transaksi')->increments();
            $table->timestamps();
            $table->integer('total_item');
            $table->integer('total_harga');
            $table->biginteger('id_barang')->unsigned();
            $table->foreign('id_barang')->references('id_barang')->on('barangs')->onDelete('cascade');
            $table->string('status_pembayaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
