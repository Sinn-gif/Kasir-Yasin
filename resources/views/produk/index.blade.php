@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold mb-0">Produk</h3>
        <a href="{{ route('produk.create') }}" class="btn btn-success">
            <i class="fa fa-plus"></i> Tambah Produk
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-danger text-center">
                        <tr>
                            <th>Kode</th>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Harga / KG</th>
                            <th>Stok (KG)</th>
                            <th>Nama Supplier</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse($produk as $p)
                            <tr>
                                <td>AB{{ str_pad($p->id_produk, 3, '0', STR_PAD_LEFT) }}</td>
                                <td>
                                    @if($p->gambar)
    <img src="{{ asset('images/'.$p->gambar) }}" alt="Gambar Produk" class="img-thumbnail" width="70">
@else
    <span class="text-muted">Tidak ada gambar</span>
@endif

                                </td>
                                <td>{{ $p->nama_produk }}</td>
                                <td>{{ number_format($p->harga_per_produk, 0, ',', '.') }}</td>
                                <td>{{ $p->stok_kg }}</td>
                                <td>{{ $p->supplier->nama_supplier ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('produk.edit', $p->id_produk) }}" class="btn btn-success btn-sm">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('produk.destroy', $p->id_produk) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(this)">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada data produk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Konfirmasi delete pakai JS -->
<script>
function confirmDelete(button) {
    if (confirm('Yakin ingin menghapus produk ini?')) {
        button.closest('form').submit();
    }
}
</script>
@endsection
