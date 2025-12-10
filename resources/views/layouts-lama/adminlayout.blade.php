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

  @media only screen and (max-width: 767px){
    .box{
      width: 100% !important;
    }
    .box-header .box-title {
      font-size: 14px;
    }
    .box-header h2 {
      font-size: 14px;
    }
    .btn{
      padding: 3px 6px;
    }
    div.table-responsive>div.dataTables_wrapper>div.row>div[class^="col-"]:last-child {
      padding-right: 0;
      padding-left: 0;
    }
    div.table-responsive>div.dataTables_wrapper>div.row>div[class^="col-"]:first-child {
      padding-left: 0;
      padding-right: 0;
    }

    div.dataTables_wrapper div.dataTables_paginate {
      text-align: unset;
    }
    div.dataTables_wrapper div.dataTables_length, div.dataTables_wrapper div.dataTables_filter, div.dataTables_wrapper div.dataTables_info, div.dataTables_wrapper div.dataTables_paginate {
      text-align: unset;
    }
  }
  </style>
  <!-- Author by: Rendy Wijaya -->
  <!-- NPM: 1517051082 -->
  <!-- Title: SIPUT UNILA -->

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
  @php($foto = DB::table('foto_user')->where('id_user','=',Auth::user()->id)->first())
    @php($foto_get = DB::table('foto_user')->where('id_user','=',Auth::user()->id)->get())
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="{{route('home')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="{{asset('img/Siput.png')}}" height="45px" width="45px"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="{{asset('img/Siput.png')}}" height="45px" width="45px"></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">

      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="#" id="img1" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ Auth::user()->nama}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="#" id="img2" class="img-circle" alt="User Image">

                <p>
                  {{ Auth::user()->nama}}
                </p>
              </li>
              <!-- Menu Body -->

              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{route('profile2')}}" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{{route('logout')}}" class="btn btn-default btn-flat">Log out</a>
                </div>
              </li>
            </ul>
          </li>

        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="#" id="img3" class="img-circle" alt="User Image" style="height:50px;">
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->nama}} (Admin)</p>
        </div>
      </div>

      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">PANEL UTAMA</li>

        <li class="@yield('active_home')"><a href="{{route('home')}}"><i class="fa fa-home"></i> <span>Home</span>
          <span class="pull-right-container">
            <small class="label pull-right bg-green">Admin</small>
          </span>
        </a></li>

        <li class="@yield('active_user')"><a href="{{route('user')}}"><i class="fa fa-book"></i> <span>Manajemen User</span></a></li>
        <li class="@yield('active_lokasi')"><a href="{{route('lokasi')}}"><i class="fa fa-book"></i> <span>Manajemen Lokasi</span></a></li>
        <li class="@yield('active_hmjf')"><a href="{{route('hmjf')}}"><i class="fa fa-book"></i> <span>Hak Milik dan Fungsi Hutan</span></a></li>
        <li class="@yield('active_pohon')"><a href="{{route('pohon')}}"><i class="fa fa-book"></i> <span>Data Pohon</span></a></li>
        <li class="@yield('active_fauna')"><a href="{{route('fauna')}}"><i class="fa fa-book"></i> <span>Data Fauna</span></a></li>

        <li class="treeview @yield('active_indikator')">
          <a href="#">
            <i class="fa fa-fw fa-pie-chart"></i> <span>Nilai Indikator</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="@yield('active_tajuk')"><a href="{{route('nilai_tajuk')}}"><i class="fa fa-circle-o"></i>Nilai Tajuk</a></li>
            <li class="@yield('active_krlokasi')"><a href="{{route('nilai_kerusakan_lokasi')}}"><i class="fa fa-circle-o"></i>Nilai Lokasi Kerusakan</a></li>
            <li class="@yield('active_krtipe')"><a href="{{route('nilai_kerusakan_tipe')}}"><i class="fa fa-circle-o"></i>Nilai Tipe Kerusakan</a></li>
            <li class="@yield('active_krkeparahan')"><a href="{{route('nilai_kerusakan_keparahan')}}"><i class="fa fa-circle-o"></i>Nilai Keparahan Kerusakan</a></li>
            <li class="@yield('active_sifat_tanah')"><a href="{{route('sifat_tanah')}}"><i class="fa fa-circle-o"></i> <span>Sifat Kimia Tanah</span></a></li>
          </ul>
        </li>

        <li class="@yield('active_pesan')"><a href="{{route('pengumuman')}}"><i class="fa fa-book"></i> <span>Manajemen Pemberitahuan</span></a></li>
        <li class="@yield('active_berkas')"><a href="{{route('berkas')}}"><i class="fa fa-book"></i> <span>Manajemen Berkas</span></a></li>
        </ul>
<!--

        <li class="@yield('active_plot')"><a href="{{route('plot')}}"><i class="fa fa-book"></i> <span>Data Plot</span></a></li> -->

        <!-- <li class="@yield('active-treeview') treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Kesehatan Hutan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              </ul>
        </li> -->


    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        @yield('judul_halaman')
        <small>@yield('judul_kecil')</small>
      </h1>
      <ol class="breadcrumb">
@yield('breadcrumb')
      </ol>
    </section>

    <!-- Main content -->
    <section id="tes" class="content">
      @if(session()->has('insert'))
      <div class="col-xs-12">
        <div class="row">
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Alert!</h4>
            {{ session()->get('insert') }}
          </div>
        </div>
      </div>
      @elseif(session()->has('edit'))
      <div class="col-xs-12">
        <div class="row">
          <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-warning"></i> Alert!</h4>
            {{ session()->get('edit') }}
          </div>
        </div>
      </div>
      @elseif(session()->has('delete'))
      <div class="col-xs-12">
        <div class="row">
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
            {{ session()->get('delete') }}
          </div>
        </div>
      </div>
      @endif
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
    @yield('main_section')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer animated fadeIn slower">
    <div class="pull-right hidden-xs">
      <b>Version</b> {{config('app.version')}}
    </div>
    <strong>Copyright &copy; {{date('Y')}} <a href="/">SIPUT</a>.</strong> All rights
    reserved.
  </footer>


  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

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
<script>
@yield('script_table')

$(document).ready(function(){

  @if(count($foto_get)!=0){
    $("#img1").attr("src","{{asset('upload/profile/'. $foto->filename)}}");
    $("#img2").attr("src","{{asset('upload/profile/'. $foto->filename)}}");
    $("#img3").attr("src","{{asset('upload/profile/'. $foto->filename)}}");
  }
  @else{
    $("#img1").attr("src","{{asset('Admin/dist/img/default-user.png')}}");
    $("#img2").attr("src","{{asset('Admin/dist/img/default-user.png')}}");
    $("#img3").attr("src","{{asset('Admin/dist/img/default-user.png')}}");
  }
  @endif


});
</script>
</body>
</html>
