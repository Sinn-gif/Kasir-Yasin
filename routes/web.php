<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;

// Halaman login
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::get('/login', [LoginController::class, 'showLoginForm']);
Route::post('/login', [LoginController::class, 'login'])->name('login');
// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');



// yang sudah login
Route::middleware('auth:kasir')->group(function () {

    //route Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    // route supplier
    Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');        
    Route::get('/supplier/create', [SupplierController::class, 'create'])->name('supplier.create'); 
    Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.store');         
    Route::get('/supplier/{supplier}/edit', [SupplierController::class, 'edit'])->name('supplier.edit'); 
    Route::put('/supplier/{supplier}', [SupplierController::class, 'update'])->name('supplier.update');  
    Route::delete('/supplier/{supplier}', [SupplierController::class, 'destroy'])->name('supplier.destroy'); 

    
//route produk
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');              
Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');     
Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');             
Route::get('/produk/{produk}/edit', [ProdukController::class, 'edit'])->name('produk.edit');  
Route::put('/produk/{produk}', [ProdukController::class, 'update'])->name('produk.update');   
Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');


    //route Transaksi
Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
Route::post('/transaksi/add', [TransaksiController::class, 'addItem'])->name('transaksi.add');
Route::post('/transaksi/remove', [TransaksiController::class, 'removeItem'])->name('transaksi.remove');
Route::post('/transaksi/simpan', [TransaksiController::class, 'simpan'])->name('transaksi.simpan');

//route laporan
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::post('/laporan/store', [LaporanController::class, 'store'])->name('laporan.store');
Route::get('/laporan/filter', [LaporanController::class, 'filter'])->name('laporan.filter');
});
