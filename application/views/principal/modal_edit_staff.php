<div class="tab-pane box active" id="edit" style="padding: 5px">
                <div class="box-content">
                	<?php foreach($edit_data as $row):?>
                    <?php echo form_open('principal/staff/do_update/'.$row['staff_id'] , array('class' => 'form-horizontal validatable','target'=>'_top', 'enctype' => 'multipart/form-data'));?>
                        <div class="padded">
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('name');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" name="name" value="<?php echo $row['name'];?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('employee_code');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" name="employee_code" id="emp_code_val" placeholder="Employee Code" value="<?php echo $row['employee_code'];?>"/>
                                    <input type="hidden" id="emp_code_val_hid" value="<?php echo $row['employee_code'];?>" />
                                    
                                    <span id="val_emp_code_img"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('department');?></label>
                                <div class="controls">
                                    <select class="uniform validate[required]" name="employee_department_id">
                                    <option value="">-- Select Department --</option> 
                                    <?php foreach($departments as $departments_list){ ?>
											<option value="<?php echo $departments_list['department_id']  ?>" <?php if($row['employee_department_id'] == $departments_list['department_id']) echo "selected"; ?>><?php echo $departments_list['department_name']  ?></option> 
									 <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('gender');?></label>
                                <div class="controls">
                                    <select name="sex" class="uniform" style="width:100%;">
                                        <option value="male" <?php if($row['sex'] == 'male')echo 'selected';?>><?php echo get_phrase('male');?></option>
                                        <option value="female" <?php if($row['sex'] == 'female')echo 'selected';?>><?php echo get_phrase('female');?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('birthday');?></label>
                                <div class="controls">
                                    <input type="text" class="datepicker fill-up" name="birthday" value="<?php echo $row['birthday'];?>"/>
                                </div>
                            </div>
                            <div class="control-group">

                                <label class="control-label"><?php echo get_phrase('religion'); ?></label>

                                <div class="controls">

                                    <input type="text" class="" name="religion" value="<?php echo $row['religion'];?>" />
                                </div>

                            </div>
                            <div class="control-group">

                                <label class="control-label"><?php echo get_phrase('cast'); ?></label>

                                <div class="controls">

                                    <input type="text" class="" name="cast" value="<?php echo $row['cast'];?>" />
                                </div>

                            </div>
                            <div class="control-group">

                                <label class="control-label"><?php echo get_phrase('tam_username'); ?></label>

                                <div class="controls">

                                    <input type="text" class="" name="email" id="staff_uname_val" value="<?php echo $row['email'];?>"/>
                                    <input type="hidden" id="staff_uname_val_hid" value="<?php echo $row['email'];?>" />
									<span id="val_uname_img"></span>
                                </div>

                            </div>

                            <div class="control-group">

                                <label class="control-label"><?php echo get_phrase('tam_password'); ?></label>

                                <div class="controls">

                                    <input type="text" class="" name="password" value="<?php echo $row['password'];?>"/>

                                </div>

                            </div>
                            <div class="control-group">

                                <label class="control-label"><?php echo get_phrase('blood_group'); ?></label>

                                <div class="controls">

                                    <input type="text" class="" name="blood_group" value="<?php echo $row['blood_group'];?>" />

                                </div>

                            </div>
                            <div class="control-group">

                                <label class="control-label"><?php echo get_phrase('subject'); ?></label>

                                <div class="controls">

                                    <textarea name="subject" rows="6" columns="4"><?php echo $row['subject'];?></textarea>

                                </div>

                            </div>
                            <div class="control-group">

                                <label class="control-label"><?php echo get_phrase('previous_school_name'); ?></label>

                                <div class="controls">

                                    <input type="text" class="" name="previous_school_name" value="<?php echo $row['previous_school_name'];?>"/>

                                </div>

                            </div>
                            <div class="control-group">

                                <label class="control-label"><?php echo get_phrase('present_address'); ?></label>

                                <div class="controls">

                                    <textarea name="address" rows="6" columns="4"><?php echo $row['address'];?></textarea>

                                </div>

                            </div>

                            <div class="control-group">

                                <label class="control-label"><?php echo get_phrase('permanent_address'); ?></label>

                                <div class="controls">

                                    <textarea name="permanent_address" rows="6" columns="4"><?php echo $row['permanent_address'];?></textarea>
                                    
                                </div>

                            </div>

                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('phone');?></label>
                                <div class="controls">
                                    <input type="text" class="" name="phone" value="<?php echo $row['phone'];?>"/>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('staff email');?></label>
                                <div class="controls">
                                    <input type="text" class="" name="staff_email" id="staff_email_val" value="<?php echo $row['staff_email'];?>"/>
                                    <input type="hidden" id="staff_email_val_hid" value="<?php echo $row['staff_email'];?>" />
                                     <span id="val_email_img"></span>   
                                </div>
                            </div>
                            <div class="control-group">

                                <label class="control-label"><?php echo get_phrase('father\husband\guardian name'); ?></label>

                                <div class="controls">

                                    <input type="text" class="" name="father_name" value="<?php echo $row['father_name'];?>"/>
                    

                                </div>

                            </div>
                            <div class="control-group">

                                <label class="control-label"><?php echo get_phrase('father\husband\guardian mobile number'); ?></label>

                                <div class="controls">

                                    <input type="text" class="" name="father_mobile_number" value="<?php echo $row['father_mobile_number'];?>">
                                
                                </div>

                            </div>
                            <!--
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('password');?></label>
                                <div class="controls">
                                    <input type="text" class="" name="password" value="<?php echo $row['password'];?>"/>
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('address');?></label>
                                <div class="controls">
                                    <input type="text" class="" name="address" value="<?php echo $row['address'];?>"/>
                                </div>
                            </div>
                            -->
                            
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('photo');?></label>
                                <div class="controls" style="width:210px;">
                                    <input type="file" class="" name="userfile" id="imgInp" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"></label>
                                <div class="controls" style="width:210px;">
                                    <img id="blah" src="<?php echo $this->crud_model->get_image_url('staff',$row['staff_id']);?>" alt="your image" height="100" />
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-gray"><?php echo get_phrase('edit_staff');?></button>
                        </div>
                    </form>
                    <?php endforeach;?>
                </div>
			</div>
            
<script>

$('#emp_code_val').on('change',function(){
		var tcode = $(this).val();
		var prvtcode = $('#emp_code_val_hid').val();
		
		$('#val_emp_code_img').append('<img title="<?php echo base_url(); ?>template/images/loading.gif" src="<?php echo base_url(); ?>template/images/loading.gif">');
		
		$.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>principal/schcodecheck/',
							data: { chkcode:tcode , prevchkcode:prvtcode },
							success: function(data) {
								if(data=='true'){
									$("#val_emp_code_img").text('').attr("class","label label-warning").text( "'"+ tcode +" ' already register!" );
									$("#emp_code_val").val(prvtcode).focus();
								} else {
									$("#val_emp_code_img").removeAttr("class").text('').attr("class","label label-success").text( "'"+ tcode +"' available !" );
									
								}
								
							}
				  });
		
	});
	
$('#staff_uname_val').on('change',function(){
	
	
		
		var temail = $(this).val();
		var ptemail = $('#staff_uname_val_hid').val();
		
		//alert(temail + ptemail );
		
		 if (!validateEmail(temail)) {
			$("#val_uname_img").removeAttr("class").attr("class","label label-warning").text('').text('Please enter valid email!'); 
			$("#staff_uname_val").val('').focus();
			return false;
         }
		
		$('#val_uname_img').append('<img title="<?php echo base_url(); ?>template/images/loading.gif" src="<?php echo base_url(); ?>template/images/loading.gif">');
		
		$.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>principal/schemailcheck/',
							data: { chkmail:temail , prevmail:ptemail  },
							success: function(data) {
								//alert(data);
								
								if(data=='true'){
									$("#val_uname_img").text('').attr("class","label label-warning").text( "'"+ temail +" ' already register!" );
									$("#staff_uname_val").val(ptemail).focus();
								} else {
									$("#val_uname_img").removeAttr("class").text('').attr("class","label label-success").text( "'"+ temail +"' available !" );
									
								}
								
							}
				  });
		
	});
	
	$('#staff_email_val').on('change',function(){
		
		var temail = $(this).val();
		var ptemail = $('#staff_email_val_hid').val();
		
		 if (!validateEmail(temail)) {
			$("#val_email_img").removeAttr("class").attr("class","label label-warning").text('').text('Please enter valid email!'); 
			$("#staff_email_val").val('').focus();
			return false;
        }
		
		$('#val_email_img').append('<img title="<?php echo base_url(); ?>template/images/loading.gif" src="<?php echo base_url(); ?>template/images/loading.gif">');
		
		$.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>principal/schtemailcheck/',
							data: { chkmail:temail, prevmail:ptemail  },
							success: function(data) {
								//alert(data);
								
								if(data=='true'){
									$("#val_email_img").text('').attr("class","label label-warning").text( "'"+ temail +" ' already register!" );
									$("#staff_email_val").val(ptemail).focus();
								} else {
									$("#val_email_img").removeAttr("class").text('').attr("class","label label-success").text( "'"+ temail +"' available !" );
									
								}
								
							}
				  });
		
	});
	
	// Function that validates email address through a regular expression.
function validateEmail(temail) {
	  var filter =  /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
    
   if (filter.test(temail)) {
        return true;
    }
    else {
        return false;
    }
}

</script>