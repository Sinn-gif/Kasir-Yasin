<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'supplier';
    protected $primaryKey = 'id_supplier';

    protected $fillable = [
        'nama_perusahaan',
        'kontak',
        'alamat',
        'nama_supplier',
    ];

   
    public function produk()
    {
        return $this->hasMany(Produk::class, 'id_supplier', 'id_supplier');
    }
}
