<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::with('supplier')->get();
        return view('produk.index', compact('produk'));
    }

    public function create()
    {
        $supplier = Supplier::all();

        if ($supplier->isEmpty()) {
            return redirect()->route('supplier.index')
                ->with('error', 'Maaf, data supplier belum ada. Silakan tambahkan supplier terlebih dahulu.');
        }

        return view('produk.create', compact('supplier'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required',
            'harga_per_produk' => 'required|numeric',
            'stok_kg' => 'required|numeric',
            'id_supplier' => 'required|exists:supplier,id_supplier',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['nama_produk', 'harga_per_produk', 'stok_kg', 'id_supplier']);

        // upload gambar jika ada
        if ($request->hasFile('gambar')) {
            $namaFile = time() . '_' . $request->file('gambar')->getClientOriginalName();
            $request->file('gambar')->move(public_path('images'), $namaFile);
            $data['gambar'] = $namaFile;
        }

        Produk::create($data);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $supplier = Supplier::all();
        return view('produk.edit', compact('produk', 'supplier'));
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'nama_produk' => 'required',
            'harga_per_produk' => 'required|numeric',
            'stok_kg' => 'required|numeric',
            'id_supplier' => 'required|exists:supplier,id_supplier',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['nama_produk', 'harga_per_produk', 'stok_kg', 'id_supplier']);

        // upload gambar baru
        if ($request->hasFile('gambar')) {
            // hapus gambar lama 
            if ($produk->gambar && file_exists(public_path('images/' . $produk->gambar))) {
                unlink(public_path('images/' . $produk->gambar));
            }

            $namaFile = time() . '_' . $request->file('gambar')->getClientOriginalName();
            $request->file('gambar')->move(public_path('images'), $namaFile);
            $data['gambar'] = $namaFile;
        }

        $produk->update($data);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        if ($produk->gambar && file_exists(public_path('images/' . $produk->gambar))) {
            unlink(public_path('images/' . $produk->gambar));
        }

        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }
}
