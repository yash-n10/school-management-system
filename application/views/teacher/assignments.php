
<div class="box">
	<div class="box-header">
    
    	<!------CONTROL TABS START------->
		<ul class="nav nav-tabs nav-tabs-left">
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> 
					<?php echo get_phrase('assignment_list');?>
                    	</a></li>
			<li>
            	<a href="#add" data-toggle="tab"><i class="icon-plus"></i>
					<?php echo get_phrase('add_assignment');?>
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
                    		<th><div>#</div></th>
							<th><div><?php echo get_phrase('teacher');?></div></th>
							<th><div><?php echo get_phrase('class');?></div></th>
							<th><div><?php echo get_phrase('subject');?></div></th>
                    		<th><div><?php echo get_phrase('title');?></div></th>
                    		<th><div><?php echo get_phrase('assignment');?></div></th>
							<th><div><?php echo get_phrase('posted_date');?></div></th>
                    		<th><div><?php echo get_phrase('submission_date');?></div></th>
                    		<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php $count = 1;foreach($assignments as $row):?>
                        <tr>
                            <td><?php echo $count++;?></td>
							<td><?php echo $row['assignment_teacher'];?></td>
							<td><?php
								$this->db->where('class_id',$row['class_id']);
								$total_class = $this->db->get('class')->result_array();							
								foreach($total_class as $sub_class)
									echo $sub_class['name'].'-'.$sub_class['name_numeric'];
							?></td>
							<td><?php
								$this->db->where('subject_id',$row['subject_id']);
								$total_class = $this->db->get('subject')->result_array();							
								foreach($total_class as $sub_class)
									echo $sub_class['name'];
							?></td>
							<td><?php echo $row['assignment_title'];?></td>
							<td class="span2"><?php echo $row['assignment'];?></td>
							<td><?php  if($row['posted_on']){ echo date('d M,Y', $row['posted_on']);} ?></td>
							<td><?php if($row['create_timestamp']){ echo date('d M,Y', $row['create_timestamp']);}else echo "no deadline";?></td>
							<td align="center">
                            	<a data-toggle="modal" href="#modal-form" onclick="modal('edit_assignment',<?php echo $row['assignment_id'];?>)" class="btn btn-gray btn-small">
                                		<i class="icon-wrench"></i> <?php echo get_phrase('edit');?>
                                </a>
                            	<a data-toggle="modal" href="#modal-delete" onclick="modal_delete('<?php echo base_url();?>teacher/assignments/delete/<?php echo $row['assignment_id'];?>')" class="btn btn-red btn-small">
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
                	<?php echo form_open('teacher/assignments/create' , array('class' => 'form-horizontal validatable','target'=>'_top','enctype'=>'multipart/form-data'));?>
                        <div class="padded">
						
							<div class="control-group">
                                <label class="control-label"><?php echo get_phrase('teacher');?></label>
                                <div class="controls">
                                    <input type="text" name="assignment_teacher" readonly value="<?php echo $this->session->userdata('name'); ?>" />
                                </div>
                            </div>
							<div class="control-group">
                                <label class="control-label"><?php echo get_phrase('select_class');?></label>								
                                <div class="controls">									
                                    <select class="uniform validate[required]" name="assignment_class_id" id="fee_period_cid">
										<option value=""><?php echo get_phrase('select_a_class');?></option>
										<?php
										$value=$this->session->userdata('teacher_id');										
											$this->db->where('teacher_id',$value);
											$this->db->group_by('class_id');	
											$classes = $this->db->get('subject')->result_array();										
											print_r($classes);
											foreach($classes as $rows)
											{		
												$this->db->select('*');
												$this->db->where('class_id',$rows['class_id']);
												$classes1 = $this->db->get('class')->result_array();
											foreach($classes1 as $row_c):
											?>
												<option value="<?php echo $row_c['class_id'];?>">
														<?php echo $row_c['name'].'-'.$row_c['name_numeric'];?></option>
											<?php
											endforeach;
											}
											?>
									</select>
									<span id="val_fc_id"></span>
                                </div>
                            </div>	
							<div class="control-group">
                                <label class="control-label"><?php echo get_phrase('select_subject');?></label>
                                <div class="controls">
                                    <select class="uniform validate[required]" id="fee_period_pid" name="subject_id">
										<option value="">-- Select Subject --</option>
									</select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('title');?></label>
                                <div class="controls">
                                    <input type="text" class="uniform validate[required]" name="assignment_title"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('assignment');?></label>
                                <div class="controls">
                                    <div class="box closable-chat-box">
                                        <div class="box-content padded">
                                                <div class="chat-message-box">
                                                <textarea class="uniform validate[required]" name="assignment" id="ttt" rows="5" placeholder="<?php echo get_phrase('add_assignment');?>"></textarea>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                           
							<div class="control-group">
                                <label class="control-label"><?php echo get_phrase('last submission date');?></label>
                                <div class="controls">
                                    <label class="control-label"><input type="radio" onclick="displayDateApplicable()" class="uniform validate[required]" name="applicable"/><?php echo get_phrase(' applicable');?></label><label class="control-label"><input type="radio" onclick="displayDateNot()" class="uniform validate[required]" name="applicable"/><?php echo get_phrase(' not_applicable');?></label>
                                </div>
                            </div>
							<div class="control-group" id="applicable_date" style="display:none;">
                                <label class="control-label" id="applicable_name"><?php echo get_phrase('select deadline');?></label>
                                <div class="controls">
                                    <input type="text"  class="datepicker fill-up validate[required]" id="datepicker_main" name="create_timestamp"/>
									<input type="text"  class="uniform validate[required]" id="datepicker_main1" name="create_timestamp"/>
                                </div>
                            </div>
							<div class="control-group" >
                                <label class="control-label"><?php echo get_phrase('Upload File');?></label>
                                <div class="controls" style="width:210px;">
                                    <input type="file" class="uniform validate[required]" name="assignmentfile" id="assignmentfile" />
                                </div>
                            </div>
							
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-blue"><?php echo get_phrase('add_assignment');?></button>
                        </div>
                    </form>                
                </div>                
			</div>
			<!----CREATION FORM ENDS--->
            
		</div>
	</div>
</div>

<script>
$('#fee_period_cid').on('change',function(){
	
	
	
	var fc_id = $(this).val();
	
	
	
	$('#val_fc_id').append('<img title="<?php echo base_url(); ?>template/images/loading.gif" src="<?php echo base_url(); ?>template/images/loading.gif">');
	
	
		
		
		$.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>teacher/assignments_subjects/',
							data: { get_fc_id:fc_id },
							success: function(data) {
								//alert(data);
								
								$('#val_fc_id').text('');
									
								$('#fee_period_pid').text('').append(data);
								
							}
				  });
	
	
});

function displayDateApplicable()
{
	document.getElementById("applicable_name").style.display="block";
	document.getElementById("applicable_date").style.display="block";
	document.getElementById("datepicker_main1").style.display="none";
	document.getElementById("datepicker_main1").disabled=true;
	document.getElementById("datepicker_main").disabled=false;
	document.getElementById("datepicker_main").style.display="block";
}

function displayDateNot()
{
	document.getElementById("applicable_name").style.display="none";
	document.getElementById("applicable_date").style.display="block";
	document.getElementById("datepicker_main").style.display="none";
	document.getElementById("datepicker_main").disabled=true;
	document.getElementById("datepicker_main1").style.display="block";
	document.getElementById("datepicker_main1").value="no_final_date";	
}

</script>