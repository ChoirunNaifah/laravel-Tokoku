@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>Edit Penjualan</h2>

    <form action="{{ route('penjualan.update', $penjualan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="pembeli_id" class="form-label">Pembeli</label>
            <select name="pembeli_id" id="pembeli_id" class="form-select" required>
                <option value="">-- Pilih Pembeli --</option>
                @foreach($pembeli as $p)
                    <option value="{{ $p->id }}" {{ old('pembeli_id', $penjualan->pembeli_id) == $p->id ? 'selected' : '' }}>
                        {{ $p->nama }}
                    </option>
                @endforeach
            </select>
            @error('pembeli_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tanggal_pesan" class="form-label">Tanggal Pesan</label>
            <input type="date" name="tanggal_pesan" id="tanggal_pesan" class="form-control" value="{{ old('tanggal_pesan', $penjualan->tanggal_pesan) }}" required>
            @error('tanggal_pesan')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <hr>
        <h5>Detail Barang</h5>

        <div id="barang-list">
            @foreach($penjualan->detailPenjualan as $detail)
            <div class="barang-item mb-3">
                <select name="barang_id[]" class="form-select mb-2" required>
                    <option value="">-- Pilih Barang --</option>
                    @foreach($barang as $b)
                        <option value="{{ $b->id }}" {{ $b->id == $detail->barang_id ? 'selected' : '' }}>
                            {{ $b->nama }} (Harga: {{ number_format($b->harga, 0, ',', '.') }})
                        </option>
                    @endforeach
                </select>
                <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" min="1" value="{{ $detail->jumlah }}" required>
                <button type="button" class="btn btn-danger btn-sm mt-2 btn-hapus-barang">Hapus</button>
            </div>
            @endforeach
        </div>

        <button type="button" id="tambah-barang" class="btn btn-secondary mb-3">+ Tambah Barang</button>

        <div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<script>
    document.getElementById('tambah-barang').addEventListener('click', function() {
        const barangList = document.getElementById('barang-list');
        const newBarang = document.createElement('div');
        newBarang.classList.add('barang-item', 'mb-3');
        newBarang.innerHTML = `
            <select name="barang_id[]" class="form-select mb-2" required>
                <option value="">-- Pilih Barang --</option>
                @foreach($barang as $b)
                    <option value="{{ $b->id }}">{{ $b->nama }} (Harga: {{ number_format($b->harga, 0, ',', '.') }})</option>
                @endforeach
            </select>
            <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" min="1" required>
            <button type="button" class="btn btn-danger btn-sm mt-2 btn-hapus-barang">Hapus</button>
        `;

        barangList.appendChild(newBarang);

        // Event untuk tombol hapus
        newBarang.querySelector('.btn-hapus-barang').addEventListener('click', function() {
            newBarang.remove();
        });
    });

    // Event untuk tombol hapus pada barang yang sudah ada
    document.querySelectorAll('.btn-hapus-barang').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('.barang-item').remove();
        });
    });
</script>
@endsection
