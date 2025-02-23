<style type="text/css">
	.RETURN{
		background: #000!important;
		color: #fff;
	}
    .LATE{
        background: #ccc!important;
    }
</style>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<div class="form-group has-feedback">
	<div class="box box-primary">
		<div class="box-body">    
			<div class='row'>
				<div class='col-sm-3'></div>
				<div class='col-sm-6'>					
				</div>
			</div> 
		    <div class="row top">
				<div class="col-md-12">
					<div class="col-md-4">
						<div class="form-group">
							<label for="inputPassword" class="col-sm-4 col-form-label">Employee Code.</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="nos" name="nos" value="" placeholder="Enter Employee Code" required="" onchange="submits()">
							</div>
						</div>
					</div>
				</div>
			</div>
			<hr/>
			<input type="hidden" id="stu_id" name="stu_id" value="">
		    <div class="row top" id="detail" style="display: none;">
				<div class="col-md-12">
					<div class="col-md-3">
						<div class="form-group">
							<label for="inputPassword" class="col-sm-4 col-form-label">NAME :</label>
							<div class="col-sm-8">
								<span id="name"></span>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="inputPassword" class="col-sm-4 col-form-label">CLASS :</label>
							<div class="col-sm-8">
								<span id="class"></span>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="inputPassword" class="col-sm-5 col-form-label">SECTION :</label>
							<div class="col-sm-5">
								<span id="section"></span>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="inputPassword" class="col-sm-7 col-form-label">ADMISSION N0. :</label>
							<div class="col-sm-5">
								<span id="adm"></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="box box-primary" id="book_status" style="display: none;">
		<div class="box-body">    

			<div class="row col-md-12">
				<a class="btn btn-danger" onclick="getdata('A')"><span><i class="fa fa-book"></i>&nbsp;&nbsp;&nbsp;ALL</span></a>	
                <a style="color:#fff;background: #000!important;" class="btn btn-primary" onclick="getdata('R')"><span><i class="fa fa-book"></i>&nbsp;&nbsp;&nbsp;RETURNED</span></a>   
                <a style="border:1px solid #000;color:#000;background: #fff!important;" class="btn btn-success" onclick="getdata('I')"><span><i class="fa fa-book"></i>&nbsp;&nbsp;&nbsp;ISSUED</span></a>    
                <a style="background: #ccc!important;" class="btn btn-danger" onclick="getdata('L')"><span><i class="fa fa-book"></i>&nbsp;&nbsp;&nbsp;LATE RETURNED</span></a>    
                <a class="btn btn-success pull-right" onclick="issue()"><span><i class="fa fa-book"></i>&nbsp;&nbsp;&nbsp;NEW ISSUE</span></a>  			
			</div>
			<div class="row col-md-12">
				<hr>
			</div>
			<br>
			<div class="row top">
				<div class="col-md-12">					
					<div class="table-responsive" id="book_det">
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="issue_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">NEW BOOK ISSUE</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div class="row">
        	<div class="col-md-12">
        		<div class="col-md-1">
        		</div>
        		<div class="col-md-10">
					<div class="form-group">
						<label for="inputPassword" class="col-sm-4 col-form-label">Document/Book Accession No.</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="dbi" name="dbi" value="" placeholder="Enter Document/Book ID" required="" onchange="submits_book()">
						</div>
					</div>
				</div>
        	</div>
        </div>
        <br>
        <div class="row">
        	<div class="col-md-12">
        		<div class="table-responsive" id="book_issue_detail">
					<table class="table table-striped table-dark" id="book_details">
						<thead>
							<tr>
								<th scope="col">Accession No</th>
								<th scope="col">Document/Book Name</th>
								<th scope="col">Publisher</th>
								<th scope="col">Almirah No</th>
								<th scope="col">Rack No</th>									
								<th scope="col">Action</th>
							</tr>
						</thead>
						<tbody>
						    
						   
					  	</tbody>
					</table>
				</div>
        	</div>
        </div>
        <br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a class="btn btn-primary" onclick="issue_final()">Issue</a>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="return_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="width:750px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">RETURN BOOK/DOCUMENT</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-1">
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <!-- <label for="inputPassword" class="col-sm-4 col-form-label">Document/Book Accession No.</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="dbi" name="dbi" value="" placeholder="Enter Document/Book ID" required="" onchange="submits_book()">
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive" id="book_issue_detail">
                    <table class="table table-striped table-dark" id="book_details">
                        <thead>
                            <tr>
                                <th scope="col">Accession No</th>
                                <th scope="col">Document/Book Name</th>
                                <th scope="col">Publisher</th>
                                <th scope="col">Issue Date</th>
                                <th scope="col">Submission Date</th>
                                <th scope="col">Almirah No</th>
                                <th scope="col">Rack No</th>                                    
                                <th scope="col">Fine (&#8377;)</th>    
                            </tr>
                        </thead>
                        <tbody id="return_book_data">
                            
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a class="btn btn-primary" onclick="return_final()">Return</a>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    function getdata(m)
    {
        var stu_id = $('#stu_id').val();
        var gets = m;
        $.ajax({
            url : "<?php echo base_url('library/issue_return/staff/getdata');?>",
            type: "POST",
            data: {stu_id:stu_id,gets:gets},
            dataType: 'json',
            success: function (data)
            {
                $('#book_det').html('');
                $('#book_det').html(data.datas);
                $('#detail').show();
                $('#book_status').show();
                $('#book_detail').DataTable({ 
                      "destroy": true, 
                   });
            },
        });  
    }

	function return_final()
	{
		var stu_id = $('#stu_id').val();
		var br_id  = $('#book_return_id').val();
		$.ajax({
            url : "<?php echo base_url('library/issue_return/staff/return_book_final');?>",
            type: "POST",
            data: {br_id:br_id,stu_id:stu_id},
            dataType: 'json',
            success: function (data)
            {
               console.log(data);
               $('#book_det').html('');
               $('#book_det').html(data.datas);
               swal("RETURNED!", "Successfully Returned Book!", "success");
               $('#return_modal').modal('hide');
                $('#book_detail').DataTable({ 
                      "destroy": true, 
                   });
            },
        });
	}

	function return_book(id)
	{
		$.ajax({
            url : "<?php echo base_url('library/issue_return/staff/return_book');?>",
            type: "POST",
            data: {id:id},
            success: function (data)
            {
                $('#return_book_data').html('');
                $('#return_book_data').html(data);
                $('#return_modal').modal('show');
                 $('#book_detail').DataTable({ 
                      "destroy": true, 
                   });
            },
        });
	}

	function issue_final()
	{
		var stu_id = $('#stu_id').val();
		$.ajax({
            url : "<?php echo base_url('library/issue_return/staff/final_issue');?>",
            type: "POST",
            data: {stu_id:stu_id},
            dataType: 'json',
            success: function (data)
            {
            	swal("ISSUED!", "Successfully Issued Book!", "success");
            	$('#book_det').html('');
            	$('#book_det').html(data.datas);
            	$('#issue_modal').modal('hide');
                 $('#book_detail').DataTable({ 
                      "destroy": true, 
                   });
            },
        });
	}
	function issue()
	{
		$('#issue_modal').modal('show');
		$('#dbi').focus();
	}

	$( document ).ready(function() {
		
	    $("#nos").focus();
	    $('#book_detail').DataTable();
	});

	function submits()
	{
		var adm_no = $('#nos').val();
		$.ajax({
            url : "<?php echo base_url('library/issue_return/staff/get_detail');?>",
            type: "POST",
            data: {adm_no:adm_no},
            dataType: 'json',
            success: function (data)
            {
            	$('#book_det').html('');
            	$('#book_det').html(data.datas);
            	$('#detail').show();
            	$('#book_status').show();
            	$('#stu_id').val('');
            	$('#stu_id').val(data.ids);

            	$('#name').text('');
            	$('#name').text(data.name);
            	$('#class').text('');
            	$('#class').text(data.class);
            	$('#section').text('');
            	$('#section').text(data.section);
            	$('#adm').text('');
            	$('#adm').text(data.admission_no);
                $('#book_detail').DataTable({ 
                      "destroy": true, 
                   });
            },
        });  
	}

	function submits_book()
	{
		var book_no = $('#dbi').val();
		var stu_id = $('#stu_id').val();
		$.ajax({
            url : "<?php echo base_url('library/issue_return/staff/get_book');?>",
            type: "POST",
            data: {book_no:book_no,stu_id:stu_id},
            success: function (data)
            {
            	$('#book_issue_detail').html('');
            	$('#book_issue_detail').html(data);
                 $('#book_detail').DataTable({ 
                      "destroy": true, 
                   });
            },
        });  
	}
	
	function remove(id)
	{
		var stu_id = $('#stu_id').val();
		var r = confirm("Are You Sure!");
		if (r == true) {
		$.ajax({
            url : "<?php echo base_url('library/issue_return/staff/delete_get_book');?>",
            type: "POST",
            data: {id:id,stu_id:stu_id},
            success: function (data)
            {
            	$('#book_issue_detail').html('');
            	$('#book_issue_detail').html(data);
                 $('#book_detail').DataTable({ 
                      "destroy": true, 
                   });
            },
        });
        }
        else{}  
	}
</script>