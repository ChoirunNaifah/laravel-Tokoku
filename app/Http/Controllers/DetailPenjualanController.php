<?php

namespace App\Http\Controllers;

use App\Models\DetailPenjualan;
use Illuminate\Http\Request;

class DetailPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $details = DetailPenjualan::when($search, function ($query, $search) {
            $query->where('penjualan_id', 'like', "%{$search}%")
                  ->orWhere('barang_id', 'like', "%{$search}%");
        })->paginate(10);

        return view('detail_penjualan.index', compact('details'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('detail_penjualan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'penjualan_id' => 'required|integer',
            'barang_id'    => 'required|integer',
            'jumlah'       => 'required|integer|min:1',
            'total_harga'  => 'required|numeric|min:0',
        ]);

        DetailPenjualan::create($request->all());

        return redirect()->route('detail_penjualan.index')->with('success', 'Data berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DetailPenjualan $detail_penjualan)
    {
        return view('detail_penjualan.edit', ['detail' => $detail_penjualan]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DetailPenjualan $detail_penjualan)
    {
        $request->validate([
            'penjualan_id' => 'required|integer',
            'barang_id'    => 'required|integer',
            'jumlah'       => 'required|integer|min:1',
            'total_harga'  => 'required|numeric|min:0',
        ]);

        $detail_penjualan->update($request->all());

        return redirect()->route('detail_penjualan.index')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetailPenjualan $detail_penjualan)
    {
        $detail_penjualan->delete();

        return redirect()->route('detail_penjualan.index')->with('success', 'Data berhasil dihapus.');
    }
}
