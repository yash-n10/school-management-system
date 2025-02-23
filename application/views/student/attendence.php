<div class="box">
	<div class="box-header">            
            <div class="col-md-12" style="">
                <span class='col-md-3' style='color:#990000; font-size:25px; padding-top:15px; margin-right:0px !important;'> Today's Status :  </span>
                <span class='col-md-4' style='color:#001f4d; font-size:25px; padding-top:15px; padding-left:0px !important;'> <?php echo $attend; ?> </span>
            </div>
            
    	<!------CONTROL TABS START------->
        
            <div class='col-md-12' style='margin-top:30px; margin-bottom:30px; background:#4da6ff;'>
		<ul class="nav nav-tabs nav-tabs-left">
                         
                <li class="active">
                <a href="#monthly_attend" data-toggle="pill" style='color:#004d99;'><i class="icon-align-justify"></i> 
                    <b> Monthly </b>
                </a> 
                </li>
		</ul>
            </div>
    	<!------CONTROL TABS END------->
        <div class="box-body">   
        <div class="tab-content">
        <div class='tab-pane fade in active' id="monthly_attend">
            <div class="row">
                 <form id="attendance">
                     <div class="col-md-12">
            <div class="col-md-2">
                <b>  Month Name   : </b>
            </div>   
            
            <div class="col-md-3">
                <select class="form-control" id="mnth">
                    <option value="0">Select Month </option>
                    <option value="4" >April </option>
                    <option value="5">May </option>
                    <option value="6">June </option>
                    <option value="7">July </option>
                    <option value="8">August </option>
                    <option value="9">September </option>
                    <option value="10">October </option>
                    <option value="11">November </option>
                    <option value="12">December </option>
                    <option value="1">January </option>
                    <option value="2">February </option>
                    <option value="3">March </option>
                </select>
            </div>

            
            <div class="col-md-2" style="margin-left:50px;">
                <b> Total Working Days </b>
            </div>
            
            <div class="col-md-3">
                <input type="text" id="work_day" value="" class="form-control">
            </div>
              </div>
            
                 <div class="col-md-12" style="margin-top: 30px;">
                     <div class="table-responsive">
                    <div id="monthly" class="col-md-12"> 
                        <table id="atten" class="table table-bordered table-stripped"> 
                            <!--<div class="" style="overflow-x:auto;">-->
                            <tr  style="background-color:#dcedc8">   
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
                         </form>
        </div>
        </div>
        </div>
        </div>
    
        </div>
</div>


<script type="text/javascript">

$('#mnth').change(function()
{ 
        var month = $('#mnth').val();
        var year="<?php echo date('Y');?>"

        var days=getNumberOfDays(month,year);
        var sun=getNumberOfSundays(month,year);//sundays
        
        var week_off=getNumberOfSundays(month,year).length;
        
        var working_days=(getNumberOfDays(month,year)-week_off);
        $('#work_day').val(working_days);
        
        $.ajax({
                    type:'POST',
                    data:
                            {
                              month:month,
                              year:year,
                              total_days:days,
                              total_work:working_days,
                              weekend:sun,
                              total_sun:week_off,  
                            },
                    url:"<?php echo base_url('student/month_attendance');?>",
                    datatype:'text',
                    success:function(data)
                            {
                                $('#monthly').html(data);
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