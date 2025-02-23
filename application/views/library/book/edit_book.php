<div class="form-group has-feedback">
	<div class="box-body">  
		<?php
		if($this->session->flashdata('successmsg'))
		{
		?>
			<div class="alert alert-warning alert-dismissible" id="suc_msg" style="width: 20%;height: 33px;padding: 5px 5px 5px 5px;position: absolute;">
				<a href="#" class="close" data-dismiss="alert"></a>
				<i class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $this->session->flashdata('successmsg'); ?>
			</div>

			<script type="text/javascript">
				$("#suc_msg").fadeTo(2000, 500).slideUp(500, function(){
				    $("#suc_msg").slideUp(500);
				});
			</script>
		<?php 
		} 
		?>
    	<a  class="btn btn-success pull-right" href="<?php echo base_url('library/book/book_list');?>">Back</a>
    </div>
	<form id="book_add" action="<?php echo base_url('library/book/add_book/update_data');?>" method="post">
		<div class="box box-primary">
			<div class="box-body">    
				<div class='row'>
					<div class='col-sm-3'></div>
					<div class='col-sm-6'>
						<input type="hidden" class="form-control" name="book_id" value="<?php echo $book[0]->id;?>">
						<!--  <input type="hidden" class="form-control" id="action" value=""> -->
						
					</div>
				</div>  				
				<div class="row top">
					<div class="col-md-12">
						<div class="col-md-4">
							<div class="form-group">
								<label for="inputPassword" class="col-sm-4 col-form-label">Category</label>
								<div class="col-sm-8">
									<select class="form-control" id="category" name="category">	
    									<option value="">Select..</option>  
										<?php
										foreach($category as $cat_value)
										{
											$ctid=$cat_value->id;
											$book_cat_id=$book[0]->book_category_id;
                                        ?>
											<option value="<?php echo $ctid;?>" <?php if($book_cat_id==$ctid){echo 'selected';}else{}?>>
												<?php echo $cat_value->category_name;?>
											</option>
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
									<input type="text" class="form-control" id="name" name="name" value="<?php echo $book[0]->name;?>" placeholder="Name" >
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
											$pubid=$pub_value->id;
											$book_publisher_id=$book[0]->book_publisher_id;                                       
										?>
											<option value="<?php echo $pubid;?>" <?php if($book_publisher_id==$pubid){echo 'selected';}else{}?>>
												<?php echo $pub_value->name;?>
											</option>
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
											$book_author_id=$book[0]->book_author_id;
											$aid=$author_value->id;
										?>
											<option value="<?php echo $aid;?>" <?php if($book_author_id==$aid){echo 'selected';}else{}?>>
												<?php echo $author_value->name;?>
											</option>
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
									<select class="form-control" id="vendor" name="vendor" >				    
										<option value="">Select..</option>  
										<?php
										foreach($vendor as $vendor_value)
										{
											$veid=$vendor_value->id;
											$book_vendor_id=$book[0]->book_vendor_id;
										?>
											<option value="<?php echo $veid;?>" <?php if($veid==$book_vendor_id){echo 'selected';}else{}?>>
												<?php echo $vendor_value->name;?>
											</option>
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
									<select class="form-control" id="location" name="location" >				    
										<option value="">Select..</option> 
										<?php
										foreach($library_location as $library_location_value)
										{
											$library_location_id=$book[0]->library_location_id;
											$lid=$library_location_value->id;
										?>
											<option value="<?php echo $lid;?>" <?php if($library_location_id==$lid){echo 'selected';}else{}?>>
												<?php echo $library_location_value->name;?>
											</option>
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
									<input type="text" class="form-control" id="almirah" name="almirah" value="<?php echo $book[0]->almirah_no;?>" placeholder="Almirah No" >
								</div>
							</div>
						</div>
						
						<div class="col-md-4">
							<div class="form-group">
								<label for="inputPassword" class="col-sm-4 col-form-label">Rack No</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="rack" name="rack" value="<?php echo $book[0]->rack_no;?>" placeholder="Rack No" >
								</div>
							</div>
						</div>
						
						<div class="col-md-4">
							<div class="form-group">
								<label for="inputPassword" class="col-sm-4 col-form-label">Quantity</label>
								<div class="col-sm-8">
									<input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo $book[0]->quantity;?>" placeholder="Quantity">
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
							<th>Action</th>
						  </tr>
						</thead>
						<form method="post" action="<?php echo base_url('library/book/add_book/update_data'); ?>">
						<tbody id="append_data">
							<?php 
								$x=1;
								foreach ($book_detail as $key => $book_value) 
								{
							?>
						  	<tr>
						  		<td><?php echo $x;?>.</td>
						  		<td>
						  			<input type="hidden" class="form-control" value="<?php echo $x;?>" name="ids[]">
						  			<input type="text" class="form-control" id="accession_<?php echo $x;?>" name="accession[]" placeholder="Enter Accession No" value="<?php echo $book_value->acc_no;?>">
						  		</td>
						  		<td>
						  			<input type="text" class="form-control" id="isbn_<?php echo $x;?>" name="isbn[]" placeholder="ISBN No" value="<?php echo $book_value->isbn_no;?>">
						  		</td>
						  		<td>
						  			<input type="text" class="form-control" id="pub_year_<?php echo $x;?>" name="pub_year[]" placeholder="Publish Year" value="<?php echo $book_value->publish_year;?>">
						  		</td>
						  		<td>
						  			<input type="text" class="form-control" id="edition_<?php echo $x;?>" name="edition[]" placeholder="Enter Edition" value="<?php echo $book_value->edition;?>">
						  		</td>
						  		<td>
						  			<input type="number" class="form-control" id="cost_<?php echo $x;?>" name="cost[]" placeholder="Enter Cost" value="<?php echo $book_value->cost;?>">
						  		</td>
						  		<td>
						  			<input type="number" class="form-control" id="page_<?php echo $x;?>" name="page[]" placeholder="Enter Page No" value="<?php echo $book_value->page_no;?>">
						  		</td>
						  		<td>
						  			<a href="#"><i class="fa fa-window-close fa-2x" aria-hidden="true"></i></a>
						  		</td>
						  	</tr>
						  	<?php
						  		$x++;}
						  	?>
						</tbody>
					</form>
					  </table>
					</div>
				</div>			
			</div>
		</div>

		<div class="box box-primary">
			<div class="box-body">
				<button type="submit" class="btn btn-success pull-right">UPDATE</button>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">
	/*$("#quantity").change(function()
	{
		$('#append_data').html('');
		var quantity = $('#quantity').val();
		for (i = 1; i <= quantity; i++) 
		{
			$('#append_data').append('<tr><td>'+i+'</td><td><input type="hidden" class="form-control" value="'+i+'" name="ids[]"><input type="text" class="form-control" id="accession_'+i+'" name="accession[]" placeholder="Enter Accession No"></td><td><input type="text" class="form-control" id="isbn_'+i+'" name="isbn[]" placeholder="ISBN No"></td><td><input type="text" class="form-control" id="pub_year_'+i+'" name="pub_year[]" placeholder="Publish Year"></td><td><input type="text" class="form-control" id="edition_'+i+'" name="edition[]" placeholder="Enter Edition"></td><td><input type="number" class="form-control" id="cost_'+i+'" name="cost[]" placeholder="Enter Cost"></td><td><input type="number" class="form-control" id="page_'+i+'" name="page[]" placeholder="Enter Page No"></td></tr>');
		}
	});*/
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
            url: "<?php echo base_url('library/book/add_book/update_data'); ?>",
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