<style>
	.nogap {
		padding-top: 0px;
		padding-right: 10px;
		padding-bottom: 0px;
		padding-left: 5px;
		margin-top: 1px;
		margin-right: 0px;
		margin-bottom: 1px;
		margin-left: 0px;
	}
</style>

<div class="form-group has-feedback">
	<div class="box">
		<div class="box-body">
	              <form id='frmdetails' role="form" method="POST">
				<div class="table-responsive">
					<table id="itemdetailslist" class="table table-bordered table-striped dTable">
						<thead style="background:#99ceff;">
							<tr>
								<th style="border-bottom:0px; width:7%">Bill ID</th>
								<th style="border-bottom:0px; width:8%">Bill Date</th>
								<th style="border-bottom:0px; width:10%">Admission No.</th>
								<th style="border-bottom:0px; width:15%">Student Name</th>
								<th style="border-bottom:0px; width:10%">Bill Amount</th>
	<!--							<th style="border-bottom:0px; width:9%">Approver1</th>
								<th style="border-bottom:0px; width:9%">Approver2</th>
								<th style="border-bottom:0px; width:9%">Approver3</th>   -->
								<th style="border-bottom:0px; width:20%">Status</th>
								<th style="border-bottom:0px; width:25%">Remarks</th>
								<th style="border-bottom:0px; width:5%">Action</th>
							</tr>
						</thead>

						<tbody style="font-size:14px;">
							<?php 
							if(isset($store_bill_hdr) && count($store_bill_hdr) > 0) {
								foreach ($store_bill_hdr as $arritem) { 
							?>
								<tr>
									<td><?php echo $arritem->id; ?></td> 
									<td style="text-align:center;"><?php echo $arritem->bill_date; ?></td>                                         
									<td style="text-align:center;"><?php echo $arritem->admission_no; ?></td>                                         
									<td><?php echo $arritem->student_fname . ' ' . $arritem->student_midname . ' ' . $arritem->student_lname; ?></td> 
									<td style="text-align:right;"><?php echo $arritem->bill_amt; ?></td>             
					<!--				<td><?php echo $arritem->approve1_comment; ?></td>    
									<td><?php echo $arritem->approve2_comment; ?></td>    
									<td><?php echo $arritem->approve3_comment; ?></td>    -->
									<td><?php echo $arritem->final_status; ?></td>                                         
									<td><?php echo $arritem->final_comment; ?></td>                                         
									<td style="text-align:center;">
										<?php 
										if(substr($right_access,2,1)=='U') {?>
											<a class="btn a-edit" style="color:red" onclick="updateItemDet('<?php echo $arritem->id; ?>','<?php echo $arritem->bill_date; ?>', 
																					'<?php echo $arritem->admission_no; ?>', '<?php echo $arritem->bill_amt; ?>',
																					'<?php echo $arritem->student_fname . ' ' . $arritem->student_midname . ' ' . $arritem->student_lname; ?>',
																					'<?php echo $arritem->approve1_comment; ?>', '<?php echo $arritem->date_approved1; ?>',
																					'<?php echo $arritem->approve2_comment; ?>', '<?php echo $arritem->date_approved2; ?>',
																					'<?php echo $arritem->approve3_comment; ?>', '<?php echo $arritem->date_approved3; ?>',
																					'<?php echo $get_role; ?>'
																					);">
												<i class="fa fa-check-square-o"></i> 
											</a>
										<?php } ?>                     
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


<script>
var globalid = '';
var url = "<?php echo base_url();?>";
var newtxt = 1000;

$(document).ready(function() {
		$('#add_bills').click(function() {
				save_method = 'add';
				$('#fee-box').empty();
				$('#form_bill_add')[0].reset(); 			// reset form on modals
				$('.form-group').removeClass('has-error'); 		// clear error class
				$('.help-block').empty(); 						// clear error string
				$('#div_itemid').empty();
				$('#btn_Save').text('Save');
				$('#modal_form').modal('show'); 				// show bootstrap modal
		});

        $('#approve1_comment').change(function () {
				if (($('#approve1_comment').val() == null) || ($('#approve1_comment').val() == '')) {
				//	$('#approve1_comment').disabled = true;
				//	$('#approve1_comment').attr('disabled',false);
				}
		});
		
});

 
function updDate(arg_id, arg_appr) {
		var_id = "$('#"+ arg_id +"')";
		switch (var_id) {
			case "$('#approve1_comment')":
						if ((arg_appr == 'Approved') || (arg_appr == 'Rejected'))
							$('#date_approved1').val(date('Y:m:d'));
						else 
							$('#date_approved1').val('');
						break;
			case "$('#approve2_comment')":
						if ((arg_appr == 'Approved') || (arg_appr == 'Rejected'))
							$('#date_approved2').val(date('Y:m:d'));
						else 
							$('#date_approved2').val('');
						break;
			case "$('#approve3_comment')":
						if ((arg_appr == 'Approved') || (arg_appr == 'Rejected'))
							$('#date_approved3').val(date('Y:m:d'));
						else 
							$('#date_approved3').val('');
						break;
			default:		
		}
}

function updateItemDet(id, bill_date, student_enrol_id, bill_amount, full_name, approve1_comment, app1date, approve2_comment, app2date,approve3_comment, app3date, gtype) {
		$('#errmodal').empty();
		$('#form_bill_add')[0].reset(); 		
		$('.form-group').removeClass('has-error'); 	// clear error class
		$('.help-block').empty(); 					// clear error string
		$('#div_itemid').empty();
//	alert(gtype);
		$('#bid').val(id);
		$('#bill_date').val(bill_date).trigger('change');
		$('#bill_amount').val(bill_amount);
		$('#student_fname').val(full_name);
		$('#admission_no').val(student_enrol_id).trigger('change');
		$('#approve1_comment').val(approve1_comment).trigger('change');
		$('#approve2_comment').val(approve2_comment).trigger('change');
		$('#approve3_comment').val(approve3_comment).trigger('change');
		$('#date_approve1').val(app1date).trigger('change');
		$('#date_approve2').val(app2date).trigger('change');
		$('#date_approve3').val(app3date).trigger('change');

		if (gtype == 'admin' || gtype == 'Approver 1') {
			if (($('#approve1_comment').val() != null)) {
				$('#approve1_comment').attr('disabled',true);
			}
			else {
				$('#approve1_comment').attr('disabled',false);
//				$('#date_approve1').val(date('Y-m-d'));
				$('#remarks').attr('disabled',false);
			}
		}		
		else if (gtype == 'admin' || gtype == 'Approver 2') {
			if (($('#approve2_comment').val() != null)) {
				$('#approve2_comment').attr('disabled',true);
			}
			else {
				$('#approve2_comment').attr('disabled',false);
				$('#remarks').attr('disabled',false);
			}
		}		
		else if (gtype == 'admin' || gtype == 'Approver 3') {
			if (($('#approve3_comment').val() != null)) {
				$('#approve3_comment').attr('disabled',true);
			}
			else {
				$('#approve3_comment').attr('disabled',false);
				$('#remarks').attr('disabled',false);
			}
		}		

		
		url = "<?php echo site_url('store/billapprove/fetch_billitem_details')?>/" + id;

        $.ajax({
            url: url,
            type: 'POST',
            data: {bill_id:id},
            dataType: 'html',
            success: function (data)
            {
//				alert(data);
                $('#toapprove_bill_details_div').html(data);
                $('#div_bills').modal('show');
            },
            error: function ()
            {
                alert('error occured');
                $('#div_bills').modal('show');
            }
        });
        $('#div_bills').modal('show')
}


function save() {
		var resp = confirm("Do you want save the record?");
		if (resp == true) 
		{
				$('#btn_Save').text('Saving...'); 		//change button text
				$('#btn_Save').attr('disabled',true); 	//set button disable 
        
				var err = '';
				$('#errmodal').empty();

				if (($('#approve1_comment').val() == 'Rejected') || ($('#approve2_comment').val() == 'Rejected') || ($('#approve3_comment').val() == 'Rejected')) {
					if (($('#remarks').val() == null) || ($('#remarks').val() == ''))
						err = 'Please enter REMARKS !';                  
				}

/*				if ($('#approve1_comment').val() != null) {
					if (($('#date_approve1').val() == null) || ($('#date_approve1').val() == ''))
						err = 'Please enter DATE OF APPROVAL !';
				} */
	//		alert('Err: '+ err);
//	alert($('#approve1_comment').attr('disabled'));
			
				if(err == '') {
					$('#errmodal').empty();
					var url = '';
					var bid = $('#bid').val();
					var comm_appr1 = $('#approve1_comment').val();
					var date_appr1 = $('#date_approve1').val();
					var comm_appr2 = $('#approve2_comment').val();
					var date_appr2 = $('#date_approve2').val();
					var comm_appr3 = $('#approve3_comment').val();
					var date_appr3 = $('#date_approve3').val();
					var remarks = $('#remarks').val();
					
					url = "<?php echo site_url('store/billapprove/update_details')?>/"+ $('#bid').val();
//alert(url);
					$.ajax
						({
								url : url,
								type: "POST",
								data: 
									{
										comm_appr1:comm_appr1,
										date_appr1:date_appr1,
										comm_appr2:comm_appr2,
										date_appr2:date_appr2,
										comm_appr3:comm_appr3,
										date_appr3:date_appr3
									},
								dataType: "text",
								
								success: function(data) {
								//	alert(data);
									if(data == 1) {
										$('#div_bills').modal('hide');
										window.location='/store/billapprove';
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


<!-- Bootstrap modal -->
<div class="modal fade" id="div_bills" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" id="modal_header" style="background:#00c0ee; color:white; ">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='fa fa-remove fa-sm'></i></span></button>
					<h3 class="modal-title"><b>Approve Bill</b></h3>
			</div>
		
			<div class="modal-body" id="modal-body">
				<form action="#bill_add" id="form_bill_add" name="form_bill_add" class="form-horizontal">
					<div class="form-body">
						<div class="form-group nogap">
							<div class="col-md-3 nogap"></div>
							<div class="col-md-9 nogap" id="errmodal"></div>
						</div>

<!--    **  Modal content    **  
				
						<?php if ($this->session->userdata('login_type') == 'admin' || $this->session->userdata('login_type') != 'admin') { ?>

								<div class="form-group">
									<div class="col-md-3"></div>
									<div class="col-md-9" id="errmodal"></div>
								</div>  -->

						<div id="div_itemid nogap"></div>
								
						<div class="form-group nogap">
							<input type='hidden' class="form-control" id="bid" name="bid" value="" readonly>
							<label class="control-label col-md-2 req nogap">Admission No. :</label>
							<div class="col-md-3 nogap">
								<input type='text' class="form-control" id="admission_no" name="admission_no" value="" readonly>
							</div>
							<label class="control-label col-md-3 nogap">Bill Date :</label>
							<div class="col-md-3 nogap">
								<input type='date' class="form-control" id="bill_date" name="bill_date" value="" readonly>
							</div>
						</div>
                            
						<div class="form-group nogap">
							<label class="control-label col-md-2 nogap">Name :</label>
							<div class="col-md-3 nogap">
								<input type="text" class="form-control nogap" id="student_fname" name="student_fname" placeholder="" readonly />
							</div>
							<label class="control-label col-md-3 nogap">Bill Amount (in Rs.) :</label>
							<div class="col-md-3 nogap">
								<input type='text' class="form-control" id="bill_amount" name="bill_amount" value="" readonly>
							</div>
						</div>
	
						<div class="form-group well">
							<div class="col-md-8 nogap">
								<div class="form-group nogap">
									<label class="control-label col-sm-3 nogap">1st Approver :</label>
									<div class="col-sm-3 nogap">
										<select class="form-control" name="approve1_comment" id="approve1_comment" value="" disabled>  <!--onchange="updDate(id, value);"  -->
											<option value="None">&nbsp;</option>
											<option value="Approved">Approved</option>
											<option value="Rejected">Rejected</option>
										</select>
									</div>
									<label class="control-label col-sm-2 nogap">Date :</label>
									<div class="col-sm-4 nogap">
										<input type="date" class="form-control" id="date_approve1" name="date_approve1" value="" disabled>  
									</div>
								</div>
								<div class="form-group nogap">
									<label class="control-label col-sm-3 nogap">2nd Approver :</label>
									<div class="col-sm-3 nogap">
										<select class="form-control" name="approve2_comment" id="approve2_comment" value="" disabled>
											<option value="None">&nbsp;</option>
											<option value="Approved">Approved</option>
											<option value="Rejected">Rejected</option>
										</select>
									</div>
									<label class="control-label col-sm-2 nogap">Date :</label>
									<div class="col-sm-4 nogap">
										<input type="date" class="form-control" id="date_approve2" name="date_approve2" value="" disabled>
									</div>
								</div>
								
								<div class="form-group nogap">
									<label class="control-label col-sm-3 nogap">3rd Approver :</label>
									<div class="col-sm-3 nogap">
										<select class="form-control" name="approve3_comment" id="approve3_comment" value="" disabled>
											<option value="None">&nbsp;</option>
											<option value="Approved">Approved</option>
											<option value="Rejected">Rejected</option>
										</select>
									</div>
									<label class="control-label col-sm-2 nogap">Date :</label>
									<div class="col-sm-4 nogap">
										<input type="date" class="form-control" id="date_approve3" name="date_approve3" value="" disabled>
									</div>
								</div>
								<!--	<?php } 	?>  -->
							</div>
							<div class="col-md-4 nogap">
								<div class="form-group nogap">
									<label class="control-label col-md-4 nogap" style="float:left;">Remarks :</label>
								</div>
								<div class="col-md-12 nogap">
									<textarea rows="3" class="form-control" id="remarks" name="remarks" value="" placeholder="Required, if rejected..." disabled></textarea>
								</div>
							</div>
						</div>
					</div>

					<div class="form-body" id="toapprove_bill_details_div" style="padding-top: 2%">
	
						<table class="table table-bordered" id="toapply_bill_details_tbl">
							<tbody>
							</tbody>
						</table>
					</div>
	<!--			</div>	-->

        
					<div class="modal-footer" id="modal-footer">
						<button type="button" id="btn_Save" onclick="save()" class="btn btn-success btn-sm"><strong> Save </strong></button>
						<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
					</div>
				</form>
			</div>
		</div>

	</div>
</div>
