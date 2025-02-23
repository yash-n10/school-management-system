      <style>
        .form-group
        {
            margin-top: 0px !important;
        }
      </style>
       <div class="form-group has-feedback">
        <div class="box">            
            <div class="box-header">
                 <h3 class="box-title"><b><u>Attendance Monthly Report</u></b></h3>  
            </div>
            
            
            <div class="box-body" style="padding-left:25px;padding-right:25px;">
                        <div class="col-lg-12" style="background:Wheat;padding:0px " >
                         <ul class="nav nav-pills">
                             <li class="active box-title"><a data-toggle="pill" href="#stud_report"><i class="fa fa-list"></i>Student Attendance Report</a></li>
                             <li class="box-title" style=""><a data-toggle="pill" href="#staff_report"><i class="fa fa-list"></i>Staff Attendance Report</a></li>
                         </ul>
                            
                        </div>
                    
            </div>
            
            <div class="box-body">   
            <div class="tab-content">
                
<!-------------------------------------------------------  Student Report ----------------------------------------------------------------------->
            <div class="tab-pane fade in active" id="stud_report">
                                         <div class="row">
                                             <form id="attendance" name="stud_form" method="POST">
                                                 <div class="col-md-12" style="padding-left:25px; padding-right:25px;">
                                                 <div class="panel panel-default">
                                                     <div class="heading">
                                                         <h4 class="" style="color:teal; padding-left:20px;"> Student Attendance Report Of Year
                                                             <!-- <input type="text" style="margin-left: 50px;" name="year" id="year" placeholder="Year" value='2019'> -->

                                                             <input type="text" style="margin-left: 50px;" name="year" id="year" placeholder="Year" value='<?php echo date('Y'); ?>'>
                                                              </h4>
                                                     </div> 
                                                     <hr>
                                                     
                                                     <div class="panel-body" style="padding:0px">
                                                            <div class="col-sm-1 form-group">
                                                            <label for="">Class</label>
                                                             </div>
                                                             <div class="col-sm-2 form-group">
                                                                 <select class="form-control" id="cls" name="cls"> <option value="0">Select Class </option>
                                                                   <?php foreach($class as $cls){ ?>
                                                                            <option value="<?php echo $cls->id; ?>"> <?php echo $cls->class_name; ?></option>
                                                                   <?php }  ?>
                                                                 </select>
                                                             </div>
                                                         
                                                         
                                                           <div class="col-sm-1 form-group">
                                                                 <label for="">Section</label>
                                                             </div>
                                                             <div class="col-sm-2 form-group">
                                                                 <select class="form-control" id="sec" name="sec"> <option value="0">Select Section </option>
                                                                   <?php foreach($classsection as $sec){ ?>
                                                                            <option value="<?php echo $sec->id; ?>"> <?php echo $sec->sec_name; ?></option>
                                                                   <?php }  ?>
                                                                 </select>
                                                             </div>
                                                         
                                                         
                                                              <div class="col-sm-1 form-group">
                                                                 <label for="">Month</label>
                                                             </div>
                                                             <div class="col-sm-2 form-group">
                                                                 <select class="form-control" id="mon" name="mon"> <option value="0">Select Month </option>
                                                                            
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
                                                         <div style="padding-right:15px;">
                                                         <input type="button" class="btn btn-info" id="get_report" value="Get Report" style="float:right;  margin-top:-5px;">
                                                         </div>
                                                     </div>
                                                 </div>
                                                  </div>
                                                 
                                            <div class="col-md-12" style="padding-left:25px; padding-right:25px;">
                                                        <div class="panel panel-default">
                                                        <div class="panel-body">
                                                        <div class="col-md-12" style="text-align: left;">
                                                            <span>  <label for="Total Working Days" style="color:teal; font-size: 16px;"> Total working Days</label> </span>
                                                            <span  style="padding-left:30px;">   <input type="text" id="work_day" name="work_day" value="" style="width: 57px;"> </span>
                                                              <hr>

                                                        </div>
							</div>


                                                            <div class="row">
                                                                <div class="col-md-12" id="student_div"> 
                                                                    <table id="student" class="table table-bordered table-stripped fixed" style="table-layout: fixed"> 
                                                                        <!--<div class="" style="overflow-x:auto;">-->
                                                                        <tr  style="background-color:#dcedc8">   
                                                                            <th rowspan="3" style="vertical-align: middle; text-align: center; border-right-color: #bdbdbd;"> <u> Sl no</u> </th>
                                                                            <th rowspan="3" style="vertical-align: middle; text-align: center; border-right-color: #bdbdbd;"> <u> Student no</u> </th>
                                                                             <th rowspan="3" style="vertical-align: middle; text-align: center; border-right-color:#bdbdbd;"> <u> Admission No </u></th>
                                                                            <th rowspan="3" style="vertical-align: middle; text-align: center; border-right-color: #bdbdbd;"><u> Student Name </u></th>
                                                                            <th rowspan="3" style="vertical-align: middle; text-align: center; border-right-color: #bdbdbd;"> <u>Total Present </u></th>
                                                                            <th rowspan="3" style="vertical-align: middle; text-align: center; border-right-color: #bdbdbd;"> <u>Total Absent </u></th>
                                                                            <!--<th rowspan="3" style="vertical-align: middle; text-align: center; width:30px"></th>-->
                                                                            <th colspan="3" style="vertical-align: middle; text-align: center;"><u> Month </u></th>
                                                                        </tr>
<!--                                                                        <tr style="background-color:#fce4ec">-->
                                                                            
                                                                            
                                                                        <!--</tr>-->
                                     
                                                                        <!--</div>-->
                                                                    </table>
                                                                </div>
                                                            </div>


                                                        </div>
                                            </div>

                                             </form>
                                         </div>
            </div>



<!------------------------------------------------------- Staff Report --------------------------------------------------------------------------->
                     <div class="tab-pane" id="staff_report">
                         <div class="row">
                                            <form id="attendance" name="staff_form" method="POST">
                                                 <div class="col-md-12" style="padding-left:25px; padding-right:25px;">
                                                 <div class="panel panel-default">
                                                     <div class="heading">
                                                         <h4 class="" style="color:teal; padding-left:20px; padding-top:10px;"> Staff Attendance Report Of Year
                                                             <input type="text" style="margin-left: 50px;" id="year1" name="year1" placeholder="Year"  value='<?php echo date('Y'); ?>'>
                                                   </h4>
                                                     </div>
                                                     <hr>
                                                     
                                                     <div class="panel-body">
                                                        <div class="col-sm-1 form-group">
                                                         <label for="">Month</label>
                                                        </div>
                                                             <div class="col-sm-3 form-group">
                                                                 <select class="form-control" id="mon1" name="mon1"> <option value="0">Select Month </option>
                                                                            
                                                                            <option value="4">April</option>
                                                                            <option value="5">May</option>
                                                                            <option value="6">June</option>
                                                                            <option value="7">July</option>
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
                                                        <div style="padding-right:15px;">
                                                         <input type="button" class="btn btn-info" id="get_report1" value="Get Report" style="float:right;">
                                                         </div>
                                                     </div>
                                                 </div>
                                                 </div>
                                                
                                                
                                                <div class="row">
                                                        <div class="col-md-12" style="padding-left:25px; padding-right:25px;">
                                                            <div class="panel panel-default">
                                                            <div class="panel-body">
                                                            <div class="row col-md-12" style="text-align: center;">
                                                                <span>  <label for="Total Working Days" style="color:teal; font-size: 16px;"> Total working Days</label> </span>
                                                                <span  style="padding-left:30px;">   <input type="text" id="work_day1" name="work_day1" value=""> </span>

                                                                        <hr>
                                                            </div>


                                                                <div class="row">
                                                                    <div class="col-md-12" id="staff_div">
                                                                        <table id="staff" class="table table-bordered table-stripped table-responsive">
                                                                            <tr  style="background-color:#dcedc8">   
                                                                            <th rowspan="2" style="vertical-align: middle; text-align: center; border-right-color: #bdbdbd; width:50px;"> <u> Sl  no </u></th>
                                                                            <th rowspan="2" style="vertical-align: middle; text-align: center; border-right-color: #bdbdbd; width:150px;"> <u> Employee Code </u></th>
                                                                            <th rowspan="2" style="vertical-align: middle; text-align: center; border-right-color: #bdbdbd; width:369px;"> <u> Employee name </u></th>
                                                                            <th rowspan="2" style="vertical-align: middle; text-align: center; border-right-color: #bdbdbd; width:150px;"> <u> Total Present </u></th>
                                                                            <th rowspan="2" style="vertical-align: middle; text-align: center; border-right-color: #bdbdbd; width:150px; "> <u> Total Absent </u></th>
                                                                            <th colspan="2" style="vertical-align: middle; text-align: center; width:155px;"><u> Month </u></th>
                                                                             </tr>
                                                                             
                                                                             <tr style="background-color:#fce4ec">
                                                                           
                                                                            <th></th>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </div>


                                                            </div> 
                                                            </div>
                                                        </div>
                                                    </div>
                                            </form>
                         </div>
                     </div>



</div>
            </div>
          </div>
            
        </div>
       </div>

<script>


    $('#get_report').click(function()
    {
        var month = $('#mon').val();
        var year = $('#year').val();
        var clas = $('#cls').val();
        var section = $('#sec').val();
        
//        getNumberOfDays(month,year);
        var days=getNumberOfDays(month,year);
        
//        getNumberOfSundays(month,year);
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
                    url:"<?php echo base_url('attendance/attendance_report/load_student_report');?>",
                    datatype:'text',
                    success:function(data)
                            {
                                $('#student_div').html(data);
                            },
                            error:function(req,status)
                            {
                                alert('error while loading');
                            },

                    

                        
                });
        
    });
    
    
    
    $('#get_report1').click(function()
    {
        var month1 = $('#mon1').val();
        var year1 = $('#year1').val();
        getNumberOfDays(month1,year1);
        
        var days=getNumberOfDays(month1,year1);
        
//        getNumberOfSundays(month,year);
        var sun=getNumberOfSundays(month1,year1);//sundays
        
        var week_off=getNumberOfSundays(month1,year1).length;
        
        var working_days=(getNumberOfDays(month1,year1)-week_off);
        $('#work_day1').val(working_days);
        
        
             $.ajax(
                {
                    type:'POST',
                    data:
                            {
                              month:month1,
                              year:year1,
                              total_days:days,
                              total_work:working_days,
                              weekend:sun,
                              total_sun:week_off, 
                            },
                    url:"<?php echo base_url('attendance/attendance_report/load_staff_report');?>",
                    datatype:'text',
                    success:function(data)
                            {
                                $('#staff_div').html(data);
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



 </script>
