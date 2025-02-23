<style type="text/css">
	.vertical-menu {   
		height: 350px;
		overflow-y: auto;
	}
	.size35{
		width:20px !important;
	}
</style>
<div class="form-group has-feedback">
	<div class="box box-primary">
		<div class="box-body">
			<div class="col-lg-8 col-lg-offset-2" id="successMessage" <?php if ($this->session->flashdata('successmsg')) { ?> style="padding: 10px 20px;background: #CCF5CC;text-align:center" <?php } ?>> <?php echo $this->session->flashdata('successmsg'); ?></div>
			<div class="col-lg-2">

			</div>
		</div>
		<form id="form_add" class="form-horizontal" name="form_add" method="post" action="<?php echo site_url('communication/Sms_Notification/save') ?>">

			<div class="box-body">
				<div class="col-md-12" >
					<fieldset>
						<legend style="border-bottom: 1px solid #00a65a;">SMS Configuration</legend>

						<div class="table-responsive" >
							<table class="table table-bordered table-striped" id="permission_tbl" style="width:100%">
								<thead>
									<tr>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th colspan="3" style="text-align: right">
											<a href="javascript:add_otherrow();" class="btn btn-icon-only green" style="padding: 4px 12px;height: 25px;width: 25px;margin-left: 20%;padding-left: 6px;"><i class="fa fa-plus "></i></a>
										</th>
									</tr>
									<tr>
										<th>Page</th>
										<th>SMS <input type="checkbox" class="col-master"></th>
										<th>Email <input type="checkbox" class="col-master"></th>
										<th>Mode</th>
										<th>Action</th>
										<th>Message</th>
										<th class="size35"></th>
										<th class="size35"></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($sms_notification as $val) { ?>
                                   <tr>
										<td> 
											<select class="form-control" id="page" name="page[]"  required autofocus>
												<option value="">Select Page</option>
												<?php foreach ($link as $key => $value) {
													$tabs = ($value->level != 1) ? str_repeat("&nbsp;", 10 * $value->level * $value->level) : '';
													if (($value->children_status == 'TRUE' && $value->parent_node == 0 ) || $value->level == 1) {
														$trcolor = 'background-color:#cddc3963';
													} elseif ($value->children_status == 'TRUE' && $value->level >= 2) {
														$trcolor = 'background-color:#eabdbac2';
													} else {
														$trcolor = '';
													}
													?>                                           
													<option value="<?php echo $value->id ?>" <?php if ($val->link_code == $value->id) echo 'selected="selected"'; ?>><?php echo $value->l_name; ?></option>
												<?php } ?>
											</select>
										</td>
										<td><input type="checkbox" class="checkbox child" value="YES" name="SY[]" id="c" <?php if (($val->sms)=='YES'){echo 'checked';}else { }?>>
										</td>
										<td><input type="checkbox" class="checkbox child" value="YES" name="MY[]" id="d" <?php if (($val->mail)=='YES'){echo 'checked';}else { }?>>
										</td>
										<td><select class="form-control" id="mode" name="mode[]" required autofocus>
											<option value="">Select Mode</option>
											<option value="AUTO" <?php if ($val->sms_mode == "AUTO") echo 'selected="selected"'; ?>>Automatic</option>
											<option value="MANUAL" <?php if ($val->sms_mode == "MANUAL") echo 'selected="selected"'; ?>>Manual</option>
										</td>
										<td>
											<select class="form-control" id="activity" name="activity[]" required autofocus>
												<option value="">Select Action</option>
												<?php foreach ($sms_type_master as $key => $value) { ?>
													<option value="<?php echo $value->sms_type_code ?>" <?php if ($val->activity == $value->sms_type_code) echo 'selected="selected"'; ?>><?php echo $value->sms_type_name; ?></option>
												<?php } ?>
											</select>
										</td>
										<td><textarea row="20" column="30"></textarea></td>
									
									<td onclick='rvo(this)' class='size35'><a style='color:red' class='pointer'><strong>X</strong></a>
									</td>

									<input type="hidden" id="idd" name="idd[]" value="<?php echo $val->id; ?>">
								</tr>  
                                    <?php } ?>
									<tr>
										<td> 
											<select class="form-control" id="page" name="page[]"  required autofocus>
												<option value="">Select Page</option>
												<?php foreach ($link as $key => $value) {
													$tabs = ($value->level != 1) ? str_repeat("&nbsp;", 10 * $value->level * $value->level) : '';
													if (($value->children_status == 'TRUE' && $value->parent_node == 0 ) || $value->level == 1) {
														$trcolor = 'background-color:#cddc3963';
													} elseif ($value->children_status == 'TRUE' && $value->level >= 2) {
														$trcolor = 'background-color:#eabdbac2';
													} else {
														$trcolor = '';
													}
													?>                                           
													<option value="<?php echo $value->id ?>"><?php echo $value->l_name; ?></option>
												<?php } ?>
											</select>
										</td>
										<td><input type="checkbox" class="checkbox child" value="YES" name="SY[]" id="c" >
										</td>
										<td><input type="checkbox" class="checkbox child" value="YES" name="MY[]" id="d">
										</td>
										<td><select class="form-control" id="mode" name="mode[]" required autofocus>
											<option value="">Select Mode</option>
											<option value="AUTO">Automatic</option>
											<option value="MANUAL">Manual</option>
										</td>
										<td><select class="form-control" id="activity" name="activity[]" required autofocus>
											<option value="">Select Action</option>
											<?php foreach ($sms_type_master as $key => $value) { ?>
													<option value="<?php echo $value->sms_type_code ?>"><?php echo $value->sms_type_name; ?></option>
												<?php } ?>
										</select>
									</td>
									
									<td onclick='rvo(this)' class='size35'><a style='color:red' class='pointer'><strong>X</strong></a>
									</td>
								
									<input type="hidden" id="idd" name="idd[]" value="<?php echo $value->id; ?>">
								</tr>  
							</tbody>
						</table>	
					</div>  			  
				</fieldset>
			</div>
		</div> 
		<div class="box-body">
			<div class="table-responsive">
				<div class="col-md-12">
					<div class="col-md-4 col-md-offset-1"></div>
					<div class="col-md-4" style="margin: 49px 0px 0px 42px;">       
						<button id="butt" class="btn btn-success" type="submit">SAVE</button>               
					</div>
					<div class="col-md-4 col-md-offset-1"></div>
				</div>
			</div>
		</div>
	</form> 
</div>
</div>

<script>
	$(document).ready(function () {

		$("#modu").click(function () {
			$(".checkbox").prop('checked', $(this).prop('checked'));
		});

		$(".checkbox").change(function () {
			if (!$(this).prop("checked")) {
				$("#modu").prop("checked", false);
			}
		});

		var table = $('#permission_tbl').DataTable({
			"scrollX": true,
			"scrollY": "400px",
			"scrollCollapse": true,
			"paging": false,
			"searching": false,
			"ordering": false
		});
		$('#permission_tbl tbody')
		.on('click', 'td', function () {
			var colIdx = table.cell(this).index().row;
			$('.highlight').removeClass('highlight');
			$(table.row(colIdx).nodes()).addClass('highlight');
		});
	});

</script>

<script type="text/javascript">
	$('.col-master').click(function () {
		var idx = $(this).parent().index();
		$('table td:nth-child(' + (idx + 1) + ') input.child').prop('checked', this.checked)
	})

	$('.row-master').click(function () {
		$(this).closest('tr').find('input.child').prop('checked', this.checked);
		var node = $(this).attr('data-node');
		var parent = $(this).attr('data-parent');
		$('input.child[data-parent=' + node + ']').prop('checked', this.checked);
		$('input.child[data-node=' + parent + ']').prop('checked', $('input.child[data-parent=' + parent + ']:checked').length != 0);
	});

	$('.child').change(function () {
		var $tr = $(this).closest('tr');
		$tr.find('input.row-master').prop('checked', $tr.find('.child').not(':checked').length == 0);

		var idx = $(this).parent().index(), $tds = $('table td:nth-child(' + (idx + 1) + ')');
		$tds.find('input.col-master').prop('checked', $tds.find('input.child').not(':checked').length == 0);

		var value = $(this).val();
		var node = $(this).attr('data-node');
		var parent = $(this).attr('data-parent');
		$('input.child[data-parent=' + node + '][value=' + value + ']').prop('checked', this.checked);
		$('input.child[data-node=' + parent + '][value=' + value + ']').prop('checked', $('input.child[data-parent=' + parent + '][value=' + value + ']:checked').length != 0);
	});

	function rv(abc) {
		$(abc).parent('tr').remove();
	}

	function rvo(abc) {
		rv(abc);
	}

	function add_otherrow() {
		var row = "<tr><td><select class='form-control' id='page' name='page[]'  required autofocus><option value=''>Select Page</option><?php foreach ($link as $key => $value) {$tabs = ($value->level != 1) ? str_repeat('&nbsp;', 10 * $value->level * $value->level) : '';if (($value->children_status == 'TRUE' && $value->parent_node == 0 ) || $value->level == 1) { $trcolor = 'background-color:#cddc3963';} elseif ($value->children_status == 'TRUE' && $value->level >= 2) {$trcolor = 'background-color:#eabdbac2';} else {$trcolor = '';}?><option value='<?php echo $value->id ?>'><?php echo $value->l_name; ?></option> <?php } ?> </select></td><td><input type='checkbox' class='checkbox child' value='YES' name='SY[]' id='c' data-node='<?php echo $value->id; ?>' data-level='<?php echo $value->level; ?>' data-parent='<?php echo $value->parent_node; ?>'></td><td><input type='checkbox' class='checkbox child' value='YES' name='MY[]' id='d' data-node='<?php echo $value->id; ?>' data-level='<?php echo $value->level; ?>' data-parent='<?php echo $value->parent_node; ?>'></td>	<td><select class='form-control' id='mode' name='mode[]' required autofocus><option value=''>Select Mode</option><option value='AUTO'>Automatic</option><option value='MANUAL'>Manual</option></td>	<td><select class='form-control' id='activity' name='activity[]' required autofocus><option value=''>Select Action</option><?php foreach ($sms_type_master as $key => $value) { ?><option value='<?php echo $value->sms_type_code ?>'><?php echo $value->sms_type_name; ?></option><?php } ?></select></td> <td onclick='rvo(this)' class='size35'><a style='color:red' class='pointer'><strong>X</strong></a></td><input type='hidden' id='idd' name='idd[]' value='<?php echo $value->id; ?>'></tr>  "
		$("#permission_tbl").append(row);
		$('select').select2({width: '100%', theme: "classic"});

	}


</script>
