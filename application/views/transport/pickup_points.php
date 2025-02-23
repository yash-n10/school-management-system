<div class="form-group has-feedback">
    <div class="box box-primary">
		<div class="box-body">    
			<div class='row'>
				<div class='col-sm-3'>Routes</div>
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
					<!-- <a href="<?php echo base_url(); ?>" class="btn btn-primary pull-right ">BACK</a> -->
					 <a class="btn btn-import pull-right" id="studexport" href='<?= base_url()?>transport/Routes/importcsv' data-toggle="tooltip" data-placement="bottom" title="Import Routes">
                    <i class="fa fa-cloud-upload fa-lg"></i>&nbsp;
                </a>
				</div>	
			</div>  
			<hr> 
			<form id="publisher_data">
				<div class="row top">
					<div class="col-md-12">
						
						<div class="col-md-3">
							<div class="form-group">
							    <label for="inputPassword" class="col-sm-4 col-form-label">Route</label>
							    <div class="col-sm-8">
							    	<select name="routes" id="routes">
							    		<option value="">Select Route</option>
							    		<?php foreach($route_code as $data) { ?>
							    			<option value="<?php echo $data->id ?>"><?php echo $data->route_code ?></option>
							    		<?php } ?>
							    	</select>
							       <input type="hidden" class="form-control" id="hid" value="" >
							    </div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
							    <label for="inputPassword" class="col-sm-4 col-form-label">Pickup Location</label>
							    <div class="col-sm-8">
							    	<select name="location" id="location">
							    		<option value="">Select Location</option>
							    		<?php foreach($location as $data) { ?>
							    			<option value="<?php echo $data->id ?>"><?php echo $data->location_description ?></option>
							    		<?php } ?>
							    	</select>
							    </div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
							    <label for="inputPassword" class="col-sm-4 col-form-label">Pickup Time</label>
							    <div class="col-sm-8">
							      <input type="time" class="form-control" id="pickup_time" name="pickup_time" value="" placeholder="Enter Pickup Time" >
							    </div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
							    <label for="inputPassword" class="col-sm-4 col-form-label">Amounts</label>
							    <div class="col-sm-8">
							      <input type="number" class="form-control" id="amounts" name="amounts" value="" placeholder="Enter Amounts" >
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
					    <th>Route Code</th>
					    <th>Pickup Location</th>
					    <th>Time</th>
					    <th>Amount</th>
					    <th>Action</th>
					  </tr>
					</thead>
					<tbody>
						<?php $x = 1;foreach($transport_pickup_points as $value){?>
		                <tr>
		                    <td><?php echo $x;?>.</td>
		                    <td><?php echo $value->route_name;?></td>
		                    <td><?php echo $value->location_name;?></td>
		                    <td><?php echo $value->pick_up_time;?></td>
		                    <td><?php echo $value->amounts;?></td>
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
		var routes = $('#routes').val();
		var location = $('#location').val();
		var pickup_time = $('#pickup_time').val();
		var amounts = $('#amounts').val();
		$.ajax({
            url : "<?php echo base_url('transport/Pickup_points/save');?>",
            type: "POST",
            data: {routes:routes,location:location,pickup_time:pickup_time,amounts:amounts},
            success: function (data)
            {
            	$('#data_tab').html('');
            	$('#data_tab').html(data);
				$("#publisher_data")[0].reset();
				$("#location").val('').trigger('change');
				$("#routes").val('').trigger('change');
            },
        });  
	}


	function deletes(id)
	{
		var r = confirm("Are You Sure!");
		if (r == true) {
		$.ajax({
            url: "<?php echo base_url('transport/Pickup_points/delete'); ?>",
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
            url: "<?php echo base_url('transport/Pickup_points/update'); ?>",
            type: "POST",
            data: {id:id},
            dataType:"json",
            success: function (data)
            {
             	$('#hid').val(data.hid);
              	$('#pickup_time').val(data.pick_up_time);
              	$('#amounts').val(data.amounts);
              	$('#location').val(data.location_id).prop('selected', true).trigger('change');
              	$('#routes').val(data.route_id).prop('selected', true).trigger('change');
			 
            },
        });
	}
	function update_data()
	{
		
	    var routes = $('#routes').val();
		var location = $('#location').val();
		var pickup_time = $('#pickup_time').val();
		var amounts = $('#amounts').val();
	
		var hid = $('#hid').val();
	    $.ajax({
            url: "<?php echo base_url('transport/Pickup_points/update_data'); ?>",
            type: "POST",
            data: {hid:hid,routes:routes,location:location,pickup_time:pickup_time,amounts:amounts},
            success: function (data)
            {
            
            	console.log(data);
            	$('#data_tab').html('');
            	$('#data_tab').html(data);
				$("#publisher_data")[0].reset();
				$("#location").val('').trigger('change');
				$("#routes").val('').trigger('change');
				$('#butt1').hide();
            	$('#butt').show();
            },
        });  
	}

	
</script>