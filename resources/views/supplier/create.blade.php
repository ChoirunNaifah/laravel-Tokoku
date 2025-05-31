@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Tambah Supplier</h2>
    <form action="{{ route('supplier.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama Supplier</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label>Kode Pos</label>
            <input type="text" name="kode_pos" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('supplier.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
