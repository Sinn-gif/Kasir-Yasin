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
        
        $totalStok = Produk::sum('stok_kg');

        
        $totalSupplier = Supplier::count();

        
        $totalTransaksi = Transaksi::count();

        
        return view('dashboard.index', compact('totalStok', 'totalSupplier', 'totalTransaksi'));
    }
}
