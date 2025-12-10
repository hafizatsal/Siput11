@extends('layouts.layoutauditor')
@section('title', 'Halaman Pengukuran')
@section('active_data_pengukuran', 'active')
@section('active_produktivitas', 'active')
@section('breadcrumb')
    <li><a href="{{ route('auditor.data_indikator', encrypt($id)) }}">Data Indikator</a></li>
    <li><a href="#">Paramater Produktivitas</a></li>
@endsection
@section('main_section')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Data Parameter Produktivitas</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="data_klaster" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width:5%">No.</th>
                                <th>Nama Parameter</th>
                                <th style="width:5%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>1</td>
                                <td>Pertumbuhan</td>
                                <td>
                                    <a class="fa fa-search btn btn-success btn-xs" data-info=""
                                        href="{{ route('auditor.lbds', encrypt($id)) }}"></a>
                                </td>
                            </tr>

                        </tbody>
                        <tfoot>

                        </tfoot>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
@section('data_table')
    <!-- DataTables -->
    <script src="{{ asset('Admin/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('Admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
@endsection

<script src="{{ asset('Admin/modal_ajax.min.js') }}"></script>
<script src="{{ asset('Admin/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- jquery untuk mengatur datatable -->
@section('script_table')
    <script>
        $(function() {
            $('#data_klaster').DataTable({
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                "order": [
                    [0, "asc"]
                ],
                'info': true,
                'autoWidth': false,
                'lengthMenu': [
                    [5, 10, 20],
                    [5, 10, 20]
                ],
                'bStateSave': true,
                "language": {
                    "search": "Pencarian:",
                    "lengthMenu": "Menampilkan _MENU_ data per halaman",
                    "zeroRecords": "Nothing found - sorry",
                    "info": "Halaman _PAGE_ dari _PAGES_",
                    "infoEmpty": "Belum Ada Data Tersimpan",
                    "infoFiltered": "(filtered from _MAX_ total records)",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    },
                }
            })
        })
    </script>
@endsection

@endsection
