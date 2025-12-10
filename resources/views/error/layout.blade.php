<!DOCTYPE html>
<html>
<head>
  <link rel="shortcut icon" type="image/x-icon" href="{{asset('img/Siput.png')}}" />
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SIPUT | @yield('title')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{asset('Admin/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('Admin/bower_components/Ionicons/css/ionicons.min.css')}}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('Admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('Admin/dist/css/AdminLTE.min.css')}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{asset('Admin/dist/css/skins/_all-skins.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/animate.css')}}">

  @yield('css')
  <style>
  .table-striped>thead {
    background-color: #F0F3F5;
  }
  .table-striped>tbody>tr:nth-child(even)>td,
  .table-striped>tbody>tr:nth-child(even)>th {
    background-color: #F2F2F2;

  }
  </style>
</head>

<body class="hold-transition lockscreen">

  <div class="lockscreen-wrapper">
  <div class="lockscreen-logo">
    <b>SIPUT</b>
  </div>
  <!-- User name -->
  <div class="lockscreen-name">@yield('header')</div>

  <!-- /.lockscreen-item -->
  <div class="help-block text-center">
    @yield('msg')<br><br>
    <a href="/" class="btn btn-primary">Kembali</a>
  </div>
  <div class="lockscreen-footer text-center">
    <br>Copyright &copy; SIPUT {{date('Y')}}
    All rights reserved.
  </div>
</div>

  <!-- jQuery 3 -->
  <script src="{{asset('Admin/bower_components/jquery/dist/jquery.min.js')}}"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="{{asset('Admin/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
  @yield('data_table')
  <!-- SlimScroll -->
  <script src="{{asset('Admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
  <!-- FastClick -->
  <script src="{{asset('Admin/bower_components/fastclick/lib/fastclick.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{asset('Admin/dist/js/adminlte.min.js')}}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{asset('Admin/dist/js/demo.js')}}"></script>
  <!-- page script -->
</body>
  </html>
