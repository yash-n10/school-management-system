    <div class="form-group has-feedback">
        <div class="box">            
            
          <div class="box-body">
              <div class="col-lg-12">
                  <div class="col-lg-12" style="text-align:right;">
            
              <button  class="btn btn-add" id="add_online_question" title="Add Question"> <i class="fa fa-plus-circle fa-lg"></i> </button>
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
                            <th style="border-bottom:0px">Class Code</th>
                            <th style="border-bottom:0px">Exam Name</th>
                            <th style="border-bottom:0px">Quest </th>
                            <th style="border-bottom:0px">Total Marks</th>
                            <th style="border-bottom:0px">Question</th>                                
                       		<th style="border-bottom:0px">Action</th>
                        </tr>
				</thead>
                <tbody>
                    <tr>
                        <td></td>                                         
                        <td></td>                                         
                        <td></td>                                         
                        <td></td>                                         
                        <td></td>                                   
                        <td></td>                                   
                        <td>
                            <div class="form-group row">
                              <div class="col-sm-2" >
                                  <a class="btn a-edit" id="" style="">
                              <i class="fa fa-eye"></i> ||<a class="btn a-edit" id="" style="padding-left: 0px;">
                              <i class="fa fa-edit"></i> 
                              </div>
                           <!--  <div class="col-sm-1">
                             <a class="btn a-edit" id="" style="padding-left: 0px;">
                              <i class="fa fa-edit"></i> 
                            </a>
                            </div>
 -->                          </div>
                            
                        </td>
                           
                    </tr>
                  </tbody>
                  <tfoot>
                  </tfoot>
                </table>
                    
                  </div>
               
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
                 $('#add_online_question').click(function()
                {
					window.location.href = "<?php echo base_url('academics/OnlineExam/OnlineExam/add');?>";
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
    
  });
  
//----------------------Edit operation-----------------------------
$('#employeelist a').click(function()
{   
    
    var id=$(this).attr('id');
    window.location.href = "<?php echo base_url('hr/staff/employees/edit');?>"+'/'+id;

});
//--------------------------------------------------------------------//
  
</script>




