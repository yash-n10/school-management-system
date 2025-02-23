<div class="form-group has-feedback">
  <div class="box box-primary">
    <div class="box-body">
      
    </div>
	<!-------------------edit modal------------------------->
	<div id="myeditModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Update Company</h4>
		  </div>
		  <div class="modal-body">
			<div id="com_view">
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-success" data-dismiss="modal" onclick="update_comp()">Update</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
		</div>

	  </div>
	</div>
	<!-------------------End edit modal------------------------->
	
	
	
	
    <div class="box-body">
       <table class="table">
	    <tr>
		  <th>Sl No.</th>
	      <th>Category</th>
	      <th>Group</th>
	      <th>Company</th>
	      <th>Action</th>
	    </tr>
		<?php
		  if($comp)
		  {
			  $i = 1;
			  foreach($comp as $data)
			  {
		?>
		<tr>
		  <td><?php echo $i; ?></td>
		  <td><?php echo $data->cat_name; ?></td>
		  <td><?php echo $data->group_name; ?></td>
		  <td><?php echo $data->com_name; ?></td>
		  <td>
		    <a class="btn a-edit" title="Edit" onclick="edit(<?php echo $data->id; ?>,'<?php echo $data->category_id; ?>','<?php echo $data->product_group_id; ?>','<?php echo $data->com_name; ?>')"><i class="fa fa-edit"></i> </a>
		    <a class="btn a-delete" title="Delete" onclick="del(<?php echo $data->id; ?>,<?php echo $data->category_id; ?>,<?php echo $data->product_group_id; ?>,'<?php echo $data->com_name; ?>')"><i class="fa fa-trash"></i> </a>
		  </td>
		</tr>
		<?php
			  $i++;
			  }
		  }
		?>
       </table>
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
//            if ( this.search() !== this.value ) {
//                this
//                    .search( this.value )
//                    .draw();
//            }
            var i = $(this).attr('data-column');
            var v = $(this).val();
            table.columns(i).search(v).draw();
        });
});

function edit(id,cat,group,comp)
{
	$.ajax({
		url: "<?php echo base_url('inventory/Manage_products/comp_edit'); ?>",
		type: "post",
        data: {id:id,cat:cat,group:group,comp:comp},
        success: function(data)
        {
			$("#com_view").html(data);
			$("#myeditModal").modal('show');
			//alert(data);
		}		
	});
}

function update_comp()
{
	var upd_id = $("#upd_id").val();
	var cat_comp_edt = $("#cat_comp_edt").val();
	var group_comp_edt = $("#group_comp_edt").val();
	var company_edt = $("#company_edt").val();
	
	$.ajax({
		url: "<?php echo base_url('inventory/Manage_products/updatecomp')?>",
		type: "post",
		data: {upd_id:upd_id,cat_comp_edt:cat_comp_edt,group_comp_edt:group_comp_edt,company_edt:company_edt},
		success: function(data)
		{
			alert("Update Successfully");
			location.reload();
		}
	});
}

function del(id,cat_id,grp_id,company)
{
	var cnf = confirm("Are you sure want to delete ?");
	{
		if(cnf == true)
		{
			$.ajax({
				url: "<?php echo base_url('inventory/Manage_products/delcomp')?>", 
				type: "post",
				data: {id:id,cat_id:cat_id,grp_id:grp_id},
				success: function(data)
				{
					var dt = data;
					if(dt == data)
					{
						alert("Some products are exist under this "+company);
					}
					else
					{
					  alert("Delete Successfully");
					  location.reload();	
					}
				}
			});
		}
	}
}
</script>