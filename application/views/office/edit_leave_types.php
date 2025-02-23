<div class="box">
	<div class="box-content padded">
    
    	<div class="row-fluid">
        
        		<div class="span12">
                		<div class="custom-tam-hr-frm">
                        <?php if(!empty($ltype_data)) extract($ltype_data) ?>
                	    <form class="form-horizontal validatable" method="post" action="<?php echo base_url(); ?>admin/ltypeupdate">
                        <div class="row-fluid">
                        <div class="span6">
                        <div class="control-group">
                        <label class="control-label" for="leave_type_title"><?php echo get_phrase('leave_type_title');?></label>
                        <div class="controls">
                        <input type="text" class="validate[required]" id="leave_type_title" name="leave_type_title" placeholder="Please enter title" value="<?php if(isset($leave_type_title)) echo $leave_type_title ?>">
                        </div>
                        </div>
                        </div>
                        <div class="span6">
                        <div class="control-group">
                        <label class="control-label" for="leave_type_code"><?php echo get_phrase('leave_type_code');?></label>
                        <div class="controls">
                        <input type="text" class="validate[required]" id="leave_type_code" name="leave_type_code" placeholder="Please enter code" value="<?php if(isset($leave_type_code)) echo $leave_type_code ?>">
                        </div>
                        </div>
                        </div>
                        </div>
                        <div class="row-fluid">
                        <div class="span6">
                        <div class="control-group">
                        <label class="control-label" for="leave_type_max_days"><?php echo get_phrase('max_days_allowed');?></label>
                        <div class="controls">
                        	<input type="number" min="1"  name="leave_type_max_days" id="leave_type_max_days" class="validate[required]" placeholder="Please enter max days" value="<?php if(isset($leave_type_max_days)) echo $leave_type_max_days ?>" />
                               
                        </div>
                        </div>
                        </div>
                        <div class="span6">
                        <div class="control-group">
                        <label class="control-label" for="leave_type_status"><?php echo get_phrase('leave_type_status');?></label>
                        <div class="controls">
                        	<select name="leave_type_status" id="leave_type_status" class="validate[required]">
                                <option value="active" <?php if($leave_type_status=='active') echo "selected" ?>>Active</option>
                                <option value="inactive" <?php if($leave_type_status=='inactive') echo "selected" ?>>Inactive</option>
                            </select>
                        </div>
                        </div>
                        </div>
                        </div>
                        <div class="row-fluid">
                        <div class="span6">
                        <div class="control-group">
                        <label class="control-label" for="half_allow_status"><?php echo get_phrase('half_allow_status');?></label>
                        <div class="controls">
                        	<label class="radio inline">
                            <input type="radio" name="half_allow_status" id="half_allow_status_y" value="Y"  <?php if($leave_type_half_allow=='Y') echo "checked" ?>> yes
                            </label>
                            <label class="radio inline">
                            <input type="radio" name="half_allow_status" id="half_allow_status_n" value="N" <?php if($leave_type_half_allow=='N') echo "checked" ?>> no
                            </label>
                        </div>
                        </div>
                        </div>
                        <div class="span6">
                        <div class="control-group">
                        <div class="controls">
                        <input type="hidden" value="<?php if(isset($leave_type_id)) echo $leave_type_id ?>" name="hid_lt_id" id="hid_lt_id" />
                        <button type="submit" class="btn btn-lightblue"><?php echo get_phrase('edit_leave_type');?></button>
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