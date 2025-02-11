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
                        <h3>Catatan Pemasukan Booking</h3>
                        <p class="text-subtitle text-muted">Informasi Pemasukan atau Booking Pelanggan</p>
                    </div>
                   @component('components.breadcumb', [
                          'menu' => ' Data Pemasukan'
                   ])
                   @endcomponent
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data Booking Pelanggan</h4>
                        <p class="card-text">Informasi booking yang telah diselesaikan maupun belum diselesaikan.</p>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped" id="table1">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Nama Hewan</th>
                                    <th>No. Telepon</th>
                                    <th>Tanggal Booking</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($booking as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->nama_hewan }}</td>
                                    <td><a href="tel:{{ $item->telpon }}">{{ $item->telpon }}</a></td>
                                    <td>{{ $item->tanggal }}</td>
                                    <td>
                                            @if ($item->status == 'belum dikerjakan')
                                                <span class="badge bg-danger">{{ $item->status }}</span>
                                            @else
                                                <span class="badge bg-success">{{ $item->status }}</span>
                                            @endif
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap">
                                            <button type="button" class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#editbook-{{ $item->id }}">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#Informasi-{{ $item->id }}">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </button>
                                            <a href="{{ route('nota', ['id' => $item->id]) }}" class="btn btn-danger m-1">
                                                <i class="fas fa-file-alt"></i>
                                            </a>
                                        </div>
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
</div>

<!-- Modal -->
@include('components.modals.infobook')

@foreach ($booking as $booking)
<div class="modal fade" id="editbook-{{ $booking->id }}" tabindex="-1" role="dialog" aria-labelledby="editbookTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editbookTitle">Menu Edit Booking</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('informations.update', $booking->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan</label>
                        <textarea name="catatan" class="form-control" id="catatan" rows="4" placeholder="Tuliskan Catatan">{{ old('catatan', $booking->catatan) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="diskon" class="form-label">Diskon</label>
                        <input type="number" name="diskon" class="form-control" id="diskon" value="{{ old('diskon', $booking->diskon) }}" placeholder="Masukkan diskon dalam bentuk nominal rupiah" required>
                    </div>

                    <div class="mb-3">
                        <label for="editobat" class="form-label">Edit Obat</label>
                        <div id="editobat-container">
                            @php
                                // Ambil data dari session atau database, gunakan array kosong jika tidak ada
                                $editedObats = session("editedObats.{$booking->id}") ?? null;
                                $obats = collect($editedObats ?: $booking->inventori ?: []);
                            @endphp

                            @foreach ($obats as $index => $obat)
                                <div class="editobat-item">
                                    <input type="hidden" name="editobat[{{ $index }}][id]" value="{{ old("editobat.$index.id", $obat->id ?? '') }}">
                                    <label>Nama Obat</label>
                                    <input type="text" name="editobat[{{ $index }}][nama_barang]" class="form-control" value="{{ old("editobat.$index.nama_barang", $obat->nama_barang ?? '') }}" required>


                            @endforeach

                            <!-- Input untuk menambahkan obat baru -->
                            <div class="editobat-item">
                                <label>Nama Obat Baru</label>
                                <input type="text" name="editobat[new][nama_barang]" class="form-control" placeholder="Masukkan nama obat">

                            </div>

                        </div>
                    </div>
                </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <span>Batal</span>
                </button>
                <button type="submit" class="btn btn-primary ml-1">
                    <span>Update Pesanan</span>
                </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach








<!-- end Modal -->

@endsection
