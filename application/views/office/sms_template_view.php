<div class="box">
	<div class="box-header">
    
    	<!------CONTROL TABS START------->
		<ul class="nav nav-tabs nav-tabs-left">
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> 
					<?php echo get_phrase('sms_template_list');?>
                    	</a></li>
			<li>
            	<a href="#add" data-toggle="tab"><i class="icon-plus"></i>
					<?php echo get_phrase('add_sms_template');?>
                    	</a></li>
		</ul>
    	<!------CONTROL TABS END------->
        
	</div>
	<div class="box-content padded">
		<div class="tab-content">
            <!----TABLE LISTING STARTS--->
            <div class="tab-pane box <?php if(!isset($edit_data))echo 'active';?>" id="list">
                <table cellpadding="0" cellspacing="0" border="0" class="dTable responsive">
                	<thead>
                		<tr>
                    		<th><div>#</div></th>
                    		<th><div><?php echo get_phrase('sms_template_content');?></div></th>

						<th></th></tr>
					</thead>
                    <tbody>
                    	<?php $count = 1;foreach($sms_templates as $row):?>
                        <tr>
                            <td><?php echo $count++;?></td>
							<td><?php echo $row['sms_template_content'];?></td>
							<td align="center">
                            	<a data-toggle="modal" href="#modal-form" onclick="modal('edit_sms_template',<?php echo $row['sms_template_id'];?>)" class="btn btn-gray btn-small">
                                		<i class="icon-wrench"></i> <?php echo get_phrase('edit');?>
                                </a>
                            	<a data-toggle="modal" href="#modal-delete" onclick="modal_delete('<?php echo base_url();?>admin/sms_template_view/delete/<?php echo $row['sms_template_id'];?>')" class="btn btn-red btn-small">
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
                	<?php echo form_open('admin/sms_template_view/create' , array('class' => 'form-horizontal validatable','target'=>'_top'));?>
                        <div class="padded">
                           
  <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('sms_template_content');?></label>
                                <div class="controls">
                                    <div class="box closable-chat-box">
                                        <div class="box-content padded">
                                                <div class="chat-message-box">
                                                <textarea name="sms_template_content" id="ttt" rows="5" placeholder="<?php echo get_phrase('add_sms_template');?>" class="validate[required]"></textarea>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        <div class="form-actions">
                            <button type="submit" class="btn btn-gray"><?php echo get_phrase('add_sms_template');?></button>
                        </div>
                    </form>                
                </div>                
			</div>
			<!----CREATION FORM ENDS--->
            
		</div>
	</div>
</div>
