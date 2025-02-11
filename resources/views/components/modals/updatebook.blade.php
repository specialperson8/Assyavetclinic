updatebook 
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
                              <option value="0" {{ !$item->karyawan1 && !$item->karyawan2 ? 'selected' : '' }}>Pilih jumlah karyawan yang bekerja</option>
                              <option value="1" {{ $item->karyawan1 && !$item->karyawan2 ? 'selected' : '' }}>Satu Orang</option>
                              <option value="2" {{ $item->karyawan1 && $item->karyawan2 ? 'selected' : '' }}>Dua Orang</option>
                              <option value="3" {{ $item->karyawan1 && $item->karyawan2 && $item->karyawan3 ? 'selected' : '' }}>Tiga Orang</option>
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
                            <input type="text" class="form-control" name="berat" value="{{$item->berat}}" id="berat" placeholder="Masukkan Berat hewan yang diperiksa">
                            <small class="form-text text-muted">Tuliskan hanya angka saja dengan satuan kilogram</small>
                        </div>
                        <div class="mb-3">
                            <label for="jenis" class="form-label">Jenis Hewan</label>
                            <input type="text" class="form-control" name="jenis" value="{{$item->jenishewan}}" id="jenis" placeholder="Masukkan Jenis Hewan yang anda periksa" value="">
                            <small class="form-text text-muted">Tuliskan jenis hewan yang tepat</small>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal Keluar Hewan</label>
                            <input type="date" class="form-control" name="tanggal" id="tanggal"
                                value="{{ $item->keluar }}">
                        </div>
                        <div class="mb-3">
                            <label for="uangMuka" class="form-label">Uang Muka</label>
                            <input type="number" class="form-control" name="dp" value="{{$item->dp}}" id="uangMuka" value="0" placeholder="Masukkan nominal uang muka yang telah diselesaikan">
                            <small class="form-text text-muted">Jika tidak ada uang muka kosongkan saja</small>
                        </div>

                        <h5 class="mt-4">Layanan yang digunakan</h5>

                        <!-- Layanan Vaksin -->
                        <div class="card mb-3 border shadow-sm">
                          <div class="card-header bg-primary text-white">
                              <strong>Layanan Vaksin</strong>
                          </div>
                          <div class="card-body">
                              <div class="mb-3 mt-2">
                                  <label for="vaksinSelect-{{ $item->id }}" class="form-label">Vaksin</label>
                                  <select class="form-select" id="vaksinSelect-{{ $item->id }}" name="vaksin" aria-label="Default select example">
                                      <option value="Tidak menggunakan layanan ini" {{ $item->vaksin == 'Tidak menggunakan layanan ini' ? 'selected' : '' }}>Pilih Jenis vaksin yang digunakan</option>
                                      @foreach ($vaksin as $vaksinItem)
                                          <option value="{{ $vaksinItem->nama }}" data-price="{{ $vaksinItem->harga }}" {{ $item->vaksin == $vaksinItem->nama ? 'selected' : '' }}>{{ $vaksinItem->nama }}</option>
                                      @endforeach
                                  </select>
                                  <small class="form-text text-muted">Jika tidak menggunakan layanan vaksin lewati saja</small>
                              </div>
                              <div class="row g-3">
                                  <div class="col-sm">
                                      <input type="number" class="form-control" id="jumlahVaksin-{{ $item->id }}" placeholder="Masukkan jumlah vaksin" name="vaksin_kuantitas" aria-label="Masukkan jumlah vaksin yang digunakan" value="{{ $item->vaksin_kuantitas ?? '' }}">
                                  </div>
                                  <div class="col-sm">
                                      <input type="number" class="form-control" id="hargaPerItem-{{ $item->id }}" placeholder="Harga Per Item" aria-label="State" readonly value="{{ $item->vaksin_harga_per_item ?? '' }}">
                                  </div>
                                  <div class="col-sm">
                                      <input type="number" class="form-control" id="totalBiaya-{{ $item->id }}" name="vaksin_harga" placeholder="Total biaya" aria-label="Zip" readonly value="{{ $item->vaksin_harga ?? '' }}">
                                  </div>
                              </div>
                          </div>
                      </div>
                      

                        <!-- Layanan Grooming -->
                        <div class="card mb-3 border shadow-sm">
                          <div class="card-header bg-dark text-white">
                              <strong>Layanan Grooming</strong>
                          </div>
                          <div class="card-body">
                              <div class="mb-3 mt-2">
                                  <label for="groomingSelect-{{ $item->id }}" class="form-label">Grooming</label>
                                  <select class="form-select" id="groomingSelect-{{ $item->id }}" name="grooming" aria-label="Default select example">
                                      <option value="Tidak menggunakan layanan ini" {{ $item->grooming == 'Tidak menggunakan layanan ini' ? 'selected' : '' }}>Tidak Menggunakan Layanan ini</option>
                                      @foreach ($grooming as $groomingItem)
                                          <option value="{{ $groomingItem->nama }}" data-harga="{{ $groomingItem->harga }}" {{ $item->grooming == $groomingItem->nama ? 'selected' : '' }}>{{ $groomingItem->nama }}</option>
                                      @endforeach
                                  </select>
                                  <small class="form-text text-muted">Jika tidak menggunakan layanan grooming lewati saja</small>
                              </div>
                              <div class="row g-3">
                                  <div class="col-sm">
                                      <input type="number" class="form-control" id="jumlahGrooming-{{ $item->id }}" name="grooming_kuantitas" placeholder="Masukkan jumlah grooming" aria-label="Masukkan jumlah grooming yang digunakan" value="{{ $item->grooming_kuantitas ?? '' }}">
                                  </div>
                                  <div class="col-sm">
                                      <input type="number" class="form-control" id="hargaPerGrooming-{{ $item->id }}" placeholder="Harga Per Item" aria-label="State" readonly value="{{ $item->grooming_harga_per_item ?? '' }}">
                                  </div>
                                  <div class="col-sm">
                                      <input type="number" class="form-control" id="totalBiayaGrooming-{{ $item->id }}" name="grooming_harga" placeholder="Total biaya" aria-label="Zip" readonly value="{{ $item->grooming_harga ?? '' }}">
                                  </div>
                              </div>
                          </div>
                      </div>
                      

                        <!-- Layanan Operasi -->
                        <div class="card mb-3 border shadow-sm">
                          <div class="card-header bg-warning text-white">
                              <strong>Layanan Operasi</strong>
                          </div>
                          <div class="card-body">
                              <div class="mb-3 mt-2">
                                  <label for="operasiSelect-{{ $item->id }}" class="form-label">Operasi</label>
                                  <select class="form-select" id="operasiSelect-{{ $item->id }}" name="operasi" aria-label="Default select example">
                                      <option value="Tidak menggunakan layanan ini" {{ $item->operasi == 'Tidak menggunakan layanan ini' ? 'selected' : '' }}>Tidak Menggunakan Layanan ini</option>
                                      @foreach ($operasi as $operasiItem)
                                          <option value="{{ $operasiItem->nama }}" data-harga="{{ $operasiItem->harga }}" {{ $item->operasi == $operasiItem->nama ? 'selected' : '' }}>{{ $operasiItem->nama }}</option>
                                      @endforeach
                                  </select>
                                  <small class="form-text text-muted">Jika tidak menggunakan layanan operasi lewati saja</small>
                              </div>
                              <div class="row g-3">
                                  <div class="col-sm">
                                      <input type="number" class="form-control" id="jumlahOperasi-{{ $item->id }}" name="operasi_kuantitas" placeholder="Masukkan jumlah operasi" aria-label="Masukkan jumlah operasi yang digunakan" value="{{ $item->operasi_kuantitas ?? '' }}">
                                  </div>
                                  <div class="col-sm">
                                      <input type="number" class="form-control" id="hargaPerOperasi-{{ $item->id }}" placeholder="Harga Per Item" aria-label="State" readonly value="{{ $item->operasi_harga_per_item ?? '' }}">
                                  </div>
                                  <div class="col-sm">
                                      <input type="number" class="form-control" id="totalBiayaOperasi-{{ $item->id }}" name="operasi_harga" placeholder="Total biaya" aria-label="Zip" readonly value="{{ $item->operasi_harga ?? '' }}">
                                  </div>
                              </div>
                          </div>
                      </div>

                        <!-- Layanan Jasa Dokter -->
                        <div class="card mb-3 border shadow-sm">
                          <div class="card-header bg-success text-white">
                              <strong>Layanan Jasa Dokter</strong>
                          </div>
                          <div class="card-body">
                              <div class="mb-3 mt-2">
                                  <label for="jasaDokterSelect-{{ $item->id }}" class="form-label">Jasa Dokter</label>
                                  <select class="form-select" id="jasaDokterSelect-{{ $item->id }}" name="jasa_dokter" aria-label="Default select example">
                                      <option value="Tidak menggunakan layanan ini" {{ $item->jasa_dokter == 'Tidak menggunakan layanan ini' ? 'selected' : '' }}>Tidak Menggunakan Layanan ini</option>
                                      @foreach ($jasa_dokter as $jasaDokterItem)
                                          <option value="{{ $jasaDokterItem->nama }}" data-harga="{{ $jasaDokterItem->harga }}" {{ $item->jasa_dokter == $jasaDokterItem->nama ? 'selected' : '' }}>{{ $jasaDokterItem->nama }}</option>
                                      @endforeach
                                  </select>
                                  <small class="form-text text-muted">Jika tidak menggunakan layanan jasa dokter lewati saja</small>
                              </div>
                              <div class="row g-3">
                                  <div class="col-sm">
                                      <input type="number" class="form-control" id="jumlahJasaDokter-{{ $item->id }}" name="jasa_dokter_kuantitas" placeholder="Masukkan jumlah jasa dokter" aria-label="Masukkan jumlah jasa dokter yang digunakan" value="{{ $item->jasa_dokter_kuantitas ?? '' }}">
                                  </div>
                                  <div class="col-sm">
                                      <input type="number" class="form-control" id="hargaPerJasaDokter-{{ $item->id }}" placeholder="Harga Per Item" aria-label="State" readonly value="{{ $item->jasa_dokter_harga_per_item ?? '' }}">
                                  </div>
                                  <div class="col-sm">
                                      <input type="number" class="form-control" id="totalBiayaJasaDokter-{{ $item->id }}" name="jasa_dokter_harga" placeholder="Total biaya" aria-label="Zip" readonly value="{{ $item->jasa_dokter_harga ?? '' }}">
                                  </div>
                              </div>
                          </div>
                      </div>

                        <!-- Layanan Diagnosa -->
                        <div class="card mb-3 border shadow-sm">
                          <div class="card-header bg-danger text-white">
                              <strong>Layanan Diagnosa Penunjang</strong>
                          </div>
                          <div class="card-body">
                              <div class="mb-3 mt-2">
                                  <label for="diagnosaPenunjangSelect-{{ $item->id }}" class="form-label">Diagnosa Penunjang</label>
                                  <select class="form-select" id="diagnosaPenunjangSelect-{{ $item->id }}" name="diagnosa_penunjang" aria-label="Default select example">
                                      <option value="Tidak menggunakan layanan ini" {{ $item->diagnosa_penunjang == 'Tidak menggunakan layanan ini' ? 'selected' : '' }}>Tidak menggunakan layanan ini</option>
                                      @foreach ($diagnosa as $diagnosaPenunjangItem)
                                          <option value="{{ $diagnosaPenunjangItem->nama }}" data-harga="{{ $diagnosaPenunjangItem->harga }}" {{ $item->diagnosa_penunjang == $diagnosaPenunjangItem->nama ? 'selected' : '' }}>{{ $diagnosaPenunjangItem->nama }}</option>
                                      @endforeach
                                  </select>
                                  <small class="form-text text-muted">Jika tidak menggunakan layanan diagnosa penunjang lewati saja</small>
                              </div>
                              <div class="row g-3">
                                  <div class="col-sm">
                                      <input type="number" class="form-control" id="jumlahDiagnosaPenunjang-{{ $item->id }}" name="diagnosa_penunjang_kuantitas" placeholder="Masukkan jumlah diagnosa penunjang" aria-label="Masukkan jumlah diagnosa penunjang yang dilakukan" value="{{ $item->diagnosa_penunjang_kuantitas ?? '' }}">
                                  </div>
                                  <div class="col-sm">
                                      <input type="number" class="form-control" id="hargaPerDiagnosaPenunjang-{{ $item->id }}" placeholder="Harga Per Item" aria-label="State" readonly value="{{ $item->diagnosa_penunjang_harga_per_item ?? '' }}">
                                  </div>
                                  <div class="col-sm">
                                      <input type="number" class="form-control" id="totalBiayaDiagnosaPenunjang-{{ $item->id }}" name="diagnosa_penunjang_harga" placeholder="Total biaya" aria-label="Zip" readonly value="{{ $item->diagnosa_penunjang_harga ?? '' }}">
                                  </div>
                              </div>
                          </div>
                      </div>

                        <!-- Layanan Transportasi -->
                        <div class="card mb-3 border shadow-sm">
                            <div class="card-header bg-info text-white">
                                <strong>Layanan Transportasi</strong>
                            </div>
                            <div class="card-body">
                              <div class="mb-3 mt-2">
                                <label for="transportasiSelect-{{ $item->id }}" class="form-label">Transportasi</label>
                                <select class="form-select" id="transportasiSelect-{{ $item->id }}" name="transportasi" aria-label="Default select example">
                                    <option value="Tidak menggunakan layanan ini" {{ $item->transportasi == 'Tidak menggunakan layanan ini' ? 'selected' : '' }}>Tidak Menggunakan layanan ini</option>
                                    <option value="transportasi jemput" {{ $item->transportasi == 'transportasi jemput' ? 'selected' : '' }}>Transportasi Jemput</option>
                                    <option value="transportasi antar" {{ $item->transportasi == 'transportasi antar' ? 'selected' : '' }}>Transportasi Antar</option>
                                    <option value="transportasi antar jemput" {{ $item->transportasi == 'transportasi antar jemput' ? 'selected' : '' }}>Transportasi Antar Jemput</option>
                                </select>
                                <small class="form-text text-muted">Jika tidak menggunakan layanan transportasi lewati saja</small>
                            </div>
                            <div class="row g-3">
                              <div class="col-sm">
                                  <input type="number" class="form-control" id="jumlahTransportasi-{{ $item->id }}" name="transportasi_kuantitas" placeholder="Masukkan jumlah layanan transportasi" aria-label="Masukkan jumlah transportasi yang digunakan" value="{{ $item->transportasi_kuantitas }}">
                              </div>
                              <div class="col-sm">
                                  <input type="number" class="form-control" id="hargaPerTransportasi-{{ $item->id }}" name="transport_harga" placeholder="Harga Per Item" aria-label="State" value="{{ $item->transport_harga }}">
                              </div>
                              <div class="col-sm">
                                  <input type="number" class="form-control" id="totalBiayaTransportasi-{{ $item->id }}" name="total_transport" placeholder="Total biaya" aria-label="Zip" value="{{ $item->total_trasport }}" readonly>
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
                        <span class="d-none d-sm-block">Perbarui Pemesanan</span>
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