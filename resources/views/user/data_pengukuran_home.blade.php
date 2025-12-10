@extends('layouts.layout')
@section('title','Halaman Pengukuran')
@section('css')
  <link rel="stylesheet" href="{{asset('Admin/bower_components/morris.js/morris.css')}}">
@endsection
@section('active-treeview','active')
@section('active_pengukuran','active')
@section('judul_halaman','Halaman Pengukuran')
@section('main_section')
<div class="box" style="margin:20px auto 0 auto; width:60%">
  <div class="box-header">
      <h4>Data Pengukuran</h4>
      <hr>

      <form class="form-horizontal form-label-left" action="{{route('user.data_pengukuran')}}" method="GET">
          {{ csrf_field() }}
          <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kepemilikan_home">Kepemilikan
              </label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <select class="form-control kepemilikan" name="kepemilikan_home" id="kepemilikan_home">
                  <option value="%">Semua Kepemilikan</option>
                  @foreach($kepemilikan as $key => $value)
                  <option value="{{$value->id_hak_milik}}">{{$value->hak_milik}}</option>
                  @endforeach
                </select>
              </div>
            </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tipe_hutan_home">Tipe Hutan
            </label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <select class="form-control" name="tipe_hutan_home" id="tipe_hutan_home">
                <option value="%">Semua Tipe Hutan</option>
                @foreach($jenis as $key => $value)
                <option value="{{$value->id_jenis_hutan}}">{{$value->nama}}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div id="div_fungsihutan" style="display:none;" class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fungsi_hutan_home">Fungsi Hutan
              </label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <select class="form-control tipe_hutan" name="fungsi_hutan_home" id="fungsi_hutan_home">
                  <option value="%">Semua Fungsi Hutan</option>
                </select>
              </div>
            </div>

            <div class="form-group" style="">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="provinsi_home">Provinsi
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <select required class="form-control" name="provinsi_home" id="provinsi_home">
                      <option value="%">Semua Provinsi</option>
                      @foreach($provinsi as $key => $value)
                      <option value="{{$value->id_provinsi}}">{{$value->nama_provinsi}}</option>
                      @endforeach
                      </select>
                </div>
              </div>

              <div id="div_kabupaten" class="form-group" style="display:none">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kabupaten_home">Kabupaten
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <select class="form-control" name="kabupaten_home" id="kabupaten_home">
                        <option value="%">Semua Kabupaten</option>
                      </select>
                </div>
              </div>

              <div class="form-group" id="div_kecamatan" style="display:none">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kecamatan_home">Kecamatan
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <select class="form-control" id="kecamatan_home" name="kecamatan_home">
                        <option value="%">Semua Kecamatan</option>
                      </select>
                </div>
              </div>

              <div class="col-md-6 col-sm-6 col-xs-12">
                <button type="submit" name="lihat" id="lihat" value="lihat" class="btn btn-primary"><i class="fa fa-search"></i> Lihat Data Pengukuran Kesehatan Hutan</button>
                </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <button type="button" name="tambah_data" id="tambah_data" value="tambah_pengukuran" class="btn btn-success"><i class="fa fa-search"></i> Tambah Data Pengukuran Kesehatan Hutan</button>
              </div>
        </form>

  </div>

</div>

@include('user/include/data_klaster/modal-tambah_data_klaster')
@endsection
<script src="{{asset('Admin/modal_ajax.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/jquery/src/jquery.js')}}"></script>

<script type="text/javascript">
$(document).ready(function(){
  $('#tambah_data').prop("disabled",true);

  $('#kepemilikan_home').on('input',function(e){
    console.log($('#fungsi_hutan_home option:selected').val());
    if($('#kepemilikan_home option:selected').val()!='%'
    && $('#tipe_hutan_home option:selected').val()!='%'
    && $('#fungsi_hutan_home option:selected').val()!='%'
    && $('#provinsi_home option:selected').val()!='%'
    && $('#kabupaten_home option:selected').val()!='%'
    && $('#kecamatan_home option:selected').val()!='%'
  ){
        $('#tambah_data').prop("disabled",false);
      }
    else{
      $('#tambah_data').prop("disabled",true);
      }

  });

  $('#tipe_hutan_home').on('input',function(e){
    if($('#kepemilikan_home option:selected').val()!='%'
    && $('#tipe_hutan_home option:selected').val()!='%'
    && $('#fungsi_hutan_home option:selected').val()!='%'
    && $('#provinsi_home option:selected').val()!='%'
    && $('#kabupaten_home option:selected').val()!='%'
    && $('#kecamatan_home option:selected').val()!='%'){
        $('#tambah_data').prop("disabled",false);
      }
    else{
      $('#tambah_data').prop("disabled",true);
      }
    var id_jenis= e.target.value;
    var selected= $(this).val();
      $("#div_fungsihutan").show();
      $.get('/user/json-fungsi?id_jenis=' + id_jenis, function(data){
        console.log(data);
        $('#fungsi_hutan_home').empty();
        $('#fungsi_hutan_home').append('<option value="%" disable="true" selected="true">Semua Fungsi Hutan</option>');
        $.each(data, function(index, fungsiObj){
          $('#fungsi_hutan_home').append('<option value="' + fungsiObj.id_fungsi + '">' + fungsiObj.fungsi + '</option>');

        })
      });
    });

    $('#fungsi_hutan_home').on('input',function(e){
      if($('#kepemilikan_home option:selected').val()!='%'
      && $('#tipe_hutan_home option:selected').val()!='%'
      && $('#fungsi_hutan_home option:selected').val()!='%'
      && $('#provinsi_home option:selected').val()!='%'
      && $('#kabupaten_home option:selected').val()!='%'
      && $('#kecamatan_home option:selected').val()!='%'){
          $('#tambah_data').prop("disabled",false);
        }
      else{
        $('#tambah_data').prop("disabled",true);
        }

    });

    $('#provinsi_home').on('change',function(e){
      if($('#kepemilikan_home option:selected').val()!='%'
      && $('#tipe_hutan_home option:selected').val()!='%'
      && $('#fungsi_hutan_home option:selected').val()!='%'
      && $('#provinsi_home option:selected').val()!='%'
      && $('#kabupaten_home option:selected').val()!='%'
      && $('#kecamatan_home option:selected').val()!='%'){
          $('#tambah_data').prop("disabled",false);
        }
      else{
        $('#tambah_data').prop("disabled",true);
      }
      var id_prov = e.target.value;
      var selected_p= $(this).val();
      var k = $('#provinsi_home option:selected').text();
      if (selected_p != "") {
      $.get('/user/json-kabupaten?id_provinsi=' + id_prov, function(data){
      // menampilkan kabupaten
      $('#div_kabupaten').show();
      $('#kabupaten_home').empty();
      $('#kabupaten_home').append('<option value="%" disable="true" selected="true">Semua Kabupaten</option>');

      $('#kecamatan_home').empty();
      $('#kecamatan_home').append('<option value="%" disable="true" selected="true">Semua Kecamatan</option>');

      $.each(data, function(index, kabupatenObj){
        $('#kabupaten_home').append('<option value="' + kabupatenObj.id + '">' + kabupatenObj.nama_kabupaten + '</option>');
      });
        });
  }
      });

      $('#kabupaten_home').on('change',function(e){
        if($('#kepemilikan_home option:selected').val()!='%'
        && $('#tipe_hutan_home option:selected').val()!='%'
        && $('#fungsi_hutan_home option:selected').val()!='%'
        && $('#provinsi_home option:selected').val()!='%'
        && $('#kabupaten_home option:selected').val()!='%'
        && $('#kecamatan_home option:selected').val()!='%'){
            $('#tambah_data').prop("disabled",false);
          }
        else{
          $('#tambah_data').prop("disabled",true);
          }
        var id_kab = e.target.value;
        console.log(id_kab);
        var selected_kab= $(this).val();
        var k = $('#kabupaten_home option:selected').text();
        if (selected_kab != "") {
        $.get('/user/json-kecamatan?id=' + id_kab, function(data){
        // menampilkan kecamatan
        $('#div_kecamatan').show();
        $('#kecamatan_home').empty();
        $('#kecamatan_home').append('<option value="%" disable="true" selected="true">Semua Kecamatan</option>');
        $.each(data, function(index, kecamatanObj){
          $('#kecamatan_home').append('<option value="' + kecamatanObj.id + '">' + kecamatanObj.nama_kecamatan + '</option>');
        });
          });
    }
        });

        $('#kecamatan_home').on('change',function(e){
          if($('#kepemilikan_home option:selected').val()!='%'
          && $('#tipe_hutan_home option:selected').val()!='%'
          && $('#fungsi_hutan_home option:selected').val()!='%'
          && $('#provinsi_home option:selected').val()!='%'
          && $('#kabupaten_home option:selected').val()!='%'
          && $('#kecamatan_home option:selected').val()!='%'){
              $('#tambah_data').prop("disabled",false);
            }
          else{
            $('#tambah_data').prop("disabled",true);
          }
          });

        $('#tambah_data').click(function(e){
          $('#kepemilikan').val($('#kepemilikan_home').val());
          $('#jenis').val($('#tipe_hutan_home').val());
          $('#provinsi').val($('#provinsi_home').val());

          $.get('/user/json-fungsi?id_jenis=' + $('#jenis').val(), function(data){
          $('#fungsi').empty();
          $('#fungsi').append('<option value="%" disable="true" selected="true">Semua Fungsi Hutan</option>');
          $.each(data, function(index, fungsiObj){
          $('#fungsi').append('<option value="' + fungsiObj.id_fungsi + '">' + fungsiObj.fungsi + '</option>');
          });

          $('#fungsi').val($('#fungsi_hutan_home').val());
         });

         $.get('/user/json-kabupaten?id_provinsi=' + $('#provinsi').val(), function(data){
         $('#kabupaten').empty();
         $('#kabupaten').append('<option value="%" disable="true" selected="true">Semua Kabupaten</option>');
         $.each(data, function(index, kabupatenObj){
         $('#kabupaten').append('<option value="' + kabupatenObj.id + '">' + kabupatenObj.nama_kabupaten + '</option>');
         });
         $('#kabupaten').val($('#kabupaten_home').val());
         });

         $.get('/user/json-kecamatan?id=' + $('#kabupaten_home').val(), function(data){
         $('#kecamatan').empty();
         $('#kecamatan').append('<option value="%" disable="true" selected="true">Semua Kecamatan</option>');
         $.each(data, function(index, kecamatanObj){
         $('#kecamatan').append('<option value="' + kecamatanObj.id + '">' + kecamatanObj.nama_kecamatan + '</option>');
         });
         $('#kecamatan').val($('#kecamatan_home').val());
          });

          $.get('/user/json-desa?id=' + $('#kecamatan_home').val(), function(data){
          $('#desa').empty();
          $('#desa').append('<option value="%" disable="true" selected="true">Semua Kecamatan</option>');
          $.each(data, function(index, desaObj){
          $('#desa').append('<option value="' + desaObj.id + '">' + desaObj.nama_desa + '</option>');
          });

           });

          $('#tambah3').modal('show');

        });
  });
</script>
