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
        font-size: 14px;
    }
    .form-control{
        padding: 6px 5px !important;
    }
    .chosen-disabled {
        opacity: 6.5!important;
        cursor: default;
    }
    .div_margin{
        padding-left:0px !important;
        padding-right:0px !important;
    }
</style>
<div class="form-group">
    <div class="panel  panel-default"> 


        <div class="panel-body">

            <form enctype="multipart/form-data" id="salarydetails_form" action="<?php echo base_url();?>hr/payroll/Salary_calculator/<?php echo $task;?>" method="post">
                <div class="col-sm-12 col-md-12">

                    <div class="row">
                        <div class="col-sm-6">

                            <fieldset class="">

                                <legend class="" style="font-size:18px;color:green">
                                    <u>Profile</u> <span class="required"></span>
                                </legend>

                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        <label  style="font-weight: 600">Year</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <select id="year" name="year" class="form-control" required>
                                            <option value="">Select</option>
                                            <option value="<?php echo $fin_yr_start; ?>" <?php if ($year == $fin_yr_start) {
    											echo 'selected=selected'; } ?>><?php echo $fin_yr_start; ?></option>
                                            <option value="<?php echo $fin_yr_end; ?>" <?php if ($year == $fin_yr_end) {
    											echo 'selected=selected'; } ?>><?php echo $fin_yr_end; ?></option>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        <label  style="font-weight: 600">Employee Code</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <select class="chosen-select form-control" id="emp_code" name="emp_code"  required <?php if ($task == 'View') { echo 'disabled=true'; } ?>>
                                            <option value="">Select Employee Code</option>  
												<?php foreach ($emp_details as $row) { ?>
                                                <option value="<?php echo $row->id; ?>" <?php
												    if ($emp_code == $row->id) {
												        echo 'selected=selected';
												    }
												    ?>><?php echo $row->employee_code; ?></option>
												<?php } ?>
                                        </select>
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        <label  style="font-weight: 600">Month</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <select class="chosen-select form-control" id="sal_mnth" name="sal_mnth"  required <?php if ($task == 'View') {
											    echo 'disabled=true';
											} ?> >
                                            <option value="">Select Month</option>  
                                            <!--<option value="0" id="0">Select Month</option>-->  
                                            <option value="04" data-year="<?php echo $fin_yr_start; ?>" <?php if ($sal_month == 4) {
											    echo 'selected=selected';
											} ?>>April</option>
                                            <option value="05" data-year="<?php echo $fin_yr_start; ?>" <?php if ($sal_month == 5) {
											    echo 'selected=selected';
											} ?>>May</option>
                                            <option value="06" data-year="<?php echo $fin_yr_start; ?>" <?php if ($sal_month == 6) {
											    echo 'selected=selected';
											} ?>>June</option>
                                            <option value="07" data-year="<?php echo $fin_yr_start; ?>" <?php if ($sal_month == 7) {
											    echo 'selected=selected';
											} ?>>July</option>
                                            <option value="08" data-year="<?php echo $fin_yr_start; ?>" <?php if ($sal_month == 8) {
											    echo 'selected=selected';
											} ?>>August</option>
                                            <option value="09" data-year="<?php echo $fin_yr_start; ?>" <?php if ($sal_month == 9) {
											    echo 'selected=selected';
											} ?>>September</option>
                                            <option value="10" data-year="<?php echo $fin_yr_start; ?>" <?php if ($sal_month == 10) {
											    echo 'selected=selected';
											} ?>>October</option>
                                            <option value="11" data-year="<?php echo $fin_yr_start; ?>" <?php if ($sal_month == 11) {
											    echo 'selected=selected';
											} ?>>November</option>
                                            <option value="12" data-year="<?php echo $fin_yr_start; ?>" <?php if ($sal_month == 12) {
											    echo 'selected=selected';
											} ?>>December</option>
                                            <option value="01" data-year="<?php echo $fin_yr_end; ?>" <?php if ($sal_month == 1) {
											    echo 'selected=selected';
											} ?>>January</option>
                                            <option value="02" data-year="<?php echo $fin_yr_end; ?>" <?php if ($sal_month == 2) {
											    echo 'selected=selected';
											} ?>>February</option>
                                            <option value="03" data-year="<?php echo $fin_yr_end; ?>" <?php if ($sal_month == 3) {
											    echo 'selected=selected';
											} ?>>March</option>
                                        </select>
                                    </div>

                                </div>


                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label style="font-weight: 600">Employee Name</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input class="col-sm-12 form-control" name="employee_name" id="employee_name" type="text" value="<?php echo $emp_name; ?>" disabled="true">
                                    </div> 
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label style="font-weight: 600">Aadhar No.</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input class="col-sm-12 form-control" name="aadhar_no" id="aadhar_no" type="text" value="<?php echo $aadhar; ?>" disabled="true">
                                    </div> 
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label style="font-weight: 600">Employee Category</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="col-sm-8 chosen-select form-control" id="category" name="category" class="category" disabled="true">
                                            <option value="">Select Category</option>                                                                    
                                            <?php foreach ($category as $row) { ?>
                                                <option value="<?php echo $row->id; ?>" <?php if ($cat == $row->id) {
                                                        echo 'selected=selected';
                                                    } ?>><?php echo $row->category_desc; ?></option>
                                                <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label style="font-weight: 600">Designation</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="col-sm-8 chosen-select form-control" id="designation" name="designation" class="designation" disabled="true">
                                            <option value="">Select Designation</option>
												<?php foreach ($designation as $desg) {
												    ?>
                                                <option value="<?php echo $desg->id; ?>" <?php
												    if ($design == $desg->id) {
												        echo 'selected=selected';
												    }
												    ?>><?php echo $desg->designation_desc; ?>
												</option>
												<?php } ?>
                                        </select>
                                    </div>

                                </div>

                            </fieldset>
                        </div>

                        <div class="col-sm-6">

                            <fieldset class="">
                                <legend class="" style="font-size:18px;color:green">
                                    Account Details <span class="required"></span>
                                </legend>

                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label style="font-weight: 600"> Bank Name</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="form-control chosen-select col-sm-8" name="bank_name" id="bank_name" disabled="true">
                                            <option value="">Select Bank Name</option>
											<?php foreach ($fetch_bank as $bnk) {
											    ?>
                                                <option value="<?php echo $bnk->id; ?>" <?php
												    if ($bank == $bnk->id) {
												        echo 'selected=selected';
												    }
											    ?>><?php echo $bnk->bank_name; ?></option>
											<?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label style="font-weight: 600">Bank Account No.</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input class="col-sm-12 form-control" name="account_no" id="account_no" type="text" value="<?php echo $accnt; ?>" disabled="true">
                                    </div> 
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label style="font-weight: 600">IFSC Code</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input class="col-sm-12 form-control" name="ifsc" id="ifsc" type="text" value="<?php echo $ifsc; ?>" disabled="true">
                                    </div> 
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label style="font-weight: 600">Pan Card No.</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input class="col-sm-12 form-control" name="pan_no" id="pan_no" type="text" value="<?php echo $pan; ?>" disabled="true">
                                    </div> 
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label style="font-weight: 600">PF Account No.</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input class="col-sm-12 form-control" name="pf_no" id="pf_no" type="text" value="<?php echo $pf; ?>" disabled="true">
                                    </div> 
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label style="font-weight: 600">ESIC No.</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input class="col-sm-12 form-control" name="esi_no" id="esi_no" type="text" value="<?php echo $esic; ?>" disabled="true">
                                    </div> 
                                </div>

                            </fieldset>

                        </div>

                    </div>

                    <div class="row" style="padding-top:2%">
                        <div class="col-sm-12">
                            <fieldset class="">
                                <legend class="" style="font-size:18px;color:green">
                                    Salary Calculator <span class="required"></span>
                                </legend>
                                <div class="form-group row">
                                  <div class="col-md-3">
                                        <label style="font-weight: 600">Total WeekOff in this Month</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control" name="weekoff" id="weekoff" type="text" value="<?php echo $weekoff; ?>" readonly="" >
                                    </div>
                                    <div class="col-md-3">
                                        <label style="font-weight: 600">Days Paid</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control" name="paid_day" id="paid_day" type="text" value="<?php echo $paid_days; ?>" readonly="">
                                    </div> 
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label style="font-weight: 600">Total Working Days</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control" name="wrk_day" id="wrk_day" type="text" value="<?php echo $working_days; ?>" readonly="">
                                    </div> 


                                    <div class="col-md-3">
                                        <label style="font-weight: 600">Total Holidays</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control" name="holi_day" id="holi_day" type="text" value="<?php echo $total_holiday; ?>" readonly="">
                                    </div> 
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label style="font-weight: 600">Total Leave Approved</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control" name="leave" id="leave" type="text" value="<?php echo $total_leave_approved; ?>" readonly="">
                                    </div> 

                                    <div class="col-md-3">
                                        <label style="font-weight: 600">Absent Days</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control" name="leave_exceed" id="leave_exceed" type="text" value="<?php echo $absent_days; ?>" readonly="">
                                    </div> 
                                </div>

                                <div class="form-group row">
                                    

                                    <div class="col-md-3">
                                        <label style="font-weight: 600">Advance Salary(if taken)</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control" name="adv" id="adv" type="text" value="" <?php if ($task == 'View') {
										    echo 'readonly=true';
										} ?>>
                                    </div> 
                                    <div class="col-md-3">
                                        <label style="font-weight: 600">Rembursement Amt</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control" name="rembursement" id="rembursement" type="text" value="" <?php if ($task == 'View') {
                                            echo 'readonly=true';
                                        } ?>>
                                    </div> 
                                </div>
                                <div class="row" style="text-align:center; padding:10px;margin:10px; background-color:#fce4ec ;">
                                    <div class="col-md-12" >   
                                        <label for="" style="padding-right: 20px;">Salary Paid for the month </label> 
                                        <input type="text" name="sal_paid" id="sal_paid" readonly="" value="<?php echo $payable; ?>" data-actual="" > 
                                    </div>                    
                                </div>

                            </fieldset>
                        </div>
                    </div>

                    <div class="row" style="padding-top:2%">
                        <div class="col-sm-12">
                            <fieldset class="">

                                <legend class="" style="font-size:18px;color:green">
                                    Salary Details <span class="required"></span>
                                </legend>


                                <div class="" style="">
                                    <input type="hidden" name="sal_head_id" value="<?php echo $sal_head_id; ?>" id="sal_head_id">
                                    <div class="col-md-12" style="background-color:#dcedc8; border:1px solid gray;">
                                        <div class="col-md-3" style="font-weight: 800; text-align:center;">
                                            Earning Salary
                                        </div>
                                        <div class="col-md-3" style=" border-left:1px solid gray; font-weight: 800; text-align:center;">
                                            Amount
                                        </div>
                                        <div class="col-md-3" style=" border-left:1px solid gray; font-weight: 800; text-align:center;">
                                            Deduction Salary
                                        </div>
                                        <div class="col-md-3" style=" border-left:1px solid gray; font-weight: 800; text-align:center;">
                                            Amount
                                        </div>
                                    </div>
                                </div>

                                <div class="row">                                                          
                                    <div class="col-md-12"  id="sal_amt">
                                        <div class="col-md-6 div_margin">
                                            <table class="table table-bordered">
											<?php
											$tot = 0;
											$earn = 0;
											foreach ($fetch_salary_name as $sal) {
											    if ($sal->salary_typ == 1) {
											        if ($task == 'Update' || $task == 'View') {
											            $earn = round(($sal->sal_amt / $working_days) * $paid_days);
											            $tot = $tot + $earn;
											        }
											        ?>
                                                        <tr id="salary_calc">
                                                        <input type="hidden" name="sal_id[]" value="<?php echo $sal->id; ?>">
                                                        <td class="col-md-6"><?php echo $sal->salary_name; ?> </td>
                                                        <td class="col-md-6" style="padding:8px;"> 
                                                            <input type="text" data-actual="<?php echo $earn; ?>" id="earning_<?php echo $sal->id; ?>" name="sal_amount[]" value="<?php
				                                                if ($task == 'Update' || $task == 'View') {

				                                                    echo $earn;
				                                                } else {
				                                                    echo '';
				                                                }
				                                                ?>" disabled="true"></td>
                                                        </tr>
					                                    <?php }
					                                }
					                                ?>
                                                <tr style="background-color:#f5f5f5;"> <td > Total Earnings </td> <td  style="padding:8px;"> 
                                                        <input type="text" name="total_sal" id="total_sal" data-actual="<?php echo $tot; ?>" value="<?php
						                                if ($task == 'Update' || $task == 'View') {
						                                    echo $tot;
						                                }
						                                ?>" disabled="true"> </td> </tr>
                                            </table>
                                        </div>

                                        <div class="col-md-6 div_margin">
                                            <table class="table table-bordered">
											<?php
											$total1 = 0;
											$deduct = 0;
											foreach ($fetch_salary_name as $sal) {
											    if ($sal->salary_typ == 2) {
											        if ($task == 'Update' || $task == 'View') {
											            $deduct = ($sal->sal_amt / $working_days) * $paid_days;
											            $total1 = $total1 + $deduct;
											        }
											        ?>
                                                        <tr id="sal_calc">
                                                        <input type="hidden" name="sal_id[]" value="<?php echo $sal->id; ?>">
                                                        <td class="col-md-5"> <?php echo $sal->salary_name; ?> </td>
                                                        <td class="col-md-7">
                                                            <input type="text" id="deduction_<?php echo $sal->id; ?>" data-actual="<?php echo $deduct; ?>" name="sal_amount[]" value="<?php
														        if ($task == 'Update' || $task == 'View') {
														            echo $deduct;
														        } else {
														            echo '';
														        }
														        ?>" disabled="true">
                                                        </td> 
                                                        </tr>
												    <?php }
												}
												?>
                                                <tr style="background-color:#f5f5f5;"> <td > Total Deductions </td> <td  style="padding:8px;"> 
                                                        <input type="text" name="total_deduc_sal" id="total_deduc_sal" data-actual="<?php echo $total1; ?>" value="<?php
														if ($task == 'Update' || $task == 'View') {
														    echo $total1;
														}
														?>" disabled="true"></td> 
												</tr>
                                            </table>
                                        </div>

                                    </div>
                                </div>
											<?php
											// if ($task == 'Update' || $task == 'View') {
											//                                        $payable = $tot-$total1;
											//                                    } else {
											//                                        $payable = 0;
											//                                    } 
											?>
                                <div class="col-md-12" style="text-align:center; border:1px solid gray; padding:10px; background-color:#fce4ec ;">
                                    <div class="col-md-6">    <label for="" style="padding-right: 20px;"> Net Payable Salary </label> <input type="text" name="net" id="net" data-actual="<?php echo $payable; ?>"  value="<?php echo $payable; ?>" disabled="true">  </div>
                                    <div class="col-md-6">    <label for="" style="padding-right: 20px;"> Gross Salary </label> <input type="text" name="gross" id="gross" data-actual="<?php echo $gross_pay; ?>" value="<?php echo $gross_pay; ?>" disabled="true"> </div>
                                </div>


                                  <!----------CTC HEAD CAL-------------->

                            <div class="row">
                            <div class="col-md-12">
                                        <table class="table table-bordered">
                                            <tr style="background-color:#dcedc8">
                                        <th> Salary (CTC HEAD)</th> 
                                        <th> Amount </th>
                                    </tr>
                                            <?php
                                            $total2 = 0;
                                            foreach ($fetch_salary_name as $sal) {
                                                // echo '<pre>';
                                                // print_r($sal);
                                                if ($sal->salary_typ == 4 ) {
                                                    if ($task == 'Update') {
                                                        $ctccc = round(($sal->sal_amt));
                                                        $total2 = $total2 + $ctccc;
                                                    }
                                                    ?>
                                                    <tr id="sal_calc_ctc">
                                                    <input type="hidden" name="sal_id[]" value="<?php echo $sal->id; ?>">
                                                    <td class="col-md-6"> <?php echo $sal->salary_name; ?> </td>
                                                    <td class="col-md-6">
                                                        <input  type="text"   id="ctchead_<?php echo $sal->id; ?>" name="sal_amount[]" value="<?php
                                                        if ($task == 'Update') {
                                                            echo $ctccc;
                                                        } else {
                                                            echo '';
                                                        }
                                                        ?>" required>
                                                        
                                                        
                                                    </td> 
                                                    </tr>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                            <tr style="background-color:#f5f5f5;"> <td > Total CTC HEAD AMT </td> <td  style="padding:8px;"> <input type="text"  readonly name="total_ctc_sal" id="total_ctc_sal" data-actual="<?php echo $total2; ?>" value="<?php
                                                        if ($task == 'Update' || $task == 'View') {
                                                            echo $total2;
                                                        }
                                                        ?>" disabled="true"></td> </tr>
                                    </div>

                                </div>

                            <!----------CTC HEAD CAL-------------->




                                <div class="" style="margin-top:70px;">
                                    <table class="table table-bordered table-striped" style="border:1px solid grey !important;">

                                        <tr style="background-color:#dcedc8">
                                            <th  style="text-align:center"> Salary</th> 
                                            <th  style="text-align:center"> Amount </th>
                                        </tr>


                                        <tr style="">
                                            <td style="padding-left:30px;" class="col-md-4"> PF Employer </td>
                                            <td style="padding-left:30px;" class="col-md-8">

                                                <input  style="padding-left:15px !important;" type="text" data-actual="" name="pf_employer" id="pf_employer" value="<?php echo $pf_empl; ?>" disabled="true"> 
                                            </td>
                                        </tr>
                                        <tr style="">
                                            <td style="padding-left:30px;"> Health Insurance Employer </td>
                                            <td style="padding-left:30px;" class="col-md-8"> 

                                                <input style="padding-left:15px !important;" type="text" data-actual="" name="medical_employer" id="medical_employer" value="<?php echo $health_empl; ?>" disabled="true"> </td>
                                        </tr>

                                        <tr style="background-color:#fffde7;">
                                            <td style="padding-left:30px; font-weight:600;"> CTC of this Month </td>
                                            <td style="padding-left:30px;">  <input type="text" style="padding-left:15px !important;" data-actual="" name="ctc_mnth" id="ctc_mnth" value="<?php echo $ctc_mon; ?>" disabled="true"> </td>
                                        </tr>

                                    </table>
                                </div>



                            </fieldset>
                        </div>

                    </div>    

                    <div class="row" style="padding-top:2%">
                        <div class="col-lg-12" style="text-align:center; margin-bottom: 20px;"> 
<?php if ($task != 'View') { ?>
                                <a class="btn btn-info" style="width: 120px;font-family: sans-serif; padding: 2px 12px !important;font-weight: bold;border-radius: 12px;" id="back" href="<?php echo site_url('hr/payroll/salary_calculator'); ?>" ><i class="fa fa-arrow-left"> </i> Back</a>
                                <input type="submit" class="btn btn-success" style="width: 120px;font-family: sans-serif;" name="" id="" value="<?php echo $task; ?>" >

<?php } else { ?>
                                <a  class="btn btn-info" style="width: 120px;font-family: sans-serif; padding: 2px 12px !important;font-weight: bold;border-radius: 12px;" id="back" href="<?php echo site_url('hr/payroll/salary_calculator'); ?>"><i class="fa fa-arrow-left"> </i> Back</a>
                                <button type="button" class="btn btn-success"><i class="fa fa-download"> </i> Download Pay Slip</button>
                                <!--<input type="button" class="btn btn-success" style="font-family: sans-serif;" name="btn_save" id="btn_save" value="Download Pay Slip">-->
<?php } ?>
                        </div>
                    </div>

                    <!--</div>-->


                </div>      
            </form>
        </div>

    </div>
</div>
<!-- /.box-body -->
</div>
<!-- /.box -->


<script>

    $(document).ready(function () {

        var task = '<?php echo $task; ?>';
//                 alert(task);
        var emp_id = '<?php echo $emp_code; ?>';

//       $(".chosen-select").chosen({width: "100%"});   


        $('#emp_code').change(function () {
            var i = 0;
            $('#sal_mnth').val('');
            $.ajax({
                url: "<?php echo site_url('hr/payroll/salary_calculator/create_salary1'); ?>",
                type: 'POST',

                data: {emp_id: this.value,

                },
                dataType: 'JSON',
                success: function (data)
                {
                	// alert(data);
                    var sum_earning = 0;
                    var sum_deduction = 0;
                    var sum_ctc = 0;
                    var len = (data['length']);
//                    $.each(data, function (index, element)
//                    {
//alert(data['cat']);
                    $('#employee_name').val(data['name']);
                    $('#designation').val(data['desig']).prop('selected', true).trigger('change');
                    $('#category').val(data['cat']).prop('selected', true).trigger('change');
                    $('#bank_name').val(data['bank']).prop('selected', true).trigger('change');
                    $('#account_no').val(data['account']);
                    $('#aadhar_no').val(data['aadhar']);
                    $('#pf_no').val(data['pf']);
                    $('#pan_no').val(data['pan']);
                    $('#ifsc').val(data['ifsc_code']);
                    $('#esi_no').val(data['esi']);

                    if (data['msg'] == '') {
                      
                        $('#sal_head_id').val(data['sal_head_id']);
                        $('#pf_employer').val(data['pf_empl']);
                        $('#pf_employer').attr('data-actual', data['pf_empl']);
                        $('#medical_employer').val(data['med_empl']);
                        $('#medical_employer').attr('data-actual', data['med_empl']);
                        $('#gross').val(data['gross1']);
                        
                        $('#ctc_yr').val(data['ctc_ann']);
                        $.each(data['amount']['e'], function (ind, elem)
                        {

                            $('#earning_' + ind).val(elem);
                            $('#earning_' + ind).attr('data-actual', elem);
                            sum_earning += Number($('#earning_' + ind).val());
                        });

                        $.each(data['amount']['d'], function (ind, elem)
                        {
                        	
                            $('#deduction_' + ind).val(elem);
                            $('#deduction_' + ind).attr('data-actual', elem);
                            sum_deduction += Number($('#deduction_' + ind).val());
                            // alert(ind);
                        });

                        $.each(data['amount']['c'], function (ind, elem)
                        {

                            $('#ctchead_' + ind).val(elem);
                            $('#ctchead_' + ind).attr('data-actual', elem);
                            sum_ctc += Number($('#ctchead_' + ind).val());
                            // alert(sum_ctc)
                        });

                        $('#total_sal').val(sum_earning);
                        $('#total_sal').attr('data-actual', sum_earning);
                        $('#total_deduc_sal').val(sum_deduction);
                        $('#total_deduc_sal').attr('data-actual', sum_deduction);

                        $('#total_ctc_sal').val(sum_ctc);
                        $('#total_ctc_sal').attr('data-actual', sum_ctc);

                        var tottctc=(Number($('#pf_employer').val()) + Number($('#total_ctc_sal').val()) + Number($('#gross').val()));
                        // alert(tottctc);
                        $('#ctc_mnth').val(tottctc);
                        $('#ctc_mnth').attr('data-actual',tottctc);
                        // alert(ctc);
//                             var net_payable=Number($('#total_sal').val())-Number($('#total_deduc_sal').val());
                        $('#net').val(data['net']);
                        $('#net').attr('data-actual', data['net']);

                        $('#gross').attr('data-actual', data['gross1']);
                        $('#sal_paid').val($('#net').val());
                        $('#sal_paid').attr('data-actual', $('#net').val());
                        $('#btn_save').attr('disabled', false);
                        $('#btn_pay').attr('disabled', false);
                    } else {
                        alert(data['msg']);
                        $('#btn_save').attr('disabled', true);
                        $('#btn_pay').attr('disabled', true);
                    }
//                    });



                },

                error: function (req, status)
                {
                    alert('error');
                },

            });
        });


        $('#adv').change(function ()
        {
            var net_pay = $('#net').val();
            var advance = $('#adv').val();
            var paid = net_pay - advance;
            if (advance != '')
            {
                $('#sal_paid').val(paid);
            }

        });

         $('#rembursement').change(function ()
        {
            var net_pay = $('#net').val();
            var rem = $('#rembursement').val();
            var paid = Number(net_pay) + Number(rem);
            if (rem != '')
            {
                $('#sal_paid').val(paid);
            }

        });


        $('#btn_save').click(function () {

            if (task == 'Save')
            {
                action_url = '<?php echo base_url('hr/payroll/salary_calculator/save'); ?>';
            }
            else
            {
                var sal_calc_id = '<?php echo $sal_calc_id; ?>';
                action_url = '<?php echo base_url('hr/payroll/salary_calculator/update'); ?>' + '/' + sal_calc_id;
            }

            if (!$('#salarydetails_form')[0].checkValidity())
            {
                $(this).show();
                $('#salarydetails_form')[0].reportValidity();
                return false;
            } else {

                var savestatus = confirm('Are you sure want to save');

                if (savestatus == true) {
                    $.ajax({
                        type: 'POST',
                        url: action_url,
                        data: $('#salarydetails_form'),
                        datatype: 'text',
                        success: function (data)
                        {
                            alert('saved successfully');
                            window.location.href = "<?php echo base_url('hr/payroll/salary_calculator'); ?>";
                        },
                        error: function (req, status)
                        {
                            alert('error while saving');
                        }
                    });
                }
            }
        });



        $('#sal_mnth').change(function ()
        {
            var month = $('#sal_mnth').val();
//            var year = (new Date).getFullYear(); //current year
            var year = $('#year').val(); //current year
            var em_code = $('#emp_code').val();
            var month_year = $('#sal_mnth').find(':selected').attr('data-year');

            if (year == '' || em_code == '') {
                alert('Please choose the above option');
                $('#sal_mnth').val('');
                return false;
            }
            if (year != month_year) {
                alert('Please choose the correct year');
                $('#year').val('');
                $('#emp_code').val('');
                $('#sal_mnth').val('');
                return false;
            }

            var days = getNumberOfDays(month, year);

            var week_off = getNumberOfSundays(month, year).length;

            // var working_days = (getNumberOfDays(month, year));
            var working_days = (getNumberOfDays(month, year) - week_off);
            $('#wrk_day').val(working_days);

            $.ajax({
                type: 'POST',
                data:
                {
                    mnth: month,
                    year: year,
                    emp_code: em_code,
                    working_days: working_days,
                },
                url: "<?php echo base_url('hr/payroll/salary_calculator/find_holiday'); ?>",
                datatype: 'JSON',
                success: function (data)
                {
                    var d = $.parseJSON(data);

                    if (d['msg'] != '') {
                        alert(d['msg']);
                        // $('#btn_save').css('disabled', true);
                        $('#btn_save').attr('disabled', true);
                    } else {
                        // $('#btn_save').css('disabled', false);
                        $('#btn_save').attr('disabled', false);

                        $('#weekoff').val(week_off);
                        $('#holi_day').val(d['holiday']);
                        $('#leave').val(d['leave']);
                        
                        var present =d['extra'];
                        // alert($('#leave').val());
                        // alert(paidd_day);
                        // var leave = Number($('#wrk_day').val()) - Number(present);
                        // var net_day = $('#wrk_day').val() - $('#leave_exceed').val();
                        var absentt=d['absent_days'];
                        // alert(absentt);
                        if(absentt==''){
                            $('#leave_exceed').val(0);
                        }else{
                            $('#leave_exceed').val(d['absent_days']);
                        }
                        
                        var net_day = Number(week_off) + Number(working_days) - Number($('#leave_exceed').val());
                        // alert(leave);
                        $('#paid_day').val(net_day);

                        var sal_paid = (Number($('#sal_paid').attr('data-actual')) / working_days) * Number(net_day);
                        $('#sal_paid').val(sal_paid.toFixed(0));

                        $("input[id^='earning']").each(function ()
                        {
                            var me = this.id;
                            var sal = (Number($(this).attr('data-actual')) / working_days) * Number(net_day);
                            $('#' + me).val(sal.toFixed(0));
                        });

                        $("input[id^='deduction']").each(function ()
                        {
                            var me = this.id;
                            var sald = (Number($(this).attr('data-actual')) / working_days) * Number(net_day);
                            $('#' + me).val(sald.toFixed(0));
                        });
                        var tot_earn = (Number($('#total_sal').attr('data-actual')) / working_days) * Number(net_day);
                        var total_deduc_sal = (Number($('#total_deduc_sal').attr('data-actual')) / working_days) * Number(net_day);
                        $('#total_sal').val(tot_earn.toFixed(0));
                        $('#total_deduc_sal').val(total_deduc_sal.toFixed(0));

                        var net_payable = ((Number($('#net').attr('data-actual')) / working_days) * Number(net_day) );
                        // var gross_salary = (Number($('#gross').attr('data-actual')) / working_days) * Number(net_day);
                        var gross_salary = (Number($('#gross').attr('data-actual')));
                        $('#net').val(net_payable.toFixed(0));
                        $('#gross').val(gross_salary.toFixed(0));

                        // var pf_employer = (Number($('#pf_employer').attr('data-actual')));
                        var pf_employer = (Number($('#pf_employer').attr('data-actual')) / working_days) * Number(net_day);
                        var esic_employer = (Number($('#medical_employer').attr('data-actual')) / working_days) * Number(net_day);
                        var ctc_mnth = (Number($('#ctc_mnth').attr('data-actual')));
                        // var ctc_mnth = (Number($('#ctc_mnth').attr('data-actual')) / working_days) * Number(net_day);
                        $('#pf_employer').val(pf_employer.toFixed(0));
                        $('#medical_employer').val(esic_employer.toFixed(0));
                        var tottctccal=(Number(pf_employer) + Number(gross_salary) + Number($('#total_ctc_sal').val()));
                        // alert(tottctccal);
                        $('#ctc_mnth').val(tottctccal.toFixed(0));
                    }
                },
                error: function (req, status)
                {
                    alert('error while loading');
                },

            });

        });


        function getNumberOfDays(month, year)
        {
            var day = new Date(year, month, 0).getDate();
            return day;
//      alert(day);
        }

        function getNumberOfSundays(m, y)
        {
            var days = new Date(y, m, 0).getDate();
            var sundays = [8 - (new Date(m + '/01/' + y).getDay())];
            for (var i = sundays[0] + 7; i < days; i += 7)
            {
                sundays.push(i);
            }
            return  sundays;
        }

    });


</script>

<script type="text/javascript">

	function yash() {
<?php		foreach ($fetch_salary_name as $sal) {
		    if ($sal->salary_typ == 1) {
	?>	var earn =<?php echo round($sal->sal_amt);}?>;
	<?php if ($sal->salary_typ == 2) {?>
		var deduct=<?php echo round($sal->sal_amt);}?>;
	<?php if ($sal->salary_typ == 4) {?>
		var ctccc=<?php echo round($sal->sal_amt);}?>;

<?php }?>
	alert(earn);
	alert(deduct);
	alert(ctccc);

	}
</script>