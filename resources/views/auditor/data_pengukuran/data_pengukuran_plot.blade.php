@extends('layouts.layoutauditor')
@section('title','Klaster Plot')
@section('css')
@endsection
@section('active_data_pengukuran','active')
@section('active_pengukuran_plot','active')
@section('breadcrumb')
<li><a href="#">Data Pengukuran Plot</a></li>
@endsection
@section('judul_halaman','Pilih Klaster Plot')
@section('main_section')

<div class="box" style="margin:20px auto 0 auto; width:50%">
  <div class="box-header">
      <h4>Pilih Klaster Plot</h4>
      <hr>

      <form class="form-horizontal form-label-left" action="{{route('auditor.lihatpengukuran')}}" method="GET">
          {{ csrf_field() }}
          <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pengukuranke">Pengukuran ke# *
              </label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <select required class="form-control" name="pengukuranke" id="pengukuranke">
                  <option value="">Pilih Pengukuran</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                </select>
              </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tahun_pengukuran">Tahun *
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <select required class="form-control" name="tahun_pengukuran" id="tahun_pengukuran">
                    <option value="">Pilih Tahun Pengukuran</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kategori">Kategori (Nama Pengukur) *
                  </label>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                    <select required class="form-control" name="kategori" id="kategori">
                      <option value="">Pilih Kategori Hutan</option>
                    </select>
                  </div>
                </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_klaster_plot">Nama Klaster Plot *
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <select required class="form-control" name="nama_klaster_plot" id="nama_klaster_plot">
                    <option value="">Pilih Klaster Plot</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_plot">Nama Plot *
                  </label>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                    <select required class="form-control" name="nama_plot" id="nama_plot">
                      <option value="">Pilih Plot</option>
                    </select>
                  </div>
                </div>

                <button type="submit" name="lihat" id="lihat" value="lihat" class="btn btn-primary center-block"><i class="fa fa-search"></i> Lihat Data Plot</button>
        </form>

  </div>

</div>

@endsection

<script src="{{asset('Admin/modal_ajax.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/jquery/dist/jquery.min.js')}}"></script>

<script type="text/javascript">
$(document).ready(function(){

  $('#pengukuranke').change(function(e){
    var pengukuran_ke = e.target.value;
    $.ajax({
        type: 'post',
        url: '{{route("auditor.json_data_tahun")}}',
        data: {
          '_token': $('input[name=_token]').val(),
          'id': pengukuran_ke,
        },
        success: function (data) {
          if (data.length > 0) {
            $('#tahun_pengukuran').empty();
            $('#tahun_pengukuran').append('<option value="" disable="true" selected="true">Pilih Tahun</option>');
            $.each(data, function (key, value) {
          $('#tahun_pengukuran').append('<option value="' + value['tahun_pengukuran'] + '">' + value['tahun_pengukuran'] + '</option>');
          });
        }
        else{
          $('#tahun_pengukuran').empty();
          $('#tahun_pengukuran').append('<option value="" disable="true" selected="true">Data kosong</option>');
        }
      }
      });
  });

  $('#tahun_pengukuran').change(function(e){
    var tahun_pengukuran = e.target.value;
    $.ajax({
        type: 'post',
        url: '{{route("auditor.json_data_kategori")}}',
        data: {
          '_token': $('input[name=_token]').val(),
          'id': tahun_pengukuran,
        },
        success: function (data) {
          if (data.length > 0) {
            $('#kategori').empty();
            $('#kategori').append('<option value="" disable="true" selected="true">Pilih Kategori</option>');
            $.each(data, function (key, value) {
          $('#kategori').append('<option value="' + value['id_data_klaster'] + '">' + value['kategori'] + ' (' + value['nama_pengukur'] + ')' + '</option>');
          });
        }
        else{
          $('#kategori').empty();
          $('#kategori').append('<option value="" disable="true" selected="true">Data kosong</option>');
        }
      }
      });
  });

$('#kategori').change(function(e){
  var id_data_klaster = e.target.value;
  $('#nama_klaster_plot').empty();
  $('#nama_klaster_plot').append('<option value="" disable="true" selected="true">Pilih Klaster Plot</option>');
  $.get('/user/json-data_klaster_plot?id_data_klaster=' + id_data_klaster, function(data){
    $.each(data, function(index, klasterObj){
      $('#nama_klaster_plot').append('<option value="' + klasterObj.id_klaster_plot + '">' + klasterObj.nama_klaster + '</option>');

    })
  });
});

  $('#nama_klaster_plot').change(function(e){
    var id_klaster = e.target.value;
    $.ajax({
        type: 'post',
        url: '{{route("auditor.data_plot_klaster3")}}',
        data: {
          '_token': $('input[name=_token]').val(),
          'id': id_klaster,
        },
        success: function (data) {
          if (data.length > 0) {
            $('#nama_plot').empty();
            $('#nama_plot').append('<option value="" disable="true" selected="true">Pilih Plot</option>');
          $.each(data, function (key, value) {
          $('#nama_plot').append('<option value="' + value['id_plot'] + '">' + value['nama_plot'] + '</option>');
          });
        }
        else{
          $('#nama_plot').empty();
          $('#nama_plot').append('<option value="" disable="true" selected="true">Data kosong</option>');
        }
      }
      });
  });

  $('#nama_plot').change(function(e){
    var id_plot = e.target.value;
    $('#pengukuran_ke').empty();
    $('#pengukuran_ke').append('<option value="" disable="true" selected="true">Pilih Pengukuran</option>');
  });

});
</script>
