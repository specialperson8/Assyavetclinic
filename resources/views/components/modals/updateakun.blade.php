<!-- update modal -->
@foreach ($users as $item)
<div class="modal fade" id="updateModalCenter-{{ $item->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalCenterTitle">Update Karyawan
                                        </h5>
                                        <button type="button" class="close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <i data-feather="x"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('updateakunkaryawan', ['id' => $item->id]) }}" method="POST">
                                                @csrf
                                                @method('POST')
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                            <div class="mb-3">
                                                <label for="InputName" class="form-label">Nama
                                                    Karyawan</label>
                                                <input type="text" class="form-control" id="InputName"
                                                    aria-describedby="InputName"
                                                    placeholder="Masukkan Nama Lengkap Karyawan Anda" value="{{ $item->name }}" name="nama" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">Email
                                                    Karyawan</label>
                                                <input type="email" class="form-control" id="exampleInputEmail1"
                                                    aria-describedby="emailHelp"
                                                    placeholder="Masukkan alamat email karyawan anda" value="{{ $item->email }}" name="email" required>
                                                <div id="emailHelp" class="form-text">*Pastikan email yang digunakan
                                                    dalam keadaan aktif.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputPassword1"
                                                    class="form-label">Password</label>
                                                <input type="password" class="form-control"
                                                    id="exampleInputPassword1"
                                                    placeholder="Masukkan Kata Sandi anda atau gunakan kata sandi baru" name="password" required>
                                            </div>
                                            <input type="hidden" value="karyawan" name="role">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light-secondary"
                                            data-bs-dismiss="modal">
                                            <i class="bx bx-x d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">Batal</span>
                                        </button>
                                        <button type="submit" class="btn btn-primary ml-1">
                                            <i class="bx bx-check d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">Perbarui Akun</span>
                                        </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
@endforeach
<!-- End of modal -->