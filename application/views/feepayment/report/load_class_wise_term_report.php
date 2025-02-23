 <style>
    .dt-button.red {
        color: darkgreen;
        font-weight: bold;
    }
</style>   
<form id="frmstudent3" role="form" method="POST">
<div class='table-responsive'>
    <table id="studentlist3" class="table table-bordered table-striped">
        <caption id="tabletitle2" style="text-align:center">CLASS WISE TERM REPORT</caption>
        <thead>
            <tr> 
                <th rowspan="2"> Class</th>
                <th rowspan="2"> Section </th>
                <th colspan="2" style="text-align: center"> Term</th>
                <th rowspan="2"> Grand Total </th>
                <th colspan="<?php echo count($paymodeqry);?>" style="text-align: center;border-bottom:1px solid black"> Mode</th>

            </tr>
            <tr>
                <th> Annual </th>
                <th> Monthly </th>
                <?php $tot_mode=array();foreach ($paymodeqry as $p) { $tot_mode[$p->id]=0;?>
                        <th> <?php echo $p->mode_name;?> </th>
                    <?php }?>
            </tr>

        </thead>
         <tbody id="classsect_load_td">
            <?php for($i=0;$i<$cnti;$i++){
                            for($j=0;$j<$cntj[$i];$j++) {?>
                            <tr>
                              
                                <td><?php echo $class[$i][$j];?></td>
                                <td><?php echo $section[$i][$j];?></td>
                                <td><?php echo $annual_amount[$i][$j];?></td>
                                <td><?php echo $monthly_amount[$i][$j];?></td>
                                <td><?php echo $grand_total[$i][$j];?></td>
                                <?php foreach ($paymodeqry as $p) { $tot_mode[$p->id] += $mode[$i][$j][$p->id];?>
                                    <th> <?php if($mode[$i][$j][$p->id]!=''){echo $mode[$i][$j][$p->id].' INR';}?> </th>
                                <?php }?>
                                
                            </tr>

                  <?php  $cls= $class[$i][$j]; }?>
                  
                  
                            <tr>
                                
                                <th style="border-bottom:1px solid black;"><?php echo $cls.' Total';?></th>
                                <th style="border-bottom:1px solid black;"></th>
                                <th style="border-bottom:1px solid black;"><?php echo $total_annual_amt[$i];?></th>
                                <th style="border-bottom:1px solid black;"><?php echo $total_monthly_amt[$i];?></th>
                                <th style="border-bottom:1px solid black;"><?php echo $total_grand_amt[$i];?></th>
                                <?php foreach ($paymodeqry as $p) {?>
                                <th style="border-bottom:1px solid black;"> <?php if($tot_mode[$p->id]!=''){echo $tot_mode[$p->id].' INR';}?> </th>
                            <?php }?>
                                
                            </tr>
                  
                  
                 <?php }?>
         </tbody>
    </table>

</div>
</form>

<?php //if($this->session->userdata('school_id')==5) { ?>
<script>
    $('#studentlist3').DataTable(
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
    <?php // } else { } ?>