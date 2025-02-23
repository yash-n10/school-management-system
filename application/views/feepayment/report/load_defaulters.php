 <form id='frmtemplate' role="form" method="POST">
        <table id="studentlist" class="table table-bordered table-striped"  style="margin-top: 25px;">
            <thead>
            <tr>
                <th> Admission No </th>
                <th> Student Name </th>
                <th> Class </th>
                <th> Section </th>
                <th> Annual</th>
                <th> Monthly </th>
                <!-- <th> Transport </th> -->
                <th> Total Unpaid Amount</th>
            </tr>
            </thead>
            <tbody id="annual_load_td">
                <?php 
                    for($i=0;$i<$cnt;$i++) { ?>
                                    <tr>
                                            <td> <?php echo $admsn_no[$i];?> </td>
                                            <td> <?php echo $name[$i];?> </td>
                                            <td> <?php echo $class_id[$i];?> </td>
                                            <td> <?php echo $section_id[$i];?></td>
                                            <td> <?php echo $annual[$i];?></td>
                                            <td> <?php echo $month[$i];?></td>
                                            <!-- <td> <?php echo $month[$i];?></td> -->
                                            <td> <?php // echo $total[$i];?> </td>
                                          
                                    </tr>
                    <?php } ?>
            </tbody>
        </table>
</form>
<script>
    $('#studentlist').DataTable(
            {
                 dom: 'Bfrtip',
                 buttons: [
                                {
                                    extend: 'collection',
                                    text: 'Export',
                                    buttons: [
                                        '<i class="fa fa-file-excel-o"></i>copy',
                                        'excel',
                                        'csv',
                                        'pdf',
                                        'print'



//                                        'copyFlash',
                                        'csvFlash',
                                        'excelFlash',
                                        'pdfFlash',
                                        'print'
                                    ]
                                }
                            ],
                            
                            
                        serverSide: true,    
                            
            });
    
    </script>