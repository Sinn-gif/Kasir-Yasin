@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold mb-0">Edit Produk</h3>
        <a href="{{ route('produk.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('produk.update', $produk->id_produk) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" name="nama_produk"
                            value="{{ old('nama_produk', $produk->nama_produk) }}"
                            class="form-control @error('nama_produk') is-invalid @enderror"
                            required>
                        @error('nama_produk')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Harga per KG</label>
                        <input type="number" step="0.01" name="harga_per_kg"
                            value="{{ old('harga_per_kg', $produk->harga_per_produk) }}"
                            class="form-control @error('harga_per_kg') is-invalid @enderror"
                            required>
                        @error('harga_per_kg')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Stok (KG)</label>
                        <input type="number" name="stok_kg"
                            value="{{ old('stok_kg', $produk->stok_kg) }}"
                            class="form-control @error('stok_kg') is-invalid @enderror"
                            required>
                        @error('stok_kg')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Supplier</label>
                        <select name="id_supplier"
                                class="form-select @error('id_supplier') is-invalid @enderror"
                                required>
                            <option value="">-- Pilih Supplier --</option>
                            @foreach($supplier as $s)
                                <option value="{{ $s->id_supplier }}"
                                    {{ old('id_supplier', $produk->id_supplier) == $s->id_supplier ? 'selected' : '' }}>
                                    {{ $s->nama_supplier }}
                                </option>
                            @endforeach
                        </select>

                        @error('id_supplier')
                            <small class="text-danger">Harap pilih supplier</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Gambar Produk</label>
                        <input type="file" name="gambar"
                            class="form-control @error('gambar') is-invalid @enderror">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                        @error('gambar')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label d-block">Gambar Saat Ini</label>
                        <img src="{{ asset('images/'.$produk->gambar) }}" alt="Gambar Produk" class="img-thumbnail" width="120">
                    </div>

                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> Update
                    </button>
                    <a href="{{ route('produk.index') }}" class="btn btn-warning">Batal</a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
