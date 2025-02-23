<div class="form-group has-feedback">
  <div class="box box-primary">
  <div class="box-body">
    <div class="col-sm-2"></div>
  <div class="col-sm-8">
     <div class="box-body">
	 
	    <form id="formm">
		   <table class="table">
			 <tr>
			   <td>Vendor</td>
			   <td>
			     <select class='form-control' name='vendor' required>
				   <option value=''>Select</option>
				   <?php
				     if($vendor)
					 {
						foreach($vendor as $data)
						{
				   ?>
				   <option value='<?php echo $data->id; ?>'><?php echo $data->ledger_name; ?></option>
				   <?php
						}						
					 }
				   ?>
				 </select>
			   </td>
			   
			   <td>Order Date</td>
			   <td><input type="date" name='order_date' class='form-control' required></td>
			 </tr>
			 
			 <tr>
			   <td colspan='4' align='right'><button type="button" class='btn btn-warning' onclick='add()'>ADD</button></td>
			 </tr>
		   </table>
		   
		   <table class='table' id='mytbl'>
		     <tr>
			   <th>Product</th>
			   <th>Qty</th>
			   <th>UQC</th>
		     </tr>
		   </table>
		   
		   <table class='table'>
			 <tr>
			   <td colspan='3' align='center'><button type="button" class='btn btn-success' onclick='save()'>SUBMIT</button></td>
			 </tr> 
		   </table>
		   
		</form>   
		   

    </div>
  </div>
  </div>
  <div id="reqbox" style="display:none;">
  <div class="box-body" id="adddata">
         
  </div>
  </div>
  </div>  
  </div>
  </div>

  

<script>
function add()
{
	var value = "<tr><td><select class='form-control' name='pro[]' required><option value=''>Select</option><?php foreach($pro as $data){ ?><option value='<?php echo $data->id; ?>'><?php echo $data->product; ?></option><?php } ?></select></td><td><input type='text' name='qty[]' class='form-control' required></td><td><select name='uqc[]' class='form-control' required><option value=''>Select</option><?php foreach($uqc as $data){ ?><option value='<?php echo $data->id; ?>'><?php echo $data->name; ?></option><?php } ?></select></td><td style='color:red; cursor:pointer' onclick='rmv(this)'>X</td></tr>";
	$("#mytbl").append(value);
}

function rmv(arg)
{
	$(arg).parent('tr').remove();
}

function save()
{
	if(!$('#formm')[0].checkValidity())
	{
	    $(this).show();
        $("#formm")[0].reportValidity();
        return false;		
	}
	else
	{
		$.ajax({
			url: "<?php echo base_url('inventory/Purchase_order/save'); ?>",
			type: "post",
			data: $("#formm").serialize(),
			success: function(data)
			{
				alert('Added Successfully');
				window.location='index';
			}
		});
	}
}
</script>