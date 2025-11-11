@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h3 class="fw-bold mb-4">DASHBOARD</h3>

    <div class="row text-center">
        {{-- ✅ Total Transaksi --}}
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header bg-danger text-white fw-bold">Transaksi</div>
                <div class="card-body bg-dark text-white fs-1 fw-bold">
                    {{ $totalTransaksi }}
                </div>
            </div>
        </div>

        {{-- Total Stok Produk --}}
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header bg-danger text-white fw-bold">Stok</div>
                <div class="card-body bg-dark text-white fs-1 fw-bold">
                    {{ $totalStok }}
                </div>
            </div>
        </div>

        {{-- Total Supplier --}}
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header bg-danger text-white fw-bold">Supplier</div>
                <div class="card-body bg-dark text-white fs-1 fw-bold">
                    {{ $totalSupplier }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
