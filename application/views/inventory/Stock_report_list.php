<div class="form-group has-feedback">
  <div class="box box-primary">
    <div class="box-body">
    
	<br /><br />
	
        <div class="table-responsive">
        <table class="table table-bordered table-striped" id="period">
          <thead style="background:#99ceff;">
            <tr>
             <th>Sl No.</th>
		     <th>Product</th>
		     <th>Batch</th>
		     <th>Quantity</th>
         <th>HSN</th>
		     <th>MFG Date</th>
		     <th>Expiry Date</th>
		     <th>Size</th>
		     <th>Color</th>
		     <th>Price</th>
            </tr>
          </thead>
          
          
          <tbody>
            <?php
		     if($stock_report)
			 {
				 $i = 1;
				 foreach($stock_report as $data)
				 {
		   ?>
		   <tr>
		     <td><?php echo $i; ?></td>
		     <td><?php echo $data->proname; ?></td>
		     <td><?php echo $data->batch; ?></td>
		     <td><?php echo $data->qty; ?></td>
         <td><?php echo $data->hsn; ?></td>
		     <td><?php echo $data->mfg_date; ?></td>
		     <td><?php echo $data->exp_date; ?></td>
		     <td><?php echo $data->size; ?></td>
		     <td><?php echo $data->color; ?></td>
		     <td><?php echo $data->price; ?></td>
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