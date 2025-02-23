<style>
	input.largerCheckbox{
		width:40px;
		height:15px;
	}
</style>
<div class="form-group">
    <div class='box'>
        <div class='box-header form-group'>
            <form id="export-form" action="<?php echo base_url("feepayment/Report/exportpaymentlogcheque"); ?>" method="POST">
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
                      <!--   <div class="" style="float:right;" id="div_change">
                            <?php $date = date('Y-m-d'); ?>
                            <a class="btn btn-success" id="paylog_export" href="#" onclick="event.preventDefault();
                                           document.getElementById('export-form').submit();" download>
                                <i class="fa fa-cloud-download fa-lg"></i>&nbsp; Export 
                            </a>
                        </div>  -->
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
           <!--  <div class="col-sm-12 col-md-12">
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
                        <option value="1">Successful</option>
                        <option value="0">Failure</option>
                        <option value="2">Pending</option>

                    </select>

                </div>

            </div> -->
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
                                <th> Description </th>
                                <th> Total Paid Amount</th>
                                <th> Remarks </th> 
                                <th> Payment Method </th>  
                                <th> Receipt No </th>
                                <th> Order Id </th>
                                <th>Action </th>

                            </tr> 
                        </thead>
                        <tbody id="annual_load_td">
                            <?php
                            if (isset($data) && count($data) > 0) {
                                foreach ($data as $student) {
                                    print_r($student);
                                    ?>
                                    <tr>
                                        <td ></td>
                                        <td ></td>
                                        <td ></td>
                                        <td ></td>
                                        <td ></td>
                                        <td ></td>
                                        <td ></td>
                                        <td ></td>
                                        <td ></td>
                                        <td ></td>
                                        <td ></td>
                                        <td ></td>
                                        
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

<div class="modal fade right" id="sideModalTR" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-side modal-top-right" role="document">
    <form id="textbook_status_form" name="textbook_status_form">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Book list</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <hr>
        <p>Amount: <span id="amount"></span> Admission No: <span id="adm_no"></span></p>
      </div>
      <div class="modal-body">
        <table class="table table-sm" style="margin-bottom:0px;">
          <thead>
            <input type="hidden" id="head_id" name="head_id">
            <input type="hidden" id="student_id" name="student_id">
            <input type="hidden" id="class_fee_head_id" name="class_fee_head_id">
            <input type="hidden" id="fee_category" name="fee_category" value="3">
            <tr>
              <th scope="col">Sl.No.</th>
              <th scope="col">Check</th>
              <th scope="col">Book Name</th>
              <th scope="col">Book Amount</th>
              <th scope="col">Paid Status</th>
              <th scope="col">Status</th>              
            </tr>
          </thead>

          <tbody id="book_list_tbody">
            
          </tbody>
        </table>
         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" name="submit" class="btn btn-primary" onclick ="changestatusbook()">SAVE</button>
      </div>
    </div>
</form>
  </div>
</div>
<!-- Side Modal Top Right -->
<!-- Central Modal Small -->


<script type="text/javascript">
    function mymodel(id,amount,student_id,adm,class_fee_head_id)
    {
        var class_fee_head_id=class_fee_head_id;
        var id=id;
        var student_id=student_id;
        $('#amount').text(amount);
        $('#adm_no').text(adm);
        $('#head_id').val(id);
        $('#class_fee_head_id').val(class_fee_head_id);
        $('#student_id').val(student_id);
            $.ajax
                ({
                    url: "<?php echo site_url('feepayment/report/fetch_book_list') ?>",
                    type: "POST",
                    data: {id: id,class_fee_head_id:class_fee_head_id,student_id:student_id},
                    dataType: 'JSON',
                    success: function (data) {
                        $('#book_list_tbody').html(data);
                         $('#sideModalTR').modal('show');
                    },
                    error: function (errdata) {
                    }
                });
     
    }

    $(document).ready(function ()
    {
        datatable();

        $('#annuallstClass' + ',#annuallstSection' + ',#inputdate1' + ',#inputdate2').change(function ()
        {

            datatable();

            var class_id = $('#annuallstClass').val();
            var section_id = $('#annuallstSection').val();
            var from_date = $('#inputdate1').val();
            var to_date = $('#inputdate2').val();


        });

        function datatable()
        {
            var class_id = $('#annuallstClass').val();
            var section_id = $('#annuallstSection').val();
            var from_date = $('#inputdate1').val();
            var to_date = $('#inputdate2').val();

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
                    url: '<?php echo base_url('feepayment/Report/paymentlogtxtbook_report'); ?>',
                    type: 'POST',
                    data: {class_id: class_id,
                        section_id: section_id,
                        from_date: from_date,
                        to_date: to_date,
                    }
                },

               "dom": 'Bfrtip',
                buttons: [
                               {
                                   extend: 'collection',
                                   text: 'Export',
                                   buttons: [
//                                        'copy',
                                       'excel',
                                       'csv',
                                       'pdf',
                                       'print'
                                   ]
                               }
                           ],


            });
        }


    });


function changestatusbook(){
                    $.ajax
                    ({
                        url: "<?php echo site_url('feepayment/report/update_textbook_status') ?>",
                        type: "POST",
                        data: $('#textbook_status_form').serialize(),
                        dataType: "text",
                        success: function (data) {
                            alert('Data Save Successfully');
                            window.location.href = "<?php echo base_url('feepayment/report/txtBook_collection') ?>";
                        },
                        error: function (errdata) {
                        }
                    });
}

function changestatusbounce(id,amount){
    var fee_trans_head_id=id;
    var total_amount=amount;

                    $.ajax
                    ({
                        url: "<?php echo site_url('feepayment/report/update_cheque_collection_status_bounce') ?>",
                        type: "POST",
                        data: {fee_trans_head_id: fee_trans_head_id,total_amount:total_amount},
                        dataType: "text",
                        success: function (data) {
                            alert('Data Save Successfully');
//                            location.reload();
                            window.location.href = "<?php echo base_url('feepayment/report') ?>";
                        },
                        error: function (errdata) {
                        }
                    });
}
</script>
 