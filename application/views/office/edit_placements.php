<div class="box">
	<div class="box-content padded">
    
    	<div class="row-fluid">
        
        		<div class="span12">
                		<div class="custom-tam-hr-frm">
                        <?php if(!empty($placement_data)) extract($placement_data) ?>
                	    <form class="form-horizontal validatable" method="post" action="<?php echo base_url(); ?>admin/placementupdate">
                        <div class="row-fluid">
                        <div class="span6">
                        <div class="control-group">
                        <label class="control-label" for="placement_title"><?php echo get_phrase('title');?></label>
                        <div class="controls">
                        <input type="text" class="validate[required]" id="placement_title" name="placement_title" placeholder="Please enter title" value="<?php if(isset($placement_title)) echo $placement_title; ?>">
                        </div>
                        </div>
                        </div>
                        <div class="span6">
                        <div class="control-group">
                        <label class="control-label" for="placement_date"><?php echo get_phrase('date');?></label>
                        <div class="controls">
                        <input type="text" class="datepicker fill-up validate[required]" id="placement_date" name="placement_date" placeholder="Please enter date" value="<?php if(isset($placement_date)) echo $placement_date; ?>">
                        </div>
                        </div>
                        </div>
                        </div>
                        <div class="row-fluid">
                        <div class="span6">
                        <div class="control-group">
                        <label class="control-label" for="placement_company"><?php echo get_phrase('company');?></label>
                        <div class="controls">
                        	<input type="text" name="placement_company" id="placement_company" class="validate[required]" placeholder="Please enter company" value="<?php if(isset($placement_company)) echo $placement_company; ?>" />
                               
                        </div>
                        </div>
                        </div>
                        <div class="span6">
                        <div class="control-group">
                        <label class="control-label" for="placement_description"><?php echo get_phrase('description');?></label>
                        <div class="controls">
                        	<textarea name="placement_description" id="placement_description" class="validate[required]" style="resize:none;"><?php if(isset($placement_description)) echo $placement_description; ?></textarea>
                        </div>
                        </div>
                        </div>
                        </div>
                        <div class="row-fluid">
                        <div class="span6">
                        <div class="control-group">
                        <label class="control-label" for="placement_status"><?php echo get_phrase('placement_status');?></label>
                        <div class="controls">
                        	<select name="placement_status" id="placement_status" class="validate[required]">
                                <option value="active" <?php if(isset($placement_status) && $placement_status=='active' ) echo "selected"; ?> >Active</option>
                                <option value="inactive" <?php if(isset($placement_status) && $placement_status=='inactive' ) echo "selected"; ?>>Inactive</option>
                            </select>
                        </div>
                        </div>
                        </div>
                        <div class="span6">
                        <div class="control-group">
                        <div class="controls">
                        <input type="hidden" value="<?php if(isset($placement_id)) echo $placement_id; ?>" name="hid_psl_id" id="hid_psl_id" />
                        <button type="submit" class="btn btn-lightblue"><?php echo get_phrase('edit_placement');?></button>
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