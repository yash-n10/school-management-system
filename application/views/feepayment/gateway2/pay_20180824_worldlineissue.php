<style type="text/css">
    /*    .helper {
    position: absolute;
    top: -4px;
    left: -4px;
    cursor: pointer;
    display: block;
    font-size: 16px;
    user-select: none;
    color: #e7e7e7;
    }
    .helper:before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    margin: 4px;
    width: 22px;
    height: 22px;
    transition: transform 0.28s ease;
    border-radius: 3px;
    border: 2px solid #7bbe72;
    }
    .helper:after {
    content: '';
    display: block;
    width: 10px;
    height: 5px;
    border-bottom: 2px solid #7bbe72;
    border-left: 2px solid #7bbe72;
    -webkit-transform: rotate(-45deg) scale(0);
    -moz-transform: rotate(-45deg) scale(0);
    -ms-transform: rotate(-45deg) scale(0);
    transform: rotate(-45deg) scale(0);
    position: absolute;
    top: 12px;
    left: 10px;
    }
    input[type="checkbox"]:checked ~ .helper::before {
    color: #7bbe72;
    }
    
    input[type="checkbox"]:checked ~ .helper::after {
    -webkit-transform: rotate(-45deg) scale(1);
    -moz-transform: rotate(-45deg) scale(1);
    -ms-transform: rotate(-45deg) scale(1);
    transform: rotate(-45deg) scale(1);
    }*/

    .btn .span.glyphicon {    			
        opacity: 0;				
    }
    .btn.active .span.glyphicon {				
        opacity: 1;				
    }
    .fa-credit-card
    {
        content:url("<?php echo base_url('assets/img/pay_logo2.jpg'); ?>"); 
        width:60px;
        height:40px;
    }
    img
    {
        src:"<?php echo base_url('assets/img/pay_logo2.jpg'); ?>"; 
        width:58px;
        height:20px;
    }
    .span{
        font-weight: bold;
        font-size: 14px;
    }
    .btn-app
    {
        height: 42px;
        margin: 0 0 0px 10px;
    }
    tr.highlight {
        background-color: #dff0d8 !important;
        border-color: #d6e9c6 !important;
        font-weight:bold !important;
        /*color:darkgreen !important;*/
    } 
    .with-border{
        background: #ff8080;
        color:white;
        border-bottom: 1px solid gainsboro;
        padding-bottom: 2px;
        padding-top: 2px;
        font-weight:bold;
        font-size:10px
    }
    .box{
        box-shadow: 3px 3px 3px 2px #ccc;;
    }
    li { cursor: pointer; }
    .active1{    background: forestgreen;
                 color: white;}
    </style>
    <div class="form-group has-feedback">
        <?php if($this->session->flashdata('redirectmsg')) {?>
        <div class="alert alert-warning" style="background-color: #f7ce8d !important;color:#980909 !important;padding: 7px;text-align:center">
            <i class="fa fa-warning"> </i> <label> <?php echo $this->session->flashdata('redirectmsg');?></label>
        </div>
        <?php }?>
    <div class="panel  panel-danger">
        
        <div class="panel-heading" style="padding: 5px 15px;color: white;background-color: #ff6666;border-color: #fc9797;" style="font-weight:bold;font-size:18px"><i class="fa fa-inr">  </i> <b> <span style=""> Pay Fees</span></b></div>
        <div class="panel-body">
            <!--<div class="row" style="padding-top:5px;">-->
            <?php if ($fee_type1 == 1) {
                ?>
                <div class="col-md-5">
                    <div class="box" style="border: 1px solid darkgrey;">

                        <form class="form-horizontal" method="POST" name="mont_paym" role="form" id="mont_paym" action="<?php echo base_url("Payment/request"); ?>">
                            <div class="box-header with-border" style="">
                            <!--<h3 class="box-title">Monthly Payment Details <?php // if (count($monthly_fee_paid) == 0) {   ?> [UNPAID]  <?php // }   ?></h3>-->
                                <h3 class="box-title">Monthly Fee </h3>
                            </div>
                            <div class="box-body">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                <table id="paymentlist" class="table table-bordered table-striped">
                                    <thead>


                                        <tr>
                                            <td colspan="2">
                                                <!--<div class="row" style="margin-right: 5px !important;margin-left: 0px !important;">Select Month</div>-->
                                                <div id="monthdiv" class="row" style="margin-right: 5px !important;margin-left: 5px !important;">
                                                    <div class="col-xs-12 col-md-12" style="padding-right: 11px; padding-left:11px;">

                                                        <div id="1" class="row">                                   
                                                            <label  class="checkbox-inline  col-xs-1" > 
                                                                <input type="checkbox"  <?php
                                                                if (!empty($checked_status[1])) {
                                                                    echo $checked_status[1];
                                                                }
                                                                ?> <?php
                                                                if (!empty($pais_status[1])) {
                                                                    echo $pais_status[1];
                                                                }
                                                                ?>  name="month[]" value="1" ><i class="helper"></i>Apr</label>                      
                                                            <label class="checkbox-inline col-xs-1"><input class="" type="checkbox" autocomplete="off" <?php
                                                                if (!empty($checked_status[2])) {
                                                                    echo $checked_status[2];
                                                                }
                                                                ?> <?php
                                                                if (!empty($pais_status[2])) {
                                                                    echo $pais_status[2];
                                                                }
                                                                ?> name="month[]" value="2">May</label>
                                                            <label class="checkbox-inline col-xs-1"><input type="checkbox" autocomplete="off" <?php
                                                                if (!empty($checked_status[3])) {
                                                                    echo $checked_status[3];
                                                                }
                                                                ?> <?php
                                                                if (!empty($pais_status[3])) {
                                                                    echo $pais_status[3];
                                                                }
                                                                ?> name="month[]" value="3">Jun</label>

                                                            <label class="checkbox-inline col-xs-1" ><input type="checkbox" autocomplete="off" <?php
                                                                if (!empty($checked_status[4])) {
                                                                    echo $checked_status[4];
                                                                }
                                                                ?> <?php
                                                                if (!empty($pais_status[4])) {
                                                                    echo $pais_status[4];
                                                                }
                                                                ?> name="month[]" value="4">Jul</label>
                                                        </div>
                                                        <div class="row">
                                                            <label class="checkbox-inline col-xs-1"><input type="checkbox" autocomplete="off" <?php
                                                                if (!empty($checked_status[5])) {
                                                                    echo $checked_status[5];
                                                                }
                                                                ?> <?php
                                                                if (!empty($pais_status[5])) {
                                                                    echo $pais_status[5];
                                                                }
                                                                ?> name="month[]" value="5">Aug</label>
                                                            <label class="checkbox-inline col-xs-1"><input type="checkbox" autocomplete="off" <?php
                                                                if (!empty($checked_status[6])) {
                                                                    echo $checked_status[6];
                                                                }
                                                                ?> <?php
                                                                if (!empty($pais_status[6])) {
                                                                    echo $pais_status[6];
                                                                }
                                                                ?> name="month[]" value="6">Sep</label>

                                                            <label  class="checkbox-inline col-xs-1"><input type="checkbox" autocomplete="off" <?php
                                                                if (!empty($checked_status[7])) {
                                                                    echo $checked_status[7];
                                                                }
                                                                ?> <?php
                                                                if (!empty($pais_status[7])) {
                                                                    echo $pais_status[7];
                                                                }
                                                                ?> name="month[]" value="7">Oct</label>
                                                            <label class="checkbox-inline col-xs-1"><input type="checkbox" autocomplete="off" <?php
                                                                if (!empty($checked_status[8])) {
                                                                    echo $checked_status[8];
                                                                }
                                                                ?> <?php
                                                                if (!empty($pais_status[8])) {
                                                                    echo $pais_status[8];
                                                                }
                                                                ?> name="month[]" value="8">Nov</label>
                                                        </div>

                                                        <div id="2" class="row">    

                                                            <label class="checkbox-inline col-xs-1 col-md-1"><input type="checkbox" autocomplete="off"  <?php
                                                                if (!empty($checked_status[9])) {
                                                                    echo $checked_status[9];
                                                                }
                                                                ?> <?php
                                                                if (!empty($pais_status[9])) {
                                                                    echo $pais_status[9];
                                                                }
                                                                ?> name="month[]" value="9">Dec</label>


                                                            <label class="checkbox-inline col-xs-1 col-md-1"><input type="checkbox" autocomplete="off"  <?php
                                                                if (!empty($checked_status[10])) {
                                                                    echo $checked_status[10];
                                                                }
                                                                ?> <?php
                                                                if (!empty($pais_status[10])) {
                                                                    echo $pais_status[10];
                                                                }
                                                                ?> name="month[]" value="10">Jan</label>
                                                            <label class="checkbox-inline col-xs-1 col-md-1"><input type="checkbox" autocomplete="off"  <?php
                                                                if (!empty($checked_status[11])) {
                                                                    echo $checked_status[11];
                                                                }
                                                                ?> <?php
                                                                if (!empty($pais_status[11])) {
                                                                    echo $pais_status[11];
                                                                }
                                                                ?> name="month[]" value="11">Feb</label>
                                                            <label class="checkbox-inline col-xs-1 col-md-1"><input type="checkbox" autocomplete="off" <?php
                                                                if (!empty($checked_status[12])) {
                                                                    echo $checked_status[12];
                                                                }
                                                                ?> <?php
                                                                if (!empty($pais_status[12])) {
                                                                    echo $pais_status[12];
                                                                }
                                                                ?> name="month[]" value="12">Mar</label>
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
                                        <?php
                                        $total = 0;
                                        $total1 = 0;

                                        foreach ($monthly_fee->result() as $row) {
                                            $total = $total + $row->fee_amount * $count;
                                            ?>             
                                            <tr>                 
                                                <td style="white-space: nowrap"><?php echo $row->fee_name; ?></td>
                                                <td style="white-space: nowrap"><?php echo $row->fee_amount * $count; ?> </td>              
                                            </tr>
                                        <?php } ?>  
                                        <?php
                                        if ($transport_fee_amt != 0) {
//                                            $total = $total + $transport_fee_amt * $count;
                                            $total = $total + $transport_fee_amt;
                                            ?>
                                            <tr>                 
                                                <td>Transport Fee</td>
                                                <!--<td><input type="text" readonly="true" style="border: 0px;width: 100%;background:inherit" name="trans_fee_amt" value="<?php // echo $transport_fee_amt * $count; ?>"></td>-->              
                                                <td><input type="text" readonly="true" style="border: 0px;width: 100%;background:inherit" name="trans_fee_amt" value="<?php echo $transport_fee_amt; ?>"></td>              
                                            </tr>
                                        <?php } ?>
                                        <input type="hidden" name="actual_fine_due_month" value="<?php echo $due_month ?>">    
                                        <?php
                                        if ($fine_apply_status == 1 && $fine_amount != 0) {
                                            $total = $total + $fine_amount;
                                            ?>
                                            <tr>                 
                                                <td>Fine (for <?php echo $due_month; ?> Month)</td>
                                        
                                        <input type="hidden" name="fine_due_month" value="<?php echo $due_month ?>">
                                        <td><input type="text" readonly="true" style="border: 0px;width: 100%;background:inherit" name="fine_amt" value="<?php echo $fine_amount; ?>"></td>              
                                        </tr>
                                    <?php } ?>
                                        
                                       <?php 
                                       $bm=date('m');
                                        if ($bm >= 1 && $bm <= 3) {
                                             $bm = $bm + 12;
                                         } 
                                       if (count($annual_fee_paid->result()) == 0 && $school[0]->annual_month!=0 && ($bm-3)>=$school[0]->annual_month) {
                                            $total_annual_f = 0;
                                            foreach ($annual_fee->result() as $obj) {
                                                $total_annual_f = $total_annual_f + $obj->fee_amount;
                                            }
                                            $total = $total + $total_annual_f;
                                            ?>
                                             <tr>                 
                                                <td>Annual Fee (as this is the last month for Annual)</td>
                                                <td>
                                                    <input type="text" readonly="true" style="border: 0px;width: 100%;background:inherit" name="annual_last_fee_amt" value="<?php echo $total_annual_f; ?>">
                                                </td>              
                                             </tr>
                                        
                                        
                                        <?php } ?> 
                                    <tr  style="font-size: 17px;font-weight: bold;">                 
                                        <td>Total</td>
                                        <td><input type="text" readonly="true" style="border: 0px;width: 100%;background:inherit" name="total_m" value="<?php echo $total; ?>"></td>              
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <?php if(date('Y-m-d')<=$academic_session[0]->end_date) { 
                                    
                                
                                    if($academic_session[0]->fin_year==$student[0]->student_academicyear_id) { 
                                        
                                    
                                    if ($disable_trans == 1) { ?>
                                    <span class="span" style="color:red;text-align: left !important">You Have Crossed the Payment Due Date of this Month !<br></span>
                                    <span class="span" style="font-weight:normal;color:red;"> (Payment will be Active from <?php echo $start_pay_date; ?>) </span>

                                <?php
                                } else {
                                    if ($school[0]->stop_transaction == 'NO') {
                                        ?>
                                        <b>TOTAL UNPAID AMOUNT: </b>               
                                        <input type="hidden" value="<?php echo $total; ?>" name="total_val" id="total_val">
            <?php // if ($total > 0) {  ?>
                                        <button class="btn btn-app" id="total" name="total" type="button" style="padding: 0px;">
                                            <img src="<?php echo base_url('assets/img/pay_logo2.jpg'); ?>"><br>

                                            <span class="span" id="tot_val"><?php echo $total; ?> INR</span>
                                        </button> 
                                        <?php // } else {   ?>
                                        <!--                                        <b><?php // echo $total;  ?> INR</b>-->
                                        <?php // }
                                    } else {
                                        ?>
                                        <span class="span" style="color:red;text-align: left !important">Sorry for the inconvenience. Transaction has been blocked for a Limited Days !<br></span>
                                        <?php }
                                    }
                                }else {
                                    ?>
                                        <span class="span" style="color:red;text-align: left !important">Sorry! Your Data is not Updated yet for Current Session. Please Contact your School Administrator !<br></span>
                                <?php } 
                                }else{ ?>
                                        
                                        <span class="span" style="color:red;text-align: left !important">Sorry! Your Payment For <?=$academic_session[0]->session; ?> Session Has Been Clossed. Please Contact your School Administrator !<br></span>
                                        
                                <?php }?>
                            </div>
                        </form>
                    </div>
                </div>
<?php } ?> 
<?php if ($fee_type2 == 4) {
    ?>
                <div class="col-md-4">
                    <div class="box" style="border: 1px solid darkgrey;">
                        <form class="form-horizontal" method="POST" role="form" id="anual_paym" action="<?php echo base_url("payment/request") ?>">
                            <div class="box-header with-border" style="">
                                <h3 class="box-title">Annual Fee<?php // if (count($annual_fee_paid) == 0) { ?>   <?php // } ?></h3>
                            </div>
                            <div class="box-body">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                <table id="ann_paymentlist" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>                 
                                            <th>Fee Name</th>
                                            <th>Fee Amount</th>     
                                        </tr>
                                    </thead>
                                        <?php if (count($annual_fee_paid->result()) == 0) { ?>       <!--------------------------for unpaid---------------->                                                      
                                        <tbody id="get_annual_fee_det"> 
                                            <?php
                                            $total_annual = 0;
                                            foreach ($annual_fee->result() as $obj) {
                                                $total_annual = $total_annual + $obj->fee_amount;
                                                ?>
                                                <tr>
                                                    <td><?php echo $obj->fee_name; ?></td>
                                                    <td><?php echo $obj->fee_amount; ?></td>

                                                </tr>
                                        <?php } ?>
                                            <tr  style="font-size: 17px;font-weight: bold;">                 
                                                <td>Total</td>
                                                <td><input type="text" readonly="true" style="border: 0px;width: 100%;" name="total_y1" value="<?php echo $total_annual; ?>"></td>              
                                            </tr>
                                            <!--------------------------for Paid----------------> 
                                            <?php
                                        } else {
                                            $total_annual = 0;
                                            foreach ($annual_fee->result() as $obj) {
                                                $total_annual = $total_annual + $obj->fee_amount;
                                                ?>
                                                <tr>                 
                                                    <td><?php echo $obj->fee_name; ?></td>
                                                    <td><?php echo $obj->fee_amount; ?></td>    
                                                </tr>
                                            <?php } ?>
                                            <tr  style="font-size: 17px;font-weight: bold;">                 
                                                <td>Total</td>
                                                <td><?php echo $total_annual; ?></td>              
                                            </tr>
                                            <tr><td colspan="2" style="background: lightgreen;
                                                    color: darkgreen;
                                                    font-size: 20px;
                                                    font-weight: bold;text-align: center;padding: 0px;">PAID</td></tr>    


                                        <?php } ?>     
                                    </tbody>
                                </table>
                            </div>
                            <?php if (count($annual_fee_paid->result()) == 0) { ?>
                            <div class="modal-footer">
                                  <?php  if(date('Y-m-d')<=$academic_session[0]->end_date) {
                                        if($academic_session[0]->fin_year==$student[0]->student_academicyear_id) { 
                                ?>
                                                
                                                    <?php if ($disable_trans == 1) { ?>                                  
                                                        <span class="span" style="color:red;">You Have Crossed the Payment Due Date of this Month !<br></span>
                                                        <span class="span" style="font-weight:normal;color:red;"> (Payment will be Active from <?php echo $start_pay_date; ?>) </span>

                                                    <?php } else { ?>
                                                        <b>TOTAL UNPAID AMOUNT: </b> 
                                                                <?php
                                                                if ($total_annual > 0) {
                                                                    if ($school[0]->stop_transaction == 'NO') {
                                                                        ?>
                                                                <input type="hidden" value="<?php echo $total_annual; ?>" name="total_ann_val" id="total_ann_val">
                                                                <button class="btn btn-app" id="total_annual" name="total_annual" type="button" style="padding:0px">
                                                                    <img src="<?php echo base_url('assets/img/pay_logo2.jpg'); ?>"><br>
                                                                    <span class="span" id="tot_val"><?php echo $total_annual; ?> INR</span>
                                                                </button>
                                                            <?php } else { ?>
                                                                <span class="span" style="color:red;text-align: left !important">Sorry for the inconvenience. Transaction has been blocked for a Limited Days !<br></span>
                                                            <?php }
                                                        } else { ?> 
                                                            <b><?php echo $total_annual; ?> INR</b>

                                                            <?php }
                                                        }
                                                        ?>
                                                
                                    <?php }else {?>
                                        <span class="span" style="color:red;text-align: left !important">Sorry! Your Data is not Updated yet for Current Session. Please Contact your School Administrator !<br></span>
                          
                                <?php  } } else{ ?>
                                <span class="span" style="color:red;text-align: left !important">Sorry! Your Payment For <?=$academic_session[0]->session; ?> Session Has Been Clossed. Please Contact your School Administrator !<br></span>
                                <?php } ?>
                                </div>
                            <?php }?>
                        </form>
                    </div>
                </div>


<?php } else {
    ?>

                <div class="col-md-4">
                    <div class="box" style="border: 1px solid darkgrey;">
                        <form class="form-horizontal" method="POST" role="form" id="half_paym" action="<?php echo base_url("payment/request") ?>">
                            <div class="box-header with-border" style="">
                                <h3 class="box-title">Half-yearly Payment Details</h3>
                            </div>
                            <div class="box-body">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                <table id="half_paymentlist" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>                 
                                            <th>Fee Name</th>
                                            <th>Fee Amount</th>     
                                        </tr>
                                    </thead> 
                                    <tbody>
    <?php
    $total_half = 0;
    foreach ($half_yearly_fee->result() as $obj_fee) {
        $total_half = $total_half + $obj_fee->fee_amount;
        ?>
                                            <tr>                 
                                                <td><?php echo $obj_fee->fee_name; ?></td>
                                                <td><?php echo $obj_fee->fee_amount; ?></td>     
                                            </tr>
    <?php } ?>
                                        <tr  style="font-size: 17px;font-weight: bold;">                 
                                            <td>Total</td>
                                            <td><input type="text" readonly="true" style="border: 0px;width: 100%;" name="total_h1" id="total_h1" value="<?php echo $total_half; ?>"></td>              
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                            <div class="box-body">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <td><input type="checkbox" <?php
    if (count($query_half_trans) >= 1) {
        echo 'checked disabled';
    }
    ?> name="half[]"></td> 
                                        <td>Half yearly-1(Apr-Sept)</td> 
                                        <td>
                                            <span class="span" id="tot_val"><?php echo $total_half; ?> INR</span>                                                                                                       
                                        </td>
                                        <td>
    <?php if (count($query_half_trans) >= 1) {
        ?>
                                                <input type="button" class="btn btn-success" style="width:70px" value="Paid">
    <?php } else { ?>

                                                <input type="button" class="btn btn-danger" value="Unpaid">  
    <?php } ?>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td><input type="checkbox" name="half[]"></td> 
                                        <td>Half yearly-2(Oct-Mar)</td> 
                                        <td>
                                            <span class="span" id="tot_val"><?php echo $total_half; ?> INR</span>                                                        
                                        </td> 
                                        <td>
    <?php if (count($query_half_trans) == 2) {
        ?>
                                                <input type="button" class="btn btn-success" style="width:70px" value="Paid">
    <?php } else { ?>

                                                <input type="button" class="btn btn-danger" value="Unpaid">  
    <?php } ?>

                                        </td>
                                    </tr> 
                                    <tr>
                                        <td colspan="2"></td> 
                                        <td></td>
                                        <td>
                                            <?php if(date('Y-m-d')<=$academic_session[0]->end_date) { 
                                                if($academic_session[0]->fin_year==$student[0]->student_academicyear_id) { 
                                                  if ($disable_trans == 1) {  
                                                
                                                    ?>
                                                            <span class="span" style="color:red;text-align: left !important">You Have Crossed the Payment Due Date of this Month !<br></span>
                                                            <span class="span" style="font-weight:normal;color:red;"> (Payment will be Active from <?php echo $start_pay_date; ?>) </span>
                                                    <?php
                                                    } else { 
                                                
                                                        if ($school[0]->stop_transaction == 'NO') {

                                                        ?>    
                                                        <button class="btn btn-app" id="total_half" name="total_half2" type="button" style="padding:0px">
                                                            <img src="<?php echo base_url('assets/img/pay_logo2.jpg'); ?>"><br>
                                                            <span  class="span" id="tot_half">000 INR</span>
                                                        </button>  
                                                       <?php } else {
                                                            ?>
                                                            <span class="span" style="color:red;text-align: left !important">Sorry for the inconvenience. Transaction has been blocked for a Limited Days !<br></span>
                                                            <?php }
                                                        } 
                                            
                                                }else {
                                                     ?>
                                                    <span class="span" style="color:red;text-align: left !important">Sorry! Your Data is not Updated yet for Current Session. Please Contact your School Administrator !<br></span>
                                            <?php }  
                                            
                                            }else{ ?>
                                        
                                            <span class="span" style="color:red;text-align: left !important">Sorry! Your Payment For <?=$academic_session[0]->session; ?> Session Has Been Clossed. Please Contact your School Administrator !<br></span>
                                        
                                            <?php }?>
                                        </td> 
                                    </tr>
                                </table>  
                            </div>
                        </form>
                    </div>
                </div>
<?php } ?>
            <div class="col-md-3">
                <div class="box" style="border: 1px solid darkgrey;">
                    <form class="form-horizontal" method="POST" role="form" id="other_paym" action="<?php echo base_url("payment/request") ?>">
                        <div class="box-header with-border" style="">
                            <h3 class="box-title">Other Fee</h3>
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
                                        <td><input type="text" readonly="true" style="border: 0px;width: 100%;background: inherit" name="total_other" id="total_other" value="<?php // echo $total_other;  ?>"></td>              
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                        <div class="box-body">
                            <table class="table table-bordered table-striped" >

                                <tr>

                                    <td></td>
<?php   if(date('Y-m-d')<=$academic_session[0]->end_date) { 
    
                if($academic_session[0]->fin_year==$student[0]->student_academicyear_id) {   
                    if ($disable_trans == 1) { ?>
                                        <td colspan="2">
                                            <span  class="span" style="color:red;text-align: left !important">You Have Crossed the Payment Due Date of this Month !<br></span>
                                            <span class="span" style="font-weight:normal;color:red;"> (Payment will be Active from <?php echo $start_pay_date; ?>) </span>
                                        </td>
                                    <?php } else {
                                        if ($school[0]->stop_transaction == 'NO') {
                                            ?>

                                            <td style="text-align:right;">
                                                <button class="btn btn-app" id="total_other2" name="total_other2" type="button" style="padding:0px">
                                                    <img src="<?php echo base_url('assets/img/pay_logo2.jpg'); ?>"><br>
                                                    <span class="span" id="tot_other">000 INR</span>
                                                </button>                                                                                                                                                                                     
                                            </td> 
                                        <?php } else { ?>
                                        <span class="span" style="color:red;text-align: left !important">Sorry for the inconvenience. Transaction has been blocked for a Limited Days !<br></span>
                                <?php }
                            } }else {
                                    ?>
                                        <span class="span" style="color:red;text-align: left !important">Sorry! Your Data is not Updated yet for Current Session. Please Contact your School Administrator !<br></span>
                                <?php } 
                                }else{ ?>
                                        
                                        <span class="span" style="color:red;text-align: left !important">Sorry! Your Payment For <?=$academic_session[0]->session; ?> Session Has Been Clossed. Please Contact your School Administrator !<br></span>
                                        
                                <?php }?>
                                </tr>
                            </table>  
                        </div>
                    </form>
                </div>
            </div>
            <!--</div>-->
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
                                <tr style="background: white;">
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
                                        if ($value == 2) {
                                            if ($payment->m > 1) {

                                                $month_var = $payment->from_month + $payment->m - 1;
                                                $str .= $payment->m . " Months Fees (" . $month[$payment->from_month] . " to " . $month[$month_var] . "),";
                                            } else {
                                                $str .= $payment->m . " Month Fees (" . $month[$payment->from_month] . "),";
                                            }
                                        } else if ($value == 1) {
                                            $str .= ' Annual Fees,';
                                        } else if ($value == 3) {
                                            $str .= ' Other Fees,';
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
                                        }
                                    }
                                    $str = rtrim($str, ',');
                                    ?>
                                    <tr <?php if ($payment->response_code == '0' && $payment->paid_status == 1) { ?> title="Click to get E-receipt" onclick="get_pdfdet(<?php echo $payment->id ?>);" style="color:darkgreen" <?php }else{ ?> style="color:red" <?php }?>>
                                        <td><?php echo date('Y-m-d', strtotime($payment->payment_date)); ?></td>
                                        <td><?php echo $str; ?></td>
                                        <td><?php echo $payment->total_amount . ' INR'; ?></td>
                                        <td><?php echo $payment->remarks. ' (' . $payment->response_message . ')'; ?></td>
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
<!---------------------------------------------------------------------------------------------------------------------------------------------->
<!-----------------------------------------------Monthly  fee popup--------------------------------------------------------------->
<div class="modal fade" id="modal_trans_charges" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="monthly_fee_popup" method="POST" role="form" action="<?php echo base_url("payment/request"); ?>">
                <div class="modal-header" style="background: lightgoldenrodyellow;border-bottom: 1px solid gainsboro;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="span" aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Total amount</h4>
                </div>
                <div class="modal-body" style="background:oldlace">
                    <div class="box-body edit_form">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <table class="table table-responsive">
                                    <tr>
                                        <th>Name : <label  id="name_m" style="font-weight:normal;color: darkred;"></label></th>

                                        <th>Class : <label  id="class_m" style="font-weight:normal;color: darkred;"><span class="span" id="class"></span><span class="span" id="sec"></span></label></th>

                                        <th>Category : <label  id="category_m" style="font-weight:normal;color: darkred;"><span class="span" id="class"></span><span class="span" id="sec"></span></label></th>



                                    </tr>
                                    <tr>
                                        <th colspan="3" style="text-align:center">Total Fee : <label  id="total_fee" style="font-weight:normal;color: darkred;"></label></th>

                                    </tr>

                                </table>
                            </div>
                        </div>
<!--                        <div class="form-group" style="margin-bottom: 0px !important;">
                            <label  class="col-sm-4 control-label" style="padding-right: 0px !important;text-align: left;">Name</label><label class="col-sm-1 control-label" style="PADDING-left: 0px;PADDING-right: 0px;width: 1.333333%;">:</label>
                            <div class="col-sm-7">
                                <label  id="name_m" class="col-sm-7 control-label" style="padding-left: 0px !important;width: 100%;text-align: left;"></label>
                                <input type="password" class="form-control" id="total_fee" name="total_fee" value="" required autofocus>
                            </div>
                        </div>

                        <div class="form-group" style="margin-bottom: 0px !important;">
                            <label  class="col-sm-4 control-label" style="padding-right: 0px !important;text-align: left;">Class</label><label class="col-sm-1 control-label" style="PADDING-left: 0px;PADDING-right: 0px;width: 1.333333%;">:</label>
                            <div class="col-sm-7">
                                <label  id="class_m" class=" control-label" style="padding-left: 0px !important;width: 100%;text-align: left;"><span class="span" id="class"></span><span class="span" id="sec"></span></label>
                                <input type="password" class="form-control" id="total_fee" name="total_fee" value="" required autofocus>
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom: 0px !important;">
                            <label  class="col-sm-4 control-label" style="padding-right: 0px !important;text-align: left;">Category</label><label class="col-sm-1 control-label" style="PADDING-left: 0px;PADDING-right: 0px;width: 1.333333%;">:</label>
                            <div class="col-sm-7">
                                <label  id="category_m" class=" control-label" style="padding-left: 0px !important;width:35%;text-align: left;"><span class="span" id="class"></span><span class="span" id="sec"></span></label>
                                <input type="password" class="form-control" id="total_fee" name="total_fee" value="" required autofocus>
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom: 0px !important;">
                            <label  class="col-sm-4 control-label" style="padding-right: 0px !important;text-align: left;">Total Fee</label><label class="col-sm-1 control-label" style="PADDING-left: 0px;PADDING-right: 0px;width: 1.333333%;">:</label>
                            <div class="col-sm-7">
                                <label  id="total_fee" class=" control-label" style="padding-left: 0px !important;width: 15%;text-align: left;"></label>
                                <input type="password" class="form-control" id="total_fee" name="total_fee" value="" required autofocus>
                            </div>
                        </div>-->
                        <!--                                <div class="form-group" style="margin-bottom: 0px !important;">
                        <label  class="col-sm-4 control-label" style="padding-right: 0px !important;text-align: left;"> Transaction Charge</label><label class="col-sm-1 control-label" style="PADDING-left: 0px;PADDING-right: 0px;width: 1.333333%;">:</label>
                        <div class="col-sm-7">
                        <label id="TransactionCharge" class="control-label" style="padding-left: 0px !important;width: 15%"></label>
                        <input type="password" class="form-control" id="TransactionCharge" name="TransactionCharge" value="" required autofocus>
                        </div>
                        </div>-->
<!--                        <div class="form-group" style="border-top: 1px solid lightgrey;margin-top:10px;border-bottom: 1px solid lightgrey;padding-bottom: 10px;">
                            <label  class="col-sm-4 control-label" style="padding-right: 0px !important;text-align: left;">Total</label><label class="col-sm-1 control-label" style="PADDING-left: 0px;PADDING-right: 0px;width: 1.333333%;">:</label>
                            <div class="col-sm-7">
                                <label  id="total_amt" class="control-label" style="padding-left: 0px !important;width: 15%;text-align: left;"></label>
                                <input type="text" readonly="true" id="total_amt" class="form-control" id="change_re_password" name="total_amt" value="" >
                            </div>
                        </div>-->
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
                        <span class="span" id="tot_val1"></span>

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
            <form class="form-horizontal" id="" method="POST" role="form" action="<?php echo base_url("payment/request"); ?>">
                <div class="modal-header" style="background: lightgoldenrodyellow;border-bottom: 1px solid gainsboro;">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="span" aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Total amount</h4>
                </div>
                <div class="modal-body" style="background:oldlace">
                    <div class="box-body edit_form">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <table class="table table-responsive">
                                    <tr>
                                        <th>Name : <label  id="name_a" style="font-weight:normal;color: darkred;"></label></th>

                                        <th>Class : <label  id="class_a" style="font-weight:normal;color: darkred;"><span class="span" id="class"></span><span class="span" id="sec"></span></label></th>

                                        <th>Category : <label  id="category_a" style="font-weight:normal;color: darkred;"><span class="span" id="class"></span><span class="span" id="sec"></span></label></th>



                                    </tr>
                                    <tr>
                                        <th colspan="3" style="text-align:center">Total Fee : <label  id="total_fee1" style="font-weight:normal;color: darkred;"></label></th>

                                    </tr>

                                </table>
                            </div>
                        </div>
<!--                        <div class="form-group" style="margin-bottom: 0px !important;">
                            <label  class="col-sm-4 control-label" style="padding-right: 0px !important;text-align: left;">Name</label><label class="col-sm-1 control-label" style="PADDING-left: 0px;PADDING-right: 0px;width: 1.333333%;">:</label>
                            <div class="col-sm-7">
                                <label  id="name_a" class="col-sm-7 control-label" style="padding-left: 0px !important;width: 100%;text-align: left;"></label>
                                <input type="password" class="form-control" id="total_fee" name="total_fee" value="" required autofocus>
                            </div>
                        </div>

                        <div class="form-group" style="margin-bottom: 0px !important;">
                            <label  class="col-sm-4 control-label" style="padding-right: 0px !important;text-align: left;">Class</label><label class="col-sm-1 control-label" style="PADDING-left: 0px;PADDING-right: 0px;width: 1.333333%;">:</label>
                            <div class="col-sm-7">
                                <label  id="class_a" class=" control-label" style="padding-left: 0px !important;width: 100%;text-align: left;"><span class="span" id="class"></span><span class="span" id="sec"></span></label>
                                <input type="password" class="form-control" id="total_fee" name="total_fee" value="" required autofocus>
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom: 0px !important;">
                            <label  class="col-sm-4 control-label" style="padding-right: 0px !important;text-align: left;">Category</label><label class="col-sm-1 control-label" style="PADDING-left: 0px;PADDING-right: 0px;width: 1.333333%;">:</label>
                            <div class="col-sm-7">
                                <label  id="category_a" class=" control-label" style="padding-left: 0px !important;width: 35%;text-align: left;"><span class="span" id="class"></span><span class="span" id="sec"></span></label>
                                <input type="password" class="form-control" id="total_fee" name="total_fee" value="" required autofocus>
                            </div>
                        </div>

                        <div class="form-group" style="margin-bottom: 0px !important;">
                            <label  class="col-sm-4 control-label" style="padding-right: 0px !important;text-align: left;">Total Fee</label><label class="col-sm-1 control-label" style="PADDING-left: 0px;PADDING-right: 0px;width: 1.333333%;">:</label>
                            <div class="col-sm-7">
                                <label  id="total_fee1" class=" control-label" style="padding-left: 0px !important;width: 15%;text-align: left;"></label>
                                <input type="password" class="form-control" id="total_fee" name="total_fee" value="" required autofocus>
                            </div>
                        </div>-->
                        <!--                                <div class="form-group" style="margin-bottom: 0px !important;">
                        <label  class="col-sm-4 control-label" style="padding-right: 0px !important;text-align: left;"> Transaction Charge</label><label class="col-sm-1 control-label" style="PADDING-left: 0px;PADDING-right: 0px;width: 1.333333%;">:</label>
                        <div class="col-sm-7">
                        <label  id="TransactionCharge1" class="control-label" style="padding-left: 0px !important;width: 15%"></label>
                        <input type="password" class="form-control" id="TransactionCharge" name="TransactionCharge" value="" required autofocus>
                        </div>
                        </div>-->
<!--                        <div class="form-group" style="border-top: 1px solid lightgrey;margin-top:10px;padding-bottom: 10px;border-bottom: 1px solid lightgrey;">
                            <label  class="col-sm-4 control-label" style="padding-right: 0px !important;text-align: left;">Total</label><label class="col-sm-1 control-label" style="PADDING-left: 0px;PADDING-right: 0px;width: 1.333333%;">:</label>
                            <div class="col-sm-7">
                                <label  id="total_amt1" class=" control-label" style="padding-left: 0px !important;width: 15%;text-align: left;"></label>
                                <input type="text" readonly="true" id="total_amt1" class="form-control"  name="total_amt1" value="" required>
                            </div>
                        </div>-->
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
                        <span class="span" id="tot_val2"></span>
                    </button>                          
                </div>
            </form>
        </div>
    </div>
</div>
<!---------------------------------------------------------------------------------------------------------------------------------------------------->



<!------------------------------------ CHANGE USER PASSWORD FIRST LOGIN ------------------------------------------------------------------------------->
<div class="modal fade" id="modal_change_password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="change_initial_password" method="POST" role="form" action="<?php echo base_url("payment/change_password") ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="span" aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Change User Password</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body edit_form">
                        <div class="form-group">
                            <label for="change_password" class="col-sm-4 control-label">Password:</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="change_password" name="change_password" value="" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="change_re_password" class="col-sm-4 control-label">Re-enter Password:</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="change_re_password" name="change_re_password" value="" required>
                            </div>
                        </div>
                    </div>
                    <p id="change_initial_error" style="color:red"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" name="btn_edit_user" id="btn_edit_user" class="btn btn-primary"><i class="fa fa-lock"></i> Update Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-------------------------------------------------------------------------------------------------------------------------------------->
<script>
    var mon_total =<?php echo $total; ?>;
    var pgw ='<?php echo $payment_gateway; ?>';


//    $.ajaxSetup({
//        data: {
//            '<?php // echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
//        }
//    });
//    $.ajaxSetup({
//        data: {
//            csrf_test_name: $.cookie('csrf_cookie_name')
//        }
//    });
    function get_pdfdet(trans_id)
    {

        $('#monthly_pay1').load('<?php echo base_url('payment/btn_download_pop_load'); ?>' + '/' + 'dwld_no', {trans_id: trans_id});
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
//            $('#monthly_pay').load('<?php // echo base_url('student/mon_pop_load');   ?>', {stud_id: stud_id, month_id: month_id,fee_cat:fee_cat_id});
//            $("#transaction_det").modal('show');
            $('#monthly_pay1').load('<?php echo base_url('payment/btn_download_pop_load'); ?>', {stud_id: stud_id, month_no: month_no, month_desc: month_desc, year: year, fee_cat: fee_cat_id, sem_name: sem});
            $("#transaction_det1").modal('show');
        } else if (status == 'year')
        {
            fee_cat_id = 1;
            $('#monthly_pay1').load('<?php echo base_url('payment/btn_download_pop_load'); ?>', {stud_id: stud_id, month_no: 0, month_desc: month_desc, year: year, fee_cat: fee_cat_id, sem_name: sem});
            $("#transaction_det1").modal('show');
        } else if (status == 'half')
        {
            fee_cat_id = 4;
            $('#monthly_pay1').load('<?php echo base_url('payment/btn_download_pop_load'); ?>', {stud_id: stud_id, month_no: 0, month_desc: month_desc, year: year, fee_cat: fee_cat_id, sem_name: sem});
            $("#transaction_det1").modal('show');
        } else
        {

        }

    }





    $('#change_pass').click(function ()
    {
        $('#modal_change_password').modal('show');
    });

    $(document).ready(function ()
    {

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


        var count = 0;
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

        /*------------  To show the Monthly pop up on pay button clic --------*/
        $("#total").click(function ()
        {
//     
            var total1 = $("#total_val").val();

            var $checkboxes = $('#paymentlist td input[type="checkbox"]');
//     var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
            var countCheckedCheckboxes = $checkboxes.filter(function () {
                return this.checked && !this.disabled;
            }).length;
//$('input[type="checkbox"]').filter(function() {
//    return this.checked && !this.disabled;
//}).length;

//     $("#TransactionCharge").text(countCheckedCheckboxes*5);
            $("#name_m").text('<?php echo html_escape($student[0]->name); ?>');
            $("#class_m").text('<?php echo html_escape($student[0]->class_name); ?>' + '--' + '<?php echo html_escape($student[0]->sec_name); ?>');
            $("#category_m").text('<?php echo html_escape($student[0]->cat_name); ?>');

//                                $("#TransactionCharge").text(5);
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
        var stud_id ='<?php echo $student_id; ?>';
        
//    -------------------------------------------------------------------------------------------
        $('#half_paym input[type=checkbox]').change(function ()
        {
            var count_chk = 1;
            $('#half_paym input[type=checkbox]').each(function () {
                if (this.checked)
                {
                    count_chk++;
                }

            });
            count_chk--;
            var total_half = (Number($('#total_h1').val())) * (count_chk);
            $("#tot_half").text(total_half + ' INR');


        });
        $('#total_half').click(function () {

            var count_chk = 1;
            $('#half_paym input[type=checkbox]').each(function () {
                if (this.checked)
                {
                    count_chk++;
                }

            });
            count_chk--;
            var total_half = (Number($('#total_h1').val())) * (count_chk);


            $('#total1').attr('form', 'half_paym');

            $('#total1').attr('name', 'total3');
            $('#total1').attr('id', 'total3');

            $("#name_m").text($("#name").val());
            $("#class_m").text('<?php echo html_escape($student[0]->class_name); ?>' + '--' + '<?php echo html_escape($student[0]->sec_name); ?>');
            $("#category_m").text('<?php echo html_escape($student[0]->cat_name); ?>');

            $("#TransactionCharge").text(5);
            $("#total_fee").text(total_half);
            $("#total_amt").text(Number(total_half));
            $("#tot_val1").text((Number(total_half)) + ' INR');
            $("#modal_trans_charges").modal('show');

        });


//     ------------------------------------------------------------------------------------------------------------------   


        $('#mont_paym input[type=checkbox]').change(function ()
        {
            var month_id = [];
//            var prev_mon, cur_mon;
            var next_mon, cur_mon;
            var i = 0;
            

            cur_mon = $(this).val();

//            prev_mon = Number(cur_mon) + 1;
            next_mon = Number(cur_mon) + 1;
            var lastmonthlyfeemonth='<?php echo $lastmonthlyfeemonth;?>';
//            if (!$("#mont_paym :checkbox[value=" + prev_mon + "]").prop("checked"))
//            {
//                if (this.checked) {
//                    $("#mont_paym :checkbox[value=" + prev_mon + "]").removeAttr('disabled');
//                } else {
//                    $("#mont_paym :checkbox[value=" + prev_mon + "]").prop('disabled', 'true');
//                }
//
//            } else
//            {
//
//                for (var c = Number(prev_mon); c <= 12; c++) {
//
//                    $("#mont_paym :checkbox[value=" + c + "]").prop('checked', false);
//                    $("#mont_paym :checkbox[value=" + c + "]").prop('disabled', 'true');
//
//                }
//
//            }
            if(Number(cur_mon) >= lastmonthlyfeemonth){
                var n = 12-Number(lastmonthlyfeemonth);
//                    alert(lastmonthlyfeemonth);
                if(this.checked){

                            for(var d=Number(lastmonthlyfeemonth); d<=(Number(lastmonthlyfeemonth)+Number(n));d++){

                                $("#mont_paym :checkbox[value=" + d + "]").prop('checked',true); 
                                $("#mont_paym :checkbox[value=" + d + "]").removeAttr('disabled');

                            }
                }else{

                            for(var d=Number(lastmonthlyfeemonth); d<=(Number(lastmonthlyfeemonth)+Number(n));d++){

                                $("#mont_paym :checkbox[value=" + d + "]").prop('checked',false); 
                                $("#mont_paym :checkbox[value=" + d + "]").removeAttr('disabled');

                            }
//                        
                }

            }else{


                    if (!$("#mont_paym :checkbox[value=" + next_mon + "]").prop("checked"))
                    {
                        if(this.checked && pgw!='WORLDLINE'){
                            $("#mont_paym :checkbox[value=" + next_mon + "]").removeAttr('disabled');
                        }else{
                            $("#mont_paym :checkbox[value=" + next_mon + "]").prop('disabled', 'true');
                        }

                    } else
                    {
                            var n = 12-Number(next_mon);
                            for(var c=Number(next_mon); c<=(Number(next_mon)+Number(n));c++){

                                $("#mont_paym :checkbox[value=" + c + "]").prop('checked',false); 
                                $("#mont_paym :checkbox[value=" + c + "]").prop('disabled', 'true');

                            }

                    }
            }
            $('#mont_paym input[type=checkbox]:checked').each(function ()
            {
                month_id[i] = (this.value);

                i++;
            });

            get_stud_month_fee('', month_id);


        });


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




        function get_stud_month_fee(status, month_id)
        {

            var fee;
            var actualfine=$('input[name="actual_fine_due_month"]').val();
            $.ajax({
                url: '<?php echo base_url('payment/get_student_fee'); ?>',
                dataType: "text",
                method: 'POST',
                data: {stud_id: stud_id, month_id: month_id,actualfine:actualfine},
                success: function (data) {
                    var x = data.split("|");
//                                        alert(x[1]);
//                                        alert(x[2]);
                    $("#mont_paym #tot_val").text(x[1] + ' INR');
                    $("#get_month_fee_det").html(x[0]);
                    $("#total_val").val(x[1]);

                }
            });
        }


//    $("#paymentlist").DataTable();
//    $("#paidlist").DataTable();
        $("#schoolbulletin").DataTable();

        $('#student_change_password').on('submit', function () {
            if ($('#change_password').val() != $('#change_re_password').val()) {
                $('#change_password_error').html('Password should match');
                return false;
            } else {
                return true;
            }
        });
        $('#change_initial_password').on('submit', function () {
            if ($('#change_password').val() != $('#change_re_password').val()) {
                $('#change_initial_error').html('Password should match');
                return false;
            } else {
                return true;
            }
        });



    });

    function winPop(url, w, h)
    {
        winDef = "toolbar=0,location=0,status=0, menubar=0,scrollbars=yes,resizable=0,width=" + w + ",height=" + h;
        window.open(url, "_blank", winDef);
    }
</script>        