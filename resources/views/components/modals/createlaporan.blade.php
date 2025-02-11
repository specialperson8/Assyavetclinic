<div class="modal fade" id="buatlaporan" tabindex="-1" role="dialog" aria-labelledby="tambahbookTitle" aria-hidden="true">
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
                    <div class="mb-4">
                        <label for="booking_id" class="form-label">Pilih Booking yang ingin dilaporkan</label>
                        <select name="booking_id" class="form-control" id="booking_id" required>
                            <option value="" disabled selected>Pilih Booking</option>
                            @foreach($bookings as $booking)
                                <option value="{{ $booking->id }}">{{ $booking->kode_booking }} - {{ $booking->nama }}</option>
                            @endforeach
                        </select>
                    </div>

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

                    {{-- <img src="{{dirname(base_path()) . '/testing/laporan/1.jpg'}}" alt=""> --}}
                   {{-- <img src="{{$image}}" alt=""> --}}

                    <div class="mb-4">
                        <label for="bukti" class="form-label">Bukti Pekerjaan (Opsional)</label>
                        <input type="file" name="bukti" class="form-control" id="bukti" accept=".jpg,.jpeg,.png,.pdf">
                    </div>

                    <div class="mb-4">
                        <label for="status" class="form-label">Status Laporan</label>
                        <select name="status" class="form-control" id="status" required>
                            <option value="" disabled selected>Pilih Status</option>
                            <option value="Selesai">Selesai</option>
                            <option value="Proses Perawatan">Proses Perawatan</option>
                        </select>
                    </div>

                    <input type="hidden" name="karyawan1" value="{{ Auth::user()->id }}" >

                    <hr class="my-4">

                    <!-- Section Layanan -->
                    <h5 class="text-primary mb-3">Layanan yang Digunakan</h5>
                    <div id="layanan-container"></div>
                    <button type="button" id="add-layanan" class="btn btn-primary px-4 py-2 mb-2">
                        Tambah Layanan
                    </button>

                    <hr class="my-4">

                    <!-- Section Barang -->
                    <h5 class="text-success mb-3">Barang yang Diambil</h5>
                    <div id="barang-container"></div>
                    <button type="button" id="add-barang" class="btn btn-success px-4 py-2 mb-2">
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
                <select name="layanan_id[]" class="form-control layanan-select">
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
                <input type="number" name="kuantitas[]" class="form-control kuantitas-input" placeholder="Jumlah layanan yang digunakan" min="1">
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
                <select name="inventori_id[]" class="form-control barang-select">
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
                <input type="number" name="kuantitas_barang[]" class="form-control kuantitas-barang-input" placeholder="Jumlah barang yang diambil" min="1">
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Section Layanan
        const layananContainer = document.getElementById('layanan-container');
        const addLayananButton = document.getElementById('add-layanan');

        addLayananButton.addEventListener('click', function () {
            const template = document.getElementById('layanan-template').content.cloneNode(true);
            const layananItem = template.querySelector('.layanan-item');
            layananContainer.appendChild(layananItem);
            attachEventListenersToLayananInputs(layananItem);
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

        // Section Barang
        const barangContainer = document.getElementById('barang-container');
        const addBarangButton = document.getElementById('add-barang');

        addBarangButton.addEventListener('click', function () {
            const template = document.getElementById('barang-template').content.cloneNode(true);
            const barangItem = template.querySelector('.barang-item');
            barangContainer.appendChild(barangItem);
            attachEventListenersToBarangInputs(barangItem);
        });

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