@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow rounded-4">
        <div class="card-header bg-primary text-white rounded-top d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-truck"></i> Data Supplier</h4>
            <a href="{{ route('supplier.create') }}" class="btn btn-light">
                <i class="fas fa-plus-circle"></i> Tambah Supplier
            </a>
        </div>

        <div class="card-body">
            <!-- Formulir Pencarian -->
            <form method="GET" action="{{ route('supplier.index') }}" class="mb-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nama, alamat, atau kode pos" value="{{ request('search') }}">
                    <button type="submit" class="btn btn-secondary">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </form>

            <!-- Pesan Sukses -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Tabel Data Supplier -->
            @if($supplier->isEmpty())
                <div class="alert alert-warning text-center">
                    <i class="fas fa-exclamation-circle"></i> Belum ada data supplier.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Kode Pos</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($supplier as $index => $data)
                                <tr>
                                    <td class="text-center">{{ $index + 1 + ($supplier->currentPage() - 1) * $supplier->perPage() }}</td>
                                    <td>{{ $data->nama }}</td>
                                    <td>{{ $data->alamat }}</td>
                                    <td class="text-center">{{ $data->kode_pos }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('supplier.edit', $data->id) }}" class="btn btn-warning btn-sm me-1" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('supplier.destroy', $data->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3 d-flex justify-content-end">
                    {{ $supplier->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
