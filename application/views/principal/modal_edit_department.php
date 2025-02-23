<div class="tab-pane box active" id="edit" style="padding: 5px">
    <div class="box-content">
        <?php foreach($edit_data as $row):?>
        <?php echo form_open('principal/departments/do_update/'.$row['department_id'] , array('class' => 'form-horizontal validatable','target'=>'_top'));?>
            <div class="padded">
                <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('department_name');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" name="department_name" value="<?php echo $row['department_name'] ?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('department_status');?></label>
                                <div class="controls">
                                   <select name="department_status" class="uniform">
                                   	<option value="active" <?php if($row['department_status'] == 'active') echo "selected"; ?>>Active</option>
                                    <option value="inactive" <?php if($row['department_status'] == 'inactive') echo "selected"; ?>>In-active</option>
                                   </select>
                                </div>
                            </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-gray"><?php echo get_phrase('edit_department');?></button>
            </div>
        </form>
        <?php endforeach;?>
    </div>
</div>