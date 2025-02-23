
<div class="form-group ">
    <div class="box box-primary">            
        <div class="box-body">
            <?php //if(substr($right_access,0,1)=='C'){?>
            <div class="col-lg-12">
                <div class="col-lg-12" style="text-align:right;"><button data-toggle="modal" class="btn btn-add" id="add_salary_group"> <i class="fa fa-plus-circle fa-lg"></i> </button></div>
              
            </div>
            <?php //}?>  
        </div>


            
            <div class="box-body">
            

              <form id='frmtemplate' role="form" method="POST">
                  <div class="table-responsive">
                <table id="salary_structure_list" class="table table-bordered table-striped">
                <thead style="background: #33495c;color: white;">
                        <tr>
                                        <th style="border-bottom:0px">#</th>
                                        <th style="border-bottom:0px">Slab Name</th>                                                                         
                                        <th style="border-bottom:0px">Designation</th>                                                                         
                                        <th style="border-bottom:0px">Pay Scale</th>                                                                         
                                        <th style="border-bottom:0px">Grade Pay</th>                                                                         
                                        <th style="border-bottom:0px">Applicable From</th>                                                                         
                                        <th style="border-bottom:0px">Action</th>
                        </tr>
		</thead>
                <thead style="background: #d9e9f8;">
                    <tr id="searchhead">
                        <th style="border-bottom:2px solid darkcyan;border-top:0px">
                            <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="0"/>
                        </th>
                        <th style="border-bottom:2px solid darkcyan;border-top:0px">
                            <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="1"/>
                        </th>
                      <th style="border-bottom:2px solid darkcyan;border-top:0px">
                            <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="1"/>
                        </th>
                        <th style="border-bottom:2px solid darkcyan;border-top:0px">
                            <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="1"/>
                        </th>
                        <th style="border-bottom:2px solid darkcyan;border-top:0px">
                            <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="1"/>
                        </th>
                        <th style="border-bottom:2px solid darkcyan;border-top:0px">
                            <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="1"/>
                        </th>
                        <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                    </tr>
                </thead>
                  <tbody>
                  <?php 
              $count = 1;
              foreach($salary_group as $row):?>
               
                    <tr>
                      <td><?php echo $row->id;?> </td>
                      <td><?php echo $row->slab_name;?></td>          
                      <td><?php echo $fetch_designation[$row->designation_id];?></td>          
                      <td><?php echo $row->from_basic.'-'.$row->to_basic;?></td>          
                      <td><?php echo $row->grade_pay;?></td>          
                      <td><?php echo $row->applicable_from;?></td>          
 					  
                      <td>
                          <div class="form-group row">
                                <?php //if(substr($right_access,3,1)=='D'){?>
                                <div class="col-sm-1" style="line-height: 2;">
                                    <input type="checkbox" class="btn"  id="<?php echo $row->id; ?>">
                                </div>
                                <?php //} if(substr($right_access,2,1)=='U'){?>
                                <div class="col-sm-2">
                                 <a class="btn a-edit" id="<?php echo $row->id;?>">
                                  <i class="fa fa-edit"></i>
                                </a>
                                </div>
                                <?php //} ?>
                          </div>
                      </td>
                           
                    </tr>
                 <?php endforeach;?>
                  </tbody>
                 
                </table>
              </div>
                <?php //if(substr($right_access,3,1)=='D'){?>
                  <div class="box-body" style="text-align:right">
                    <?php if(count($salary_group) > 0){?>              
                    <input type="button" class="btn btn-danger" id="emp_cats" value="Delete" onclick="deleteClass();">
                    <?php// }   ?>
                    
                  </div>
               <?php }?>

                 </form>
            </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>

<div class="modal fade" id="div_salary_slab" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="modal-title"> Add Pay Slab</h3>
			</div>
                        <form action="javascript:save();" id="frm_salary_structure" name="form" class="form-horizontal" method="post">
			<div class="modal-body form">
				
                            <div class="form-group">
                                <label class="control-label col-md-3">Designation</label>
                                <div class="col-md-8">
                                    <select class="form-control " id="designation_id" name="designation_id" required>
                                            <option value="0">Select </option>
                                            <?php foreach ($fetch_designation as $key=>$val) {
                                                ?>
                                                <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                                        <?php } ?>
                                        </select>
                                    <span class="help-block"><</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Slab Name</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="salary_group_name" name="salary_group_name" placeholder="Slab Name" value=''>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Applicable From</label>
                                <div class="col-md-8">
                                    <div class='input-group date' id='datetimepicker1'>
                                    <input type='month' class="form-control" id="applicable_from" name="applicable_from" value="" placeholder="xxxx-xx (e.g 2017-11)" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Salary Slab</label>
                                <div class="col-md-3" style="padding-right: 0px;">
                                    <input type="number" class="form-control" id="from_basic" name="from_basic" placeholder="From Basic" value=''>
                                </div>
                                <div class="col-md-1" style="width:0px"> - </div>
                                <div class="col-md-3" style="padding-left: 0px;">
                                    <input type="number" class="form-control" id="to_basic" name="to_basic" placeholder="To Basic" value=''>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Grade Pay</label>
                                <div class="col-md-8">
                                    <input type="number" class="form-control" id="grade_pay" name="grade_pay" placeholder="Grade Pay" value=''>
                                </div>
                                
                            </div>
                
         		</div> 
			<div class="modal-footer">
				<button type="button" id="btnSave" onclick="save()" class="btn btn-success">Save</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			</div>
                        </form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>



<script>

var globalid = '';
    $(function ()
    {
        var table=$('#salary_structure_list').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true
        });
         $('#searchhead th input').on('keyup change', function () {
//            if ( this.search() !== this.value ) {
//                this
//                    .search( this.value )
//                    .draw();
//            }
            var i = $(this).attr('data-column');
            var v = $(this).val();
            table.columns(i).search(v).draw();
        });

    });

	$('#add_salary_group').click(function() {

		save_method = 'add';
		$('#frm_salary_structure')[0].reset(); // reset form on modals
                $('#errmodal').empty();
		$('.form-group').removeClass('has-error'); // clear error class
		$('.help-block').empty(); // clear error string
		$('#div_salary_slab').modal('show'); // show bootstrap modal
		$('.modal-title').text('Add Pay Slab'); // Set Title to Bootstrap modal title
                $('select').trigger('change');

        });


    
    $('#salary_structure_list a').click(function ()
    {

        var idmain=this.id;
	$('#errmodal').empty();
	$('#frm_salary_structure')[0].reset();
	$('.form-group').removeClass('has-error'); // clear error class
	$('.help-block').empty(); // clear error string
        $.ajax({
                url : "<?php echo e(base_url());?>/<?=e(uri_string()) . '/getrec/'?>"+idmain,
                type: "POST",
                data: {id:idmain},
                dataType: "json",
                })
        .done(function( msg ) {
              //  console.log(msg);

                  var idx=msg[0].designation_id;          
                  $('#designation_id option').filter(function(){return this.value === idx }).prop('selected', true).trigger('change');
                  $('#salary_group_name').val(msg[0].salary_group_name);
                  $('#applicable_from').val(msg[0].applicable_from);
                  $('#from_basic').val(msg[0].from_basic);
                  $('#to_basic').val(msg[0].to_basic);
                  $('#grade_pay').val(msg[0].grade_pay);
                            
                })
        .fail(function(msg) {
                console.log(msg);
                });
	globalid = idmain;
	save_method = 'update';
	$('#div_salary_slab').modal('show'); // show bootstrap modal
	$('.modal-title').text('Update Pay Slab'); // Set Title to Bootstrap modal title
	return false;

           
    });
    


<?php //if(substr($right_access,3,1)=='D'){?>
    function deleteClass()
    {
        var r = confirm("Are you sure you want to delete this record?");
//                var id='1';
        if (r == true)
        {
            var class_id_string = [];
            var i = 0;
            $("input:checked").each(function ()
            {
                class_id_string[i] = $(this).attr("id");
                i++;
            });

//
            $.ajax({
                url: "<?php echo site_url('hr/settings/pay_scale/delete') ?>",
                type: "POST",
                data: {
                    class_id_string: class_id_string},
                dataType: "text",
                success: function (data)
                {
                    window.location.href = "<?php echo base_url('hr/settings/pay_scale'); ?>";
//                         
                },
                error: function (data, status)
                {
                    alert('e' + data + status);
                }});

        }
    }
    
<?php //}?>



function save() {

            if (save_method == 'add')
            {
                action_url = '<?php echo base_url('hr/settings/pay_scale/save'); ?>';
            }
            else
            {
                
                action_url = '<?php echo base_url('hr/settings/pay_scale/update'); ?>';
            }


            if (!$('#frm_salary_structure')[0].checkValidity())
            {
//                                                alert($('#add_stud_frm')[0].validationMessage);
                $(this).show();
                $('#frm_salary_structure')[0].reportValidity();
                return false;
            } else {

                var savestatus = confirm('Are you sure want to save');

                if (savestatus == true) {
                    $.ajax({
                        type: 'POST',
                        url: action_url,
                        data: $('#frm_salary_structure').serialize()+'&idmain='+globalid,
                        datatype: 'text',
                        success: function (data)
                        {
                            alert('saved successfully');
                            window.location.href = "<?php echo base_url('hr/settings/pay_scale'); ?>";
                        },
                        error: function (req, status)
                        {
                            alert('error while saving');
                        }
                    }); 
                }
            }

        };

</script>
