<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaksi_layanan extends Model
{
    use HasFactory;

    protected $table = 'transaksi_layanans';

    protected $fillable = ['booking_id', 'layanan_id', 'laporan_id', 'jumlah', 'total'];

    public function booking()
    {
        return $this->belongsTo(booking::class);
    }

    public function laporan()
    {
        return $this->belongsTo(laporanbooking::class);
    }

    public function layanan()
    {
        return $this->belongsTo(layanan::class);
    }
}
