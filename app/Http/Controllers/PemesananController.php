<?php

namespace App\Http\Controllers;

use App\Models\booking;
use App\Models\Inventori;
use App\Models\laporanbooking;
use App\Models\Transaksi;
use App\Models\transaksi_layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PemesananController extends Controller
{
    public function index()
    {
        $bookings = booking::with(['user', 'karyawan1', 'karyawan2', 'karyawan3'])
            ->latest()
            ->get();
        return view('pemesanan', compact('bookings'));
    }

    public function store(Request $request)
    {
        try {
            // Validasi data dari form
            $validatedData = $request->validate([
                // Validasi yang sudah ada sebelumnya
                'booking_id' => 'required|exists:bookings,id',
                'judul_laporan' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'tanggal' => 'required|date',
                'bukti' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
                'layanan_id' => 'nullable|array',
                'layanan_id.*' => 'nullable|exists:layanans,id',
                'kuantitas' => 'nullable|array',
                'kuantitas.*' => 'nullable|integer|min:1',
                'total_harga_pure' => 'nullable|array',
                'total_harga_pure.*' => 'nullable|numeric|min:0',
                'inventori_id' => 'nullable|array',
                'inventori_id.*' => 'nullable|exists:inventoris,id',
                'kuantitas_barang' => 'nullable|array',
                'kuantitas_barang.*' => 'nullable|integer|min:1',
                'total_harga_barang' => 'nullable|array',
                'total_harga_barang.*' => 'nullable|numeric|min:0',
                'status' => 'required',
                'karyawan1' => 'nullable|exists:users,id',
                'karyawan2' => 'nullable|exists:users,id',
                'karyawan3' => 'nullable|exists:users,id',
            ]);

            // dd($validatedData);

            // Simpan data laporan (kode ini sudah ada)
            $laporan = new laporanbooking();
            $laporan->booking_id = $validatedData['booking_id'];
            $laporan->user_id = auth()->user()->id;
            $laporan->judul_laporan = $validatedData['judul_laporan'];
            $laporan->deskripsi = $validatedData['deskripsi'];
            $laporan->tanggal = $validatedData['tanggal'];

            // Simpan file bukti jika ada
            if ($request->hasFile('bukti') && $request->file('bukti')->isValid()) {
                $timestamp = now()->timestamp;
                $filename = $validatedData['judul_laporan'] . '_' . $timestamp . '.' . $request->file('bukti')->getClientOriginalExtension();
                $path = $request->file('bukti')->storeAs('laporan', $filename, 'public');
                $laporan->bukti = $path;
            }
            $laporan->save();

            // Simpan layanan (kode ini sudah ada)
            if (!empty($validatedData['layanan_id'])) {
                foreach ($validatedData['layanan_id'] as $index => $layananId) {
                    $layanan = new transaksi_layanan();
                    $layanan->booking_id = $validatedData['booking_id'];
                    $layanan->laporan_id = $laporan->id;
                    $layanan->layanan_id = $layananId;
                    $layanan->jumlah = $validatedData['kuantitas'][$index];
                    $layanan->total = $validatedData['total_harga_pure'][$index];
                    $layanan->save();
                }
            }

            // Simpan barang (kode ini sudah ada)
            if (!empty($validatedData['inventori_id'])) {
                foreach ($validatedData['inventori_id'] as $index => $inventoriId) {
                    $inventory = Inventori::find($inventoriId);
                    $kuantitasBarang = $validatedData['kuantitas_barang'][$index];
                    if ($inventory->jumlah < $kuantitasBarang) {
                        return redirect()->back()->withErrors(['inventori_id' => "Stok barang {$inventory->nama_barang} tidak mencukupi."])->withInput();
                    }
                    $inventory->jumlah -= $kuantitasBarang;
                    $inventory->save();

                    $barang = new Transaksi();
                    $barang->booking_id = $validatedData['booking_id'];
                    $barang->laporan_id = $laporan->id;
                    $barang->inventori_id = $inventoriId;
                    $barang->jumlah = $kuantitasBarang;
                    $barang->total = $validatedData['total_harga_barang'][$index];
                    $barang->save();
                }
            }

            // Update status dan karyawan di tabel bookings
            $booking = Booking::find($validatedData['booking_id']);
            $booking->status = $validatedData['status'];
            $booking->tanggal = $validatedData['tanggal'];
            $booking->karyawan1 = $validatedData['karyawan1'] ?? null;
            $booking->karyawan2 = $validatedData['karyawan2'] ?? null;
            $booking->karyawan3 = $validatedData['karyawan3'] ?? null;
            $booking->save();

            return redirect()->route('laporan.index')->with('success', 'Laporan berhasil disimpan.');
        } catch (\Exception $e) {
            Log::error('Error saat menyimpan laporan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan laporan. Silakan coba lagi.');
        }
    }
}
