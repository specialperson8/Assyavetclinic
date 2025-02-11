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
                        <h3>Daftar Pengambilan Barang</h3>
                        <p class="text-subtitle text-muted">Informasi Pengambilan Barang yang terdapat pada klinik anda</p>
                    </div>
                    @component('components.breadcumb', [
                        'menu' => ' Data Pengambilan Barang'
                 ])   
                 @endcomponent
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        @if(auth()->user()->role == 'karyawan')
                            <button type="button" class="btn btn-primary block" data-bs-toggle="modal"
                                data-bs-target="#exampleModalCenter">
                                Ambil Barang
                            </button>
                        @endif
                    </div>
                    <div class="card-body">
                        <table class="table table-striped" id="table1">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah Pengambilan</th>
                                    <th>Harga</th>
                                    <th>Terakhir diperbarui</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaksi as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->Inventori->nama_barang ?? 'Tidak ada nama' }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td>Rp.{{ number_format($item->total, 0, ',', '.') }}</td>
                                    <td>{{ $item->updated_at->format('d/m/Y') }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning block" data-bs-toggle="modal"
                                            data-bs-target="#updateModal-{{ $item->id }}">
                                            <i class="far fa-edit"></i>
                                        </button>
                                        
                                        @foreach ($transaksi as $item)
                                        <div class="modal fade" id="updateModal-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalCenterTitle">Update Pengambil Barang</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('updatetransaksi') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="booking_id" value="{{ $item->booking->id ?? '' }}">
                                                            <input type="hidden" name="inventori_id" value="{{ $item->Inventori->id ?? '' }}">
                                                            <input type="hidden" id="harga-{{ $item->id }}" value="{{ $item->Inventori->harga ?? 0 }}">
                                                            <div class="mb-3">
                                                                <strong>
                                                                    <label for="InputName" class="form-label">Pemilik Booking</label>
                                                                </strong>
                                                                <input type="text" class="form-control" value="{{ $item->booking->nama ?? 'Tidak ada nama' }}" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <strong>
                                                                    <label for="InputBarang" class="form-label">Nama Barang</label>
                                                                </strong>
                                                                <input type="text" class="form-control" value="{{ $item->Inventori->nama_barang ?? 'Tidak ada nama' }}" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <strong>
                                                                    <label for="selectJumlah" class="form-label">Pembaruan Jumlah yang dilakukan</label>
                                                                </strong>
                                                                <select class="form-select" id="selectJumlah-{{ $item->id }}" aria-label="Default select example">
                                                                    <option selected value="">Pilih jenis perubahan kuantitasnya</option>
                                                                    <option value="tambah">Penambahan Kuantitas</option>
                                                                    <option value="kurang">Pengurangan Kuantitas</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3" id="penambahanContainer-{{ $item->id }}" style="display: none;">
                                                                <strong>
                                                                    <label for="penambahan" class="form-label">Jumlah Penambahan</label>
                                                                </strong>
                                                                <input type="number" class="form-control" id="penambahan-{{ $item->id }}" name="penambahan" value="0" min="0">
                                                            </div>
                                                            <div class="mb-3">
                                                                <strong>
                                                                    <label for="total" class="form-label">Total Penambahan</label>
                                                                </strong>
                                                                <input type="number" class="form-control" id="totalpenambahan-{{ $item->id }}" name="totalpenambahan" value="0" readonly>
                                                            </div>
                                                            <div class="mb-3" id="penguranganContainer-{{ $item->id }}" style="display: none;">
                                                                <strong>
                                                                    <label for="pengurangan" class="form-label">Jumlah Pengurangan</label>
                                                                </strong>
                                                                <input type="number" class="form-control" id="pengurangan-{{ $item->id }}" name="pengurangan" value="0" min="0">
                                                            </div>
                                                            <div class="mb-3">
                                                                <strong>
                                                                    <label for="total" class="form-label">Total Pengurangan</label>
                                                                </strong>
                                                                <input type="number" class="form-control" id="totalpengurangan-{{ $item->id }}" name="totalpengurangan" value="0" readonly>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                                                    <i class="bx bx-x d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">Batal</span>
                                                                </button>
                                                                <button type="submit" class="btn btn-primary ml-1">
                                                                    <i class="bx bx-check d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">Simpan</span>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        

                                        <button type="button" class="btn btn-danger" onclick="confirmDeletion({{ $item->id }})">
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
            
    <script>
        function confirmDeletion(itemId) {
            if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
                // Redirect ke route untuk menghapus item
                window.location.href = '/delete-item/' + itemId;
            }
        }
    </script>
    <script>
        document.getElementById('InputBarang').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var stok = selectedOption.getAttribute('data-stok');
            document.getElementById('stokTersedia').textContent = 'Stok Tersedia: ' + stok;
        });
    </script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
        @foreach ($transaksi as $item)
        const selectJumlah{{ $item->id }} = document.getElementById('selectJumlah-{{ $item->id }}');
        const penambahanContainer{{ $item->id }} = document.getElementById('penambahanContainer-{{ $item->id }}');
        const penguranganContainer{{ $item->id }} = document.getElementById('penguranganContainer-{{ $item->id }}');
        const penambahanInput{{ $item->id }} = document.getElementById('penambahan-{{ $item->id }}');
        const penguranganInput{{ $item->id }} = document.getElementById('pengurangan-{{ $item->id }}');
        const totalPenambahan{{ $item->id }} = document.getElementById('totalpenambahan-{{ $item->id }}');
        const totalPengurangan{{ $item->id }} = document.getElementById('totalpengurangan-{{ $item->id }}');
        const harga{{ $item->id }} = parseFloat(document.getElementById('harga-{{ $item->id }}').value);

        selectJumlah{{ $item->id }}.addEventListener('change', function () {
            penambahanContainer{{ $item->id }}.style.display = this.value === 'tambah' ? 'block' : 'none';
            penguranganContainer{{ $item->id }}.style.display = this.value === 'kurang' ? 'block' : 'none';
            calculateTotal{{ $item->id }}();
        });

        penambahanInput{{ $item->id }}.addEventListener('input', calculateTotal{{ $item->id }});
        penguranganInput{{ $item->id }}.addEventListener('input', calculateTotal{{ $item->id }});

        function calculateTotal{{ $item->id }}() {
            let jumlah = 0;
            if (selectJumlah{{ $item->id }}.value === 'tambah') {
                jumlah = parseFloat(penambahanInput{{ $item->id }}.value) || 0;
                totalPenambahan{{ $item->id }}.value = jumlah * harga{{ $item->id }};
                totalPengurangan{{ $item->id }}.value = 0;
            } else if (selectJumlah{{ $item->id }}.value === 'kurang') {
                jumlah = parseFloat(penguranganInput{{ $item->id }}.value) || 0;
                totalPengurangan{{ $item->id }}.value = jumlah * harga{{ $item->id }};
                totalPenambahan{{ $item->id }}.value = 0;
            }
        }
        @endforeach
    });
</script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputBarang = document.getElementById('InputBarang');
            const inputJumlah = document.getElementById('InputJumlah');
            const inputHarga = document.getElementById('InputHarga');
            const inputTotal = document.getElementById('InputTotal');
        
            inputBarang.addEventListener('change', function() {
                const selectedOption = inputBarang.options[inputBarang.selectedIndex];
                const hargaPerItem = selectedOption.getAttribute('data-price');
                inputHarga.value = hargaPerItem;
                calculateTotal();
            });
        
            inputJumlah.addEventListener('input', calculateTotal);
        
            function calculateTotal() {
                const jumlah = inputJumlah.value;
                const hargaPerItem = inputHarga.value;
                if (jumlah && hargaPerItem) {
                    inputTotal.value = jumlah * hargaPerItem;
                } else {
                    inputTotal.value = 0;
                }
            }
        });
    </script>
        
        <!-- modal -->
        @include('components.modals.ambil')
@endsection