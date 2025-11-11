<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Produk;
use App\Models\DetailTransaksi;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function index()
    {
        $produk = Produk::all();
        $cart = session('cart', []);
        return view('transaksi.index', compact('produk', 'cart'));
    }

    public function tambahKeKeranjang(Request $request)
    {
        $produk = Produk::find($request->id_produk);
        if (!$produk) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$request->id_produk])) {
            $cart[$request->id_produk]['qty'] += $request->qty;
        } else {
            $cart[$request->id_produk] = [
                'id' => $produk->id_produk,
                'nama' => $produk->nama_produk,
                'harga' => $produk->harga_per_produk,
                'qty' => $request->qty,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function hapusDariKeranjang($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Produk dihapus dari keranjang.');
    }

    public function simpan(Request $request)
    {
        $pesanan = $request->input('pesanan', []);

        if (empty($pesanan)) {
            return response()->json(['message' => 'Tidak ada pesanan yang dikirim.'], 400);
        }

        DB::beginTransaction();

        try {
            $totalTransaksi = 0;
            $totalItemTerjual = 0;

            // 🔹 Buat transaksi utama
            $transaksi = Transaksi::create([
                'tanggal' => Carbon::now()->toDateString(),
                'total_harga' => 0,
                'id_kasir' => 1, // sesuaikan dengan login kasir kamu
            ]);

            // 🔹 Simpan setiap item detail
            foreach ($pesanan as $item) {
                $produk = Produk::find($item['id']);
                if (!$produk) continue;

                if ($produk->stok_kg < $item['qty']) {
                    DB::rollBack();
                    return response()->json([
                        'message' => "Stok tidak cukup untuk produk {$produk->nama_produk}"
                    ], 400);
                }

                // Kurangi stok
                $produk->stok_kg -= $item['qty'];
                $produk->save();

                // Hitung subtotal
                $subtotal = $produk->harga_per_produk * $item['qty'];
                $totalTransaksi += $subtotal;
                $totalItemTerjual += $item['qty'];

                // 🔹 Simpan detail transaksi (dengan nama produk agar tidak hilang jika produk dihapus)
                DetailTransaksi::create([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'id_produk' => $produk->id_produk,
                    'nama_produk' => $produk->nama_produk, // disimpan di tabel detail
                    'jumlah_kg' => $item['qty'],
                    'subtotal' => $subtotal,
                ]);
            }

            // 🔹 Update total transaksi
            $transaksi->update([
                'total_harga' => $totalTransaksi,
            ]);

            // 🔹 Simpan ke laporan
            Laporan::create([
                'id_transaksi' => $transaksi->id_transaksi,
                'jumlah_transaksi' => $totalItemTerjual,
                'total_penjualan' => $totalTransaksi,
                'periode' => Carbon::now()->toDateString(),
            ]);

            DB::commit();
            session()->forget('cart');

            return response()->json(['message' => 'Transaksi dan laporan berhasil disimpan!']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan transaksi: ' . $e->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan transaksi: ' . $e->getMessage()
            ], 500);
        }
    }
}
