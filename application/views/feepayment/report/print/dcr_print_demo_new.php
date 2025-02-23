<?php ini_set('memory_limit','-1'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>DCR</title>
<style>
    .dt-button.red {
        color: darkgreen;
        font-weight: bold;
    }
    .table-bordered>tbody>tr>td,.table-bordered>thead>tr>th 
      {
          border: 0.0001px solid grey;
          text-align:center;
      }

      /*.header { position: fixed; left: 0px; top: 0px; right: 0px;}*/
    

</style>
<div class="">
    <div class="" style="width: 20%;position: absolute;">
        <?php  $school_id=$school_data[0]->id; ?>
        <div class="" style="text-align: center;">
            <img src="assets/img/<?php echo $school_id.'.JPG';?>" style="height:100px">
        </div>
    </div>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <!-- <div class="row p-5"> -->
        <div class="" style="width: 80%;position: absolute;">
            <center><h1><?php echo $school_data[0]->description;?></h1>
            <p class="font-weight-bold" style="margin: 0 0 1px;"><?php echo $school_data[0]->vision;?></p>
          
        </div>
    <!-- </div> -->
    </div>
<div style="border:1px solid;height:50px;margin-top: 90px;">
 <p style="font-size: 18px;float: left;">Collected By : <?php echo $c_centre_name; ?></p><p style="font-size: 18px;text-align: center;font-weight: bold;">Daily Collection Report as on <?php echo $datee; ?></p>
</div>
</div>
<!-- <div class="header" style="padding-top: -60px;">
  <div style="width: 100%;">
    <div class="" style="width: 20%;position: absolute;">
        <?php  $school_id=$school_data[0]->id; ?>
        <div class="" style="text-align: center;">
            <img src="assets/img/<?php echo $school_id.'.JPG';?>" style="height:100px">
        </div>
    </div>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <div class="" style="width: 80%;position: absolute;">
        <center><h1><?php echo $school_data[0]->description;?></h1>
        <p class="font-weight-bold"><?php echo $school_data[0]->vision;?></p>
       </center>
    </div>
  </div>
  <div class="header1" style="padding-bottom: -50px;">
    <div style="width: 100%;border:1px solid;height:35px;margin-top: 70px;">
      <span style="font-size: 14px;text-align: left;padding-top: -30px;">Collected By : <?php echo $c_centre_name; ?></span>
      <span style="font-size: 18px;margin-left: 800px;padding-top: -30px;">Daily Collection Report as on <?php echo $datee; ?></span>
    </div>
  </div>
</div><br><br><br><br> -->
<form id="frmstudent3" role="form" method="POST" >
       <div class="table-responsive">
        <table id="studentlist3" class="table table-bordered table-striped" >
                   <thead>
                <tr> 
                                    
                    <th rowspan="2" style="border-bottom:1px solid black;"> Sl.No. </th>
                    <?php if($c_centre_name=='Feesclub') { ?>
                      <th rowspan="2" style="border-bottom:1px solid black;"> Transaction Id</th>
                    <?php } ?>
                    <th rowspan="2" style="border-bottom:1px solid black;"> Adm.No.</th>
                    <th rowspan="2" style="border-bottom:1px solid black;"> Name </th>
                    <th rowspan="2" style="border-bottom:1px solid black;"> Class</th>
                    <th rowspan="2" style="border-bottom:1px solid black;"> Month Details</th>
                    <?php if($trans_status=='YES'){?>
            <th colspan="<?php echo count($fee_ty)+2-count($rmvcol1);?>" style="text-align: center;border-bottom:1px solid black;"> FEE TYPE</th>
            <?php }else{?>
            <th colspan="<?php echo count($fee_ty)+1-count($rmvcol1);?>" style="text-align: center;border-bottom:1px solid black;"> FEE TYPE</th>
            <?php }?>
            <!-- <th rowspan="2" style="border-bottom:1px solid black;"> FINE WAIVER </th> -->
            <th rowspan="2" style="border-bottom:1px solid black;"> POS No. </th>
            <th rowspan="2" style="border-bottom:1px solid black;"> Receipt No</th>
            <th rowspan="2" style="border-bottom:1px solid black;"> TOTAL AMOUNT </th>  
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
                     
                     
                </tr>
             </thead>
             <tbody id="monthlyfees_load_td">
                  <?php 
                  $i=1;
                  $total_fee_amt=0;$trans_amt_total=0;$fine_amt_total=0;$disc_amt_total=0;$readmsnamttot=0;
                  foreach($fetch_transaction_date as $ftd) {

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
                  
                                         
                     <td><?php echo $i;?></td>
                     <?php if($c_centre_name=='Feesclub') { ?>
                     <td><?php echo $ftd->transaction_id;?></td>
                   <?php } ?>
                     <td><?php echo $ftd->admission_no;?></td>
                     <td><?php echo $ftd->name;?></td>
                     <td><?php echo $class[$ftd->class_id].'  '.$section[$ftd->section_id];?></td>
                     <td><?php $m=array();$m=explode(',',$ftd->month_details);
                     $str='';

                      $fi = reset($m);
                      $last = end($m);
                      if($fi==0)
                      {
                        $first=$m[1];
                      }
                      else{
                        $first=$fi;
                      }
                     foreach($m as $v) 
                      { 

                        $str.=$month_arr[$v].' ';
                  } 

                  if($first==1)
            {
              $aaa="Apr";
            }
            if($first=='2')
            {
              $aaa="May";
            }
            if($first=='3')
            {
              $aaa="Jun";
            }
            if($first=='4')
            {
              $aaa="July";
            }
            if($first=='5')
            {
              $aaa="Aug";
            }
            if($first=='6')
            {
              $aaa="Sep";
            }
             if($first=='7')
            {
              $aaa="Oct";
            }
             if($first=='8')
            {
              $aaa="Nov";
            }
             if($first=='9')
            {
              $aaa="Dec";
            }
             if($first=='10')
            {
              $aaa="Jan";
            }
              if($first=='11')
            {
              $aaa="Feb";
            }
            if($first=='12')
            {
              $aaa="Mar";
            }


             if($last==1)
            {
              $bbb="Apr";
            }
            if($last=='2')
            {
              $bbb="May";
            }
            if($last=='3')
            {
              $bbb="Jun";
            }
            if($last=='4')
            {
              $bbb="July";
            }
            if($last=='5')
            {
              $bbb="Aug";
            }
            if($last=='6')
            {
              $bbb="Sep";
            }
             if($last=='7')
            {
              $bbb="Oct";
            }
             if($last=='8')
            {
              $bbb="Nov";
            }
             if($last=='9')
            {
              $bbb="Dec";
            }
             if($last=='10')
            {
              $bbb="Jan";
            }
              if($last=='11')
            {
              $bbb="Feb";
            }
            if($last=='12')
            {
              $bbb="Mar";
            }

            if($aaa==$bbb)
            {
              $mn_det=$aaa;
            }
            else
            {
              $mn_det=$aaa.'-'.$bbb;
            }

                  echo $mn_det;?></td>
                  <!-- echo $first.'-'.$last;?></td> -->
                      <?php $total=0;foreach($fee_ty as $d=>$v) {
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

                            }
                            else if($fee_cat_id[$d]==3){
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
                    
                     <!-- <td><?php $disc_amt_total+=$ftd->discount_amount ; echo $ftd->discount_amount;?></td> -->
                     <td><?php echo $ftd->pos_no;?></td>
                     <td><?php echo $ftd->receipt_no;?></td>
                      <td><?php echo $ftd->total_amount;?></td>
                </tr>
                
      
                 <?php $i++; } ?>
                <tr style="border: 0.0001px solid grey;">
                    <?php if(!is_array($rmvcol) || !in_array('fee_cat', $rmvcol)) {?><th style="border: 0.0001px solid grey;">Total</th><?php }?>
                    <th style="border: 0.0001px solid grey;">Total</th>                    
                    <?php if($c_centre_name=='Feesclub') { ?>
                     <th style="border: 0.0001px solid grey;"></th>
                   <?php } ?>
                   
                  
                    <th style="border: 0.0001px solid grey;"></th>
                    <th style="border: 0.0001px solid grey;"></th>
                    <th style="border: 0.0001px solid grey;"></th>
                    <?php foreach($fee_ty as $d=>$v) {
                        if(!is_array($rmvcol1) || !in_array($d, $rmvcol1)) {?>
                    <th style="border: 0.0001px solid grey;"> <?php echo $total_fee_amt_wise[$d]; ?> </th>
                        <?php }} ?>
                    <?php if($trans_status=='YES'){?>
                     <th style="border: 0.0001px solid grey;"> <?php echo $trans_amt_total;?></th>
                    <?php }?>
                    <th style="border: 0.0001px solid grey;"><?php echo $fine_amt_total;?></th>
                    
                    <!-- <th style="border: 0.0001px solid grey;"><?php echo $disc_amt_total;?></th> -->
                    <th style="border: 0.0001px solid grey;"></th>
                    <th style="border: 0.0001px solid grey;"></th>
                     <th style="border: 0.0001px solid grey;"><?php echo $total_fee_amt;?></th>
                </tr>
                
             </tbody>
        </table>
        
        
       </div>
    </form>




    <?php 

     $total_cash_amt=$tot_mode[1];
     $total_pos_amt=$tot_mode[4];
     $total_dc_amt=$tot_mode[5];
     $total_cc_amt=$tot_mode[6];
     $total_nb_amt=$tot_mode[7];
     $total_online=$total_dc_amt + $total_cc_amt +$total_nb_amt;
    $this->load->library('numbertowords');
        $wordssamt=strtoupper($this->numbertowords->convert_number_dcr($total_fee_amt) . ' only');
     ?>


     <div style="width:100%;font-size: 18px">
        <div style="width:70%;float:left;padding-top: 100px;">
                <p><b>COLLECTION STATEMENT SUMMARY</b></p>
                <p>Total Cancelled Receipt : <?php echo $total_cancel_receipt; ?></p>
                <p>Amount Collected in Figures : Rs <?php echo $total_fee_amt; ?></p>
                <!-- <p>Amount Collected in Figures : Rs <?php echo $amttfig; ?></p> -->
                <p>Amount Collected in Words : <?php echo $wordssamt; ?></p>
                <p>Total Amount Collected by Cash of Rs <?php echo $total_cash_amt; ?>  , Collected POS Rs <?php echo $total_pos_amt; ?></p>
                <p>Total Amount Collected by Cheque of Rs , Collected Online Rs <?php echo $total_online; ?> </p>
                <p>Amount Deposited in Bank : Rs_____________________________</p>
                <p>Date of Deposit : ____/____/__________</p>
                <p>Balance Cash in Hand : Rs_____________________________</p>
        </div>
          <div style="width:30%;float:right;padding-top: 100px;">
              <div style="border:1px solid">
                  <p>&nbsp;&nbsp;&nbsp;Rs ___________________________________</p>
                  <p>&nbsp;&nbsp;&nbsp;In Custody of ________________________________</p>
                  <p style="text-align:center">Signature</p>
              </div>
        </div>
      
    </div>
      <div style="width:100%;padding-top: 500px;font-size: 18px"> 
     <p><span><b>Prepared By:</b>----------------</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><b>Checked By:</b>------------------</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><b>Accountant:</b>------------------</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><b>Principal:</b>------------------</span></p>
  </div>
       </div>
        <br>
          <?php 
          if(function_exists('date_default_timezone_set')) {
            date_default_timezone_set("Asia/Kolkata");
          }

            $date = date("d/m/Y");
            $date1 =  date("H:i a");?>
          <p>Printed on Date : <?php echo $date; ?> at <?php echo $date1; ?></p>
    </form>
  <!-- <div style="page-break-after: always;"></div> -->
     


<script type="text/php">
    if ( isset($pdf) ) {
        $text = 'Page: {PAGE_NUM} of {PAGE_COUNT}';
        $font = Font_Metrics::get_font("Times New Roman", "regular");

        $pdf->page_text(1550, 20, $text, $font, 12);
    }
</script>
