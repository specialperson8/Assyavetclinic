<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventori extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_barang',
        'jumlah',
        'harga',
        'tanggal_pembuatan',
        'satuan',
        'editobat',
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function obats()
    {
        return $this->hasMany(booking::class);
    }
}
