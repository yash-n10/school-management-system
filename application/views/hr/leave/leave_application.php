<!--<style>-->
<!--    .chosen-disabled {
        opacity: .8!important;
        cursor: default;
    }-->
<!--</style>-->
<div class="form-group has-feedback">
    <div class="box">            
        <div class="box-body">
            <?php if (substr($right_access, 0, 1) == 'C') { ?>
                <div class="col-lg-12">
                    <div class="col-lg-12" style="text-align:right;">
                        <button data-toggle="modal" data-target="#div_leave_apply" onclick="check_apply_details()" class="btn btn-add" id="add_leave_apply" title="Apply Leave">
                            <i class="fa fa-plus-circle fa-lg"></i> 
                        </button>
                    </div>

                </div>
            <?php } ?>
        </div>





        <div class="box-body">


            <form id='frmleave_apply_approve' role="form" method="POST">
                <div class="table-responsive">
                    <table id="leave_apply_approve_list" class="table table-bordered table-striped">
                        <thead style="background:#99ceff;">
                            <tr>
                                <th style="border-bottom:0px">Employee Code</th>
                                <th style="border-bottom:0px">Leave Type</th>
                                <th style="border-bottom:0px">From Date</th>
                                <th style="border-bottom:0px">To Date</th>
                                <th style="border-bottom:0px">No.of Days</th>
                                <th style="border-bottom:0px">Applied By</th>
                                <th style="border-bottom:0px">Leave Status</th>
                                <th style="border-bottom:0px">Authorized By</th>
                                <th style="border-bottom:0px">Authorized Comment</th>
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
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($leave_apply_approve as $row) {
                                ?>
                                <tr>
                                    <td><?php echo $row->emp_code; ?></td>                                         
                                    <td><?php echo $row->leave_id; ?></td>                                         
                                    <td><?php echo $row->from_date; ?></td>                                         
                                    <td><?php echo $row->to_date; ?></td>                                         
                                    <td><?php echo $row->no_of_days; ?></td>                                         
                                    <td><?php echo $row->applied_by; ?></td>    
                                    <?php if ($row->leave_status == 'PENDING') {
                                        $class = 'background:#f39c12;color:white';
                                    } else if ($row->leave_status == 'APPROVED' || $row->leave_status == 'APPROVED:LOP') {
                                        $class = 'background:#398439;color:white';
                                    } else {
                                        $class = 'background:#ac2925 ;color:white';
                                    } ?>
    
                                    <td style="<?php echo $class; ?>">
                                            <?php echo $row->leave_status; ?>
                                    
                                    </td>                                         
                                    <td><?php echo $row->approved; ?></td>                                         
                                    <td><?php if ($row->leave_status != 'CANCELLED') {
                                            echo $row->remarks;
                                        } else {
                                            echo $row->approve_comment;
                                        } ?></td>                                         
                                    <td>
                                        <div class="form-group row">
                                                <?php if (substr($right_access, 3, 1) == 'D' && $row->leave_status == 'PENDING') { ?>
                                                <div class="col-sm-1">
                                                    <input type="checkbox" class="btn"  id="<?php echo $row->id; ?>">
                                                </div>
                                                <?php } if (substr($right_access, 2, 1) == 'U' && $row->leave_status == 'PENDING') { ?>
                                                <div class="col-sm-2">
                                                    <a class="btn a-edit" id="<?php echo $row->id; ?>" onclick="edit_apply(this.id,<?php echo $row->emp_id; ?>, '<?php echo $row->emp_name; ?>', '<?php echo $row->emp_desg; ?>', '<?php echo $row->reason; ?>', '<?php echo $row->remarks; ?>', '<?php echo $row->leave_type_id; ?>')">
                                                        <i class="fa fa-edit"></i> 
                                                    </a>
                                                </div>
                                                <?php } if ($row->leave_status == 'PENDING' && $session_employee_id != $row->emp_id) { ?>
                                                <div class="col-sm-2">
                                                    <button class="btn btn-primary" type="button" id="<?php echo $row->id; ?>" onclick="toapproval(this.id,<?php echo $row->emp_id; ?>, '<?php echo $row->emp_name; ?>', '<?php echo $row->emp_desg; ?>', '<?php echo $row->reason; ?>', '<?php echo $row->remarks; ?>', '<?php echo $row->leave_type_id; ?>', 'approve')">
                                                        Approve/Reject
                                                    </button>
                                                </div>
                                                <?php } else if (($row->leave_status == 'APPROVED' || $row->leave_status == 'APPROVED:LOP') && $session_employee_id != $row->emp_id) { ?>
                                                <div class="col-sm-2">
                                                    <button class="btn btn-danger" type="button" id="<?php echo $row->id; ?>" onclick="toapproval(this.id,<?php echo $row->emp_id; ?>, '<?php echo $row->emp_name; ?>', '<?php echo $row->emp_desg; ?>', '<?php echo $row->reason; ?>', '<?php echo $row->remarks; ?>', '<?php echo $row->leave_type_id; ?>', 'cancel')">
                                                        Cancel
                                                    </button>
                                                </div>
                                                <?php } ?>
                                        </div>
                                    </td>

                                </tr>
                        <?php } ?>
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>

                </div>
                    <?php if (substr($right_access, 3, 1) == 'D') { ?>
                    <div class="box-body" style="text-align:right">
                    <?php if (count($leave_apply_approve) > 0) { ?>              
                            <input type="button" class="btn btn-danger" id="emp_cats" value="Delete" onclick="deleteLeaveApply();">
                    <?php } ?>

                    </div>
                    <?php } ?>

            </form>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>

<div id="div_leave_apply" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <form action="<?php echo base_url('hr/leave/leave_application/save'); ?>" method="post" id="manage_apply_leave"  class="form-horizontal">

                <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title">Apply Leave</h3>
                </div>
                <div class="modal-body form">
                    <div class="form-body">
                            <?php if ($this->session->userdata('login_type') == 'admin' || $this->session->userdata('login_type') == 'principal' || $this->session->userdata('login_type') == 'hr') { ?>
                            <div class="form-group" >
                                <label class="control-label col-md-2 req"> Emp. Code :</label>
                                <div class="col-md-4">
                                    <select class="form-control" name="employee_code" id="employee_code" required>
                                        <option value="">Select Employee code</option>
                                        <?php foreach ($fetch_employee as $emp) { ?>

                                            <option value="<?php echo $emp->id ?>" <?php if ($task = 'edit') {
            
                                            } ?>><?php echo $emp->employee_code ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">Emp. Name :</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="employee_name" name="employee_name" placeholder="Employee Name" readonly />
                                </div>
                                <label class="control-label col-md-2">Designation :</label>
                                <div class="col-md-4">
                                    <select class="form-control chosen-select" name="designation" id="designation" disabled="true">
                                        <option value="">Designation</option>
                                        <?php foreach ($fetch_designation as $desg) { ?>

                                            <option value="<?php echo $desg->id ?>"><?php echo $desg->designation_desc ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <?php } else { ?>
                            <input type="hidden" name="employee_code" id="employee_code" value="<?php echo $session_employee_id; ?>">

                            <?php } ?>
                            <div class="form-group">
                                <label class="control-label col-md-2">From Date :</label>
                                <div class="col-md-4">
                                    <input type='date' class="form-control" id="applicable_from" name="applicable_from" value="" required>
                                </div>
                                <label class="control-label col-md-2" >To Date :</label>
                                <div class="col-md-4">
                                    <input type='date' class="form-control" id="applicable_to" name="applicable_to" value="">
                                </div>
                            </div>
                        <div class="form-group">
                            <label class="control-label col-md-2" >Leave Type :</label>
                            <div class="col-md-4">
                                <select class="form-control" name="leave_type" id="leave_type" required>
                                    <option value="">Select Leave Type</option>
                                        <?php foreach ($fetch_leave_type as $leave) { ?>

                                        <option value="<?php echo $leave->id ?>"><?php echo $leave->leave_type_code ?></option>
                                        <?php } ?>
                                </select>
                            </div>
                            <label class="control-label col-md-2" >No.of Days :</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="nodays" name="nodays" placeholder="No. of days"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2" >Reason :</label>
                            <div class="col-md-4">
                                <textarea class="form-control" name="reason"id="reason" placeholder="Reason" required></textarea>

                            </div>

                        </div>
                    </div>

                    <div class="form-body" id="toapply_leave_details_div" style="padding-top: 2%">

                        <table class="table table-bordered" id="toapply_leave_details_tbl">

                            <thead>
                                <tr><td colspan="4" style="text-align:center;font-size: 18px;border-bottom:1px solid grey">Leave Details</td></tr>
                                <tr>
                                    <th>Leave Type</th>
                                    <th>Opening Leave</th>
                                    <th>Taken Leave</th>
                                    <th>Available Leave</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>

                        </table>
                    </div>

                </div>
                <div class="modal-footer">
                    <label id="error_apply" style="color:red;float: left"></label>
                    <button type="button" class="btn btn-success" id="btn_save">Apply</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
            <!--</div>-->
        </div>

    </div>
</div>





<div id="div_toapproval" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <form action="<?php echo base_url('hr/leave/leave_approval/approve'); ?>" method="post" id="manage_approval"  class="form-horizontal">

                <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title">Application Details</h3>
                        <input type="hidden" name="approve_leave" id="approve_leave" value="">
                </div>
                <div class="modal-body form">
                    <div class="form-body">
                        <div class="form-group " >
                            <label class="control-label col-md-1 req"> Emp. Code </label>

                            <div class="col-md-3">
                                <select class="form-control" name="toapprove_employee_code" id="toapprove_employee_code" style="pointer-events: none;background-color: #eee;opacity: 1;">
                                    <option value="">Select Employee code</option>
                                    <?php foreach ($fetch_employee as $emp) { ?>

                                        <option value="<?php echo $emp->id ?>"><?php echo $emp->employee_code ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <label class="control-label col-md-1">Emp. Name </label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="toapprove_employee_name" name="toapprove_employee_name" placeholder="Employee Name" style="pointer-events: none;background-color: #eee;opacity: 1;" />
                            </div>
                            <label class="control-label col-md-1" >Designation </label>
                            <div class="col-md-3">
                                <select class="form-control " name="toapprove_designation" id="toapprove_designation" style="pointer-events: none;background-color: #eee;opacity: 1;">
                                    <option value="">Designation</option>
                                        <?php foreach ($fetch_designation as $desg) { ?>

                                        <option value="<?php echo $desg->id ?>"><?php echo $desg->designation_desc ?></option>
                                        <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-1">From Date </label>
                            <div class="col-md-3">
                                <input type='date' class="form-control" id="toapprove_applicable_from" name="toapprove_applicable_from" value="" style="pointer-events: none;background-color: #eee;opacity: 1;">
                            </div>
                            <label class="control-label col-md-1">To Date </label>
                            <div class="col-md-3">
                                <input type='date' class="form-control" id="toapprove_applicable_to" name="toapprove_applicable_to" value="" style="pointer-events: none;background-color: #eee;opacity: 1;">
                            </div>
                            <label class="control-label col-md-1">No.of Days </label>
                            <div class="col-md-3">
                                <input type="number" class="form-control" id="toapprove_nodays" name="toapprove_nodays" placeholder="No. of days" style="pointer-events: none;background-color: #eee;opacity: 1;"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-1">Leave Type </label>
                            <div class="col-md-3">
                                <select class="form-control" name="toapprove_leave_type" id="toapprove_leave_type" style="pointer-events: none;background-color: #eee;opacity: 1;">
                                    <option value="">Select Leave Type</option>
                                        <?php foreach ($fetch_leave_type as $leave) { ?>

                                        <option data-loss="<?php echo $leave->loss_of_pay; ?>" value="<?php echo $leave->id ?>"><?php echo $leave->leave_type_code ?></option>
                                        <?php } ?>
                                </select>
                            </div>
                            <label class="control-label col-md-1">Reason </label>
                            <div class="col-md-3">
                                <textarea class="form-control" name="toapprove_reason" id="toapprove_reason" placeholder="Reason" style="pointer-events: none;background-color: #eee;opacity: 1;"></textarea>

                            </div>

                        </div>

                    </div>
                    <div class="form-body" id="toapprove_leave_details_div" style="padding-top: 2%">

                        <table class="table table-bordered" id="toapprove_leave_details_tbl">

                            <thead>
                                <tr><th colspan="4">Leave Details</th></tr>
                                <tr>
                                    <th>Leave Type</th>
                                    <th>Opening Leave</th>
                                    <th>Taken Leave</th>
                                    <th>Available Leave</th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                    <div class="form-body">
                        <div class="form-group row">
                            <label class="col-md-12 req"> Comment </label>
                            <div class="col-md-6">
                                <textarea class="form-control" required name="comment" autofocus=""></textarea>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="modal-footer" id="modal-footer-approve" style="display:none">
                    <button type="button" class="btn btn-success" id="btn_approve" onclick="leave_approve('APPROVED');">Approve</button>
                    <button type="button" class="btn btn-danger" id="btn_reject" onclick="leave_approve('REJECTED');">Reject</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                <div class="modal-footer" id="modal-footer-cancel" style="display:none">
                    <button type="button" class="btn btn-danger" id="btn_approve_cancel" onclick="leave_approve('CANCELLED');">Cancel</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
            <!--</div>-->
        </div>

    </div>
</div>
<script>
    $(document).ready(function () {

//    $('.chosen-select').chosen({width:"100%"});
//    $('#datetimepicker1,'+'#datetimepicker2').datetimepicker({

//                todayBtn: true,
//                autoclose: true,
//                pickerPosition: "bottom-left",
//                format:'yyyy-mm-dd',
//                startView:3,
//                minView:3
//            


//            }); 


        $('#employee_code').change(function () {

//        alert(this.value);



            $.ajax({
                url: '<?php echo base_url('hr/leave/leave_application/get_employee_information'); ?>',
                data: {code: $(this).val()},
                type: 'POST',
                dataType: 'JSON',
                success: function (data)
                {

                    $.each(data, function (index, element)
                    {

                        $('#employee_name').val(element['name']);

                        $('#designation').val(element['designation_id']).prop('selected', true).trigger('change');;

                    });

                },
                error: function ()
                {
                    alert('error');
                }


            });
            find_apply_leave_details($(this).val());

        });



        $('#applicable_from,' + '#applicable_to').change(function ()
        {
            var d = new Date($('#applicable_from').val());

            var month_from = d.getMonth();
            var year_from = d.getFullYear();
            var day_from = d.getDate();
            var diff = 0;
            if ($('#applicable_to').val() != '')
            {
                var dto = new Date($('#applicable_to').val());
                var month_to = dto.getMonth();
                var day_to = dto.getDate();

                if (month_from == month_to)
                {


                    diff = Number(day_to - day_from) + 1;

                } else
                {
                    var new_month = Number(month_from) + 1;
                    var nodays = new Date(year_from, new_month, 0).getDate();
//                                alert('last='+nodays+'from='+day_from);
                    var diff_half1 = Number(nodays - day_from) + 1;
                    diff = Number(diff_half1) + Number(day_to);

                }

            } else {
                diff = 1;



            }


            $('#nodays').val(diff);
            if (diff <= 0) {

                alert('Please choose correct "To date" !!!!!!!!');

                $('#applicable_to').css('border', '1px solid red');
                $('#btn_save').attr('disabled', true);
            } else {

                $('#applicable_to').css('border', '1px solid #d2d6de');
                $('#btn_save').attr('disabled', false);
            }

        });




        $('#btn_save').click(function ()
        {


            var url = $('#manage_apply_leave').attr('action');

            if (!$('#manage_apply_leave')[0].checkValidity())
            {
//                                                alert($('#add_stud_frm')[0].validationMessage);
                $(this).show();
                $('#manage_apply_leave')[0].reportValidity();
                return false;
            } else {

//                alert($('#leave_type').val());
//                alert($('#nodays').val());
//                alert($('#toapply_leave_details_tbl #bal_leave_' + $('#leave_type').val()).text());
                if (Number($('#toapply_leave_details_tbl #bal_leave_' + $('#leave_type').val()).text()) >= $('#nodays').val()) {
//                    alert('ok');
                    $.ajax({

                        url: url,
                        type: 'POST',
                        data: $('#manage_apply_leave').serialize(),
                        dataType: 'text',
                        success: function (data)
                        {
                            alert('Leave Applied Successfully !');
                            window.location.reload();

                        },
                        error: function ()
                        {
                        }


                    });
                } else {
                    alert('Sorry You Have Insufficient Balance for This Leave Type!');
                }
            }


        });




    });


    $(function ()
    {
        var table =$('#leave_apply_approve_list').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "order": [[2, "asc"]],
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

    });

    function check_apply_details() {


//   alert($('#toapply_leave_details_tbl tbody').html());
<?php if ($this->session->userdata('login_type') != 'admin' && $this->session->userdata('login_type') != 'principal' && $this->session->userdata('login_type') != 'hr') { ?>
    //           alert('<?php // echo $this->session->userdata('login_type')  ?>');
            find_apply_leave_details('<?php echo $session_employee_id; ?>');
<?php } ?>
    }
//----------------------Edit operation-----------------------------

    function edit_apply(id, emp_id, name, desg, reason, remarks, leave_type)
    {
//      alert(id);

        var from_date = $('#' + id).closest('tr').find("td:nth-child(3)").text();
        var to_date = $('#' + id).closest('tr').find("td:nth-child(4)").text();
        var nodays = $('#' + id).closest('tr').find("td:nth-child(5)").text();
//            alert(from_date);  
//            var id=$('#leave_apply_approve_list a').attr('id');


        var action_url = '<?php echo base_url('hr/leave/leave_application/update'); ?>' + '/' + id;
        $('#manage_apply_leave').attr('action', action_url);
        $('#employee_code').val(emp_id).prop('selected', true).trigger("change");
        $('#applicable_from').val(from_date);
        $('#applicable_to').val(to_date);
        $('#nodays').val(nodays);
        $('#employee_name').val(name);
        $('#reason').val(reason);
        $('#remarks').val(remarks);
        $('#designation').val(desg).prop('selected', true).trigger("change");
        $('#leave_type').val(leave_type).prop('selected', true).trigger("change");
        $('#btn_save').text('Update');
        $('#div_leave_apply').modal('show');
        find_apply_leave_details(emp_id);

    }
    function find_apply_leave_details(empid) {
//    alert(empid);
        $.ajax({
            url: '<?php echo base_url('hr/leave/leave_application/fetch_leave_details'); ?>',
            data: {empl_id: empid},
            type: 'POST',
            dataType: 'JSON',
            success: function (data)
            {
                if (data[1] == 0) {
                    $('#error_apply').text('No Leave Types with Leave Balance');
                    $('#toapprove_leave_details_div').html('');
                    $('#toapply_leave_details_tbl tbody').html('');
                    $('#btn_save').attr('disabled', true);
                } else {
                    $('#error_apply').text('');
                    $('#btn_save').attr('disabled', false);
                    $('#toapply_leave_details_div').html(data[0]);
                }

            },
            error: function ()
            {
                alert('error');
            }


        });
    }

    function toapproval(id, emp_id, name, desg, reason, remarks, leave_type, button_status)
    {
//            var session_emp_id='<?php // echo $session_employee_id; ?>';
//            if(session_emp_id==emp_id) {
//            }
        var from_date = $('#' + id).closest('tr').find("td:nth-child(3)").text();
        var to_date = $('#' + id).closest('tr').find("td:nth-child(4)").text();
        var nodays = $('#' + id).closest('tr').find("td:nth-child(5)").text();
        $('#toapprove_employee_code').val(emp_id).prop('selected', true).trigger('change');;
        $('#approve_leave').val(id);
        $('#toapprove_applicable_from').val(from_date);
        $('#toapprove_applicable_to').val(to_date);
        $('#toapprove_nodays').val(nodays);
        $('#toapprove_employee_name').val(name);
        $('#toapprove_reason').val(reason);
        $('#toapprove_remarks').val(remarks);
        $('#toapprove_designation').val(desg).prop('selected', true).trigger('change');;
        $('#toapprove_leave_type').val(leave_type).prop('selected', true).trigger('change');;
        if (button_status == 'approve') {
            $('#modal-footer-approve').css('display', 'block');
            $('#modal-footer-cancel').css('display', 'none');
        } else {
            $('#modal-footer-approve').css('display', 'none');
            $('#modal-footer-cancel').css('display', 'block');
        }
        $.ajax({
            url: '<?php echo base_url('hr/leave/Leave_approval/fetch_leave_details'); ?>' + '/' + emp_id,
            type: 'POST',
            data: {empl_id: emp_id, leave_type: leave_type},
            dataType: 'html',
            success: function (data)
            {
//                    alert(data);
                $('#toapprove_leave_details_div').html(data);
                $('#div_toapproval').modal('show');
            },
            error: function ()
            {
                alert('error occured');
                $('#div_toapproval').modal('show');
            }
        });
        $('#div_toapproval').modal('show')
    }

    function leave_approve(status) {

        if (!$('#manage_approval')[0].checkValidity())
        {
//                                                alert($('#add_stud_frm')[0].validationMessage);
            $(this).show();
            $('#manage_approval')[0].reportValidity();
            return false;
        } else {


            if (status == 'CANCELLED') {

                var url = '<?php echo base_url('hr/leave/Leave_approval/cancel'); ?>';
            } else {

                var url = '<?php echo base_url('hr/leave/Leave_approval/approve'); ?>';
                if (status == 'APPROVED') {
//                            alert($('#toapprove_leave_type').find(":selected").attr('data-loss'));
                    if (($('#toapprove_leave_details_tbl #bal_leave').text() == '0') || ($('#toapprove_leave_type').find(":selected").attr('data-loss') == 'YES')) {

                        status = 'APPROVED:LOP';
                    }
                }
            }
            $.ajax({
                url: url,
                type: 'POST',
                data: $('#manage_approval').serialize() + '&status=' + status,
                dataType: 'text',
                success: function (data) {

                    alert('Successfully done');
                    window.location.reload();
                },
                error: function () {
                }

            });

        }
    }


    $('#div_leave_apply').on('hidden.bs.modal', function (e)
    {
        $('#manage_apply_leave')[0].reset();
//            $('#toapprove_leave_details_div').html('');
        $('#toapply_leave_details_tbl tbody').html('');
//            alert($('#toapprove_leave_details_div').html());
        $('select').trigger('change');
        $('#btn_save').text('Apply');
        $('#employee_code,' + '#designation,' + '#leave_type');
        $('#manage_apply_leave').attr('action', "<?php echo site_url('hr/leave/leave_application/save') ?>");

    });



//--------------------------------------------------------------------

    function deleteLeaveApply()
    {
        var r = confirm("Are you sure you want to delete this record?");
//                var id='1';
        if (r == true)
        {
            var apply_id_string = [];
            var i = 0;
            $("input:checked").each(function ()
            {
                apply_id_string[i] = $(this).attr("id");
                i++;
            });

//
            $.ajax({
                url: "<?php echo site_url('hr/leave/leave_application/delete') ?>",
                type: "POST",
                data: {apply_id_string: apply_id_string},
                dataType: "text",
                success: function (data)
                {
                    window.location.reload();
//                         
                },
                error: function (data, status)
                {
                    alert('e' + data + status);
                }
            });

        }
    }

</script>