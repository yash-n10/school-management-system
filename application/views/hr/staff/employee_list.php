    <div class="form-group has-feedback">
        <div class="box">            
            
          <div class="box-body">
              <div class="col-lg-12">
                  <div class="col-lg-12" style="text-align:right;">
              <?php if(substr($right_access,0,1)=='C'){?>
            
              <button  class="btn btn-add" id="add_employee" title="Add Employee"> <i class="fa fa-plus-circle fa-lg"></i> </button>

            
              <?php }?>
                <a class="btn btn-export" id="studexport" href='<?= base_url() . uri_string() ?>/exportcsv/All/All' download data-toggle="tooltip" data-placement="bottom" title="Export Employee">
                        <i class="fa fa-cloud-download fa-lg"></i>&nbsp;
                </a>

              <?php
                //if (!$read_only) {
                if(substr($right_access, 0,1)=='C' || substr($right_access, 2,1)=='U') {
                ?>
                <a class="btn btn-import" id="studimport" href='<?= base_url() . uri_string() ?>/importcsv'  data-toggle="tooltip" data-placement="bottom" title="Import Employee">
                        <i class="fa fa-cloud-upload fa-lg"></i>&nbsp;
                </a>
              <?php
}
?>
              </div>
              </div>
          </div>


            

            
            <div class="box-body">
              <form id='frmemployee' role="form" method="POST">
                  <div class="table-responsive">
                <table id="employeelist" class="table table-bordered table-striped">
                 <thead style="background:#99ceff;">
                        <tr>

                                        <th style="border-bottom:0px">#</th>
                                        <th style="border-bottom:0px">Employee Code</th>
                                        <th style="border-bottom:0px">Employee Name</th>
                                        <th style="border-bottom:0px">Employee Category</th>
                                        <th style="border-bottom:0px">Designation</th>
                                        <th style="border-bottom:0px">Department</th>
                                        <th style="border-bottom:0px">Leave Group</th>
                                        <th style="border-bottom:0px">Phone No.</th>
                                        <th style="border-bottom:0px">Email</th>
                                   
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
                        <th style="border-bottom:2px solid darkcyan;border-top:0px">
                            <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="5"/>
                        </th>
                        <th style="border-bottom:2px solid darkcyan;border-top:0px">
                            <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="6"/>
                        </th>
                        <th style="border-bottom:2px solid darkcyan;border-top:0px">
                            <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="7"/>
                        </th>
                        <th style="border-bottom:2px solid darkcyan;border-top:0px">
                            <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="8"/>
                        </th>

                        <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                    </tr>
                </thead>
                  <tbody>
                  <?php 
              $count = 1;foreach($employee as $row):?>
               
                    <tr>
                        <td><?php echo $row->id;?></td>                                         
                        <td><?php echo $row->employee_code;?></td>                                         
                        <td><?php echo $row->name;?></td>                                         
                        <td><?php echo $row->category_name;?></td>                                         
                        <td><?php echo $row->designation_name;?></td>                                         
                        <td><?php echo $row->department_name;?></td>                                         
                        <td><?php echo $row->leave_group;?></td>                                         
                        <td><?php echo $row->phone_no;?></td>                                         
                        <td><?php echo $row->email;?></td>                                         
                        <td>
                            <div class="form-group row">
                              <?php if(substr($right_access,3,1)=='D'){?>
                              <div class="col-sm-1" >
                                  <input type="checkbox" class="btn"  id="<?php echo $row->id; ?>">
                              </div>
                              <?php }if(substr($right_access,2,1)=='U'){?>
                            <div class="col-sm-2">
                             <a class="btn a-edit" id="<?php echo $row->id;?>" style="padding-left: 0px;">
                              <i class="fa fa-edit"></i> 
                            </a>
                            </div>
                              <?php }?>
                          </div>
                            
                        </td>
                           
                    </tr>
                 <?php endforeach;?>
                  </tbody>
                  <tfoot>
                  </tfoot>
                </table>

                <?php if(substr($right_access,3,1)=='D'){?>
                  <div class="box-body" style="text-align:right">
                    <?php if(count($employee) > 0){?>              
                    <input type="button" class="btn btn-danger" id="subjects" value="Delete" onclick="deleteEmployee();">
                    <?php }   ?>
                    
                  </div>
                <?php }?>
               
                  </div>
                 </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
        

<script>
var globalid = '';
var school_temp = '';
var newtxt = 1000;

  $(document).ready(function()
  {                     
                 $('#add_employee').click(function()
                {


                        window.location.href = "<?php echo base_url('hr/staff/employees/add');?>";

                });
                
                
  });

 

  $(function () 
  {
          var table =  $('#employeelist').DataTable({
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
$('#employeelist a').click(function()
{   
    
    var id=$(this).attr('id');
//   var action_url="<?php // echo base_url('hr/staff/employee/edit');?>"+'/'+id;
//    $.ajax
//    ({
//        type:'POST',
////        data:formdata,
//        url: action_url,
//        datatype:"text",
//        success: function(data)
//        {
//            window.location.href = '<?php // echo base_url('hr/staff/employee');?>';
//
//        },
//        error: function(data)
//        {
//            alert('error occured while saving'+data);
//        }
//
//    });
    window.location.href = "<?php echo base_url('hr/staff/employees/edit');?>"+'/'+id;
//    });
   
//     window.location.href = 
     
//     history.replaceState({}, null, "/staff_management/employee/edit");
     
});
//--------------------------------------------------------------------

  function deleteEmployee()
  {
                var r = confirm("Are you sure you want to delete this record?");
                var id;
                if(r == true)
                 {
                      var employee_id_string =[];
                      var i=0;
                      $("input:checked").each(function() {
                            employee_id_string[i]= $(this).attr("id");
                            i++;
                      });

//
                    $.ajax({
                          url : "<?php echo site_url('hr/staff/employees/delete')?>",
                          type: "POST",
                          data: {employee_id_string:employee_id_string},
                          dataType: "text",
                          success: function(data)
                          {
                               window.location.href = "<?php echo base_url('hr/staff/employees');?>";
//                         
                          },
                          error : function(data,status)
                          {
                                alert('e'+data+status);
                      }});

                  }
  }

  
</script>




