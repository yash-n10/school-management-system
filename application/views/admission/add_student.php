<style>
    .form-group{margin-bottom: 10px;} 
    fieldset { 
        border: solid 1px #a6a6a6 !important;
        padding: 0 10px 10px 10px;
        border-bottom: none;
        /*    border-radius: 8px;*/
        border-top-left-radius: 25px;
        border-bottom-left-radius: 25px;
        border-top: 2px solid #29a3a3 !important;
    }
    legend{
        width: auto !important;
        padding:0 10px;
        border: none;
        font-size: 14px;
        font-variant: small-caps;
        letter-spacing: 1px;
        text-decoration: underline;
    }
    .form-control{
        padding: 6px 5px !important;
        color:darkblue
    }
            .error-block {
        font-size: 12px;
    color: red;
    }
    .error-block >p {
        margin: 3px;
    }
</style>
<link href="<?php echo e(base_url("assets/AdminLTE/plugins/bootstrap-fileinput/bootstrap-fileinput.css")); ?>" rel="stylesheet" type="text/css" />


<div class="panel  panel-default"> 
    <div class="panel-body">
        <form enctype="multipart/form-data" id="studentdetails" action="" method="post">
            <div class="col-sm-12 col-md-12">

                <div class="row">
                    <div class="col-sm-9">

                        <fieldset class="">

                            <legend class="" style="font-size:18px;color:green">
                                Official Details <span class="required"></span>
                            </legend>

                            <div class="row">
                             <div class="form-group col-sm-3">
                                    <label  style="font-weight: 600">Academic Session</label>
                                    <select class="form-control chosen-select" id="student_academicyear_id" name="student_academicyear_id" required>
                                        <option value="">Select Session</option>       
                                        <?php foreach ($edit_columns['student_academicyear_id']['select_opts'] as $opt) { ?>
                                            <option <?php if($task=='Update') if($data[0]->student_academicyear_id==$opt->opt_id){echo 'selected="selected"';}  ?> value="<?php echo $opt->opt_id; ?>"><?php echo $opt->opt_disp; ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="error-block"></span>
                                </div>
                                
                               <!--  <div class="form-group col-sm-4">
                                    <label  style="font-weight: 600">Academic Session</label>
                                    <input class="form-control" name="acedemic" id="acedemic" type="text" value="<?php if($task=='Update') echo $data[0]->acedemic_id_disp?>" required disabled>
                                    <span class="error-block"></span>
                                </div> -->

                                <div class="form-group col-sm-3">
                                    <label style="font-weight: 600">Admission Date</label>
                                    <input type='date' class="form-control" id="admission_date" name="admission_date" value="<?php if($task=='Update') echo $data[0]->admission_date;  ?>">

                                    <span class="error-block"></span>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label style="font-weight: 600">Fisrt Adm in Class</label>
                                     <select class="form-control chosen-select" id="first_class" name="first_class">
                                        <option value="">Select Class</option>       
                                        <?php foreach ($edit_columns['first_class']['select_opts'] as $opt) { ?>
                                            <option <?php if($task=='Update') if($data[0]->first_class==$opt->opt_disp){echo 'selected="selected"';}  ?>  value="<?php echo $opt->opt_disp; ?>"><?php echo $opt->opt_disp; ?></option>
                                        <?php } ?>
                                    </select>

                                    <span class="error-block"></span>
                                </div>
                                <div class="form-group col-sm-3">
                                    <?php //if(($this->session->userdata('school_id')==35)) { ?>
                                    <?php if(($this->session->userdata('school_id')==35) ||($this->session->userdata('school_id')==29)) { 
                                    		$fetchmaxadm=$this->db->query("SELECT MAX(CONVERT(admission_no,UNSIGNED)) as adm_no FROM student")->result();
                                    		 $newadm=$fetchmaxadm[0]->adm_no+1 ;	
                                    		
                                    	?>
                                         <label  style="font-weight: 600">Admission No.</label><span style='color:red;font-weight:bold'>*</span>
                                          <input class="form-control" name="admission_no" id="admission_no" type="text" value="<?php if($task=='Update') { echo $data[0]->admission_no; } else { echo $newadm;}  ?>" required onchange='duplication_check(this)' readonly>
                                    <?php }  else { ?>
                                    <label  style="font-weight: 600">Admission No.</label><span style='color:red;font-weight:bold'>*</span>
                                    <input class="form-control" name="admission_no" id="admission_no" type="text" value="<?php if($task=='Update') echo $data[0]->admission_no;  ?>" required onchange='duplication_check(this)'>
                                    <?php } ?>
                                    <span class="error-block"></span>
                                </div>
                                

                            </div>
                            <div class="row">


                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">First Name</label><span style='color:red;font-weight:bold'>*</span>
                                    <input class="form-control" name="first_name" id="first_name" type="text" value="<?php if($task=='Update') echo $data[0]->first_name;  ?>" required pattern="[a-zA-Z ]+">
                                    <span class="error-block"></span>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Middle Name</label>
                                    <input class="form-control" name="middle_name" id="middle_name" type="text" value="<?php if($task=='Update') echo $data[0]->middle_name;  ?>" pattern="[a-zA-Z ]+">
                                    <span class="error-block"></span>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Last Name</label>
                                    <input class="form-control" name="last_name" id="last_name" type="text" value="<?php if($task=='Update') echo $data[0]->last_name;  ?>" pattern="[a-zA-Z ]+">
                                    <span class="error-block"></span>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Class</label><span style='color:red;font-weight:bold'>*</span>
                                    <select class="form-control chosen-select" id="class_id" name="class_id" required>
                                        <option value="">Select Class</option>       
                                        <?php foreach ($edit_columns['class_id']['select_opts'] as $opt) { ?>
                                            <option <?php if($task=='Update') if($data[0]->class_id==$opt->opt_id){echo 'selected="selected"';}  ?>  value="<?php echo $opt->opt_id; ?>"><?php echo $opt->opt_disp; ?></option>
                                        <?php } ?>
                                    </select>

                                    <span class="error-block"></span>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Section</label><span style='color:red;font-weight:bold'>*</span>
                                    <select class="form-control chosen-select" id="section_id" name="section_id" required>
                                        <option value="0">Select Section</option>
                                        <?php foreach ($edit_columns['section_id']['select_opts'] as $opt) { ?>
                                            <option <?php if($task=='Update') if($data[0]->section_id==$opt->opt_id){echo 'selected="selected"';}  ?>  value="<?php echo $opt->opt_id; ?>"><?php echo $opt->opt_disp; ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="error-block"></span>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Roll No.</label>
                                    <input class="form-control" name="roll" id="roll" type="text" value="<?php if($task=='Update') echo $data[0]->roll;  ?>">
                                    <span class="error-block"></span>
                                </div>
                                <?php if($this->session->userdata('school_id')==43){?>
                                
                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Id</label>
                                    <input class="form-control" name="id" id="id" type="text" value="<?php echo $data[0]->id;?>" readonly>
                                    <span class="error-block"></span>
                                </div>

                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Net Roll No</label>
                                    <input class="form-control" name="net_roll" id="net_roll" type="text" value="<?php echo $data[0]->net_roll;?>">
                                    <span class="error-block"></span>
                                </div>
  
                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Exam roll</label>
                                    <input class="form-control" name="exam_roll" id="exam_roll" type="text" value="<?php echo $data[0]->exam_roll;?>">
                                    <span class="error-block"></span>
                                </div>

                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">N roll No</label>
                                    <input class="form-control" name="n_roll" id="n_roll " type="text" value="<?php echo $data[0]->n_roll;?>">
                                    <span class="error-block"></span>
                                </div>

                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Sets</label>
                                    <input class="form-control" name="sets" id="sets" type="text" value="<?php echo $data[0]->sets;?>">
                                    <span class="error-block"></span>
                                </div>
                                
                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Hostel</label>
                                    <input class="form-control" name="hostel" id="hostel" type="text" value="<?php echo $data[0]->hostel;?>">
                                    <span class="error-block"></span>
                                </div>
                            
                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Head Master</label>
                                    <input class="form-control" name="headmaster" id="headmaster" type="text" value="<?php echo $data[0]->headmaster;?>">
                                    <span class="error-block"></span>
                                </div>

                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Color House</label>
                                    <input class="form-control" name="color_house" id="color_house" type="text" value="<?php echo $data[0]->color_house;?>">
                                    <span class="error-block"></span>
                                </div>

                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Auditorium Sitting Plan</label>
                                    <input class="form-control" name="auditorium_seat" id="auditorium_seat" type="text" value="<?php echo $data[0]->auditorium_seat;?>">
                                    <span class="error-block"></span>
                                </div>

                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Akash/ETC</label>
                                    <input class="form-control" name="coaching" id="coaching" type="text" value="<?php echo $data[0]->coaching;?>">
                                    <span class="error-block"></span>
                                </div>

                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Bottle</label>
                                    <input class="form-control" name="bottle" id="bottle" type="text" value="<?php echo $data[0]->bottle;?>">
                                    <span class="error-block"></span>
                                </div>

                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Parv</label>
                                    <input class="form-control" name="parv" id="parv" type="text" value="<?php echo $data[0]->parv;?>">
                                    <span class="error-block"></span>
                                </div>

                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Medium</label>
                                    <input class="form-control" name="medium" id="medium" type="text" value="<?php echo $data[0]->medium;?>">
                                    <span class="error-block"></span>
                                </div>

                              

                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Pl House</label>
                                    <input class="form-control" name="pl_house" id="pl_house" type="text" value="<?php echo $data[0]->pl_house;?>">
                                    <span class="error-block"></span>
                                </div>

                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Plan House</label>
                                    <input class="form-control" name="plan_house" id="plan_house" type="text" value="<?php echo $data[0]->plan_house;?>">
                                    <span class="error-block"></span>
                                </div>

                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Final House</label>
                                    <input class="form-control" name="final_house" id="final_house" type="text" value="<?php echo $data[0]->final_house;?>">
                                    <span class="error-block"></span>
                                </div>


                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Religion</label>
                                    <input class="form-control" name="religion" id="religion" type="text" value="<?php echo $data[0]->religion;?>">
                                    <span class="error-block"></span>
                                </div>

                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Category</label>
                                    <input class="form-control" name="category" id="category" type="text" value="<?php echo $data[0]->category;?>">
                                    <span class="error-block"></span>
                                </div>

                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Blood Group</label>
                                    <input class="form-control" name="blood_group" id="blood_group" type="text" value="<?php echo $data[0]->blood_group;?>">
                                    <span class="error-block"></span>
                                </div>

                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Reg No</label>
                                    <input class="form-control" name="reference_no" id="reference_no" type="text" value="<?php echo $data[0]->reference_no;?>">
                                    <span class="error-block"></span>
                                </div>

                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Co Curricular</label>
                                    <input class="form-control" name="co_curricular" id="co_curricular" type="text" value="<?php echo $data[0]->co_curricular;?>">
                                    <span class="error-block"></span>
                                </div>

                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Category</label>
                                    <input class="form-control" name="category" id="category" type="text" value="<?php echo $data[0]->category;?>">
                                    <span class="error-block"></span>
                                </div>

                            <?php }?>
<!--                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Course( If Any)</label>
                                    <select class="form-control chosen-select" id="course_id" name="course_id" >
                                        <option value="0">Select Course</option>
                                        <?php // foreach ($edit_columns['course_id']['select_opts'] as $opt) { ?>
                                            <option <?php // if($task=='Update') if($data[0]->course_id==$opt->opt_id){echo 'selected="selected"';}  ?>  value="<?php // echo $opt->opt_id; ?>"><?php // echo $opt->opt_disp; ?></option>
                                        <?php // } ?>
                                    </select>
                                    <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                                </div>-->
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-sm-3">
                        <div class="fileinput fileinput-new" data-provides="fileinput" style="margin-top: 12px;">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;border: 1px solid #ddd;">

                                        <?php if(isset($data[0]->photo)) { ?>
                                        
                                            <img src="<?php echo e(base_url('/assets/Schools_Photos/student_pic/'.basename($data[0]->photo)))?>" alt="Student Pic" /> 
                                        
                                        <?php }else{?>

                                            <img src="<?php echo e(base_url("assets/img/red_user.png")) ?>" alt="" /> 
                                        <?php }?>

                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                    <div>
                                        <button class="btn red btn-outline-info btn-file">
                                            <span class="fileinput-new"> Select image </span>
                                            <span class="fileinput-exists"> Change </span>
                                            <input type="file" name="photo" id="photo"> 
                                            <span class="error-block"></span>
                                        </button>
                                        
                                        <a href="javascript:;" class="btn red fileinput-exists btn-danger" data-dismiss="fileinput"> Remove </a>
                                        <!--<a href="javascript:;" class="btn red fileinput-exists btn-success"> Upload </a>-->
                                    </div>
                        </div>
                    </div>
                </div>

                <div class="row" style="padding-top:2%">
                    <div class="col-sm-9">
                        <fieldset class="">

                            <legend class="" style="font-size:18px;color:green">
                                Personal Details <span class="required"></span>
                            </legend>
                            <div class="row">


                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">D.O.B</label>
                                    <input type='date' class="form-control" id="dob" name="dob" value="<?php if($task=='Update') echo $data[0]->dob;  ?>" >
                                    <span class="error-block"></span>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Gender</label>
                                    <div>
                                        <label class="radio-inline"><input type="radio" name="gender" value="0" checked="checked"<?php if($task=='Update') if($data[0]->gender=='0'){ echo 'checked=checked';} ?>>Male</label>
                                        <label class="radio-inline"><input type="radio" name="gender" value="1" <?php if($task=='Update') if($data[0]->gender=='1'){ echo 'checked=checked';} ?>>Female</label>
                                    </div>
                                    <span class="error-block"></span>
                                </div>
                                <!--                                                                <div class="form-group col-sm-3">
                                <label style="font-weight: 600">Mother Tongue</label>
                                <input  class="form-control" name="mother_tongue" id="mother_tongue" type="text" value="<?php // echo $spouse_name; ?>">
                                <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                                </div>-->
                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Aadhar No</label>
                                    <input class="form-control" name="student_aadhar" id="student_aadhar" type="text" value="<?php if($task=='Update') echo $data[0]->student_aadhar; ?>" >
                                    <span class="error-block"></span>
                                </div>
                            </div>
                            <!--                                                            <div class="row">
                            
                            <div class="form-group col-sm-3">
                            <label style="font-weight: 600">Birth Place</label>
                            <input  class="form-control" name="birth_place" id="birth_place" type="text" value="<?php // echo $spouse_name; ?>">
                            <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                            </div>
                            <div class="form-group col-sm-3">
                            <label style="font-weight: 600">Nationality</label>
                            <input class="form-control" name="nationality" id="nationality" type="text" value="<?php // echo $martial_status; ?>">
                            <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                            </div>
                            <div class="form-group col-sm-3">
                            <label style="font-weight: 600">Religion</label>
                            <input  class="form-control" name="religion" id="religion" type="text" value="<?php // echo $spouse_name; ?>">
                            <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                            </div>
                            <div class="form-group col-sm-3">
                            <label style="font-weight: 600">Caste</label>
                            <input class="form-control" name="caste" id="caste" type="text" value="<?php // echo $martial_status; ?>">
                            <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                            </div>
                            </div>-->

                            <div class="row">

                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Father's Name</label>
                                    <input  class="form-control" name="father_name" id="father_name" type="text" value="<?php if($task=='Update') echo $data[0]->father_name; ?>">
                                    <span class="error-block"></span>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Father's Mobile No.</label>
                                    <input class="form-control" name="father_phone" id="father_phone" type="text" value="<?php if($task=='Update') echo $data[0]->father_phone; ?>">
                                    <span class="error-block"></span>
                                </div>
                                <!--                                                                <div class="form-group col-sm-3">
                                <label style="font-weight: 600">Father's Job Description</label>
                                <input  class="form-control" name="father_job" id="father_job" type="text" value="<?php // echo $spouse_name; ?>">
                                <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                                </div>-->
                                 <?php if($this->session->userdata('school_id')!=5) { ?>
                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Father's Aadhar No.</label>
                                    <input class="form-control" name="father_aadhar" id="father_aadhar" type="text" value="<?php if($task=='Update') echo $data[0]->father_aadhar; ?>">
                                    <span class="error-block"></span>
                                </div>
                            <?php } ?>
                            </div>
                            <div class="row">

                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Mother's Name</label>
                                    <input  class="form-control" name="mother_name" id="mother_name" type="text" value="<?php if($task=='Update') echo $data[0]->mother_name; ?>">
                                    <span class="error-block"></span>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Mother's Mobile No.</label>
                                    <input class="form-control" name="mother_phone" id="mother_phone" type="text" value="<?php if($task=='Update') echo $data[0]->mother_phone; ?>">
                                    <span class="error-block"></span>
                                </div>
                                <!--                                                                <div class="form-group col-sm-3">
                                <label style="font-weight: 600">Mother's Job Description</label>
                                <input  class="form-control" name="mother_job" id="mother_job" type="text" value="<?php // echo $spouse_name; ?>">
                                <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                                </div>-->
                                 <?php if($this->session->userdata('school_id')!=5) { ?>
                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Mother's Aadhar No.</label>
                                    <input class="form-control" name="mother_aadhar" id="mother_aadhar" type="text" value="<?php if($task=='Update') echo $data[0]->mother_aadhar; ?>">
                                    <span class="error-block"></span>
                                </div>
                            <?php } ?>
                            </div>
                            <?php if($this->session->userdata('school_id')!=5) { ?>
                            <div class="row">

                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Guardian's Name</label>
                                    <input  class="form-control" name="guardian_name" id="guardian_name" type="text" value="<?php if($task=='Update') echo $data[0]->guardian_name; ?>">
                                    <span class="error-block"></span>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Guardian's Mobile No.</label>
                                    <input class="form-control" name="guardian_phone" id="guardian_phone" type="text" value="<?php if($task=='Update') echo $data[0]->guardian_phone; ?>">
                                    <span class="error-block"></span>
                                </div>
                                <!--                                                                <div class="form-group col-sm-3">
                                <label style="font-weight: 600">Guardian's Job Description</label>
                                <input  class="form-control" name="guardian_job" id="guardian_job" type="text" value="<?php // echo $spouse_name; ?>">
                                <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                                </div>-->
                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Guardian's Aadhar No.</label>
                                    <input class="form-control" name="guardian_aadhar" id="guardian_aadhar" type="text" value="<?php if($task=='Update') echo $data[0]->guardian_aadhar; ?>">
                                    <span class="error-block"></span>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if($this->session->userdata('school_id')==35) { ?>
                        <div class="row">
                                <div class="form-group col-sm-3">
                                    <label style="font-weight: 600">Blood Group</label>
                                    <input  class="form-control" name="blood_group" id="blood_group" type="text" value="<?php if($task=='Update') echo $data[0]->blood_group; ?>">
                                    <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                                </div>
                                <div class="form-group col-sm-3">
                                    <label style="font-weight: 600">Nationality</label>
                                    <input class="form-control" name="nationality" id="nationality" type="text" value="<?php if($task=='Update') echo $data[0]->nationality; ?>">
                                    <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                                </div>
                                <div class="form-group col-sm-3">
                                    <label style="font-weight: 600">Religion</label>
                                    <input  class="form-control" name="religion" id="religion" type="text" value="<?php if($task=='Update') echo $data[0]->religion; ?>">
                                    <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                                </div>
                                <div class="form-group col-sm-3">
                                    <label style="font-weight: 600">Caste</label>
                                    <input class="form-control" name="caste" id="caste" type="text" value="<?php if($task=='Update') echo $data[0]->caste; ?>">
                                    <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                                    </div>
                            </div>
                        <?php } ?>

                        </fieldset>

                    </div>    
                    <!--                                                <div class="col-sm-3">
                    
                    <fieldset class="">
                    <legend class="" style="font-size:18px;color:green">Health Status <span class="required"></span></legend>
                    <div class="row">
                    <div class="form-group col-sm-12">
                    <label style="font-weight: 600">Blood Group</label>
                    <textarea class="form-control" name="blood_group" id="blood_group"><?php // echo $address; ?></textarea>
                    <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                    </div>
                    <div class="form-group col-sm-12">
                    <label style="font-weight: 600">Height</label>
                    <textarea class="form-control" name="height" id="height"><?php // echo $address; ?></textarea>
                    <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                    </div>
                    <div class="form-group col-sm-12">
                    <label class="" style="font-weight: 600">Weight</label>
                    <input class="form-control" name="weight" id="weight" type="number" value="<?php // echo $phone; ?>">
                    <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                    </div>
                    <div class="form-group col-sm-12">
                    <label class="" style="font-weight: 600">Vision</label>
                    <input class="form-control" name="vision" id="vision" type="email" value="<?php // echo $email; ?>">
                    <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                    </div>
                    
                    
                    </div>
                    
                    </fieldset>
                    
                    </div>  -->
                    <div class="col-sm-3">
                        <fieldset class="">
                            <legend class="" style="font-size:18px;color:green">Contact Details <span class="required"></span></legend>
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label style="font-weight: 600">Present Address</label>
                                    <textarea class="form-control" name="address" id="address"><?php if($task=='Update') echo $data[0]->address; ?></textarea>
                                    <span class="error-block"></span>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label style="font-weight: 600">Permanent Address</label>
                                    <textarea class="form-control" name="permanentaddress" id="permanentaddress"><?php echo $data[0]->permanent_address; ?></textarea>
                                    <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                                </div>
                                <div class="form-group col-sm-12">
                                    <?php if($this->session->userdata('school_id')==35) { ?>
                                    <label class="" style="font-weight:  600">Phone No <?php if ($school[0]->pwd_generation == 'AUTO') echo '' ?></label><span style='color:red;font-weight:bold'>*</span>
                                    <?php  } else { ?>
                                       <label class="" style="font-weight:  600">Phone No <?php if ($school[0]->pwd_generation == 'AUTO') echo '<span style="font-weight:lighter">( Also As Password )<span>' ?></label><span style='color:red;font-weight:bold'>*</span>      
                                    <?php } ?>
                                    <input class="form-control" name="phone" id="phone" type="number" value="<?php if($task=='Update') echo $data[0]->phone; ?>" required>
                                    <?php if($this->session->userdata('school_id')!=35) { ?>
                                    <?php if($task=='Update' && $school[0]->pwd_generation=='AUTO') {?>
                                    <select class="form-control" name="pwd_change" id="pwd_change">
                                        <option value=''>Want to change Password?</option>
                                        <option value='YES'>YES</option>
                                    </select>
                                    <?php }?>
                                    <?php }?>
                                    <span class="error-block"></span>
                                </div>
                                <?php if($this->session->userdata('school_id')!=5) { ?>
                                <div class="form-group col-sm-12">
                                    <label for="reg_input_name" class="" style="font-weight: 600">Email</label><span style='color:red;font-weight:bold'>*</span>
                                    <input class="form-control" name="email_address" id="email_address" type="email" value="<?php if($task=='Update') echo $data[0]->email_address; ?>">
                                    <span class="error-block"></span>
                                </div>
                            <?php } ?>

                            </div>

                        </fieldset>

                    </div>

                </div>
                <!--                                            <div class="row" style="padding-top:2%">
                <div class="col-sm-12">
                <fieldset class="">
                <legend class="" style="font-size:18px;color:green">Contact Details <span class="required"></span></legend>
                <div class="row">
                <div class="form-group col-sm-3">
                <label style="font-weight: 600">Present Address</label>
                <textarea class="form-control" name="address" id="address"><?php // echo $address; ?></textarea>
                <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                </div>
                <div class="form-group col-sm-3">
                <label style="font-weight: 600">Permanent Address</label>
                <textarea class="form-control" name="permanentaddress" id="permanentaddress"><?php // echo $address; ?></textarea>
                <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                </div>
                <div class="form-group col-sm-3">
                <label class="" style="font-weight: 600">Phone No</label>
                <input class="form-control" name="phone" id="phone" type="number" value="<?php // echo $phone; ?>">
                <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                </div>
                <div class="form-group col-sm-3">
                <label for="reg_input_name" class="" style="font-weight: 600">Email</label>
                <input class="form-control" name="email_address" id="email_address" type="email" value="<?php // echo $email; ?>">
                <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                </div>
                
                
                </div>
                
                </fieldset>
                
                </div>
                </div>-->
                <div class="row" style="padding-top:2%">
                    <div class="col-sm-12">
                        <fieldset class="">
                            <legend class="" style="font-size:18px;color:green">Other's Details <span class="required"></span></legend>
                            <div class="row">
                                <div class="form-group col-sm-3">
                                    <label style="font-weight: 600">Course( If Any)</label>
                                    <select class="form-control chosen-select" id="course_id" name="course_id" >
                                        <option value="0">Select Course</option>
                                        <?php foreach ($edit_columns['course_id']['select_opts'] as $opt) { ?>
                                            <option <?php if($task=='Update') if($data[0]->course_id==$opt->opt_id){echo 'selected="selected"';}  ?>  value="<?php echo $opt->opt_id; ?>"><?php echo $opt->opt_disp; ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="error-block"></span>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label style="font-weight: 600">Fee Category<span style='color:red;font-weight:bold'>*</span></label>
                                    <select class="form-control chosen-select" id="stud_category" name="stud_category" required>
                                        <option value="">Select Fee Category</option>
                                        <?php foreach ($edit_columns['stud_category']['select_opts'] as $opt) { ?>
                                            <option <?php if($task=='Update') if($data[0]->stud_category==$opt->opt_id){echo 'selected="selected"';}  ?>  value="<?php echo $opt->opt_id; ?>"><?php echo $opt->opt_disp; ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="error-block"></span>
                                </div>
                                <?php if ($school[0]->admsn_in_between == 'YES') { ?>
                                <div class="form-group col-sm-3">
                                        <label style="font-weight: 600">Student Type</label>
                                        <select class="form-control" name="student_type" id="student_type">
                                        	<option value="NEW ADMISSION" <?php if($task=='Update'&& $data[0]->student_type=='NEW ADMISSION') echo 'selected=selected'; ?> >NEW ADMISSION</option>
                                            <option value="EXISTING" <?php if($task=='Update' && $data[0]->student_type=='EXISTING') echo 'selected=selected' ; ?> >EXISTING</option>
                                            
                                            <option value="TRANSFERED" <?php if($task=='Update'&& $data[0]->student_type=='TRANSFERED') echo 'selected=selected'; ?> >TRANSFERED</option>
                                        </select>
                                        <span class="error-block"></span>
                                </div>
                                
                                <div class="form-group col-sm-3" style="display:none" id="div_start_fee_month">
                                        <label style="font-weight: 600">Start Fee Month</label>
                                        <select class="form-control" name="start_fee_month" id="start_fee_month">
                                            <option value="1" <?php if($task=='Update' && $data[0]->start_fee_month==1) echo 'selected=selected';else echo 'selected=selected'; ?>>April</option>
                                            <option value="2" <?php if($task=='Update' && $data[0]->start_fee_month==2) echo 'selected=selected';?>>May</option>
                                            <option value="3" <?php if($task=='Update' && $data[0]->start_fee_month==3) echo 'selected=selected';?>>June</option>
                                            <option value="4" <?php if($task=='Update' && $data[0]->start_fee_month==4) echo 'selected=selected';?>>July</option>
                                            <option value="5" <?php if($task=='Update' && $data[0]->start_fee_month==5) echo 'selected=selected';?>>August</option>
                                            <option value="6" <?php if($task=='Update' && $data[0]->start_fee_month==6) echo 'selected=selected';?>>September</option>
                                            <option value="7" <?php if($task=='Update' && $data[0]->start_fee_month==7) echo 'selected=selected';?>>October</option>
                                            <option value="8" <?php if($task=='Update' && $data[0]->start_fee_month==8) echo 'selected=selected';?>>November</option>
                                            <option value="9" <?php if($task=='Update' && $data[0]->start_fee_month==9) echo 'selected=selected';?>>December</option>
                                            <option value="10" <?php if($task=='Update' && $data[0]->start_fee_month==10) echo 'selected=selected';?>>January</option>
                                            <option value="11" <?php if($task=='Update' && $data[0]->start_fee_month==11) echo 'selected=selected';?>>February</option>
                                            <option value="12" <?php if($task=='Update' && $data[0]->start_fee_month==12) echo 'selected=selected';?>>March</option>
                                        </select>
                                        <span class="error-block"></span>
                                </div>
                                <?php }?>
                                
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-3">
                                        <label style="font-weight: 600">Fine Waiver</label>
                                        <select class="form-control" name="fine_waiver" id="fine_waiver">
                                            <option <?php if($task=='Update' && $data[0]->fine_waiver=='NO') echo 'selected=selected'; ?>>NO</option>
                                            <option <?php if($task=='Update'&& $data[0]->fine_waiver=='YES') echo 'selected=selected'; ?>>YES</option>
                                        </select>
                                        <span class="error-block"></span>
                                </div>
                            </div>
                        </fieldset>

                    </div>
                </div>
                <!------------------------------------tranport details----------------------------------------->
                
                <div class="row" style="padding-top:2%">
                    <div class="col-sm-9">
                        <fieldset class="">
                            <legend class="" style="font-size:18px;color:green">Transport Details <span class="required"></span></legend>
                            <div class="row"> 
                                <div class="form-group col-sm-3">
                                    <label style="font-weight: 600">Pickup Point</label>
                                    <select class="form-control chosen-select" id="ppoint_id" name="ppoint_id" onchange="pick_up(this.value)">
                                        <option value="0">Select Pickup Point</option>
                                        <?php foreach ($edit_columns['ppoint_id']['select_opts'] as $opt) { ?>
                                            <option <?php if($task=='Update') if($data[0]->ppoint_id==$opt->opt_id){echo 'selected="selected"';}  ?>  value="<?php echo $opt->opt_id; ?>"><?php echo $opt->opt_disp; ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="error-block"></span>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label style="font-weight: 600">Vehicle No</label>
                                    <select class="form-control chosen-select" id="transport_id" name="transport_id" onchange="getamount();">
                                        <option value="0">Select Vehicle No</option>
                                        <?php if($task=='Update'){?>
                                            <?php foreach ($edit_columns['transport_id']['select_opts'] as $opt) { ?>
                                            <option <?php if($data[0]->transport_id==$opt->opt_id){echo 'selected="selected"';}  ?>  value="<?php echo $opt->opt_id; ?>"><?php echo $opt->opt_disp; ?></option>
                                            <?php } ?>
                                        <?php }?>
                                    </select>
                                    <span class="error-block"></span>
                                </div> 
                                <?php if ($school[0]->transport_fee == 'YES') { ?>
                                    <div class="form-group col-sm-3">
                                        <label style="font-weight: 600">Transport Fee(If Any)</label>
                                        <input class="form-control" name="transport_amt" id="transport_amt" type="number" value="<?php if($task=='Update') echo $data[0]->transport_amt; ?>" >
                                        <span class="error-block"></span>
                                    </div>
                                <?php } ?>

                                
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-sm-3">
                        <fieldset>
                            <legend class="" style="font-size:18px;color:green">Family Photo<span class="required"></span></legend>
                            <div class="col-sm-3">
                                        <div class="fileinput fileinput-new" data-provides="fileinput" style="margin-top: 12px;">
                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;border: 1px solid #ddd;">

                                                <?php if(isset($data[0]->family_photo)) { ?>
                                            
                                                <img src="<?php echo e(base_url('/assets/Schools_Photos/family_pic/'.basename($data[0]->family_photo)))?>" alt="Family Pic" /> 
                                            
                                                <?php }else{?>

                                                <img src="<?php echo e(base_url("assets/img/red_user.png")) ?>" alt="" /> 
                                                <?php }?>

                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                            <div>
                                                <button class="btn red btn-outline-info btn-file">
                                                    <span class="fileinput-new"> Select image </span>
                                                    <span class="fileinput-exists"> Change </span>
                                                    <input type="file" name="family_photo" id="family_photo"> 
                                                    <!-- <span class="error-block"></span> -->
                                                </button>
                                                
                                                <a href="javascript:;" class="btn red fileinput-exists btn-danger" data-dismiss="fileinput"> Remove </a>
                                            </div>
                                        </div>
                                    </div> 
                        </fieldset>
                    </div>
                </div>
                
                <!-------------------------------------------end tranport details------------------------------------------------>
                <div class="row" style="padding-top:2%">
                    <div class="col-lg-12" style="text-align:center"> 
                        <button type="button" class="btn btn-primary" style="width: 120px;font-family: sans-serif;float:left" id="back" ><i class="fa fa-arrow-left"> </i> Back</button>
                        <!--<input type="button" class="btn btn-primary" style="width: 120px;font-family: sans-serif;" id="back" value="Back">--> 
                        <input type="button" class="btn btn-success" style="width: 120px;font-family: sans-serif;" name="saveemployee" id="btn_save" value="<?php echo $task; ?>" onclick="save()" <?php if($task=='Update' && $data[0]->student_academicyear_id!=$data[0]->sessid){ echo 'disabled=true title="You Cant Update this student! You have to either promote or passout this student"';}?>>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
<script src="<?php echo e(base_url("assets/AdminLTE/plugins/bootstrap-fileinput/bootstrap-fileinput.js")); ?>" type="text/javascript"></script>
<script>
    var globalid = '';
    var save_method = '<?php echo $task; ?>';

    $('#back').click(function () {
        window.location.href = "<?php echo base_url('admission/student'); ?>";
    });

    $(document).ready(function(){
        if($('#student_type').val()!='EXISTING') {
            $('#div_start_fee_month').show();
        }else{
            $('#div_start_fee_month').hide();
        }
    });

    function save() {

        if (!$('form')[0].checkValidity())
        {
//                                                alert($('#add_stud_frm')[0].validationMessage);
            $(this).show();
            $('form')[0].reportValidity();
            return false;
        } else {
            var r = confirm("Are you sure you want to save?");
            if (r == true) {
                $('#btnSave').text('saving...'); //change button text
                $('#btnSave').attr('disabled', true); //set button disable 

                var url;
                // console.log(save_method);
                if (save_method == 'Save') {
                    url = "<?php echo base_url('admission/student/add'); ?>";
                    $('#btnSave').text('Saving...');
//                    alert(url);
                } else {

                    globalid="<?php if($task=='Update') {echo $data[0]->id; }else {echo '';}?>";
                    $('#btnSave').text('Updating...');
                    url = "<?php echo base_url('admission/student/update/'); ?>" + globalid;
                   
                }

                $.ajax
                        ({
                            url: url,
                            type: "POST",
//                            data: $('form').serialize(),
                            data: new FormData($('form')[0]),
                            contentType:false,
                            processData:false,
                            cache:false,
//                            dataType: "text",
                            dataType: "json",
                            success: function (data) {
////                                
                                console.log(data);
//                                if (data == 1) { //if success close modal and reload ajax table
////                                    $('#modal_form').modal('hide');
//                                        alert("Successfully Done!");
//                                    window.location.href="<?php // echo base_url('admission/student'); ?>";
//                                }
//
////						$('#btnSave').text('save'); //change button text
////						$('#btnSave').attr('disabled',false); //set button enable 
                                    if($.isEmptyObject(data.error)){
                                        alert("Successfully Done!");
                                        window.location.href="<?php echo base_url('admission/student'); ?>";

                                     }else{
                                     	alert("Failed Try Again !");

     //                                        $("#errmodal").css('display','block');
     //                                        $("#errmodal").html(data.error);
                                                 $.each(data.error, function(key, value) {
                                                     if(value){
                                                         $('#' + key).css('border','1px solid red');
                                                         $('#' + key).next('.error-block').html(value);
                                                     }
                                                 });
                                     }

                                     $('#btnSave').text('save'); //change button text
                                     $('#btnSave').attr('disabled',false); //set button enable 
                            },
                                error:function(d,d1){
                                    alert('error');
                                }
                        });
            } else {
                return false;
            }

        }
    }


    function duplication_check(me) {

        var field_name = $(me).attr('name');
//        alert(field_name);
        var value = $(me).val();
        $.ajax({
            url: '<?php echo base_url('admission/student/duplication_check'); ?>',
            type: "POST",
            data: {field_name: field_name,
                value: value,
            },
            dataType: "text",
            success: function (data) {
//                if (data != '') {
//
////				alert(data);
//                    $("#"+field_name+"_error").text(data);
//                    $("#"+field_name+"_error").css('display','block');
//                    $('#btn_save').attr('disabled', true);
//                } else {
//                    $('#errmodal').text('');
//                    $("#"+field_name+"_error").css('display','none');
//                    $('#btn_save').attr('disabled', false);
//                }

                if (data != '') {

//				alert(data);
//                    $("#"+field_name+"_error").text(data);
//                    $("#"+field_name+"_error").css('display','block');
                    $('#' + field_name).next('.error-block').html(data);
                    $('#btn_save').attr('disabled', true);
                } else {
                    $('#errmodal').text('');
                    $('#' + field_name).next('.error-block').html('');
                    $('#btn_save').attr('disabled', false);
                }
            },
            error: function (data, status) {
                alert('Error.');
            }
        });

    }

    function pick_up(abc)
    {
       var id = abc;
        
        
         $.ajax({
            url: "<?php echo base_url(); ?>Get_vehicle",
            type: "POST",
            data: {id: id},
            dataType: "json",
            success: function (data) 
            {
                
             $('#transport_id').html();
             $('#transport_id').html(data.successdata);
            }
        });
    }
    function getamount()
    {
        var vehicle=$('#transport_id').val();
        var ppoint_id=$('#ppoint_id').val();
        $.ajax({
            url: "<?php echo base_url(); ?>admission/student/Get_amount",
            type: "POST",
            data: {vehicle: vehicle,ppoint_id:ppoint_id},
            dataType: "json",
            success: function (data) 
            {
                $('#transport_amt').val(data.amount);
            }
        });
    }
    
    
    $('#student_type').change(function(){
            if(this.value!='EXISTING') {
                $('#div_start_fee_month').show();
            }else{
                $('#div_start_fee_month').hide();
            }
    });
    
</script>
