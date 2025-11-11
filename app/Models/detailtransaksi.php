<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    // Nama tabel sesuai migration
    protected $table = 'detail_transaksi';

    // Primary key
    protected $primaryKey = 'id_detail';

    // Mass assignable
    protected $fillable = [
        'id_transaksi',
        'id_produk',
        'jumlah_kg', // field jumlah sesuai migration
        'subtotal'
    ];

    /**
     * Relasi ke Produk
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    /**
     * Relasi ke Transaksi
     */
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id_transaksi');
    }
}
