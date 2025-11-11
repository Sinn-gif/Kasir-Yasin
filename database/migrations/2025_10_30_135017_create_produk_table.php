<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->bigIncrements('id_produk');
            $table->string('nama_produk');
            $table->decimal('harga_per_produk', 12, 2);
            $table->decimal('stok_kg',12,2);
            $table->unsignedBigInteger('id_supplier');
            $table->string('gambar');
            $table->timestamps();

            $table->foreign('id_supplier')
                  ->references('id_supplier')
                  ->on('supplier')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
