<script>
    setTimeout(function () {
        $('#message').fadeOut("slow");
    }, 5000);
    setTimeout(function () {
        $('#message1').fadeOut("slow");
    }, 5000);
</script>
<div class="form-group">
    <div class='box'>
        <div class='box-header form-group'>
            <form id="export-form"  method="POST">
                <div class="col-sm-12 col-md-12">
                        <label class="control-label col-md-2 col-sm-2">Class Name</label>
                        <div class="col-sm-2 col-md-2">
                            <select name="annuallstClass" id="annuallstClass" class="form-control">
                                <option value="all">All Class</option>
                                <?php
                                foreach ($aclass as $class) {
                                    ?>
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


            </div>
            </form>
        </div>
    </div>
    <div class="box">




        <div class="box-body">

            <center><div id="message" style="display:none" class="btn btn-success">Receipt Cancel Successfully</div></center>
            <center><div id="message1" style="display:none" class="btn btn-success">Receipt Cancel Rejected</div></center>

            <div class="col-sm-12 col-md-12 table-responsive" id="annual_load" style="padding-top:3%">

                <form id="frmstudent1" role="form" method="POST">

                    <table id="studentlist1234" class="table table-bordered table-striped">
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
                                <th> Payment Method </th>  
                                <th> Payment Mode </th>  
                                <th> Receipt No </th>
                                <th> Order Id </th>
                                <th>Action</th>

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

 function approve(id) {
          var idd=id;
            var r = confirm('Are you sure you want to cancel the Receipt?');
            if (r == true) {
           $.ajax({
            url: '<?php echo base_url();?>feepayment/report/approve',
            type:"POST",
            data:{idd:idd},
            success:function(data)
            {
                $('#message').show();
                window.location.reload();
                // $('#message').show();
                // console.log(data);
            }
           });
       }
       else{
         return false;
       }

}

 function reject(id) {
          var idd=id;
            var r = confirm('Are you sure you want to Reject this Receipt Cancelation?');
            if (r == true) {
           $.ajax({
            url: '<?php echo base_url();?>feepayment/report/reject',
            type:"POST",
            data:{idd:idd},
            success:function(data)
            {
                $('#message1').show();
                window.location.reload();
                // $('#message').show();
                // console.log(data);
            }
           });
       }
       else{
         return false;
       }

}
    $(document).ready(function ()
    {
        datatable();

        $('#annuallstClass' + ',#annuallstSection' + ',#inputdate1' + ',#inputdate2' + ',#collection_center').change(function ()
        {

            datatable();

            var class_id = $('#annuallstClass').val();
            var section_id = $('#annuallstSection').val();
            var from_date = $('#inputdate1').val();
            var to_date = $('#inputdate2').val();
            var collection_center = $('#collection_center').val();
        });

        function datatable()
        {
            var class_id = $('#annuallstClass').val();
            var section_id = $('#annuallstSection').val();
            var from_date = $('#inputdate1').val();
            var to_date = $('#inputdate2').val();
            var collection_center = $('#collection_center').val();

            $('#studentlist1234').DataTable({
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
                    url: '<?php echo base_url('feepayment/Report/receiptcancellog_report'); ?>',
                    type: 'POST',
                    data: {class_id: class_id,section_id: section_id,from_date: from_date,to_date: to_date,collection_center: collection_center}
                },
              


            });
        }


    });
                           


</script>