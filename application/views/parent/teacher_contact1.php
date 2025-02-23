 <?php
    
//    echo '<pre>';
//    print_r($student_detail);
//    die
    ?>
<div class="box">
       <div class="box-header">
        <!------CONTROL TABS START------->

        <ul class="nav nav-tabs nav-tabs-left">
            <li class="active">
                <a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> 
                    <?php echo get_phrase('teacher_contact'); ?>
                </a>
            </li>
        </ul>

        <!------CONTROL TABS END------->
    </div>
    <div class="box-content padded">
		<div class="tab-content">
            <!----TABLE LISTING STARTS--->
            <div class="tab-pane box <?php if(!isset($edit_data))echo 'active';?>" id="list">
                <div class="box-content">
                	<?php echo form_open('parents/teacher_enquiry/send' , array('class' => 'form-horizontal validatable','target'=>'_top'));?>
                        <div class="padded">
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('student_name');?></label>
                                <div class="controls">
                                    <input type="text"  readonly value="<?php echo $student_detail->name; ?>" name="student_name" size="35" />
                                </div>
                           </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('class_name');?></label>
                                <div class="controls">
                                    <input type="text"  readonly value="<?php echo $student_detail->class_id; ?>" name="student_class" size="35" />
                                </div>
                           </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('select teacher');?></label>
                                <select name="teacher" style="margin-left:20px;">

                                <option value=""><?php echo get_phrase('select teacher');?></option>

                                <?php 
                                foreach($teacher_detail as $row):
                                ?>
                                    <option value="<?php echo $row['teacher_id'];?>"><?php echo $row['teacher_name'];?></option>

                                <?php

                                endforeach;

                                ?>

                            </select>
                            </div>
                            <div class="control-group">
                                    <label class="control-label"><?php echo get_phrase('teacher_enquiry'); ?></label>
                                    <div class="controls">
                                        <div class="box closable-chat-box">
                                            <div class="box-content padded">
                                                <div class="chat-message-box">
                                                    <textarea name="teacher_enquiry" id="teacher_enquiry" rows="5" placeholder="<?php echo get_phrase('teacher_enquiry'); ?>" class="validate[required]"></textarea>
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
            <!----TABLE LISTING ENDS--->
            </div>
<!----CREATION FORM STARTS---->
	</div>
</div>
</div>
