<?php

namespace App\Http\Controllers;

use App\Models\booking;
use App\Models\Inventori;
use App\Models\laporanbooking;
use App\Models\layanan;
use App\Models\Pekerja;
use App\Models\Transaksi;
use App\Models\transaksi_layanan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PembuatanPekerjaanControllers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $laporan = laporanbooking::with(['booking', 'user', 'layanans', 'barangs'])->latest()->get();
        $layanans = layanan::all();
        $karyawans = User::where('role', '!=', 'superadmin')->get();
        $bookings = booking::where('status', '!=', 'selesai')->get();
        $inventories = Inventori::all();

        return view('jadwalkerja', compact('laporan', 'bookings', 'layanans', 'inventories', 'karyawans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // Validasi data dari form
            $validatedData = $request->validate([
                // Validasi yang sudah ada sebelumnya
                'users' => 'required|exists:users,id',
                'booking_id' => 'required|exists:bookings,id',
                'judul_laporan' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'tanggal' => 'required',
                'status' => 'required|string',
            ]);

            // Simpan data laporan (kode ini sudah ada)
            $laporan = new laporanbooking();
            $laporan->user_id = $validatedData['users'];
            $laporan->booking_id = $validatedData['booking_id'];
            $laporan->judul_laporan = $validatedData['judul_laporan'];
            $laporan->deskripsi = $validatedData['deskripsi'];
            $laporan->tanggal = $validatedData['tanggal'];
            $laporan->status = $validatedData['status'];


            // Simpan data laporan ke database
            $laporan->save();

            // Update status dan karyawan di tabel bookings
            $booking = Booking::find($validatedData['booking_id']);
            $booking->tanggal = $validatedData['tanggal'];
            $booking->status = $validatedData['status'];
            $booking->save();

            return redirect()->route('pembuatan-pekerjaan.index')->with('success', 'Laporan berhasil disimpan.');
        } catch (\Exception $e) {
            Log::error('Error saat menyimpan laporan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan laporan. Silakan coba lagi.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $laporan = laporanbooking::findOrFail($id);

            // Validasi data dari form
            $validatedData = $request->validate([
                'judul_laporan' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'tanggal' => 'required|date',
                'status' => 'required|string',
            ]);

            // Simpan data laporan
            $laporan->judul_laporan = $validatedData['judul_laporan'];
            $laporan->deskripsi = $validatedData['deskripsi'];
            $laporan->tanggal = $validatedData['tanggal'];
            $laporan->status = $validatedData['status'];

            // Simpan data laporan ke database
            $laporan->save();

            $booking = Booking::find($laporan->booking_id);
            $booking->tanggal = $validatedData['tanggal'];
            $booking->status = $validatedData['status'];

            return redirect()->route('pembuatan-pekerjaan.index')->with('success', 'Laporan berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error saat memperbarui laporan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui laporan. Silakan coba lagi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $laporan = laporanbooking::findOrFail($id);

            // Hapus transaksi layanan
            $transaksiLayanan = transaksi_layanan::where('laporan_id', $id)->get();
            foreach ($transaksiLayanan as $layanan) {
                $layanan->delete();
            }

            // Hapus transaksi dan kembalikan stok inventori
            $transaksiBarang = Transaksi::where('laporan_id', $id)->get();
            foreach ($transaksiBarang as $barang) {
                $inventory = Inventori::find($barang->inventori_id);
                if ($inventory) {
                    $inventory->jumlah += $barang->jumlah;
                    $inventory->save();
                }
                $barang->delete();
            }

            // Hapus data dari model Pekerja
            $pekerja = Pekerja::where('laporan_id', $id)->get();
            foreach ($pekerja as $p) {
                $p->delete();
            }

            // Hapus laporan
            $laporan->delete();

            return redirect()->route('pembuatan-pekerjaan.index')->with('success', 'Laporan berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error saat menghapus laporan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus laporan. Silakan coba lagi.');
        }
    }
}
