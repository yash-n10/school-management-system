<style type="text/css">
    .vertical-menu {   
        height: 350px;
        overflow-y: auto;
    }
    .size35{
        width:20px !important;
    }
</style>
<div class="form-group has-feedback">
    <div class="box box-primary">
         <div class="box-body">
        <div class="col-lg-8 col-lg-offset-2" id="successMessage" <?php if ($this->session->flashdata('successmsg')) { ?> style="padding: 10px 20px;background: #CCF5CC;text-align:center" <?php } ?>> <?php echo $this->session->flashdata('successmsg'); ?></div>
        <div class="col-lg-2">
            
        </div>
        <!--<div class="col-lg-12" style="text-align:center;">-->
            <div class="box" id="viewdatabox" style="display:none;border:1px solid red;background-color: #CCF5CC">
                <div class="box-body" id="viewdata">
                    <p style="color:red" ><b>NO USER AVAILABE IN TABLE!!</b></p>
                </div>
            </div>

        <!--</div>-->
        
      
    </div>
        <form id="form_add" class="form-horizontal" name="form_add" method="post" action="<?php echo site_url('settings/Role_permission/dualconcernsave') ?>">

            <div class="box-body">
                <div class="col-md-12" >
                    <fieldset>
                        <legend style="border-bottom: 1px solid #00a65a;">Dual Consent:</legend>

                        <div class="table-responsive" >
                            <table class="table table-bordered table-striped" id="permission_tbl" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <!--<th></th>-->
                                            <!--<th></th>-->
                                            <th></th>
<!--                                            <th></th>
                                            <th></th>-->
                                            <th></th>
                                            <th colspan="3" style="text-align: right">
                                                <a href="javascript:add_otherrow();" class="btn btn-icon-only green" style="padding: 4px 12px;height: 25px;width: 25px;margin-left: 20%;padding-left: 6px;"><i class="fa fa-plus "></i></a>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Page</th>
                                            <!--<th>All <input type="checkbox" id="modu"></th>-->
                                            <th>Add <input type="checkbox" class="col-master"></th>
                                            <!--<th>Modify <input type="checkbox" class="col-master"></th>-->
                                            <th>Delete <input type="checkbox" class="col-master"></th>
<!--                                            <th>Inputer/Initiator</th>
                                            <th>Approver</th>-->
                                            <th>Authorisor</th>
                                            <th class="size35"></th>
                                        </tr>
                                    </thead>
                                <tbody>
                                    
                                    <?php foreach ($dual_permission as $val) {
//                                     print_r($val);                                      
                                        ?>
                                        <tr>
                                            <td>
                                                <select class="form-control" id="page" name="page[]"  required autofocus>
                                                    <option value="">Select Page</option>
                                                    <?php
                                                        foreach ($link as $key => $value) {
                                                        $tabs = ($value->level != 1) ? str_repeat("&nbsp;", 10 * $value->level * $value->level) : '';
                                                        if (($value->children_status == 'TRUE' && $value->parent_node == 0 ) || $value->level == 1) {
                                                            $trcolor = 'background-color:#cddc3963';
                                                        } elseif ($value->children_status == 'TRUE' && $value->level >= 2) {
                                                            $trcolor = 'background-color:#eabdbac2';
                                                        } else {
                                                            $trcolor = '';
                                                        }
                                                        ?>                                           
                                                        <option value="<?php echo $value->id ?>" <?php if ($val->link_code == $value->id) echo 'selected="selected"'; ?>><?php echo $value->l_name; ?></option>
                                                    <?php } ?>
                                                </select> 
                                            </td>
                                            
                                            <!--<td><input type="checkbox" class="row-master" data-node="<?php echo $value->id; ?>" data-level="<?php echo $value->level; ?>" data-parent="<?php echo $value->parent_node; ?>"></td>-->
                                            <td><input type="checkbox" class="checkbox child" value="C" <?php if (($val->permission)=='C' ||($val->permission)=='CD'){echo 'checked';}else { }?> name="C[]" id="c" data-node="<?php echo $value->id; ?>" data-level="<?php echo $value->level; ?>" data-parent="<?php echo $value->parent_node; ?>"></td>
                                            <!--<td><input type="checkbox" class="checkbox child" value="U" name="U[]" id="u" data-node="<?php echo $value->id; ?>" data-level="<?php echo $value->level; ?>" data-parent="<?php echo $value->parent_node; ?>"></td>-->
                                            <td><input type="checkbox" class="checkbox child" value="D" <?php if (($val->permission)=='D' || ($val->permission)=='CD'){echo 'checked';}else { }?> name="D[]" id="d" data-node="<?php echo $value->id; ?>" data-level="<?php echo $value->level; ?>" data-parent="<?php echo $value->parent_node; ?>"></td>

<!--                                            <td><select class="form-control" id="user_group1" name="user_group[]" required autofocus>
                                                    <option value="">Select user group</option>
                                                    <?php foreach ($employee as $emp) { ?>
                                                        <option value="<?php echo $emp->id ?>" <?php if ($val->authorise_person1 == $emp->user_id) echo 'selected="selected"'; ?>><?php echo $emp->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                            <td><select class="form-control" id="user_group2" name="user_group_sec[]" required autofocus>
                                                    <option value="">Select user group</option>
                                                    <?php foreach ($employee as $emp) { ?>
                                                    <option value="<?php echo $emp->id ?>" <?php if ($val->authorise_person2 == $emp->user_id) echo 'selected="selected"'; ?>><?php echo $emp->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>-->
                                            <td><select class="form-control" id="user_group3" name="user_group_th[]" required autofocus>
                                                    <option value="">Select user group</option>
                                                    <?php foreach ($employee as $emp) { ?>
                                                    <option value="<?php echo $emp->id ?>" <?php if ($val->authorise_person3 == $emp->user_id) echo 'selected="selected"'; ?>><?php echo $emp->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                            <td class="size35"></td>

                                        </tr>
                                    <?php } ?>

                                    
                                    <tr>
                                        <td> 
                                            <select class="form-control" id="page" name="page[]"  required autofocus>
                                                <option value="">Select Page</option>
                                                <?php
                                                foreach ($link as $key => $value) {
                                                    $tabs = ($value->level != 1) ? str_repeat("&nbsp;", 10 * $value->level * $value->level) : '';
                                                    if (($value->children_status == 'TRUE' && $value->parent_node == 0 ) || $value->level == 1) {
                                                        $trcolor = 'background-color:#cddc3963';
                                                    } elseif ($value->children_status == 'TRUE' && $value->level >= 2) {
                                                        $trcolor = 'background-color:#eabdbac2';
                                                    } else {
                                                        $trcolor = '';
                                                    }
                                                    ?>                                           
                                                    <option value="<?php echo $value->id ?>"><?php echo $value->l_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <!--<td><input type="checkbox" class="row-master" data-node="<?php echo $value->id; ?>" data-level="<?php echo $value->level; ?>" data-parent="<?php echo $value->parent_node; ?>"></td>-->
                                        <td><input type="checkbox" class="checkbox child" value="C" name="C[]" id="c" data-node="<?php echo $value->id; ?>" data-level="<?php echo $value->level; ?>" data-parent="<?php echo $value->parent_node; ?>"></td>
                                        <!--<td><input type="checkbox" class="checkbox child" value="U" name="U[]" id="u" data-node="<?php echo $value->id; ?>" data-level="<?php echo $value->level; ?>" data-parent="<?php echo $value->parent_node; ?>"></td>-->
                                        <td><input type="checkbox" class="checkbox child" value="D" name="D[]" id="d" data-node="<?php echo $value->id; ?>" data-level="<?php echo $value->level; ?>" data-parent="<?php echo $value->parent_node; ?>"></td>
<!--                                        <td><select class="form-control" id="user_group4" name="user_group[]" required autofocus>
                                                <option value="">Select user group</option>
                                                <?php foreach ($employee as $emp) { ?>
                                                    <option value="<?php echo $emp->user_id ?>"><?php echo $emp->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td><select class="form-control" id="user_group5" name="user_group_sec[]" required autofocus>
                                                <option value="">Select user group</option>
                                                <?php foreach ($employee as $emp) { ?>
                                                <option value="<?php echo $emp->user_id ?>"><?php echo $emp->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>-->
                                        <td><select class="form-control" id="user_group6" name="user_group_th[]" required autofocus>
                                                <option value="">Select user group</option>
                                                <?php foreach ($employee as $emp) { ?>
                                                <option value="<?php echo $emp->user_id ?>"><?php echo $emp->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td onclick='rvo(this)' class='size35'><a style='color:red' class='pointer'><strong>X</strong></a></td>
                                        <td class="size35"></td>
                                        <input type="hidden" id="link_code" name="link_code[<?php echo $value->id ?>]" value="<?php echo $value->l_code; ?>">
                                        <input type="hidden" id="idd" name="idd[]" value="<?php echo $value->id; ?>">
                                    </tr>  
                                </tbody>
                            </table>
                        </div>    
                    </fieldset>

                </div>
            </div> 
            <div class="box-body">
                <div class="table-responsive">
                    <div class="col-md-12">
                        <div class="col-md-4 col-md-offset-1"></div>
                        <div class="col-md-4" style="margin: 49px 0px 0px 42px;">
                            <!--<a id="butt" class="btn btn-success">SAVE</a>-->               
                            <button id="butt" class="btn btn-success" type="submit">SAVE</button>               
                        </div>
                        <div class="col-md-4 col-md-offset-1"></div>
                    </div>
                </div>
            </div>

        </form> 
    </div>
    
    
</div>



<script>
    $(document).ready(function () {
        $("#modu").click(function () {
            $(".checkbox").prop('checked', $(this).prop('checked'));
        });

        $(".checkbox").change(function () {
            if (!$(this).prop("checked")) {
                $("#modu").prop("checked", false);
            }
        });

        var table = $('#permission_tbl').DataTable({
            "scrollX": true,
            "scrollY": "400px",
            "scrollCollapse": true,
            "paging": false,
            "searching": false,
            "ordering": false

        });
        $('#permission_tbl tbody')
                .on('click', 'td', function () {
                    var colIdx = table.cell(this).index().row;
//            alert(colIdx);
                    $('.highlight').removeClass('highlight');
                    $(table.row(colIdx).nodes()).addClass('highlight');
                });
    });

</script>

<script type="text/javascript">
    $('.col-master').click(function () {
        var idx = $(this).parent().index();
        $('table td:nth-child(' + (idx + 1) + ') input.child').prop('checked', this.checked)
    })

    $('.row-master').click(function () {
        $(this).closest('tr').find('input.child').prop('checked', this.checked);
        var node = $(this).attr('data-node');
        var parent = $(this).attr('data-parent');
        $('input.child[data-parent=' + node + ']').prop('checked', this.checked);
        $('input.child[data-node=' + parent + ']').prop('checked', $('input.child[data-parent=' + parent + ']:checked').length != 0);
    });

    $('.child').change(function () {
        var $tr = $(this).closest('tr');
        $tr.find('input.row-master').prop('checked', $tr.find('.child').not(':checked').length == 0);

        var idx = $(this).parent().index(), $tds = $('table td:nth-child(' + (idx + 1) + ')');
        $tds.find('input.col-master').prop('checked', $tds.find('input.child').not(':checked').length == 0);

        var value = $(this).val();
        var node = $(this).attr('data-node');
        var parent = $(this).attr('data-parent');
        $('input.child[data-parent=' + node + '][value=' + value + ']').prop('checked', this.checked);
        $('input.child[data-node=' + parent + '][value=' + value + ']').prop('checked', $('input.child[data-parent=' + parent + '][value=' + value + ']:checked').length != 0);
    });

    function rv(abc) {
        $(abc).parent('tr').remove();
    }

    function rvo(abc) {
        rv(abc);
    }
    
    function add_otherrow() {
        var row = "<tr><td><select class='form-control' id='page' name='page[]' required autofocus><option value=''>Select Page</option><?php foreach ($link as $key => $value) {$tabs = ($value->level != 1) ? str_repeat('&nbsp;', 10 * $value->level * $value->level) : '';if (($value->children_status == 'TRUE' && $value->parent_node == 0 ) || $value->level == 1) {$trcolor = 'background-color:#cddc3963';} elseif ($value->children_status == 'TRUE' && $value->level >= 2) {$trcolor = 'background-color:#eabdbac2';} else { $trcolor = '';} ?> <option value='<?php echo$value->id ?>'><?php echo $value->l_name; ?></option><?php } ?></select> </td><td><input type='checkbox' class='checkbox child' value='C' name='C[]' id='c' data-node='<?php echo $value->id; ?>' data-level='<?php echo $value->level; ?>' data-parent='<?php echo $value->parent_node; ?>'></td><td><input type='checkbox' class='checkbox child' value='D' name='D[]' id='d' data-node='<?php echo $value->id; ?>' data-level='<?php echo $value->level; ?>' data-parent='<?php echo $value->parent_node; ?>'></td><td> <select class='form-control' id='user_group3' name='user_group_th[]' required autofocus><option value=''>Select user group</option><?php foreach ($employee as $emp) { ?><option value='<?php echo $emp->user_id ?>'><?php echo $emp->name; ?></option><?php } ?> </select> </td><td onclick='rvo(this)' class='size35'><a style='color:red' class='pointer'><strong>X</strong></a></td><td class='size35'></td><input type='hidden' id='link_code' name='link_code[<?php echo $value->id ?>]' value='<?php echo $value->l_code; ?>'><input type='hidden' id='idd' name='idd[]' value='<?php echo $value->id; ?>'></tr>"
//        var row = "<tr><td><select class='form-control' id='page' name='page[]' required autofocus><option value=''>Select Page</option><?php foreach ($link as $key => $value) {$tabs = ($value->level != 1) ? str_repeat('&nbsp;', 10 * $value->level * $value->level) : '';if (($value->children_status == 'TRUE' && $value->parent_node == 0 ) || $value->level == 1) {$trcolor = 'background-color:#cddc3963';} elseif ($value->children_status == 'TRUE' && $value->level >= 2) {$trcolor = 'background-color:#eabdbac2';} else { $trcolor = '';} ?> <option value='<?php echo$value->id ?>'><?php echo $value->l_name; ?></option><?php } ?></select> </td><td><input type='checkbox' class='checkbox child' value='C' name='C[]' id='c' data-node='<?php echo $value->id; ?>' data-level='<?php echo $value->level; ?>' data-parent='<?php echo $value->parent_node; ?>'></td><td><input type='checkbox' class='checkbox child' value='D' name='D[]' id='d' data-node='<?php echo $value->id; ?>' data-level='<?php echo $value->level; ?>' data-parent='<?php echo $value->parent_node; ?>'></td><td> <select class='form-control' id='user_group1' name='user_group[]' required autofocus><option value=''>Select user group</option><?php foreach ($employee as $emp) { ?><option value='<?php echo $emp->user_id ?>'><?php echo $emp->name; ?></option> <?php } ?></select></td><td> <select class='form-control' id='user_group2' name='user_group_sec[]' required autofocus><option value=''>Select user group</option><?php foreach ($employee as $emp) { ?><option value='<?php echo $emp->user_id ?>'><?php echo $emp->name; ?></option><?php } ?></select></td><td> <select class='form-control' id='user_group3' name='user_group_th[]' required autofocus><option value=''>Select user group</option><?php foreach ($employee as $emp) { ?><option value='<?php echo $emp->user_id ?>'><?php echo $emp->name; ?></option><?php } ?> </select> </td><td onclick='rvo(this)' class='size35'><a style='color:red' class='pointer'><strong>X</strong></a></td><td class='size35'></td><input type='hidden' id='link_code' name='link_code[<?php echo $value->id ?>]' value='<?php echo $value->l_code; ?>'><input type='hidden' id='idd' name='idd[]' value='<?php echo $value->id; ?>'></tr>"
        $("#permission_tbl").append(row);
        $('select').select2({width: '100%', theme: "classic"});
        $('select').on("select2:close", function () {
            $(this).focus();
        });
    }
    
//  $('#user_group1').on('change',function(){
//
//  var user = $('#user_group1').find('option:selected').val();
//
//        $.ajax({
//            url: "<?php echo site_url('settings/Role_permission/CheckUsers') ?>",
//            type: "POST",
//            data: {user: user},
//            success: function(data)
//            {    
//              var ddd = data;
//             if(ddd>0)
//             {
//                $('#butt').attr('disabled',false);
//                $('#user_group2').attr('disabled',false);
//                $('#user_group3').attr('disabled',false);
//                $('#viewdatabox').hide();
//             }
//            else
//            {
//               $('#butt').attr('disabled',true);
//               $('#user_group2').attr('disabled',true);
//               $('#user_group3').attr('disabled',true);
//               $('#viewdatabox').show();
////               $('#viewdata').html(data);
//            }
//        
//        },        
//    });
//})
//
//  $('#user_group2').on('change',function(){
//
//  var user = $('#user_group2').find('option:selected').val();
//
//        $.ajax({
//            url: "<?php echo site_url('settings/Role_permission/CheckUsers') ?>",
//            type: "POST",
//            data: {user: user},
//            success: function(data)
//            {    
//              var ddd = data;
//             if(ddd>0)
//             {
//                $('#butt').attr('disabled',false);
//                $('#user_group3').attr('disabled',false);
//                $('#viewdatabox').hide();
//             }
//            else
//            {
//               $('#butt').attr('disabled',true);
//               $('#user_group3').attr('disabled',true);
//               $('#viewdatabox').show();
////               $('#viewdata').html(data);
//            }
//        
//        },        
//    });
//})
//
//  $('#user_group3').on('change',function(){
//
//  var user = $('#user_group3').find('option:selected').val();
//
//        $.ajax({
//            url: "<?php echo site_url('settings/Role_permission/CheckUsers') ?>",
//            type: "POST",
//            data: {user: user},
//            success: function(data)
//            {    
//              var ddd = data;
//             if(ddd>0)
//             {
//                $('#butt').attr('disabled',false);
//                $('#viewdatabox').hide();
//             }
//            else
//            {
//               $('#butt').attr('disabled',true);
//               $('#viewdatabox').show();
////               $('#viewdata').html(data);
//            }
//        
//        },        
//    });
//})
//
//  $('#user_group4').on('change',function(){
//
//  var user = $('#user_group4').find('option:selected').val();
//
//        $.ajax({
//            url: "<?php echo site_url('settings/Role_permission/CheckUsers') ?>",
//            type: "POST",
//            data: {user: user},
//            success: function(data)
//            {    
//              var ddd = data;
//             if(ddd>0)
//             {
//                $('#butt').attr('disabled',false);
//                $('#user_group5').attr('disabled',false);
//                $('#user_group6').attr('disabled',false);
//                $('#viewdatabox').hide();
//             }
//            else
//            {
//               $('#butt').attr('disabled',true);
//               $('#user_group5').attr('disabled',true);
//               $('#user_group6').attr('disabled',true);
//               $('#viewdatabox').show();
////               $('#viewdata').html(data);
//            }
//        
//        },        
//    });
//})
//
//$('#user_group5').on('change',function(){
//
//  var user = $('#user_group5').find('option:selected').val();
//
//        $.ajax({
//            url: "<?php echo site_url('settings/Role_permission/CheckUsers') ?>",
//            type: "POST",
//            data: {user: user},
//            success: function(data)
//            {    
//              var ddd = data;
//             if(ddd>0)
//             {
//                $('#butt').attr('disabled',false);
//                $('#user_group6').attr('disabled',false);
//                $('#viewdatabox').hide();
//             }
//            else
//            {
//               $('#butt').attr('disabled',true);
//               $('#user_group6').attr('disabled',true);
//               $('#viewdatabox').show();
////               $('#viewdata').html(data);
//            }
//        
//        },        
//    });
//})
//
//$('#user_group6').on('change',function(){
//
//  var user = $('#user_group6').find('option:selected').val();
//
//        $.ajax({
//            url: "<?php echo site_url('settings/Role_permission/CheckUsers') ?>",
//            type: "POST",
//            data: {user: user},
//            success: function(data)
//            {    
//              var ddd = data;
//             if(ddd>0)
//             {
//                $('#butt').attr('disabled',false);
//                $('#viewdatabox').hide();
//             }
//            else
//            {
//               $('#butt').attr('disabled',true);
//               $('#viewdatabox').show();
////               $('#viewdata').html(data);
//            }
//        
//        },        
//    });
//})
//
//
//    
//    
</script>
