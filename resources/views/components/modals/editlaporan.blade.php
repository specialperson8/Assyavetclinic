@foreach ($laporan as $item)
<div class="modal fade" id="editlaporan-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="editLaporanTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header text-white">
                <h5 class="modal-title" id="editLaporanTitle">Menu Laporan Perawatan Hewan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('laporan.update', ['id' => $item->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- General Laporan Details -->
                    <div class="mb-4">
                        <label for="judul_laporan" class="form-label">Judul Laporan</label>
                        <input type="text" name="judul_laporan" class="form-control" id="judul_laporan" placeholder="Judul laporan (misal: Perawatan Mingguan)" value="{{ $item->judul_laporan }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" id="deskripsi" placeholder="Deskripsi laporan perawatan hewan" rows="3" required>{{ $item->deskripsi }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="tanggal" class="form-label">Tanggal Laporan</label>
                        <input type="date" name="tanggal" class="form-control" id="tanggal" value="{{ $item->tanggal }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="bukti" class="form-label">Bukti Pekerjaan (Opsional)</label>
                        <input type="file" name="bukti" class="form-control" id="bukti" accept=".jpg,.jpeg,.png,.pdf">
                    </div>

                    <div class="mb-4">
                        <label for="status" class="form-label">Status Laporan</label>
                        <select name="status" class="form-control" id="status" required>
                            <option value="" disabled>Pilih Status</option>
                            <option value="sedang perawatan" {{ $item->booking->status == 'sedang perawatan' ? 'selected' : '' }}>sedang perawatan</option>
                            <option value="Selesai" {{$item->booking->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>

                        </select>
                    </div>

                    <hr class="my-4">

                    <!-- Section Layanan -->
                    <h5 class="text-primary mb-3">Layanan yang Digunakan</h5>
                    <div id="layanan-container-{{ $item->id }}">
                        @foreach ($item->layanans as $layanan)
                        <div class="card mb-3 layanan-item shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h6 class="card-title">Layanan</h6>
                                    <button type="button" class="btn btn-sm btn-danger remove-layanan">Hapus</button>
                                </div>
                                <div class="mb-3">
                                    <label for="layanan_id" class="form-label">Layanan</label>
                                    <select name="layanan_id[]" class="form-control layanan-select">
                                        <option value="" disabled>Pilih Layanan</option>
                                        @foreach ($layanans as $layananOption)
                                        <option value="{{ $layananOption->id }}" 
                                            data-harga="{{ $layananOption->harga }}"
                                            {{ $layananOption->id == $layanan->layanan_id ? 'selected' : '' }}>
                                            {{ $layananOption->nama }} - Rp {{ number_format($layananOption->harga, 0, ',', '.') }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="kuantitas" class="form-label">Kuantitas</label>
                                    <input type="number" name="kuantitas[]" class="form-control kuantitas-input" value="{{ $layanan->jumlah }}" min="1" required>
                                </div>
                                <div class="mb-3">
                                    <label for="total_harga" class="form-label">Total Harga</label>
                                    <input type="text" class="form-control total-harga-input" value="{{ number_format($layanan->total, 0, ',', '.') }}" readonly>
                                    <input type="hidden" name="total_harga_pure[]" value="{{ $layanan->total_harga }}">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" id="add-layanan-{{ $item->id }}" class="btn btn-primary px-4 py-2 mb-2">
                        Tambah Layanan
                    </button>

                    <hr class="my-4">

                    <!-- Section Barang -->
                    <h5 class="text-success mb-3">Barang yang Diambil</h5>
                    <div id="barang-container-{{ $item->id }}">
                        @foreach ($item->barangs as $barang)
                        <div class="card mb-3 barang-item shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h6 class="card-title">Barang</h6>
                                    <button type="button" class="btn btn-sm btn-danger remove-barang">Hapus</button>
                                </div>
                                <div class="mb-3">
                                    <label for="inventori_id" class="form-label">Barang</label>
                                    <select name="inventori_id[]" class="form-control barang-select" required>
                                        <option value="" disabled>Pilih Barang</option>
                                        @foreach ($inventories as $inventory)
                                        <option value="{{ $inventory->id }}" 
                                            data-stok="{{ $inventory->jumlah }}" 
                                            data-harga="{{ $inventory->harga }}"
                                            {{ $inventory->id == $barang->inventori_id ? 'selected' : '' }}>
                                            {{ $inventory->nama_barang }} - Stok: {{ $inventory->jumlah }} - Harga: Rp {{ number_format($inventory->harga, 0, ',', '.') }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="kuantitas_barang" class="form-label">Kuantitas</label>
                                    <input type="number" name="kuantitas_barang[]" class="form-control kuantitas-barang-input" value="{{ $barang->jumlah }}" min="1" required>
                                    <small class="text-danger d-none kuantitas-error">Mohon maaf, kuantitas barang tidak mencukupi.</small>
                                </div>
                                <div class="mb-3">
                                    <label for="total_harga_barang" class="form-label">Total Harga</label>
                                    <input type="text" class="form-control total-harga-barang-input" value="{{ number_format($barang->total, 0, ',', '.') }}" readonly>
                                    <input type="hidden" name="total_harga_barang[]" value="{{ $barang->total_harga }}">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" id="add-barang-{{ $item->id }}" class="btn btn-success px-4 py-2 mb-2">
                        Tambah Barang
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Perbarui Laporan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

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
                <input type="number" name="kuantitas[]" class="form-control kuantitas-input" min="1" required>
            </div>
            <div class="mb-3">
                <label for="total_harga" class="form-label">Total Harga</label>
                <input type="text" class="form-control total-harga-input" readonly>
                <input type="hidden" name="total_harga_pure[]" class="total-harga-pure-input">
            </div>
        </div>
    </div>
</template>

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
                <input type="number" name="kuantitas_barang[]" class="form-control kuantitas-barang-input" min="1" required>
                <small class="text-danger d-none kuantitas-error">Mohon maaf, kuantitas barang tidak mencukupi.</small>
            </div>
            <div class="mb-3">
                <label for="total_harga_barang" class="form-label">Total Harga</label>
                <input type="text" class="form-control total-harga-barang-input" readonly>
                <input type="hidden" name="total_harga_barang[]" class="total-harga-barang-pure-input">
            </div>
        </div>
    </div>
</template>


<script>
 document.addEventListener('DOMContentLoaded', function () {
    // Tambah Layanan
    document.querySelectorAll('[id^="add-layanan-"]').forEach(function (button) {
        button.addEventListener('click', function () {
            const containerId = this.id.replace('add-layanan-', 'layanan-container-');
            const container = document.getElementById(containerId);
            const layananTemplate = document.getElementById('layanan-template').content.cloneNode(true);

            container.appendChild(layananTemplate);

            // Re-attach event listeners for dynamically added elements
            attachLayananListeners(container);
        });
    });

    // Tambah Barang
    document.querySelectorAll('[id^="add-barang-"]').forEach(function (button) {
        button.addEventListener('click', function () {
            const containerId = this.id.replace('add-barang-', 'barang-container-');
            const container = document.getElementById(containerId);
            const barangTemplate = document.getElementById('barang-template').content.cloneNode(true);

            container.appendChild(barangTemplate);

            // Re-attach event listeners for dynamically added elements
            attachBarangListeners(container);
        });
    });

    // Fungsi untuk menangani event hapus layanan
    function attachLayananListeners(container) {
        container.querySelectorAll('.remove-layanan').forEach(function (button) {
            button.addEventListener('click', function () {
                const layananItem = this.closest('.layanan-item');
                layananItem.remove();
            });
        });

        // Update total harga layanan saat layanan atau kuantitas berubah
        container.addEventListener('input', function (event) {
            if (event.target.matches('.layanan-select, .kuantitas-input')) {
                updateLayananTotal(event.target.closest('.layanan-item'));
            }
        });
    }

    // Fungsi untuk menangani event hapus barang
    function attachBarangListeners(container) {
        container.querySelectorAll('.remove-barang').forEach(function (button) {
            button.addEventListener('click', function () {
                const barangItem = this.closest('.barang-item');
                barangItem.remove();
            });
        });

        // Update total harga barang saat barang atau kuantitas berubah
        container.addEventListener('input', function (event) {
            if (event.target.matches('.barang-select, .kuantitas-barang-input')) {
                updateBarangTotal(event.target.closest('.barang-item'));
            }
        });
    }

    // Fungsi untuk memperbarui total layanan
    function updateLayananTotal(layananItem) {
        const layananSelect = layananItem.querySelector('.layanan-select');
        const kuantitasInput = layananItem.querySelector('.kuantitas-input');
        const totalHargaInput = layananItem.querySelector('.total-harga-input');
        const totalHargaPureInput = layananItem.querySelector('.total-harga-pure-input');

        if (!layananSelect || !kuantitasInput) return;

        const harga = parseFloat(layananSelect.options[layananSelect.selectedIndex]?.dataset.harga || 0);
        const kuantitas = parseInt(kuantitasInput.value || 0, 10);
        const totalHarga = harga * kuantitas;

        totalHargaInput.value = totalHarga.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
        totalHargaPureInput.value = totalHarga;
    }

    // Fungsi untuk memperbarui total barang
    function updateBarangTotal(barangItem) {
        const barangSelect = barangItem.querySelector('.barang-select');
        const kuantitasInput = barangItem.querySelector('.kuantitas-barang-input');
        const totalHargaInput = barangItem.querySelector('.total-harga-barang-input');
        const totalHargaPureInput = barangItem.querySelector('.total-harga-barang-pure-input');
        const stokError = barangItem.querySelector('.kuantitas-error');

        if (!barangSelect || !kuantitasInput) return;

        const harga = parseFloat(barangSelect.options[barangSelect.selectedIndex]?.dataset.harga || 0);
        const stok = parseInt(barangSelect.options[barangSelect.selectedIndex]?.dataset.stok || 0, 10);
        const kuantitas = parseInt(kuantitasInput.value || 0, 10);

        if (kuantitas > stok) {
            stokError.classList.remove('d-none');
        } else {
            stokError.classList.add('d-none');
        }

        const totalHarga = harga * kuantitas;

        totalHargaInput.value = totalHarga.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
        totalHargaPureInput.value = totalHarga;
    }

    // Inisialisasi awal untuk layanan dan barang
    document.querySelectorAll('[id^="layanan-container-"]').forEach(attachLayananListeners);
    document.querySelectorAll('[id^="barang-container-"]').forEach(attachBarangListeners);
});

</script>