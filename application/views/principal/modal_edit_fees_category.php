<div class="tab-pane box active" id="edit" style="padding: 5px">
    <div class="box-content">
        <?php foreach($edit_data as $row):?>
        <?php echo form_open('principal/fees_cat/do_update/'.$row['fees_category_id'] , array('class' => 'form-horizontal validatable','target'=>'_top'));?>
            <div class="padded">
                <div class="control-group">
                    <label class="control-label"><?php echo get_phrase('fees_category');?></label>
                    <div class="controls">
                        <input type="text" class="validate[required]" name="feescatname" value="<?php echo $row['fees_category_name'];?>"/>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label"><?php echo get_phrase('fees_category_prefix');?></label>
                    <div class="controls">
                        <input type="text" class="validate[required]" name="feescatprefix" value="<?php echo $row['fees_category_prefix'];?>"/>
                    </div>
                </div>
                
                

            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-gray"><?php echo get_phrase('edit_fees_category');?></button>
            </div>
        </form>
        <?php endforeach;?>
    </div>
</div>