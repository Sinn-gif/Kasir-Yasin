@extends('layouts.app')

@section('title', 'Supplier')

@section('content')
<div class="container mt-3">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold mb-0">Supplier</h3>
        <a href="{{ route('supplier.create') }}" class="btn btn-success">
            <i class="fa fa-plus"></i> Tambah Supplier
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered text-center align-middle">
        <thead class="table-danger text-white">
            <tr>
                <th>No</th>
                <th>Nama Perusahaan</th>
                <th>Kontak</th>
                <th>Alamat</th>
                <th>Supplier</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($suppliers as $supplier)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $supplier->nama_perusahaan }}</td>
                <td>{{ $supplier->kontak }}</td>
                <td>{{ $supplier->alamat }}</td>
                <td>{{ $supplier->nama_supplier }}</td>
                <td>
                    <a href="{{ route('supplier.edit', $supplier->id_supplier) }}" class="btn btn-warning btn-sm">Edit</a>
                    <button type="button" class="btn btn-danger btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteModal"
                            data-form="{{ route('supplier.destroy', $supplier->id_supplier) }}">
                        Hapus
                    </button>
                </td>
            </tr>
            @empty
                <tr><td colspan="6" class="text-muted">Belum ada data supplier.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal Bootstrap Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold" id="deleteModalLabel">Hapus Supplier</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="display-1 text-danger mb-3">!</div>
        <p>Apakah kamu akan menghapus supplier ini?</p>
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
