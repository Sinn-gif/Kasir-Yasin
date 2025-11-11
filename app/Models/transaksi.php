<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    protected $fillable = [
        'tanggal',
        'total_harga',
        'id_kasir',
    ];

    /**
     * ✅ Relasi ke model Laporan (1 transaksi punya 1 laporan)
     */
    public function laporan()
    {
        return $this->hasOne(Laporan::class, 'id_transaksi', 'id_transaksi');
    }

    /**
     * ✅ Relasi ke model DetailTransaksi (1 transaksi punya banyak detail)
     */
    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi', 'id_transaksi');
    }

    /**
     * ✅ Relasi ke Produk lewat DetailTransaksi
     * (supaya bisa akses $transaksi->produk langsung)
     */
    public function produk()
    {
        return $this->hasManyThrough(
            Produk::class,
            DetailTransaksi::class,
            'id_transaksi', // foreign key di detail_transaksi
            'id_produk',    // foreign key di produk
            'id_transaksi', // local key di transaksi
            'id_produk'     // local key di detail_transaksi
        );
    }
}
