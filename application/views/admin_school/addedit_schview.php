<style>
       .form-group{margin-bottom: 10px;} 
 fieldset { 
 border: solid 1px #DDD !important;
    padding: 0 10px 10px 10px;
    border-bottom: none;
}
legend{
    width: auto !important;
    padding:0 10px;
    border: none;
    font-size: 16px;
    font-family:cursive;
    color:green;
}
.form-control{
    padding: 6px 5px !important;
}
</style>
<!--<div class="form-group">-->
    <div class="panel panel-default"> 
        <div class="panel-body">
            <form enctype="multipart/form-data" id="schools_form" action="<?php echo base_url("$action_url") ?>" method="post">
                
                <div class="row">
                    <div class="col-sm-8">
                        <fieldset class="">
                            <legend>
                                School Details <span class="required"></span>
                            </legend>
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label  style="font-weight: 600">School Name</label>
                                        <input type="text" class="form-control" id="school_name" name="school_name" required autofocus value="<?php echo $school_name;?>">
                                        <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                                    </div>
                                    <div class="form-group col-sm-4">
                                            <label style="font-weight: 600">School Code</label>
                                            <input type="text" class="form-control" id="school_code" name="school_code" required value="<?php echo $school_code;?>">
                                            <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label style="font-weight: 600">School Group</label>
                                        <select class="form-control" id="school_group" name="school_group"> 
                                            <option value="">- Select Group -</option>
                                            <?php foreach ($sch_group as $obj_group) { ?>
                                                <option value="<?php echo $obj_group->sgroup_code; ?>" <?php if ($selected_school_group == $obj_group->sgroup_code) echo 'selected=selected'; ?>><?php echo $obj_group->sgroup_name ?></option>
                                            <?php } ?>
                                        </select> 
                                    </div>
                                   
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label  style="font-weight: 600">Country</label>
                                        
                                        <select class="form-control" id="country" name="country" onchange="select_country()"> 
                                            <option value="">- Select Country -</option>
                                            <?php foreach ($country as $obj_country) { ?>
                                                <option value="<?php echo $obj_country->id; ?>" <?php if($selected_country==$obj_country->id) echo 'selected=selected';?>><?php echo $obj_country->country_name ?></option>
                                            <?php } ?>
                                        </select>
                                  
                                        <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                                    </div>
                                    <div class="form-group col-sm-4" id="div_state">
                                            <label style="font-weight: 600">State</label>
                                            <select class="form-control" id="school_state" name="school_state" onchange="select_state()">
                                                <option value="">- Select State -</option>
                                                 <?php foreach ($states as $obj_states) { ?>
                                                <option value="<?php echo $obj_states->id; ?>" <?php if($selected_state==$obj_states->id) echo 'selected=selected';?>><?php echo $obj_states->state_name ?></option>
                                            <?php } ?>
                                                
                                            </select>
                                            <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                                    </div>
                                    <div class="form-group col-sm-4" id="div_city">
                                            <label style="font-weight: 600">City</label>
                                            <select class="form-control" id="school_city" name="school_city" >
                                                <option value="">- Select City -</option>
                                                 <?php foreach ($cities as $obj_cities) { ?>
                                                <option value="<?php echo $obj_cities->id; ?>" <?php if($selected_city==$obj_cities->id) echo 'selected=selected';?>><?php echo $obj_cities->city_name ?></option>
                                            <?php } ?>
                                            </select>
                                            <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label  style="font-weight: 600">Contact No</label>
                                        <input type="text" class="form-control" id="contact_no" name="contact_no" required value="<?php echo $contact_no;?>">
                                        <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                                    </div>
                                    <div class="form-group col-sm-4">
                                            <label style="font-weight: 600">Email Address</label>
                                            <input type="email" class="form-control" id="email_address" name="email_address" onblur="check_email()" required value="<?php echo $email_addr;?>">
                                            <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                                    </div>
                                     <div class="form-group col-sm-4">
                                            <label style="font-weight: 600">Vision/Message</label>
                                            <input type="text" class="form-control" id="school_code" name="vision"  value="<?php echo $vision;?>">
                                            <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <label  style="font-weight: 600">Address</label>
                                        <textarea class="form-control" id="school_address" name="school_address" required ><?php echo $sch_addr;?></textarea>
                                        <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                                    </div>
                                    
                                    
                                </div>
                                
                                
                                
                            </legend>
                        </fieldset>
                    </div>
                    <div class="col-sm-4">
                        <fieldset class="">
                            <legend>
                                School Logo <span class="required"></span>
                            </legend>
                        </fieldset>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <fieldset class="">
                            <legend>
                                Fee Payment Settings <span class="required"></span>
                            </legend>
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="row" style="padding-bottom: 13px;">
                                        <div class="form-group col-sm-12">
                                    <label  style="font-weight: 600">Fee Structure : </label>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label>1. Monthly/Quarterly</label>
                                            <div class="form-group">
                                                <div class="custom-control custom-radio">
                                                  <input type="radio" name="optradio1" value="1" <?php if($fee_type1==1) {echo 'checked';} ?>>
                                                  <label class="radio-inline" for="customRadio1">Monthly</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                  <input type="radio" name="optradio1" value="2" <?php if($fee_type1==2) {echo 'checked';} ?>>
                                                  <label class="radio-inline" for="customRadio2">Quarterly</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <label>2. Annual/HalfYearly</label>
                                                <div class="form-group">
                                                    <div class="custom-control custom-radio">
                                                      <input type="radio" name="optradio2" value="3" <?php if($fee_type2==3) {echo 'checked';} ?>>
                                                      <label class="radio-inline" for="customRadio1">Half-Yearly</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                      <input type="radio" name="optradio2" value="4" <?php  if($fee_type2==4) {echo 'checked';} ?>>
                                                      <label class="radio-inline" for="customRadio2">Annual</label>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="col-sm-4"> 
                                            <label>3. Onetime :</label>
                                            <div class="form-group">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="optradio3" value="YES" <?php if($onetime=="YES") {echo 'checked';} ?>>
                                                    <label class="radio-inline" for="customRadio1">YES</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="optradio3" value="NO" <?php if($onetime=="NO") {echo 'checked';} ?>>
                                                    <label class="radio-inline" for="customRadio2">NO</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                            
                                            
                                           <!--  <label class="radio-inline">1.)</label> 
                                            <label class="radio-inline "><input type="radio" name="optradio1" value="1" <?php if($fee_type1==1) {echo 'checked';} ?>>Monthly </label>
                                            <label class="radio-inline "><input type="radio" name="optradio1" value="2" <?php if($fee_type1==2) {echo 'checked';} ?>>Quarterly</label>
                                            <label class=" radio-inline">2.)</label>
                                            <label class="radio-inline "><input type="radio" name="optradio2" value="3" <?php if($fee_type2==3) {echo 'checked';} ?>>Half-Yearly</label>
                                            <label class="radio-inline"><input type="radio" name="optradio2" value="4" <?php  if($fee_type2==4) {echo 'checked';} ?>>Annual</label>

                                            <label class=" radio-inline">3.)</label>
                                            <label class="radio-inline "><input type="radio" name="optradio3" value="YES" <?php if($onetime=="YES") {echo 'checked';} ?>>Onetime(Y)</label>
                                            <label class="radio-inline"><input type="radio" name="optradio3" value="NO" <?php if($onetime=="NO") {echo 'checked';} ?>>Onetime(N)</label> -->
                                            
                                </div>
                                        <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 

                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-5">
                                            <label  style="font-weight: 600">Start Payment Day  </label> (of every month)
                                            <input type="text" class="form-control" id="start_pay_date" name="start_pay_date" required placeholder="Day" value="<?php echo $start_pay_day;?>">
                                            <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                                        </div>
                                        <div class="form-group col-sm-5">
                                                <label style="font-weight: 600">Last Payment Day  </label> (of every month)
                                                <input type="text" class="form-control" id="last_pay_date" name="last_pay_date" required placeholder="Day" value="<?php echo $last_pay_day;?>">
                                                <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                                        </div>


                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-5">
                                                <label style="font-weight: 600">Whether to Freeze the payment after crossing Due Date </label>
                                                <select class="form-control" name="trans_freeze_status">
                                                    <option value="0" <?php if($trans_freeze_status==0) echo 'selected=selected';?>>NO</option>
                                                    <option value="1" <?php if($trans_freeze_status==1) echo 'selected=selected';?>>YES</option>
                                                </select>
                                                <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                                        </div>
                                        <div class="form-group col-sm-5">
                                                <label style="font-weight: 600">Whether to have Fine details With Monthly Segregation </label>
                                                <select class="form-control" name="fine_monthly_segregation">
                                                    <option value="NO" <?php if($fine_monthly_segregation=="NO") echo 'selected=selected';?>>NO</option>
                                                    <option value="YES" <?php if($fine_monthly_segregation=="YES") echo 'selected=selected';?>>YES</option>
                                                </select>
                                                <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-5">
                                            <label style="font-weight: 600">Last Month For Annual Fee </label> (If Applicable)
                                            <select name="annual_month" id="annual_month" class="form-control">
                                              <option value="0" <?php if($annual_last_month=="0") echo 'selected=selected';?>>Select Month</option>
                                              <option value="01" <?php if($annual_last_month=="01") echo 'selected=selected';?>>April</option>
                                              <option value="02" <?php if($annual_last_month=="02") echo 'selected=selected';?>>May</option>
                                              <option value="03" <?php if($annual_last_month=="03") echo 'selected=selected';?>>June</option>
                                              <option value="04" <?php if($annual_last_month=="04") echo 'selected=selected';?>>July</option>
                                              <option value="05" <?php if($annual_last_month=="05") echo 'selected=selected';?>>August</option>
                                              <option value="06" <?php if($annual_last_month=="06") echo 'selected=selected';?>>September</option>
                                              <option value="07" <?php if($annual_last_month=="07") echo 'selected=selected';?>>October</option>
                                              <option value="08" <?php if($annual_last_month=="08") echo 'selected=selected';?>>November</option>
                                              <option value="09" <?php if($annual_last_month=="09") echo 'selected=selected';?>>December</option>
                                              <option value="10" <?php if($annual_last_month=="10") echo 'selected=selected';?>>January</option>
                                              <option value="11" <?php if($annual_last_month=="11") echo 'selected=selected';?>>February</option>
                                              <option value="12" <?php if($annual_last_month=="12") echo 'selected=selected';?>>March</option>
                                            </select>
                                                <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                                        </div>
                                        <div class="form-group col-sm-5">
                                                <label style="font-weight: 600">Late Fine Type </label> (on select/deselect checkbox)
                                                <select class="form-control" name="fine_type_checkbox">
                                                    <option value="FIXED" <?php if($fine_type_checkbox=="FIXED") echo 'selected=selected';?>>Fixed Amount as in Class Fee</option>
                                                    <option value="ADJUSTABLE" <?php if($fine_type_checkbox=="ADJUSTABLE") echo 'selected=selected';?>>Adjustable Amount</option>
                                                    <option value="NOT_CHANGEABLE" <?php if($fine_type_checkbox=="NOT_CHANGEABLE") echo 'selected=selected';?>>Not Changeable Amount</option>
                                                </select>
                                                <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                                        </div>
                                    </div>
                                    </div>
                                <div class="col-sm-4">
                                    <div class="row">
                                        <div class="form-group col-sm-6"> 
                                                <label style="font-weight: 600">Payment Gateway</label>
                                                <select class="form-control" name="pymt_gateway" id="pymt_gateway" required>
                                                    <option value="">Select</option>
                                                    <?php foreach ($pymt_gw as $gw) { ?>                                                   
                                                        <option value="<?php echo $gw->pymt_gw_code; ?>" <?php if($selected_pw_gw==$gw->pymt_gw_code) echo 'selected=selected' ;?>><?php echo $gw->pymt_gw_code; ?></option>                                                   
                                                    <?php } ?>
                                                </select>
                                                <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                                        </div>
                                        <div class="form-group col-sm-6">
                                                <label style="font-weight: 600">Stop Transaction</label>
                                                <select class="form-control" name="stop_transaction" required>
                                                    <option value="NO" <?php if($stop_trans=='NO') echo 'selected=selected';?>>NO</option>
                                                    <option value="YES" <?php if($stop_trans=='YES') echo 'selected=selected';?>>YES</option>

                                                </select>
                                                <div class="school_val_error" id="" style="display:none"></div> 
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                                <label style="font-weight: 600">Enter Mid/Account ID </label>
                                                <input type="text" class="form-control" id="mid" name="mid" required placeholder="Merchant/Account Id" value="<?php echo $pgw_mid;?>" <?php if ($pgw_mid!=''){?> readonly <?php } ?>>
                                                <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                                        </div>
                                        <div class="form-group col-sm-6">
                                                <label style="font-weight: 600">TEST/LIVE MODE ?</label>
                                                <select name="test_live_mode" id="test_live_mode" class="form-control disabled-select" <?php if($test_live_mode=='LIVE'){ echo 'style="pointer-events: none;
  touch-action: none;"';}?>>
                                                    <option value="TEST" <?php if($test_live_mode=='TEST') echo 'selected=selected';?>>TEST</option>
                                                    <option value="LIVE" <?php if($test_live_mode=='LIVE') echo 'selected=selected';?>>LIVE</option>
                                                </select>
                                                <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                                <label style="font-weight: 600">Enter Encryption Key </label>
                                                <input type="text" class="form-control" id="enckey" name="enckey" required placeholder="Encryption Key" value="<?php echo $pgw_enc_key;?>" <?php if ($pgw_enc_key!=''){?> readonly <?php } ?>>
                                                <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                                        </div>
                                    </div>
                                    <div class="row"  id="div_access_code">
                                        <div class="form-group col-sm-12">
                                                <label style="font-weight: 600">Enter Access Code (If any)</label>
                                                <input type="text" class="form-control" id="pgw_access_code" name="pgw_access_code"  placeholder="Access Code" value="<?php echo $pgw_access_code;?>" <?php if ($pgw_access_code!=''){?> readonly <?php } ?>>
                                                <div class="school_val_error" id="Employeemaster_employee_code_em_" style="display:none"></div> 
                                        </div>
                                    </div>
                                     <div class="row">
                                     <div class="form-group col-sm-12"> 
                                            <label style="font-weight: 600">Admission in between</label>
                                                <select class="form-control" name="adm_btw">
                                                    <option value="NO" <?php if($admsn_in_between=="NO") echo 'selected=selected';?>>NO</option>
                                                    <option value="YES" <?php if($admsn_in_between=="YES") echo 'selected=selected';?>>YES</option>
                                                   
                                                </select>

                                        </div>
                                    </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <fieldset class="">
                            <legend>
                                Other Settings <span class="required"></span>
                            </legend>
                                <div class="row">
                                    <div class="form-group col-sm-3">
                                        <label class="control-label">Password Generation for Students </label>
                                            
                                        <select class="form-control" id="pwd_generation" name="pwd_generation" > 
                                            <option value="MANUAL" <?php if($pwd_gen=="MANUAL") {echo 'selected=selected';} ?>>Manual</option>
                                            <option value="AUTO" <?php if($pwd_gen=="AUTO") {echo 'selected=selected';} ?>>Auto</option>
                                        </select>
                                            
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="transport_fee" class="control-label">Is Transport Fee Applicable </label>
                                            
                                        <select class="form-control" id="transport_fee" name="transport_fee"> 
                                            <option value="NO" <?php if($trans_fee_status=="NO") {echo 'selected=selected';} ?>>NO</option>
                                            <option value="YES" <?php if($trans_fee_status=="YES") {echo 'selected=selected';} ?>>YES</option>
                                        </select>
                                            
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="transport_fee" class="control-label">Start Report Date</label>
                                            
                                        <input type="date" class="form-control" id="start_report_date" name="start_report_date" value="<?php echo $start_report_date;?>"> 
                                            
                                            
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label for="school_status" class="control-label">Status </label>
                                            
                                        <select class="form-control" id="school_status" name="school_status"> 
                                            <option value="1" <?php if($school_status=="1") {echo 'selected=selected';} ?>>Active</option>
                                            <option value="0" <?php if($school_status=="0") {echo 'selected=selected';} ?>>Inactive</option>
                                        </select>
                                            
                                    </div>
                                </div>
                            
                        </fieldset>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-sm-12">
                        <fieldset class="">
                            <legend>
                                SMS Settings <span class="required"></span>
                            </legend>
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label for="transport_fee" class="control-label">SMS INTEGRATION</label>
                                        <select class="form-control" id="sms_integration" name="sms_integration"> 
                                        <option value="NO" <?php if($sms_integration=="NO") {echo 'selected=selected';} ?>>NO</option>
                                        <option value="YES" <?php if($sms_integration=="YES") {echo 'selected=selected';} ?>>YES</option>
                                        </select>   
                                    </div>
                                     <div class="form-group col-sm-4">
                                        <label class="control-label">SEND SMS</label>  
                                        <select class="form-control" id="send_sms" name="send_sms" > 
                                        <option value="MANUAL" <?php if($send_sms=="MANUAL") {echo 'selected=selected';} ?>>Manual</option>
                                        <option value="AUTO" <?php if($send_sms=="AUTO") {echo 'selected=selected';} ?>>Auto</option>
                                        </select>                                           
                                    </div>
                                </div>
                            
                        </fieldset>
                    </div>
                </div>
                                <div class="row">
                    <div class="col-sm-12">
                        <fieldset class="">
                            <legend>
                                Module Priviledge <span class="required"></span>
                            </legend>
                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <?php $dis='';
                                    if($task=='Update') { 
                                        $dis='disabled';?>
                                    <label class="control-label"> Want to modify this ? </label> <label class="radio-inline "><input type="radio" name="optradioc" value="yes" /> Yes</label><label class="radio-inline "> <input type="radio" name="optradioc" value="no" checked=""/> NO </label>
                                    <?php }else{  $dis='';}?>
                                </div>
                                <div class="col-sm-12 checkbox checkbox-circle">
                                    <?php foreach ($modules as $value) {?>
                                    <label class="checkbox-inline"><input type="checkbox" name="module_privl[<?php echo $value->id;?>]" value="<?php echo $value->m_code;?>" <?php foreach($sch_modules as $sch){ if($sch->modules==$value->m_code) {echo 'checked';}} echo " $dis";?>><?php echo $value->m_name;?></label>
                                    <?php }?>
                                   
<!--                                   <label class="checkbox-inline"><input type="checkbox" name="module_privl[]" value="student_management" <?php // foreach($sch_modules as $sch){ if($sch->modules=='student_management') {echo 'checked';}} ?>>Student Management</label>
                                   <label class="checkbox-inline"><input type="checkbox" name="module_privl[]" value="academics" <?php // foreach($sch_modules as $sch){ if($sch->modules=='academics') {echo 'checked';}} ?>>Academics</label>
                                   <label class="checkbox-inline"><input type="checkbox" name="module_privl[]" value="hr_payroll" <?php // foreach($sch_modules as $sch){ if($sch->modules=='hr_payroll') {echo 'checked';}} ?>>HR/Payroll</label>
                                   <label class="checkbox-inline"><input type="checkbox" name="module_privl[]" value="attendence" <?php // foreach($sch_modules as $sch){ if($sch->modules=='attendence') {echo 'checked';}} ?>>Attendence</label>
                                   <label class="checkbox-inline"><input type="checkbox" name="module_privl[]" value="library" <?php // foreach($sch_modules as $sch){ if($sch->modules=='library') {echo 'checked';}} ?>>Library</label>
                                   <label class="checkbox-inline"><input type="checkbox" name="module_privl[]" value="inventory" <?php // foreach($sch_modules as $sch){ if($sch->modules=='inventory') {echo 'checked';}} ?>>Inventory</label>
                                   <label class="checkbox-inline"><input type="checkbox" name="module_privl[]" value="transport" <?php // foreach($sch_modules as $sch){ if($sch->modules=='transport') {echo 'checked';}} ?>>Transport</label>
                                   <label class="checkbox-inline"><input type="checkbox" name="module_privl[]" value="dormitory" <?php // foreach($sch_modules as $sch){ if($sch->modules=='dormitory') {echo 'checked';}} ?>>Dormitory</label>
                                   <label class="checkbox-inline"><input type="checkbox" name="module_privl[]" value="fee_management" <?php // foreach($sch_modules as $sch){ if($sch->modules=='fee_management') {echo 'checked';}} ?>>Fee Management</label>-->
                                </div>
                            </div>
                            
                        </fieldset>
                    </div>
                </div>
                <div class="row" style="padding-top:2px">
                    <div class="col-lg-5" style="padding-left:12px"> 
                        <a  href="<?php echo base_url('admin_school')?>" class="btn btn-primary" id="back"><i class="fa fa-arrow-left"> </i> Back</a>
                    </div>
                     <div class="col-lg-3">    
                        <!--<input type="button" class="btn btn-primary" style="width: 120px;font-family: sans-serif;" id="back" value="Back">--> 
                        <input type="submit" class="btn btn-success"  name="saveschool" id="btn_save" value="<?php echo $task;?>">
                    </div>
                </div>
            </form>
        </div>
    </div>
<!--</div>-->

<script>
                function select_country()
                {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url('admin_school/select_country'); ?>',
                        data: {
                            country_id: $("#country option:selected").val()
                        },
                        success: function (res) {
                            $('#div_state').html(res);
                            $('#div_state').css("display", "block");
                        },
                        error: function (req, status) {
                            return false;
                        }
                    });
                }
                
                function select_state()
                {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url('admin_school/select_state'); ?>',
                        data: {
                            state: $("#school_state option:selected").val()
                        },
                        success: function (res) {
                            //            alert(res); 
                            $('#div_city').html(res);
                            $('#div_city').css("display", "block");
                        },
                        error: function (req, status) {
                            return false;
                        }
                    });
                }
             
             $('input[name="optradioc"]').click(function(){
                    if(this.value=='yes'){
                        $('input[name^=module_privl]').removeAttr('disabled');
                    }else{
                        $('input[name^=module_privl]').attr('disabled',true);
                    }
             });
             
             
                
    </script>