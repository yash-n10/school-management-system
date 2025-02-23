<div class="box">
	<div class="box-content padded">
    
    	<div class="row-fluid">
        
        		<div class="span12">
                		<div class="custom-tam-hr-frm">
                        <?php if(!empty($fc_data)) extract($fc_data) ?>
                	    <form class="form-horizontal validatable" method="post" action="<?php echo base_url(); ?>principal/fee_cat_update">
                        <div class="row-fluid">
                        <div class="span6">
                        <div class="control-group">
                        <label class="control-label" for="fee_category"><?php echo get_phrase('fee_category');?></label>
                        <div class="controls">
                        <input type="text" class="validate[required]" id="fee_category" name="fee_category" placeholder="Please enter fee category" value="<?php if(isset($fee_category)) echo $fee_category; ?>">
                        <input type="hidden" id="fee_cat_hid" name="fee_cat_hid" value="<?php if(isset($fee_category)) echo $fee_category; ?>" />
                        <span id="val_fc_val"></span>
                        </div>
                        </div>
                        </div>
                        <div class="span6">
                        <div class="control-group">
                        <label class="control-label" for="fc_invoice_pre_fix"><?php echo get_phrase('invoice_pre_fix');?></label>
                        <div class="controls">
                        <input type="text" class="validate[required]" id="fc_invoice_pre_fix" name="fc_invoice_pre_fix" placeholder="Please enter invoice pre fix" value="<?php if(isset($fc_invoice_pre_fix)) echo $fc_invoice_pre_fix; ?>">
                        <input type="hidden" id="fee_cat_inc_hid" name="fee_cat_inc_hid" value="<?php if(isset($fc_invoice_pre_fix)) echo $fc_invoice_pre_fix; ?>" />
                        <span id="val_fc_inc"></span>
                        </div>
                        </div>
                        </div>
                        </div>
                        <div class="row-fluid">
                        <div class="span6">
                        <div class="control-group">
                        <label class="control-label" for="fee_category_description"><?php echo get_phrase('description');?></label>
                        <div class="controls">
                        	<textarea name="fee_category_description" id="fee_category_description" class="validate[required]" style="resize:none;"><?php if(isset($fee_category_description)) echo $fee_category_description; ?></textarea>
                        </div>
                        </div>
                        </div>
                        <div class="span6">
                        <div class="control-group">
                        <label class="control-label" for="fee_category_status"><?php echo get_phrase('fee_category_status');?></label>
                        <div class="controls">
                        	<select name="fee_category_status" id="fee_category_status" class="validate[required]">
                                <option value="active" <?php if(isset($fee_category_status) && $fee_category_status=='active' ) echo "selected"; ?> >Active</option>
                                <option value="inactive" <?php if(isset($fee_category_status) && $fee_category_status=='inactive' ) echo "selected"; ?>>Inactive</option>
                            </select>
                        </div>
                        </div>
                        </div>
                        </div>
                        <div class="row-fluid">
                        
                        <div class="span6">
                        <div class="control-group">
                        <div class="controls">
                        <input type="hidden" value="<?php if(isset($fee_category_id)) echo $fee_category_id; ?>" name="hid_fc_id" id="hid_fc_id" />
                        <button type="submit" class="btn btn-lightblue"><?php echo get_phrase('edit_fee_category');?></button>
                        </div>
                        </div>
                        </div>
                        </div>
                        
                        </form>
                        </div>
                
                </div>
        
        </div>
        
        
		
	</div>
</div>

<script>
$('#fee_category').on('change',function(){
	
	var fc_val = $(this).val();
	var prv_fc_val = $('#fee_cat_hid').val();
	
	$('#val_fc_val').append('<img title="<?php echo base_url(); ?>template/images/loading.gif" src="<?php echo base_url(); ?>template/images/loading.gif">');
		
		$.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>principal/fee_cat_check/',
							data: { chkfcval:fc_val , chkprvfcval : prv_fc_val },
							success: function(data) {
								//alert(data);
								
								if(data=='true'){
									$("#val_fc_val").text('').attr("class","label label-warning").text( "'"+ fc_val +" ' already exists try another !" );
									$("#fee_category").val(prv_fc_val).focus();
								} else {
									$("#val_fc_val").removeAttr("class").text('').attr("class","label label-success").text( "'"+ fc_val +"' available !" );
									
								}
								
							}
				  });
	
});

$('#fc_invoice_pre_fix').on('change',function(){
	
	var fc_inc_val = $(this).val();
	
	var prv_fc_inc_val = $('#fee_cat_inc_hid').val();
	
	$('#val_fc_inc').append('<img title="<?php echo base_url(); ?>template/images/loading.gif" src="<?php echo base_url(); ?>template/images/loading.gif">');
		
		$.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>principal/fee_cat_preinc_check/',
							data: { chkfcpreincval:fc_inc_val, chkprvfcincval:prv_fc_inc_val },
							success: function(data) {
								//alert(data);
								
								if(data=='true'){
									$("#val_fc_inc").text('').attr("class","label label-warning").text( "'"+ prv_fc_inc_val +" ' already exists try another !" );
									$("#fc_invoice_pre_fix").val(prv_fc_inc_val).focus();
								} else {
									$("#val_fc_inc").removeAttr("class").text('').attr("class","label label-success").text( "'"+ prv_fc_inc_val +"' available !" );
									
								}
								
							}
				  });
	
});

</script>