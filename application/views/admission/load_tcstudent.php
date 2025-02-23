<style>
    tr.highlight {
        background-color: #dff0d8 !important;
        border-color: #d6e9c6 !important;
        font-weight:bold !important;
    }

</style>

<div id="fee_collect_div_n" class="col-sm-12">

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
                            <input type="hidden" name="student_id" id="student_id" value="<?php echo $student_id; ?>">
                            <td ><?php echo $student_id; ?></td>
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>
   
    <div class="panel  panel-info">
        <div class="panel-heading" style="padding: 5px 15px;"><i class="glyphicon glyphicon-folder-open">  </i> <b> <span style="color:black"> Fees Collection</span></b></div>
        <div class="panel-body" style="padding:0px;">



            <?php $total_onet = 0;
                   $total_refundt = 0; if ($onetime_avai == 'YES') { ?>
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
            <?php } else{ ?>
 <div class="col-md-4" style="padding:1%">
                    <div class="box " style="border: 1px solid lightgrey;">
                        <div class="box-header" style="background: aliceblue;padding:5px">
                            <h4 class="box-title" >Monthly Fees</h4>
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
                                            <tr>
                                                <th>Total Amount</th>
                                                <th><?php echo $total_annual_amount; ?></th>
                                            </tr>
                                            <?php
                                                if ($start_fee_month != 1) {
                                                    $refunded = $total_refundannual / 12;
                                                    $total_refunded = $refunded * ($start_fee_month - 1);
                                                    $total_annual_amount = $total_annual_amount - $total_refunded;
                                                } else {
                                                    $total_refunded = 0;
                                                }
                                                ?>


                                                <?php if ($total_refunded != 0) { ?>    
                                                    <tr  style="font-weight: bold;">                 
                                                        <td style="font-size: 16px;">Refunded Amount</td>
                                                        <td><?php echo $total_refunded; ?></td>              
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
</div>
  

<script>
     $('#back').click(function () {
        window.location.href = "<?php echo base_url('admission/TcStudent/TcStudentPage'); ?>";
    });   

</script>