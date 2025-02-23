<div class="form-group">
    <div class="panel  panel-default"> 
        <div class="panel-body">
            <?php if($this->session->flashdata('successmsg')) {?>
        <div class="alert alert-success" >
            <i class="fa fa-success"> </i> <label> <?php echo $this->session->flashdata('successmsg');?></label>
        </div>
        <?php }?>

            <form enctype="multipart/form-data" id="leavegroup-form" action="<?php echo base_url('academics/class_routines/').lcfirst($task);?>" method="post">
                <div class="col-sm-12 col-md-12" style="margin-top:2%">
                    <!--                                  <div class="panel  panel-default">
                    <div class="panel-body" style="">-->

                    <div class="row" style="padding-bottom:2%">
                        <!--<div class="col-sm-1"></div>-->
                        <div class="col-sm-2">
                            <label class="req" style="font-size:16px !important">Class:</label> <span style="color:red">*</span>
                        </div>
                        <div class="col-sm-2">
                            <select class="form-control" name="class_list" id="class_list" required <?php if($task=='Update' || $clas!='') echo 'style="pointer-events:none"';?>>
                                <option value="">--Select--</option>
                                <?php foreach($classlist as $cl) {?>
                                        <option value="<?php echo $cl->id?>" <?php if($clas==$cl->id) {echo 'selected=selected';}?>><?php echo $cl->class_name?></option>
                                <?php }?>
                                
                            </select>
                            <?php echo form_error('class_list'); ?>
                        </div>
                        <div class="col-sm-2">
                            <label style="font-size:16px !important">Section:</label> <span style="color:red">*</span>
                        </div>
                        <div class="col-sm-2">
                            <select class="form-control" name="section_list" id="section_list" required <?php if($task=='Update' || $sec!='') echo 'style="pointer-events:none"';?>>
                                <option value="">--Select--</option>
                                <?php foreach($sectionlist as $sl) {?>
                                        <option value="<?php echo $sl->id?>" <?php if($sec==$sl->id) {echo 'selected=selected';}?>><?php echo $sl->sec_name?></option>
                                <?php }?>
                                
                            </select>
                            <?php echo form_error('section_list'); ?>
                        </div>

                        <div class="col-sm-2">
                            <label style="font-size:16px !important">Course (If Any):</label> <span style="color:red">*</span>
                        </div>
                        <div class="col-sm-2">
                            <select class="form-control" name="course_list" id="course_list" >
                                <option value="">--Select--</option>
                                <?php foreach($courselist as $cl) {?>
                                        <option value="<?php echo $cl->id?>" ><?php echo $cl->course_name?></option>
                                <?php }?>
                                
                            </select>
                            <?php echo form_error('course_list');
                             ?>
                        </div>
                    </div>
                    <div class="row" style="padding-bottom:2%">
                        <!--<div class="col-sm-1"></div>-->
                        <div class="col-sm-12">
                            <div class="panel  panel-default" style="margin-bottom: 0px;">
                                <div class="panel-heading" style="padding: 5px 15px;border-color:gray">
                                    <b style="font-size:16px !important"> Routine </b>
                                </div>
                                <div class="panel-body table-responsive" style="">
                                    <!--                                                                      <div style="overflow-x:auto;overflow-y:hidden;padding:2%">-->
                                    <?php $dayarray=array('1'=>'sunday','2'=>'monday','3'=>'tuesday','4'=>'wednesday','5'=>'thursday','6'=>'friday','7'=>'saturday');?>
                                    <table class="table table-normal table-bordered ">
                                        <tr style="border:1px solid black">
                                            <th>Time<br/>Day</th>
                                            <?php foreach ($period as $per_value) { ?>
                                                <th><?php echo $per_value->name; ?><br/>(<?php echo $per_value->time_start; ?>:<?php echo $per_value->time_start_min; ?> - <?php echo $per_value->time_end; ?>:<?php echo $per_value->time_end_min; ?>)</th>
                                            <?php } ?>
                                        </tr> 
                                        <?php for ($d = 2; $d <= 7; $d++) {?>
                                            <tr>
                                                <td>
                                                    <?php echo strtoupper($dayarray[$d]); ?>
                                                </td>
                                                <?php foreach ($period as $per_value) { ?>
                                                <td>
                                                    <?php if($per_value->break_yes_no=='NO') {?>
                                                    <select name="subject_id[<?php echo $dayarray[$d]?>][<?php echo $per_value->id?>]" class="form-control subjectlist" >
                                                            <option value="">&nbsp;&nbsp;-- Select--&nbsp;&nbsp;</option> 
                                                            <!--<option value="0"> Break </option>--> 
                                                                <?php foreach ($subjects as $row): 
                                                                    // print_r($row);
                                                                    // die();
                                                                    ?>
                                                                <option value="<?php echo $row->id; ?>" <?php if($task=='Update' && $qclassroutine[$dayarray[$d]][$per_value->id]==$row->id) echo 'selected=selected';?>><?php echo $row->name; ?></option>
                                                            <?php endforeach; ?>
                                                            </select>
                                                    <?php }?>
                                                </td>
                                                <?php } ?>
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
                            <!--<input type="button" class="btn btn-success"  name="saveleavegroup" id="btn_save" value="<?php echo $task; ?>">-->
                            <input type="submit" class="btn btn-success"  name="saveleavegroup" id="btn_save" value="<?php echo $task; ?>">
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
  <?php if ($this->session->flashdata('successmsg')) { ?>
//    $('#myModal').modal('show');
    <?php }?>
//     history.replaceState({}, null, "/staff_management/employee/edit");
    $(document).ready(function ()
    {
//       $(".chosen-select").chosen({width: "100%"}); 
        var task = '<?php echo $task; ?>';
//        var classroutine_id = '<?php // echo $classroutine_id; ?>';


        $('#back').click(function () {
//                alert('hi');
            window.location.href = '<?php echo base_url('academics/routine/class_routines'); ?>';
        });
        
        $('#class_list,'+'#section_list,'+'#course_list').change(function(){
            var classid=$('#class_list').val();
            var sectionid=$('#section_list').val();
            var courseid=$('#course_list').val();
            // alert(courseid);
            if(classid=='') {
                alert("Please choose Class");
                return false;
            }
            
                $.ajax
                ({
                    type: 'POST',
                   
                    url: '<?php echo base_url('academics/class_routines/getSubjects'); ?>',
                    data: {classid:classid,sectionid:sectionid,courseid:courseid},
                    dataType: "json",
                    success: function (data)
                    {
                        $('.subjectlist').html(data[0]);
                        if(data[1]=='true') {
                            alert('Routine has already made for this class and section');
                            $('#btn_save').attr('disabled',true);
                        }else{
                            $('#btn_save').attr('disabled',false);
                        }

                    },
                    error: function (data)
                    {
                        alert('error occured while saving' + data);
                    }

                });
                
        });
        
//        $('#btn_save').click(function () {
//            if (!$('#form')[0].checkValidity())
//            {
////                                                alert($('#add_stud_frm')[0].validationMessage);
//                $(this).show();
//                $('#form')[0].reportValidity();
//                $('#btn_save').attr('disabled',false);
//                return false;
//            } else {
//                var r = confirm("Are you sure you want to " + task + " This college?");
//                if (r == true)
//                {
//                    if (task == 'Save') {
//                        $('#btn_save').val('Saving');
//                        
//                    } else {
//                        $('#btn_save').val('Updating');
//                    }
//                    $('#btn_save').attr('disabled',true);
//                    return true;
//                } else {
//                    return false;
//                    $('#btn_save').attr('disabled',false);
//                }
//            }
//        });

//        $('#btn_save').click(function ()
//        {
//
//            if (!$('#leavegroup-form')[0].checkValidity())
//            {
////                                                alert($('#add_stud_frm')[0].validationMessage);
//                $(this).show();
//                $('#leavegroup-form')[0].reportValidity();
//                return false;
//            } else {
//                var formdata = $('form').serialize();
//                if (task == 'Save')
//                {
//                    action_url = '<?php // echo base_url('hr/settings/leave_group/save'); ?>';
//                }
//                else
//                {
//
//                    action_url = '<?php // echo base_url('hr/settings/leave_group/update'); ?>' + '/' + leavegroup_id;
//                }
////                alert(action_url);
//                $.ajax
//                        ({
//                            type: 'POST',
//                            data: formdata,
//                            url: action_url,
//                            datatype: "text",
//                            success: function (data)
//                            {
//                                window.location.href = '<?php // echo base_url('hr/settings/leave_group'); ?>';
//
//                            },
//                            error: function (data)
//                            {
//                                alert('error occured while saving' + data);
//                            }
//
//                        });
//
//            }
//
//        });

setTimeout(function () {
        $('.alert-success').fadeOut("slow");
    }, 5000);

    });



</script>
