<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 bg-dark text-white d-flex flex-column align-items-center p-3 vh-100">
<img src="{{ asset('asset/logo.png') }}" 
     alt="Logo" 
     class="img-fluid mb-3" 
     style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">

     

            <ul class="nav flex-column w-100">
                <li class="nav-item mb-2">
                    <a href="{{ route('dashboard.index') }}" class="nav-link text-white fw-bold">
                        <i class="fa-solid fa-house me-2"></i> Dashboard
                    </a>
                    <hr class="border-light my-1">
                </li>

                <li class="nav-item mb-2">
                    <a href="{{ route('supplier.index') }}" class="nav-link text-white fw-bold">
                        <i class="fa-solid fa-user-tie me-2"></i> Supplier
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="{{ route('produk.index') }}" class="nav-link text-white fw-bold">
                        <i class="fa-solid fa-box-open me-2"></i> Produk
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="{{ route('transaksi.index') }}" class="nav-link text-white fw-bold">
                        <i class="fa-solid fa-cart-shopping me-2"></i> Transaksi
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="{{ route('laporan.index') }}" class="nav-link text-white fw-bold">
                        <i class="fa-solid fa-chart-line me-2"></i> Laporan
                    </a>
                </li>
            </ul>

            <!-- Tombol Logout -->
            <button type="button" class="btn btn-danger w-100 fw-bold mt-auto"
                data-bs-toggle="modal" data-bs-target="#logoutModal">
                Log out
            </button>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 p-0">

            <!-- NAVBAR -->
            <nav class="navbar navbar-light bg-white shadow-sm px-4 py-3 d-flex justify-content-between">
               

                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-user-circle fa-2x text-primary me-2"></i>

                    
                    <span class="fw-bold">
                        {{ Auth::user()->nama_kasir ?? 'Kasir' }}
                    </span>
                </div>
            </nav>

            <div class="p-4">
                @yield('content')
            </div>
        </div>
    </div>
</div>

<!-- Konfirmasi Logout -->
<div class="modal fade" id="logoutModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-4">

            <h3 class="fw-bold">Logout</h3>

            <div class="display-1 fw-bold my-2">!</div>

            <h4 class="fw-bold">Anda Yakin?</h4>
            <p>Ingin keluar dari web</p>

            <div class="d-flex justify-content-center gap-3 mt-3">

                
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success px-4">Iya</button>
                </form>

                
                <button type="button" class="btn btn-danger px-4" data-bs-dismiss="modal">
                    Batal
                </button>
            </div>

        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>