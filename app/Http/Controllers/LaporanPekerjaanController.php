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

class LaporanPekerjaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $laporan = laporanbooking::with(['booking', 'user', 'layanans', 'barangs', 'karyawans'])
            ->whereDoesntHave('karyawans')
            ->latest()
            ->get();
        $layanans = layanan::all();
        $akun = User::whereIn('role', ['admin', 'karyawan'])->get();
        $bookings = booking::where('status', '!=', 'selesai')->get();
        $inventories = Inventori::all();

        return view('laporanpekerjaan', compact('laporan', 'bookings', 'layanans', 'inventories', 'akun'));
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
    public function store(Request $request,  $id)
    {
        try {
            // Validasi data dari form
            $validatedData = $request->validate([
                // Validasi yang sudah ada sebelumnya
                'booking_id' => 'required|exists:bookings,id',
                'deskripsi' => 'required|string',
                'bukti' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
                'layanan_id' => 'required|array',
                'layanan_id.*' => 'required|exists:layanans,id',
                'kuantitas' => 'required|array',
                'kuantitas.*' => 'required|integer|min:1',
                'total_harga_pure' => 'required|array',
                'total_harga_pure.*' => 'required|numeric|min:0',
                'inventori_id' => 'nullable|array',
                'inventori_id.*' => 'nullable|exists:inventoris,id',
                'kuantitas_barang' => 'nullable|array',
                'kuantitas_barang.*' => 'nullable|integer|min:1',
                'total_harga_barang' => 'nullable|array',
                'total_harga_barang.*' => 'nullable|numeric|min:0',
                'status' => 'required',
                'karyawan' => 'required|array|min:1', // Ensure at least one karyawan is selected
                'karyawan.*' => 'exists:pekerjas,id',
            ]);

            dd($validatedData);

            $laporan = laporanbooking::findOrFail($id);
            $laporan->update([
                'deskripsi' => $validatedData['deskripsi'],
                'bukti' => $request->hasFile('bukti') ? $request->file('bukti')->store('laporan', 'public') : $laporan->bukti,
            ]);

            // Simpan karyawan
            foreach ($validatedData['karyawan'] as $index => $karyawanId) {
                $karyawan = new Pekerja();
                $karyawan->laporan_id = $id;
                $karyawan->user_id = $karyawanId;
                $karyawan->save();
            }

            foreach ($validatedData['layanan_id'] as $index => $layananId) {
                $layanan = new transaksi_layanan();
                $layanan->booking_id = $validatedData['booking_id'];
                $layanan->laporan_id = $laporan->id;
                $layanan->layanan_id = $layananId;
                $layanan->jumlah = $validatedData['kuantitas'][$index];
                $layanan->total = $validatedData['total_harga_pure'][$index];
                $layanan->save();
            }


            // Simpan layanan (kode ini sudah ada)
            foreach ($validatedData['layanan_id'] as $index => $layananId) {
                $layanan = new transaksi_layanan();
                $layanan->booking_id = $validatedData['booking_id'];
                $layanan->laporan_id = $laporan->id;
                $layanan->layanan_id = $layananId;
                $layanan->jumlah = $validatedData['kuantitas'][$index];
                $layanan->total = $validatedData['total_harga_pure'][$index];
                $layanan->save();
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
            $booking->save();

            return redirect()->route('laporan.index')->with('success', 'Laporan berhasil disimpan.');
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
            // Validasi data dari form
            $validatedData = $request->validate([
                // Validasi yang sudah ada sebelumnya
                'booking_id' => 'required|exists:bookings,id',
                'deskripsi' => 'required|string',
                'bukti' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
                'layanan_id' => 'required|array',
                'layanan_id.*' => 'required|exists:layanans,id',
                'kuantitas' => 'required|array',
                'kuantitas.*' => 'required|integer|min:1',
                'total_harga_pure' => 'required|array',
                'total_harga_pure.*' => 'required|numeric|min:0',
                'inventori_id' => 'nullable|array',
                'inventori_id.*' => 'nullable|exists:inventoris,id',
                'kuantitas_barang' => 'nullable|array',
                'kuantitas_barang.*' => 'nullable|integer|min:1',
                'total_harga_barang' => 'nullable|array',
                'total_harga_barang.*' => 'nullable|numeric|min:0',
                'status' => 'required',
                'karyawan' => 'required|array|min:1', // Ensure at least one karyawan is selected
                'karyawan.*' => 'exists:pekerjas,id',
            ]);

            dd($validatedData);

            $laporan = laporanbooking::findOrFail($id);
            $laporan->update([
                'deskripsi' => $validatedData['deskripsi'],
                'bukti' => $request->hasFile('bukti') ? $request->file('bukti')->store('laporan', 'public') : $laporan->bukti,
            ]);

            // Simpan karyawan
            foreach ($validatedData['karyawan'] as $index => $karyawanId) {
                $karyawan = new Pekerja();
                $karyawan->laporan_id = $id;
                $karyawan->user_id = $karyawanId;
                $karyawan->save();
            }

            foreach ($validatedData['layanan_id'] as $index => $layananId) {
                $layanan = new transaksi_layanan();
                $layanan->booking_id = $validatedData['booking_id'];
                $layanan->laporan_id = $id;
                $layanan->layanan_id = $layananId;
                $layanan->jumlah = $validatedData['kuantitas'][$index];
                $layanan->total = $validatedData['total_harga_pure'][$index];
                $layanan->save();
            }


            // Simpan layanan (kode ini sudah ada)
            foreach ($validatedData['layanan_id'] as $index => $layananId) {
                $layanan = new transaksi_layanan();
                $layanan->booking_id = $validatedData['booking_id'];
                $layanan->laporan_id = $id;
                $layanan->layanan_id = $layananId;
                $layanan->jumlah = $validatedData['kuantitas'][$index];
                $layanan->total = $validatedData['total_harga_pure'][$index];
                $layanan->save();
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
                    $barang->laporan_id = $id;
                    $barang->inventori_id = $inventoriId;
                    $barang->jumlah = $kuantitasBarang;
                    $barang->total = $validatedData['total_harga_barang'][$index];
                    $barang->save();
                }
            }

            // Update status dan karyawan di tabel bookings
            $booking = Booking::find($validatedData['booking_id']);
            $booking->status = $validatedData['status'];
            $booking->save();

            return redirect()->route('laporan.index')->with('success', 'Laporan berhasil disimpan.');
        } catch (\Exception $e) {
            Log::error('Error saat menyimpan laporan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan laporan. Silakan coba lagi. Error: ' . $e->getMessage());
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
        //
    }
}
