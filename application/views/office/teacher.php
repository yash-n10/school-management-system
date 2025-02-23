<?php //print_r($departments) ?>
<?php if($department_id=='') { ?>
<div class="span4 offset3" style="float:none !important;">

            <div class="box">

                <div class="box-header">

                    <span class="title"> <i class="icon-info-sign"></i> Please select a class to manage student.</span>

                </div>

                <div class="box-content padded tam-custom-border1">

                   <center>

                    <select name="department_id" onchange="window.location='<?php echo base_url(); ?>office/teacher/'+this.value">

                        <option value=""><?php echo get_phrase('select_a_department'); ?></option>

    <?php
    $departments = $this->db->get('departments')->result_array();

    foreach ($departments as $row):
        ?>

                            <option value="<?php echo $row['department_id']; ?>"

                            <?php if ($department_id == $row['department_id']) echo 'selected'; ?>>

                                <?php echo $row['department_name']; ?></option>

                            <?php
                        endforeach;
                        ?>

                    </select>

                   </center>

                    <script>

                        $(document).ready(function() {

                            function ask()

                            {

                                Growl.info({title:"Select a department to manage teacher",text:" "});

                            }

                            setTimeout(ask, 500);

                        });

                    </script>

                </div>

            </div>

        </div>
<?php } else if ($department_id!='') { ?>
<div class="box">
	<div class="box-header">
    
    	<!------CONTROL TABS START------->
		<ul class="nav nav-tabs nav-tabs-left">
        <li class="active"> <a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> <?php echo get_phrase('teacher_list');?> </a></li>
        <li> <a href="#add" data-toggle="tab"><i class="icon-plus"></i> <?php echo get_phrase('add_teaching_staff');?> </a></li>
        <!--<li> <a href="#addnontech" data-toggle="tab"><i class="icon-plus"></i> <?php echo get_phrase('add_non_teaching_staff');?> </a></li>-->
      </ul>
    	<!------CONTROL TABS END------->
        
	</div>
	<div class="box-content padded">
    
    <center class="custom-tam-cng-sel-block">

                       <span> Change Department </span>

                        <select name="department_id" onchange="window.location='<?php echo base_url(); ?>office/teacher/'+this.value">

                        <option value=""><?php echo get_phrase('select_a_department'); ?></option>

    <?php
    $departments = $this->db->get('departments')->result_array();

    foreach ($departments as $row):
        ?>

                            <option value="<?php echo $row['department_id']; ?>"

                            <?php if ($department_id == $row['department_id']) echo 'selected'; ?>>

                                <?php echo $row['department_name']; ?></option>

                            <?php
                        endforeach;
                        ?>

                    </select>
                        </center>
		<div class="tab-content">
            <!----TABLE LISTING STARTS--->
            <div class="tab-pane  active" id="list">
            		<!--<div class="action-nav-normal">
                        <div class="" style="width:300px;margin-left:33%;">
                          <a href="#" title="Users">
                            <img src="<?php //echo base_url();?>template/images/icons/teacher.png" /><br>
                            <span>Total <?php //echo count($teachers);?> teachers</span>
                          </a>
                        </div>
                    </div>-->
                    <div class="box">
                        <div class="box-content">
                            <div id="dataTables">
                            <table cellpadding="0" cellspacing="0" border="0" class="responsive" id="teacher_dtable">
                                <thead>
                                    <tr>
                                        <th><div><?php echo get_phrase('employee_code');?></div></th>
                                        <th width="80"><div><?php echo get_phrase('photo');?></div></th>
                                        <th><div><?php echo get_phrase('teacher_name');?></div></th>
										<th><div><?php echo get_phrase('batch');?></div></th>
                                        <th><div><?php echo get_phrase('department');?></div></th>
                                        <th><div><?php echo get_phrase('tam username');?></div></th>
                                        <th><div><?php echo get_phrase('options');?></div></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $count = 1;foreach($teachers as $row):?>
                                    <tr>
                                        <td><?php echo $row['employee_code'];?></td>
                                        <td><div><img src="<?php echo $this->crud_model->get_image_url('teacher',$row['teacher_id']);?>" class="avatar-medium" /></div></td>
                                        <td><?php echo $row['name'];?></td>
										<td><?php foreach($academicyear as $departments_list){												
												if($row['employee_academicyear_id']==$departments_list['academic_id'])
												{
													echo $departments_list['session_name'] ;
												}
											} ?></td>
                                        <td><?php echo $row['dname'];?></td>
                                        <td><?php echo $row['email'];?></td>
                                        <td align="center">
                                        
                                        
                                            <a  data-toggle="modal" href="#modal-form" onclick="modal('teacher_id_card',<?php echo $row['teacher_id']; ?>)" class="btn btn-red btn-small">

                                                            <i class="icon-credit-card"></i> <?php echo get_phrase('id_card'); ?>

                                                        </a>
                                            <a data-toggle="modal" href="#modal-form" onclick="modal('teacher_profile',<?php echo $row['teacher_id'];?>)"
                                                 class="btn btn-green btn-small">
                                                    <i class="icon-user"></i> <?php echo get_phrase('profile');?>
                                            </a>
                                            <a data-toggle="modal" href="#modal-form" onclick="modal('edit_teacher',<?php echo $row['teacher_id'];?>)"	class="btn btn-gray btn-small">
                                                    <i class="icon-wrench"></i> <?php echo get_phrase('edit');?>
                                            </a>
                                            <a data-toggle="modal" href="#modal-delete" onclick="modal_delete('<?php echo base_url();?>office/teacher/delete/<?php echo $row['teacher_id'];?>')"
                                                 class="btn btn-red btn-small">
                                                    <i class="icon-trash"></i> <?php echo get_phrase('delete');?>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
			</div>
            <!----TABLE LISTING ENDS--->
            
            
			<!----CREATION FORM STARTS---->
			<div class="tab-pane box" id="add" style="padding: 5px">
                <div class="box-content">
                	<?php echo form_open('office/teacher/create' , array('class' => 'form-horizontal validatable','target'=>'_top', 'enctype' => 'multipart/form-data'));?>
                    <form method="post" action="<?php echo base_url();?>office/teacher/create/" class="form-horizontal validatable" enctype="multipart/form-data">
                        <div class="padded">
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('name');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" name="firstname" placeholder="First Name"/>
                                    <input type="text" class="validate[required]" name="lastname" placeholder="Last Name" />
                                </div>
                            </div>
                             <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('employee_code');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" name="employee_code" id="emp_code_val" placeholder="Employee Code"/>
                                    <span id="val_emp_code_img"></span>
                                </div>
                            </div>
							<div class="control-group">
                                <label class="control-label"><?php echo get_phrase('academin_year');?></label>
                                <div class="controls">
                                    <select class="uniform validate[required]" name="employee_academicyear_id">
                                    <option value="">&nbsp;&nbsp;&nbsp;-- Academic Year --</option> 
                                    <?php foreach($academicyear as $departments_list){ ?>
											<option value="<?php echo $departments_list['academic_id']  ?>"><?php echo $departments_list['session_name']  ?></option> 
									 <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('department');?></label>
                                <div class="controls">
                                    <select class="uniform validate[required]" name="employee_department_id">
                                    <option value="">&nbsp;&nbsp;&nbsp;-- Select Department --</option> 
                                    <?php foreach($departments as $departments_list){ ?>
											<option value="<?php echo $departments_list['department_id']  ?>"><?php echo $departments_list['department_name']  ?></option> 
									 <?php }?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('gender');?></label>
                                <div class="controls">
                                    <select name="sex" class="uniform validate[required]" style="width:100%;">
										<option value="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-- Select Gender -- &nbsp;&nbsp;&nbsp;&nbsp;</option> 
                                        <option value="male"><?php echo get_phrase('male');?></option>
                                        <option value="female"><?php echo get_phrase('female');?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('birthday');?></label>
                                <div class="controls">
                                    <input type="text" class="datepicker fill-up" name="birthday" placeholder="Birthday"/>
                                </div>
                            </div>

                            <div class="control-group">

                                <label class="control-label"><?php echo get_phrase('religion/cast'); ?></label>

                                <div class="controls">

                                    <input type="text" class="validate[required]" name="religion" placeholder="Religion" />
                                    <input type="text" class="validate[required]" name="cast" placeholder="Cast" />
                                </div>

                            </div>

                            <div class="control-group">

                                <label class="control-label"><?php echo get_phrase('tam_username'); ?></label>

                                <div class="controls">

                                    <input type="text" class="validate[required]" name="email" id="teacher_uname_val" placeholder="Tam Username"/>
                                    
                                    <span id="val_uname_img"></span>

                                </div>

                            </div>

                            <div class="control-group">

                                <label class="control-label"><?php echo get_phrase('tam_password'); ?></label>

                                <div class="controls">

                                    <input type="text" class="validate[required]" name="password" placeholder="Tam Password"/>

                                </div>

                            </div>
                            <div class="control-group">

                                <label class="control-label"><?php echo get_phrase('blood_group'); ?></label>

                                <div class="controls">

                                    <input type="text" class="validate[required]" name="blood_group" placeholder="Blood Group"/>

                                </div>

                            </div>
                            <div class="control-group">

                                <label class="control-label"><?php echo get_phrase('subject'); ?></label>

                                <div class="controls">

                                    <textarea name="subject" class="validate[required]" rows="6" columns="4" placeholder="Subject"></textarea>

                                </div>

                            </div>
                            <div class="control-group">

                                <label class="control-label"><?php echo get_phrase('previous_school_name'); ?></label>

                                <div class="controls">

                                    <input type="text" class="validate[required]" name="previous_school_name" placeholder="Previous School Name"/>

                                </div>

                            </div>
                            <!--<div class="control-group">
                                <label class="control-label"><?php echo get_phrase('address');?></label>
                                <div class="controls">
                                    <input type="text" class="" name="address"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('password');?></label>
                                <div class="controls">
                                    <input type="text" class="" name="password"/>
                                </div>
                            </div>
                            -->
                            <div class="control-group">

                                <label class="control-label"><?php echo get_phrase('present_address'); ?></label>

                                <div class="controls">

                                    <textarea name="address" class="validate[required]" rows="6" columns="4" placeholder="Present Address"></textarea>

                                </div>

                            </div>

                            <div class="control-group">

                                <label class="control-label"><?php echo get_phrase('permanent_address'); ?></label>

                                <div class="controls">

                                    <textarea name="permanent_address" class="validate[required]" rows="6" columns="4" placeholder="Permanent Address"></textarea>
                                    
                                </div>

                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('phone');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" name="phone" placeholder="Phone"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('teacher email');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" name="teacher_email" id="teacher_email_val"  placeholder="Teacher Email"/>
                                 <span id="val_email_img"></span>   
                                </div>
                            </div>
                            <div class="control-group">

                                <label class="control-label"><?php echo get_phrase('father\husband\guardian name'); ?></label>

                                <div class="controls">

                                    <input type="text" class="validate[required]" name="father_first_name" placeholder="First Name"/>
                                    <input type="text" class="validate[required]" name="father_last_name" placeholder="Last Name" />

                                </div>

                            </div>
                            <div class="control-group">

                                <label class="control-label"><?php echo get_phrase('father\husband\guardian mobile number'); ?></label>

                                <div class="controls">

                                    <input type="text" class="validate[required]" name="father_mobile_number" placeholder="Father Mobile Number"/>
                                
                                </div>

                            </div>
                            
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('photo');?></label>
                                <div class="controls" style="width:210px;">
                                    <input type="file" class="" name="userfile" id="imgInp" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"></label>
                                <div class="controls" style="width:210px;">
                                    <img id="blah" src="<?php echo base_url();?>uploads/user.jpg" alt="your image" height="100" />
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-gray"><?php echo get_phrase('add_teacher');?></button>
                        </div>
                    </form>                
                </div>                
			</div>
			<!----CREATION FORM ENDS--->
            
            
            
            <!----CREATION NON Teaching FORM STARTS---->
			<div class="tab-pane box" id="addnontech" style="padding: 5px">
                <div class="box-content">
                	<?php echo form_open('office/teacher/create' , array('class' => 'form-horizontal validatable','target'=>'_top', 'enctype' => 'multipart/form-data'));?>
                    <form method="post" action="<?php echo base_url();?>office/teacher/create/" class="form-horizontal validatable" enctype="multipart/form-data">
                        <div class="padded">
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('name');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" name="firstname" placeholder="First Name"/>
                                    <input type="text" class="validate[required]" name="lastname" placeholder="Last Name" />
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('gender');?></label>
                                <div class="controls">
                                    <select name="sex" class="uniform validate[required]" style="width:100%;">
										<option value="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-- Select Gender -- &nbsp;&nbsp;&nbsp;&nbsp;</option> 
                                        <option value="male"><?php echo get_phrase('male');?></option>
                                        <option value="female"><?php echo get_phrase('female');?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('birthday');?></label>
                                <div class="controls">
                                    <input type="text" class="datepicker fill-up" name="birthday" placeholder="Birthday"/>
                                </div>
                            </div>

                            <div class="control-group">

                                <label class="control-label"><?php echo get_phrase('religion/cast'); ?></label>

                                <div class="controls">

                                    <input type="text" class="validate[required]" name="religion" placeholder="Religion" />
                                    <input type="text" class="validate[required]" name="cast" placeholder="Cast" />
                                </div>

                            </div>

                            <div class="control-group">

                                <label class="control-label"><?php echo get_phrase('tam_username'); ?></label>

                                <div class="controls">

                                    <input type="text" class="validate[required]" name="email" placeholder="Tam Username"/>

                                </div>

                            </div>

                            <div class="control-group">

                                <label class="control-label"><?php echo get_phrase('tam_password'); ?></label>

                                <div class="controls">

                                    <input type="text" class="validate[required]" name="password" placeholder="Tam Password"/>

                                </div>

                            </div>
                            <div class="control-group">

                                <label class="control-label"><?php echo get_phrase('blood_group'); ?></label>

                                <div class="controls">

                                    <input type="text" class="validate[required]" name="blood_group" placeholder="Blood Group"/>

                                </div>

                            </div>
                            <div class="control-group">

                                <label class="control-label"><?php echo get_phrase('subject'); ?></label>

                                <div class="controls">

                                    <textarea name="subject" class="validate[required]" rows="6" columns="4" placeholder="Subject"></textarea>

                                </div>

                            </div>
                            <div class="control-group">

                                <label class="control-label"><?php echo get_phrase('previous_school_name'); ?></label>

                                <div class="controls">

                                    <input type="text" class="validate[required]" name="previous_school_name" placeholder="Previous School Name"/>

                                </div>

                            </div>
                            <!--<div class="control-group">
                                <label class="control-label"><?php echo get_phrase('address');?></label>
                                <div class="controls">
                                    <input type="text" class="" name="address"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('password');?></label>
                                <div class="controls">
                                    <input type="text" class="" name="password"/>
                                </div>
                            </div>
                            -->
                            <div class="control-group">

                                <label class="control-label"><?php echo get_phrase('present_address'); ?></label>

                                <div class="controls">

                                    <textarea name="address" class="validate[required]" rows="6" columns="4" placeholder="Present Address"></textarea>

                                </div>

                            </div>

                            <div class="control-group">

                                <label class="control-label"><?php echo get_phrase('permanent_address'); ?></label>

                                <div class="controls">

                                    <textarea name="permanent_address" class="validate[required]" rows="6" columns="4" placeholder="Permanent Address"></textarea>
                                    
                                </div>

                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('phone');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" name="phone" placeholder="Phone"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('teacher email');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" name="teacher_email" placeholder="Teacher Email"/>
                                </div>
                            </div>
                            <div class="control-group">

                                <label class="control-label"><?php echo get_phrase('father\husband\guardian name'); ?></label>

                                <div class="controls">

                                    <input type="text" class="validate[required]" name="father_first_name" placeholder="First Name"/>
                                    <input type="text" class="validate[required]" name="father_last_name" placeholder="Last Name" />

                                </div>

                            </div>
                            <div class="control-group">

                                <label class="control-label"><?php echo get_phrase('father\husband\guardian mobile number'); ?></label>

                                <div class="controls">

                                    <input type="text" class="validate[required]" name="father_mobile_number" placeholder="Father Mobile Number"/>
                                
                                </div>

                            </div>
                            
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('photo');?></label>
                                <div class="controls" style="width:210px;">
                                    <input type="file" class="" name="userfile" id="imgInp" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"></label>
                                <div class="controls" style="width:210px;">
                                    <img id="blah" src="<?php echo base_url();?>uploads/user.jpg" alt="your image" height="100" />
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-gray"><?php echo get_phrase('add_teacher');?></button>
                        </div>
                    </form>                
                </div>                
			</div>
			<!----CREATION NON Teaching FORM ENDS--->
            
            
            
            
		</div>
	</div>
</div>
<?php } ?>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgInp").change(function(){
        readURL(this);
    });
	
	
	
	$('#emp_code_val').on('change',function(){
		
		var tcode = $(this).val();
		
		$('#val_emp_code_img').append('<img title="<?php echo base_url(); ?>template/images/loading.gif" src="<?php echo base_url(); ?>template/images/loading.gif">');
		
		$.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>office/tchcodecheck/',
							data: { chkcode:tcode },
							success: function(data) {
								//alert(data);
								
								if(data=='true'){
									$("#val_emp_code_img").text('').attr("class","label label-warning").text( "'"+ tcode +" ' already register try another !" );
									$("#emp_code_val").val('').focus();
								} else {
									$("#val_emp_code_img").removeAttr("class").text('').attr("class","label label-success").text( "'"+ tcode +"' available !" );
									
								}
								
							}
				  });
		
	});
	
	$('#teacher_uname_val').on('change',function(){
		
		var temail = $(this).val();
		
		 if (!validateEmail(temail)) {
			$("#val_uname_img").removeAttr("class").attr("class","label label-warning").text('').text('Please enter valid email!'); 
			$("#teacher_uname_val").val('').focus();
			return false;
         }
		
		$('#val_uname_img').append('<img title="<?php echo base_url(); ?>template/images/loading.gif" src="<?php echo base_url(); ?>template/images/loading.gif">');
		
		$.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>office/tchemailcheck/',
							data: { chkmail:temail },
							success: function(data) {
								//alert(data);
								
								if(data=='true'){
									$("#val_uname_img").text('').attr("class","label label-warning").text( "'"+ temail +" ' already register try another !" );
									$("#teacher_uname_val").val('').focus();
								} else {
									$("#val_uname_img").removeAttr("class").text('').attr("class","label label-success").text( "'"+ temail +"' available !" );
									
								}
								
							}
				  });
		
	});
	
	$('#teacher_email_val').on('change',function(){
		
		var temail = $(this).val();
		
		 if (!validateEmail(temail)) {
			$("#val_email_img").removeAttr("class").attr("class","label label-warning").text('').text('Please enter valid email!'); 
			$("#teacher_email_val").val('').focus();
			return false;
        }
		
		$('#val_email_img').append('<img title="<?php echo base_url(); ?>template/images/loading.gif" src="<?php echo base_url(); ?>template/images/loading.gif">');
		
		$.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>office/tchtemailcheck/',
							data: { chkmail:temail },
							success: function(data) {
								//alert(data);
								
								if(data=='true'){
									$("#val_email_img").text('').attr("class","label label-warning").text( "'"+ temail +" ' already register try another !" );
									$("#teacher_email_val").val('').focus();
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

<script src="<?php echo base_url(); ?>template/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>template/js/jquery.dataTables.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>template/css/dataTables.tableTools.css">
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>template/js/dataTables.tableTools.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>template/js/dataTables.bootstrap.js"></script>
<script>var $j = jQuery.noConflict(true);</script>
<script>
$(document).ready(function() {
    $j('#teacher_dtable').DataTable( {
		dom: 'T<"clear">lfrtip',
		 tableTools: {
            "sSwfPath": "<?php echo base_url(); ?>template/swf/copy_csv_xls_pdf.swf",
			"aButtons": [
            {
                "sExtends": "copy",
                "mColumns": [0, 2, 3, 4]
            },
            {
                "sExtends": "csv",
                "mColumns": [0, 2, 3, 4]
            },
            {
                "sExtends": "pdf",
                "mColumns": [0, 2, 3, 4]
            },
            {
                "sExtends": "print",
                "mColumns": [0, 2, 3, 4]
            },
        ]
        }
	} );
} );
</script>