 <form id='frmtemplate' role="form" method="POST">
        <table id="studentlist1" class="table table-bordered table-striped"  style="margin-top: 25px;">
            <thead>
            <tr>
                <th> Payment Date </th>
                <th> Admission No </th>
                <th> Student Name </th>
                <th> Class </th>
                <th> Section </th>
                <th> Description </th>
                <th> Total Paid Amount</th>
                <th> Remarks </th> 
                <th> Transaction Id </th>
                <th> Payment Id </th>
                <th> Payment Method </th>  
                <th> Receipt No </th>
            </tr>
            
            </thead>
            <tbody id="annual_load_td">
                <?php 
                    for($i=0;$i<$cnt;$i++) {
                        ?>
                                    <tr>
                                            <td><?php echo $date[$i];?></td>
                                            <td> <?php echo $admsn_no[$i];?> </td>
                                            <td> <?php echo $name[$i];?> </td>
                                            <td> <?php echo $class_id[$i];?></td>
                                            <td> <?php echo $section_id[$i];?></td>
                                            <td> <?php echo $description[$i];?></td>
                                            <td> <?php echo $total[$i];?></td>
                                            <td> <?php echo $remarks[$i];?> </td>
                                            <td> <?php echo $transaction_id[$i];?> </td>
                                            <td> <?php echo $payment_id[$i];?> </td>
                                            <td> <?php echo $mode_payment[$i];?> </td>
                                            <td> <?php echo $receipt_no[$i];?> </td>
                                            
                                            
                                            <!--<td> Unpaid </td>-->
                                    </tr>
                    <?php } ?>
            </tbody>
        </table>
</form>
<script>
    $('#studentlist1').DataTable(
            {
                 dom: 'Bfrtip',
                 buttons: [
                                {
                                    extend: 'collection',
                                    text: 'Export',
                                    buttons: [
//                                        '<i class="fa fa-file-excel-o"></i>copy',
                                        'excel',
                                        'csv',
                                        'pdf',
                                        'print'



//                                        'copyFlash',
//                                        'csvFlash',
//                                        'excelFlash',
//                                        'pdfFlash',
//                                        'print'
                                    ]
                                }
                            ],
                            
                            
//                        serverSide: true,    
                            
            });
    
    </script>