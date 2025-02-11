<?php

namespace App\Http\Controllers;

use App\Models\booking;
use App\Models\Inventori;
use App\Models\laporanbooking;
use App\Models\layanan;
use App\Models\transakasi_layanan;
use App\Models\Transaksi;
use App\Models\transaksi_layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LaporanbookingController extends Controller
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
        $bookings = booking::where('status', '!=', 'selesai')->get();
        $inventories = Inventori::all();
        return view('laporan', compact('laporan', 'bookings', 'layanans', 'inventories'));
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
                'booking_id' => 'required|exists:bookings,id',
                'judul_laporan' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'tanggal' => 'required|date',
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
                'karyawan1' => 'nullable|exists:users,id',
                'karyawan2' => 'nullable|exists:users,id',
                'karyawan3' => 'nullable|exists:users,id',
            ]);
            dd($validatedData); // Removed for production

            // Simpan data laporan (kode ini sudah ada)
            $laporan = new laporanbooking();
            $laporan->booking_id = $validatedData['booking_id'];
            $laporan->user_id = auth()->user()->id;
            $laporan->judul_laporan = $validatedData['judul_laporan'];
            $laporan->deskripsi = $validatedData['deskripsi'];
            $laporan->tanggal = $validatedData['tanggal'];

            // Simpan file bukti jika ada
            if ($request->hasFile('bukti') && $request->file('bukti')->isValid()) {
                $path = $request->file('bukti')->store('laporan', 'public');
                $laporan->bukti = $path;
            }
            $laporan->save();

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
            $booking->karyawan1 = $validatedData['karyawan1'];
            $booking->karyawan2 = $validatedData['karyawan2'] ?? null;
            $booking->karyawan3 = $validatedData['karyawan3'] ?? null;
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
     * @param  \App\Models\laporanbooking  $laporanbooking
     * @return \Illuminate\Http\Response
     */
    public function show(laporanbooking $laporanbooking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\laporanbooking  $laporanbooking
     * @return \Illuminate\Http\Response
     */
    public function edit(laporanbooking $laporanbooking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\laporanbooking  $laporanbooking
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
            ]);

            dd($validatedData); // Removed for production

            // Update laporan
            $laporan->update([
                'judul_laporan' => $validatedData['judul_laporan'],
                'deskripsi' => $validatedData['deskripsi'],
                'tanggal' => $validatedData['tanggal'],
                'status' => $validatedData['status'],
                'bukti' => $request->hasFile('bukti') ? $request->file('bukti')->store('laporan', 'public') : $laporan->bukti,
            ]);

            // Handle layanan
            $existingLayanan = transaksi_layanan::where('laporan_id', $id)->get();
            $updatedLayananIds = $validatedData['layanan_id'];

            foreach ($existingLayanan as $transaksiLayanan) {
                if (!in_array($transaksiLayanan->layanan_id, $updatedLayananIds)) {
                    $transaksiLayanan->delete(); // Hapus layanan yang tidak ada di input baru
                }
            }

            foreach ($validatedData['layanan_id'] as $index => $layananId) {
                transaksi_layanan::updateOrCreate(
                    ['laporan_id' => $id, 'layanan_id' => $layananId],
                    [
                        'booking_id' => $laporan->booking_id,
                        'jumlah' => $validatedData['kuantitas'][$index],
                        'total' => $validatedData['kuantitas'][$index] * Layanan::find($layananId)->harga,
                    ]
                );
            }

            // Handle barang
            $existingBarang = Transaksi::where('laporan_id', $id)->get();
            $updatedBarangIds = $validatedData['inventori_id'] ?? [];

            foreach ($existingBarang as $transaksiBarang) {
                if (!in_array($transaksiBarang->inventori_id, $updatedBarangIds)) {
                    $inventory = Inventori::find($transaksiBarang->inventori_id);
                    $inventory->jumlah += $transaksiBarang->jumlah; // Kembalikan stok
                    $inventory->save();

                    $transaksiBarang->delete(); // Hapus barang
                }
            }

            if (!empty($validatedData['inventori_id'])) {
                foreach ($validatedData['inventori_id'] as $index => $barangId) {
                    $inventory = Inventori::find($barangId);
                    $kuantitasBaru = $validatedData['kuantitas_barang'][$index];
                    $transaksiBarang = Transaksi::where('laporan_id', $id)->where('inventori_id', $barangId)->first();

                    $stokAwal = $transaksiBarang ? $transaksiBarang->jumlah : 0;
                    $stokSelisih = $kuantitasBaru - $stokAwal;

                    if ($stokSelisih > 0 && $inventory->jumlah < $stokSelisih) {
                        return back()->withErrors(['message' => "Stok tidak mencukupi untuk barang {$inventory->nama_barang}"]);
                    }

                    $inventory->jumlah -= $stokSelisih;
                    $inventory->save();

                    Transaksi::updateOrCreate(
                        ['laporan_id' => $id, 'inventori_id' => $barangId],
                        [
                            'booking_id' => $laporan->booking_id,
                            'jumlah' => $kuantitasBaru,
                            'total' => $kuantitasBaru * $inventory->harga,
                        ]
                    );
                }
            }

            return redirect()->route('laporan.index')->with('success', 'Laporan berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error saat memperbarui laporan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui laporan. Silakan coba lagi.');
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\laporanbooking  $laporanbooking
     * @return \Illuminate\Http\Response
     */
    public function destroy(laporanbooking $laporanbooking)
    {
        //
    }
}
