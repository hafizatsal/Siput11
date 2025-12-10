@extends('layouts.layout')
@section('title','Halaman Test')
@section('css')
@endsection
@section('active-treeview','active')
@section('judul_halaman','Halaman Test')
@section('main_section')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">File Upload</div>
                <div class="card-body">
                <form method="POST" action="" aria-label="">
                        @csrf
                        <div class="form-group row">
                            <label for="title" class="col-sm-4 col-form-label text-md-right">{{ __('Title') }}</label>
                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control" name="title" value="" required autofocus />

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="overview" class="col-sm-4 col-form-label text-md-right"></label>
                            <div class="col-md-6">
                                <textarea id="overview" cols="10" rows="10" class="form-control" name="overview" value="" required autofocus>{{$test}}</textarea>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="price" class="col-md-4 col-form-label text-md-right"></label>
                            <div class="col-md-6">
                                <input id="price" type="text" class="form-control" name="price" required>

                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">

                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
