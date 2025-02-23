<style>
div#modal-footer {
    margin-left: 250px!important;
}
</style>
      <div class="form-group has-feedback">
        <div class="box">            
           <div class="box-header">
               <h3 class="box-title main_head"><u>Dormitory Type</u></h3>
                 <button data-toggle="modal" data-target="#div_dormitory_type" class="btn btn-success" id="dorm_type"> <i class="fa fa-plus-circle fa-lg"></i>Add Dormitory Type</button>
            </div>
            <!-- /.box-header --> 
            
            
             <div class="box-header">
            <div class="col-lg-12">
            
            </div>
          </div>
         

            
            <div class="box-body">           

              <form id='frmtemplate' role="form" method="POST">

                <table id="dormitory_type" class="table table-bordered table-striped">
                <thead>
                        <tr>
                                        <th>Id</th>
                                        <th>Dormitory Type</th>
                                        <th>Actions</th>
                        </tr>
		</thead>
                  <tbody>
                  <?php 
              $count = 1;
              foreach($fetch_dorm_type as $row):?>
               
                    <tr>
                      <td><?php echo $row->id ;?> </td>
                      <td><?php echo $row->dorm_type;?> </td>                                                                              
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
                    <?php if(count($fetch_dorm_type) > 0){ ?>              
                    <input type="button" class="btn btn-danger" id="room_del" value="Delete" onclick="deleteClass();">
                    <?php } ?>
                    
                  </div>
               
  
                 </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
        <div id="div_dormitory_type" class="modal fade" role="dialog">
                <div class="modal-dialog">

                  <!-- Modal content-->
                  <div class="modal-content">
                      <form action="<?php echo base_url('Hostel/dormitory_type/save')?>" method="post" id="frm_dorm_type">
                          <div class="modal-header" id="modal_header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Add Dormitory Type</h4>
                          </div>
                          <div class="modal-body" id="modal-body">
                             <div class="form-group">
                                              <label class="col-md-4">Dormitory Type</label>
                                              <div class="col-md-8" style='padding-bottom:1%'> 
                                                  <input type="text" class="form-control" id="dorm_typ" name="dorm_typ" placeholder="Dormitory Type" value=''>
                                              </div>
                            </div>
                  
               

                          </div>
                          <!--<div class="modal-footer" id="modal-footer">-->
                            <div class="row" id="modal-footer">
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
            $('#dormitory_type').DataTable({
             "paging": true,
             "lengthChange": true,
             "searching": true,
             "ordering": true,
             "info": true,
             "autoWidth": true
           });
    
  });
  $(document).ready(function()
  {
      $('.chosen_select').chosen({width:"100%"});

    });
        
        
//----------------------Edit operation-----------------------------
$('#dormitory_type a').click(function()
{   
    var dorm_type1=$(this).closest('tr').find("td:nth-child(2)").text();
    var id=$(this).attr('id');
//    alert(dorm_type1);
    var action_url='<?php echo base_url('Hostel/dormitory_type/update');?>'+'/'+id;
    $('#dorm_typ').val(dorm_type1);
    $('#frm_dorm_type').attr('action',action_url);
    $('#frm_dorm_type .modal-title').text('Update Dormitory Type');
    $('#div_dormitory_type').modal('show');
    
});
//--------------------------------------------------------------------

     $('#div_dormitory_type').on('hidden.bs.modal',function(e) 
    {
        var action_url='<?php echo site_url('Hostel/dormitory_type/save')?>';
//        alert(action_url);
            $('#dorm_typ').val('');
            $('#frm_dorm_type').attr('action',action_url);
            $('#div_dormitory_type .modal-title').text('Add Dormitory Type');
    });

    $('#btn_save').click(function()
    {
            var formdata=$('#frm_dorm_type').serialize();
            var action_url=$('#frm_dorm_type').attr('action');
//             alert(action_url);


        $.ajax
        ({
            type:'POST',
            data:formdata,
            url: action_url,
            datatype:"text",
            success: function(data)
            {
                window.location.href = '<?php echo base_url('Hostel/dormitory_type/');?>';

            },
            error: function(data)
            {
                alert('error occured while saving'+data);
            }

        });

    });

  function deleteClass()
  {
                var r = confirm("Are you sure you want to delete this record?");
//                var id='1';
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
                          url : "<?php echo site_url('Hostel/dormitory_type/delete')?>",
                          type: "POST",
                          data: { 
                                    class_id_string:class_id_string },
                                    dataType: "text",
                          success: function(data)
                          {
                               window.location.href = "<?php echo base_url('Hostel/dormitory_type/');?>";
//                         
                          },
                          error : function(data,status)
                          {
                                alert('e'+data+status);
                          }});

                  } 
  }


</script>




