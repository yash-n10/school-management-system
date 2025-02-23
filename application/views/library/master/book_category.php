<style>
	.has-feedback .form-control {
    padding-right: 0.5px;
}
</style>
<div class="form-group has-feedback">
    <div class="box box-primary">
		<div class="box-body">    
			<div class='row'>
				<div class='col-sm-3'></div>
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
					<a href="<?php echo base_url(); ?>" class="btn btn-primary pull-right ">BACK</a>
				</div>	
			</div>  
			<hr> 
			<div class="row top" id="result">
			<form id="category_data">
					<div class="col-md-12">
						<div class="col-md-4">
							<div class="form-group">
							    <label for="inputPassword" class="col-sm-4 col-form-label">Type</label>
							    <div class="col-sm-6">
							    	
							      	<select class="form-control" id="type" name="type">				    
							      		<option value="">Select..</option>  
							      		<?php 
							      		foreach ($type as $key => $value) 
							      		{
							      		?>
							      			<option value="<?php echo $value->id;?>"><?php echo $value->name;?></option>
							      		<?php
							      		}
							      		?>
								    </select>
							    </div>
							    <div class="col-md-2">
							    	<a data-toggle="tooltip" data-placement="right" title="Add New Type" href="#"><i class="fa fa-plus-square" style="font-size:32px;color:red;"></i></a>
							    </div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
							    <label for="inputPassword" class="col-sm-4 col-form-label">Category Name</label>
							    <div class="col-sm-8">
							      <input type="text" class="form-control" id="category" value="" placeholder="Category Name" >
							      <br>
							    </div>
							</div>
						</div>
						
						<div class="col-md-4">
							<div class="form-group">
							</div>
						</div>
					</div>
					<br>
					<br>

					        <div class="col-md-12">
		                       <div class="col-md-2">
							   <label >NO. OF BOOK ALLOT:</label>
					
					           </div>
							    <div class="col-md-4">
								
								<label for="inputPassword" class="col-sm-4 col-form-label">For Student</label>
								<div class="col-sm-7">
								<input type="number" class="form-control" id="book_std" value="" placeholder="Max. Book Allot" >
								<br>
		                        </div> 
							   </div>
							    <div class="col-md-4">
								<label for="inputPassword" class="col-sm-4 col-form-label">For Staff</label>
								<div class="col-sm-7">
		                        <input type="number" class="form-control" id="book_staff" value="" placeholder="Max. Book Allot" >
		                        <br>
		                        </div>
							    </div>
					      </div>
               
					        <div class="col-md-12">
					    	 <div class="col-md-2">
							 <label >NO. OF DAY'S ALLOT:</label>
					
					         </div>
							<div class="col-md-4">
								<label for="inputPassword" class="col-sm-4 col-form-label">For Student</label>
								<div class="col-sm-7">
								<input type="number" class="form-control" id="day_std" value="" placeholder="Max. Day Allot" >
								<br>
							</div>

							</div>
							<div class="col-md-4">
								<label for="inputPassword" class="col-sm-4 col-form-label">For Staff</label>
								<div class="col-sm-7">
		                        <input type="number" class="form-control" id="day_staff" value="" placeholder="Max. Day Allot" >
		                        <br>
		                    </div>
							</div>
						</div>
		                </br>
					      <div class="col-md-12">
			              	<div class="col-md-2">
							<label>FINE CHARGES:</label>
					
							</div>
							<div class="col-md-4">
								<label for="inputPassword" class="col-sm-4 col-form-label">For Student</label>
								<div class="col-sm-7">
								<input type="number" class="form-control" id="fine_std" value="" placeholder="Fine Per/day" >
								<br>
							</div>

							</div>
							<div class="col-md-4">
								<label for="inputPassword" class="col-sm-4 col-form-label">For Staff</label>
								<div class="col-sm-7">
			                    <input type="number" class="form-control" id="fine_staff" value="" placeholder="Fine Per/day" >
			                    <br>
			                     <input type="hidden" class="form-control" id="hid" value="">
			                </div>
							</div>
						</div>
                        </br>

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
				<table class="table table-bordered table-striped" id="book_category">
					<thead style="background:#99ceff;">
					  <tr>
					    <th>Sl No.</th>
					    <th>Type</th>
					    <th>Category Name</th>
					    <th>Created At</th>
					    <th>Action</th>
					  </tr>
					</thead>
					<tbody>
						<?php $x = 1;foreach($category as $value){?>
						<tr>
							<td><?php echo $x;?>.</td>
							<td><?php echo $value->name;?></td>
							<td><?php echo $value->category_name;?></td>
							<td><?php echo date('d/m/Y',strtotime($value->date_created));?></td>
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
	  $('#book_category').DataTable();
	});

	function save()
	{
		var type = $('#type').val();
		var cate = $('#category').val();
		var book_std = $('#book_std').val();

		var book_staff = $('#book_staff').val();
		var day_std = $('#day_std').val();
		var day_staff = $('#day_staff').val();
		var fine_staff = $('#fine_staff').val();
		var fine_std = $('#fine_std').val();

		$.ajax({
            url: "<?php echo base_url('library/master/book_cat/save'); ?>",
            type: "POST",
            data: {type:type,cate:cate,book_std:book_std,book_staff:book_staff,fine_std:fine_std,fine_staff:fine_staff,day_std:day_std,day_staff:day_staff},
            success: function (data)
            {
            	$('#data_tab').html('');
            	$('#data_tab').html(data);
				$("#category_data")[0].reset();
				$("#type").val('').trigger('change');
            },
        });  
	}

	function deletes(id)
	{
		var r = confirm("Are You Sure!");
		if (r == true) {
		$.ajax({
            url: "<?php echo base_url('library/master/book_cat/delete'); ?>",
            type: "POST",
            data: {id:id},
            success: function (data)
            {
            	$('#data_tab').html('');
            	$('#data_tab').html(data);
				$("#category_data")[0].reset();
				$("#type").val('').trigger('change');
            },
        });
        }else{}  
	}
	function update(id)
	{
     $('#butt').hide();
     $('#butt1').show();
     $.ajax({
            url: "<?php echo base_url('library/master/book_cat/update'); ?>",
            type: "POST",
            data: {id:id},
            dataType:"json",
            success: function (data)
            {
				$('#type').html(data.typess);
				$('#hid').val(data.hid);
				$('#category').val(data.cat);
				$('#book_std').val(data.book_std);
				$('#book_staff').val(data.book_staff);
				$('#day_std').val(data.day_std);
				$('#day_staff').val(data.day_staff);
				$('#fine_staff').val(data.fine_staff);
				$('#fine_std').val(data.fine_std);
            },
        });
	}
	function update_data()
	{
		
	    var type = $('#type').val();
		var cate = $('#category').val();
		var book_std = $('#book_std').val();
		var book_staff = $('#book_staff').val();
		var day_std = $('#day_std').val();
		var day_staff = $('#day_staff').val();
		var fine_staff = $('#fine_staff').val();
		var fine_std = $('#fine_std').val();
		var hid = $('#hid').val();
	    $.ajax({
            url: "<?php echo base_url('library/master/book_cat/update_data'); ?>",
            type: "POST",
            data: {type:type,cate:cate,book_std:book_std,book_staff:book_staff,fine_std:fine_std,fine_staff:fine_staff,day_std:day_std,day_staff:day_staff,hid:hid},
            success: function (data)
            {
            	$('#data_tab').html('');
            	$('#data_tab').html(data);
				$("#category_data")[0].reset();
				$("#type").val('').trigger('change');
				$('#butt1').hide();
            	$('#butt').show();
            },
        });  
	}
</script>