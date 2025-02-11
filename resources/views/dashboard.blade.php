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
            <h3>Dashboard</h3>
        </div>
        <div class="page-content">
            <section class="row">
                <div class="col-12 col-lg-9">
                    <div class="row">
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card shadow-lg">
                                <div class="card-body px-3 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon purple">
                                                <i class="iconly-boldShow"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">
                                                @if(auth()->user()->role == 'admin' || auth()->user()->role == 'superadmin')
                                                    Inventori
                                                @else
                                                    Booking
                                                @endif
                                            </h6>
                                            <h6 class="font-extrabold mb-0">
                                                @if(auth()->user()->role == 'admin' || auth()->user()->role == 'superadmin')
                                                    {{ count($inventori) }} Barang
                                                @else
                                                    {{ count($bookingbelum) }} Menunggu
                                                @endif
                                            </h6>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card shadow-lg">
                                <div class="card-body px-3 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon blue">
                                                <i class="iconly-boldProfile"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">
                                                @if(auth()->user()->role == 'admin' || auth()->user()->role == 'superadmin')
                                                    Booking
                                                @else
                                                    Booking
                                                @endif
                                            </h6>
                                            <h6 class="font-extrabold mb-0">
                                                @if(auth()->user()->role == 'admin' || auth()->user()->role == 'superadmin')
                                                    {{ count($booking) }} Booking
                                                @else
                                                    {{ count($bookinngselesai) }} Selesai
                                                @endif
                                            </h6>
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card shadow-lg">
                                <div class="card-body px-3 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon green">
                                                <i class="iconly-boldAdd-User"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">Layanan</h6>
                                            <h6 class="font-extrabold mb-0">{{ count($layanan) }} Layanan</h6>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card shadow-lg">
                                <div class="card-body px-3 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon red">
                                                <i class="iconly-boldBookmark"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">
                                                @if(auth()->user()->role == 'admin' || auth()->user()->role == 'superadmin')
                                                    Karyawan
                                                @else
                                                    Booking
                                                @endif
                                            </h6>
                                            <h6 class="font-extrabold mb-0">
                                                @if(auth()->user()->role == 'admin' || auth()->user()->role == 'superadmin')
                                                    {{ count($karyawan) }} Orang
                                                @else
                                                    {{ count($booking) }} Booking
                                                @endif
                                            </h6>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow-lg">
                                <div class="card-header">
                                    <h4>Data Booking Menunggu</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped" id="table1">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama Pemilik</th>
                                                <th>Nama Kucing</th>
                                                <th>Alamat</th>
                                                <th>Tanggal Booking</th>
                                                <th>Aksi</th>                              
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($bookingbelums as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $item->namahewan }}</td>
                                                <td>{{$item->alamat}}</td>
                                                <td>{{ $item->tanggal }}</td>
                                                <td>
                                                    <a href="{{ route('booking-uncompleted') }}" class="btn btn-primary block">
                                                        Lihat
                                                    </a>
                                                </td>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-3">
                    <div class="card shadow-lg">
                        <div class="card-body py-4 px-5">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-xl">
                                    @if(Auth::user()->role == 'admin')
                                        <img src="admin/images/faces/1.jpg" alt="admin">
                                    @else
                                        <img src="admin/images/faces/4.jpg" alt="user">
                                    @endif
                                </div>
                                <div class="ms-3 name">
                                    <h5 class="font-bold">{{Auth::user()->name}}</h5>
                                    <h6 class="text-muted mb-0"> {{Auth::user()->role}} </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        @include('components.footer.footer_admin')
    </div>
</div>
@endsection
