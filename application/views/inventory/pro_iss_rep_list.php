<div class="form-group has-feedback">
  <div class="box box-primary">
    <div class="box-body">
    
	<a href='<?php echo base_url('inventory/Stock_issue/index'); ?>' class='pull-right'>
		<button class="btn btn-add" id="add_record" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Add Item">
			<i class="fa fa-plus-circle fa-lg"></i>&nbsp; 
		</button>
	</a>
	<br /><br />
	
        <div class="table-responsive">
        <table class="table table-bordered table-striped" id="period">
          <thead style="background:#99ceff;">
            <tr>
             <th>Sl No.</th>
		     <th>Staff</th>
		     <th>Req No</th>
		     <th>Product</th>
		     <th>Batch</th>
		     <th>Order Qty</th>
		     <th>Receive Qty</th>
		     <th>Rest Qty</th>
		     <th>UQC</th>
            </tr>
          </thead>
          
          
          <tbody>
            <?php
		    // if($product_issued)
			// {
				 //$i = 1;
				 // foreach($product_issued as $data)
				 // {
		   ?>
		   <tr>
		     <td><?php //echo $i; ?></td>
		     <td><?php //echo $data->empname; ?></td>
		     <td><?php //echo $data->req_no; ?></td>
		     <td><?php //echo $data->proname; ?></td>
		     <td><?php //echo $data->batch; ?></td>
		     <td><?php //echo $data->order_qty; ?></td>
		     <td><?php //echo $data->rec_qty; ?></td>
		     <td><?php //echo $data->rest_qty; ?></td>
		     <td><?php //echo $data->uqc; ?></td>
		   </tr>
		   <?php 
		       // $i++;
				// }
			 //}
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
          <div class="modal-dialog modal-xs ">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title" id="modal-title">Edit</h3>
              </div>
                  
              <div class="modal-body">
                <div id='edit_grn'></div>
              </div>
			  
              <div class="modal-footer">
			    <button type="submit" class="btn btn-success btn-xs" onclick="update()">Update</button>
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
</script>