<style>
	.caption {
			border:1px solid white; 
			text-align:center;
	}
</style>


<div class="form-group has-feedback">
	<div class="box box-primary">
		<div class="box-body">
			<div class="col-sm-12">
				<div class="box-body">
	 
					<form id="formm">
						<table class="table table-borderless">
						<tr  style="border:none; height:20px;">
							<td><b>Issued To : </b></td>
							<td>
								<select class="form-control" name="admission_no" id="admission_no" required>
									<option value="">---  STUDENT  ---</option>
										<?php foreach ($fetch_student as $emp) { ?>
											<option value="<?php echo $emp->admission_no; ?>"><?php echo $emp->admission_no; ?>
										<?php } ?>
									<option value="">---  STAFF  ---</option>
									<?php foreach ($employee as $value) { ?>
											<option value="<?php echo 'staff'.$value->employee_code; ?>"><?php echo $value->employee_code.'-'.$value->name; ?>
										<?php } ?>
								</select>
							</td>
							<td></td>
							<td style="text-align:right;"><b>Name : </b></td>
							<td colspan="3">
								<input type="text" class="form-control" id="student_fname" name="student_fname" placeholder="" readonly />
							</td>
							<td class="control-label col-sm-1" required><b>Bill Date :</b></td>
							<td colspan="2">
								<input type='date' class="form-control" id="bill_date" name="bill_date" value="<?php echo date('Y-m-s H:i:s'); ?>" required>
							</td>
						</tr>
						</table>
						<table class='table dTable' style="padding:none;" id='mytbl'>
		   
							<tr style="background:#00c0ee; color:white">
								<th class="caption" style="width:30%;" name="pro" >Item Name</th>
								<th class="caption">Regular Price</th>
								<th class="caption">Discount</th>
								<th class="caption">Sell Price</th>
								<th class="caption">Qty Received</th>
								<th class="caption">Amount</th>
								<th class="caption" style="width:5%; padding:0px; background: white"><button type="button" class='btn btn-warning' onclick='add()'>
										<i class="fa fa-plus fa-lg"></i></button></th>
				<!--				<th><button type="button" class='btn btn-warning' style="border: 1px solid white; align:center; padding:0px; background: white" title="Add Bill Item" onclick='add()'>
										<i class="fa fa-plus fa-md"></i><strong>&nbsp;Add</strong>  -->
									</button></th>
							</tr>
						</table>
						
						<table class='table'>
							<tr>
								<td>Grand Total: <span id="grandtotal"></span> </td>
							</tr>
							<tr>
								<td colspan='6' align='center'>
									<button type="button" class="btn btn-success" onclick='save()'>Save Records</button>
									<button type="button" class="btn btn-danger" onclick='goBack()'>Cancel</button>
								</td>
								
							</tr> 
						</table>
					</form>
				</div>
			</div>
		</div>
  
		<div id="reqbox" style="display:none;">
			<div class="box-body" id="adddata"></div>
		</div>
	</div>  
</div>


<script>
	var globalid = '';
	var url = "<?php echo base_url();?>";
	var newtxt = 1000;
	var cnt = 0;

//** Store all STORE ITEMS at a place on the page, for example, you can pass PHP variable into JS variable like this
	var sitems = <?= json_encode($arr_items); ?>;

	
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
					url: '<?php echo base_url('store/billcreate/get_student_information'); ?>',
					data: {code: $(this).val()},
					type: 'POST',
					dataType: 'JSON',
					success: function (data)
					{
						$.each(data, function (index, element)
						{
							// alert(element);
							$('#student_fname').val(element['first_name'] + ' ' + element['middle_name'] + ' ' + element['last_name']);
						});
					},

					error: function () {
						alert('error');
					}
					});
			});

			$('#pro').change(function () {
				alert('hHHHh');
				$.ajax({
					url: '<?php echo base_url('store/billcreate/get_item_information'); ?>',
					data: {code: $(this).val()},
					type: 'POST',
					dataType: 'JSON',
					success: function (data)
					{
						$.each(data, function (index, element)
						{
							$('#add1[index]').val(element['curr_qnty']);
							$('#add2[index]').val(element['curr_qnty']);
						});
					},

					error: function () {
						alert('error');
					}
					});
			});
			
	/*		$('#item_id').on('change', function (e) {
				alert('hhhhhhjji');

        		var selectedItem = getItemById($(e.target).find('option:selected').text());
				alert($(e.target).find('option:selected').text());

        		if (getItemById) {
           			$('#add1').val(selectedItem.sell_price);
	        	} else {
            			alert("Sorry, we can find description for this book");
        		}
			});

			$('#qty, #discamt').change(function () {
				if($('#qty').val() != '' && $('#finalprice').val() != '') //{
					$('#total').val($('#finalprice').val() * $('#qty').val());
		});
*/
	});


	function get_priceDet() {
		if($('#qty').val() != '' && $('#finalprice').val() != '') //{
				$('#total').val(($('#finalprice').val() * $('#qty').val()).toFixed(2));
	}
	
	
//* Create function for search ITEM  by its NAME  --- ITEM NAME field MUST BE UNIQUE
	var getItemByName = function (itemname) {
    		if (typeof sitems === 'object') {
       			 for (var key in sitems) {
           				 if (sitems[key].item_name !== 'undefined' && sitems[key].item_name  === arg_name) {
               					 return sitems[key];
           				 }
       			 }
   		 }
   		 return false;
	}

/** This Funtion using for add row in table on click button.*/
	function add() {
			cnt++;
//			var value = "<tr class='item_row' id='id_"+cnt+"'><td class='items' style='padding:0px;'>   <select class='form-control item_id' name='pro[]' id='item_id_"+cnt+"' required>      <option value=''>Select</option>      <?php foreach($arr_store_item as $data){ ?>      <option value='<?php echo $data->id; ?>'><?php echo $data->item_name; ?></option>      <?php } ?>   </select></td><td class='item_saleprice' style='padding:0px;'>	<input type='text' id='saleprice_"+cnt+"' name='sprice[]' class='form-control saleprice' style='text-align:right;padding-right:10px' value='' readonly></td><td id='item_disc' style='padding:0px;'><input type='text' name='disc[]' id='discamt_"+cnt+"' class='form-control discamt' style='text-align:right;padding-right:10px' readonly></td><td id='item_fprice_"+cnt+"' style='padding:0px;'><input type='text' name='fprice[]' id='finalprice_"+cnt+"' class='form-control finalprice' style='text-align:right;padding-right:10px' readonly></td><td id='item_qty_"+cnt+"' style='padding:0px;'><input type='number' name='qty[]' id='qty_"+cnt+"' class='form-control qty' style='text-align:right;padding-right:10px' min='0' oninput='validity.valid||(value=&quot;&quot;);' onchange='get_priceDet();' required></td><td id='item_total_"+cnt+"' style='padding:0px;'><input type='text' name='total[]' id='total_"+cnt+"' class='form-control total' style='text-align:right;padding-right:10px' readonly></td><td  style='padding:0px; text-align:center; color:red; cursor:pointer' onclick='rmv(this)'><i class='fa fa-remove fa-sm'></i></td></tr>";

			var value = "<tr class='item_row' id='id_"+cnt+"'><td class='items' style='padding:0px;'>   <select class='form-control item_id' name='pro[]' id='item_id_"+cnt+"' required>      <option value=''>Select</option>      <?php foreach($arr_store_item as $data){ ?>      <option value='<?php echo $data->id; ?>'><?php echo $data->item_name.'<br> Receipt No:'.$data->receipt_no; ?></option>      <?php } ?>   </select></td><td class='item_saleprice' style='padding:0px;'>	<input type='text' id='saleprice_"+cnt+"' name='sprice[]' class='form-control saleprice' style='text-align:right;padding-right:10px' value='' ;></td><td id='item_disc' style='padding:0px;'><input type='text' name='disc[]' id='discamt_"+cnt+"' class='form-control discamt' style='text-align:right;padding-right:10px' ></td><td id='item_fprice_"+cnt+"' style='padding:0px;'><input type='text' name='fprice[]' id='finalprice_"+cnt+"' class='form-control finalprice' style='text-align:right;padding-right:10px' ></td><td id='item_qty_"+cnt+"' style='padding:0px;'><input type='number' name='qty[]' id='qty_"+cnt+"' class='form-control qty' style='text-align:right;padding-right:10px' min='1' oninput='validity.valid||(value=&quot;&quot;);' onchange='get_priceDet();' required></td><td id='item_total_"+cnt+"' style='padding:0px;'><input type='text' name='total[]' id='total_"+cnt+"' class='form-control total' style='text-align:right;padding-right:10px' ></td><td  style='padding:0px; text-align:center; color:red; cursor:pointer' onclick='rmv(this)'><i class='fa fa-remove fa-sm'></i></td><input type='hidden' name='curr[]' id='curr_"+cnt+"' class='form-control curr'></tr>";



		
			



			/* This function work on change of Item Name Drop down.*/
			$(function(){
				$('#item_id_'+cnt).on("change",function(){
					item_id = $(this).val();
					if(item_id!="")
					{
						controller_url = "<?php echo base_url('store/Billcreate/fetch_item_details');?>";
						$.ajax({
				       			url: controller_url,
								method: "POST",
								data: {item_id:item_id},
				        
								success: function (data) {
									var myObj = $.parseJSON(data);
									mrp_sele_price = myObj.sell_price;	
									disc_amt = myObj.disc_amt;
									qnty_curr = myObj.qnty_curr;
									sale_price = parseFloat(mrp_sele_price - disc_amt);
									$('#saleprice_'+cnt).val(mrp_sele_price);
									$('#discamt_'+cnt).val(disc_amt);
									$('#finalprice_'+cnt).val(sale_price);
									$('#curr_'+cnt).val(qnty_curr);
								}
				        });
					}
				});
			});
			$(function(){
$('#saleprice_'+cnt).on('change',function(){
				var final=$('#saleprice_'+cnt).val() -$('#discamt_'+cnt).val() ;
				// alert($('#finalprice_'+cnt).val());
				// alert(final);
				$('#finalprice_'+cnt).val(final);
			});
			});
			$(function(){
$('#discamt_'+cnt).on('change',function(){
				var final=$('#saleprice_'+cnt).val() -$('#discamt_'+cnt).val() ;
				// alert($('#finalprice_'+cnt).val());
				// alert(final);
				$('#finalprice_'+cnt).val(final);
			});
			});
			$(function(){
				$('#qty_'+cnt).on('change',function(){
					if (($('#curr_'+cnt).val() - $(this).val()) < 0){
						alert($('#curr_'+cnt).val());
						$(this).val(0);
					}
					else {
						final_price = $('#finalprice_'+cnt).val();
						qty = $(this).val();
						ttl = final_price * qty;
						$('#total_'+cnt).val(ttl);
						calculatetotal();
					}
			});
			});		

			$("#mytbl").append(value);
			//$("#mytbl").attr("id", "id_" + cnt);
		}

		 $(function(){
      calculatetotal();
    });

			

	/*Grand Total of Bill */
    function calculatetotal(){
			var sum = 0;
			$(".total").each(function(){
				sum += +$(this).val();
			});
			$("#grandtotal").text(sum);
    }


	function rmv(arg) {
			$(arg).parent('tr').remove();
			calculatetotal();
	}

	
	function goBack() {
			var resp = confirm("Do you want to CANCEL the operation?");
			if (resp == true)
				window.location='/store/billcreate';
	}


	function save() {
			if(!$('#formm')[0].checkValidity()) {
					$(this).show();
					$("#formm")[0].reportValidity();
					return false;		
			}
			else {
					url = "<?php echo site_url('store/billcreate/saveRecs')?>";
					$.ajax
					({
							url : url,
							method: "POST",
							data: $("#formm").serialize(),
							dataType: "text",
								
							success: function(data) {
								if(data == 1) {
									alert('Records created Successfully !');
									window.location='/store/billcreate';
								}
								if(data == 0) {
									alert('Please add data first !');
									window.location.reload();
								}
							}
					});
			}
	}

</script>
