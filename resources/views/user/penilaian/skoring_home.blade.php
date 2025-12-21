@extends('layouts.layout')
@section('title','Halaman Skoring')
@section('css')
  <link rel="stylesheet" href="{{asset('Admin/bower_components/morris.js/morris.css')}}">
@endsection
@section('active_penilaian','active')
@section('active_nilai_akhir','active')
@section('breadcrumb')
<li><a href="#">Nilai Akhir Kesehatan Hutan</a></li>
@endsection
@section('judul_halaman','Halaman Skoring')
@section('main_section')
<div class="box animated fadeIn slower" style="margin:20px auto 0 auto; width:60%">
  <div class="box-header">
      <h4>Penilaian Kesehatan</h4>
      <hr>

      <form class="form-horizontal form-label-left" action="{{route('user.penilaian_kesehatan')}}" method="post">
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
                  <option value="99">Perubahan (butuh pengukuran 1 &amp; 2)</option>
                  <option value="%">Semua Pengukuran (butuh pengukuran 1, 2 dan 3)</option>
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
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pilih_indikator">Pilih Indikator *
                  </label>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" value="produktivitas" id="c_prod" name="c_prod">
                        Produktivitas
                      </label>
                    </div>

                    <div class="checkbox">
                      <label>
                        <input type="checkbox" value="kerusakan" id="c_vit" name="c_vit">
                        Vitalitas
                      </label>
                    </div>

                    <div class="checkbox">
                      <label>
                        <input type="checkbox" value="ktk" id="c_ktk" name="c_ktk">
                        Kualitas Tapak
                      </label>
                    </div>

                  </div>

                  <div class="col-md-4 col-sm-4 col-xs-12">

                    <div class="checkbox">
                      <label>
                        <input type="checkbox" value="biodiversitas" id="c_biodiv" name="c_biodiv">
                        Biodiversitas Pohon
                      </label>
                    </div>

                    <div class="checkbox">
                      <label>
                        <input type="checkbox" value="biodiversitas" id="c_biodivf" name="c_biodivf">
                        Biodiversitas Fauna
                      </label>
                    </div>

                    <div class="checkbox">
                      <label>
                        <input type="checkbox" value="%" id="check_all" name="check_all">
                        Pilih Semua
                      </label>
                    </div>

                  </div>

                </div>
          <span id="param_produktivitas" style="display:none;">
          <div class="form-group">
              <label class="col-md-3 col-sm-3 col-xs-12 control-label">Parameter <br> Produktifitas
              </label>

              <div class="col-md-9 col-sm-9 col-xs-12">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="lbds" id="lbds" name="lbds">
                    LBDS
                  </label>
                </div>
              </div>

              <div class="col-md-9 col-sm-9 col-xs-12">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="volume" id="volume" name="volume">
                    VOLUME
                  </label>
                </div>
              </div>
            </div>
          </span>

          <span id="param_vitalitas" style="display:none;">
            <div class="form-group">
                <label class="col-md-3 col-sm-3 col-xs-12 control-label">Parameter <br> Vitalitas
                </label>

                <div class="col-md-9 col-sm-9 col-xs-12">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" value="kerusakan" id="kerusakan" name="kerusakan">
                      Kerusakan
                    </label>
                  </div>
                </div>

                <div class="col-md-9 col-sm-9 col-xs-12">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" value="ktjk" id="ktjk" name="ktjk">
                      Kondisi Tajuk
                    </label>
                  </div>
                </div>
              </div>
            </span>

            <span id="param_ktapak" style="display:none;">
            <div class="form-group">
                <label class="col-md-3 col-sm-3 col-xs-12 control-label">Parameter <br> Kualitas Tapak
                </label>

                <div class="col-md-3 col-sm-3 col-xs-12">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" value="kimia" id="kimia" name="kimia">
                      Sifat Kimia
                    </label>
                  </div>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-12">
                  <span id="list_sifat" name="list_sifat" style="display:none;">
                    <select class="form-control" name="sifat-sifat_kimia" id="sifat-sifat_kimia">
                      <option value="">Pilih Sifat</option>
                      <option value="1">KTK</option>
                      <option value="2">pH Tanah</option>
                      <option value="3">Horizon tanah</option>
                      <option value="4">Nitrogen</option>
                      <option value="5">Fosfor</option>
                      <option value="6">Kalium</option>
                      <option value="7">Magnesium</option>
                      <option value="8">Kalsium</option>
                      <option value="9">Belerang</option>
                    </select>
                  </span>
                </div>

                <div class="col-md-9 col-sm-9 col-xs-12">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" value="fisik" id="fisik" name="fisik">
                      Sifat Fisikaa
                    </label>
                  </div>
                </div>
              </div>
            </span>

            <span id="param_biodive" style="display:none;">
            <div class="form-group">
                <label class="col-md-3 col-sm-3 col-xs-12 control-label">Parameter <br> Biodiversitas <br> Pohon
                </label>

                <div class="col-md-9 col-sm-9 col-xs-12">
                  <label>
                    <input type="checkbox" value="haksenp" id="haksenp" name="haksenp"> H' Pohon
                  </label>
                </div>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                    <label>
                      <input type="checkbox"  value="jpliup" id="jpliup" name="jpliup"> J' Pohon
                    </label>
                  </div>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                    <label>
                      <input type="checkbox" value="dmgp" id="dmgp" name="dmgp"> DMg Pohon
                    </label>
                  </div>
                </div>
            </span>

              <span id="param_biodivef" style="display:none;">
              <div class="form-group">
                <label class="col-md-3 col-sm-3 col-xs-12 control-label">Parameter <br> Biodiversitas <br>Fauna
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <label>
                    <input type="checkbox" value="haksenf" id="haksenf" name="haksenf"> H' Fauna
                  </label>
                </div>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                    <label>
                      <input type="checkbox" value="jpliuf" id="jpliuf" name="jpliuf"> J' Fauna
                    </label>
                  </div>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                    <label>
                      <input type="checkbox" value="dmgf" id="dmgf" name="dmgf"> DMg Fauna
                    </label>
                  </div>
                </div>
            </span>

              <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                <button type="submit" name="submitbutton" id="lihat" value="lihat" class="btn btn-success"><i class="fa fa-search"></i> Lihat Penilaian Kesehatan Hutan</button>
              </div>
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
    else if(pengukuran_ke=="%"){
      $.ajax({
          type: 'post',
          url: '{{route("user.json_data_tahun2")}}',
          data: {
            '_token': $('input[name=_token]').val(),
            'id': kategori,
            'pengke' : 1,
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
    else if(pengukuran_ke=="99"){
      $.ajax({
          type: 'post',
          url: '{{route("user.json_data_tahun2")}}',
          data: {
            '_token': $('input[name=_token]').val(),
            'id': kategori,
            'pengke' : 1,
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

    $('#c_biodivf').on('change',function(){
      if($('#c_biodivf').is(':checked')) {
        $('#haksenf').prop('checked', true);
      }
      else{
        $('#haksenf').prop('checked', false);
      }

    });

    $('#c_biodiv').on('click',function(){
      if($('#c_biodiv').is(':checked')) {
        $('#haksenp').prop('checked', true);
      }
      else{
        $('#haksenp').prop('checked', false);
      }
    });

      $('#check_all').on('click',function(){

        if ($('#check_all').prop('checked')==true) {
          $('#c_prod').prop('checked', true);
          $('#c_vit').prop('checked', true);
          $('#c_ktk').prop('checked', true);
          $('#c_biodiv').prop('checked', true);
          $('#c_biodivf').prop('checked', true);
          $('#param_produktivitas').slideDown();
          $('#param_vitalitas').slideDown();
          $('#param_ktapak').slideDown();
          $('#param_biodive').slideDown();
          $('#haksenp').prop('checked', true);
          $('#param_biodivef').slideDown();
          $('#haksenf').prop('checked', true);
        }
        else{
          $('#c_prod').prop('checked', false);
          $('#c_vit').prop('checked', false);
          $('#c_ktk').prop('checked', false);
          $('#c_biodiv').prop('checked', false);
          $('#c_biodivf').prop('checked', false);
          $('#param_produktivitas').slideUp();
          $('#param_vitalitas').slideUp();
          $('#param_ktapak').slideUp();
          $('#param_biodive').slideUp();
          $('#haksenp').prop('checked', false);
          $('#param_biodivef').slideUp();
          $('#haksenp').prop('checked', false);
        }
      });

      $('#c_prod').on('click',function(){
        if($('#c_prod').is(':checked')) {
          $('#param_produktivitas').slideDown();
        }
        else{
          $('#param_produktivitas').slideUp();
        }
      });

      $('#c_vit').on('click',function(){
        if($('#c_vit').is(':checked')) {
          $('#param_vitalitas').slideDown();
        }
        else{
          $('#param_vitalitas').slideUp();
        }
      });

      $('#c_ktk').on('click',function(){
        if($('#c_ktk').is(':checked')) {
          $('#param_ktapak').slideDown();
        }
        else{
          $('#param_ktapak').slideUp();
          $('#kimia').prop('checked', false);
        }
      });

      $('#c_biodiv').on('click',function(){
        if($('#c_biodiv').is(':checked')) {
          $('#param_biodive').slideDown();
        }
        else{
          $('#param_biodive').slideUp();
          $('#haksenp').prop('checked', false);
        }
      });

      $('#c_biodivf').on('click',function(){
        if($('#c_biodivf').is(':checked')) {
          $('#param_biodivef').slideDown();
        }
        else{
          $('#param_biodivef').slideUp();
          $('#haksenf').prop('checked', true);
        }
      });

      $('#kimia').on('click',function(){
        if($('#kimia').is(':checked')) {
          $('#list_sifat').slideDown();
        }
        else{
          $('#list_sifat').slideUp();
        }

      });

  });
</script>

