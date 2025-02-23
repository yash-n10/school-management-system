<div class="form-group has-feedback">
	<div class="box">
		<div class="box-body">
			<div class="col-lg-12">
				<?php if(substr($right_access,0,1)=='C'){?>
					<div class="col-lg-12" style="text-align:right;">
			<!--			<button class="btn btn-add" id="add_bills"><i class="fa fa-plus-circle fa-lg"></i><strong>&nbsp;Add</strong></button>   -->
						<button data-toggle="modal" data-target="#div_bills"  class="btn btn-add" id="add_bills" title="Create Bill">
							<i class="fa fa-plus-circle fa-lg"></i> 
					</button>
					</div>
				<?php }?>
			</div>
		</div>
			
		<div class="box-body">
	              <form id='frmdetails' role="form" method="POST">
				<div class="table-responsive">
					<table id="itemdetailslist" class="table table-bordered table-striped dTable">
						<thead style="background:#99ceff;">
							<tr>
								<th style="border-bottom:0px">Bill Date</th>
								<th style="border-bottom:0px">Student Admission No.</th>
								<th style="border-bottom:0px">Student Name</th>
								<th style="border-bottom:0px">1st Approver</th>
								<th style="border-bottom:0px">2nd Approver</th>
								<th style="border-bottom:0px">3rd Approver</th>
								<th style="border-bottom:0px">Final Status</th>
								<th style="border-bottom:0px">Final Comment</th>
								<th style="border-bottom:0px">Action</th>
							</tr>
						</thead>

						<thead style="background: #cce6ff">
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

						<tbody>
							<?php 
							if(isset($bills_approve) && count($bills_approve) > 0) {
								foreach ($bills_approve as $arritem) { 
							?>
								<tr>
									<td><?php echo $arritem->id; ?></td> 
									<td><?php echo $arritem->bill_date; ?></td>                                         
									<td><?php echo $arritem->student_enrol_id; ?></td>                                         
									<td><?php echo $arritem->student_fname + '  ' + $arritem->student_fname; ?></td>                                         
									<td><?php echo $arritem->approve1_comment; ?></td>    
									<td><?php echo $arritem->approve2_comment; ?></td>    
									<td><?php echo $arritem->approve3_comment; ?></td>    
									<td><?php echo $arritem->final_status; ?></td>                                         
									<td><?php echo $arritem->final_comment; ?></td>                                         
									<td>
										<?php 
										if(substr($right_access,2,1)=='U') {?>
											<a class="btn a-edit" onclick="updateItemDet('<?php echo $arritem->id; ?>','<?php echo $arritem->bill_date; ?>', '<?php echo $arritem->student_enrol_id; ?>', '<?php echo $arritem->approve1_comment; ?>','<?php echo $arritem->approve2_comment;?>', '<?php echo $arritem->approve3_comment;?>');">
												<i class="fa fa-edit"></i> 
											</a>
										<?php }
										if (substr($right_access,3,1)=='D') {?>
											<a class="btn a-delete" data-toggle="modal" onclick="delete_Details('<?php echo $arritem->id; ?>');">
												<i class="fa fa-trash-o"></i> 
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


function updateItemDet(id, bill_date, student_enrol_id, approve1_comment, approve2_comment, approve3_comment) {
		$('#errmodal').empty();
		$('#form_bill_add')[0].reset(); 		// reset form on modals
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
		alert($('#modal_form').id);
		$('#modal_form').modal('show');
		return false;
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




<!--                                Modal           -->

<!-- Bootstrap modal -->
<div class="modal fade" id="div_bills" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" id="modal_header" style="background:lightblue">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><strong>&times;</strong></span></button>
					<h3 class="modal-title">Create Bill</h3>
			</div>
		
			<div class="modal-body" id="modal-body">
				<form action="#bill_add" id="form_bill_add" name="form_bill_add" class="form-horizontal">
					<div class="form-body">
						<div class="form-group">
							<div class="col-md-3"></div>
							<div class="col-md-9" id="errmodal"></div>
						</div>




<!--    **  Modal content    **  
			<form action="<?php echo base_url('store/billapprove/save'); ?>" method="post" id="manage_bill"  class="form-horizontal">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title">Create Bill</h3>
				</div>
				
				<div class="modal-body form">
					<div class="form-body">
						<?php if ($this->session->userdata('login_type') == 'admin' || $this->session->userdata('login_type') == 'principal' || $this->session->userdata('login_type') == 'hr') { ?>

								<div class="form-group">
									<div class="col-md-3"></div>
									<div class="col-md-9" id="errmodal"></div>
								</div>  -->

						<div id="div_itemid"></div>
								
						<div class="form-group" >
							<label class="control-label col-md-2 req">Admission No. :</label>
							<div class="col-md-3">
								<select class="form-control" name="admission_no" id="admission_no" required>
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

                    

					<div class="form-body" id="toapply_leave_details_div" style="padding-top: 2%">
	
						<table class="table table-bordered" id="toapply_leave_details_tbl">
							<thead>
								<tr><td colspan="4" style="text-align:center;font-size: 18px;border-bottom:1px solid grey">Leave Details</td></tr>
								<tr>
									<th>Leave Type</th>
									<th>Opening Leave</th>
									<th>Taken Leave</th>
									<th>Available Leave</th>
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
			<!--	
				<div class="modal-footer">
					<label id="error_apply" style="color:red;float: left"></label>
					<button type="button" class="btn btn-success" id="btn_save">Apply</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>   -->
			</form>
            <!--</div>-->
		</div>

	</div>
</div>
