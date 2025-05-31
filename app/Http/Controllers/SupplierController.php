<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Menampilkan daftar supplier dengan fitur pencarian
     */
    public function index(Request $request)
    {
        // Inisialisasi query ke model Supplier
        $query = Supplier::query();

        // Cek apakah ada parameter pencarian (search)
        if ($search = $request->input('search')) {
            // Tambahkan kondisi pencarian ke query
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%")
                  ->orWhere('kode_pos', 'like', "%{$search}%");
        }

        // Dapatkan hasil query dengan pagination
        $supplier = $query->paginate(10);

        // Kirim data supplier dan kata kunci pencarian ke view
        return view('supplier.index', compact('supplier'));
    }

    /**
     * Menampilkan form untuk menambahkan supplier baru
     */
    public function create()
    {
        return view('supplier.create');
    }

    /**
     * Menyimpan data supplier baru ke database
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required',
            'kode_pos' => 'required',
        ]);

        // Simpan data supplier
        Supplier::create($request->all());

        // Redirect dengan pesan sukses
        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit data supplier
     */
    public function edit(Supplier $supplier)
    {
        return view('supplier.edit', compact('supplier'));
    }

    /**
     * Mengupdate data supplier yang ada
     */
    public function update(Request $request, Supplier $supplier)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required',
            'kode_pos' => 'required',
        ]);

        // Update data supplier
        $supplier->update($request->all());

        // Redirect dengan pesan sukses
        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil diupdate!');
    }

    /**
     * Menghapus data supplier
     */
    public function destroy(Supplier $supplier)
    {
        // Hapus data supplier
        $supplier->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil dihapus!');
    }
}
