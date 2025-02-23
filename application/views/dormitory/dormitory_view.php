     <style>
div#modal-footer {
    margin-left: 250px!important;
}
</style>
     
      <div class="form-group has-feedback">
        <div class="box">            
           <div class="box-header">
               <h3 class="box-title main_head"><u>Dormitories</u></h3>
            </div>
            <!-- /.box-header --> 
            
            
            
          <div class="box-body">
            <div class="col-lg-12">
            <div class="col-lg-12" style="text-align:right;"><button data-toggle="modal" data-target="#div_add_dormitory" class="btn btn-success" id="add_dorm"> <i class="fa fa-plus-circle fa-lg"></i> Add Dormitory</button></div>

            </div>
          </div>


            

            
            <div class="box-body">           

              <form id='frmtemplate' role="form" method="POST">

                <table id="dormitory_list" class="table table-bordered table-striped">
                <thead>
                        <tr>
                                        <th>Id</th>
                                        <th>Dormitory No</th>
                                        <th>Dormitory Name</th>
                                        <th>Dormitory Type</th>
                                        <th>No. of Rooms</th>
                                        <th>Address</th>
                                        <th>Dormitory Contact No</th>
                                        <th>Warden</th>
                                        <th>Actions</th>
                        </tr>
		</thead>
                  <tbody>
                  <?php 
              $count = 1;
              foreach($fetch_dormitory as $row):?>
               
                    <tr>
                      <td><?php echo $row->id ;?> </td>
                      <td><?php echo $row->dormitory_no ;?> </td>
                      <td><?php echo $row->dormitory_name ;?></td>                                                                               
                      <td><?php echo $row->d_type ;?></td>                                                                               
                      <td><?php echo $row->no_of_rooms ;?></td>                                                                               
                      <td><?php echo $row->description ;?></td>                                                                               
                      <td><?php echo $row->contact ;?></td>                                                                               
                      <td><?php echo $row->warden;?></td>                                                                               
                      <td>
                          <div class="form-group row">
                              <div class="col-sm-1" style="line-height: 2;">
                                  <input type="checkbox" class="btn"  id="<?php echo $row->id; ?>">
                              </div>
                            <div class="col-sm-2">
                             <a class="btn" id="<?php echo $row->id;?>" onclick="edit(this,<?php echo $row->dorm_type_id;?> )">
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
                    <?php // if(count($fetch_dormitory) > 0){ ?>              
                    <input type="button" class="btn btn-danger" id="dorm_del" value="Delete" onclick="deleteClass();">
                    <?php // }   ?>
                    
                  </div>
               

                 </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
        <div id="div_add_dormitory" class="modal fade" role="dialog">
                <div class="modal-dialog">

                  <!-- Modal content-->
                  <div class="modal-content">
                      <form action="<?php echo base_url('Hostel/dormitory_list/save')?>" method="post" id="frm_dorm_add">
                          <div class="modal-header" id="modal_header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Add Dormitory</h4>
                          </div>
                          <div class="modal-body" id="modal-body" style="height:300px !important;">
                             <div class="form-group">
                                              <label class="col-md-4">Dormitory No</label>
                                              <div class="col-md-8" style='padding-bottom:1%'>
                                                  <input type="text" class="form-control" id="d_no" name="d_no" placeholder="Dormitory No." value=''>
                                              </div>
                            </div>
                            <div class="form-group">
                                              <label class="col-md-4">Dormitory Name</label>
                                              <div class="col-md-8" style='padding-bottom:1%'>
                                                  <input type="text" class="form-control" id="d_name" name="d_name" placeholder="Dormitory Name" value=''>
                                              </div>
                            </div>
                              
                            <div class="form-group">
                                              <label class="col-md-4">Dormitory Type</label>
                                              <div class="col-md-8" style='padding-bottom:1%'>
                                                  <select class="form-control chosen_select" name="dorm_type" id="dorm_type" val="">
                                                  <option value="">Select Dormitory Type</option>
                                                  <?php foreach($fetch_dorm_type as $row) { ?>
                                                      <option value="<?php echo $row->id; ?>"><?php echo $row->dorm_type; ?></option>           
                                                  <?php }?>
                                                        </select>
                                                  <!--<input type="text" class="form-control" id="d_type" name="d_type" placeholder="Dormitory Type" value=''>-->
                                              </div>
                            </div>
                              
                            <div class="form-group">
                                              <label class="col-md-4">No of Bed</label>
                                              <div class="col-md-8" style='padding-bottom:1%'>
                                                  <input type="number" class="form-control" id="room_no" name="room_no" placeholder="No of Rooms" value=''>
                                              </div>
                            </div>
                              
                            <div class="form-group">
                                              <label class="col-md-4">Address</label>
                                              <div class="col-md-8" style='padding-bottom:1%'>
                                                  <input type="text" class="form-control" id="address" name="address" placeholder="Address" value=''>
                                              </div>
                            </div>
                              
                            
                            <div class="form-group">
                                              <label class="col-md-4">Contact No</label>
                                              <div class="col-md-8" style='padding-bottom:1%'>
                                                  <input type="number" maxlength="10" class="form-control" id="contact" name="contact" placeholder="contact" value=''>
                                              </div>
                            </div>
                              
                            <div class="form-group">
                                              <label class="col-md-4">Warden</label>
                                              <div class="col-md-8" style='padding-bottom:1%'>
                                                  <input type="text" class="form-control" id="warden" name="warden" placeholder="warden" value=''>
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
            $('#dormitory_list').DataTable({
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
//$('#dormitory_list a').click(function()
function edit(me,type)
{   
    var dno=$(me).closest('tr').find("td:nth-child(2)").text();
    var dname=$(me).closest('tr').find("td:nth-child(3)").text();
    var d_type=$(me).closest('tr').find("td:nth-child(4)").text();
    var room=$(me).closest('tr').find("td:nth-child(5)").text();
    var add=$(me).closest('tr').find("td:nth-child(6)").text();
    var cont=$(me).closest('tr').find("td:nth-child(7)").text();
    var ward=$(me).closest('tr').find("td:nth-child(8)").text();
    alert(d_type);
    var id=$(this).attr('id');
//    alert(id);
    var action_url='<?php echo base_url('Hostel/dormitory_list/update');?>'+'/'+id;
    $('#d_no').val(dno);
    $('#d_name').val(dname);
    $('#room_no').val(room);
    $('#address').val(add);
    $('#dorm_type').val(type).prop('selected',true).trigger("chosen:updated");
    $('#contact').val(cont);
    $('#warden').val(ward);
    $('#frm_dorm_add').attr('action',action_url);
    $('#frm_dorm_add .modal-title').text('Update Dormitory');
    
    $('#div_add_dormitory').modal('show');
    
}
//--------------------------------------------------------------------

     $('#div_add_dormitory').on('hidden.bs.modal',function(e) 
    {
        var action_url='<?php echo site_url('Hostel/dormitory_list/save')?>';
//        alert(action_url);
            $('#d_no').val('');
            $('#d_name').val('');
            $('#room_no').val('');
            $('#desc').val('');
            $('#frm_dorm_add').attr('action',action_url);
            $('#frm_dorm_add .modal-title').text('Add Dormitory');
    });

    $('#btn_save').click(function()
    {
            var formdata=$('#frm_dorm_add').serialize();
            var action_url=$('#frm_dorm_add').attr('action');
//             alert(action_url);


        $.ajax
        ({
            type:'POST',
            data:formdata,
            url: action_url,
            datatype:"text",
            success: function(data)
            {
                window.location.href = '<?php echo base_url('Hostel/dormitory_list/');?>';

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
                          url : "<?php echo site_url('Hostel/dormitory_list/delete')?>",
                          type: "POST",
                          data: { 
                                    class_id_string:class_id_string },
                                    dataType: "text",
                          success: function(data)
                          {
                               window.location.href = "<?php echo base_url('Hostel/dormitory_list/');?>";
//                         
                          },
                          error : function(data,status)
                          {
                                alert('e'+data+status);
                          }});

                  }
  }


</script>




