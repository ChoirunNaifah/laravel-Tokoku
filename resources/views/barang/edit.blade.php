@extends('layouts.app')

@section('title', 'Edit Barang')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0">
                <div class="card-body p-4">
                    <div class="mb-4 text-center">
                        <h3 class="fw-bold text-primary">
                            <i class="fas fa-box-open me-2"></i> Edit Barang
                        </h3>
                        <p class="text-muted mb-0">Ubah informasi barang sesuai kebutuhan.</p>
                    </div>

                    <!-- Tombol kembali -->
                    <div class="mb-3">
                        <a href="{{ route('barang.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>

                    <form action="{{ route('barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <!-- Nama Barang -->
                        <div class="mb-3">
                            <label for="nama" class="form-label fw-semibold">Nama Barang</label>
                            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan nama barang" value="{{ old('nama', $barang->nama) }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div class="mb-3">
                            <label for="kategori_id" class="form-label fw-semibold">Kategori</label>
                            <select name="kategori_id" id="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" {{ old('kategori_id', $barang->kategori_id) == $kategori->id ? 'selected' : '' }}>
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
                            <label for="harga" class="form-label fw-semibold">Harga</label>
                            <input type="number" name="harga" id="harga" class="form-control @error('harga') is-invalid @enderror" placeholder="Masukkan harga barang" value="{{ old('harga', $barang->harga) }}" required>
                            @error('harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Gambar -->
                        <div class="mb-3">
                            <label for="gambar" class="form-label fw-semibold">Gambar Barang</label>
                            <input type="file" name="gambar" id="gambar" class="form-control @error('gambar') is-invalid @enderror" accept="image/*">
                            @error('gambar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            @if ($barang->gambar)
                                <div class="mt-3 text-center">
                                    <img src="{{ Storage::url($barang->gambar) }}" class="img-fluid rounded shadow-sm" style="max-width: 200px;" alt="Gambar Barang">
                                </div>
                            @endif
                        </div>

                        <!-- Tombol Submit -->
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary fw-bold">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
