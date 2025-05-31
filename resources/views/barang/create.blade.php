@extends('layouts.app')

@section('title', 'Tambah Barang')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-primary">
                            <i class="fas fa-box me-2"></i> Tambah Barang
                        </h3>
                        <p class="text-muted mb-0">Silakan isi data barang yang ingin ditambahkan ke dalam sistem.</p>
                    </div>

                    <!-- Tombol kembali -->
                    <div class="mb-3">
                        <a href="{{ route('barang.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Barang
                        </a>
                    </div>

                    <!-- Form Tambah Barang -->
                    <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf

                        <!-- Nama Barang -->
                        <div class="mb-3">
                            <label for="nama" class="form-label fw-semibold">Nama Barang</label>
                            <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Contoh: Sepatu Running" value="{{ old('nama') }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div class="mb-3">
                            <label for="kategori_id" class="form-label fw-semibold">Kategori</label>
                            <select id="kategori_id" name="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Harga -->
                        <div class="mb-3">
                            <label for="harga" class="form-label fw-semibold">Harga (Rp)</label>
                            <input type="number" id="harga" name="harga" class="form-control @error('harga') is-invalid @enderror" placeholder="Masukkan harga, contoh: 100000" value="{{ old('harga') }}" required>
                            @error('harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Gambar -->
                        <div class="mb-3">
                            <label for="gambar" class="form-label fw-semibold">Gambar Barang</label>
                            <input type="file" id="gambar" name="gambar" class="form-control @error('gambar') is-invalid @enderror" accept="image/*" required>
                            @error('gambar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tombol Submit -->
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary fw-bold">
                                <i class="fas fa-plus-circle me-1"></i> Simpan Barang
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
