
<div class="form-group has-feedback">
<!-- <div class="col-md-12" >
		   
		</div> -->
    <div class="box box-primary">
    	<div class="box-body">  
    	<a  class="btn btn-success pull-right" href="<?php echo base_url('library/book/add_book');?>">Add Book</a>
    	 <a class="btn btn-import" id="studimport" href='<?php echo base_url('library/book/Book_list/importcsv');?>'  data-toggle="tooltip" data-placement="bottom" title="Import Books"><i class="fa fa-cloud-upload fa-lg"></i>&nbsp;</a>
    </div>

		<div class="box-body">    
			<div class="table-responsive" id="data_tab">
				<table class="table table-bordered table-striped" id="book_list">
					<thead style="background:#99ceff;">
					  <tr>
					    <th>Accession No.</th>
					    <th>Type</th>
					    <th>Category</th>
					    <th>Name</th>
					    <th>Almirah No</th>
					    <th>Rack No</th>
					    <th>Created At</th>
					    <th>Action</th>
					  </tr>
					</thead>
					<tbody>
						<?php 
						$i = 1;
						foreach($book as $value){?>
							<tr>
								<td><?php echo $value->id;?></td>
								<td><?php echo $value->type_name;?></td>
								<td><?php echo $value->category_name;?></td>
								<td><?php echo $value->name;?></td>
								<td><?php echo $value->almirah_no;?></td>
								<td><?php echo $value->rack_no;?></td>
								<td><?php echo date('d-m-Y',strtotime($value->date_created));?></td>
								<td><a href="#"><i class="fa fa-eye" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url('library/book/add_book/edit_book');?>/<?php echo $value->id;?>"style="cursor: pointer;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;<a style="cursor: pointer;" onclick="deletes(<?php echo $value->id;?>)"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
							</tr>
						<?php $i++;}?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>		
<script type="text/javascript">
	$(document).ready(function() {
	  $('#book_list').DataTable();
	});

	function deletes(id)
	{
		var r = confirm("Are You Sure!");
		if (r == true) {
		  
		$.ajax({
            url: "<?php echo base_url('library/book/book_list/delete'); ?>",
            type: "POST",
            data: {id:id},
            success: function (data)
            {
            	$('#data_tab').html('');
            	$('#data_tab').html(data);
				
            },
        }); 
        } else {
		}  
	}
	// function update(id)
	// {
 //     $('#butt').hide();
 //     $('#butt1').show();
 //     $.ajax({
 //            url: "<?php echo base_url('library/master/book_cat/update'); ?>",
 //            type: "POST",
 //            data: {id:id},
 //            dataType:"json",
 //            success: function (data)
 //            {
 //             $('#type').html(data.typess);
 //              $('#hid').val(data.hid);
	// 		  $('#category').val(data.cat);
	// 		  $('#book_std').val(data.book_std);
 //             $('#book_staff').val(data.book_staff);
	// 		 $('#day_std').val(data.day_std);
	// 		 $('#day_staff').val(data.day_staff);
	// 		 $('#fine_staff').val(data.fine_staff);
	// 		 $('#fine_std').val(data.fine_std);
 //            },
 //        });
	// }
</script>