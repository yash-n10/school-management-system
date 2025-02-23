<div class="form-group has-feedback">
    <div class="box box-primary">
		<div class="box-body">    
			<div class='row'>
				<div class='col-sm-3'></div>
				<div class='col-sm-6'>
					<?php
					if($this->session->flashdata('success'))
					{
					?>
						<div class="alert alert-success alert-dismissible" id="suc_msg">
						<a href="#" class="close" data-dismiss="alert"></a>
						<?php echo $this->session->flashdata('success'); ?>
						</div>
					<?php 
					} 
					?>
				</div>

				<div class='col-sm-3'>
					<a href="<?php echo base_url(); ?>" class="btn btn-primary pull-right ">BACK</a>
				</div>	
			</div>  
			<hr> 
			<form id="vendor_data" onsubmit="save()">
				<div class="row top">
					<div class="col-md-12">
						<div class="col-md-4">
							<div class="form-group">
							    <label for="inputPassword" class="col-sm-4 col-form-label">Vendor Name</label>
							    <div class="col-sm-8">
							      <input type="text" class="form-control" id="vendor" value="" placeholder="Vendor Name" >
							      <input type="hidden" class="form-control" id="hid" value="" >
							    </div>
							</div>
						</div>
						
						<div class="col-md-4">
							<div class="form-group">
							</div>
						</div>
					</div>
				</div>
				<hr>
				 <a id="butt1" class="btn btn-success pull-right" onclick="update_data()" style="display:none;">UPDATE</a> 
				<a id="butt" class="btn btn-success pull-right" onclick="save()">SAVE</a>  
				
			</form>
		</div>
	</div>
</div>

<div class="form-group has-feedback">
    <div class="box box-primary">
		<div class="box-body">    
			<div class="table-responsive" id="data_tab">
				<table class="table table-bordered table-striped" id="book_vendor">
					<thead style="background:#99ceff;">
					  <tr>
					    <th>Sl No.</th>
					    <th>Vendor Name</th>
					    <th>Created At</th>
					    <th>Action</th>
					  </tr>
					</thead>
					<tbody>
						<?php $x = 1;foreach($vendor_data as $value){?>
		                <tr>
		                    <td><?php echo $x;?>.</td>
		                    <td><?php echo $value->name;?></td>
		                    <td><?php echo date('d/m/Y',strtotime($value->date_created));?></td>
		                    <td><a onclick="update(<?php echo $value->id;?>)" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a data-toggle="tooltip" data-placement="top" title="Delete" style="cursor: pointer;" onclick="deletes(<?php echo $value->id;?>)" ><i class="fa fa-trash" aria-hidden="true"></i></a></td>
		                </tr>
		                <?php $x++;}?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	$(document).ready(function() {
	  $('#book_vendor').DataTable();
	});

	function save()
	{
		var vendor = $('#vendor').val();
		$.ajax({
            url : "<?php echo base_url('library/master/book_vendor/save');?>",
            type: "POST",
            data: {vendor:vendor},
            success: function (data)
            {
            	$('#data_tab').html('');
            	$('#data_tab').html(data);
				$("#vendor_data")[0].reset();
            },
        });  
	}

	function deletes(id)
	{
		var r = confirm("Are You Sure!");
		if (r == true) {
		  
			$.ajax({
	            url: "<?php echo base_url('library/master/book_vendor/delete'); ?>",
	            type: "POST",
	            data: {id:id},
	            success: function (data)
	            {
	            	$('#data_tab').html('');
	            	$('#data_tab').html(data);
					$("#vendor_data")[0].reset();
	            },
	        });  

		} else {
		} 
	}
		function update(id)
	{
     $('#butt').hide();
     $('#butt1').show();
     $.ajax({
            url: "<?php echo base_url('library/master/book_vendor/update'); ?>",
            type: "POST",
            data: {id:id},
            dataType:"json",
            success: function (data)
            {
             $('#hid').val(data.hid);
              $('#vendor').val(data.name);
			 
            },
        });
	}
	function update_data()
	{
		
	    var vendor = $('#vendor').val();
	
		var hid = $('#hid').val();
	    $.ajax({
            url: "<?php echo base_url('library/master/book_vendor/update_data'); ?>",
            type: "POST",
            data: {vendor:vendor,hid:hid},
            success: function (data)
            {
            
            	console.log(data);
            	$('#data_tab').html('');
            	$('#data_tab').html(data);
				$("#vendor_data")[0].reset();
				$("#type").val('').trigger('change');
				$('#butt1').hide();
            	$('#butt').show();
            },
        });  
	}
</script>