@extends('layouts.adminlayout')
@section('title','Manajemen Berkas')
@section('active_berkas','active')
@section('breadcrumb')
<li><a href="{{route('home')}}"><i class="fa fa-fw fa-home"></i> Home</a></li>
<li><a href="#">Berkas</a></li>
@endsection
@section('main_section')
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">Berkas</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <form role="form" method="post" action="{{route('admin.berkas_edit')}}" enctype="multipart/form-data"
          onsubmit="document.getElementById('submit_berkas').disabled=true;
          document.getElementById('submit_berkas').value='Sedang mengupload...';">
          {{csrf_field()}}
              <input type="hidden" id="input_by" name="input_by" value="{{ Auth::user()->id}}">

              <div class="form-group">
                <label for="file_panduan">1. File Panduan SIPUT</label>
                <input type="file" name="file_panduan" id="file_panduan" class="form-group">
              </div>

              <div class="form-group">
                <label for="file_tally">2. File Tally Sheet</label>
                <input type="file" name="file_tally" id="file_tally">
              </div>

              <div class="box-footer">
                <input type="submit" id="submit_berkas" name="submit_berkas" value="Ubah" class="btn btn-success pull-right">

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

  <script type="text/javascript">
  $(document).ready(function(){

    });
  </script>

  @endsection
