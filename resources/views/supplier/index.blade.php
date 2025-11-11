@extends('layouts.app')

@section('title', 'Supplier')

@section('content')
<div class="container mt-3">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold mb-0">Supllier</h3>
        <a href="{{ route('supplier.create') }}" class="btn btn-success">
            <i class="fa fa-plus"></i> Tambah Supplier
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <table class="table table-bordered">
        <thead class="table-danger" style="color: white;">
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
            @foreach($suppliers as $supplier)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $supplier->nama_perusahaan }}</td>
                <td>{{ $supplier->kontak }}</td>
                <td>{{ $supplier->alamat }}</td>
                <td>{{ $supplier->nama_supplier }}</td>
                <td>
                    <a href="{{ route('supplier.edit', $supplier->id_supplier) }}" class="btn btn-warning btn-sm">Edit</a>

                    <form action="{{ route('supplier.destroy', $supplier->id_supplier) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Hapus supplier ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>
</div>
@endsection
