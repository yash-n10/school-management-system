<form id='frmtemplate1' role="form" method="POST">
                     <table id="studentlist1" class="table table-bordered table-striped" style="margin-top: 25px;">
                         <thead>
                         <tr>
                             <th> Student Id </th>
                             <th> Admission No </th>
                             <th> Student Name </th>
                             <th> Class </th>
                             <th> Section </th>
                             <!--<th> Month </th>-->
                             <th> Total Amount </th>
                             <th> Status </th>
                         </tr>
                         </thead>
                         <tbody id="month_load_td">
                <?php 
                    for($j=0;$j<$cnt1;$j++) {
                        ?>
                                    <tr>
                                            <td> <?php echo $student_id[$j];?> </td>
                                            <td> <?php echo $admsn_no[$j];?> </td>
                                            <td> <?php echo $name[$j];?> </td>
                                            <td> <?php echo $class_id[$j];?></td>
                                            <td> <?php echo $section_id[$j];?></td>
                                            <!--<th> <?php // echo $total[$i];?> </th>-->
                                            <td> <?php echo $total[$j];?> </td>
                                            <td> Unpaid</td>
                                    </tr>
                    <?php } ?>
            </tbody>
                     </table>
</form>
<script>
    $('#studentlist1').DataTable(
             {
                 // dom: 'Bfrtip',
                 // buttons: [
                 //                {
                 //                    extend: 'collection',
                 //                    text: 'Export',
                 //                    buttons: [
                 //                        'excel',
                 //                        'csv',
                 //                        'pdf',
                 //                        'print'
                 //                    ]
                 //                }
                 //            ],
            }
            
            
            );
    
    </script>