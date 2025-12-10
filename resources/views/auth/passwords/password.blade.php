<!DOCTYPE html>
<html>
<head>
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
                    <a href="{{ url('/home') }}" style="font-size:20pt"><b>RESET SIPUT </b></a>

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
                            <span class="input-group-addon">@</span>
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
                                  Gunakan akun lain <a href="config('app.url')">login</a>
                            </div><!-- /.col -->
                            <div class="col-xs-4">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Reset</button>
                            </div><!-- /.col -->
                        </div>
                    </form>

                </div><!-- /.login-box-body -->

            </div><!-- /.login-box -->
        </div>

        <script src="{{ asset('/js/app.js') }}"></script>

    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
    </body>
</html>


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" aria-label="{{ __('Reset Password') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
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
