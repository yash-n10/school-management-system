<div class="form-group has-feedback">
  <div class="box box-primary">
    <div class="box-body">
    
	<a href='<?php echo base_url('inventory/Goods/index'); ?>' class='pull-right'>
		<button class="btn btn-add" id="add_record" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Add Item">
			<i class="fa fa-plus-circle fa-lg"></i>&nbsp; 
		</button>
	</a><br /><br />
	
        <div class="table-responsive">
        <table class="table table-bordered table-striped" id="period">
          <thead style="background:#99ceff;">
            <tr>
             <th>Sl No.</th>
		     <th>GRN No.</th>
		     <th>Vendor</th>
		     <th>Order No.</th>
		     <th>Invoice No.</th>
		     <th>Basic Total</th>
		     <th>CGST</th>
		     <th>SGST</th>
		     <th>IGST</th>
		     <th>Net Total</th>
		     <th>Action</th>
            </tr>
          </thead>
          
          
          <tbody>
            <?php
		     if($grn)
			 {
				 $i = 1;
				 foreach($grn as $data)
				 {
		   ?>
		   <tr>
		     <td><?php echo $i; ?></td>
		     <td><?php echo $data->grn_no; ?></td>
		     <td><?php echo $data->vendername; ?></td>
		     <td><?php echo $data->vw_ord; ?></td>
		     <td><?php echo $data->inv_no; ?></td>
		     <td><?php echo $data->basictotal; ?></td>
		     <td><?php echo $data->gst_c; ?></td>
		     <td><?php echo $data->gst_s; ?></td>
		     <td><?php echo $data->gst_i; ?></td>
		     <td><?php echo $data->nettotal; ?></td>
		     <td>
			   <a class="btn a-view" title="View" onclick="vieww('<?php echo $data->grn_no; ?>')"><i class="fa fa-eye"></i></i></a>
			   <a class="btn a-edit" title="Edit" onclick="edit('<?php echo $data->grn_no; ?>')"><i class="fa fa-edit"></i></a>
			 </td>
		   </tr>
		   <?php 
		        $i++;
				 }
			 }
		   ?>
          </tbody>
        </table>
        </div>
       <!--view Modal-->
        <div id="ViewModal" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title" id="modal-title">View</h3>
              </div>
                  
              <div class="modal-body">
                <div id='view_grn'></div>
              </div>
			  
              <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
      <!-- End View Modal-->
	  
	  
	  <!--view Modal-->
        <div id="editModal" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg ">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title" id="modal-title">Edit</h3>
              </div>
                  
              <div class="modal-body">
                <div id='edit_grn'></div>
              </div>
			  
              <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
      <!-- End View Modal-->
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


function vieww(grn)
{
	var grn_no = grn;
	$.post("<?php echo base_url('inventory/Grn/vieww'); ?>",{grn_no:grn_no},function(data){
		$("#view_grn").html(data);
		$("#ViewModal").modal('show');
	});
}

function edit(grn)
{
	var grn_no = grn;
	$.post("<?php echo base_url('inventory/Grn/edit'); ?>",{grn_no:grn_no},function(data){
		$("#edit_grn").html(data);
		$("#editModal").modal('show');
	}); 
}
</script>