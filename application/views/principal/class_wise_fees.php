<div class="box">
	<div class="box-header">
    
    	<!------CONTROL TABS START------->
		<ul class="nav nav-tabs nav-tabs-left">
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> 
					<?php echo get_phrase('class_wise_fees_list');?>
                    	</a></li>
			<li>
            	<a href="#add" data-toggle="tab"><i class="icon-plus"></i>
					<?php echo get_phrase('add_class_wise_fees');?>
                    	</a></li>
                    	
		</ul>
    	<!------CONTROL TABS END------->
        
	</div>
	<div class="box-content padded">
		<div class="tab-content">            
            <!----TABLE LISTING STARTS--->
            <div class="tab-pane box active" id="list">
				
                <table cellpadding="0" cellspacing="0" border="0" class="dTable responsive">
                	<thead>
                		<tr>
                    		<th><div><?php echo get_phrase('s.no');?></div></th>
                    		<th><div><?php echo get_phrase('class');?></div></th>
                            <th><div><?php echo get_phrase('fee_category');?></div></th>
                             <th><div><?php echo get_phrase('fee_amount');?></div></th>
                    		<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php
                    	 $class_results=array();
                    	 $classes = $this->db->get('class')->result_array();
						 foreach ($classes as $classe) {
							 $class_results[$classe['class_id']]=$classe['name'];
						 }
						 
						 
						 $fee_categorys_results=array();
                    	 $fee_categorys = $this->db->get('fees_category')->result_array();
						 foreach ($fee_categorys as $fee_category) {
							 $fee_categorys_results[$fee_category['fees_category_id']]=$fee_category['fees_category_name'];
						 }
						 
                    	 $count = 1;foreach($class_wise_fees as $row):?>
                        <tr>
                        	<td><?php echo $count++; ?></td>
                            <td><?php
                            if(!empty($class_results[$row['class']])){
                            	echo $class_results[$row['class']];
                            }
                             ?></td>
                              <td><?php
                            if(!empty($fee_categorys_results[$row['fee_category']])){
                            	echo $fee_categorys_results[$row['fee_category']];
                            }
                             ?></td>
                            <td><?php echo $row['fee_amount']; ?></td>
                            <td align="center">
                            	<a data-toggle="modal" href="#modal-form" onclick="modal('edit_class_wise_fees',<?php echo $row['fee_amount_id'];?>)" class="btn btn-gray btn-small">
                                		<i class="icon-wrench"></i> <?php echo get_phrase('edit');?>
                                </a>
                            	<a data-toggle="modal" href="#modal-delete" onclick="modal_delete('<?php echo base_url();?>principal/class_wise_fees/delete/<?php echo $row['fee_amount_id'];?>')" class="btn btn-red btn-small">
                                		<i class="icon-trash"></i> <?php echo get_phrase('delete');?>
                                </a>
        					</td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
			</div>
            <!----TABLE LISTING ENDS--->
            
            
			<!----CREATION FORM STARTS---->
			<div class="tab-pane box" id="add" style="padding: 5px">
                <div class="box-content">
                	<?php echo form_open('principal/class_wise_fees/create' , array('class' => 'form-horizontal validatable','target'=>'_top'));?>
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
				
				                            <option value="<?php echo $classe['class_id'];?>">
				
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
				
				                        foreach($fee_categorys as $row):
				
				                        ?>
				
				                            <option value="<?php echo $row['fees_category_id'];?>"
				
				                            	<?php if($class_id == $row['fees_category_id'])echo 'selected';?>>
				
				                                	<?php echo $row['fees_category_name'];?></option>
				
				                        <?php
				
				                        endforeach;
				
				                        ?>
				
				                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('fee_amount');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" name="fee_amount_name"/>
                                </div>
                            </div>
                          <!--  <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('class');?></label>
                                <div class="controls">
                                    <select name="class_id" class="uniform" style="width:100%;">
                                    	<?php 
										$classes = $this->db->get('class')->result_array();
										foreach($classes as $row):
										?>
                                    		<option value="<?php echo $row['class_id'];?>"><?php echo $row['name'];?></option>
                                        <?php
										endforeach;
										?>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('teacher');?></label>
                                <div class="controls">
                                    <select name="teacher_id" class="uniform" style="width:100%;">
                                    	<?php 
										$teachers = $this->db->get('teacher')->result_array();
										foreach($teachers as $row):
										?>
                                    		<option value="<?php echo $row['teacher_id'];?>"><?php echo $row['name'];?></option>
                                        <?php
										endforeach;
										?>
                                    </select>
                                </div>
                            </div>-->
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-gray"><?php echo get_phrase('add_class_wise_fees');?></button>
                        </div>
                    </form>                
                </div>                
			</div>
			<!----CREATION FORM ENDS--->
            
		</div>
	</div>
</div>