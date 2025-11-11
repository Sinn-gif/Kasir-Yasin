<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->id('id_laporan');
            $table->unsignedBigInteger('id_transaksi');
            $table->integer('jumlah_transaksi')->default(0);
            $table->decimal('total_penjualan', 12, 2)->default(0);
            $table->date('periode');
            $table->timestamps();

            // Relasi ke tabel transaksi (pastikan nama & tipe cocok)
            $table->foreign('id_transaksi')
                  ->references('id_transaksi')
                  ->on('transaksi')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};
