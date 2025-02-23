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
			<div class="col-lg-12">
				<?php if(substr($right_access,0,1)=='C'){?>
					<div class="col-lg-12" style="">
						<a type="button" class="btn btn-add" title="Generate Bill" style="float:right; font-weight:bold; " href="<?php echo site_url('store/billcreate/generate_bill');?>">
							<i class="fa fa-plus fa-lg"></i>&nbsp;&nbsp;New Bill</a>

					</div>
				<?php }?>
			</div>
		</div>
			
		<div class="box-body">
	              <form id='frmdetails' role="form" method="POST">
				<div class="table-responsive">
					<table id="itemdetailslist" class="table table-bordered table-striped dTable">
						<thead style="background:#99ceff;">
							<tr class="nogap">
								<th>S.No</th>
								<th style="border-bottom:0px; width:7%;">Bill ID</th>
								<th style="border-bottom:0px; width:8%;">Bill Date</th>
								<th style="border-bottom:0px; width:12%;">Admission No.</th>
								<th style="border-bottom:0px; width:15%;">Student Name</th>
<!--								<th style="border-bottom:0px; width:9%;">Approver1</th>
								<th style="border-bottom:0px; width:9%;">Approver2</th>
								<th style="border-bottom:0px; width:9%;">Approver3</th>    -->
								<th style="border-bottom:0px; width:15%;">Status</th>
								<th style="border-bottom:0px; width:25%;">Comments</th>
								<th style="border-bottom:0px; width:10%;">Action</th>
							</tr>
						</thead>

						<tbody style="font-size:14px;">
							<?php 
							if(isset($store_bill_hdr) && count($store_bill_hdr) > 0) {
							$i=1;
								foreach ($store_bill_hdr as $arritem) { 
							?>
								<tr class="nogap">
									<td><?php echo $i;?></td>
									<td class="nogap"><?php echo $arritem->id; ?></td> 
									<td class="nogap"><?php echo $arritem->bill_date; ?></td>                                         
									<td class="nogap" style="text-align:center; "><?php echo $arritem->admission_no; ?></td>                                         
									<td class="nogap"><?php echo $arritem->student_fname . '  ' . $arritem->student_midname . ' ' . $arritem->student_lname; ?></td>                                         
<!--									<td><?php echo $arritem->approve1_comment; ?></td>    
									<td><?php echo $arritem->approve2_comment; ?></td>    
									<td><?php echo $arritem->approve3_comment; ?></td>     -->
									<td class="nogap"><?php echo $arritem->final_status; ?></td>                                         
									<td class="nogap"><?php echo $arritem->final_comment; ?></td>                                         
									<td class="nogap" style="align:center;">
											<a class="btn a-edit" style="color:grey" data-toggle="tooltip" title="View" onclick="updateItemDet('<?php echo $arritem->id; ?>','<?php echo $arritem->bill_date; ?>', 
																					'<?php echo $arritem->admission_no; ?>', '<?php echo $arritem->bill_amt; ?>',
																					'<?php echo $arritem->student_fname . '  ' . $arritem->student_midname . ' ' . $arritem->student_lname; ?>',
																					'<?php echo $arritem->approve1_comment; ?>', '<?php echo $arritem->date_approved1; ?>',
																					'<?php echo $arritem->approve2_comment; ?>', '<?php echo $arritem->date_approved2; ?>',
																					'<?php echo $arritem->approve3_comment; ?>', '<?php echo $arritem->date_approved3; ?>', 'vu'
																					);">
												<i class="fa fa-eye"></i> 
											</a>
										<?php if(substr($right_access,2,1)=='U') { if (strtoupper($arritem->final_status) == 'REJECTED') {?> 
											<a class="btn a-edit" data-toggle="tooltip" title="Update" onclick="updateItemDet('<?php echo $arritem->id; ?>','<?php echo $arritem->bill_date; ?>', 
																					'<?php echo $arritem->admission_no; ?>', '<?php echo $arritem->bill_amt; ?>',
																					'<?php echo $arritem->student_fname . '  ' . $arritem->student_midname . ' ' . $arritem->student_lname; ?>',
																					'<?php echo $arritem->approve1_comment; ?>', '<?php echo $arritem->date_approved1; ?>',
																					'<?php echo $arritem->approve2_comment; ?>', '<?php echo $arritem->date_approved2; ?>',
																					'<?php echo $arritem->approve3_comment; ?>', '<?php echo $arritem->date_approved3; ?>','<?php echo $arritem->approver4_comment; ?>', '<?php echo $arritem->date_approved4; ?>', 'up'
																					);">
												<i class="fa fa-edit"></i> 
												<!-- <?php print_r($arritem);?> -->
											</a>
										<?php }} ?>

									</td>                         
								</tr>
								<?php $i++;}
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
	//			$('#modal_form').modal('show'); 				// show bootstrap modal
		});

        $('#admission_no').change(function () {
            $.ajax({
                url: '<?php echo base_url('store/billapprove/get_student_information'); ?>',
                data: {code: $(this).val()},
                type: 'POST',
                dataType: 'JSON',
                success: function (data)
                {
                    $.each(data, function (index, element)
                    {
                        $('#student_fname').val(element['first_name'] + ' ' + element['middle_name'] + ' ' + element['last_name']);
                        $('#student_midname').val(element['middle_name']);
                    });
                },

                error: function () {
                    alert('error');
                }
            });
        });
});


function updateItemDet(id, bill_date, student_enrol_id, bill_amount, full_name, approve1_comment, app1date, approve2_comment, app2date,approve3_comment, app3date,approve4_comment, app4date, argAct) {

		$('#errmodal').empty();
		$('#form_bill_add')[0].reset(); 		
		$('.form-group').removeClass('has-error'); 	// clear error class
		$('.help-block').empty(); 					// clear error string
		$('#div_itemid').empty();

		$('#bid').val(id);
		$('#bill_date').val(bill_date).trigger('change');
		$('#bill_amount').val(bill_amount);
		$('#admission_no').val(student_enrol_id).trigger('change');
		$('#student_fname').val(full_name);
		$('#approve1_comment').val(approve1_comment).trigger('change');
		$('#approve2_comment').val(approve2_comment).trigger('change');
		$('#approve3_comment').val(approve3_comment).trigger('change');
		$('#approve4_comment').val(approve4_comment).trigger('change');
		$('#date_approve1').val(app1date).trigger('change');
		$('#date_approve2').val(app2date).trigger('change');
		$('#date_approve3').val(app3date).trigger('change');
		$('#date_approve4').val(app4date).trigger('change');
		
		if (argAct == 'up') {
			url = "<?php echo site_url('store/billcreate/fetch_billitem_details')?>/" + id;
			$('#btn_Save').attr('disabled',false);
			$('#modTitle').text('Edit Bill');
			$('#btn_Close').text('Cancel');
		} else {
			url = "<?php echo site_url('store/billcreate/fetch_billitem_details_vu')?>/" + id;
			$('#btn_Save').attr('disabled',true);
			$('#modTitle').text('View Bill');
			$('#btn_Close').text('Close');
		}
//		alert(url);

        $.ajax({
            url: url,
            type: 'POST',
            data: {bill_id:id},
            dataType: 'html',
            success: function (data)
            {
				// alert(data);
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



function save(arg_id, arg_val) {
	// alert(arg_id);
	// alert(arg_val);
	var ndxS = (arg_id.indexOf("_") + 1);
	var ndxE = (arg_id.length - arg_id.indexOf("_"));
	var ndx = arg_id.substr(ndxS, ndxE);
// alert(ndxS);
// alert(ndxE);
// alert(ndx);
//	alert($('#total_'+ndx).val());

	url = "<?php echo site_url('store/billcreate/updateRecs')?>/"+ arg_val;

		$.ajax
			({
				url : url,
				type: "POST",
				data: 
					{
						detid:arg_val,
						reg_price:$('#sprice_'+ndx).val(),
						disc_amt:$('#disc_'+ndx).val(),
						sell_price:$('#fprice_'+ndx).val(),
						item_amt:$('#total_'+ndx).val()
					},

				dataType: "text",
							
				success: function(data) {
					if(data == 1) {
//							$('#div_bills').modal('hide');
							window.location.reload();
					}
					else{
						alert(data);
					}
									$('#btn_Save').text('Save');
									$('#btn_Save').attr('disabled',false);
								}
						});                    
			
	
}


function updData(arg_id, arg_val) {
		var ndxS = (arg_id.indexOf("_") + 1);
		var ndxE = (arg_id.length - arg_id.indexOf("_"));
		var ndx = arg_id.substr(ndxS, ndxE);

//		alert($('#disc_'+ndx).val());
		var sellp = arg_val - $('#disc_'+ndx).val();
		$('#fprice_'+ndx).val(sellp.toFixed(2));
		$('#total_'+ndx).val(($('#qty_'+ndx).val() * sellp).toFixed(2))
}

function updDatadisc(arg_id, arg_val) {
		var ndxS = (arg_id.indexOf("_") + 1);
		var ndxE = (arg_id.length - arg_id.indexOf("_"));
		var ndx = arg_id.substr(ndxS, ndxE);

//		alert($('#sprice_'+ndx).val());
		var sellp = $('#sprice_'+ndx).val() - arg_val;
		$('#fprice_'+ndx).val(sellp.toFixed(2));
		$('#total_'+ndx).val(($('#qty_'+ndx).val() * sellp).toFixed(2))
}

</script>


<!--        Modal            -->

<!-- Bootstrap modal -->
<div class="modal fade" id="div_bills" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" id="modal_header" style="background:#00c0ee; color:white; ">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='fa fa-remove fa-sm'></i></span></button>
					<h3 id="modTitle" class="modal-title" style="font-weight:bold;">Bill Details</h3>
			</div>
		
			<div class="modal-body" id="modal-body">
				<form  id="form_bill_add" name="form_bill_add" class="form-horizontal"> 
					<div class="form-body">
						<div class="form-group nogap">
							<div class="col-md-3 nogap"></div>
							<div class="col-md-9 nogap" id="errmodal"></div>
						</div>

						<div id="div_itemid nogap"></div>
								
						<div class="form-group nogap">
							<label class="control-label col-md-2 req nogap">Admission No. :</label>
							<div class="col-md-3 nogap">
								<select class="form-control" name="admission_no" id="admission_no" disabled>
									<option value="" >Select Admission No.</option>
										<?php foreach ($fetch_student as $emp) { ?>
											<option disabled="disabled" value="<?php echo $emp->admission_no ?>"><?php echo $emp->admission_no ?>
										<?php } ?>
								</select>
							</div>
							<label class="control-label col-md-3 nogap">Bill Date :</label>
							<div class="col-md-3 nogap">
								<input type='date' class="form-control" id="bill_date" name="bill_date" value="" readonly>
							</div>
						</div>
                            
						<div class="form-group nogap">
							<label class="control-label col-md-2 nogap">Name :</label>
							<div class="col-md-3 nogap">
								<input type="text" class="form-control nogap" id="student_fname" name="student_fname" placeholder="" readonly>
							</div>
							<label class="control-label col-md-3 nogap">Bill Amount (in Rs.) :</label>
							<div class="col-md-3 nogap">
								<input type='text' class="form-control" style="font-weight:bold;" id="bill_amount" name="bill_amount" value="" readonly>
							</div>
						</div>
	
						<div class="form-group well">
							<div class="col-md-8 nogap">
								<div class="form-group nogap">
									<label class="control-label col-sm-3 nogap">Storekeeper :</label>
									<div class="col-sm-3 nogap">
										<select class="form-control" name="approve1_comment" id="approve1_comment" value="" readonly>
											<option disabled="disabled" value="None">&nbsp;</option>
											<option disabled="disabled" value="Approved">Approved</option>
											<option disabled="disabled" value="Rejected">Rejected</option>
										</select>
									</div>
									<label class="control-label col-sm-3 nogap">Approved on :</label>
									<div class="col-sm-3 nogap">
										<input type="text" class="form-control" id="date_approved1" name="date_approved1" value="" readonly>
									</div>
								</div>
								<div class="form-group nogap">
									<label class="control-label col-sm-3 nogap">Bill Clerk :</label>
									<div class="col-sm-3 nogap">
										<select class="form-control" name="approve2_comment" id="approve2_comment" value="" readonly>
											<option disabled="disabled" value="None">&nbsp;</option>
											<option disabled="disabled" value="Approved">Approved</option>
											<option disabled="disabled" value="Rejected">Rejected</option>
										</select>
									</div>
									<label class="control-label col-sm-3 nogap">Approved on :</label>
									<div class="col-sm-3 nogap">
										<input type="text" class="form-control" id="date_approved2" name="date_approved2" value="" readonly>
									</div>
								</div>
								
								<div class="form-group nogap">
									<label class="control-label col-sm-3 nogap">Accountant :</label>
									<div class="col-sm-3 nogap">
										<select class="form-control" name="approve3_comment" id="approve3_comment" value="" readonly>
											<option disabled="disabled" value="None">&nbsp;</option>
											<option disabled="disabled" value="Approved">Approved</option>
											<option disabled="disabled" value="Rejected">Rejected</option>
										</select>
									</div>
									<label class="control-label col-sm-3 nogap">Approved on :</label>
									<div class="col-sm-3 nogap">
										<input type="text" class="form-control" id="date_approved3" name="date_approved3" value="" readonly >
									</div>
								</div>
								<div class="form-group nogap">
									<label class="control-label col-sm-3 nogap">AO :</label>
									<div class="col-sm-3 nogap">
										<select class="form-control" name="approve4_comment" id="approve4_comment" value="" readonly>
											<option disabled="disabled" value="None">&nbsp;</option>
											<option disabled="disabled" value="Approved">Approved</option>
											<option disabled="disabled" value="Rejected">Rejected</option>
										</select>
									</div>
									<label class="control-label col-sm-3 nogap">Approved on :</label>
									<div class="col-sm-3 nogap">
										<input type="text" class="form-control" id="date_approved4" name="date_approved4" value="" readonly >
									</div>
								</div>
								
							</div>
							<div class="col-md-4 nogap">
								<div class="form-group nogap">
									<label class="control-label col-md-4 nogap" style="float:left;">Remarks :</label>
								</div>
								<div class="col-md-9 nogap">
									<textarea rows="3" class="form-control" id="remarks" name="remarks" value="" placeholder="Enter comments if rejected..." readonly></textarea>
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
        
					<div class="modal-footer" id="modal-footer">
						<button type="button" id="btn_Save" onclick="save(id,'')" class="btn btn-success btn-sm"><strong> Save </strong></button>
						<button type="button" id="btn_Close" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
					</div>
				</form>
			</div>  <!--   Uncommented -->
		</div>
	</div>
</div>
