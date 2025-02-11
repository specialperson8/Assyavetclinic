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
                        <h3>Daftar Layanan</h3>
                        <p class="text-subtitle text-muted">Informasi Layanan yang terdapat pada klinik anda</p>
                    </div>
                    @component('components.breadcumb', [
                        'menu' => ' Daftar Layanan'
                 ])   
                 @endcomponent
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-primary block" data-bs-toggle="modal"
                            data-bs-target="#tambahlayanan">
                            Tambah Layanan
                        </button>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped" id="table1">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Layanan</th>
                                    <th>Jenis Layanan</th>
                                    <th>Harga Layanan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($layanan as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->jenis}}</td>
                                    <td>Rp.{{ number_format($item->harga, 0, ',', '.') }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary block" data-bs-toggle="modal"
                                            data-bs-target="#updateModalLayanan-{{ $item->id }}">
                                            <i class="far fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger block" onclick="confirmDeletion({{ $item->id }})"><i class="far fa-trash-alt"></i></button>
                                    </td>
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
    @include('components.modals.tambahlayanan')
    @include('components.modals.updatelayanan')
    <!-- end modal -->

    @isset($item)
    <script>
        function confirmDeletion(id) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Kamu ingin menghapus {{ $item->nama }} dari Inventori",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'secondary',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create a form and submit it
                    var form = document.createElement('form');
                    form.action = `/deletelayanan/${id}`;
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