<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Barang;
use App\Models\Pembeli;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index(Request $request)
    {
        
        $search = $request->query('search');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $data = Penjualan::with(['pembeli', 'kasir', 'detailPenjualan'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('pembeli', function ($q) use ($search) {
                    $q->where('nama', 'like', '%' . $search . '%');
                });
            })
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                // Konversi ke format Y-m-d agar hanya mempertimbangkan tanggal tanpa jam
                $startDateFormatted = Carbon::parse($startDate)->toDateString();
                $endDateFormatted = Carbon::parse($endDate)->toDateString();

                $query->whereBetween(DB::raw('DATE(tanggal_pesanan)'), [$startDateFormatted, $endDateFormatted]);
            })
            ->orderBy('tanggal_pesanan', 'desc')
            ->paginate(5);

        return view('penjualan.index', compact('data'));
    }

    public function create()
    {
        $barangs = Barang::all();
        $pembelis = Pembeli::all();
        return view('penjualan.create', compact('barangs', 'pembelis'));
    }

    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'pembeli_id' => 'required|exists:pembelis,id', // Pastikan pembeli_id valid
            'barang_id' => 'required|array', // barang_id harus berupa array
            'barang_id.*' => 'exists:barangs,id', // Setiap barang_id harus ada di tabel barangs
            'jumlah' => 'required|array', // jumlah harus berupa array
            'jumlah.*' => 'integer|min:1', // Setiap jumlah harus integer dan minimal 1
        ]);

        // Cek stok barang sebelum melanjutkan
        foreach ($request->barang_id as $key => $barang_id) {
            $barang = Barang::find($barang_id);
            $jumlah = $request->jumlah[$key];

            // Jika stok tidak mencukupi
            if ($barang->stok < $jumlah) {
                return redirect()->back()
                    ->withInput() // Mengembalikan input yang sudah diisi
                    ->withErrors(['jumlah.' . $key => 'Stok ' . $barang->nama . ' tidak mencukupi. Stok tersedia: ' . $barang->stok]);
            }
        }

        // Buat data penjualan
        $penjualan = Penjualan::create([
            'pembeli_id' => $request->pembeli_id,
            'kasir_id' => auth()->id(), // Ambil ID user yang sedang login sebagai kasir
            'tanggal_pesanan' => now(), // Tanggal pesanan diisi dengan waktu sekarang
        ]);

        // Simpan detail penjualan
        foreach ($request->barang_id as $key => $barang_id) {
            // Ambil data barang
            $barang = Barang::find($barang_id);

            // Hitung total harga
            $total_harga = $barang->harga * $request->jumlah[$key];

            // Simpan detail penjualan
            DetailPenjualan::create([
                'penjualan_id' => $penjualan->id,
                'barang_id' => $barang_id,
                'jumlah' => $request->jumlah[$key],
                'total_harga' => $total_harga,
            ]);

            // Kurangi stok barang
            $barang->stok -= $request->jumlah[$key];
            $barang->save();
        }

        // Redirect ke halaman index dengan pesan success
        return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil dibuat.');
    }

    public function destroy(Penjualan $penjualan)
    {
        DetailPenjualan::where('penjualan_id', $penjualan->id)->delete();

        $penjualan->delete();
        return redirect()->route('penjualan.index')->with('success', 'Berhasil Menghapus Penjualan!');
    }

    public function show($id)
    {
        $penjualan = Penjualan::with(['pembeli', 'kasir', 'detailPenjualan.barang'])->findOrFail($id);
        return view('penjualan.show', compact('penjualan'));
    }

    public function print($id)
    {
        $penjualan = Penjualan::with(['pembeli', 'kasir', 'detailPenjualan.barang'])->findOrFail($id);
        return view('penjualan.print', compact('penjualan'));
    }

    public function downloadPDF(Request $request)
    {
        // Ambil data penjualan berdasarkan pencarian
        $search = $request->query('search');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $data = Penjualan::with(['pembeli', 'kasir', 'detailPenjualan'])
                ->when($search, function ($query) use ($search) {
                    $query->whereHas('pembeli', function ($q) use ($search) {
                        $q->where('nama', 'like', '%' . $search . '%');
                    });
                })
                ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                    // Konversi ke format Y-m-d agar hanya mempertimbangkan tanggal tanpa jam
                    $startDateFormatted = Carbon::parse($startDate)->toDateString();
                    $endDateFormatted = Carbon::parse($endDate)->toDateString();

                    $query->whereBetween(DB::raw('DATE(tanggal_pesanan)'), [$startDateFormatted, $endDateFormatted]);
                })
                ->orderBy('tanggal_pesanan', 'desc')
                ->get(); // Sesuaikan jumlah item per halaman

        // Load view PDF dengan data penjualan
        $pdf = Pdf::loadView('penjualan.pdf', compact('data', 'search' , 'startDate', 'endDate'));

        // Download PDF
        return $pdf->download('laporan-penjualan.pdf');
    }
}