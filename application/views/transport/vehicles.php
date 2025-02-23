<div class="form-group has-feedback">
    <div class="box box-primary">
		<div class="box-body">    
			<div class='row'>
				<div class='col-sm-3'>Vehicles</div>
				<div class='col-sm-6'>
					<?php
					if($this->session->flashdata('success')){
					?>
					<div class="alert alert-success alert-dismissible" id="suc_msg">
					<a href="#" class="close" data-dismiss="alert"></a>
					<?php echo $this->session->flashdata('success'); ?>
					</div>
					<?php } ?>
				</div>

				<div class='col-sm-3'>
					<a href="<?php echo base_url('transport/vehicles/vehicles_list'); ?>" class="btn btn-primary pull-right ">BACK</a>
				</div>	
			</div>  
			<hr> 
			<form id="publisher_data">
				<div class="row top">
					<div class="col-md-12">
						<div class="col-md-4">
							<div class="form-group">
							    <label for="inputPassword" class="col-sm-4 col-form-label">Vehicle No.</label>
							    <div class="col-sm-8">
							      <input type="text" class="form-control" id="vehicle_no" name="vehicle_no" value="" placeholder="Vehicle No" >
							       <input type="hidden" class="form-control" id="hid" value="" >
							    </div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
							    <label for="inputPassword" class="col-sm-4 col-form-label">Seats</label>
							    <div class="col-sm-8">
							      <input type="number" class="form-control" id="seats" name="seats" value="" placeholder="No. of Seats" >
							    </div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
							    <label for="inputPassword" class="col-sm-4 col-form-label">Usable Seats</label>
							    <div class="col-sm-8">
							      <input type="text" class="form-control" id="usable_seats" name="usable_seats" value="" placeholder="Usable Seats" >
							    </div>
							</div>
						</div>
					</div>
				</div>
					<div class="row top">
					<div class="col-md-12">
						<div class="col-md-4">
							<div class="form-group">
							    <label for="inputPassword" class="col-sm-4 col-form-label">Vehicle Type</label>
							    <div class="col-sm-8">
							      <select class="form-control" id="vehicle_type" name="vehicle_type">
							      	<option value="">Select</option>
							      	<option value="Ownership">Ownership</option>
							      	<option value="Contract">Contract</option>
							      </select>
							    </div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
							    <label for="inputPassword" class="col-sm-4 col-form-label">Contact</label>
							    <div class="col-sm-8">
							      <input type="number" class="form-control" id="contact" name="contact" value="" placeholder="Cantact No." >
							    </div>
							</div>
						</div>
							<div class="col-md-4">
							<div class="form-group">
							    <label for="inputPassword" class="col-sm-4 col-form-label">Insurance Renewal Date</label>
							    <div class="col-sm-8">
							      <input type="date" class="form-control" id="insurance_date" name="insurance_date" value="" placeholder="Insurance Date" >
							    </div>
							</div>
						</div>
						</div>
					</div>
						

				<hr>
				<a id="butt" class="btn btn-success pull-right" onclick="save()">SAVE</a>  
				 <a id="butt1" class="btn btn-success pull-right" onclick="update_data()" style="display:none;">UPDATE</a> 
				
			</form>
		</div>
	</div>
</div>

<div class="form-group has-feedback">
    <div class="box box-primary">
		<div class="box-body">    
			<div class="table-responsive" id="data_tab">
				<table class="table table-bordered table-striped" id="book_publisher">
					<thead style="background:#99ceff;">
					  <tr>
					    <th>Sl No.</th>
					    <th>Vehicle No</th>
					    <th>Seats</th>
					    <th>Usable Seats</th>
					    <th>Vehicle Type</th>
					    <th>Contact</th>
					    <th>Insurance Date</th>
					    <th>Action</th>
					  </tr>
					</thead>
					<tbody>
						<?php $x = 1;foreach($vehicle as $value){?>
		                <tr>
		                    <td><?php echo $x;?>.</td>
		                    <td><?php echo $value->vehicle_no;?></td>
		                    <td><?php echo $value->total_seats;?></td>
		                    <td><?php echo $value->max_allot_seats;?></td>
		                    <td><?php echo $value->vehicle_type;?></td>
		                    <td><?php echo $value->contact_person;?></td>
		                    <td><?php echo date('d/m/Y',strtotime($value->insurance_renew_date));?></td>
		                    <td><a  data-toggle="tooltip" data-placement="top" title="Edit" onclick="update(<?php echo $value->id;?>)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a data-toggle="tooltip" data-placement="top" title="Delete" style="cursor: pointer;" onclick="deletes(<?php echo $value->id;?>)"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
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
	  $('#book_publisher').DataTable();
	});

	function save()
	{
		var vehicle_no = $('#vehicle_no').val();
		var seats = $('#seats').val();
		var usable_seats = $('#usable_seats').val();
		var vehicle_type = $('#vehicle_type').val();
		var contact = $('#contact').val();
		var insurance_date = $('#insurance_date').val();
		$.ajax({
            url : "<?php echo base_url('transport/Vehicles/save');?>",
            type: "POST",
            data: {vehicle_no:vehicle_no,seats:seats,usable_seats:usable_seats,vehicle_type:vehicle_type,contact:contact,insurance_date:insurance_date},
            success: function (data)
            {
            	$('#data_tab').html('');
            	$('#data_tab').html(data);
				$("#publisher_data")[0].reset();
            },
        });  
	}

	function deletes(id)
	{
		var r = confirm("Are You Sure!");
		if (r == true) {
		$.ajax({
            url: "<?php echo base_url('transport/Vehicles/delete'); ?>",
            type: "POST",
            data: {id:id},
            success: function (data)
            {
            	$('#data_tab').html('');
            	$('#data_tab').html(data);
				$("#publisher_data")[0].reset();
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
            url: "<?php echo base_url('transport/Vehicles/update'); ?>",
            type: "POST",
            data: {id:id},
            dataType:"json",
            success: function (data)
            {
             	$('#hid').val(data.hid);
              	$('#vehicle_no').val(data.vehicle_no);
              	$('#seats').val(data.total_seats);
              	$('#usable_seats').val(data.max_allot_seats);
              	// $('#vehicle_type').val(data.vehicle_type);
              	$('#contact').val(data.contact);
              	$('#insurance_date').val(data.insurance_date);
              	$('#vehicle_type').val(data.vehicle_type).prop('selected', true).trigger('change');
			 
            },
        });
	}
	function update_data()
	{
		
	    var vehicle_no = $('#vehicle_no').val();
		var seats = $('#seats').val();
		var usable_seats = $('#usable_seats').val();
		var vehicle_type = $('#vehicle_type').val();
		var contact = $('#contact').val();
		var insurance_date = $('#insurance_date').val();
	
		var hid = $('#hid').val();
	    $.ajax({
            url: "<?php echo base_url('transport/Vehicles/update_data'); ?>",
            type: "POST",
            data: {vehicle_no:vehicle_no,seats:seats,usable_seats:usable_seats,vehicle_type:vehicle_type,contact:contact,insurance_date:insurance_date,hid:hid},
            success: function (data)
            {
            
            	console.log(data);
            	$('#data_tab').html('');
            	$('#data_tab').html(data);
				$("#publisher_data")[0].reset();
				$("#vehicle_type").val('').trigger('change');
				$('#butt1').hide();
            	$('#butt').show();
            },
        });  
	}

	function deletes(id)
	{
		var r = confirm("Are You Sure!");
		if (r == true) {
		$.ajax({
            url: "<?php echo base_url('transport/Vehicles/delete'); ?>",
            type: "POST",
            data: {id:id},
            success: function (data)
            {
            	$('#data_tab').html('');
            	$('#data_tab').html(data);
				$("#publisher_data")[0].reset();
            },
        });
        } else {
		}   
	}
	
</script>