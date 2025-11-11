@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
<div class="container mt-3">
    <h3 class="fw-bold mb-4">Laporan</h3>

    <!-- FILTER TANGGAL -->
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
                        <button class="btn fw-bold text-white px-4" style="background-color:#00A6FF;">
                            Cari
                        </button>
                        <a href="{{ route('laporan.index') }}" class="btn btn-secondary fw-bold px-4">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- TABEL LAPORAN -->
    <div class="table-responsive">
        <table class="table table-bordered text-center align-middle" style="border: 3px solid #00A6FF;">
            <thead style="background-color: #FF2C2C; color: white;">
                <tr>
                    <th>Tanggal</th>
                    <th>No Transaksi</th>
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
                                        {{ $trx->id_transaksi }}
                                    </td>
                                    <!-- ✅ Gunakan nama_produk dari detail_transaksi -->
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
                            <td>{{ $trx->id_transaksi }}</td>
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
