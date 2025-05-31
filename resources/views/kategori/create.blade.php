@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Tambah Kategori</h2>

    <form action="{{ route('kategori.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Kategori</label>
            <input type="text" class="form-control" name="nama" id="nama" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
