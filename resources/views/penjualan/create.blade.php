@extends('layouts.app')

@section('title', 'Tambah Penjualan')
@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Tambah Penjualan</h3>
                <a href="{{ route('penjualan.index') }}" class="btn btn-primary">
                    History Penjualan
                </a>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('penjualan.store') }}" id="form-penjualan">
                    @csrf
                    <div class="form-group">
                        <label for="pembeli_id">Pembeli</label>
                        <select name="pembeli_id" id="pembeli_id" class="form-control" required>
                            <option value="">Pilih Pembeli</option>
                            @foreach($pembelis as $pembeli)
                                <option value="{{ $pembeli->id }}">{{ $pembeli->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <br>
                    <!-- Barang dan Jumlah -->
                    <div id="barang-container">
                        <div class="row barang-row">
                            <br>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="barang_id">Barang</label>
                                    <select name="barang_id[]" class="form-control barang-select" required>
                                        <option value="">Pilih Barang</option>
                                        @foreach($barangs as $barang)
                                            <option value="{{ $barang->id }}" data-harga="{{ $barang->harga }}">
                                                {{ $barang->nama }} - Rp {{ number_format($barang->harga, 0, ',', '.') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="jumlah">Jumlah</label>
                                    <input type="number" name="jumlah[]" class="form-control jumlah-input" required min="1">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <br>
                                    <button type="button" class="btn btn-danger btn-block hapus-barang" disabled>Hapus</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <!-- Tombol Tambah Barang -->
                    <div class="form-group">
                        <button type="button" id="tambah-barang" class="btn btn-secondary">
                            + Tambah Barang
                        </button>
                    </div>
                    <br>
                    <!-- Total Harga -->
                    <div class="form-group">
                        <label for="total_harga">Total Harga</label>
                        <input type="text" id="total_harga" class="form-control" readonly>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk Menambah Barang dan Menghitung Total -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const barangContainer = document.getElementById('barang-container');
            const tambahBarangBtn = document.getElementById('tambah-barang');
            const totalHargaInput = document.getElementById('total_harga');

            // Fungsi untuk menghitung total harga
            function hitungTotalHarga() {
                let total = 0;
                document.querySelectorAll('.barang-row').forEach(row => {
                    const harga = row.querySelector('.barang-select').selectedOptions[0]?.dataset.harga || 0;
                    const jumlah = row.querySelector('.jumlah-input').value || 0;
                    total += harga * jumlah;
                });
                totalHargaInput.value = `Rp ${total.toLocaleString()}`;
            }

            // Tambah baris barang baru
            tambahBarangBtn.addEventListener('click', function () {
                const newRow = document.querySelector('.barang-row').cloneNode(true);
                newRow.querySelectorAll('input, select').forEach(input => input.value = '');
                newRow.querySelector('.hapus-barang').disabled = false;
                barangContainer.appendChild(newRow);

                // Tambahkan event listener untuk menghitung total harga
                newRow.querySelector('.barang-select').addEventListener('change', hitungTotalHarga);
                newRow.querySelector('.jumlah-input').addEventListener('input', hitungTotalHarga);
            });

            // Hapus baris barang
            barangContainer.addEventListener('click', function (e) {
                if (e.target.classList.contains('hapus-barang')) {
                    e.target.closest('.barang-row').remove();
                    hitungTotalHarga();
                }
            });

            // Hitung total harga saat barang atau jumlah diubah
            document.querySelectorAll('.barang-select, .jumlah-input').forEach(input => {
                input.addEventListener('change', hitungTotalHarga);
                input.addEventListener('input', hitungTotalHarga);
            });
        });
    </script>
@endsection