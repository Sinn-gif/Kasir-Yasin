@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
<div class="container mt-3">
    <h3 class="fw-bold mb-4">Laporan</h3>

    <!--TANGGAL -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('laporan.index') }}" method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="fw-bold">Tanggal</label>
                        <input type="date" name="tanggal"
                               value="{{ request('tanggal') }}"
                               class="form-control">
                    </div>

                    <div class="col-md-8 d-flex justify-content-end gap-2">
                        <button class="btn fw-bold text-white px-4" style="background-color:#1aee0f;">
                            Cari
                        </button>
                        <a href="{{ route('laporan.index') }}" class="btn btn-danger fw-bold px-4">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- TABEL LAPORAN -->
   <div class="table-responsive">
    <table class="table table-bordered text-center align-middle border-3 border-primary">
        <thead class="table-danger text-white">
            <tr>
                <th>Tanggal</th>
                <th>ID Transaksi</th>
                <th>Nama Produk</th>
                <th>Jumlah Terjual</th>
                <th>Total</th>
            </tr>
        </thead>


            <tbody>
                @forelse ($transaksi as $trx)
                    @if($trx->detailTransaksi->count())
                        @foreach ($trx->detailTransaksi as $detail)
                            <tr>
                                @if($loop->first)
                                    <td rowspan="{{ $trx->detailTransaksi->count() }}">
                                        {{ $trx->tanggal }}
                                    </td>
                                    <td rowspan="{{ $trx->detailTransaksi->count() }}">
                                        {{ 'TR' . str_pad($trx->id_transaksi, 4, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <!-- ngambil nama produk di detail_transaksi -->
                                    <td>{{ $detail->nama_produk ?? $detail->produk->nama_produk ?? '-' }}</td>
                                    <td>{{ number_format($detail->jumlah_kg, 2, ',', '.') }} KG</td>
                                    <td rowspan="{{ $trx->detailTransaksi->count() }}">
                                        Rp{{ number_format($trx->total_harga, 0, ',', '.') }}
                                    </td>
                                @else
                                    <td>{{ $detail->nama_produk ?? $detail->produk->nama_produk ?? '-' }}</td>
                                    <td>{{ number_format($detail->jumlah_kg, 2, ',', '.') }} KG</td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>{{ $trx->tanggal }}</td>
                            <td>{{ 'TR' . str_pad($trx->id_transaksi, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>-</td>
                            <td>-</td>
                            <td>Rp{{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="5" class="text-muted fw-bold py-3">
                            Maaf, belum ada transaksi pada tanggal tersebut.
                        </td>
                    </tr>
                @endforelse
            </tbody>

            <tfoot style="font-weight: bold;">
                <tr>
                    <td colspan="4" class="text-end">Jumlah Keseluruhan</td>
                    <td>Rp{{ number_format($totalKeseluruhan, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
