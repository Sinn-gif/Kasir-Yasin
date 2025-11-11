<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;

class LaporanController extends Controller
{
    /**
     * Tampilkan laporan transaksi dengan filter tanggal (tanpa bulan/tahun).
     */
    public function index(Request $request)
    {
        // Ambil semua transaksi + detail + produk
        $query = Transaksi::with(['detailTransaksi.produk']);

        // === FILTER BERDASARKAN TANGGAL ===
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        // Ambil data hasil filter
        $transaksi = $query->orderBy('tanggal', 'desc')->get();

        // Hitung total keseluruhan dari semua transaksi
        $totalKeseluruhan = $transaksi->sum('total_harga');

        return view('laporan.index', compact('transaksi', 'totalKeseluruhan'));
    }

    /**
     * Fitur filter lama: filter laporan berdasarkan tanggal awal dan akhir.
     * (Dibiarkan agar tidak merusak fungsi lain.)
     */
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
