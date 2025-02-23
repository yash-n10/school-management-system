<div class="form-group">
    <div class='box'>
        <div class='box-header form-group'>
            <form id="export-form" action="<?php echo base_url("feepayment/Report/settle_report"); ?>" method="POST">
                <div class="col-sm-12 col-md-12">
                    <table class="table" >
                        <tr>
                            <th class="col-md-2" style="border:0px !important;text-align: center">From Date</th>
                            <td class="col-md-2" style="border:0px !important"><input type="date" name="from_date" class="form-control" required value="<?= set_value('from_date') ?>" min="<?php echo $school_date_created;?>"></td>
                            <th class="col-md-2" style="border:0px !important;text-align: center">To Date</th>
                            <td class="col-md-2" style="border:0px !important"><input type="date" name="to_date" class="form-control" required value="<?= set_value('to_date') ?>" min="<?php echo $school_date_created;?>"></td>
                            <td style="border:0px !important"><input type="submit" class="btn btn-info" value="Show Data"></td>

                        </tr>
                    </table>
                </div>
            </form>
            <span style="color:red">NOTE: If in case Settlement date falls under any holiday (Sundat, Saturday, National holiday etc.) , then settlement will be done in next working days. </span>
        </div>
        
    </div>
</div>

<div class="box">
    
    <div class="box-body">
        <h4 style="color:darkcyan;text-align: center;font-weight:bold"> <u>TYPE 1</u> </h4>
        <div class="col-sm-12 col-md-12 table-responsive" id="annual_load">
            <form id="frmstudent1" role="form" method="POST">
                <table id="studentlist1" class="table table-bordered table-striped">
                    <caption id="tabletitle" style="text-align:center"></caption>
                     <thead style="background: #cce6ff">

                         <tr> 

                             <th rowspan="2" style="border-right:1px solid black;border-bottom: 1px solid #99ceff"> Transaction Date </th>
                             
                             <th colspan="4" style="text-align: center;border-bottom:1px solid black;border-right:1px solid black"> Card </th>
                             <th colspan="2" style="text-align: center;border-bottom:1px solid black;border-right:1px solid black"> NetBanking </th>
                             <th rowspan="2" style="border-bottom: 1px solid #99ceff"> Grand Total </th>

                         </tr> 
                         <tr>
                             <th style="border-bottom: 1px solid #99ceff"> Credit Card Amount (CC)</th>
                             <th style="border-bottom: 1px solid #99ceff"> Debit Card Amount (DC)</th>
                             <th style="border-bottom: 1px solid #99ceff"> Total Amount (Card)</th>
                             <th style="border-right:1px solid black;border-bottom: 1px solid #99ceff">Card Settlement Date </th>
                             <th style="border-bottom: 1px solid #99ceff">NetBanking Amount (NB)</th>
                             <th style="border-right:1px solid black;border-bottom: 1px solid #99ceff">Net Banking Settlement Date </th>
                         </tr>
                      </thead>
                      <tbody id="date_load_td">
                           <?php
                            if (isset($data1) && count($data1) > 0) {
                                $setllecard=array();
                                $setllenb=array();
                                foreach ($data1 as $s) {
                                    
                                    $setllecard[$s->settle_card]['cc']=$s->cc_amt;
                                    $setllecard[$s->settle_card]['dc']=$s->dc_amt;
                                    $setllecard[$s->settle_card]['tot']=$s->cc_amt+$s->dc_amt;
                                    $setllenb[$s->settle_nb]=$s->nb_amt;
                                    
                                    ?>
                          <tr>
                              <td><?php if($s->trxday==NULL){ echo 'Total';}else{echo $s->trxday;}?></td>
                              <td><?php echo $s->cc_amt;?></td>
                              <td><?php echo $s->dc_amt;?></td>
                              <td><?php echo $s->tot_card_amt?></td>
                              <td><?php echo $s->settle_card;?></td>
                              <td><?php echo $s->nb_amt;?></td>
                              <td><?php echo $s->settle_nb;?></td>
                              <td><?php echo $s->grand_tot;?></td>
                          </tr>
                              <?php }
                            } ?>
                      </tbody>
                 </table>
            </form>
        </div>
    </div>
</div>


<div class="box">
    <div class="box-body">
        <h4 style="color:darkcyan;text-align: center;font-weight:bold"> <u>TYPE 2</u> </h4>
        <div class="col-sm-12 col-md-12 table-responsive" id="annual_load">
            <form id="frmstudent1" role="form" method="POST">
                <table id="studentlist2" class="table table-bordered table-striped">
                    <caption id="tabletitle" style="text-align:center"></caption>
                     <thead style="background: #cce6ff">

                         <tr> 

                             <th rowspan="2" style="border-right:1px solid black;border-bottom: 1px solid #99ceff"> Settlement Date </th>
                             
                             <th colspan="3" style="text-align: center;border-bottom:1px solid black"> Card Amount</th>
                             <th rowspan="2" style="border-left:1px solid black;border-right:1px solid black;border-bottom: 1px solid #99ceff"> NetBanking Amount</th>
                             <th rowspan="2" style="border-bottom: 1px solid #99ceff"> Grand Total </th>

                         </tr> 
                         <tr>
                             <th style="border-bottom: 1px solid #99ceff"> Credit Card Amount (CC)</th>
                             <th style="border-bottom: 1px solid #99ceff"> Debit Card Amount (DC)</th>
                             <th style="border-bottom: 1px solid #99ceff"> Total Card Amount</th>
                         </tr>
                      </thead>
                      <tbody id="date_load_td">
                           <?php
                            if (isset($data1) && count($data1) > 0) {
                                foreach ($data1 as $s2) {
                                    $tot=0;
                                    $tot=$setllecard[$s2->trxday]['tot']+$setllenb[$s2->trxday];
                                    ?>
                          <tr>
                              <td><?php if($s2->trxday==NULL){ echo 'Total';}else{echo $s2->trxday;}?></td>
                              <td><?php echo $setllecard[$s2->trxday]['cc'];?></td>
                              <td><?php echo $setllecard[$s2->trxday]['dc'];?></td>
                              <td><?php echo $setllecard[$s2->trxday]['tot'];?></td>
                              <td><?php echo $setllenb[$s2->trxday];?></td> 
                              <td><?php echo $tot;?></td>
                          </tr>
                              <?php }
                            } ?>
                      </tbody>
                 </table>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function ()
    {
//        datatable();
        
        $('#studentlist1,'+'#studentlist2').DataTable({
            // dom: 'Bfrtip',
            //      buttons: [
            //                     {
            //                         extend: 'collection',
            //                         text: 'Export',
            //                         className: 'red',
            //                         buttons: [
                              
            //                             'excel',
            //                             'csv',
            //                             'pdf',
            //                             'print'
            //                         ]
            //                     }
            //                 ]
        });
        
//        function datatable()
//        {            
//
//            $('#studentlist1').DataTable({
//                "destroy": true,
//                "paging": true,
//                "lengthChange": true,
//                "searching": true,
//                "ordering": true,
//                "info": true,
//                "autoWidth": true,
//                "processing": true,
//                serverSide: true,
//                ajax: {
//                    url: '<?php // echo base_url('feepayment/Report/paymentlog_report'); ?>',
//                    type: 'POST',
//                    data: {
//                    }
//                }
//
//            });
//        }
        
    });
    </script>