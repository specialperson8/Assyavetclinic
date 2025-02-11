@foreach ($layanan as $item)
<div class="modal fade" id="updateModalLayanan-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="updatelayananTittle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updatelayananTittle">Menu Update Data Layanan</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('updatelayanan', ['id' => $item->id]) }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="mb-3">
                        <label for="InputLayanan" class="form-label">Nama Layanan</label>
                        <input type="text" name="nama" class="form-control" id="InputName" aria-describedby="InputLayanan" value="{{$item->nama}}" placeholder="Masukkan Nama Layanan yang hendak kamu tambah" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleDataList" class="form-label">Jenis Layanan</label>
                        <input class="form-control" type="text" name="jenis" list="datalistOptions" id="exampleDataList" value="{{$item->jenis}}" placeholder="Tuliskan jenis layanan yang hendak anda tambah" required>
                        <datalist id="datalistOptions">
                            <option value="Vaksin">
                            <option value="Grooming">
                            <option value="Operasi">
                            <option value="Lainnya">
                            <option value="Jasa Dokter">
                            <option value="Diagnosa Penunjang">
                        </datalist>
                    </div>
                    <div class="mb-3">
                        <label for="InputHarga" class="form-label">Harga Layanan</label>
                        <input type="number" name="harga" class="form-control" value="{{$item->harga}}" id="InputHarga" placeholder="Contoh 800000" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Batal</span>
                </button>
                <button type="submit" class="btn btn-primary ml-1">
                    <span class="d-none d-sm-block">Perbarui</span>
                </button>
            </form>
            </div>
        </div>
    </div>
</div>

@endforeach