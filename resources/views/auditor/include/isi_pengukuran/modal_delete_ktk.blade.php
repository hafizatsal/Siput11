<div class="modal modal-danger fade" id="modal_delete_ktk">
       <div class="modal-dialog">
         <div class="modal-content">
           <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span></button>
             <h4 class="modal-title">Hapus Data</h4>
           </div>
           <form class="" action="{{route('auditor.hapus_ktk_kimia')}}" method="get">
             {{csrf_field()}}
           <div class="modal-body">
             <p>Yakin ingin menghapus data?</p>
             <input type="hidden" name="hapus_id" id="hapus_id" value="">
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
       $('#modal_delete_ktk').on('show.bs.modal', function(event){
          var button = $(event.relatedTarget);
          var kimia = button.data('kimia');
          var modal = $(this)
         modal.find('.modal-body #hapus_id').val(kimia);

       });
    });
       </script>
@endpush