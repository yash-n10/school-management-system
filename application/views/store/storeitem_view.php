	<div class="form-group has-feedback">
	<div class="box">
	
		<div class="box-body">
			<div class="col-lg-12">
				<div class="col-lg-6" style="text-align:left;">
					<form id='frm_reptype' role="search" method="POST" action="<?php echo site_url('store/storeitem/get_report')?>">     
						 <p><h4><span style="color:#00acee; font-weight:bold; ">Select a report type:</span></h4></p>
						<input type="radio" name="repStock" <?php if (isset($repStock) && $repStock=="all") echo "checked";?> value="all" style="color:#00acee;" <?php if($rep_type=='all'){ echo "checked=checked";} ?>>
								<label for="all" style="font-size:13px;">&nbsp;&nbsp;All Data</label>
						<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
						<input type="radio" name="repStock" <?php if (isset($repStock) && $repStock=="alert") echo "checked";?> value="alert" <?php if($rep_type=='alert'){ echo "checked=checked";} ?>>
								<label for="alert" style="font-size:13px;">&nbsp;&nbsp;Stock in Red&nbsp;&nbsp;&nbsp;&nbsp;</label>
						<button class="btn btn-warning btn-sm" value="Get Data" onclick="reports()">Get Data</input>
					</form>
				</div>
				<?php if(substr($right_access,0,1)=='C'){?>
				<div class="col-lg-6" style="text-align:center !important;">
						<button class="btn btn-add" id="add_itemdetails"><i class="fa fa-plus-circle fa-lg"></i><strong>&nbsp;Add</strong></button>
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
						<!--		<th style="border-bottom:0px; width:10%; text-align:center !important;">Item ID</th>		-->
								<th>S.No</th>
								<th style="border-bottom:0px; width:25%; text-align:center !important;">Item Name</th>
								<th style="border-bottom:0px; text-align:center !important;">Minimum Quantity</th>
								<th style="border-bottom:0px; text-align:center !important;">Current Quantity</th>
								<th style="border-bottom:0px; text-align:center !important;">Alert</th>
								<th style="border-bottom:0px; text-align:center !important;"> Actual Price</th>
								<th style="border-bottom:0px; text-align:center !important;">Discount (in %)</th>
								<th style="border-bottom:0px; text-align:center !important;">Discount (in Rs.)</th>
								<th style="border-bottom:0px; text-align:center !important;">Action</th>
							</tr>
						</thead>
						<tbody>

							<?php 
							if(isset($arr_store_item) && count($arr_store_item) > 0) {
								$i=0;
							while($i< count($arr_store_item)){ 
							
							?>
								<tr>
					<!--				<td><?php echo $arritem->id; ?></td>				-->
									<td><?php echo $i +1;?></td>
									<td><?php echo $arr_store_item[$i]->item_name; ?></td>
									<td style="text-align:center !important; padding-right:10px;"><?php echo $arr_store_item[$i]->qnty_min; ?></td>
									<?php 
									$item_name=$arr_store_item[$i]->item_name;
									$discount=$this->db->query("SELECT receipt_no,disc_amt,disc_pct,sell_price FROM store_items where item_name='$item_name' ORDER BY id");
									$discount=$discount->result();

									?>
									<td style="text-align:center !important; padding-right:10px;"><?php echo $arr_store_item[$i]->qnty_curr; ?></td>                                    
									<td style="text-align:center !important;"><?php echo $arr_store_item[$i]->qnty_alert; ?></td>
									<td style="text-align:center !important; padding-right:10px;"><?php foreach ($discount as $key) {
										echo "Receipt No : ".$key->receipt_no."<br>Actual Amount:".$key->sell_price."<br><br><br>";
									} ?></td>
									
									<td style="text-align:center !important; padding-right:10px;"><?php foreach ($discount as $key) {
										echo "Receipt No : ".$key->receipt_no."<br>Discount Percentage:".$key->disc_pct."<br><br><br>";
									} ?></td>
									<td style="text-align:center !important; padding-right:10px;"><?php foreach ($discount as $key) {
										echo "Receipt No : ".$key->receipt_no."<br>Discount Amount:".$key->disc_amt."<br>";
									} ?></td>
									<td style="text-align:center !important;">
										<?php 
										if(substr($right_access,2,1)=='U') {?>
											<!-- <a class="btn a-edit" onclick="updateItemDet('<?php echo $arr_store_item[$i]->id; ?>', '<?php echo $arr_store_item->store_type; ?>', '<?php echo $arr_store_item->item_name; ?>', 
																					'<?php echo $arr_store_item[$i]->qnty_min; ?>','<?php echo $arr_store_item[$i]->qnty_curr;?>', '<?php echo $arr_store_item[$i]->sell_price;?>',
																					'<?php echo $arr_store_item[$i]->disc_pct;?>', '<?php echo $arr_store_item[$i]->disc_amt;?>');">
												<i class="fa fa-edit"></i> 
											</a> -->
										<?php }
										if (substr($right_access,3,1)=='D') {?>
											<a class="btn a-delete" data-toggle="modal" onclick="deletes('<?php echo $arritem[$i]->id; ?>');">
												<i class="fa fa-trash-o"></i> 
											</a>
										<?php } ?>         
 									</td>                         
								</tr>
								<?php
								$i++; }
							
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
				
		$('#add_itemdetails').click(function() {
				save_method = 'add';
				$('#fee-box').empty();
				$('#form_itemdetails_add')[0].reset(); 			// reset form on modals
				$('.form-group').removeClass('has-error'); 		// clear error class
				$('.help-block').empty(); 						// clear error string
				$('#div_itemid').empty();
				$('#btn_save').text('Save');
				$('#modal_form').modal('show'); 				// show bootstrap modal
		});


		$('#sellPrice, #discPct').change(function () {
			if($('#sellPrice').val() != '' && $('#discPct').val() != '') //{
				$('#discAmt').val(($('#sellPrice').val() * $('#discPct').val())/ 100);
		});

});


function updateItemDet(id, storetype, itemname, qtymin, qtycurr, sellprice, discpct, discamt) {
		$('#errmodal').empty();
		$('#form_itemdetails_add')[0].reset(); 		// reset form on modals
		$('.form-group').removeClass('has-error'); 	// clear error class
		$('.help-block').empty(); 					// clear error string
		$('#div_itemid').empty();
		$('#div_itemid').append('<div class="form-group"><label class="control-label col-md-3" style="font-size:13px;">ID :</label><div class="col-md-9" id="modal_classid">'+id+'</span></div></div>');
		$('#id').val(id);
		$('#storeType').val(storetype).trigger('change');
		$('#itemName').val(itemname);
		$('#qtyMin').val(qtymin);
		$('#qtyCurr').val(qtycurr);
		$('#sellPrice').val(sellprice);
		$('#discPct').val(discpct);
		$('#discAmt').val(discamt);
		
		globalid = id;
		save_method = 'update';
		$('#btn_save').text('Update');
		$('#modal_form').modal('show');
		return false;
}


function save()
{
		var resp = confirm("Do you want save the record?");
		if (resp == true) 
		{
				$('#btn_Save').text('Saving...'); //change button text
				$('#btn_Save').attr('disabled',true); //set button disable 
        
				var err = '';
				$('#errmodal').empty();

				if($('#itemName').val() == '' || $('#itemName').val() == null) {
                    err = 'Please enter Item Name!';
				}
				if($('#storeType').val() == '' || $('#storeType').val() == null) {
                    err = 'Please enter Store Type!';
				}

				if(err == '') {
					$('#errmodal').empty();
					var url;
					var item_name=$('#itemName').val();
					var qnty_min=$('#qtyMin').val();
					var qnty_curr=$('#qtyCurr').val();
					var sell_price=$('#sellPrice').val();
					var disc_pct=$('#discPct').val();
					var disc_amt=$('#discAmt').val();
					var store_type=$('#storeType').val();
					
					if(save_method == 'add') {
						url = "<?php echo site_url('store/storeitem/add_details')?>";
					} 
					else {
						var modal_classid1=$('#modal_classid').text();
						
						$('#btn_Save').text('updating...');
						url = "<?php echo site_url('store/storeitem/update_details')?>/"+modal_classid1;
					}

					$.ajax
						({
								url : url,
								method: "POST",
								data: 
									{
										store_type:store_type,
										item_name:item_name,
										qnty_min:qnty_min,
										qnty_curr:qnty_curr,
										sell_price:sell_price,
										disc_pct:disc_pct,
										disc_amt:disc_amt
									},
								dataType: "text",
								
								success: function(data) {
									if(data == 1) {
										$('#modal_form').modal('hide');
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


function deletes(id)
{
	var resp = confirm("Do you want to DELETE the record?");
	if (resp == true) 
	{ 
		var del_id = id;
		$.post('<?php echo base_url('store/storeitem/delete_details'); ?>',{del_id:del_id},
				function(data){
						alert('Data Deleted Successfully');
						location.reload();
				}
		);
	}
}


</script>


<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" id="modal_header" style="background:#00acee; color:white; ">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='fa fa-remove fa-sm'></i></span></button>
					<h4 class="modal-title"><b>Store Item Details</b></h4>
			</div>
		
			<div class="modal-body" id="modal-body">
				<form action="#item_details_add" id="form_itemdetails_add" name="form_itemdetails_add" class="form-horizontal">
					<div class="form-body">
						<div class="form-group">
							<div class="col-lg-3"></div>
							<div class="col-lg-9" id="errmodal"></div>
						</div>


						<div id="div_itemid"></div>
						<div class="form-group">
							<label class="control-label col-lg-3" style="font-size:13px;">Store Type :</label>
							<div class="col-lg-4">
								<select id="storeType" name="storeType" class="form-control" value="<?php echo $this->var_role ?>">
									<option value="">-- Select STORE -- </option>
			<!--						<option value="BOOK STORE">BOOK STORE</option>
									<option value="CLOTH STORE">CLOTH STORE</option>
									<option value="">---  Select  ---</option> 		-->
										<?php foreach ($arr_store as $row) { ?>
											<option value="<?php echo $row->storename ?>"><?php echo $row->storename; ?>
										<?php } ?>

								</select>
							<!--	<input id="storeType" name="storeType" class="form-control" type="text" value="">  -->
								<span class="help-block"></span>
							</div>
						</div>
                   
						<div class="form-group">
							<label class="control-label col-lg-3" style="font-size:13px;">Item Name :</label>
							<div class="col-lg-9">
								<input id="itemName" name="itemName" placeholder="" class="form-control" type="text" value="" required>
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-lg-3" style="font-size:13px;">Minimum Quantity :</label>
							<div class="col-lg-3">
								<input id="qtyMin" name="qtyMin" placeholder="" class="form-control" type="number" min="0" oninput="validity.valid||(value='');">
								<span class="help-block"></span>
							</div>
<!--						</div>
                   				<div class="form-group">   -->
							<label class="control-label col-lg-3" style="font-size:13px;">Current Quantity :</label>
							<div class="col-lg-3">
								<input id="qtyCurr" name="qtyCurr" placeholder="" class="form-control" type="number" value="" min="0" oninput="validity.valid||(value='');">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3" style="font-size:13px;">Price :</label>
							<div class="col-md-9">
								<input id="sellPrice" name="sellPrice" placeholder="00.00" class="form-control" type="number" value="" step="0.01" min="0" oninput="validity.valid||(value='');">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3" style="font-size:13px;">Discount (in %) :</label>
							<div class="col-md-9">
								<input id="discPct" name="discPct" placeholder="0" class="form-control" type="number" value="" step="0.01" min="0" oninput="validity.valid||(value='');">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3" style="font-size:13px;">Discount (in Rs.) :</label>
							<div class="col-md-9">
								<input id="discAmt" name="discAmt" placeholder="0.00" class="form-control" type="number" value="" step="0.01" min="0" oninput="validity.valid||(value='');">
								<span class="help-block"></span>
							</div>
						</div>
					</div>
				</form>
			</div>
        
			<div class="modal-footer" id="modal-footer">
				<button type="button" id="btn_save" onclick="save()" class="btn btn-success btn-sm"><strong> Save </strong></button>
				<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>