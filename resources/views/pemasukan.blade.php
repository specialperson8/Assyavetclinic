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
                                    <th>Kode Booking</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Nama Hewan</th>
                                    <th>Tanggal Booking</th>
                                    <th>Status</th>
                                    @if(auth()->user()->role = 'karyawan')
                                        <th>Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($booking as $item)
                                <tr>
                                    <td>{{ $item->kode_booking}}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->nama_hewan }}</td>
                                    <td>{{ $item->tanggal }}</td>
                                    <td>
                                            @if ($item->status == 'Belum Selesai')
                                                <span class="badge bg-danger">Belum dikerjakan</span>
                                            @else
                                                <span class="badge bg-success">{{ $item->status }}</span>
                                            @endif
                                    </td>
                                    @if(auth()->user()->role = 'karyawan')
                                        <td>
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#buatlaporan-{{$item->id}}">
                                                <i class="fas fa-briefcase"></i>
                                            </button>
                                        </td>
                                    @endif
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
@include('components.modals.createlaporanselesai')
<!-- end Modal -->
@endsection