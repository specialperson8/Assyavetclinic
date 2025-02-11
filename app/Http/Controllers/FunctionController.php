<?php

namespace App\Http\Controllers;

use App\Models\booking;
use App\Models\Inventori;
use App\Models\layanan;
use App\Models\transakasi_layanan;
use App\Models\Transaksi;
use App\Models\transaksi_layanan;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Mpdf\Mpdf;

class FunctionController extends Controller
{

    // Fungsi tambah booking 
    public function storebook(Request $request)
    {
        try {
            // Validate incoming data
            $validatedData = $request->validate([
                'kode_booking' => 'required|unique:bookings', // Adjust to match form field name
                'user_id' => 'required',
                'nama' => 'required',
                'nama_hewan' => 'required',
                'alamat' => 'required',
                'telpon' => 'required',
                'tanggal' => 'required|date',
                'keluhan' => 'required',
            ]);

            // Create a new Pemesanan record
            $pemesanan = new booking();
            $pemesanan->kode_booking = $validatedData['kode_booking'];
            $pemesanan->user_id = $validatedData['user_id'];
            $pemesanan->nama = $validatedData['nama'];
            $pemesanan->nama_hewan = $validatedData['nama_hewan'];
            $pemesanan->alamat = $validatedData['alamat'];
            $pemesanan->telpon = $validatedData['telpon'];
            $pemesanan->tanggal = $validatedData['tanggal'];
            $pemesanan->keluhan = $validatedData['keluhan'];
            $pemesanan->total = 0; // Default value (you can modify as needed)
            $pemesanan->status = 'Belum Selesai'; // Default status

            // Generate QR code using Endroid QR Code
            $result = Builder::create()
                ->writer(new PngWriter())
                ->data($validatedData['kode_booking']) // Use 'kode_booking' for the QR code data
                ->size(200)
                ->margin(10)
                ->build();

            // Set the path for storing the QR code
            $barcodeName = $validatedData['kode_booking'] . '.png';
            $barcodePath = public_path('book/' . $barcodeName);

            // Save the QR code to the public/book directory
            $result->saveToFile($barcodePath);

            // Save the Pemesanan model to the database
            $pemesanan->save();

            // Redirect with success message
            return redirect()->route('homepage')->with('success', 'Pemesanan berhasil ditambahkan');
        } catch (\Throwable $th) {
            // Log error and return error message
            Log::error('Error saat menambahkan pemesanan: ' . $th->getMessage());
            return redirect()->route('homepage')->with('error', 'Pemesanan gagal ditambahkan');
        }
    }

    public function storeinventori(Request $request)
    {
        try {
            $request->validate([
                'nama_barang' => 'required|string|max:255',
                'tanggal_pembuatan' => 'required|date',
                'harga' => 'required|integer',
                'satuan' => 'nullable|string|max:255',
                'jumlah' => 'required|integer',
            ]);
            Inventori::create([
                'nama_barang' => $request->nama_barang,
                'tanggal_pembuatan' => Carbon::parse($request->tanggal_pembuatan),
                'harga' => $request->harga,
                'satuan' => $request->satuan,
                'jumlah' => $request->jumlah,
            ]);
            return redirect()->route('inventori')->with('success', 'Barang berhasil ditambahkan di Inventori');
        } catch (\Illuminate\Validation\ValidationException | \Exception $e) {
            Log::error('Error saat menambahkan barang di inventori: ' . $e->getMessage());
            return redirect()->route('inventori')->with('error', 'Mohon maaf barang gagal ditambahkan di Inventori');
        }
    }

    // Fungsi tambah akun karyawan
    public function storeakunkaryawan(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'role' => 'required|string',
            ]);
            // dd($request->all());

            User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role ?? 'karyawan',
            ]);
            return redirect()->route('karyawan')->with('success', 'Akun karyawan berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException | \Exception $e) {
            Log::error('Error saat menambahkan akun karyawan: ' . $e->getMessage());
            return redirect()->route('karyawan')->with('error', 'Akun karyawan gagal ditambahkan');
        }
    }

    public function storeuser(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'role' => 'required|string',
            ]);
            // dd($request->all());

            User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role ?? 'karyawan',
            ]);
            return redirect()->route('homepage')->with('success', 'Akun karyawan berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException | \Exception $e) {
            Log::error('Error saat menambahkan akun karyawan: ' . $e->getMessage());
            return redirect()->route('homepage')->with('error', 'Akun karyawan gagal ditambahkan');
        }
    }

    //fungsi tambah layanan
    public function storelayanan(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:255',
                'jenis' => 'required|string|max:255',
                'harga' => 'required|integer',
            ]);
            layanan::create([
                'nama' => $request->nama,
                'jenis' => $request->jenis,
                'harga' => $request->harga,
            ]);
            return redirect()->route('layanan')->with('success', 'Layanan berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException | \Exception $e) {
            return redirect()->route('layanan')->with('error', 'Layanan gagal ditambahkan');
        }
    }

    //fungsi tambah pengambilan barang 
    public function storetransaksi(Request $request)
    {
        try {
            $request->validate([
                'booking_id' => 'required|exists:bookings,id',
                'inventori_id' => 'required|exists:inventoris,id',
                'jumlah' => 'required|integer|min:1',
                'total' => 'required|integer|min:0',
            ]);

            // Reduce inventory stock
            $inventori = Inventori::find($request->inventori_id);
            if ($inventori->jumlah < $request->jumlah) {
                return back()->with('error', 'Mohon Maaf, stok barang tidak mencukupi');
            }
            $inventori->jumlah -= $request->jumlah;
            $inventori->save();

            // Save new transaction
            Transaksi::create([
                'booking_id' => $request->booking_id,
                'inventori_id' => $request->inventori_id,
                'jumlah' => $request->jumlah,
                'total' => $request->total,
            ]);

            return redirect()->route('manajemen-stok')->with('success', 'Transaction saved and stock updated successfully');
            Log::info('Transaction saved and stock updated successfully');
        } catch (\Illuminate\Validation\ValidationException | \Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Mohon Maaf, stok barang tidak mencukupi');
        }
    }

    //fungsi update ambil barang
    public function updatetransaksi(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'inventori_id' => 'required|exists:inventoris,id',
            'penambahan' => 'nullable|integer|min:0',
            'pengurangan' => 'nullable|integer|min:0',
            'totalpenambahan' => 'nullable|numeric|min:0',
            'totalpengurangan' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $inventori = Inventori::find($request->inventori_id);
            $transaksi = Transaksi::where('booking_id', $request->booking_id)
                ->where('inventori_id', $request->inventori_id)
                ->first();

            if (!$inventori || !$transaksi) {
                return back()->withErrors(['message' => 'Inventori atau Transaksi tidak ditemukan']);
            }

            $jumlah_sebelumnya = $transaksi->jumlah;
            $penambahan = $request->penambahan ?? 0;
            $pengurangan = $request->pengurangan ?? 0;

            // Hitung jumlah baru
            $jumlah_baru = $jumlah_sebelumnya + $penambahan - $pengurangan;

            // Total penambahan dan pengurangan dari input
            $total_penambahan = $request->totalpenambahan ?? 0;
            $total_pengurangan = $request->totalpengurangan ?? 0;

            // Hitung total baru
            $total = $transaksi->total + $total_penambahan - $total_pengurangan;

            // Update stok inventori
            if ($penambahan > 0 && $inventori->jumlah < $penambahan) {
                return back()->withErrors(['jumlah' => 'Stok tidak mencukupi untuk penambahan']);
            }

            if ($penambahan > 0) {
                $inventori->jumlah -= $penambahan;
            }
            if ($pengurangan > 0) {
                $inventori->jumlah += $pengurangan;
            }

            $inventori->save();

            $transaksi->update([
                'jumlah' => $jumlah_baru,
                'total' => $total,
            ]);

            DB::commit();

            return redirect()->route('manajemen-stok')->with('success', 'Transaksi diperbarui dan stok disesuaikan dengan sukses');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['message' => 'Kesalahan saat memperbarui transaksi: ' . $e->getMessage()]);
        }
    }


    //fungsi update akun karyawan
    public function updateakunkaryawan(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        try {
            $user = User::findOrFail($id);
            $user->name = $validatedData['nama'];
            $user->email = $validatedData['email'];
            $user->password = Hash::make($validatedData['password']);
            $user->save();

            return redirect()->route('karyawan')->with('success', 'Data karyawan berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->route('karyawan')->with('error', 'Mohon maaf pastikan semua input telah kamu isi ya');
        }
    }

    //fungsi update barang inventori 
    public function updateinventori(Request $request, $id)
    {
        try {
            $request->validate([
                'nama_barang' => 'required|string|max:255',
                'tanggal_pembuatan' => 'required|date',
                'harga' => 'required|integer',
                'jumlah' => 'required|integer',
                'satuan' => 'nullable|string|max:255',
            ]);
            $inventori = Inventori::findOrFail($id);
            $inventori->nama_barang = $request->nama_barang;
            $inventori->tanggal_pembuatan = Carbon::parse($request->tanggal_pembuatan);
            $inventori->harga = $request->harga;
            $inventori->jumlah = $request->jumlah;
            $inventori->satuan = $request->satuan;
            $inventori->save();

            return redirect()->route('inventori')->with('success', 'Data inventori berhasil diperbarui');
        } catch (\Illuminate\Validation\ValidationException | \Exception $e) {
            return redirect()->route('inventori')->with('error', 'Mohon maaf data inventori gagal diperbarui');
        }
    }

    //fungsi update status booking    
    public function updatestatusbooking(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|string',
                'karyawan1' => 'required|string',
                'karyawan2' => 'nullable|string',
                'karyawan3' => 'nullable|string',
                'nama' => 'required|string',
                'namahewan' => 'required|string',
                'berat' => 'required|numeric',
                'jenis' => 'required|string',
                'tanggal' => 'required|date',
                'dp' => 'nullable|numeric',
                'vaksin' => 'nullable|string',
                'vaksin_kuantitas' => 'nullable|numeric',
                'vaksin_harga' => 'nullable|numeric',
                'grooming' => 'nullable|string',
                'grooming_kuantitas' => 'nullable|numeric',
                'grooming_harga' => 'nullable|numeric',
                'operasi' => 'nullable|string',
                'operasi_kuantitas' => 'nullable|numeric',
                'operasi_harga' => 'nullable|numeric',
                'lainnya' => 'nullable|string',
                'lainnya_kuantitas' => 'nullable|numeric',
                'lainnya_harga' => 'nullable|numeric',
                'jasa_dokter' => 'nullable|string',
                'jasa_dokter_kuantitas' => 'nullable|numeric',
                'jasa_dokter_harga' => 'nullable|numeric',
                'diagnosa_penunjang' => 'nullable|string',
                'diagnosa_penunjang_kuantitas' => 'nullable|numeric',
                'diagnosa_penunjang_harga' => 'nullable|numeric',
                'transportasi' => 'nullable|string',
                'transportasi_kuantitas' => 'nullable|numeric',
                'transport_harga' => 'nullable|numeric',
                'total_transport' => 'nullable|numeric',
            ]);

            $booking = Booking::findOrFail($id);
            $booking->status = $request->status;
            $booking->karyawan1 = $request->karyawan1;
            $booking->karyawan2 = $request->karyawan2;
            $booking->karyawan3 = $request->karyawan3;
            $booking->nama = $request->nama;
            $booking->namahewan = $request->namahewan;
            $booking->berat = $request->berat;
            $booking->jenishewan = $request->jenis;
            $booking->tanggal = Carbon::parse($request->tanggal);
            $booking->dp = $request->dp;
            $booking->vaksin = $request->vaksin;
            $booking->vaksin_kuantitas = $request->vaksin_kuantitas;
            $booking->vaksin_harga = $request->vaksin_harga;
            $booking->grooming = $request->grooming;
            $booking->grooming_kuantitas = $request->grooming_kuantitas;
            $booking->grooming_harga = $request->grooming_harga;
            $booking->operasi = $request->operasi;
            $booking->operasi_kuantitas = $request->operasi_kuantitas;
            $booking->operasi_harga = $request->operasi_harga;
            $booking->lainnya = $request->lainnya;
            $booking->lainnya_kuantitas = $request->lainnya_kuantitas;
            $booking->lainnya_harga = $request->lainnya_harga;
            $booking->jasa_dokter = $request->jasa_dokter;
            $booking->jasa_dokter_kuantitas = $request->jasa_dokter_kuantitas;
            $booking->jasa_dokter_harga = $request->jasa_dokter_harga;
            $booking->diagnosa_penunjang = $request->diagnosa_penunjang;
            $booking->diagnosa_penunjang_kuantitas = $request->diagnosa_penunjang_kuantitas;
            $booking->diagnosa_penunjang_harga = $request->diagnosa_penunjang_harga;
            $booking->transportasi = $request->transportasi;
            $booking->transportasi_kuantitas = $request->transportasi_kuantitas;
            $booking->transport_harga = $request->transport_harga;
            $booking->total_trasport = $request->total_transport;

            $booking->save();

            return redirect()->route('booking-uncompleted')->with('success', 'Status booking berhasil diubah');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error: ' . $e->getMessage(), ['errors' => $e->errors()]);
            return redirect()->route('booking-uncompleted')->with('error', 'Data yang diberikan tidak valid.');
        } catch (\Exception $e) {
            Log::error('General error: ' . $e->getMessage());
            return redirect()->route('booking-uncompleted')->with('error', 'Mohon maaf status booking gagal diubah.');
        }
    }


    //fungsi update layanan
    public function updatelayanan(Request $request, $id)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:255',
                'jenis' => 'required|string|max:255',
                'harga' => 'required|integer',
            ]);
            $layanan = layanan::findOrFail($id);
            $layanan->nama = $request->nama;
            $layanan->jenis = $request->jenis;
            $layanan->harga = $request->harga;
            $layanan->save();

            return redirect()->route('layanan')->with('success', 'Data layanan berhasil diperbarui');
        } catch (\Illuminate\Validation\ValidationException | \Exception $e) {
            return redirect()->route('layanan')->with('error', 'Mohon maaf data layanan gagal diperbarui');
        }
    }

    //fungsi delete akun karyawan
    public function deleteakunkaryawan($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect()->route('karyawan')->with('success', 'Data karyawan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('karyawan')->with('error', 'Mohon Maaf Data karyawan gagal dihapus');
        }
    }

    //fungsi delete barang inventori
    public function deleteinventori($id)
    {
        try {
            $inventori = Inventori::findOrFail($id);
            $inventori->delete();
            return redirect()->route('inventori')->with('success', 'Barang berhasil dihapus dari inventori');
        } catch (\Exception $e) {
            return redirect()->route('inventori')->with('error', 'Mohon Maaf barang gagal dihapus dari inventori');
        }
    }

    //fungsi delete layanan
    public function deletelayanan($id)
    {
        try {
            $layanan = layanan::findOrFail($id);
            $layanan->delete();
            return redirect()->route('layanan')->with('success', 'Layanan berhasil dihapus');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('layanan')->with('error', 'Mohon Maaf layanan gagal dihapus');
        }
    }

    public function deleteItem($id)
    {
        // Ambil data transaksi berdasarkan ID
        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return redirect()->route('manajemen-stok')->withErrors(['message' => 'Transaksi tidak ditemukan']);
        }

        // Ambil data inventori berdasarkan ID dari transaksi
        $inventori = Inventori::find($transaksi->inventori_id);

        if ($inventori) {
            // Tambahkan jumlah inventori sesuai dengan jumlah dari transaksi
            $inventori->jumlah += $transaksi->jumlah;
            $inventori->save();
        }

        // Hapus transaksi
        $transaksi->delete();

        return redirect()->route('manajemen-stok')->with('success', 'Item berhasil dihapus dan inventori diperbarui');
    }

    //fungsi export PDF
    public function exportPDF($id)
    {
        // Ambil data transaksi berdasarkan ID
        $transaksi = booking::where('id', $id)->with('user')->first();
        $inventori = Inventori::all();
        $layanan = transaksi_layanan::where('booking_id', $id)->with('layanan')->get();
        $obat = Transaksi::where('booking_id', $id)->with('inventori')->get();
        $totalTransaksi = Transaksi::where('booking_id', $id)->sum('total');
        $totalHarga = transaksi_layanan::where('booking_id', $id)->sum('total');

        $pembayaran = $totalTransaksi +  $totalHarga - $transaksi->dp - $transaksi->diskon;


        if (!$transaksi) {
            return redirect()->route('manajemen-stok')->withErrors(['message' => 'Transaksi tidak ditemukan']);
        }

        if (!$obat) {
            return redirect()->route('manajemen-stok')->withErrors(['message' => 'Obat tidak ditemukan']);
        }


        // Kirim data ke view dan render menjadi string
        $html = view('pdf.nota', compact('transaksi', 'obat', 'totalTransaksi', 'totalHarga', 'pembayaran', 'layanan'))->render();

        // Inisialisasi Dompdf
        $pdf = Pdf::loadHTML($html)
            ->setPaper([0, 0, 315, 1100], 'portrait'); // 315 = 11 cm (dalam poin), 9999 untuk panjang dinamis

        $pdf->set_option('isHtml5ParserEnabled', true)

            ->set_option('isRemoteEnabled', true);


        // Output PDF ke browser
        return $pdf->stream('Nota Pembayaran.pdf');
    }
}
