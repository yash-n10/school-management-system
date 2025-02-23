     
     
      <div class="form-group has-feedback">
        <div class="box">            
           <div class="box-header">
               <h3 class="box-title main_head"><u>Designation List</u></h3>
            </div>
            <!-- /.box-header --> 
            
            
            
          <div class="box-body">
            <div class="col-lg-12">
              <div class="col-lg-12" style="text-align:right;"><button data-toggle="modal" data-target="#add_post" class="btn btn-success" id="add_design"> <i class="fa fa-plus-circle fa-lg"></i> Add Designation</button></div>

            </div>
          </div>


            

            
            <div class="box-body">
            

              <form id='frmtemplate' role="form" method="POST">

                <table id="postlist" class="table table-bordered table-striped">
                 <thead>
                        <tr>
                                        <th>Designation Id</th>
                                        <th><div>Designation</div></th>
                                   
                                        <th><div>Actions</div></th>
                        </tr>
		</thead>
                  <tbody>
                  <?php 
              $count = 1;
              foreach($employee_designation as $row):?>
               
                    <tr>
                        <td><?php echo $row->id; ?></td>
                      <td><?php echo $row->designation_desc;?></td>                                         
                      <td>
                          <div class="form-group row">
                              <div class="col-sm-1" style="line-height: 2;">
                                  <input type="checkbox" class="btn"  id="<?php echo $row->id; ?>">
                              </div>
                            <div class="col-sm-2">
                             <a class="btn" id="<?php echo $row->id;?>">
                              <i class="fa fa-edit"></i> Edit
                             </a>
                            </div>
                          </div>
                      </td>
                           
                    </tr>
                 <?php endforeach;?>
                  </tbody>
                  <tfoot>
                  </tfoot>
                </table>

                
                  <div class="box-body" style="text-align:right">
                    <?php if(count($employee_designation) > 0){?>              
                    <input type="button" class="btn btn-danger" id="subjects" value="Delete" onclick="deleteClass();">
                    <?php }   ?>
                    
                  </div>
               

                 </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
        <div id="add_post" class="modal fade" role="dialog">
                <div class="modal-dialog">

                  <!-- Modal content-->
                  <div class="modal-content">
                      <form action="<?php echo base_url('staff_management/employee_designation/save')?>" method="post" id="manage_post">
                          <div class="modal-header" id="modal_header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Add Designation</h4>
                          </div>
                          <div class="modal-body" id="modal-body">
                             <div class="form-group">
                                              <label class="col-md-3">Designation</label>
                                              <div class="col-md-8">
                                                  <input type="text" class="form-control" id="post" name="post" placeholder="Designation"/>
                                              </div>
                            </div>
                          </div>
                          <!--<div class="modal-footer" id="modal-footer">-->
                            <div class="row" id="modal-footer">
                                <button type="submit" class="btn btn-success" id="btn_save">Save</button>
                            </div>
                      </form>
                    <!--</div>-->
                  </div>

                </div>
        </div>

<script>

  $(function () 
  {
            $('#postlist').DataTable({
             "paging": true,
             "lengthChange": true,
             "searching": true,
             "ordering": true,
             "info": true,
             "autoWidth": true
           });
    
  });
  
//----------------------Edit operation-----------------------------
$('#postlist a').click(function()
{   
    var post=$(this).closest('tr').find("td:nth-child(2)").text();
    var id=$(this).attr('id');
    var action_url='<?php echo base_url('staff_management/employee_designation/update');?>'+'/'+id;
    $('#post').val(post);
    $('#manage_post').attr('action',action_url);
    $('#manage_post .modal-title').text('Update Designation');
    $('#add_post').modal('show');
    
});


$('#add_post').on('hidden.bs.modal',function(e) 
    {
            $('#post').val('');
            $('#manage_post').attr('action',"<?php echo site_url('staff_management/employee_designation/save')?>");
            $('#manage_post .modal-title').text('Add Designation');
    });



//--------------------------------------------------------------------

  function deleteClass()
  {
                var r = confirm("Are you sure you want to delete this record?");
//                var id;
                if(r == true)
                 {
                      var class_id_string =[];
                      var i=0;
                      $("input:checked").each(function () 
                      {
                            class_id_string[i]= $(this).attr("id");
                            i++;
                      });

//
                    $.ajax({
                          url : "<?php echo site_url('staff_management/employee_designation/delete')?>",
                          type: "POST",
                          data: {class_id_string:class_id_string},
                          dataType: "text",
                          success: function(data)
                          {
                               window.location.href = "<?php echo base_url('staff_management/employee_designation');?>";
//                         
                          },
                          error : function(data,status)
                          {
                                alert('e'+data+status);
                      }});

                  }
  }


 





  

  
</script>
