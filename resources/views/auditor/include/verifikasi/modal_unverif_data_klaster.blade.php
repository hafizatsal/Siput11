<div class="modal modal-warning fade" id="modal_unverif_data_klaster">
       <div class="modal-dialog">
         <div class="modal-content">
           <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span></button>
             <h4 class="modal-title">Unverifikasi Data Klaster</h4>
           </div>
           <form class="" action="{{route('auditor.verifikasi.unverif')}}" method="post">
             {{csrf_field()}}
           <div class="modal-body">
             <p>Yakin ingin unverifikasi data?</p>
             <input type="hidden" name="unverif_id_data_klaster" id="unverif_id_data_klaster" value="">
             </div>
           <div class="modal-footer">
             <button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
             <button type="submit" class="btn btn-warning">OK</button>
           </form>
           </div>
         </div>
         <!-- /.modal-content -->
       </div>
       <!-- /.modal-dialog -->
     </div>

@push('script_tambahan')
<script type="text/javascript">
  $(document).ready(function(){

    $('#modal_unverif_data_klaster').on('show.bs.modal', function(event){
      var button = $(event.relatedTarget);
      var id_data_klaster = button.data('data_klaster');
      var modal = $(this)
    modal.find('#unverif_id_data_klaster').val(id_data_klaster);
    });

  });
</script>
@endpush