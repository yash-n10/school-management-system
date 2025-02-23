     
     
      <div class="form-group has-feedback">
        <div class="box">            
           <div class="box-header">
               <h3 class="box-title main_head"><u>Rooms</u></h3>
            </div>
            <!-- /.box-header --> 
            
            
            
          <div class="box-body">
            <div class="col-lg-12">
            <div class="col-lg-12" style="text-align:right;"><button data-toggle="modal" data-target="#div_add_room" class="btn btn-success" id="add_room"> <i class="fa fa-plus-circle fa-lg"></i> Add Room</button></div>

            </div>
          </div>


            

            
            <div class="box-body">           

              <form id='frmtemplate' role="form" method="POST">

                <table id="room_list" class="table table-bordered table-striped">
                <thead>
                        <tr>
                                        <th>Id</th>
                                        <th>Room No</th>
                                        <th>Dormitory Name</th>
                                        <th>Max Student Allocated </th>
                                        <th>Amount Per Student</th>
                                        <th>Description</th>
                                        <th>Actions</th>
                        </tr>
		</thead>
                  <tbody>
                  <?php 
              $count = 1;
              foreach($fetch_room as $row):?>
               
                    <tr>
                      <td><?php echo $row->id ;?> </td>
                      <td><?php echo $row->room_no ;?> </td>
                      <td><?php echo $row->dorm_name ;?></td>                                                                               
                      <td><?php echo $row->max_student ;?></td>                                                                                                                                                             
                      <td><?php echo $row->amount ;?></td>                                                                               
                      <td><?php echo $row->description ;?></td>                                                                               
                      <td>
                          <div class="form-group row">
                              <div class="col-sm-1" style="line-height: 2;">
                                  <input type="checkbox" class="btn"  id="<?php echo $row->id; ?>">
                              </div>
                            <div class="col-sm-2">
                             <a class="btn" id="<?php echo $row->id;?>" onclick="edit(this,<?php echo $row->dorm_id;?> )">
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
                    <?php if(count($fetch_room) > 0){ ?>              
                    <input type="button" class="btn btn-danger" id="dorm_del" value="Delete" onclick="deleteClass();">
                    <?php }   ?>
                    
                  </div>
               

                 </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
        <div id="div_add_room" class="modal fade" role="dialog">
                <div class="modal-dialog">

                  <!-- Modal content-->
                  <div class="modal-content">
                      <form action="<?php echo base_url('Hostel/room_list/save')?>" method="post" id="frm_room_add">
                          <div class="modal-header" id="modal_header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Add Room</h4>
                          </div>
                          <div class="modal-body" id="modal-body">
                              
                            <div class="form-group">
                                              <label class="col-md-4">Dormitory Name</label>
                                              <div class="col-md-8" style='padding-bottom:1%'>
                                                  <select class="form-control chosen_select dropdown" name="dorm_name" id="dorm_name" val="">
                                                  <option value="">Select Dormitory Name</option>
                                                  <?php foreach($fetch_dorm as $row) { ?>
                                                      <option value="<?php echo $row->id; ?>"><?php echo $row->dormitory_name; ?></option>           
                                                  <?php }?>
                                                        </select>
                                                  <!--<input type="text" class="form-control" id="dorm_name" name="dorm_name" placeholder="Dormitory Name" value=''>-->
                                              </div>
                            </div>
 
                             <div class="form-group">
                                              <label class="col-md-4">Room No</label>
                                              <div class="col-md-8" style='padding-bottom:1%'>
                                                  <input type="text" class="form-control" id="room_cnt" name="room_cnt" placeholder="Room No." value=''>
                                              </div>
                            </div>
                          
                              
                            <div class="form-group">
                                              <label class="col-md-4">Max Student Allowed</label>
                                              <div class="col-md-8" style='padding-bottom:1%'>
                                                  <input type="text" class="form-control" id="student" name="student" placeholder="Max Student Allowed" value=''>
                                              </div>
                            </div>

                              
                              <div class="form-group">
                                <label class="col-md-4">Amount Per Student</label>
                                <div class="col-md-8" style='padding-bottom:1%'>
                                    <input type="text" class="form-control" id="amt" name="amt" placeholder="Amount" value=''>
                                </div>
                              </div>
                              
                            <div class="form-group">
                                <label class="col-md-4">Description</label>
                                <div class="col-md-8" style='padding-bottom:1%'>
                                    <input type="text" class="form-control" id="desc" name="desc" placeholder="Description" value=''>
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
            $('#room_list').DataTable({
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

        });
        
        
//----------------------Edit operation-----------------------------
function edit(me,room_id)
{
//$('#room_list a').click(function()
//{   
    var room_no=$(me).closest('tr').find("td:nth-child(2)").text();
//    var dorm_name=$(me).closest('tr').find("td:nth-child(3)").text();
//    alert(dorm_name);
    var stud=$(me).closest('tr').find("td:nth-child(4)").text();
    var amnt=$(me).closest('tr').find("td:nth-child(5)").text();
    var desc=$(me).closest('tr').find("td:nth-child(6)").text();
//    alert(category);
    var id=$(me).attr('id');
//    alert(id);
    var action_url='<?php echo base_url('Hostel/room_list/update');?>'+'/'+id;
    $('#room_cnt').val(room_no);
    $('#dorm_name').val(room_id).prop('selected',true).trigger("chosen:updated");
    $('#student').val(stud);
    $('#amt').val(amnt);
    $('#desc').val(desc);
    $('#frm_room_add').attr('action',action_url);
    $('#frm_room_add .modal-title').text('Update Room');
    
    $('#div_add_room').modal('show');
    
//});
}
//--------------------------------------------------------------------

     $('#div_add_room').on('hidden.bs.modal',function(e) 
    {
        var action_url='<?php echo site_url('Hostel/room_list/save')?>';
//        alert(action_url);
            $('#room_cnt').val('');
            $('#dorm_name').val('');
            $('#student').val('');
            $('#amt').val('');
            $('#desc').val('');
            $('#frm_room_add').attr('action',action_url);
            $('#frm_room_add .modal-title').text('Add Room');
    });

    $('#btn_save').click(function()
    {
            var formdata=$('#frm_room_add').serialize();
            var action_url=$('#frm_room_add').attr('action');
//             alert(action_url);


        $.ajax
        ({
            type:'POST',
            data:formdata,
            url: action_url,
            datatype:"text",
            success: function(data)
            {
                window.location.href = '<?php echo base_url('Hostel/room_list');?>';

            },
            error: function(data)
            {
                alert('error occured while saving'+data);
            }

        });

    });
    
    
    $('#room_cnt').change(function()
    {
        var dorm=$('#dorm_name').val();
//        alert(dorm);
        
        $.ajax({
                type:"POST",
                data:{dorm_id:dorm,},
                url:"<?php echo base_url('hostel/count_room');?>",
                dataType:"text",
                success:function(data)
                        {
                            if(data==1)
                            {
                                return true;
                            }
                            
                            else
                            {
                                alert('All Rooms Are Occupied');
                                $('#btn_save').attr('disabled',true);
                            }
                        },
                error:function()
                        {
                            alert('error');
                        },
            
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
                          url : "<?php echo site_url('Hostel/room_list/delete')?>",
                          type: "POST",
                          data: { 
                                    class_id_string:class_id_string },
                                    dataType: "text",
                          success: function(data)
                          {
                               window.location.href = "<?php echo base_url('Hostel/room_list/');?>";
//                         
                          },
                          error : function(data,status)
                          {
                                alert('e'+data+status);
                          }});

                  }
  }


</script>




