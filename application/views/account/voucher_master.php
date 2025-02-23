<div class="form-group has-feedback">
    <div class="box box-primary">
        <div class="box-body">
            <div class="col-lg-12" style="text-align:right;">
                <a class="btn btn-add" data-toggle="modal" data-target="#myModal" title="Add New Voucher Type">
                    <i class="fa fa-plus-circle fa-lg"></i>&nbsp;
                </a>

            </div>
            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="form_add" class="form-horizontal" method="post">    
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h3 class="modal-title">Add New Voucher Type</h3>
                            </div>
                            <div class="modal-body">

                                <div class="form-group" style="width:90%;margin-left:5%;">
                                    <label for="email">Voucher Name</label>
                                    <input type="text" class="form-control" id="voucher_name" name="voucher_name">
                                    <span id="error-voucher_name"><?php echo form_error('voucher_name'); ?></span>
                                </div>

                                <div class="form-group" style="width:90%;margin-left:5%;">
                                    <label for="email">Under Voucher Group</label>
                                    <select class="form-control select2" name="voucher_group" id="voucher_group">
                                        <option value="">Select</option>
                                        <?php foreach ($voucher_master_group as $vm) { ?>
                                            <option value="<?php echo $vm->voucher_code ?>"><?php echo $vm->voucher_name; ?></option>

                                        <?php } ?>

                                    </select>
                                    <span id="error-voucher_group"><?php echo form_error('voucher_group'); ?></span>
                                </div>

                                <div class="form-group" style="width:90%;margin-left:5%;">
                                    <label for="email">IS IGST?</label><br />
                                    <select name="is_igst" id="is_igst" class="form-control required">
                                        <option value="">Select</option>
                                        <option value="YES">YES</option>
                                        <option value="NO">NO</option>
                                    </select>
                                    <span id="error-is_igst"><?php echo form_error('is_igst'); ?></span>
                                </div> 

                                <div class="form-group" style="width:90%;margin-left:5%;">
                                    <label for="email">IS CGST?</label><br />
                                    <select name="is_cgst" id="is_cgst" class="form-control required " style="pointer-events: none" disabled="">
                                        <option value="">Select</option>
                                        <option value="YES">YES</option>
                                        <option value="NO">NO</option>
                                    </select>
                                    <span id="error-is_cgst"><?php echo form_error('is_cgst'); ?></span>
                                </div> 

                                <div class="form-group" style="width:90%;margin-left:5%;">
                                    <label for="email">IS SGST?</label><br />
                                    <select name="is_sgst" id="is_sgst" class="form-control required" style="pointer-events: none" disabled="">
                                        <option value="">Select</option>
                                        <option value="YES">YES</option>
                                        <option value="NO">NO</option>
                                    </select>
                                    <span id="error-is_sgst"><?php echo form_error('is_sgst'); ?></span>
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
                            <th style="border-bottom:0px">Voucher Code</th>
                            <th style="border-bottom:0px">Voucher Name</th>
                            <th style="border-bottom:0px">Voucher Group</th>
                            <th style="border-bottom:0px">IS CGST?</th>
                            <th style="border-bottom:0px">IS SGST?</th>
                            <th style="border-bottom:0px">IS IGST?</th>
                            <th style="border-bottom:0px">Created Date</th>
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
                            <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="4"/>
                            </th>
                            <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="5"/>
                            </th>
                            <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="6"/>
                            </th>
                            <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>

                            <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $i = '1';

//foreach ($data['voucher_master'] as $vm) {
                        foreach ($voucher_master as $vm) {

# code...

                            if ($vm->status == 'Y') {
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $vm->voucher_code ?></td>
                                    <td><?php echo $vm->voucher_name; ?></td>
                                    <td><?php
                                        if ($vm->voucher_group != 'PRIMARY') {
                                            echo $vm->voucher_group;
// echo [$vmm->voucher_group][$vm->voucher_group];
                                        } else {
                                            echo $vm->voucher_group;
                                        }
                                        ?>
                                    </td>

                                    <td><?php echo $vm->is_cgst; ?></td>
                                    <td><?php echo $vm->is_sgst; ?></td>
                                    <td><?php echo $vm->is_igst; ?></td>
                                    <td><?php echo $vm->date_created; ?></td>
                                    <td><span><?php if ($vm->voucher_group != 'PRIMARY') { ?><a id="<?php echo $vm->id; ?>" class="btn a-edit" title="Edit" onclick="edit(<?php echo $vm->id; ?>, '<?php echo $vm->id; ?>')"><i class="fa fa-edit"></i> </a></span>
                                            <span><a class="btn a-delete" title="Delete" onclick="deletes(<?php echo $vm->id; ?>)"><i class="fa fa-trash"></i> </a></span><?php }
                                    } ?></td>



                            </tr>
    <?php $i++;
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
            var voucher_code = $('#voucher_name').val();
            var voucher_name = $('#voucher_name').val();
            var voucher_group = $('#voucher_group').val();
            var is_igst = $('#is_igst').val();
            $.ajax({
                url: "<?php echo base_url('account/Voucher_master/save') ?>",
                type: "POST",
                dataType: 'json',
                data: {voucher_code: voucher_code, voucher_name: voucher_name, voucher_group: voucher_group, is_igst: is_igst},

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
            $.post('<?php echo base_url('account/Voucher_master/del'); ?>', {del_id: del_id}, function (data) {
                alert('Data Deleted Successfully');
                location.reload();
            });
        }
    }

    function edit(id)
    {
        $("form")[0].reset();
        $('#butt_update').attr('onclick', 'update(' + id + ')');
        $.post('<?php echo site_url('account/Voucher_master/edit') ?>', {id: id}, function (data) {
            $("#datas").html('');
            $("#datas").html(data);
            $('#EditModal').modal('show');
        });
    }


    function update()
    {

    }
</script>

<script type="text/javascript">

    $('#is_igst').change(function () {
        if (this.value == 'YES') {
            $('#is_cgst').val('NO').trigger('change');
            $('#is_sgst').val('NO').trigger('change');
        } else if (this.value == 'NO') {
            $('#is_cgst').val('YES').trigger('change');
            $('#is_sgst').val('YES').trigger('change');
        }
    });
</script>