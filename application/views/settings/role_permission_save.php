<style type="text/css">
	.vertical-menu {   
		height: 350px;
		overflow-y: auto;
	}
	td.disp_row {
		padding: 0px 0px 0px 5px; 
		height:30px; 
	}
</style>

<div class="form-group has-feedback">
	<div class="box box-primary">
		<div class="box-body">
			<div class="col-lg-12">
				<a class="btn btn-primary" href="<?php echo base_url('settings/Role_permission/index'); ?>">
					<i class="fa fa-reply fa-lg"></i><b>&nbsp;&nbsp;Back</b>
				</a>
			</div>
		</div>

		<form id="form_add" class="form-horizontal" name="form_add" method="post" action="<?php echo site_url('settings/Role_permission/save') ?>">
			<div class="box-body">
				<div class="table-responsive">
					<div class="col-md-12">
						<div class="col-md-6 col-md-offset-1">
							<div class="form-group">
								<label for="email" class="col-sm-3 control-label">Role Code</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="group_code" name="group_code" required="">
								</div>
								<span id="error-paper_cat_code"><?php echo form_error('group_code'); ?></span>
							</div>
							<div class="form-group">
								<label for="email" class="col-sm-3 control-label">Role Name</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="group_name" name="group_name" required="">
								</div>
								<span id="error-paper_cat_name"><?php echo form_error('group_name'); ?></span>
							</div>
						</div>

						<div class="col-md-3" style="margin: 49px 0px 0px 42px;">
                            <!--<a id="butt" class="btn btn-success">SAVE</a>-->               
							<button id="butt" class="btn btn-success" type="submit"><b>Save</b></button>               
						</div>
					</div>
				</div>
			</div>   

			<div class="box-body">
				<div class="col-md-12" >
					<fieldset>
						<legend style="border-bottom:1px solid #aqua; background:#00b0de; padding-right:5px; color:white; font-weight:bold;">Permission:</legend>

						<div class="table-responsive" style="width:100%;">
							<table class="table table-bordered table-striped" id="permission_tbl" style="width:100%">
								<thead>
									<tr>
								<!--<th>#</th>-->
										<th style="width:55%;">Link</th>
										<th style="width:15%; text-align:center;">For Specific Login</th>
										<th style="width:6%; text-align:center;">All<br><input type="checkbox" id="modu"></th>
										<th style="width:6%; text-align:center;">Add<br><input type="checkbox" class="col-master"></th>
										<th style="width:6%; text-align:center;">View<br><input type="checkbox" class="col-master"></th>
										<th style="width:6%; text-align:center;">Modify<br><input type="checkbox" class="col-master"></th>
										<th style="width:6%; text-align:center;">Delete<br><input type="checkbox" class="col-master"></th>
									</tr>
								</thead>
								
								<tbody>
								<?php
								foreach ($link as $key => $value) {
// echo '<pre>';
// print_r($value); 
									$tabs = ($value->level!=1) ? str_repeat("&nbsp;", 10*$value->level*$value->level) :'';
									if(($value->children_status=='TRUE' && $value->parent_node==0 )|| $value->level==1 ) {
										$trcolor='background-color:#cddc3963';
									} elseif ($value->children_status=='TRUE' && $value->level>=2){
										$trcolor='background-color:#eabdbac2';
									} else {
										$trcolor='';
									}
									?> 
									<tr style="<?php echo $trcolor;?>">
                                    <!--<td><?php // echo $value->id ?></td>-->
										<td class="disp_row" style="padding: 0px 0px 0px 5px; height:32px; vertical-align:middle;"><?php echo  $tabs.$value->l_name ?></td>
										<td class="disp_row" style="padding: 0px 0px 0px 5px; height:32px; vertical-align:middle;"><?php echo $value->link_status ?></td>
										<td class="disp_row" style="text-align:center;padding: 0px 0px 0px 5px; height:32px; vertical-align:middle;"><input type="checkbox" class="row-master" data-node="<?php echo $value->id; ?>" data-level="<?php echo $value->level;?>" data-parent="<?php echo $value->parent_node;?>"></td>
										<td class="disp_row" style="text-align:center;padding: 0px 0px 0px 5px; height:32px; vertical-align:middle;"><input type="checkbox" class="checkbox child" value="C" name="C[<?php echo $value->id ?>]" id="c" data-node="<?php echo $value->id; ?>" data-level="<?php echo $value->level;?>" data-parent="<?php echo $value->parent_node;?>"></td>
										<td class="disp_row" style="text-align:center;padding: 0px 0px 0px 5px; height:32px; vertical-align:middle;"><input type="checkbox" class="checkbox child" value="R" name="R[<?php echo $value->id ?>]" id="r" data-node="<?php echo $value->id; ?>" data-level="<?php echo $value->level;?>" data-parent="<?php echo $value->parent_node;?>"></td>
										<td class="disp_row" style="text-align:center;padding: 0px 0px 0px 5px; height:32px; vertical-align:middle;"><input type="checkbox" class="checkbox child" value="U" name="U[<?php echo $value->id ?>]" id="u" data-node="<?php echo $value->id; ?>" data-level="<?php echo $value->level;?>" data-parent="<?php echo $value->parent_node;?>"></td>
										<td class="disp_row" style="text-align:center;padding: 0px 0px 0px 5px; height:32px; vertical-align:middle;"><input type="checkbox" class="checkbox child" value="D" name="D[<?php echo $value->id ?>]" id="d" data-node="<?php echo $value->id; ?>" data-level="<?php echo $value->level;?>" data-parent="<?php echo $value->parent_node;?>"></td>
										<input type="hidden" id="link_code" name="link_code[<?php echo $value->id ?>]" value="<?php echo $value->l_code; ?>"></input>
										<input type="hidden" id="idd" name="idd[]" value="<?php echo $value->id; ?>"></input>
									</tr>  
									<?php 
								} ?> 
							</tbody>
						</table>
					</div>    
				</fieldset>


                </div>
            </div> 

        </form> 
    </div>
</div>


<script>

//	 $('#butt').click(function () {	
//    if(!$('#form_add')[0].checkValidity()) {
//      $(this).show();
//      $('#form_add')[0].reportValidity();
//      return false;
//  }
//  else {
//     $.ajax({
//      
//     	url:"<?php // echo site_url('settings/Role_permission/save')  ?>",     	     	 
//     	type:"POST",
//     	data:$('#form_add').serialize(),
//     	success:function(data)
//     	{
//            alert
////     		alert("save Successfully");
//       window.location.href = "<?php echo base_url(); ?>settings/Role_permission/index";
//     	}
//
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
            "paging": false,
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
    });

</script>


