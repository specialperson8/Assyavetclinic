@foreach ($bookings as $booking)
<div class="modal fade" id="editbook-{{ $booking->id }}" tabindex="-1" role="dialog" aria-labelledby="editbookTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editbookTitle">Menu Edit Booking</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('booking.update', $booking->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" id="nama" value="{{ $booking->nama }}" placeholder="Masukkan nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama_hewan" class="form-label">Nama Hewan</label>
                        <input type="text" name="nama_hewan" class="form-control" id="nama_hewan" value="{{ $booking->nama_hewan }}" placeholder="Masukkan nama hewan" required>
                    </div>
                    <div class="mb-3">
                        <label for="berat_hewan" class="form-label">Berat Hewan</label>
                        <input type="number" name="berat_hewan" class="form-control" id="berat_hewan" value="{{ $booking->berat_hewan }}" placeholder="Masukkan berat hewan" required>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_hewan" class="form-label">Jenis Hewan</label>
                        <input type="text" name="jenis_hewan" class="form-control" id="jenis_hewan" value="{{ $booking->jenis_hewan }}" placeholder="Jenis Hewan" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" name="alamat" class="form-control" id="alamat" value="{{ $booking->alamat }}" placeholder="Masukkan alamat" required>
                    </div>
                    <div class="mb-3">
                        <label for="telpon" class="form-label">Telepon</label>
                        <input type="number" name="telpon" class="form-control" id="telpon" value="{{ $booking->telpon }}" placeholder="Contoh 6281234567890" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" id="tanggal" value="{{ $booking->tanggal }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="keluhan" class="form-label">Keluhan</label>
                        <textarea name="keluhan" class="form-control" id="keluhan" placeholder="Masukkan keluhan">{{ $booking->keluhan }}</textarea>
                    </div>
                    <input type="hidden" name="total" class="form-control" id="total" value="{{ $booking->total }}" readonly>
                    <input type="hidden" name="status" class="form-control" id="status" value="{{ $booking->status }}" readonly>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <span>Batal</span>
                </button>
                <button type="submit" class="btn btn-primary ml-1">
                    <span>Update Pesanan</span>
                </button>
            </form>
            </div>
        </div>
    </div>
</div>
@endforeach
