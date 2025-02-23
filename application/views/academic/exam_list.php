<div class="form-group" >
    <div class='box box-primary panel'>
        <div class="panel-heading" style="padding: 0px 8px;border-bottom: 0px;">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#term" style="font-weight:bold;">Term Exams</a></li>
                <li class=""><a data-toggle="tab" href="#unit" style="font-weight:bold">Unit/Periodic Test</a></li>

            </ul>
        </div>
        <div class='box-body'>

            <div class="tab-content">
                <div class="tab-pane fade active in" id="term"> 

                    <div class="col-sm-12 col-md-12">
                        <div class="col-lg-12" style="text-align:right;padding-bottom: 5px">
                            <?php
//if (!$read_only) {
                            if (substr($right_access, 0, 1) == 'C') {
                                ?>
                                <button class="btn btn-add" id="add_record" data-toggle="tooltip" data-placement="bottom" title="Add <?= e($rec_type) ?>">
                                    <i class="fa fa-plus-circle fa-lg"></i>&nbsp;
                                </button>
                                <?php
                            }
                            ?>
                            <a class="btn btn-export" href='<?php echo e(base_url() . uri_string()) ?>/exportcsv' download data-toggle="tooltip" data-placement="bottom" title="Export <?= e($rec_type) ?>">
                                <i class="fa fa-cloud-download fa-lg"></i>&nbsp;
                            </a>

                            <?php
//if (!$read_only) {
                            if (substr($right_access, 0, 1) == 'C' || substr($right_access, 2, 1) == 'U') {
                                ?>
                                <a class="btn btn-import" id="studimport" href='<?= base_url() . uri_string() ?>/importcsv'  data-toggle="tooltip" data-placement="bottom" title="Import <?= e($rec_type) ?>">
                                    <i class="fa fa-cloud-upload fa-lg"></i>&nbsp;
                                </a>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <form id='frmclass' role="form" method="POST">
                            <div class="table-responsive">
                                <table id="termlist" class="table table-bordered table-striped">
                                    <thead style="background:#99ceff;">
                                        <tr>

                                            <th style="border-bottom:0px" rowspan="2">#</th>
                                            <th style="border-bottom:0px" rowspan="2">Exam Code</th>
                                            <th style="border-bottom:0px" rowspan="2">Exam Name</th>
                                            <th style="border-bottom:0px" rowspan="2">Theory / External</th>
                                            <th style="border-bottom:0px" colspan="3">Practical</th>
                                            <th style="border-bottom:0px" rowspan="2">Grand Total</th>
                                            <th style="border-bottom:0px" rowspan="2">Pass Mks</th>
                                            <th style="border-bottom:0px" rowspan="2">Actions</th>
                                        </tr>
                                        <tr>
                                            <th style="border-bottom:0px">Unit / periodic test</th>
                                            <th style="border-bottom:0px">Class Performance</th>
                                            <th style="border-bottom:0px">Subject Assignment</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($termdata as $value) { ?>
                                            <tr>
                                                <td><?php echo $value->id; ?></td>                                                                                                                                                                     
                                                <td><?php echo $value->excode; ?></td>                                                                                                                                                                                                                                                                                                                                        
                                                <td><?php echo $value->name; ?></td>                                                                                                                                                                     
                                                <td><?php echo $value->theory_mark; ?></td>                                                                                                                                                                     
                                                <td><?php echo $value->practical_mark; ?></td>                                                                                                                                                                     
                                                <td><?php echo $value->class_performance_mks; ?></td>                                                                                                                                                                     
                                                <td><?php echo $value->subj_assgn_marks; ?></td>                                                                                                                                                                     
                                                <td><?php echo $value->grand_total; ?></td>                                                                                                                                                                     
                                                <td><?php echo $value->pass_mark; ?></td>                                                                                                                                                                     
                                                <td>
                                                    <?php if (substr($right_access, 2, 1) == 'U') { ?>
                                                        <a class="btn a-edit" onclick="edit_rec('<?php echo $value->id; ?>','TERM','form');" data-toggle="tooltip" title="Edit" data-placement="bottom"><i class="fa fa-edit"></i></a>
                                                    <?php }
                                                    if (substr($right_access, 3, 1) == 'D') {
                                                        ?>
                                                        <a class="btn a-delete" data-toggle="modal" onclick="delete_rec('<?php echo $value->id; ?>');" title="Delete"><i class="fa fa-trash"></i></a>
                                                    <?php } ?>
                                                    <a class="btn " onclick="exam_schedule('<?php echo $value->id; ?>');" style="color: rgb(0, 39, 255);padding: 0 8px;" title="Exam Schedule"><i class="fa fa-calendar"></i></a>

                                                </td>                                                                                                                                                                     

                                            </tr>
                                    <?php } ?>

                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>
                            </div>
                        </form>
                    </div>

                </div>

                <div class="tab-pane fade in" id="unit"> 
                    <div class="col-sm-12 col-md-12">
                        <div class="col-lg-12" style="text-align:right;padding-bottom: 5px">
                            <?php
//if (!$read_only) {
                            if (substr($right_access, 0, 1) == 'C') {
                                ?>
                                <button class="btn btn-add" id="addunit_record" data-toggle="tooltip" data-placement="bottom" title="Add <?= e($rec_type) ?>">
                                    <i class="fa fa-plus-circle fa-lg"></i>&nbsp;
                                </button>
                                <?php
                            }
                            ?>
                            <a class="btn btn-export" href='<?php echo e(base_url() . uri_string()) ?>/exportcsv' download data-toggle="tooltip" data-placement="bottom" title="Export <?= e($rec_type) ?>">
                                <i class="fa fa-cloud-download fa-lg"></i>&nbsp;
                            </a>

                            <?php
//if (!$read_only) {
                            if (substr($right_access, 0, 1) == 'C' || substr($right_access, 2, 1) == 'U') {
                                ?>
                                <a class="btn btn-import" id="unitstudimport" href='<?= base_url() . uri_string() ?>/importcsv'  data-toggle="tooltip" data-placement="bottom" title="Import <?= e($rec_type) ?>">
                                    <i class="fa fa-cloud-upload fa-lg"></i>&nbsp;
                                </a>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <form id='frmunit' role="form" method="POST">
                            <div class="table-responsive">
                                <table id="unitlist" class="table table-bordered table-striped" style="width:100%">
                                    <thead style="background:#99ceff;">
                                        <tr>

                                            <th style="border-bottom:0px">#</th>
                                            <th style="border-bottom:0px">Exam Code</th>
                                            <th style="border-bottom:0px">Exam Name</th>
                                            <th style="border-bottom:0px">Grand Total</th>
                                            <th style="border-bottom:0px">Pass Mks</th>
                                            <th style="border-bottom:0px">Actions</th>
                                        </tr>

                                    </thead>

                                    <tbody>
                                            <?php foreach ($unitdata as $value) { ?>
                                            <tr>
                                                <td><?php echo $value->id; ?></td>                                                                                                                                                                     
                                                <td><?php echo $value->excode; ?></td>                                                                                                                                                                                                                                                                                                                                        
                                                <td><?php echo $value->name; ?></td>                                                                                                                                                                                                                                                                                                                                     
                                                <td><?php echo $value->grand_total; ?></td>                                                                                                                                                                     
                                                <td><?php echo $value->pass_mark; ?></td>                                                                                                                                                                     
                                                <td>
                                                    <?php if (substr($right_access, 2, 1) == 'U') { ?>
                                                        <a class="btn a-edit" onclick="edit_rec('<?php echo $value->id; ?>','UNIT','form2');" data-toggle="tooltip" title="Edit" data-placement="bottom"><i class="fa fa-edit"></i></a>
                                                    <?php }
                                                    if (substr($right_access, 3, 1) == 'D') {
                                                        ?>
                                                        <a class="btn a-delete" data-toggle="modal" onclick="delete_rec('<?php echo $value->id; ?>');" title="Delete"><i class="fa fa-trash"></i></a>
                                                    <?php } ?>
                                                    <a class="btn " onclick="exam_schedule('<?php echo $value->id; ?>');" style="color: rgb(0, 39, 255);padding: 0 8px;" title="Exam Schedule"><i class="fa fa-calendar"></i></a>

                                                </td>                                                                                                                                                                     

                                            </tr>
                                            <?php } ?>

                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>

            </div>


        </div>
    </div>


    <!-- /.box -->
</div>

<script>
    var globalid = '';
    var url = "<?php echo base_url(); ?>";
    var newtxt = 1000;

    $(document).ready(function () {
        $('#add_record').click(function () {

            save_method = 'add';
            $('#form')[0].reset(); // reset form on modals
            $('#errmodal').empty();
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('select').trigger('change');
            $('#modal_form').modal('show'); // show bootstrap modal
            $('.modal-title').text('Add Term Exam'); // Set Title to Bootstrap modal title

        });

        $('#addunit_record').click(function () {

            save_method = 'add';
            $('#form2')[0].reset(); // reset form on modals
            $('#errmodal').empty();
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('select').trigger('change');
            $('#modal_form2').modal('show'); // show bootstrap modal
            $('.modal-title').text('Add Periodic/Unit Exam'); // Set Title to Bootstrap modal title

        });
        var table = $('#termlist').DataTable({
            "scrollX": true,
            "scrollY": "300px",
            "scrollCollapse": true,
            "paging": false,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,

        });

        var table = $('#unitlist').DataTable({
//            "scrollX": true,
//            "scrollY": "300px",
//            "scrollCollapse": true,
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,

        });


    });

<?php
if (!$read_only) {
    ?>

        function edit_rec(id,type,form) {


            $('#'+form+' #errmodal').empty();
            $('#'+form)[0].reset();

            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
    //        $('select').trigger('change');
            $.ajax({
                url: "<?php echo base_url(); ?>/<?= uri_string() . '/getrec/' ?>" + id,
                            type: "POST",
                            dataType: "json",
                })
                .done(function (msg) {

                    $('#'+form+' #excode').val(msg[0].excode).prop('selected', true).trigger('change');
                    $('#'+form+' #exam_name').val(msg[0].name);
                    $('#'+form+' #theory_marks').val(msg[0].theory_mark);
                    $('#'+form+' #unit_marks').val(msg[0].practical_mark);
                    $('#'+form+' #class_performance').val(msg[0].class_performance_mks);
                    $('#'+form+' #subject_assignment').val(msg[0].subj_assgn_marks);
                    $('#'+form+' #pass_marks').val(msg[0].pass_mark);
                    $('#'+form+' #grand_total').val(msg[0].grand_total);
                })
                .fail(function (msg) {
                    console.log(msg);
                });
                globalid = id;
                save_method = 'update';
                $('#modal_'+form).modal('show'); // show bootstrap modal
                $('.modal-title').text('Update <?= $rec_type ?>'); // Set Title to Bootstrap modal title
                return false;

        }

        function save(type,form) {

            if (!$('#'+form)[0].checkValidity())
            {
//                                                alert($('#add_stud_frm')[0].validationMessage);
                $(this).show();
                $('#'+form)[0].reportValidity();
                return false;
            } else {
                var r = confirm("Are you sure you want to save?");
                if (r == true) {
                    $('#'+form+' #btnSave').text('saving...'); //change button text
                    $('#'+form+' #btnSave').attr('disabled', true); //set button disable 
                    var err = '';
                    $('#'+form+' #errmodal').empty();

                    <?php
                    foreach ($edit_columns as $col => $colparams) {
                            if (isset($colparams['required'])) {
                                    echo "\t\tif ($('#$col').val() == '') {\n";
                                    echo "\t\t\terr = '';\n";
                                    echo "}";
                            }
                    }
                    ?>
                    if (err == '') {
                        $('#'+form+' #errmodal').empty();
                        var url;
                        if (save_method == 'add') {
                            url = "<?php echo base_url(); ?>/<?= uri_string() . '/add' ?>";
                        } else {
                            $('#'+form+' #btnSave').text('updating...');
                            url = "<?php echo base_url(); ?>/<?= uri_string() . '/update' ?>/" + globalid;
                        }

                        $.ajax
                        ({
                            url: url,
                            type: "POST",
                            data: $('#'+form).serialize(),
                            dataType: "text",
                            success: function (data) {
                                if (data == 1) { //if success close modal and reload ajax table
                                    
                                    $('#modal_'+form).modal('hide');
                                    window.location.reload();
                                }

                                $('#'+form+' #btnSave').text('save'); //change button text
                                $('#'+form+' #btnSave').attr('disabled', false); //set button enable 
                            }
                        });

                    } else {
                        $('#'+form+' #errmodal').css('color', 'Red');
                        $('#'+form+' #errmodal').append(err);
                        $('#'+form+' #btnSave').text('save'); //change button text
                        $('#'+form+' #btnSave').attr('disabled', false); //set button disable 
                    }
                } else {
                        return false;
                }

            }
        }







        function exam_schedule(id) {

            window.location.href = '<?php echo base_url(); ?>' + '<?= uri_string() . '/examSchedule/' ?>' + id;
        }


        function grandTotal() {
            var theory_mks = $.isNumeric($('#theory_marks').val()) ? Number($('#theory_marks').val()) : 0;
            var unit_marks = $.isNumeric($('#unit_marks').val()) ? Number($('#unit_marks').val()) : 0;
            var class_performance = $.isNumeric($('#class_performance').val()) ? Number($('#class_performance').val()) : 0;
            var subject_assignment = $.isNumeric($('#subject_assignment').val()) ? Number($('#subject_assignment').val()) : 0;

            var sum = theory_mks + unit_marks + class_performance + subject_assignment;
            $('#grand_total').val(sum);

        }

    <?php
}
?>

</script>

<?php
if (!$read_only) {
    ?>

    <!-- Bootstrap modal -->
    <div class="modal fade" id="modal_form" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Add Term Exam </h3>
                </div>
                <div class="modal-body form">
                    <form action="javascript:save();" id="form" name="form" class="form-horizontal">
                        <div class="form-body">
                            <div class="form-group">
                                <div class="col-md-3"></div>
                                <div class="col-md-9" id="errmodal" style="color:red;font-weight:bold"></div>
                            </div>
                            <div id="id"></div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Exam Term</label>
                                <div class="col-md-9">
                                    <select id="excode"  name="excode" class="form-control" required>
                                        <option  value=''>None</option>
                                        <option  value='TERM1'>TERM 1</option>
                                        <option  value='TERM2'>TERM 2</option>
                                        <option  value='TERM3'>TERM 3</option>

                                    </select>
                                    <span class="help-block"></span>
                                </div>
                                <input type="hidden" name="extype" value="TERM">
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Exam Name</label>
                                <div class="col-md-9">
                                    <input id="exam_name" name="name" placeholder="Exam Name" class="form-control" type="text" >
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Theory / External Weightage:</label>
                                <div class="col-md-9">
                                    <input id="theory_marks" name="theory_mark" placeholder="Written Exam Marks" class="form-control" type="number" min="0"  onchange="grandTotal()" onkeyup="grandTotal()">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Practical / Internal Weightage:</label>
                                <div class="col-md-9">
                                    <input id="unit_marks" name="practical_mark" placeholder="Unit / Periodic Test Weightage" class="form-control" type="number" min="0" onchange="grandTotal()" onkeyup="grandTotal()">
                                    <input id="class_performance" name="class_performance_mks" placeholder="Class Performance Weightage" class="form-control" type="number" min="0" onchange="grandTotal()" onkeyup="grandTotal()">
                                    <input id="subject_assignment" name="subj_assgn_marks" placeholder="Subject Assignment Weightage" class="form-control" type="number" min="0" onchange="grandTotal()" onkeyup="grandTotal()">
                                    <span class="help-block"></span>
                                </div>

                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Grand Total:</label>
                                <div class="col-md-9">
                                    <input id="grand_total" name="grand_total" placeholder="Grand Total" class="form-control" type="number" readonly="">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Pass Marks:</label>
                                <div class="col-md-9">
                                    <input id="pass_marks" name="pass_mark" placeholder="Pass Marks" class="form-control" type="number" >
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div> 
                <div class="modal-footer">
                    <button type="button" id="btnSave" onclick="save('TERM','form')" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- End Bootstrap modal -->


    <!-- Bootstrap modal -->
    <div class="modal fade" id="modal_form2" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Add UNIT Exam </h3>
                </div>
                <div class="modal-body form">
                    <form action="javascript:save();" id="form2" name="form2" class="form-horizontal">
                        <div class="form-body">
                            <div class="form-group">
                                <div class="col-md-3"></div>
                                <div class="col-md-9" id="errmodal2" style="color:red;font-weight:bold"></div>
                            </div>
                            <div id="id"></div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Exam Code</label>
                                <div class="col-md-9">
                                    <input id="excode" name="excode" placeholder="Exam Code" class="form-control" type="text" >
                                    <span class="help-block"></span>
                                </div>
                                <input type="hidden" name="extype" value="UNIT">
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Exam Name</label>
                                <div class="col-md-9">
                                    <input id="exam_name" name="name" placeholder="Exam Name" class="form-control" type="text" >
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Grand Total:</label>
                                <div class="col-md-9">
                                    <input id="grand_total" name="grand_total" placeholder="Grand Total" class="form-control" type="number">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Pass Marks:</label>
                                <div class="col-md-9">
                                    <input id="pass_marks" name="pass_mark" placeholder="Pass Marks" class="form-control" type="number" >
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div> 
                <div class="modal-footer">
                    <button type="button" id="btnSave" onclick="save('UNIT','form2')" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- End Bootstrap modal -->
    <?php
}
?>
