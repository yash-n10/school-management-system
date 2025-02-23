<div class="box">
	<div class="box-content padded">
    
    	<div class="row-fluid">
        
        		<div class="span12">
                		<div class="custom-tam-hr-frm">
                        <?php if(!empty($feeperiod)) extract($feeperiod) ?>
                	    <form class="form-horizontal validatable" method="post" action="<?php echo base_url(); ?>office/fee_period_update">
                        
                        <div class="control-group">
                        <label class="control-label" for="fee_period_cid"><?php echo get_phrase('fee_category');?></label>
                        <div class="controls">
                        <select class="validate[required] uniform" id="fee_period_cid" name="fee_period_cid">
                        
                        	<option value="">--- select fee category ---</option>
                            
                            <?php foreach($fc_data as $fc_data_view){ ?>
                            
                            	<option value="<?php echo $fc_data_view->fee_category_id; ?>" <?php if($fc_data_view->fee_category_id == $fee_period_cid)  echo "selected" ?> ><?php echo $fc_data_view->fee_category; ?></option>
                            
                            <?php } ?>
                        
                        </select>
                       <span id="val_fc_id"></span>
                        </div>
                        </div>
                       
                        <div class="control-group">
                        <label class="control-label" for="fee_period_pid"><?php echo get_phrase('particular_name');?></label>
                        <div class="controls">
                        	<select name="fee_period_pid" id="fee_period_pid" class="validate[required] uniform">
                            	
                                <option value="" >- select fee category first -</option>
                                
                                <?php  $ci =& get_instance(); $ci->load->model('fee_model'); $fp_data = $ci->fee_model->getfpdata($fee_period_cid); ?>
                            	<?php foreach($fp_data as $fp_data_view){ ?>
                            
                            	<option value="<?php echo $fp_data_view->fee_particular_id; ?>" <?php if($fp_data_view->fee_particular_id == $fee_period_pid)  echo "selected" ?> ><?php echo $fp_data_view->fee_particular_name; ?></option>
                            
                            <?php } ?>
                            </select>
                         
                        </div>
                        </div>
                        
                        <div class="control-group">
                        <label class="control-label" for="fee_period_sdate"><?php echo get_phrase('start_date');?></label>
                        <div class="controls">
                        	<input type="text" name="fee_period_sdate" id="fee_period_sdate" class="datepicker fill-up validate[required]" placeholder="Please enter start date" value="<?php if(isset($fee_period_sdate)) echo $fee_period_sdate ?>" />
                         
                        </div>
                        </div>
                        
                        <div class="control-group">
                        <label class="control-label" for="fee_period_edate"><?php echo get_phrase('end_date');?></label>
                        <div class="controls">
                        	<input type="text" name="fee_period_edate" id="fee_period_edate" class="datepicker fill-up validate[required]" placeholder="Please enter end date" value="<?php if(isset($fee_period_edate)) echo $fee_period_edate ?>" />
                            
                            <span id="dateError"></span>
                         
                        </div>
                        </div>
                        
                        <div class="control-group">
                        <label class="control-label" for="fee_period_ddate"><?php echo get_phrase('due_date');?></label>
                        <div class="controls">
                        	<input type="text" name="fee_period_ddate" id="fee_period_ddate" class="datepicker fill-up validate[required]" placeholder="Please enter due date" value="<?php if(isset($fee_period_ddate)) echo $fee_period_ddate ?>" />
                            
                            <span id="dateErrordue"></span>
                         
                        </div>
                        </div>
                       
                        
                        <div class="control-group">
                        <div class="controls">
                        <input type="hidden" name="fee_period_id_hid" id="fee_period_id_hid" value="<?php if(isset($fee_period_id)) echo $fee_period_id ?>" />
                        <button type="submit" class="btn btn-lightblue"><?php echo get_phrase('edit_fee_period');?></button>
                        </div>
                        </div>
                        
                        
                        </form>
                        </div>
                
                </div>
        
        </div>
        
        
		
	</div>
</div>

<script>
$('#fee_period_cid').on('change',function(){
	
	
	
	var fc_id = $(this).val();
	
	
	
	$('#val_fc_id').append('<img title="<?php echo base_url(); ?>template/images/loading.gif" src="<?php echo base_url(); ?>template/images/loading.gif">');
	
	
		
		
		$.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>office/fee_particulars_data/',
							data: { get_fc_id:fc_id },
							success: function(data) {
								//alert(data);
								
								$('#val_fc_id').text('');
									
								$('#fee_period_pid').text('').append(data);
								
							}
				  });
	
	
});


$( "#fee_period_sdate,#fee_period_edate" ).change(function() {
		var srtDt=$('#fee_period_sdate').val();
		var enDt=$('#fee_period_edate').val();
		if(srtDt!='' && enDt!=''){
		 $.ajax({
							type: 'POST',
							url: '<?php echo base_url() ?>office/datecompare/',
							data: { startDate:srtDt ,endDate:enDt },
							success: function(data) {
								//alert(data);
								if(data=='false'){
									$('#dateError').text('Please select end date must be later than start date').css('color','#CC0000').css('padding-left','15px');
									$('#fee_period_edate').val('');
								} 
							}
				  });
		}
});
$( "#fee_period_sdate,#fee_period_edate").focus(function() {
		$('#dateError').text('');
});
$( "#fee_period_sdate,#fee_period_ddate" ).change(function() {
		var srtDt=$('#fee_period_sdate').val();
		var enDt=$('#fee_period_ddate').val();
		if(srtDt!='' && enDt!=''){
		 $.ajax({
							type: 'POST',
							url: '<?php echo base_url() ?>office/datecompare/',
							data: { startDate:srtDt ,endDate:enDt },
							success: function(data) {
								//alert(data);
								if(data=='false'){
									$('#dateErrordue').text('Please select due date must be later than start date').css('color','#CC0000').css('padding-left','15px');
									$('#fee_period_ddate').val('');
								} 
							}
				  });
		}
});
$( "#fee_period_sdate,#fee_period_ddate").focus(function() {
		$('#dateErrordue').text('');
});

</script>