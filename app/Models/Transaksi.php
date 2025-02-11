<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis';

    protected $fillable = ['booking_id', 'inventori_id', 'laporan_id', 'jumlah', 'total'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function inventori()
    {
        return $this->belongsTo(Inventori::class);
    }

    public function layanan()
    {
        return $this->belongsTo(laporanbooking::class);
    }
}
