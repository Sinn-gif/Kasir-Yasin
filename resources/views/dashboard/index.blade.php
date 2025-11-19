@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h3 class="fw-bold mb-4">Dashboard</h3>

    <div class="row text-center">
        {{-- Total Transaksi --}}
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header bg-danger text-white fw-bold">Transaksi</div>
                <div class="card-body bg-dark text-white fs-1 fw-bold">
                    {{ $totalTransaksi }}
                </div>
            </div>
        </div>

        {{-- Total Stok Produk --}}
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header bg-danger text-white fw-bold">Stok Per(KG)</div>
                <div class="card-body bg-dark text-white fs-1 fw-bold">
                    {{ $totalStok }}
                </div>
            </div>
        </div>

        {{-- Total Supplier --}}
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header bg-danger text-white fw-bold">Supplier</div>
                <div class="card-body bg-dark text-white fs-1 fw-bold">
                    {{ $totalSupplier }}
                </div>
            </div>
        </div>

        {{-- Total Pendapatan --}}
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header bg-danger text-white fw-bold">Pendapatan</div>
                <div class="card-body bg-dark text-white fs-1 fw-bold">
                    Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        {{-- Data Barang Masuk --}}
        <div class="col-md-8 mb-3">
            <div class="card shadow">
                <div class="card-header bg-primary text-white fw-bold">
                    Data Barang Masuk
                </div>

                <div class="card-body p-0">
                    <table class="table table-bordered mb-0 text-center align-middle">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th>Nama Produk</th>
                                <th>Stok (KG)</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($produk as $p)
                            <tr>
                                <td>{{ $p->nama_produk }}</td>
                                <td>{{ $p->stok_kg }}</td>
                                <td>Rp {{ number_format($p->harga_per_kg, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-danger fw-bold">Belum ada produk masuk</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Daftar Supplier --}}
        <div class="col-md-4 mb-3">
            <div class="card shadow">
                <div class="card-header bg-success text-white fw-bold">
                    Daftar Supplier
                </div>

                <div class="card-body p-0">
                    <table class="table table-bordered mb-0 text-center align-middle">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th>Nama Supplier</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($supplier as $s)
                                <tr>
                                    <td>{{ $s->nama_supplier }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-danger fw-bold">Belum ada supplier</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
