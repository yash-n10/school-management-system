<div class="tab-pane box active" id="edit" style="padding: 5px">
    <div class="box-content">
        <?php foreach($edit_data as $row):?>
        <?php echo form_open('principal/employee_category/do_update/'.$row['employee_category_id'] , array('class' => 'form-horizontal validatable','target'=>'_top'));?>
            <div class="padded">
                <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('employee_category_name');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" name="employee_category_name" value="<?php echo $row['employee_category_name'] ?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('employee_category_status');?></label>
                                <div class="controls">
                                   <select name="employee_category_status" class="uniform">
                                   	<option value="active" <?php if($row['employee_category_status'] == 'active') echo "selected"; ?>>Active</option>
                                    <option value="inactive" <?php if($row['employee_category_status'] == 'inactive') echo "selected"; ?>>In-active</option>
                                   </select>
                                </div>
                            </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-gray"><?php echo get_phrase('edit_employee_category');?></button>
            </div>
        </form>
        <?php endforeach;?>
    </div>
</div>