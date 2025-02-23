<style>
  a{
    /*color:#fff!important;*/
    font-weight: bold!important;

  }
  @media (min-width: 768px) and (max-width: 1024px) {  
  .btn-app {        
      min-width: 148px;
      height: 83px;
      font-size: 15px;
      background-color:none;
      border:0px solid;
    }
}
  @media (min-width: 481px) and (max-width: 767px) {    
    .btn-app {        
      min-width: 148px;
      height: 83px;
      font-size: 13px;
      background-color:none;
      border:0px solid;
    }    
  }
  @media (min-width: 320px) and (max-width: 480px) {  
   .btn-app {        
        min-width: 128px;
        height: 83px;
        font-size: 15px;
        background-color:none;
        border:0px solid;
      }    
}
@media (min-width: 120px) and (max-width: 318px) {  
   .btn-app {        
        min-width: 143px;
        height: 83px;
        font-size: 12px;
        background-color:none;
        border:0px solid;
      }    
}

  .info-box-text {
      color: #fff;
  }
  
  .external:hover
  {
    -moz-transform: scale(1.1);
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
  }
  
  .products-list .product-info {
    margin-left: 0px; 
  }
  .nav-tabs-custom>.nav-tabs>li.active {
    border-top-color: #dd4b39;
  }
  @media (min-width: 992px){
    .cc_profile {      
      margin-top: -55px;
    }
    .reportdiv
    {
      margin-top:-35px;
    }
    .btn-app {        
      min-width: 148px;
      height: 83px;
      font-size: 15px;
      background-color:none;
      border:0px solid;
    }
  }
  .badge {  
    min-width: 10px;
    padding: 3px 9px;
    font-size: 12px;
    border-radius: 5px;
  }
  .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 4px;
    line-height: 1.52857143;
    vertical-align: top;
    border-top: 1px solid #ddd;
  }
  .products-list .product-description {    
    white-space: normal;
  }


  .element {
    height: 10px;
    width: 10px;
    border-radius: 32px;
    margin: 0 auto;
    background-color: red;
    animation-name: stretch;
    animation-duration: 1.3s; 
    animation-timing-function: ease-out; 
    animation-delay: 0;
    animation-direction: alternate;
    animation-iteration-count: infinite;
    animation-fill-mode: none;
    animation-play-state: running;
  }

  @keyframes stretch {
    0% {
      transform: scale(.1);
      background-color: red;
      border-radius: 100%;
    }
    50% {
      background-color: orange;
    }
    30% {
      transform: scale(0.5);
      background-color: red;
    }
  }

</style>
<div class="row">
  <div class="col-md-12">
    <span class=""><i class="fa fa-graduation-cap" style="font-size:50px; float:left; padding-right:15px; color: #001f4d;"></i> </span> 
    <span class="" style="font-size:30px; color: #990000;font-weight:600;text-transform:capitalize;"><?php echo 'Welcome ,' . ' ' . $user_name; ?></span>
  </div>
</div>
<section class="content">    
  <div class="row">
    <div class="col-md-8">          
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">My Favorites</h3>
        </div>
        <div class="box-body">         
              <?php if (in_array('academics', $a)) { ?>
              <a class="btn btn-app bg-red" href="<?php echo base_url('academics/subject_teachers'); ?>" style="color:#fff;">
                <i class="fa fa-book"></i> Academics
              </a>
            <?php } ?>
          
          <!-- <a class="btn btn-app bg-aqua" href="<?php echo base_url('Teacher/salary_structure'); ?>">
            <i class="fa fa-calendar-minus-o"></i> Salary Structure
          </a> -->
          <?php if($school1[0]->school_group=='ARMY'){?> 
          <a class="btn btn-app bg-aqua" href="<?php echo base_url('admission/student'); ?>">
            <i class="fa fa-users"></i> Pending Students <?php echo $total_pending; ?>
          </a>
          <?php }else { ?>
             <a class="btn btn-app bg-aqua" href="<?php echo base_url('admission/student'); ?>">
            <i class="fa fa-barcode"></i> Student
          </a>
          <?php } ?>

          <?php if (in_array('library', $a)) { ?>
          <a class="btn btn-app bg-yellow" href="<?php echo base_url('ebooks/Ncert'); ?>">
            <i class="fa fa-book"></i> Ebooks
          </a>
        <?php } ?>
        <?php if (in_array('academics', $a)) { ?>
          
          <a class="btn btn-app bg-green" href="<?php echo base_url('attendance/staff_attendance'); ?>">
            <i class="fa fa-save"></i> Attendance
          </a> 
        <?php } ?>
          <?php if (in_array('library', $a)) { ?>
          <a class="btn btn-app bg-purple" href="<?php echo base_url('hr/leave/my_leave'); ?>">
            <i class="fa fa-book"></i> My Leave
          </a>
        <?php } ?>
        
         <a href="" class="btn btn-app bg-yellow" href="<?php echo base_url('hr/payroll/my_payslip'); ?>">
            <i class="fa fa-inr"></i> My Payslip
          </a>
          
          <?php if (in_array('attendence', $a)) { ?>
          <a class="btn btn-app bg-aqua" href="<?php echo base_url(''); ?>">
            <!-- <span class="badge bg-yellow">3</span> -->
            <i class="fa fa-bullhorn"></i>Communication
          </a>
        <?php }?>
        <?php if (in_array('transport', $a)) { ?>
          <a class="btn btn-app bg-purple" href="<?php echo base_url(''); ?>">
            <!-- <span class="badge bg-purple">5</span> -->
            <i class="fa fa-user"></i> Library
          </a>
        <?php } ?>
        <?php if (in_array('academics', $a)) { ?>
          <a class="btn btn-app bg-aqua" href="">
            <!-- <span class="badge bg-green">2</span> -->
            <i class="fa fa-barcode"></i> Marks Upload
          </a>
        <?php } ?>

         <?php if (in_array('fee_management', $a)) { ?>
            <a class="btn btn-app bg-red" href="" style="color:#fff;">
              <i class="fa fa-bullhorn"></i> Send SMS
            </a>
          <?php } ?>
           <?php if (in_array('academics', $a)) { ?>          
          <a class="btn btn-app bg-green" href="<?php echo base_url('academics/homework/add_homework')?>">
            <i class="fa fa-save"></i> Upload Homework
          </a> 
        <?php } ?>
         <a class="btn btn-app bg-yellow" href="<?php echo base_url('ebooks/notes') ?>">
            <i class="fa fa-book"></i> Uploads Notes
          </a>         
        </div>              
        <div class="box-footer text-center">
          <a href="javascript:void(0)" class="uppercase">View All </a>
        </div>          
      </div>            
    </div>
    <div class="col-md-4">  
      <div class="row">                               
        <div class="col-md-12 cc_profile">  
            <div class="box box-warning direct-chat direct-chat-warning">
              <div class="box-header with-border">
                <h3 class="box-title">Noticeboard</h3>
              </div>
              <div class="box-body">
                <div class="direct-chat-messages">
                    <marquee class="marq" direction = "up" loop="" scrollamount="2" onmouseover="this.stop();" onmouseout="this.start();"> 
                      <?php
                                  $this->db->order_by('create_timestamp', 'desc');
                                  $this->db->limit('5');
                                  $notices = $this->db->get('noticeboard')->result_array();

                                  $lastdate = '';
                                foreach ($notices as $key=>$row):
                                  $color=($key % 2===0) ? '#f39c12' : '#d2d6de';
                                  $fontcolor=($key % 2===0) ? '#fff' : '#000';
                                    $rowdate = $row['create_timestamp'];
                          $timestamp = strtotime($rowdate);

                          $new_date = date("d-m-Y", $timestamp);

                                    $day = date('l', $new_date);

                          $orderdate = explode('-', $new_date);
                          $monthh   = $orderdate[1];
                          $datee = $orderdate[0];
                          $year  = $orderdate[2];

                                $mon=date('F',strtotime($new_date));
                                      ?>
                  <div class="direct-chat-msg" >
                    <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left"><?php echo strtoupper($day); ?></span>
                      <span class="direct-chat-timestamp pull-right"><?php echo $datee; ?>th <?php echo $mon; ?> <?php echo $year;?> </span>
                    </div>                     
                    <div class="direct-chat-text" style="margin:0px;color:<?php echo $fontcolor; ?>;background-color:<?php echo $color; ?>">
                      <?php echo $row['notice_title']; ?> : <?php echo $row['notice']; ?>
                    </div>
                  </div>
                  <?php endforeach; ?>  
                  </marquee>    
                </div>  
                          
              </div>              
            </div>

          
        </div>                                               
      </div>             
    </div>
  </div>

  <div class="row">
    <div class="col-md-8">          
      <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Time Table </h3>
            </div>
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered no-margin">
                  <thead>
                  <tr>
                    <th style="color:#0000b3">Period/Time</th>
                     <?php foreach ($period_cnt1 as $row1) { ?>
                    <th style="color:#0000b3">
                      <b><?php echo $row1->period_name .' '.'('.$row1->time_start.':'.$row1->time_start_min.'-'.$row1->time_end.':'.$row1->time_end_min.')'; ?></b></th> 
                      <?php } ?>     
                  </tr>
                  </thead>  
                  <tbody>
                  
                 <?php for($i=0; $i<=$cnt; $i++) { ?>
                  <tr>
                      <td> <?php echo strtoupper($dayyy[$i]); ?></td>
                      <?php for($j=0; $j<=$cnt; $j++) { ?>
                      <td> <?php if(isset($day_subject[$i][$j])) { echo $day_subject[$i][$j]; } else { echo ' ';}?>
                          <br>
                      <?php if(isset($tchr_nam[$i][$j])) { echo  $class_p_id[$i][$j] .' '. $sec_p_id[$i][$j]  ; } else {echo $tchr_nam[$i][$j]; } ?></td>
                      <?php } ?>
                  </tr>
                <?php }?>
           
                  
              </tbody>
            </table>
          </div>
        </div>
        
      </div>           
    </div>

                              
    <div class="col-md-4 reportdiv">  
      <div class="row">                               
        <div class="col-md-12">   
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title text-center">Report</h3>                                          
            </div>  
            <div class="box-body box-profile" style="padding:0px 5px 5px 5px;">
              <div class="info-box bg-yellow">
                      <span class="info-box-icon"><i class="fa fa-home"></i></span>

                      <div class="info-box-content">
                          <span class="info-box-text" style="text-align:right;">Last Leave Taken</span>
                           <div>
                            <h5><strong>Casual leave</strong></h5>
                            <p><strong>Date </strong>: 2019-Apr-25 to 2019-Apr-28</p>
                            <!-- <p><strong>Reason</strong>:  Casual leave</p> -->
                        </div>     
                      </div>
                  </div>
              <div class="info-box bg-green">
                <span class="info-box-icon"><i class="fa fa-rupee"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text" style="text-align:right;">Projection - <?php echo $school['mon'] ?></span>
                  <span class="info-box-number" style="font-size:14px;">Estimated : <i class="fa fa-rupee">&nbsp;</i><?php echo $pro_data['estimated']; ?></span>
                  <span class="progress-description">Collected : <i class="fa fa-rupee">&nbsp;</i><?php echo $pro_data['collected']; ?>
                  </span>
                  <span class="progress-description">Balance :
                    <i class="fa fa-rupee">&nbsp;</i><?php echo $pro_data['balance']; ?>
                  </span>
                </div>
              </div>
              <div class="">
                <div class="box box-info">
                  <div class="box-header with-border" style="background-color:#dd4b39 ">
                    <h3 class="box-title" style="color:#fff;">Today Time Table</h3>
                  </div>
                  <div class="box-body" style="padding:2px;">
                    <div class="table-responsive">
                      <table class="table no-margin">
                        <thead>
                          <tr>
                              <th>Period/Time</th>
                               <?php foreach ($period_cnt as $row) { ?>
                                <th style="color:#0000b3">
                                  <?php echo $row->period_name .' '.'('.$row->time_start.':'.$row->time_start_min.'-'.$row->time_end.':'.$row->time_end_min.')'; ?></th> 
                                  <?php } ?>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                              <td>Teacher</td>
                                <?php foreach ($period_cnt as $row) { ?>
                                <td style="color:#0000b3">
                                  <b><?php echo $row->classs_name.' ' .$row->sec_name .'--'.$row->subject_name; ?></b></td> 
                                  <?php } ?>     
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>                        
                </div>
              </div>
              <div class="">
                <div class="box box-info">
                  <div class="box-header with-border" style="background-color:#dd4b39 ">
                    <h3 class="box-title" style="color:#fff;">Today Attendance</h3>
                  </div>
                  <div class="box-body" style="padding:2px;">
                    <div class="table-responsive">
                      <table class="table no-margin">
                        <thead>
                          <tr>
                              <th>Class</th>
                              <th>Sec</th>
                              <th>Capture</th>
                              <th>SMS</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($attendance_data as $key => $value) { 
                            $send_sms=$value->sms;
                            if($send_sms=='YES')
                            {
                               $sms_val='<i class="fa fa-check" style="color:green"></i>';
                            }
                            else{
                               $sms_val='<i class="fa fa-close" style="color:red"></i>';
                            }
                            ?>
                          <tr>
                              <td><?php echo $value->class_name; ?></td>
                              <td><?php echo $value->section_name;?></td>
                              <td>YES</td>
                              <td><?php echo $sms_val; ?></td>
                          </tr>
                          <?php } ?>
                          
                        </tbody>
                      </table>
                    </div>
                  </div>                        
                </div>
              </div>
            </div>
          </div>       
        </div>                                               
      </div>             
    </div>
  </div>

<!--EVENT MODAL-->
  <div class="modal fade" id="tradition" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Your Profile is incomplete.</h4>
              <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
            </div>
            <div class="modal-body">
              <h4 style="text-transform:uppercase;"> Hey <?php echo $teacher_profile[0]->name ; ?>,</h4>
              <h4>We're Glad you're here. Please complete your profile.</h4>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" onclick="new1()">Update Your Profile</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
                
            </div>
            </div>
          </div>
       

  </div>  
  <!--EVENT MODAL-->
  
  
</section>

<script type="text/javascript">
  <?php if(($teacher_profile[0]->employee_code=='') ||($teacher_profile[0]->email=='')  ||($teacher_profile[0]->phone_no=='')|| ($teacher_profile[0]->gender=='')) { ?>
    $(window).on('load',function(){
        $('#tradition').modal('show'); 
    });
  <?php } ?>

  function new1()
  {
    window.location.assign("<?php echo base_url() ?>hr/staff/employees");
  }

    document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');

  var calendar = new FullCalendar.Calendar(calendarEl, {
    plugins: [ 'dayGrid', 'list', 'googleCalendar' ],
    header: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,listYear'
    },

    displayEventTime: false, // don't show the time column in list view
    googleCalendarApiKey: 'AIzaSyDcnW6WejpTOCffshGDDb4neIrXVUA1EAE',

    // US Holidays
    events: 'en.usa#holiday@group.v.calendar.google.com',

    eventClick: function(arg) {

      // opens events in a popup window
      window.open(arg.event.url, '_blank', 'width=700,height=600');

      // prevents current tab from navigating
      arg.jsEvent.preventDefault();
    }

  });

  calendar.render();
});
</script>
