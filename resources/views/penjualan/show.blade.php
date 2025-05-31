@extends('layouts.app')

@section('title', 'Detail Penjualan')
@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="mb-0">Detail Penjualan</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Pembeli:</strong> {{ $penjualan->pembeli->nama }}</p>
                        <p><strong>Kasir:</strong> {{ $penjualan->kasir->name }}</p>
                        <p><strong>Tanggal Pesanan:</strong> {{ $penjualan->tanggal_pesanan }}</p>
                    </div>
                    <div class="col-md-6 text-right">
                        <p><strong>Total Harga:</strong> Rp {{ number_format($penjualan->detailPenjualan->sum('total_harga'), 0, ',', '.') }}</p>
                    </div>
                </div>

                <hr>

                <h4>Daftar Barang</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Harga Satuan</th>
                                <th>Jumlah</th>
                                <th>Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penjualan->detailPenjualan as $key => $detail)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $detail->barang->nama }}</td>
                                    <td>Rp {{ number_format($detail->barang->harga, 0, ',', '.') }}</td>
                                    <td>{{ $detail->jumlah }}</td>
                                    <td>Rp {{ number_format($detail->total_harga, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
@endsection