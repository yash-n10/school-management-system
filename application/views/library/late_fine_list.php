<div class="form-group has-feedback">
  <div class="box box-primary">
    <div class="box-body">
    
	<a href='<?php echo base_url('library/Late_fine/add'); ?>' class='pull-right'>
		<button class="btn btn-add" id="add_record" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Add Item">
                <i class="fa fa-plus-circle fa-lg"></i>&nbsp; 
		</button>
	</a><br /><br />
	
        <div class="table-responsive">
        <table class="table table-bordered table-striped" id="period">
          <thead style="background:#99ceff;">
            <tr>
             <th>Sl No.</th>
             <th>Late Fine</th>
             <th>Action</th>
            </tr>
          </thead>
          
          
          <tbody>
		  <?php
		    $i = 1;
			if($late_fine){
			foreach($late_fine as $data){
		  ?>
		    <tr>
			  <td><?php echo $i; ?></td>
			  <td><?php echo $data->late_fine; ?> Rs.</td>
			  <td>
			    <a class="btn a-edit" title="Edit" onclick="edit(<?php echo $data->id; ?>,'<?php echo $data->late_fine; ?>')"><i class="fa fa-edit"></i></a>
			  </td>
		    </tr>
			<?php } $i++; } ?>	
          </tbody>
        </table>
		 
		<!-- Modal -->
		<div id="myModaledit" class="modal fade" role="dialog">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Modal Header</h4>
			  </div>
			  <div class="modal-body">
				<div id='edit'></div>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</div>
		  </div>
		</div>
		<!--end modal ---> 
        </div>
  </div>
</div>

<script>
$(function (){
    var table=$('#period').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true
    });
    $('#searchhead th input').on('keyup change', function () {
            var i = $(this).attr('data-column');
            var v = $(this).val();
            table.columns(i).search(v).draw();
    });
});

function edit(id,late_fine){
	$.post('<?php echo base_url('library/Late_fine/edit'); ?>',{id:id,late_fine:late_fine},function(data){
		$("#edit").html(data);
		$("#myModaledit").modal('show');
	});
}
</script>