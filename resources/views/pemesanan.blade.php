<!DOCTYPE html>
<html dir="@if (session()->has('language_direction_from_dropdown')) @if(session()->get('language_direction_from_dropdown') == 1) {{ __('rtl') }} @else {{ __('ltr') }} @endif @else {{ __('ltr') }} @endif" lang="@if (session()->has('language_code_from_dropdown')){{ str_replace('_', '-', session()->get('language_code_from_dropdown')) }}@else{{ str_replace('_', '-',   $language->language_code) }}@endif">

<head>

    <!-- style modal -->
    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/app.css') }}">

    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="title" content="@if (isset($general_seo)){{ $general_seo->site_name }} @endif">
    <meta name="description" content="@if (isset($general_seo)){{ $general_seo->site_desc }} @endif">
    <meta name="keywords" content="@if (isset($general_seo)){{ $general_seo->site_keywords }} @endif">
    <meta name="author" content="superadmin">
    <meta property="fb:app_id" content="@if (isset($general_seo)){{ $general_seo->fb_app_id }} @endif">
    <meta property="og:title" content="@if (isset($general_seo)){{ $general_seo->site_name }} @endif">
    <meta property="og:url" content="@if (isset($general_seo)){{ url()->current() }} @endif">
    <meta property="og:description" content="@if (isset($general_seo)){{ $general_seo->site_desc }} @endif">
    <meta property="og:image" content="@if (!empty($general_site_image->favicon_image)){{ asset('uploads/img/general/'.$general_site_image->favicon_image) }} @endif">
    <meta itemprop="image" content="@if (!empty($general_site_image->favicon_image)){{ asset('uploads/img/general/'.$general_site_image->favicon_image) }} @endif">
    <meta property="og:type" content="website">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:image" content="@if (!empty($general_site_image->favicon_image)){{ asset('uploads/img/general/'.$general_site_image->favicon_image) }} @endif">
    <meta property="twitter:title" content="@if (isset($general_seo)){{ $general_seo->site_name }} @endif">
    <meta property="twitter:description" content="@if (isset($general_seo)){{ $general_seo->site_desc }} @endif">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title>{{ __('frontend.home') }} @if (isset($general_seo)) - {{ $general_seo->site_name }} @endif</title>


	<link rel="icon" href="https://assyavetclinic.com/logo-web.png" type="image/x-icon">
    <link rel="shortcut icon" href="https://assyavetclinic.com/logo-web.png" type="image/x-icon">

@if (!empty($general_site_image->favicon_image))
    <!-- Favicon -->
        <link href="{{ asset('uplods/img/general/'.$general_site_image->favicon_image) }}" sizes="128x128" rel="shortcut icon" type="image/x-icon" />
        <link href="{{ asset('uploads/img/general/'.$general_site_image->favicon_image) }}" sizes="128x128" rel="shortcut icon" />
@else
    <!-- Favicon -->
        <link href="{{ asset('uploads/img/dummy/favicon.png') }}" sizes="128x128" rel="shortcut icon" type="image/x-icon" />
        <link href="{{ asset('uploads/img/dummy/favicon.png') }}" sizes="128x128" rel="shortcut icon" />
@endif

    <!--// Boostrap  //-->
    <link rel="stylesheet" href="{{ asset('assets/frontend/vendor/css/bootstrap.min.css') }}">
    <!--// Magnific Popup //-->
    <link rel="stylesheet" href="{{ asset('assets/frontend/vendor/css/magnific.popup.min.css') }}">
    <!--// Animate Css //-->
    <link rel="stylesheet" href="{{ asset('assets/frontend/vendor/css/animate.min.css') }}">
    <!--// Vegas Slider Css //-->
    <link rel="stylesheet" href="{{ asset('assets/frontend/vendor/css/vegas.slider.min.css') }}">
    <!--// Owl Carousel //-->
    <link rel="stylesheet" href="{{ asset('assets/frontend/vendor/css/owl.carousel.min.css') }}">
    <!--// Owl Carousel Default //-->
    <link rel="stylesheet" href="{{ asset('assets/frontend/vendor/css/owl.carousel.default.min.css') }}">
    <!--// Font Awesome //-->
    <link rel="stylesheet" href="{{ asset('assets/frontend/fonts/font_awesome/css/all.css') }}">
    <!--// Flat Icons //-->
    <link rel="stylesheet" href="{{ asset('assets/frontend/fonts/flat_icons/flaticon.css') }}">
    <!--// Theme Main Css //-->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/pemesanan.css') }}">
    <!--// Theme Color Css //-->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/skins/default-color.css') }}" id="theme-color-toggle" />

    <!--// Color Option Css //-->
<meta name="google-site-verification" content="mpuXWFLZmP1x2Ti2G2PJo8Jpw-BSsI4aD3Aa984ULx8" />
@if (isset($google_analytic))
    <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $google_analytic->google_analytic }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', '{{ $google_analytic->google_analytic }}');
        </script>
    @endif

        <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-M5LP13BB4T"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-M5LP13BB4T');
</script>

</head>


<body data-spy="scroll" data-target="#fixedNavbar" @if (session()->has('language_direction_from_dropdown')) @if(session()->get('language_direction_from_dropdown') == 1)  class="rtl-mode" @endif @elseif (isset($language)) @if ($language->direction == 1) class="rtl-mode" @endif  @endif>


    <div class="page-wrapper" id="wrapper">
    <header class="header fixed-top" id="header">
        <div id="nav-menu-wrap">
            <div class="container">
                <nav class="navbar navbar-expand-lg p-0">
                    @if (!empty($general_site_image->site_colored_logo_image))
                        <a class="navbar-brand" title="Home" href="{{ url('/') }}">
                            <img src="{{ asset('uploads/img/general/'.$general_site_image->site_white_logo_image) }}" alt="Logo White" class="img-fluid logo-transparent">
                            <img src="{{ asset('uploads/img/general/'.$general_site_image->site_colored_logo_image) }}" alt="Logo Black" class="img-fluid logo-normal">
                        </a>
                    @else
                        <a class="navbar-brand" title="Home" href="#">
                            <img src="{{ asset('uploads/img/dummy/assya323.png') }}" alt="Logo White" class="img-fluid logo-transparent">
                            <img src="{{ asset('uploads/img/dummy/assya323.png') }}" alt="Logo Black" class="img-fluid logo-normal">
                        </a>
                    @endif
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#fixedNavbar"
                            aria-controls="fixedNavbar" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="togler-icon-inner">
                                <span class="line-1"></span>
                                <span class="line-2"></span>
                                <span class="line-3"></span>
                            </span>
                    </button>
                    <div class="collapse navbar-collapse main-menu justify-content-end" id="fixedNavbar">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="/" data-scroll-nav="1">Kembali Ke Beranda</a>
                            </li>





                            <li class="nav-item">
                                <a class="nav-link menu-link" href="{{ route('pemesanan') }}">Pemesanan</a>
                            </li>


                            @isset ($external_url)
                                @if ($external_url->status == 1)
                                    <li class="nav-item navbar-btn-resp d-flex align-items-center">
                                        <a href="{{ $external_url->btn_link }}" class="primary-btn">
                                            <span class="text">{{ $external_url->btn_name }}</span>
                                            <span class="icon"><i class="fa fa-arrow-right"></i></span>
                                        </a>
                                    </li>
                                @endif
                            @endisset

                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    </div>

    <section class="breadcrumb-section section" data-scroll-index="1" @if (isset($breadcrumb)) data-bg-image-path = "{{ asset('uploads/img/general/'.$breadcrumb->breadcrumb_image) }}"
             @else data-bg-image-path="{{ asset('uploads/img/dummy/1920x350.jpg') }}"
            @endif>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="breadcrumb-inner">
                        <h1>Layanan</h1>
                        <ul class="breadcrumb-links">
                            <li>
                                <a href="{{ url('/') }}">{{ __('frontend.home') }}</a>
                            </li>
                            <li class="active">
                            <a href="{{ route('pemesanan') }}">Pemesanan</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="container-booking">
        <h2 class="booking">Daftar Booking</h2>
        <div class="search-container">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Cari Kode Booking Anda">
            </div>
        </div>
        <div class="row-booking" id="bookingContainer">
            @foreach ($bookings as $item)
            <div class="card booking-card" data-kode="{{ $item->kode_booking }}" data-user-id="{{ $item->user_id }}" style="display: none;">
                <div class="date">
                    <time datetime="{{ \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d') }}">
                        <span>{{ \Carbon\Carbon::parse($item->tanggal)->format('d') }}</span>
                        <span>{{ \Carbon\Carbon::parse($item->tanggal)->format('M') }}</span>
                    </time>
                </div>
                <div class="card-cont">
                    <small>#{{$item->kode_booking}}</small>
                    <h3>{{$item->nama}}</h3>
                    <p>Nama Hewan: {{$item->nama_hewan}} - ({{$item->jenis_hewan}})</p>
                    <p>Tanggal Masuk: {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</p>
                    <a href="{{ route('daftarlaporan', ['data' => $item->id]) }}">Detail Booking</a>
                </div>
                <div class="barcode">
                    <img src="{{ asset('book/' . $item->kode_booking . '.png') }}" alt="Barcode {{$item->kode_booking}}">
                </div>
            </div>
            @endforeach
        </div>
        <div id="noBookingMessage" style="text-align: center; display: none;">
            <p>Tidak ada hasil ditemukan. Silakan masukkan kode booking yang benar.</p>
        </div>
    </section>
    
    <script>
       document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const noBookingMessage = document.getElementById('noBookingMessage');
    const bookingCards = document.querySelectorAll('.booking-card');

    // Hide all cards initially
    bookingCards.forEach(card => card.style.display = 'none');

    searchInput.addEventListener('input', function () {
        const searchValue = searchInput.value.trim().toLowerCase();
        let hasResults = false;

        if (searchValue === '') {
            // If search input is empty, hide all cards and show "no results" message
            bookingCards.forEach(card => card.style.display = 'none');
            noBookingMessage.style.display = 'block';
        } else {
            // Show cards that match the search value
            bookingCards.forEach(card => {
                const kodeBooking = card.getAttribute('data-kode').toLowerCase();
                if (kodeBooking === searchValue) {
                    card.style.display = 'block';
                    hasResults = true;
                } else {
                    card.style.display = 'none';
                }
            });

            // Toggle "no results" message
            noBookingMessage.style.display = hasResults ? 'none' : 'block';
        }
    });
});

    </script>
    
</body>
