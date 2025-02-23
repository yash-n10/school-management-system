<div class="form-group has-feedback">
    <div class="box box-primary">
        <div class="box-body">
            <div class="col-lg-12" style="text-align:right;">
                <a class="btn btn-add" data-toggle="modal" data-target="#myModal" title="Add Group">
                    <i class="fa fa-plus-circle fa-lg"></i>&nbsp;
                </a>

            </div>
            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="form_add" class="form-horizontal" method="post">    
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h3 class="modal-title">Add Group</h3>
                            </div>
                            <div class="modal-body">

                                <div class="form-group" style="width:90%;margin-left:5%;">
                                    <label for="email">Group Name</label>
                                    <input type="text" class="form-control" id="group_name" name="group_name">
                                    <span id="error-group_name"><?php echo form_error('group_name'); ?></span>
                                </div>

                                <div class="form-group" style="width:90%;margin-left:5%;">
                                    <label for="email">Under Group</label>
                                    <select class="form-control" name="under_group" id="under_group">
                                        <option value="">Select</option>
                                        <?php foreach ($group_detail as $ledger_group_value) { ?>
                                            <option  value="<?php echo $ledger_group_value->id; ?>"><?php echo $ledger_group_value->group_name; ?></option>
                                        <?php } ?>
                                    </select>
                                    <span id="error-under_group"><?php echo form_error('under_group'); ?></span>
                                </div>

                                <div class="form-group" style="width:90%;margin-left:5%;">
                                    <label for="email">Description</label><br />
                                    <input type="text" class="form-control" id="description" name="description">
                                    <span id="error-description"><?php echo form_error('description'); ?></span>
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
                            <th style="border-bottom:0px">Group Name</th>
                            <th style="border-bottom:0px">Under Group</th>
                            <th style="border-bottom:0px">Parent Group</th>
                            <th style="border-bottom:0px">Description</th>
                            <th style="border-bottom:0px"> Action</th>
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
                            <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>

                            <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                        </tr>
                    </thead>          
                    <tbody>
                        <?php
                        $i = '1';
                        foreach ($group_detail as $val) {
                            if ($val->status == 'Y') {
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $val->group_name ?></td>
                                    <td><?php echo $val->under_group ?></td>
                                    <td><?php echo $val->parent_group ?></td>
                                    <td><?php echo $val->description ?></td>
                                    <td>
                                        <?php if($val->id>36) {?>
                                        <span><a class="btn a-edit" title="Edit" onclick="edit(<?php echo $val->id; ?>, '<?php echo $val->group_name; ?>', '<?php echo $val->id; ?>', '<?php echo $val->parent_group; ?>', '<?php echo $val->description; ?>', '<?php echo $val->parent_group_id; ?>', '<?php echo $val->group_type; ?>')"><i class="fa fa-edit"></i> </a></span>
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
            var group_name = $('#group_name').val();
            var under_group = $('#under_group').val();
            var description = $('#description').val();
            $.ajax({
                url: "<?php echo base_url('account/Group/save') ?>",
                type: "POST",
                dataType: 'json',
                data: {group_name: group_name, under_group: under_group, description: description},
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
            $.post('<?php echo base_url('account/Group/del'); ?>', {del_id: del_id},
                    function (data) {
                        alert('Data Deleted Successfully');
                        location.reload();
                    });
        }
    }

    function edit(id, group_name, under_group, parent_group, description, parent_group_id, group_type)
    {
        $("form")[0].reset();
        $('#butt_update').attr('onclick', 'update(' + id + ')');
        $.post('<?php echo site_url('account/Group/edit') ?>', {id: id, group_name: group_name, under_group: under_group, parent_group: parent_group, description: description, parent_group_id: parent_group_id, group_type: group_type}, function (data) {
            $("#datas").html('');
            $("#datas").html(data);
            $('#EditModal').modal('show');
        });
    }


    function update()
    {
        var update_id = $("#update_id").val();
        var group_name_edt = $("#group_name_edt").val();
        var under_group_edt = $("#under_group_edt").val();
        var description_edt = $("#description_edt").val();

        $.post('<?php echo base_url('account/Group/update') ?>', {update_id: update_id, group_name_edt: group_name_edt, under_group_edt: under_group_edt, description_edt: description_edt}, function (data) {
            alert('Successfully Updated');
            location.reload();
        });
    }
</script>