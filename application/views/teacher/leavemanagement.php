<div class="box">
	<div class="box-header">
    
    	<!------CONTROL TABS START------->
		<ul class="nav nav-tabs nav-tabs-left">
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> 
					<?php echo get_phrase('leaves_applied');?>
                    	</a></li>
			<li>
            	<a href="#add" data-toggle="tab"><i class="icon-plus"></i>
					<?php echo get_phrase('apply_leave');?>
                    	</a></li>
		</ul>
    	<!------CONTROL TABS END------->
        
	</div>
	<div class="box-content padded">
		<div class="tab-content">
            <!----TABLE LISTING STARTS--->
            <div class="tab-pane box active" id="list">
                <table cellpadding="0" cellspacing="0" border="0" class="dTable responsive">
                	<thead>
                		<tr>
                    		<th><div>#</div></th>
                    		<th><div><?php echo get_phrase('leave_type');?></div></th>
                    		<th><div><?php echo get_phrase('from_date');?></div></th>
                    		<th><div><?php echo get_phrase('to_date');?></div></th>
                            <th><div><?php echo get_phrase('no_of_days');?></div></th>
                            <th><div><?php echo get_phrase('status');?></div></th>
                    		<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php $count = 1;foreach($leave_data as $row):?>
                        <tr>
                            <td><?php echo $count++;?></td>
							<td><?php echo $row['ltype'];?></td>
                            <td class="center"><?php echo date('d M,Y', strtotime($row['leave_fdate']));?></td>
                            <td class="center"><?php echo date('d M,Y', strtotime($row['leave_tdate']));?></td>
							<td align="right"><?php echo $row['leave_count'];?></td>
                            <td class="center"><?php $ls = $row['leave_status'];
							
								if($ls == 0){
									
									echo "Pending";
								} else if($ls == 1) {
									
									echo "Approved";
								} else if($ls == 2) {
									
									echo "Rejected";
								}
							
							?></td>
							<td align="center">
                            	<!--<a data-toggle="modal" href="#modal-form" onclick="modal('edit_leave',<?php echo $row['leave_id'];?>)" class="btn btn-gray btn-small">
                                		<i class="icon-wrench"></i> <?php echo get_phrase('edit');?>
                                </a>-->
                            	<a data-toggle="modal" href="#modal-delete" onclick="modal_delete('<?php echo base_url();?>teacher/leavemanagement/delete/<?php echo $row['leave_id'];?>')" class="btn btn-red btn-small">
                                		<i class="icon-trash"></i> <?php echo get_phrase('delete');?>
                                </a>
        					</td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
			</div>
            <!----TABLE LISTING ENDS--->
            
            
			<!----CREATION FORM STARTS---->
			<div class="tab-pane box" id="add" style="padding: 5px">
                <div class="box-content">
                	<?php echo form_open('teacher/leavemanagement/create' , array('class' => 'form-horizontal validatable','target'=>'_top'));?>
                        <div class="padded">
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('leave_type');?></label>
                                <div class="controls">
                                    <select class="validate[required]" name="leave_type" id="leave_type">
                                    	<option value="">--- Select Leave Type ---</option>
                                        <?php foreach($ltype_data as $ltype_data_view) { ?>
                                        	<option value="<?php echo $ltype_data_view->leave_type_id ?>"><?php echo $ltype_data_view->leave_type_title ?></option>
                                       	<?php } ?> 
                                    </select>
                                    
                                </div>
                            </div>
                            <div id="cstm-leave-data">
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('max_days / Taken / Remains');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required] span1" name="mx_dts" id="mx_dts" readonly="readonly"/>
                                    <input type="text" class="validate[required] span1" name="tk_dts" id="tk_dts" readonly="readonly"/>
                                    <input type="text" class="validate[required] span1" name="rm_dts" id="rm_dts" readonly="readonly"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('from');?></label>
                                <div class="controls">
                                    <input type="text" class="datepicker fill-up validate[required]" name="lstartDate" id="lstartDate"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('to');?></label>
                                <div class="controls">
                                    <input type="text" class="datepicker fill-up validate[required]" name="lendDate" id="lendDate"/>
                                    <span id="dateError"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('no_of_days');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" name="no_dts" id="no_dts" readonly="readonly"/>
                                    <span id="cntError"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('comments');?></label>
                                <div class="controls">
                                  
                                                <textarea name="comments"  rows="5" cols="7" style="resize:none" placeholder="<?php echo get_phrase('add_comments');?>" class="validate[required]"></textarea>
                                </div>
                            </div>
                            

                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-blue"><?php echo get_phrase('apply_leave');?></button>
                        </div>
                        </div>
                        </div>
                        
                    </form>                
                </div>                
			</div>
			<!----CREATION FORM ENDS--->
            
		</div>
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
								
								$('#mx_dts').val(data.mdays);
								$('#tk_dts').val(data.thks);
								$('#rm_dts').val(data.rms);
								
								$('#cstm-leave-data').show();
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
													var rml = parseInt($('#rm_dts').val());
													var cnt = parseInt(data);
													
													if(rml < cnt){
													$('#cntError').text('your leave count is higher than ' + rml).css('color','#CC0000').css('padding-left','15px');
													$('#no_dts').val('');
													$('#lendDate').val('');
													}
													else {
														$('#cntError').text('');
														$('#no_dts').val(cnt);
													}
													
													
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
$(window).load( function(){
	
	$('#cstm-leave-data').hide();
});

</script>