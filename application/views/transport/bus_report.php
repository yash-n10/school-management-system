<div class="form-group has-feedback">
    <div class="box">

        <div class="box-body">

<!--            <div class="col-sm-12 col-md-12">
               
                <div class="" style="float:right;" id="div_change">
                            <a class="btn btn-success" id="paylog_export" href="<?php // echo base_url("Report/exportpaymentlog/all/all/all/all"); ?>" download>
                                <i class="fa fa-cloud-download fa-lg"></i>&nbsp; Export 
                            </a>
                        </div> 
            </div>-->

            

            <div class="col-sm-12 col-md-12" id="annual_load"  style="padding-top: 3%;">

                <form id='frmtemplate' role="form" method="POST">
                    <table id="buslist" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th> Admission No </th>
                                <th> Student Name </th>
                                <th> Class </th>
                                <th> Section </th>
                                <th> Roll No </th>
                                <th> Bus No </th>
                                <th> Bus Route</th>
                                <th> Bus Pickup Point</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bus_data as $value) {?>
                                     
                            
                            <tr>
                                <td><?php echo $value->admission_no;?> </td>
                                <td><?php echo $value->first_name;?>  </td>
                                <td><?php echo $value->class_name;?>  </td>
                                <td><?php echo $value->sec_name;?>  </td>
                                <td><?php echo $value->roll;?>  </td>
                                <td><?php echo $value->vehicle_no;?>  </td>
                                <td><?php echo $value->route_code;?>  </td>
                                <td><?php echo $value->location_description;?>  </td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </form>


            </div>


        </div>


    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
<script>
    $(document).ready(function ()
    {
    $('#buslist').DataTable(
            {
//             lengthChange: false,
             dom: 'Bfrtip',
                 buttons: [
//                            'excel', 'pdf', 'csv' 
                                {
                                    extend: 'collection',
                                    text: 'Export',
                                    className: 'red',
                                    buttons: [
                              
//                                        '<i class="fa fa-file-excel-o"></i>copy',
                                        'excel',
                                        'csv',
                                        'pdf',
                                        'print'
//
//
//
////                                        'copyFlash',
////                                        'csvFlash',
////                                        'excelFlash',
////                                        'pdfFlash',
////                                        'print'
                                    ]
                                }
                            ]

//                          caption: caption{
//                          'Title'
//                          }  
//                        serverSide: true,    
                            
            });
            });
//            table.buttons().container()
//        .appendTo( '#studentlist1_wrapper .col-sm-6:eq(0)' );    
    </script>