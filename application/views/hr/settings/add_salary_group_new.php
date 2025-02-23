<style>
    .form-group{margin-bottom: 10px;} 
    fieldset { 
        /*border:solid 1px #528000ab !important;*/
        /*border:solid 1px #c6c6c6 !important;*/
        border: solid 1px #DDD !important;
        padding: 0 10px 10px 10px;
        border-bottom: none;
        /*        border-radius: 8px;
        border-top-left-radius: 25px;
        border-bottom-left-radius: 25px;
        border-top: 2px solid #29a3a3 !important;*/
    }
    legend{
        width: auto !important;
        padding:0 10px;
        border: none;
        font-size: 16px;
        font-family:cursive;
        letter-spacing: 1px;
        color:green;
        /*        font-variant: small-caps;
        letter-spacing: 1px;
        text-decoration: underline;*/
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

            <form enctype="multipart/form-data" id="salarydetails_form" action="" method="post">
                <div class="col-sm-12 col-md-12">
                    <!--my-->
                    <div class="form-group">

                        <div class="form-row">
                            <div class="form-group col-sm-4">
                                <label style="font-weight: 600">Designation</label>
                                <select class="form-control chosen-select" id="designation" name="designation" required>
                                    <option value="0">Select </option>
                                    <?php foreach ($fetch_designation as $desg) {
                                        ?>
                                        <option <?php
                                        if ($designation == $desg->id) {
                                            echo 'selected="selected"';
                                        }
                                        ?>  value="<?php echo $desg->id; ?>"><?php echo $desg->designation_desc; ?></option>
<?php } ?>
                                </select>

                                <div class="" id="" style=""></div> 
                            </div>


                            <div class="form-group col-sm-4">
                                <label for="Salary Group">Salary Group:</label>
                                <input type="text" class="form-control" name="salary_group_name" value="<?php echo $salary_group_name; ?>" placeholder=" salary_group_name" required>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="applicable">Applicable Month/Year From:</label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='month' class="form-control" id="applicable_from" name="applicable_from" value="<?php echo $applicable_from; ?>" placeholder="xxxx-xx (e.g 2017-11)" required>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
                <br>
                <br><br>
                <br><br>

                <div class="row" style="padding-top:2%">
                    <div class="col-sm-12">
                        <fieldset class="">

                            <legend class="" style="font-size:18px;color:green">
                                Salary Details <span class="required"></span>
                            </legend>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="" style="padding-right: 20px;"> Gross  </label> <input type="number" min="0" step="0.001" name="gross_enter" id="gross_enter" value="<?php echo $gross_pay; ?>">
                                </div>
                                <div class="col-md-1">OR</div>
                                <div class="col-md-4">
                                    <label for="" style="padding-right: 20px;">  Fixed Pay  </label> <input type="number" min="0" step="0.001" name="basic_enter" id="basic_enter" value="<?php echo $gross_pay; ?>">
                                </div>
                            </div>

                            <div class="" style="padding-top:2%">
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
                                                    <input type="hidden" name="sal_wage_type[]" value="<?php echo $sal->wages_type; ?>">
                                                    <input type="hidden" name="sal_percnt_amt[]" value="<?php echo $sal->percent_or_amt; ?>">
                                                    <?php if($sal->wages_type!='FIXED') $title='('.$sal->percent_or_amt.'% of '.$sal->wages_type.')'; else $title='(FIXED)';?>
                                                    <td class="col-md-6"> <?php echo $sal->salary_name.' '. $title; ?> </td>
                                                    <td class="col-md-6" style="padding:8px;"> <input type="number" step="0.001" min="0" required id="earning_<?php echo $sal->id; ?>" name="sal_amount[]" value="<?php
                                                        if ($task == 'Update') {
                                                            echo $sal->sal_amt;
                                                        } else {
                                                            echo '';
                                                        }
                                                        ?>"></td>
                                                    </tr>
                                                <?php
                                                }
                                            }
                                            ?>
                                            <tr style="background-color:#f5f5f5;"> 
                                                <td > Total Earning </td> 
                                                <td  style="padding:8px;"> 
                                                    <input type="number" step="0.001" min="0" readonly name="total_sal" id="total_sal" value="<?php
                                                           if ($task == 'Update') {
                                                               echo $tot;
                                                           }
                                                           ?>"></td> </tr>
                                        </table>
                                    </div>

                                    <div class="col-md-6 div_margin">
                                        <table class="table table-bordered">
                                            <?php
                                            $total1 = 0;
                                            foreach ($fetch_salary_name as $sal) {
                                                if ($sal->salary_typ == 2 ) {
                                                    if ($task == 'Update') {
                                                        $total1 = $total1 + $sal->sal_amt;
                                                    }
                                                    ?>
                                                    <tr id="sal_calc">
                                                    <input type="hidden" name="sal_id[]" value="<?php echo $sal->id; ?>">
                                                    <input type="hidden" name="sal_wage_type[]" value="<?php echo $sal->wages_type; ?>">
                                                    <input type="hidden" name="sal_percnt_amt[]" value="<?php echo $sal->percent_or_amt; ?>">
                                                    <?php if($sal->wages_type!='FIXED') $title='('.$sal->percent_or_amt.'% of '.$sal->wages_type.')'; else $title='(FIXED)';?>
                                                    <td class="col-md-6"> <?php echo $sal->salary_name.' ' .$title; ?> </td>
                                                    <td class="col-md-6">
                                                        <input  type="number" step="0.001"  min="0" style="pointer-events: none" id="deduction_<?php echo $sal->id; ?>" name="sal_amount[]" value="<?php
                                                        if ($task == 'Update') {
                                                            echo $sal->sal_amt;
                                                        } else {
                                                            echo '';
                                                        }
                                                        ?>" required>

                                                        <!--  <input  type="number" step="0.001"  min="0" style="pointer-events: none" id="deduction_<?php// echo $sal->id; ?>" name="sal_amount[]" value="<?php
                                                        //if ($task == 'Update') {
                                                           // echo $sal->sal_amt;
                                                       // } else {
                                                           // echo '';
                                                        }
                                                        ?>" required> -->
                                                        
                                                        
                                                    </td> 
                                                    </tr>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                            <tr style="background-color:#f5f5f5;"> <td > Total Deduction </td> <td  style="padding:8px;"> <input type="number" min="0"  step="0.001" readonly name="total_deduc_sal" id="total_deduc_sal" value="<?php
                                                    if ($task == 'Update') {
                                                        echo $total1;
                                                    }
                                                    ?>"></td> </tr>
                                        </table>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-12" style="text-align:center; border:1px solid gray; padding:10px; background-color:#fce4ec ;">
                                <div class="col-md-6">    <label for="" style="padding-right: 20px;"> Net Payable Salary </label> <input type="number" min="0" step="0.001" readonly name="net" id="net" value="<?php echo $payable; ?>">  </div>
                                <div class="col-md-6">    <label for="" style="padding-right: 20px;"> Gross Salary </label> <input type="number" min="0" step="0.001" readonly name="gross" id="gross" value="<?php echo $gross_pay; ?>"> </div>
                            </div>


                            <div class="" style="margin-top:70px;">
                                <table class="table table-bordered table-striped" style="border:1px solid grey !important;">
                                    <tr style="background-color:#dcedc8">
                                        <th  style="text-align:center"> Salary (Employer Contribution)</th> 
                                        <th  style="text-align:center"> Amount </th>
                                    </tr>
                                    <?php
                                            $totale = 0;
                                            foreach ($fetch_salary_name as $sal) {
                                                if ($sal->salary_typ == 3 ) {
                                                    if ($task == 'Update') {
                                                        $totale = $totale + $sal->sal_amt;
                                                    }
                                                    ?>
                                    <tr style="">
                                        <input type="hidden" name="sal_id[]" value="<?php echo $sal->id; ?>">
                                        <input type="hidden" name="sal_wage_type[]" value="<?php echo $sal->wages_type; ?>">
                                        <input type="hidden" name="sal_percnt_amt[]" value="<?php echo $sal->percent_or_amt; ?>">
                                        <?php if($sal->wages_type!='FIXED') $title='('.$sal->percent_or_amt.'% of '.$sal->wages_type.')'; else $title='(FIXED)';?>
                                        <td style="padding-left:30px;"> <?php echo $sal->salary_name.' ' .$title; ?></td>
                                        <td style="padding-left:30px;" class="col-md-8">
                                            <input  type="number" step="0.001"  min="0"  id="ededuction_<?php echo $sal->id; ?>" name="sal_amount[]" value="<?php
                                                        if ($task == 'Update') {
                                                            echo $sal->sal_amt;
                                                        } else {
                                                            echo '';
                                                        }
                                                        ?>" required>
                                        </td>
                                    </tr>
                                            <?php }}?>

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
                <!--my-->





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

        
        $('#gross_enter').change(function(){
            var gross=$(this).val();
            alert(gross);
            var ba=0;
            var da=0;
            $("input[name^='sal_id']").each(function(){
              
                var wagetype=$(this).next('input').val();
                var percent_amt=$(this).next('input').next('input').val();
                
                
                switch(wagetype) {
                    case 'FIXED' : $(this).closest('tr').find('input[name^="sal_amount"]').val(percent_amt);
                        break;
                    case 'GROSS' : 
                       var amt=(percent_amt*gross)/100;
                       $(this).closest('tr').find('input[name^="sal_amount"]').val(amt);
                       break;
                    case 'BA+DA' :    
                        var ba=Number($('#earning_1').val());
                        var da=Number($('#earning_2').val());
                        var amt=(percent_amt*(ba+da))/100;
                       $(this).closest('tr').find('input[name^="sal_amount"]').val(amt);
                       break;
                    case 'BA' : 
                        var ba=Number($('#earning_1').val());
                        var amt=(percent_amt*ba)/100;
                       $(this).closest('tr').find('input[name^="sal_amount"]').val(amt);
                       break;
                   default:
                       break;
                }
                
                
                
            });
            var total = 0;
                $("input[id^='earning']").each(function ()
                {

                    total += Number(this.value);
                });
                var toten = total.toFixed();
                $('#total_sal').val(toten);
                
                var total1 = 0;
                $("input[id^='deduction']").each(function ()
                {
                    total1 += Number(this.value);

                });
                var tot = total1.toFixed();
                $('#total_deduc_sal').val(tot);
            calc_gross();
            
        });
        
        $('#basic_enter').change(function(){
           
            var gross=0;
            var ba=Number(this.value);
            var da=0;
            $("input[name^='sal_id']").each(function(){
              
                var wagetype=$(this).next('input').val();
                var percent_amt=$(this).next('input').next('input').val();
                
                if(this.value==1) {
                    $('#earning_1').val(ba);
                    alert($('#earning_1').val());
                }else{
                    switch(wagetype) {
                        case 'FIXED' : $(this).closest('tr').find('input[name^="sal_amount"]').val(percent_amt);
                            break;
                        case 'GROSS' : 
                           var amt=(percent_amt*gross)/100;
                           $(this).closest('tr').find('input[name^="sal_amount"]').val(amt);
                           break;
                        case 'BA+DA' :    
                            
                            var da=Number($('#earning_2').val());
                            var amt=(percent_amt*(ba+da))/100;
                           $(this).closest('tr').find('input[name^="sal_amount"]').val(amt);
                           break;
                        case 'BA' : 
                           
                            var amt=(percent_amt*ba)/100;
                           $(this).closest('tr').find('input[name^="sal_amount"]').val(amt);
                           break;
                       default:
                           break;
                    }
                
                }
                
            });
            var total = 0;
                $("input[id^='earning']").each(function ()
                {

                    total += Number(this.value);
                });
                var toten = total.toFixed();
                $('#total_sal').val(toten);
                
                var total1 = 0;
                $("input[id^='deduction']").each(function ()
                {
                    total1 += Number(this.value);

                });
                var tot = total1.toFixed();
                $('#total_deduc_sal').val(tot);
            calc_gross();
            
        });
        
        



        $('#btn_save').click(function () {

            if (task == 'Save')
            {
                action_url = '<?php echo base_url('hr/settings/salary_groups/save'); ?>';
            }
            else
            {
                var salary_group_id = '<?php echo $salary_group_id; ?>';
                action_url = '<?php echo base_url('hr/settings/salary_groups/update'); ?>' + '/' + salary_group_id;
            }


            if (!$('#salarydetails_form')[0].checkValidity())
            {
//                                                alert($('#add_stud_frm')[0].validationMessage);
                $(this).show();
                $('#salarydetails_form')[0].reportValidity();
                return false;
            } else {

                var savestatus = confirm('Are you sure want to save');

                if (savestatus == true) {
                    $.ajax({
                        type: 'POST',
                        url: action_url,
                        data: $('#salarydetails_form').serialize(),
                        datatype: 'text',
                        success: function (data)
                        {
                            alert('saved successfully');
                            window.location.href = "<?php echo base_url('hr/settings/salary_groups'); ?>";
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

                total1 += Number(this.value);
            });
            var tot = total1.toFixed();
            $('#total_deduc_sal').val(tot);
            calc_gross();

        });


        $('#salary_calc input[type=number],' + '#sal_calc input[type=number]').change(function ()
        {

            calc_gross();
        });



        function calc_gross()
        {
            var net_payable = Number($('#total_sal').val()) - Number($('#total_deduc_sal').val());
            $('#net').val(net_payable);

            var deduct = $('#total_deduc_sal').val();
            var gross_sal = (Number(net_payable) + Number(deduct));  // Gross salary = Earning salary = NetPayable+Deduction
            $('#gross').val(gross_sal);
            var gross1 = Number($('#gross').val());
            
            var total1=0;
            $("input[id^='ededuction_']").each(function(){
                total1 += Number(this.value);
            });
            
            
            $('#ctc_mnth').val(gross1+total1);    // CTC/month = Gross Salary + Employer Contribution Salary 
            var year = (Number(gross1+total1) * 12);
            var year1 = year.toFixed();
            $('#ctc_yr').val(year1);

        }





    });


</script>
