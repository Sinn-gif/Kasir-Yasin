<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;

class LaporanController extends Controller
{
   
    public function index(Request $request)
    {
        
        $query = Transaksi::with(['detailTransaksi.produk']);

        // berdasarkan tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        
        $transaksi = $query->orderBy('tanggal', 'desc')->get();

        
        $totalKeseluruhan = $transaksi->sum('total_harga');

        return view('laporan.index', compact('transaksi', 'totalKeseluruhan'));
    }

   
    public function filter(Request $request)
    {
        $query = Transaksi::with(['detailTransaksi.produk']);

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        $transaksi = $query->latest()->get();
        $totalKeseluruhan = $transaksi->sum('total_harga');

        return view('laporan.index', compact('transaksi', 'totalKeseluruhan'));
    }
}
