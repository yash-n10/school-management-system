<div class="tab-pane box active" id="edit" style="padding: 5px">
    <div class="box-content">
        <?php foreach($edit_data as $row):?>
        <?php echo form_open('admin/leavemanagement/do_update/'.$row['leave_id'] , array('class' => 'form-horizontal validatable','target'=>'_top'));?>
            <div class="padded">
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('leave_status');?></label>
                                <div class="controls">
                                    <select class="validate[required]" name="leave_status" id="leave_status">
                                    	<option value="">--- Select Leave Type ---</option>
                                       		<option value="0" 
                                            <?php 
											if($row['leave_status'] == 0){ echo "selected"; }
											?>
                                            
                                            >Pending</option>
                                        	<option value="1" 
                                            <?php 
											if($row['leave_status'] == 1){ echo "selected"; }
											?>
                                            
                                            >Approve</option>
                                            
                                            <option value="2" 
                                            <?php 
											if($row['leave_status'] == 2){ echo "selected"; }
											?>
                                            
                                            >Reject</option>
                                       	
                                    </select>
                                    
                                </div>
                            </div>
                            
                            
                            
                            
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('message');?></label>
                                <div class="controls">
                                  
                                                <textarea name="message"  rows="5" cols="7" style="resize:none" placeholder="<?php echo get_phrase('add_message');?>" class="validate[required]"><?php echo $row['leave_message'] ?></textarea>
                                </div>
                            </div>
                            

                        </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-gray"><?php echo get_phrase('update_status');?></button>
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