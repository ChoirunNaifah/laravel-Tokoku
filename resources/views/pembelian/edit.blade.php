@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Pembelian</h1>

    {{-- Form untuk mengedit pembelian --}}
    <form method="POST" action="{{ route('pembelian.update', $pembelian->id) }}">
        @csrf
        @method('PUT')

        {{-- Pilih Barang --}}
        <div class="mb-3">
            <label for="barang_id" class="form-label">Barang</label>
            <select name="barang_id" id="barang_id" class="form-control">
                <option value="" disabled selected>Pilih Barang</option>
                @foreach($barangs as $barang)
                    <option value="{{ $barang->id }}" {{ $barang->id == $pembelian->barang_id ? 'selected' : '' }}>
                        {{ $barang->nama }}
                    </option>
                @endforeach
            </select>
            @error('barang_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Pilih Supplier --}}
        <div class="mb-3">
            <label for="supplier_id" class="form-label">Supplier</label>
            <select name="supplier_id" id="supplier_id" class="form-control">
                <option value="" disabled selected>Pilih Supplier</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ $supplier->id == $pembelian->supplier_id ? 'selected' : '' }}>
                        {{ $supplier->nama }}
                    </option>
                @endforeach
            </select>
            @error('supplier_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Jumlah --}}
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" name="jumlah" id="jumlah" class="form-control" value="{{ old('jumlah', $pembelian->jumlah) }}" min="1">
            @error('jumlah')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Tanggal --}}
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal', $pembelian->tanggal) }}">
            @error('tanggal')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Status --}}
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="pending" {{ $pembelian->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="selesai" {{ $pembelian->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
            @error('status')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Tombol Submit --}}
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
