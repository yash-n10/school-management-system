<style>
    .dt-button.red {
        color: darkgreen;
        font-weight: bold;
    }
</style>
<form id="frmstudent2" role="form" method="POST">
<div class="table-responsive">
<table id="studentlist2" class="table table-bordered table-striped">
    <thead>
        <tr> 

            <th rowspan="2" style="border-bottom:1px solid black;"> ADMISSION NO. </th>
            <th rowspan="2" style="border-bottom:1px solid black;"> NAME </th>
            <th rowspan="2" style="border-bottom:1px solid black;"> CLASS </th>

            <th rowspan="2" style="border-bottom:1px solid black;"> CATEGORY </th>
            <?php if($trans_status=='YES'){?>
            <th colspan="<?php echo count($monthly_fee['fee_ty'])+3?>" style="text-align: center;border-bottom:1px solid black;"> FEE TYPE</th>
            <?php }else{?>
            <th colspan="<?php echo count($monthly_fee['fee_ty'])+2?>" style="text-align: center;border-bottom:1px solid black;"> FEE TYPE</th>
            <?php }?>
            <th rowspan="2" style="border-bottom:1px solid black;"> TOTAL FEE </th>
        </tr>
        <tr>


           <?php foreach($monthly_fee['fee_ty'] as $d) { ?>
                    <th style="border-bottom:1px solid black;"> <?php echo $monthly_fee['f_name'][$d->id]; ?> </th>
          <?php } ?>
                    <?php if($trans_status=='YES'){?>
                    <th style="border-bottom:1px solid black;">Transport Fee </th>
                    <?php }?>
                    <th style="border-bottom:1px solid black;">Fine </th>
                    <th style="border-bottom:1px solid black;">Re-Admission-Fine </th>
        </tr>

    </thead>
     <tbody id="monthly_load_td">
            <?php for($i=0;$i<$monthly_fee['stud_cnt'];$i++){?>
                 
                 <tr>
                     <td><?php echo $monthly_fee['admission'][$i];?></td>
                     <td><?php echo $monthly_fee['studname'][$i];?></td>
                     <td><?php echo $monthly_fee['studclass'][$i];?></td>
                     <td><?php echo $monthly_fee['stud_cat'][$i];?></td>
                      <?php foreach($monthly_fee['fee_ty'] as $d) { ?>
                     <td><?php echo $monthly_fee['fee_amnt'][$i][$d->id];?></td>
                      <?php } ?>
                     <?php if($trans_status=='YES'){?>
                     <td><?php echo $monthly_fee['transport_amt'][$i];?></td>
                     <?php }?>
                     <td><?php echo $monthly_fee['fine'][$i];?></td>
                     <td><?php echo $monthly_fee['readmsnfine'][$i];?></td>
                     <td><?php echo $monthly_fee['total1'][$i];?></td>
                 </tr>
                  <?php } ?>
     </tbody>
</table>

</div>
</form>  



<script>
    $('#studentlist2').DataTable(
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
//            table.buttons().container()
//        .appendTo( '#studentlist1_wrapper .col-sm-6:eq(0)' );    
    </script>