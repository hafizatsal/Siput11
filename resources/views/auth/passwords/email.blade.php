<!DOCTYPE html>
<html>
<head>
  <link rel="shortcut icon" type="image/x-icon" href="{{asset('img/Siput.png')}}" />
    <meta charset="UTF-8">
    <title>Kesehatan Hutan</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{asset('/css/all.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/login.css')}}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome -->
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
                    <a href="{{ url('/home') }}" style="font-size:20pt"><b>RESET PASSWORD </b></a>

                </div><!-- /.login-logo -->
                    <p class="login-box-msg" style="font-size:9pt;"> SILAHKAN MASUKKAN EMAIL UNTUK RESET PASSWORD ANDA</p>
                    @if (session('status'))
                      <div class="alert alert-success">
                          {{ session('status') }}
                      </div>
                    @endif
                    <form action="{{ route('password.email') }}" method="post">
                      @csrf
                        <div class="input-group">
                            <input placeholder="Email" id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                            <span class="input-group-addon"><i class="fa fa-fw fa-envelope"></i></span>
                        </div>
                        @if ($errors->has('email'))
                        <div class="form-group has-error">
                          <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                          </span>
                        </div>
                        @endif

                        <br>

                        <div class="row">
                            <div class="col-xs-8">
                                  Gunakan <a href="{{config('app.url')}}">akun lain</a>.
                            </div><!-- /.col -->
                            <div class="col-xs-4">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Reset</button>
                            </div><!-- /.col -->
                        </div>
                        <br>
                        <div class="alert alert-warning">
                            Jika Anda tidak menerima notifikasi email, harap hubungi administrator secara manual (siputunila@gmail.com) untuk mendapatkan link.
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
