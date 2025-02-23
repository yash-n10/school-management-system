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
	
	<!-------------------edit modal------------------------->
	<div id="myeditgrpModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Update Group</h4>
		  </div>
		  <div class="modal-body">
			<div id="grp_view">
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-success" data-dismiss="modal" onclick="update_grp()">Update</button>
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
	      <th>Group Name</th>
	      <th>Action</th>
	    </tr>
		<?php
		  if($group)
		  {
			  $i = 1;
			  foreach($group as $data)
			  {
		?>
		<tr>
		  <td><?php echo $i; ?></td>
		  <td><?php echo $data->cat_name; ?></td>
		  <td><?php echo $data->group_name; ?></td>
		  <td>
		    <a class="btn a-edit" title="Edit" onclick="edit(<?php echo $data->pg_id; ?>,<?php echo $data->pro_cat_id; ?>,'<?php echo $data->group_name; ?>')"><i class="fa fa-edit"></i> </a>
		    <a class="btn a-delete" title="Delete" onclick="del(<?php echo $data->pg_id; ?>,'<?php echo $data->group_name; ?>')"><i class="fa fa-trash"></i> </a>
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

function edit(id,cat_id,grp)
{
	$.ajax({
		url: "<?php echo base_url('inventory/Manage_products/editgrp'); ?>",
		type: "post",
        data: {id:id,cat_id:cat_id,grp:grp},
        success: function(data)
        {
			$("#grp_view").html(data);
			$("#myeditgrpModal").modal('show');
		}		
	});
}

function update_grp()
{
	var upd_id = $("#upd_id").val();
	var cat_edt = $("#cat_edt").val();
	var group_name_edt = $("#group_name_edt").val();
	
	$.ajax({
		url: "<?php echo base_url('inventory/Manage_products/updategrpp')?>",
		type: "post",
		data: {upd_id:upd_id,cat_edt:cat_edt,group_name_edt:group_name_edt},
		success: function(data)
		{
			alert("Update Successfully");
			location.reload();
		}
	});
}

function del(id,group)
{
	var cnf = confirm("Are you sure want to delete ?");
	{
		if(cnf == true)
		{
			$.ajax({
				url: "<?php echo base_url('inventory/Manage_products/delgrp')?>", 
				type: "post",
				data: {id:id},
				success: function(data)
				{
					var dt = data;
					if(dt == 'N')
					{
						alert("Some products are exist under this "+group);
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