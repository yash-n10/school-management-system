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
        <div class="box-body">
            <div class="row action_section">
                <div class="col-md-12" style="text-align: center">
                    <center><h3 style="margin-top: 10px;"><u> Subject Teachers : <?php echo $academic_name; ?> </u></h3></center>
                </div>
            </div>

            <form name="add_subject_teacher" id="add_subject_teacher" method="post" action="#" >
                <fieldset class="">

                    <div class="row">   
                        <input type="hidden" class="form-control" name="updateid" value="<?php echo $updateid; ?>">
                        <div class="col-sm-3 col-md-3"></div>
                        <div class="col-sm-7 col-md-7" style="padding-right: 0px;">

                            <table class="table table-striped nowrap" id="other_charge_tbl111" style="white-space: nowrap;width:100%">
                                <thead>
                                    <tr>
                                        
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>

                                        <th colspan="3" style="text-align: right">
                                            <a href="javascript:add_otherrow();" class="btn btn-icon-only green" style="padding: 4px 12px;height: 25px;width: 25px;margin-left: 20%;padding-left: 6px;">
                                                <i class="fa fa-plus "></i>
                                            </a>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="size196">Class</th>
                                        <th class="size160"> Section</th>
                                        <th class="size160"> Subject</th>
                                        <th class="size160"> Teacher</th>
                                        <th class="size35"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($selectdata as $val) {
                                      
                                        ?>
                                        <tr>
                                            <td>
                                                <select class="form-control" name="class[]" required>
                                                    <option value="0">Select Class</option>
                                                    <?php foreach ($classes as $bat) { ?>
                                                        <option value="<?php echo $bat->id ?>" <?php if ($val->class_id == $bat->id) echo 'selected="selected"'; ?> ><?php echo $bat->class_name ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                              <td>
                                                <select class="form-control" name="sec[]" id="programme">
                                                    <option value="0">Select Section</option>
                                                    <?php
                                                    foreach ($sect as $value) {
                                                        ?>
                                                        <option value="<?php echo $value->id; ?>"<?php if ($val->section_id == $value->id) echo 'selected="selected"'; ?> ><?php echo $value->sec_name; ?></option>
                                                        <?php
                                                    }
                                                    ?> 
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control" name="subject[]" id="subject">
                                                    <option value="0">Select Subject</option>
                                                    <?php
                                                    foreach ($subjects as $value) {
                                                        ?>
                                                        <option value="<?php echo $value->id; ?>" <?php if ($val->subject_id == $value->id) echo 'selected="selected"'; ?>><?php echo $value->name; ?></option>
                                                        <?php
                                                    }
                                                    ?> 
                                                </select>
                                            </td>
                                            <td>
                                         <select class="form-control" name="teacher[]" id="teacher">
                                                    <option value="0">Select Teacher</option>
                                                    <?php
                                                    foreach ($teacher as $value) {
                                                        ?>
                                                        <option value="<?php echo $value->id; ?>" <?php if ($val->teacher_id == $value->id) echo 'selected="selected"'; ?>><?php echo $value->name; ?></option>
                                                        <?php
                                                    }
                                                    ?> 
                                                </select>
                                          
                                        </td>
                                            <td class="size35"></td>

                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td>
                                            <select class="form-control" name="class[]" required>
                                                <option value="0">Select Class</option>
                                                <?php foreach ($classes as $bat) { ?>
                                                    <option value="<?php echo $bat->id ?>"><?php echo $bat->class_name ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>

                                         <td>
                                         <select class="form-control" name="sec[]" id="programme">
                                                    <option value="0">Select Section</option>
                                                    <?php
                                                    foreach ($sect as $value) {
                                                        ?>
                                                        <option value="<?php echo $value->id; ?>"><?php echo $value->sec_name; ?></option>
                                                        <?php
                                                    }
                                                    ?> 
                                                </select>
                                          
                                        </td>
                                        <td>
                                         <select class="form-control" name="subject[]" id="subject">
                                                    <option value="0">Select Subject</option>
                                                    <?php
                                                    foreach ($subjects as $value) {
                                                        ?>
                                                        <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                                        <?php
                                                    }
                                                    ?> 
                                                </select>
                                          
                                        </td>
                                        <td>
                                         <select class="form-control" name="teacher[]" id="teacher">
                                                    <option value="0">Select Teacher</option>
                                                    <?php
                                                    foreach ($teacher as $value) {
                                                        ?>
                                                        <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
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

                <div class="panel-footer" style="padding: 2px 24px;">
                    <div class="row" style="<?php // echo $style1;  ?>">
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
</div>
<script>
    function rv(abc) {
        $(abc).parent('tr').remove();
    }

    function rvo(abc) {
        rv(abc);
    }
    function add_otherrow() {

        var row = '<tr><td><select class="form-control" name="class[]" required><option value="0">Select Class</option><?php foreach ($classes as $bat) { ?><option value="<?php echo $bat->id ?>"><?php echo $bat->class_name ?></option><?php } ?> </select></td><td><select class="form-control" name="sec[]" id="programme"><option value="0">Select Section</option> <?php foreach ($sect as $value) { ?><option value="<?php echo $value->id; ?>"><?php echo $value->sec_name; ?></option><?php } ?> </select></td><td><select class="form-control" name="subject[]" id="subject"><option value="0">Select Subject</option> <?php foreach ($subjects as $value) { ?><option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option><?php } ?> </select></td><td> <select class="form-control" name="teacher[]" id="teacher"> <option value="0">Select Teacher</option><?php foreach ($teacher as $value) { ?><option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option><?php } ?> </select></td><td onclick="rvo(this)" class="size35"><a style="color:red" class="pointer"><strong>X</strong></a></td></tr>'
	        $("#other_charge_tbl111").append(row);
	        $('select').select2({width: '100%', theme: "classic"});
	        $('select').on("select2:close", function () {
	            $(this).focus();
	        });
    }


    function save()
    {
        if (!$('#add_subject_teacher')[0].checkValidity()) {
            $(this).show();
            $('#add_subject_teacher')[0].reportValidity();
            return false;
        } else
        {
            $.ajax
                    ({
                        url: "<?php echo base_url('academics/Subject_teachers_ruchi/saveclass_sub_teacher') ?>",
                        type: "POST",
                        data: $('#add_subject_teacher').serialize(),
                        dataType: "json",
                        success: function (data) {
                           // alert('Data Save Successfully');
                            //window.location.href = "<?php echo base_url('academics/Subject_teachers') ?>";
                        },
                        error: function (errdata) {
                        }
                    });
        }
    }
    
     $('#back').click(function () {
            window.location.href = '<?php echo base_url('academics/Subject_teachers_ruchi'); ?>';
        });



function check($p)
                {
                   var remove_id = $p;
                   alert(remove_id);

            $.post('<?php echo base_url('feepayment/Exam_fee/removebatch'); ?>', {remove_id: remove_id}, function (data) {

            });
                }
</script>