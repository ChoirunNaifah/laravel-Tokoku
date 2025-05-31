<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembeli;

class PembeliController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $pembelis = Pembeli::when($search, function ($query, $search) {
            return $query->where('nama', 'like', "%$search%");
        })->paginate(10);

        return view('pembeli.index', compact('pembelis'));
    }

    public function create()
    {
        return view('pembeli.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:15',
        ]);

        Pembeli::create($request->all());

        return redirect()->route('pembeli.index')->with('success', 'Data pembeli berhasil ditambahkan!');
    }

    public function edit(Pembeli $pembeli)
    {
        return view('pembeli.edit', compact('pembeli'));
    }

    public function update(Request $request, Pembeli $pembeli)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:15',
        ]);

        $pembeli->update($request->all());

        return redirect()->route('pembeli.index')->with('success', 'Data pembeli berhasil diperbarui!');
    }

    public function destroy(Pembeli $pembeli)
    {
        $pembeli->delete();

        return redirect()->route('pembeli.index')->with('success', 'Data pembeli berhasil dihapus!');
    }
}
