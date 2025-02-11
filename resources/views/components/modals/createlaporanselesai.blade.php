@foreach ($booking as $item)
<div class="modal fade" id="buatlaporan-{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="tambahbookTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header text-white ">
                <h5 class="modal-title" id="tambahbookTitle">Menu Laporan Perawatan Hewan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('laporanprogres') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Booking Selection -->
                    {{-- <div class="mb-4">
                        <label for="booking_id" class="form-label">Pilih Booking yang ingin dilaporkan</label>
                        <select name="booking_id" class="form-control" id="booking_id" required>
                            <option value="" disabled selected>Pilih Booking</option>
                            @foreach($bookings as $booking)
                                <option value="{{ $booking->id }}">{{ $booking->kode_booking }} - {{ $booking->nama }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                    <input type="hidden" name="booking_id" class="form-control" id="booking_id"  value="{{$item->id}}" required>

                    <!-- General Laporan Details -->
                    <div class="mb-4">
                        <label for="judul_laporan" class="form-label">Judul Laporan</label>
                        <input type="text" name="judul_laporan" class="form-control" id="judul_laporan" placeholder="Judul laporan (misal: Perawatan Mingguan)" required>
                    </div>

                    <div class="mb-4">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" id="deskripsi" placeholder="Deskripsi laporan perawatan hewan" rows="3" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="tanggal" class="form-label">Tanggal Laporan</label>
                        <input type="date" name="tanggal" class="form-control" id="tanggal" required>
                    </div>

                    <div class="mb-4">
                        <label for="bukti" class="form-label">Bukti Pekerjaan (Opsional)</label>
                        <input type="file" name="bukti" class="form-control" id="bukti" accept=".jpg,.jpeg,.png,.pdf">
                    </div>

                   <input type="hidden" name="status" class="form-control" id="status" value="Selesai" >
                   <hr class="my-4">

<h5 class="text mb-3">Karyawan yang Mengerjakan</h5>

<div id="karyawan-container-{{$item->id}}">
    <!-- Input untuk Karyawan 1 -->
    <div class="mb-4 d-none karyawan-item" id="karyawan-item-1">
        <label for="karyawan1" class="form-label">Karyawan 1</label>
        <select name="karyawan1" class="form-control" id="karyawan1">
            <option value="" disabled selected>Pilih Karyawan</option>
            @foreach($karyawans as $karyawan)
                <option value="{{ $karyawan->id }}">{{ $karyawan->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Input untuk Karyawan 2 -->
    <div class="mb-4 d-none karyawan-item" id="karyawan-item-2">
        <label for="karyawan2" class="form-label">Karyawan 2</label>
        <select name="karyawan2" class="form-control" id="karyawan2">
            <option value="" disabled selected>Pilih Karyawan</option>
            @foreach($karyawans as $karyawan)
                <option value="{{ $karyawan->id }}">{{ $karyawan->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Input untuk Karyawan 3 -->
    <div class="mb-4 d-none karyawan-item" id="karyawan-item-3">
        <label for="karyawan3" class="form-label">Karyawan 3</label>
        <select name="karyawan3" class="form-control" id="karyawan3">
            <option value="" disabled selected>Pilih Karyawan</option>
            @foreach($karyawans as $karyawan)
                <option value="{{ $karyawan->id }}">{{ $karyawan->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<!-- Tombol untuk Menambah/Mengurangi Input Karyawan -->
<div class="mb-3">
    <button type="button" class="btn btn-primary mb-2 add-karyawan">Tambah Karyawan</button>
    <button type="button" class="btn btn-danger mb-2 d-none remove-karyawan">Hapus Karyawan</button>
</div>


                    <hr class="my-4">

                    <!-- Section Layanan -->
                    <h5 class="text-primary mb-3">Layanan yang Digunakan</h5>
                    <div id="layanan-container-{{$item->id}}"></div>
                    <button type="button" class="btn btn-primary px-4 py-2 mb-2 add-layanan">
                        Tambah Layanan
                    </button>

                    <hr class="my-4">

                    <!-- Section Barang -->
                    <h5 class="text-success mb-3">Barang yang Diambil</h5>
                    <div id="barang-container-{{$item->id}}"></div>
                    <button type="button" class="btn btn-success px-4 py-2 mb-2 add-barang">
                        Tambah Barang
                    </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Buat Laporan</button>
            </form>
            </div>
        </div>
    </div>
</div>

<!-- Template for Layanan -->
<template id="layanan-template">
    <div class="card mb-3 layanan-item shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h6 class="card-title">Layanan</h6>
                <button type="button" class="btn btn-sm btn-danger remove-layanan">Hapus</button>
            </div>
            <div class="mb-3">
                <label for="layanan_id" class="form-label">Layanan</label>
                <select name="layanan_id[]" class="form-control layanan-select" required>
                    <option value="" disabled selected>Pilih Layanan</option>
                    @foreach($layanans as $layanan)
                        <option value="{{ $layanan->id }}" data-harga="{{ $layanan->harga }}">
                            {{ $layanan->nama }} - Rp {{ number_format($layanan->harga, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="kuantitas" class="form-label">Kuantitas</label>
                <input type="number" name="kuantitas[]" class="form-control kuantitas-input" placeholder="Jumlah layanan yang digunakan" min="1" required>
            </div>

            <div class="mb-3">
                <label for="total_harga" class="form-label">Total Harga</label>
                <input type="text" class="form-control total-harga-input" placeholder="Total harga akan dihitung otomatis" readonly>
                <input type="hidden" name="total_harga_pure[]" class="total-harga-pure-input">
            </div>
        </div>
    </div>
</template>

<!-- Template for Barang -->
<template id="barang-template">
    <div class="card mb-3 barang-item shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h6 class="card-title">Barang</h6>
                <button type="button" class="btn btn-sm btn-danger remove-barang">Hapus</button>
            </div>
            <div class="mb-3">
                <label for="inventori_id" class="form-label">Barang</label>
                <select name="inventori_id[]" class="form-control barang-select" required>
                    <option value="" disabled selected>Pilih Barang</option>
                    @foreach($inventories as $inventory)
                        <option value="{{ $inventory->id }}" data-stok="{{ $inventory->jumlah }}" data-harga="{{ $inventory->harga }}">
                            {{ $inventory->nama_barang }} - Stok: {{ $inventory->jumlah }} - Harga: Rp {{ number_format($inventory->harga, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="kuantitas_barang" class="form-label">Kuantitas</label>
                <input type="number" name="kuantitas_barang[]" class="form-control kuantitas-barang-input" placeholder="Jumlah barang yang diambil" min="1" required>
                <small class="text-danger d-none kuantitas-error">Mohon maaf, kuantitas barang tidak mencukupi.</small>
            </div>

            <div class="mb-3">
                <label for="total_harga_barang" class="form-label">Total Harga</label>
                <input type="text" class="form-control total-harga-barang-input" placeholder="Total harga akan dihitung otomatis" readonly>
                <input type="hidden" name="total_harga_barang[]" class="total-harga-barang-pure-input">
            </div>
        </div>
    </div>
</template>
@endforeach

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Event delegation for Layanan
    document.body.addEventListener('click', function (event) {
        if (event.target.classList.contains('add-layanan')) {
            const modal = event.target.closest('.modal');
            const layananContainer = modal.querySelector('[id^="layanan-container-"]');
            const template = document.getElementById('layanan-template').content.cloneNode(true);
            const layananItem = template.querySelector('.layanan-item');
            layananContainer.appendChild(layananItem);
            attachEventListenersToLayananInputs(layananItem);
        }
    });

    // Event delegation for Barang
    document.body.addEventListener('click', function (event) {
        if (event.target.classList.contains('add-barang')) {
            const modal = event.target.closest('.modal');
            const barangContainer = modal.querySelector('[id^="barang-container-"]');
            const template = document.getElementById('barang-template').content.cloneNode(true);
            const barangItem = template.querySelector('.barang-item');
            barangContainer.appendChild(barangItem);
            attachEventListenersToBarangInputs(barangItem);
        }
    });

    // Event delegation for Karyawan
    document.body.addEventListener('click', function (event) {
        if (event.target.classList.contains('add-karyawan')) {
            const modal = event.target.closest('.modal');
            const karyawanContainer = modal.querySelector('[id^="karyawan-container-"]');
            const maxKaryawan = 3;
            let currentKaryawanCount = karyawanContainer.querySelectorAll('.karyawan-item:not(.d-none)').length;

            if (currentKaryawanCount < maxKaryawan) {
                currentKaryawanCount++;
                const karyawanItem = karyawanContainer.querySelector(`#karyawan-item-${currentKaryawanCount}`);
                if (karyawanItem) {
                    karyawanItem.classList.remove('d-none');
                }

                if (currentKaryawanCount > 0) {
                    modal.querySelector('.remove-karyawan').classList.remove('d-none');
                }

                if (currentKaryawanCount === maxKaryawan) {
                    event.target.classList.add('d-none');
                }
            }
        }

        if (event.target.classList.contains('remove-karyawan')) {
            const modal = event.target.closest('.modal');
            const karyawanContainer = modal.querySelector('[id^="karyawan-container-"]');
            let currentKaryawanCount = karyawanContainer.querySelectorAll('.karyawan-item:not(.d-none)').length;

            if (currentKaryawanCount > 0) {
                const karyawanItem = karyawanContainer.querySelector(`#karyawan-item-${currentKaryawanCount}`);
                if (karyawanItem) {
                    karyawanItem.classList.add('d-none');
                    karyawanItem.querySelector('select').value = '';
                }
                currentKaryawanCount--;

                if (currentKaryawanCount === 0) {
                    event.target.classList.add('d-none');
                }

                if (currentKaryawanCount < 3) {
                    modal.querySelector('.add-karyawan').classList.remove('d-none');
                }
            }
        }
    });

    function attachEventListenersToLayananInputs(layananItem) {
        const layananSelect = layananItem.querySelector('.layanan-select');
        const kuantitasInput = layananItem.querySelector('.kuantitas-input');
        const totalHargaInput = layananItem.querySelector('.total-harga-input');
        const totalHargaPureInput = layananItem.querySelector('.total-harga-pure-input');

        layananSelect.addEventListener('change', function () {
            calculateLayananTotal(layananSelect, kuantitasInput, totalHargaInput, totalHargaPureInput);
        });

        kuantitasInput.addEventListener('input', function () {
            calculateLayananTotal(layananSelect, kuantitasInput, totalHargaInput, totalHargaPureInput);
        });

        layananItem.querySelector('.remove-layanan').addEventListener('click', function () {
            layananItem.remove();
        });
    }

    function calculateLayananTotal(layananSelect, kuantitasInput, totalHargaInput, totalHargaPureInput) {
        const selectedLayanan = layananSelect.options[layananSelect.selectedIndex];
        const harga = parseFloat(selectedLayanan.getAttribute('data-harga')) || 0;
        const kuantitas = parseInt(kuantitasInput.value) || 0;

        const totalHarga = harga * kuantitas;

        totalHargaInput.value = totalHarga.toLocaleString('id-ID', {
            style: 'currency',
            currency: 'IDR',
        });

        totalHargaPureInput.value = totalHarga;
    }

    function attachEventListenersToBarangInputs(barangItem) {
        const barangSelect = barangItem.querySelector('.barang-select');
        const kuantitasInput = barangItem.querySelector('.kuantitas-barang-input');
        const totalHargaInput = barangItem.querySelector('.total-harga-barang-input');
        const totalHargaPureInput = barangItem.querySelector('.total-harga-barang-pure-input');
        const errorElement = barangItem.querySelector('.kuantitas-error');

        barangSelect.addEventListener('change', function () {
            calculateBarangTotal(barangSelect, kuantitasInput, totalHargaInput, totalHargaPureInput, errorElement);
        });

        kuantitasInput.addEventListener('input', function () {
            calculateBarangTotal(barangSelect, kuantitasInput, totalHargaInput, totalHargaPureInput, errorElement);
        });

        barangItem.querySelector('.remove-barang').addEventListener('click', function () {
            barangItem.remove();
        });
    }

    function calculateBarangTotal(barangSelect, kuantitasInput, totalHargaInput, totalHargaPureInput, errorElement) {
        const selectedBarang = barangSelect.options[barangSelect.selectedIndex];
        const stok = parseInt(selectedBarang.getAttribute('data-stok')) || 0;
        const harga = parseFloat(selectedBarang.getAttribute('data-harga')) || 0;
        const kuantitas = parseInt(kuantitasInput.value) || 0;

        if (kuantitas > stok) {
            errorElement.classList.remove('d-none');
        } else {
            errorElement.classList.add('d-none');
        }

        const totalHarga = harga * kuantitas;

        totalHargaInput.value = totalHarga.toLocaleString('id-ID', {
            style: 'currency',
            currency: 'IDR',
        });

        totalHargaPureInput.value = totalHarga;
    }
});
</script>