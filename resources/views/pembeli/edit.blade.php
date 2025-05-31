@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Pembeli</div>

                <div class="card-body">
                    <form action="{{ route('pembeli.update', $pembeli->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control" value="{{ old('nama', $pembeli->nama) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-control" required>
                                <option value="Laki-laki" {{ $pembeli->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ $pembeli->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" required>{{ old('alamat', $pembeli->alamat) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="no_hp" class="form-label">No HP</label>
                            <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $pembeli->no_hp) }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('pembeli.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
