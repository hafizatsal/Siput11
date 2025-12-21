@extends('layouts.layoutauditor')

@section('title','Halaman Skoring')

@section('css')
    <link rel="stylesheet" href="{{asset('Admin/bower_components/morris.js/morris.css')}}">
    <link rel="stylesheet" href="{{asset('Admin/cdn/table-responsive.css')}}">

    <link rel="stylesheet"
          href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css"
          integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
          crossorigin=""/>

    <link rel="stylesheet"
          href="https://unpkg.com/esri-leaflet-geocoder@2.2.13/dist/esri-leaflet-geocoder.css"
          integrity="sha512-v5YmWLm8KqAAmg5808pETiccEohtt8rPVMGQ1jA6jqkWVydV5Cuz3nJ9fQ7ittSxvuqsvI9RSGfVoKPaAJZ/AQ=="
          crossorigin="">
@endsection

@section('active_penilaian','active')
@section('active_nilai_akhir','active')
@section('judul_halaman','Halaman Skoring')

@section('breadcrumb')
    <li><a href="javascript:history.back()">Nilai Akhir Kesehatan Hutan</a></li>
    <li><a href="#">Nilai Kesehatan Plot</a></li>
@endsection

@section('main_section')

    {{-- =================== NILAI KESEHATAN KLASTER (CHART) =================== --}}
    @if($jumlah_plot!=1)
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title"><b>Skoring Kesehatan Hutan Klaster Plot {{$kode_klaster_plot}}</b></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>

            <div class="box-body chart-responsive">
                <h4>Pengukuran ke-{{$pengukuran_ke}}</h4>
                <canvas id="densityChart" width="600" height="150"></canvas>
                <div class="text-center">
                    <button type="button" class="btn btn-success"></button>Baik
                    <button type="button" class="btn btn-warning"></button>Sedang
                    <button type="button" class="btn btn-danger"></button>Buruk
                </div>
            </div>
        </div>
    @endif

    {{-- =================== PETA LOKASI =================== --}}
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title"><b>Lokasi Plot Penilaian dan atau Pemantauan Kesehatan Hutan</b></h3>
        </div>
        <div class="box-body">
            <div id="mapid" class="box-body chart-responsive" style="height:250px;"></div>
        </div>
    </div>

    {{-- =================== NILAI KESEHATAN PER PLOT =================== --}}
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><b>Nilai Kesehatan per Plot</b></h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table id="nilai_kesehatan" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th style="vertical-align: middle; width:15%;">Nama Plot</th>
                        <th style="vertical-align: middle;">Nilai Kesehatan per Plot</th>
                        <th style="text-align: center; vertical-align: middle; width:4%">Kondisi</th>
                        <th style="text-align: center; vertical-align: middle; width:4%">Lihat Detail</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php($i=0)
                    @foreach($id_plot as $value)
                        <tr>
                            <td>{{$value->nama_plot}}</td>
                            <td>{{$na_total[$i]}}</td>
                            <td style="text-align: center; vertical-align: middle">
                                @if($nilai_skor[$i]=="Baik")
                                    <span class='label label-success'>O</span>
                                @endif
                                @if($nilai_skor[$i]=="Sedang")
                                    <span class='label label-warning'>O</span>
                                @endif
                                @if($nilai_skor[$i]=="Buruk")
                                    <span class='label label-danger'>O</span>
                                @endif
                            </td>
                            <td style="text-align: center; vertical-align: middle">
                                <form id="detail{{$i}}" method="post"
                                      action="{{route('auditor.penilaian.kesehatan.detail_plot')}}">
                                    @csrf
                                    <input type="hidden" name="pengukuran_ke" value="{{$pengukuran_ke}}">
                                    <input type="hidden" name="id_plot" value="{{$value->id_plot}}">
                                    <input type="hidden" name="p_lbds" value="{{$p_lbds}}">
                                    <input type="hidden" name="p_volume" value="{{$p_volume}}">
                                    <input type="hidden" name="p_kerusakan" value="{{$p_kerusakan}}">
                                    <input type="hidden" name="p_ktjk" value="{{$p_ktjk}}">
                                    <input type="hidden" name="p_kimia" value="{{$p_kimia}}">
                                    <input type="hidden" name="sifat-sifat_kimia" value="{{$sifat_kimia}}">
                                    <input type="hidden" name="p_fisik" value="{{$p_fisik}}">
                                    <input type="hidden" name="p_jpliu" value="{{$p_jpliu}}">
                                    <input type="hidden" name="p_dmg" value="{{$p_dmg}}">
                                    <input type="hidden" name="haksenp" value="{{$haksenp}}">
                                    <input type="hidden" name="haksenf" value="{{$haksenf}}">
                                </form>

                                <a class="fa fa-search btn btn-success btn-xs"
                                   onclick="document.getElementById('detail{{$i}}').submit()"></a>
                            </td>
                        </tr>
                        @php($i++)
                    @endforeach
                    </tbody>
                    <tfoot></tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- =================== RANGE SKOR KESEHATAN KLASTER =================== --}}
    <div class="box box-primary collapsed-box">
        <div class="box-header with-border">
            <h3 class="box-title"><b>Range Skor Kesehatan Klaster Plot {{$kode_klaster_plot}}</b></h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th style="vertical-align: middle">Skor</th>
                        <th style="text-align: center; vertical-align: middle">Min</th>
                        <th style="text-align: center; vertical-align: middle">-</th>
                        <th style="text-align: center; vertical-align: middle">Max</th>
                        <th>Kondisi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @for($i=1;$i<=3;$i++)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$range_nks_l[$i-1]}}</td>
                            <td>-</td>
                            <td>{{$range_nks_r[$i]}}</td>
                            <td>
                                @if($kondisi[$i-1]=="Baik")
                                    <span class="label label-success">O</span>
                                @elseif($kondisi[$i-1]=="Sedang")
                                    <span class="label label-warning">O</span>
                                @else
                                    <span class="label label-danger">O</span>
                                @endif
                                {{$kondisi[$i-1]}}
                            </td>
                        </tr>
                    @endfor
                    </tbody>
                    <tfoot></tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- =================== DATA KUALITAS TAPAK (KIMIA) =================== --}}
    @if($p_kimia!="")
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title"><b>Data Kualitas Tapak (Kimia)</b></h3>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Sifat Kimia</th>
                            <th>CEC (me/100 g)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php($id=1)
                        @foreach($data_ktk_kimia as $sifat_kimia)
                            <tr>
                                <td>{{$sifat_kimia->sifat_kimia}}</td>
                                <td>{{$sifat_kimia->cec}}</td>
                            </tr>
                            @php($id++)
                        @endforeach
                        @if($id==1)
                            <tr>
                                <td colspan="2" style="text-align: center; vertical-align: middle">Tidak ada data</td>
                            </tr>
                        @endif
                        </tbody>
                        <tfoot></tfoot>
                    </table>
                </div>
            </div>
        </div>
    @endif

    {{-- =================== DATA KUALITAS TAPAK (FISIK) =================== --}}
    @if($p_fisik!="")
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title"><b>Data Kualitas Tapak (Fisika)</b></h3>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="data_ktk_fisik" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th rowspan="2" style="text-align: center; vertical-align: middle">Titik Plot</th>
                            <th colspan="2" style="text-align: center; vertical-align: middle">Penutupan tanah <br> %</th>
                            <th rowspan="2" style="text-align: center; vertical-align: middle">Tekstur tanah</th>
                            <th rowspan="2" style="text-align: center; vertical-align: middle">Warna tanah</th>
                            <th rowspan="2" style="text-align: center; vertical-align: middle">
                                Ketebalan <br> Lapisan tanah <br> (cm)
                            </th>
                            <th colspan="2" style="text-align: center; vertical-align: middle">Titik Koordinat</th>
                        </tr>
                        <tr>
                            <th style="text-align: center; vertical-align: middle">Terbuka</th>
                            <th style="text-align: center; vertical-align: middle">Tertutup</th>
                            <th style="text-align: center; vertical-align: middle">Lintang <br> o/U/S</th>
                            <th style="text-align: center; vertical-align: middle">Bujur <br> o/B/T</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php($format = "%d ᴼ %d ’ %s ” %s")
                        @foreach($data_fisik as $data_fisik)
                            @php($l_splitName_p = explode(' ', $data_fisik->lintang_tanah, 3))
                            @php($l_splitName2_p = $l_splitName_p[1] ?? 0)
                            @php($l_splitName3_p = $l_splitName_p[2] ?? 0)

                            @php($ket_lintang_pt = $l_splitName_p[0] >= 0 ? 'LU' : 'LS')
                            @if($ket_lintang_pt == 'LS')
                                @php($l_splitName_p[0] = $l_splitName_p[0] * -1)
                            @endif

                            @php($l_splitName_pb = explode(' ', $data_fisik->bujur_tanah, 3))
                            @php($l_splitName2_pb = $l_splitName_pb[1] ?? 0)
                            @php($l_splitName3_pb = $l_splitName_pb[2] ?? 0)

                            @php($ket_bujur_pt = $l_splitName_pb[0] >= 0 ? 'BT' : 'BB')
                            @if($ket_bujur_pt == 'BB')
                                @php($l_splitName_pb[0] = $l_splitName_pb[0] * -1)
                            @endif

                            <tr>
                                <td>{{$data_fisik->titik_plot}}</td>
                                <td>{{$data_fisik->terbuka}}</td>
                                <td>{{$data_fisik->tertutup}}</td>
                                <td>{{$data_fisik->tekstur}}</td>
                                <td>{{$data_fisik->warna_tanah}}</td>
                                <td>{{$data_fisik->ketebalan}}</td>
                                <td>{{sprintf($format, $l_splitName_p[0], $l_splitName2_p, $l_splitName3_p, $ket_lintang_pt)}}</td>
                                <td>{{sprintf($format, $l_splitName_pb[0], $l_splitName2_pb, $l_splitName3_pb, $ket_bujur_pt)}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot></tfoot>
                    </table>
                </div>
            </div>
        </div>
    @endif

    {{-- =================== DATA BIODIVERSITAS FAUNA =================== --}}
    @if($haksenf!="" || $p_jpliuf!="" || $p_dmgf!="")
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><b>Data Biodiversitas Fauna</b></h3>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="table-indikator" style="padding:10px;">
                        <thead>
                        <tr>
                            <th style="width:10%">#</th>
                            <th style="width:25%">Nama Fauna</th>
                            <th style="width:25%">Nama Latin</th>
                            <th>Jumlah</th>
                            <th>ni</th>
                            <th>ln(ni)</th>
                            <th>H'</th>
                            @if($p_jpliuf)
                                <th>J'</th>
                            @endif
                            @if($p_dmgf)
                                <th>DMg</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @php ($nmr=1)
                        @php($jumlah_total=0)
                        @php($total_jpliuf=0)
                        @php($total_dmgf=0)
                        @foreach($jumlah_fauna as $d)
                            <tr>
                                <td>{{$nmr}}</td>
                                <td>{{$d->nama_fauna}}</td>
                                <td><i>{{$d->nama_latin_fauna}}</i></td>
                                <td>{{$nf[$nmr-1]}}</td>
                                <td>{{$nif[$nmr-1]}}</td>
                                <td>{{$ln_nif[$nmr-1]}}</td>
                                <td>{{$ni_ln_nif[$nmr-1]}}</td>
                                @if($p_jpliuf)
                                    <td>{{$j_pliuf[$nmr-1]}}</td>
                                @endif
                                @if($p_dmgf)
                                    <td>{{$d_mgf[$nmr-1]}}</td>
                                @endif
                                @php($jumlah_total += $nf[$nmr-1])
                                @php($total_jpliuf += $j_pliuf[$nmr-1] ?? 0)
                                @php($total_dmgf += $d_mgf[$nmr-1] ?? 0)
                                @php($nmr++)
                            </tr>
                        @endforeach
                        </tbody>
                        <thead>
                        <tr>
                            <th>Jumlah</th>
                            <th></th>
                            <th></th>
                            <th>{{$jumlah_total}}</th>
                            <th></th>
                            <th></th>
                            <th>@if($haksenf!=""){{$rata_h_aksenf}}@endif</th>
                            @if($p_jpliuf)
                                <th>{{$rata_j_pliuf}}</th>
                            @endif
                            @if($p_dmgf)
                                <th>{{$rata_dmgf}}</th>
                            @endif
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    @endif

    {{-- =================== NILAI PERHITUNGAN PER PLOT =================== --}}
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><b>Nilai Perhitungan Kesehatan Hutan per Plot</b></h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_4" data-toggle="tab">Nilai Analisis</a></li>
                    <li><a href="#tab_3" data-toggle="tab">Nilai Skor</a></li>
                    <li><a href="#tab_2" data-toggle="tab">Nilai Tertimbang</a></li>
                    <li><a href="#tab_1" data-toggle="tab">Nilai Indikator Kesehatan</a></li>
                </ul>
                <div class="tab-content">
                    {{-- TAB 1: Nilai Indikator --}}
                    <div class="tab-pane fade" id="tab_1">
                        <table id="Nilai_Indikator" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th style="text-align: center; vertical-align: middle">Nama Plot</th>
                                @if($p_lbds!="")
                                    <th style="text-align: center; vertical-align: middle">Nilai LBDS <br> (NS X NT)</th>
                                @endif
                                @if($p_volume!="")
                                    <th style="text-align: center; vertical-align: middle">Nilai Volume <br> (NS X NT)</th>
                                @endif
                                @if($p_ktjk!="")
                                    <th style="text-align: center; vertical-align: middle">Nilai Kondisi Tajuk <br> (NS X NT)</th>
                                @endif
                                @if($p_kerusakan!="")
                                    <th style="text-align: center; vertical-align: middle">Nilai Kerusakan <br> (NS X NT)</th>
                                @endif
                                @if($haksenp!="")
                                    <th style="text-align: center; vertical-align: middle">Nilai H' Pohon <br> (NS X NT)</th>
                                @endif
                                @if($p_jpliu!="")
                                    <th style="text-align: center; vertical-align: middle">Nilai J' Pohon <br> (NS X NT)</th>
                                @endif
                                @if($p_dmg!="")
                                    <th style="text-align: center; vertical-align: middle">Nilai DMg Pohon <br> (NS X NT)</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @php($i=0)
                            @foreach($id_plot as $value)
                                <tr>
                                    <td>{{$value->nama_plot}}</td>
                                    @if($p_lbds!="")
                                        <td>{{$skor_lbds[$i]}} x {{$nt_produktivitas[$i]}} = {{$na_lbds[$i]}}</td>
                                    @endif
                                    @if($p_volume!="")
                                        <td>{{$skor_volume[$i]}} x {{$nt_produktivitas[$i]}} = {{$na_volume[$i]}}</td>
                                    @endif
                                    @if($p_ktjk!="")
                                        <td>{{$skor_vcr[$i]}} x {{$nt_ktjk[$i]}} = {{$na_tajuk[$i]}}</td>
                                    @endif
                                    @if($p_kerusakan!="")
                                        <td>{{$skor_tli[$i]}} x {{$nt_kerusakan[$i]}} = {{$na_kerusakan[$i]}}</td>
                                    @endif
                                    @if($haksenp!="")
                                        <td>{{$skor_h_aksen[$i]}} x {{$nt_biodiv[$i]}} = {{$na_h_aksen[$i]}}</td>
                                    @endif
                                    @if($p_jpliu!="")
                                        <td>{{$skor_j_pliu[$i]}} x {{$nt_biodiv[$i]}} = {{$na_j_pliu[$i]}}</td>
                                    @endif
                                    @if($p_dmg!="")
                                        <td>{{$skor_dmg[$i]}} x {{$nt_biodiv[$i]}} = {{$na_dmg[$i]}}</td>
                                    @endif
                                </tr>
                                @php($i++)
                            @endforeach
                            </tbody>
                            <tfoot></tfoot>
                        </table>
                    </div>

                    {{-- TAB 2: Nilai Tertimbang --}}
                    <div class="tab-pane fade" id="tab_2">
                        <table id="Nilai_Tertimbang" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th style="text-align: center; vertical-align: middle">Nama Plot</th>
                                @if($p_lbds!="")
                                    <th style="text-align: center; vertical-align: middle">Nilai Tertimbang <br> Produktifitas</th>
                                @endif
                                @if($p_ktjk!="")
                                    <th style="text-align: center; vertical-align: middle">Nilai Tertimbang Kondisi <br> Tajuk</th>
                                @endif
                                @if($p_kerusakan!="")
                                    <th style="text-align: center; vertical-align: middle">Nilai Tertimbang Kerusakan</th>
                                @endif
                                @if($haksenp!="")
                                    <th style="text-align: center; vertical-align: middle">Nilai Tertimbang H' <br> Pohon</th>
                                @endif
                                @if($p_jpliu!="")
                                    <th style="text-align: center; vertical-align: middle">Nilai Tertimbang J' <br> Pohon</th>
                                @endif
                                @if($p_dmg!="")
                                    <th style="text-align: center; vertical-align: middle">Nilai Tertimbang DMg <br> Pohon</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @php($i=0)
                            @foreach($id_plot as $value)
                                <tr>
                                    <td>{{$value->nama_plot}}</td>
                                    @if($p_lbds!="")
                                        <td>{{$nt_produktivitas[$i]}}</td>
                                    @endif
                                    @if($p_ktjk!="")
                                        <td>{{$nt_ktjk[$i]}}</td>
                                    @endif
                                    @if($p_kerusakan!="")
                                        <td>{{$nt_kerusakan[$i]}}</td>
                                    @endif
                                    @if($haksenp!="")
                                        <td>{{$nt_biodiv[$i]}}</td>
                                    @endif
                                    @if($p_jpliu!="")
                                        <td>{{$nt_biodiv[$i]}}</td>
                                    @endif
                                    @if($p_dmg!="")
                                        <td>{{$nt_biodiv[$i]}}</td>
                                    @endif
                                </tr>
                                @php($i++)
                            @endforeach
                            </tbody>
                            <tfoot></tfoot>
                        </table>
                    </div>

                    {{-- TAB 3: Nilai Skor --}}
                    <div class="tab-pane fade" id="tab_3">
                        <table id="nilai_skor" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th style="text-align: center; vertical-align: middle">Nama Plot</th>
                                @if($p_lbds!="")
                                    <th style="text-align: center; vertical-align: middle">Nilai Skor Pertumbuhan <br> (LBDS)</th>
                                @endif
                                @if($p_volume!="")
                                    <th style="text-align: center; vertical-align: middle">Nilai Skor Pertumbuhan<br> (Volume)</th>
                                @endif
                                @if($p_ktjk!="")
                                    <th style="text-align: center; vertical-align: middle">Nilai Skor <br> Kondisi Tajuk (VCRp)</th>
                                @endif
                                @if($p_kerusakan!="")
                                    <th style="text-align: center; vertical-align: middle">Nilai Skor <br> Kerusakan (PLI)</th>
                                @endif
                                @if($haksenp!="")
                                    <th style="text-align: center; vertical-align: middle">Nilai Skor Biodiversitas <br>Pohon (H')</th>
                                @endif
                                @if($p_jpliu!="")
                                    <th style="text-align: center; vertical-align: middle">Nilai Skor Biodiversitas <br>Pohon (J')</th>
                                @endif
                                @if($p_dmg!="")
                                    <th style="text-align: center; vertical-align: middle">Nilai Skor Biodiversitas <br>Pohon (DMg)</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @php($i=0)
                            @foreach($id_plot as $value)
                                <tr>
                                    <td>{{$value->nama_plot}}</td>
                                    @if($p_lbds!="")
                                        <td>{{$skor_lbds[$i]}}</td>
                                    @endif
                                    @if($p_volume!="")
                                        <td>{{$skor_volume[$i]}}</td>
                                    @endif
                                    @if($p_ktjk!="")
                                        <td>{{$skor_vcr[$i]}}</td>
                                    @endif
                                    @if($p_kerusakan!="")
                                        <td>{{$skor_tli[$i]}}</td>
                                    @endif
                                    @if($haksenp!="")
                                        <td>{{$skor_h_aksen[$i]}}</td>
                                    @endif
                                    @if($p_jpliu!="")
                                        <td>{{$skor_j_pliu[$i]}}</td>
                                    @endif
                                    @if($p_dmg!="")
                                        <td>{{$skor_dmg[$i]}}</td>
                                    @endif
                                </tr>
                                @php($i++)
                            @endforeach
                            </tbody>
                            <tfoot></tfoot>
                        </table>
                    </div>

                    {{-- TAB 4: Nilai Analisis --}}
                    <div class="tab-pane fade in active" id="tab_4">
                        <table id="nilai_analisis" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th style="text-align: center; vertical-align: middle">Nama Plot</th>
                                @if($p_lbds!="")
                                    <th style="text-align: center; vertical-align: middle">LBDS <br> (m<sup>2</sup>)</th>
                                @endif
                                @if($p_volume!="")
                                    <th style="text-align: center; vertical-align: middle">Volume <br> (m<sup>3</sup>)</th>
                                @endif
                                @if($p_ktjk!="")
                                    <th style="text-align: center; vertical-align: middle">VCRp</th>
                                @endif
                                @if($p_kerusakan!="")
                                    <th style="text-align: center; vertical-align: middle">PLI</th>
                                @endif
                                @if($haksenp!="")
                                    <th style="text-align: center; vertical-align: middle">H' Pohon</th>
                                @endif
                                @if($p_jpliu)
                                    <th style="text-align: center; vertical-align: middle">J' Pohon</th>
                                @endif
                                @if($p_dmg)
                                    <th style="text-align: center; vertical-align: middle">DMg Pohon</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @php($i=0)
                            @foreach($id_plot as $value)
                                <tr>
                                    <td>{{$value->nama_plot}}</td>
                                    @if($p_lbds!="")
                                        <td>{{$nilai_lbds[$i]}}</td>
                                    @endif
                                    @if($p_volume!="")
                                        <td>{{$nilai_volume[$i]}}</td>
                                    @endif
                                    @if($p_ktjk!="")
                                        <td>{{$nilai_vcr[$i]}}</td>
                                    @endif
                                    @if($p_kerusakan!="")
                                        <td>{{$nilai_tli[$i]}}</td>
                                    @endif
                                    @if($haksenp!="")
                                        <td>{{$rata_h_aksen[$i]}}</td>
                                    @endif
                                    @if($p_jpliu)
                                        <td>{{$rata_j_pliu[$i]}}</td>
                                    @endif
                                    @if($p_dmg)
                                        <td>{{$rata_dmg[$i]}}</td>
                                    @endif
                                </tr>
                                @php($i++)
                            @endforeach
                            </tbody>
                            <tfoot></tfoot>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- =================== RANGE SKOR PARAMETER =================== --}}
    <div class="box box-primary collapsed-box">
        <div class="box-header with-border">
            <h3 class="box-title"><b>Range Skor Parameter</b></h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">

            @if($p_lbds!="")
                <div class="col-md-3">
                    <h4 style="text-align:center">Range Pertumbuhan Pohon <br>(LBDS)</h4>
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Skor</th>
                                <th>Min</th>
                                <th>-</th>
                                <th>Max</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($skor=0)
                            @for($i=1;$i<=10;$i++)
                                <tr>
                                    <td>{{++$skor}}</td>
                                    <td>{{$range_lbds_l[$i-1]}}</td>
                                    <td>-</td>
                                    <td>{{$range_lbds_r[$i]}}</td>
                                </tr>
                            @endfor
                            </tbody>
                            <tfoot></tfoot>
                        </table>
                    </div>
                </div>
            @endif

            @if($p_volume!="")
                <div class="col-md-3">
                    <h4 style="text-align:center">Range Pertumbuhan Pohon <br>(Volume)</h4>
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Skor</th>
                                <th>Min</th>
                                <th>-</th>
                                <th>Max</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($skor=0)
                            @for($i=1;$i<=10;$i++)
                                <tr>
                                    <td>{{++$skor}}</td>
                                    <td>{{$range_volume_l[$i-1]}}</td>
                                    <td>-</td>
                                    <td>{{$range_volume_r[$i]}}</td>
                                </tr>
                            @endfor
                            </tbody>
                            <tfoot></tfoot>
                        </table>
                    </div>
                </div>
            @endif

            @if($p_ktjk!="")
                <div class="col-md-3">
                    <h4 style="text-align:center">Range Kondisi Tajuk Pohon <br>(VCRp)</h4>
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Skor</th>
                                <th>Min</th>
                                <th>-</th>
                                <th>Max</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($skor=0)
                            @for($i=1;$i<=10;$i++)
                                <tr>
                                    <td>{{++$skor}}</td>
                                    <td>{{$range_vcr_l[$i-1]}}</td>
                                    <td>-</td>
                                    <td>{{$range_vcr_r[$i]}}</td>
                                </tr>
                            @endfor
                            </tbody>
                            <tfoot></tfoot>
                        </table>
                    </div>
                </div>
            @endif

            @if($p_kerusakan!="")
                <div class="col-md-3">
                    <h4 style="text-align:center">Range Kerusakan Pohon <br>(PLI)</h4>
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Skor</th>
                                <th>Min</th>
                                <th>-</th>
                                <th>Max</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($skor=0)
                            @for($i=1;$i<=10;$i++)
                                <tr>
                                    <td>{{++$skor}}</td>
                                    <td>{{$range_tli_l[$i]}}</td>
                                    <td>-</td>
                                    <td>{{$range_tli_r[$i-1]}}</td>
                                </tr>
                            @endfor
                            </tbody>
                            <tfoot></tfoot>
                        </table>
                    </div>
                </div>
            @endif

            @if($haksenp!="")
                <div class="col-md-3">
                    <h4 style="text-align:center">Range Biodiversitas Pohon <br>(H')</h4>
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Skor</th>
                                <th>Min</th>
                                <th>-</th>
                                <th>Max</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($skor=0)
                            @for($i=1;$i<=10;$i++)
                                <tr>
                                    <td>{{++$skor}}</td>
                                    <td>{{$range_h_aksen_l[$i-1]}}</td>
                                    <td>-</td>
                                    <td>{{$range_h_aksen_r[$i]}}</td>
                                </tr>
                            @endfor
                            </tbody>
                            <tfoot></tfoot>
                        </table>
                    </div>
                </div>
            @endif

            @if($j_pliu!="")
                <div class="col-md-3">
                    <h4 style="text-align:center">Range Biodiversitas Pohon <br>(J')</h4>
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Skor</th>
                                <th>Min</th>
                                <th>-</th>
                                <th>Max</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($skor=0)
                            @for($i=1;$i<=10;$i++)
                                <tr>
                                    <td>{{++$skor}}</td>
                                    <td>{{$range_j_pliu_l[$i-1]}}</td>
                                    <td>-</td>
                                    <td>{{$range_j_pliu_r[$i]}}</td>
                                </tr>
                            @endfor
                            </tbody>
                            <tfoot></tfoot>
                        </table>
                    </div>
                </div>
            @endif

            @if($d_mg!="")
                <div class="col-md-3">
                    <h4 style="text-align:center">Range Biodiversitas Pohon <br>(DMg)</h4>
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Skor</th>
                                <th>Min</th>
                                <th>-</th>
                                <th>Max</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($skor=0)
                            @for($i=1;$i<=10;$i++)
                                <tr>
                                    <td>{{++$skor}}</td>
                                    <td>{{$range_dmg_l[$i-1]}}</td>
                                    <td>-</td>
                                    <td>{{$range_dmg_r[$i]}}</td>
                                </tr>
                            @endfor
                            </tbody>
                            <tfoot></tfoot>
                        </table>
                    </div>
                </div>
            @endif

        </div>
    </div>

@endsection {{-- end main_section --}}

{{-- =================== JS LIBRARIES (INJEK VIA LAYOUT) =================== --}}
@section('data_table')
    {{-- jQuery + vendor --}}
    <script src="{{asset('Admin/bower_components/raphael/raphael.min.js')}}"></script>
    <script src="{{asset('Admin/bower_components/morris.js/morris.min.js')}}"></script>

    <script src="{{asset('Admin/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('Admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('Admin/cdn/table-responsive.min.js')}}"></script>

    {{-- Chart.js (satu saja, yang minified) --}}
    <script src="{{ asset('js/chart.min.js') }}"></script>

    {{-- Leaflet + Esri --}}
    <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"
            integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg=="
            crossorigin=""></script>
    <script src="https://unpkg.com/esri-leaflet@2.2.4/dist/esri-leaflet.js"
            integrity="sha512-tyPum7h2h36X52O2gz+Pe8z/3l+Y9S1yEUscbVs5r5aEY5dFmP1WWRY/WLLElnFHa+k1JBQZSCDGwEAnm2IxAQ=="
            crossorigin=""></script>
    <script src="https://unpkg.com/esri-leaflet-geocoder@2.2.13/dist/esri-leaflet-geocoder.js"
            integrity="sha512-zdT4Pc2tIrc6uoYly2Wp8jh6EPEWaveqqD3sT0lf5yei19BC1WulGuh5CesB0ldBKZieKGD7Qyf/G0jdSe016A=="
            crossorigin=""></script>
@endsection

{{-- =================== SCRIPT LOGIC: CHART, MAP, DATATABLES =================== --}}
@section('script_table')
    <script>
        // ================= CHART KESEHATAN PLOT =================
        (function () {
            var densityCanvas = document.getElementById("densityChart");
            if (!densityCanvas || typeof Chart === 'undefined') return;

            Chart.defaults.global.legend.display = false;
            Chart.defaults.global.defaultFontFamily = "Lato";
            Chart.defaults.global.defaultFontSize = 18;

            var skor_akhir = [];
            @for($i=0; $i<count($na_total); $i++)
                skor_akhir[{{ $i }}] = {{ $na_total[$i] }};
            @endfor

            var maks  = {{ max($na_total) }};
            var maks2 = parseInt(maks);
            var extraIndex = {{ count($na_total) }};

            if (maks2 >= 0 && maks2 < 10) {
                skor_akhir[extraIndex] = maks2 + 0.5;
            } else if (maks2 >= 10 && maks2 < 100) {
                skor_akhir[extraIndex] = maks2 + 5;
            } else if (maks2 >= 100 && maks2 < 1000) {
                skor_akhir[extraIndex] = maks2 + 50;
            } else {
                skor_akhir[extraIndex] = maks2 + 500;
            }

            var warna = [];
            @for($i=0; $i<count($nilai_skor); $i++)
                @if($nilai_skor[$i]=="Buruk")
                    warna[{{ $i }}] = 'rgba(208, 15, 18, 0.6)';
                @elseif($nilai_skor[$i]=="Sedang")
                    warna[{{ $i }}] = 'rgba(192, 208, 15, 0.6)';
                @elseif($nilai_skor[$i]=="Baik")
                    warna[{{ $i }}] = 'rgba(0, 255, 0, 0.6)';
                @endif
            @endfor

            var densityData = {
                data: skor_akhir,
                backgroundColor: warna,
                borderWidth: 2,
                hoverBorderWidth: 0
            };

            var options = {
                responsive: true,
                scales: {
                    ticks: {
                        beginAtZero: true
                    }
                },
                elements: {
                    rectangle: {
                        borderSkipped: 'left'
                    }
                }
            };

            new Chart(densityCanvas, {
                type: 'bar',
                data: {
                    labels: [
                        @foreach($id_plot as $value)
                            "{{$value->nama_plot}}",
                        @endforeach
                    ],
                    datasets: [densityData]
                },
                options: options
            });
        })();

        // ================= PETA LEAFLET =================
        (function () {
            if (typeof L === 'undefined') return;
            var mapContainer = document.getElementById('mapid');
            if (!mapContainer) return;

            var satelite = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            });

            var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            });

            var gmaps = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            });

            var mymap = L.map('mapid', {
                scrollWheelZoom: false,
                layers: [osm]
            });

            var mapIndonesia = [
                [5.528511, 95.20752],
                [-8.754795, 103.271484],
                [-11.092166, 141.240234],
                [6.315299, 142.910156]
            ];
            mymap.fitBounds(mapIndonesia);

            var baseMaps = {
                'OSM': osm,
                'Google Maps': gmaps,
                'Satelite': satelite
            };
            L.control.layers(baseMaps).addTo(mymap);

            var bounds = [];
            var latlngs = [];

            @foreach($id_plot as $value)
                (function () {
                    var koordinatLintang = "{{$value->koordinat_LS}}";
                    var split_l = koordinatLintang.split(' ');
                    var degL = parseFloat(split_l[0] || 0);
                    var minL = parseFloat(split_l[1] || 0);
                    var secL = parseFloat(split_l[2] || 0);

                    var menit_l = minL / 60;
                    var detik_l = secL / 3600;
                    var ketLintang;
                    var lat;

                    if (degL < 0) {
                        lat = degL - menit_l - detik_l;
                        ketLintang = " LS";
                    } else {
                        lat = degL + menit_l + detik_l;
                        ketLintang = " LU";
                    }

                    var koordinatBujur = "{{$value->koordinat_BT}}";
                    var split_b = koordinatBujur.split(' ');
                    var degB = parseFloat(split_b[0] || 0);
                    var minB = parseFloat(split_b[1] || 0);
                    var secB = parseFloat(split_b[2] || 0);

                    var menit_b = minB / 60;
                    var detik_b = secB / 3600;
                    var ketBujur;
                    var lng;

                    if (degB < 0) {
                        lng = degB - menit_b - detik_b;
                        ketBujur = "BB";
                    } else {
                        lng = degB + menit_b + detik_b;
                        ketBujur = "BT";
                    }

                    var marker = L.marker([lat, lng]).addTo(mymap);
                    bounds.push(marker.getLatLng());

                    marker.bindPopup(
                        "{{$value->nama_plot}} <br/> Koordinat: " +
                        Math.abs(degL) + " ᴼ " + minL + " ' " + secL + " \" " + ketLintang + ", " +
                        Math.abs(degB) + " ᴼ " + minB + " ' " + secB + " \" " + ketBujur
                    );

                    L.circle([lat, lng], {radius: 17.95}).addTo(mymap);
                    L.circle([lat, lng], {radius: 7.32, fillColor: 'green', color: 'green'}).addTo(mymap);

                    var namaPlot = "{{$value->nama_plot}}";
                    if (namaPlot === "PLOT 1") {
                        latlngs[0] = marker.getLatLng();
                    }
                    if (namaPlot === "PLOT 2") {
                        latlngs[1] = latlngs[0];
                        latlngs[2] = marker.getLatLng();
                    }
                    if (namaPlot === "PLOT 3") {
                        latlngs[3] = latlngs[0];
                        latlngs[4] = marker.getLatLng();
                    }
                    if (namaPlot === "PLOT 4") {
                        latlngs[5] = latlngs[0];
                        latlngs[6] = marker.getLatLng();
                    }
                })();
            @endforeach

            if (bounds.length) {
                mymap.fitBounds(bounds);
                L.polyline(latlngs, {color: 'red'}).addTo(mymap);
            }
        })();

        // ================= DATATABLES =================
        $(function () {
            $('#Nilai_Indikator').DataTable({
                responsive: true,
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: false,
                bStateSave: true,
                language: {
                    search: "Pencarian:",
                    lengthMenu: "Menampilkan _MENU_ data per halaman",
                    zeroRecords: "Nothing found - sorry",
                    info: "Halaman _PAGE_ dari _PAGES_",
                    infoEmpty: "Belum Ada Data Tersimpan",
                    infoFiltered: "(filtered from _MAX_ total records)",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                }
            });

            $('#Nilai_Tertimbang').DataTable({
                responsive: true,
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: false,
                bStateSave: true,
                language: {
                    search: "Pencarian:",
                    lengthMenu: "Menampilkan _MENU_ data per halaman",
                    zeroRecords: "Nothing found - sorry",
                    info: "Halaman _PAGE_ dari _PAGES_",
                    infoEmpty: "Belum Ada Data Tersimpan",
                    infoFiltered: "(filtered from _MAX_ total records)",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                }
            });

            $('#nilai_skor').DataTable({
                responsive: true,
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: false,
                bStateSave: true,
                language: {
                    search: "Pencarian:",
                    lengthMenu: "Menampilkan _MENU_ data per halaman",
                    zeroRecords: "Nothing found - sorry",
                    info: "Halaman _PAGE_ dari _PAGES_",
                    infoEmpty: "Belum Ada Data Tersimpan",
                    infoFiltered: "(filtered from _MAX_ total records)",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                }
            });

            $('#nilai_analisis').DataTable({
                responsive: true,
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: false,
                bStateSave: true,
                language: {
                    search: "Pencarian:",
                    lengthMenu: "Menampilkan _MENU_ data per halaman",
                    zeroRecords: "Nothing found - sorry",
                    info: "Halaman _PAGE_ dari _PAGES_",
                    infoEmpty: "Belum Ada Data Tersimpan",
                    infoFiltered: "(filtered from _MAX_ total records)",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                }
            });

            $('a[data-toggle="tab"]').on('shown.bs.tab', function () {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust()
                    .responsive.recalc();
            });
        });
    </script>
@endsection

