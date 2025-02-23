<div class="form-group has-feedback">
  <div class="box box-primary">
    <div class="box-body">
    
	<a href='<?php echo base_url('inventory/Purchase_order/add'); ?>' class='pull-right'>
		<button class="btn btn-add" id="add_record" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Add Item">
			<i class="fa fa-plus-circle fa-lg"></i>&nbsp; 
		</button>
	</a><br /><br />
	
        <div class="table-responsive">
        <table class="table table-bordered table-striped" id="period">
          <thead style="background:#99ceff;">
            <tr>
             <th>Sl No.</th>
		     <th>Order No.</th>
		     <th>Vendor</th>
		     <th>Order Date</th>
		     <th>Product</th>
		     <th>Order Quntity</th>
		     <th>Action</th>
            </tr>
          </thead>
          
          
          <tbody>
            <?php
		     if($purchase_order)
			 {
				 $i = 1;
				 foreach($purchase_order as $data)
				 {
		   ?>
		   <tr>
		     <td><?php echo $i; ?></td>
		     <td><?php echo $data->order_no; ?></td>
		     <td><?php echo $data->venname; ?></td>
		     <td><?php echo $data->order_date; ?></td>
		     <td><?php echo $data->proname; ?></td>
		     <td><?php echo $data->order_qty; ?></td>
		     <td>
			   <a class="btn a-edit" title="Edit" onclick="edit(<?php echo $data->id; ?>,<?php echo $data->product; ?>,<?php echo $data->uqc; ?>,<?php echo $data->order_qty; ?>)"><i class="fa fa-edit"></i></a>
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
                <button type="button" class="btn btn-success btn-xs" onclick="update()">Update</button>
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

function edit(id,product,uqc,qty){
	$.ajax({
		url: "<?php echo base_url('inventory/Purchase_order/edit'); ?>",
		type: "POST",
		data: {id:id,product:product,uqc,uqc,qty:qty},
		success: function(data){
			$("#edit_grn").html(data);
			$("#editModal").modal('show');
		}
	});
}

function update(){
	var pro = $("#pro").val();
	var uqc = $("#uqc").val();
	var qty = $("#qty").val();
	var id = $("#id").val();
    $.ajax({
		url: "<?php echo base_url('inventory/Purchase_order/update'); ?>",
		type: "POST",
		data: {pro:pro,uqc:uqc,qty:qty,id:id},
		success: function(data){
			alert('update Successfully');
			location.reload();
		}
	});
}
</script>