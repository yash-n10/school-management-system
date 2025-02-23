<div class="tab-pane box active" id="edit" style="padding: 5px">
    <div class="box-content">
        <?php foreach($edit_data as $row):?>
        <?php echo form_open('admin/timetable/do_update/'.$row['timetable_id'] , array('class' => 'form-horizontal validatable','target'=>'_top'));?>
            <div class="padded">
                        <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('timetable_title');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" name="timetable_title" value="<?php echo $row['timetable_title'];?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('timetable_category');?></label>
                                <div class="controls">
                                	<select class="validate[required]" id="timetable_cid" name="timetable_cid">
                                    	<option value="">--- select timetable category ---</option>
                                    	<?php foreach($timetable_categories_view as $timetable_categories_sel):?>
                                        	<option value="<?php echo $timetable_categories_sel['timetable_category_id']; ?>" <?php if($timetable_categories_sel['timetable_category_id'] == $row['timetable_cid'] ) echo "selected"  ?> ><?php echo $timetable_categories_sel['timetable_category_name']; ?></option>
                                        <?php endforeach;?>
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('timetable_content');?></label>
                                <div class="controls">
                                </div>
                               </div>
                            <div class="control-group">
							  
								<?php
								$this->fckeditor->InstanceName = 'timetable_content';

								$this->fckeditor->Value = $row['timetable_content'];

								 $this->fckeditor->create(); ?>			
							 
							</div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('timetable_status');?></label>
                                <div class="controls">
                                   <select name="timetable_status" class="uniform">
                                   	<option value="active" <?php if($row['timetable_status'] == 'active')  echo "selected"; ?>>Active</option>
                                    <option value="inactive" <?php if($row['timetable_status'] == 'inactive')  echo "selected"; ?>>In-active</option>
                                   </select>
                                </div>
                            </div>
                            
                          
                        </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-gray"><?php echo get_phrase('edit_timetable');?></button>
            </div>
        </form>
        <?php endforeach;?>
    </div>
</div>