<div class="form-group has-feedback">
    <div class="box box-primary">
        <div class="box-body">
            <div class="col-lg-12" style="text-align:right;">
                <a class="btn btn-add" data-toggle="modal" data-target="#myModal" title="Add Ledger">
                    <i class="fa fa-plus-circle fa-lg"></i>&nbsp;
                </a>

            </div>
            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="form_add" class="form-horizontal" method="post">    
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h3 class="modal-title">Add Ledger</h3>
                            </div>
                            <div class="modal-body">

                                <div class="form-group" style="width:90%;margin-left:5%;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="email">Ledger Name</label>
                                            <input type="text" class="form-control" id="ledger_name" name="ledger_name">
                                            <span id="error-ledger_name"><?php echo form_error('ledger_name'); ?></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email">Group Name</label>
                                            <select class="form-control" name="under_group" id="under_group">
                                                <option value="">Select</option>
                                                <?php foreach ($ledger_group as $value_group) { ?>
                                                    <option value="<?php echo $value_group->id; ?>"><?php echo $value_group->group_name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <span id="error-under_group"><?php echo form_error('under_group'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" style="width:90%;margin-left:5%;">
                                    <div class="row">
                                        <div class="col-md-6">               
                                            <label for="email">Email</label>
                                            <input type="text" class="form-control" id="email" name="email">
                                            <span id="error-email"><?php echo form_error('email'); ?></span>
                                        </div>
                                        <div class="col-md-6">               
                                            <label for="email">Phone Number</label>
                                            <input type="text" class="form-control" id="phone" name="phone">
                                            <span id="error-phone"><?php echo form_error('phone'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" style="width:90%;margin-left:5%;">
                                    <label for="email">Address</label><br />
                                    <textarea type="text" class="form-control" id="address" name="address"></textarea>
                                    <span id="error-address"><?php echo form_error('address'); ?></span>
                                </div>
                                <div class="form-group" style="width:90%;margin-left:5%;">
                                    <div class="row">
                                        <div class="col-md-6">               
                                            <label for="email">City</label>
                                            <input type="text" class="form-control" id="city" name="address">
                                            <span id="error-city"><?php echo form_error('city'); ?></span>
                                        </div>
                                        <div class="col-md-6">               
                                            <label for="email">State</label>
                                            <select class="form-control" name="state" id="state">
                                                <option value="">Select</option>
                                                <?php foreach ($state as $value_state) { ?>                   
                                                    <option value="<?php echo $value_state->state_code; ?>"><?php echo $value_state->state_name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <span id="error-state"><?php echo form_error('state'); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" style="width:90%;margin-left:5%;">
                                    <div class="row">
                                        <div class="col-md-6">               
                                            <label for="email">Zip Code</label>
                                            <input type="text" class="form-control" id="zip" name="zip">
                                            <span id="error-zipcode"><?php echo form_error('zip'); ?></span>
                                        </div>
                                        <div class="col-md-6">               
                                            <label for="email">Aadhar Number</label>
                                            <input type="text" class="form-control" id="adhar" name="adhar">
                                            <span id="error-aadhar"><?php echo form_error('adhar'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" style="width:90%;margin-left:5%;">
                                    <div class="row">
                                        <div class="col-md-6">               
                                            <label for="email">Pan No.</label>
                                            <input type="text" class="form-control" id="pan_no" name="pan_no">
                                            <span id="error-pan_no"><?php echo form_error('pan_no'); ?></span>
                                        </div>
                                        <div class="col-md-6">               
                                            <label for="email">Bank Name</label>
                                            <input type="text" class="form-control" id="bank_name" name="bank_name">
                                            <span id="error-bank_name"><?php echo form_error('bank_name'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" style="width:90%;margin-left:5%;">
                                    <div class="row">
                                        <div class="col-md-6">               
                                            <label for="email">Account No.</label>
                                            <input type="text" class="form-control" id="account_number" name="account_number">
                                            <span id="error-account_number"><?php echo form_error('account_number'); ?></span>
                                        </div>
                                        <div class="col-md-6">               
                                            <label for="email">Opening Date</label>
                                            <input type="date" class="form-control" id="op_date" name="op_date">
                                            <span id="error-op_date"><?php echo form_error('op_date'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" style="width:90%;margin-left:5%;">
                                    <div class="row">
                                        <div class="col-md-6">               
                                            <label for="email">Opening Amount</label>
                                            <select class='form-control' id="cr_dr" name="cr_dr">
                                                <option value="">Select</option>
                                                <option value="DR">DR</option>
                                                <option value="CR">CR</option>
                                            </select>
                                            <span id="error-op_amount"><?php echo form_error('cr_dr'); ?></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email"></label>
                                            <input type="text" class="form-control" id="op_amount" name="op_amount" placeholder="Opening Amount">
                                            <span id="error-op_amount"><?php echo form_error('op_amount'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" style="width:90%;margin-left:5%;">
                                    <div class="row">
                                        <div class="col-md-6">               
                                            <label for="email">Credit Limit</label>
                                            <input type="text" class="form-control" id="credit_limit" name="credit_limit">
                                            <span id="error-credit_limit"><?php echo form_error('credit_limit'); ?></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email">Credit Days</label>
                                            <input type="text" class="form-control" id="credit_days" name="credit_days" >
                                            <span id="error-credit_days"><?php echo form_error('credit_days'); ?></span>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="modal-footer">
                                <a id="butt" class="btn btn-success" onclick="save()">SAVE</a>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </form> 
                    </div>
                </div>
            </div>
            <!--Edit Modal-->
            <div id="EditModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h3 class="modal-title" id="modal-title">Update Group</h3>
                        </div>
                        <form id="form_edit" class="form-horizontal" method="post" style="width:90%;margin-left:5%;">    
                            <div class="modal-body">

                                <div id="datas">				

                                </div>



                            </div>
                            <div class="modal-footer">
                                <a id="butt_update" class="btn btn-success" onclick="update()">UPDATE</a>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </form> 
                    </div>
                </div>
            </div>
            <!-- End Edit Modal-->
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="period">
                    <thead style="background:#99ceff;">
                        <tr>
                            <th style="border-bottom:0px">S.No.</th>
                            <th style="border-bottom:0px">Ledger Name</th>
                            <th style="border-bottom:0px">Group Name</th>
                            <th style="border-bottom:0px">Email</th>
                            <th style="border-bottom:0px">Phone</th>
                            <th style="border-bottom:0px">Address</th>
                            <th style="border-bottom:0px">City</th>
                            <th style="border-bottom:0px">State</th>
                            <th style="border-bottom:0px">Opening Date</th>
                            <th style="border-bottom:0px">Opening Amount</th>
                            <th style="border-bottom:0px">Action</th>
                        </tr>
                    </thead>
                    <thead style="background: #cce6ff">
                        <tr id="searchhead">

                            <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="0"/>
                            </th>
                            <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="1"/>
                            </th>
                            <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="2"/>
                            </th>
                            <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="3"/>
                            </th>
                            <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="4"/>
                            </th>
                            <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="5"/>
                            </th>
                            <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="6"/>
                            </th>
                            <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="7"/>
                            </th>
                            <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="8"/>
                            </th>
                            <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>

                            <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $i = '1';
                        foreach ($ledger_detail as $val) {
                            if ($val->status == 'Y') {
                                ?>
                                <tr>
                                    <td><?php echo $val->id; ?></td>
                                    <td><?php echo $val->ledger_name ?></td>
                                    <td><?php echo $val->name ?></td>
                                    <td><?php echo $val->email ?></td>
                                    <td><?php echo $val->phone ?></td>
                                    <td><?php echo $val->address ?></td>
                                    <td><?php echo $val->city ?></td>
                                    <td><?php echo $val->state ?></td>
                                    <td><?php echo $val->opening_date ?></td>
                                    <td><?php echo $val->opening_balance ?></td>
                                    <td> <?php if($val->id>15) {?>
                                        <span><a class="btn a-edit" title="Edit" onclick="edit(<?php echo $val->id; ?>, '<?php echo $val->ledger_name; ?>', '<?php echo $val->id; ?>', '<?php echo $val->email; ?>', '<?php echo $val->phone; ?>', '<?php echo $val->address; ?>', '<?php echo $val->city; ?>', '<?php echo $val->state; ?>', '<?php echo $val->zip_code; ?>', '<?php echo $val->uid_no; ?>', '<?php echo $val->pan_no; ?>', '<?php echo $val->bank_name; ?>', '<?php echo $val->account_number; ?>', '<?php echo $val->opening_date; ?>', '<?php echo $val->cr_dr; ?>', '<?php echo $val->opening_balance; ?>', '<?php echo $val->credit_limit; ?>', '<?php echo $val->credit_days; ?>', )"><i class="fa fa-edit"></i> </a></span>
                                    <span><a class="btn a-delete" title="Delete" onclick="deletes(<?php echo $val->id; ?>)"><i class="fa fa-trash"></i> </a></span><?php }?></td>
                                </tr>
                                <?php $i++;
                            }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>   
    </div>
</div>

<script>

    $(function ()
    {
        var table = $('#period').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true
        });
        $('#searchhead th input').on('keyup change', function () {
//            if ( this.search() !== this.value ) {
//                this
//                    .search( this.value )
//                    .draw();
//            }
            var i = $(this).attr('data-column');
            var v = $(this).val();
            table.columns(i).search(v).draw();
        });
<?php if ($this->session->flashdata('successmsg')) { ?>
            $('#myMsgModal').modal('show');
<?php } ?>
    });


    $('#class').on('change keyup', function () {
        var value = $(this).val();
        $.ajax({
            url: "<?php //echo site_url('academics/homework/Add_homework/GetSection') ?>",
            type: "POST",
            data: {id: value},
            success: function (data)
            {
                $('#section').empty();
                $("#section").append(data);
            },
        });
    });

    function save()
    {
        if (!$('#form_add')[0].checkValidity()) {
            $(this).show();
            $('#form_add')[0].reportValidity();
            return false;
        } else
        {
            var ledger_name = $('#ledger_name').val();
            var under_group = $('#under_group').val();
            var email = $('#email').val();
            var phone = $('#phone').val();
            var address = $('#address').val();
            var city = $('#city').val();
            var state = $('#state').val();
            var zip_code = $('#zip').val();
            var uid_no = $('#adhar').val();
            var pan_no = $('#pan_no').val();
            var bank_name = $('#bank_name').val();
            var account_number = $('#account_number').val();
            var cr_dr = $('#cr_dr').val();
            var opening_date = $('#op_date').val();
            var opening_balance = $('#op_amount').val();
            var credit_limit = $('#credit_limit').val();
            var credit_days = $('#credit_days').val();

            $.ajax({
                url: "<?php echo base_url('account/Ledger/save') ?>",
                type: "POST",
                data: {ledger_name: ledger_name, under_group: under_group, email: email, phone: phone, address: address, city: city, state: state, zip_code: zip_code, uid_no: uid_no, pan_no: pan_no, bank_name: bank_name, account_number: account_number, cr_dr: cr_dr, opening_date: opening_date, opening_balance: opening_balance, credit_limit: credit_limit, credit_days: credit_days},
                dataType: 'json',
                success: function (data)
                {
                    if (data.success == 'Y')
                    {
//alert('Successfully Added');
                        location.reload();
                    } else
                    {
                        $.each(data.error, function (key, value) {
                            if (value)
                            {
                                $('#error-' + key).css('color', 'red');
                                $('#error-' + key).html(value);
                            }
                        });
                    }
                },
            });

        }
    }

    function deletes(id)
    {
        var r = confirm("Are you sure you want to Delete?");
        if (r == true)
        {
            var del_id = id;
            $.post('<?php echo base_url('account/Ledger/del'); ?>', {del_id: del_id}, function (data) {
                alert('Data Deleted Successfully');
                location.reload();
            });
        }
    }


    function edit(id, ledger_name, name, email, phone, address, city, state, zip_code, uid_no, pan_no, bank_name, account_number, opening_date, cr_dr, opening_balance, credit_limit, credit_days)
    {
        $("form")[0].reset();
        $('#butt_update').attr('onclick', 'update(' + id + ')');
        $.post('<?php echo site_url('account/Ledger/edit') ?>', {id: id, ledger_name: ledger_name, name: name, email: email, phone: phone, address: address, city: city, state: state, zip_code: zip_code, uid_no: uid_no, pan_no: pan_no, bank_name: bank_name, account_number: account_number, opening_date: opening_date, cr_dr: cr_dr, opening_balance: opening_balance, credit_limit: credit_limit, credit_days: credit_days}, function (data) {
            $("#datas").html('');
            $("#datas").html(data);
            $('#EditModal').modal('show');
        });
    }


    function update()
    {
        var update_id = $("#update_id").val();
        var ledger_name_edt = $("#ledger_name_edt").val();
        var under_group_edt = $("#under_group_edt").val();
        var email_edt = $("#email_edt").val();
        var phone_edt = $("#phone_edt").val();
        var address_edt = $("#address_edt").val();
        var city_edt = $("#city_edt").val();
        var state_edt = $("#state_edt").val();
        var zip_code_edt = $("#zip_code_edt").val();
        var uid_no_edt = $("#uid_no_edt").val();
        var pan_no_edt = $("#pan_no_edt").val();
        var bank_name_edt = $("#bank_name_edt").val();
        var account_number_edt = $("#account_number_edt").val();
        var cr_dr_edt = $("#cr_dr_edt").val();
        var opening_date_edt = $("#opening_date_edt").val();
        var opening_balance_edt = $("#opening_balance_edt").val();
        var credit_limit_edt = $("#credit_limit_edt").val();
        var credit_days_edt = $("#credit_days_edt").val();

        $.post('<?php echo base_url('account/Ledger/update') ?>', {update_id: update_id, ledger_name_edt: ledger_name_edt, under_group_edt: under_group_edt, email_edt: email_edt, phone_edt: phone_edt, address_edt: address_edt, city_edt: city_edt, state_edt: state_edt, zip_code_edt: zip_code_edt, uid_no_edt: uid_no_edt, pan_no_edt: pan_no_edt, bank_name_edt: bank_name_edt, account_number_edt: account_number_edt, cr_dr_edt: cr_dr_edt, opening_date_edt: opening_date_edt, opening_balance_edt: opening_balance_edt, credit_limit_edt: credit_limit_edt, credit_days_edt: credit_days_edt}, function (data) {
            alert('Successfully Updated');
            location.reload();
        });


    }
</script>