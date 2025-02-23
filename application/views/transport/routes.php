<div class="form-group has-feedback">
    <div class="box box-primary">
		<div class="box-body">    
			<div class='row'>
				<div class='col-sm-3'>Routes</div>
				<div class='col-sm-6'>
					<div id="trip_div" style="display:none;">
						<div class="form-group">
							    <label for="inputPassword" class="col-sm-2 col-form-label">Trip</label>
							    <div class="col-sm-6">
							       <input type="text" class="form-control" id="trip_name" value="" >
							    </div>
							    &nbsp;&nbsp;
								<a id="save_trip_xtra" class="btn btn-success pull-right" onclick="savetrip();">SAVE</a>
							</div>
							
						</div>

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
			<script>
				function opntrip(me){
					var id=me.value;
					if(id=='add_trip')
					{
						$('#trip_div').show();
					}else{
						$('#trip_div').hide();
					}
				}
			</script>
			<form id="publisher_data">
				<div class="row top">
					<div class="col-md-12">
						
						<div class="col-md-4">
							<div class="form-group">
							    <label for="inputPassword" class="col-sm-4 col-form-label">Trip</label>
							    <div class="col-sm-8">
							    	<select name="trip" id="trip" onchange ="opntrip(this)">
							    		<option value="">Select Trip</option>
							    		<option value="add_trip">Add Trip</option>
							    		<?php foreach($trip as $data) { ?>
							    			<option value="<?php echo $data->id ?>"><?php echo $data->trip_name ?></option>
							    		<?php } ?>
							    	</select>
							       <input type="hidden" class="form-control" id="hid" value="" >
							    </div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
							    <label for="inputPassword" class="col-sm-4 col-form-label">Vehicle No.</label>
							    <div class="col-sm-8">
							    	<select name="vehicle_no" id="vehicle_no">
							    		<option value="">Select Vehicle</option>
							    		<?php foreach($vehicle as $data) { ?>
							    			<option value="<?php echo $data->id ?>"><?php echo $data->vehicle_no ?></option>
							    		<?php } ?>
							    	</select>
							       <input type="hidden" class="form-control" id="hid" value="" >
							    </div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
							    <label for="inputPassword" class="col-sm-4 col-form-label">Route Code</label>
							    <div class="col-sm-8">
							      <input type="text" class="form-control" id="routes" name="routes" value="" placeholder="Enter Routes Code" >
							    </div>
							</div>
						</div>
					
					</div>
				</div>
					<div class="row top">
					<div class="col-md-12">
							<div class="col-md-4">
							<div class="form-group">
							    <label for="inputPassword" class="col-sm-4 col-form-label">Start Point</label>
							    <div class="col-sm-8">
							    	<select name="start_point" id="start_point">
							    		<option value="">Select Start Point</option>
							    		<?php foreach($location as $data) { ?>
							    			<option value="<?php echo $data->id ?>"><?php echo $data->location_description ?></option>
							    		<?php } ?>
							    	</select>
							    </div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
							    <label for="inputPassword" class="col-sm-4 col-form-label">End Point</label>
							    <div class="col-sm-8">
							     <select name="end_point" id="end_point">
							    		<option value="">Select End Point</option>
							    		<?php foreach($location as $data) { ?>
							    			<option value="<?php echo $data->id ?>"><?php echo $data->location_description ?></option>
							    		<?php } ?>
							    	</select>
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
					    <th>Vehicle No</th>
					    <th>Start</th>
					    <th>End</th>
					    <th>Trip</th>
					    <th>Action</th>
					  </tr>
					</thead>
					<tbody>
						<?php $x = 1;foreach($routes as $value){?>
		                <tr>
		                    <td><?php echo $x;?>.</td>
		                    <td><?php echo $value->route_code;?></td>
		                    <td><?php echo $value->vehicle_name;?></td>
		                    <td><?php echo $value->start_point;?></td>
		                    <td><?php echo $value->end_point;?></td>
		                    <td>Trip</td>
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
		var routes = $('#routes').val();
		var start_point = $('#start_point').val();
		var end_point = $('#end_point').val();
		var trip = $('#trip').val();
		$.ajax({
            url : "<?php echo base_url('transport/Routes/save');?>",
            type: "POST",
            data: {vehicle_no:vehicle_no,routes:routes,start_point:start_point,end_point:end_point,trip:trip},
            success: function (data)
            {
            	$('#data_tab').html('');
            	$('#data_tab').html(data);
				$("#publisher_data")[0].reset();
            },
        });  
	}

	function savetrip()
	{
		var trip_name = $('#trip_name').val();
		$.ajax({
            url : "<?php echo base_url('transport/Routes/savetrip');?>",
            type: "POST",
            data: {trip_name:trip_name},
            success: function (data)
            {
            	$('#data_tab').html('');
            	$('#data_tab').html(data);
				$("#publisher_data")[0].reset();
				$('#trip_div').css('display','none');
            },
        });  
	}

	function deletes(id)
	{
		var r = confirm("Are You Sure!");
		if (r == true) {
		$.ajax({
            url: "<?php echo base_url('transport/Routes/delete'); ?>",
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
            url: "<?php echo base_url('transport/Routes/update'); ?>",
            type: "POST",
            data: {id:id},
            dataType:"json",
            success: function (data)
            {
             	$('#hid').val(data.hid);
              	$('#routes').val(data.route_code);
              	$('#vehicle_no').val(data.vehicle_no).prop('selected', true).trigger('change');
              	$('#start_point').val(data.start_place).prop('selected', true).trigger('change');
              	$('#end_point').val(data.end_place).prop('selected', true).trigger('change');
              	$('#trip').val(data.trip).prop('selected', true).trigger('change');
			 
            },
        });
	}
	function update_data()
	{
		
	    var vehicle_no = $('#vehicle_no').val();
		var routes = $('#routes').val();
		var start_point = $('#start_point').val();
		var end_point = $('#end_point').val();
		var trip = $('#trip').val();
	
		var hid = $('#hid').val();
	    $.ajax({
            url: "<?php echo base_url('transport/Routes/update_data'); ?>",
            type: "POST",
            data: {vehicle_no:vehicle_no,routes:routes,start_point:start_point,end_point:end_point,trip:trip,hid:hid},
            success: function (data)
            {
            
            	console.log(data);
            	$('#data_tab').html('');
            	$('#data_tab').html(data);
				$("#publisher_data")[0].reset();
				$("#vehicle_no").val('').trigger('change');
				$("#start_point").val('').trigger('change');
				$("#end_point").val('').trigger('change');
				$("#trip").val('').trigger('change');
				$('#butt1').hide();
            	$('#butt').show();
            },
        });  
	}

	
</script>