<div class="box">
	<div class="box-content padded">
    
    	<div class="row-fluid">
        
        		<div class="span12">
                		<div class="custom-tam-hr-frm">
                	    <form class="form-horizontal validatable" method="post" action="<?php echo base_url(); ?>office/fee_cat_insert">
                        <div class="row-fluid">
                        <div class="span6">
                        <div class="control-group">
                        <label class="control-label" for="fee_category"><?php echo get_phrase('fee_category');?></label>
                        <div class="controls">
                        <input type="text" class="validate[required]" id="fee_category" name="fee_category" placeholder="Please enter fee category">
                        <span id="val_fc_val"></span>
                        </div>
                        </div>
                        </div>
                        <div class="span6">
                        <div class="control-group">
                        <label class="control-label" for="fc_invoice_pre_fix"><?php echo get_phrase('invoice_pre_fix');?></label>
                        <div class="controls">
                        	<input type="text" name="fc_invoice_pre_fix" id="fc_invoice_pre_fix" class="validate[required]" placeholder="Please enter invoice pre fix" />
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
                        	<textarea name="fee_category_description" id="fee_category_description" class="validate[required]" style="resize:none;"></textarea>
                        </div>
                        </div>
                        </div>
                        
                        <div class="span6">
                        <div class="control-group">
                        <label class="control-label" for="fee_category_status"><?php echo get_phrase('fee_category_status');?></label>
                        <div class="controls">
                        	<select name="fee_category_status" id="fee_categorystatus" class="uniform validate[required]">
								<option value="">-- Time Table Status --&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        </div>
                        </div>
                        </div>
                        <div class="row-fluid">
                        
                        <div class="span6">
                        <div class="control-group">
                        <div class="controls">
                        
                        <button type="submit" class="btn btn-lightblue"><?php echo get_phrase('add_fee_category');?></button>
                        </div>
                        </div>
                        </div>
                        </div>
                        
                        </form>
                        </div>
                
                </div>
        
        </div>
        
        <div class="row-fluid">
        	<div class="span12">
            <?php //print_r($fee_cat_data) ?>
            	    <table class="table table-bordered">
                    		<thead>
                            	<tr>
                                	<th>Fee Category</th>
                                    <th>Invoice Pre Fix</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($fee_cat_data)) { foreach($fee_cat_data as $fee_cat_data_view) { ?>
                            	<tr>
                                	<td><?php echo $fee_cat_data_view->fee_category ?></td>
                                    <td><?php echo $fee_cat_data_view->fc_invoice_pre_fix ?></td>
                                    <td><?php echo ucfirst($fee_cat_data_view->fee_category_status) ?></td>
                                    <td>
                                    <a href="<?php echo base_url();?>office/feeparticulars/<?php echo $fee_cat_data_view->fee_category_id ?>" class="btn btn-small btn-green"><i class="icon-edit"></i> Add Particulars</a> 
                                    <a href="<?php echo base_url();?>office/fee_cat_edit/<?php echo $fee_cat_data_view->fee_category_id ?>" class="btn btn-small btn-lightblue"><i class="icon-edit"></i> Edit</a>  <a data-toggle="modal" href="#modal-delete" onclick="modal_delete('<?php echo base_url();?>office/fee_cat_delete/<?php echo $fee_cat_data_view->fee_category_id ?>')" class="btn btn-small btn-red"><i class="icon-trash"></i> Trash</a></td>
                                </tr>
                            <?php } } ?>    
                            </tbody>
                    </table>
            
            </div>
        </div>
		
	</div>
</div>

<script>
$('#fee_category').on('change',function(){
	
	var fc_val = $(this).val();
	
	$('#val_fc_val').append('<img title="<?php echo base_url(); ?>template/images/loading.gif" src="<?php echo base_url(); ?>template/images/loading.gif">');
		
		$.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>office/fee_cat_check/',
							data: { chkfcval:fc_val },
							success: function(data) {
								//alert(data);
								
								if(data=='true'){
									$("#val_fc_val").text('').attr("class","label label-warning").text( "'"+ fc_val +" ' already exists try another !" );
									$("#fee_category").val('').focus();
								} else {
									$("#val_fc_val").removeAttr("class").text('').attr("class","label label-success").text( "'"+ fc_val +"' available !" );
									
								}
								
							}
				  });
	
});

$('#fc_invoice_pre_fix').on('change',function(){
	
	var fc_inc_val = $(this).val();
	
	$('#val_fc_inc').append('<img title="<?php echo base_url(); ?>template/images/loading.gif" src="<?php echo base_url(); ?>template/images/loading.gif">');
		
		$.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>office/fee_cat_preinc_check/',
							data: { chkfcpreincval:fc_inc_val, chkprvfcincval:'' },
							success: function(data) {
								//alert(data);
								
								if(data=='true'){
									$("#val_fc_inc").text('').attr("class","label label-warning").text( "'"+ fc_inc_val +" ' already exists try another !" );
									$("#fc_invoice_pre_fix").val('').focus();
								} else {
									$("#val_fc_inc").removeAttr("class").text('').attr("class","label label-success").text( "'"+ fc_inc_val +"' available !" );
									
								}
								
							}
				  });
	
});

</script>