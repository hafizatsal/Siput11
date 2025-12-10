@extends('layouts.layout')
@section('title','Klaster Plot')
@section('css')
@endsection
@section('active_plot_ukur','active')
@section('active_plot','active')
@section('breadcrumb')
<li><a href="#">Data Plot</a></li>
@endsection
@section('judul_halaman','Pilih Plot')
@section('main_section')

<div class="box animated fadeIn slower" style="margin:20px auto 0 auto; width:50%">
  <div class="box-header">
      <h4>Pilih Plot</h4>
      <hr>

      <form class="form-horizontal form-label-left" action="{{route('user.detail_plot')}}" method="GET">
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
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kategori">Kategori (Nama Pengukur) *
                  </label>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                    <select required class="form-control" name="kategori" id="kategori">
                      <option value="">Pilih Kategori Hutan</option>
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_klaster_plot">Nama Klaster *
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
    $(".loading").show();
    var pengukuran_ke = e.target.value;
    $.ajax({
        type: 'post',
        url: '{{route("user.json_data_kategori")}}',
        data: {
          '_token': $('input[name=_token]').val(),
          'id': pengukuran_ke,
        },
        success: function (data) {
          if (data.length > 0) {
            $('#kategori').empty();
            $('#kategori').append('<option value="%" disable="true" selected="true">Semua Kategori</option>');
            $.each(data, function (key, value) {
          $('#kategori').append('<option value="' + value['kategori'] + '">' + value['kategori'] + ' (' + value['nama_pengukur'] + ')' + '</option>');
          });
        }
        else{
          $('#kategori').empty();
          $('#kategori').append('<option value="" disable="true" selected="true">Data kosong</option>');
        }
        $(".loading").hide();
      }
      });
  });

  $('#kategori').change(function(e){
    $(".loading").show();
    var kategori = e.target.value;
    var pengukuran_ke = $('#pengukuranke').val();
    if(pengukuran_ke==1){
      $.ajax({
          type: 'post',
          url: '{{route("user.json_data_tahun")}}',
          data: {
            '_token': $('input[name=_token]').val(),
            'id': kategori,
            'pengke' : pengukuran_ke,
          },
          success: function (data) {
            if (data.length > 0) {
              $('#tahun_pengukuran').empty();
              $('#tahun_pengukuran').append('<option value="" disable="true" selected="true">Pilih Tahun</option>');
              $.each(data, function (key, value) {
            $('#tahun_pengukuran').append('<option value="' + value['id_data_klaster'] + '">' + value['tahun_pengukuran'] + '</option>');
            });
          }
          else{
            $('#tahun_pengukuran').empty();
            $('#tahun_pengukuran').append('<option value="" disable="true" selected="true">Data kosong</option>');
          }
          $(".loading").hide();
        }
        });
    }
    else{
      $.ajax({
          type: 'post',
          url: '{{route("user.json_data_tahun")}}',
          data: {
            '_token': $('input[name=_token]').val(),
            'id': kategori,
            'pengke' : pengukuran_ke,
          },
          success: function (data) {
            if (data.length > 0) {
              $('#tahun_pengukuran').empty();
              $('#tahun_pengukuran').append('<option value="" disable="true" selected="true">Pilih Tahun</option>');
              $.each(data, function (key, value) {
            $('#tahun_pengukuran').append('<option value="' + value['id_data_klaster2'] + '">' + value['tahun_pengukuran'] + '</option>');
            });
          }
          else{
            $('#tahun_pengukuran').empty();
            $('#tahun_pengukuran').append('<option value="" disable="true" selected="true">Data kosong</option>');
          }
          $(".loading").hide();
        }
        });
    }

  });

  $('#tahun_pengukuran').change(function(e){
    $(".loading").show();
    var id_data_klaster = e.target.value;
    $.ajax({
        type: 'post',
        url: '{{route("user.json_data_klaster_plot2")}}',
        data: {
          '_token': $('input[name=_token]').val(),
          'id': id_data_klaster,
        },
        success: function (data) {
          if (data.length > 0) {
            $('#nama_klaster_plot').empty();
            $('#nama_klaster_plot').append('<option value="" disable="true" selected="true">Pilih Klaster Plot</option>');
            $.each(data, function (key, value) {
          $('#nama_klaster_plot').append('<option value="' + value['id_klaster_plot'] + '">' + value['nama_klaster'] + '</option>');
          });
        }
        else{
          $('#nama_klaster_plot').empty();
          $('#nama_klaster_plot').append('<option value="" disable="true" selected="true">Data kosong</option>');
        }
        $(".loading").hide();
      }
      });
  });

  $('#nama_klaster_plot').change(function(e){
    $(".loading").show();
    var id_klaster = e.target.value;
    $.ajax({
        type: 'post',
        url: '{{route("user.data_plot_klaster3")}}',
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
        $(".loading").hide();
      }
      });
  });

});
</script>
