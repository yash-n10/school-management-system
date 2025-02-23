<style>
    .dt-button.red {
        color: darkgreen;
        font-weight: bold;
    }
</style>

<form id="frmstudent1" role="form" method="POST">
       <div class="table-responsive">
        <table id="studentlist1" class="table table-bordered table-striped">
            <!-- <h2>Daily Collection Report as on <?php //echo $dateee; ?></h2> -->
            <thead>
                <tr>
                    <th colspan="11"></th>
                    <th colspan="12">Daily Collection Report as on <?php echo $dateee; ?></th>
                    <th colspan="11"></th>
                </tr>
                <tr> 
                    <th rowspan="2" style="border-bottom:1px solid black;"> ADMISSION NO. </th>
                    <th rowspan="2" style="border-bottom:1px solid black;"> NAME </th>
                    <th rowspan="2" style="border-bottom:1px solid black;"> CLASS </th>
                    <th rowspan="2" style="border-bottom:1px solid black;"> CATEGORY </th>
                    <?php if($trans_status=='YES'){?>
            <th colspan="<?php echo count($fee_details['fee_ty'])+3?>" style="text-align: center;border-bottom:1px solid black;"> FEE TYPE</th>
            <?php }else{?>
            <th colspan="<?php echo count($fee_details['fee_ty'])+2?>" style="text-align: center;border-bottom:1px solid black;"> FEE TYPE</th>
            <?php }?>
                    <th rowspan="2" style="border-bottom:1px solid black;"> Instant Discount </th>
                     <th rowspan="2" style="border-bottom:1px solid black;"> Receipt No </th>
                    <th rowspan="2" style="border-bottom:1px solid black;"> TOTAL FEE </th>
                </tr> 
                <tr>
                    <?php foreach($fee_details['fee_ty'] as $d) { ?>
                    <th style="border-bottom:1px solid black;"> <?php echo $fee_details['f_name'][$d->id]; ?> </th>
                    <?php } ?>
                    <?php if($trans_status=='YES'){?>
                     <th style="border-bottom:1px solid black;"> Transport Fee </th>
                      <?php }?>
                     <th style="border-bottom:1px solid black;"> Fine </th>
                     <th style="border-bottom:1px solid black;"> Re-Admission-Fine </th>
                     
                </tr>
             </thead>
             <tbody id="daily_load_td">
                  <?php for($k=0;$k<$fee_details['stud_cnt'];$k++) { ?>                 
                 <tr>
                     <td><?php echo $fee_details['admission'][$k];?></td>
                     <td><?php echo $fee_details['studname'][$k];?></td>
                     <td><?php echo $fee_details['studclass'][$k];?></td>
                     <td><?php echo $fee_details['stud_cat'][$k];?></td>
                      <?php foreach($fee_details['fee_ty'] as $d) { ?>
                     <td><?php echo $fee_details['fee_amnt'][$k][$d->id];?></td>
                     <?php } ?>
                     <?php if($trans_status=='YES'){?>
                     <td><?php echo $fee_details['transport_amt'][$k];?></td>
                     <?php }?>
                     <td><?php echo $fee_details['fine'][$k];?></td>
                     <td><?php echo $fee_details['readmsnfine'][$k];?></td>
                     <td><?php echo $fee_details['instant_discount'][$k];?></td>
                     <td><?php echo $fee_details['receipt_no'][$k];?></td>
                     <td><?php echo $fee_details['total1'][$k];?></td>
                </tr>
      
                 <?php } ?>
                 
             </tbody>
             <tfoot>
                 <tr>
                     <th colspan="34">COLLECTION STATEMENT SUMMARY</th>
                 </tr>
                 <tr>
                     <th colspan="34">Total Cancelled Receipt : 0</th>
                 </tr>
                 <tr>
                     <th colspan="34">Amount Collected in Figures : Rs <?php echo sum($fee_details['total1']);?></th>
                 </tr>
                  <tr>
                     <th colspan="34">Amount Collected in Words :</th>
                 </tr>
                 <tr>
                     <th colspan="34">Total Amount Collected by Cash of Rs <?php echo $tot_mode; ?> , Collected POS </th>
                 </tr>
                  <tr>
                      <th colspan="34">Total Amount Collected by Cheque of Rs , Collected Online </th>
                 </tr>
             </tfoot>
        </table>
     
       </div>
    </form>
<script>
    var table=$('#studentlist1').DataTable(
            {
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
                                            pageSize: 'A1'
                                        },
                                        {
                                            extend: 'print',
                                            orientation: 'landscape',
                                            pageSize: 'A1'
                                        },
                                    ]
                                }
                            ]

                            
            });
    </script>