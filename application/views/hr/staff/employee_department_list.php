     
     
      <div class="form-group has-feedback">
        <div class="box">            
           <div class="box-header">
               <h3 class="box-title main_head"><u>Department List</u></h3>
            </div>
            <!-- /.box-header --> 
            
            
            
          <div class="box-body">
            <div class="col-lg-12">
              <div class="col-lg-12" style="text-align:right;"><button data-toggle="modal" data-target="#add_dept" class="btn btn-success" id="add_depart"> <i class="fa fa-plus-circle fa-lg"></i> Add Department</button></div>

            </div>
          </div>


            

            
            <div class="box-body">
            

              <form id='frmtemplate' role="form" method="POST">

                <table id="deptlist" class="table table-bordered table-striped">
                 <thead>
                        <tr>
                                        <th>Dept Id</th>
                                        
                                        <th><div>Department Name</div></th>
                                   
                                        <th><div>Actions</div></th>
                        </tr>
		</thead>
                  <tbody>
                  <?php 
              $count = 1;
              foreach($employee_department as $row):?>
               
                    <tr>
                        <td><?php echo $row->id;?> </td>
                      <td><?php echo $row->department_desc;?></td>                                         
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
                    <?php if(count($employee_department) > 0){?>              
                    <input type="button" class="btn btn-danger" id="dept" value="Delete" onclick="deleteClass();">
                    <?php }   ?>
                    
                  </div>
               

                 </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
        <div id="add_dept" class="modal fade" role="dialog">
                <div class="modal-dialog">

                  <!-- Modal content-->
                  <div class="modal-content">
                      <form action="<?php echo base_url('staff_management/employee_department/save')?>" method="post" id="manage_dept">
                          <div class="modal-header" id="modal_header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Add Department</h4>
                          </div>
                          <div class="modal-body" id="modal-body">
                             <div class="form-group">
                                              <label class="col-md-4">Department Name</label>
                                              <div class="col-md-7">
                                                  <input type="text" class="form-control" id="depart" name="depart" placeholder="Department Name"/>
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
            $('#deptlist').DataTable({
             "paging": true,
             "lengthChange": true,
             "searching": true,
             "ordering": true,
             "info": true,
             "autoWidth": true
           });
    
  });
  
//----------------------Edit operation-----------------------------
$('#deptlist a').click(function()
{   
    var department=$(this).closest('tr').find("td:nth-child(2)").text();
    var id=$(this).attr('id');
    var action_url='<?php echo base_url('staff_management/employee_department/update');?>'+'/'+id;
    $('#depart').val(department);
    $('#manage_dept').attr('action',action_url);
    $('#manage_dept .modal-title').text('Update Department');
    $('#add_dept').modal('show');
    
});




$('#add_dept').on('hidden.bs.modal',function(e) 
    {
            $('#depart').val('');
            $('#manage_dept').attr('action',"<?php echo site_url('staff_management/employee_department/save')?>");
            $('#manage_dept .modal-title').text('Add Department');
    });

//--------------------------------------------------------------------

  function deleteClass()
  {
                var r = confirm("Are you sure you want to delete this record?");
                var id;
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
                          url : "<?php echo site_url('staff_management/employee_department/delete')?>",
                          type: "POST",
                          data: {class_id_string:class_id_string},
                          dataType: "text",
                          success: function(data)
                          {
                               window.location.href = "<?php echo base_url('staff_management/employee_department');?>";
//                         
                          },
                          error : function(data,status)
                          {
                                alert('e'+data+status);
                      }});

                  }
  }


 





  

  
</script>




