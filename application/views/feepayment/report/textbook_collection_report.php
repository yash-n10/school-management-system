<style>
	input.largerCheckbox{
		width:40px;
		height:15px;
	}
</style>
<div class="form-group">
<!--     <div class='box'>
        <div class='box-header form-group'>
            <form id="export-form" action="<?php echo base_url("feepayment/Report/txtBook_collection_new") ?>" method="POST">
                <div class="col-sm-12 col-md-12">
                        <label class="control-label col-md-2 col-sm-2">Class Name</label>
                        <div class="col-sm-2 col-md-2">


                            <select name="class_id" id="annuallstClass" class="form-control">
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


                            <select name="section_id" id="annuallstSection" class="form-control">
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
                    <input type="date" id="inputdate1" name="from_date" class="form-control" style="padding: 6px 4px;" value="<?php echo date('Y-m-d'); ?>" min="<?php echo $school_date_created;?>">

                </div>  
                <label class="control-label col-md-2 col-sm-2">End Date</label>
                <div class="col-sm-2 col-md-2">
                    <input type="date" id="inputdate2" name="to_date" class="form-control" style="padding: 6px 4px;" min="<?php echo $school_date_created;?>">

                </div>
            </div>
            <div class="col-sm-12 col-md-12">
            <input type="submit" name="submit" value="SUBMIT" class="btn btn-primary">
        </div>
            </form>
        </div>
    </div> -->
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
                                <th> Book Status</th>
                                <th>Action </th>

                            </tr> 
                        </thead>
                        <tbody id="annual_load_td">
                            <?php
                                foreach ($query_payment as $row) {
                                    // echo '<pre>';
                                    // print_r($row);
                                    $payment_date = $row->payment_date;
                                    $q = $this->dbconnection->select('student', 'admission_no,class_id,(select class_name from class where id=class_id) as class_name,'
                                            . 'section_id,(select sec_name from section where id=section_id) as sec_name', "id=$row->student_id");
                                    $class_fee_head_id=$row->class_fee_head_id;
                                    $firstname = $row->firstname;
                                    $admission_no = $q[0]->admission_no;
                                    $name = $row->name;
                                    $class_name = $q[0]->class_name;
                                    $sec_name = $q[0]->sec_name;
                                    $fe_desc = explode(',', $row->fee);
                                    $str = '';

                                foreach ($fe_desc as $index => $value) {
                                    if ($value == 3) {
                                        $otherfeeget = $this->dbconnection->select('fee_transaction_det', '(select fee_name from fee_master where id=other_fee_id) as otherfee', "fee_trans_head_id=$row->id and fee_cat_id=3");
                                        $strotherfee = '';
                                        foreach ($otherfeeget as $ot) {
                                            $strotherfee .= $ot->otherfee . ',';
                                        }
                                        $strotherfee = rtrim($strotherfee, ',');
                                        $str .= " TextBook Fees($strotherfee),";
                                    } 
                                }
                                    ?>
                                    <tr>
                                        <td ><?php echo $payment_date; ?></td>
                                        <td ><?php echo $admission_no; ?></td>
                                        <td ><?php echo $name; ?></td>
                                        <td ><?php echo $class_name; ?></td>
                                        <td ><?php echo $sec_name; ?></td>
                                        <td ><?php echo $str; ?></td>
                                        <td ><?php echo $row->total_amount; ?></td>
                                        <td ><?php echo $row->remarks . ' (' . $row->response_message . ')'; ?></td>
                                        <td ><?php echo $row->payment_method; ?></td>
                                        <td ><?php echo $row->receipt_no; ?></td>
                                        <td ><?php echo $this->session->userdata('school_code') . '-' . $q[0]->admission_no . '-' . $row->id ?></td>
                                        <td ><?php echo $row->book_status; ?></td>
                                        <td ><button type="button" name="clear" class="btn btn-success" value="'<?php echo $row->id ?>'" onclick="mymodel('<?php echo $row->id; ?>','<?php echo $row->total_amount; ?>','<?php echo $row->student_id; ?>','<?php echo $q[0]->admission_no; ?>','<?php echo $class_fee_head_id; ?>')">Action</button></td>
                                        
                                    </tr>
    <?php 
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
        <button type="button" name="submit" id="btn_book_save" class="btn btn-primary" onclick ="changestatusbook()">SAVE</button>
      </div>
    </div>
</form>
  </div>
</div>
<!-- Side Modal Top Right -->
<!-- Central Modal Small -->


<script type="text/javascript">
    $(document).ready(function() {
    $('#studentlist1').DataTable({
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
} );
    } );
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
function changestatusbook(){
                    $.ajax
                    ({
                        url: "<?php echo site_url('feepayment/report/update_textbook_status') ?>",
                        type: "POST",
                        data: $('#textbook_status_form').serialize(),
                        dataType: "text",
                        success: function (data) {
                            alert('Data Save Successfully');
                            window.location.href = "<?php echo base_url('feepayment/report/txtBook_collection_new') ?>";
                        },
                        error: function (errdata) {
                        }
                    });
}

</script>
 