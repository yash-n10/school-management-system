 <style>
    .dt-button.red {
        color: darkgreen;
        font-weight: bold;
    }
</style>   
<form id="frmstudent2" role="form" method="POST">

    <div class='table-responsive'>
    <table id="studentlist2" class="table table-bordered table-striped">
        <caption id="tabletitle1" style="text-align:center">CATEGORY WISE TERM REPORT</caption>
        <thead>
<!--            <tr>
                <th colspan="5" id="tabletitle1" style="text-align:center"> CATEGORY WISE TERM REPORT </th> 
            </tr>-->
            <tr> 
                <th rowspan="3"> Category </th>
                <th colspan="3" style="text-align: center"> Term</th>
                <th rowspan="3"> Grand Total </th>
                <th colspan="<?php echo count($paymodeqry);?>" style="text-align: center;border-bottom:1px solid black"> Mode</th>
            </tr>
            <tr>
                <th> Onetime </th>
                <th> Annual </th>
                <th> Quarterly </th>
                <?php $tot_mode=array();foreach ($paymodeqry as $p) { $tot_mode[$p->id]=0;?>
                        <th> <?php echo $p->mode_name;?> </th>
                    <?php }?>
            </tr>

        </thead>
         <tbody id="category_load_td">
                <?php for($i=0;$i<$cnti;$i++){?>
                 
                 <tr>
                     <td><?php echo $category_list[$i];?></td>
                     
                     
                     <td><?php if($onetime_amount[$i]!='') {echo $onetime_amount[$i].' INR';};?></td>
                     <td><?php if($annual_amount[$i]!='') {echo $annual_amount[$i].' INR';};?></td>
                     <td><?php if($monthly_amount[$i]!=''){echo $monthly_amount[$i].' INR';};?></td>
                     <td><?php echo $grand_total[$i].' INR';?></td>
                     <?php foreach ($paymodeqry as $p) { $tot_mode[$p->id] += $mode[$i][$p->id];?>
                        <td> <?php if($mode[$i][$p->id]!=''){echo $mode[$i][$p->id].' INR';}?> </td>
                    <?php }?>
                 </tr>
                 
                 <?php }?>
                 <tr>
                     <th>TOTAL</th>
              
                     
                     <th><?php echo $total_onetime_amt.' INR';?></th>
                     <th><?php echo $total_annual_amt.' INR';?></th>
                     <th><?php echo $total_monthly_amt.' INR';?></th>
                     <th><?php echo $total_grand_amt.' INR';?></th> 
                     <?php foreach ($paymodeqry as $p) {?>
                        <th> <?php if($tot_mode[$p->id]!=''){echo $tot_mode[$p->id].' INR';}?> </th>
                    <?php }?>
                 </tr>
         </tbody>
    </table>

    </div>
</form>


<?php //if($this->session->userdata('school_id')==5) { ?>

<script>
    $('#studentlist2').DataTable(
            {
//             lengthChange: false,
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
                                            pageSize: 'A4'
                                        },
                                        {
                                            extend: 'print',
                                            orientation: 'landscape',
                                            pageSize: 'A4'
                                        },
                                    ]
                                }
                            ]
                            
                            
//                        serverSide: true,    
                            
            });
             //            table.buttons().container()
//        .appendTo( '#studentlist1_wrapper .col-sm-6:eq(0)' );    
    </script>

     <?php //} else { } ?>