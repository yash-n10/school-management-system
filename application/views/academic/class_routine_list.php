<style>
    .btn-info {
            background-color: rgba(0, 192, 239, 0.14901960784313725);
    color: #0a0a0a;
    }
</style>
<div class="form-group has-feedback">
    <div class="box">            
        <div class="box-body">
            
            <?php if (substr($right_access, 0, 1) == 'C') { ?>
                <div class="col-lg-12">
                    <div class="col-lg-12" style="text-align:right;">
                        <button  class="btn btn-add" id="add_routine" title="Add Routine"> <a href="<?php echo base_url()?>academics/Class_routines/addClassRoutine"><i class="fa fa-plus-circle fa-lg"></i>&nbsp;</a></button>
            <a  class="btn btn-add" href="<?php echo base_url()?>academics/Class_routines/prints" title="Print Routine" target="_blank"><i class="fa fa-print fa-lg"></i>&nbsp;</a></div>
                </div>
            <?php } ?>
        </div>
        <div class="box-body">
            <div class="box-content padded">
                <div class="tab-content">
                    
                    <?php if (substr($right_access, 1, 1) == 'R') { ?>
                        <div class="tab-pane active" id="list">
                            <div class="panel-group" id="accordion2">
                            <?php
                            $toggle = true;
                            $dayarray=array('1'=>'sunday','2'=>'monday','3'=>'tuesday','4'=>'wednesday','5'=>'thursday','6'=>'friday','7'=>'saturday');
                           
                            foreach ($classes as $row):
                                 $clid = $row->id;
                                $secm = explode('-', $row->section);

                                if (!empty($row->section) && count($secm) > 0) {
                                    foreach ($secm as $sec):
                                    $sec_name = '';
                                    $sec_namedash = '';
                                     $sec_nameid = $row->id;
                                     $secid=$sec;
                                    // echo '----';
                                    //  $clid;
                                    if ($sec != '') {
                                     
                                        $sec_name = $this->dbconnection->get_section_name_by_id($sec);
                                        // $sec_name = $sectionname[$sec];
                                        // print_r($sec_name);
                                        $sec_namedash ="-".$sec_name;
                                        $sec_nameid =$row->id . $sec;
                                    }

                                    


                                    
                                     $crid=$corse_idd[0]->course_id;
                                   
                                   // print_r($cr_id);

                                    // $crseeenammme=$this->dbconnection->Get_namme('course', 'id', $corse_idd,"course_name");
                                   
                                    // print_r($corse_idd);
                           

                                    ?>				
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a style="font-size: 20px;padding: 7px 420px 8px 2px;" data-toggle="collapse" data-parent="#accordion2" href="#collapse<?php echo $sec_nameid;?>">
                                                     
                                                    <i class="icon-rss icon-1x"></i> Class <?php echo $row->class_name . '-' . $sec_name; ?>
                                                    <?php
                                                    
                                                    $clid = $row->id;
                                                    if (!empty($teachername[$clid][$sec])) {
                                                        ?>
                                                        <span  style="font-size: 14px;padding-left:5px"><span style="font-weight: bold;">Class Teacher :&nbsp;</span><?php echo $teachername[$clid][$sec]; ?></span>
                                                    <?php } else { ?>
                                                        <span  style="font-size: 14px;padding-left:5px"><span style="font-weight: bold;">Class Teacher :&nbsp;</span>N/A</span>
                                                    <?php } ?>    
                                                    
                                                     <span  style="font-size: 14px;padding-left:5px">
                                                         <?php 
                                                     $corse_idd=$this->db->query("select course_id from class_routine where class_id='$clid' and section_id='$secid' and status=1 and academic_year_id={$this->academic_session[0]->fin_year} group by course_id")->result(); 
                                                     /*echo $this->db->last_query();*/
                                                     $crseeeid=$corse_idd[0]->course_id;
                                                     // echo '<pre>';
                                                     // print_r($corse_idd);
                                                     $crseeename=$this->dbconnection->Get_namme('course', 'id', $crseeeid,"course_name");
                                                     ?><?php if($crseeeid>0) { ?>
                                                        <span style="font-weight: bold;">Course :&nbsp;<?php echo $crseeename ;?></span>
                                                        <?php } else { ?>
                                                            <!-- <span style="font-weight: bold;">Course :&nbsp;<?php echo $crseeename ;?></span> -->
                                                       <?php } ?>
                                                    </span>
                                                </a>
                                                <a class="btn a-edit pull-right" onclick="editbulk('<?php echo $clid ?>','<?php echo $sec?>')" style="color: green;"><i class="fa fa-edit"></i></a>
                                            </h4>                                                    
                                        </div>

                                        <div id="collapse<?php echo $row->id . $sec; ?>" class="panel-collapse collapse <?php if ($toggle) { echo 'in'; $toggle = false;}?> " >
                                            <div class="panel-body  table-responsive" style="width:100%">
                                                <table  class="table table-striped table-bordered table-hover">
                                                    <thead style="background: yellowgreen">
                                                        <tr>
                                                            <th>Time<br/>Day</th>
                                                            <?php foreach ($period as $per_value) { ?>
                                                                <th><?php echo $per_value->name; ?><br/>(<?php echo $per_value->time_start; ?>:<?php echo $per_value->time_start_min; ?> - <?php echo $per_value->time_end; ?>:<?php echo $per_value->time_end_min; ?>)</th>
                                                            <?php } ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody>                                                           

                                                    <?php for ($d = 1; $d <= 7; $d++) {?>
                                                        <?php if($dayarray[$d]!='sunday'){ ?>
                                                        <tr class="gradeA">
                                                            <th width="100" style="background: #d6f793;"><?php echo strtoupper($dayarray[$d]); ?></th>
                                                                <?php foreach ($period as $per_valu) { ?>
                                                                <td>  
                                                        <?php if ($dayarray[$d] == 'sunday') { 
                                                            echo 'Holiday';
                                                        } else {
                                                             $pid = $per_valu->id;
                                                            $clsid = $row->id;

                                                            $rows = $this->dbconnection->GetRoutinedata($pid, $dayarray[$d], $clsid, $sec,$academic_session);                                
                                                            $co = count($rows);
                                                            if ($co > 0) { ?>
                                                                <div class="btn-group">
                                                                    <button class="btn btn-info" data-toggle="dropdown" style="min-width:149px;width:120px">
                                                                        <b>
                                                                        <?php echo $newtext1 = wordwrap($rows[0]['name'], 10); ?>
                                                                        </b>
                                                                        <br>
                                                                        <i>
                                                                        <?php if ($rows[0]['tname']) { ?>

                                                                            (<?php echo $newtext = wordwrap($rows[0]['tname'], 10); ?>)
                                                                        <?php
                                                                        } else {
                                                                            echo '(N/A)';
                                                                        }
                                                                        ?>
                                                                        </i>
                                                                        <span class="caret"></span>
                                                                    </button>
                                                                    <style>
                                                                        .dropdown-menu>li>a {
                                                                                color: #fff;
                                                                            }
                                                                    </style>
                                                <ul class="dropdown-menu" style="border:3px solid #ccc;background-color: #00acd6;">
                                                        <?php if (substr($right_access, 2, 1) == 'U') { ?>
                                                        <li>
                                                            <a data-toggle="modal" onclick="remarks();"><i class="icon-cog"></i>Remarks
                                                            </a>
                                                        </li>
                                                        <?php } if (substr($right_access, 2, 1) == 'U') { ?>
                                                        <li>
                                                            <a data-toggle="modal" onclick="homework();"><i class="icon-trash"></i>Homework
                                                            </a>
                                                        </li>
                                                         <?php } ?>
                                                </ul>
                                                                                        </div>
                                                                                        <?php
                                                                                    } else { echo '--';?>
                                                                                         
                                                                                    <?php } ?>
                                                                                <?php } ?>   

                                                                            </td>
                                                                        <?php } ?>
                                                                    </tr>
                                                                <?php }} ?>
                                                            </tbody>
                                                        </table>                                        
                                                    </div>
                                                </div>
                                            </div>
                                <?php endforeach; ?>
                                <?php } 
                                endforeach; ?>
                            </div>
                        </div>
<?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <div id="add_routine" class="modal fade" role="dialog"> -->
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo base_url('academics/class_routines/save') ?>" method="post" id="manage_classRoutine" class="form-horizontal">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Add Routine</h3>
                </div>
                <div class="modal-body form">
                    <div class="form-body">
                        <div class="form-group">
                            <label class=" control-label col-sm-3" >Class:</label>
                            <div class="col-sm-3">
                                <select name="class_id" id="class_id" class="form-control" style="width:100%;">
                                    <option value="">&nbsp;&nbsp;-- Select --&nbsp;&nbsp;&nbsp;</option> 
                                    <?php foreach ($classes as $row): ?>
                                        <option value="<?php echo $row->id; ?>"><?php echo $row->class_name; ?></option>
                                    <?php endforeach; ?>
                                </select>               
                            </div>          
                            <label class="control-label col-sm-2">Section:</label>
                            <div class="col-sm-3">
                                <select name="section_id" class="form-control">
                                    <option value="">&nbsp;&nbsp;-- Select--&nbsp;&nbsp;</option> 
                                        <?php foreach ($section1 as $row): ?>
                                        <option value="<?php echo $row->id; ?>"><?php echo $row->sec_name; ?></option>
                                        <?php endforeach; ?>
                                </select>
                            </div>
                        </div>                         
                        <div class="form-group">
                            <label class="control-label col-sm-3" >Day:</label>
                            <div class="col-sm-3">
                                <select name="day" class="form-control">
                                    <option value="">&nbsp;&nbsp;-- Select--&nbsp;&nbsp;</option>
                                    <option value="sunday">sunday</option>
                                    <option value="monday">monday</option>
                                    <option value="tuesday">tuesday</option>
                                    <option value="wednesday">wednesday</option>
                                    <option value="thursday">thursday</option>
                                    <option value="friday">friday</option>
                                    <option value="saturday">saturday</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" >Subject:</label>
                            <div class="col-sm-3">
                                <select name="subject_id" class="form-control">
                                    <option value="">&nbsp;&nbsp;-- Select--&nbsp;&nbsp;</option> 
                                    <?php foreach ($subjects as $row): ?>
                                        <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" >Period:</label>
                            <div class="col-sm-4">
                                <select id="period" name="period" class="uniform form-control col-sm-3">
                                    <option value="">--Select Period--</option>
                                    <?php foreach ($period as $per_value) { ?>
                                        <option value="<?php echo $per_value->id; ?>"><?php echo $per_value->name; ?> &nbsp;&nbsp;&nbsp;(<?php echo $per_value->time_start; ?>:<?php echo $per_value->time_start_min; ?> - <?php echo $per_value->time_end; ?>:<?php echo $per_value->time_end_min; ?>)</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btn_save">Save</button> 
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
<!-- </div> -->

<script>

    $(function ()
    {
        $('#examlist').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true
        });

        $('.closes').click(function () {
            $('.fade').removeClass('modal-backdrop');
        });

        $('#add_routine').click(function ()
        {
            window.location.href = "<?php echo base_url('academics/routine/class_routines/addRoutine'); ?>";

        });
    });

function remarks(){
    alert('remarks');
}
function homework(){
    alert('homework');
}
//    $('#add_routine').on('hidden.bs.modal', function (e)
//    {
//        $('#modal_header #modal-title').text('Add Routine');
//        $('#manage_classRoutine')[0].reset();
//        $('select').val('').prop('selected', true).trigger('change');
//        $('.fade').removeClass('modal-backdrop');
//    });
    function edit(classs_routine_id, class_name, sec_name, day, subject_id, period_id)
    {
        var par = ['no_val', 'class_id', 'section_id', 'day', 'subject_id', 'period']
        for (var i = 1, j = arguments.length; i < j; i++)
        {
            select_drop_down(par[i], arguments[i]);
        }

        $('#add_routine').modal('show');
        $('#modal_header #modal-title').text('Edit Routine');
        $('#manage_classRoutine').attr('action', '<?php echo base_url('academics/class_routines/update'); ?>' + '/' + classs_routine_id);
    }

    function select_drop_down(name_attr, val)
    {

        $('select[name=' + name_attr + ']').find("option:contains('" + val + "')").each(function () {
            if (($(this).text() == val) || ($(this).val() == val)) {
                $(this).attr("selected", "selected").trigger('change');
            }
        });
    }
    function deleteClass_routine(id)
    {
        var r = confirm("Are you sure you want to delete this record?");
        var id;
        if (r == true)
        {
            $.ajax({
                url: "<?php echo site_url('academics/class_routines/delete') ?>" + "/" + id,
                type: "POST",
                data: {cr: id},
                dataType: "text",
                success: function (data)
                {
                    window.location.href = "<?php echo base_url('academics/routine/class_routines'); ?>";
                },
                error: function (data, status)
                {
                    alert('e' + data + status);
                }});
        } else {
            $('.fade').removeClass('modal-backdrop');
        }
    }
    
    function editbulk(clas,sec) {
    
        window.location.href = "<?php echo base_url('academics/routine/class_routines/editRoutine/'); ?>"+clas+"/"+sec;
    }


    $('#btn_save').click(function ()
    {
        var url = $('#manage_classRoutine').attr('action');

        $.ajax({
            url: url,
            type: "POST",
            data: $('#manage_classRoutine').serialize(),
            dataType: "text",
            success: function (data)
            {
                console.log(data);
                window.location.href = "<?php echo base_url('academics/routine/class_routines'); ?>";
            },
            error: function ()
            {
                alert('Error occured');
            }
        });

    });

</script>