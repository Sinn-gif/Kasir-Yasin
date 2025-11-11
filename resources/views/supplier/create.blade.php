@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Supplier</h1>

    <form action="{{ route('supplier.store') }}" method="POST">
        @csrf

        <div class="text-end mb-3">
            <a href="{{ route('supplier.index') }}" class="btn btn-danger">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="mb-3">
            <label>Nama Perusahaan</label>
            <input type="text" name="nama_perusahaan" 
                   class="form-control @error('nama_perusahaan') is-invalid @enderror"
                   required>
            @error('nama_perusahaan')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label>Kontak</label>
            <input type="text" name="kontak" 
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
                      required></textarea>
            @error('alamat')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label>Nama Supplier</label>
            <input type="text" name="nama_supplier" 
                   class="form-control @error('nama_supplier') is-invalid @enderror"
                   required>
            @error('nama_supplier')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
