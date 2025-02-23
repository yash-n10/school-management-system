<div class="form-group has-feedback" style="overflow-x:scroll;">
<!-- 	<div class="box box-primary">
		<div class="box-body">
			<div class="col-sm-12">
				<div class="box-body"> -->
	 
					<form id="formm">
<!--						<table class="table">
							<tr>
								<td colspan='4' align='right'>
									<button type="button" class='btn btn-warning' onclick='add()'>
										<i class="fa fa-plus-circle fa-lg"></i><strong>&nbsp;Add</strong>
									</button></td>
							</tr>
						</table>
-->		  
						<table class='table table-striped dTable'  id='mytbl'>
							<tr style="background:#00c0ee; color:white; padding:1px;">
								<th style=" border: 1px solid white;text-align: center; ">Item Name</th>
								<th style="">Store</th>
								<th style=" border: 1px solid white; text-align: center; ">Receipt No</th>
								<th style=" border: 1px solid white; text-align: center; ">Supplier Name</th>
								<th style=" border: 1px solid white; text-align: center; ">Rate</th>
								<th style=" border: 1px solid white; text-align: center; ">Work Order No</th>
								<th style=" border: 1px solid white; text-align: center; ">Supplier Invoice No</th>
								<th style=" border: 1px solid white; text-align: center; " >Qty Received</th>
								<th style=" border: 1px solid white; text-align: center; " >Unit</th>
								<th style=" border: 1px solid white; text-align: center; ">Amount</th>
								<th style=" border: 1px solid white; text-align: center;">Discount Percentage</th>
								<th style=" border: 1px solid white; text-align: center;">Discount Amount</th>
								<th style=" border: 1px solid white; text-align: center; ">Receipt Date</th>

								<th style=" border: 1px solid white;  padding:0px; background: white"><button type="button" class='btn btn-warning' onclick='add()'>
										<i class="fa fa-plus fa-lg"></i></button></th>
							</tr>
						</table>
						
						<table class='table'>
							<tr>
								<td colspan='3' align='center'><button type="button" class='btn btn-success' onclick='save()'>Save Records</button></td>
							</tr> 
						</table>
					</form>
				
		
  
		<!-- <div id="reqbox" style="display:none;"> -->
			<!-- <div class="box-body" id="adddata"></div> -->
		
</div>
 

<script>

	function add() {
			var value = "<tr style='padding:0px;'>	<td style='padding:0px;  '><select  name='pro[]' required><option value=''>Select</option><?php foreach($arr_store_item as $data){ ?><option value='<?php echo $data->item_name; ?>'><?php echo $data->item_name; ?></option><?php } ?></select></td><td style='padding:0px; '><select  name='store[]' required><option value=''>Select</option><option value='BOOKSTORE'>BOOKSTORE</option><option value='CLOTHSTORE'>CLOTHSTORE</option></select></td>	<td style='padding:0px; '><input type='text' name='receipt_no[]'  required></td>	<td style='padding:0px; '><input type='text' name='supplier_name[]'  required></td>	<td style='padding:0px; '><input type='number' name='rate[]' id='rate[]'  required></td>		<td style='padding:0px; '><input type='text' name='work_order[]'  required></td>	<td style='padding:0px; '><input type='text' name='supplier_invoice[]'  required></td>	<td style='padding:0px; '><input type='number' name='qty[]' id='qty[]'   min='0' oninput='validity.valid||(value=&quot;&quot;);'  onchange='yash(this)' required></td><td style='padding:0px; '><input type='text' name='unit[]' id='unit[]'   min='0' oninput='validity.valid||(value=&quot;&quot;);'  onchange='yash(this)' required></td><td style='padding:0px; '><input type='number' name='amount[]'  required></td><td style='padding:0px;'><input type='number' name='disc_pct[]'  required></td><td style='padding:0px; '><input type='number' name='disc_amt[]'  required></td><td style='padding:0px; '><input type='date'  name='date_received[]'  required value=<?php echo date('Y-m-d'); ?>></td>	<td style='color:red; cursor:pointer' onclick='rmv(this)'><i class='fa fa-remove fa-sm'></i></td></tr>";
			$("#mytbl").append(value);
	}

	function rmv(arg) {
			$(arg).parent('tr').remove();
	}
	
	function save() {
				if(!$('#formm')[0].checkValidity()) {
						$(this).show();
						$("#formm")[0].reportValidity();
						return false;		
				}
				else {
						url = "<?php echo site_url('store/addqty/saveRecs')?>";

						$.ajax
						({
								url : url,
								method: "POST",
								data: $("#formm").serialize(),
								dataType: "text",
								success: function(data) {
								// alert(data);
								console.log(data);
									if(data == 1) {
										alert('Records updated Successfully !');
										// window.location='/store/storeitem';
									}
									if(data == 0) {
										alert('Please add data first !');
										// window.location.reload();
									}
								}
						});
				}
	}
	
	
</script>
