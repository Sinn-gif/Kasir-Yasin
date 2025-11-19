<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->bigIncrements('id_produk')->unique();
            $table->string('nama_produk');
            $table->decimal('harga_per_kg', 10, 2);
            $table->decimal('stok_kg', 10, 2);

            // wajib nullable untuk bisa SET NULL
            $table->unsignedBigInteger('id_supplier')->nullable();

            $table->string('gambar')->nullable();
            $table->timestamps();

            // foreign key supplier dengan SET NULL
            $table->foreign('id_supplier')
                  ->references('id_supplier')
                  ->on('supplier')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
