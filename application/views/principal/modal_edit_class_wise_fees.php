<div class="tab-pane box active" id="edit" style="padding: 5px">
    <div class="box-content">
        <?php foreach($edit_data as $row):?>
        <?php echo form_open('principal/class_wise_fees/do_update/'.$row['fee_amount_id'] , array('class' => 'form-horizontal validatable','target'=>'_top'));?>
            <div class="padded">
               				<div class="control-group">
                                <label class="control-label"><?php echo get_phrase('class');?></label>
                                <div class="controls">
                                    <select class="validate[required]" name="classname">

				                    	<option value=""><?php echo get_phrase('select_a_class');?></option>
				
										<?php 
				
				                        $classes = $this->db->get('class')->result_array();
				
				                        foreach($classes as $classe):
				
				                        ?>
				
				                            <option value="<?php echo $classe['class_id'];?>"
				
				                            	<?php if($row['class'] == $classe['class_id'])echo 'selected';?>>
				
				                                	Class <?php echo $classe['name'];?></option>
				
				                        <?php
				
				                        endforeach;
				
				                        ?>
				
				                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('fee_category');?></label>
                                <div class="controls">
                                    <select  class="validate[required]" name="fee_category_name">

				                    	<option value=""><?php echo get_phrase('select_fees_category');?></option>
				
										<?php 
				
				                        $fee_categorys = $this->db->get('fees_category')->result_array();
				
				                        foreach($fee_categorys as $fee_category):
				
				                        ?>
				
				                            <option value="<?php echo $fee_category['fees_category_id'];?>"
				
				                            	<?php if($row['fee_category'] == $fee_category['fees_category_id'])echo 'selected';?>>
				
				                                	<?php echo $fee_category['fees_category_name'];?></option>
				
				                        <?php
				
				                        endforeach;
				
				                        ?>
				
				                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('fee_amount');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" name="fee_amount_name" value="<?php echo $row['fee_amount'];?>"/>
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