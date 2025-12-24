@extends('layouts.adminlayout')
@section('title','Manajemen Pengumuman')
@section('active_pesan','active')
@section('breadcrumb')
<li><a href="{{route('admin.home')}}"><i class="fa fa-fw fa-home"></i> Home</a></li>
<li><a href="#">Pengumuman</a></li>
@endsection
@section('main_section')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Pengumuman</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body pad">
          <form method="post" action="{{route('admin.pengumuman.insert')}}"
          onsubmit="document.getElementById('submit_pengumuman').disabled=true;
          document.getElementById('submit_pengumuman').value='Sedang menerbitkan...';">
              {{csrf_field()}}
              <input type="hidden" id="input_by" name="input_by" value="{{ Auth::user()->id}}">
              <div id="mulai" style="display:none;">
                <textarea id="isi_pengumuman" name="isi_pengumuman" rows="10" cols="80" class="form-control">{{$isi_pengumuman}}</textarea>
                <div class="box-footer">
                  <input type="submit" id="submit_pengumuman" name="submit_pengumuman" value="Terbitkan" class="btn btn-success pull-right">
                </div>
              </div>

          </form>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->

  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">Pengumuman Tambahan / Link Download</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <form method="post" action="{{route('admin.pengumuman_tambah.insert')}}"
          onsubmit="document.getElementById('submit_download').disabled=true;
          document.getElementById('submit_download').value='Mengubah pengaturan...';">
              {{csrf_field()}}
              <input type="hidden" id="input_by2" name="input_by2" value="{{ Auth::user()->id}}">

              <textarea id="download_link" name="download_link" rows="10" cols="80" class="form-control">{{$isi_link}}</textarea>

                <div class="box-footer">
                  <input type="submit" id="submit_download" name="submit_pengumuman" value="Ubah" class="btn btn-success pull-right">

              </div>

          </form>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
  <script src="{{asset('Admin/modal_ajax.min.js')}}"></script>
  <script src="{{asset('Admin/bower_components/jquery/dist/jquery.min.js')}}"></script>
  @section('data_table')
  <script src="{{asset('Admin/bower_components/ckeditor/ckeditor.js')}}"></script>
  @endsection
  <script type="text/javascript">
  $(document).ready(function(){
    CKEDITOR.replace('isi_pengumuman')
    CKEDITOR.replace('download_link')
    $('#mulai').show();
    });
  </script>

  @endsection

