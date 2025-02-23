<style>
    .pointer {cursor: pointer;}
    .size35{
        width:20px !important;
    }
    .input-group-addon>i {
        color: #2c2d2f;
    }
</style>

<div class="page-content-inner">
    <div class="box">
        <form name="add_exam_room_alloc" id="add_exam_room_alloc" method="post" action="#" >
        <div class="box-body">
            <div class="row action_section">
                 <?php foreach ($exam_room_head as $val) { ?>
                <div class="col-md-12" style="text-align: center">
                <!--<center><h3> Exam Fee <?php // echo $academic_name;  ?> </h3>-->
                    <center><h4 style="margin-top: 10px;"><u><span style="color:blue">Room No. : </span> <?php echo $room_no; ?></u>&nbsp;&nbsp;<u><span style="color:blue"> Exam Name : </span><?php echo $val->name;?></u>&nbsp;&nbsp; <u><span style="color:blue">No. of Seats : </span><?php echo $val->no_of_seats;?></u></h4></center>
                    <?php } ?>
                </div>
            </div>

            
                <fieldset class="">

                    <div class="row">   
                       
                        <input type="hidden" class="form-control" name="updateid" value="<?php echo $updateid; ?>">
                        <div class="col-sm-3 col-md-3"></div>
                        <div class="col-sm-7 col-md-7" style="padding-right: 0px;">

                            <table class="table table-striped nowrap" id="other_charge_tbl" style="white-space: nowrap;width:100%">
                                
                                <thead>
                                    <tr>
                                        <th colspan="3" style="text-align: right">
                                            <a href="javascript:add_otherrow();" class="btn btn-icon-only green" style="padding: 4px 12px;height: 25px;width: 25px;margin-left: 20%;padding-left: 6px;">
                                                <i class="fa fa-plus "></i>
                                            </a>
                                        </th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th class="size196">Class</th>
                                        <th class="size160"> Section</th>
                                        <th class="size160"> From Roll</th>
                                        <th class="size160"> To Roll</th>
                                        <th class="size35"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($exam_room_detail as $val) {
                                        ?>
                                        <tr>

                                            <td>
                                                <select class="form-control" id="class" name="class[]" required>
                                                    <?php
                                                    foreach ($class as $key => $cls) {
                                                        ?>
                                                        <option value="<?php echo $cls->id; ?>"<?php if ($val->class_id == $cls->id) echo 'selected="selected"'; ?> ><?php echo $cls->class_name; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control" id="section" name="section[]" onchange="roll_no(this.value)">
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control" id="from_roll" name="from_roll[]">
                                                    <!-- <?php
                                                    foreach ($student as $key => $stu) {
                                                        ?>
                                                        <option value="<?php echo $stu->roll; ?>"<?php if ($val->from_roll == $stu->roll) echo 'selected="selected"'; ?> ><?php echo $stu->roll; ?></option>
                                                        <?php
                                                    }
                                                    ?> -->
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control" id="to_roll" name="to_roll[]">
                                                    <?php
                                                    foreach ($student as $key => $stu) {
                                                        ?>
                                                        <option value="<?php echo $stu->roll; ?>"<?php if ($val->to_roll == $stu->roll) echo 'selected="selected"'; ?> ><?php echo $stu->roll; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                           <!--  <td><a id="<?php echo $val->id;?>" target="_blank" href="<?php echo base_url(('academics/Exam_rooms/'));?>pdfinvoices/<?php echo $val->id;?>" data-toggle="tooltip" data-placement="top" title="Download"><i class="fa fa-file-alt"></i>Download Sitting</a></td>
                                            
                                            <td><a id="<?php echo $val->id;?>" target="_blank" href="<?php echo base_url(('academics/Exam_rooms/'));?>pdf_atten_sheet/<?php echo $val->id;?>" data-toggle="tooltip" data-placement="top" title="Download"><i class="fa fa-file-alt"></i>Download Attendence Sheet</a></td>
                                            <td class="size35"></td> -->

                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td>
                                            <select class="form-control" id="class1" name="class[]" required>
                                                <?php
                                                foreach ($class as $key => $cls) {
                                                    ?>
                                                    <option value="<?php echo $cls->id; ?>"><?php echo $cls->class_name; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </td>

                                        <td>
                                            <select class="form-control" id="section1" name="section[]">
                                                
                                            </select>

                                        </td>
                                        <td>
                                            <select class="form-control" id="from_roll" name="from_roll[]">
                                                <?php
                                                foreach ($student as $key => $stu) {
                                                    ?>
                                                    <option value="<?php echo $stu->roll; ?>"><?php echo $stu->roll; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control" id="to_roll" name="to_roll[]">
                                                <?php
                                                foreach ($student as $key => $stu) {
                                                    ?>
                                                    <option value="<?php echo $stu->roll; ?>"><?php echo $stu->roll; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td onclick='rvo(this)' class='size35'><a style='color:red' class='pointer'><strong>X</strong></a></td>
                                        <td class="size35"></td>


                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-sm-2 col-md-2"></div>
                    </div>
                </fieldset>

                

          

        </div>
<div class="panel-footer" style="padding: 2px 24px;">
                    <div class="row" style="<?php // echo $style1;   ?>">
                        <div class="col-lg-12" style="text-align:center">
                            <button type="button" class="btn btn-primary" style="width: 120px;font-family: sans-serif;float:left" id="back" ><i class="fa fa-arrow-left"> </i> Back</button>
                            <a class="btn btn-success" onclick="save()" id="load">SUBMIT</a>
                            <button class="btn btn-secondary buttonload" id="load_f" style="display: none;" type="button">
                                <i class="fa fa-spinner fa-spin"></i>Submitting
                            </button> 
                        </div>
                    </div>
                </div>
  </form>
    </div>
</div>
<div class="modal fade" id="transaction_det1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="monthly_pay1">

        </div>
    </div>
</div>
<script>
    
    function rv(abc) {
        $(abc).parent('tr').remove();
    }

    function rvo(abc) {
        rv(abc);
    }
    function add_otherrow() {

        var row = "<tr><td><select class='form-control' id='class3' name='class[]' required><?php foreach ($class as $key => $cls) { ?><option value='<?php echo $cls->id; ?>'><?php echo $cls->class_name; ?></option><?php } ?></select></td><td><select class='form-control' id='section3' name='section[]' onchange='roll_no(this.value)'></select></td><td><select class='form-control' id='from_roll' name='from_roll[]'><?php foreach ($student as $key => $stu) { ?><option value='<?php echo $stu->roll; ?>'><?php echo $stu->roll; ?></option><?php } ?></select></td><td><select class='form-control' id='to_roll' name='to_roll[]'><?php foreach ($student as $key => $stu) { ?><option value='<?php echo $stu->roll; ?>'><?php echo $stu->roll; ?></option>'<?php } ?></select></td><td onclick='rvo(this)' class='size35'><a style='color:red' class='pointer'><strong>X</strong></a></td></tr>"
        $("#other_charge_tbl").append(row);
        $('select').select2({width: '100%', theme: "classic"});
        $('select').on("select2:close", function () {
            $(this).focus();
        });
    }

    function save()
    {
        if (!$('#add_exam_room_alloc')[0].checkValidity()) {
            $(this).show();
            $('#add_exam_room_alloc')[0].reportValidity();
            return false;
        } else
        {
            $.ajax
                    ({
                        url: "<?php echo base_url('academics/Exam_rooms/saveExamRoomAlloc') ?>",
                        type: "POST",
                        data: $('#add_exam_room_alloc').serialize(),
                        dataType: "json",
                        success: function (data) {
//                            alert('Data Save Successfully');
                            window.location.href = "<?php echo base_url('academics/Exam_rooms') ?>";
                        },
                        error: function (errdata) {
                        }
                    });
        }
    }

    $('#back').click(function () {
//                alert('hi');
        window.location.href = '<?php echo base_url('academics/Exam_rooms'); ?>';
    });
</script>
<script>
    $('#other_charge_tbl').on("change", 'select[name^=class]', function () {  //dynamically creted table event change
    
//        alert('hii');
        var me=this;
        var value = $(this).val();
        $.ajax({
            url: "<?php echo site_url('academics/Exam_rooms/getclasssection') ?>",
            type: "POST",
            data: {id: value},
            success: function (data)
            {                
                $(me).closest('tr').find("select[name^=section]").html('');
                $(me).closest('tr').find("select[name^=section]").html(data);
            },
        });
    });


    function roll_no(roll)
    {

        var roll = roll;
        alert(roll);
        var cls = $("#class").val();
        var sec = $("#section").val();

        $.post("<?php echo base_url('academics/Exam_rooms/getsturoll') ?>", {roll: roll, cls: cls, sec: sec}, function (data) {
            $("#from_roll").html(data);
            $("#to_roll").html(data);
// alert(branch);
        })

    }

</script>