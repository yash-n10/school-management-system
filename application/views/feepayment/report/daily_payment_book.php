<div class="form-group">
    <div class='box'>
        <div class='box-header form-group'>
            <form id="export-form" action="<?php echo base_url("feepayment/Report/exportpaymentlog"); ?>" method="POST">
                <div class="col-sm-12 col-md-12">
                        <label class="control-label col-md-2 col-sm-2">Class Name</label>
                        <div class="col-sm-2 col-md-2">
                            <select name="annuallstClass" id="annuallstClass" class="form-control">
                                <option value="all">All Class</option>
                                <?php
                                foreach ($aclass as $class) { ?>
                                    
                                    <option value="<?php echo $class->id; ?>"><?php echo $class->class_name; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <label class="control-label col-md-2 col-sm-2">Section Name</label>
                        <div class="col-sm-2 col-md-2">


                            <select name="annuallstSection" id="annuallstSection" class="form-control">
                                <option value="all">All Section</option>
                                <?php
                                foreach ($asection as $sec) {
                                    ?>
                                    <option value="<?php echo $sec->id; ?>"><?php echo $sec->sec_name; ?></option>
                                    <?php
                                }
                                ?>
                            </select>


                        </div>
                            <?php if((($this->session->userdata('user_id')==1) && ($this->session->userdata('school_id')==29))||(($this->session->userdata('user_id')==1) && ($this->session->userdata('school_id')==25)) ){ ?>
                        <div class="" style="float:right;" id="div_change">
                            <?php $date = date('Y-m-d'); ?>
                            <a class="btn btn-success" id="paylog_export" href="#" onclick="event.preventDefault();
                                           document.getElementById('export-form').submit();" download>
                                <i class="fa fa-cloud-download fa-lg"></i>&nbsp; Export 
                            </a>
                        </div> 
                    <?php } elseif ($this->session->userdata('school_id')==5 ||$this->session->userdata('school_id')==37) { ?>
                       <div class="" style="float:right;" id="div_change">
                            <?php $date = date('Y-m-d'); ?>
                            <a class="btn btn-success" id="paylog_export" href="#" onclick="event.preventDefault();
                                           document.getElementById('export-form').submit();" download>
                                <i class="fa fa-cloud-download fa-lg"></i>&nbsp; Export 
                            </a>
                        </div> 
                    <?php } else{ ?>
                    <div class="" style="float:right;" id="div_change">
                            <?php $date = date('Y-m-d'); ?>
                            <a class="btn btn-success" id="paylog_export" href="#" onclick="event.preventDefault();
                                           document.getElementById('export-form').submit();" download>
                                <i class="fa fa-cloud-download fa-lg"></i>&nbsp; Export 
                            </a>
                        </div> 
                    <?php } ?>
            </div>

            <div class="col-sm-12 col-md-12">
                <label class="control-label col-md-2 col-sm-2">Start Date</label>
                <div class="col-sm-2 col-md-2">
                    <input type="date" id="inputdate1" name="st_date" class="form-control" style="padding: 6px 4px;" value="<?php echo date('Y-m-d'); ?>" min="<?php echo $school_date_created;?>">
                </div>  
                <label class="control-label col-md-2 col-sm-2">End Date</label>
                <div class="col-sm-2 col-md-2">
                    <input type="date" id="inputdate2" name="ed_date" class="form-control" style="padding: 6px 4px;" min="<?php echo $school_date_created;?>">

                </div>
            </div>
            <div class="col-sm-12 col-md-12">
                <label class="control-label col-md-2 col-sm-2">Collection Center</label>
                <div class="col-sm-2 col-md-2">
                    <select class="form-control" name="collection_center" id="collection_center">
                        <option value="all">All</option>
                        <?php
                        foreach ($collection_center as $cc) {
                            ?>
                            <option value="<?php echo $cc->collection_code; ?>"><?php echo $cc->collection_desc; ?></option>
                            <?php
                        }
                        ?>
                    </select>

                </div>  
                <label class="control-label col-md-2 col-sm-2">Transaction Type</label>
                <div class="col-sm-2 col-md-2">
                    <select class="form-control" name="transac_type" id="transac_type">
                        <option value="all">All</option>
                        <option value="0">Successful</option>
                        <option value="2">Failure</option>
                        <?php if($this->session->userdata('school_id')==35) { ?>
                            <option value="4">Receipt Cancel</option>
                        <?php } ?>
                        <option value="3">Gateway Visiting</option>

                    </select>

                </div>

            </div>
            </form>
        </div>
    </div>
    <div class="box">




        <div class="box-body">



            <div class="col-sm-12 col-md-12 table-responsive" id="annual_load" style="padding-top:3%">

                <form id="frmstudent1" role="form" method="POST">

                    <table id="studentlist1" class="table table-bordered table-striped">
                        <thead>
                            <tr> 
                                <th> Payment Date </th>
                                <th> Admission No </th>
                                <th> Student Name </th>
                                <th> Class </th>
                                <th> Section </th>
                                <th> Collection Center </th>
                                <th> Description </th>
                                <th> Total Paid Amount</th>
                                <th> Remarks </th> 
                                <th> Transaction Id </th>
                                <th> Payment Id </th>
                                <th> Payment Method </th>  
                                <th> Payment Mode </th>  
                                <th> Receipt No </th>
                                <th> Year </th>
                                <th> Order Id </th>

                            </tr> 
                        </thead>
                        <tbody id="annual_load_td">
                            <?php
                            if (isset($data) && count($data) > 0) {
                                foreach ($data as $student) {
                                    ?>
                                    <tr>
                                      <!--   <td ></td>
                                        <td ></td>
                                        <td ></td>
                                        <td ></td>
                                        <td ></td>
                                        <td ></td>
                                        <td ></td>
                                        <td ></td>
                                        <td ></td>
                                        <td ></td> -->
                                    </tr>
    <?php }
} ?>
                        </tbody>
                    </table>


                </form>

            </div>

        </div>
    </div>
</div>


<script type="text/javascript">

    $(document).ready(function ()
    {
        datatable();

        $('#annuallstClass' + ',#annuallstSection' + ',#inputdate1' + ',#inputdate2' + ',#collection_center' + ',#transac_type').change(function ()
        {

            datatable();

            var class_id = $('#annuallstClass').val();
            var section_id = $('#annuallstSection').val();
            var from_date = $('#inputdate1').val();
            var to_date = $('#inputdate2').val();
            var collection_center = $('#collection_center').val();
            var transac_type = $('#transac_type').val();

//            $('#paylog_export').attr('href', '<?php // echo base_url('feepayment/Report/exportpaymentlog'); ?>' + '/' + class_id + '/' + section_id + '/' + collection_center + '/' + transac_type + '/' + from_date + '/' + to_date);
////        alert(class_id);
//        
//        if(class_id=='')
//        {
//            alert('Please select Class !!!');
//        }
//        else{
//        
//        $('#annual_load_td').html("<tr><td colspan='12'><h3 style='text-align:center'> Loading....... </h3></td></tr>");
////         alert(from_date);
//        $.ajax({
//            
//                    url: '<?php // echo base_url();  ?>report/paymentlog_report',
//                    dataType: "text",
//                    method: 'post',  
//                    data: {
//                                class_id:class_id,                                             
//                                section_id:section_id,   
//                                from_date:from_date,
//                                to_date:to_date
//                    },
//                    success: function(data) {
////                      alert(data);
//                        $('#annual_load').html(data);
//                    },
//                    error: function() {
//                    alert('Error while Loading!');
//
//                    }
//            
//        });
//        
//        }

        });

        function datatable()
        {
            var class_id = $('#annuallstClass').val();
            var section_id = $('#annuallstSection').val();
            var from_date = $('#inputdate1').val();
            var to_date = $('#inputdate2').val();
            var collection_center = $('#collection_center').val();
            var transac_type = $('#transac_type').val();

            $('#studentlist1').DataTable({
                "destroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "processing": true,
                serverSide: true,
                ajax: {
                    url: '<?php echo base_url('feepayment/Report/paymentlog_report'); ?>',
                    type: 'POST',
                    data: {class_id: class_id,
                        section_id: section_id,
                        from_date: from_date,
                        to_date: to_date,
                        collection_center: collection_center,
                        transac_type: transac_type,
                    }
                },
//                "dom": 'Bfrtip',
//                 buttons: [
//                                {
//                                    extend: 'collection',
//                                    text: 'Export',
//                                    buttons: [
////                                      'copy',
//                                        'excel',
//                                        'csv',
//                                        'pdf',
//                                        'print'
//                                    ]
//                                }
//                            ],

            });
        }

//        $('#paylog_export').click(function(e){
//                e.preventDefault();
//                var data=$('#studentlist1').html();
////                alert(data);
//                $.post( "<?php // echo base_url('feepayment/report/export'); ?>", { data: data } );
//               
//               
////               $.ajax({
////                   url : '<?php // echo base_url('feepayment/report/export'); ?>',
//                   type :'POST',
//                   
//               });
//               window.location='<?php // echo base_url('feepayment/report/export'); ?>'+'?data='+data;
//        });

    });



</script>