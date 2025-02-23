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
                        <!-- <?php 
                        echo "<pre>";print_r($fee_ty);
                        ?> -->
            <th colspan="<?php echo count($fee_ty)+3-count($rmvcol1);?>" style="text-align: center;border-bottom:1px solid black;"> FEE TYPE</th>
            <?php }else{?>
            <th colspan="<?php echo count($fee_ty)+2-count($rmvcol1);?>" style="text-align: center;border-bottom:1px solid black;"> FEE TYPE</th>
            <?php }?>
                    <!--<th rowspan="2" style="border-bottom:1px solid black;"> TOTAL FEE </th>-->
            
            <th rowspan="2" style="border-bottom:1px solid black;"> FINE WAIVER </th>
            <th rowspan="2" style="border-bottom:1px solid black;"> POS No. </th>
            <th rowspan="2" style="border-bottom:1px solid black;"> Remarks/Receipt No/Collection Centre </th>
            <?php if($this->session->userdata('school_id')==29){ ?>
            <th rowspan="2" style="border-bottom:1px solid black;"> TEXT BOOK FEE </th>
            <?php } ?>
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
//                  foreach ($paymodeqry as $p) { $tot_mode[$p->id]=0;}
                  foreach($fetch_transaction_date as $ftd) {
                  //   echo '<pre>';
                  // print_r($ftd) ;
                  // echo '<pre>';


                        $fee_head_id    = $ftd->id;

                        $stud_class     = $ftd->class_id;
                        $stud_course    = $ftd->course_id;
                        // $stud_cat       = $ftd->stud_category;
                        $stud_cat       = $ftd->fee_stud_category;
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

                     


                     <!-- FEE TYPE START -->
                      




                     <?php $total=0;foreach($fee_ty as $d=>$v) {
                        // echo $fee_cat_id[$d].'<br>';
                          $fee_amt=0;

                          if(!is_array($rmvcol1) || !in_array($d, $rmvcol1)) {
                           $s=($fee_cat_id[$d]==3)?'':" and stud_cat=$stud_cat";
                          $class_fee = $this->dbconnection->select("class_fee_det", "fee_amount,fee_cat", "class_fee_head_id=$ftd->class_fee_head_id $s and status=1  and fee_id=" . $d);
                         
                           
                           
                            if ($fee_cat_id[$d]!=8 && $fee_cat_id[$d]!=3 && count($class_fee) > 0) {
                                $fee_qry = $this->dbconnection->select("fee_transaction_det", "id,fee_trans_head_id,month_no,amount", "fee_trans_head_id=$fee_head_id and fee_cat_id=" . $class_fee[0]->fee_cat);
                                $fee_amt = 0;

                                if (count($fee_qry) > 0) {
                                    
                                    if($fee_cat_id[$d]==5){
                                        $de=$class_fee[0]->fee_amount/3;
                                    }else{
                                        $de=$class_fee[0]->fee_amount;
                                    }
                                    foreach ($fee_qry as $rfee) {                                       
                                            
                                            $fee_amt = $fee_amt + $de;
                                            $total += $de;
                                       
                                        
                                    }


                                } else {
                                    $fee_amt = 0;
                                    $total += 0;
                                }
                                
//                                if($schgrp=='ARMY' && $fee_cat_id[$d]==5) {
//                                    $fee_amt=($fee_amt/count($fee_qry))*((count($fee_qry)+$ftd->start_fee_month)/3);
//                                }
                            }else if($fee_cat_id[$d]==8){
                                $fee_qry = $this->dbconnection->select("fee_transaction_det", "id,fee_trans_head_id,amount,other_fee_id", "fee_trans_head_id=$fee_head_id and fee_cat_id=8 and other_fee_id=$d");
                                
                                $fee_amt=0;
                                if (count($fee_qry) > 0) {
                                    foreach ($fee_qry as $rfee) {
                                      // print_r($rfee);
                                      // echo '<pre>';
                                     
                                      $fee_amt = $fee_amt + $rfee->amount;
                                      $total += $rfee->amount;
                                    }
                                   
                                }else {
                                    $fee_amt = 0;
                                    $total += 0;
                                }

                            }
                            else if($fee_cat_id[$d]==9){
                                $fee_qry = $this->dbconnection->select("fee_transaction_det", "id,fee_trans_head_id,amount,other_fee_id", "fee_trans_head_id=$fee_head_id and fee_cat_id=9");
                                
                                $fee_amt=0;
                                if (count($fee_qry) > 0) {
                                    foreach ($fee_qry as $rfee) {
                                      // print_r($rfee);
                                      // echo '<pre>';
                                     
                                      $fee_amt = $fee_amt + $rfee->amount;
                                      $total += $rfee->amount;
                                    }
                                   
                                }else {
                                    $fee_amt = 0;
                                    $total += 0;
                                }

                            }
                            else if($fee_cat_id[$d]==3){



                              if($this->session->userdata('school_id')==29)
                              {

                                $fee_qry = $this->dbconnection->select("fee_transaction_det", "id,fee_trans_head_id,amount,other_fee_id", "fee_trans_head_id=$fee_head_id and fee_cat_id=3 and other_fee_id>32 and other_fee_id<94");

                                // $fee_qry = $this->dbconnection->select("fee_transaction_det", "id,fee_trans_head_id,amount,other_fee_id", "fee_trans_head_id=$fee_head_id and fee_cat_id=3 and other_fee_id>32 and other_fee_id<94");

                                //echo"<pre>";echo $this->db->last_query();

                                
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
                              }


                              else{

                                $fee_qry = $this->dbconnection->select("fee_transaction_det", "id,fee_trans_head_id,amount,other_fee_id", "fee_trans_head_id=$fee_head_id and fee_cat_id=3 and other_fee_id=$d");
                                
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
                              }
                                

                            } 
                            else {
                                $fee_amt = 0;
                                $total += 0;
                            }
                          $total_fee_amt_wise[$d]=$total_fee_amt_wise[$d]+$fee_amt;
                          
                          ?>
                     
<!-- FEE TYPE END -->

                    <!-- <td><?php // echo $fee_amnt[$ftd->id][$d];?></td> -->
                     <td><?php echo $fee_amt;?></td>
                          <?php }} ?>
                     <?php if($trans_status=='YES'){
//                         if (!empty($ftd->transport_amt)) {
                                $trns_qry = $this->dbconnection->select("fee_transaction_det", "id,fee_trans_head_id,amount", "fee_trans_head_id=$fee_head_id and fee_cat_id=6");
                                $trans_amt = 0;
                                if (count($trns_qry) > 0) {
                                    foreach ($trns_qry as $rt) {
                                        $trans_amt = $trans_amt + $rt->amount;
                                        $total += $rt->amount;
                                    }

                                }
                                 else {
                                    $trans_amt = 0;
                                    $total += 0;
                                }
//                            } else {
//                                $trans_amt = 0;
//                                $total += 0;
//                            }
                         
                         ?>
                     <!--<td><?php // echo $fee_amnt[$ftd->id]['trans'];?></td>-->
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
                     <td><?php echo $ftd->pos_no;?></td>
                     <td><?php echo $ftd->receipt_no.' - '.$ftd->remarks.' - '.$ftd->collection_centre;?></td>
                     <?php 
                     //echo $this->session->user_data('school_id');
                     


                     //BOOK FEE AMOUNT ADDITION AND COLUMN HIDE

                     if($this->session->userdata('school_id')==29)
                      {

                        $text_fee_amt=0;

                        $fee_qry = $this->dbconnection->select("fee_transaction_det", "sum(amount) as text_amount", "fee_trans_head_id=$fee_head_id and fee_cat_id=3 and other_fee_id in (33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137)");

                        // $fee_qry = ("SELECT fee_transaction_det", "sum(amount) as text_amount", "fee_trans_head_id=$fee_head_id and fee_cat_id=3 and other_fee_id in (33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118)");

                        // echo"<pre>";
                        //      print_r($fee_qry);

                        if (count($fee_qry) > 0) {
                            foreach ($fee_qry as $rfee) {
                             
                              $text_fee_amt = $text_fee_amt + $rfee->text_amount;
                              $total += $rfee->text_amount;
                            }                           
                        }else {
                            $text_fee_amt = 0;
                            $total += 0;
                        } 
                        ?>
                         <td><?php echo $text_fee_amt;?></td>
                     <?php } ?>
                    
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
                    <th></th>
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
                    <th></th>
                    <th></th>
                </tr>
                <?php }?>
                
             </tbody>
        </table>
        
       </div>
    </form>

<?php //if ($this->session->userdata('school_id')==5) { ?>
<script>
    var n=3;
    <?php if(is_array($rmvcol) && in_array('fee_cat', $rmvcol)) {?>
       var n=2; 
            <?php }?>
    var table=$('#studentlist3').DataTable(
            {
//             lengthChange: false,
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
                                            pageSize: 'A2'
                                        },
                                        {
                                            extend: 'print',
                                            orientation: 'landscape',
                                            pageSize: 'A2'
                                        },
                                    ]
                                }
                            ]

                            
            });
        
    
    </script>
<?php //} else{ ?>

<?php //} ?>