
<div class="form-group has-feedback">
        <div class="box">

                <div class="box-header">
                    <h3 class="box-title main_head"> <u>Dormitory Report</u> </h3>
                </div>
                <div class="box-body">
                        <div class="col-lg-12" style="background:wheat;">
                         <ul class="nav nav-pills nav-justified">
                             <li class="active"><a data-toggle="pill" href="#dorm">Dormitory Report</a></li>
                             <li class=""><a data-toggle="pill" href="#room">Room Report</a></li>
                             <li class=""><a data-toggle="pill" href="#berth">Room's Berth Report</a></li>
                         </ul>
                            
                        </div>
                    
                </div>
                <div class="box-body">
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="dorm">
                                                <div class="col-sm-12 col-md-12" style="padding-top:1%">
                                                    <form id='frmdorm' role="form" method="POST">                            
                                                        <div class='col-sm-12'  style="padding:3%">
                                                         <label class="control-label col-md-2 col-sm-2">Dormitory Name</label>
                                                                <select class='chosen-select col-sm-3' id='dorm1'>
                                                                    <option value=''>Select Dormitory</option>
                                                                    <option value='0'>All</option>
                                                                    <?php foreach($dormitory as $row) { ?>
                                                                        <option value="<?php echo $row->id;?>" id='<?php echo $row->id;?>'><?php echo $row->dormitory_name;?> </option>
                                                                    <?php } ?>
                                                                </select>
                                                        </div>
                                                        
                                                        
                                                         <div class="col-sm-12 col-md-12" id="dorm_load" style="padding-top:2%">                                
                                                            <table id="drom_report" class="table table-bordered table-striped">
                                                            <thead>
                                                                    <tr>
                                                                                    <th>Id</th>
                                                                                    <th>Dormitory No</th>
                                                                                    <th>Dormitory Name</th>
                                                                                    <th>No of Rooms</th>
                                                                                    <th>Total Allocated</th>
                                                                                    <th>Total Available</th>
                                                                                    <th>Status</th>
                                                                      
                                                                    </tr>
                                                            </thead>
                                                              <tbody id="dorm_wise_report">
                                                
                                                              </tbody>
                                                            </table>
                                                </div>
                                                    </form>
                                            </div>
                            </div>
    
                            <div class="tab-pane fade" id="room">
                                
                                                    <div class="col-sm-12 col-md-12" style="padding-top:1%">
                                                      <form id='frmtemplate' role="form" method="POST">                                     
                                                       <div class="col-sm-12 col-md-12" style="padding-top:1%">         
                                                        <div class='col-sm-6'  style="padding:3%">
                                                         <label class="control-label col-md-4 col-sm-4">Dormitory</label>
                                                                <select class='col-sm-8' id='dormit'>
                                                                    <option value=''>Select Dormitory</option>
                                                                    <option value='0'>All</option>
                                                                    <?php foreach($dormitory as $row) { ?>
                                                                        <option value="<?php echo $row->id;?>"><?php echo $row->dormitory_name;?> </option>
                                                                    <?php } ?>
                                                                </select>
                                                        </div>
                                                                
                                                        <div class='col-sm-6'  style="padding:3%">
                                                         <label class="control-label col-md-4 col-sm-4">Room</label>
                                                         <div class="col-md-8" style='padding-bottom:1%' id="load_room1">
                                                                <select class='col-sm-12' id='room2'>
                                                                    <option value=''>Select Room</option>
                                                                    <option value='0'>All</option>
                                                                    <?php foreach($room as $row) { ?>
                                                                        <option value="<?php echo $row->id;?>"><?php echo $row->room_no;?> </option>
                                                                    <?php } ?>
                                                                </select>
                                                        </div>
                                                       </div>
                                                               
                                                            <div class="col-sm-12 col-md-12" id="room_load" style="padding-top:2%">      
                                                            <table id="room_report" class="table table-bordered table-striped">
                                                            <thead>
                                                                    <tr>
                                                                                    <th>Id</th>
                                                                                    <th>Dormitory No</th>
                                                                                    <th>Dormitory Name</th>
                                                                                    <th>Room No</th>
                                                                                    <th>Max Student Allowed</th>
                                                                                    <th>Total Allocated</th>
                                                                                    <th>Total Available</th>
                                                                                    <th>Status</th>
                                                                      
                                                                    </tr>
                                                            </thead>
                                                              <tbody id="room_wise_report">
                                                
                                                              </tbody>
                                                              <tfoot>
                                                              </tfoot>
                                                            </table>
                                                            </div>
                                                             </form>

                                                    </div> 
                            </div>
                            </div>
                            
    
                            <div class="tab-pane fade" id="berth">
                                                    <div class="col-sm-12 col-md-12" style="padding-top:1%">                                                       
                                                    <form id='frmtemplate' role="form" method="POST">                  
                                                    <div class="col-sm-12 col-md-12" style="padding-top:1%">         
                                                        <div class='col-sm-6'  style="padding:3%">
                                                         <label class="control-label col-md-4 col-sm-4">Dormitory</label>
                                                                <select class='form-control col-md-8 col-sm-8' id='dormitory'>
                                                                    <option value=''>Select Dormitory</option>
                                                                    <option value='0'>All</option>
                                                                    <?php foreach($dormitory as $row) {
                                                                        ?>
                                                                        <option value="<?php echo $row->id;?>"><?php echo $row->dormitory_name;?> </option>
                                                                    <?php } ?>
                                                                </select>
                                                        </div>
                                                                
                                                        <div class='col-sm-6'  style="padding:3%">
                                                         <label class="control-label col-md-4 col-sm-4">Room</label>
                                                         <div class="col-md-8" id="load_room2">
                                                                <select class='form-control col-sm-8' id='room1'>
                                                                    <option value=''>Select Room</option>
                                                                    <option value='0'>All</option>
                                                                    <?php foreach($room as $row) { ?>
                                                                        <option value="<?php echo $row->id;?>"><?php echo $row->room_no;?> </option>
                                                                    <?php } ?>
                                                                </select>
                                                         </div>
                                                        </div>
                                                       </div>

                                                        <div class="col-sm-12 col-md-12" id="berth_load" style="padding-top:2%"> 
                                                            <table id="berth_report" class="table table-bordered table-striped">
                                                            <thead>
                                                                    <tr>
                                                                                    <th>Id</th>
                                                                                    <th>Dormitory No</th>
                                                                                    <th>Dormitory Name</th>
                                                                                    <th>Room No</th>
                                                                                    <th>Berth No</th>
                                                                                    <th>Status</th>                                                  
                                                                    </tr>
                                                            </thead>
                                                              <tbody id="berth_wise_report">
                                                    
                                                              </tbody>
                                                              <tfoot>
                                                              </tfoot>
                                                            </table>
                                                        </div>
                                                             </form>            
                                                     </div> 
                            </div>
                            
                            
                            
                        </div>
                </div>
            
            </div>
        </div>


 <script type="text/javascript">
      
 $(function () 
  {
            $('#drom_report').DataTable({
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
    $('#dorm1').change(function(){
           var dorm_id=$(this).val();
//           alert(dorm_id);
           $.ajax({
               url:"<?php echo base_url('hostel/dorm_fetch');?>",
              type:"POST",
              data:{dormit:dorm_id},
              
              dataType:"text",
              success:function(data)
                {
//                    alert('hi');
                    $('#dorm_load').html(data);
                },
              error:function(req,status)
                {
                    alert('error');
                },
              
           });

        });
        
        
        $('#load_room1').on('change','#room_no',function()
        {
            var dorm=$('#dormit').val();
            var room_id=$('#room_no').val();
//            alert(room_id);
            
            $.ajax({
                type:"POST",
                data:{
                     room:room_id,
                     dorm_id:dorm,
                    },
                url:"<?php echo base_url('hostel/room_fetch'); ?>",
                dataType:"text",
                success:function(data)
                    {
//                        alert('hi');
                        $('#room_load').html(data);
                    },
                error:function(req,status)
                    {
                        alert('error');
                    },
            });
        });
        
        
        
       $('#dormit').change(function()
       {
           var dorm=$('#dormit').val();
           var room=$('#room2').val();
           
                $.ajax({
                        type:"POST",
                        data:{dorm_no:dorm,
                               room_no:room },
                        url:"<?php echo base_url('hostel/get_room1');?>",
                        dataType:"text",
                        success:function(data)
                                {
                                    $('#load_room1').html(data);
                                },
                        error:function(req,status)
                                {
                                    alert('error');
                                },
                                
                        });
       });  
       
       
       
      $('#dormitory').change(function()
       {
           var dorm=$('#dormitory').val();
           var room=$('#room1').val();
           
                $.ajax({
                        type:"POST",
                        data:{dorm_no:dorm,
                               room_no:room },
                        url:"<?php echo base_url('hostel/get_room1');?>",
                        dataType:"text",
                        success:function(data)
                                {
                                    $('#load_room2').html(data);
                                },
                        error:function(req,status)
                                {
                                    alert('error');
                                },
                                
                        });
       });
       
       
        
        
        $('#load_room2').on('change','#room_no',function()
        {
            var dorm=$('#dormitory').val();
            var room_id=$('#room_no').val();
            
            $.ajax({
                   type:"POST",
                   url:"<?php echo base_url('hostel/berth_fetch');?>",
                   data:{
                       dorm_id:dorm,
                       room:room_id,
                   },
                   dataType:"text",
                   success:function(data)
                        {
//                            alert(data);
                            $('#berth_load').html(data);
                        },
                   error:function(req,status)
                        {
                            alert('error');
                        },
            });
        });
    });     
            
 </script>