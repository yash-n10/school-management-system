

<div class="form-group has-feedback">
    <div class="box">            
<!--        <div class="box-header">
            <h3 class="box-title main_head"><u>Room Allocated</u></h3>
        </div>-->
        <!-- /.box-header --> 



        <div class="box-body">
            <div class="col-lg-12">
                <div class="col-lg-12" style="text-align:right;"><button data-toggle="modal" data-target="#div_allocate_room" class="btn btn-success" id="allocate_room"> <i class="fa fa-plus-circle fa-lg"></i> Allocate Room</button></div>
            </div>
        </div>


        <div class="box-body">           

            <form id='frmtemplate' role="form" method="POST">

                <table id="allocation_list" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Room No</th>
                            <th>Dormitory Name</th>
                            <th>Berth No</th>
                            <th>Admission No</th>
                            <th>Student Name</th>
                            <th>Class</th>
                            <th>Allocation Date</th>
                            <th>Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 1;
                        foreach ($fetch_stud_room as $row):
                            ?>

                            <tr>
                                <td><?php echo $row->id; ?> </td>
                                <td><?php echo $row->room_no; ?> </td>
                                <td><?php echo $row->dorm_name; ?></td>                                                                               
                                <td><?php echo $row->berth_no; ?></td>                                                                               
                                <td><?php echo $row->admission; ?></td>                                                                               
                                <td><?php echo $row->stud_name; ?></td>                                                                               
                                <td><?php echo $row->class; ?></td>                                                                               
                                <td><?php echo $row->alloc_date; ?></td>                                                                               
                                <td><?php echo $row->amount; ?></td>                                                                               
                                <td>
                                    <div class="form-group row">
                                        <div class="col-sm-1" style="line-height: 2;">
                                            <input type="checkbox" class="btn"  id="<?php echo $row->id; ?>">
                                        </div>
                                        <div class="col-sm-2">
                                            <a class="btn" id="<?php echo $row->id; ?>" onclick="edit(this,<?php echo $row->stud_id; ?>, <?php echo $row->dorm_id; ?>, <?php echo $row->room_id; ?>)">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                        </div>
                                    </div>
                                </td>

                            </tr>
<?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>


                <div class="box-body" style="text-align:right">
                    <?php if (count($fetch_stud_room) > 0) { ?>              
                        <input type="button" class="btn btn-danger" id="room_del" value="Delete" onclick="deleteClass();">
<?php } ?>

                </div>


            </form>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>
</div>
<div id="div_allocate_room" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form action="<?php echo base_url('Hostel/allocate_student/save') ?>" method="post" id="frm_room_allocate">
                <div class="modal-header" id="modal_header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Allocate Room</h4>
                </div>
                <div class="modal-body" id="modal-body" style="height:350px;">

                    <div class="form-group">
                        <label class="col-md-4">Dormitory Name</label>
                        <div class="col-md-8" style='padding-bottom:1%'>
                            <select class="form-control" name="dorm_name" id="dorm_name">
                                <option value="">Select Dormitory Name</option>
                                <?php foreach ($fetch_dorm as $row) { ?>
                                    <option value="<?php echo $row->id; ?>"><?php echo $row->dormitory_name; ?></option>           
<?php } ?>
                            </select>
                            <!--<input type="text" class="form-control" id="dorm_name" name="dorm_name" placeholder="Dormitory Name" value=''>-->
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4">Room No</label>
                        <div class="col-md-8" style='padding-bottom:1%' id="load_room">
                            <select class="form-control" name="room_no" id="room_no">
                                <option value="">Select Room No</option>
                                <?php foreach ($fetch_room as $row) { ?>
                                    <option value="<?php echo $row->id; ?>"><?php echo $row->room_no; ?></option>           
<?php } ?>
                            </select>
                            <!--<input type="text" class="form-control" id="room_no" name="room_no" placeholder="Room No." value=''>-->
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-4">Berth No</label>
                        <div class="col-md-8" style='padding-bottom:1%'>

                            <input type="text" class="form-control" id="berth" name="berth" placeholder="Berth No" value=''>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4">Admission No</label>
                        <div class="col-md-8" style='padding-bottom:1%'>
                            <select class="form-control" name="adm" id="adm">
                                <option value="">Select Admission No.</option>
                                <?php foreach ($fetch_stud as $row) { ?>
                                    <option value="<?php echo $row->id; ?>" class="admisn"><?php echo $row->admission_no; ?></option>           
<?php } ?>
                            </select>
                            <!--<input type="text" class="form-control" id="student" name="student" placeholder="Max Student Allowed" value=''>-->
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4">Student Name</label>
                        <div class="col-md-8" style='padding-bottom:1%'>

                            <input type="text" class="form-control" id="stud_name" name="stud_name" placeholder="Student Name" value=''>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-4">Class</label>

                        <div class="col-md-8" style='padding-bottom:1%'>
                            <input type="text" class="form-control" id="clas" name="clas" placeholder="Class Name" value=''>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-4">Allocation Date </label>    
                        <div class="col-md-8" style='padding-bottom:1%'>
                            <input type="date" class="form-control" id="alloc_d" name="alloc_d" placeholder="Allocation Date" value=''>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-4">Amount</label>

                        <div class="col-md-8" style='padding-bottom:1%'>
                            <input type="text" class="form-control" id="amnt" name="amnt" placeholder="Amount" value=''>
                        </div>
                    </div>


                </div>
                <!--<div class="modal-footer" id="modal-footer">-->
                <div class="row" id="modal-footer">
                    <button type="button" class="btn btn-success" id="btn_save">Save</button>
                </div>
            </form>
            <!--</div>-->
        </div>

    </div>
</div>

<script>


    $(function ()
    {
        $('#allocation_list').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true
        });

    });
    $('#load_room').on('change', '#room_no', function ()
    {
        var r_no = $('#room_no').val();
        var d_no = $('#dorm_name').val();


        $.ajax({
            type: "POST",
            data: {room: r_no,
                dorm: d_no, },
            url: "<?php echo base_url('hostel/fetch_amount'); ?>",
            dataType: "JSON",
            success: function (data)
            {
                $.each(data, function (index, element)
                {
//                                 alert(element['amount']);
                    $('#amnt').val(element['amount']);

                });

            },
            error: function (req, status)
            {
                alert('error');
            },

        });
    });
    $(document).ready(function ()
    {
        $('.chosen_select').chosen({width: "100%"});


        $('#adm').change(function () {
//          alert($('#adm').val());
            $.ajax({
                type: "POST",
                data: {admission: this.value},
                async: false,
                url: "<?php echo base_url('hostel/student_detail'); ?>",
                dataType: "JSON",
                success: function (data)
                {
                    $.each(data, function (index, element)
                    {
                        $('#stud_name').val(element['name']);
                        $('#clas').val(element['class']);
                    });
                },

                error: function (req, status)
                {
                    alert('error');
                },
            });
            return false;
        });


        $('#dorm_name').change(function ()
        {
            var dorm = $('#dorm_name').val();
            var room = $('#room_no').val();

            $.ajax({
                type: "POST",
                data: {dorm_no: dorm,
                    room_no: room},
                url: "<?php echo base_url('hostel/get_room'); ?>",
                dataType: "text",
                success: function (data)
                {
                    $('#load_room').html(data);
                },
                error: function (req, status)
                {
                    alert('error');
                },

            });
        });



    });


//----------------------Edit operation-----------------------------
//$('#allocation_list a').click(function()
    function edit(me, admission, dorm, room)
    {
        var stud_name = $(me).closest('tr').find("td:nth-child(6)").text();
        var clas = $(me).closest('tr').find("td:nth-child(7)").text();
        var brth = $(me).closest('tr').find("td:nth-child(4)").text();
        var alloc = $(me).closest('tr').find("td:nth-child(8)").text();
        var amnt = $(me).closest('tr').find("td:nth-child(9)").text();
//    alert(amnt);
        var id = $(me).attr('id');
        var action_url = '<?php echo base_url('Hostel/allocate_student/update'); ?>' + '/' + id;
        $('#room_no').val(room).prop('selected', true).trigger("chosen:updated");
        $('#dorm_name').val(dorm).prop('selected', true).trigger("chosen:updated");
        $('#adm').val(admission).prop('selected', true).trigger("chosen:updated");
        $('#stud_name').val(stud_name);
        $('#clas').val(clas);
        $('#alloc_d').val(alloc);
        $('#amnt').val(amnt);
        $('#berth').val(brth);
        $('#frm_room_allocate').attr('action', action_url);
        $('#frm_room_allocate .modal-title').text('Update Allocation');

        $('#div_allocate_room').modal('show');

    }
//--------------------------------------------------------------------

    $('#div_allocate_room').on('hidden.bs.modal', function (e)
    {
        var action_url = '<?php echo site_url('Hostel/allocate_student/save') ?>';
//        alert(action_url);
        $('#room_no').val('');
        $('#dorm_name').val('');
        $('#adm').val('');
        $('#stud_name').val('');
        $('#clas').val('');
        $('#alloc_d').val('');
        $('#amnt').val('');
        $('#berth').val('');
        $('#frm_room_allocate').attr('action', action_url);
        $('#frm_room_allocate .modal-title').text('Allocate Room');
    });

    $('#btn_save').click(function ()
    {
        var formdata = $('#frm_room_allocate').serialize();
        var action_url = $('#frm_room_allocate').attr('action');
//             alert(action_url);


        $.ajax
                ({
                    type: 'POST',
                    data: formdata,
                    url: action_url,
                    datatype: "text",
                    success: function (data)
                    {
                        window.location.href = '<?php echo base_url('Hostel/allocate_student/'); ?>';

                    },
                    error: function (data)
                    {
                        alert('error occured while saving' + data);
                    }

                });

    });


    $('#berth').change(function ()
    {
        alert('hi');
        $.ajax({
            type: "POST",
            data: {room: $('#room_no').val(),
                dorm: $('#dorm_name').val(), },
            url: "<?php echo base_url('hostel/count_berth'); ?>",
            dataType: "Text",
            success: function (data)
            {
                if (data == 1)
                {
                    return true;
                } else
                {
                    alert('No Seat Available');
                    $('#btn_save').attr('disabled', true);
                }
            },

            error: function (req, status)
            {
                alert('error');
            },
        });
    });

    function deleteClass()
    {
        var r = confirm("Are you sure you want to delete this record?");
//                var id='1';
        if (r == true)
        {
            var class_id_string = [];
            var i = 0;
            $("input:checked").each(function ()
            {
                class_id_string[i] = $(this).attr("id");
//                            alert($(this).attr("id"));
                i++;
            });

//
            $.ajax({
                type: "POST",
                data: {
                    class_id_string: class_id_string},
                dataType: "text",
                url: "<?php echo site_url('Hostel/allocate_student/delete') ?>",
                success: function (data)
                {
                    window.location.href = "<?php echo base_url('Hostel/allocate_student/'); ?>";
//                         
                },
                error: function (data, status)
                {
                    alert('e' + data + status);
                }});

        }
    }


</script>




