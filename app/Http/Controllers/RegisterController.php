<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // sesuaikan jika pakai model Login
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // Menampilkan form register
    public function showRegisterForm()
    {
        return view('auth.register'); // arahkan ke view auth/register.blade.php
    }

    // Proses data register
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Simpan user ke database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Redirect ke login setelah registrasi berhasil
        return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
    }
}
