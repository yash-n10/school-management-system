<div class="form-group has-feedback">
  <div class="box box-primary">
    <div class="box-body">
    
	<div class="col-lg-12">
             <div class="col-lg-12" style="text-align:right;">
              <?php if(substr($right_access,0,1)=='C'){?>
            
             <!-- <button  class="btn btn-add" id="add_employee" title="Add Employee"> <i class="fa fa-plus-circle fa-lg"></i> </button>-->
				<a class="btn btn-add" id="add_record" href='<?php echo base_url('library/Books/add'); ?>' class='pull-right'>
					<i class="fa fa-plus-circle fa-lg"></i>&nbsp; 
				</a>
            
              <?php }?>
                <a class="btn btn-export" id="studexport" href='<?= base_url() . uri_string() ?>/exportcsv/All/All' download data-toggle="tooltip" data-placement="bottom" title="Export Book">
                        <i class="fa fa-cloud-download fa-lg"></i>&nbsp;
                </a>

              <?php
                //if (!$read_only) {
                if(substr($right_access, 0,1)=='C' || substr($right_access, 2,1)=='U') {
                ?>
                <a class="btn btn-import" id="studimport" href='<?= base_url() . uri_string() ?>/importcsv'  data-toggle="tooltip" data-placement="bottom" title="Import Books">
                        <i class="fa fa-cloud-upload fa-lg"></i>&nbsp;
                </a>
              <?php
				}
				?>
              </div>
              </div>
	</div>

        <div class="table-responsive">
        <table class="table table-bordered table-striped" id="period">
          <thead style="background:#99ceff;">
            <tr>
             <th>Sl No.</th>
		     <th>title</th>
		     <th>Subtitle</th>
		     <th>Edition</th>
		     <th>Author</th>
		     <th>Publisher</th>
		     <th>Available Qty</th>
		     <th>Issue</th>
		     <th>Action</th>
            </tr>
          </thead>
          
          
          <tbody>
		  <?php
		    $i = 1;
		    foreach($books as $data){
		  ?>
		   <tr>
		     <td><?php echo $i; ?></td>
		     <td><?php echo $data->title; ?></td>
		     <td><?php echo $data->subtitle; ?></td>
		     <td><?php echo $data->edition; ?></td>
		     <td><?php echo $data->author; ?></td>
		     <td><?php echo $data->publisher; ?></td>
		     <td><?php echo $data->rest_qty; ?></td>
		     <td>
			    <?php
				  if($data->rest_qty != 0){
				?>
			   <span class='btn btn-success btn-xs' onclick="book_issue(<?php echo $data->id; ?>)"><i class="fa fa-book" title="MAKE BOOK ISSUE"></i></span>
				  <?php }else {
					  ?>
			   <span class='btn btn-danger btn-xs'><i class="fa fa-book"></i></span>
		            
					  <?php
				  }?>

			 </td>
		     <td>
			   <a href="<?php echo base_url('library/Books/edit/'.$data->id); ?>" class="btn a-edit" title="Edit"><i class="fa fa-edit"></i></a>
			 </td>
		   </tr>
			<?php $i++; } ?>
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
				     <td>
					 <input type='hidden' id="issued_book" value='1' class='form-control'>
					 <input type='text' id="tot_iss_qty" class='form-control' readonly>
					 </td>
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
				<button type="button" class="btn btn-success" onclick='book_issue_save()' id='issue'>Issue</button>
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
	$("#tot_iss_qty").val(data[10]);
	
	var tot_iss_qty = data[10];
	var no_of_allowed_book = data[7];
	var d = new Date();
    var month = d.getMonth()+1;
    var day = d.getDate();
    var output = d.getFullYear() + '-' +
    (month<10 ? '0' : '') + month + '-' +
    (day<10 ? '0' : '') + day;
	var dt = new Date(output);
	var exp_date = data[9];
	var dt1 = new Date(exp_date);
	 
	if(tot_iss_qty == no_of_allowed_book ){
		$('#issue').attr('disabled',true);
		$("#no_book").css('border-color','red');
		$("#tot_iss_qty").css('border-color','red');
		$('#issue').text('Expired');
		$('#issue').css('background-color','#d73925');
		$('#issue').css('border-color','#d73925');
		$("#card_exp").css('border-color','#ddd');
	} else if( dt1 <= dt){
		$('#issue').attr('disabled',true);
		$("#card_exp").css('border-color','red');
		$("#no_book").css('border-color','#ddd');
		$("#tot_iss_qty").css('border-color','#ddd');
		$('#issue').text('Expired');
		$('#issue').css('background-color','#d73925');
		$('#issue').css('border-color','#d73925');
	}	else{
		$('#issue').attr('disabled',false);
		$("#no_book").css('border-color','#ddd');
		$("#card_exp").css('border-color','#ddd');
		$("#tot_iss_qty").css('border-color','#ddd');
		$('#issue').text('Issue');
		$('#issue').css('background-color','#008d4c');
		$('#issue').css('border-color','#008d4c');
	}
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
</script>