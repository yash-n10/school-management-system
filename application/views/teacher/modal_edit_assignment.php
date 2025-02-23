<div class="tab-pane box active" id="edit" style="padding: 5px">
    <div class="box-content">
        <?php foreach($edit_data as $row):?>
        <?php echo form_open('teacher/assignments/do_update/'.$row['assignment_id'] , array('class' => 'form-horizontal validatable','target'=>'_top','enctype'=>'multipart/form-data'));?>
            <div class="padded">
				<div class="control-group">
                                <label class="control-label"><?php echo get_phrase('teacher');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" name="assignment_teacher" readonly value="<?php echo $this->session->userdata('name'); ?>" />
                                </div>
                            </div>
				<div class="control-group">
                                <label class="control-label"><?php echo get_phrase('select_class');?></label>								
                                <div class="controls">									
                                    <select name="assignment_class_id" id="fee_period_cid">
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
												<option value="<?php echo $row_c['class_id'];?>" <?php if($row_c['class_id']==$row['class_id']) echo 'selected'; ?>>
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
									<select id="fee_period_pid" name="subject_id">
										<option value="">-- Select Subject --</option>
									<?php 
											$this->db->where('class_id',$row['class_id']);
											$this->db->where('teacher_id',$this->session->userdata('teacher_id'));
											$classes = $this->db->get('subject')->result_array();									
											foreach($classes as $mineclass)
											{
										?>
										<option value="<?php echo $mineclass['subject_id'];?>" <?php if($mineclass['subject_id']==$row['subject_id']) echo 'selected'; ?> ><?php echo $mineclass['name']; ?></option>
										<?php  } ?>
									</select>
                                </div>
                            </div>	
					
                <div class="control-group">
                    <label class="control-label"><?php echo get_phrase('title');?></label>
                    <div class="controls">
                        <input type="text" class="validate[required]" name="assignment_title" value="<?php echo $row['assignment_title'];?>"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"><?php echo get_phrase('assignment');?></label>
                    <div class="controls">
                        <div class="box closable-chat-box">
                            <div class="box-content padded">
                                    <div class="chat-message-box">
                                    <textarea name="assignment" id="ttt" rows="5" placeholder="<?php echo get_phrase('add_assignment');?>"><?php echo $row['assignment'];?></textarea>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>       
				
				<div class="control-group">
                                <label class="control-label"><?php echo get_phrase('last submission date');?></label>
                                <div class="controls">									
                                    <label class="control-label"><input type="radio" onclick="displayDateApplicable()" class="uniform validate[required]" name="applicable" <?php if($row['create_timestamp']) echo 'checked'; ?>/><?php echo get_phrase(' applicable');?></label><label class="control-label"><input type="radio" onclick="displayDateNot()" class="uniform validate[required]" <?php if(!$row['create_timestamp']) echo 'checked'; ?> name="applicable"/><?php echo get_phrase(' not_applicable');?></label>
                                </div>
                </div>
				<div class="control-group" id="applicable_date2">  
								<?php if($row['create_timestamp']){ ?>
								<label class="control-label" ><?php echo get_phrase('select deadline');?></label>
								<?php } ?>
                                <div class="controls">                                    
									<input type="text"  class="<?php if($row['create_timestamp']){?>datepicker uniform validate[required]"<?php } ?> value="<?php if($row['create_timestamp']) echo date('m/d/Y', $row['create_timestamp']); ?>" id="datepicker_main2" name="create_timestamp"/>
                                </div>
                </div>
				<div class="control-group" id="applicable_date" style="display:none;">
                                <label class="control-label" id="applicable_name"><?php echo get_phrase('select deadline');?></label>
                                <div class="controls">
                                    <input type="text"  class="datepicker  validate[required]" value="<?php if($row['create_timestamp']) echo date('m/d/Y', $row['create_timestamp']); echo 'disabled'; ?>" id="datepicker_main" name="create_timestamp"/>
									<input type="text"  class="uniform validate[required]" id="datepicker_main1" name="create_timestamp" <?php if($row['create_timestamp']) echo 'disabled'; ?>/>
                                </div>
                </div>
				
				<div class="control-group">
                                <label class="control-label"><?php echo get_phrase('Upload File');?></label>
                                <div class="controls" style="width:210px;">
                                    <input type="file" class="" name="assignmentfile" id="assignmentfile" />
                                </div>
                </div>
				<div class="control-group">
                                <div class="controls" style="width:210px;">
								<input type="hidden" value="<?php echo $row['assignment_attachment']; ?>" name="assignmentfile1" />
                                    <?php echo $row['assignment_attachment']; ?>
                                </div>
                </div>
				

            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-gray"><?php echo get_phrase('edit_assignment');?></button>
            </div>
        </form>
        <?php endforeach;?>
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
	document.getElementById("applicable_date2").style.display="none";
	document.getElementById("datepicker_main2").disabled=true;
}

function displayDateNot()
{
	document.getElementById("applicable_name").style.display="none";
	document.getElementById("applicable_date").style.display="block";
	document.getElementById("datepicker_main").style.display="none";
	document.getElementById("datepicker_main").disabled=true;
	document.getElementById("datepicker_main1").style.display="block";
	document.getElementById("datepicker_main1").value="no_final_date";	
	document.getElementById("applicable_date2").style.display="none";
	document.getElementById("datepicker_main2").disabled=true;
}

</script>