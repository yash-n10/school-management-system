
<div class="form-group">
    <div class="panel  panel-default"> 
        <div class="panel-body">

            <form enctype="multipart/form-data" id="leavegroup-form" action="" method="post">
                <div class="col-sm-12 col-md-12" style="margin-top:2%">
                    <!--                                  <div class="panel  panel-default">
                    <div class="panel-body" style="">-->

                    <div class="row" style="padding-bottom:2%">
                        <!--<div class="col-sm-1"></div>-->
                        <div class="col-sm-2">
                            <label class="req" style="font-size:16px !important">Leave Group:</label>
                        </div>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="leavegrp_name" value="<?php echo $leavegrp_name; ?>" placeholder="Enter Group Name" required="">
                        </div>
                        <div class="col-sm-3">
                            <label style="font-size:16px !important">Applicable Month/Year From:</label>
                        </div>
                        <div class="col-sm-2">
                            <div class='input-group date' id='datetimepicker1'>
                                <input type='month' class="form-control" id="applicable_from" name="applicable_from" value="<?php echo $applicable_from; ?>" placeholder="xxxx-xx (e.g 2017-11)" required="">
                                <!--                                                                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </span>-->
                            </div>
                        </div>
                    </div>
                    <div class="row" style="padding-bottom:2%">
                        <!--<div class="col-sm-1"></div>-->
                        <div class="col-sm-12">
                            <div class="panel  panel-default" style="margin-bottom: 0px;">
                                <div class="panel-heading" style="padding: 5px 15px;border-color:gray">
                                    <b style="font-size:16px !important"> Leave Entitlement </b>
                                </div>
                                <div class="panel-body" style="">
                                    <!--                                                                      <div style="overflow-x:auto;overflow-y:hidden;padding:2%">-->
                                    <table class="table table-normal table-bordered ">
                                        <tr style="border:1px solid black">

                                            <th>Leave Type</th>
                                            <th>Allowed?</th>
                                            <th>Total Allowed</th>
                                            <th>Total Allowed/Month</th>                                                                              
                                            <th>Carry Frwd to Next Year?</th>
                                            <th>Max. Carry Frwd</th>
                                            <th>Converted to Amount?</th>
                                            <th>Converted Amount</th>
                                        </tr> 
                                        <?php foreach ($fetch_leave as $r) { ?>
                                            <tr>
                                            <input type="hidden" name="leave_id[]" value="<?php echo $r->id ?>">
                                            <td><?php echo $r->leave_type_code ?></td>
                                            <td>
                                                <select class="form-control" id="<?php echo $r->id ?>" name="allowed[]" style="padding-right: 0px;">
                                                    <option value="N" <?php if ($task == 'Update') {
                                            if ($r->allowed == 'N') {
                                                echo 'selected=selected';
                                            }
                                        } ?>>NO</option>
                                                    <option value="Y" <?php if ($task == 'Update') {
                                            if ($r->allowed == 'Y') {
                                                echo 'selected=selected';
                                            }
                                        } ?>>YES</option>
                                                </select>
                                            </td>
                                            <td><input type="number" class="form-control" value="<?php if ($task == 'Update') {
                                            echo $r->total_allowed;
                                        } ?>" name="total_allowed[]" id="total_allowed_<?php echo $r->id ?>"></td>
                                            <td><input type="number" class="form-control" value="<?php if ($task == 'Update') {
                                            echo $r->total_allowed_per_month;
                                        } ?>" name="total_allowed_per_month[]" id="total_allowed_per_month_<?php echo $r->id ?>"></td>
                                            <td>
                                                <select class="form-control" style="height:100%" name="carry_frwd[]" id="carry_frwd_<?php echo $r->id ?>">
                                                    <option value="N" <?php if ($task == 'Update') {
                                            if ($r->carry_frwd == 'N') {
                                                echo 'selected=selected';
                                            }
                                        } ?>>NO</option>
                                                    <option value="Y" <?php if ($task == 'Update') {
                                            if ($r->carry_frwd == 'Y') {
                                                echo 'selected=selected';
                                            }
                                        } ?>>YES</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" value="<?php if ($task == 'Update') {
                                            echo $r->max_carry_frwd;
                                        } ?>" name="max_carry_frwd[]" id="max_carry_frwd_<?php echo $r->id ?>">
                                            </td>
                                            <td>
                                                <select class="form-control" style="height:100%" name="convert_to_amt[]" id="convert_to_amt_<?php echo $r->id ?>">
                                                    <option value="N" <?php if ($task == 'Update') {
                                            if ($r->convrt_to_amount == 'N') {
                                                echo 'selected=selected';
                                            }
                                        } ?>>NO</option>
                                                    <option value="Y" <?php if ($task == 'Update') {
                                            if ($r->convrt_to_amount == 'Y') {
                                                echo 'selected=selected';
                                            }
                                        } ?>>YES</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" step="0.01" class="form-control" value="<?php if ($task == 'Update') {
                                            echo $r->amount;
                                        } ?>" name="amount[]" id="amount_<?php echo $r->id ?>">
                                            </td>
                                            </tr> 
<?php } ?>
                                    </table>
                                    <!--</div>-->
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-lg-5"> 
                            <button type="button" class="btn btn-primary" id="back"><i class="fa fa-arrow-left"> </i> Back</button>
                        </div>
                        <div class="col-lg-3">    
                        <!--<input type="button" class="btn btn-primary" style="width: 120px;font-family: sans-serif;" id="back" value="Back">--> 
                            <input type="button" class="btn btn-success"  name="saveleavegroup" id="btn_save" value="<?php echo $task; ?>">
                        </div>
                    </div>

                    <!--                                      </div>
                    </div>-->

                </div>
            </form>
        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->

<script>

//     history.replaceState({}, null, "/staff_management/employee/edit");
    $(document).ready(function ()
    {
//       $(".chosen-select").chosen({width: "100%"}); 
        var task = '<?php echo $task; ?>';
        var leavegroup_id = '<?php echo $leavegroup_id; ?>';
//            $('#datetimepicker1').datetimepicker({
//                
//                todayBtn: true,
//                autoclose: true,
//                pickerPosition: "bottom-left",
//                format:'mm-yyyy',
//                startView:3,
//                minView:3
//            
//                
//
//            }); 

        $('select[name^=allowed]').each(function () {
//                alert(this.value);
            var idc = this.id;
//                alert(idc);
            hide_show(idc, this.value);
        });

        $('select[name^=allowed]').change(function () {
            var idc = this.id;
            hide_show(idc, this.value);
        });

        function hide_show(idc, value) {

            var status1 = false;
            var status2 = '';
            if (value == 'N') {
                status1 = true;
                status2 = 'none';

            }
            $('input[id=total_allowed_' + idc + ']').attr('readonly', status1);
            $('input[id=total_allowed_per_month_' + idc + ']').attr('readonly', status1);
            $('select[id=carry_frwd_' + idc + ']').css('pointer-events', status2);
            $('input[id=max_carry_frwd_' + idc + ']').attr('readonly', status1);
            $('select[id=convert_to_amt_' + idc + ']').css('pointer-events', status2);
            $('input[id=amount_' + idc + ']').attr('readonly', status1);

        }

        $('#back').click(function () {
//                alert('hi');
            window.location.href = '<?php echo base_url('hr/settings/leave_group'); ?>';
        });

        $('#btn_save').click(function ()
        {

            if (!$('#leavegroup-form')[0].checkValidity())
            {
//                                                alert($('#add_stud_frm')[0].validationMessage);
                $(this).show();
                $('#leavegroup-form')[0].reportValidity();
                return false;
            } else {
                var formdata = $('form').serialize();
                if (task == 'Save')
                {
                    action_url = '<?php echo base_url('hr/settings/leave_group/save'); ?>';
                }
                else
                {

                    action_url = '<?php echo base_url('hr/settings/leave_group/update'); ?>' + '/' + leavegroup_id;
                }
//                alert(action_url);
                $.ajax
                        ({
                            type: 'POST',
                            data: formdata,
                            url: action_url,
                            datatype: "text",
                            success: function (data)
                            {
                                window.location.href = '<?php echo base_url('hr/settings/leave_group'); ?>';

                            },
                            error: function (data)
                            {
                                alert('error occured while saving' + data);
                            }

                        });

            }

        });



    });



</script>
