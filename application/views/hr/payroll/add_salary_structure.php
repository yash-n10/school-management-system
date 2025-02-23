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

            <form enctype="multipart/form-data" id="salarydetails_form" action="<?php echo base_url('hr/payroll/salary_structure/save'); ?>">
                <div class="col-sm-12 col-md-12">

                    <div class="row">
                        <div class="col-sm-6">

                            <fieldset class="">

                                <legend class="" style="font-size:18px;color:green">
                                    <u>Profile</u> <span class="required"></span>
                                </legend>

                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        <label  style="font-weight: 600">Start Date</label>
                                    </div>
                                    <div class="col-sm-8">
<!--                                        <input type="number" min="1900" max="2099" step="1" id="year" name="year" class="form-control" value="<?php // echo $year; ?>" <?php // if ($task == 'Update') {
//                                                echo 'disabled=true';
//                                            } ?> required>-->
                                            <input type="date" id="start_date" min="<?php echo $fin_yr_start_date;?>" max="<?php echo $fin_yr_end_date;?>" name="start_date" class="form-control" value="<?php echo $start_date; ?>" <?php // if ($task == 'Update') { echo 'disabled=true';
//                                            } ?> required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        <label  style="font-weight: 600">End Date</label>
                                    </div>
                                    <div class="col-sm-8">
<!--                                        <input type="number" min="1900" max="2099" step="1" id="year" name="year" class="form-control" value="<?php // echo $year; ?>" <?php // if ($task == 'Update') {
//                                                echo 'disabled=true';
//                                            } ?> required>-->
                                            <input type="date" id="end_date" name="end_date" min="<?php echo $fin_yr_start_date;?>" max="<?php echo $fin_yr_end_date;?>" class="form-control" value="<?php echo $end_date; ?>" <?php // if ($task == 'Update') { echo 'disabled=true';
//                                            } ?> required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        <label  style="font-weight: 600">Employee Code</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <select class="chosen-select form-control" id="emp_code" name="emp_code" <?php // if ($task == 'Update') {
//                                                echo 'disabled = "true"';
//                                                } ?>  required>
                                            <option value="">Select Employee Code</option>  
                                                <?php foreach ($emp_details as $row) { ?>
                                                <option value="<?php echo $row->id; ?>" <?php if ($emp_code == $row->id) {
                                                        echo 'selected=selected';
                                                    } ?>><?php echo $row->employee_code; ?></option>
                                                <?php } ?>
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
                                                <option value="<?php echo $desg->id; ?>" <?php if ($design == $desg->id) {
                                                    echo 'selected=selected';
                                                } ?>><?php echo $desg->designation_desc; ?></option>
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
                                                <option value="<?php echo $bnk->id; ?>" <?php if ($bank == $bnk->id) {
                                                    echo 'selected=selected';
                                                } ?>><?php echo $bnk->bank_name; ?></option>
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
                                        <label style="font-weight: 600">Pan Card No.</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input class="col-sm-12 form-control" name="pan_no" id="pan_no" type="text" value="<?php echo $pan; ?>" disabled="true">
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
                                    Salary Details <span class="required"></span>
                                </legend>


                                <div class="" style="">
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

                                    <div class="col-md-12">
                                        <div class="col-md-6 div_margin">
                                            <table class="table table-bordered">
                                                <?php
                                                $tot = 0;
                                                foreach ($fetch_salary_name as $sal) {
                                                    if ($sal->salary_typ == 1) {
                                                        if ($task == 'Update') {
                                                            $tot = $tot + $sal->sal_amt;
                                                        }
                                                        ?>
                                                        <tr id="salary_calc">
                                                        <input type="hidden" name="sal_id[]" value="<?php echo $sal->id; ?>">
                                                        <td class="col-md-6"> <?php echo $sal->salary_name; ?> </td>
                                                        <td class="col-md-6" style="padding:8px;"> <input type="number" step="0.001" min="0" required id="earning_<?php echo $sal->id; ?>" name="sal_amount[]" value="<?php if ($task == 'Update') {
                                                            echo $sal->sal_amt;
                                                        } else {
                                                            echo '';
                                                        } ?>"></td>
                                                        </tr>
                                                            <?php }
                                                        } ?>
                                                        <tr style="background-color:#f5f5f5;"> 
                                                            <td > Total Earning </td> 
                                                            <td  style="padding:8px;"> 
                                                                <input type="number" step="0.001" min="0" readonly name="total_sal" id="total_sal" value="<?php if ($task == 'Update') {
                                                    echo $tot;
                                                } ?>"></td> </tr>
                                            </table>
                                        </div>

                                        <div class="col-md-6 div_margin">
                                            <table class="table table-bordered">
                                                <?php $total1 = 0;
                                                foreach ($fetch_salary_name as $sal) {
                                                    if ($sal->salary_typ == 2) {
                                                        if ($task == 'Update') {
                                                            $total1 = $total1 + $sal->sal_amt;
                                                        }
                                                        ?>
                                                        <tr id="sal_calc">
                                                        <input type="hidden" name="sal_id[]" value="<?php echo $sal->id; ?>">
                                                        <td class="col-md-5"> <?php echo $sal->salary_name; ?> </td>
                                                        <td class="col-md-7">
                                                            <input class="col-md-2" type="number" step="0.001" min="0" name="emp_prcnt" id="emp_prcnt" value="" style="padding:0px !important;">
                                                            <div class="col-md-2" style="padding:0px !important;"> % of </div>
                                                            <input class="col-md-3" type="number" step="0.001" min="0" name="basic" id="basic"  placeholder="Basic salary" value="">
                                                            <div class="col-md-1" style="padding:0px !important;"> = </div>
                                                            <input class="col-md-4" type="number" step="0.001"  min="0" style="pointer-events: none" id="deduction_<?php echo $sal->id; ?>" name="sal_amount[]" value="<?php if ($task == 'Update') {
                                                                echo $sal->sal_amt;
                                                            } else {
                                                                echo '';
                                                            } ?>" required>
                                                        </td> 
                                                        </tr>
                                                            <?php }
                                                        } ?>
                                                <tr style="background-color:#f5f5f5;"> <td > Total Deduction </td> <td  style="padding:8px;"> <input type="number" min="0"  step="0.001" readonly name="total_deduc_sal" id="total_deduc_sal" value="<?php if ($task == 'Update') {
                                                    echo $total1;
                                                } ?>"></td> </tr>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                                    <?php // if ($task == 'Update') {
//                                        $payable = abs($tot-$total1);
//                                    } else {
//                                        $payable = 0;
//                                    } ?>
                                <div class="col-md-12" style="text-align:center; border:1px solid gray; padding:10px; background-color:#fce4ec ;">
                                    <div class="col-md-6">    <label for="" style="padding-right: 20px;"> Net Payable Salary </label> <input type="number" min="0" step="0.001" readonly name="net" id="net" value="<?php echo $payable; ?>">  </div>
                                    <div class="col-md-6">    <label for="" style="padding-right: 20px;"> Gross Salary </label> <input type="number" min="0" step="0.001" readonly name="gross" id="gross" value="<?php echo $gross_pay; ?>"> </div>
                                </div>


                                <div class="" style="margin-top:70px;">
                                    <table class="table table-bordered table-striped" style="border:1px solid grey !important;">
                                        <tr style="background-color:#dcedc8">
                                            <th  style="text-align:center"> Salary</th> 
                                            <th  style="text-align:center"> Amount </th>
                                        </tr>

                                        <tr style="">
                                            <td style="padding-left:30px;"> PF Employer </td>
                                            <td style="padding-left:30px;" class="col-md-8">
                                                <input class="col-md-2" type="text" name="empl_pf_prcnt" id="empl_pf_prcnt" value="">
                                                <div class="col-md-1" style="padding-right:0px !important;"> % of </div>
                                                <input class="col-md-3" type="text" name="basic_pf_empl" id="basic_pf_empl"  placeholder="Basic salary" value="">
                                                <div class="col-md-1" style="padding-right:0px !important;"> = </div>
                                                <input class="col-md-5" style="padding-left:15px !important;pointer-events: none;" type="number" required  step="0.001" name="pf_employer" id="pf_employer" value="<?php echo $pf_empl; ?>"> 

                                            </td>
                                        </tr>
                                        <tr style="">
                                            <td style="padding-left:30px;"> Health Insurance Employer </td>
                                            <td style="padding-left:30px;" class="col-md-8"> 
                                                <input class="col-md-2" type="text" name="empl_med_prcnt" id="empl_med_prcnt" value="">
                                                <div class="col-md-1" style="padding-right:0px !important;"> % of </div>
                                                <input class="col-md-3" type="text" name="basic_med_empl" id="basic_med_empl"  placeholder="Basic salary" value="">
                                                <div class="col-md-1" style="padding-right:0px !important;"> = </div>
                                                <input class="col-md-5" type="number"  step="0.001" required style="pointer-events: none;" name="medical_employer" id="medical_employer" value="<?php echo $health_empl; ?>"> 
                                            </td>
                                        </tr>

                                        <tr style="background-color:#fffde7;">
                                            <td style="padding-left:30px; font-weight:600;"> CTC Per Month </td>
                                            <td style="padding-left:30px;">  <input type="number"  step="0.001"  required style="pointer-events: none" name="ctc_mnth" id="ctc_mnth" value="<?php echo $ctc_mon; ?>"> </td>
                                        </tr>
                                        <tr style="background-color:#fffde7;">
                                            <td style="padding-left:30px; font-weight:600;"> CTC Per Year </td>
                                            <td style="padding-left:30px;">  <input type="number"  step="0.001" required style="pointer-events: none" name="ctc_yr" id="ctc_yr" value="<?php echo $ctc_ann; ?>"> </td>
                                        </tr>

                                    </table>
                                </div>



                            </fieldset>
                        </div>

                    </div>    

                    <!--</div>-->



                    <div class="row" style="padding-top:2%">
                        <div class="col-lg-12" style="text-align:center; margin-bottom: 20px;"> 
                        <!--<button type="button" class="btn btn-primary" style="width: 120px;font-family: sans-serif;float:left" id="back" ><i class="fa fa-arrow-left"> </i> Back</button>-->
                            <input type="button" class="btn btn-success" style="width: 120px;font-family: sans-serif;" name="btn_save" id="btn_save" value="<?php echo $task; ?>">
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
//             alert(emp_id);

//       $(".chosen-select").chosen({width: "100%"});   
        $('#end_date').change(function(){
            if(this.value<$('#start_date').val()){
                
                alert('Please choose correct "To date" !!!!!!!!');
                $('#btn_save').attr('disabled',true);
            }else{
                $('#btn_save').attr('disabled',true);
            }
        });

        $('#emp_code').change(function () {
            var salary_head_id='<?php echo $salary_head_id; ?>';
            $.ajax({
                url: "<?php echo site_url('hr/payroll/salary_structure/create_salary'); ?>",
                type: 'POST',
                async: false,
                data: {emp_code: this.value,start_year:$('#start_date').val(),end_year:$('#end_date').val(),salary_head_id:salary_head_id},
                dataType: 'JSON',
                success: function (data) {
                    $.each(data[0], function (index, element)
                    {
//                        alert(element['category_id']);
                        $('#employee_name').val(element['name']);
                        $('#designation').val(element['designation_id']).prop('selected', true).trigger('change');
                        $('#category').val(element['category_id']).prop('selected', true).trigger('change');
                        $('#bank_name').val(element['bank_id']).prop('selected', true).trigger('change');
                        $('#account_no').val(element['bank_accnt_no']);
                        $('#aadhar_no').val(element['aadhar_id']);
                        $('#pf_no').val(element['pf_accnt']);
                        $('#pan_no').val(element['pan_no']);
                        $('#esi_no').val(element['esi_accnt']);
                    });
                    
                    if(data[1]!=''){
                        
                        alert(data[1]);
                        $('#btn_save').attr('disabled',true);
                        
                    }else{
                        $('#btn_save').attr('disabled',false);
                    }
                },
                error: function (req, status)
                {
                    alert('error');
                },
            });
            return false;
        });


        $('#btn_save').click(function () {

            if (task == 'Save')
            {
                action_url = '<?php echo base_url('hr/payroll/salary_structure/save'); ?>';
            }
            else
            {
                var salary_head_id = '<?php echo $salary_head_id; ?>';
                action_url = '<?php echo base_url('hr/payroll/salary_structure/update'); ?>' + '/' + salary_head_id;
            }


            if(!$('#salarydetails_form')[0].checkValidity())
            {
        //                                                alert($('#add_stud_frm')[0].validationMessage);
                $(this).show();
                $('#salarydetails_form')[0].reportValidity();
                                            return false;
            }
            else{ 
                
                var savestatus=confirm('Are you sure want to save');
                
                if(savestatus==true) {
                        $.ajax({
                            type: 'POST',
                            url: action_url,
                            data: $('#salarydetails_form').serialize(),
                            datatype: 'text',
                            success: function (data)
                            {
                                alert('saved successfully');
                                window.location.href = "<?php echo base_url('hr/payroll/salary_structure/save'); ?>";
                            },
                            error: function (req, status)
                            {
                                alert('error while saving');
                            }
                        });
                }
            }
            
        });

        $('#salary_calc input[type=number]').change(function () {
            var total = 0;
            $("input[id^='earning']").each(function ()
            {

                total += Number(this.value);
            });
            var toten = total.toFixed();
            $('#total_sal').val(toten);
            
            calc_gross();

        });

        $('#sal_calc input[type=number]').change(function () {
            var total1 = 0;
            $("input[id^='deduction']").each(function ()
            {
                var basic = $(this).prev().prev().val();
                var prcent = $(this).prev().prev().prev().prev().val();
//        alert(basic);
//        alert(prcent);
                var calc = ((basic / 100) * prcent);
                var calc1 = calc.toFixed(0);
                $(this).val(calc1);
                total1 += Number(calc1);
//        alert(total1);
            });
            var tot = total1.toFixed();
            $('#total_deduc_sal').val(tot);
            calc_gross();

        });


        $('#salary_calc input[type=number],' + '#sal_calc input[type=number]').change(function ()
        {

            calc_gross();
        });

        $('#basic_pf_empl,' + '#basic_med_empl').change(function ()
        {
            calculate_deduction();
        });

        function calc_gross()
        {
            var net_payable=Number($('#total_sal').val())-Number($('#total_deduc_sal').val());
            $('#net').val(net_payable);
            
            var deduct = $('#total_deduc_sal').val();
            var gross_sal = (Number(net_payable) + Number(deduct));  // Gross salary = Earning salary = NetPayable+Deduction
            $('#gross').val(gross_sal);
            var gross1 = $('#gross').val();
            var pf_em = $('#pf_employer').val();
            var med_em = $('#medical_employer').val();
            var month = (Number(gross1) + Number(pf_em));
            var month1 = (Number(month) + Number(med_em));
            var month2 = month1.toFixed();
            $('#ctc_mnth').val(month2);    // CTC/month = Gross Salary + Employer Contribution Salary 
            var year = (Number(month1) * 12);
            var year1 = year.toFixed();
            $('#ctc_yr').val(year1);

        }

        function calculate_deduction()
        {

            var pf_prcnt = $('#empl_pf_prcnt').val();
//    alert(pf_prcnt);
            var basic_pf = $('#basic_pf_empl').val();
//    alert(basic_pf);
            var pf_emp_cal = ((basic_pf / 100) * pf_prcnt);
            var round_pf = pf_emp_cal.toFixed(0);
            $('#pf_employer').val(round_pf);

            var basic_med = $('#basic_med_empl').val();
            var med_prcnt = $('#empl_med_prcnt').val();
            var med_calc = ((basic_med / 100) * med_prcnt);
            var round_med = med_calc.toFixed(0);
            $('#medical_employer').val(round_med);
            
            var gross1 = $('#gross').val();
            var pf_em = $('#pf_employer').val();
            var med_em = $('#medical_employer').val();
            var month = (Number(gross1) + Number(pf_em));
            var month1 = (Number(month) + Number(med_em));
            var month2 = month1.toFixed();
            $('#ctc_mnth').val(month2);
            var year = (Number(month1) * 12);
            var year1 = year.toFixed();
            $('#ctc_yr').val(year1);
        }




    });


</script>
