<div class="form-group has-feedback">
    <div class="box">            
        <div class="box-body">
            <div class="col-lg-12">
                <div class="col-lg-12" style="text-align:right;"></div>
            </div>
        </div>
         <div class="box-body">
             <div class="col-md-5 col-md-offset-3" style="height:40px">
                    <?php if ($this->session->flashdata('successmsg')) { ?>
                        <div class="col-md-12">
                            <div class="alert alert-success alert-dismissible"  id="success-alert">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Success!</strong> <?php echo $this->session->flashdata('successmsg'); ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
        </div>

        <div class="box-body">
            <form id="form_add" method="post">
                <div class="row">
                    <div class="col-md-2 form-group">
                        <label for="exampleFormControlSelect1">Examination Name</label>
                            <select class="form-control" id="examname" name="examname">
                                <option value="">&nbsp;&nbsp;--Select Examination--&nbsp;&nbsp;</option>
                                <?php
                                foreach ($examination as $key => $exam_value) {
                                    ?>
                                    <option value="<?php echo $exam_value->id; ?>"><?php echo $exam_value->name; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                    </div>

                    <div class="col-md-2 form-group">
                        <label for="exampleFormControlSelect1">Class</label>
                        <select class="form-control" id="class" name="class_id">
                            <option value="">&nbsp;&nbsp;--Select Class--&nbsp;&nbsp;</option>
                            <?php
                            foreach ($class as $key => $class_value) {
                                ?>
                                <option value="<?php echo $class_value->id; ?>"><?php echo $class_value->class_name; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-2 form-group">
                        <label for="exampleFormControlSelect1">Section</label>
                        <select class="form-control" id="section" name="section_id">
                            <option value="">&nbsp;&nbsp;--Select Section--&nbsp;&nbsp;</option>
                        </select>
                    </div>

                    <div class="col-md-2 form-group">
                        <label for="exampleFormControlSelect1">Subject</label>
                        <select class="form-control" id="subject" name="subject">
                            <option value="">&nbsp;&nbsp;--Select Subject--&nbsp;&nbsp;</option>
                            <?php
                            foreach ($subject as $key => $subject_value) {
                                ?>
                                <option value="<?php echo $subject_value->id; ?>"><?php echo $subject_value->name; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>

                    <?php if (substr($right_access, 0, 1) == 'C') { ?>    
                        <div class="col-md-1 form-group" style="text-align: center">
                            <label for="exampleFormControlSelect1">&nbsp;</label>
                            <a title="ADD MARKS" class="btn btn-add form-control" id="add_marks" title="Add Marks" > <i class="fa fa-plus-circle fa-lg"></i>  </a>
                        </div>
                    <?php } ?>    
                    <?php if (substr($right_access, 1, 1) == 'R') { ?>    
                        <div class="col-md-1 form-group">
                            <label for="exampleFormControlSelect1">&nbsp;</label>
                            <a title="VIEW MARKS" class="btn btn-success form-control" id="view_marks" title="View Marks"> <i class="fa fa-eye fa-lg"></i>  </a>
                        </div>
                    <?php } ?>
                    <div class="col-md-2 form-group">

                    </div>
                </div>
                <div class="box" id="adddatabox" style="display:none;">
        <!--<form id="form_add" method="post">-->
            <div class="box-body" id="adddata">

            </div>
            <hr/>
            <div class="box-body" id="addbutton">
                <a class="btn btn-success" onclick="save()" id="add">SUBMIT</a>
                <!--<a class="btn btn-success pull-right" id="add">SUBMIT</a>-->
            </div>
        <!--</form>-->
    </div>
            </form>
        </div>
    </div>

    <div class="box" id="viewdatabox">
        <div class="box-body" id="viewdata">
            <p>No data available in table</p>
        </div>

    </div>
    <style>
        table ,tr td{
            border:1px solid red
        }
        tbody {
            display:block;
            height:440px;
            overflow:auto;
        }
        thead, tbody tr {
            display:table;
            width:100%;
            table-layout:fixed;
        }
        thead {
            width: calc( 100% - 1em );
        }
        table {
            width:100%;
        }
    </style>
    <div class="box" id="adddatabox" style="display:none;">
        <form id="form_add" method="post">
            <div class="box-body" id="adddata">

            </div>
            <hr/>
            <div class="box-body" id="addbutton">
                <a class="btn btn-success pull-right" id="add">SUBMIT</a>
            </div>
        </form>
    </div>

    <div class="box" id="alreadydata" style="display:none;">
        <div class="box-body" id="adddata">
            <p>The Subject Marks for selected class and examination have been added already to students!!</p>
            <p>Click on <a title="Click Here" class="btn btn-success" id="view_markss">View Marks</a> To View its marks</p>
        </div>
    </div>
</div>

<?php if (substr($right_access, 2, 1) == 'U') { ?>
    <div id="EditModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update Marks</h4>
                </div>
                <div class="modal-body">

                    <div class="row form-group">
                        <label class="col-md-2">Student Name :</label>
                        <div class="col-md-8" style='padding-bottom:1%'>
                            <input type="text" class="form-control" id="names" name="datefrom" placeholder="Name" disabled="" />        
                        </div>                       
                    </div>

                    <div class="row form-group">
                        <label class="col-md-2">Class No :</label>
                        <div class="col-md-8" style='padding-bottom:1%'>
                            <input type="text" class="form-control" id="classe" name="day" placeholder="Day" disabled="" />
                            <input type="hidden" class="form-control" id="routinid" />
                        </div>           
                    </div> 


                    <div class="row form-group">
                        <label class="col-md-2">Section :</label>
                        <div class="col-md-8" style='padding-bottom:1%'>
                            <input type="text" class="form-control" id="sectione" name="day" placeholder="Day" disabled="" />
                            <input type="hidden" class="form-control" id="routinid" />
                        </div>           
                    </div> 


                    <div class="row form-group">
                        <label class="col-md-2">Subject :</label>
                        <div class="col-md-8" style='padding-bottom:1%'>
                            <input type="text" class="form-control" id="subjecte" name="day" placeholder="Day" disabled="" />
                            <input type="hidden" class="form-control" id="routinid" />
                        </div>           
                    </div> 

                    <div class="row form-group">
                        <label class="col-md-2">Marks Obtained :</label>
                        <div class="col-md-8" style='padding-bottom:1%'>
                            <input type="text" class="form-control" id="marksobt" name="day" placeholder="Marks Obtained"/>
                        </div>   

                    </div> 

                </div>
                <div class="modal-footer">
                    <input type="hidden" id="examid" value="">
                    <input type="hidden" id="classid" value="">
                    <input type="hidden" id="sectionid" value="">
                    <input type="hidden" id="markid" value="">
                    <input type="hidden" id="studentid" value="">
                    <input type="hidden" id="subjectid" value="">

                    <a class="btn btn-success update" onclick="update()">Update</a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
<?php } ?>
<script>
    function update()
    {

        var examid = $('#examid').val();
        var classid = $('#classid').val();
        var sectionid = $('#sectionid').val();
        var markid = $('#markid').val();
        var studentid = $('#studentid').val();
        var marksobt = $('#marksobt').val();
        var subjectid = $('#subjectid').val();

        if (markid == 0)
        {
            $('#EditModal').modal('hide');
            $.ajax({
                url: "<?php echo site_url('academics/Marks/GetTotalMark') ?>",
                type: "POST",
                data: {id: examid, classid: classid, studentid: studentid, marksobt: marksobt, subjectid: subjectid},
                success: function (data)
                {
                    var exam = $('#examname').find('option:selected').val();
                    var examunit = $('#examnameunit').find('option:selected').val();
                    var clas = $('#class').find('option:selected').val();
                    var sect = $('#section').find('option:selected').val();
                    var subj = $('#subject').find('option:selected').val();

                        $.ajax({
                            url: "<?php echo site_url('academics/Marks/GetData') ?>",
                            type: "POST",
                            data: {exam: exam, clas: clas, sect: sect, subj: subj},
                            success: function (data)
                            {
                                $('#viewdata').html(data);
                                $('#templatelistss').DataTable({
                                    "paging": true,
                                    "lengthChange": true,
                                    "searching": true,
                                    "ordering": true,
                                    "info": true,
                                    "autoWidth": true
                                });

                            },
                        });

                },
            });
        } else
        {
            $('#EditModal').modal('hide');
            $.ajax({
                url: "<?php echo site_url('academics/Marks/UpdateMarks') ?>",
                type: "POST",
                data: {id: markid, marks: marksobt},
                success: function (data)
                {

                    var exam = $('#examname').find('option:selected').val();
                    var examunit = $('#examnameunit').find('option:selected').val();
                    var clas = $('#class').find('option:selected').val();
                    var sect = $('#section').find('option:selected').val();
                    var subj = $('#subject').find('option:selected').val();
                    
                    $.ajax({
                    url: "<?php echo site_url('academics/Marks/ExamType') ?>",
                    type: "POST",
                    data: {exam: exam},
                    success: function (data)
                    {
                        var exam_type = data;
                        if (exam_type =='TERM')
                        {
                            $.ajax({
                            url: "<?php echo site_url('academics/Marks/GetData') ?>",
                            type: "POST",
                            data: {exam: exam, clas: clas, sect: sect, subj: subj},
                            success: function (data)
                            {
                                $('#viewdata').html(data);
                                $('#templatelistss').DataTable({
                                    "paging": true,
                                    "lengthChange": true,
                                    "searching": true,
                                    "ordering": true,
                                    "info": true,
                                    "autoWidth": true
                                });

                            },
                        });
                        }
                        else
                        {
                         $.ajax({
                            url: "<?php echo site_url('academics/Marks/GetData') ?>",
                            type: "POST",
                            data: {examunit: examunit, clas: clas, sect: sect, subj: subj},
                            success: function (data)
                            {
                                $('#viewdata').html(data);
                                $('#templatelistss').DataTable({
                                    "paging": true,
                                    "lengthChange": true,
                                    "searching": true,
                                    "ordering": true,
                                    "info": true,
                                    "autoWidth": true
                                });

                            },
                        });
                        }
                    } 
                    });
                    
                   

                },
            });
        }

    }

    function editmarks(exam, clas, sect, subj, markid, stid, clsname, secname, fname, marksobt, subjectname)
    {
        $('#names').val(fname);
        $('#classe').val(clsname);
        $('#sectione').val(secname);
        $('#subjecte').val(subjectname);
        $('#marksobt').val(marksobt);
        $('#examid').val(exam);
        $('#classid').val(clas);
        $('#sectionid').val(sect);
        $('#markid').val(markid);
        $('#studentid').val(stid);
        $('#subjectid').val(subj);
        $('#EditModal').modal('show');
    }
//
//
//    $('#add').on('click', function () {
//        if (!$('#form_add')[0].checkValidity()) {
//            $(this).show();
//            $('#form_add')[0].reportValidity();
//            return false;
//        } else
//        {
//            var exam = $('#examname').find('option:selected').val();
//            var clas = $('#class').find('option:selected').val();
//            var sect = $('#section').find('option:selected').val();
//            var subj = $('#subject').find('option:selected').val();
//
//            $.ajax({
//                url: "<?php echo site_url('academics/Marks/ExamType') ?>",
//                type: "POST",
//                data: {exam: exam},
//                success: function (data)
//                {
//                    var exam_type = data;
//                    if (exam_type =='TERM')
//                    {
//                    $.ajax({
//                    url: "<?php echo site_url('academics/Marks/GetGrandTotalMark') ?>",
//                    type: "POST",
//                    data: {id: exam},
//                    success: function (data)
//                    {
//
//                        var i = 0;
//                        $('form input[name=user_input_external]').each(function () {
//                            i++;
//
//                            var student_id = $('#stid_' + i).val();
//                            var subject_id = subj;
//                            var class_id = clas;
//                            var section_id = sect;
//                            var exam_id = exam;
//                            var written = $('#markobtexternal').val();
//                            var periodic = $('#markobtunit').val();
//                            var note_book = $('#markobtclassrecord').val();
//                            var assignment = $('#markobtsubenrichment').val();
//                            var mark_obtained = $('#markobtgrandtotal').val();
//                            var comment = $('#comment').val();
//                            var totalmark = data;
//                            $.ajax({
//                                url: "<?php echo site_url('academics/Marks/AddMark') ?>",
//                                type: "POST",
//                                data: {student_id: student_id, subject_id: subject_id, class_id: class_id,section_id:section_id, exam_id: exam_id, mark_obtained: mark_obtained, mark_total: totalmark, written: written, periodic: periodic, note_book: note_book, assignment: assignment, comment: comment,exam_type:exam_type},
//                                success: function (data)
//                                {
//                                    location.reload()
//                                },
//                            });
//                        });
//
//                        alert('Marks Successfully Added');
//                    },
//                });
//                    }
//                    else
//                    {
//                                        $.ajax({
//                    url: "<?php echo site_url('academics/Marks/GetGrandTotalMark') ?>",
//                    type: "POST",
//                    data: {id: exam},
//                    success: function (data)
//                    {
//                        var i = 0;
//                        $('form input[name=user_input]').each(function () {
//                            i++;
//
//                            var student_id = $('#stid_' + i).val();
//                            var subject_id = subj;
//                            var class_id = clas;
//                            var section_id = sect;
//                            var exam_id = exam;
//                            var periodic = $('#markobt').val();
//                            var mark_obtained = $('#markobt').val();
//                            var totalmark = data;
//                            $.ajax({
//                                url: "<?php echo site_url('academics/Marks/AddMark') ?>",
//                                type: "POST",
//                                data: {student_id: student_id, subject_id: subject_id, class_id: class_id,section_id:section_id, exam_id: exam_id, mark_obtained: mark_obtained, mark_total: totalmark, periodic: periodic,exam_type:exam_type},
//                                success: function (data)
//                                {
//                                    location.reload()
//                                },
//                            });
//                        });
//
//        alert('Marks Successfully Added');
//                    },
//                });
//                    }
//                 },//END EXAM TYPE
//            });
//
//        }
//    });

    $('#class').on('click change keyup', function () {
        var value = $(this).val();
        $.ajax({
            url: "<?php echo site_url('academics/Marks/GetSection') ?>",
            type: "POST",
            data: {id: value},
            success: function (data)
            {
                $('#section').empty();
                $("#section").append(data);
            },
        });
    });


    $('#class,' + '#section').on('change click keyup', function () {
        var clas = $('#class').find('option:selected').val();
        var sect = $('#section').val();
        $.ajax({
            url: "<?php echo site_url('academics/Marks/GetSubjects') ?>",
            type: "POST",
            data: {clasid: clas, sect: sect},
            success: function (data)
            {

                $('#subject').empty();
                $("#subject").append(data);
            },
        });

    });

    $('#view_marks,' + '#view_markss').on('click', function () {
        $('#alreadydata').hide();
        $('#adddatabox').hide();
        $('#viewdatabox').show();
        var exam = $('#examname').find('option:selected').val();
        var clas = $('#class').find('option:selected').val();
        var sect = $('#section').find('option:selected').val();
        var subj = $('#subject').find('option:selected').val();

        $.ajax({
            url: "<?php echo site_url('academics/Marks/GetData') ?>",
            type: "POST",
            data: {exam: exam, clas: clas, sect: sect, subj: subj},
            success: function (data)
            {
                $('#viewdata').html(data);
                $('#templatelistss').DataTable({
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": true
                });
            },
        });
    });

    $('#section').on('click change', function () {
        var val = $(this).val();
        if (val == '')
        {
            alert('Please Select Class First');
        }
    });


    $('#add_marks').on('click', function () {
        $('#alreadydata').hide();
        $('#viewdatabox').hide();
        $('#adddatabox').show();

        var exam = $('#examname').find('option:selected').val();
        var clas = $('#class').find('option:selected').val();
        var sect = $('#section').find('option:selected').val();
        var subj = $('#subject').find('option:selected').val();

        $.ajax({
                url: "<?php echo site_url('academics/Marks/ExamType') ?>",
                type: "POST",
                data: {exam: exam},
                success: function (data)
                {
                    var exam_type = data;
                    if (exam_type =='TERM')
                    {
                                    $.ajax({
                url: "<?php echo site_url('academics/Marks/Get') ?>",
                type: "POST",
                data: {exam: exam, clas: clas, subj: subj},
                success: function (data)
                {
                    var ddd = data;
                    if (ddd > 0)
                    {
                        $('#adddatabox').hide();
                        $('#view_marks').attr('disabled', false);
                        $('#alreadydata').show();

                    } else
                    {
                        $('#view_marks').attr('disabled', true);
                        $.ajax({
                            url: "<?php echo site_url('academics/Marks/GetAddDataTerm') ?>",
                            type: "POST",
                            data: {exam: exam, clas: clas, sect: sect, subj: subj},
                            success: function (data)
                            {
                                $('#adddata').html(data);
                            },
                        });
                    }

                },
            });
                    } else
                    {
                $.ajax({
                url: "<?php echo site_url('academics/Marks/Get') ?>",
                type: "POST",
                data: {exam: exam, clas: clas, subj: subj},
                success: function (data)
                {
                    var ddd = data;
                    if (ddd > 0)
                    {
                        $('#adddatabox').hide();
                        $('#view_marks').attr('disabled', false);
                        $('#alreadydata').show();

                    } else
                    {
                        $('#view_marks').attr('disabled', true);
                        $.ajax({
                            url: "<?php echo site_url('academics/Marks/GetAddData') ?>",
                            type: "POST",
                            data: {exam: exam, clas: clas, sect: sect, subj: subj},
                            success: function (data)
                            {
                                $('#adddata').html(data);
                            },
                        });
                    }

                },
            });
                    }

                },//END EXAM TYPE
            });

    })

    function autocal(me) {
        var get_external=$(me).closest('tr').find('input[name="user_input_external[]"]').val();
        var external_mks= $.isNumeric( get_external) ? Number(get_external):0;
        var get_unit=$(me).closest('tr').find('input[name="user_input_unit[]"]').val();
        var unit_mks= $.isNumeric( get_unit) ? Number(get_unit):0;
        var get_subenrichment=$(me).closest('tr').find('input[name="user_input_subenrichment[]"]').val();
        var subenrichment= $.isNumeric( get_subenrichment) ? Number(get_subenrichment):0;
        var get_classrecord=$(me).closest('tr').find('input[name="user_input_classrecord[]"]').val();
        var classrecord= $.isNumeric( get_classrecord) ? Number(get_classrecord):0;     
        var sum=external_mks+unit_mks+subenrichment+classrecord;
        
        $(me).closest('tr').find('input[name="user_input_grandtotal[]"]').val(sum);
    }
    
    
    
        function save()
    {
        if (!$('#form_add')[0].checkValidity()) {
            $(this).show();
            $('#form_add')[0].reportValidity();
            return false;
        } else
        {
            $.ajax
                    ({
                        url: "<?php echo site_url('academics/Marks/AddMark') ?>",
                        type: "POST",
                        data: $('#form_add').serialize(),
                        dataType: "json",
                        success: function (data) {
//                            alert('Data Save Successfully');
//                            location.reload();
                            window.location.href = "<?php echo base_url('academics/Marks') ?>";
                        },
                        error: function (errdata) {
                        }
                    });
        }
    }
</script>
