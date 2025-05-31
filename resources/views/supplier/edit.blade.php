@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Edit Supplier</h2>
    <form action="{{ route('supplier.update', $supplier->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Nama Supplier</label>
            <input type="text" name="nama" class="form-control" value="{{ $supplier->nama }}" required>
        </div>
        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" required>{{ $supplier->alamat }}</textarea>
        </div>
        <div class="mb-3">
            <label>Kode Pos</label>
            <input type="text" name="kode_pos" class="form-control" value="{{ $supplier->kode_pos }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('supplier.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
