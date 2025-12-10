@extends('layouts.layout')
@section('title','Warning')
@section('judul_halaman','Warning')
@section('title_box','Selamat datang di Sistem Informasi Penilaian Kesehatan Hutan')
@section('breadcrumb')
<li><a href="javascript:history.back()">Kembali</a></li>
@endsection
@section('main_section')
<div class="error-page">
        <h2 class="headline text-red">500</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-red"></i> Oops! {{$pesan}}!</h3>

          <p>
            Coba periksa apakah data pengukuran sudah dimasukkan dengan benar.
            Sementara itu, coba <a href="{{route('user.detail_klaster', encrypt($id_klaster))}}">periksa data pengukuran</a>.
          </p>
        </div>
      </div>
      <!-- /.error-page -->
@endsection
