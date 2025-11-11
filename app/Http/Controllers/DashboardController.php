<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Supplier;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung total stok semua produk
        $totalStok = Produk::sum('stok_kg');

        // Hitung total supplier
        $totalSupplier = Supplier::count();

        // ✅ Hitung total transaksi
        $totalTransaksi = Transaksi::count();

        // Kirim ke view
        return view('dashboard.index', compact('totalStok', 'totalSupplier', 'totalTransaksi'));
    }
}
