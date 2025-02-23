<style>
/*    .table>tbody>tr.warning>td{
background-color: #eae6c5; 
}*/
</style>
<div class="form-group has-feedback">
        <div class="box">
        <div class="box-body">
            <div class="col-lg-12">
                <div class="col-lg-6" >
                    <a class="btn btn-primary" href="<?php echo base_url('hr/staff/employees'); ?>">
                        <i class="fa fa-reply fa-lg"></i>&nbsp; &nbsp;Back
                    </a>
                </div>
                <div class="col-lg-6" style="text-align:right;">
                    <a class="btn btn-success" href="<?php echo base_url('hr/staff/employees/download_format'); ?>" download="">
                        <i class="fa fa-cloud-download fa-lg"></i>&nbsp;Download Format
                    </a>
                </div>
            </div>
        </div>
<?php if(substr($right_access, 0,1)=='C') {?>
<div class="box-body">
<form enctype='multipart/form-data' id='form' class="form-horizontal" action="<?php echo base_url('hr/staff/employees/upload'); ?>" method='post'>
<div class="box-body">
<div class="col-lg-3">Select CSV File to upload</div>
<div class="col-lg-3">
<input class="form-control" size='50' type='file' name='admission_upload' required>
</div>
<div class="col-lg-2"><input type='submit' class="btn btn-success" name='submit' id='submit' value='New Employee Upload'></div>

<div class="col-lg-3"><input type='submit' class="btn btn-warning" name='submit2' formaction="<?php echo base_url('hr/staff/employees/bulk_update'); ?>"  id='submit2' value='Bulk Update'></div>
</div>
</form>
</div>
<?php if($this->session->flashdata('employeebulkupdate')) {?>
<div class="alert alert-warning" style="background-color: #f7ce8d !important;color:#980909 !important;padding: 7px;text-align:center">
<label> <?php echo $this->session->flashdata('employeebulkupdate');?></label>
</div>
<?php }?>
<?php if($this->session->flashdata('employeeupload')) {?>
<div class="alert alert-warning" style="background-color: #f7ce8d !important;color:#980909 !important;padding: 7px;text-align:center">
<label> <?php echo $this->session->flashdata('employeeupload');?></label>
</div>
<?php }?>
<?php } else{?>
<div class="box-body">
<div class="col-lg-12"><b>NOTE:</b>   You Don't Have Permission To Upload</div>
</div>
<?php }?>
</div>
<?php
if (isset($errors) && count($errors) > 0) {
?>
<div class="box">
<div class="box-body">
<legend><u>Errors</u></legend>
<pre>
<?php
//    print_r($errors);
foreach ($errors as $error=>$v) {
echo "$v\n";
}
?>
</pre>
</div>	
</div>
<?php
}
?>
<div class="box">
<div class="box-body">
<legend><u>Instructions</u></legend>
<ol>
<li>First <b>Download the Format</b> (File Should be in CSV( Comma Separated Delimited) Format).</li>
<!--<li><b>Admission No</b> Column is <b>Required</b>.</li>-->
<!--<li>Enter Class Code like (e.g for nursery =&gt; NUR , for lkg =&gt; LKG, for class I =&gt;1 , for class II =&gt;2  and so on) in class column (as created in Class Link).</li>-->
<!--<li>Enter Section Id instead of Section Name in Section Column (as created in Section Link).</li>-->
<!--<li>Enter Course Code in Course Column for Class 11 and 12 (as created in Course Link).</li>-->
<!--<li>D.O.B. should in the format of "dd-mm-YYYY" or "dd/mm/YYYY" e.g( 02-10-2017).</li>-->
<li><span style="color:red"> In Case of <b><u>Bulk Update</u></b> , Employee Code. and Only those column which you want to change Against this Employee Code is REQUIRED. Let Other Column be blank.</span></li>
</ol>

<div class="table-responsive " style="padding-top:8px">
<table class="table table-striped table-bordered ">
<thead>

</thead>
<tr class="success">

<th>Employee Code <span style="color:red">(REQUIRED in UPLOAD and BULK UPDATE)</span></th>
<th>Employee Name <span style="color:red;font-size:11px">(REQUIRED IN UPLOAD ONLY)</span></th>
<th>Joining Date</th>
<th>Employee Category <span style="color:red;font-size:11px">(REQUIRED IN UPLOAD ONLY)</span></th>
<th>Department <span style="color:red;font-size:11px">(REQUIRED IN UPLOAD ONLY)</span></th>
<th>Designation <span style="color:red;font-size:11px">(REQUIRED IN UPLOAD ONLY)</span></th>
<th>Leave Group <span style="color:red;font-size:11px">(REQUIRED IN UPLOAD ONLY)</span></th>
<th>User Group <span style="color:red;font-size:11px">(REQUIRED IN UPLOAD ONLY)</span></th>
<th>Salary Group <span style="color:red;font-size:11px">(REQUIRED IN UPLOAD ONLY)</span></th>
<th>Qualification </th>
<th>Total Experience</th>
<th>Father's Name</th>
<th>Mother's Name</th>
<th>D.O.B.</th>
<th>Gender</th>
<th>Martial Status</th>
<th>Spouse Name</th>
<th>Aadhar No</th>
<th>Voter Id</th>
<th>Bank Name</th>
<th>Account NO</th>
<th>IFSC Code</th>
<th>Pan NO</th>
<th>Branch Address</th>
<th>PF No</th>
<th>ESI No</th>
<th>Address</th>
<th>Phone No</th>
<th>Email</th>
<th>Pension No</th>
<th>Pension Nominee</th>

</tr>                   
<tr class="warning">
<td >Employee Code REQUIRED</td>
<td>Employee Name</td>
<td>(dd-mm-YYYY or dd/mm/YYYY) should be in number e.g( 02-10-2017)</td>
<td>1). TEACHING <br> 2). NON-TEACHING <br> (choose one option)</td>
<td><?php $str='';$s=1;foreach($fetch_department as $ac){$str.=$s.'.)  '.$ac->department_desc.' <html><br></html>'; $s++;} rtrim($str); echo $str;?> (choose one option)</td>
<td><?php $str1='';$s1=1;foreach($fetch_designation as $ac){$str1.=$s1.'.)  '.$ac->designation_desc.' <html><br></html>'; $s1++;} rtrim($str1); echo $str1;?> (choose one option)</td>
<td><?php $str2='';$s2=1;foreach($fetch_leave_group as $ac){$str2.=$s2.'.)  '.$ac->leave_group_name.' <html><br></html>';$s2++;} rtrim($str2); echo $str2;?> (choose one option)</td>
<td><?php $str3='';$s3=1;foreach($fetch_user_group as $ac){$str3.=$s3.'.)  '.$ac->group_type.' <html><br></html>';$s3++;} rtrim($str2); echo $str3;?> (choose one option)</td>
<td><?php $str4='';$s4=1;foreach($fetch_salary_group as $ac){$str4.=$s4.'.)  '.$ac->salary_group_name.' <html><br></html>';$s4++;} rtrim($str2); echo $str4;?> (choose one option)</td>
<td>Qualification</td>
<td>Total Experience</td>
<td>Father's Name</td>
<td>Mother's Name</td>
<td>(dd-mm-YYYY or dd/mm/YYYY) should be in number e.g( 02-10-2017)</td>
<td>M/F</td>
<td>Martial Status</td>
<td>Spouse Name</td>
<td>Aadhar No</td>
<td>Voter Id</td>
<td>Bank Name</td>
<td>Account NO</td>
<td>IFSC Code</td>
<td>Pan NO</td>
<td>Branch Address</td>
<td>PF No</td>
<td>ESI No</td>
<td>Address</td>
<td>Phone No</td>
<td>Email</td>
<td>Pension No</td>
<td>Pension Nominee</td>

</tr>
</table>   
</div>
</div>	
</div>

</div>
