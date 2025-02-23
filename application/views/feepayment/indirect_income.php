<div class="form-group has-feedback" id="load">
    <div class="box">
        <div class="box-body">
            <div class="col-lg-12">
                <div class="col-lg-12" style="text-align:right;">
                 <button type="button" class="btn btn-add" data-toggle="modal" data-target="#myFeeModal"><i class="fa fa-plus-circle fa-lg"></i></button>
                </div>
            </div>
        </div>
        <div class="box-body">
            <form id='frmtemplate' role="form" method="POST">
                <div class="table-responsive">
                    <table id="templatelist" class="table table-bordered table-striped ">
                        <thead style="background:#99ceff;">
                            <tr>
                                <th style="border-bottom:0px">#</th>
                                <th style="border-bottom:0px">Name</th>
                                <th style="border-bottom:0px">Fee Name</th>
                                <th style="border-bottom:0px">Amount</th>
                                <th style="border-bottom:0px">Payment Date</th>
                                <th style="border-bottom:0px">Remarks</th>
                                <th style="border-bottom:0px">Paid Status</th>
                                <th style="border-bottom:0px">Action</th>
                            </tr>
                        </thead>
                        <thead style="background: #cce6ff">
                            <tr id="searchhead">
                                <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1;foreach ($fetch_trans_data as $obj_fee) {
                                ?>
                            <tr>

                                <td><?php echo $i;?></td>
                                <td><?php echo $obj_fee->bill_name;?></td>
                                <td><?php echo $obj_fee->feename; ?></td>
                                <td><?php echo $obj_fee->total_amount;?></td>
                                <td><?php echo $obj_fee->payment_date; ?></td>
                                <td><?php echo $obj_fee->remarks; ?>(<?php echo $obj_fee->response_message; ?>)</td>
                                <td><button type="button" class="btn btn-success">PAID</button></td>
                                <td><a class="btn" href="<?php echo base_url("feepayment/collection/Payment_pdf_indirect/payment_pdf_indirect/$obj_fee->id"); ?>" style="color:#555285;padding:1px" title="2 Copy Receipt Download" target="_blank"><i class="glyphicon glyphicon-circle-arrow-down"> </i> </a></td>
                            </tr>
                           <?php  $i++;} ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
        <!-- Modal -->
<div id="myFeeModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="padding: 6px; border-bottom:0px;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Fee Collection </h4>
            </div>
            <form class="form-horizontal"  method="post" id="frmcollectfee">
                <div class="modal-body">
                    <fieldset>
                          <div class="row">
                            <div class="col-sm-3">
                                <label>Adm No: </label> <select name="admission_no" id="admission_no" class="form-control" onchange="chkadmissio();">

                                    <option value="00000">Select</option>
                                    <?php foreach ($admission_no as  $value) { ?>
                                       <option value="<?php echo $value->id;?>"><?php echo $value->admission_no;?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label>Name: </label> <input type="text" class="form-control" id="bill_name" name="bill_name">
                            </div>

                            <div class="col-sm-3">
                                <label>Class: </label> <input type="text" class="form-control" id="bill_class" name="bill_class">
                            </div>
                            <div class="col-sm-3">
                                <label>Contact: </label> <input type="text" class="form-control" id="bill_contact" name="bill_contact">
                            </div>
                          </div>
                      </fieldset><hr>
                    <fieldset>
                        

                        <table class="table table-hover" style="margin-bottom:0px">
                            <thead>
                                 <tr class="row">
                                    <th class="col-sm-1"></th>
                                    <th class="col-sm-3">Fee Head</th>
                                    <!-- <th class="col-sm-4"></th> -->
                                    <!-- <th class="col-sm-4">Fee Head</th> -->
                                    <th class="col-sm-8">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <input type="checkbox" name="fee_head[8]" id="chk_8" value="8" checked="checked" style="display: none">
                                  <tr class="row" id="instant_fee_misc">
                                    <td class="col-sm-1"> </td>
                                    <!-- <td class="col-sm-3"><label for="chk_8" style="display: none">Indirect Fees</label></td> -->
                                    <td class="col-sm-8">
                                        <table class="table table-bordered table-striped" id="instantfee_tbl">
                               <?php foreach ($fee_type as  $value) { ?>
                                                <tr>
                                                	<td><input type="checkbox" id="instant_fee<?php echo $value->id ?>" value="<?php echo $instfee->amount ?>" name="instantfee_chk[<?php echo $value->id ?>][<?php echo $value->id ?>]"></td>
                                                    <td><label for="instant_fee<?php echo $value->id ?>"><?php echo $value->fee_name; ?></label></td>
                                                    <td><input type="text" class="form-control" value="" id="indirect_income"  name="fee_amt[8]" onchange="cal_amt()"></td>
                                                </tr>
    <?php } ?>
                                        </table>
                                    </td>
                                </tr>
                            
                            </tbody>
                            <tfoot>
                                <tr class="row">
                                    <th class="col-sm-1"></th>
                                    <th class="col-sm-3">Total Amount</th>
                                    <!-- <th class="col-sm-4"></th> -->
                                    <th class="col-sm-8" style="text-align: center"><input type="text" class="form-control" id="tot_amt_th" value="" name="tot_amount" required style="padding-right:1px;pointer-events: none;" oninvalid="this.setCustomValidity('Please Select Atleast One Fee Type from above')" oninput="setCustomValidity('')" ></th>
                                </tr>
                            </tfoot>
                        </table>
                    </fieldset>
                    <fieldset>
                        <legend>Other Information</legend>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-3">
                                    <label for="email"><b>Payment Date</b></label>
                                    <input type="date" name="payment_date" class="form-control" value="<?php echo date("Y-m-d"); ?>" required>
                                </div>
                                    <div class="col-sm-3">
                                    <label for="email"><b>Collection Center</b></label>
                                    <select class="form-control" name="collection_center" required>
                                        <option value="">Select</option>
                                        <?php foreach ($collection_centers as $cc) { ?>
                                        <option value="<?php echo $cc->collection_code ?>"><?php echo $cc->collection_desc; ?></option>
                                        <?php } ?>
                                    </select>                                
                                </div>
                                    <div class="col-sm-3">
                                    <label for="email"><b>Payment Mode</b></label>
                                    <select class="form-control" name="mode_payment" id="mode_payment" required="">
                                        <option value="POS">POS</option>
                                        <option value="CASH">CASH</option>
                                        <option value="CHEQUE">CHEQUE</option>
                                        <option value="CHALLAN">CHALLAN</option>
                                        <option value="DRAFT">DRAFT</option>
                                        
                                    </select>                                
                                </div>
                                 <div class="col-sm-3" id="pos_div" style="display: none">
                                    <label for="email"><b>POS No.</b></label>
                                    <input type="text"  name="pos_no" class="form-control">
                                </div>
                            </div>
                        </div>
                      <!--   <div class="row" id="pos_div" style="display: none">
                            <div class="col-sm-12">
                                <div class="col-sm-4">
                                    <label for="email"><b>POS No.</b></label>
                                    <input type="text"  name="pos_no" class="form-control">
                                </div>
                            </div>
                        </div> -->
                        <div class="row" id="cheque_div" style="display: none">
                            <div class="col-sm-12">
                                <div class="col-sm-4">
                                    <label for="email"><b>Cheque No.</b></label>
                                    <input type="text"  name="cheque_no" class="form-control">
                                </div>
                                <div class="col-sm-4">
                                    <label for="email"><b>Cheque Date</b></label>
                                    <input type="date"  name="cheque_date" class="form-control">
                                </div>
                                <div class="col-sm-4">
                                    <label for="email">Status</label>
                                    <select class="form-control" name="cheque_status" id="cheque_status">
                                        <option value="">Select</option>
                                        <option value="Pending">Under Clearance</option>
                                        <option value="Cleared">Cleared</option>
                                        <option value="Bounce">Bounce</option>
                                    </select>  
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- <div class="col-sm-4">
                                    <label for="email">Bank Name <span style="font:10px;font-weight: normal;">(in case collected in Bank/POS/CHEQUE)</span></label>
                                    <select class="form-control" name="bank_name">
                                        <option value="">Select</option>
                                        <?php foreach ($bank_list as $bl) { ?>
                                            <option value="<?php echo $bl->bank_code ?>"><?php echo $bl->bank_code; ?></option>
                                        <?php } ?>
                                    </select>                                
                                </div> -->
                                <div class="col-sm-4">
                                    <label for="email">Automatic Receipt <span style="font:10px;font-weight: normal;">(Yes/No)</span></label>
                                    <select class="form-control" name="automatic_receipt" id="automatic_receipt">
                                        <option value="YES">YES</option>  
                                        <option value="NO">NO</option>                                     
                                    </select>
                                </div>
                                <div class="col-sm-4" id="auto_receipt_div" style="display: none">
                                    <label for="email">Receipt No.<span style="font:10px;font-weight: normal;">(In case don't want to generate automated Receipt No.)</span></label>
                                    <input type="text"  name="receipt_no" class="form-control" style="padding:0px;padding-left:2px">
                                </div>
                                <div class="col-sm-4">
                                    <label for="email">Remarks</label>
                                    <textarea  name="remarks" required="" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-12">
                                    <label for="email">Remarks</label>
                                    <textarea  name="remarks" required="" class="form-control" style="padding:0px;padding-left:2px"></textarea>
                                </div>
                            </div>
                        </div> -->
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" id="collectmodel" type="button">Confirm</button>                   
                </div>
            </form>
        </div>
    </div>
</div>
    </div>
</div>

<script>
    var globalid = '';
    var url = "<?php echo base_url(); ?>";
    var newtxt = 1000;

    $(document).ready(function ()
    {

            $('#templatelist').DataTable({
                "paging": true,
                "info": true,
                "autoWidth": true,
                dom: 'Bfrtip',
                buttons: [
                {
                    extend: 'collection',
                    text: 'Export',
                    buttons: [

                        'excel',
                        'csv',
                        'print'

                    ]
                }
        ]

            });

    });


    function cal_amt()
    {

        var tot_amt = 0;
        $('#frmcollectfee input[name^=fee_amt]').each(function ()
        {
            if (this.id == 'indirect_income')
            {
           
                tot_amt = tot_amt + Number($(this).val());
            }

        });
        $('#tot_amt_th').val(tot_amt + ' INR');
    }

    $('#automatic_receipt').change(function () {
        if (this.value == 'NO') {
            $('#auto_receipt_div').css('display', 'block');
        } else {
            $('#auto_receipt_div').css('display', 'none');
        }
    });

    $('#mode_payment').change(function () {
        if (this.value == 'CHEQUE') {
            $('#cheque_div').css('display', 'block');
        } else
        {
            $('#cheque_div').css('display', 'none');
        }
    });
    $('#mode_payment').change(function () {
        if (this.value == 'POS') {
            $('#pos_div').css('display', 'block');
        } else
        {
            $('#pos_div').css('display', 'none');
        }
    });




    $('#collectmodel').click(function ()
    {

        if (!$('#frmcollectfee')[0].checkValidity())
        {
            $(this).show();
            $('#frmcollectfee')[0].reportValidity();
            return false;
        } else {

            var r = confirm("Are you sure you want to Collect fees?");
            $('#collectmodel').val('Collecting.....');
            if (r == true)
            {

                $('#myFeeModal').modal('hide');
                var formdata = $('#frmcollectfee').serialize();
                // alert(formdata);
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('feepayment/Indirect_income/save_offln_payment_indirect'); ?>',
                    data: formdata,
                    dataType: "json",
                    success: function (res)
                    {
                    	console.log(res);
                         alert(res.msg);

                        // window.location.href="<?php //echo base_url("feepayment/collection/Payment_pdf/payment_pdf/")  ?>"+res.fee_trans_id+'/'+res.student_id;

                    },
                  
                });
               
            } else
            {
                // return false;

            }
        }
    });


    $('#frmcollectfee input[type=checkbox][name^=fee_head]').change(function ()
    {
        var id = $(this).val();
        var isChecked = $(this).is(':checked');
        var amount = 0;
         if (id == 8)
        {
            $('#instantfee_tbl input[type="checkbox"][name^=instantfee_chk]').prop("disabled", !isChecked);
        }

        $('input[name="fee_amt[' + id + ']"').prop("readonly", !isChecked);


        if (isChecked)
        {
             if (id == 8)
            {
                $('#instantfee_tbl').on('change', 'input[type=checkbox]', function ()
                {
                    var instant_amt = 0;
                    $('#instantfee_tbl input[type=checkbox]').each(function ()
                    {
                        if (this.checked)
                        {
                            instant_amt = instant_amt + Number($(this).parent().next('td').next('td').text());
                        }

                    });

                    $('#frmcollectfee input[name="fee_amt[12]"]').val(instant_amt);
                     cal_amt();
                });

            } else {
                $('#frmcollectfee input[name="fee_amt[' + id + ']"').val(amount);
            }

        } else {
            
            if (id == 8)
            {
                $('#instantfee_tbl input[type="checkbox"][name^=instantfee_chk]').prop("checked", isChecked);
            }
        }

         cal_amt();

    });
</script>

<script>
    function chkadmissio()
    {
        var stid=$('#admission_no').val();  
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('feepayment/Indirect_income/getadmdata'); ?>',
                    data:{ stid: stid,},
                    dataType:'JSON',
                    success: function (res)
                    {
                        console.log(res);
                        $('#bill_class').val(res['class']);
                        $('#bill_name').val(res['student_name']);
                        $('#bill_contact').val(res['phone']);

                    },
                    error: function (req, status)
                    {
                        alert('No data Found');
                        return false;
                    }
                });
                
                
    }
</script>




