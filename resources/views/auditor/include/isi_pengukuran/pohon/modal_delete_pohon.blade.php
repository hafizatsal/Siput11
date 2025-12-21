<div class="modal modal-danger fade" id="modal_delete_pohon">
       <div class="modal-dialog">
         <div class="modal-content">
           <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span></button>
             <h4 class="modal-title">Hapus Data</h4>
           </div>
           <form class="" action="/auditor/data_pohon/hapus" method="get">
             {{csrf_field()}}
           <div class="modal-body">
             <p>Yakin ingin menghapus data?</p>
             <input type="hidden" name="hapus_id" id="hapus_id" value="">
             <input type="hidden" id="id_klasters_plot2" name="id_klasters_plot2" value="{{$id_plot}}">
             <input type="hidden" id="id_jenis_tanaman2" name="id_jenis_tanaman2" value="">
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
       $('#modal_delete_pohon').on('show.bs.modal', function(event){
          var button = $(event.relatedTarget);
          var pohon = button.data('pohon');
          var jenis = button.data('jenis');
          var modal = $(this)
         modal.find('.modal-body #hapus_id').val(pohon);
         $('#id_jenis_tanaman2').val(jenis);

       });
    });
       </script>
@endpush