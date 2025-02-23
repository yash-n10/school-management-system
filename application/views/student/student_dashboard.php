    <style>
        .external:hover
        {
            -moz-transform: scale(1.1);
            -webkit-transform: scale(1.1);
            transform: scale(1.1);
        }
        
    </style>
<!-- Main content -->
        <div class="row" style="margin-bottom:20px;">
            <div class="col-md-12">
                <span class=""><i class="fa fa-graduation-cap" style="font-size:50px; float:left; padding-right:15px; color: #001f4d;"></i> </span> 
                <span class="" style="font-size:30px; color: #990000;"><?php echo 'Welcome ,'.' '.$student_name;?></span>
            </div>
        </div>
        
        <div class="action-nav-normal">
		
            <div class="col-sm-1" style="margin-left:10px; margin-right:15px;">
                <a href="<?php echo base_url();?>student/exam">
                <div class="col-md-1 external" style="background-color:#ff3333; margin: 20px auto; width: 100px; height: 100px; border-radius: 200px;">
                    <div><i class="fa fa-file-text-o fa-3x" style="color:white; padding-top:15px; padding-left: 18px; padding-right: 15px; padding-bottom:6px;"></i></div>
                    <div class='external' style="text-align:center; color:white; font-size:15px;"><?php echo 'Exam';?></div>
                </div>   
                </a>
            </div>
            
             <div class="col-sm-1" style="margin-left:10px; margin-right:15px;">
                <a href="<?php echo base_url();?>student/attendence">
                <div class="col-md-1 external" style="background-color: #4da6ff; margin: 20px auto; width: 100px; height: 100px; border-radius: 200px;">
                    <div><i class="fa fa-check-square-o fa-3x" style="color:white; padding-top:15px; padding-left: 15px; padding-right: 15px;"></i></div>
                    <div class='external' style="text-align:center; color:white; font-size:15px;"><?php echo 'Attendance';?></div>
                </div>                        
            </div>
            
            <div class="col-sm-1" style="margin-left:15px; margin-right:15px;">
                <a href="<?php echo base_url();?>student/assignments">
                <div class="col-md-1 external" style="background-color: #00cc66; margin: 20px auto; width: 100px; height: 100px; border-radius: 200px;">
                    <div><i class="fa fa-pencil-square-o fa-3x" style="color:white; padding-top:15px; padding-left: 15px; padding-right: 15px;"></i></div>
                    <div class='external' style="text-align:center; color:white; font-size:15px;"><?php echo get_phrase('assignments');?></div>
                </div>                        
            </div>
     
            
            <div class="col-sm-1" style="margin-left:15px; margin-right:15px;">
                <a href="<?php echo base_url();?>student/class_routine">
                <div class="col-md-1 external" style="background-color: #ff3377; margin: 20px auto; width: 100px; height: 100px; border-radius: 200px;">
                    <div><i class="fa fa-calendar fa-3x" style="color:white; padding-top:15px; padding-left: 15px; padding-right: 15px;"></i></div>
                    <div class='external' style="text-align:center; color:white; font-size:14px;"><?php echo get_phrase('class_routine');?></div>
                </div>                        
            </div>
            
             <div class="col-sm-1" style="margin-left:15px; margin-right:15px;">
                <a href="<?php echo base_url();?>student/book">
                <div class="col-md-1 external" style="background-color: #0000cc; margin: 20px auto; width: 100px; height: 100px; border-radius: 200px;">
                    <div><i class="fa fa-book fa-4x" style="color:white; padding-top:15px; padding-left: 12px; padding-right: 15px; padding-bottom: 3px;"></i></div>
                    <div class='external' style="text-align:center; color:white; font-size:15px;"><?php echo get_phrase('library');?></div>
                </div>                        
            </div>                        

             <div class="col-sm-1" style="margin-left:15px; margin-right:15px;">
                <a href="<?php echo base_url();?>student/subject">
                <div class="col-md-1 external" style="background-color: #a31aff; margin: 20px auto; width: 100px; height: 100px; border-radius: 200px;">
                    <div><i class="fa fa-list fa-3x" style="color:white; padding-top:15px; padding-left: 15px; padding-right: 15px; padding-bottom: 5px;"></i></div>
                    <div class='external' style="text-align:center; color:white; font-size:15px;"><?php echo get_phrase('subjects');?></div>
                </div>                        
            </div>
            
            
            <div class="col-sm-1" style="margin-left:15px; margin-right:15px;">
                <a href="<?php echo base_url();?>student/noticeboard">
                <div class="col-md-1 external" style="background-color: #009999; margin: 20px auto; width: 100px; height: 100px; border-radius: 200px;">
                    <div><i class="fa fa-info-circle fa-4x" style="color:white; padding-top:15px; padding-left:15px; padding-right: 15px;"></i></div>
                    <div class='external' style="text-align:center; color:white; font-size:12px;"><?php echo 'Notice Board';?></div>
                </div>                        
            </div>
            
            
            <div class="col-sm-1" style="margin-left:15px; margin-right:15px;">
                <a href="<?php echo base_url();?>student/questionpaper">
                <div class="col-md-1 external" style="background-color:#0077b3 ; margin: 20px auto; width: 100px; height: 100px; border-radius: 200px;">
                    <div><i class="fa fa-question-circle fa-3x" style="color:white; padding-top:15px; padding-left:15px; padding-right: 15px;"></i></div>
                    <div class='external' style="text-align:center; color:white; font-size:12px;"><?php echo 'Previous Questions';?></div>
                </div>  
                </a>
            </div>
            
            <div class="col-sm-1" style="margin-left:15px; margin-right:15px;">
                <a href="<?php echo base_url();?>student/tasks">
                <div class="col-md-1 external" style="background-color: #004d00; margin: 20px auto; width: 100px; height: 100px; border-radius: 200px;">
                    <div><i class="fa fa-flag-o fa-4x" style="color:white; padding-top:15px; padding-left:15px; padding-right: 15px;"></i></div>
                    <div class='external' style="text-align:center; color:white; font-size:12px;"><?php echo get_phrase('things_do_to');?></div>
                </div>                        
            </div>
           

            <div class="col-sm-1"  style="margin-left:15px; margin-right:15px;">
                <a href="https://crm.feesclub.com">
                <div class="col-md-1 external" style="background-color: #b30059; margin: 20px auto; width: 100px; height: 100px; border-radius: 200px;">
                    <div><i class="fa fa-inr fa-4x" style="color:white; padding-top:15px; padding-left:18px; padding-right: 15px;"></i></div>
                    <div class='external' style="text-align:center; color:white; font-size:15px;"><?php echo get_phrase('payment');?></div>
                </div>  
                </a>
            </div>
            
           
            
            <div class="col-sm-1" style="margin-left:15px; margin-right:15px;">
                <a href="<?php echo base_url();?>student/dormitory">
                <div class="col-md-1 external" style="background-color: #ff661a; margin: 20px auto; width: 100px; height: 100px; border-radius: 200px;">
                    <div><i class="fa fa-home fa-3x" style="color:white; padding-top:15px; padding-left:15px; padding-right: 15px;  padding-bottom: 8px;"></i></div>
                    <div class='external' style="text-align:center; color:white; font-size:15px;"><?php echo get_phrase('dormitory');?></div>
                </div>                        
            </div>
            
            <div class="col-sm-1" style="margin-left:15px; margin-right:15px;">
                <a href="<?php echo base_url();?>student/transport">
                <div class="col-md-1 external" style="background-color:#248f24; margin: 20px auto; width: 100px; height: 100px; border-radius: 200px;">
                    <div><i class="fa fa-bus fa-4x" style="color:white; padding-top:15px; padding-left:11px; padding-right: 15px;  padding-bottom: 2px;"></i></div>
                    <div class='external' style="text-align:center; color:white; font-size:15px;"><?php echo get_phrase('transport');?></div>
                </div>                        
            </div>       
            
            <div class="col-sm-1" style="margin-left:15px; margin-right:15px;">
                <a href="<?php echo base_url();?>student/transport">
                <div class="col-md-1 external" style="background-color:#e63900; margin: 20px auto; width: 100px; height: 100px; border-radius: 200px;">
                    <div><i class="fa fa-trophy fa-4x" style="color:white; padding-top:15px; padding-left:11px; padding-right: 15px;  padding-bottom: 2px;"></i></div>
                    <div class='external' style="text-align:center; color:white; font-size:15px;"><?php echo 'Events';?></div>
                </div>                        
            </div> 
            
              <div class="col-sm-1" style="margin-left:15px; margin-right:15px;">
                <a href="<?php echo base_url();?>student/transport">
                <div class="col-md-1 external" style="background-color:#ff6666; margin: 20px auto; width: 100px; height: 100px; border-radius: 200px;">
                    <div><i class="fa fa-comments-o fa-4x" style="color:white; padding-top:15px; padding-left:11px; padding-right: 15px;  padding-bottom: 2px;"></i></div>
                    <div class='external' style="text-align:center; color:white; font-size:15px;"><?php echo 'Contact';?></div>
                </div>                        
            </div>
        </div>

<div class='col-md-12' style=' background:#ecf0f5; margin-top:20px;'>
    <div class="col-md-8">
         <div class='box box-solid' style='background:#6699ff;'>
                    <div class='box-header'>
                         <h7 class="panel-title" style='color:white;'>Today's Class Routine</h7>
                    <div class='pull-right box-tools'>
                        <button type="button" class="btn btn-sm" data-widget="collapse" style='color:black; background:#4d88ff; color:white;'><i class="fa fa-minus"></i></button>                           
                    </div>                     
                    </div>
             
             <div class="box-footer text-black">
                  <div class="table-responsive">
                      <table class='table table-bordered table-stripped'>
                          <tr style='background:#cce6ff;'>
                              <th style='background:#ffe6e6;'> <?php echo date('d-m-y');?> </th>
                              <?php for($k=0; $k<$period; $k++) { ?>
                              <th style='color:#3366cc'> <?php echo $day_subject[$k];?> </th>
                              <?php } ?>
                          </tr> 
                          
                          <tr>
                              <td style='background:#cce6ff;'> <?php echo $day; ?> </td>
                              <?php for($m=0; $m<$period; $m++) { ?>
                              <td> <?php if($start[$m]!='') { echo $start[$m].':'.$start_min[$m]."-".$end[$m].":".$end_min[$m];} else { echo ''; }?> 
                                  <br><b><?php echo $tchr_nam[$m]; ?> </b>
                              </td>
                              <?php } ?>
                          </tr>
   
                      </table>
                  </div>
             </div>
         </div>
    </div>
    
    <div class='col-md-1'>
        
    </div>
    
    <div class='col-md-3'>
        <div class='box box-solid' style='border-left:3px solid red; background:#ffebe6'>
                    <div class='box-header'>
                         <h7 class="panel-title">   Class Teacher  </h7>
                    <div class='pull-right box-tools'>
                    <button type="button" class="btn btn-sm" data-widget="collapse" style='color:black; background:#ffd6cc; float:left !important;'><i class="fa fa-minus"></i>
                    </button>
                           
                    </div>
                     
                    </div>
                
                <div class="box-footer text-black">
                      <div class="table-responsive">
                    
                    <!-- /.col -->
                    <table class='table table-bordered table-stripped'>
                        <tr>
                            <th> Name </th>
                            <td> <?php echo $teacher; ?> </td>
                        </tr>
                        
                          <tr>
                            <th> Subject </th>
                            <td> <?php echo $teacher; ?> </td>
                        </tr>
                        
                          <tr>
                            <th> Contact </th>
                            <td> <?php echo $teacher_contact; ?> </td>
                        </tr>
                        
                          <tr>
                            <th> Email </th>
                            <td> <?php echo $email; ?> </td>
                        </tr>
                    </table>
                      </div>

                </div>
             </div>
    </div>
    
</div>
    
<div class='col-md-12' style='background:#ecf0f5;'>
<div class='col-md-4'>  
    <div class='box box-solid' style='background:#ff6666;'>
        <div class='box-header'>
            <span style='padding-right:5px;'><i class="fa fa-user-circle" style='color:white'></i> </span>
            <span><h4 class='box-title' style='color:white'>My Profile</h4></span>
            <div class='pull-right box-tools'>
                <button type="button" class="btn btn-sm" data-widget="collapse" style='background:#ff4d4d; color:white;'><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>

        
            <div class="box-footer text-black">
                  <div class="table-responsive">
                    
                    <!-- /.col -->
                    <table class='table table-bordered table-stripped'>
                        <tr>
                            <th>Admission No  </th>
                            <td> <?php echo $adm ;?></td>
                        </tr>
                        
                        <tr>
                            <th>Class  </th>
                            <td> <?php echo $clas ;?></td>
                        </tr>
                        
                         <tr>
                            <th>Section  </th>
                            <td> <?php echo $sec ;?></td>
                        </tr>
                        
                         <tr>
                            <th>Contact No  </th>
                            <td> <?php echo $contact ;?></td>
                        </tr>
                        
                        <tr>
                            <th>Email  </th>
                            <td> <?php echo $email;?></td>
                        </tr>
                        
                        <tr>
                            <th>Father's Name  </th>
                            <td> <?php echo $father ;?></td>
                        </tr>
                        
                        <tr>
                            <th>Mother's Name  </th>
                            <td> <?php echo $mother ;?></td>
                        </tr>
                        
                        <tr>
                            <th>Address  </th>
                            <td> <?php echo $addrs ;?></td>
                        </tr>
                    </table>
                  </div>
            </div>
    </div>
    </div>

    
    
    <div class='col-md-5'>
        <div class='box box-solid' style='background:#47d1d1;'>
        <div class='box-header'>
            <span style='padding-right:5px;'><i class="fa fa-bar-chart" style='color:white'></i> </span>
            <span><h4 class='box-title' style='color:white'>Statistics</h4></span>
            <div class='pull-right box-tools'>
                <button type="button" class="btn btn-sm" data-widget="collapse" style='background:#00e6e6; color:white;'><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
            
        <div class="box-footer text-black">
                  <div class="row">
                         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="panel panel-default" style="border-top:2px solid #3c8dbc; margin:0px;">                                                    
                                                    <div class="panel-body">                      
                                                        <div class="row" style="">
                                                            <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">
                                                                <span class="info-box-text" style="color: #3c8dbc;font-weight: bold;font-size: 15px; text-align:left">Attendance</span>
                                                            </div>                                                    
                                                        </div>
                                                        
                                                        <div class="col-md-12" >
                                                            <div class="" id="chart_div" style='text-align:right;'>                                                                
                                                            </div>                                                                                                              
                                                        </div>
                                                    </div>
                                                </div>
                             
                             <div class="panel panel-default" style="border-top:2px solid #3c8dbc; margin-top:10px;">                                                    
                                                    <div class="panel-body">                      
                                                        <div class="row" style="">
                                                            <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">
                                                                <span class="info-box-text" style="color: #3c8dbc;font-weight: bold;font-size: 15px; text-align:left">Exam Report</span>
                                                            </div>                                                    
                                                        </div>
                                                        
                                                        <div class="col-md-12">
                                                            <div class="" id="bar_chart_div" style='text-align:right;'>                                                                
                                                            </div>                                                                                                              
                                                        </div>
                                                    </div>
                              </div>

                                    <!-- fix for small devices only -->
                                    <div class="clearfix visible-sm-block"></div>
                         </div>
                  </div>
        </div>
        </div>
        </div>
    
    <div class='col-md-3'>

             <div class='box box-solid' style='border-left:3px solid green; background:#ffebe6'>
                    <div class='box-header'>
                         <h7 class="panel-title">   Subject Teacher  </h7>
                    <div class='pull-right box-tools'>
                    <button type="button" class="btn btn-sm" data-widget="collapse" style='color:black; background:#ffd6cc; float:left !important;'><i class="fa fa-minus"></i>
                    </button>
                           
                    </div>
                     
                    </div>
                
                <div class="box-footer text-black">
                    <div class="table-responsive">
                    
                    <!-- /.col -->
                    <table class='table table-bordered table-stripped'>
                         <?php for($j=0; $j<$sub_cnt-1; $j++) {?>
                        <tr>                          
                            <th> <?php echo $subject[$j]; ?> </th>
                            <td> <?php echo $tchr_nm[$j]; ?></td>
                        </tr>
                         <?php }?>
                    </table>
                    </div>
                </div>
                </div>
        
        
          <div class='box box-solid' style='border-left:3px solid blue; background:#ffebe6'>
                    <div class='box-header'>
                         <h7 class="panel-title"> Last Fee Paid  </h7>
                    <div class='pull-right box-tools'>
                        <button type="button" class="btn btn-sm" data-widget="collapse" style='color:black; background:#ffd6cc; float:left !important;'><i class="fa fa-minus"></i></button>                           
                    </div>                     
                    </div>
                
                <div class="box-footer text-black">
                            <div class="table-responsive">
                    <table class='table table-bordered table-stripped'>
                        
                        <tr> <th>  Amount </th>
                            <td> <?php echo $fee_amnt; ?></td>
                        </tr>
                        
                        <tr> <th>  Payment Date </th>
                            <td> <?php echo $fee_date; ?></td>
                        </tr>
                        
                    </table>
                    </div>
                </div>
           </div>
    </div>
    

</div>




<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>  
<script type="text/javascript">
//    google.charts.load("visualization","1.1", {packages: ['corechart']});
    google.charts.load("current", {packages: ['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    
 function drawChart() { 
      var jsonData = $.ajax({ 
          url : "<?php echo base_url('Dashboard/result_graph');?>", 
          dataType: "json", 
          async: false 
          }).responseText; 
           
      // Create our data table out of JSON data loaded from server. 
      var data = new google.visualization.DataTable(jsonData);  
      // Instantiate and draw our chart, passing in some options. 
      var chart = new google.visualization.PieChart(document.getElementById('chart_div')); 
      chart.draw(data, {width: 350, height: 175}); 
      
      var barchart = new google.visualization.BarChart(document.getElementById('bar_chart_div'));
      barchart.draw(data, { width:300, height:150 });
    }
    
   
</script>


