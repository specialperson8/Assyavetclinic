<?php

namespace App\Http\Controllers;

use App\Models\booking;
use App\Models\obat;
use App\Models\Transaksi;
use App\Models\Inventori;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookings = booking::with(['user', 'karyawan1', 'karyawan2', 'karyawan3'])->latest()->get();
        return view('daftarbooking', compact('bookings'));
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
            // Validate incoming data
            $validatedData = $request->validate([
                'kode_booking' => 'required|unique:bookings', // Adjust to match form field name
                'nama' => 'required',
                'nama_hewan' => 'required',
                'berat_hewan' => 'required',
                'jenis_hewan' => 'required',
                'alamat' => 'required',
                'telpon' => 'required',
                'tanggal' => 'required|date',
                'keluhan' => 'required',
                'dp' => 'nullable|numeric'
            ]);

            // Create a new Pemesanan record
            $pemesanan = new booking();
            $pemesanan->kode_booking = $validatedData['kode_booking'];
            $pemesanan->nama = $validatedData['nama'];
            $pemesanan->nama_hewan = $validatedData['nama_hewan'];
            $pemesanan->berat_hewan = $validatedData['berat_hewan'];
            $pemesanan->jenis_hewan = $validatedData['jenis_hewan'];
            $pemesanan->alamat = $validatedData['alamat'];
            $pemesanan->telpon = $validatedData['telpon'];
            $pemesanan->tanggal = $validatedData['tanggal'];
            $pemesanan->keluhan = $validatedData['keluhan'];
            $pemesanan->total = 0; // Default value (you can modify as needed)
            $pemesanan->status = 'Belum Selesai'; // Default status
            $pemesanan->dp = $validatedData['dp'] ?? 0; // Default value (you can modify as needed)

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
            return redirect()->route('booking.index')->with('success', 'Pemesanan berhasil ditambahkan');
        } catch (\Throwable $th) {
            // Log error and return error message
            Log::error('Error saat menambahkan pemesanan: ' . $th->getMessage());
            return redirect()->route('booking.index')->with('error', 'Pemesanan gagal ditambahkan');
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
            // Validate incoming data
            $validatedData = $request->validate([
                'nama' => 'required',
                'nama_hewan' => 'required',
                'berat_hewan' => 'required',
                'jenis_hewan' => 'required',
                'alamat' => 'required',
                'telpon' => 'required',
                'tanggal' => 'required|date',
                'keluhan' => 'required',
            ]);

            // Find the booking by ID
            $pemesanan = booking::findOrFail($id);

            // Update the booking record
            $pemesanan->nama = $validatedData['nama'];
            $pemesanan->nama_hewan = $validatedData['nama_hewan'];
            $pemesanan->berat_hewan = $validatedData['berat_hewan'];
            $pemesanan->jenis_hewan = $validatedData['jenis_hewan'];
            $pemesanan->alamat = $validatedData['alamat'];
            $pemesanan->telpon = $validatedData['telpon'];
            $pemesanan->tanggal = $validatedData['tanggal'];
            $pemesanan->keluhan = $validatedData['keluhan'];
            $pemesanan->total = $request->input('total'); // Assuming total is not being changed
            $pemesanan->status = $request->input('status'); // Assuming status is not being changed

            // Save the updated booking record to the database
            $pemesanan->save();

            // Redirect with success message
            return redirect()->route('booking.index')->with('success', 'Pemesanan berhasil diperbarui');
        } catch (\Throwable $th) {
            // Log error and return error message
            Log::error('Error saat memperbarui pemesanan: ' . $th->getMessage());
            return redirect()->route('booking.index')->with('error', 'Pemesanan gagal diperbarui');
        }
    }

    public function updateCatatan(Request $request, $id)
    {
        try {

            $validatedData = $request->validate([
                'catatan' => 'required|string',
                'diskon' => 'required|numeric',
                'editobat' => 'array',
                'editobat.*.nama_barang' => 'nullable|string',
                'editobat.*.jumlah' => 'nullable|numeric',
            ]);

            // Simpan perubahan obat ke dalam session tanpa mengubah database
            session()->put("editedObats.{$id}", $validatedData['editobat']);

            // Temukan pemesanan berdasarkan ID
            $pemesanan = Booking::findOrFail($id);
            $pemesanan->catatan = $validatedData['catatan'];
            $pemesanan->diskon = $validatedData['diskon'];
            $pemesanan->editobat = $validatedData['editobat'];

            // Simpan perubahan
            $pemesanan->save();

            return redirect()->route('booking-completed')->with('success', 'Informasi Pemesanan berhasil diperbarui');
        } catch (\Throwable $th) {
            Log::error('Error saat memperbarui pemesanan: ' . $th->getMessage());
            return redirect()->route('booking-completed')->with('error', 'Pemesanan gagal diperbarui');
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
            $item = booking::findOrFail($id); // Find the item by ID

            // Retrieve related transactions
            $transaksis = DB::table('transaksis')
                ->whereIn('laporan_id', function ($query) use ($id) {
                    $query->select('id')
                        ->from('laporanbookings')
                        ->where('booking_id', $id);
                })->get();

            // Return stock to inventory if inventory exists
            foreach ($transaksis as $transaksi) {
                $inventori = Inventori::find($transaksi->inventori_id);
                if ($inventori) {
                    $inventori->jumlah += $transaksi->jumlah;
                    $inventori->save();
                }
            }

            // Delete related records in transaksis table
            DB::table('transaksis')->whereIn('laporan_id', function ($query) use ($id) {
                $query->select('id')
                    ->from('laporanbookings')
                    ->where('booking_id', $id);
            })->delete();

            // Delete related records in transaksi_layanans table
            DB::table('transaksi_layanans')->whereIn('laporan_id', function ($query) use ($id) {
                $query->select('id')
                    ->from('laporanbookings')
                    ->where('booking_id', $id);
            })->delete();

            // Delete related records in pekerjas table
            DB::table('pekerjas')->whereIn('laporan_id', function ($query) use ($id) {
                $query->select('id')
                    ->from('laporanbookings')
                    ->where('booking_id', $id);
            })->delete();

            // Delete related records in laporanbookings table
            DB::table('laporanbookings')->where('booking_id', $id)->delete();

            $item->delete(); // Delete the item

            return redirect()->route('booking.index')->with('success', 'Item berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('booking.index')->with('error', 'Item gagal dihapus. Error: ' . $e->getMessage());
        }
    }
}
