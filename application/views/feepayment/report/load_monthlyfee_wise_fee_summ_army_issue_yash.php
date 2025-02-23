<style>
    .dt-button.red {
        color: darkgreen;
        font-weight: bold;
    }
</style>
<?php // print_r($fee_ty);?>
<form id="frmstudent3" role="form" method="POST">
       <div class="table-responsive">
        <table id="studentlist3" class="table table-bordered table-striped">
            <thead>
                <tr> 

                    
                    <?php if(!is_array($rmvcol) || !in_array('fee_cat', $rmvcol)) {?><th rowspan="2" style="border-bottom:1px solid black;"> FEE CATEGORY </th><?php }?>
                    <th rowspan="2" style="border-bottom:1px solid black;"> PAYMENT MODE </th>
                    <th rowspan="2" style="border-bottom:1px solid black;"> TRANSACTION ID. </th>
                    <th rowspan="2" style="border-bottom:1px solid black;"> TRANSACTION DATE </th>
                    <th rowspan="2" style="border-bottom:1px solid black;"> TOTAL AMOUNT </th>
                    <?php if(!is_array($rmvcol) || !in_array('status', $rmvcol)) {?><th rowspan="2" style="border-bottom:1px solid black;"> STATUS </th><?php }?>
                    <th rowspan="2" style="border-bottom:1px solid black;"> ADMISSION NO. </th>
                    <th rowspan="2" style="border-bottom:1px solid black;"> NAME </th>
                    <th rowspan="2" style="border-bottom:1px solid black;"> CLASS-SEC </th>
                    <th rowspan="2" style="border-bottom:1px solid black;"> ROLL NO </th>
                    <th rowspan="2" style="border-bottom:1px solid black;"> MONTH DETAILS </th>
                    <?php if($trans_status=='YES'){?>
            <th colspan="<?php echo count($fee_ty)+3-count($rmvcol1);?>" style="text-align: center;border-bottom:1px solid black;"> FEE TYPE</th>
            <?php }else{?>
            <th colspan="<?php echo count($fee_ty)+2-count($rmvcol1);?>" style="text-align: center;border-bottom:1px solid black;"> FEE TYPE</th>
            <?php }?>
            <th rowspan="2" style="border-bottom:1px solid black;"> Instant Discount </th>
            <th rowspan="2" style="border-bottom:1px solid black;"> Remarks/Receipt No </th>
                </tr> 
                <tr>
                    <?php $total_fee_amt_wise=array();foreach($fee_ty as $d=>$v) {
                        if(!is_array($rmvcol1) || !in_array($d, $rmvcol1)) {
                        $total_fee_amt_wise[$d]=0;?>
                    <th style="border-bottom:1px solid black;"> <?php echo $v; ?> </th>
                        <?php }} ?>
                    <?php if($trans_status=='YES'){?>
                     <th style="border-bottom:1px solid black;"> Transport Fee </th>
                      <?php }?>
                     <th style="border-bottom:1px solid black;"> Fine </th>
                     <th style="border-bottom:1px solid black;"> Re-Admission-Fine </th>
                     
                </tr>
             </thead>
             <tbody id="monthlyfees_load_td">
                  <?php $total_fee_amt=0;$trans_amt_total=0;$fine_amt_total=0;$disc_amt_total=0;$readmsnamttot=0;
                  // echo "<pre>";print($paymodeqry);die();
                  foreach($fetch_transaction_date as $ftd) { 
                        $fee_head_id    = $ftd->id;

                        $stud_class     = $ftd->class_id;
                        $stud_course    = $ftd->course_id;
                        $stud_cat       = $ftd->stud_category;  
                        $total_fee_amt+=$ftd->total_amount;
                        foreach ($paymodeqry as $p) {
                             if(strtolower($ftd->mode)==strtolower($p->mode_name)){
                                $tot_mode[$p->id] += $ftd->total_amount;
                            }
                        }
                      ?>                 
                 <tr>
                     <!--<td><?php // echo $ftd->fee_cat;?></td>-->
                     <?php if(!is_array($rmvcol) || !in_array('fee_cat', $rmvcol)) {?><td><?php if($schgrp=='ARMY') {echo 'Quarterly Fee';}else{echo 'Monthly Fee';}?></td><?php }?>
                     <td><?php echo $ftd->payment_method;?></td>
                     <td><?php echo $ftd->transaction_id;?></td>
                     <td><?php echo $ftd->payment_date;?></td>
                     <td><?php echo $ftd->total_amount;?></td>
                     <?php if(!is_array($rmvcol) || !in_array('status', $rmvcol)) {?><td><?php echo $ftd->response_message;?></td><?php }?>
                     <td><?php echo $ftd->admission_no;?></td>
                     <td><?php echo $ftd->name;?></td>
                     <td><?php echo $class[$ftd->class_id].' - '.$section[$ftd->section_id];?></td>
                     <td><?php echo $ftd->roll;?></td>
                     <td><?php $m=array();$m=explode(',',$ftd->month_details);$str='';foreach($m as $v) { $str.=$month_arr[$v].' ';} echo $str;?></td>
                      <?php $total=0;foreach($fee_ty as $d=>$v) {
                        // print_r($v);
                          $fee_amt=0;
                          if(!is_array($rmvcol1) || !in_array($d, $rmvcol1)) {
                            $s=($fee_cat_id[$d]==3)?'':" and stud_cat=$stud_cat";
                          $class_fee = $this->dbconnection->select("class_fee_det", "fee_amount,fee_cat,fee_id,(select fee_type from fee_master where id=fee_id) fee_type", "class_fee_head_id=$ftd->class_fee_head_id $s and status=1 and stud_cat=$ftd->stud_category and fee_id=" . $d);
                           
                            if ($fee_cat_id[$d]!=8 && count($class_fee) > 0) {
                                $fee_qry = $this->dbconnection->select("fee_transaction_det", "id,fee_trans_head_id,month_no,amount", "fee_trans_head_id=$fee_head_id and fee_cat_id=" . $class_fee[0]->fee_cat);
                                $fee_amt = 0;
                                // print_r($class_fee);
                                // echo '<pre>';
                                
                               
                                if (count($fee_qry) > 0) {
                                    
                                    if($fee_qry[0]->month_no!=0){
                                        if($fee_cat_id[$d]==5)
                                      {
                                          $de=round($class_fee[0]->fee_amount/3);
                                      }
                                      else
                                      {
                                        $de=round($class_fee[0]->fee_amount);
                                      }
                                    }

                                    else
                                    {
                                      if($fee_cat_id[$d]==1)
                                      {
                                          $start_fee_month=$ftd->start_fee_month;
                                           $rest_month = (12-$start_fee_month)+1;
                                            $fee_amount = $class_fee[0]->fee_amount;
                                            $fee_id     = $class_fee[0]->fee_id;
                                            if($fee_id==10 || $fee_id==16)
                                            {
                                                $de = round($fee_amount);
                                            }                
                                            else
                                            {
                                                $de = round(($fee_amount/12)*$rest_month);
                                            }
                                      }
                                      else{
                                        $dee=round($class_fee[0]->fee_amount/12);
                                        $de=$dee*12;
                                      }
                                    }
                                    foreach ($fee_qry as $rfee) {
                                            
                                            $fee_amt = $fee_amt + $de;
                                            $total += $de;

                                    }


                                } else {
                                    $fee_amt = 0;
                                    $total += 0;
                                }
                            }else if($fee_cat_id[$d]==8){
                                $fee_qry = $this->dbconnection->select("fee_transaction_det", "id,fee_trans_head_id,amount,other_fee_id", "fee_trans_head_id=$fee_head_id and fee_cat_id=8 and other_fee_id=$d");
                                $fee_amt=0;
                                if (count($fee_qry) > 0) {
                                    foreach ($fee_qry as $rfee) {
                                        $fee_amt = $fee_amt + $rfee->amount;
                                        $total += $rfee->amount;
                                    }
                                   
                                }else {
                                    $fee_amt = 0;
                                    $total += 0;
                                }

                            }  else {
                                $fee_amt = 0;
                                $total += 0;
                            }
                           $total_fee_amt_wise[$d]=$total_fee_amt_wise[$d]+$fee_amt;
                          ?>
                     <td><?php echo $fee_amt;?></td>
                          <?php }} ?>
                     <?php if($trans_status=='YES'){
                                $trns_qry = $this->dbconnection->select("fee_transaction_det", "id,fee_trans_head_id,amount", "fee_trans_head_id=$fee_head_id and fee_cat_id=6");
                                $trans_amt = 0;
                                if (count($trns_qry) > 0) {
                                    foreach ($trns_qry as $rt) {
                                        $trans_amt = $trans_amt + $rt->amount;
                                        $total += $rt->amount;
                                    }

                                } else {
                                    $trans_amt = 0;
                                    $total += 0;
                                }
                         
                         ?>
                     <td><?php echo $trans_amt;?></td>
                     <?php $trans_amt_total+=$trans_amt;}?>
                     <td><?php 
                     $fine_qry = $this->dbconnection->select("fee_transaction_det", "id,fee_trans_head_id,month_no,amount", "fee_trans_head_id =$fee_head_id and fee_cat_id=0");
                        $fine_amt = 0;
                        if (count($fine_qry) > 0) {
                            foreach ($fine_qry as $rfine) {
                                $fine_amt = $fine_amt + $rfine->amount;
                                $total += $rfine->amount;
                            }

                        } else {
                            $fine_amt = 0;
                            $total += 0;
                        }
                     
                     
                     $fine_amt_total+=$fine_amt;
                     
                     $readmissionfine = $this->dbconnection->select("fee_transaction_det", "amount", "fee_trans_head_id =$fee_head_id and fee_cat_id=11");
                     
                     echo $fine_amt;?></td>
                     <td><?php if(!empty($readmissionfine)) {echo $readmissionfine[0]->amount; $total += $readmissionfine[0]->amount; $readmsnamttot+= $readmissionfine[0]->amount;}?></td>
                     <td><?php $disc_amt_total+=$ftd->discount_amount ; echo $ftd->discount_amount;?></td>
                     <td><?php echo $ftd->receipt_no.' - '.$ftd->remarks;?></td>
                </tr>
                
      
                 <?php } ?>
                <tr>
                    <?php if(!is_array($rmvcol) || !in_array('fee_cat', $rmvcol)) {?><th>Total</th><?php }?>
                    <th>Total</th>
                    <th></th>
                    <th></th>
                    <th><?php echo $total_fee_amt;?></th>
                    <?php if(!is_array($rmvcol) || !in_array('status', $rmvcol)) {?><th></th><?php }?>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <?php foreach($fee_ty as $d=>$v) {
                      // print_r($v);
                      // echo '<pre>';
                      // echo '----';
                      
                      // print_r($d);
                      // echo '<pre>';
                        if(!is_array($rmvcol1) || !in_array($d, $rmvcol1)) {?>
                    <th> <?php echo $total_fee_amt_wise[$d]; ?> </th>
                        <?php }} ?>
                    <?php if($trans_status=='YES'){?>
                     <th> <?php echo $trans_amt_total;?></th>
                    <?php }?>
                    <th><?php echo $fine_amt_total;?></th>
                    <th><?php echo $readmsnamttot;?></th>
                    <th><?php echo $disc_amt_total;?></th>
                    <th></th>
                </tr>
                
                <?php foreach ($paymodeqry as $key => $value) { ?>
                <tr>
                    <?php if(!is_array($rmvcol) || !in_array('fee_cat', $rmvcol)) {?><th><?php echo $value->mode_name;?></th><?php }?>
                    <th><?php echo $value->mode_name;?></th>
                    <th></th>
                    <th></th>
                    <th><?php echo $tot_mode[$value->id];?></th>
                    <?php if(!is_array($rmvcol) || !in_array('status', $rmvcol)) {?><th></th><?php }?>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <?php foreach($fee_ty as $d=>$v) {
                        if(!is_array($rmvcol1) || !in_array($d, $rmvcol1)) {?>
                    <th> <?php // echo $total_fee_amt_wise[$d]; ?> </th>
                        <?php }} ?>
                    <?php if($trans_status=='YES'){?>
                     <th> <?php // echo $trans_amt_total;?></th>
                    <?php }?>
                    <th><?php // echo $fine_amt_total;?></th>
                    <th><?php // echo $fine_amt_total;?></th>
                    <th><?php // echo $disc_amt_total;?></th>
                    <th></th>
                </tr>
                <?php }?>
                
             </tbody>
        </table>
        
       </div>
    </form>
<script>
    var n=3;
    <?php if(is_array($rmvcol) && in_array('fee_cat', $rmvcol)) {?>
       var n=2; 
            <?php }?>
    var table=$('#studentlist3').DataTable(
            {
             "order": [[n, "desc"]],
             dom: 'Bfrtip',
                 buttons: [

                                {
                                    extend: 'collection',
                                    text: 'Export',
                                    className: 'red',
                                    buttons: [

                                        'excel',
                                        'csv',
                                         {
                                            extend: 'pdf',
                                            orientation: 'landscape',
                                            pageSize: 'A3'
                                        },
                                        {
                                            extend: 'print',
                                            orientation: 'landscape',
                                            pageSize: 'A3'
                                        },
                                    ]
                                }
                            ]

                            
            });

    
    </script>