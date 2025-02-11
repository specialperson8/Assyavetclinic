<!DOCTYPE html>
<html dir="@if (session()->has('language_direction_from_dropdown')) @if(session()->get('language_direction_from_dropdown') == 1) {{ __('rtl') }} @else {{ __('ltr') }} @endif @else {{ __('ltr') }} @endif" lang="@if (session()->has('language_code_from_dropdown')){{ str_replace('_', '-', session()->get('language_code_from_dropdown')) }}@else{{ str_replace('_', '-',   $language->language_code) }}@endif">

<head>

    <!-- style modal -->
    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

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
                        <h1>Daftar Laporan</h1>
                        <ul class="breadcrumb-links">
                            <li>
                                <a href="{{ url('/') }}">{{ __('frontend.home') }}</a>
                            </li>
                            <li class="active">
                                <a href="{{ route('pemesanan') }}">Pemesanan</a>
                            </li>
                            <li class="active">
                                <a href="#">Detail Laporan Booking</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="container-booking">
        <h2 class="booking">Daftar Laporan</h2>
        <div class="search-container">
            
        </div>
        <div class="row-booking">
            @foreach ($laporan as $item)
            <div class="card">
                <div class="date">
                    <time datetime="{{ \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d') }}">
                        <span>{{ \Carbon\Carbon::parse($item->tanggal)->format('d') }}</span>
                        <span>{{ \Carbon\Carbon::parse($item->tanggal)->format('M') }}</span>
                    </time>
                </div>
                <div class="card-cont">
                    <small>#{{$item->booking->kode_booking}}</small>
                    <h3>{{$item->judul_laporan}}</h3>
                    <p>{{ \Illuminate\Support\Str::limit($item->deskripsi, 50, '...') }}</p>
                    <p>Tanggal Masuk: {{ \Carbon\Carbon::parse($item->tanggal)->format('l, d-m-Y') }}</p>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#detailModal{{$item->id}}">Lihat Data</a>
                </div>
                <div class="barcode">
                    <img src="{{ asset('book/' . $item->booking->kode_booking . '.png') }}" alt="Barcode {{$item->kode_booking}}">
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="detailModal{{$item->id}}" tabindex="-1" aria-labelledby="detailModalLabel{{$item->id}}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header text-white">
                            <h5 class="modal-title" id="detailModalLabel{{$item->id}}">{{$item->judul_laporan}}</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @if ($item->bukti)
                            <div class="mb-3 text-center">
                                <img src="{{ asset('laporan/' . $item->bukti) }}" alt="Bukti Pekerjaan" class="img-fluid rounded" style="max-width: 200px;">
                            </div>
                            @endif
                            <p><strong>Kode Booking:</strong> {{$item->booking->kode_booking}}</p>
                            <p><strong>Deskripsi:</strong> {{$item->deskripsi}}</p>
                            <p><strong>Tanggal Masuk:</strong> {{ \Carbon\Carbon::parse($item->tanggal)->format('l, d-m-Y') }}</p>
                            {{-- <div class="barcode">
                                <img src="{{ asset('book/' . $item->booking->kode_booking . '.png') }}" alt="Barcode {{$item->kode_booking}}">
                            </div> --}}
                            @if ($item->layanans->isNotEmpty())
                            <h5 class="mt-4 mb-2">Layanan</h5>
                            @foreach ($item->layanans as $layanan)
                            <div class="mb-4">
                                <h6 class="text-secondary">{{ $layanan->layanan->nama }}</h6>
                                <span>Kuantitas: {{ $layanan->jumlah }}</span><br>
                                <span>Harga per item: Rp {{ number_format($layanan->harga, 0, ',', '.') }}</span><br>
                                <span>Total Harga: Rp {{ number_format($layanan->total, 0, ',', '.') }}</span>
                            </div>
                            @endforeach
                            @endif
                            @if ($item->barangs->isNotEmpty())
                            <h5 class="mt-4 mb-2">Inventori</h5>
                            @foreach ($item->barangs as $barang)
                            <div class="mb-3">
                                <h6 class="text-secondary">{{ $barang->inventori->nama_barang }}</h6>
                                <span>Kuantitas: {{ $barang->jumlah }}</span><br>
                                <span>Harga per item: Rp {{ number_format($barang->harga, 0, ',', '.') }}</span><br>
                                <span>Total Harga: Rp {{ number_format($barang->total, 0, ',', '.') }}</span>
                            </div>
                            @endforeach
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>

