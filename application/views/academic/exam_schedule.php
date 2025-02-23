
<div class="form-group">
    <div class="panel  panel-default"> 
        <div class="panel-body">
            <?php // if($this->session->userdata('successmsg')) {?>
        <div class="alert alert-success" style="display:none">
            <i class="fa fa-success"> </i> <label id="smsg"> <?php // echo $this->session->flashdata('successmsg');?></label>
        </div>
        <?php // }?>

            <form enctype="multipart/form-data" id="leavegroup-form" action="<?php echo base_url('academics/Exams/')."saveSchedule";?>" method="post">
                <div class="col-sm-12 col-md-12" >

                    <div class="row" style="margin-bottom:4%">
                        <input type="hidden" name="examid" value="<?php echo $exam_id?>">
                        <div class="col-sm-3">
                            <label class="req" style="font-size:16px !important">Class:</label> <span style="color:red">*</span>
                            <select class="form-control" name="classid" id="classid" required >
                                <option value="">--Select--</option>
                                <?php foreach($classes as $cl) {?>
                                        <option value="<?php echo $cl->id?>" ><?php echo $cl->class_name?></option>
                                <?php }?>
                                
                            </select>
                            <?php echo form_error('class_list'); ?>
                        </div>
                        
                        <div class="col-sm-3">
                            <label style="font-size:16px !important">Section:</label> <span style="color:red">*</span>
                        
                            <select class="form-control" name="sectionid" id="sectionid" required >
                                <option value="">--Select--</option>
                                <?php foreach($section1 as $sl) {?>
                                        <option value="<?php echo $sl->id?>" ><?php echo $sl->sec_name?></option>
                                <?php }?>
                                
                            </select>
                            <?php echo form_error('section_list'); ?>
                        </div>
                        <div class="col-sm-3">
                            <label style="font-size:16px !important">Course(If Any):</label> <span style="color:red">*</span>
                        
                            <select class="form-control" name="courseid" id="courseid" required >
                                <option value="0">--Select--</option>
                                <?php foreach($course as $sl) {?>
                                        <option value="<?php echo $sl->id?>" <?php if($sec==$sl->id) {echo 'selected=selected';}?>><?php echo $sl->course_name?></option>
                                <?php }?>
                                
                            </select>
                            <?php echo form_error('course_list'); ?>
                        </div>
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-info" id="organize" style = "margin-top:20px;"><i class="fa fa-clock-o" aria-hidden="true"></i> Schedule</button>

                            <a id="print_e_s" onclick="printpdfs();" target="_blank" title="Download" class="btn btn-warning" style = "margin-top:20px;"><i class="fa fa-print"></i> Print</a>
                        </div>
                    </div>
                    
                    <div class="row" style="padding-bottom:2%" id="printDiv">
                        <!--<div class="col-sm-1"></div>-->
                        <div class="col-sm-12">
                            <div class="panel  panel-default" style="margin-bottom: 0px;">
                                <div class="panel-heading" style="padding: 5px 15px;border-color:gray">
                                    <b style="font-size:16px !important"> <?php echo $exam_name;?> Exam Routine  </b>
                                    <!--<div class="pull-right btn-sm" style="    padding-right: 10px;">-->
                                        <!--<button class="btn btn-primary" id='add'>Add</button>-->
                                        <a href="javascript:add_row();" class="pull-right btn btn-icon-only green" style="padding:0px">
                                            <i class="fa fa-plus "></i>
                                        </a>
                                    <!--</div>-->
                                </div>
                                <div class="panel-body table-responsive" style="width:100%">
                                    <table class="table table-bordered " style="width:100%" id="examtbl">
                                        <thead>
                                            <tr>

                                                    <th style="width:14%">Date</th>
                                                    <th style="width:14%">Subject</th>
                                                    <!-- <th style="width:14%">Total Marks</th>
                                                    <th style="width:14%">Pass Marks</th> -->
                                                    <th style="width:14%">Start Time</th>
                                                    <th style="width:14%">End Time</th>
                                                    <!-- <th style="width:14%;display:none">Room No</th> -->
                                                    <th style="width:2%">#</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody_data">
                                            
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-lg-5"> 
                            <button type="button" class="btn btn-primary" id="back"><i class="fa fa-arrow-left"> </i> Back</button>
                        </div>
                        <div class="col-lg-3" id="div_save" style="display:none">    
                        <!--<input type="button" class="btn btn-primary" style="width: 120px;font-family: sans-serif;" id="back" value="Back">--> 
                            <!--<input type="button" class="btn btn-success"  name="saveleavegroup" id="btn_save" value="<?php // echo $task; ?>">-->
                            <input type="button" class="btn btn-success"  name="saveleavegroup" id="btn_save" onclick="save()" value="<?php echo $task; ?>">
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
            window.location.href = '<?php echo base_url('academics/Exams'); ?>';
        });


        
        $('#organize').click(function(){
            var classid=$('#classid').val();
            var sectionid=$('#sectionid').val();
            var courseid=$('#courseid').val();
            if(classid=='' ||sectionid=='') {
                alert("Please choose Class & Section");
                return false;
            }
            
           
            
                $.ajax
                ({
                    type: 'POST',
                   
                    url: '<?php echo base_url('academics/Exams/getSchedule'); ?>',
                    data: {classid:classid,sectionid:sectionid,courseid:courseid,examid:'<?php echo $exam_id?>'},
//                    dataType: "html",
                    dataType: "json",
                    success: function (data)
                    {
//                        $('#tbody_data').html(data);
                        $('#tbody_data').html(data.tbody);
                        $('.time-picker').timepicker({showInputs: false});
                        $('select').select2({width:'100%',theme: "classic"});
                        $('#div_save').show();

                    },
                    error: function (data)
                    {
                        alert('error occured while saving' + data);
                    }

                });
                
        });
        
    

setTimeout(function () {
        $('.alert-success').fadeOut("slow");
    }, 5000);

    });

function add_row() {
            var classid=$('#classid').val();
            var sectionid=$('#sectionid').val();
            var courseid=$('#courseid').val();
            if(classid=='' ||sectionid=='') {
                alert("Please choose Class & Section");
                return false;
            }
            $.ajax
                ({
                    type: 'POST',
                   
                    url: '<?php echo base_url('academics/Exams/getSubjects'); ?>',
                    data: {classid:classid,sectionid:sectionid,courseid:courseid,examid:'<?php echo $exam_id?>'},
                    dataType: "json",
                    success: function (data)
                    {
                        //        row_no = Number(document.getElementById("examtbl").rows.length) + '.';
        var tbody="<tr><td style='width:14%'>\n\
<input type='date' name='date_exam[]' class='form-control' required>\n\
</td>\n\
<td style='width:14%'>\n\
<select name='subject[]' class='form-control' required>\n\
<option value=''></option> ";
    $.each(data, function (ind, elem)
    {
        tbody+="<option value='"+elem['id']+"'>"+elem['name']+"</option>";
    });
    
tbody += "</select></td>\n\
<td style='width:14%'>\n\
<div class='input-group input-append bootstrap-timepicker' >\n\
<input value ='' type='text' class='form-control time-picker' name ='start_time[]' required>\n\
<span class='input-group-addon add-on'><i class='fa fa-clock-o'></i></span>\n\
</div></td>\n\
<td style='width:14%'><div class='input-group input-append bootstrap-timepicker' >\n\
<input value ='' type='text' class='form-control time-picker' name ='end_time[]' required>\n\
<span class='input-group-addon add-on'><i class='fa fa-clock-o'></i></span>\n\
</div>\n\
</td>\n\
\n\
<td style='width:2%' onclick='rv(this)'><a style='color:red'> <strong>X</strong></a></td></tr>";
    
        $("#examtbl").append(tbody);
        $('select').select2({width:'100%',theme: "classic"});
        $('.time-picker').timepicker({showInputs: false});
//        $('select').select2();
        $('select').on("select2:close", function () {
            $(this).focus();
        });
//        alert($('input[name="optradio"]:checked').val());
//        changeicon($('input[type="radio"][name="optradio"]:checked').val());

                    },
                    error: function (data)
                    {
                        alert('error occured while saving' + data);
                    }

                });

    }
    
    function rv(abc) {
        $(abc).parent('tr').remove();
    }
    function save() {


        var url = '';
        if (!$('form')[0].checkValidity())
        {
            $(this).show();
            $('form')[0].reportValidity();
            return false;
        } else {
//            $('#load').hide();
//            $('#load_f').show();

//            if (save_method == 'add') {
            url = "<?php echo base_url('academics/Exams/')."saveSchedule" ?>";
//            } else {
//                    
//                    url = "<?php // echo base_url('voucher_master/update_voucher_type')   ?>";
//            }

            $.ajax
                    ({
                        url: url,
                        type: "POST",
                        data: $('form').serialize(),
                        dataType: "json",
                        success: function (data) {


                                $('#tbody_data').html(data.tbody);
                                $('.alert-success').show();
                                $('#smsg').text(data.msg);
                                $('.time-picker').timepicker({showInputs: false});
                                $('select').select2({width:'100%',theme: "classic"});
                                $('#div_save').show();
                                setTimeout(function () {
                                    $('.alert-success').fadeOut("slow");
                                }, 5000);

                        },
                        error: function (errdata) {

                        }

                    });



        }
    }

</script>
<script> 
function printpdfs()
{
    var classid=$('#classid').val();
    var sectionid=$('#sectionid').val();
    var courseid=$('#courseid').val();                        
    window.location.href = "<?php echo base_url()?>academics/Exams/pdf_exam_routine/<?php echo $exam_id?>/"+classid +"/"+sectionid, '_blank';
}
</script>
     
