<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Barang;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    // Menampilkan daftar pembelian dengan fitur pencarian dan pagination
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Query data pembelian dengan relasi ke barang dan supplier
        $pembelians = Pembelian::with(['barang', 'supplier'])
            ->when($search, function ($query, $search) {
                $query->whereHas('barang', function ($q) use ($search) {
                    $q->where('nama', 'like', "%$search%");
                })
                ->orWhereHas('supplier', function ($q) use ($search) {
                    $q->where('nama', 'like', "%$search%");
                })
                ->orWhere('status', 'like', "%$search%");
            })
            ->paginate(10);

        return view('pembelian.index', compact('pembelians'));
    }

    // Menampilkan form untuk membuat pembelian baru
    public function create()
    {
        $barangs = Barang::all();
        $suppliers = Supplier::all();

        return view('pembelian.create', compact('barangs', 'suppliers'));
    }

    // Menyimpan data pembelian baru
    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'status' => 'required|in:pending,selesai',
        ]);

        Pembelian::create($request->all());

        return redirect()->route('pembelian.index')->with('success', 'Data pembelian berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit data pembelian
    public function edit(Pembelian $pembelian)
    {
        $barangs = Barang::all();
        $suppliers = Supplier::all();

        return view('pembelian.edit', compact('pembelian', 'barangs', 'suppliers'));
    }

    // Memperbarui data pembelian
    public function update(Request $request, Pembelian $pembelian)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'status' => 'required|in:pending,selesai',
        ]);

        $pembelian->update($request->all());

        return redirect()->route('pembelian.index')->with('success', 'Data pembelian berhasil diperbarui.');
    }

    // Menghapus data pembelian
    public function destroy(Pembelian $pembelian)
    {
        $pembelian->delete();

        return redirect()->route('pembelian.index')->with('success', 'Data pembelian berhasil dihapus.');
    }
}
