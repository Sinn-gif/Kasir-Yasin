@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Supplier</h1>

    <form action="{{ route('supplier.update', $supplier->id_supplier) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Perusahaan</label>
            <input type="text" name="nama_perusahaan"
                   value="{{ old('nama_perusahaan', $supplier->nama_perusahaan) }}"
                   class="form-control @error('nama_perusahaan') is-invalid @enderror"
                   required>
            @error('nama_perusahaan')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label>Kontak</label>
            <input type="text" name="kontak"
                   value="{{ old('kontak', $supplier->kontak) }}"
                   class="form-control @error('kontak') is-invalid @enderror"
                   required>
            @error('kontak')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat"
                      class="form-control @error('alamat') is-invalid @enderror"
                      required>{{ old('alamat', $supplier->alamat) }}</textarea>
            @error('alamat')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label>Nama Supplier</label>
            <input type="text" name="nama_supplier"
                   value="{{ old('nama_supplier', $supplier->nama_supplier) }}"
                   class="form-control @error('nama_supplier') is-invalid @enderror"
                   required>
            @error('nama_supplier')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('supplier.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
