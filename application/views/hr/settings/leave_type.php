 <div class="form-group has-feedback">
        <div class="box">            

            <!-- /.box-header --> 
            
            
            
          <div class="box-body">
              <?php if(substr($right_access,0,1)=='C'){?>
            <div class="col-lg-12">
              <div class="col-lg-12" style="text-align:right;"><button data-toggle="modal" data-target="#div_leave_type" class="btn btn-add" id="add_leave_type" title="Add Leave Type"> <i class="fa fa-plus-circle fa-lg"></i> </button></div>
              
            </div>
              <?php }?>
          </div>


            

            
            <div class="box-body">
            

              <form id='frmtemplate' role="form" method="POST">
                  <div class="table-responsive">
                <table id="leavetypelist" class="table table-bordered table-striped">
                <thead style="background:#99ceff;"> 
                        <tr>
                                        <th style="border-bottom:0px">#</th>
                                        <th style="border-bottom:0px">Leave Code</th>
                                        <th style="border-bottom:0px">Leave Description</th>
                                        <th style="border-bottom:0px">Loss Of Pay</th>
                                        <th style="border-bottom:0px">Half days Allow</th>
                                        <th style="border-bottom:0px">Action</th>
                        </tr>
		</thead>
                <thead style="background: #cce6ff">
                    <tr id="searchhead">
                       
                        <th style="border-bottom:2px solid darkcyan;border-top:0px">
                            <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="0"/>
                        </th>
                        <th style="border-bottom:2px solid darkcyan;border-top:0px">
                            <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="1"/>
                        </th>
                        <th style="border-bottom:2px solid darkcyan;border-top:0px">
                            <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="2"/>
                        </th>
                        <th style="border-bottom:2px solid darkcyan;border-top:0px">
                            <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="3"/>
                        </th>
                        <th style="border-bottom:2px solid darkcyan;border-top:0px">
                            <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="4"/>
                        </th>

                        <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                    </tr>
                </thead>
                  <tbody>
                  <?php 
              $count = 1;
              foreach($fetch_leave as $row):?>
               
                    <tr>
                      <td><?php echo $row->id;?> </td>
                      <td><?php echo $row->leave_type_code;?></td>                                         
                      <td><?php echo $row->leave_type_name;?></td>                                         
                      <td><?php echo $row->loss_of_pay;?></td>                                         
                      <!--<td <?php // if($row->status==1){?> style="color:green;font-weight:bolder"<?php // } else{ ?> style="color:red;font-weight:bolder"<?php // } ?>><?php // if($row->status==1){echo 'Active' ;}else{echo 'InActive' ;}?></td>-->                                         
                      <td><?php echo $row->half_days_allow;?></td>                                         
                      <td>
                          <div class="form-group row">
                              <?php if(substr($right_access,3,1)=='D'){?>
                                <div class="col-sm-1" >
                                    <input type="checkbox" class="btn"  id="<?php echo $row->id; ?>">
                                </div>
                              <?php } if(substr($right_access,2,1)=='U'){?>
                                <div class="col-sm-2">
                                 <a class="btn a-edit" id="<?php echo $row->id;?>">
                                  <i class="fa fa-edit"></i> 
                                </a>
                                </div>
                              <?php } ?>
                          </div>
                      </td>
                           
                    </tr>
                 <?php endforeach;?>
                  </tbody>
                  <tfoot>
                  </tfoot>
                </table>
                  </div>
                <?php if(substr($right_access,3,1)=='D'){?>
                  <div class="box-body" style="text-align:right">
                    <?php if(count($fetch_leave) > 0){?>              
                    <input type="button" class="btn btn-danger" id="emp_cats" value="Delete" onclick="deleteLeavetype();">
                    <?php }   ?>
                    
                  </div>
                <?php }?>
               

                 </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>

        <div id="div_leave_type" class="modal fade" role="dialog">
                <div class="modal-dialog">

                  <!-- Modal content-->
                  <div class="modal-content">
                      <form action="<?php echo base_url('hr/settings/leave_type/save')?>" method="post" id="frmleavetype" class="form-horizontal">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h3 class="modal-title">Add Leave Type</h3>
                          </div>
                          <div class="modal-body form">
                              <div class="form-body">
                                    <div class="form-group">
                                                     <label class="control-label col-md-4">Leave Code </label>
                                                     <div class="col-md-8">
                                                         <input type="text" class="form-control" id="leave_type_code" name="leave_type_code" placeholder="Code" required/>
                                                     </div>
                                   </div>
                                    <div class="form-group">
                                                     <label class="control-label col-md-4">Leave Description </label>
                                                     <div class="col-md-8" >
                                                         <input type="text" class="form-control" id="leave_type_name" name="leave_type_name" placeholder="Name" required/>
                                                     </div>
                                   </div>
                                    <div class="form-group">
                                                     <label class="control-label col-md-4">Loss Of Pay</label>
                                                     <div class="col-md-8">
                                                         <select class="form-control" name="loss_of_pay" id="loss_of_pay" required="">
                                                             <option value="NO">NO</option>
                                                             <option value="YES">YES</option>
                                                         </select>
                                                     </div>
                                   </div>
                                   <div class="form-group">
                                                     <label class="control-label col-md-4">Half Days Allow </label>
                                                     <div class="col-md-8">
                                                         <label class="radio-inline"><input type="radio" name="half_days_allow" id="half_days_allow" value="Y">Yes</label>
                                                         <label class="radio-inline"><input type="radio" name="half_days_allow" checked="checked" id="half_days_allow" value="N">No</label>
                                                     </div>
                                   </div>
                              </div>
                          </div>
                          <!--<div class="modal-footer" id="modal-footer">-->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" id="btn_save">Save</button>
                            </div>
                      </form>
                    <!--</div>-->
                  </div>

                </div>
        </div>

<script>
  $(function () 
  {
            var table=$('#leavetypelist').DataTable({
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
  
//----------------------Edit operation-----------------------------
$('#leavetypelist a').click(function()
{   
    
            var code=$(this).closest('tr').find("td:nth-child(2)").text();
            var name=$(this).closest('tr').find("td:nth-child(3)").text();
            var lossstatus=$(this).closest('tr').find("td:nth-child(4)").text();
            var status=$(this).closest('tr').find("td:nth-child(5)").text();
            if(status=='Active')
            {
                var stat=1;
            }
            else{
                var stat=2;
            }
            var half_day_allow=$(this).closest('tr').find("td:nth-child(5)").text();
            var id=$(this).attr('id');
            var action_url='<?php echo base_url('hr/settings/leave_type/update');?>'+'/'+id;
            $('#leave_type_code').val(code);
            $('#leave_type_name').val(name);
            $('#status').val(stat).prop("selected",true);
            $('#loss_of_pay').val(lossstatus).prop("selected",true);
            $('input[name=half_days_allow][value=' + half_day_allow + ']').prop("checked", true);
            $('#frmleavetype').attr('action',action_url);
            $('#frmleavetype .modal-title').text('Update Leave Type');

            $('#div_leave_type').modal('show');
//            alert($('#half_days_allow').val());
            
            
    
});
//--------------------------------------------------------------------
    $('#div_leave_type').on('hidden.bs.modal',function(e) 
    {
            $('#leave_type_code').val('');
            $('#leave_type_name').val('');
            $('#status').val('').prop("selected",true);
            $('#loss_of_pay').val('NO').prop("selected",true);
            $('input[name=half_days_allow][value="N"]').prop("checked", true);
            $('#frmleavetype').attr('action',"<?php echo site_url('hr/settings/leave_type/save')?>");
            $('#frmleavetype .modal-title').text('Add Leave Type');
    });


    $('#btn_save').click(function()
    {
            var formdata=$('#frmleavetype').serialize();
            var action_url=$('#frmleavetype').attr('action');
//             alert(formdata);
            if(!$('#frmleavetype')[0].checkValidity())
            {
        //                                                alert($('#add_stud_frm')[0].validationMessage);
                $(this).show();
                $('#frmleavetype')[0].reportValidity();
                                            return false;
            }
            else{

                $.ajax
                ({
                    type:'POST',
                    data:formdata,
                    url: action_url,
                    datatype:"text",
                    success: function(data)
                    {
                        window.location.href = '<?php echo base_url('hr/settings/leave_type');?>';

                    },
                    error: function(data)
                    {
                        alert('error occured while saving'+data);
                    }

                });
            }

    });










  function deleteLeavetype()
  {
                var r = confirm("Are you sure you want to delete this record?");
//                var id='1';
                if(r == true)
                 {
                      var leave_type_id_string =[];
                      var i=0;
                      $("input:checked").each(function () 
                      {
                            leave_type_id_string[i]= $(this).attr("id");
                            i++;
                      });

//
                    $.ajax({
                          url : "<?php echo site_url('hr/settings/leave_type/delete')?>",
                          type: "POST",
                          data: {leave_type_id_string:leave_type_id_string},
                          dataType: "text",
                          success: function(data)
                          {
                               window.location.href = "<?php echo base_url('hr/settings/leave_type');?>";
//                         
                          },
                          error : function(data,status)
                          {
                                alert('e'+data+status);
                      }});

                  }
  }

</script>
