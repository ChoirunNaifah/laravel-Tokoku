@extends('layouts.app')

@push('styles')
<style>
    body {
        background: linear-gradient(to right, #f8f9fa, #e3f2fd);
    }

    .pressable {
        transition: transform 0.1s ease-in-out;
    }

    .pressable:active {
        transform: scale(0.94);
    }

    .hover-border-effect {
        transition: all 0.3s ease;
        border: 2px solid transparent;
        transform: scale(1);
    }

    .hover-border-effect:hover {
        border-color: white;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        transform: translateY(-5px) scale(1.03);
    }

    .card {
        margin-bottom: 1.5rem;
        opacity: 0;
        animation: fadeIn 0.6s ease-in-out forwards;
    }

    @keyframes fadeIn {
        to {
            opacity: 1;
        }
    }

    .card-title,
    .card-text {
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }

    .btn.pressable {
        border-radius: 20px;
        font-weight: 600;
        padding: 6px 16px;
    }

    @media (max-width: 768px) {
        .card-body h5 {
            font-size: 1.2rem;
        }

        .card-body p {
            font-size: 0.9rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4 text-primary">Selamat Datang ^-^ di Dashboard Tokoku!</h1>
        <p class="lead text-secondary">Kelola produk, penjualan, dan stok dengan mudah dan cepat.</p>
    </div>

    <div class="row g-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-lg rounded-4 bg-primary text-white hover-border-effect">
            <div class="card-body text-center">
                <h5 class="card-title">📦 Barang</h5>
                <p class="card-text">Kelola daftar barang.</p>
                <a href="{{ route('barang.index') }}" class="btn btn-light pressable">Kelola Barang</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-lg rounded-4 bg-success text-white hover-border-effect">
            <div class="card-body text-center">
                <h5 class="card-title">🏷️ Kategori</h5>
                <p class="card-text">Lihat dan atur kategori barang.</p>
                <a href="{{ route('kategori.index') }}" class="btn btn-light pressable">Kelola Kategori</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-lg rounded-4 bg-warning text-white hover-border-effect">
            <div class="card-body text-center">
                <h5 class="card-title">🧍 Pembeli</h5>
                <p class="card-text">Data pelanggan toko.</p>
                <a href="{{ route('pembeli.index') }}" class="btn btn-light pressable">Kelola Pembeli</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-lg rounded-4 bg-danger text-white hover-border-effect">
            <div class="card-body text-center">
                <h5 class="card-title">🚚 Supplier</h5>
                <p class="card-text">Daftar supplier barang.</p>
                <a href="{{ route('supplier.index') }}" class="btn btn-light pressable">Kelola Supplier</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-lg rounded-4 bg-info text-white hover-border-effect">
            <div class="card-body text-center">
                <h5 class="card-title">🛒 Penjualan</h5>
                <p class="card-text">Pantau transaksi penjualan.</p>
                <a href="{{ route('penjualan.index') }}" class="btn btn-light pressable">Kelola Penjualan</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-lg rounded-4 bg-secondary text-white hover-border-effect">
            <div class="card-body text-center">
                <h5 class="card-title">📥 Pembelian</h5>
                <p class="card-text">Kelola transaksi pembelian.</p>
                <a href="{{ route('pembelian.index') }}" class="btn btn-light pressable">Kelola Pembelian</a>
            </div>
        </div>
    </div>
</div>
@endsection
