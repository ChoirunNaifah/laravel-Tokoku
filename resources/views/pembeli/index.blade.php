@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">📋 Data Pembeli</h4>
                </div>

                <div class="card-body">
                    {{-- Pesan Sukses --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Form Pencarian --}}
                    <div class="mb-3">
                        <form action="{{ route('pembeli.index') }}" method="GET">
                            <div class="input-group shadow-sm">
                                <input type="text" name="search" class="form-control" placeholder="Cari Nama Pembeli" value="{{ request('search') }}" aria-label="Cari Nama Pembeli">
                                <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i> Cari</button>
                            </div>
                        </form>
                    </div>

                    {{-- Tombol Tambah Pembeli --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold">Total Data: {{ $pembelis->total() }}</h5>
                        <a href="{{ route('pembeli.create') }}" class="btn btn-success shadow-sm">
                            <i class="bi bi-plus-circle"></i> Tambah Pembeli
                        </a>
                    </div>

                    {{-- Tabel Data Pembeli --}}
                    @if($pembelis->isEmpty())
                        <div class="text-center py-4">
                            <i class="bi bi-emoji-frown fs-1"></i>
                            <p class="text-muted mt-2">Belum ada data pembeli yang tersedia.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered shadow-sm">
                                <thead class="bg-primary text-white">
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Alamat</th>
                                        <th>No HP</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pembelis as $pembeli)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $pembeli->nama }}</td>
                                            <td class="text-center">{{ ucfirst($pembeli->jenis_kelamin) }}</td>
                                            <td>{{ $pembeli->alamat }}</td>
                                            <td class="text-center">{{ $pembeli->no_hp }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('pembeli.edit', $pembeli->id) }}" class="btn btn-warning btn-sm shadow-sm">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>
                                                <form action="{{ route('pembeli.destroy', $pembeli->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm shadow-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                        <i class="bi bi-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="d-flex justify-content-center mt-4">
                            {{ $pembelis->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
