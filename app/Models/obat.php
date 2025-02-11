<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class obat extends Model
{
    use HasFactory;

    protected $table = 'bookings';

    protected $fillable = [
        'id',
        'kode_booking',
        'user_id',
        'nama',
        'nama_hewan',
        'berat_hewan',
        'jenis_hewan',
        'alamat',
        'telpon',
        'tanggal',
        'keluar',
        'keluhan',
        'karyawan1',
        'karyawan2',
        'karyawan3',
        'dp',
        'total',
        'status',
        'catatan',
        'diskon',
        'editobat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function karyawan1()
    {
        return $this->belongsTo(User::class);
    }

    public function karyawan2()
    {
        return $this->belongsTo(User::class);
    }

    public function karyawan3()
    {
        return $this->belongsTo(User::class);
    }

    public function karyawan($column)
    {
        return $this->belongsTo(User::class, $column);
    }

    public function getKaryawan($column)
    {
        return $this->belongsTo(User::class, $column)->first();
    }
}
