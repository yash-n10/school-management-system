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
			<h4 class="modal-title">Update Category</h4>
		  </div>
		  <div class="modal-body">
			<div id="cat_view">
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-success" data-dismiss="modal" onclick="update()">Update</button>
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
	      <th>Product</th>
	      <th>HSN</th>
	      <th>Action</th>
	    </tr>
		<?php
		  if($pro)
		  {
			  $i = 1;
			  foreach($pro as $data)
			  {
		?>
		<tr>
		  <td><?php echo $i; ?></td>
		  <td><?php echo $data->category_name; ?></td>
		  <td><?php echo $data->group_name; ?></td>
		  <td><?php echo $data->comp_name; ?></td>
		  <td><?php echo $data->product; ?></td>
		  <td><?php echo $data->hsn; ?></td>
		  <td>
		    <a class="btn a-edit" title="Edit" onclick="edit(<?php echo $data->id; ?>)"><i class="fa fa-edit"></i> </a>
		    <a class="btn a-delete" title="Delete" onclick="del(<?php echo $data->id; ?>)"><i class="fa fa-trash"></i> </a>
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

function edit(id,cat,code)
{
	$.ajax({
		url: "<?php echo base_url('inventory/Manage_products/edit'); ?>",
		type: "post",
        data: {id:id,cat:cat,code},
        success: function(data)
        {
			$("#cat_view").html(data);
			$("#myeditModal").modal('show');
		}		
	});
}

function update()
{
	var upd_id = $("#upd_id").val();
	var cat_edt = $("#cat_edt").val();
	var gst_edt = $("#gst_edt").val();
	
	$.ajax({
		url: "<?php echo base_url('inventory/Manage_products/update')?>",
		type: "post",
		data: {upd_id:upd_id,cat_edt:cat_edt,gst_edt:gst_edt},
		success: function(data)
		{
			alert("Update Successfully");
			location.reload();
		}
	});
}

function del(id)
{
	var cnf = confirm("Are you sure want to delete ?");
	{
		if(cnf == true)
		{
			$.ajax({
				url: "<?php echo base_url('inventory/Manage_products/del')?>", 
				type: "post",
				data: {id:id},
				success: function(data)
				{
					alert("Delete Successfully");
					location.reload();
				}
			});
		}
	}
}
</script>