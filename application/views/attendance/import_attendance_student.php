<div class="box-body">
	<div class="tab-content">
		<div class="tab-pane fade in active" id="stud_attend">
			<div class="row">
				<form id="form_attendance" name="form_attendance" method="POST" action='<?php echo base_url('attendance/student_attendance/import_csv_attendnce');?>' enctype='multipart/form-data'>
					<div class="col-md-12" style="padding-left:25px; padding-right:25px;">
						<div class="panel panel-default">
							<div class="heading">
                                <h4 class="" style="color:teal; padding-left:20px; padding-top:10px;">Import Student Attendance 
                                <input type="text" style="margin-left: 50px;" name="year" id="year" placeholder="Year" value='2019' readonly>
                                <!-- <input type="hidden" style="margin-left: 50px;" name="year" id="year" placeholder="Year" value='<?php echo date('Y'); ?>' readonly> -->
                                </h4>
                             <!-- <select name="year" id="year">
                                    <option value="2019">2019</option>
                                    <option value="2020">2020</option>
                                </select> -->
                            </div> 

                            <hr>
							<div class="panel-body">
                                            <div class="col-sm-1 form-group"> <label for="">Class</label></div>
                                            <div class="col-sm-2 form-group">
                                                <select class="form-control" id="cls" name="cls"> 
                                                    <option value="0">Select Class </option>
                                                    <?php foreach($class as $cls){ ?>
                                                    <option value="<?php echo $cls->id; ?>"> <?php echo $cls->class_name; ?></option>
                                                    <?php }  ?>
                                                </select>
                                            </div>
                                                 
                                            <div class="col-sm-1 form-group"><label for="">Section</label></div>
                                            <div class="col-sm-2 form-group">
                                                <select class="form-control" id="sec" name="sec"> <option value="0">Select Section </option>
                                                <?php foreach($classsection as $sec){ ?>
                                                <option value="<?php echo $sec->id; ?>"> <?php echo $sec->sec_name; ?></option>
                                                    <?php }  ?>
                                                </select>
                                            </div>
                                                 
                                                 
                                            <div class="col-sm-1 form-group"> <label for="">Month</label></div>
                                            <div class="col-sm-2 form-group">
                                                <select class="form-control" id="mon" name="mon"> 
                                                    <option value="0">Select Month </option>          
                                                    <option value="4">April</option>
                                                    <option value="5" >May</option>
                                                    <option value="6">June</option>
                                                    <option value="7" >July</option>
                                                    <option value="8">August </option>
                                                    <option value="9">September</option>
                                                    <option value="10">October</option>
                                                    <option value="11">November</option>
                                                    <option value="12">December</option>
                                                    <option value="1">January</option>
                                                    <option value="2">February</option>
                                                    <option value="3">March</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3" style="float:right; padding-right:20px; margin-bottom:20px;">
                                        <input type="button" class="btn btn-info" id="get_report" value="GET FORMAT" style="float:right;  margin-top:10px;">

                                            </div>
                                           
                            </div>
                        

						</div>
					</div>
                             <div class="col-lg-8 col-lg-offset-2" id="successMessage" <?php if ($this->session->flashdata('Success')) { ?> style="padding: 10px 20px;background: #CCF5CC;text-align:center" <?php } ?>> <?php echo $this->session->flashdata('Success'); ?></div>            
					<div class="col-md-12" style="padding-left:25px; padding-right:25px;">
						<div class="panel panel-default">
                            <div class="heading">
                                <h4 class="" style="color:teal; padding-left:20px; padding-top:10px;">Mark Attendance </h4>
                                <hr>

                            </div>
                        <div class="box-body">
                          <div class="col-lg-3">Select CSV File to upload</div>
                           <div class="col-lg-3">
                            <input class="form-control" size='50' type='file' name='attendance_upload' required>
                          </div>
                          <div class="col-lg-2"><input type='submit' class="btn btn-success" name='submit' id='submit' value='Upload'></div>
                        </div>
                          </form>
                            <div class="panel-body" id="student_div">
                                <table id="student" class="table table-bordered table-stripped fixed" style="table-layout: fixed;"> 
                                    <tr  style="background-color:#dcedc8">   
                                        <th rowspan="3" style="vertical-align: middle; text-align: center; border-right-color: #bdbdbd;"> <u> Sl no</u> </th>
                                        <th rowspan="3" style="vertical-align: middle; text-align: center; border-right-color: #bdbdbd;"> <u> Student no</u> </th>
                                        <th rowspan="3" style="vertical-align: middle; text-align: center; border-right-color:#bdbdbd;"> <u> Admission No </u></th>
                                        <th rowspan="3" style="vertical-align: middle; text-align: center; border-right-color: #bdbdbd;"><u> Student Name </u></th>
                                        <th colspan="3" style="vertical-align: middle; text-align: center;"><u> Month </u></th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
					
              
               
			</div>
				
			</div>
		</div>
	</div> 
    <div class="box">
        <div class="box-body ">
            <legend><u>Instructions</u></legend>
                        <ol>
                <li>First <b>Download the Format</b> (File Should be in CSV( Comma Separated Delimited) Format).</li>
                                <li>Please do not change student id.</li>
                                <li>Write <b>P</b> for Present and <b>A</b> for Absent</li>
                                <li>Do not change Sunday Column</li>
                                
            </ol>
                    <!--     <div class="table-responsive ">
                         <table class="table table-striped table-bordered ">
                            <tr class="success">
                                <th>Student Id</th>
                                <th>Attandence</th>
                            </tr>
                            <tr class="danger">
                                <td>Please do not change student id.</td>
                                <td>Write P for Present and A for Absent</td>
                            </tr>
                        </table>   
                        </div> -->
                        
            
        </div>  
    </div>
    <script>
    $(document).ready(function()
    {
        
    $('#get_report').click(function()
    {
        var month = $('#mon').val();
        var year = $('#year').val();
        var clas = $('#cls').val();
        var section = $('#sec').val();
        
        var days=getNumberOfDays(month,year);
        
        var sun=getNumberOfSundays(month,year);//sundays
        
        var week_off=getNumberOfSundays(month,year).length;
        
        var working_days=(getNumberOfDays(month,year)-week_off);
        $('#work_day').val(working_days);
        
        $.ajax(
                {
                    type:'POST',
                    data:
                            {
                              month:month,
                              year:year,
                              total_days:days,
                              total_work:working_days,
                              weekend:sun,
                              total_sun:week_off,
                              class:clas,
                              section:section,  
                            },
                    url:"<?php echo base_url('attendance/student_attendance/load_student_import');?>",
                    datatype:'text',
                    success:function(data)
                            {
                                // console.log(data);
                                $('#student_div').html(data);
                            },
                            error:function(req,status)
                            {
                                alert('error while loading');
                            },

                    

                        
                });
        
    });    



function getNumberOfDays(month,year)
{
      var day = new Date(year,month,0).getDate();
      return day;
//      alert(day);
}

function getNumberOfSundays( m, y )
{
    var days = new Date( y,m,0 ).getDate();
    var sundays = [ 8 - (new Date( m +'/01/'+ y ).getDay()) ];
    for ( var i = sundays[0] + 7; i < days; i += 7 )
    {
    sundays.push( i );
    }
    return  sundays;
}
       
        });
        
             $('#save_attendance').click(function()
        {
             var detail=$('#form_attendance').serialize();
         //    alert($('#attendance').val());
         //print_r(detail);
      //   console.log(detail);

                // console.log(detail);
            if ($('#cls').val()==0 || $('#sec').val()==0 || $('#mon')=='')
            {
            alert('Please select Class and Section and Date'); 
            }
             else
             {
             $.ajax({
                    type:'POST',
                    url:"<?php echo base_url('attendance/Student_attendance/save_stud_attendance_monthly');?>",
                    data:$('#form_attendance').serialize(),
                    // dataType:'text',
                    success:function(data)
                    {
                        // console.log(data);
                        // alert('Attendance saved successfully');
                        // window.location.reload();
                    },
                    error:function(req,status)
                    {
                         alert('error while saving');
                    }
              });
            }
        });   
         setTimeout(function () {
        $('#successMessage').fadeOut("fast");
    }, 5000);
</script>
                
               
                 
            





