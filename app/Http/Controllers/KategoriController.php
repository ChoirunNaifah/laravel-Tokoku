<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Menampilkan daftar kategori dengan fitur pencarian
     */
    public function index(Request $request)
    {
        // Inisialisasi query ke model Kategori
        $query = Kategori::query();

        // Cek apakah ada parameter pencarian (search)
        if ($search = $request->input('search')) {
            $query->where('nama', 'like', "%{$search}%");
        }

        // Dapatkan hasil query dengan pagination
        $kategori = $query->paginate(10);

        // Kirim data kategori dan kata kunci pencarian ke view
        return view('kategori.index', compact('kategori'));
    }

    /**
     * Menampilkan form untuk menambahkan kategori baru
     */
    public function create()
    {
        return view('kategori.create');
    }

    /**
     * Menyimpan data kategori baru ke database
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        // Simpan data kategori
        Kategori::create($request->all());

        // Redirect dengan pesan sukses
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit data kategori
     */
    public function edit(Kategori $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    /**
     * Mengupdate data kategori yang ada
     */
    public function update(Request $request, Kategori $kategori)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        // Update data kategori
        $kategori->update($request->all());

        // Redirect dengan pesan sukses
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diupdate!');
    }

    /**
     * Menghapus data kategori
     */
    public function destroy(Kategori $kategori)
    {
        // Hapus data kategori
        $kategori->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
