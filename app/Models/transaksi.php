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

   
    public function laporan()
    {
        return $this->hasOne(Laporan::class, 'id_transaksi', 'id_transaksi');
    }


    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi', 'id_transaksi');
    }

 
    public function produk()
    {
        return $this->hasManyThrough(
            Produk::class,
            DetailTransaksi::class,
            'id_transaksi',
            'id_produk',    
            'id_transaksi', 
            'id_produk'     
        );
    }
}
