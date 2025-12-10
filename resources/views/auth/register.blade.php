<!DOCTYPE html>
<html>
<head>
  <link rel="shortcut icon" type="image/x-icon" href="{{asset('img/Siput.png')}}" />
    <meta charset="UTF-8">
    <title>Kesehatan Hutan</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('/css/all.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/login.css') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{asset('Admin/bower_components/font-awesome/css/font-awesome.min.css')}}">

</head>
<body class="hold-transition login-page"></body>
        <div id="app" v-cloak>
            <div class="login-box">
                <div class="login-box-body">
                    <div class="div-left-img">
                        <img src="{{asset('img/logo_unila.png')}}" class="center-block" style="width:120px;">
                    </div>
                    <div class="div-right-img">
                        <img src="{{asset('img/dikti.png')}}" class="center-block" style="width:120px;">
                    </div>

                <div class="login-logo">
                    <a href="{{ url('/') }}" style="font-size:20pt"><b>REGISTRASI SIPUT </b></a>

                </div><!-- /.login-logo -->
                    <p class="login-box-msg" style="font-size:9pt;"> SILAHKAN MELAKUKAN REGISTRASI UNTUK MEMULAI PENILAIAN/ENTRI DATA KESEHATAN HUTAN</p>
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Opps!</strong> Ada permasalahan : <br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form action="{{ url('/register') }}" method="post"
                    onsubmit="document.getElementById('submit').disabled=true;
                    document.getElementById('submit').value='Registering...';">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        {{--  <login-input-field
                                name="{{ config('auth.providers.users.field','email') }}"
                                domain="{{ config('auth.defaults.domain','') }}"
                        ></login-input-field>  --}}
                        <div class="input-group">
                                <input type="text" class="form-control" placeholder="Nama" name="nama"/ required>
                                <span class="input-group-addon"><i class="fa fa-fw fa-user"></i></span>
                        </div>
                        <br>

                        <div class="input-group">
                                <input type="text" class="form-control" placeholder="Email" name="email" required/>
                                <span class="input-group-addon"><i class="fa fa-fw fa-envelope"></i></span>
                        </div>
                        <br>

                        <div class="input-group">
                          <input placeholder="Instansi" type="text" name="instansi" value="" class="form-control">
                          <span class="input-group-addon"><i class="fa fa-fw fa-building"></i></span>
                        </div>
                        <br>

                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Username" name="username" required/>
                            <span class="input-group-addon">@</span>
                        </div>
                        <br>
                        <div class="input-group">
                            <input type="password" class="form-control" placeholder="Password" name="password" required/>
                            <span class="input-group-addon"><i class="fa fa-fw fa-lock"></i></span>
                        </div>
                      <br>
                        <div class="input-group">
                            <input id="password-confirm" type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation" required/>
                            <span class="input-group-addon"><i class="fa fa-fw fa-lock"></i></span>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-xs-7">
                            </div>
                            <!-- /.col -->
                            <div class="col-xs-5">
                                <input type="submit" id="submit" class="btn btn-primary btn-block btn-flat" value="Registrasi">
                            </div>
                            <!-- /.col -->
                            <div class="col-xs-12">
                                <div class="checkbox icheck">
                                        Sudah Punya Akun? Klik <a href="{{ url('/login') }}">disini </a>untuk login
                                </div>
                            </div>
                        </div>
                    </form>

              </div><!-- /.login-box-body -->
            </div><!-- /.login-box -->
        </div>

        <script src="{{ asset('/js/app.js') }}"></script>

    <script>

    </script>
    </body>
</html>
