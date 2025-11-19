<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $produk = Produk::with('supplier')
            ->when($search, function ($query, $search) {
                $query->where('nama_produk', 'like', "%$search%")
                      ->orWhere('harga_per_kg', 'like', "%$search%")
                      ->orWhere('stok_kg', 'like', "%$search%")
                      ->orWhereHas('supplier', function($q) use ($search) {
                          $q->where('nama_supplier', 'like', "%$search%");
                      });
            })
            ->get();

        return view('produk.index', compact('produk', 'search'));
    }

    public function create()
    {
        $supplier = Supplier::all();

        if ($supplier->isEmpty()) {
            return redirect()->route('supplier.index')
                ->with('error', 'Maaf, harus mengisi supplier terlebih dahulu.');
        }

        return view('produk.create', compact('supplier'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk'    => 'required|string|max:255|unique:produk,nama_produk',
            'harga_per_kg'   => 'required|numeric|min:0',
            'stok_kg'        => 'required|numeric|min:0',
            'id_supplier'    => 'required|exists:supplier,id_supplier',
            'gambar'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['nama_produk', 'harga_per_kg', 'stok_kg', 'id_supplier']);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $namaFile);
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
            'nama_produk'  => 'required|string|max:255|unique:produk,nama_produk,' . $produk->id_produk . ',id_produk',
            'harga_per_kg' => 'required|numeric|min:0',
            'stok_kg'      => 'required|numeric|min:0',
            'id_supplier'  => 'required|exists:supplier,id_supplier',
            'gambar'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['nama_produk', 'harga_per_kg', 'stok_kg', 'id_supplier']);

        if ($request->hasFile('gambar')) {

            if ($produk->gambar && file_exists(public_path('images/' . $produk->gambar))) {
                unlink(public_path('images/' . $produk->gambar));
            }

            $file = $request->file('gambar');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $namaFile);
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
