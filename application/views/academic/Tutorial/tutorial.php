<div class="form-group has-feedback">
    <div class="box box-primary">
		<div class="box-body">    
			<div class='row'>
				<div class='col-sm-3'>Add Tutorial</div>
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
					<a href="<?php echo base_url('academics/Tutorial/Tutorial'); ?>" class="btn btn-primary pull-right">Reload</a>
				</div>	
			</div>  
			<hr> 
			<form id="publisher_data" enctype="multipart/form-data">
				<div class="row top">
					<div class="col-md-12">
						<div class="col-md-4">
							<div class="form-group">
							    <label for="inputPassword" class="col-sm-4 col-form-label">Class</label>
							    <div class="col-sm-8">
							     <select name="v_class" id="v_class" class="form-control">
							     	<option value="">Select Class</option>
							     	<?php foreach ($class as $key => $value) { ?>
							     		<option value="<?php echo $value->id ?>"><?php echo $value->class_name; ?>
							     	<?php } ?>
							     </select>
							       <input type="hidden" class="form-control" id="hid" value="" >
							    </div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
							    <label for="inputPassword" class="col-sm-4 col-form-label">Subject</label>
							    <div class="col-sm-8">
							     <select name="subject" id="subject" class="form-control">
							     	<option value="">Select Subject</option>
							     	<?php foreach ($subject as $key => $value) { ?>
							     		<option value="<?php echo $value->id ?>"><?php echo $value->name; ?>
							     	<?php } ?>
							     </select>
							    </div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
							    <label for="inputPassword" class="col-sm-4 col-form-label">Title</label>
							    <div class="col-sm-8">
							      <input type="text" class="form-control" id="title" name="title" value="" placeholder="Enter Title" >
							    </div>
							</div>
						</div>
					</div>
				</div>
					<div class="row top">
					<div class="col-md-12">
						<div class="col-md-4">
							<div class="form-group">
							    <label for="inputPassword" class="col-sm-4 col-form-label">Video Url</label>
							    <div class="col-sm-8">
							      <input type="text" name="video_url" id="video_url" class="form-control" placeholder="Enter Video url">
							    </div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
							    <label for="inputPassword" class="col-sm-4 col-form-label">Image</label>
							    <div class="col-sm-8">
							      <input type="file" class="form-control" id="image" name="image" value="">
							    </div>
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
							    <label for="inputPassword" class="col-sm-4 col-form-label">Date</label>
							    <div class="col-sm-8">
							      <input type="date" class="form-control" id="lesson_date" name="lesson_date" value="">
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
					    <th>CLass Name</th>
					    <th>Subject Name</th>
					    <th>Title</th>
					    <th>Video url</th>
					    <th>Date</th>
					    <th>Image</th>
					    <th>Action</th>
					  </tr>
					</thead>
					<tbody>
						<?php $x = 1;foreach($video_tutorial as $value){?>
		                <tr>
		                    <td><?php echo $x;?>.</td>
		                    <td><?php echo $value->class_name;?></td>
		                    <td><?php echo $value->subject_name;?></td>
		                    <td><?php echo $value->title;?></td>
		                    <td><?php echo $value->video_url;?></td>
		                    <td><?php echo $value->lesson_date;?></td>
		                    <td><?php echo $value->image_video;?></td>
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
		var v_class = $('#v_class').val();
		var subject = $('#subject').val();
		var title = $('#title').val();
		var video_url = $('#video_url').val();
		var video_image = $('#video_image').val();
		var lesson_date = $('#lesson_date').val();
		$.ajax({
		        type: "POST",
			    url: "<?php echo base_url('academics/Tutorial/Tutorial/save');?>",
			    data: new FormData($('#publisher_data')[0]),
			    processData: false,
			    contentType: false,
			    dataType:"json",
			    success: function (data) {
			        $('#data_tab').html('');
		            	$('#data_tab').html(data);
						$("#publisher_data")[0].reset();
		    	}
    });
	}

	function deletes(id)
	{
		var r = confirm("Are You Sure!");
		if (r == true) {
		$.ajax({
            url: "<?php echo base_url('academics/Tutorial/Tutorial/delete'); ?>",
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
            url: "<?php echo base_url('academics/Tutorial/Tutorial/update'); ?>",
            type: "POST",
            data: {id:id},
            dataType:"json",
            success: function (data)
            {
             	$('#hid').val(data.hid);
              	$('#video_url').val(data.video_url);
              	$('#title').val(data.title);
              	$('#lesson_date').val(data.lesson_date);
              	$('#video_image').val(data.image_video);
              	$('#v_class').val(data.class_id).prop('selected', true).trigger('change');
              	$('#subject').val(data.subject_id).prop('selected', true).trigger('change');
			 
            },
        });
	}
	function update_data()
	{
		var v_class = $('#v_class').val();
		var subject = $('#subject').val();
		var title = $('#title').val();
		var video_url = $('#video_url').val();
		var video_image = $('#video_image').val();
		var lesson_date = $('#lesson_date').val();
		var hid = $('#hid').val();
	    $.ajax({
            url: "<?php echo base_url('academics/Tutorial/Tutorial/update_data'); ?>",
			    data: {v_class:v_class,subject:subject,title:title,video_url:video_url,lesson_date:lesson_date,hid:hid},
			    type: "POST",
            	dataType:"json",
            success: function (data)
            {
            
            	console.log(data);
            	$('#data_tab').html('');
            	$('#data_tab').html(data);
				$("#publisher_data")[0].reset();
				$("#v_class").val('').trigger('change');
				$("#subject").val('').trigger('change');
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