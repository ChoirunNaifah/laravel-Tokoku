@extends('layouts.app')

@section('title', 'Dashboard - Penjualan')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm rounded-4">
        <div class="card-header bg-primary text-white rounded-top d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-shopping-cart"></i> Data Penjualan</h4>
            <div>
                <a href="{{ route('penjualan.create') }}" class="btn btn-light me-2">
                    <i class="fas fa-plus-circle"></i> Tambah
                </a>
                <a href="{{ route('penjualan.downloadPDF', ['search' => request('search'), 'start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" class="btn btn-danger">
                    <i class="fas fa-file-pdf"></i> PDF
                </a>
            </div>
        </div>

        <div class="card-body">
            <!-- Form Filter -->
            <form method="GET" action="{{ route('penjualan.index') }}" class="mb-4">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="start_date" class="form-label">Tanggal Awal</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="end_date" class="form-label">Tanggal Akhir</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="search" class="form-label">Cari Pembeli</label>
                        <input type="text" name="search" class="form-control" placeholder="Masukkan nama pembeli..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Cari
                        </button>
                        <a href="{{ route('penjualan.index') }}" class="btn btn-secondary w-100">
                            <i class="fas fa-sync-alt"></i> Reset
                        </a>
                    </div>
                </div>
            </form>

            <!-- Tabel Penjualan -->
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Pembeli</th>
                            <th>Kasir</th>
                            <th>Tanggal Pesanan</th>
                            <th>Total Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $key => $item)
                            <tr>
                                <td class="text-center">{{ $data->firstItem() + $key }}</td>
                                <td>{{ $item->pembeli->nama }}</td>
                                <td>{{ $item->kasir->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_pesanan)->format('d-m-Y') }}</td>
                                <td class="text-end">Rp {{ number_format($item->detailPenjualan->sum('total_harga'), 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('penjualan.show', $item->id) }}" class="btn btn-info btn-sm" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('penjualan.print', $item->id) }}" class="btn btn-success btn-sm" title="Cetak">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    <button class="btn btn-danger btn-sm" onclick="hapus({{ $item->id }})" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>

                                    <form id="form-hapus-{{ $item->id }}" action="{{ route('penjualan.destroy', $item->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Data penjualan tidak ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $data->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<!-- JavaScript Konfirmasi Delete -->
<script>
    function hapus(id) {
        if (confirm("Apakah kamu yakin ingin menghapus data ini?")) {
            document.getElementById('form-hapus-' + id).submit();
        }
    }
</script>
@endsection
