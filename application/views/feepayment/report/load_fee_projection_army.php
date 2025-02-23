 <form id='frmtemplate' role="form" method="POST">
        <table id="studentlist2" class="table table-bordered table-striped"  style="margin-top: 25px;">
            <thead>
            <tr>
            <th> SNo </th>
            <th> Class </th>
            <th> Section </th>
            <th> Strength </th>
            <th> Estimated <?php echo $mnth;?> Fee </th>
            <th> Collected <?php echo $mnth;?> Fee</th>
            <th> Balance For <?php echo $mnth;?> <br> (Estimated-Collected)</th>
            <!-- <th> Status </th>  -->
            </tr>
            </thead>
            <tbody>
                <?php 
                $sum_strength=0;
                $sum_estimated=0;
                $sum_collected=0;
                $sum_balance=0;
                $sno=1;
                    for($i=0;$i<$cnti;$i++) {

                         for($j=0;$j<$cntj[$i];$j++) {
                             $sum_strength=$sum_strength+$strength[$i][$j];
                             $sum_estimated=$sum_estimated+$estimated[$i][$j];
                             $sum_collected=$sum_collected+$collected[$i][$j];
                             $sum_balance=$sum_balance+$balance[$i][$j];
                        ?>
                
                                    <tr>
                                        <td><?php echo $sno;?></td>
                                            <td><?php echo $class[$i][$j]; ?></td>
                                            <td><?php echo $section[$i][$j]; ?> </td>
                                            <td><?php echo $strength[$i][$j]; ?> </td>
                                            <td><?php echo $estimated[$i][$j]; ?></td>
                                            <td><?php echo round($collected[$i][$j]); ?></td>
                                            <td><?php echo round($balance[$i][$j]); ?></td>
                                            <!-- <td></td> -->
                                    </tr>
                    <?php 
                            $sno++;
                        }
                    
                        } ?>
                                    <tr>
                                        <td><?php // echo $sno;?></td>
                                            <th>Total</th>
                                            <th> </th>
                                            <th> <?php echo $sum_strength; ?> </th>
                                            <th> <?php echo $sum_estimated. ' INR'; ?></th>
                                            <th> <?php echo round($sum_collected).' INR'; ?></th>
                                            <th> <?php echo round($sum_balance).' INR'; ?></th>
                                            <!-- <th> </th> -->
                                    </tr>
            </tbody>
        </table>
</form>
<script>

	$(document).ready(function()
{
    datatable();


    function datatable()
        {

           $('#studentlist2').DataTable({


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
                                            orientation: 'portrait',
                                            pageSize: 'A4'
                                        },
                                        {
                                            extend: 'print',
                                            orientation: 'portrait',
                                            pageSize: 'A4'
                                        },
                                    ]
                                }
                            ],
               
            });
            }

            });
     // $('#studentlist2').DataTable(
     //        {
     //            dom: 'Bfrtip',
     //            buttons: [
     //                           {
     //                               extend: 'collection',
     //                               text: 'Export',
     //                               buttons: [
     //                                   'csvFlash',
     //                                   'excelFlash',
     //                                   'pdfFlash',
     //                                   'print'
     //                               ]
     //                           }
     //                       ],
                            
                            
     //        });
    
    </script>