<div class="form-group has-feedback">
  <div class="box box-primary">
    <div class="box-body">
    
	<!--<a href='<?php //echo base_url(''); ?>' class='pull-right'>
		<button class="btn btn-add" id="add_record" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Add Item">
			<i class="fa fa-plus-circle fa-lg"></i>&nbsp; 
		</button>
	</a>--><br /><br />
	
        <div class="table-responsive">
        <table class="table table-bordered table-striped" id="period">
          <thead style="background:#99ceff;">
            <tr>
             <th>Sl No.</th>
		     <th>title</th>
		     <th>ISBN</th>
		     <th>Admission No</th>
		     <th>Issued By</th>
		     <th>Lib Card NO.</th>
                     <th>Days limit</th>
		     <th>issued Date</th>
		     <th>Return Date</th>
		     <th>Status</th>
		     <th>Returned Date</th>
		     <th>Late Fine</th>
            </tr>
          </thead>
          
		    <input type="hidden" id='late_fine' value='<?php echo $late_fine[0]->late_fine ?>'>
		            
          <tbody>
		  <?php
		    $i = 1;
			if($issued_books){
		    foreach($issued_books as $data){
		  ?>
		   <tr>
		     <td><?php echo $i; ?></td>
		     <td><?php echo $data->title; ?></td>
		     <td><?php echo $data->isbn; ?></td>
		     <td><?php echo $data->adm_no; ?></td>
		     <td><?php echo $data->first_name; ?></td>
		     <td><?php echo $data->lib_card_no; ?></td>
			 <?php
			   $dt = $data->date_created;
			   $dtt = explode(" ",$dt);
			   $dc = $dtt[0];
			 ?>
			 <td><?php echo $data->days_allow; ?></td>
		     <td><button class='btn btn-danger btn-xs'><?php echo $dc; ?></button></td>
			 <td><button class='btn btn-success btn-xs'><?php echo date('Y-m-d', strtotime($dc. ' + '.$data->days_allow.' days')); ?></button></td>
			 
			 
		     <td>
			 <?php
			   if($data->book_status != 'Returned'){
			 ?>
			   <button class='btn btn-danger btn-xs' onclick="book_return('<?php echo $data->book_code; ?>',<?php echo $data->issued_qty; ?>,<?php echo $data->id; ?>,'<?php echo date('Y-m-d', strtotime($dc. ' + '.$data->days_allow.' days')); ?>')">Confirm Return</button>
			   <?php }else{
			   ?>
			   <button class='btn btn-success btn-xs'>Returned</button>
			   <?php
			   } ?>
			 </td>
			  <td>
			  <?php
			    if($data->return_date != ''){
			  ?>
			    <button class='btn btn-success btn-xs'><?php echo $data->return_date; ?></button>
				<?php } ?>
			  </td>
			  <?php
			    if($data->late_fine != ''){
					if($data->late_fine != 0){
			  ?>
			  <td><button class='btn btn-danger btn-xs'><?php echo $data->late_fine; ?> Rs.</button></td>
					<?php } else{
						?>
						<td><button class='btn btn-success btn-xs'><?php echo $data->late_fine; ?> Rs.</button></td>
						<?php
					} ?>
				<?php } ?>
		   </tr>
			<?php $i++; } } ?>
          </tbody>
        </table>
        </div>
		
		<!-- Modal -->
		<div id="Bookissuing" class="modal fade" role="dialog">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">ISSUING BOOK</h3>
				<div class='row'>
				  <div class='col-sm-4'><b>Title</b></div>
				  <div class='col-sm-4' style="text-align:center;"><b>Available Qty</b></div>
				  <div class='col-sm-4' style="text-align:right;"><b>Class</b></div>
				</div>
				<div class='row'>
				  <div class='col-sm-4'><button class='btn btn-danger btn-xs'><div id='title'></div></button></div>
				  <div class='col-sm-4' style="text-align:center;"><button class='btn btn-warning' title="Available Qty"><div id='qty'></div></button></div>
				  <div class='col-sm-4' style="text-align:right;"><button class='btn btn-danger btn-xs'><div id='class'></div></button></div>
				</div>
			  </div>
			  <div class="modal-body">
				 <table class='table table-dark'>
				 <input type="hidden" id="book_code">
				   <tr>
					 <th>Adm No.</th>
					 <td colspan='3'>
					   <select class='table' id="adm_no" onchange="adm_det(this.value)" readonly required>
					     <option value="">Select</option>
						 <?php
						   foreach($library as $dt){
						 ?>
					     <option value="<?php echo $dt->adm_no; ?>"><?php echo $dt->adm_no; ?></option>
						 <?php } ?>
					   </select>
					 </td>
				   </tr>
				   
				   <tr>
				     <th>Lib card No.</th>
				     <td colspan='3'><input type='text' id="lib_card_no" class='form-control' readonly></td>
				   </tr>
				   
				   <tr>
				     <th>Student Name</th>
				     <td><input type='text' id="first_name" class='form-control' readonly></td>
				     <td><input type='text' id="middle_name" class='form-control' readonly></td>
				     <td><input type='text' id="last_name" class='form-control' readonly></td>
				   </tr>
				   
				   <tr>
				     <th>Class/Sec/Roll</th>
				     <td><input type='text' id="classs" class='form-control' readonly></td>
				     <td><input type='text' id="sec" class='form-control' readonly></td>
				     <td><input type='text' id="roll" class='form-control' readonly></td>
				   </tr>
				   
				   <tr>
				     <th>No. of allowed Books</th>
				     <td><input type='text' id="no_book" class='form-control' readonly></td>
					 <th>No. of Issued Books</th>
				     <td><input type='text' id="issued_book" value='1' class='form-control' readonly></td>
				   </tr>
				   
				   <tr>
				     <th>allowed Days</th>
				     <td colspan='3'><input type='text' id="days_allow" class='form-control' readonly></td>
				   </tr>
				   
				   <tr>
				     <th>Card Expiry</th>
				     <td colspan='3'><input type='text' id="card_exp" class='form-control' readonly></td>
				   </tr>
				 </table>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-success" onclick='book_issue_save()'>Issue</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			  </div>
			</div>
		  </div>
		</div>
		<!-- End Modal -->
		
		
       <!--view Modal-->
        <div id="ViewModal" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title" id="modal-title">View</h3>
              </div>
                  
              <div class="modal-body">
                <div id='view_grn'></div>
              </div>
			  
              <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
      <!-- End View Modal-->
	  
	  
	  <!--view Modal-->
        <div id="editModal" class="modal fade" role="dialog">
          <div class="modal-dialog modal-xs ">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title" id="modal-title">Edit</h3>
              </div>    
              <div class="modal-body">
                <div id='edit_grn'></div>
              </div>
			  
              <div class="modal-footer">
                <button type="button" class="btn btn-success btn-xs" data-dismiss="modal" onclick="update()">Update</button>
                <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
      <!-- End View Modal-->
	  
  </div>
</div>

<script>
$(function (){
    var table=$('#period').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true
    });
    $('#searchhead th input').on('keyup change', function () {
            var i = $(this).attr('data-column');
            var v = $(this).val();
            table.columns(i).search(v).draw();
    });
});


function book_issue(id){
	$.post('<?php echo base_url('library/Books/issue'); ?>',{id:id},function(data){
		var dt = $.parseJSON(data);
		$("#book_code").val(dt[0]);
		$("#title").text(dt[1]);
		$("#class").text(dt[2]);
		$("#qty").text(dt[3]);
		$("#Bookissuing").modal('show');
	});
}

function adm_det(adm_no){
$.post('<?php echo base_url('library/Books/fetch_lib_det'); ?>',{adm_no:adm_no},function(data){
	var data = $.parseJSON(data);
	$("#lib_card_no").val(data[0]);
	$("#first_name").val(data[1]);
	$("#middle_name").val(data[2]);
	$("#last_name").val(data[3]);
	$("#classs").val(data[4]);
	$("#sec").val(data[5]);
	$("#roll").val(data[6]);
	$("#no_book").val(data[7]);
	$("#days_allow").val(data[8]);
	$("#card_exp").val(data[9]);
});
}

function book_issue_save(){
	var adm_no = $("#adm_no").val();
	var lib_card_no = $("#lib_card_no").val();
	var first_name = $("#first_name").val();
	var middle_name = $("#middle_name").val();
	var last_name = $("#last_name").val();
	var classs = $("#classs").val();
	var sec = $("#sec").val();
	var roll = $("#roll").val();
	var no_book = $("#no_book").val();
	var issued_book = $("#issued_book").val();
	var days_allow = $("#days_allow").val();
	var card_exp = $("#card_exp").val();
	var book_code = $("#book_code").val();
	
	if(adm_no == ''){
		alert('Select Admission No.');
	}else{
		$.post('<?php echo base_url('library/Books/book_issue_save'); ?>',{adm_no:adm_no,lib_card_no:lib_card_no,first_name:first_name,middle_name:middle_name,last_name:last_name,classs:classs,sec:sec,roll:roll,no_book:no_book,issued_book:issued_book,days_allow:days_allow,card_exp:card_exp,book_code:book_code},function(data){
			alert('Issued Successfully');
			location.reload();
		});
	}
}

function book_return(book_code,issued_qty,id,ret_date){
	    var late_fine = $("#late_fine").val();
		var current_date = new Date();
		var return_date = new Date(ret_date);
		var diff = new Date(current_date - return_date);
		var days = diff/1000/60/60/24;
		var tot_days  = Math.round(days);
		
		var tot_late_fine = late_fine * tot_days;
		if(tot_late_fine < 0){
			tot_late_fine = 0;
		}
		alert('Your Total late fine '+tot_late_fine +' Rs.');
		var cnf = confirm('Are You Sure Want To Pay Amount And Return Book');
	    if(cnf == true){
		
	    $.post('<?php echo base_url('library/Issued_books/return_book'); ?>',{book_code:book_code,issued_qty:issued_qty,id:id,tot_late_fine:tot_late_fine},function(data){
		alert('Book Returned');
		location.reload();
	    });	
	 }
}
</script>