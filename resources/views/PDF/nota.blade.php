<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <style>
        @media print {
            .page-break {
                display: block;
                page-break-before: always;
            }
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        #invoice-POS {
            padding: 20px;
            margin: 0 auto;
            width: 315px;
            background: #FFF;
            border-radius: 10px;
        }

        #invoice-POS h1 {
            font-size: 1.5em;
            color: #222;
        }

        #invoice-POS h2 {
            font-size: .9em;
        }

        #invoice-POS h3 {
            font-size: 1.2em;
            font-weight: 300;
            line-height: 2em;
        }
        #invoice-POS p {
            font-size: .7em;
            color: #666;
            line-height: 1.2em;
        }

        #invoice-POS #top, #invoice-POS #mid, #invoice-POS #bot {
            /* Targets all id with 'col-' */
            border-bottom: 1px solid #EEE;
        }
        #invoice-POS #top {
            min-height: 100px;
        }
        #invoice-POS #mid {
            min-height: 80px;
        }
        #invoice-POS #bot {
            min-height: 50px;
        }

        #invoice-POS #top .logo {
            height: 40px;
            width: 150px;
            background-size: 150px 40px;
        }
        #invoice-POS .clientlogo {
            float: left;
            height: 60px;
            width: 60px;
            background: url('../../admin/images/pdf/logo.png') no-repeat;
            background-size: 60px 60px;
            border-radius: 50px;
        }

        #invoice-POS .info {
            display: block;
            margin-left: 0;
        }
        #invoice-POS .title {
            float: right;
        }
        #invoice-POS .title p {
            text-align: right;
        }
        #invoice-POS table {
            width: 100%;
            border-collapse: collapse;
        }
        #invoice-POS .tabletitle {
            font-size: 10px;
            background: #EEE;
        }
        #invoice-POS .service {
            border-bottom: 1px solid #EEE;
        }
        #invoice-POS .item {
            width: 24mm;
        }
        #invoice-POS .itemtext {
            font-size: 10px;
            text-align: center;
            pl
        }
        #invoice-POS #legalcopy {
            margin-top: 5mm;
        }


    </style>

</head>
<body translate="no">
    <div id="invoice-POS">
        <center id="top">
            <div class="logo"></div>
            <img src="admin/images/pdf/logo.png" alt="">
            <div class="info">
                {{-- <h1 style="color: #666"><span style="color: #2B8BBB">Assya</span> Vet Clinic</h1> --}}
                <p>Jl. Jambangan Persada No.31, Jambangan, Kec. Jambangan, Surabaya, Jawa Timur 60232</p>
                <p>No. Telp : 0812-3456-7890</p>
            </div>
        </center>

        <div id="mid">
            <p style="text-align: center; font-size: 1.5em"><strong>{{$transaksi->kode_booking}}</strong></p>
            <div class="info">
                <h2>Info Kontak</h2>
                <p>Customer : {{$transaksi->nama}}</p>
                <p>Nama Hewan: {{$transaksi->nama_hewan}}</p>
                <p>Jenis Hewan: {{$transaksi->jenis_hewan}}</p>
                <p>Berat Hewan : {{$transaksi->berat_hewan}} Kg</p>
                <p>Tanggal Masuk: {{ \Carbon\Carbon::parse($transaksi->updated_at)->translatedFormat('d F Y') }}</p>
                <p>Tanggal Keluar: {{ \Carbon\Carbon::parse($transaksi->tanggal)->translatedFormat('d F Y') }}</p>
            </div>
            <div class="info">
                <h2>Informasi Perawatan</h2>
                <p>Catatan : <br>{{$transaksi->catatan}}</p>
            </div>
        </div>

        <div>
            <h2>Obat-Obatan</h2>
            <table>
                <tr class="tabletitle">
                    <th class="item">Obat</th>
                    <th class="Hours">Kuantitas</th>
                    <th class="Rate">Harga per Item</th>
                    <th class="Rate">Total</th>
                </tr>
                @foreach ($obat as $item)
                    <tr class="service">
                        <td class="tableitem"><p class="itemtext">{{ $item->Inventori->nama_barang ?? 'Tidak ada nama' }}</p></td>
                        <td class="tableitem"><p class="itemtext">{{$item->jumlah}} Item</p></td>
                        <td class="tableitem"><p class="itemtext">Rp.{{ number_format($item->Inventori->harga, 0, ',', '.') }}</p></td>
                        <td class="tableitem"><p class="itemtext">Rp.{{ number_format($item->total, 0, ',', '.') }}</p></td>
                    </tr>
                @endforeach    </table>
        </div>

        <div>
            <h2>Layanan yang Digunakan</h2>
            <table>
                <tr class="tabletitle">
                    <th class="item">Layanan</th>
                    <th class="Hours">Kuantitas</th>
                    <th class="Rate">Harga per Item</th>
                    <th class="Rate">Total</th>
                </tr>
                @foreach ($layanan as $item)
                    <tr class="service">
                        <td class="tableitem"><p class="itemtext">{{ $item->Layanan->nama ?? 'Tidak ada nama' }}</p></td>
                        <td class="tableitem"><p class="itemtext">{{$item->jumlah}} Item</p></td>
                        <td class="tableitem"><p class="itemtext">Rp.{{ number_format($item->Layanan->harga, 0, ',', '.') }}</p></td>
                        <td class="tableitem"><p class="itemtext">Rp.{{ number_format($item->total, 0, ',', '.') }}</p></td>
                    </tr>
                @endforeach    </table>
        </div>

        <div class="total" style="text-align: right;">
            <h2 style="font-size: 12px; color: #666">Uang Muka: Rp{{ number_format($transaksi->dp, 0, ',', '.') }}</h2>
            <h2 style="font-size: 12px; color: #666">Total Biaya Obat: Rp{{ number_format($totalTransaksi, 0, ',', '.') }}</h2>
            <h2 style="font-size: 12px; color: #666">Total Biaya Layanan: Rp{{ number_format($totalHarga, 0, ',', '.') }}</h2>
            <h2 style="font-size: 12px; color: #666">Diskon: Rp{{ number_format($transaksi->diskon, 0, ',', '.') }}</h2>
            <h2 style="font-size: 12px; color: #666">Sisa Pembayaran: Rp{{ number_format($pembayaran, 0, ',', '.') }}</h2>
        </div>

        <div id="legalcopy">
            <p class="legal"><strong>Terima kasih Telah Menggunakan Layanan Kami!</strong> Kami Tunggu kedatangan anda di Assya Vet Clinic </p>
        </div>
    </div>
</body>
</html>
