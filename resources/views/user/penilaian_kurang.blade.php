@extends('layouts.layout')
@section('title','Warning')
@section('judul_halaman','Warning')
@section('title_box','Selamat datang di Sistem Informasi Penilaian Kesehatan Hutan')

@section('main_section')
<div class="error-page">
        <h2 class="headline text-red">501</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-red"></i> Oops! {{$pesan}}!</h3>

          <p>
            Kembali ke halaman <a href="{{route('user.penilaian_klaster')}}">penilaian</a>.
          </p>
        </div>
      </div>
      <!-- /.error-page -->
@endsection
