<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Kasir;

class KasirSeeder extends Seeder
{
    public function run(): void
    {
        $kasir = new Kasir();
        $kasir->nama_kasir = 'Budi Anwar';
        $kasir->username = 'Idola';
        $kasir->password = Hash::make('12345');
        $kasir->save();
    }
}
