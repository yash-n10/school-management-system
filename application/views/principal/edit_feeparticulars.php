<div class="box">
	<div class="box-content padded">
    
    	<div class="row-fluid">
        
        		<div class="span12">
                		<div class="custom-tam-hr-frm">
                        <?php if(!empty($fp_data)) extract($fp_data); //print_r($fp_data); ?>
                	    <form class="form-horizontal validatable" method="post" action="<?php echo base_url(); ?>principal/fee_particular_update">
                        
                        <div class="control-group">
                        <label class="control-label" for="fee_category"><?php echo get_phrase('fee_category');?></label>
                        <div class="controls">
                        <input type="text" class="validate[required]" id="fee_category" name="fee_category" value="<?php if(isset($fcategory)) echo $fcategory; ?>" disabled="disabled">
                        <input type="hidden" name="fee_category_id" id="fee_category_id" value="<?php if(isset($fee_category_id)) echo $fee_category_id; ?>" />
                        </div>
                        </div>
                       
                        <div class="control-group">
                        <label class="control-label" for="fee_particular_name"><?php echo get_phrase('particular_name');?></label>
                        <div class="controls">
                        	<input type="text" name="fee_particular_name" id="fee_particular_name" class="validate[required]" placeholder="Please enter particular name" value="<?php if(isset($fee_particular_name)) echo $fee_particular_name; ?>" />
                            <input type="hidden" name="fee_particular_name_hid" id="fee_particular_name_hid" value="<?php if(isset($fee_particular_name)) echo $fee_particular_name; ?>" /> 
                            <span id="val_fp_val"></span>
                        </div>
                        </div>
                       
                        <div class="control-group">
                        <label class="control-label" for="fee_particular_description"><?php echo get_phrase('description');?></label>
                        <div class="controls">
                        	<textarea name="fee_particular_description" id="fee_particular_description" class="validate[required]" style="resize:none;"><?php if(isset($fee_particular_description)) echo $fee_particular_description; ?></textarea>
                        </div>
                        </div>
                        
                        <div class="control-group">
                        <label class="control-label" for="fee_particular_type"><?php echo get_phrase('type');?></label>
                        <div class="controls">
                        	<select name="fee_particular_type" id="fee_particular_type" class="uniform validate[required]" >
                            	<option value="">--- select type ---</option>
                                <option value="fp_all" <?php if(isset($fee_particular_type) && $fee_particular_type =='fp_all') echo "selected"; ?> >All</option>
                              <!--  <option value="fp_standard" <?php if(isset($fee_particular_type) && $fee_particular_type =='fp_standard') echo "selected"; ?>>Standard</option>-->
                                <option value="fp_class" <?php if(isset($fee_particular_type) && $fee_particular_type =='fp_class') echo "selected"; ?> >Class</option>
                                <option value="fp_roll" <?php if(isset($fee_particular_type) && $fee_particular_type =='fp_roll') echo "selected"; ?>>Roll No</option>
                            </select>
                            <span id="val_fp_type"></span>
                        </div>
                        </div>
                        
                        
                        <div id="custom-tam-fp-type-blck">
                        
                        	
                            <?php if( $fee_particular_type =='fp_standard'){ ?>
								
								<div class="control-group">
                                <label class="control-label" for="fee_particular_type_id"><?php echo get_phrase('standard'); ?></label>
								<div class="controls">
                                <select id="fee_particular_type_id" name="fee_particular_type_id" class="uniform">
                                <option value="">----select standard----</option>
								<?php foreach($fp_standard_data as $fp_standard_data_view){ ?>
								<option value="<?php echo $fp_standard_data_view->standard_id ?>" <?php if($fp_standard_data_view->standard_id == $fee_particular_type_id ) echo "selected"; ?>>
								<?php echo $fp_standard_data_view->standard_name ?></option>;
								<?php	} ?>
                                </select>
                                </div>
                                </div>
								
							<?php } else if( $fee_particular_type =='fp_class') {?>
                            
                            	<div class="control-group">
                                <label class="control-label" for="fee_particular_type_id"><?php echo get_phrase('class'); ?></label>
								<div class="controls">
                                <select id="fee_particular_type_id" name="fee_particular_type_id" class="uniform">
                                <option value="">----select class----</option>
								<?php foreach($fp_class_data as $fp_class_data_view){ ?>
								<option value="<?php echo $fp_class_data_view->class_id ?>" <?php if($fp_class_data_view->class_id == $fee_particular_type_id ) echo "selected"; ?>>
								<?php echo $fp_class_data_view->name ?></option>;
								<?php	} ?>
                                </select>
                                </div>
                                </div>
                            
                            <?php } else if ($fee_particular_type =='fp_roll') { ?>
                            
                            	<div class="control-group">
                                <label class="control-label" for="fee_particular_type_cid"><?php echo get_phrase('class'); ?></label>
								<div class="controls">
                                <select id="fee_particular_type_cid" name="fee_particular_type_cid" class="uniform">
                                <option value="">----select class----</option>
								<?php foreach($fp_class_data as $fp_class_data_view){ ?>
								<option value="<?php echo $fp_class_data_view->class_id ?>" <?php if($fp_class_data_view->class_id == $fee_particular_type_cid ) echo "selected"; ?>>
								<?php echo $fp_class_data_view->name ?></option>;
								<?php	} ?>
                                </select>
                                </div>
                                </div>
                                <div id="custom-tam-fp-type-blck-roll">
                                
                                <?php  $ci =& get_instance(); $ci->load->model('fee_model'); $fp_roll_data = $ci->fee_model->getrolls($fee_particular_type_cid); ?>
                                
                                <div class="control-group">
                                <label class="control-label" for="fee_particular_type_id"><?php echo get_phrase('Roll No'); ?></label>
								<div class="controls">
                                
								<?php foreach($fp_roll_data as $fp_roll_data_view){ ?>
                                
                                <?php $values = explode(',', $fee_particular_type_id); if( in_array($fp_roll_data_view->student_id, $values)) { ?> 
								<label class="checkbox inline"><input type="checkbox" id="fee_particular_type_id<?php echo $fp_roll_data_view->student_id ?>" name="fee_particular_type_id[]" value="<?php echo $fp_roll_data_view->student_id ?>" checked='checked'><?php echo $fp_roll_data_view->name.'-'.$fp_roll_data_view->roll ?></label>
                              <?php } else {?>   
                              
                              <label class="checkbox inline"><input type="checkbox" id="fee_particular_type_id<?php echo $fp_roll_data_view->student_id ?>" name="fee_particular_type_id[]" value="<?php echo $fp_roll_data_view->student_id ?>"><?php echo $fp_roll_data_view->name.'-'.$fp_roll_data_view->roll ?></label>
                              
                              <?php } ?>
                                
								
								<?php	} ?>
                                
                                
                                
                                </div>
                                </div>
                                
                                </div>
                            
                            <?php } ?>
                            
                        
                        </div>
                        
                        
                       	<div class="control-group">
                        <label class="control-label" for="fee_particular_amount"><?php echo get_phrase('amount');?></label>
                        <div class="controls">
                        	<input type="number"  name="fee_particular_amount" id="fee_particular_amount" class="validate[required]" placeholder="Please enter particular amount" value="<?php if(isset($fee_particular_amount)) echo $fee_particular_amount; ?>" />
                         
                        </div>
                        </div>
                        <div class="control-group">
                        <label class="control-label" for="fee_particular_discount"><?php echo get_phrase('discount');?></label>
                        <div class="controls">
                        	<input type="text"  name="fee_particular_discount" id="fee_particular_discount" class="validate[required]" placeholder="Please enter particular discount" value="<?php if(isset($fee_particular_discount)) echo $fee_particular_discount; ?>"  />
                         
                        </div>
                        </div>
                         <div class="control-group" <?php if(isset($fee_particular_discount_reason) && $fee_particular_discount_reason == '' )  echo 'style="display:none;"'?>  id="custom-tam-fp-discount">
                        <label class="control-label" for="fee_particular_discount_reason"><?php echo get_phrase('discount_reason');?></label>
                        <div class="controls">
                        	<textarea name="fee_particular_discount_reason" id="fee_particular_discount_reason" class="validate[required]" style="resize:none;"><?php if(isset($fee_particular_discount_reason)) echo $fee_particular_discount_reason; ?></textarea>
                        </div>
                        </div>
                        <div class="control-group" >
                        <label class="control-label" for="fee_particular_status"><?php echo get_phrase('fee_particular_status');?></label>
                        <div class="controls">
                        	<select name="fee_particular_status" id="fee_particular_status" class="uniform validate[required]">
                                <option value="active" <?php if(isset($fee_particular_status) && $fee_particular_status=='active') echo 'selected' ?>>Active</option>
                                <option value="inactive" <?php if(isset($fee_particular_status) && $fee_particular_status=='inactive') echo 'selected' ?>>Inactive</option>
                            </select>
                        </div>
                        </div>
                        
                        <div class="control-group">
                        <div class="controls">
                        <input type="hidden" value="<?php if(isset($fee_particular_id)) echo $fee_particular_id; ?>" id="fee_particular_id_hid" name="fee_particular_id_hid" />
                        <button type="submit" class="btn btn-lightblue"><?php echo get_phrase('edit_fee_particular');?></button>
                        </div>
                        </div>
                        
                        
                        </form>
                        </div>
                
                </div>
        
        </div>
        
        
		
	</div>
</div>

<script>

$('#fee_particular_name').on('change',function(){
	
	var fp_val = $(this).val();
	var prv_fp_val = $('#fee_particular_name_hid').val();
	var fc_id = $('#fee_category_id').val();
	
	$('#val_fp_val').append('<img title="<?php echo base_url(); ?>template/images/loading.gif" src="<?php echo base_url(); ?>template/images/loading.gif">');
		
		$.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>principal/fee_particular_check/',
							data: { chkfpval:fp_val,chkfcid:fc_id,chk_prv_fp_val:prv_fp_val },
							success: function(data) {
								//alert(data);
								
								if(data=='true'){
									$("#val_fp_val").text('').attr("class","label label-warning").text( "'"+ fp_val +" ' already exists with above fee caregory try another !" );
									$("#fee_particular_name").val(prv_fp_val).focus();
								} else {
									$("#val_fp_val").removeAttr("class").text('').attr("class","label label-success").text( "'"+ fp_val +"' available !" );
									
								}
								
							}
				  });
	
});

$('#fee_particular_type').on('change',function(){
	
	var fp_type = $(this).val();
	
	$('#val_fp_type').append('<img title="<?php echo base_url(); ?>template/images/loading.gif" src="<?php echo base_url(); ?>template/images/loading.gif">');
	
	if(fp_type != '' || fp_type != 'fp_all'){
		
		
		
		$.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>principal/fee_particular_type/',
							data: { get_fp_type:fp_type },
							success: function(data) {
								//alert(data);
								
								$('#val_fp_type').text('');
									
								$('#custom-tam-fp-type-blck').text('').append(data);
								
							}
				  });
	}
	
});

$(document).on('change','#fee_particular_type_cid',function(){
	
	
	var fp_cid = $(this).val();
	
	
	
	$.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>principal/fee_particular_type/',
							data: { get_fp_cid:fp_cid , get_fp_type:'frm_class' },
							success: function(data) {
								//alert(data);
								
								
									
								$('#custom-tam-fp-type-blck-roll').text('').append(data);
								
							}
				  });
	
});
$('#fee_particular_discount').on('change',function(){
	
	var fp_discount = $(this).val();
	
	if(fp_discount > 0){
		
		$('#custom-tam-fp-discount').show(1000);
		
	}else{
		$('#custom-tam-fp-discount').hide(1000);
	}
	
});

$('.fp-roll-view').on('click',function(e){
	
	var fp_rolls = $(this).data('rolls-val');
	var fp_roll_class = $(this).data('roll-class');
	
	//alert(fp_rolls + fp_roll_class );
	
	$('#custom-tam-model-body-roll').text('');
	
	
	$.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>principal/fee_particular_rolls/',
							data: { srolls:fp_rolls , sclass:fp_roll_class },
							success: function(data) {
								//alert(data);
								
								
									
								$('#custom-tam-model-body-roll').text('').append(data);
								
							}
				  });
	
	
	           e.preventDefault();
				$('#custom-tam-model-roll').modal('show');
	
	
});

</script>