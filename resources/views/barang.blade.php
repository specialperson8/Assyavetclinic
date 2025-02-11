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
                        <h3>Inventori Barang</h3>
                        <p class="text-subtitle text-muted">Informasi barang yang terdapat pada klinik anda</p>
                    </div>
                    @component('components.breadcumb', [
                        'menu' => ' Inventori Barang'
                 ])   
                 @endcomponent
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        @if (Auth::check() && Auth::user()->role == 'admin')
                            <button type="button" class="btn btn-primary block" data-bs-toggle="modal"
                                data-bs-target="#ModalTambahBarang">
                                <strong><i class="fas fa-plus"></i> Tambah Barang</strong>
                            </button>
                        @endif
                    </div>
                    <div class="card-body">
                        <table class="table table-striped" id="table1">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Barang</th>
                                    <th>Stok</th>
                                    <th>Harga</th>
                                    <th>Terakhir diperbarui</th>
                                    @if (Auth::check() && Auth::user()->role == 'admin')
                                    <th>Aksi</th>
                                    @endif                               
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inventori as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_barang }}</td>
                                    <td>{{ $item->jumlah }} {{ $item->satuan}}</td>
                                    <td>Rp.{{ number_format($item->harga, 0, ',', '.') }}</td>
                                    <td>{{ $item->updated_at->format('d/m/Y') }}</td>
                                    @if (Auth::check() && Auth::user()->role == 'admin')
                                        <td>
                                            <div class="d-flex flex-wrap">
                                                <button type="button" class="btn btn-warning m-1" data-bs-toggle="modal"
                                                    data-bs-target="#updateModal-{{ $item->id }}">
                                                    <i class="far fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger m-1" onclick="confirmDeletion({{ $item->id }})">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
        @include('components.footer.footer_admin')
    </div>
  
    <!-- Modal -->
    @include('components.modals.tambahbarang')
    @include('components.modals.updatebarang')
    <!-- End Modal -->

    @isset($item)
    <script>
        function confirmDeletion(id) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Kamu ingin menghapus {{ $item->name }} dari Inventori",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'secondary',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create a form and submit it
                    var form = document.createElement('form');
                    form.action = `/deletebarang/${id}`;
                    form.method = 'post';
    
                    // CSRF token
                    var csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = '{{ csrf_token() }}';
                    form.appendChild(csrfInput);
    
                    // Method spoofing for DELETE request
                    var methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';
                    form.appendChild(methodInput);
    
                    document.body.appendChild(form);
                    form.submit();
                }
            })
        }
    </script>    
    @endisset
@endsection