<div class="tab-pane box active" id="edit" style="padding: 5px">
    <div class="box-content">
        <?php foreach($edit_data as $row):?>
        <?php echo form_open('teacher/leavemanagement/do_update/'.$row['leave_id'] , array('class' => 'form-horizontal validatable','target'=>'_top'));?>
            <div class="padded">
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('leave_type');?></label>
                                <div class="controls">
                                    <select class="validate[required]" name="leave_type" id="leave_type">
                                    	<option value="">--- Select Leave Type ---</option>
                                        <?php foreach($ltype_data as $ltype_data_view) { ?>
                                        	<option value="<?php echo $ltype_data_view->leave_type_id ?>" 
                                            <?php 
											if($row['leave_tid'] == $ltype_data_view->leave_type_id){ echo "selected"; }
											?>
                                            
                                            ><?php echo $ltype_data_view->leave_type_title ?></option>
                                       	<?php } ?> 
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('max_days_allowed');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" name="mx_dts" id="mx_dts" readonly="readonly" value="<?php echo $row['leave_type_max_days'] ?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('from');?></label>
                                <div class="controls">
                                    <input type="text" class="datepicker fill-up validate[required]" name="lstartDate" id="lstartDate" value="<?php echo date('m/d/Y',strtotime($row['leave_fdate'])) ?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('to');?></label>
                                <div class="controls">
                                    <input type="text" class="datepicker fill-up validate[required]" name="lendDate" id="lendDate" value="<?php echo date('m/d/Y',strtotime($row['leave_tdate'])) ?>"/>
                                    <span id="dateError"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('no_of_days');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" name="no_dts" id="no_dts" readonly="readonly" value="<?php echo $row['leave_count'] ?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('comments');?></label>
                                <div class="controls">
                                  
                                                <textarea name="comments"  rows="5" cols="7" style="resize:none" placeholder="<?php echo get_phrase('add_comments');?>" class="validate[required]"><?php echo $row['leave_comments'] ?></textarea>
                                </div>
                            </div>
                            

                        </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-gray"><?php echo get_phrase('edit_noticeboard');?></button>
            </div>
        </form>
        <?php endforeach;?>
    </div>
</div>
<script>
$('#leave_type').on('change',function(){
	var ltype = $(this).val();
	
	if(ltype !=''){
		 $.ajax({
							type: 'POST',
							url: '<?php echo base_url() ?>teacher/ltypedata/',
							data: { lType:ltype  },
							success: function(data) {
								
								$('#mx_dts').val(data);
								
								
							}
				  });
		}
	
	
});
$( "#lstartDate,#lendDate" ).change(function() {
		var srtDt=$('#lstartDate').val();
		var enDt=$('#lendDate').val();
		if(srtDt!='' && enDt!=''){
		 $.ajax({
							type: 'POST',
							url: '<?php echo base_url() ?>teacher/datecompare/',
							data: { startDate:srtDt ,endDate:enDt },
							success: function(data) {
								//alert(data);
								if(data=='false'){
									$('#dateError').text('Please select end date must be later than start date').css('color','#CC0000').css('padding-left','15px');
									$('#lendDate').val('');
								} else if(data=='true'){
									
								 $.ajax({
												type: 'POST',
												url: '<?php echo base_url() ?>teacher/caldays/',
												data: { startDate:srtDt ,endDate:enDt },
												success: function(data) {
													
													//alert(data);
													$('#no_dts').val(data);
													}
									  });

									
									
								}
							}
				  });
		}
});
$( "#lstartDate,#lendDate").focus(function() {
		$('#dateError').text('');
});
</script>