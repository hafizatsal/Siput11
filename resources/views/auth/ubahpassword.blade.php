@extends('layouts.layout')
@section('title','Halaman Profile')
@section('breadcrumb')
<li><a href="#">Home</a></li>
@endsection
@section('main_section')

<div class="row">
   <div class="col-xs-12">
     <div class="box box-primary">
       <div class="box-header with-border">
         <h3 class="box-title">Ubah Password</h3>
       </div>
        <div class="box-body">
          @if (session('error'))
            <div class="alert alert-danger"> {{ session('error') }} </div>
          @endif
          @if (session('success'))
            <div class="alert alert-success"> {{ session('success') }} </div>
          @endif
          <form id="form-change-password" role="form" method="POST" action="{{route('password_ubah')}}"
          novalidate class="form-horizontal">
          <div class="col-md-9">
            <label for="current-password" class="col-sm-4 control-label">Current Password</label>
            <div class="col-sm-8">
              <div class="form-group">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="password" class="form-control" id="current-password" name="current-password" placeholder="Password">
              </div>
            </div>
            <label for="password" class="col-sm-4 control-label">New Password</label>
            <div class="col-sm-8">
              <div class="form-group">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
              </div>
            </div>
            <label for="password_confirmation" class="col-sm-4 control-label">Re-enter Password</label>
            <div class="col-sm-8">
              <div class="form-group">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Re-enter Password">
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-5 col-sm-6">
              <input type="submit" id="ubahpw" class="btn btn-success" value="Ubah">
            </div>
          </div>
        </form>
        </div>
      </div>
    </div>
</div>
<script src="{{asset('Admin/modal_ajax.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/jquery/dist/jquery.min.js')}}"></script>


@endsection
