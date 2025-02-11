@foreach ($booking as $item)
    <div class="modal fade text-left" id="pengerjaan-{{ $item->id }}" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17">Menu Pengerjaan Pesanan</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('updatestatusbooking', ['id' => $item->id]) }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="mb-3">
                            <label for="karyawanSelect-{{ $item->id }}" class="form-label">Karyawan Yang Mengerjakan</label>
                            <select class="form-select" id="karyawanSelect-{{ $item->id }}" aria-label="Default select example">
                                <option selected>Pilih jumlah karyawan yang bekerja</option>
                                <option value="1">Satu Orang</option>
                                <option value="2">Dua Orang</option>
                                <option value="3">Tiga Orang</option>
                            </select>
                        </div>
                        <div>
                            <div class="mb-3 karyawan1-{{ $item->id }}">
                                <label for="nameKaryawan1" class="form-label">Karyawan pertama yang mengerjakan</label>
                                <input type="text" class="form-control" name="karyawan1" value=" {{Auth::user()->name}}" id="nameKaryawan1" placeholder="Masukkan Nama Karyawan Yang Mengerjakan" readonly>
                            </div>
                            <div class="mb-3 karyawan2-{{ $item->id }}">
                                <label for="nameKaryawan2" class="form-label">Karyawan kedua yang mengerjakan</label>
                                <input type="text" class="form-control" name="karyawan2" id="nameKaryawan2" placeholder="Masukkan Nama Karyawan Yang Mengerjakan">
                            </div>
                            <div class="mb-3 karyawan3-{{ $item->id }}">
                                <label for="nameKaryawan3" class="form-label">Karyawan ketiga yang mengerjakan</label>
                                <input type="text" class="form-control" name="karyawan3" id="nameKaryawan3" placeholder="Masukkan Nama Karyawan Yang Mengerjakan">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="namePemilik" class="form-label">Nama Pemilik</label>
                            <input type="text" class="form-control" name="nama" id="namePemilik"
                                value="{{ $item->nama }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="namaKucing" class="form-label">Nama Kucing</label>
                            <input type="text" class="form-control" name="namahewan" id="namaKucing"
                                value="{{ $item->namahewan }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="berat" class="form-label">Berat Hewan</label>
                            <input type="text" class="form-control" name="berat" id="berat"  placeholder="Masukkan Berat hewan yang diperiksa">
                            <small class="form-text text-muted">Tuliskan hanya angka saja dengan satuan kilogram</small>
                        </div>
                        <div class="mb-3">
                            <label for="jenis" class="form-label">Jenis Hewan</label>
                            <input type="text" class="form-control" name="jenis" id="jenis" placeholder="Masukkan Jenis Hewan yang anda perika">
                            <small class="form-text text-muted">Tuliskan jenis hewan yang tepat</small>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal Keluar Hewan</label>
                            <input type="date" class="form-control" name="tanggal" id="tanggal"
                                value="{{ $item->tanggal }}">
                        </div>
                        <div class="mb-3">
                            <label for="uangMuka" class="form-label">Uang Muka</label>
                            <input type="number" class="form-control" name="dp" id="uangMuka" value="0" placeholder="Masukkan nominal uang muka yang telah diselesaikan">
                            <small class="form-text text-muted">Jika tidak ada uang muka kosongkan saja</small>
                        </div>
                        <h5 class="mt-4">Layanan yang digunakan</h5>
                        <div class="card mb-3 border shadow-sm">
                          <div class="card-header bg-primary text-white">
                              <strong>Layanan Vaksin</strong>
                          </div>
                          <div class="card-body">
                              <div class="mb-3 mt-2">
                                  <label for="vaksinSelect-{{ $item->id }}" class="form-label">Vaksin</label>
                                  <select class="form-select" id="vaksinSelect-{{ $item->id }}" name="vaksin" aria-label="Default select example">
                                      <option selected>Pilih Jenis vaksin yang digunakan</option>
                                      <option value="tidak ada">Tidak Ada</option>
                                      @foreach ($vaksin as $vaksinItem)
                                      <option value="{{ $vaksinItem->nama }}" data-price="{{ $vaksinItem->harga }}">{{ $vaksinItem->nama }}</option>
                                      @endforeach
                                  </select>
                                  <small class="form-text text-muted">Jika tidak menggunakan layanan vaksin lewati saja</small>
                              </div>
                              <div class="row g-3">
                                  <br>
                                  <div class="col-sm">
                                      <input type="number" class="form-control" id="jumlahVaksin-{{ $item->id }}" placeholder="Masukkan jumlah vaksin" name="vaksin_kuantitas" aria-label="Masukkan jumlah vaksin yang digunakan">
                                      <br>
                                  </div>
                                  <div class="col-sm">
                                      <input type="number" class="form-control" id="hargaPerItem-{{ $item->id }}" placeholder="Harga Per Item" aria-label="State" readonly>
                                  </div>
                                  <div class="col-sm">
                                      <input type="number" class="form-control" id="totalBiaya-{{ $item->id }}" name="vaksin_harga" placeholder="Total biaya" aria-label="Zip" readonly>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <div class="card mb-3 border shadow-sm">
                          <div class="card-header bg-dark text-white">
                              <strong>Layanan Grooming</strong>
                          </div>
                          <div class="card-body">
                            <div class="mb-3 mt-2">
                              <label for="groomingSelect-{{ $item->id }}" class="form-label">Grooming</label>
                              <select class="form-select" id="groomingSelect-{{ $item->id }}" name="grooming" aria-label="Default select example">
                                  <option selected>Pilih Jenis grooming yang digunakan</option>
                                  <option value="tidak ada">Tidak Ada</option>
                                  @foreach ($grooming as $groomingItem)
                                  <option value="{{ $groomingItem->nama }}" data-harga="{{ $groomingItem->harga }}">{{ $groomingItem->nama }}</option>
                                  @endforeach
                              </select>
                              <small class="form-text text-muted">Jika tidak menggunakan layanan grooming lewati saja</small>
                          </div>
                          <div class="row g-3">
                              <br>
                              <div class="col-sm">
                                <input type="number" class="form-control" id="jumlahGrooming-{{ $item->id }}" name="grooming_kuantitas" placeholder="Masukkan jumlah grooming" aria-label="Masukkan jumlah grooming yang digunakan">
                                <br>
                              </div>
                              <div class="col-sm">
                                <input type="number" class="form-control" id="hargaPerGrooming-{{ $item->id }}" placeholder="Harga Per Item" aria-label="State" readonly>
                              </div>
                              <div class="col-sm">
                                <input type="number" class="form-control" id="totalBiayaGrooming-{{ $item->id }}" name="grooming_harga" placeholder="Total biaya" aria-label="Zip" readonly>
                              </div>
                          </div>
                          </div>
                        </div>
                        <div class="card mb-3 border shadow-sm">
                          <div class="card-header bg-warning text-white">
                              <strong>Layanan Operasi</strong>
                          </div>
                          <div class="card-body">
                            <div class="mb-3 mt-2">
                              <label for="operasiSelect-{{ $item->id }}" class="form-label">Operasi</label>
                              <select class="form-select" name="operasi" id="operasiSelect-{{ $item->id }}" aria-label="Default select example">
                                  <option selected>Pilih Operasi apa yang digunakan</option>
                                  <option value="tidak ada">Tidak Ada</option>
                                  @foreach ($operasi as $operasiItem)
                                  <option value="{{ $operasiItem->nama }}" data-operasi="{{ $operasiItem->harga }}">{{ $operasiItem->nama }}</option>
                                  @endforeach
                              </select>
                              <small class="form-text text-muted">Jika tidak menggunakan layanan operasi lewati saja</small>
                          </div>
                          <div class="row g-3">
                              <br>
                              <div class="col-sm">
                                <input type="number" class="form-control" name="operasi_kuantitas" id="jumlahOperasi-{{ $item->id }}" placeholder="Masukkan jumlah Operasi" aria-label="Masukkan jumlah grooming yang digunakan">
                                <br>
                              </div>
                              <div class="col-sm">
                                <input type="number" class="form-control" id="hargaPerOperasi-{{ $item->id }}" placeholder="Harga Per Item" aria-label="harga" readonly>
                              </div>
                              <div class="col-sm">
                                <input type="number" class="form-control" name="operasi_harga" id="totalBiayaOperasi-{{ $item->id }}" placeholder="Total biaya" aria-label="total" readonly>
                              </div>
                          </div>
                        </div>
                        <div class="card mb-3 border shadow-sm">
                          <div class="card-header bg-primary text-white">
                              <strong>Tindakan Lainnya</strong>
                          </div>
                          <div class="card-body">
                            <div class="mb-3 mt-2">
                              <label for="lainnyaSelect-{{ $item->id }}" class="form-label">Tindakan Lainnya</label>
                              <select class="form-select" id="lainnyaSelect-{{ $item->id }}" name="lainnya" aria-label="Default select example">
                                  <option selected>Pilih Tindakan lainnya apa yang digunakan</option>
                                  <option value="tidak ada">Tidak Ada</option>
                                  @foreach ($lainnya as $lainnyaItem)
                                  <option value="{{ $lainnyaItem->nama }}" data-tindakanlain="{{ $lainnyaItem->harga }}">{{ $lainnyaItem->nama }}</option>
                                  @endforeach
                              </select>
                              <small class="form-text text-muted">Jika tidak menggunakan tindakan lainnya lewati saja</small>
                          </div>
                          <div class="row g-3">
                              <br>
                              <div class="col-sm">
                                <input type="number" class="form-control" name="lainnya_kuantitas" id="jumlahTindakan-{{ $item->id }}" placeholder="Kuantitas atau jumlah" aria-label="Masukkan jumlah grooming yang digunakan">
                                <br>
                              </div>
                              <div class="col-sm">
                                <input type="number" class="form-control" id="hargaPerTindakan-{{ $item->id }}" placeholder="Harga Per Item" aria-label="State" readonly>
                              </div>
                              <div class="col-sm">
                                <input type="number" class="form-control" name="lainnya_harga" id="totalBiayaTindakan-{{ $item->id }}" placeholder="Total biaya" aria-label="Zip" readonly>
                              </div>
                          </div>
                          </div>
                        </div>




                        <div class="card mb-3 border shadow-sm">
                          <div class="card-header bg-info text-white">
                            <strong>Jasa Dokter</strong>
                          </div>
                          <div class="card-body">
                          <div class="mb-3 mt-2">
                            <label for="jasadokterSelect-{{ $item->id }}" class="form-label">Jasa Dokter</label>
                            <select class="form-select" id="jasadokterSelect-{{ $item->id }}" name="jasa_dokter" aria-label="Default select example">
                              <option selected>Pilih jasa dokter apa yang digunakan</option>
                              <option value="tidak ada">Tidak Ada</option>
                              @foreach ($jasa_dokter as $JasaDokterItem)
                              <option value="{{ $JasaDokterItem->nama }}" data-jasadokter="{{ $JasaDokterItem->harga }}">{{ $JasaDokterItem->nama }}</option>
                              @endforeach
                            </select>
                            <small class="form-text text-muted">Jika tidak menggunakan layanan jasa dokter lewati saja</small>
                          </div>
                          <div class="row g-3">
                            <br>
                            <div class="col-sm">
                              <input type="number" class="form-control" name="jasa_dokter_kuantitas" id="jumlahJasaDokter-{{ $item->id }}" placeholder="Masukkan jumlah grooming" aria-label="Masukkan jumlah grooming yang digunakan">
                              <br>
                            </div>
                            <div class="col-sm">
                              <input type="number" class="form-control" id="hargaPerJasaDokter-{{ $item->id }}" placeholder="Harga Per Item" aria-label="State" readonly>
                            </div>
                            <div class="col-sm">
                              <input type="number" class="form-control" name="jasa_dokter_harga" id="totalBiayaJasaDokter-{{ $item->id }}" placeholder="Total biaya" aria-label="Zip" readonly>
                            </div>
                          </div>
                          </div>
                        </div>

                        <div class="card mb-3 border shadow-sm">
                          <div class="card-header bg-success text-white">
                            <strong>Diagnosa Penunjang</strong>
                          </div>
                          <div class="card-body">
                            <div class="mb-3 mt-2">
                              <label for="diagnosaSelect-{{ $item->id }}" class="form-label">Diagnosa Penunjang</label>
                              <select class="form-select" id="diagnosaSelect-{{ $item->id }}" name="diagnosa_penunjang" aria-label="Default select example">
                                <option selected>Pilih Operasi apa yang digunakan</option>
                                <option value="tidak ada">Tidak Ada</option>
                                @foreach ($diagnosa as $DiagnosaItem)
                                <option value="{{ $DiagnosaItem->nama }}" data-diagnosa="{{ $DiagnosaItem->harga }}">{{ $DiagnosaItem->nama }}</option>
                                @endforeach
                              </select>
                              <small class="form-text text-muted">Jika tidak menggunakan layanan diagnosa penunjang lewati saja</small>
                            </div>
                            <div class="row g-3">
                              <br>
                              <div class="col-sm">
                                <input type="number" class="form-control" id="jumlahDiagnosa-{{ $item->id }}" name="diagnosa_penunjang_kuantitas" placeholder="Masukkan jumlah grooming" aria-label="Masukkan jumlah grooming yang digunakan">
                                <br>
                              </div>
                              <div class="col-sm">
                                <input type="number" class="form-control" id="hargaPerDiagnosa-{{ $item->id }}" placeholder="Harga Per Item" aria-label="State" readonly>
                              </div>
                              <div class="col-sm">
                                <input type="number" class="form-control" id="totalBiayaDiagnosa-{{ $item->id }}" name="diagnosa_penunjang_harga" placeholder="Total biaya" aria-label="Zip" readonly>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="card mb-3 border shadow-sm">
                          <div class="card-header bg-primary text-white">
                          <strong>Transportasi</strong>
                          </div>
                          <div class="card-body">
                          <div class="mb-3 mt-2">
                            <label for="transport" class="form-label">Transportasi</label>
                            <input type="text" class="form-control" id="transport" name="transportasi" placeholder="Masukkan layanan transportasi yang digunakan">
                            <small class="form-text text-muted">Jika tidak menggunakan layanan transportasi, kosongkan saja</small>
                          </div>
                          <div class="row g-3">
                            <br>
                            <div class="col-sm">
                            <input type="number" class="form-control" name="transportasi_kuantitas" id="jumlahpenggunaan" placeholder="Masukkan jumlah penggunaan layanan" aria-label="jumlah">
                            <br>
                            </div>
                            <div class="col-sm">
                            <input type="number" class="form-control" name="transport_harga" id="hargaperlayanan" placeholder="Harga tiap transportasi" aria-label="harga">
                            </div>
                            <div class="col-sm">
                            <input type="number" class="form-control" name="total_transport" id="totalbiayaPerTransportasi" placeholder="Total biaya" aria-label="total" readonly>
                            </div>
                          </div>
                          </div>
                        </div>

                        <input type="hidden" value="Telah diselesaikan" name="status">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>
                    <button type="submit" class="btn btn-success ml-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Klik untuk menyelesaikan</span>
                    </button>
                </form>
                </div>
            </div>
        </div>
    </div>
@endforeach


<!-- extesion -->
@include('components.extensions.karyawan')
@include('components.extensions.vaksin')
@include('components.extensions.grooming')
@include('components.extensions.operasi')
@include('components.extensions.lainnya')
@include('components.extensions.jasadokter')
@include('components.extensions.diagnosa')
@include('components.extensions.transportasi')
<!-- end extesion -->
