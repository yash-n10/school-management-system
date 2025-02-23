<div class="form-group has-feedback">
	<div class="box">
		<div class="box-body">

	              <form id='frmdetails' role="form" method="POST">
				<div class="table-responsive">
					<table id="itemdetailslist" class="table table-bordered table-striped dTable">
						<thead style="background:#99ceff;">
							<tr>
								<th style="border-bottom:0px; width:6%;">Bill Id</th>
								<th style="border-bottom:0px; width:7%;">Bill Date</th>
								<th style="border-bottom:0px; width:7%;">Admission No.</th>
								<th style="border-bottom:0px; width:15%;">Student Name</th>
								<th style="border-bottom:0px; width:9%;">Approver1</th>
								<th style="border-bottom:0px; width:9%;">Approver2</th>
								<th style="border-bottom:0px; width:9%;">Approver3</th>
								<th style="border-bottom:0px; width:11%;">Status</th>
								<th style="border-bottom:0px; width:19%;">Comments</th>
								<th style="border-bottom:0px; width:10%;">Action</th>
							</tr>
						</thead>

						<thead style="background: #cce6ff;">
							<tr id="searchhead">
								<th style="border-bottom:2px solid darkcyan;border-top:0px"><i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i>
									<input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="1"/>
								</th>
								<th style="border-bottom:2px solid darkcyan;border-top:0px"><i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i>
									<input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="2"/>
								</th>
								<th style="border-bottom:2px solid darkcyan;border-top:0px"><i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i>
									<input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="3"/>
								</th>
								<th style="border-bottom:2px solid darkcyan;border-top:0px"><i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i>
									<input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="4"/>
								</th>
								<th style="border-bottom:2px solid darkcyan;border-top:0px"><i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i>
									<input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="5"/>
								</th>
								<th style="border-bottom:2px solid darkcyan;border-top:0px">
									<i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="6"/>
								</th>
								<th style="border-bottom:2px solid darkcyan;border-top:0px"><i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i>
									<input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="7"/>
								</th>
								<th style="border-bottom:2px solid darkcyan;border-top:0px"><i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i>
									<input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="8"/>
								</th>
								<th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
							</tr>
						</thead>

						<tbody style="font-size:12px;">
							<?php 
							if(isset($store_bill_hdr) && count($store_bill_hdr) > 0) {
								foreach ($store_bill_hdr as $arritem) { 
							?>
								<tr>
									<td><?php echo $arritem->id; ?></td> 
									<td><?php echo $arritem->bill_date; ?></td>                                         
									<td><?php echo $arritem->admission_no; ?></td>                                         
									<td><?php echo $arritem->student_fname + '  ' + $arritem->student_fname; ?></td>                                         
									<td><?php echo $arritem->approve1_comment; ?></td>    
									<td><?php echo $arritem->approve2_comment; ?></td>    
									<td><?php echo $arritem->approve3_comment; ?></td>    
									<td><?php echo $arritem->final_status; ?></td>                                         
									<td><?php echo $arritem->final_comment; ?></td>                                         
									<td>
										<?php
										if (substr($right_access,2,1)=='U') {?>
										<a id="AAA" class="btn a-edit"  style="color:orange;" href="<?php echo base_url();?>store/Billapprove/update_load/<?php echo $arritem->id; ?>">
											<i class="fa fa-check-square-o"></i></a>
										<?php } ?>                     
										<!-- <?php
										if (substr($right_access,2,1)=='U') {?>
										<a class="btn a-edit" data-toggle="modal" data-target="#div_bills" style="color:red" id="<?php echo $arritem->id; ?>">
											<i class="fa fa-plus-square-o"></i></a>
										<?php } ?>    -->                  
									</td>                         
								</tr>
								<?php }
							}
							?>
						</tbody>

						<tfoot>
						</tfoot>
					</table>
				</div>	
			</form>
		</div>
       </div>
</div>



<!--    **    BOOTSTRAP MODEL for UPDATE    **     -->

<div class="modal fade" id="div_bills" role="dialog">
	<div class="modal-dialog modal-lg">
	
       <!--  MODAL  CONTENT  -->
		<div class="modal-content">
			<form action="<?php echo base_url('store/billapprove/approve'); ?>" method="post" id="manage_approval" name="manage_approve"  class="form-horizontal">
		
				<div class="modal-header" id="modal_header" style="background:lightblue">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><strong>&times;</strong></span></button>
					<h3 class="modal-title">Approve Bill</h3>
					<input type="hidden" name="approve_bill" id="approve_bill" value="">
				</div>
		
				<div class="modal-body" id="modal-body">
<!--				<form action="#bill_add" id="manage_approve" class="form-horizontal">  -->
					<div class="form-body">
						<div class="form-group">
							<div class="col-md-3"></div>
							<div class="col-md-9" id="errmodal"></div>
						</div>

<!-- 					<?php if ($this->session->userdata('login_type') == 'admin' || $this->session->userdata('login_type') == 'principal' || $this->session->userdata('login_type') == 'hr') { ?>
-->
						<div id="div_itemid"></div>
								
						<div class="form-group" >
							<label class="control-label col-md-2 req">Admission No. :</label>
							<div class="col-md-3">
								<select class="form-control" name="admission_no" id="admission_no" readonly>
									<option value="">Select Admission No.</option>
										<?php foreach ($fetch_student as $emp) { ?>
											<option value="<?php echo $emp->admission_no ?>"><?php echo $emp->admission_no ?>
										<?php } ?>
								</select>
							</div>
							<label class="control-label col-md-3" required>Bill Date :</label>
							<div class="col-md-4">
								<input type='date' class="form-control" id="bill_date" name="bill_date" value="" required>
							</div>
						</div>
                            
						<div class="form-group">
							<label class="control-label col-md-2">Name :</label>
							<div class="col-md-4">
								<input type="text" class="form-control" id="student_fname" name="student_fname" placeholder="" readonly />
							</div>
							<label class="control-label col-md-2">Bill Amount :</label>
							<div class="col-md-4">
								<input type="text" class="form-control" id="bill_amt" name="bill_amt" placeholder="" readonly />
							</div>

						</div>

						<div class="form-group">
							<label class="control-label col-md-2">1st Approver :</label>
							<div class="col-md-4">
								<select class="form-control" name="approve1_comment" id="approve1_comment" value="" required>
									<option value="None">&nbsp;</option>
									<option value="Approved">Approved</option>
									<option value="Rejected">Rejected</option>
								</select>
							</div>
							<label class="control-label col-md-2">Date of Approval :</label>
							<div class="col-md-4">
								<input type='date' class="form-control" id="date_approved1" name="date_approved1" value="" readonly>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">1st Approver :</label>
							<div class="col-md-4">
								<select class="form-control" name="approve2_comment" id="approve2_comment" value="" required>
									<option value="None">&nbsp;</option>
									<option value="Approved">Approved</option>
									<option value="Rejected">Rejected</option>
								</select>
							</div>
							<label class="control-label col-md-2">Date of Approval :</label>
							<div class="col-md-4">
								<input type='date' class="form-control" id="date_approved2" name="date_approved2" value="" readonly>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">1st Approver :</label>
							<div class="col-md-4">
								<select class="form-control" name="approve3_comment" id="approve3_comment" value="" required>
									<option value="None">&nbsp;</option>
									<option value="Approved">Approved</option>
									<option value="Rejected">Rejected</option>
								</select>
							</div>
							<label class="control-label col-md-2">Date of Approval :</label>
							<div class="col-md-4">
								<input type='date' class="form-control" id="date_approved3" name="date_approved3" value="" readonly>
							</div>
						</div>

			<!--				<?php } 
							?>  -->
                            
					</div>

					<div class="form-body" id="toapprove_bill_details_div" style="padding-top: 2%">
						<table class="table table-bordered" id="toapply_bill_details_tbl">
							<thead>
								<tr>
									<th>Item Name</th>
									<th>Regular Price</th>
									<th>Discount</th>
									<th>Sell Price</th>
									<th>Qty Received</th>
									<th>Amount</th>
								</tr>
							</thead>

							<tbody>
							</tbody>
						</table>
					</div>
				</div>

				<div class="modal-footer" id="modal-footer">
					<button type="button" id="btn_Save" onclick="save()" class="btn btn-success btn-sm"><strong> Save </strong></button>
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>

var globalid = '';
var url = "<?php echo base_url();?>";
var newtxt = 1000;

$(document).ready(function() {
	  $("#div_bill").on('show.bs.modal', function(){
    alert('The modal is about to be shown.');
  });

	function updateItemDet(id, bill_date, student_enrol_id, approve1_comment, approve2_comment, approve3_comment) {
alert ('Hi');
		$('#errmodal').empty();
		$('#manage_approve')[0].reset(); 		// reset form on modals
		$('.form-group').removeClass('has-error'); 	// clear error class
		$('.help-block').empty(); 					// clear error string
		$('#div_itemid').empty();
		$('#div_itemid').append('<div class="form-group"><label class="control-label col-md-3">ID</label><div class="col-md-9" id="modal_classid">'+id+'</span></div></div>');
        $('#approve_bill').val(id);
 //       $('#bill_id').val(id);
        $('#admission_no').val(student_enrol_id).prop('selected', true).trigger('change');;
        $('#approve1_comment').val(approve1_comment).prop('selected', true).trigger('change');;
        $('#approve2_comment').val(approve2_comment).prop('selected', true).trigger('change');;
        $('#approve3_comment').val(approve3_comment).prop('selected', true).trigger('change');;
       
		$.ajax({
            url: '<?php echo base_url('store/billapprove/fetch_bill_details'); ?>' + '/' + bill_id,
            type: 'POST',
            data: {approve_bill: approve_bill},
            dataType: 'html',
			
            success: function (data) {
                $('#toapprove_bill_details_div').html(data);
                $('#div_bills').modal('show');
            },
            error: function() {
                alert('error occured');
                $('#div_bills').modal('show');
            }
        });
        $('#div_bills').modal('show');
	};

	
	
		$('#AAA').click(function() {
//				save_method = 'add';
				$('#fee-box').empty();
				globalid = $(data-id).val();
				
				alert(globalid);
				$('#manage_approval')[0].reset(); 			// reset form on modals
				$('.form-group').removeClass('has-error'); 		// clear error class
				$('.help-block').empty(); 						// clear error string
				$('#div_itemid').empty();
				$('#btn_save').text('Save');
				$('#modal_form').modal('show'); 				// show bootstrap modal
		});
});


function updateItemDetOld(id, bill_date, student_enrol_id, approve1_comment, approve2_comment, approve3_comment) {
	alert('Hi');
		$('#errmodal').empty();
		$('#manage_approve')[0].reset(); 		// reset form on modals
		$('.form-group').removeClass('has-error'); 	// clear error class
		$('.help-block').empty(); 					// clear error string
		$('#div_itemid').empty();
		$('#div_itemid').append('<div class="form-group"><label class="control-label col-md-3">ID</label><div class="col-md-9" id="modal_classid">'+id+'</span></div></div>');
		$('#bill_date').val(bill_date).trigger('change');
		$('#admission_no').val(student_enrol_id).trigger('change');
		$('#approve1_comment').val(approve1_comment).trigger('change');
		$('#approve2_comment').val(approve2_comment).trigger('change');
		$('#approve3_comment').val(approve3_comment).trigger('change');

		globalid = id;
		save_method = 'update';
		$('#btn_save').text('Update');
		alert($('#modal_form'));
		$('#modal_form').modal('show');
		return false;
}


function updateItemDet(id, bill_date, student_enrol_id, approve1_comment, approve2_comment, approve3_comment) {
alert ('Hi');
		$('#errmodal').empty();
		$('#manage_approve')[0].reset(); 		// reset form on modals
		$('.form-group').removeClass('has-error'); 	// clear error class
		$('.help-block').empty(); 					// clear error string
		$('#div_itemid').empty();
		$('#div_itemid').append('<div class="form-group"><label class="control-label col-md-3">ID</label><div class="col-md-9" id="modal_classid">'+id+'</span></div></div>');
        $('#approve_bill').val(id);
 //       $('#bill_id').val(id);
        $('#admission_no').val(student_enrol_id).prop('selected', true).trigger('change');;
        $('#approve1_comment').val(approve1_comment).prop('selected', true).trigger('change');;
        $('#approve2_comment').val(approve2_comment).prop('selected', true).trigger('change');;
        $('#approve3_comment').val(approve3_comment).prop('selected', true).trigger('change');;
       
		$.ajax({
            url: '<?php echo base_url('store/billapprove/fetch_bill_details'); ?>' + '/' + bill_id,
            type: 'POST',
            data: {approve_bill: approve_bill},
            dataType: 'html',
			
            success: function (data) {
                $('#toapprove_bill_details_div').html(data);
                $('#div_bills').modal('show');
            },
            error: function() {
                alert('error occured');
                $('#div_bills').modal('show');
            }
        });
        $('#div_bills').modal('show');
}



function save() {
	var resp = confirm("Do you want save the record?");
	if (resp == true) 
		{
				$('#btn_Save').text('Saving...'); //change button text
				$('#btn_Save').attr('disabled',true); //set button disable 
        
				var err = '';
				$('#errmodal').empty();

				if($('#bill_date').val() == '') {
                    err = 'Please enter Bill Date !';
				}

				if(err == '') {
					$('#errmodal').empty();
					var url = '';
					var student_enrol_id = $('#admission_no').val();
					var bill_date=$('#bill_date').val();

					if(save_method == 'add') {
						url = "<?php echo site_url('store/billapprove/add_details')?>";
					} 
					else {
						var modal_classid1=$('#modal_classid').text();
						$('#btn_Save').text('updating...');
						url = "<?php echo site_url('store/billapprove/update_details')?>/"+modal_classid1;
					}

					$.ajax
						({
								url : url,
								type: "POST",
								data: 
									{
										student_enrol_id:student_enrol_id,
										bill_date:bill_date
									},
								dataType: "text",
								
								success: function(data) {
									if(data == 1) {
										$('#div_bills').modal('hide');
										window.location.reload();
									}

									$('#btn_Save').text('Save');
									$('#btn_Save').attr('disabled',false);
								}
						});                    
				}
				else {
					$('#errmodal').css('color','Red');
					$('#errmodal').append(err);
					$('#btn_Save').text('Save'); //change button text
					$('#btn_Save').attr('disabled',false); //set button disable 
				}
		} 
		else {
			return false;
		}
}

</script>
