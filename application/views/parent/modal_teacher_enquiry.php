<div class="box-content">
    
                	<?php echo form_open('parents/teacher_enquiry/send' , array('class' => 'form-horizontal validatable','target'=>'_top'));?>
                        <input type="hidden" name="class_id" value="<?php echo $info -> class_id; ?>" >
                        <input type="hidden" name="teacher_id" value="<?php echo $info -> teacher_id; ?>" >
                        <input type="hidden" name="subject_id" value="<?php echo $info -> subject_id; ?>" >
                        
                           <div class="padded">
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('student_name');?></label>
                                <div class="controls">
                                    <input type="text"  readonly value="<?php echo $info ->student_name; ?>" name="student_name" size="35" />
                                </div>
                           </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('class_name');?></label>
                                <div class="controls">
                                    <input type="text"  readonly value="<?php echo $info ->class_name; ?>" name="student_class" size="35" />
                                </div>
                           </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('subject');?></label>
                                <div class="controls">
                                    <input type="text"  readonly value="<?php echo $info ->name; ?>" name="student_class" size="35" />
                                </div>
                           </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('teacher');?></label>
                                <div class="controls">
                                    <input type="text"  readonly value="<?php echo $info->teacher_name; ?>" name="teacher_name" size="35" />
                                </div>
                            </div>
                            <div class="control-group">
                                    <label class="control-label"><?php echo get_phrase('teacher_enquiry'); ?></label>
                                    <div class="controls">
                                        <div class="box closable-chat-box">
                                            <div class="box-content padded">
                                                <div class="chat-message-box">
                                                    <textarea name="enquiry" id="teacher_enquiry" rows="5" placeholder="<?php echo get_phrase('teacher_enquiry'); ?>" class="validate[required]"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-gray"><?php echo get_phrase('send_enquiry'); ?></button>
                                    </div>
                            </div>
                       </div>
		</div>