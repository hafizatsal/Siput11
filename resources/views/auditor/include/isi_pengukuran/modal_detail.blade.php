<div class="modal fade" id="modal_detail">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Data Pengukuran Plot</h4>
      </div>
      <div class="modal-body">
        <table id="detail_plot" class="table table-striped">
          @include('auditor.include.data_pengukuran.keterangan_pengukuran')
        </table>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
</div>
<script type="text/javascript">
$(document).ready(function(){


});
</script>
