    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo base_url(''); ?>/assets/AdminLTE/plugins/iCheck/flat/blue.css">
    <link rel="stylesheet" href="<?php echo base_url(''); ?>/assets/AdminLTE/plugins/iCheck/flat/green.css">
    <link rel="stylesheet" href="<?php echo base_url(''); ?>/assets/AdminLTE/plugins/iCheck/flat/red.css">
    <style type="text/css">  

        .btn .span.glyphicon 
        {    			
            opacity: 0;				
        }
        .btn.active .span.glyphicon 
        {				
            opacity: 1;				
        }
        .fa-credit-card
        {
            content:url("<?php echo base_url('assets/img/pay_logo2.jpg'); ?>"); 
            width:60px;
            height:40px;
        }
        .has-feedback img
        {
            src:"<?php echo base_url('assets/img/pay_logo2.jpg'); ?>"; 
            width:58px;
            height:20px;
        }
        .modal img
        {
            src:"<?php echo base_url('assets/img/pay_logo2.jpg'); ?>"; 
            width:58px;
            height:20px;
        }
        .spans
        {
            font-weight: bold;
            font-size: 14px;
        }
        .btn-app
        {
            height: 42px;
            margin: 0 0 0px 10px;
        }
        tr.highlight 
        {
            background-color: #dff0d8 !important;
            border-color: #d6e9c6 !important;
            font-weight:bold !important;
            /*color:darkgreen !important;*/
        } 
        .with-border
        {
            /*        background: #d66d6c;*/
            color:#540505;
            border-bottom: 0px !important;
            padding-bottom: 2px;
            padding-top: 2px;
            font-weight:bold;
            font-size:10px
        }
        .box-title
        {
            font-style: italic;
            font-weight: bold;
            letter-spacing: 1px;
            text-shadow: 3px 2px #fbe5e5;
            line-height:2 !important;
        }
        .box
        {
            box-shadow: 3px 3px 3px 2px #ccc;;
        }
        li 
        { 
            cursor: pointer; 
        }
        .active1
        {    
            background: forestgreen;
            color: white;
        }
    </style>

    <div class="form-group has-feedback">
    <?php if ($this->session->flashdata('redirectmsg')) { ?>
        <div class="alert alert-warning" style="background-color: #f7ce8d !important;color:#980909 !important;padding: 7px;text-align:center">
            <i class="fa fa-warning"> </i> <label> <?php echo $this->session->flashdata('redirectmsg'); ?></label>
        </div>
    <?php } ?>
    <div class="panel  panel-danger" style="border-color:#d76b7d">
        <div class="panel-heading" style="padding: 5px 15px;color: white;background-color:#6e2f2f;border-color: #fc9797;" style="font-weight:bold;font-size:18px"><i class="fa fa-inr">  </i> <b> <span style="font-size:initial"> Pay Fees </span></b></div>
        <div class="panel-body">
            <div class="row" style="margin-right: -7px !important;margin-left: -7px !important;">
                <div class="col-md-4">
                    <div class="box" style="border: 1px solid darkgrey;">

                        <form class="form-horizontal" method="POST" name="mont_paym" role="form" id="mont_paym" action="<?php echo base_url("Payment_army/request"); ?>">
                            <div class="box-header with-border" style="">

                                <h3 class="box-title"><u>Quarterly Fees</u> </h3>
                            </div>
                            <div class="box-body">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                <table id="paymentlist" class="table table-bordered table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <td colspan="2">
                                                <!--<div class="row" style="margin-right: 5px !important;margin-left: 0px !important;">Select Month</div>-->
                                                <div id="monthdiv" class="row" style="margin-right: 5px !important;margin-left: 5px !important;">
                                                    <div class="col-xs-12 col-md-12" style="padding-right: 11px; padding-left:11px;">
                                                        <div id="1" class="row">    
                                                            <?php if (1 >= $student[0]->start_fee_month) { ?>
                                                                <label  class="checkbox-inline  col-xs-1" > 
                                                                    <input type="checkbox"  <?php
                                                                    if (!empty($checked_status[1])) {
                                                                        echo $checked_status[1];
                                                                    }
                                                                    ?> <?php
                                                                    if (!empty($pais_status[1])) {
                                                                        echo $pais_status[1];
                                                                    }
                                                                    ?>  name="month[]" value="1" data-qtr="<?php echo $qtrs['1']; ?>"><i class="helper"></i>Apr</label>     
                                                                       <?php } if (2 >= $student[0]->start_fee_month) { ?>
                                                                <label class="checkbox-inline col-xs-1"><input class="" type="checkbox" autocomplete="off" <?php
                                                                    if (!empty($checked_status[2])) {
                                                                        echo $checked_status[2];
                                                                    }
                                                                    ?> <?php
                                                                    if (!empty($pais_status[2])) {
                                                                        echo $pais_status[2];
                                                                    }
                                                                    ?> name="month[]" value="2" data-qtr="<?php echo $qtrs['2']; ?>">May</label>
                                                                <?php } if (3 >= $student[0]->start_fee_month) { ?>
                                                                <label class="checkbox-inline col-xs-1"><input type="checkbox" autocomplete="off" <?php
                                                                    if (!empty($checked_status[3])) {
                                                                        echo $checked_status[3];
                                                                    }
                                                                    ?> <?php
                                                                    if (!empty($pais_status[3])) {
                                                                        echo $pais_status[3];
                                                                    }
                                                                    ?> name="month[]" value="3" data-qtr="<?php echo $qtrs['3']; ?>">Jun</label>
                                                                <?php } if (4 >= $student[0]->start_fee_month) { ?>
                                                                <label class="checkbox-inline col-xs-1" ><input type="checkbox" autocomplete="off" <?php
                                                                    if (!empty($checked_status[4])) {
                                                                        echo $checked_status[4];
                                                                    }
                                                                    ?> <?php
                                                                    if (!empty($pais_status[4])) {
                                                                        echo $pais_status[4];
                                                                    }
                                                                    ?> name="month[]" value="4" data-qtr="<?php echo $qtrs['4']; ?>">Jul</label>
                                                                <?php } ?>
                                                        </div>
                                                        <div class="row">
                                                            <?php if (5 >= $student[0]->start_fee_month) { ?>
                                                                <label class="checkbox-inline col-xs-1"><input type="checkbox" autocomplete="off" <?php
                                                                    if (!empty($checked_status[5])) {
                                                                        echo $checked_status[5];
                                                                    }
                                                                    ?> <?php
                                                                    if (!empty($pais_status[5])) {
                                                                        echo $pais_status[5];
                                                                    }
                                                                    ?> name="month[]" value="5" data-qtr="<?php echo $qtrs['5']; ?>">Aug</label>
                                                                <?php } if (6 >= $student[0]->start_fee_month) { ?>
                                                                <label class="checkbox-inline col-xs-1" ><input type="checkbox" autocomplete="off" <?php
                                                                    if (!empty($checked_status[6])) {
                                                                        echo $checked_status[6];
                                                                    }
                                                                    ?> <?php
                                                                    if (!empty($pais_status[6])) {
                                                                        echo $pais_status[6];
                                                                    }
                                                                    ?> name="month[]" value="6" data-qtr="<?php echo $qtrs['6']; ?>">Sep</label>
                                                                <?php } if (7 >= $student[0]->start_fee_month) { ?>
                                                                <label  class="checkbox-inline col-xs-1"><input type="checkbox" autocomplete="off" <?php
                                                                    if (!empty($checked_status[7])) {
                                                                        echo $checked_status[7];
                                                                    }
                                                                    ?> <?php
                                                                    if (!empty($pais_status[7])) {
                                                                        echo $pais_status[7];
                                                                    }
                                                                    ?> name="month[]" value="7" data-qtr="<?php echo $qtrs['7']; ?>">Oct</label>
                                                                <?php } if (8 >= $student[0]->start_fee_month) { ?>
                                                                <label class="checkbox-inline col-xs-1"><input type="checkbox" autocomplete="off" <?php
                                                                    if (!empty($checked_status[8])) {
                                                                        echo $checked_status[8];
                                                                    }
                                                                    ?> <?php
                                                                    if (!empty($pais_status[8])) {
                                                                        echo $pais_status[8];
                                                                    }
                                                                    ?> name="month[]" value="8" data-qtr="<?php echo $qtrs['8']; ?>">Nov</label>
                                                                <?php } ?>
                                                        </div>

                                                        <div id="2" class="row">    
                                                            <?php if (9 >= $student[0]->start_fee_month) { ?>
                                                                <label class="checkbox-inline col-xs-1 col-md-1"><input type="checkbox" autocomplete="off"  <?php
                                                                    if (!empty($checked_status[9])) {
                                                                        echo $checked_status[9];
                                                                    }
                                                                    ?> <?php
                                                                    if (!empty($pais_status[9])) {
                                                                        echo $pais_status[9];
                                                                    }
                                                                    ?> name="month[]" value="9" data-qtr="<?php echo $qtrs['9']; ?>">Dec</label>

                                                            <?php } if (10 >= $student[0]->start_fee_month) { ?>
                                                                <label class="checkbox-inline col-xs-1 col-md-1"><input type="checkbox" autocomplete="off"  <?php
                                                                    if (!empty($checked_status[10])) {
                                                                        echo $checked_status[10];
                                                                    }
                                                                    ?> <?php
                                                                    if (!empty($pais_status[10])) {
                                                                        echo $pais_status[10];
                                                                    }
                                                                    ?> name="month[]" value="10" data-qtr="<?php echo $qtrs['10']; ?>">Jan</label>
                                                                <?php } if (11 >= $student[0]->start_fee_month) { ?>
                                                                <label class="checkbox-inline col-xs-1 col-md-1"><input type="checkbox" autocomplete="off"  <?php
                                                                    if (!empty($checked_status[11])) {
                                                                        echo $checked_status[11];
                                                                    }
                                                                    ?> <?php
                                                                    if (!empty($pais_status[11])) {
                                                                        echo $pais_status[11];
                                                                    }
                                                                    ?> name="month[]" value="11" data-qtr="<?php echo $qtrs['11']; ?>">Feb</label>
                                                                <?php } if (12 >= $student[0]->start_fee_month) { ?>
                                                                <label class="checkbox-inline col-xs-1 col-md-1"><input type="checkbox" autocomplete="off" <?php
                                                                    if (!empty($checked_status[12])) {
                                                                        echo $checked_status[12];
                                                                    }
                                                                    ?> <?php
                                                                    if (!empty($pais_status[12])) {
                                                                        echo $pais_status[12];
                                                                    }
                                                                    ?> name="month[]" value="12" data-qtr="<?php echo $qtrs['12']; ?>">Mar</label>
                                                                <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <!--<td><label id="fees_amount"></label></td>-->
                                        </tr>
                                        <tr>                 
                                            <th>Fee Name</th>
                                            <th>Amount</th>     
                                        </tr>
                                    </thead>
                                    <tbody id="get_month_fee_det">     
                                        <tr>
                                            <td></td>
                                            <td>
                                                <input type="hidden" name="actual_fine_due_month" value="<?php echo $due_month ?>">    
                                                <input type="hidden" name="fine_due_month" value="<?php echo $fineacmonth ?>">
                                            </td>
                                        </tr>
                                        <?php
                                        $total = 0;
                                        $total1 = 0;

                                        foreach ($quarterly_fee->result() as $row) 
                                        {

                                            if ($start_fee_month != 1 && in_array($qtrs[$start_fee_month - 1], $qtrpaid)) 
                                            {
                                                $subtractqtr = round(($row->fee_amount / $qtrsetcount[$qtrs[$start_fee_month - 1]]) * ($start_fee_month - 1));
                                            } 
                                            else 
                                            {
                                                $subtractqtr = 0;
                                            }

                                            $total = $total + (($row->fee_amount * count($qtrpaid)) - $subtractqtr);
                                            ?>             
                                            <tr>                 
                                                <td style="white-space: nowrap"><?php echo $row->fee_name; ?></td>
                                                <td style="white-space: nowrap"><?php echo ($row->fee_amount * count($qtrpaid)) - $subtractqtr; ?> </td>              
                                            </tr>
                                        <?php 
                                        } 

                                        if (count($fetch_instant_fees_det) > 0) 
                                        {
                                            foreach ($fetch_instant_fees_det as $instfee) {
//                                            $total = $total + $transport_fee_amt * $count;
                                                $total = $total + $instfee->amount;
                                                ?>
                                                <tr>                 
                                                    <td><?php echo $instfee->fee_desc . " (Instant Fee)"; ?></td>
                                                    <!--<td><input type="text" readonly="true" style="border: 0px;width: 100%;background:inherit" name="trans_fee_amt" value="<?php // echo $transport_fee_amt * $count;       ?>"></td>-->              
                                                    <td><input type="text" readonly="true" style="border: 0px;width: 100%;background:inherit" name="instantfee_chk[<?php echo $instfee->id ?>][<?php echo $instfee->fee_id; ?>]" value="<?php echo $instfee->amount; ?>"></td>              
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>    
                                                
                                        <?php
                                        if ($fine_apply_status == 1 && $fine_amount != 0) 
                                        {
                                            $total = $total + $fine_amount;
                                            ?>
                                            <tr>                 
                                                <!--<td>Fine (for <?php // echo $due_month;    ?> Month)</td>-->
                                                <td>Fine Amount
                                                    
                                                </td>

                                                <td><input type="text" readonly="true" style="border: 0px;width: 100%;background:inherit" name="fine_amt" value="<?php echo $fine_amount; ?>"></td>              
                                            </tr>
                                        <?php
                                        } 
                                        ?>

                                        <?php
                                        $bm = date('m');
                                        if ($bm >= 1 && $bm <= 3) {
                                            $bm = $bm + 12;
                                        }
                                        if (count($annual_fee_paid->result()) == 0 && $school[0]->annual_month != 0 && ($bm - 3) >= $school[0]->annual_month) {
                                            $total_annual_f = 0;
                                            $total_annual_rf = 0;
                                            foreach ($annual_fee->result() as $obj) {
                                                $total_annual_f = $total_annual_f + $obj->fee_amount;
                                                if ($obj->fee_type == 'REFUND') {
                                                    $total_annual_rf = $total_annual_rf + $obj->fee_amount;
                                                }
                                            }
                                            if ($total_annual_f != 0) {
                                                $total_refunded=0;
                                                if ($start_fee_month != 1) {
                                                    $refunded = $total_annual_rf / 12;
                                                    $total_refunded = $refunded * ($start_fee_month - 1);
                                                    $total_annual_f = $total_annual_f - $total_refunded;
                                                }
                                                $total = $total + $total_annual_f;
                                                ?>
                                                <tr>                 
                                                    <td>Annual Fee (as this is the last month for Annual)</td>
                                                    <td>
                                                        <input type="hidden" readonly="true" style="border: 0px;width: 100%;background:inherit" name="annual_total_refunded" value="<?php echo $total_refunded; ?>">
                                                        <input type="text" readonly="true" style="border: 0px;width: 100%;background:inherit" name="annual_last_fee_amt" value="<?php echo $total_annual_f; ?>">
                                                    </td>              
                                                </tr>

                                                <?php
                                            }
                                        }
                                        ?> 
                                        <?php

                                        if (count($onetime_fee_paid->result()) == 0 && $student[0]->student_type!='EXISTING') {
                                            $total_onetime = 0;
                                            $total_onet = 0;
                                            $total_refundt = 0;
                                            foreach ($onetime_fee->result() as $obj) {
                                                $total_onetime = $total_onetime + $obj->fee_amount;
                                                if ($obj->fee_cat == 9) {
                                                    $total_onet = $total_onet + $obj->fee_amount;
                                                }
                                                if ($obj->fee_cat == 10) {
                                                    $total_refundt = $total_refundt + $obj->fee_amount;
                                                }
                                            }
                                            if ($total_onetime != 0) {
                                                $total = $total + $total_onetime;
                                                
                                                ?>
                                                <tr>                 
                                                    <td>OneTime Fee</td>
                                                    <td>
                                                        <input type="text" readonly="true" style="border: 0px;width: 100%;background:inherit" name="onetime_fee_amt" value="<?php echo $total_onetime; ?>">
                                                        <input type="hidden" name="categorylist[1]" value="<?php echo $total_onet; ?>">
                                                        <input type="hidden" name="categorylist[2]" value="<?php echo $total_refundt; ?>">
                                                    </td>              
                                                </tr>

                                                <?php
                                            }
                                        }
                                        ?> 
                                        <?php
                                        foreach ($oth_fee_id as $ofeeid => $ovalue) {
                                            $total = $total + $oth_fee_amount[$ofeeid];
                                            ?>
                                            <tr>                 
                                                <td><?php echo $ovalue; ?></td>
                                                <td>
                                                    <input type="text" readonly="true" style="border: 0px;width: 100%;background:inherit" name="oth_fee[<?= $ofeeid; ?>]" value="<?php echo $oth_fee_amount[$ofeeid]; ?>">
                                                </td>              
                                            </tr>
                                        <?php } ?>     

                                    </tbody>
                                    <tfoot id="get_month_fee_detfoot">
                                        <tr  style="font-size: 17px;font-weight: bold;">                 
                                            <td>Total</td>
                                            <td><input type="text" readonly="true" style="border: 0px;width: 100%;background:inherit" name="total_m" id="total_m" value="<?php echo $total; ?>"></td>              
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <?php
                                if (date('Y-m-d') <= $academic_session[0]->end_date) {

                                    if ($academic_session[0]->fin_year == $student[0]->student_academicyear_id) {


                                        if ($disable_trans == 1) 
                                        {
                                            ?>
                                            <span class="spans" style="color:red;text-align: left !important">You Have Crossed the Payment Due Date of this Month !<br></span>
                                            <span class="spans" style="font-weight:normal;color:red;"> (Payment will be Active from <?php echo $start_pay_date; ?>) </span>

                                            <?php
                                        } 
                                        else 
                                        {
                                            if ($school[0]->stop_transaction == 'NO') 
                                            {
                                                ?>
                                                <b>TOTAL UNPAID AMOUNT: </b>               
                                                <input type="hidden" value="<?php echo $total; ?>" name="total_val" id="total_val">
                                                <?php // if ($total > 0) {    ?>
                                                <button class="btn btn-app" id="total" name="total" type="button" style="padding: 0px;">
                                                    <img src="<?php echo base_url('assets/img/pay_logo2.jpg'); ?>"><br>
                                                    <span class="spans" id="tot_val"><?php echo $total; ?> INR</span>
                                                </button> 
                                                <?php // } else {    ?>
                                                <!--                                        <b><?php // echo $total;     ?> INR</b>-->
                                                <?php
// }
                                            } else {
                                                ?>
                                                <!--<span class="span" style="color:red;text-align: left !important">Sorry for the inconvenience. Transaction has been blocked for a Limited Days !<br></span>-->
                                                <span class="spans" style="color:red;text-align: left !important">Sorry for the inconvenience. System is Under Upgradation !<br></span>
                                                <?php
                                            }
                                        }
                                    } 
                                    else 
                                    {
                                        ?>
                                        <span class="spans" style="color:red;text-align: left !important">Sorry! Your Data is not Updated yet for Current Session. Please Contact your School Administrator !<br></span>
                                        <?php
                                    }
                                } 
                                else 
                                {
                                    ?>

                                    <span class="spans" style="color:red;text-align: left !important">Sorry! Your Payment For <?= $academic_session[0]->session; ?> Session Has Been Closed. Please Contact your School Administrator !<br></span>

                            <?php 
                                } 
                            ?>
                            </div>
                        </form>
                    </div>
                </div>

                <?php // } ?>
                <?php 
                    if ($fee_type2 == 4) 
                    {
                        if ($school[0]->onetime == 'YES' && $student[0]->student_type!='EXISTING') 
                        { 
                            $classcol='col-md-4';
                        }
                        else
                        {
                            $classcol='col-md-8';
                        }
                    ?>
                    <!-- <div class="<?php echo $classcol;?>">
                        <div class="box" style="border: 1px solid darkgrey;">
                            <form class="form-horizontal" method="POST" role="form" id="anual_paym" action="<?php echo base_url("payment_army/request") ?>">
                                <div class="box-header with-border" style="">
                                    <h3 class="box-title"><u>Annual Fees</u></h3>
                                </div>
                                <div class="box-body">
                                    <div class="table-responsive" >

                                        <table id="ann_paymentlist" class="table table-bordered table-striped" style="width:100%">
                                            <thead>
                                                <tr>                 
                                                    <th>Fee Name</th>
                                                    <th>Fee Amount</th>     
                                                </tr>
                                            </thead>
                                            <tbody id="get_annual_fee_det"> 
                                                <?php
                                                $total_annual = 0;
                                                $total_refundannual = 0;
                                                $rest_month = (12-$start_fee_month)+1;

                                                foreach ($annual_fee->result() as $obj) 
                                                {
                                                	$fee_amount = $obj->fee_amount;
                        							$fee_id     = $obj->fee_id;
                        							if($fee_id==10 || $fee_id==16)
							                        {
							                            $fee = $fee_amount;
							                        }                
							                        else
							                        {
							                            $fee = ($fee_amount/12)*$rest_month;
							                        }

                                                    $total_annual = $total_annual + $fee;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $obj->fee_name; ?></td>
                                                        <td> <?php echo $fee;?> </td>

                                                    </tr>
                                                <?php 
                                            	} 
                                            	?>

                                            </tbody>
                                            <tfoot>
                                                <tr  style="font-weight: bold;">                 
                                                    <td style="font-size: 17px;">Total</td>
                                                    <td ><input type="text" readonly="true" style="border: 0px;width: 100%;font-size: 16px;" name="total_y1" value="<?php echo $total_annual; ?>"></td>              
                                                </tr>
                                                <?php if (count($annual_fee_paid->result()) != 0) { ?>
                                                    <tr>

                                                        <td colspan="2" style="background: lightgreen;
                                                            color: darkgreen;
                                                            font-size: 20px;
                                                            font-weight: bold;text-align: center;padding: 0px;">PAID</td>
                                                    </tr>    
                                                <?php } ?>     
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <?php 
                                if (count($annual_fee_paid->result()) == 0) 
                                { 
                                ?>
                                <div class="modal-footer">
                                    <?php
                                    if (date('Y-m-d') <= $academic_session[0]->end_date) 
                                    {
                                        if ($academic_session[0]->fin_year == $student[0]->student_academicyear_id) 
                                        {
                                            if ($disable_trans == 1) 
                                            { 
                                            ?>                                  
                                                <span class="spans" style="color:red;">You Have Crossed the Payment Due Date of this Month !<br></span>
                                                <span class="spans" style="font-weight:normal;color:red;"> (Payment will be Active from <?php echo $start_pay_date; ?>) </span>

                                            <?php 
                                        	} 
                                            else 
                                            { 
                                            ?>
                                                <b>TOTAL UNPAID AMOUNT: </b> 
                                                <?php
                                                if ($total_annual > 0) {
                                                    if ($school[0]->stop_transaction == 'NO') 
                                                    {
                                                        ?>
                                                        <input type="hidden" value="<?php echo $total_annual; ?>" name="total_ann_val" id="total_ann_val">
                                                        <button class="btn btn-app" id="total_annual" name="total_annual" type="button" style="padding:0px">
                                                            <img src="<?php echo base_url('assets/img/pay_logo2.jpg'); ?>"><br>
                                                            <span class="spans" id="tot_val"><?php echo $total_annual; ?> INR</span>
                                                        </button>
                                                    <?php } else { ?>
                                                        <span class="spans" style="color:red;text-align: left !important">Sorry for the inconvenience. System is under Upgradation !<br></span>
                                                        <?php
                                                    }
                                                } else {
                                                    ?> 
                                                    <b><?php echo $total_annual; ?> INR</b>

                                                    <?php
                                                }
                                            }
                                        } 
                                        else 
                                        { 
                                        ?>
                                            <span class="spans" style="color:red;text-align: left !important">Sorry! Your Data is not Updated yet for Current Session. Please Contact your School Administrator !<br></span>

                                        <?php
                                        }
                                    } 
                                    else 
                                    {
                                    ?>
                                        <span class="spans" style="color:red;text-align: left !important">Sorry! Your Payment For <?= $academic_session[0]->session; ?> Session Has Been Clossed. Please Contact your School Administrator !<br></span>
                                    <?php 
                                	} 
                                	?>
                                </div>
                            	<?php 
                            	} 
                            	?>
                            </form>
                        </div>
                    </div> -->


                <?php }
                ?>
                
                <?php if ($school[0]->onetime == 'YES' && $student[0]->student_type!='EXISTING') { ?>
                    <!--onetime fee start-->

                    <!-- <div class="col-md-4">
                        <div class="box" style="border: 1px solid darkgrey;">
                            <form class="form-horizontal" method="POST" role="form" id="onetime_paym" action="<?php echo base_url("payment_army/request") ?>">
                                <div class="box-header with-border" style="">
                                    <h3 class="box-title"><u>Onetime Fees</u></h3>
                                </div>
                                <div class="box-body">
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                    <table id="one_paymentlist" class="table table-bordered table-striped" style="width:100%">
                                        <thead>
                                            <tr>                 
                                                <th>Fee Name</th>
                                                <th>Fee Amount</th>     
                                            </tr>
                                        </thead>

                                        <tbody id="get_onetime_fee_det"> 
                                            <?php
                                            $total_onetime = 0;
                                            $total_onet = 0;
                                            $total_refundt = 0;
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

    
                                        </tbody>
                                        <tfoot>
                                            <tr  style="font-size: 17px;font-weight: bold;">                 
                                                    <td>Total </td>
                                                    <td><input type="text" readonly="true" style="border: 0px;width: 100%;" name="total_o" value="<?php echo $total_onetime; ?>">
                                                        <input type="hidden" name="categorylist[1]" value="<?php echo $total_onet; ?>">
                                                        <input type="hidden" name="categorylist[2]" value="<?php echo $total_refundt; ?>">
                                                    </td>         

                                            </tr>
                                        <?php if (count($onetime_fee_paid->result()) != 0) { ?> 
                                            <tr>
                                                <td colspan="2" style="background: lightgreen;color: darkgreen;font-size: 20px;font-weight: bold;text-align: center;padding: 0px;">PAID</td>
                                            </tr>    

                                        <?php } ?> 
                                        </tfoot>
                                    </table>
                                </div>
                                <?php if (count($onetime_fee_paid->result()) == 0) { ?>
                                    <div class="modal-footer">
                                        <?php
                                        if (date('Y-m-d') <= $academic_session[0]->end_date) {
                                            if ($academic_session[0]->fin_year == $student[0]->student_academicyear_id) {
                                                ?>

                                                <?php if ($disable_trans == 1) { ?>                                  
                                                    <span class="spans" style="color:red;">You Have Crossed the Payment Due Date of this Month !<br></span>
                                                    <span class="spans" style="font-weight:normal;color:red;"> (Payment will be Active from <?php echo $start_pay_date; ?>) </span>

                                                <?php } else { ?>
                                                    <b>TOTAL UNPAID AMOUNT: </b> 
                                                    <?php
                                                    if ($total_onetime > 0) {
                                                        if ($school[0]->stop_transaction == 'NO') {
                                                            ?>
                                                            <input type="hidden" value="<?php echo $total_onetime; ?>" name="total_one_val" id="total_one_val">
                                                            <button class="btn btn-app" id="total_onetime" name="total_onetime" type="button" style="padding:0px">
                                                                <img src="<?php echo base_url('assets/img/pay_logo2.jpg'); ?>"><br>
                                                                <span class="spans" id="tot_val"><?php echo $total_onetime; ?> INR</span>
                                                            </button>
                                                        <?php } else { ?>
                                                            <span class="spans" style="color:red;text-align: left !important">Sorry for the inconvenience. System is under Upgradation !<br></span>
                                                            <?php
                                                        }
                                                    } else {
                                                        ?> 
                                                        <b><?php echo $total_onetime; ?> INR</b>

                                                        <?php
                                                    }
                                                }
                                                ?>

                                            <?php } else { ?>
                                                <span class="spans" style="color:red;text-align: left !important">Sorry! Your Data is not Updated yet for Current Session. Please Contact your School Administrator !<br></span>

                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <span class="spans" style="color:red;text-align: left !important">Sorry! Your Payment For <?= $academic_session[0]->session; ?> Session Has Been Clossed. Please Contact your School Administrator !<br></span>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </form>
                        </div>
                    </div> -->




                    <!--onetime fee end-->

                <?php } ?>
            </div>
            <div class="row" style="margin-right: -7px !important;margin-left: -7px !important;">
                <div class="col-md-4">
                    <div class="box" style="border: 1px solid darkgrey;">
                        <form class="form-horizontal" method="POST" role="form" id="other_paym" action="<?php echo base_url("payment_army/request") ?>">
                            <div class="box-header with-border" style="">
                                <h3 class="box-title"><u>Other/Additional Fees</u></h3>
                            </div>
                            <div class="box-body" style="width:100%">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                <table id="other_fee" class="table table-bordered table-striped" style="width:100%">
                                    <thead>
                                        <tr>  
                                            <th></th>
                                            <th>Fee Name</th>
                                            <th>Fee Amount</th>     
                                        </tr>
                                    </thead> 
                                    <tbody>
                                        <?php
                                        $total_other = 0;
                                        foreach ($other_fee->result() as $obj_fee) {
                                            $total_other = $total_other + $obj_fee->fee_amount;
                                            ?>
                                            <tr> 
                                                <td><input type="checkbox" name="other[]" value="<?php echo $obj_fee->fee_id; ?>"></td>
                                                <td><?php echo $obj_fee->fee_name; ?></td>
                                                <td><input type="text" readonly="true" style="border: 0px;background: inherit;width: 100%;" name="other_amt[<?php echo $obj_fee->fee_id; ?>]" id="other_amt_<?php echo $obj_fee->fee_id; ?>" value="<?php echo $obj_fee->fee_amount; ?>"></td>     
                                            </tr>
                                        <?php } ?>
                                        <tr  style="font-size: 17px;font-weight: bold;"> 
                                            <td></td>
                                            <td>Total</td>
                                            <td><input type="text" readonly="true" style="border: 0px;width: 100%;background: inherit" name="total_other" id="total_other" value="<?php // echo $total_other;       ?>"></td>              
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                            
                            <div class="box-body">
                                <table class="table table-bordered table-striped" >
                                    <tr>
                                        <td></td>
                                        <?php
                                        if (date('Y-m-d') <= $academic_session[0]->end_date) {

                                            if ($academic_session[0]->fin_year == $student[0]->student_academicyear_id) {
                                                if ($disable_trans == 1) {
                                                    ?>
                                                    <td colspan="2">
                                                        <span  class="spans" style="color:red;text-align: left !important">You Have Crossed the Payment Due Date of this Month !<br></span>
                                                        <span class="spans" style="font-weight:normal;color:red;"> (Payment will be Active from <?php echo $start_pay_date; ?>) </span>
                                                    </td>
                                                    <?php
                                                } else {
                                                    if ($school[0]->stop_transaction == 'NO') {
                                                        ?>

                                                        <td style="text-align:right;">
                                                            <button class="btn btn-app" id="total_other2" name="total_other2" type="button" style="padding:0px">
                                                                <img src="<?php echo base_url('assets/img/pay_logo2.jpg'); ?>"><br>
                                                                <span class="spans" id="tot_other">000 INR</span>
                                                            </button>                                                                                                                                                                                     
                                                        </td> 
                                                    <?php } else { ?>
                                                        <!--<span class="span" style="color:red;text-align: left !important">Sorry for the inconvenience. Transaction has been blocked for a Limited Days !<br></span>-->
                                                    <span class="spans" style="color:red;text-align: left !important">Sorry for the inconvenience. System is Under Upgradation !<br></span>
                                                    <?php
                                                }
                                            }
                                        } else {
                                            ?>
                                            <span class="spans" style="color:red;text-align: left !important">Sorry! Your Data is not Updated yet for Current Session. Please Contact your School Administrator !<br></span>
                                            <?php
                                        }
                                    } else {
                                        ?>

                                        <span class="spans" style="color:red;text-align: left !important">Sorry! Your Payment For <?= $academic_session[0]->session; ?> Session Has Been Clossed. Please Contact your School Administrator !<br></span>

                                    <?php } ?>
                                    </tr>
                                </table>  
                            </div>
                        </form>
                    </div>
                </div>



                <!--instant fee div -->
                <div class="col-md-8">
                    <div class="box" style="border: 1px solid darkgrey;">
                        <form class="form-horizontal" method="POST" role="form" id="instant_paym" action="<?php echo base_url("payment_army/request") ?>">
                            <div class="box-header with-border" style="">
                                <h3 class="box-title"><u>Instant Fees</u></h3>
                            </div>
                            <div class="box-body" style="width:100%">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                <table id="instant_fee" class="table table-bordered table-striped" style="width:100%">
                                    <thead>
                                        <tr>  
                                            <th></th>
                                            <th>Fee Name</th>
                                            <th>Fee Amount</th>     
                                        </tr>
                                    </thead> 
                                    <tbody>
                                        <?php
                                        if (count($fetch_instant_fees_det) > 0) {
                                            $total_instant = 0;

                                            foreach ($fetch_instant_fees_det as $instfee) {
                                                $total_instant = $total_instant + $instfee->amount;
                                                ?>
                                                <tr> 
                                                    <td><input type="checkbox" name="instant[]" value="<?php echo $instfee->id; ?>"></td>
                                                    <td><?php echo $instfee->fee_desc; ?></td>
                                                    <td><input type="text" readonly="true" style="border: 0px;width: 100%;background:inherit" name="instant_amt[<?php echo $instfee->id ?>]" id="instant_amt_<?php echo $instfee->id; ?>" value="<?php echo $instfee->amount; ?>"></td>              
                                                    <td><input type="hidden" name="instant_feeid[<?php echo $instfee->id ?>]" id="instant_feeid_<?php echo $instfee->id; ?>" value="<?php echo $instfee->fee_id; ?>"></td>              
                                                </tr>
                                            <?php } ?>
                                            <tr  style="font-size: 17px;font-weight: bold;"> 
                                                <td></td>
                                                <td>Total</td>
                                                <td><input type="text" readonly="true" style="border: 0px;width: 100%;background: inherit" name="total_instant" id="total_instant" value="<?php // echo $total_other;        ?>"></td>              
                                            </tr>


                                        <?php } else { ?>
                                            <tr>
                                                <td colspan="3" style="text-align:center">

                                                    <span  class="spans" style="color:rgb(85, 33, 134);text-align: center !important">No Instant Fee Allocated in your account !<br></span>
                                                </td>
                                            </tr>                
                                        <?php } ?>
                                    </tbody>
                                </table>

                            </div>
                            <?php if (count($fetch_instant_fees_det) > 0) { ?>      

                                <div class="box-body">
                                    <table class="table table-bordered table-striped" >

                                        <tr>


                                            <td></td>
                                            <?php
                                            if (date('Y-m-d') <= $academic_session[0]->end_date) {

                                                if ($academic_session[0]->fin_year == $student[0]->student_academicyear_id) {
                                                    if ($disable_trans == 1) {
                                                        ?>
                                                        <td colspan="2">
                                                            <span  class="spans" style="color:red;text-align: left !important">You Have Crossed the Payment Due Date of this Month !<br></span>
                                                            <span class="spans" style="font-weight:normal;color:red;"> (Payment will be Active from <?php echo $start_pay_date; ?>) </span>
                                                        </td>
                                                        <?php
                                                    } else {
                                                        if ($school[0]->stop_transaction == 'NO') {
                                                            ?>

                                                            <td style="text-align:right;">
                                                                <button class="btn btn-app" id="total_instant2" name="total_instant2" type="button" style="padding:0px">
                                                                    <img src="<?php echo base_url('assets/img/pay_logo2.jpg'); ?>"><br>
                                                                    <span class="spans" id="tot_instant">000 INR</span>
                                                                </button>                                                                                                                                                                                     
                                                            </td> 
                                                        <?php } else { ?>
                                                            <!--<span class="span" style="color:red;text-align: left !important">Sorry for the inconvenience. Transaction has been blocked for a Limited Days !<br></span>-->
                                                        <span class="spans" style="color:red;text-align: left !important">Sorry for the inconvenience. System is Under Upgradation !<br></span>
                                                        <?php
                                                    }
                                                }
                                            } else {
                                                ?>
                                                <span class="spans" style="color:red;text-align: left !important">Sorry! Your Data is not Updated yet for Current Session. Please Contact your School Administrator !<br></span>
                                                <?php
                                            }
                                        } else {
                                            ?>

                                            <span class="spans" style="color:red;text-align: left !important">Sorry! Your Payment For <?= $academic_session[0]->session; ?> Session Has Been Clossed. Please Contact your School Administrator !<br></span>

                                        <?php } ?>
                                        </tr>
                                    </table>  
                                </div>
                            <?php } ?>
                        </form>
                    </div>
                </div>

                <!--instant fee div end -->


            </div>
        </div>
    </div>
    <div class="box">
        <div class="box-body" >

            <div class="panel  panel-success">
                <div class="panel-heading" style="padding: 5px 15px;background-color: #c7eab9"><i class="glyphicon glyphicon-time">  </i> <b> <span style="color:black"> Transaction History</span></b></div>
                <div class="panel-body" style="padding:0px">

                    <div class="table-responsive">
                        <table id="list1" class="table table-bordered table-striped" style="width:100%">
                            <thead style="border-bottom: 1px solid black !important">
                                <tr>
                                    <th>Payment date</th>
                                    <th>Description</th>
                                    <th>Total Amount</th>

                                    <th>Remarks</th>
                                    <th>Receipt No</th>
                                    <th>Payment Id</th>

                                    <th>Status</th>
                                    <th>E-receipt</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total_paid = 0;
                                $month = array(1 => "April", 2 => "May", 3 => "June", 4 => "July", 5 => "August", 6 => "September", 7 => "October", 8 => "Novemeber", 9 => "December", 10 => "January", 11 => "February", 12 => "March");
                                $cnt = 0;
                                foreach ($transaction_history->result() as $payment) {
                                    $cnt++;

                                    if ($payment->paid_status != 0) {
                                        $total_paid = $total_paid + $payment->total_amount;
                                    }

                                    $fe_desc = explode(',', $payment->fee);
                                    $str = '';
                                    foreach ($fe_desc as $index => $value) {
                                        if ($value == 2 || $value == 5) {
                                            if ($payment->m > 1) {

                                                $month_var = $payment->from_month + $payment->m - 1;
                                                $str .= $payment->m . " Months Fees (" . $month[$payment->from_month] . " to " . $month[$month_var] . "),";
                                            } else {
                                                $str .= $payment->m . " Month Fees (" . $month[$payment->from_month] . "),";
                                            }
                                        } else if ($value == 1) {
                                            $str .= ' Annual Fees,';
                                        } else if ($value == 9) {
                                            $str .= ' Onetime Fees,';
                                        } else if ($value == 3) {
                                            $str .= ' Other/Additional Fees,';
                                        } else if ($value == 8) {
                                            $str .= ' Instant/Misc. Fees,';
                                        } else if ($value == 4) {
                                            $str .= ' Half-Yearly Fees,';
                                        } else if ($value == 6) {
                                            $str .= ' Transport Fees,';
                                        } else if ($value == 0) {
                                            if ($payment->d > 1) {
                                                $str .= ' ' . $payment->d . ' Months Fine';
                                            } else {
                                                $str .= ' ' . $payment->d . ' Month Fine';
                                            }
                                        } else if ($value == 7) {
                                            $str .= ' Instant Discount,';
                                            $discount = $row->discount_amount;
                                        }
                                    }
                                    $str = rtrim($str, ',');
                                    ?>
                                    <tr <?php if ($payment->response_code == '0' && $payment->paid_status == 1) { ?> title="Click to get E-receipt" onclick="get_pdfdet(<?php echo $payment->id ?>);" style="color:darkgreen" <?php } else { ?> style="color:red" <?php } ?>>
                                        <td><?php echo date('Y-m-d', strtotime($payment->payment_date)); ?></td>
                                        <td><?php echo $str; ?></td>
                                        <td><?php echo $payment->total_amount . ' INR'; ?></td>
                                        <td><?php echo $payment->remarks . ' (' . $payment->response_message . ')'; ?></td>
                                        <td><?php echo $payment->receipt_no; ?></td>
                                        <td><?php echo $payment->payment_id; ?></td>

                                        <td><?php
                                            if ($payment->chargeback_status && $payment->paid_status == 0) {
                                                echo 'You Have Done ChargeBack (UNPAID)';
                                            } else if ($payment->paid_status == 0) {
                                                echo 'UNPAID';
                                            } else {
                                                echo 'PAID';
                                            }
                                            ?></td>
                                        <td><?php if ($payment->response_code == '0' && $payment->paid_status == 1) { ?>   <a href="#" title="Click to get E-receipt"  onclick="get_pdfdet(<?php echo $payment->id ?>);" class="form-contrrol">Download</a> <?php } ?></td>
                                    </tr>     
                                <?php }
                                ?>
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="modal-footer">
                    <b>TOTAL PAID AMOUNT : <?php echo $total_paid; ?> INR</b>
                </div>
            </div>
        </div>
    </div>
</div>

<!----------------------------payment with extra charges (these model to show receipt Plz Dont remove these !!!!!!)------------------------------>
<div class="modal fade" id="transaction_det" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="monthly_pay">

        </div>
    </div>
</div>
<div class="modal fade" id="transaction_det1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="monthly_pay1">

        </div>
    </div>
</div>
<!-------------------------------------------------------------------------------------------------------------------------------->


<!-----------------------------------------------Monthly  fee popup--------------------------------------------------------------->
<div class="modal fade" id="modal_trans_charges" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="monthly_fee_popup" method="POST" role="form" action="<?php echo base_url("payment_army/request"); ?>">
                <div class="modal-header" style="background: lightgoldenrodyellow;border-bottom: 1px solid gainsboro;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="spans" aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Total amount</h4>
                </div>
                <div class="modal-body" style="background:oldlace">
                    <div class="box-body edit_form">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <table class="table table-responsive">
                                    <tr>
                                        <th>Name : <label  id="name_m" style="font-weight:normal;color: darkred;"></label></th>
                                        <th>Class : <label  id="class_m" style="font-weight:normal;color: darkred;"><span class="spans" id="class"></span><span class="spans" id="sec"></span></label></th>
                                        <th>Category : <label  id="category_m" style="font-weight:normal;color: darkred;"><span class="spans" id="class"></span><span class="spans" id="sec"></span></label></th>
                                    </tr>
                                    <tr>
                                        <th colspan="3" style="text-align:center">Total Fee : <label  id="total_fee" style="font-weight:normal;color: darkred;"></label></th>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="form-group" style="margin-top:10px;padding-bottom: 10px;border-top:1px solid lightgrey;border-bottom:1px solid lightgrey ">
                            <div class="col-sm-12">
                                <table class="table">
                                    <thead><tr><th style="text-align:center;color:crimson">Important Instructions While Doing Online Payment</th></tr></thead>
                                    <tbody>
                                        <tr>
                                            <td style="color:midnightblue;font-family: sans-serif">
                                                <i class="fa fa-check-square-o" aria-hidden="true" style="color:blueviolet"> </i> 
                                                Do not Press <b>Refresh,Back or Close</b> tabs or browser arrow while transaction is going on.
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="color:midnightblue;font-family: sans-serif">
                                                <i class="fa fa-check-square-o" aria-hidden="true" style="color:blueviolet"> </i> 
                                                Please wait till page redirects back to <b>Feesclub</b> after transaction..
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="color:midnightblue;font-family: sans-serif">
                                                <i class="fa fa-check-square-o" aria-hidden="true" style="color:blueviolet"> </i> 
                                                In case of network glitch, slow down or failure or session timeout during the payment or transaction,
                                                please check whether your bank account has been debited or not before initiating the second payment 
                                                and accordingly resort to one of the following options:

                                                <ul>
                                                    <li>In case the Bank Account appears to be debited , please do not try to do payment twice .
                                                        and immediately thereafter contact us  to confirm payment.In Case Payment is not received by school , then the bank  will credit amount back to concerned account within 8 to 10 working days</li>
                                                    <li>In case , the Bank Account is not debited, You can initiate a fresh transaction to make payment.</li>
                                                </ul>
                                            </td></tr>
                                        <tr>
                                            <td style="color:midnightblue;font-family: sans-serif">
                                                <i class="fa fa-check-square-o" aria-hidden="true" style="color:blueviolet"></i> 
                                                If there is no payment acknowledgement with payment receipt after Payment Confirmation from Payment Gateway ,Please contact us on our Watsapp No.
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:center">

                                                <u><i class="fa fa-file-text" style="color:red" aria-hidden="true"></i><a style="color:red;font-weight:600;" href="javascript:winPop('https://crm.feesclub.com/Download/Terms-and-Conditions-Worldline-PG.pdf','640','580')">Online Payment Terms and Conditions &nbsp (Click to read...) </a></u>

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer" style="background:oldlace">
                    <button class="btn btn-app" id="total1" name="total1" type="submit" form="mont_paym" style="padding:0px;">
                        <img src="<?php echo base_url('assets/img/pay_logo2.jpg'); ?>"><br>
                        <span class="spans" id="tot_val1"></span>
                    </button>                          
                </div>
            </form>
        </div>
    </div>
</div>
<!------------------------------------------------------------------------------------------------------------------------------------->



<!------------------------------------------------Yearly fee popup--------------------------------------------------------------------------->
<div class="modal fade" id="modal_trans_charges2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="" method="POST" role="form" action="<?php echo base_url("payment_army/request"); ?>">
                <div class="modal-header" style="background: lightgoldenrodyellow;border-bottom: 1px solid gainsboro;">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="spans" aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Total amount</h4>
                </div>
                <div class="modal-body" style="background:oldlace">
                    <div class="box-body edit_form">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <table class="table table-responsive">
                                    <tr>
                                        <th>Name : <label  id="name_a" style="font-weight:normal;color: darkred;"></label></th>

                                        <th>Class : <label  id="class_a" style="font-weight:normal;color: darkred;"><span class="spans" id="class"></span><span class="spans" id="sec"></span></label></th>

                                        <th>Category : <label  id="category_a" style="font-weight:normal;color: darkred;"><span class="spans" id="class"></span><span class="spans" id="sec"></span></label></th>



                                    </tr>
                                    <tr>
                                        <th colspan="3" style="text-align:center">Total Fee : <label  id="total_fee1" style="font-weight:normal;color: darkred;"></label></th>

                                    </tr>

                                </table>
                            </div>
                        </div>

                        <div class="form-group" style="margin-top:10px;padding-bottom: 10px;border-top:1px solid lightgrey;border-bottom:1px solid lightgrey ">
                            <div class="col-sm-12">
                                <table class="table">
                                    <thead><tr><th style="text-align:center;color:crimson">Important Instructions While Doing Online Payment</th></tr></thead>
                                    <tbody>
                                        <tr>
                                            <td style="color:midnightblue;font-family: sans-serif">
                                                <i class="fa fa-check-square-o" aria-hidden="true" style="color:blueviolet"> </i> 
                                                Do not Press <b>Refresh,Back or Close</b> tabs or browser arrow while transaction is going on.
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="color:midnightblue;font-family: sans-serif">
                                                <i class="fa fa-check-square-o" aria-hidden="true" style="color:blueviolet"> </i> 
                                                Please wait till page redirects back to <b>Feesclub</b> after transaction..
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="color:midnightblue;font-family: sans-serif">
                                                <i class="fa fa-check-square-o" aria-hidden="true" style="color:blueviolet"> </i> 
                                                In case of network glitch, slow down or failure or session timeout during the payment or transaction,
                                                please check whether your bank account has been debited or not before initiating the second payment 
                                                and accordingly resort to one of the following options:

                                                <ul>
                                                    <li>In case the Bank Account appears to be debited , please do not try to do payment twice .
                                                        and immediately thereafter contact us  to confirm payment.In Case Payment is not received by school , then the bank  will credit amount back to concerned account within 8 to 10 working days</li>
                                                    <li>In case , the Bank Account is not debited, You can initiate a fresh transaction to make payment.</li>
                                                </ul>
                                            </td></tr>
                                        <tr>
                                            <td style="color:midnightblue;font-family: sans-serif">
                                                <i class="fa fa-check-square-o" aria-hidden="true" style="color:blueviolet"></i> 
                                                If there is no payment acknowledgement with payment receipt after Payment Confirmation from Payment Gateway ,Please contact us on our Watsapp No.
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:center">

                                                <u><i class="fa fa-file-text" style="color:red" aria-hidden="true"></i><a style="color:red;font-weight:600;" href="javascript:winPop('https://crm.feesclub.com/Download/Terms-and-Conditions-Worldline-PG.pdf','640','580')">Online Payment Terms and Conditions &nbsp (Click to read...) </a></u>

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer" style="background:oldlace">                
                    <button class="btn btn-app" id="total2" name="total2" type="submit" form="anual_paym" style="padding: 0px">
                        <img src="<?php echo base_url('assets/img/pay_logo2.jpg'); ?>"><br>
                        <span class="spans" id="tot_val2"></span>
                    </button>                          
                </div>
            </form>
        </div>
    </div>
</div>
<!---------------------------------------------------------------------------------------------------------------------------------------------------->


<!-- iCheck -->
<!--<script src="<?php // echo base_url('');  ?>/assets/AdminLTE/plugins/iCheck/icheck.min.js"></script>-->
<!-------------------------------------------------------------------------------------------------------------------------------------->
<script>
    var mon_total =<?php echo $total; ?>;
    var startfee = "<?php echo $start_fee_month; ?>";
    var stud_id = '<?php echo $student_id; ?>';
    var fineacmonth = '<?php echo $fineacmonth; ?>';

    function get_pdfdet(trans_id)
    {

        $('#monthly_pay1').load('<?php echo base_url('payment_army/btn_download_pop_load'); ?>' + '/' + 'dwld_no', {trans_id: trans_id});
        $("#transaction_det1").modal('show');
    }

//*** ---------------------     Download link  ------------------  ***//
    function get_det(stud_id, month_no, month_desc, status, year, e)
    {
//        $(this).closest('tr').siblings(":first").text();
        var x = $(e).parent().siblings(":first").text();
        var sem;
        if (x.indexOf("SEM-1") >= 0)
        {
            sem = 'SEM-1';
        } else
        {
            sem = 'SEM-2';
        }
//        alert(status);
        var fee_cat_id;
        if (status == 'mon')
        {
            fee_cat_id = 2;
//            $('#monthly_pay').load('<?php // echo base_url('student/mon_pop_load');         ?>', {stud_id: stud_id, month_id: month_id,fee_cat:fee_cat_id});
//            $("#transaction_det").modal('show');
            $('#monthly_pay1').load('<?php echo base_url('payment_army/btn_download_pop_load'); ?>', {stud_id: stud_id, month_no: month_no, month_desc: month_desc, year: year, fee_cat: fee_cat_id, sem_name: sem});
            $("#transaction_det1").modal('show');
        } else if (status == 'year')
        {
            fee_cat_id = 1;
            $('#monthly_pay1').load('<?php echo base_url('payment_army/btn_download_pop_load'); ?>', {stud_id: stud_id, month_no: 0, month_desc: month_desc, year: year, fee_cat: fee_cat_id, sem_name: sem});
            $("#transaction_det1").modal('show');
        } else if (status == 'half')
        {
            fee_cat_id = 4;
            $('#monthly_pay1').load('<?php echo base_url('payment_army/btn_download_pop_load'); ?>', {stud_id: stud_id, month_no: 0, month_desc: month_desc, year: year, fee_cat: fee_cat_id, sem_name: sem});
            $("#transaction_det1").modal('show');
        } else
        {

        }

    }


    $(document).ready(function ()
    {

//                $('input[type="checkbox"]').iCheck({
//                    checkboxClass: 'icheckbox_flat-red',
//                    radioClass: 'iradio_flat-red',
//                    increaseArea: '0.5%' // optional
//                }); 


        var tableann = $('#ann_paymentlist').DataTable({
//                "destroy":true,
            "scrollX": true,
            "scrollY": "258px",
            "scrollCollapse": true,
            "paging": false,
            "searching": false,
            "ordering": false,
            "info": false
        });
        var tablequar = $('#paymentlist').DataTable({
            "scrollX": true,
            "scrollY": "174px",
            "scrollCollapse": true,
            "paging": false,
            "searching": false,
            "ordering": false,
            "info": false
        });


        var table = $('#list1').DataTable({
            "scrollX": true,
            "scrollY": "300px",
            "scrollCollapse": true,
            "paging": false,
            "order": [[0, "desc"]]
        });

        $('#list1 tbody').on('click', 'td', function () {
            var colIdx = table.cell(this).index().row;
//            alert(colIdx);
            $('.highlight').removeClass('highlight');
            $(table.row(colIdx).nodes()).addClass('highlight');
        });
        
        var tableone = $('#one_paymentlist').DataTable({
            "scrollX": true,
            "scrollY": "268px",
            "scrollCollapse": true,
            "paging": false,
            "searching": false,
            "ordering": false,
            "info": false
        });



        var count = (startfee - 1);

        $('#paymentlist input[type=checkbox]').each(function ()
        {
            if (this.checked)
            {

                count++;
//                    alert(count);
            }
        });



        for (var st = (count + 2); st <= 12; st++)
        {
            $("#paymentlist :checkbox[value=" + st + "]").prop('disabled', 'true');
        }





        $('#mont_paym input[type=checkbox]').change(function ()
        {
            var month_id = [];
            var qtr_id = [];
            var next_mon, cur_mon;
            var k = 0;
            cur_mon = $(this).val();
            var qtrset = $(this).attr('data-qtr');
            next_mon = Number(qtrset) + 1;


            if (this.checked) {

                $("#mont_paym :checkbox[data-qtr=" + qtrset + "]").filter(function () {
                    return Number(this.value) >= startfee;
                }).prop('checked', true);

            } else {
                $("#mont_paym :checkbox[data-qtr=" + qtrset + "]").filter(function () {
                    return Number(this.value) >= startfee;
                }).prop('checked', false);

            }
            $("#mont_paym :checkbox[data-qtr=" + qtrset + "]").filter(function () {
                return Number(this.value) >= startfee;
            }).removeAttr('disabled');
//$("#mont_paym :checkbox[data-qtr=" + qtrset + "]").removeAttr('disabled');

            if (!$("#mont_paym :checkbox[data-qtr=" + next_mon + "]").prop("checked"))
            {

                if (this.checked) {
                    $("#mont_paym :checkbox[data-qtr=" + next_mon + "]").removeAttr('disabled');

                } else {
                    $("#mont_paym :checkbox[data-qtr=" + next_mon + "]").prop('disabled', 'true');
                }

            } else
            {
                var qtrset = "<?php echo count($qtrset); ?>";
                for (var c = Number(next_mon); c < (Number(qtrset)); c++) {

                    $("#mont_paym :checkbox[data-qtr=" + c + "]").prop('checked', false);
                    $("#mont_paym :checkbox[data-qtr=" + c + "]").prop('disabled', 'true');

                }

            }


            $('#mont_paym input[type=checkbox]:checked').each(function ()
            {
                if(!$(this).is('[disabled]')) 
                {
                    month_id[k] = (this.value);
                
                    qtr_id[k] = $(this).attr('data-qtr');
                
                    k++;
                    console.log('hi ');
                }

            });

            $('#mont_paym #total').attr('disabled', true);
            get_stud_qtr_fee(qtr_id, month_id);


        });

        /*------------  To show the Monthly pop up on pay button clic --------*/
        $("#total").click(function ()
        {
            var total1 = $("#total_val").val();
            var $checkboxes = $('#paymentlist td input[type="checkbox"]');
            //var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
            
            var countCheckedCheckboxes = $checkboxes.filter(function () {
                return this.checked && !this.disabled;
            }).length;
            
            //$('input[type="checkbox"]').filter(function() {
            //return this.checked && !this.disabled;
            //}).length;

            //$("#TransactionCharge").text(countCheckedCheckboxes*5);
            
            $("#name_m").text('<?php echo html_escape($student[0]->name);?>');
            $("#class_m").text('<?php echo html_escape($student[0]->class_name);?>'+'--'+'<?php echo html_escape($student[0]->sec_name);?>');
            $("#category_m").text('<?php echo html_escape($student[0]->cat_name); ?>');

            //$("#TransactionCharge").text(5);
            $("#total_fee").text(total1);
            $("#total_amt").text(Number(total1));
            $("#tot_val1").text((Number(total1)) + ' INR');
            $('#total1').attr('form', 'mont_paym');
            $("#modal_trans_charges").modal('show');

        });






        /*------------  To show the Annual pop up on pay button clic --------*/
        $("#total_annual").click(function ()
        {
//     alert('hello');
            var total1 = $("#total_ann_val").val();

            $("#modal_trans_charges2").modal('show');
//     alert($("#class").val());
            $("#name_a").text($("#name").val());
            $("#class_a").text('<?php echo html_escape($student[0]->class_name); ?>' + '--' + '<?php echo html_escape($student[0]->sec_name); ?>');
            $("#category_a").text('<?php echo html_escape($student[0]->cat_name); ?>');


            $("#TransactionCharge1").text(5);
            $("#total_fee1").text(total1);
            $("#total_amt1").text(Number(total1));
            $("#tot_val2").text((Number(total1)) + ' INR');

        });


//    -------------------------------------------------------------------------------------------

//     ------------------------------------------------------------------------------------------------------------------   

        $('#other_fee input[type=checkbox]').change(function ()
        {
            var sum_other = 0;
            $('#other_fee input[type=checkbox]:checked').each(function ()
            {
                var ido = $(this).val();
//                                 alert($('#other_amt_'+ido).val()); 
                sum_other = sum_other + Number($('#other_amt_' + ido).val());

            });
//                            alert(sum_other);
            $('#total_other').val(sum_other);
            $('#tot_other').text(sum_other + ' INR');
        });

        $("#total_other2").click(function ()
        {
//     
            var totalother = $("#total_other").val();

            $('#total1').attr('form', 'other_paym');
            $('#total1').attr('name', 'total4');
            $('#total1').attr('id', 'total4');
            $("#name_m").text($("#name").val());
            $("#class_m").text('<?php echo html_escape($student[0]->class_name); ?>' + '--' + '<?php echo html_escape($student[0]->sec_name); ?>');
            $("#category_m").text('<?php echo html_escape($student[0]->cat_name); ?>');

//                                $("#TransactionCharge").text(5);
            $("#total_fee").text(totalother);
            $("#total_amt").text(Number(totalother));
            $("#tot_val1").text((Number(totalother)) + ' INR');

            $("#modal_trans_charges").modal('show');

        });

//instant fee div//
        $('#instant_fee input[type=checkbox]').change(function ()
        {
            var sum_other = 0;
            $('#instant_fee input[type=checkbox]:checked').each(function ()
            {
                var ido = $(this).val();
//                                 alert($('#instant_amt_'+ido).val()); 
                sum_other = sum_other + Number($('#instant_amt_' + ido).val());

            });
//                            alert(sum_other);
            $('#total_instant').val(sum_other);
            $('#tot_instant').text(sum_other + ' INR');
        });

        $("#total_instant2").click(function ()
        {
//     
            var totalinstant = $("#total_instant").val();

            $('#total1').attr('form', 'instant_paym');
            $('#total1').attr('name', 'total5');
            $('#total1').attr('id', 'total5');
            $("#name_m").text($("#name").val());
            $("#class_m").text('<?php echo html_escape($student[0]->class_name); ?>' + '--' + '<?php echo html_escape($student[0]->sec_name); ?>');
            $("#category_m").text('<?php echo html_escape($student[0]->cat_name); ?>');

//                                $("#TransactionCharge").text(5);
            $("#total_fee").text(totalinstant);
            $("#total_amt").text(Number(totalinstant));
            $("#tot_val1").text((Number(totalinstant)) + ' INR');

            $("#modal_trans_charges").modal('show');

        });



        $("#total_onetime").click(function ()
        {
//     
            var totalother = $("#total_one_val").val();

            $('#total1').attr('form', 'onetime_paym');
            $('#total1').attr('name', 'total6');
            $('#total1').attr('id', 'total6');
            $("#name_m").text($("#name").val());
            $("#class_m").text('<?php echo html_escape($student[0]->class_name); ?>' + '--' + '<?php echo html_escape($student[0]->sec_name); ?>');
            $("#category_m").text('<?php echo html_escape($student[0]->cat_name); ?>');

//                                $("#TransactionCharge").text(5);
            $("#total_fee").text(totalother);
            $("#total_amt").text(Number(totalother));
            $("#tot_val1").text((Number(totalother)) + ' INR');

            $("#modal_trans_charges").modal('show');

        });

        function get_stud_qtr_fee(qtr_id = [], month_id = [])
        {
            $('#mont_paym #total').attr('disabled', true);
            var fee;
            var actualfine = $('input[name="actual_fine_due_month"]').val();
            $.ajax({
                url: '<?php echo base_url('payment_army/get_student_fee'); ?>',
                method: 'POST',
                data: {stud_id: stud_id, month_id: month_id, actualfine: actualfine, qtr_id: qtr_id},
                dataType: "text",
                success: function (data) {
                    console.log(data);
                    var x = data.split("|");
                    $("#mont_paym #tot_val").text(x[1] + ' INR');
                    $("#get_month_fee_det").html(x[0]);
                    $("#get_month_fee_detfoot").html('');

                    $("#total_m").val(x[1]);

                    $("#total_val").val(x[1]);
//                    $('#mont_paym #total').attr('disabled',true);
                    $('#mont_paym #total').attr('disabled', false);

                }
            });
        }

    });
    function winPop(url, w, h)
    {
        winDef = "toolbar=0,location=0,status=0, menubar=0,scrollbars=yes,resizable=0,width=" + w + ",height=" + h;
        window.open(url, "_blank", winDef);
    }

</script>        
