<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        return view('supplier.index', compact('suppliers'));
    }

    public function create()
    {
        return view('supplier.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_perusahaan' => 'required',
            'kontak' => 'required|regex:/^[0-9]+$/',
            'alamat' => 'required',
            'nama_supplier' => 'required',
        ], [
            'required' => 'Maaf, isi dengan benar.',
            'regex' => 'Maaf, isi dengan benar.',
        ]);

        Supplier::create($request->all());

        return redirect()->route('supplier.index')
            ->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function edit(Supplier $supplier)
    {
        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'nama_perusahaan' => 'required',
            'kontak' => 'required|regex:/^[0-9]+$/',
            'alamat' => 'required',
            'nama_supplier' => 'required',
        ], [
            'required' => 'Maaf, isi dengan benar.',
            'regex' => 'Maaf, isi dengan benar.',
        ]);

        $supplier->update($request->all());

        return redirect()->route('supplier.index')
            ->with('success', 'Supplier berhasil diupdate.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('supplier.index')
            ->with('success', 'Supplier berhasil dihapus.');
    }
}
