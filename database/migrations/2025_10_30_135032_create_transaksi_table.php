<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->bigIncrements('id_transaksi');
            $table->date('tanggal');
            $table->decimal('total_harga', 12, 2);
            $table->unsignedBigInteger('id_kasir');
            $table->timestamps();

            $table->foreign('id_kasir')
                  ->references('id_kasir')
                  ->on('kasirs')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
