<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Vertically Centered</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('storetransaksi') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <strong>
                            <label for="InputName" class="form-label">Kode Booking</label>
                        </strong>
                        <select class="form-select" name="booking_id" aria-label="Default select example" required>
                            <option selected>Pilih Transaksi yang ingin kamu pilih</option>
                            @foreach ($booking as $item)
                            <option value="{{$item->id}}">#{{$item->id}}-{{$item->nama}} ({{$item->namahewan}})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <strong>
                            <label for="InputBarang" class="form-label">Nama Barang</label>
                        </strong>
                        <select class="form-select" name="inventori_id" id="InputBarang" aria-label="Default select example" required>
                            <option selected>Pilih Barang yang ingin kamu ambil</option>
                            @foreach ($inventori as $data)
                            <option value="{{$data->id}}" data-price="{{$data->harga}}" data-stok="{{$data->jumlah}}">{{$data->nama_barang}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <strong>
                            <label for="InputJumlah" class="form-label">Jumlah Barang</label>
                        </strong>
                        <input type="number" class="form-control" name="jumlah" id="InputJumlah" placeholder="Masukkan jumlah barang yang ingin diambil" required>
                        <small class="text-muted" id="stokTersedia">Stok Tersedia: </small>
                    </div>
                    <div class="mb-3">
                        <strong>
                            <label for="InputHarga" class="form-label">Harga Per Item Barang</label>
                        </strong>
                        <input type="number" class="form-control" id="InputHarga" readonly>
                    </div>
                    <div class="mb-3">
                        <strong>
                            <label for="InputTotal" class="form-label">Total Biaya</label>
                        </strong>
                        <input type="number" class="form-control" name="total" id="InputTotal" readonly required>
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
