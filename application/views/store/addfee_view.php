<div class="form-group has-feedback">
	<div class="box box-primary">
		<div class="box-body col-lg-12">
			<div class="col-sm-2">					
				<button class="btn btn-add" id="go_back" title="Go Back" onclick="goBack();"><i class="fa fa-chevron-circle-left fa-lg"></i><strong>&nbsp;Back</strong></button>
			</div>
			<div class="col-sm-9">
				<div class="box-body">
	 
					<form id="formm">
						<table class='table table-striped dTable' style="border-collapse: collapse;" id='mytbl'>
							<tr style="background:#00c0ee; color:white; padding:1px;">
								<th style="width:20%; border: 1px solid white; align:center;">Date</th>
								<th style="width:40%; border: 1px solid white; align:center;">Admission No.</th>
								<th style="width:15%; border: 1px solid white; align:center;">Tution Fee</th>
								<th style="width:5%; border: 1px solid white; align:center; padding:0px; background: white"><button type="button" class='btn btn-warning' onclick='add()'>
										<i class="fa fa-plus fa-lg"></i></button></th>
							</tr>
						</table>
						
						<table class='table'>
							<tr>
								<td colspan='3' align='center'><button type="button" class='btn btn-success' onclick='save()'>Save Records</button></td>
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

	function add() {
			var value = "<tr style='padding:0px;'><td style='padding:0px;'><input type='date' class='form-control' name='date_received[]'  required value=<?php echo date('Y-m-d'); ?>></td><td style='padding:0px;'><select class='form-control' name='pro[]' required><option value=''>Select</option><?php foreach($arr_students as $data){ ?><option value='<?php echo $data->admission_no; ?>'><?php echo $data->admission_no . ' :: ' . $data->first_name . ' ' . $data->middle_name . ' ' . $data->last_name; ?></option><?php } ?></select></td><td style='padding:0px;'><input type='number'  min='0' oninput='validity.valid||(value=&quot;&quot;);' name='qty[]' class='form-control' required></td><td style='color:red; cursor:pointer' onclick='rmv(this)'><i class='fa fa-remove fa-sm'></i></td></tr>";
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
						url = "<?php echo site_url('store/addfee/saveRecs')?>";

						$.ajax
						({
								url : url,
								method: "POST",
								data: $("#formm").serialize(),
								dataType: "text",
								
								success: function(data) {
									if(data == 1) {
										alert('Records saved Successfully !');
										window.location='/store/addfee';
									}
									if(data == 0) {
										alert('Please add data first !');
										window.location.reload();
									}
								}
						});
				}
	}
	
	function goBack() {
		window.location='/store/addfee';
	}

</script>
