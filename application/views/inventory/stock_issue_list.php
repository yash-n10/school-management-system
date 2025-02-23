<div class="form-group has-feedback">
  <div class="box box-primary">
   <div class="box-body">
     <div class="col-sm-12">
	  <div class="box-body">
		<table class='table'>
		   <tr>
			 <th style="text-align:right">Staff</th>
			 <td style="width:170px;">
			   <select class='form-control' id='staff' name='vendor' required onchange="staff(this.value)">
				<option value=''>Select</option>
				<?php
				  if($employee)
				  {
					  foreach($employee as $data)
					  {
				?>
				<option value='<?php echo $data->id; ?>'><?php echo $data->name; ?></option>
				<?php	  
					  }
				  }
				?>
			   </select>
			 </td>
		   </tr>
		   
		   <tr>
			 <th style="text-align:right">Request Number</th>
			 <td>
			   <select class='form-control' required id="req_view">
				 <option value="">Select</option>
			   </select>
			 </td>
		   </tr>
		   
		   <tr>
			 <td colspan='2' align='right'><button type='button' class='btn btn-warning btn-xs' onclick='view()'>VIEW</button></td>
		   </tr>
		</table>
        <div id='viewpro'></div>
		
        <!----batch modal---------->
        <div id="BatchModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Choose Batch</h4>
			  </div>
			  <div class="modal-body">
				<div id="viewbatch"></div>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			  </div>
			</div>

		  </div>
		</div>
		<!----end batch modal---------->

      </div>
     </div>  
   </div>
  </div>
</div>

<script>
  function staff(id)
  {
	  var staff_id = id;
	  $.ajax({
		  url: "<?php echo base_url('inventory/Stock_issue/fetorder'); ?>",
		  type: "post",
		  data: {staff_id:staff_id},
		  success: function(data)
		  {
			  $("#req_view").html(data);
		  }
	  });
  }
  
  function view()
  {
	  var staff = $("#staff").val();
	  var req_view = $("#req_view").val();
	  if(staff != '' && req_view != '')
	  {
		  $.ajax({
			  url: "<?php echo base_url('inventory/Stock_issue/fetpro'); ?>",
			  type: "post",
			  data: {staff_id:staff,req_no:req_view},
			  success: function(data)
			  {
				  $("#viewpro").html(data);
			  }
		  });
	  }
	  else
	  {
		  alert('Please Select First');
	  }
  }
  
  function qty(vall)
  {
	var id = vall.id;
    var dist = id.split("_");
	var newid = dist[1];
	
	var ordqty = Number($("#ordqty_"+newid).val());
	var qty = Number($("#qty_"+newid).val());
	var proid = $("#proid_"+newid).val();
	var batch = $("#batch_"+newid).val();
	
	if(ordqty < qty)
	{
		alert('Enter valid Qty');
		$("#qty_"+newid).val('');
	}
	else
	{
		var cal = Number(ordqty)-Number(qty);
		$("#restqty_"+newid).val(cal);
		$.ajax({
			url: "<?php echo base_url('inventory/Stock_issue/pro_bat'); ?>",
			type: "post",
			data: {proid:proid,batch:batch},
			success: function(data)
			{
				var cm_data = data;
				$("#price_"+newid).val(cm_data);
				var price = $("#price_"+newid).val();
				var tot = Number(qty) * Number(price);
				
				$("#totprice_"+newid).val(tot);
			}
		});
	}
	
  }
  
  function btch(vl)
  {
	  var id = vl.id;
	  var dist = id.split("_");
	  var newid = dist[1];
	  var proid = $("#proid_"+newid).val();
	  $.ajax({
			  url: "<?php echo base_url('inventory/Stock_issue/fetchbatch'); ?>",
			  type: "post",
			  data: {proid:proid,id:id},
			  success: function(data)
			  {
				  $("#viewbatch").html(data);
				  $("#BatchModal").modal('show');
			  }
		  });
  }
  
  function chkbatch(vall,id)
  {
	  var chkbatch = vall;
	  $("#BatchModal").modal('hide');
	  $("#"+id).val(chkbatch);
  }
  
  function closee(cl_id)
  {
	  var close_id = cl_id;
	  $("#pro_"+close_id).attr('disabled',true);
	  $("#batch_"+close_id).attr('disabled',true);
	  $("#ordqty_"+close_id).attr('disabled',true);
	  $("#qty_"+close_id).attr('disabled',true);
	  $("#restqty_"+close_id).attr('disabled',true);
	  $("#uqc_"+close_id).attr('disabled',true);
	  $("#price_"+close_id).attr('disabled',true);
	  $("#totprice_"+close_id).attr('disabled',true);
	  $("#tr_"+close_id).hide();
	  $("#tr_"+close_id).remove();
  }
  
  function product_issue()
  {
	  if(!$('#form_id')[0].checkValidity())
	  {
		  $(this).show();
		  $("#form_id")[0].reportValidity();
		  return false;
	  }
	  else
	  {
		  $.ajax({
			  url: "<?php echo base_url('inventory/Stock_issue/issue'); ?>",
			  type: "post",
			  data: $("#form_id").serialize(),
			  success: function(data)
			  {
				  alert('Submit Completed');
				  location.reload();
			  }
		  });
	  }
  }
</script>