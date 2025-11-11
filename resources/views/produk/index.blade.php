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
                                    <button type="button" class="btn btn-danger btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal"
                                            data-form="{{ route('produk.destroy', $p->id_produk) }}">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
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

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold" id="deleteModalLabel">Hapus Produk</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="display-1 text-danger mb-3">!</div>
        <p>Apakah kamu akan menghapus produk ini?</p>
      </div>
      <div class="modal-footer justify-content-center border-0">
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger fw-bold px-4">Hapus</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const formAction = button.getAttribute('data-form');
        const deleteForm = document.getElementById('deleteForm');
        deleteForm.setAttribute('action', formAction);
    });
});
</script>
@endsection
