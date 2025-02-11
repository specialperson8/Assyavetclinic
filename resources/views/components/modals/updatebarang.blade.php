@foreach ($inventori as $item)
<div class="modal fade" id="updateModal-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="updateModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalTitle">Menu Tambah Barang Inventori</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('updateinventori', ['id' => $item->id]) }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="mb-3">
                        <label for="InputBarang" class="form-label">Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control" value="{{$item->nama_barang}}" id="InputBarang" aria-describedby="InputBarang" placeholder="Masukkan Nama barang yang ingin ditambahkan di Inventori" required>
                    </div>
                    <div class="mb-3">
                        <label for="InputStok" class="form-label">Jumlah Stok Barang</label>
                        <input type="number" name="jumlah" class="form-control" value="{{$item->jumlah}}" id="InputStok" placeholder="Masukkan jumlah stok barang yang hendak ditambahkan" required>
                    </div>
                    <div class="mb-3">
                        <label for="InputHarga" class="form-label">Harga per-Item Barang</label>
                        <input type="number" name="harga" class="form-control" value="{{$item->harga}}" id="InputHarga" placeholder="Contoh : 10000" required>
                    </div>
                    <div class="mb-3">
                        <label for="InputSatuan" class="form-label">Satuan Barang</label>
                        <input type="text" name="satuan" class="form-control" value="{{$item->satuan}}" id="InputSatuan" placeholder="Masukkan satuan barang (contoh: kg, liter, pcs)" required>
                    </div>
                    <div class="mb-3">
                        <label for="InputTanggal" class="form-label">Tanggal Pencatatan Barang</label>
                        <input type="date" class="form-control" name="tanggal_pembuatan" value="{{$item->tanggal_pembuatan}}" id="InputTanggal" placeholder="Masukkan tanggal anda ketika memasukkan barang ke Gudang" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Batal</span>
                </button>
                <button type="submit" class="btn btn-success ml-1">
                    <span class="d-none d-sm-block">Simpan</span>
                </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach