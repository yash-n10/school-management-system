<div class="form-group has-feedback">
  <div class="box box-primary">
  <div class="box-body">
    <div class="col-sm-2"></div>
  <div class="col-sm-8">
     <div class="box-body">
	   <form id="req">
	   <table class="table" id="mytbl">
	     <tr>
		   <td></td>
		  
		   <th>STAFF</th>
		   <td>
		     <select name="staff" class='form-control' required>
			   <option value="">Select</option>
			   <?php
			     if($employee)
				 {
					 foreach($employee as $data)
					 {
			   ?>
			   <option value="<?php echo $data->id; ?>"><?php echo $data->name; ?></option>
			   <?php 
					 }
				 }
			   ?>
			 </select>
			 <span id="error-staff"></span>
		   </td>
	     </tr>
	     <tr>
		   <td colspan='4' align='right'><button type="button" class='btn btn-warning' onclick="add()">ADD</button></td>
		 </tr>
	     <tr>
		   <th>Product</td>
		   <th>Qty</td>
		   <th>UQC</td>
	     </tr>
		 
	   </table>
	   
	   <table class='table'>
	     <tr>
		   <td colspan='3' align='center'><button type="button" class="btn btn-success" onclick="save()">SUBMIT</button></td>
		 </tr>
	   </table>
	   </form>
    </div>
  </div>
  <div class="col-sm-2"></div>  
  </div>
  </div>
</div>

<script>
$(function ()
{
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

function add()
{
	var row = "<tr><td><select class='form-control' name='pro[]' required><option value=''>Select</option><?php foreach($pro as $data){?><option value='<?php echo $data->id; ?>'><?php echo $data->product; ?></option><?php } ?></select><span id='error-pro'></span></td><td><input type='text' name='qty[]' class='form-control' required><span id='error-qty'></span></td><td><select class='form-control' name='uqc[]' required><option value=''>Select</option><?php foreach($uqc as $data){?><option value='<?php echo $data->id; ?>'><?php echo $data->name; ?></option><?php } ?></select><span id='error-uqc'></span></td><td style='cursor:pointer; color:red; font-weight:bold' onclick='rmv(this)'>X</td></tr>"
	$("#mytbl").append(row);
}

function rmv(arg)
{
	$(arg).parent('tr').remove();
}

function save()
{
	if(!$('#req')[0].checkValidity())
	{
	    $(this).show();
        $("#req")[0].reportValidity();
        return false;		
	}
	else
	{
		$.ajax({
			url: "<?php echo base_url('inventory/Requisition/save'); ?>",
			type: "post",
			data: $('#req').serialize(),
			success: function(data)
			{
				alert('Added Successfully');
				window.location='index';
			}
		});
	}
}
</script>