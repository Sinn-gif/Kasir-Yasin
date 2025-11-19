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
        // Total transaksi
        $totalTransaksi = Transaksi::count();

        // Total stok semua produk
        $totalStok = Produk::sum('stok_kg');

        // Total supplier
        $totalSupplier = Supplier::count();

        // Total pendapatan (jumlah semua total_harga di tabel transaksi)
        $totalPendapatan = Transaksi::sum('total_harga');

        // Ambil daftar produk untuk tabel
        $produk = Produk::all();

        // Ambil daftar supplier untuk tabel
        $supplier = Supplier::all();

        return view('dashboard.index', compact(
            'totalTransaksi',
            'totalStok',
            'totalSupplier',
            'totalPendapatan',
            'produk',
            'supplier'
        ));
    }
}
