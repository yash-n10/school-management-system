<div class="table-responsive">
<table id="studentlist1" class="table table-bordered table-striped" style="width:100%">
    <thead>
<?php $y=date('y');?>

        <tr>
            <th> Adm No </th>
            <th> Stud Name </th>
            <th> Class </th>
            <th>Apr'<?=$y;?> Rcpt No.</th>
            <th>Apr'<?=$y;?> Amt</th>
            <th>Apr'<?=$y;?> Pay Dt</th>
            <th>May'<?=$y;?> Rcpt No.</th>
            <th>May'<?=$y;?> Amt</th>
            <th>May'<?=$y;?> Pay Dt</th>
            <th>Jun'<?=$y;?> Rcpt No.</th>
            <th>Jun'<?=$y;?> Amt</th>
            <th>Jun'<?=$y;?> Pay Dt</th>
            <th>Jul'<?=$y;?> Rcpt No.</th>
            <th>Jul'<?=$y;?> Amt</th>
            <th>Jul'<?=$y;?> Pay Dt</th>
            <th>Aug'<?=$y;?> Rcpt No.</th>
            <th>Aug'<?=$y;?> Amt</th>
            <th>Aug'<?=$y;?> Pay Dt</th>
            <th>Sep'<?=$y;?> Rcpt No.</th>
            <th>Sep'<?=$y;?> Amt</th>
            <th>Sep'<?=$y;?> Pay Dt</th>
            <th>Oct'<?=$y;?> Rcpt No.</th>
            <th>Oct'<?=$y;?> Amt</th>
            <th>Oct'<?=$y;?> Pay Dt</th>
            <th>Nov'<?=$y;?> Rcpt No.</th>
            <th>Nov'<?=$y;?> Amt</th>
            <th>Nov'<?=$y;?> Pay Dt</th>
            <th>Dec'<?=$y;?> Rcpt No.</th>
            <th>Dec'<?=$y;?> Amt</th>
            <th>Dec'<?=$y;?> Pay Dt</th>
            <th>Jan'<?=$y+1;?> Rcpt No.</th>
            <th>Jan'<?=$y+1;?> Amt</th>
            <th>Jan'<?=$y+1;?> Pay Dt</th>
            <th>Feb'<?=$y+1;?> Rcpt No.</th>
            <th>Feb'<?=$y+1;?> Amt</th>
            <th>Feb'<?=$y+1;?> Pay Dt</th>
            <th>Mar'<?=$y+1;?> Rcpt No.</th>
            <th>Mar'<?=$y+1;?> Amt</th>
            <th>Mar'<?=$y+1;?> Pay Dt</th>
        </tr>
        
    </thead>
    <tbody id="annual_load_td1">
        
        <?php foreach ($query_defaulter as $row) {?>
        <tr>
            <td>  <?php echo $row->admission_no;?></td>
            <td> <?php echo $row->name;?></td>
            <td> <?php echo $row->class_name.'-'.$row->sec_name;?></td>
            <td><?php echo $row->apr_receipt_no;?> </td>
            <td> <?php echo $row->apr_total_amount;?></td>
            <td><?php echo $row->apr_payment_date;?> </td>
            <td><?php echo $row->may_receipt_no;?> </td>
            <td> <?php echo $row->may_total_amount;?></td>
            <td> <?php echo $row->may_payment_date;?></td>
            <td> <?php echo $row->jun_receipt_no;?></td>
            <td> <?php echo $row->jun_total_amount;?></td>
            <td> <?php echo $row->jun_payment_date;?></td>
            <td> <?php echo $row->jul_receipt_no;?></td>
            <td><?php echo $row->jul_total_amount;?> </td>
            <td><?php echo $row->jul_payment_date;?> </td>
            <td> <?php echo $row->aug_receipt_no;?></td>
            <td> <?php echo $row->aug_total_amount;?> </td>
            <td> <?php echo $row->aug_payment_date;?></td>
            <td> <?php echo $row->sep_receipt_no;?></td>
            <td> <?php echo $row->sep_total_amount;?></td>
            <td> <?php echo $row->sep_payment_date;?></td>
            <td> <?php echo $row->oct_receipt_no;?></td>
            <td> <?php echo $row->oct_total_amount;?></td>
            <td> <?php echo $row->oct_payment_date;?></td>
            <td> <?php echo $row->nov_receipt_no;?></td>
            <td> <?php echo $row->nov_total_amount;?></td>
            <td> <?php echo $row->nov_payment_date;?></td>
            <td> <?php echo $row->dec_receipt_no;?></td>
            <td> <?php echo $row->dec_total_amount;?></td>
            <td><?php echo $row->dec_payment_date;?> </td>
            <td> <?php echo $row->jan_receipt_no;?></td>
            <td> <?php echo $row->jan_total_amount;?></td>
            <td> <?php echo $row->jan_payment_date;?></td>
            <td><?php echo $row->feb_receipt_no;?> </td>
            <td> <?php echo $row->feb_total_amount;?></td>
            <td> <?php echo $row->feb_payment_date;?></td>
            <td> <?php echo $row->mar_receipt_no;?></td>
            <td> <?php echo $row->mar_total_amount;?></td>
            <td> <?php echo $row->mar_payment_date;?></td>
        </tr>

        
        <?php }?>
    </tbody>
</table>
</div>
<script>
    $('#studentlist1').DataTable(
            {
                "columnDefs": [ {
            "visible": false,
            "targets": -1
        } ],
                 dom: 'Bfrtip',
                 buttons: [
                                {
                                    extend: 'collection',
                                    text: 'Export',
                                    buttons: [
//                                        '<i class="fa fa-file-excel-o"></i>copy',
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
                                      
//
//
//
////                                        'copyFlash',
////                                        'csvFlash',
////                                        'excelFlash',
////                                        'pdfFlash',
////                                        'print'
                                    ],
                                    orientation: 'landscape',
                                        pageSize: 'LEGAL'
                                }
                            ],
//                                      dom: 'Bfrtip',
//        buttons: [
//            {
//                extend: 'pdfHtml5',
//                orientation: 'landscape',
//                pageSize: 'LEGAL'
//            }
//        ]
                            
//                        serverSide: true,    
                            
            });
// var table =$('#studentlist').DataTable( {
////                                
//                                "scrollY": "300px",
//                                "scrollX": true,
//                                "scrollCollapse": true,
//                                "paging":         false,
//
//                            } );
    </script>