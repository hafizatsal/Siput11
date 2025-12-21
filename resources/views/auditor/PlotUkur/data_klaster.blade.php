@extends('layouts.layoutauditor')
@section('title','Klaster')
@section('active_plot_ukur','active')
@section('active_data_klaster','active')
@section('breadcrumb')
<li><a href="#">Data Klaster</a></li>
@endsection
@section('judul_halaman','Pilih Kategori Klaster')
@section('main_section')
<div class="row">
  <div class="col-xs-12">
<div class="box animated fadeIn slower" style="margin:20px auto 0 auto; width:50%">
  <div class="box-header">
      <h4>Pilih Kategori Klaster</h4>
      <hr>

      <form class="form-horizontal form-label-left" action="{{route('auditor.data_klaster.lihat')}}" method="GET">
          {{ csrf_field() }}
          <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pengukuranke">Pengukuran ke#
              </label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <select class="form-control" name="pengukuranke" id="pengukuranke">
                  <option value="%">Semua Pengukuran</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                </select>
              </div>
            </div>

              <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kategori">Kategori (Nama Pengukur)
                  </label>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                    <select class="form-control" name="kategori" id="kategori">
                      <option value="%">Semua Kategori Hutan</option>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tahun_pengukuran">Tahun
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                      <select class="form-control" name="tahun_pengukuran" id="tahun_pengukuran">
                        <option value="%">Semua Tahun Pengukuran</option>
                      </select>
                    </div>
                  </div>

                <button style="margin-top:10px; width:170px;" type="submit" name="lihat" id="lihat" value="lihat" class="btn btn-primary center-block"><i class="fa fa-search"></i> Lihat Data Klaster</button>
        </form>

  </div>
</div>
</div>
</div>
@include('auditor.include.data_klaster.modal-tambah_data_klaster')
@endsection

@push('script_tambahan')
<script src="{{asset('Admin/modal_ajax.min.js')}}"></script>
@endpush

@push('script_tambahan')
<script type="text/javascript">
$(document).ready(function(){

  $('#tambah_data').click(function(e){
    $('#tambah_data_klaster').modal('show');

  });

  $('#pengukuranke').change(function(e){
    $(".loading").show();
    var pengukuran_ke = e.target.value;
    $.ajax({
        type: 'post',
        url: '{{route("auditor.json_data_kategori")}}',
        data: {
          '_token': $('input[name=_token]').val(),
          'id': pengukuran_ke,
        },
        success: function (data) {
          if (data.length > 0) {
            $('#kategori').empty();
            $('#kategori').append('<option value="%" disable="true" selected="true">Pilih Kategori</option>');
            $.each(data, function (key, value) {
          $('#kategori').append('<option value="' + value['kategori'] + '">' + value['kategori'] + ' (' + value['nama_pengukur'] + ')' + '</option>');
          });
        }
        else{
          $('#kategori').empty();
          $('#kategori').append('<option value="%" disable="true" selected="true">Data kosong</option>');
        }
        $(".loading").hide();
      }
      });
  });

  $('#kategori').change(function(e){
    $(".loading").show();
    var kategori = e.target.value;
    var pengukuran_ke = $('#pengukuranke').val();
    $.ajax({
        type: 'post',
        url: '{{route("auditor.json_data_tahun")}}',
        data: {
          '_token': $('input[name=_token]').val(),
          'id': kategori,
          'pengke' : pengukuran_ke,
        },
        success: function (data) {
          if (data.length > 0) {
            $('#tahun_pengukuran').empty();
            $('#tahun_pengukuran').append('<option value="%" disable="true" selected="true">Pilih Tahun</option>');
            $.each(data, function (key, value) {
          $('#tahun_pengukuran').append('<option value="' + value['id_data_klaster'] + '">' + value['tahun_pengukuran'] + '</option>');
          });
        }
        else{
          $('#tahun_pengukuran').empty();
          $('#tahun_pengukuran').append('<option value="%" disable="true" selected="true">Data kosong</option>');
        }
        $(".loading").hide();
      }
      });
  });
});
</script>
@endpush