@extends('layouts.admin')

@section('content')

<div id="modal-form" class="modal fade" role="dialog" tabindex="1" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="modal-title">Tambah Peralatan IKM</h4>
      </div>
      <div class="modal-body">
        <form method="post" data-toggle="validator" action="" id="theForm">
          {{ csrf_field() }} {{ method_field('POST') }}
        <div class="form-group">
          <label for="nama">Nama Kriteria</label>
          <input type="text" name="nama" value="" class="form-control" id="nama" required placeholder="">
        </div>


        <div class="form-group">
          <label for="keterangan">Keterangan</label>
          <select class="form-control" name="keterangan">
            <option value="benefit">Benefit</option>
            <option value="cost">Cost</option>
          </select>
        </div>


        <button type="submit" class="btn btn-info btn-fill" id="simpan">Simpan Data</button>
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
                  <h3>Kelola Kriteria Pemilihan IKM</h3>

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

                    <p>Daftar kriteria yang akan digunakan acuan dalam pemilihan IKM</p>
                    <br>

                    <!-- table show daftar user yang dapat mengakses sistem -->
                    <div class="row">
                      <div class="com-md-12">
                        <div class="panel panel-default">

                          <div class="panel-heading">
                            <h5>Daftar Komoditi
                              <a onclick="addForm()" style="color:white" class="btn btn-primary pull-right">Tambah Kriteria </a>
                            </h5>
                          </div>

                          <div class="panel-body" style="overflow-x:auto;">
                            <table id="staf-table" width="100%" class="table table-striped table-bordered table-hover">
                              <thead>
                                <tr>
                                  <th width="50">ID</th>
                                  <th>Nama Kriteria</th>
                                  <th>Keterangan</th>
                                  <th>Bobot</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>

                              </tbody>
                            </table>
                          </div>


                        </div>
                      </div>
                    </div>


                </div>
            </div>

    </div>


      <script src="{{ asset('js/rupiah.js') }}"></script>

    <script type="text/javascript">
    var table;
    $(document).ready(function() {


      justNum($('#tahun'));
      justNum($('#harga'));
      justNum($('#kapasitas'));
      justNum($('#jumlah'));


      table = $('#staf-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('api.kriteria') }}",
        columns: [
          {data: 'id', name: 'id'},
          {data: 'nama', name: 'nama'},
          {data: 'keterangan', name: 'keterangan'},
          {data: 'bobot', name: 'bobot'},
          {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
      });


    });

    function deleteData(id){
      var csrf_token = $('meta[name="crsf_token"]').attr('content');
      Swal({
        title: 'Hapus Data?',
        text: "Apakah anda yakin ingin menghapus data ini",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.value) {
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : "{{ url('kriteria') }}" + '/' + id,
            type: "POST",
            data: {'_method': 'DELETE', '_token': csrf_token},
            success: function(data) {
              table.ajax.reload();
              console.log(data);
              Swal({
                position: 'top-end',
                type: 'success',
                title: 'Data berhasil dihapus',
                showConfirmButton: false,
                timer: 1500
              })
            },
            error: function(){
              Swal({
                position: 'top-end',
                type: 'error',
                title: 'Data berhasil dihapus',
                showConfirmButton: false,
                timer: 1500
              })
            }
          });
        }
      });
    }


    function editData(id) {
      save_method = 'edit';
      $('input[name=_method]').val('PATCH');
      urlAction = "{{ url('kriteria') }}";
      $('#modal-title').text('Edit Peralatan IKM');
      console.log(id);
      // $('#modal-form')[0].reset();
      console.log(urlAction);
      $.ajax({
        url: "{{ url('kriteria') }}/" + id + "/edit",
        type: "GET",
        dataType: "JSON",
        success: function(data) {

          $('#modal-form').modal('show');


          // edit action pada form menjadi format URL patch di web.php
          $("#modal-form").find("form").attr("action", urlAction + '/' + id);

          $('#id').val(data.id);
          $('#nama').val(data.nama);
          $('#keterangan').val(data.keterangan);

        },
        error: function() {
          Swal({
            position: 'top-end',
            type: 'error',
            title: 'Terjadi kesalahan',
            showConfirmButton: false,
            timer: 1500
          })
        },
      });
    }

    $(function(){
      $('#modal-form form').validator().on('submit', function (e) {
        e.preventDefault();
        var data = $('form').serialize();
        console.log("Submit dipencet");
        var form_action = $("#modal-form").find("form").attr("action");
        var csrf_token = $('meta[name="crsf_token"]').attr('content');
        console.log(form_action);
        $.ajax({
          // headers: {
          //   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          // },
          url: form_action,
          type: "POST",
          dataType: "JSON",
          data: data,
          success: function(data) {
            table.ajax.reload();
            $(".modal").modal('hide');
            Swal({
              position: 'top-end',
              type: 'success',
              title: 'Selamat data berhasi disimpan',
              showConfirmButton: false,
              timer: 1500
            });
          },
          error: function(jqXhr, json, errorThrown){// this are default for ajax errors
            var errors = jqXhr.responseJSON;
            var errorsHtml = '';
            $.each(errors['errors'], function (index, value) {
                errorsHtml += '<ul class="list-group"><li class="list-group-item alert alert-danger">' + value + '</li></ul>';
            });
            //I use SweetAlert2 for this
            swal({
                title: "Error " + jqXhr.status + ': ' + errorThrown,// this will output "Error 422: Unprocessable Entity"
                html: errorsHtml,
                width: 'auto',
                confirmButtonText: 'Try again',
                cancelButtonText: 'Cancel',
                confirmButtonClass: 'btn',
                cancelButtonClass: 'cancel-class',
                showCancelButton: true,
                closeOnConfirm: true,
                closeOnCancel: true,
                type: 'error'
            }, function(isConfirm) {
                if (isConfirm) {
                     $('#openModal').click();//this is when the form is in a modal
                }
            });

          } //error close
        });
      });
    });

    function addForm() {
      save_method = "add";
      $('input[name=_method]').val('POST');
      $('#modal-form').modal('show');
      $('#theForm')[0].reset();
      $('.modal-title').text('Tambah Data Kriteria');
      console.log('Tampilkan Form ADD');
      $("#modal-form").find("form").attr("action", "{{ route('add.kriteria') }}");
    }

    function showData(id) {
      save_method = 'edit';
      $('input[name=_method]').val('PATCH');
      urlAction = "{{ url('peralatan') }}";
      $('#modal-title').text('Peralatan IKM');
      console.log(id);
      // $('#modal-form')[0].reset();
      console.log(urlAction);
      $.ajax({
        url: "{{ url('peralatan') }}/" + id + "/edit",
        type: "GET",
        dataType: "JSON",
        success: function(data) {

          $('#modal-form').modal('show');


          // edit action pada form menjadi format URL patch di web.php
          $("#modal-form").find("form").attr("action", urlAction + '/' + id);

          $('#id').val(data.id);
          $('#jenis_alat').val(data.jenis_alat);
          $('#tahun').val(data.tahun);
          $('#spesifikasi').hide();
          $('#kapasitas').val(data.kapasitas);
          $('#jumlah').val(data.jumlah);
          $('#buatan').val(data.buatan);
          $('#harga').val(data.harga);
          $('#asal').val(data.asal);

          data = data.spesifikasi;

          $("#theForm input").prop("disabled", true);
          $("#theForm textarea").prop("disabled", true);
          $("#simpan").hide();
          $("#par").text(data);


        },
        error: function() {
          Swal({
            position: 'top-end',
            type: 'error',
            title: 'Terjadi kesalahan',
            showConfirmButton: false,
            timer: 1500
          })
        },
      });
    }









    </script>

@endsection
