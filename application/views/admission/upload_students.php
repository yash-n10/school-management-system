<style>
/*    .table>tbody>tr.warning>td{
       background-color: #eae6c5; 
    }*/
</style>
<div class="form-group has-feedback">
	<div class="box">
		<div class="box-body">
			<div class="col-lg-12">
				<div class="col-lg-12" style="text-align:right;">
					<!---<a class="btn btn-success" href="/admission/upload_students/help">
						<i class="fa fa-question-circle fa-lg"></i>&nbsp;Upload Help
					</a>---->
					<a class="btn btn-success" href="<?php echo base_url('admission/upload_students/download_format'); ?>" download="">
						<i class="fa fa-cloud-download fa-lg"></i>&nbsp;Download Format
					</a>
				</div>
			</div>
		</div>
                <?php if(substr($right_access, 0,1)=='C') {?>
		<div class="box-body">
			<form enctype='multipart/form-data' id='form' class="form-horizontal" action="<?php echo base_url('admission/upload_students/upload'); ?>" method='post'>
                <div class="box-body" style="padding-bottom:5px">
                        <div class="col-lg-3">Academic Session</div>
                        <div class="col-lg-3">
                            <select name="academic_session" id="academic_session" class="form-control" required>
                                <option value=''>- Select academic session -</option>
                                <?php
                                       foreach ($session as $school) {
                                ?>
                                <option value='<?php echo $school->id ?>' <?php if($activesess==$school->id) echo 'selected=selected';?>><?php echo $school->session; ?></option>
                                <?php
                                        }
                                ?>
                            </select>
                        </div>
                    </div>
				<div class="box-body">
					<div class="col-lg-3">Select CSV File to upload</div>
					<div class="col-lg-3">
						<input class="form-control" size='50' type='file' name='admission_upload' required>
					</div>
					<div class="col-lg-2"><input type='submit' class="btn btn-success" name='submit' id='submit' value='New Student Upload'></div>
                                        
                                        <div class="col-lg-3"><input type='submit' class="btn btn-warning" name='submit2' formaction="<?php echo base_url('admission/upload_students/bulk_update'); ?>"  id='submit2' value='Bulk Update'>
                                        </div>
				</div>
			</form>
		</div>
                <?php if($this->session->flashdata('bulkupdate')) {?>
                    <div class="alert alert-warning" style="background-color: #f7ce8d !important;color:#980909 !important;padding: 7px;text-align:center">
                        <label> <?php echo $this->session->flashdata('bulkupdate');?></label>
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
				<li>Enter Section Id instead of Section Name in Section Column (as created in Section Link).</li>
				<!--<li>Enter Course Code in Course Column for Class 11 and 12 (as created in Course Link).</li>-->
				<!--<li>D.O.B. should in the format of "dd-mm-YYYY" or "dd/mm/YYYY" e.g( 02-10-2017).</li>-->
                                <li><span style="color:red"> In Case of <b><u>Bulk Update</u></b> , Admission No. and Only those column which you want to change Against this Admission no is REQUIRED. Let Other Column be blank.</span></li>
			</ol>
                        
                        <div class="table-responsive " style="padding-top:8px">
                         <table class="table table-striped table-bordered ">
                             <thead>
                                 
                             </thead>
                            <tr class="success">
                               
                                <th>Admission Number <span style="color:red">(REQUIRED in UPLOAD and BULK UPDATE)</span></th>
                                <th>First Name <span style="color:red;font-size:11px">(REQUIRED IN UPLOAD ONLY)</span></th>
                                <th>Middle Name</th>
                                <th>Last Name</th>
                                <th>Category <span style="color:red;font-size:11px">(REQUIRED IN UPLOAD ONLY)</span></th>
                                <th>Class <span style="color:red;font-size:11px">(REQUIRED IN UPLOAD ONLY)</span></th>
                                <th>Section <span style="color:red;font-size:11px">(REQUIRED IN UPLOAD ONLY)</span></th>
                                <th>Phone Number <span style="color:red;font-size:11px">(REQUIRED IN UPLOAD ONLY)</span></th>
                                <th>Email Address</th>
                                <th>Fathers Name</th>
                                <th>D.O.B.</th>
                                <th>Gender</th>
                                <th>Course <span style="color:red;font-size:11px">(REQUIRED IN UPLOAD ONLY)</span></th>
                                <th>Transport Fee per month(if any)</th>
                                <th>Fine Waiver (if want to waive off then YES)</th>
                                <th>Admission Date</th>
                                <th>Mother's Name</th>
                                <th>Student's Aadhar No.</th>
                                <th>Father's Aadhar No</th>
                                <th>Mother's Aadhar No.</th>
                                <th>Father's Phone No.</th>
                                <th>Mother's Phone No.</th>
                                <th>Guardian's Name</th>
                                <th>Guardian's Aadhar No</th>
                                <th>Guardian's Phone No</th>
                                <th>Correspondence Address</th>
                                <th>Roll</th>
                                <th>Pickup Points</th>
                                <th>Vehicle No</th>
                                <th>Student Type</th>
                                <th>Start Fee Month</th>
                                <th>First Class</th>
                                <th>Hostel Name</th>
                            </tr>                   
                            <tr class="warning">
                                <td >Admission No. REQUIRED</td>
                                <td>First Name</td>
                                <td>Middle Name</td>
                                <td>Last Name</td>
                                <td><?php $str='';$s=1;foreach($acategory as $ac){$str.=$s.'.)  '.$ac->cat_code.' <html><br></html>'; $s++;} rtrim($str); echo $str;?> (choose one option)</td>
                                <td><?php $str1='';$s1=1;foreach($aclass as $ac){$str1.=$s1.'.)  '.$ac->class_code.' <html><br></html>'; $s1++;} rtrim($str1); echo $str1;?> (choose one option)</td>
                                <td><?php $str2='';$s2=1;foreach($asection as $ac){$str2.=$s2.'.)  '.$ac->id.' for '.$ac->sec_name.' '.' <html><br></html>';$s2++;} rtrim($str2); echo $str2;?> (choose one option) <br><b>e.g For A section, Put 1</b></td>
                                <td>Contact No</td>
                                <td></td>                        
                                <td></td>                        
                                <td>(dd-mm-YYYY or dd/mm/YYYY) should be in number e.g( 02-10-2017)</td>
                                <td>0 (for Boy)/1 (for Girl)</td>
                                <td><?php $str3='';$s3=1;foreach($acourse as $ac){$str3.=$s3.'.)  '.$ac->course_code.' <html><br></html>';$s3++;} rtrim($str3); echo $str3;?> (choose one option)</td>
                                <td>Transport Fee Amount (If Applicable for this Admission No)</td>
                                <td>Enter YES if want to waive off the LATE FINE otherwise let it be blank</td>
                                <td>(dd-mm-YYYY or dd/mm/YYYY) should be in number e.g( 02-10-2017)</td>
                                <td>Mother's Name</td>
                                <td>Student's Aadhar No.</td>
                                <td>Father's Aadhar No</td>
                                <td>Mother's Aadhar No.</td>
                                <td>Father's Phone No.</td>
                                <td>Mother's Phone No.</td>
                                <td>Guardian's Name</td>
                                <td>Guardian's Aadhar No</td>
                                <td>Guardian's Phone No</td>
                                <td>Correspondence Address</td>
                                <td>Roll</td>
                                <td><?php $strp='';$pp=1;foreach($aLocations as $al){$strp.=$pp.'.)  '.$al->location_description.' <html><br></html>'; $pp++;} rtrim($strp); echo $strp;?> (choose one option)</td>
                                <td><?php $strv='';$v=1;foreach($aVehicleNo as $av){$strv.=$v.'.)  '.$av->vehicle_no.' <html><br></html>'; $v++;} rtrim($strv); echo $strv;?> (choose one option)</td>
                                <td>EXISTING/NEW ADMISSION/TRANSFERED (Choose any one option)</td>
                                <td>1.) 1 for April<br>2.) 2 for May<br>3.) 3 for June<br>4.) 4 for July<br>5.) 5 for August<br>6.) 6 forSeptember<br>7.) 7 for October<br>8.) 8 for November<br>9.) 9 for December<br>10.) 10 for January<br>11.) 11 for February<br>12.) 12 for  March</td>
                                <td><?php $str1='';$s1=1;foreach($aclass as $ac){$str1.=$s1.'.)  '.$ac->class_name.' <html><br></html>'; $s1++;} rtrim($str1); echo $str1;?> (choose one option)</td>
                                <td>Hostel Name</td>
                            </tr>
                        </table>   
                        </div>
		</div>	
	</div>

</div>
