<?php

namespace App\Http\Controllers;

use App\Models\booking;
use App\Models\Inventori;
use App\Models\laporanbooking;
use App\Models\layanan;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;


class AllController extends Controller
{
    public function index()
    {
        $karyawan = User::where('role', 'karyawan')->get();
        $inventori = Inventori::all();
        $layanan = layanan::all();
        $layananTerbaru = layanan::latest()->take(5)->get();
        $booking = booking::all();
        $bookingbelum = booking::where('status', 'belum dikerjakan')->get();
        $bookingbelums = booking::where('status', 'belum dikerjakan')->latest()->take(5)->get();
        $bookinngselesai = booking::where('status', 'Telah diselesaikan')->get();
        $lastThreeUsers = $karyawan->slice(-3);
        return view('dashboard', compact(
            'karyawan',
            'bookingbelum',
            'bookinngselesai',
            'lastThreeUsers',
            'booking',
            'layanan',
            'bookingbelums',
            'layananTerbaru',
            'inventori'
        ));
    }

    public function karyawan()
    {
        $users = User::where('role', 'karyawan')->get();
        return view('karyawan', compact('users'));
    }

    public function booking()
    {
        $booking = booking::where('status', '!=', 'Selesai')->latest()->get();
        $layanans = layanan::all();
        $inventories = Inventori::all();
        $karyawans = User::where('role', 'karyawan')->get();
        return view('pemasukan', compact('booking', 'layanans', 'inventories', 'karyawans'));
    }

    public function complete()
    {
        $booking = booking::with('user')->where('status', 'Selesai')->get();
        return view('complete', compact('booking'));
    }

    public function inventori()
    {
        $inventori = Inventori::all();
        return view('barang', compact('inventori'));
    }

    public function manajemenstok()
    {
        $booking = booking::latest()->get();
        $inventori = Inventori::all();
        $transaksi = Transaksi::with('inventori', 'booking')->get();
        return view('ambilbarang', compact('booking', 'inventori', 'transaksi'));
    }

    public function layanan()
    {
        $layanan = layanan::latest()->get();
        return view('layanan', compact('layanan'));
    }

    public function pekerjaansaya()
    {
        $laporan = laporanbooking::with(['booking', 'user', 'layanans', 'barangs', 'karyawans'])
            ->whereHas('karyawans', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->latest()
            ->get();
        $layanans = layanan::all();
        $akun = User::where('role', 'karyawan')->get();
        $bookings = booking::where('status', '!=', 'selesai')->get();
        $inventories = Inventori::all();

        return view('pekerjaan', compact('laporan', 'bookings', 'layanans', 'inventories', 'akun'));
    }
}
