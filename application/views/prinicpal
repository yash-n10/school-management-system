<div class="box">
	<div class="box-header">
    
    	<!------CONTROL TABS START------->
		<ul class="nav nav-tabs nav-tabs-left">
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> 
					<?php echo get_phrase('leaves_applied');?>
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
                            <th><div><?php echo get_phrase('leave_applied_by');?></div></th>
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
                            <td><?php echo $row['aname'];?></td>
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
                            	<a data-toggle="modal" href="#modal-form" onclick="modal('edit_leave',<?php echo $row['leave_id'];?>)" class="btn btn-gray btn-small">
                                		<i class="icon-wrench"></i> <?php echo get_phrase('edit');?>
                                </a>
                            	<!--<a data-toggle="modal" href="#modal-delete" onclick="modal_delete('<?php echo base_url();?>admin/leavemanagement/delete/<?php echo $row['leave_id'];?>')" class="btn btn-red btn-small">
                                		<i class="icon-trash"></i> <?php echo get_phrase('delete');?>
                                </a>-->
        					</td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
			</div>
            <!----TABLE LISTING ENDS--->
            
            
			
            
		</div>
	</div>
</div>
<script>
$('#leave_type').on('change',function(){
	var ltype = $(this).val();
	
	if(ltype !=''){
		 $.ajax({
							type: 'POST',
							url: '<?php echo base_url() ?>admin/ltypedata/',
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
							url: '<?php echo base_url() ?>admin/datecompare/',
							data: { startDate:srtDt ,endDate:enDt },
							success: function(data) {
								//alert(data);
								if(data=='false'){
									$('#dateError').text('Please select end date must be later than start date').css('color','#CC0000').css('padding-left','15px');
									$('#lendDate').val('');
								} else if(data=='true'){
									
								 $.ajax({
												type: 'POST',
												url: '<?php echo base_url() ?>admin/caldays/',
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