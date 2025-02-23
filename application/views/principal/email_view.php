<div class="box">
	<div class="box-header">
    
    	<!------CONTROL TABS START------->
		<ul class="nav nav-tabs nav-tabs-left">
			<li class="active">
                            <a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> 
				<?php echo get_phrase('send_email');?>
                            </a>
                        </li>
    	<!------CONTROL TABS END------->        
	</div>
    
	<div class="box-content padded">
		<div class="tab-content">
            <!----TABLE LISTING STARTS--->
            <div class="tab-pane box <?php if(!isset($edit_data))echo 'active';?>" id="list">
                <div class="box-content">
                	<?php echo form_open('principal/email_view/'.$ac_type.'/send' , array('class' => 'form-horizontal validatable','target'=>'_top'));?>
                        <div class="padded">
<!--                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('student_class');?></label>
                                <div class="controls">
                                    <input type="text"  readonly value="<?php echo $class_name; ?>" name="student_class" size="35" />
                                </div>
                           </div>-->
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('account_type');?></label>
                                <div class="controls">
                                    <input type="text" id="" readonly  value="<?php echo $ac_type; ?>" name="account_type"  />
                                </div>
                           </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('email_subject');?></label>
                                <div class="controls">
                                    <input type="text" id="" name="email_recepients1"  />
                                </div>
                           </div>
                    
                            <div class="control-group">
                                    <label class="control-label"><?php echo get_phrase('email_body'); ?></label>
                                    <div class="controls">
                                        <div class="box closable-chat-box">
                                            <div class="box-content padded">
                                                <div class="chat-message-box">
                                                    <textarea name="send_email_body" id="ttt" rows="5" placeholder="<?php echo get_phrase('send_email'); ?>" class="validate[required]"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-gray"><?php echo get_phrase('send_email'); ?></button>
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

