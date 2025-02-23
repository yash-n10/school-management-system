<style>
    .treeview span.indent{
        
    }
    </style>

<div class="form-group has-feedback">
    <div class="box box-primary">
        <div class="box-body">
            <div class="col-lg-12">
                <!--<div class="col-lg-12">-->
                <a class="btn btn-primary" href="<?php echo base_url('settings/Role_permission/index'); ?>">
                    <i class="fa fa-reply fa-lg"></i>&nbsp; &nbsp;Back
                </a>

                <!--</div>-->

            </div>

        </div>
        <?php
        foreach ($group as $key => $value1) {
//print_r($value);
        }
        ?>
        <form id="form_up" class="form-horizontal" method="post" action="<?php echo base_url('settings/Role_permission/update') ?>">
            <div class="box-body">
                <div class="table-responsive">

                    <div class="col-md-12">
                        <div class="col-md-6 col-md-offset-1">
                            <div class="form-group">
                                <label for="email" class="col-sm-3 control-label">Role Code</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="group_code" id="group_code" value="<?php echo $value1->group_code; ?>" required>
                                </div>
                                <span id="error-group_code"><?php echo form_error('group_code'); ?></span>
                            </div>

                            <div class="form-group">
                                <label for="email" class="col-sm-3 control-label">Role Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="group_name" name="group_name" value="<?php echo $value1->group_type; ?>" required>
                                </div>
                                <span id="error-group_name"><?php echo form_error('group_name'); ?></span>
                            </div>

                        </div>

                        <div class="col-md-3" style="margin: 49px 0px 0px 42px;">
                            <input type="hidden" name="id" value="<?php echo $value1->id; ?>">
                            <!-- <a id="grpup" class="btn btn-success">Update</a>                -->
                            <button id="grpup" class="btn btn-success" type="submit">Update</button>       
                        </div>
                    </div>


                </div>
            </div>   

            <div class="box-body">
                
                    <fieldset>

                        <legend style="border-bottom: 1px solid #00a65a;">Permission:</legend>
                        <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="permission_tbl" style="width:100%">
                            <thead>
                            <tr>
                                <!--<th>#</th>-->
                                <th>Link</th>
                                <th>For Specific Login</th>
                                <th>All <input type="checkbox" id="modu"></th>
                                <th>Add <input type="checkbox" class="col-master"></th>
                                <th>View <input type="checkbox" class="col-master"></th>
                                <th>Modify <input type="checkbox" class="col-master"></th>
                                <th>Delete <input type="checkbox" class="col-master"></th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php $io=1;
                                foreach ($link as $key => $value) {
//                                    error_reporting(0);
                                    $lcode = $value->l_code;
                                    $idss = $value->id;
                                    $usergroup_id = $this->uri->segment(4);
                                    $ts = (array_key_exists($idss,$datas))? str_split($datas[$idss]):array();
//                                    print_r($ts);
                                    $tabs = ($value->level!=1) ? str_repeat("&nbsp;", 10*$value->level*$value->level) :'';
                                    if(($value->children_status=='TRUE' && $value->parent_node==0 )|| $value->level==1 ) {$trcolor='background-color:#cddc3963';}elseif($value->children_status=='TRUE' && $value->level>=2){ $trcolor='background-color:#eabdbac2';}else{$trcolor='';}
                                    ?> 
                                    <tr style="<?php echo $trcolor;?>">
                                        <!--<td><?php // echo $io ?></td>-->
                                        <td><?php echo $tabs.$value->l_name ?></td>
                                        <td><?php echo $value->link_status ?></td>
                                        <td><input type="checkbox" class="row-master" data-node="<?php echo $idss; ?>" data-level="<?php echo $value->level;?>" data-parent="<?php echo $value->parent_node;?>"></td>
                                        <td><input type="checkbox" class="checkbox child" <?php if (in_array("C", $ts)) { echo 'checked';}else{ echo 'ccc';}?> value="C" name="C[<?php echo "$value->id" ?>]" id="c" data-node="<?php echo $idss; ?>" data-level="<?php echo $value->level;?>" data-parent="<?php echo $value->parent_node;?>"></td>
                                        <td><input type="checkbox" class="checkbox child" <?php if (in_array("R", $ts)) { echo 'checked';} ?> value="R" name="R[<?php echo "$value->id" ?>]" id="r" data-node="<?php echo $idss; ?>" data-level="<?php echo $value->level;?>" data-parent="<?php echo $value->parent_node;?>"></td>
                                        <td><input type="checkbox" class="checkbox child" <?php if (in_array("U", $ts)) { echo 'checked';} ?>  value="U" name="U[<?php echo "$value->id" ?>]" id="u" data-node="<?php echo $idss; ?>" data-level="<?php echo $value->level;?>" data-parent="<?php echo $value->parent_node;?>"></td>
                                        <td><input type="checkbox" class="checkbox child" <?php if (in_array("D", $ts)) { echo 'checked';} ?> value="D" name="D[<?php echo "$value->id" ?>]" id="d" data-node="<?php echo $idss; ?>" data-level="<?php echo $value->level;?>" data-parent="<?php echo $value->parent_node;?>"></td>
                                        <input type="hidden" id="link_code" name="link_code[<?php echo "$value->id" ?>]" value="<?php echo $value->l_code; ?>"></input>
                                        <input type="hidden" id="idd" name="idd[]" value="<?php echo $value->id; ?>"></input>
                                    </tr>  
                                    <?php $io++;}
//                                } ?> 

                         </tbody>           
                        </table>
                        </div>
                    </fieldset>
           
            </div> 
        </form> 
    </div>
</div>

<script>
//  $('#grpup').click(function () {	
// if(!$('#form_up')[0].checkValidity()) {
//      $(this).show();
//      $('#form_up')[0].reportValidity();
//      return false;
//  }
//  else{
//     $.ajax({
//     	url:"<?php // echo site_url('settings/Role_permission/update') ?>",     	     	 
//     	type:"POST",
//     	data:$('#form_up').serialize(),
//     	success:function(data)
//     	{
//     		console.log();
//     		// alert("Update Successfully");
//            // window.location.href = "<?php // echo base_url(); ?>settings/Role_permission/index";
//     	}

//     });
//     }
// });
</script>

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
        
        var table =$('#permission_tbl').DataTable( {
            "scrollX": true,
            "scrollY": "400px",
            "scrollCollapse": true,
            "paging":         false,
            "searching": false,
            "ordering": false
            
        } );
        $('#permission_tbl tbody')
        .on( 'click', 'td', function () {
            var colIdx = table.cell(this).index().row;
//            alert(colIdx);
            $('.highlight').removeClass( 'highlight' );
            $( table.row( colIdx ).nodes() ).addClass( 'highlight' );
        } );
    });

</script>

<script type="text/javascript">
    $('.col-master').click(function () {
        var idx = $(this).parent().index();
        $('table td:nth-child(' + (idx + 1) + ') input.child').prop('checked', this.checked)
    })

    $('.row-master').click(function () {
        $(this).closest('tr').find('input.child').prop('checked', this.checked);
        var node=$(this).attr('data-node');
        var parent=$(this).attr('data-parent');
        $('input.child[data-parent='+node+']').prop('checked', this.checked);
        $('input.child[data-node='+parent+']').prop('checked', $('input.child[data-parent='+parent+']:checked').length!=0);
        
    });

    $('.child').change(function () {
        var $tr = $(this).closest('tr');
        $tr.find('input.row-master').prop('checked', $tr.find('.child').not(':checked').length == 0);

        var idx = $(this).parent().index(), $tds = $('table td:nth-child(' + (idx + 1) + ')');
        $tds.find('input.col-master').prop('checked', $tds.find('input.child').not(':checked').length == 0);
        
        var value=$(this).val();
        var node=$(this).attr('data-node');
        var parent=$(this).attr('data-parent');
        $('input.child[data-parent='+node+'][value='+value+']').prop('checked', this.checked);
        $('input.child[data-node='+parent+'][value='+value+']').prop('checked', $('input.child[data-parent='+parent+'][value='+value+']:checked').length!=0);
    })

</script>
