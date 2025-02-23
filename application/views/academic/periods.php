<div class="form-group has-feedback">
    <div class="box">
        <div class="box-body">
            <div class="col-lg-12">
                <div class="col-lg-12" style="text-align:right;">
                    <?php if(substr($right_access, 0,1)=='C') {?>
                    <button data-toggle="modal" data-target="#addperiod" class="btn btn-add" id="add_session" title="Add Periods"> <i class="fa fa-plus-circle fa-lg"></i> </button>
                    <?php } ?>
                </div>
            </div>
        </div> 

        
        <div class="box-body">
            <?php if(substr($right_access, 1,1)=='R') {?>
            <table cellpadding="0" cellspacing="0" border="2"  class="table table-striped table-bordered" id="period">
                <thead style="background:#99ceff;">
                    <tr>
                        <th style="border-bottom:0px">S.No.</th>
                        <th style="border-bottom:0px">Period Name</th>
                        <th style="border-bottom:0px">Start Time</th>
                        <th style="border-bottom:0px">End Time</th>
                        <th style="border-bottom:0px">Actions</th>
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
                    </tr>
                </thead>
                <tbody>
<?php
$x = 1;
foreach ($periods as $value) {
    ?>
                        <tr>
                            <td><?php echo $x; ?></td>
                            <td><?php echo $value->name; ?></td>
                            <td><?php echo $value->time_start . "&nbsp;:&nbsp;" . $value->time_start_min; ?></td>
                            <td><?php echo $value->time_end . "&nbsp;:&nbsp;" . $value->time_end_min; ?></td>
                            <td><span><a class="btn a-edit" onclick="edit(<?php echo $value->id; ?>, '<?php echo $value->name; ?>',<?php echo $value->time_start; ?>,<?php echo $value->time_start_min; ?>,<?php echo $value->time_end; ?>,<?php echo $value->time_end_min; ?>,'<?php echo $value->break_yes_no; ?>')"><i class="fa fa-edit"></i> </a></span>
                                <span><a class="btn a-delete" id="" onclick="delet(<?php echo $value->id; ?>)"><i class="fa fa-trash"></i> </a></span></td>          
                        </tr>
                        <?php $x++;
                    } ?>
                </tbody>
            </table>
            <?php }?>
        </div>
    </div>


</div>
<?php if(substr($right_access, 0,1)=='C' || substr($right_access, 2,1)=='U') {?>
<div id="addperiod" class="modal fade" role="dialog">

            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="form_add" class="form-horizontal" method="post">

                        <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="modal-title">Add Period</h3>
			</div>

                        <div class="modal-body form">

                            <div class="form-group ">
                                <label for="staticEmail" class="control-label col-sm-2">Period Name </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="p_name" id="pname" placeholder="1." value="" required>
                                </div>
                                <label for="inputPassword" class="control-label col-sm-2 ">Is Break?</label>
                                <div class="col-sm-2">
                                    <input type="checkbox"  name="isbreak" id="isbreak"  style="margin-top: 10px;" value="YES"> YES
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword" class="control-label col-sm-2 ">Start Hour</label>
                                <div class="col-sm-6">
                                    <select id="time_start" name="time_start" class="form-control" required> 
                                        <option value="">--Select Start Hour--</option> 
                                        <?php
                                        for ($x = 0; $x <= 23; $x++) {
                                            if ($x < 10) {
                                                ?>
                                                <option value="<?php echo "0" . $x; ?>"><?php echo "0" . $x; ?></option>
                                                <?php
                                            } else {
                                                ?>
                                                <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="inputPassword" class="control-label col-sm-2">Start Min</label>
                                <div class="col-sm-6">
                                    <select id="time_start_min" name="time_start_min" class="form-control" required> 
                                        <option value="">--Select Start Min--</option> 
<?php
for ($x = 0; $x <= 60; $x++) {
    if ($x < 10) {
        ?>
                                                <option value="<?php echo "0" . $x; ?>"><?php echo "0" . $x; ?></option>
                                                <?php
                                            } else {
                                                ?>
                                                <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="inputPassword" class="control-label col-sm-2 ">End Hour</label>
                                <div class="col-sm-6">
                                    <select id="time_end" name="time_end" class="form-control" required>
                                        <option value="">--Select End Hour--</option> 
<?php
for ($x = 0; $x <= 23; $x++) {
    if ($x < 10) {
        ?>
                                                <option value="<?php echo "0" . $x; ?>"><?php echo "0" . $x; ?></option>
                                                <?php
                                            } else {
                                                ?>
                                                <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>                       
                                    </select>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="inputPassword" class="control-label col-sm-2 ">End Min</label>
                                <div class="col-sm-6">
                                    <select id="time_end_min" name="time_end_min" class="form-control" required> 
                                        <option value="">--Select End Min--</option> 
<?php
for ($x = 0; $x <= 60; $x++) {
    if ($x < 10) {
        ?>
                                                <option value="<?php echo "0" . $x; ?>"><?php echo "0" . $x; ?></option>
                                                <?php
                                            } else {
                                                ?>
                                                <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            

                        </div>

                        <div class="modal-footer">
                            <?php if(substr($right_access, 0,1)=='C') {?>
                            <a class="btn btn-success" id="save" onclick="save()">SAVE</a>
                            <?php }?>
                            <?php if(substr($right_access, 2,1)=='U') {?>
                            <button class="btn btn-success update" style="display:none;">UPDATE</button>
                            <?php }?>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
<?php }?>
<script>
    $(function ()
    {
        var table=$('#period').DataTable({
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
    });

    function save()
    {
        var name = $('#pname').val();
        var isbreak = $('#isbreak').val();
        var start_hr = $('#time_start').find('option:selected').val();
        var start_mi = $('#time_start_min').find('option:selected').val();
        var end_ht = $('#time_end').find('option:selected').val();
        var end_mi = $('#time_end_min').find('option:selected').val();

        if (!$('#form_add')[0].checkValidity()) {
            $(this).show();
            $('#form_add')[0].reportValidity();
            return false;
        } else {
            $.ajax({
                url: "<?php echo site_url('academics/periods/add') ?>",
                type: "POST",
                data: {name: name, start_hr: start_hr, start_mi: start_mi, end_ht: end_ht, end_mi: end_mi,isbreak:isbreak},
                success: function (data)
                {
//console.log(data)
                    location.reload();
                },

            });
        }
    }

    function edit(id, name, starthr, startmin, endhr, endmin, break_yes_no)
    {
        $('#pname').val(name);
        if(break_yes_no=='YES') {
        $('#isbreak').prop('checked',true);
        }
        var par = ['no_val', 'p_name', 'time_start', 'time_start_min', 'time_end', 'time_end_min']
        for (var i = 1, j = arguments.length; i < j; i++)
        {
            select_drop_down(par[i], arguments[i]);
        }
        $('#addperiod').modal('show');
        $('.modal-title').text('');
        $('.modal-title').text('Edit Period');
        
        $('#save').hide();
        $('.update').show();
        $('#form_add').attr('action', '<?php echo base_url('academics/periods/updates'); ?>' + '/' + id);
    }

    function select_drop_down(name_attr, val)
    {
        $('select[name=' + name_attr + ']').find("option:contains('" + val + "')").each(function () {
            if (($(this).text() == val) || ($(this).val() == val)) {
                $(this).attr("selected", "selected").trigger('change');
            }
        });
    }

    function delet(id)
    {
        $.ajax({
            url: "<?php echo site_url('academics/periods/deletes') ?>",
            type: "POST",
            data: {id: id},
            success: function (data)
            {
                console.log(data);
                location.reload();
            },

        });
    }


    $('#addperiod').on('hidden.bs.modal', function (e)
    {
//        alert('hdjf');
        
        $('#form_add')[0].reset();
        $('select').trigger('change');
        $('.modal-title').text('Add Period');
        $('#save').show();
        $('.update').hide();
        
    });

</script>