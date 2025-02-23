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
					<div class="col-lg-12" style="text-align:right;">
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
							<tr>
								<th style="border-bottom:0px; width:6%">Bill ID</th>
								<th style="border-bottom:0px; width:7%">Bill Date</th>
								<th style="border-bottom:0px; width:7%">Admission No.</th>
								<th style="border-bottom:0px; width:15%">Student Name</th>
								<th style="border-bottom:0px; width:9%">Approver1</th>
								<th style="border-bottom:0px; width:9%">Approver2</th>
								<th style="border-bottom:0px; width:9%">Approver3</th>
								<th style="border-bottom:0px; width:11%">Status</th>
								<th style="border-bottom:0px; width:19%">Comments</th>
								<th style="border-bottom:0px; width:10%">Action</th>
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
									<td style="align:center;">
										<?php 
										if(substr($right_access,2,1)=='U') {?>
											<a class="btn a-edit" onclick="updateItemDet('<?php echo $arritem->id; ?>','<?php echo $arritem->bill_date; ?>', '<?php echo $arritem->admission_no; ?>', 
																					'<?php echo $arritem->approve1_comment; ?>',
																					'<?php echo $arritem->approve2_comment;?>', '<?php echo $arritem->approve3_comment;?>');">
												<i class="fa fa-edit"></i> 
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
//		$('#div_itemid').append('<div class="form-group style="display: inline;"><label class="control-label col-md-2">Id :</label><div class="col-md-10" id="modal_classid">'+id+'</span></div></div>');
		$('#bill_date').val(bill_date).trigger('change');
		$('#admission_no').val(student_enrol_id).trigger('change');
		$('#approve1_comment').val(approve1_comment).trigger('change');
		$('#approve2_comment').val(approve2_comment).trigger('change');
		$('#approve3_comment').val(approve3_comment).trigger('change');
		
url = "<?php echo site_url('store/billcreate/fetch_billitem_details')?>/" + id;
alert(url);
        $.ajax({
            url: url,
            type: 'POST',
            data: {bill_id:id},
            dataType: 'html',
            success: function (data)
            {
				alert(data);
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

//		globalid = id;
//		save_method = 'update';
//		$('#btn_save').text('Update');
//		alert($('#modal_form').);
//		$('#div_bills').modal('show');
//		return false;
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


<!--        Modal            -->

<!-- Bootstrap modal -->
<div class="modal fade" id="div_bills" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" id="modal_header" style="background:#00c0ee; color:white; ">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='fa fa-remove fa-sm'></i></span></button>
					<h3 class="modal-title"><b>Edit Bill</b></h3>
			</div>
		
			<div class="modal-body" id="modal-body">
				<form action="#bill_add" id="form_bill_add" name="form_bill_add" class="form-horizontal">
					<div class="form-body">
						<div class="form-group nogap">
							<div class="col-md-3 nogap"></div>
							<div class="col-md-9 nogap" id="errmodal"></div>
						</div>




<!--    **  Modal content    **  
			<form action="<?php echo base_url('store/billcreate/save'); ?>" method="post" id="manage_bill"  class="form-horizontal">
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

						<div id="div_itemid nogap"></div>
								
						<div class="form-group nogap">
							<label class="control-label col-md-2 req nogap">Admission No. :</label>
							<div class="col-md-3 nogap">
								<select class="form-control" name="admission_no" id="admission_no" readonly>
									<option value="" readonly>Select Admission No.</option>
										<?php foreach ($fetch_student as $emp) { ?>
											<option value="<?php echo $emp->admission_no ?>"><?php echo $emp->admission_no ?>
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
										<select class="form-control" name="approve1_comment" id="approve1_comment" value="" required>
											<option value="None">&nbsp;</option>
											<option value="Approved">Approved</option>
											<option value="Rejected">Rejected</option>
										</select>
									</div>
									<label class="control-label col-sm-3 nogap">Approved on :</label>
									<div class="col-sm-3 nogap">
										<input type='text' class="form-control" id="date_approved1" name="date_approved1" value="" readonly>
									</div>
								</div>
								<div class="form-group nogap">
									<label class="control-label col-sm-3 nogap">2nd Approver :</label>
									<div class="col-sm-3 nogap">
										<select class="form-control" name="approve2_comment" id="approve2_comment" value="" required>
											<option value="None">&nbsp;</option>
											<option value="Approved">Approved</option>
											<option value="Rejected">Rejected</option>
										</select>
									</div>
									<label class="control-label col-sm-3 nogap">Approved on :</label>
									<div class="col-sm-3 nogap">
										<input type='input' class="form-control" id="date_approved2" name="date_approved2" value="" readonly>
									</div>
								</div>
								
								<div class="form-group nogap">
									<label class="control-label col-sm-3 nogap">3rd Approver :</label>
									<div class="col-sm-3 nogap">
										<select class="form-control" name="approve3_comment" id="approve3_comment" value="" required>
											<option value="None">&nbsp;</option>
											<option value="Approved">Approved</option>
											<option value="Rejected">Rejected</option>
										</select>
									</div>
									<label class="control-label col-sm-3 nogap">Approved on :</label>
									<div class="col-sm-3 nogap">
										<input type='text' class="form-control" id="date_approved3" name="date_approved3" value="" readonly>
									</div>
								</div>

								<div class="form-group nogap">
									<label class="control-label col-sm-3 nogap">4th Approver :</label>
									<div class="col-sm-3 nogap">
										<select class="form-control" name="approve4_comment" id="approve4_comment" value="" required>
											<option value="None">&nbsp;</option>
											<option value="Approved">Approved</option>
											<option value="Rejected">Rejected</option>
										</select>
									</div>
									<label class="control-label col-sm-3 nogap">Approved on :</label>
									<div class="col-sm-3 nogap">
										<input type='text' class="form-control" id="date_approved4" name="date_approved4" value="" readonly>
									</div>
								</div>
								<!--	<?php } 	?>  -->
							</div>
							<div class="col-md-4 nogap">
								<div class="form-group nogap">
									<label class="control-label col-md-4 nogap" style="float:left;">Remarks :</label>
								</div>
								<div class="col-md-9 nogap">
									<textarea rows="3" class="form-control" id="remarks" name="remarks" value="" placeholder="Enter comments if rejected..."></textarea>
								</div>
							</div>
						</div>
					</div>

					<div class="form-body" id="toapprove_bill_details_div" style="padding-top: 2%">
	
						<table class="table table-bordered" id="toapply_bill_details_tbl">
<!--							<thead>
								<tr><td colspan="6" style="text-align:center;font-size: 18px;border-bottom:1px solid grey">Bill Details</td></tr>
								<tr>
									<th>Item Name</th>
									<th>Regular Price</th>
									<th>Discount (in Rs.)</th>
									<th>Sell Price</th>
									<th>Qty</th>
									<th>Amount</th>
								</tr>
							</thead>		-->
							<tbody>

							</tbody>
						</table>
					</div>
	<!--			</div>	-->

        
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
