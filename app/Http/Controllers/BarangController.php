<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    // Menampilkan semua data barang
    public function index(Request $request)
    {
        $search = $request->get('search');

        $data = Barang::where(function ($query) use ($search) {
            $query->where('nama', 'like', "%$search%")
                ->orWhere('stok', 'like', "%$search%")
                ->orWhere('harga', 'like', "%$search%");
            })
            ->orWhereHas('kategori', function ($query) use ($search) {
                $query->where('nama', 'like', "%$search%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('barang.index', compact('data'));
    }

    // Menampilkan form untuk menambah barang
    public function create()
    {
        $kategoris = Kategori::all();
        return view('barang.create', compact('kategoris'));
    }

    // Menyimpan data barang baru

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'harga' => 'required|numeric|min:0',
            'gambar' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = new Barang();
        $data->nama = $request->nama;
        $data->kategori_id = $request->kategori_id;
        $data->harga = $request->harga;
        $data->stok = 0;

        // Cek jika ada file gambar yang diupload
        if ($request->hasFile('gambar')) {
            // Generate nama file unik menggunakan uniqid atau Str::random
            $gambar = $request->file('gambar');
            $fileName = 'barang_images/' . uniqid() . '.' . $gambar->getClientOriginalExtension();

            // Simpan gambar ke folder public/barang_images
            $gambar->storeAs('public/', $fileName);

            // Simpan nama file ke database
            $data->gambar = $fileName;
        }

        $data->save();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    // Menampilkan form untuk mengedit barang
    public function edit(Barang $barang)
    {
        $kategoris = Kategori::all();
        return view('barang.edit', compact('barang', 'kategoris'));
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'harga' => 'required|numeric|min:0',
            'gambar' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $barang->nama = $request->nama;
        $barang->kategori_id = $request->kategori_id;
        $barang->harga = $request->harga;

        // Cek jika ada file gambar yang diupload
        if ($request->hasFile('gambar')) {

            if ($barang->gambar) {
                Storage::delete('public/' . $barang->gambar);
            }

            // Generate nama file unik menggunakan uniqid atau Str::random
            $gambar = $request->file('gambar');
            $fileName = 'barang_images/' . uniqid() . '.' . $gambar->getClientOriginalExtension();

            // Simpan gambar ke folder public/barang_images
            $gambar->storeAs('public/', $fileName);

            // Simpan nama file ke database
            $barang->gambar = $fileName;
        }

        $barang->save();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui!');
    }

    // Menghapus data barang
    public function destroy($id)
    {
        // Cari data berdasarkan ID
        $barang = Barang::findOrFail($id);

        // Cek apakah file gambar ada dan jika ada, hapus file dari storage
        if ($barang->gambar && Storage::exists('public/' . $barang->gambar)) {
            Storage::delete('public/' . $barang->gambar);
        }

        // Hapus data barang dari database
        $barang->delete();

        // Redirect dengan pesan success
        return redirect()->route('barang.index')->with('success', 'Berhasil Menghapus Barang');
    }
}
