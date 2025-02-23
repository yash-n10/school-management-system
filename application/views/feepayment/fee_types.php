<div class="form-group has-feedback" id='loaddiv'>
	<div class="box">
		<div class="box-body">
			<div class="col-lg-12">
				<div class="col-lg-12" style="text-align:right;">
					<?php
//if (!$read_only) {
					if (substr($right_access, 0, 1) == 'C') {
						?>
						<button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#importBook">Import Text Book</button>

						<button class="btn btn-add" id="add_record" title="Add <?= $rec_type ?>">
							<i class="fa fa-plus-circle fa-lg"></i>&nbsp;
						</button>
						<?php
					}
					?>
                    <!----<a class="btn btn-success" href='<?= base_url() . uri_string() ?>/help'>
                    <i class="fa fa-question-circle fa-lg"></i>&nbsp;<?= $rec_type ?> Help
                </a>---->
                <a class="btn btn-export" href='/<?= uri_string() ?>/exportcsv' download title="<?= $rec_type ?> Export CSV">
                	<i class="fa fa-cloud-download fa-lg"></i>&nbsp;
                </a>
            </div>
        </div>
    </div>

    <div class="box-body">
    	<form id='frmclass' role="form" method="POST">
    		<div class="table-responsive">
    			<table id="datalist" class="table table-bordered table-striped">
    				<thead style="background:#99ceff;">
    					<tr>
    						<?php
    						$colcnt = 0;
    						$hiddencols = array();
    						foreach ($display_columns as $field => $disp) {
    							echo "\t\t\t\t\t\t\t\t<th style='border-bottom:0px'>$disp</th>\n";
    							$colcnt++;
    						}
    						?>
    						<th style="border-bottom:0px">Actions</th>
    					</tr>
    				</thead>
    				<thead style="background: #cce6ff">
    					<tr id="searchhead">
    						<?php
    						$colcnt1 = 0;
    						foreach ($display_columns as $field => $disp) {
    							?>
    							<th style="border-bottom:2px solid darkcyan;border-top:0px">
    								<i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="<?php echo $colcnt1; ?>"/>
    							</th>

    							<?php
    							$colcnt1++;
    						}
    						?>
    						<th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
    					</tr>
    				</thead>
    				<tbody>
    					<?php
    					if (isset($data) && count($data) > 0) {
    						foreach ($data as $rec) {
    							echo "\t\t\t\t\t\t\t<tr>\n";
    							foreach ($display_columns as $field => $disp) {
    								echo "\t\t\t\t\t\t\t\t<td id='{$field}-{$rec->$rec_key}'>{$rec->$field}</td>\n";
    							}
    							?>
    							<td>
    								<?php
//if (!$read_only) {
    								?>      
    								<?php if (substr($right_access, 2, 1) == 'U') { ?>
    									<a class="btn a-edit" onclick="edit_rec('<?= $rec->$rec_key ?>');"><i class="fa fa-edit"></i></a>
    								<?php } ?>
    								<?php if (substr($right_access, 3, 1) == 'D') { ?>
    									<a class="btn a-delete" data-toggle="modal" onclick="delete_rec('<?= $rec->$rec_key ?>');"><i class="fa fa-trash"></i></a>
    								<?php } ?>
    								<?php
//}
    								?>
    								<?php if (isset($edit_columns['lat']) && isset($edit_columns['long'])) { ?>
    									<a class="btn" target='_blank' href='https://www.google.com/maps/place/<?= $rec->location_description ?>/@<?= $rec->lat ?>,<?= $rec->long ?>,8z'><i class="fa fa-map"></i>Map</a>
    								<?php } ?>
    							</td>                                                                                                                                                                     
    						</tr>
    						<?php
    					}
    				}
    				?>
    			</tbody>
    			<tfoot>
    			</tfoot>
    		</table>
    	</div>
    </form>
</div>
<!-- /.box-body -->
</div>
<!-- /.box -->
</div>

<script>
	var globalid = '';
	var url = "<?php echo base_url(); ?>";
	var newtxt = 1000;

	$(document).ready(function () {
		$('#add_record').click(function () {
			<?php if (!$modal_form['status']) { ?>
				window.location.href = '<?php echo base_url(); ?>' + '<?= uri_string() . '/add_form' ?>';

			<?php } else { ?>
				save_method = 'add';
                $('#form')[0].reset(); // reset form on modals
                $('#errmodal').empty();
                $('.form-group').removeClass('has-error'); // clear error class
                $('.help-block').empty(); // clear error string
                $('select').trigger('change');
                $('#modal_form').modal('show'); // show bootstrap modal
                $('.modal-title').text('Add <?= $rec_type ?>'); // Set Title to Bootstrap modal title
            <?php } ?>
        });
		var table = $('#datalist').DataTable({
			"paging": true,
			"lengthChange": true,
			"searching": true,
			"ordering": true,
			"info": true,
			"autoWidth": false,
			"columnDefs": [
			<?php
			foreach ($hiddencols as $col) {
				echo "\t\t{\n";
				echo "\t\t\t\"targets\": [ $col ],\n";
				echo "\t\t\t\"visible\": false,\n";
				echo "\t\t},\n";
			}
			?>
			],
			serverSide: true,
			ajax: {
				url: '<?php echo base_url(); ?>' + '/<?= uri_string() . '/paged_data' ?>',
				type: 'POST'
			},
		});

		$('#searchhead th input').on('keyup change', function () {
//            if ( this.search() !== this.value ) {
//                this
//                    .search( this.value )
//                    .draw();
//            }
var i = $(this).attr('data-column');
var v = $(this).val();
table.columns(i).search(v).draw();
});



		$('#fee_cat_id').change(function () {
			if (this.value == 2 || this.value == '' || this.value == 1  || this.value == 8) {
				$('#checkbox_div_month_set').css('display', 'none');

			} else {
				$('#checkbox_div_month_set').css('display', 'block');
				$('input[type="checkbox"][name="month_set[]"]').each(function () {
					$(this).prop("checked", false);
					$(this).removeAttr('disabled');
				});
			}

			if(this.value==2 || this.value==1 || this.value==5) {

				$('#radio_div_fee_type').css('display', 'block');
			}else{
				$('#radio_div_fee_type').css('display', 'none');
			}
		});


		$('#checkbox_div_month_set').change(function () {
			var count = $('input[type="checkbox"][name="month_set[]"]:checked').length;
			if (count >= 2 && $('#fee_cat_id').val() == 4) {
				$('input[type="checkbox"][name="month_set[]"]:not(":checked")').each(function () {
					$(this).prop('disabled', 'true');
				});
			} else {
				$('input[type="checkbox"][name="month_set[]"]:not(":checked")').each(function () {
					$(this).removeAttr('disabled');
				});
			}
		});

	});

	<?php
	if (!$read_only) {
		?>

		function edit_rec(id) {

			<?php if (!$modal_form['status']) { ?>
				window.location.href = '<?php echo base_url(); ?>' + '<?= uri_string() . '/edit_form/' ?>' + id;

			<?php } else { ?>

				$('#errmodal').empty();
				$('#form')[0].reset();
                $('.form-group').removeClass('has-error'); // clear error class
                $('.help-block').empty(); // clear error string
                $.ajax({
                	url: "<?php echo base_url(); ?>/<?= uri_string() . '/getrec/' ?>" + id,
                	type: "POST",
                	dataType: "json",
                })
                .done(function (msg) {
                	console.log(msg);
                	<?php
                	foreach ($edit_columns as $col => $colparams) {
                		if ($colparams['type'] == 'select') {
                			echo "\t\t\t\tvar idx=msg[\"0\"].$col;\n";
                			echo "\t\t\t\t$('#$col option').filter(function(){\n";
                			echo "\t\t\t\t\treturn this.value === idx\n";
                			echo "\t\t\t\t}).prop('selected', true).trigger('change');\n";
                		} elseif($colparams['type'] == 'checkbox'){
                			echo "\t\t\t\t if($('#fee_cat_id').val()==1 || $('#fee_cat_id').val()==2 || $('#fee_cat_id').val()==8) $('#checkbox_div_month_set').css('display', 'none'); else $('#checkbox_div_month_set').css('display', 'block'); var section=msg[\"0\"].$col;\n";
                			echo "var arr = section.split(',');$('input[type=\"checkbox\"][name=\"month_set[]\"]').removeAttr('disabled');\n";
                			echo "$.each(arr, function(index, val){ if(val!='') $('input[type=checkbox][value='+val+']').prop('checked', true);});\n";
                			echo "if (arr.length >= 2 && $('#fee_cat_id').val() == 4) {\n";
                			echo "$('input[type=\"checkbox\"][name=\"month_set[]\"]:not(\":checked\")').each(function () {\n";
                			echo "$(this).prop('disabled', 'true');});} \n";
                			echo "else {\n";
                			echo "$('input[type=\"checkbox\"][name=\"month_set[]\"]:not(\":checked\")').each(function () {\n";
                			echo " $(this).removeAttr('disabled');});}";

                		}elseif ($colparams['type'] == 'radio') {
                			echo "\t\t\t\t if($('#fee_cat_id').val()==1 || $('#fee_cat_id').val()==2 || $('#fee_cat_id').val()==5) $('#radio_div_fee_type').css('display', 'block'); else $('#radio_div_fee_type').css('display', 'none');   var idx=msg[\"0\"].$col;\n";
                			echo "\t\t\t\t  $('input:radio[name=$col]').filter(function(){\n";
                			echo "\t\t\t\t\treturn this.value === idx\n";
                			echo "\t\t\t\t}).attr('checked', true);\n";
                		} else {
                			echo "\t\t\t\t$('#$col').val(msg[\"0\"].$col);\n";
                		}
                	}
                	?>
                })
                .fail(function (msg) {
                	console.log(msg);
                });
                globalid = id;
                save_method = 'update';
                            $('#modal_form').modal('show'); // show bootstrap modal
                            $('.modal-title').text('Update <?= $rec_type ?>'); // Set Title to Bootstrap modal title
                            return false;
                        <?php } ?>
                    }

                    function save() {

                    	if (!$('#form')[0].checkValidity())
                    	{
//                                                alert($('#add_stud_frm')[0].validationMessage);
$(this).show();
$('#form')[0].reportValidity();
return false;
} else {
	var r = confirm("Are you sure you want to save?");
	if (r == true) {
                    $('#btnSave').text('saving...'); //change button text
                    $('#btnSave').attr('disabled', true); //set button disable 
                    var err = '';
                    $('#errmodal').empty();
                    if (err == '') {
                    	$('#errmodal').empty();
                    	var url;
                    	if (save_method == 'add') {
                    		url = "<?php echo base_url(); ?>/<?= uri_string() . '/add' ?>";
                    	} else {
                    		$('#btnSave').text('updating...');
                    		url = "<?php echo base_url(); ?>/<?= uri_string() . '/update' ?>/" + globalid;
                    	}
                    	var  month_applicable = '';
                    	$("input[name='month_set[]']:checked").each(function ()
                    	{
                    		if (month_applicable == '')
                    		{
                    			month_applicable = this.value;
                    		} else
                    		{
                    			month_applicable += "," + this.value;
                    		}
                    	});
                    	$.ajax
                    	({
                    		url: url,
                    		type: "POST",
                    		data:
                    		{
                    			month_applicable:month_applicable ,
                    			fee_name:$('input[name="fee_name"]').val(),
                    			fee_cat_id:$('select[name="fee_cat_id"]').val(),
                    			fee_type:$('input[name="fee_type"]').val()

                    		},
                    		dataType: "text",
                    		success: function (data) {
                                        if (data == 1) { //if success close modal and reload ajax table
                                        	$('#modal_form').modal('hide');
                                        	window.location.reload();
                                        }

                                        $('#btnSave').text('save'); //change button text
                                        $('#btnSave').attr('disabled', false); //set button enable 
                                    }
                                });

                    } else {
                    	$('#errmodal').css('color', 'Red');
                    	$('#errmodal').append(err);
                        $('#btnSave').text('save'); //change button text
                        $('#btnSave').attr('disabled', false); //set button disable 
                    }
                } else {
                	return false;
                }

            }
        }



        function delete_rec(id) {
        	var r = confirm('Are you sure you want to delete this record?');
        	if (r == true) {
        		var dataval = {'id': id};
        		$.ajax({
        			url: url + "/<?= uri_string() . '/delete/' ?>" + id,
        			type: "POST",
        			data: dataval,
        			dataType: "text",
        			success: function (data) {
        				window.location.reload();
        			},
        			error: function (data, status) {
        				alert('Error deleting <?= $rec_type ?>.');
        			}
        		});
        	} else {
        		return false;
        	}
        }


        function duplication_check(me) {

        	var field_name = $(me).attr('name');
        	var value = $(me).val();
        	$.ajax({
        		url: url + "/<?= uri_string() . '/duplication_check' ?>",
        		type: "POST",
        		data: {field_name: field_name,
        			value: value,
        		},
        		dataType: "text",
        		success: function (data) {
        			if (data != '') {

//				alert(data);
$('#errmodal').text(data);
$('#btnSave').attr('disabled', true);
} else {
	$('#errmodal').text('');
	$('#btnSave').attr('disabled', false);
}
},
error: function (data, status) {
	alert('Error.');
}
});

        }



        <?php
    }
    ?>

</script>


<?php
if (!$read_only) {
	?>

	<!-- Bootstrap modal -->
	<div class="modal fade" id="modal_form" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title"><?= $rec_type ?> Form</h3>
				</div>
				<div class="modal-body form">
					<form action="javascript:save();" id="form" name="form" class="form-horizontal">
						<div class="form-body">
							<div class="form-group">
								<div class="col-md-3"></div>
								<div class="col-md-9" id="errmodal" style="color:red;font-weight:bold"></div>
							</div>
							<div id="id"></div>
							<?php
							foreach ($edit_columns as $col => $colparams) {
								$disp = $colparams['disp'];
								$type = $colparams['type'];
								$restrictions = '';
								if (isset($colparams['required']))
									$req = ' required';
								else
									$req = '';
								if (isset($colparams['duplication_check']))
									$duplicate = ' onchange="duplication_check(this)"';
								else
									$duplicate = '';
								if ($type != 'select' && $type != 'checkbox' &&  $type != 'radio') {
									if ($type == 'text' && isset($colparams['maxlength']))
										$restrictions .= "maxlength=\"{$colparams['maxlength']}\"";
									if ($type == 'number') {
										if (isset($colparams['min']))
											$restrictions .= "min=\"{$colparams['min']}\" ";
										if (isset($colparams['max']))
											$restrictions .= "max=\"{$colparams['max']}\" ";
										if (isset($colparams['step']))
											$restrictions .= "step=\"{$colparams['step']}\" ";
									}
									?>
									<div class="form-group">
										<label class="control-label col-md-3"><?= $disp ?></label>
										<div class="col-md-9">
											<input id="<?= $col ?>" name="<?= $col ?>" placeholder="<?= $disp ?>" class="form-control" type="<?= $type ?>" <?= $restrictions ?><?= $req ?><?= $duplicate ?>>
											<span class="help-block"></span>
										</div>
									</div>
									<?php
								}elseif ($type == 'checkbox') {
									?>

									<div class="form-group" style="display:none" id="checkbox_div_<?= $col ?>">
										<label class="control-label col-md-3"><?= $disp ?></label>
										<div class="col-md-9">
											<?php foreach ($colparams['select_opts'] as $opt) { ?>
												<input id="<?= $col ?><?= $opt->opt_id ?>" name="<?= $col ?>[]" type="checkbox" value='<?php echo $opt->opt_id ?>'> <?php echo $opt->opt_disp ?> &nbsp;&nbsp;&nbsp;
											<?php } ?>
											<span class="help-block"></span>
										</div>
									</div>            

								<?php }elseif ($type == 'radio') {
									?>

									<div class="form-group" style="display:none" id="radio_div_<?= $col ?>">
										<label class="control-label col-md-3"><?= $disp ?></label>
										<div class="col-md-9">
											<?php foreach ($colparams['select_opts'] as $opt) { ?>

												<label class="radio-inline"><input type="radio" id="<?= $col ?>" name="<?= $col ?>" value='<?php echo $opt->opt_id ?>'><?php echo $opt->opt_disp ?></label>
											<?php } ?>
											<span class="help-block"></span>
										</div>
									</div>            

								<?php } else {
									?>
									<div class="form-group">
										<label class="control-label col-md-3"><?= $disp ?></label>
										<div class="col-md-9">
											<select id="<?= $col ?>"  name="<?= $col ?>" class="form-control"<?= $req ?><?= $duplicate ?>>
												<option  value=''>None</option>
												<?php
												foreach ($colparams['select_opts'] as $opt) {
													echo "\t\t\t\t\t\t\t\t<option  value='$opt->opt_id'>$opt->opt_disp</option>\n";
												}
												?>
											</select>
											<span class="help-block"></span>
										</div>
									</div>
									<?php
								}
							}
							?>
						</div>
					</form>
				</div> 
				<div class="modal-footer">
					<button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save   </button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<!-- End Bootstrap modal -->

	<!-- This modal using for Import Text Book List -->
	<div id="importBook" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Import Text Book List</h4>
				</div>
				<div class="modal-body">
					<form id="import_book_list" action="<?php echo base_url('import-text-book');?>" method="post">
						<div>
							<input type="file" name="excle_file" class="form-control">
						</div><br>

						<div align="right">
							<input type="submit" name="sub_btn" class="btn btn-md btn-success" value="Submit">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</form>

					
				</div>
			</div>

		</div>
	</div>


	<?php
}
?>



