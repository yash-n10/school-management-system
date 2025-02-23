<div class="form-group has-feedback">
	<div class="box-body">  
    	<a  class="btn btn-success pull-right" href="<?php echo base_url('library/book/book_list');?>">Back</a>
    </div>
	<form id="book_add" action="<?php echo base_url('library/book/add_book/add');?>" method="post">
		<div class="box box-primary">
			<div class="box-body">    
				<div class='row'>
					<div class='col-sm-3'></div>
					<div class='col-sm-6'>
						 <input type="hidden" class="form-control" id="hid" value="">
						 <input type="hidden" class="form-control" id="action" value="">
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
				</div>  				
				<div class="row top">
					<div class="col-md-12">
						<div class="col-md-4">
							<div class="form-group">
								<label for="inputPassword" class="col-sm-4 col-form-label">Category</label>
								<div class="col-sm-8">
									<select class="form-control" id="category" name="category" required="">				    
										<option value="">Select..</option>  
										<?php
										foreach($category as $cat_value)
										{
										?>
										<option value="<?php echo $cat_value->id;?>"><?php echo $cat_value->category_name;?></option>
										<?php 
										}
										?>
									</select>
								</div>
							</div>
						</div>
						
						<div class="col-md-4">
							<div class="form-group">
								<label for="inputPassword" class="col-sm-4 col-form-label">Name</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="name" name="name" value="" placeholder="Name" required="">

								</div>
							</div>
						</div>
						
						<div class="col-md-4">
							<div class="form-group">
								<label for="inputPassword" class="col-sm-4 col-form-label">Publisher</label>
								<div class="col-sm-8">
									<select class="form-control" id="publisher" name="publisher">				    
										<option value="">Select..</option>  
										<?php
										foreach($publisher as $pub_value)
										{
										?>
										<option value="<?php echo $pub_value->id;?>"><?php echo $pub_value->name;?></option>
										<?php 
										}
										?>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row top">
					<div class="col-md-12">
						<div class="col-md-4">
							<div class="form-group">
								<label for="inputPassword" class="col-sm-4 col-form-label">Author</label>
								<div class="col-sm-8">
									<select class="form-control" id="author" name="author">				    
										<option value="">Select..</option>  
										<?php
										foreach($author as $author_value)
										{
										?>
										<option value="<?php echo $author_value->id;?>"><?php echo $author_value->name;?></option>
										<?php 
										}
										?>
									</select>
								</div>
							</div>
						</div>
						
						<div class="col-md-4">
							<div class="form-group">
								<label for="inputPassword" class="col-sm-4 col-form-label">Vendor</label>
								<div class="col-sm-8">
									<select class="form-control" id="vendor" name="vendor" required="">				    
										<option value="">Select..</option>  
										<?php
										foreach($vendor as $vendor_value)
										{
										?>
										<option value="<?php echo $vendor_value->id;?>"><?php echo $vendor_value->name;?></option>
										<?php 
										}
										?>
									</select>
								</div>
							</div>
						</div>
						
						<div class="col-md-4">
							<div class="form-group">
								<label for="inputPassword" class="col-sm-4 col-form-label">Library Location</label>
								<div class="col-sm-8">
									<select class="form-control" id="location" name="location" required="">				    
										<option value="">Select..</option> 
										<?php
										foreach($library_location as $library_location_value)
										{
										?>
										<option value="<?php echo $library_location_value->id;?>"><?php echo $library_location_value->name;?></option>
										<?php 
										}
										?> 
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row top">
					<div class="col-md-12">
						<div class="col-md-4">
							<div class="form-group">
								<label for="inputPassword" class="col-sm-4 col-form-label">Almirah No</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="almirah" name="almirah" value="" placeholder="Almirah No" >
								</div>
							</div>
						</div>
						
						<div class="col-md-4">
							<div class="form-group">
								<label for="inputPassword" class="col-sm-4 col-form-label">Rack No</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="rack" name="rack" value="" placeholder="Rack No" >
								</div>
							</div>
						</div>
						
						<div class="col-md-4">
							<div class="form-group">
								<label for="inputPassword" class="col-sm-4 col-form-label">Quantity</label>
								<div class="col-sm-8">
									<input type="number" class="form-control" id="quantity" name="quantity" value="" placeholder="Quantity">
								</div>
							</div>
						</div>
					</div>
				</div>				
			</div>
		</div>
		<div class="box box-primary">
			<div class="box-body"> 
				<div class="row top">
					<div class="col-md-12 table-responsive">
						<table class="table table-bordered">
						<thead>
						  <tr>
							<th>S.No.</th>
							<th>Accession No.</th>
							<th>ISBN No.</th>
							<th>Publish Year</th>
							<th>Edition</th>
							<th>Cost</th>
							<th>Pages</th>
						  </tr>
						</thead>
						<tbody id="append_data">
						  
						</tbody>
					  </table>
					</div>
				</div>			
			</div>
		</div>

		<div class="box box-primary">
			<div class="box-body">
				
				<button type="submit" class="btn btn-success pull-right">SAVE</button>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">
	$("#quantity").change(function()
	{
		$('#append_data').html('');
		var quantity = $('#quantity').val();
		for (i = 1; i <= quantity; i++) 
		{
			$('#append_data').append('<tr><td>'+i+'</td><td><input type="hidden" class="form-control" value="'+i+'" name="ids[]"><input type="text" class="form-control" id="accession_'+i+'" name="accession[]" placeholder="Enter Accession No"></td><td><input type="text" class="form-control" id="isbn_'+i+'" name="isbn[]" placeholder="ISBN No"></td><td><input type="text" class="form-control" id="pub_year_'+i+'" name="pub_year[]" placeholder="Publish Year"></td><td><input type="text" class="form-control" id="edition_'+i+'" name="edition[]" placeholder="Enter Edition"></td><td><input type="number" class="form-control" id="cost_'+i+'" name="cost[]" placeholder="Enter Cost"></td><td><input type="number" class="form-control" id="page_'+i+'" name="page[]" placeholder="Enter Page No"></td></tr>');
		}
	});
	
</script>