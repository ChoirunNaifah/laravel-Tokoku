@extends('layouts.app')

@section('content')
<div class="container py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">📦 Daftar Pembelian</h1>
        <a href="{{ route('pembelian.create') }}" class="btn btn-success btn-lg shadow-sm">+ Tambah Pembelian</a>
    </div>

    {{-- Form pencarian --}}
    <form method="GET" action="{{ route('pembelian.index') }}" class="mb-4">
        <div class="input-group shadow">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari barang, supplier, atau status..." aria-label="Cari barang">
            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Cari</button>
        </div>
    </form>

    {{-- Tabel data pembelian --}}
    <div class="table-responsive shadow-sm rounded-3">
        <table class="table table-hover table-bordered text-center">
            <thead class="bg-primary text-white">
                <tr>
                    <th>Barang</th>
                    <th>Supplier</th>
                    <th>Jumlah</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pembelians as $pembelian)
                    <tr>
                        <td class="align-middle">{{ $pembelian->barang->nama }}</td>
                        <td class="align-middle">{{ $pembelian->supplier->nama }}</td>
                        <td class="align-middle">{{ $pembelian->jumlah }}</td>
                        <td class="align-middle">{{ $pembelian->tanggal }}</td>
                        <td class="align-middle">
                            <span class="badge {{ $pembelian->status == 'selesai' ? 'bg-success' : 'bg-warning' }}">
                                {{ ucfirst($pembelian->status) }}
                            </span>
                        </td>
                        <td class="align-middle">
                            <a href="{{ route('pembelian.edit', $pembelian) }}" class="btn btn-warning btn-sm shadow-sm">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="{{ route('pembelian.destroy', $pembelian) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm shadow-sm" onclick="return confirm('Yakin ingin menghapus?')">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="bi bi-emoji-frown fs-3"></i> <br> Tidak ada data pembelian.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $pembelians->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
