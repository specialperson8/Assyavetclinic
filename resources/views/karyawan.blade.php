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
                        <h3>Daftar Karyawan</h3>
                        <p class="text-subtitle text-muted">Informasi Karyawan yang terdapat pada klinik anda</p>
                    </div>
                   @component('components.breadcumb', [
                          'menu' => ' Daftar Karyawan'
                   ])   
                   @endcomponent
                </div>
            </div>
            
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-primary block" data-bs-toggle="modal"
                            data-bs-target="#createModalCenter">
                            Tambah Karyawan
                        </button>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped" id="table1">
                            <thead>
                                <tr>
                                    <th>ID Karyawan</th>
                                    <th>Nama Karyawan</th>
                                    <th>Email</th>
                                    <th>Terakhir diperbarui</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $data)
                                <tr>
                                    <td>{{ $data->id }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->email }}</td>
                                    <td>{{ $data->updated_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="d-flex flex-wrap">
                                            <button type="button" class="btn btn-primary m-1" data-bs-toggle="modal"
                                            data-bs-target="#updateModalCenter-{{ $data->id }}">
                                            Edit
                                            </button>
                                            <button type="button" class="btn btn-danger m-1" onclick="confirmDeletion({{ $data->id }})">Hapus</button>
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
        {{-- modal  --}}
        @include('components.modals.tambahakun')
        @include('components.modals.updateakun')
    </div>
</div>
@isset($data)
<script>
    function confirmDeletion(id) {
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Kamu ingin menghapus akun {{ $data->name }}",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonColor: 'secondary',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                // Assuming you're using a form to handle deletion
                var form = document.createElement('form');
                form.action = `/deleteakunkaryawan/${id}`; // Adjust the URL with the actual ID
                form.method = 'post';
    
                // CSRF token is necessary for Laravel applications
                var csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}'; // Ensure this is properly parsed by Blade
                form.appendChild(csrfInput);
    
                // Method spoofing to perform a DELETE request
                var methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);
    
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>

@endisset
@endsection