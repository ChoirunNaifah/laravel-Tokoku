<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DetailPenjualanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return redirect()->route('login');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin'])->name('login.process');

//register
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.process');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// CRUD Routes
Route::resource('barang', BarangController::class);
Route::resource('kategori', KategoriController::class);
Route::resource('penjualan', PenjualanController::class);
Route::resource('pembelian', PembelianController::class);
Route::resource('pembeli', PembeliController::class);
Route::resource('supplier', SupplierController::class);
Route::resource('detail_penjualan', DetailPenjualanController::class);

Route::group(['middleware' => 'auth.custom'], function () {
    Route::resource('barangs', BarangController::class);
    Route::resource('pembelis', PembeliController::class);
    Route::resource('penjualans', PenjualanController::class);
});



Route::get('/barang-view', function () {
    return view('barang');
})->middleware('auth')->name('barang.view');


Route::resource('/barang', BarangController::class);
Route::get('penjualan/export-pdf', [PenjualanController::class, 'exportPdf'])->name('penjualan.exportPdf');

 Route::put('/pembelian/selesai/{id}', [PembelianController::class, 'selesai'])->name('pembelian.selesai');
    Route::resource('pembelian', PembelianController::class);
    
    Route::get('/penjualan/download-pdf', [PenjualanController::class, 'downloadPDF'])->name('penjualan.downloadPDF');
    Route::get('/penjualan/print/{id}', [PenjualanController::class, 'print'])->name('penjualan.print');

    Route::resource('penjualan', PenjualanController::class);
