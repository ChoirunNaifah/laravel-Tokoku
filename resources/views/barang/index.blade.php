@extends('layouts.app')

@section('title', 'Dashboard - Barang')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm rounded-4">
        <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white rounded-top">
            <h4 class="mb-0"><i class="fas fa-boxes"></i> Data Barang</h4>
            <a href="{{ route('barang.create') }}" class="btn btn-light shadow-sm">
                <i class="fas fa-plus-circle"></i> Tambah Barang
            </a>
        </div>
        <div class="card-body">

            <!-- Form Pencarian -->
            <form method="GET" action="{{ route('barang.index') }}" class="mb-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari barang..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </form>

            <!-- Tabel Data -->
            <div class="table-responsive">
                <table class="table table-striped align-middle table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Harga</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $key => $item)
                            <tr>
                                <td class="text-center">{{ $data->firstItem() + $key }}</td>
                                <td>{{ $item->nama ?? '-' }}</td>
                                <td>{{ $item->kategori->nama ?? '-' }}</td>
                                <td class="text-center">
                                    @if ($item->stok == 0)
                                        <span class="badge bg-danger">Habis</span>
                                    @else
                                        {{ $item->stok }}
                                    @endif
                                </td>
                                <td class="text-end">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    @if ($item->gambar)
                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#gambarModal{{ $item->id }}">
                                            <i class="fas fa-image"></i> Lihat
                                        </button>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('barang.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-danger btn-sm" onclick="hapus({{ $item->id }})">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <form id="form-hapus-{{ $item->id }}" action="{{ route('barang.destroy', $item->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal Gambar -->
                            @if ($item->gambar)
                                <div class="modal fade" id="gambarModal{{ $item->id }}" tabindex="-1" aria-labelledby="gambarModalLabel{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Gambar: {{ $item->nama }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <img src="{{ asset('storage/' . $item->gambar) }}" alt="Gambar Barang" class="img-fluid rounded shadow-sm" style="max-height: 300px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Data Kosong</td>
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

<!-- Script Konfirmasi Delete -->
<script>
    function hapus(id) {
        if (confirm("Yakin ingin menghapus barang ini?")) {
            document.getElementById('form-hapus-' + id).submit();
        }
    }
</script>
@endsection
