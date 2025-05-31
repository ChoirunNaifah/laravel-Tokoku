@extends('layouts.app')

@push('styles')
<style>
    body {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        font-family: 'Segoe UI', sans-serif;
    }

    .register-card {
        background-color: #fff;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        width: 100%;
        max-width: 450px;
        margin: 100px auto;
    }

    .register-title {
        color: #6a11cb;
        font-weight: bold;
    }

    .form-label {
        font-weight: 500;
    }

    .btn-primary {
        background-color: #6a11cb;
        border: none;
    }

    .btn-primary:hover {
        background-color: #5011a1;
    }

    .logo {
        width: 70px;
        height: 70px;
        object-fit: cover;
        margin-bottom: 10px;
    }
</style>
@endpush

@section('content')
<div class="register-card text-center">
    <!-- Logo -->
    <img src="https://cdn-icons-png.flaticon.com/512/263/263115.png" alt="Tokoku Ifa" class="logo">

    <h3 class="register-title mb-3">Daftar Akun Baru</h3>

    @if($errors->any())
        <div class="alert alert-danger py-2">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('register.process') }}">
        @csrf
        <div class="mb-3 text-start">
            <label for="name" class="form-label text-secondary">Nama</label>
            <input type="text" name="name" class="form-control" required autofocus placeholder="Nama lengkap">
        </div>

        <div class="mb-3 text-start">
            <label for="email" class="form-label text-secondary">Email</label>
            <input type="email" name="email" class="form-control" required placeholder="ifa@example.com">
        </div>

        <div class="mb-3 text-start">
            <label for="password" class="form-label text-secondary">Password</label>
            <input type="password" name="password" class="form-control" required placeholder="******">
        </div>

        <div class="mb-3 text-start">
            <label for="password_confirmation" class="form-label text-secondary">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" required placeholder="******">
        </div>

        <button type="submit" class="btn btn-primary w-100">Daftar</button>
    </form>

    <div class="mt-3 text-center">
        <span>Sudah punya akun?</span>
        <a href="{{ route('login') }}" class="text-decoration-none text-primary fw-bold">Login</a>
    </div>
</div>
@endsection
