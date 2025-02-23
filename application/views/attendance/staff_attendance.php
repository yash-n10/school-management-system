     			<div class="box-body">                
                 	<div class="tab-content">
                      	<div class="tab-pane fade in active" id="staff_attend">
                             <div class="row">
                                <form id="staff_attendance" name="staff_attendance" method="POST">
                                    <div class="col-md-12" style="padding-left:25px; padding-right:25px;">
                                        <div class="panel panel-default">
                                            <div class="heading">
                                             <h4 class="" style="color:teal; padding-left:20px; padding-top:10px;"> Attendance </h4>
                                            </div>
                                            <hr>                                                                          
                                                                  
                                            <div class="panel-body">
												<div class="col-sm-1 form-group">
													<label for="">Date</label>
												</div>
												<div class='col-sm-4 input-group date' id='datetimepicker1'>
													<input type='date' class="form-control" id="attendance_date_staff" name="attendance_date_staff" value="">
												</div>
                                            </div>
                                                                  
                                            <div class="row">
                                                <div class="" style="float:right; padding-right:20px; margin-bottom:20px;">
                                                    <span><input type="button" class="btn btn-success" value="Capture Attendance" id="manage_staff_attendance">  </span>
                                                    <span><input type="button" class="btn btn-info" value="Edit/View Attendance" id="view_staff_attendance"></span>
                                                </div>
                                            </div>                
                                        </div>
                                    </div>
                                         
                                         
                                    <div class="col-md-12" style="padding-left:25px; padding-right:25px;">
                                        <div class="panel panel-default">
                                            <div class="heading">
                                                <h4 class="" style="color:teal; padding-left:20px; padding-top:10px;">Mark Attendance </h4>
                                                <hr>
                                                 
                                                <div class="panel-body" id="div_upload_staff">
                                                    <div class="row" style="padding:10px;">
	                                                    <table id="staff_att" class="table table-bordered table-stripped">
	                                                        <thead>
	                                                            <tr style="background-color:#dcedc8;">
	                                                            <th> SNo</th>
	                                                            <th> Employee Code</th>
	                                                            <th> Employee Name</th>
	                                                            <th> Attendance</th>
	                                                            <th> Remarks</th>                                            
	                                                            </tr>
	                                                        </thead>
	                                                    </table> 
                                                	</div>
                                                </div>                                                         
                                            </div>
                                        </div>
										<div class="col-lg-12"  style="text-align: center;">
											<input type="button" class="btn btn-success" id="save_staff_attendance" value="Save Attendance"> 
											<input type="button" class="btn btn-success" id="update_staff_attendance" value="Update Attendance"> 
										</div>
                                    </div>
                                </form>
                            </div>
                      	</div>
                 	</div>
     			</div>
           


<script>
$('#update_staff_attendance').hide();
$(document).ready(function()
{
    $('#manage_staff_attendance').click(function()
    {
        var task='add';
        fetch(task);
    });
    
    $('#view_staff_attendance').click(function()
    {
        var task='edit';
        fetch(task);
    });
        
        function fetch(task)
        {

            var date=$('#attendance_date_staff').val();

            if(!Date.parse(date))
            {
            alert('Please select Date'); 
            }
                
            else if(task=='add')
            {
                $('#update_staff_attendance').hide();
                $('#save_staff_attendance').show();  
                                
                $.ajax({
					type:'POST',
					data:{
						task:task,
						date:date,
					},
					url:'<?php echo base_url('attendance/staff_attendance/validate_staff_attendance')?>',
					datatype:'text',
					success:function(data)
                    {
                        if(data==1)
                        {                            
	                        alert('Attendance already captured for selected date.');
	                        $('#save_staff_attendance').attr('disabled',true);
	                        $('#div_upload_staff').html('');
                        }
                        
                        else
                        {
                            $('#save_staff_attendance').attr('disabled',false);
                        	$.ajax({
                                type:'POST',
                                url:'<?php echo base_url('attendance/staff_attendance/load_staff');?>',
                                data:
                                {
                                    task:task,
                                    date:date,
                                },
                                datatype:'text',
                                success:function(data)
                                {
                                    $('#div_upload_staff').html(data);
                                },
                                error:function(req,status)
                                {
                                    alert('error while loading');
                                },

                            });
                        }
                    }
                });
    		} 
    		else
            {
             
				$('#update_staff_attendance').show();
				$('#save_staff_attendance').hide();
                $.ajax({ 
                    type:'POST',
                    url:'<?php echo base_url('attendance/staff_attendance/load_staff');?>',
                    data:
                    {
                        task:task,
                        date:date,
                    },
                    datatype:'text',
                    success:function(data)
                    {
                    	//console.log(data);
                        $('#div_upload_staff').html(data);
                    },
                    error:function(req,status)
                    {
                        alert('error while loading');
                    },

             	});
            }
		}

//        



        $('#save_staff_attendance').click(function()
        {
            var date=$('#attendance_date_staff').val();
            
            if(!Date.parse(date))
            {
            	alert('Please select Date'); 
            }
            else
            {
            	$.ajax({
                    type:'POST',
                    url:"<?php echo base_url('attendance/staff_attendance/save_staff_attendance');?>",
                    data:$('#staff_attendance').serialize(),
                    datatype:'text',
                    success:function(data)
                    {
                    	//console.log(data);
                       	alert('Attendance saved successfully');
                        window.location.reload();
                    },
                    /*error:function(req,status)
                    {
                        alert('error while saving');
                    }*/
              });
            }
        });
        
        
       $('#update_staff_attendance').click(function()
        {
                $.ajax({
                    type:'POST',
                    url:"<?php echo base_url('attendance/staff_attendance/update_staff_attendance');?>",
                    data:$('#staff_attendance').serialize(),
                    datatype:'text',
                    success:function(data)
                    {
                        alert('Attendance updated successfully');
                        window.location.reload();
                    },
                    error:function(req,status)
                    {
                        alert('error while updating');
                    }
              });
            
       });
            
});

</script>
