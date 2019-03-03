@extends('layouts.admin')

@section('content')


    <div class="row justify-content-center">

            <div style="padding-left: 20px; padding-right: 20px" class="card">
                <div class="card-header">


                  <br>

                  <div class="" style="margin-top: 20px">
                      <!-- untuk batas kosong -->
                  </div>


                  <h3>Evaluasi Perkembangan IKM Penerima Bantuan</h3>

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

                    <br>

                    <!-- table show daftar user yang dapat mengakses sistem -->
                    <div class="row">
                      <div class="com-md-12">


                        <div class="panel-body" style="overflow-x:auto;">

                          <form method="post" action="{{ url('/evaluasi/edit') }}" id="theForm">
                            {{ csrf_field() }} {{ method_field('PATCH') }}


                          <input type="hidden" name="idUser" value="" class="form-control" id="idUser" placeholder="">

                          <?php $i = 0; ?>
                          @foreach($evaluasi as $data)
                          <?php $data ?>
                          <!-- cek apakah nama kriteria adalah jarak, jika ia maka isikan nilainya -->
                          @if($data -> nama == 'jarak' || $data -> nama == 'Jarak' || $data -> nama == 'Lama Berdirinya Usaha (Tahun)')
                            <?php
                              $read = 'hidden';
                             ?>
                          @else
                          <?php
                            $read = 'text';
                           ?>
                          @endif

                          <?php
                          //membatasi agar nilai dari kriteria yang belum diisi berinilai 0
                          // $dataNilai = null;
                          // // echo $i;
                          // // echo "<br />";
                          //   if($i > $dataKrit -> count()-1){
                          //     $dataNilai[$i] = 0;
                          //   } else {
                          //     $dataNilai[$i] = $dataKrit[$i] -> nilai;
                          //   }
                           ?>

                            <div class="form-group">
                              <label for="{{ $data -> id }}">{{ $data -> nama }}</label>
                              <input type="{{$read}}" name="{{ $data -> id }}" value="{{ $data -> nilai }}" class="form-control" id="{{ $data -> id }}" required  placeholder="">
                              <input type="hidden" name="idData" value="{{ $data -> id }}" class="form-control">
                            </div>
                            <?php $i++; ?>
                          @endforeach

                          @foreach($penerima as $penerim)
                            @if($penerim -> user_id == Auth::user() -> id)
                              <button type="submit" class="btn btn-info btn-fill" id="simpan">Simpan Data</button>
                            @endif
                          @endforeach



                        </form>



                        </div>


                      </div>
                    </div>


                </div>
            </div>

    </div>


    <script src="{{ asset('js/rupiah.js') }}"></script>
    <script type="text/javascript">
        $(".form-control").inputFilter(function(value) {
          return /^\d*$/.test(value);
        });
    </script>

    <script type="text/javascript">
    var table;
    $(document).ready(function() {


    });









    </script>

@endsection
