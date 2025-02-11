<?php

namespace App\Http\Controllers;

use App\Models\Pekerja;

use App\Models\booking;
use App\Models\Inventori;
use App\Models\laporanbooking;
use App\Models\layanan;
use App\Models\transakasi_layanan;
use App\Models\Transaksi;
use App\Models\transaksi_layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PekerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pekerja  $pekerja
     * @return \Illuminate\Http\Response
     */
    public function show(Pekerja $pekerja)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pekerja  $pekerja
     * @return \Illuminate\Http\Response
     */
    public function edit(Pekerja $pekerja)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pekerja  $pekerja
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $laporan = laporanbooking::findOrFail($id);

            // Validasi data dari form
            // dd($request->all());

            $validatedData = $request->validate([
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
                'karyawan_id' => 'required|array',
                'karyawan_id.*' => 'exists:users,id',

            ]);

            // Removed for production
            // dd($validatedData);

            // Update laporan
            $laporan->update([
                'judul_laporan' => $validatedData['judul_laporan'],
                'deskripsi' => $validatedData['deskripsi'],
                'tanggal' => $validatedData['tanggal'],
                'status' => $validatedData['status'],
                'bukti' => $request->hasFile('bukti')
                    ? $request->file('bukti')->move(public_path('laporan'), $validatedData['judul_laporan'] . '_' . time() . '.' . $request->file('bukti')->getClientOriginalExtension())->getFilename()
                    : $laporan->bukti,
            ]);


            // Handle karyawan
            $existingKaryawan = Pekerja::where('laporan_id', $id)->get();
            $updatedKaryawanIds = $validatedData['karyawan_id'];

            foreach ($existingKaryawan as $karyawan) {
                if (!in_array($karyawan->user_id, $updatedKaryawanIds)) {
                    $karyawan->delete(); // Hapus karyawan yang tidak ada di input baru
                }
            }

            foreach ($validatedData['karyawan_id'] as $karyawanId) {
                Pekerja::updateOrCreate(
                    ['laporan_id' => $id, 'user_id' => $karyawanId],
                    ['laporan_id' => $id, 'user_id' => $karyawanId]
                );
            }


            // Handle layanan
            if (isset($validatedData['layanan_id'])) {
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

            $booking = Booking::find($laporan->booking_id);
            $booking->status = $validatedData['status'];
            if ($validatedData['status'] == 'Selesai') {
                $booking->tanggal = $validatedData['tanggal'];
            }
            $booking->save();
            return redirect()->route('laporan.index')->with('success', 'Laporan berhasil diperbarui.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error: ', $e->errors());
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error saat memperbarui laporan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui laporan. Silakan coba lagi.');
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pekerja  $pekerja
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pekerja $pekerja)
    {
        //
    }
}
