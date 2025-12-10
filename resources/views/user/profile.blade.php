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
         <h3 class="box-title">Profile {{Auth::user()->username}}</h3>
       </div>
        <div class="box-body box-profile">
          @if($cek_foto_user!=0)
            <img class="profile-user-img img-responsive img-circle" src="{{asset('upload/profile/'. $role->filename)}}" alt="User profile picture">
          @else
          <img class="profile-user-img img-responsive img-circle" src="{{asset('Admin/dist/img/default-user.png')}}" alt="User profile picture">
          @endif
            <h3 class="profile-username text-center">{{Auth::user()->nama}}</h3>

            <p class="text-muted text-center">{{$role->role_name}}</p>

          <div class="col-xs-12 table-responsive">
          <table id="detail_plot" class="table">
            <tbody>
              <tr>
                <td style="width:20%;">Nama Pengguna</td>
                <td> : {{Auth::user()->nama}}</td>
                <td></td>
              </tr>

              <tr>
                <td>Peran</td>
                <td> : {{$role->role_name}}</td>
                <td></td>
              </tr>

              <tr>
                <td>Instansi</td>
                <td> : {{$role->instansi}} </td>
                <td></td>
              </tr>

            </tbody>
            <tfoot>

            </tfoot>
          </table>


        </div>
        <div class="box-footer pull-right">
          <button type="button" name="edit" id="edit" class="btn btn-success" data-toggle="modal" data-target="#modal_edit_profile">Edit</button>
          <a name="ubah_password" id="ubah_password" class="btn btn-warning" href="{{route('user.ubah_password')}}">Ubah Password</a>
          </div>
        </div>
      </div>
    </div>
</div>
<script src="{{asset('Admin/modal_ajax.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/jquery/dist/jquery.min.js')}}"></script>

@include('user.include.profile.modal_edit_profile')
@endsection
