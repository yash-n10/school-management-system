<div class="responsive">
<table id="studentlist" class="table table-bordered table-striped" style="width:100%">
    <thead>
    <tr>
        <th> Admission No </th>
        <th> Student Name </th>
        <th> Class </th>
        <th> Section </th>
        <th> Fees Category </th>
        <th> Annual Fees Status </th>
        <th> No. Of Paid Month</th>
        <?php if($schoolgrp=='ARMY') {?>
        <th> No. Of Paid Qtr</th>
        <?php }?>
    </tr>
    </thead>
    <tbody id="annual_load_td">
        <?php for($k=0;$k<$cnt;$k++){?>
        <tr>
            <td><?php  echo $admsn_no[$k];?></td>
            <td><?php  echo $name[$k];?></td>
            <td><?php  echo $class_id[$k];?></td>
            <td><?php  echo $section_id[$k];?></td>
            <td><?php  echo $studcat_id[$k];?></td>
           <?php if($annual[$k]=='Paid'){ $value='PAID' ; $class='btn-success';}else if($annual[$k]=='Unpaid'){ $value='UNPAID' ; $class='btn-danger';} ?>
            <td><div class='btn <?php echo $class;?>' style='width:50%'><?php echo $value;?></div>


            </td>
            <th><div class='btn btn-warning' style='border-radius: 50%;background-color:bisque;font-weight:bolder;color:black'><?php  echo $month[$k];?></div></th>
            <?php if($schoolgrp=='ARMY') {
                            if($start_fee_month[$k]!= '1'){
                                 $mn=$month[$k]+($start_fee_month[$k]-1);
                            }
                            else{
                                 $mn = ($month[$k] );
                            }
                            if ($month_arr[$mn] == $month_arr[$month]) 
                            {
                                $h = ' Quarter paid-(' . $month_arr[$start_fee_month[$k]] . ' to ' . $month_arr[$month[$k]] . ')';
                            } 
                            else 
                            {
                                $h = ' Quarter paid-(' . $month_arr[$start_fee_month[$k]] . ' to ' . $month_arr[$mn] . ')';
                            }
                ?>
            <th><div class='btn btn-warning' style='border-radius: 50%;background-color:bisque;font-weight:bolder;color:black'><?php  echo ($month[$k]+($start_fee_month[$k]-1))/3 .''.$h;?></div></th>
            <?php }?>
        </tr>
        <?php  }?>
    </tbody>
</table>
</div>
<script>
//    $('#studentlist').DataTable(
//            {
//                 dom: 'Bfrtip',
//                 buttons: [
//                                {
//                                    extend: 'collection',
//                                    text: 'Export',
//                                    buttons: [
//                                        'excel',
//                                        'csv',
//                                        'pdf',
//                                        'print'
//
//                                        '<i class="fa fa-file-excel-o"></i>copy',
//
//
////                                        'copyFlash',
////                                        'csvFlash',
////                                        'excelFlash',
////                                        'pdfFlash',
////                                        'print'
//                                    ]
//                                }
//                            ],
                            
                            
//                        serverSide: true,    
                            
//            });
 var table =$('#studentlist').DataTable( {
//                                
                                "scrollY": "300px",
                                "scrollX": true,
                                "scrollCollapse": true,
                                "paging":         false,

                            } );
    </script>