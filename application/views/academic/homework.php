<div class="form-group has-feedback">
    <div class="box box-primary">
		<div class="box-body">    
			<div class='row'>
				<div class='col-sm-3'>Homework</div>
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
			</div>  
			<hr> 
			<form id="publisher_data">
				<div class="row top">
					<div class="col-md-12">
						
						<div class="col-md-3">
							<div class="form-group">
							    <label for="inputPassword" class="col-sm-4 col-form-label">Class</label>
							    <div class="col-sm-8">
							    	<select name="class" id="class">
							    		<option value="">Select Class</option>
							    		 <?php foreach($classs as $value){?>
					                      	<option value="<?php echo $value->id;?>"><?php echo $value->class_name;?></option>
					                      <?php }?>
							    	</select>
							       <input type="hidden" class="form-control" id="hid" value="" >
							    </div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
							    <label for="inputPassword" class="col-sm-4 col-form-label">Section</label>
							    <div class="col-sm-8">
							    	<select class="form-control" id="section" name="section" required>
                      					<option value="">-- Select Section --</option>
                    				</select>
							    </div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
							    <label for="inputPassword" class="col-sm-4 col-form-label">Subject</label>
							    <div class="col-sm-8">
							     <select class="form-control" id="subject" name="subject" required>
                       				<option value="">-- Select Subject --</option>
                				</select>
                			</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
							    <label for="inputPassword" class="col-sm-5 col-form-label">Homework Date</label>
							    <div class="col-sm-7">
							      <input type="text" id="homework_date" name="homework_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly="">
							    </div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
							    <label for="inputPassword" class="col-sm-4 col-form-label">Submission Date</label>
							    <div class="col-sm-8">
							      <input type="date" class="form-control" id="dos" name="dos" required> 
							    </div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
							    <label for="inputPassword" class="col-sm-4 col-form-label">Attachment</label>
							    <div class="col-sm-8">
							      <input type="file" id="userfile" name="userfile" class="form-control filestyle" autocomplete="off">
							    </div>
							</div>
							<center><img id="previewHolder" alt="" width="250px" height="200px"/ style="display:none"></center>
						</div>
						<div class="col-md-6">
							<div class="form-group">
							    <label for="inputPassword" class="col-sm-2 col-form-label">Description</label>
							    <div class="col-sm-10">
							      <textarea class="form-control" id="descr" name="descr" rows="2"></textarea>
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
							<th>S.No.</th>
							<th>Class</th>
							<th>Section</th>
							<th>Subject</th>
							<th>D/O/A</th>
							<th>D/O/S</th>
							<th>Descriptions</th>
							<th>Homework</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $x = 1;foreach($homework as $value){?>
		                <tr>
		                    <td><?php echo $x;?></td>
			                <td><?php echo $value->class_name;?></td>
			                <td><?php echo $value->sec_name;?></td>
			                <td><?php echo $value->name;?></td>
			                <td><?php echo $value->date_created;?></td>
			                <td><?php echo $value->dos;?></td>
			                <td><?php echo $value->description;?></td>
			                <?php if($value->attachment !='') {?>
		                  	<td><a href="<?php echo base_url();?>/homework/<?php echo $value->attachment;?>" class="btn btn-primary">View</a></td>
			                <?php } else { ?>
		                  <td><button class="btn btn-warning">No Attachment</button></td>
			                <?php } ?>
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

	$('#class').on('change keyup',function(){
  var value = $(this).val();
  $.ajax({
      url : "<?php echo site_url('academics/homework/Add_homework/GetSection')?>",
      type: "POST",
      data: {id:value},
      success: function(data)
      {         
        $('#section').empty();
        $("#section").append(data);
      },        
  });
});

$('#class_ed').on('change keyup',function(){
  var value = $(this).val();
  $.ajax({
      url : "<?php echo site_url('academics/homework/Add_homework/GetSection')?>",
      type: "POST",
      data: {id:value},
      success: function(data)
      {         
        $('#section_ed').empty();
        $("#section_ed").append(data);
      },        
  });
});

$('#class,#section').on('click change keyup',function(){
  var clas = $('#class').find('option:selected').val();
  var sect = $('#section').find('option:selected').val();

  $.ajax({
      url : "<?php echo site_url('academics/homework/Add_homework/GetSubjects')?>",
      type: "POST",
      data: {clasid:clas,sect:sect},
      success: function(data)
      { 
        $('#subject').empty();
        $("#subject").append(data);
      },        
  });
});

$('#class_ed,#section_ed').on('click change keyup',function(){
  var clas = $('#class_ed').find('option:selected').val();
  var sect = $('#section_ed').find('option:selected').val();

  $.ajax({
      url : "<?php echo site_url('academics/homework/Add_homework/GetSubjects')?>",
      type: "POST",
      data: {clasid:clas,sect:sect},
      success: function(data)
      { 
        $('#subject_ed').empty();
        $("#subject_ed").append(data);
      },        
  });
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