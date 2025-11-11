@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')
<div class="container">
    <h3 class="fw-bold mb-4">Transaksi</h3>

    <div class="row">
        <!-- Daftar Produk -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-success text-white fw-bold">
                    Daftar Produk
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($produk as $item)
                        <div class="col-md-6 mb-3">
                            <div class="card h-100 text-center">
                                <div class="card-body">
                                    @if($item->gambar)
                                        <img src="{{ asset('images/'.$item->gambar) }}" 
                                             alt="{{ $item->nama_produk }}" 
                                             class="img-fluid rounded mb-2" 
                                             style="max-height: 100px; object-fit: cover;">
                                    @else
                                        <span class="text-muted d-block mb-2">Tidak ada gambar</span>
                                    @endif

                                    <h6 class="fw-bold">{{ $item->nama_produk }}</h6>
                                    <p>Rp {{ number_format($item->harga_per_produk, 0, ',', '.') }}</p>
                                    <p class="text-muted mb-1">
                                        Stok: <span id="stok-{{ $item->id_produk }}">{{ $item->stok_kg }}</span> kg
                                    </p>
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-danger btn-sm kurang-produk" data-id="{{ $item->id_produk }}">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                        <button class="btn btn-success btn-sm tambah-produk"
                                            data-id="{{ $item->id_produk }}"
                                            data-nama="{{ $item->nama_produk }}"
                                            data-harga="{{ $item->harga_per_produk }}">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Pesanan -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-success text-white fw-bold">
                    Daftar Pesanan
                </div>
                <div class="card-body" id="daftar-pesanan">
                    <p class="text-muted text-center">Belum ada pesanan</p>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center fw-bold">
                    <span>Total: Rp <span id="total-harga">0</span></span>
                    <button id="btnBayar" class="btn btn-primary btn-sm" disabled>Bayar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- NOTIFIKASI -->
<div id="notif" 
     class="alert d-none position-fixed top-0 end-0 m-3 p-3 shadow"
     style="z-index: 9999; width: 300px;">
</div>

<!-- Modal Pembayaran -->
<div class="modal fade" id="modalPembayaran" tabindex="-1" aria-labelledby="modalPembayaranLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="modalPembayaranLabel">Pembayaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Total Harga</label>
          <input type="text" id="totalHargaInput" class="form-control" readonly>
        </div>
        <div class="mb-3">
          <label class="form-label">Uang Bayar</label>
          <input type="number" id="uangBayarInput" class="form-control" placeholder="Masukkan nominal">
        </div>
        <div class="mb-3">
          <label class="form-label">Kembalian</label>
          <input type="text" id="kembalianInput" class="form-control" readonly>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
        <button type="button" id="btnKonfirmasiBayar" class="btn btn-success" disabled>Konfirmasi Bayar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Pembayaran Berhasil -->
<div class="modal fade" id="modalBerhasil" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center p-4">
      <div class="text-success mb-3" style="font-size: 70px;">&#10004;</div>
      <h5 class="fw-bold mb-3">Pembayaran Berhasil</h5>
      <button class="btn btn-success fw-bold px-4" id="btnSimpan">Simpan</button>
    </div>
  </div>
</div>

<script>
function showNotif(text, type='success') {
    const notif = document.getElementById('notif');
    notif.className = `alert alert-${type}`;
    notif.textContent = text;
    notif.classList.remove('d-none');
    setTimeout(() => notif.classList.add('d-none'), 2000);
}

document.addEventListener('DOMContentLoaded', function () {
    let pesanan = [];

    // Tambah produk
    document.querySelectorAll('.tambah-produk').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const nama = this.dataset.nama;
            const harga = parseFloat(this.dataset.harga);
            const stokEl = document.getElementById('stok-' + id);
            let stok = parseFloat(stokEl.textContent);

            if (stok <= 0) {
                showNotif("Stok produk habis!", "danger");
                return;
            }

            stokEl.textContent = (stok - 1).toFixed(2);

            let item = pesanan.find(p => p.id === id);
            if (item) item.qty += 1;
            else pesanan.push({ id, nama, harga, qty: 1 });

            renderPesanan();
        });
    });

    // Kurangi produk
    document.querySelectorAll('.kurang-produk').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const stokEl = document.getElementById('stok-' + id);
            let stok = parseFloat(stokEl.textContent);

            let item = pesanan.find(p => p.id === id);
            if (item) {
                item.qty -= 1;
                stokEl.textContent = (stok + 1).toFixed(2);
                if (item.qty <= 0) pesanan = pesanan.filter(p => p.id !== id);
            }

            renderPesanan();
        });
    });

    // Render daftar pesanan
    function renderPesanan() {
        const daftarPesanan = document.getElementById('daftar-pesanan');
        const totalEl = document.getElementById('total-harga');
        const btnBayar = document.getElementById('btnBayar');

        daftarPesanan.innerHTML = '';

        if (pesanan.length === 0) {
            daftarPesanan.innerHTML = '<p class="text-muted text-center">Belum ada pesanan</p>';
            totalEl.textContent = 0;
            btnBayar.disabled = true;
            return;
        }

        let total = 0;
        pesanan.forEach(item => {
            total += item.harga * item.qty;

            const div = document.createElement('div');
            div.classList.add('d-flex','justify-content-between','align-items-center','mb-2');
            div.innerHTML = `
                <span>${item.nama} x${item.qty}</span>
                <span>Rp ${new Intl.NumberFormat('id-ID').format(item.harga * item.qty)}</span>
            `;
            daftarPesanan.appendChild(div);
        });

        totalEl.textContent = new Intl.NumberFormat('id-ID').format(total);
        btnBayar.disabled = false;
    }

    const modal = new bootstrap.Modal(document.getElementById('modalPembayaran'));
    const modalBerhasil = new bootstrap.Modal(document.getElementById('modalBerhasil'));
    const totalHargaInput = document.getElementById('totalHargaInput');
    const uangBayarInput = document.getElementById('uangBayarInput');
    const kembalianInput = document.getElementById('kembalianInput');
    const btnKonfirmasiBayar = document.getElementById('btnKonfirmasiBayar');
    const btnBayar = document.getElementById('btnBayar');

    btnBayar.addEventListener('click', () => {
        const total = parseFloat(document.getElementById('total-harga').textContent.replace(/[^\d]/g,'')) || 0;
        totalHargaInput.value = `Rp ${new Intl.NumberFormat('id-ID').format(total)}`;
        uangBayarInput.value = '';
        kembalianInput.value = '';
        btnKonfirmasiBayar.disabled = true;
        modal.show();
    });

    uangBayarInput.addEventListener('input', () => {
        const total = parseInt(document.getElementById('total-harga').textContent.replace(/[^\d]/g,'')) || 0;
        const bayar = parseFloat(uangBayarInput.value) || 0;
        const kembalian = bayar - total;

        if (kembalian >= 0) {
            kembalianInput.value = `Rp ${new Intl.NumberFormat('id-ID').format(kembalian)}`;
            btnKonfirmasiBayar.disabled = false;
        } else {
            kembalianInput.value = 'Uang kurang';
            btnKonfirmasiBayar.disabled = true;
        }
    });

    // SIMPAN TRANSAKSI
    btnKonfirmasiBayar.addEventListener('click', () => {
        fetch("{{ route('transaksi.simpan') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ pesanan })
        })
        .then(res => res.json())
        .then(data => {
            // Tutup modal pembayaran
            modal.hide();

            // Reset pesanan
            pesanan = [];
            renderPesanan();

            // Tampilkan modal berhasil
            modalBerhasil.show();

            // Tombol simpan menuju laporan
            document.getElementById('btnSimpan').addEventListener('click', () => {
                modalBerhasil.hide();
                window.location.href = "{{ route('laporan.index') }}";
            });
        })
        .catch(err => {
            console.error(err);
            showNotif("Terjadi kesalahan!", "danger");
        });
    });

});
</script>
@endsection
