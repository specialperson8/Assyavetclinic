<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class laporanbooking extends Model
{
    use HasFactory;

    protected $table = 'laporanbookings';

    protected $fillable = [
        'id',
        'booking_id',
        'user_id',
        'judul_laporan',
        'deskripsi',
        'status',
        'bukti',
        'tanggal',
    ];

    public function booking()
    {
        return $this->belongsTo(booking::class);
    }

    public function layanans()
    {
        return $this->hasMany(transaksi_layanan::class, 'laporan_id');
    }

    public function barangs()
    {
        return $this->hasMany(Transaksi::class, 'laporan_id');
    }

    public function karyawans()
    {
        return $this->hasMany(Pekerja::class, 'laporan_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
