<div class="box">
	<div class="box-header">
    
    	<!------CONTROL TABS START------->
		<ul class="nav nav-tabs nav-tabs-left">
		<?php if($page_type==2) {?>
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> 
					<?php echo get_phrase('timetable_categories_list');?>
                    	</a></li>
			<li>
            	<a href="#add" data-toggle="tab"><i class="icon-plus"></i>
					<?php echo get_phrase('add_timetable_category');?>
                    	</a></li>
		<?php } ?>
		<?php if($page_type==1) {?>
			 <li class="active">
            	<a href="#timetablelist" data-toggle="tab"><i class="icon-align-justify"></i> 
					<?php echo get_phrase('timetables_list');?>
                    	</a></li>
           <li >
            	<a href="#add_timetable" data-toggle="tab"><i class="icon-plus"></i>
					<?php echo get_phrase('add_timetable');?>
                    	</a></li>
          
		<?php } ?>
		</ul>
    	<!------CONTROL TABS END------->
        
	</div>
	<div class="box-content padded">
		<div class="tab-content"> 
			<?php if($page_type==2) {?>
            <!----TABLE LISTING STARTS--->
            <div class="tab-pane box active" id="list">				
                <table cellpadding="0" cellspacing="0" border="0" class="dTable responsive">
                	<thead>
                		<tr>
                    		<th><div><?php echo get_phrase('sno');?></div></th>
                    		<th><div><?php echo get_phrase('timetable_category_name');?></div></th>
                            <th><div><?php echo get_phrase('timetable_category_status');?></div></th>
                    		<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php $count = 1;foreach($timetable_categories as $timetable_categories_list):?>
                        <tr>
                        	<td><?php echo $count++; ?></td>
                            <td><?php echo $timetable_categories_list['timetable_category_name']; ?></td>
                            <td><?php echo ucfirst($timetable_categories_list['timetable_category_status']); ?></td>
							<td align="center">
                            	<a data-toggle="modal" href="#modal-form" onclick="modal('edit_timetable_category',<?php echo $timetable_categories_list['timetable_category_id'];?>)" class="btn btn-gray btn-small">
                                		<i class="icon-wrench"></i> <?php echo get_phrase('edit');?>
                                </a>
                            	<a data-toggle="modal" href="#modal-delete" onclick="modal_delete('<?php echo base_url();?>principal/timetable_category/delete/<?php echo $timetable_categories_list['timetable_category_id'];?>')" class="btn btn-red btn-small">
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
                	<?php echo form_open('principal/timetable_category/create' , array('class' => 'form-horizontal validatable','target'=>'_top'));?>
                        <div class="padded">
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('timetable_category_name');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" name="timetable_category_name"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('timetable_category_status');?></label>
                                <div class="controls">
                                   <select name="timetable_category_status" class="uniform validate[required]">
								   <option value="">-- Time Table Status --&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                   	<option value="active">Active</option>
                                    <option value="inactive">In-active</option>
                                   </select>
                                </div>
                            </div>
                            
                          
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-gray"><?php echo get_phrase('add_timetable_category');?></button>
                        </div>
                    </form>                
                </div>                
			</div>
			<!----CREATION FORM ENDS--->
			<?php } ?>
            <?php if($page_type==1) {?>
            <!----CREATION TIME TABLE FORM STARTS---->
			<div class="tab-pane box" id="add_timetable" style="padding: 5px">
                <div class="box-content">
                	<?php echo form_open('principal/timetable/create' , array('class' => 'form-horizontal validatable','enctype' => 'multipart/form-data','target'=>'_top'));?>
                        <div class="padded">
                        <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('timetable_title');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" name="timetable_title"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('timetable_category');?></label>
                                <div class="controls">
                                	<select class="uniform validate[required]" id="timetable_cid" name="timetable_cid">
                                    	<option value="">select timetable category</option>
                                    	<?php foreach($timetable_categories_view as $timetable_categories_sel):?>
                                        	<option value="<?php echo $timetable_categories_sel['timetable_category_id']; ?>"><?php echo $timetable_categories_sel['timetable_category_name']; ?></option>
                                        <?php endforeach;?>
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="control-group">
							  <label class="control-label" for="timetable_content"><?php echo get_phrase('timetable_content');?></label>
							  <div class="controls">
								<?php
								$this->fckeditor->InstanceName = 'timetable_content';

								//$this->fckeditor->Value = 'the default content inside the editor';

								 $this->fckeditor->create(); ?>			
							  </div>
							</div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('timetable_status');?></label>
                                <div class="controls">
                                   <select name="timetable_status" class="uniform validate[required]">
									<option value="">&nbsp;&nbsp;-- Time Table Status --&nbsp;</option>
                                   	<option value="active">Active</option>
                                    <option value="inactive">In-active</option>
                                   </select>
                                </div>
                            </div>
                            
                          
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-gray"><?php echo get_phrase('add_timetable');?></button>
                        </div>
                    </form>                
                </div>                
			</div>
			<!----CREATION TIME TABLE FORM ENDS--->
            
            <!----TABLE LISTING STARTS--->
            <div class="tab-pane box active" id="timetablelist">
				
                <table cellpadding="0" cellspacing="0" border="0" class="dTable responsive">
                	<thead>
                		<tr>
                    		<th><div><?php echo get_phrase('sno');?></div></th>
                    		<th><div><?php echo get_phrase('timetable_title');?></div></th>
                            <th><div><?php echo get_phrase('timetable_category');?></div></th>
                            <th><div><?php echo get_phrase('timetable_status');?></div></th>
                    		<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php $count = 1;foreach($timetable_view as $timetable_view_list):?>
                        <tr>
                        	<td><?php echo $count++; ?></td>
                            <td><?php echo $timetable_view_list['timetable_title']; ?></td>
                            <td><?php echo $timetable_view_list['cname']; ?></td>
                            <td><?php echo ucfirst($timetable_view_list['timetable_status']); ?></td>
							<td align="center">
                            	<a data-toggle="modal" href="#modal-form" onclick="modal('edit_timetable',<?php echo $timetable_view_list['timetable_id'];?>)" class="btn btn-gray btn-small">
                                		<i class="icon-wrench"></i> <?php echo get_phrase('edit');?>
                                </a>
                            	<a data-toggle="modal" href="#modal-delete" onclick="modal_delete('<?php echo base_url();?>principal/timetable/delete/<?php echo $timetable_view_list['timetable_id'];?>')" class="btn btn-red btn-small">
                                		<i class="icon-trash"></i> <?php echo get_phrase('delete');?>
                                </a>
        					</td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
			</div>
            <!----TABLE LISTING ENDS--->
			<?php } ?>
            
		</div>
	</div>
</div>