<style>
    tr.highlight {
        background-color: #dff0d8 !important;
        border-color: #d6e9c6 !important;
        font-weight:bold !important;
        /*color:black !important;*/
    }

</style>
<div id="fee_collect_div_n">

    <div class="panel  panel-success">
        <div class="panel-heading" style="padding: 5px 15px;"><i class="glyphicon glyphicon-th-list"></i><b> <span style="color:black">Student Information</span></b></div>
        <div class="panel-body" style="padding:0px">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" style="margin:0px">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Admission No.</th>
                            <th>Student Name</th>
                            <th>Father's Name</th>
                            <th>DOB</th>
                            <th>Category</th>
                            <th>Class</th>
                            <th>Course</th>
                            <th>Phone No.</th>
                            <th>Email Address</th>
                            <th>Student Session</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $student_id; ?></td>
                            <td><?php echo $admission_no; ?></td>
                            <td><?php echo $student_name; ?></td>
                            <td><?php echo $father_name; ?></td>
                            <td><?php echo date('d-m-Y', strtotime($dob)); ?></td>
                            <td><?php echo $category_name; ?></td>
                            <td><?php echo $class . ' ' . $section; ?></td>
                            <td><?php echo $course; ?></td>
                            <td><?php echo $phone; ?></td>


                            <td><?php echo $email_address; ?></td>
                            <td><?php echo $stud_acedemic_session; ?></td>
                        </tr>
                        <?php if ($stud_acedemic_session_id != $active_acedemic_session[0]->fin_year) { ?>
                            <tr style="color:red;text-align:center;font-weight:bold">
                                <td colspan=9>
                                    Data Is Not UpDated (Since Active session is not matched with Student session)
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="panel  panel-info">
        <div class="panel-heading" style="padding: 5px 15px;"><i class="glyphicon glyphicon-folder-open">  </i> <b> <span style="color:black"> Fees Collection</span></b></div>
        <div class="panel-body" style="padding:0px;">
            <?php if (substr($right_access, 0, 1) == 'C' && ($stud_acedemic_session_id == $active_acedemic_session[0]->fin_year)) { ?>
                <div class="row" >
                    <div class="col-sm-12" style="padding:5px 15px;text-align: right">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myFeeModal" <?php // if($this->session->userdata('school_id')==5 || $this->session->userdata('school_id')==30) echo 'disabled';   ?>>Collect Fee</button>
                    </div>
                </div>
            <?php } ?>


            <?php $total_onet = 0;
                   $total_refundt = 0; if ($onetime_avai == 'YES' && $student_type!='EXISTING') { ?>
                <!--onetime fee start-->

                <div class="col-md-4" style="padding:1%">
                    <div class="box " style="border: 1px solid lightgrey;">


                        <form class="form-horizontal" method="POST" role="form" id="onetime_paym" action="<?php echo base_url("payment_army/request") ?>">

                            <div class="box-header" style="background: aliceblue;padding:5px">
                                <h4 class="box-title" >Onetime Fees</h4>
                            </div>
                            <div class="box-body">
                                 <div class='row'>
                                <div class="col-lg-12">
                                <table id="one_paymentlist" class="table table-bordered table-striped" style="width:100%">
                                    <thead>
                                        <tr>                 
                                            <th>Fee Name</th>
                                            <th>Fee Amount</th>     
                                        </tr>
                                    </thead>
                                    <?php // if (count($onetime_fee_paid->result()) == 0) { ?>       <!--------------------------for unpaid---------------->                                                      
                                    <tbody id="get_onetime_fee_det"> 
                                        <?php {
                                            
                                            $total_onetime = 0;
                                            foreach ($onetime_fee->result() as $obj) {
                                                $total_onetime = $total_onetime + $obj->fee_amount;
                                                if ($obj->fee_cat == 9) {
                                                    $total_onet = $total_onet + $obj->fee_amount;
                                                }
                                                if ($obj->fee_cat == 10) {
                                                    $total_refundt = $total_refundt + $obj->fee_amount;
                                                }
                                                ?>
                                                <tr>                 
                                                    <td><?php echo $obj->fee_name; ?></td>
                                                    <td><?php echo $obj->fee_amount; ?></td>    
                                                </tr>
                                            <?php } ?>

                                            
                                            <tr  style="font-size: 17px;font-weight: bold;">                 
                                                    <td>Total</td>
                                                    <td id="amountpaidonetime"><?php echo $total_onetime; ?></td>  
                                            <input type="hidden" name="categorylist[1]" value="<?php echo $total_onet; ?>">
                                            <input type="hidden" name="categorylist[2]" value="<?php echo $total_refundt; ?>">
                                            </tr>
                                        
                                    <?php } ?>     
                                    </tbody>
                                </table>
                                </div>
                                 </div>
                                  <div id="onetime" class='row'>
                                <div class="col-lg-12" style="text-align:center">

                                    <?php if (count($onetime_fee_paid)>0) { ?>

                                        <h4 style="background: #85e085">PAID</h4>
                                    <?php } ?>
                                </div>

                            </div>   
                            </div>
                            
                        </form>
                    </div>
                </div>

                <!--onetime fee end-->

            <?php } ?>


            <?php if ($fee_type1 == 2) { ?>
                <div class="col-md-4" style="padding:1%">
                    <div class="box " style="border: 1px solid lightgrey;">
                        <div class="box-header" style="background: aliceblue;padding:5px">
                            <h4 class="box-title" >Quaterly Fees</h4>
                        </div>
                        <div class="box-body">
                            <div class='row'>
                                <div class="col-lg-12 tab-content">
                                    <div id="month">
                                        <form name="frmfee" id="frmfee" role="form" method="POST">
                                            <input type="hidden" value="" id="month_val" name="month_val">

                                            <div class="col-lg-12">
                                                <table id="studentlist" class="table table-bordered table-striped">

                                                    <thead>
                                                        <tr>
                                                            <th class='col-lg-6'>Fee Description</th>
                                                            <th class='col-lg-6'>Fee Amount</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php
                                                        $total_monthly_amount = 0;
                                                        foreach ($fees1 as $mon_fee) {
                                                            $total_monthly_amount = $total_monthly_amount + $mon_fee->fee_amount;
                                                            ?>
                                                            <tr id="row<?php echo $mon_fee->fee_id ?>">
                                                                <td><?php echo $mon_fee->fee_desc; ?></td>
                                                                <td><?php echo $mon_fee->fee_amount; ?></td>

                                                            </tr>
                                                            <?php
                                                        }
                                                        if ($transport_fee_amt != 0) {
                                                            $total_monthly_amount = $total_monthly_amount + $transport_fee_amt;
                                                            ?>
                                                            <tr>                 
                                                                <td>Transport Fee</td>
                                                                <td><input type="text" readonly="true" style="border: 0px;width:65px;background:inherit" name="trans_fee_amt" value="<?php echo $transport_fee_amt; ?>"></td>              
                                                            </tr>
                                                        <?php } ?>
                                                        <tr>
                                                            <th>Total Amount</th>
                                                            <th id="amountpaidquarterly"><?php echo $total_monthly_amount; ?></th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>


                                        </form>
                                    </div>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-lg-12" id="">
                                    <fieldset>
                                        <legend>Months Status</legend>
                                        <?php for ($pm = 1; $pm <= 12; $pm++) { ?> 
                                            <div class="btn col-sm-2 col-md-2 col-xs-3" style="padding: 6px 6px;width:42px ;font-weight: bold;<?php
                                            if($pm<$start_fee_month){
                                                echo 'border:1px solid black;';
                                            }else if ($pm>=$start_fee_month && $pm <= $paid_month) {
                                                echo 'background-color:#85e085;color: green;';
                                            }elseif ($pm>$paid_month && $pm<=$paid_month+$chqpaid_month) {
            
                                                echo 'background-color:#fbd222;color: black;';
                                            }  else {
                                                echo 'background-color:#ff6161;color: white;';
                                            }
                                            ?>;margin: 1px"><?php echo $month[$pm]; ?></div>
                                             <?php } ?>
                                    </fieldset>

                                </div>
                            </div>
                        </div>         
                    </div>

                </div>
                <!--</div>-->
            <?php } ?>

            <?php if ($fee_type2 == 4) { ?>
                <div class="col-md-4" style="padding:1%">
                    <div class="box " style="border: 1px solid lightgrey;">
                        <div class="box-header" style="background: aliceblue;padding:5px">
                            <h4 class="box-title" >Annual Fees</h4>
                        </div>
                        <div class="box-body">

                            <div class='row'>
                                <div class="col-lg-12">
                                    <table id="studentlist1" class="table table-bordered table-striped">

                                        <thead>
                                            <tr>
                                                <th class='col-lg-6'>Fee Description</th>
                                                <th class='col-lg-6'>Fee Amount</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $total_annual_amount = 0;
                                            $total_refundannual = 0;
                                            foreach ($fees2 as $hy_fee) {

                                                $total_annual_amount = $total_annual_amount + $hy_fee->fee_amount;
                                                if($hy_fee->fee_type=='REFUND') {
                                                        $total_refundannual = $total_refundannual + $hy_fee->fee_amount;
                                                    }
                                                ?>
                                                <tr id="row<?php echo $hy_fee->fee_id ?>">
                                                    <td><?php echo $hy_fee->fee_desc; ?></td>
                                                    <td><?php echo $hy_fee->fee_amount; ?></td>

                                                </tr>
                                            <?php } ?>
                                                                                            <?php
                                                if ($start_fee_month != 1) {
                                                    $refunded = $total_refundannual / 12;
                                                    $total_refunded = $refunded * ($start_fee_month - 1);
                                                    $total_annual_amount = round($total_annual_amount - $total_refunded);
                                                } else {
                                                    $total_refunded = 0;
                                                }
                                                ?>
                                            <tr>
                                                <th >Total Amount</th>
                                                <th <?php if ($total_refunded == 0){ ?> id="annamountpaid" <?php }?>><?php echo $total_annual_amount; ?></th>
                                            </tr>



                                                <?php if ($total_refunded != 0) { ?>    
                                                    <tr  style="font-weight: bold;">                 
                                                        <td style="font-size: 16px;">Refunded Amount</td>
                                                        <td><?php echo round($total_refunded); ?></td>              
                                                    </tr> 
                                                    <tr>
                                                    <th>Amount to be paid</th>
                                                        <th id="annamountpaid"><?php echo $total_annual_amount; ?></th>
                                                    </tr>
                                                <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="month" class='row'>
                                <div class="col-lg-12" style="text-align:center">

                                    <?php if ($paid_status2 == 1) { ?>

                                        <h4 style="background: #85e085">PAID</h4>
                                    <?php } ?>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            <?php } ?>
                            <div class="col-md-4" style="padding:1%">
                <div class="box " style="border: 1px solid lightgrey;">
                    <div class="box-header" style="background: aliceblue;padding:5px">
                        <h4 class="box-title" >Other/Additional Fees</h4>
                    </div>
                    <div class="box-body">
                        <table id="spstudentlist" class="table table-bordered table-striped">

                            <thead>
                                <tr>
                                    <th class='col-lg-4'>Fee Description</th>
                                    <th class='col-lg-4'>Amount</th>
                                    <th class='col-lg-4'>Month</th>


                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($other_fees as $othrfee) { ?>
                                    <tr id="otherrow<?php echo $othrfee->fee_id ?>"> 
                                        <td><?php echo $othrfee->fee_desc; ?></td>
                                        <td><?php echo $othrfee->fee_amount; ?></td>
                                        <td>
                                            <?php
                                            if (!empty($othrfee->month_set)) {
                                                $e1 = explode(',', $othrfee->month_set);
                                                $stre1 = '';
                                                foreach ($e1 as $ev1) {
                                                    $stre1 .= $month[$ev1] . ', ';
                                                }

                                                echo $stre1 = rtrim($stre1, ', ');
                                            }
                                            ?>
                                        </td>

                                    </tr>
                                <?php } ?>
                            </tbody>

                        </table>
                    </div>

                </div>
            </div>
            <div class="col-md-4" style="padding:1%">
                <div class="box " style="border: 1px solid lightgrey;">
                    <div class="box-header" style="background: aliceblue;padding:5px">
                        <h4 class="box-title" >Instant/Misc. Fees</h4>
                    </div>
                    <div class="box-body">
                        <table id="spstudentlist" class="table table-bordered table-striped">

                            <thead>
                                <tr>
                                    <th class='col-lg-4'>Fee Description</th>
                                    <th class='col-lg-4'>Amount</th>
                                    <th class='col-lg-4'>Date of Allocation</th>
                                    <th class='col-lg-4'>Status</th>



                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($fetch_instant_fees_det1 as $insfee) { ?>
                                    <tr id="otherrow<?php echo $insfee->fee_id ?>"> 


                                        <td><?php echo $insfee->fee_desc; ?></td>
                                        <td><?php echo $insfee->amount; ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($insfee->date_created)); ?></td>
                                        <th <?php
                                        if ($insfee->paid_status == 1) {
                                            echo 'style="background: #85e085";color: green;';
                                        } else {
                                            echo 'style="background: #ff6161;color:#fff;"';
                                        }
                                        ?>><?php
                                                if ($insfee->paid_status == 1) {
                                                    echo 'Paid';
                                                } else {
                                                    echo 'Unpaid';
                                                };
                                                ?></th>


                                    </tr>
                                <?php } ?>
                            </tbody>

                        </table>
                    </div>

                </div>
            </div>



        </div>


    </div>
    <div class="panel  panel-success">
        <div class="panel-heading" style="padding: 5px 15px;"><i class="glyphicon glyphicon-time">  </i> <b> <span style="color:black"> Transaction History</span></b></div>
        <div class="panel-body" style="padding:0px;">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" style="margin:0px;width:100%" id="list1" >
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Total Amount</th>
                            <th>Transaction Id</th>
                            <th>Payment Id</th>
                            <th>Payment Date</th>
                            <th>Remarks</th>
                            <th>Receipt No</th>
                            <th>Collection center</th>
                            <th>Status</th>
                            <th>Actions</th>
                            <!--<th></th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($t = 0; $t < $cntt; $t++) { ?>
                            <tr>
                                <td><?php echo $description[$t]; ?></td>
                                <td><?php echo $amount[$t] . ' INR'; ?></td>
                                <td><?php echo $transaction_id[$t]; ?></td>
                                <td><?php echo $payment_id[$t]; ?></td>
                                <td><?php echo $payment_date[$t]; ?></td>
                                <td><?php echo $remarks[$t] . ' (' . $response_message[$t] . ' )'; ?></td>
                                <td><?php echo $receipt_no[$t]; ?></td>
                                <td><?php echo $collection_centre[$t]; ?></td>
                                <td><?php
                                    if ($paid_status[$t] == 1) {
                                        echo 'Paid';
                                    } else if ($paid_status[$t] == 0 && $charge_back[$t] == 1) {
                                        echo 'ChargeBack Applied';
                                    } else {
                                        echo 'UNPAID';
                                    };
                                    ?></td>
                                <td> 
                                    <?php if ($paid_status[$t] == 1) { ?>
                                        <a class="btn" href="<?php echo base_url("feepayment/collection/Offline_payment_army/download_receipt/$fee_trans_head_id[$t]/$student_id"); ?>" style="padding:0px" title="Receipt Download"><i class="glyphicon glyphicon-download-alt"> </i> </a>
                                        <?php // if($this->session->userdata('school_id')!=26 ){  ?>
                                        <a class="btn" href="<?php echo base_url("feepayment/collection/Payment_pdf/payment_pdf_army/$fee_trans_head_id[$t]/$student_id"); ?>" style="color:#555285;padding:1px" title="2 Copy Receipt Download" target="_blank"><i class="glyphicon glyphicon-circle-arrow-down"> </i> </a>
                                        <?php // }else{  ?>
                                        <!--<a class="btn" href="<?php // echo base_url("feepayment/collection/Payment_pdf/dot_matrix/$fee_trans_head_id[$t]/$student_id");  ?>" style="color:#555285;padding:1px" title="2 Copy Receipt Download"><i class="glyphicon glyphicon-circle-arrow-down"> </i> </a>-->
                                        <?php // } ?>
                                        <?php
                                        if (substr($right_access, 2, 1) == 'U') {
                                            if ($collection_centre[$t] != 'FCLB') {
                                                ?>
                                                <a class="btn" onclick="editTransaction(this, '<?php echo trim($remarks[$t]); ?>', '<?php echo $mode[$t]; ?>', '<?php echo $bank_name[$t]; ?>', '<?php echo date('Y-m-d', strtotime($payment_date[$t])); ?>', '<?php echo $amount[$t]; ?>')" style="color:green;padding:0px" title="Edit" id="<?php echo $fee_trans_head_id[$t]; ?>"><i class="glyphicon glyphicon-pencil"> </i></a>

                <!--<a class="btn" onclick="deleteTransaction(this,'<?php echo trim($remarks[$t]); ?>','<?php echo $mode[$t]; ?>','<?php echo $bank_name[$t]; ?>','<?php echo date('Y-m-d', strtotime($payment_date[$t])); ?>','<?php // echo $amount[$t];   ?>')" style="color:red;padding:0px" title="Cancel" id="<?php // echo $fee_trans_head_id[$t];   ?>"><i class="glyphicon glyphicon-remove"> </i> </a>-->
                                                <a class="btn"  style="color:red;padding:0px" title="Cancel" id="<?php echo $fee_trans_head_id[$t]; ?>"><i class="glyphicon glyphicon-remove"> </i> </a>
                                            <?php
                                            }
                                        }
                                        ?>
    <?php } ?>

                                </td>
                            </tr>
<?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
<!-- Modal -->
<div id="myFeeModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Fee Collection <center> <span style="color:#010d6d">Admission No.: <b><?php echo $admission_no; ?></b></span> <span style="color:#010d6d">Student name : <b><?php echo $student_name; ?></b></span> <span style="color:#010d6d">Class & Sec : <b><?php echo $class . ' ' . $section; ?></b></span></center></h4>
            </div>
            <form class="form-horizontal"  method="post" id="frmcollectfee">
                <div class="modal-body">
                    <fieldset>
                        <table class="table table-hover" style="margin-bottom:0px">
                            <thead>
                                <tr class="row">
                                    <th class="col-sm-1"></th>
                                    <th class="col-sm-3">Fee Head</th>
                                    <th class="col-sm-4"></th>
                                    <th style="text-align: center" class="col-sm-4">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($onetime_avai == 'YES' && $student_type!='EXISTING') {
                                    if ($paid_status2 == 0) {
                                        ?>
                                        <tr class="row">
                                            <td class="col-sm-1"><input type="checkbox" name="fee_head[9]" id="chk_9" value="9"></td>
                                            <td class="col-sm-3">Onetime Fees</td>
                                            <td class="col-sm-4">
                                            </td>
                                            <td class="col-sm-4">
                                                <input type="text" required class="form-control" name="fee_amt[9]" style="padding-right:1px; pointer-events: none;" readonly>
                                                <input type="hidden" name="cal_list[9]" value="<?php echo $total_onet; ?>" >
                                                <input type="hidden" name="cal_list[10]" value="<?php echo $total_refundt; ?>" >
                                            </td>
                                        </tr>
                                    <?php }
                                }
                                ?>

<?php if ($fee_type1 == 2 &&  $paid_month!=12) { ?>
                                    <tr class="row" id="mont_paym">
                                        <td class="col-sm-1"><input type="checkbox" name="fee_head[5]" id="chk_5" value="5"></td>
                                        <td class="col-sm-3">Quarterly Fees</td>
                                        <td class="col-sm-4">
                                            <select name="noofqtr" class="form-control"  disabled="true" id="noofqtr" required>
                                                <option value="">--Select--</option>
                                                <?php if($start_fee_month<=3 && $paid_month<3) {?>
                                                <option value="0">Qtr1 (APR-MAY-JUN)</option>
                                                <?php }?>
                                                <?php if($start_fee_month<=6 && $paid_month<6) {?>
                                                <option value="1">Qtr2 (JUL-AUG-SEP)</option>
                                                <?php } if($start_fee_month<=9 && $paid_month<9) {?>
                                                <option value="2">Qtr3 (OCT-NOV-DEC)</option>
                                                <?php } if($start_fee_month<=12 && $paid_month<12) {?>
                                                <option value="3">Qtr4 (JAN-FEB-MAR)</option>
                                                <?php }?>
                                            </select>
                                            <input type="hidden" name="noofmonth" id="noofmonth" value="">
                                        </td>

                                        <td class="col-sm-4"><input type="text" class="form-control" name="fee_amt[5]" style="padding-right:1px;pointer-events: none;" readonly></td>              
                                        <!--<td class="col-sm-4"><input type="text" required class="form-control" name="fee_amt[9]" style="padding-right:1px; pointer-events: none;" readonly></td>-->
                                    </tr>

                                <?php } ?>


                                <?php
                                if ($fee_type2 == 4) {
                                    if ($paid_status2 == 0) {
                                        ?>
                                        <tr class="row">
                                            <td class="col-sm-1"><input type="checkbox" name="fee_head[1]" id="chk_1" value="1"></td>
                                            <td class="col-sm-3">Annual Fees</td>
                                            <td class="col-sm-4">
                                            </td>
                                            <td class="col-sm-4"><input type="text" required class="form-control" name="fee_amt[1]" style="padding-right:1px; pointer-events: none;" readonly></td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr class="row" id="halffeetr">

                                    </tr>
                                    <?php
                                }
                                ?>
                                <tr class="row" id="othrowmonthly">

                                </tr>
<?php if (count($fetch_other_fees_det_withoutmonth) > 0) { ?>
                                    <tr class="row" id="othrow">
                                        <td class="col-sm-1"> <input type="checkbox" name="fee_head[3]" id="chk_3" value="3"></td>
                                        <td class="col-sm-3">Other Fees</td>
                                        <td class="col-sm-4">
                                            <table class="table table-bordered table-striped" id="otherfee_tbl">
    <?php foreach ($fetch_other_fees_det_withoutmonth as $othrfee) { ?>
                                                    <tr>
                                                        <td><input type="checkbox" id="oth_fee<?php echo $othrfee->fee_id ?>" value="<?php echo $othrfee->fee_amount ?>" name="other_chk[<?php echo $othrfee->fee_id ?>]" disabled></td>
                                                        <td><?php echo $othrfee->fee_desc; ?></td>
                                                        <td><?php echo $othrfee->fee_amount; ?></td>
                                                    </tr>
    <?php } ?>
                                            </table>
                                        </td>
                                        <td class="col-sm-4"><input type="text" class="form-control" value="" id="other_feeth" required name="fee_amt[3]" style="padding-right:1px;pointer-events: none;" readonly oninvalid="this.setCustomValidity('Please Select atleast one Other Fee Type')" oninput="setCustomValidity('')" onchange="setCustomValidity('')"></td>
                                    </tr>
                                <?php } ?>
<?php if (count($fetch_instant_fees_det) > 0) { ?>
                                    <tr class="row" id="instant_fee_misc">
                                        <td class="col-sm-1"> <input type="checkbox" name="fee_head[8]" id="chk_8" value="8"></td>
                                        <td class="col-sm-3">Instant/Misc. Fees</td>
                                        <td class="col-sm-4">
                                            <table class="table table-bordered table-striped" id="instantfee_tbl">
    <?php foreach ($fetch_instant_fees_det as $instfee) { ?>
                                                    <tr>
                                                    <!--<input type="hidden" value="<?php // echo $instfee->id   ?>" name="instantfeemainid[]">-->
                                                        <td><input type="checkbox" id="instant_fee<?php echo $instfee->fee_id ?>" value="<?php echo $instfee->amount ?>" name="instantfee_chk[<?php echo $instfee->id ?>][<?php echo $instfee->fee_id ?>]" disabled></td>
                                                        <td><?php echo $instfee->fee_desc; ?></td>
                                                        <td><?php echo $instfee->amount; ?></td>
                                                    </tr>
    <?php } ?>
                                            </table>
                                        </td>
                                        <td class="col-sm-4"><input type="text" class="form-control" value="" id="instant_misc_feeth" required name="fee_amt[8]" style="padding-right:1px;pointer-events: none;" readonly oninvalid="this.setCustomValidity('Please Select atleast one Instant Fee Type')" oninput="setCustomValidity('')" onchange="setCustomValidity('')"></td>
                                    </tr>
<?php } ?>
                                <tr class="row">
                                    <td class="col-sm-1"><input type="checkbox" disabled="true" name="fee_head[0]" id="chk_0" value="0"></td>
                                    <td class="col-sm-3" id="fine_td">Fine </td>
                            <input type="hidden" name="no_of_duemonth" value="<?php echo $fine_month ?>"> 
                            <td class="col-sm-4">
                            </td>
                            <td class="col-sm-4"><input type="text" class="form-control" required name="fee_amt[0]" id="fee_fine" style="padding-right:1px;pointer-events: none;" value="" readonly ></td>
                            <!-- <td class="col-sm-4"><input type="text" class="form-control" required name="fee_amt[0]" id="fee_fine" style="padding-right:1px;pointer-events: none;" value="" readonly ></td> -->
                            </tr>
                            <?php if ($readmsnfineamt != 0) { ?>
                                <tr class="row">
                                    <td class="col-sm-1"><input type="checkbox"  name="fee_head[11]" id="chk_11" value="11"  ></td> 
                                    <td class="col-sm-3" id="re_admission_fine">Re-Admission-Fine</td>
                                    <td class="col-sm-4">
                                    </td>
                                    <td class="col-sm-4"><input type="text" class="form-control" required name="fee_amt[11]" id="re_admission_fineamt"  style="padding-right:1px;pointer-events: none;" value="" readonly ></td>
                                </tr>
<?php } ?>
                            <tr class="row">
                                <td class="col-sm-1"><input type="checkbox"  name="fee_head[7]" id="chk_7" value="7"></td> 
                                <td class="col-sm-3" id="instant_discount">Instant Discount</td>
                                <td class="col-sm-4">
                                </td>
                                <td class="col-sm-4"><input type="text" class="form-control" required name="fee_amt[7]" id="instant_discount" onchange="cal_amt()" style="padding-right:1px;" value="" readonly ></td>
                            </tr>
                            </tbody>
                            <tfoot>
                                <tr class="row">
                                    <th class="col-sm-1"></th>
                                    <th class="col-sm-3">Total Amount</th>
                                    <th class="col-sm-4"></th>
                                    <th class="col-sm-4" style="text-align: center"><input type="text" class="form-control" id="tot_amt_th" value="" name="tot_amount" required style="padding-right:1px;pointer-events: none;" oninvalid="this.setCustomValidity('Please Select Atleast One Fee Type from above')" oninput="setCustomValidity('')" ></th>
                                </tr>
                            </tfoot>
                        </table>
                    </fieldset>
                    <fieldset>
                        <legend>Other Information</legend>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-4">
                                    <label for="email"><b>Payment Date</b></label>
                                    <input type="date" name="payment_date" class="form-control" value="<?php echo date("Y-m-d"); ?>" required>
                                </div>
                                <div class="col-sm-4">
                                    <label for="email"><b>Collection Center</b></label>
                                    <select class="form-control" name="collection_center" required>
                                        <!-- <option value="">Select</option> -->
                                        <?php foreach ($collection_centers as $cc) { ?>
                                            <option value="<?php echo $cc->collection_code ?>"><?php echo $cc->collection_desc; ?></option>
<?php } ?>
                                    </select>                                
                                </div>
                                <div class="col-sm-4">
                                    <label for="email"><b>Payment Mode</b></label>
                                    <select class="form-control" name="mode_payment" id="mode_payment" required="">
                                        <option value="POS">POS</option>
                                        <!-- <option value="">Select</option> -->
                                        <option value="CASH">CASH</option>
                                        <option value="CHEQUE">CHEQUE</option>
                                        <option value="CHALLAN">CHALLAN</option>
                                        <option value="DRAFT">DRAFT</option>
                                        
                                        <option value="DC">Debit Card</option>
                                        <option value="CC">Credit Card</option>
                                        <option value="NB">Net Banking</option>
                                        <option value="RTGS">RTGS</option>
                                        <option value="NEFT">NEFT</option>
                                    </select> 
                                </div>

                            </div>
                        </div>
                        <div class="row" id="cheque_div" style="display: none">
                            <div class="col-sm-12">
                                <div class="col-sm-4">
                                    <label for="email"><b>Cheque No.</b></label>
                                    <input type="text"  name="cheque_no" class="form-control">
                                </div>
                                <div class="col-sm-4">
                                    <label for="email"><b>Cheque Date</b></label>
                                    <input type="date"  name="cheque_date" class="form-control">
                                </div>
                                <div class="col-sm-4">
                                    <label for="email">Status</label>
                                    <select class="form-control" name="cheque_status" id="cheque_status" >
                                        <option value="">Select</option>
                                        <option value="Pending">Under Clearance</option>
                                        <option value="Cleared">Cleared</option>
                                        <option value="Bounce">Bounce</option>
                                    </select>  
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-4">
                                    <label for="email">Bank Name <span style="font:10px;font-weight: normal;">(in case collected in Bank/POS/CHEQUE)</span></label>
                                    <select class="form-control" name="bank_name">
                                        <!-- <option value="">Select</option> -->
                                        <option value="HDFC">HDFC</option>
                                        <option value="SBI">SBI</option>
                                        <option value="IDBI">IDBI</option>
                                        <option value="PNB">PNB</option>
                                        <option value="ICICI">ICICI</option>
                                        <option value="HDFC">HDFC</option>
                                        <option value="IFCI ">IFCI </option>
                                        <option value="BOI">BOI</option>
                                        <option value="AXB">AXB</option>
                                        <option value="IIBI">IIBI</option>
                                        <option value="UCO">UCO</option>
                                        <option value="CNB">CNB</option>
                                        <option value="CBI  ">CBI  </option>
                                        <option value="CRB">CRB</option>
                                        <option value="IOB ">IOB </option>
                                        <option value="IIB">IIB</option>
                                        <option value="PSB ">PSB </option>
                                        <option value="UOB ">UOB </option>
                                        <option value="YBL">YBL</option>
                                        <option value="ALB">ALB</option>
                                        <option value="ANB">ANB</option>
                                        <option value="BOB ">BOB </option>
                                        <option value="DNB">DNB</option>
                                        <option value="KBL">KBL</option>
                                        <option value="BDB">BDB</option>
                                        <option value="FRB">FRB</option>
                                       <!--  <?php foreach ($bank_list as $bl) { ?>
                                            <option value="<?php echo $bl->bank_code ?>"><?php echo $bl->bank_code; ?></option>
                                        <option value="CBI">CBI</option>
<?php } ?> -->
                                    </select>    
                                </div>
                                <div class="col-sm-4">
                                    <label for="email">Whether want to generate automatic receipt no. <span style="font:10px;font-weight: normal;">(Yes/No)</span></label>
                                    <select class="form-control" name="automatic_receipt" id="automatic_receipt">                                                                           
                                        <option value="YES">YES</option>  
                                        <option value="NO">NO</option>  
                                    </select>
                                </div>
                                <div class="col-sm-4" id="auto_receipt_div" style="display: none">
                                    <label for="email">Receipt No.<span style="font:10px;font-weight: normal;">(In case don't want to generate automated Receipt No.)</span></label>
                                    <input type="text"  name="receipt_no" class="form-control" style="padding:0px;padding-left:2px">
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-12">
                                    <label for="email">Remarks</label>
                                    <textarea  name="remarks" required="" class="form-control" style="padding:0px;padding-left:2px"></textarea>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" id="collectmodel" type="button">Confirm</button>                   
                </div>
            </form>
        </div>

    </div>
</div>

<div id="myEditFeeModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Fee Collection</h4>
            </div>
            <form class="form-horizontal"  method="post" id="frmeditcollectfee">
                <div class="modal-body">
                    <div class="row" style="padding-bottom:3%">
                        <!--                        <div class="col-sm-1"></div>-->
                        <div class="col-sm-4" style="text-align:right" id=""><b>Description</b></div>
                        <!--                        <div class="col-sm-3"></div>-->
                        <div class="col-sm-8" id="edit_description" style="font-weight:bold;font-family: monospace;font-size: larger;color:darkblue"></div>
                        <input type="hidden" name="tot_amount_update_hidden" id="tot_amount_update_hidden">
                        <input type="hidden" name="fee_trans_id_hidden" id="fee_trans_id_hidden">
                    </div>
                    <fieldset>
                        <legend>Other Information</legend>
                        <!--<table class="table" style="border:0px !important">-->
                        <div class="row form-group" id="row_tot_amount_update">
                            <div class="col-sm-1">1.)</div>
                            <div class="col-sm-3"><b>Total Amount</b></div>
                            <div class="col-sm-3"></div>
                            <div class="col-sm-5"><input type="number" name="tot_amount_update" id="tot_amount_update" class="form-control" style="padding:0px;padding-left:2px" value="" required></div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-1">2.)</div>
                            <div class="col-sm-3"><b>Payment Date</b></div>
                            <div class="col-sm-3"></div>
                            <div class="col-sm-5"><input type="date" name="edit_payment_date" id="edit_payment_date" class="form-control" style="padding:0px;padding-left:2px" value="<?php echo date("Y-m-d"); ?>" required></div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-1">3.)</div>
                            <div class="col-sm-3"><b>Payment Mode</b></div>
                            <div class="col-sm-3"></div>
                            <div class="col-sm-5">
                                <select class="form-control" name="edit_mode_payment" id="edit_mode_payment" required="">
                                    <option value="">Select</option>
                                    <option value="CASH">CASH</option>
                                    <option value="CHEQUE">CHEQUE</option>
                                    <option value="CHALLAN">CHALLAN</option>
                                    <option value="DRAFT">DRAFT</option>
                                    <option value="POS">POS</option>
                                    <option value="DC">Debit Card</option>
                                    <option value="CC">Credit Card</option>
                                    <option value="NB">Net Banking</option>
                                    <option value="RTGS">RTGS</option>
                                    <option value="NEFT">NEFT</option>
                                </select>                                
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-1">4.)</div>
                            <div class="col-sm-3"><b>Collection Center</b></div>
                            <div class="col-sm-3"></div>
                            <div class="col-sm-5">
                                <select class="form-control" name="edit_collection_center" id="edit_collection_center" required>
                                    <option value="">Select</option>
<?php foreach ($collection_centers as $cc) { ?>

                                        <option value="<?php echo $cc->collection_code ?>"><?php echo $cc->collection_desc; ?></option>
<?php } ?>
                                </select>                                
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-1">5.)</div>
                            <div class="col-sm-6"><b>Bank Name (in case collected in Bank)</b></div>
                            <!--<div class="col-sm-3"></div>-->
                            <div class="col-sm-5">
                                <select class="form-control" name="edit_bank_name" id="edit_bank_name">
                                    <option value="">Select</option>
<?php foreach ($bank_list as $bl) { ?>

                                        <option value="<?php echo $bl->bank_code ?>"><?php echo $bl->bank_code; ?></option>
<?php } ?>
                                </select>                                
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-1"> 6.)</div>
                            <div class="col-sm-3"><b>Remarks</b></div>
                            <div class="col-sm-3"></div>
                            <div class="col-sm-5"><textarea  name="edit_remarks" id="edit_remarks" required="" class="form-control" style="padding:0px;padding-left:2px"></textarea></div>
                        </div>                        
                        <div class="row form-group">
                            <div class="col-sm-1"> 7.)</div>
                            <div class="col-sm-6"><b>Receipt No. (If any)</b></div>
                            <!--<div class="col-sm-3"></div>-->
                            <div class="col-sm-5"><input type="text"  name="receipt_no" id="edit_receipt_no" class="form-control" style="padding:0px;padding-left:2px"></div>
                        </div>
                        <!--</table>-->
                    </fieldset>
                    <div class="row form-group" style="padding-top:3%;display:none" id="reasondiv">
                        <!--                        <div class="col-sm-1"></div>-->
                        <div class="col-sm-4" style="text-align:right" id=""><b>Reason</b></div>
                        <!--                        <div class="col-sm-3"></div>-->
                        <div class="col-sm-8" id="edit_reasondiv" style="font-weight:bold;font-family: monospace;font-size: larger;color:darkblue;"><input type="text"  name="reason" required id="edit_reason" class="form-control" style="padding:0px;padding-left:2px"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" id="updatecollectmodel" type="button">Update</button>
                    <button class="btn btn-danger" id="deletecollectmodel" type="button" style="display:none">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>    

<script>
    var admission_no = "<?php echo $admission_no ?>";
    var student_id = "<?php echo $student_id; ?>";
    var dataload = "<?php echo $dataload; ?>";

    var class_id = "<?php echo $class_id; ?>";
    var section_id = "<?php echo $section_id; ?>";
    var category_id = "<?php echo $category_id; ?>";
    var course_id = "<?php echo $course_id; ?>";
    var class_fee_head_id = "<?php echo $class_fee_head_id; ?>";
    var fine_month = "<?php echo $fine_month; ?>";
    var original_due_month = "<?php echo $original_due_month; ?>";
    var fine_amount = "<?php echo $fine_amount; ?>";
    var fee_session_year = "<?php echo $fee_session_year; ?>";

    var startfee = "<?php echo $start_fee_month; ?>";


//    $('#mdlclose,'+'#single-copy,'+'#double-copy').click(function(){
////        alert('dgfd');
//        
//    });
    $('#frmcollectfee input[type=checkbox]').change(function () {
        $('#tot_amt_th')[0].setCustomValidity("");
<?php // if($fee_type2!=4){   ?>
//                $('#half-yearlyth')[0].setCustomValidity("");
<?php // }   ?>
<?php if (count($fetch_other_fees_det_withoutmonth) > 0) { ?>
            $('#other_feeth')[0].setCustomValidity("");
<?php } ?>
    });



    $('#frmcollectfee input[type=checkbox][name^=fee_head]').change(function ()
    {
        var id = $(this).val();

//            $('#half-yearlyth')[0].setCustomValidity("");
        var isChecked = $(this).is(':checked');
        var amount = 0;
        if (id == 5)
        {
            $('#noofqtr').prop("disabled", !isChecked);

            if (fine_month != 0)
            {
                $('input[name="fee_head[' + 0 + ']"').prop("disabled", !isChecked);
                $('input[name="fee_head[' + 0 + ']"').prop('checked', true);
                var fineChecked = $('input[name="fee_head[' + 0 + ']"').is(':checked');
                $('input[name="fee_amt[' + 0 + ']"').prop("readonly", !fineChecked);

                famount = get_fine_amount(fine_month).responseText;

                $('#frmcollectfee input[name="fee_amt[' + 0 + ']"').val(famount);
                $('input[name="fee_head[' + 11 + ']"').prop("disabled", !isChecked);
                $('input[name="fee_head[' + 11 + ']"').prop('checked', true);
                var readmsnfineChecked = $('input[name="fee_head[' + 11 + ']"').is(':checked');
                $('input[name="fee_amt[' + 11 + ']"').prop("readonly", !readmsnfineChecked);
                $('#frmcollectfee input[name="fee_amt[' + 11 + ']"').val('<?php echo $readmsnfineamt?>');
            } else {
                $('input[name="fee_head[' + 0 + ']"').prop('checked', false);
                $('input[name="fee_head[' + 11 + ']"').prop('checked', false);
            }
            amount = $('#amountpaidquarterly').text();

        } else if (id == 1)
        {
            amount = $('#annamountpaid').text();
        } else if (id == 9)
        {
            amount = $('#amountpaidonetime').text();
        }else if (id == 3)
        {
            $('#otherfee_tbl input[type="checkbox"][name^=other_chk]').prop("disabled", !isChecked);

        } else if (id == 0)
        {
            var due_month = $('#frmcollectfee input[name="no_of_duemonth"]').val();
            amount = get_fine_amount(due_month).responseText;

        } else if (id == 11)
        {
//            $('input[name="fee_head[' + 11 + ']"').prop('checked', true);
            $('#frmcollectfee input[name="fee_amt[' + 11 + ']"').val('<?php echo $readmsnfineamt?>');
            amount = '<?php echo $readmsnfineamt?>';

        } else if (id == 8)
        {
            $('#instantfee_tbl input[type="checkbox"][name^=instantfee_chk]').prop("disabled", !isChecked);
        }
//        else if (id == 9)
//        {
//            amount = $('#onetime_fee').text();
//        }

        $('input[name="fee_amt[' + id + ']"').prop("readonly", !isChecked);


        if (isChecked)
        {
            if (id == 5)
            {
                $('#noofqtr').change(function ()
                {

                    var qtr_no = Number($(this).val())+1;
                    
                    var school_id = '<?php echo $this->session->userdata('school_id') ?>';
                    var paid_month =<?php echo $paid_month ?>;
                    var transfee = '<?php echo $transport_fee_amt ?>';
//                    var fee_amt = amount * Number($(this).val());
                    var fee_amt = amount ;
                    var maxmonth=qtr_no*3;
                    var minmonth=maxmonth-2;
                    
                    if(startfee>=minmonth && startfee<=maxmonth) {

                        var netqtr=fee_amt/3;
                        var nomon=(maxmonth-startfee)+1;
                        var fee_amt =Math.round((nomon)*netqtr);
                        $('#noofmonth').val(nomon);
                    }else{
                        $('#noofmonth').val(3);
                    }
                    
                    var month_no =$('#noofmonth').val();
                    
                    var mn = qtr_no;

                    $('#frmcollectfee input[name="fee_amt[5]"]').val(fee_amt);
//                    $('#frmcollectfee input[name="trans_fee_amt"]').val(mn * transfee);
                    cal_amt();


                    if (month_no <= fine_month)
                    {
                        $('#frmcollectfee input[name="no_of_duemonth"]').val(month_no);
                        $('#fine_td').text('Fine For ' + month_no + ' Months');
//                                    $("#chk_0").prop("checked", false);
//                                    $("#fee_fine").val("");
//                                    $('input[name="fee_amt['+0+']"').prop("readonly",true);
                        ffamount = get_fine_amount(month_no).responseText;

                        $('#frmcollectfee input[name="fee_amt[' + 0 + ']"').val(ffamount);
                    } else {
                        $('#frmcollectfee input[name="no_of_duemonth"]').val(fine_month);
                        $('#fine_td').text('Fine For ' + fine_month + ' Months');
                    }

                    get_halfother_amount(month_no, paid_month);

                });
            } else if (id == 4)
            {
                $('#half_head').on('change', 'input[type=checkbox]', function ()
                {

                    var count_chk = $('#half_head input[type=checkbox]:checked').length;
                    var fee_amt3 = amount * count_chk;
                    $('#frmcollectfee input[name="fee_amt[4]"]').val(fee_amt3);
                    cal_amt();
                });

            } else if (id == 3)
            {
                $('#otherfee_tbl').on('change', 'input[type=checkbox]', function ()
                {
                    var othr_amt = 0;
                    $('#otherfee_tbl input[type=checkbox]').each(function ()
                    {
                        if (this.checked)
                        {
                            othr_amt = othr_amt + Number($(this).parent().next('td').next('td').text());
                        }

                    });

                    $('#frmcollectfee input[name="fee_amt[3]"]').val(othr_amt);
                    cal_amt();
                });

            } else if (id == 8)
            {
                $('#instantfee_tbl').on('change', 'input[type=checkbox]', function ()
                {
                    var instant_amt = 0;
                    $('#instantfee_tbl input[type=checkbox]').each(function ()
                    {
                        if (this.checked)
                        {
                            instant_amt = instant_amt + Number($(this).parent().next('td').next('td').text());
                        }

                    });

                    $('#frmcollectfee input[name="fee_amt[8]"]').val(instant_amt);
                    cal_amt();
                });

            } else {
                $('#frmcollectfee input[name="fee_amt[' + id + ']"').val(amount);
            }

        } else 
        {
            if (id == 5)
            {
                $('#noofqtr').val('').trigger('change');
                $('input[name="fee_head[' + 0 + ']"').prop("checked", isChecked);
                $('input[name="fee_amt[' + 0 + ']"').val('');
            }
            get_halfother_amount((Number($('#noofqtr').val())+1)*3, '<?php echo $paid_month ?>');
            $('#frmcollectfee input[name="fee_amt[' + id + ']"]').val('');

            if (id == 4)
            {
                $('#half_chk_1').prop("checked", isChecked);
                $('#half_chk_2').prop("checked", isChecked);
            }
            if (id == 3)
            {
                $('#otherfee_tbl input[type="checkbox"][name^=other_chk]').prop("checked", isChecked);
            }
            if (id == 8)
            {
                $('#instantfee_tbl input[type="checkbox"][name^=instantfee_chk]').prop("checked", isChecked);
            }
        }

        cal_amt();

    });

    var table = $('#list1').DataTable({
        "scrollX": true,
        "scrollY": "400px",
        "scrollCollapse": true,
        "paging": false,
        "ordering": true,
        "order": [[4, "asc"]]

    });

    $('#list1 tbody').on('click', 'td', function () {
        var colIdx = table.cell(this).index().row;
//            alert(colIdx);
        $('.highlight').removeClass('highlight');
        $(table.row(colIdx).nodes()).addClass('highlight');
    });

    function cal_amt()
    {

        var tot_amt = 0;
        $('#frmcollectfee input[name^=fee_amt]').each(function ()
        {
            if (this.id == 'instant_discount')
            {
                tot_amt = tot_amt - Number($(this).val());
            } else
            {
                tot_amt = tot_amt + Number($(this).val());
            }

        });
        $('#tot_amt_th').val(tot_amt + ' INR');

    }


    function get_fine_amount(due_month)
    {

        var paidmonth = '<?php echo $paid_month; ?>';
        var wanttopay = $('#no_of_month').val();
        var checkmonth = Number(paidmonth) + Number(wanttopay);
        var fee;
        return $.ajax({
            url: '<?php echo base_url('feepayment/collection/Offline_payment_army/get_fine_amount'); ?>',
            dataType: "text",
            method: 'POST',
            async: false,
            cache: false,
            data: {fine_month_no: due_month, fee_session_year: fee_session_year, class: class_id, course: course_id, fine_month: fine_month, checkmonth: checkmonth, class_fee_head_id: class_fee_head_id, original_due_month: original_due_month},
            success: function (data) {


            }
        });
    }

    function get_halfother_amount(month_no, paid_month)
    {

        $.ajax({
            url: '<?php echo base_url('feepayment/collection/Offline_payment_army/get_halfother_amount'); ?>',
            dataType: "JSON",
            method: 'POST',
//            async: false,
//            cache: false,
            data: {month_no: month_no, fee_session_year: fee_session_year, student_id: student_id, course: course_id, paid_month: paid_month, class_fee_head_id: class_fee_head_id, category_id: category_id},
            success: function (data) {
//                $('#halffeetr').html(data.table_html);
                $('#othrowmonthly').html(data.table_html1);
                cal_amt();
            }
        });
    }


    $('#collectmodel').click(function ()
    {

        if (!$('#frmcollectfee')[0].checkValidity())
        {
            alert($(this).validationMessage);
            $(this).show();
            $('#frmcollectfee')[0].reportValidity();
            return false;
        } else {

            var r = confirm("Are you sure you want to Collect fees?");
            $('#collectmodel').val('Collecting.....');
            if (r == true)
            {
                $('#myFeeModal').modal('hide');
                var formdata = $('#frmcollectfee').serialize() + "&student_id=" + student_id + "&admission_no=" + admission_no + "&stud_cat=" + category_id + "&class_id=" + class_id + "&class_fee_head_id=" + class_fee_head_id + "&fee_session_year=" + fee_session_year + "&course_id=" + course_id+ "&startfee="+startfee;

                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('feepayment/collection/offline_payment_army/save_offln_payment_student_wise'); ?>',
                    data: formdata,
                    dataType: "json",
                    success: function (res)
                    {

                        alert(res.msg);

                        reload_page();
                        $('select').select2({width: '100%', theme: "classic"});
                        $('#single-copy').attr("href", "<?php echo base_url("feepayment/collection/Offline_payment_army/download_receipt/") ?>" + res.fee_trans_id + '/' + res.student_id);
                        $('#double-copy').attr("href", "<?php echo base_url("feepayment/collection/Payment_pdf/payment_pdf/") ?>" + res.fee_trans_id + '/' + res.student_id);
                        $('#myModalReceipt').modal('show');
//                                                    window.location.href="<?php // echo base_url("feepayment/collection/Offline_payment/download_receipt/")   ?>"+res.fee_trans_id+'/'+res.student_id;

                    },
                    error: function (req, status)
                    {
                        return false;
                    }
                });
                return true;
            } else
            {
                return false;
            }
        }



    });




    function editTransaction(me, remarks = '', mode = '', bank = '', date = '', amount = 0) {

//            $('#' + me.id).closest('tr').find("td:nth-child(1)").text();
        $('#edit_description').text($('#' + me.id).closest('tr').find("td:nth-child(1)").text());
        $('#edit_description').prev().attr('id', me.id)
        $('#edit_payment_date').val(date);
        $('#edit_mode_payment').val(mode).trigger('change');
        $('#fee_trans_id_hidden').val(me.id);
        $('#tot_amount_update').val(amount);
        $('#tot_amount_update_hidden').val(amount);
        $('#edit_collection_center').val($('#' + me.id).closest('tr').find("td:nth-child(8)").text()).trigger('change');
        $('#edit_bank_name').val(bank).trigger('change');
        $('#edit_remarks').val(remarks);
        $('#edit_receipt_no').val($('#' + me.id).closest('tr').find("td:nth-child(7)").text());
        $('#reasondiv').css('display', 'none');
        $('#edit_reason').attr('disabled', true);
//            $('#edit_reasondiv').css('display','none');
        $('#deletecollectmodel').css('display', 'none');
        $('#updatecollectmodel').css('display', '');
        $('#myEditFeeModal .modal-title').text('Update Fee Collection');
        $('#myEditFeeModal').modal('show');
//            alert($('#edit_description').prev().attr('id',));

    }
    function deleteTransaction(me, remarks = '', mode = '', bank = '', date = '', amount = 0) {

//            $('#' + me.id).closest('tr').find("td:nth-child(1)").text();
        $('#frmeditcollectfee input[type=text],' + '#frmeditcollectfee input[type=date],' + '#frmeditcollectfee select,' + '#frmeditcollectfee textarea').attr('disabled', true);
        $('#edit_description').text($('#' + me.id).closest('tr').find("td:nth-child(1)").text());
        $('#edit_description').prev().attr('id', me.id);
        $('#edit_payment_date').val(date);
        $('#edit_mode_payment').val(mode);
        $('#edit_collection_center').val($('#' + me.id).closest('tr').find("td:nth-child(8)").text());
        $('#edit_bank_name').val(bank);
        $('#edit_remarks').val(remarks);
        $('#tot_amount_update').val(amount);
        $('#tot_amount_update_hidden').val(amount);
        $('#edit_receipt_no').val($('#' + me.id).closest('tr').find("td:nth-child(7)").text());
        $('#reasondiv').css('display', '');
//            $('#edit_reasondiv').css('display','');
        $('#edit_reason').attr('disabled', false);
        $('#deletecollectmodel').css('display', '');
        $('#updatecollectmodel').css('display', 'none');
        $('#myEditFeeModal .modal-title').text('Delete Fee Collection');
        $('#myEditFeeModal').modal('show');
//            alert($('#edit_description').prev().attr('id',));

    }

    $('#updatecollectmodel').click(function ()
    {

        if (!$('#frmeditcollectfee')[0].checkValidity())
        {
//            alert($(this).validationMessage);
            $(this).show();
            $('#frmeditcollectfee')[0].reportValidity();
            return false;
        } else {

            var r = confirm("Are you sure you want to Update fees?");
            $('#updatecollectmodel').val('Updating.....');
            if (r == true)
            {
                $('#myEditFeeModal').modal('hide');
                var id = $('#edit_description').prev().attr('id');
                var formdata = $('#frmeditcollectfee').serialize() + "&feetransid=" + id;

                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('feepayment/collection/Offline_payment_army/update_offln_payment_student_wise'); ?>',
                    data: formdata,
                    success: function (res)
                    {

                        alert('Updated Successfully');
                        reload_page();
                        $('select').select2({width: '100%', theme: "classic"});
                    },
                    error: function (req, status)
                    {
                        return false;
                    }
                });
                return true;
            } else
            {
                return false;
            }
        }



    });

    $('#deletecollectmodel').click(function ()
    {

        if (!$('#frmeditcollectfee')[0].checkValidity())
        {
//            alert($(this).validationMessage);
            $(this).show();
            $('#frmeditcollectfee')[0].reportValidity();
            return false;
        } else {

            var r = confirm("Are you sure you want to Update fees?");
            $('#updatecollectmodel').val('Updating.....');
            if (r == true)
            {
                $('#myEditFeeModal').modal('hide');
                var id = $('#edit_description').prev().attr('id');
                var formdata = $('#frmeditcollectfee').serialize() + "&feetransid=" + id;

                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('feepayment/collection/Offline_payment_army/delete_offln_payment_student_wise'); ?>',
                    data: formdata,
                    success: function (res)
                    {

                        alert('Deleted Successfully');
                        reload_page();
                        $('select').select2({width: '100%', theme: "classic"});
                    },
                    error: function (req, status)
                    {
                        return false;
                    }
                });
                return true;
            } else
            {
                return false;
            }
        }



    });
    function reload_page() {

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('feepayment/collection/Offline_payment_army/load_student_fee_div'); ?>',
            data:
                    {
                        class: class_id,
                        section: section_id,
                        admsn: admission_no,
                        admsn_wise: admission_no,
                        dataload: dataload
                    },
            success: function (res1)
            {

                $('#fee_collect_div').html(res1);

            },
            error: function (req, status)
            {
                return false;
            }
        });
    }


    $('#automatic_receipt').change(function () {
        if (this.value == 'NO') {
            $('#auto_receipt_div').css('display', 'block');
        } else {
            $('#auto_receipt_div').css('display', 'none');
        }
    });

    $('#mode_payment').change(function () {
        if (this.value == 'CHEQUE') {
            $('#cheque_div').css('display', 'block');
            $('select[name="cheque_status[' + 0 + ']"').prop('required', true);
        } else
        {
            $('#cheque_div').css('display', 'none');
        }
    });


</script>