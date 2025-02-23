<style>
    .form-group{margin-bottom: 10px;} 
    fieldset { 
        border: solid 1px #a6a6a6 !important;
        padding: 0 10px 10px 10px;
        border-bottom: none;
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
<div class="form-group">
    <div class="panel  panel-default"> 

        <div class="panel-body">

            <?php 
            // echo $task;
            if ($task=='Save'){
?>
            <form enctype="multipart/form-data" id="employeedetails-form" action="save" method="post">
  <?php          }
  else{
// echo $this->uri->segment(5);


    ?>
<form enctype="multipart/form-data" id="employeedetails-form" action="update/<?php echo $this->uri->segment(5);?>" method="post">

  <?php }

            ?>
                <div class="col-sm-12 col-md-12">

                    <div class="row">
                        <div class="col-sm-8">

                            <fieldset class="">

                                <legend class="" style="font-size:18px;color:green">
                                    Profile <span class="required"></span>
                                </legend>

                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label  style="font-weight: 600">Employee Code</label> <span style='color:red;font-weight:bold'>*</span>
                                        <input class="form-control" name="employee_code" id="employee_code" type="text" value="<?php echo $employee_code; ?>">
                                        <span class="error-block"></span>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label style="font-weight: 600">Name</label> <span style='color:red;font-weight:bold'>*</span>
                                        <input class="form-control" name="employee_name" id="employee_name" type="text" value="<?php echo $name; ?>" required>
                                        <span class="error-block"></span>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label style="font-weight: 600">Joining Date</label> <span style='color:red;font-weight:bold'>*</span>
                                        <input type='date' class="form-control" id="doj" name="doj" value="<?php echo $doj; ?>" required>

                                        <span class="error-block"></span>
                                    </div>
                                    <div class="form-group col-sm-2">

                                    </div>
                                </div>
                                <div class="row">

                                    <div class="form-group col-sm-4">
                                        <label style="font-weight: 600">Employee Category</label> <span style='color:red;font-weight:bold'>*</span>
                                        <select class="form-control chosen-select" id="category" name="category" required>
                                            <option value="">Select Category</option>                                                                    
                                            <option <?php
                                            if ($category == 1) {
                                                echo 'selected="selected"';
                                            }
                                            ?>  value="1">Teaching Staff</option>
                                            <option <?php
                                            if ($category == 2) {
                                                echo 'selected="selected"';
                                            }
                                            ?>  value="2">Non-Teaching Staff</option>

                                        </select>

                                        <span class="error-block"></span>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label style="font-weight: 600">Department</label>
                                        <select class="form-control chosen-select" id="department" name="department" >
                                            <option value="0">Select Department</option>
                                                <?php foreach ($fetch_department as $dept) {
                                                    ?>
                                                <option <?php
                                                if ($department == $dept->id) {
                                                    echo 'selected="selected"';
                                                }
                                                ?>  value="<?php echo $dept->id; ?>"><?php echo $dept->department_desc; ?></option>
                                                <?php } ?>
                                        </select>
                                        <span class="error-block"></span>
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <label style="font-weight: 600">Designation</label> <span style='color:red;font-weight:bold'>*</span>
                                        <select class="form-control chosen-select" id="designation" name="designation" required> 
                                            <option value="0">Select Designation</option>
                                                <?php foreach ($fetch_designation as $desg) {
                                                    ?>
                                                <option <?php
                                                    if ($designation == $desg->id) {
                                                        echo 'selected="selected"';
                                                    }
                                                    ?>  
                                                    value="<?php echo $desg->id; ?>"><?php echo $desg->designation_desc; ?>
                                                </option>
                                                <?php } ?>
                                        </select>

                                        <span class="error-block"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label style="font-weight: 600">Leave Group</label> <span style='color:red;font-weight:bold'>*</span>
                                        <select class="form-control chosen-select" id="leave_group" name="leave_group">
                                            <option value="">Select Leave Group</option>
                                                <?php foreach ($fetch_leave_group as $lv) {
                                                    ?>
                                                <option <?php
                                                    if ($leave_group == $lv->id) {
                                                        echo 'selected="selected"';
                                                    }
                                                    ?>  value="<?php echo $lv->id; ?>"><?php echo $lv->leave_group_name; ?>
                                                </option>
                                                <?php } ?>
                                        </select>
                                        <span class="error-block"></span>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label style="font-weight: 600">Qualification</label>
                                        <input class="form-control" name="qualification" id="qualification" type="text" value="<?php echo $qualification; ?>">
                                        <span class="error-block"></span>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label style="font-weight: 600">Total Experience</label>
                                        <input  class="form-control" name="total_experience" id="total_experience" type="text" value="<?php echo $total_experience; ?>">
                                        <span class="error-block"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label style="font-weight: 600">User Group</label> <span style='color:red;font-weight:bold'>*</span>
                                        <select class="form-control chosen-select" id="user_group" name="user_group" required>
                                            <option value="">Select User Group</option>
                                            <?php foreach ($fetch_user_group as $uv) {
                                                ?>
                                                <option <?php
                                                if ($user_group == $uv->id) {
                                                    echo 'selected="selected"';
                                                }
                                                ?>  value="<?php echo $uv->id; ?>"><?php echo $uv->group_type; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                        <span class="error-block"></span>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label style="font-weight: 600">Salary Group</label> <span style='color:red;font-weight:bold'>*</span>
                                        <select class="form-control chosen-select" id="salary_group_id" name="salary_group_id" >
                                            <option value="">Select</option>
                                                <?php foreach ($fetch_salary_group as $lv) {
                                                    ?>
                                                <option <?php if ($salary_group == $lv->id) {
                                                    echo 'selected="selected"';
                                                } ?>  value="<?php echo $lv->id; ?>"><?php echo $lv->salary_group_name; ?>
                                                </option>
                                                <?php } ?>
                                        </select>
                                        <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <!--                                        <label style="font-weight: 600">Total Experience</label>
                                        <input  class="form-control" name="total_experience" id="total_experience" type="text" value="<?php // echo $total_experience; ?>">
                                        <span class="error-block"></span>-->
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-sm-4">
                            <div class="fileinput fileinput-new" data-provides="fileinput" style="margin-top: 12px;">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;border: 1px solid #ddd;">

                                        <?php if (!empty($photo)) { ?>

                                        <img src="<?php  echo e(base_url('/hr/staff/'.basename($photo))) ?>" alt="Staff Pic" /> 

                                        <?php } else { ?>

                                        <img src="<?php echo e(base_url("assets/img/red_user.png")) ?>" alt="" /> 
                                        <?php } ?>

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
                        <div class="col-sm-6">
                            <fieldset class="">

                                <legend class="" style="font-size:18px;color:green">
                                    Personal Details <span class="required"></span>
                                </legend>

                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">Father's Name</label>
                                        <input class="form-control" name="father_name" id="employee_code" type="text" value="<?php echo $father_name; ?>" >
                                        <span class="error-block"></span>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">Mother's name</label>
                                        <input class="form-control" name="mother_name" id="mother_name" type="text" value="<?php echo $mother_name; ?>" >
                                        <span class="error-block"></span>
                                    </div>
                                </div>
                                <div class="row">


                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">D.O.B</label>
                                        <input type='date' class="form-control" id="dob" name="dob" value="<?php echo $dob; ?>" >

                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">Gender</label>
                                        <div>
                                            <label class="radio-inline"><input type="radio" name="gender" value="M" checked="checked"<?php
                                                if ($gender == 'M') {
                                                    echo 'checked=checked';
                                                }
                                                ?>>Male</label>
                                            <label class="radio-inline"><input type="radio" name="gender" value="F" <?php
                                                if ($gender == 'F') {
                                                    echo 'checked=checked';
                                                }
                                                ?>>Female</label>
                                        </div>
                                        <span class="error-block"></span>
                                    </div>
                                </div>
                                <div class="row">


                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">Martial Status</label>
                                        <input class="form-control" name="martial_status" id="martial_status" type="text" value="<?php echo $martial_status; ?>">
                                        <span class="error-block"></span>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">Spouse Name</label>
                                        <input  class="form-control" name="spouse_name" id="spouse_name" type="text" value="<?php echo $spouse_name; ?>">
                                        <span class="error-block"></span>
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">Aadhar No</label>
                                        <input class="form-control" name="aadhar_no" id="aadhar_no" type="text" value="<?php echo $aadhar_no; ?>" >
                                        <span class="error-block"></span>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">Voter Id</label>
                                        <input  class="form-control" name="voter_id" id="voter_id" type="text" value="<?php echo $voter_id; ?>">
                                        <span class="error-block"></span>
                                    </div>
                                </div>

                                <div class="row">    


                                </div>
                            </fieldset>

                        </div>    
                        <div class="col-sm-6">

                            <fieldset class="">
                                <legend class="" style="font-size:18px;color:green">
                                    Account Details <span class="required"></span>
                                </legend>

                                <div class="row">

                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600"> Bank Name</label>
                                        <select class="form-control chosen-select" name="bank_name" id="bank_name">
                                            <option value="">Select Bank Name</option>
                                                <?php foreach ($fetch_bank as $bnk) {
                                                    ?>
                                                <option <?php
                                                    if ($bank == $bnk->id) {
                                                        echo 'selected="selected"';
                                                    }
                                                    ?>  value="<?php echo $bnk->id; ?>"><?php echo $bnk->bank_name; ?>
                                                </option>
                                                <?php } ?>
                                        </select>

                                        <span class="error-block"></span>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">Account No.</label>
                                        <input class="form-control" name="account_no" id="account_no" type="text" value="<?php echo $account_no; ?>">
                                        <span class="error-block"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">IFSC Code</label>
                                        <input class="form-control" name="ifsc_code" id="ifsc_code" type="text" value="<?php echo $ifsc_code; ?>">
                                        <span class="error-block"></span>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">PAN No</label>
                                        <input class="form-control" name="pan_no" id="pan_no" type="text" value="<?php echo $pan_no; ?>">
                                        <span class="error-block"></span>
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="form-group col-sm-12">
                                        <label style="font-weight: 600">Branch Address</label>
                                        <textarea class="form-control" name="branch_address" id="branch_address"><?php echo $branch_address; ?></textarea>
                                        <span class="error-block"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">PF No.</label>
                                        <input  class="form-control" name="pf_no" id="pf_no" type="text" value="<?php echo $pf_no; ?>">
                                        <span class="error-block"></span>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">ESI No.</label>
                                        <input class="form-control" name="esi_no" id="esi_no" type="text" value="<?php echo $esi_no; ?>">
                                        <span class="error-block"></span>
                                    </div>


                                </div>
                                <?php if($school[0]->school_group=='DAV') { ?>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">Pension No.</label>
                                        <input  class="form-control" name="pension_no" id="pension_no" type="text" value="<?php echo $pension_no; ?>">
                                        <span class="error-block"></span>
                                    </div>
                                     <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">Pension Nominee</label>
                                        <input  class="form-control" name="pension_nom" id="pension_nom" type="text" value="<?php echo $pension_nom; ?>">
                                        <span class="error-block"></span>
                                    </div>
                                </div>
                                <?PHP } ?>
                            </fieldset>

                        </div>  
                    </div>
                    <div class="row" style="padding-top:2%">
                        <div class="col-sm-12">
                            <fieldset class="">
                                <legend class="" style="font-size:18px;color:green">Contact Details <span class="required"></span></legend>
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label style="font-weight: 600">Address</label>
                                        <textarea class="form-control" name="address" id="address"><?php echo $address; ?></textarea>
                                        <span class="error-block"></span>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="reg_input_name" class="" style="font-weight: 600">Phone No</label>
                                        <input class="form-control" name="phone" id="phone" type="number" value="<?php echo $phone; ?>" required>
                                        <span class="error-block"></span>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="reg_input_name" class="" style="font-weight: 600">Email</label>
                                        <input class="form-control" name="email" id="email" type="email" value="<?php echo $email; ?>">
                                        <span class="error-block"></span> 
                                    </div>


                                </div>

                            </fieldset>

                        </div>
                    </div>
                    <div class="row" style="padding-top:2%">
                        <div class="col-lg-12" style="text-align:center"> 
                            <button type="button" class="btn btn-primary" style="width: 120px;font-family: sans-serif;float:left" id="back" ><i class="fa fa-arrow-left"> </i> Back</button>
                            <!--<input type="button" class="btn btn-primary" style="width: 120px;font-family: sans-serif;" id="back" value="Back">--> 

                            <input type="submit" class="btn btn-success" style="width: 120px;font-family: sans-serif;" name="saveemployee" id="" value="<?php echo $task; ?>">
                        </div>
                    </div>

                </div>
                <div class="col-sm-12 col-md-12" id="fee_collect_div">

                </div>

                <!--                                </div>          
                </div>-->
            </form>
        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
<script src="<?php echo e(base_url("assets/AdminLTE/plugins/bootstrap-fileinput/bootstrap-fileinput.js")); ?>" type="text/javascript"></script> 
<script>

    $(document).ready(function ()
    {
//      $(".chosen-select").chosen();
//      $(".chosen-select").chosen({width: "100%"});  
        var task = '<?php echo $task; ?>';
        var employee_id = '<?php echo $employee_id; ?>';
//            $('#datetimepicker1').datetimepicker({
//                todayBtn: true,
//                autoclose: true,
//                pickerPosition: "bottom-left",
//                format:'yyyy-mm-dd',
//                minView: 2,
//
//            }); 
//            $('#datetimepicker2').datetimepicker({
//                todayBtn: true,
//                autoclose: true,
//                pickerPosition: "bottom-left",
//                format:'yyyy-mm-dd',
//                minView: 2,
//
//            });

        $('#back').click(function () {
//                alert('hi');
            window.location.href = '<?php echo base_url('hr/staff/employees'); ?>';
        });

        $('#btn_save').click(function () {

            if (!$('#employeedetails-form')[0].checkValidity()) {
//                                                alert($('#add_stud_frm')[0].validationMessage);
                $(this).show();
                $('#employeedetails-form')[0].reportValidity();
                return false;
            } else {
                var formdata = $('form').serialize();
                if (task == 'Save')
                {
                    action_url = '<?php echo base_url('hr/staff/employees/save'); ?>';
                }
                else
                {
                    action_url = '<?php echo base_url('hr/staff/employees/update'); ?>' + '/' + employee_id;
                }
               // alert(action_url);
                $.ajax
                        ({
                            type: 'POST',
                            data: formdata,
                            url: action_url,
                            dataType: "text",
                            success: function (data)
                            {
                                window.location.href = '<?php echo base_url('hr/staff/employees'); ?>';

                            },
                            error: function (data)
                            {
                                alert('error occured while saving' + data);
                            }

                        });
            }
        });



    });



</script>