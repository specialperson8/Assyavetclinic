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
                        <h3>Daftar Booking</h3>
                        <p class="text-subtitle text-muted">
                            Informasi Booking yang terdapat pada klinik anda
                        </p>
                    </div>
                    @component('components.breadcumb', ['menu' => ' Daftar Booking'])
                    @endcomponent
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-primary block" data-bs-toggle="modal" data-bs-target="#tambahbook">
                            Buat Booking
                        </button>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped" id="table1">
                            <thead>
                                <tr>
                                    <th>Kode Pesananan</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Nama Hewan</th>
                                    <th>Petugas Pengerjaan</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookings as $item)
                                <tr>
                                    <td>{{ $item->kode_booking }}</td>
                                    <td>{{ $item->user ? $item->user->name : ($item->user_id ?? $item->nama) }}</td>
                                    <td>{{ $item->nama_hewan }}</td>
                                    <td>{{ $item->petugas ? $item->petugas->name : '-' }}</td>
                                    <td>{{ $item->created_at->format('l, d F Y') }}</td>
                                    <td>
                                        <div class="d-flex flex-wrap">
                                            <button type="button" class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#editbook-{{ $item->id }}">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger m-1" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $item->id }}">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
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

    <!-- modal -->
    @include('components.modals.createbook')
    @foreach ($bookings as $item)
        @include('components.modals.editbook', ['item' => $item])
        @include('components.modals.deletebook', ['item' => $item])
    @endforeach
    <!-- end modal -->
@endsection
