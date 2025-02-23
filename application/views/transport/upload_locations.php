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
                    <a class="btn btn-primary" href="<?php echo base_url('transport/Locations'); ?>">
						<i class="fa fa-reply fa-lg"></i>&nbsp; &nbsp;Back
					</a>
                </div>
				<div class="col-lg-6" style="text-align:right;">
					<a class="btn btn-success" href="<?php echo base_url('transport/Locations/download_format'); ?>" download="">
						<i class="fa fa-cloud-download fa-lg"></i>&nbsp;Download Format
					</a>
				</div>
			</div>
		</div>
                <?php if(substr($right_access, 0,1)=='C') {?>
		<div class="box-body">
			<form enctype='multipart/form-data' id='form' class="form-horizontal" action="<?php echo base_url('transport/Locations/upload'); ?>" method='post'>
				<div class="box-body">
					<div class="col-lg-3">Select CSV File to upload</div>
					<div class="col-lg-3">
						<input class="form-control" size='50' type='file' name='admission_upload' required>
					</div>
					<div class="col-lg-2"><input type='submit' class="btn btn-success" name='submit' id='submit' value='New Locations Upload'></div>
                                        
                                       <!-- <div class="col-lg-3"><input type='submit' class="btn btn-warning" name='submit2' formaction="<?php //echo base_url('hr/staff/employees/bulk_update'); ?>"  id='submit2' value='Bulk Update'></div>-->
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
                                <li><span style="color:red"> In Case of <b><u>Bulk Update</u></b> , Location Description. and Only those column which you want to change Against this Location Description is REQUIRED. Let Other Column be blank.</span></li>
			</ol>
                        
                        <div class="table-responsive " style="padding-top:8px">
                         <table class="table table-striped table-bordered ">
                             <thead>
                                 
                             </thead>
                            <tr class="success">
                                <th>Location Description<span style="color:red">(REQUIRED in UPLOAD and BULK UPDATE)</span></th>
                                <th>ISO</th>
                            </tr>                   
                            <tr class="warning">
                                <td>Location Description</td>
                                <td>ISO</td>
                            </tr>
                        </table>   
                        </div>
		</div>	
	</div>

</div>
