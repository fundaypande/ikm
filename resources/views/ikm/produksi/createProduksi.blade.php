@extends('layouts.admin')

@section('content')

<div id="modal-form" class="modal fade" role="dialog" tabindex="1" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="modal-title">Tambah Profil IKM</h4>
      </div>
      <div class="modal-body">
        <form enctype="multipart/form-data" method="post" data-toggle="validator" action="/user/pic/{{ Auth::user()->id }}" id="theForm">
          {{ csrf_field() }} {{ method_field('POST') }}
        <input type="hidden" name="id" id="id" value="" method="patch">
        <div class="form-group">
          <label for="nama">Gambar</label>
          <input type="file" name="gambar" class="form-control">
        </div>

        <button type="submit" class="btn btn-info btn-fill">Simpan Profil</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </form>
      </div>
      <div class="modal-footer">

      </div>
    </div>

  </div>
</div>

<!-- end modal content -->

    <div class="row justify-content-center">

            <div style="padding-left: 20px; padding-right: 20px" class="card">
                <div class="card-header">


                  <br>

                  <a href="{{ url('/kelola-ikm') }}">Kelola IKM</a>
                  <i style="" class="fa fa-angle-double-right" aria-hidden="true"></i> Produksi
                  <i style="" class="fa fa-angle-double-right" aria-hidden="true"></i> Add

                  <div class="" style="margin-top: 20px">
                      <!-- untuk batas kosong -->
                  </div>


                  <h3>Tambah Data Produksi {{ $idUser -> name }}</h3>

                </div>

                <div class="card-body">

                  @if(count($errors) > 0)
                  <div class="alert alert-danger">
                    <ul>
                      @foreach ($errors-> all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                  @endif


                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(session('warning'))
          					  <div class="alert alert-warning ">
          					    {{session('warning')}}
          					  </div>
          					@endif

          					@if(session('notif'))
          					  <div class="alert alert-primary">
          					    {{session('notif')}}
          					  </div>
          					@endif

                    <p>Pelaku IKM dapat menginputkan data-data hasil produksinya yang nantinya akan ditampilkan di halaman depan website ini sehingga membantu untuk mempromosikan
                    produk-produk yang dimiliki IKM</p>
                    <br>

                    <!-- table show daftar user yang dapat mengakses sistem -->
                    <div class="row">
                      <div class="com-md-12">
                        <div class="panel panel-default">

                          <div class="panel-heading">
                            <h5>Daftar Profil IKM
                              <!-- <a onclick="addForm()" style="color:white" class="btn btn-primary pull-right">Tambah Produksi </a> -->
                            </h5>
                          </div>

                          <div class="panel-body" style="overflow-x:auto;">
                            <form method="post" data-toggle="validator" action="{{ url('/produksi/') }}/{{$idUser -> id}}/store2"  id="theForm" enctype="multipart/form-data">
                              {{ csrf_field() }} {{ method_field('POST') }}
                            <input type="hidden" name="id" id="id" value="" method="patch">
                            <div class="form-group">
                              <label for="jenis_produksi">Jenis Produksi</label>
                              <input type="text" name="jenis_produksi" value="{{ old('jenis_produksi') }}" class="form-control" id="jenis_produksi" required placeholder="">
                            </div>
                            <div class="form-group">
                              <label for="jumlah">Jumlah</label>
                              <input min="1" type="text" name="jumlah" value="{{ old('jumlah') }}" class="form-control" id="jumlah" required placeholder="">
                            </div>
                            <div class="form-group">
                              <label for="harga">Harga</label>
                              <input type="text" name="harga" value="{{ old('harga') }}" class="form-control" id="harga" placeholder="Rp." required>
                            </div>
                            <div class="form-group">
                              <label for="nilai_penjualan">Nilai Penjualan</label>
                              <input type="text" name="nilai_penjualan" value="{{ old('nilai_penjualan') }}" class="form-control" id="nilai_penjualan" placeholder="Rp." required>
                            </div>

                            <div class="form-group">
                              <label for="tujuan">Tujuan Pemasaran</label>
                              <input type="text" name="tujuan" value="{{ old('tujuan') }}" class="form-control" id="tujuan" placeholder="">
                            </div>
                            <div class="form-group">
                              <label for="deskripsi">Deskripsi</label>
                              <textarea name="deskripsi" class="form-control" id="deskripsi" rows="2"></textarea>
                            </div>
                            <div class="forn-group">
                              <label for="tahun">Tahun</label>
                              <select id="tahun" name="tahun" class="form-control">
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                                <option value="2027">2027</option>
                                <option value="2028">2028</option>
                                <option value="2029">2029</option>
                                <option value="2030">2030</option>
                                <option value="2031">2031</option>
                                <option value="2032">2032</option>
                                <option value="2033">2033</option>
                              </select>
                            </div>
                            <br>
                            <div class="form-group">
                              <label for="photo">Gambar</label>
                              <input type="file" name="photo" class="form-control">
                            </div>

                            <input type="hidden" name="idUser" id="idUser" value="{{ $idUser -> id }}">

                            <button type="submit" class="btn btn-info btn-fill">Simpan Produksi</button>
                          </div>


                        </div>
                      </div>
                    </div>


                </div>
            </div>

    </div>


    <script src="{{ asset('js/rupiah.js') }}"></script>

    <script type="text/javascript">
      $(document).ready(function() {
        console.log('data');
        justNum($('#jumlah'));
        justNum($('#harga'));
        justNum($('#nilai_penjualan'));
        console.log('end');
      });

    </script>

@endsection
