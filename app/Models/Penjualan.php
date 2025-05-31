<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pembeli_id', 'kasir_id', 'tanggal_pesanan'
    ];

    public function pembeli()
    {
        return $this->belongsTo(Pembeli::class);
    }

    public function kasir()
    {
        return $this->belongsTo(User::class, 'kasir_id');
    }

    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class);
    }
}
