@extends('layouts.admin')

@section('content')
<div id="app">
    @include('components.headers.navbar')
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Daftar Laporan Perawatan Hewan</h3>
                        <p class="text-subtitle text-muted">
                            Informasi Laporan Perawatan Hewan yang terdapat pada klinik anda
                        </p>
                    </div>
                    @component('components.breadcumb', ['menu' => ' Daftar Laporan Perawatan Hewan'])
                    @endcomponent
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-primary block" data-bs-toggle="modal" data-bs-target="#buatlaporan">
                            Buat Laporan Perawatan Hewan
                        </button>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped" id="table1">
                            <thead>
                                <tr>
                                    <th>Kode Pesananan</th>
                                    <th>Kegiatan</th>
                                    <th>Deskripsi</th>
                                    <th>Tanggal Laporan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($laporan as $item)
                                <tr>
                                    <td>{{ $item->booking->kode_booking }}</td>
                                    <td>{{ $item->judul_laporan}}</td>
                                    <td>{{ $item->deskripsi }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('l, d F Y') }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary block" data-bs-toggle="modal" data-bs-target="#infoLaporan-{{ $item->id }}">
                                            Detail
                                        </button>
                                        <button type="button" class="btn btn-primary block" data-bs-toggle="modal" data-bs-target="#editlaporan-{{ $item->id }}">
                                            <i class="far fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger block" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
        @include('components.footer.footer_admin')
    </div>

    <!-- modal -->
    @include('components.modals.createlaporan')
    @include('components.modals.editlaporan')
    @foreach ($laporan as $item)
        <!-- Delete Modal -->
        <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel{{ $item->id }}">Konfirmasi Hapus Laporan</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus laporan ini?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('laporan.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    
    {{-- @include('components.modals.createbook')
    @include('components.modals.editbook')
    @isset($item)
        @include('components.modals.deletebook')
    @endisset --}}
    <!-- end modal -->



    @foreach ($laporan as $item)
    <div class="modal fade" id="infoLaporan-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="infoLaporanTitle" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="infoLaporanTitle">Informasi Laporan Perawatan Hewan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- General Laporan Details -->
                    <div class="mb-4">
                        <label for="judul_laporan" class="form-label">Judul Laporan</label>
                        <p class="fs-5">{{ $item->judul_laporan }}</p>
                    </div>
    
                    <div class="mb-4">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <p>{{ $item->deskripsi }}</p>
                    </div>
    
                    <div class="mb-4">
                        <label for="tanggal" class="form-label">Tanggal Laporan</label>
                        <p>{{ \Carbon\Carbon::parse($item->tanggal)->format('l, d F Y') }}</p>
                    </div>

                    <div class="mb-4">
                        <label for="tanggal" class="form-label">Jam Melakukan Laporan</label>
                        <p>{{ \Carbon\Carbon::parse($item->tanggal)->format('H:i') }}</p>
                    </div>
    
                    <div class="mb-4">
                        <label for="bukti" class="form-label">Bukti Pekerjaan (Opsional)</label><br>
                        @if($item->bukti)
                            <img src="{{ asset($item->bukti) }}" alt="Bukti Pekerjaan" class="img-fluid" style="max-width: 200px;">
                        @else
                            <p>Tidak ada bukti pekerjaan</p>
                        @endif
                    </div>
    
                    <div class="mb-4">
                        <label for="status" class="form-label">Status Laporan</label>
                        <p class="fw-bold">{{ $item->booking->status }}</p>
                    </div>
    
                    <hr class="my-4">
    
                    <!-- Section Layanan -->
                    <h5 class="text-primary mb-3">Layanan yang Digunakan</h5>
                    <div id="layanan-container-{{ $item->id }}" class="row">
                        @if ($item->layanans->isEmpty())
                            <p class="text-muted">Mohon maaf, layanan ini tidak menggunakan layanan apapun</p>
                        @else
                            @foreach ($item->layanans as $layanan)
                            <div class="col-md-12 mb-3">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="layanan_id" class="form-label">Layanan</label>
                                                <p>{{ $layanan->layanan->nama }}</p>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="harga" class="form-label">Harga Per Item</label>
                                                <p>Rp {{ number_format($layanan->layanan->harga, 0, ',', '.') }}</p>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="kuantitas" class="form-label">Kuantitas</label>
                                                <p>{{ $layanan->jumlah }}</p>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="total_harga" class="form-label">Total Harga</label>
                                                <p>Rp {{ number_format($layanan->total, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
    
                    <hr class="my-4">
    
                    <!-- Section Barang -->
                    <h5 class="text-success mb-3">Barang yang Diambil</h5>
                    <div id="barang-container-{{ $item->id }}">
                        @if ($item->barangs->isEmpty())
                            <p class="text-muted">Mohon maaf, laporan ini tidak menggunakan barang apapun di Inventori</p>
                        @else
                            @foreach ($item->barangs as $barang)
                            <div class="col-md-12 mb-3">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="inventori_id" class="form-label">Barang</label>
                                                <p>{{ $barang->inventori->nama_barang }}</p>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="harga" class="form-label">Harga Per Item</label>
                                                <p>Rp {{ number_format($barang->inventori->harga, 0, ',', '.') }}</p>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="kuantitas_barang" class="form-label">Kuantitas</label>
                                                <p>{{ $barang->jumlah }} {{ $barang->inventori->nama_barang }}</p>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="total_harga_barang" class="form-label">Total Harga</label>
                                                <p>Rp {{ number_format($barang->total, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    
    @endforeach


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
@endsection
