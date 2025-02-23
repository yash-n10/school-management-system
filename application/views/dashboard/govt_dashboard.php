<style>
.panel , .box{
    box-shadow: 3px 3px 3px 2px #aaa;
}
.fc-title
{
    display:none;
}
.fc-event
{
    border:0px solid;
}

button.fc-listYear-button.fc-button.fc-button-primary {
    display: none!important;
}
button.fc-dayGridMonth-button.fc-button.fc-button-primary.fc-button-active {
    border-radius: 2px!important;
}
</style>
<div class="row" style="margin-bottom:20px;">
    <div class="col-md-12">
        <span class=""><i class="fa fa fa-user" style="font-size:30px;margin-top: 7px; float:left; padding-right:15px; color: #001f4d;"></i> </span> 
        <span class="school_head"><?php echo 'Welcome ,' . ' ' . $user_name; ?></span>
    </div>
</div>
<section class="content">
    <div class="row">
        <div class="col-md-12">
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="panel panel-default" style="border-top:2px solid #010d6d;;">

                <div class="panel-body">
                    <div class="row" style="padding-bottom:5%">
                        <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">
                            <span class="info-box-text">Total Students</span>
                        </div>                                                    
                    </div>

                    <div class="row">
                        <div class="col-sm-6 col-lg-6 col-md-6 col-xs-6">
                            <img src="<?php echo base_url(''); ?>assets/AdminLTE/dist/img/icon/total-stud.PNG" width="62px" height="48px">
                        </div>
                        <div class="col-sm-6 col-lg-6 col-md-6 col-xs-6" >

                            <h2 class="no-margin" style="font-size:35px;text-align: right"><?php echo $total_students; ?></h2>
                        </div>
                    </div>
                </div>
            </div>

        </div>


       <?php if($this->school1[0]->school_group=='ARMY'){?> 
             <div class="col-lg-6 col-md-6 col-sm-9 col-xs-12">
                <div class="panel panel-default" style="border-top:2px solid #010d6d;;">

                    <div class="panel-body">
                        <div class="row" style="padding-bottom:5%">
                            <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">
                                <a href="<?php echo base_url('admission/student'); ?>"><span class="info-box-text">Pending Students </span></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-lg-6 col-md-6 col-xs-6">
                                <a href="<?php echo base_url('admission/student'); ?>"><img src="<?php echo base_url(''); ?>assets/AdminLTE/dist/img/icon/pending.jpg" width="62px" height="48px"></a>
                            </div>
                            <div class="col-sm-6 col-lg-6 col-md-6 col-xs-6" >

                                <a href="<?php echo base_url('admission/student'); ?>" style="color:black"><h2 class="no-margin" style="font-size:35px;text-align: right"><?php echo $total_pending; ?></h2></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         <?php }else{?>
                 <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="panel panel-default" style="border-top:2px solid #010d6d;;">

                    <div class="panel-body">
                        <div class="row" style="padding-bottom:5%">
                            <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">
                                <span class="info-box-text">Total Staff </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-lg-6 col-md-6 col-xs-6">
                                <img src="<?php echo base_url(''); ?>assets/AdminLTE/dist/img/icon/dash-register-student.PNG" width="62px" height="48px">
                            </div>
                            <div class="col-sm-6 col-lg-6 col-md-6 col-xs-6" >

                                <h2 class="no-margin" style="font-size:35px;text-align: right"><?php echo $total_registered; ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
         <?php } ?>

            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="panel panel-default" style="border-top:2px solid #010d6d;;">

                <div class="panel-body">
                    <div class="row" style="padding-bottom:5%">
                        <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">
                            <span class="info-box-text">Total School</span>
                        </div>                                                    
                    </div>

                    <div class="row">
                        <div class="col-sm-6 col-lg-6 col-md-6 col-xs-6">
                            <img src="<?php echo base_url(''); ?>assets/AdminLTE/dist/img/icon/dash-hostel.png" width="62px" height="48px">
                        </div>
                        <div class="col-sm-6 col-lg-6 col-md-6 col-xs-6" >

                            <h2 class="no-margin" style="font-size:35px;text-align:right">2</h2>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="clearfix visible-sm-block"></div>
        </div>
         <div class='col-md-1'></div>
        <?php 
            if($this->school1[0]->school_group=='ARMY'){?> 
             <div class='col-md-4' style="margin-top: -63px;"> 
                <img style="height: 180px; width: 80%; display: block;" src="http://www.apsranchi.com/images/DSC_0331-2-2-2.jpg" alt="Card image">
            </div>  
        <?php } else { } ?>
    </div>
    <br>
    
        <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card text-white bg-primary mb-3">
              <div class="card-header">Shortcut Links</div>
              <div class="card-body" style="-webkit-box-flex: 1;-ms-flex: 1 1 auto;flex: 1 1 auto;padding: 1.25rem;background-color:#f6f6f6">

            <div class="row">
                <div class="col-sm-2">
                    <a class="quick-btn" href="<?php echo base_url('admission/student'); ?>">
                        <img src="<?php echo base_url(''); ?>assets/img/dashboard_icon/students.png" style="width:75px;height:70px"><br/>
                        <label class="shortclink_name">Students</label>                       
                    </a>
                </div>
                 
                  <div class="col-sm-2">
                    <a class="quick-btn" href="<?php echo base_url('hr/payroll/salary_structure'); ?>">
                        <img src="<?php echo base_url(''); ?>assets/img/dashboard_icon/hr.png" style="width:75px;height:70px;"><br/>
                        <label class="shortclink_name">Payroll</label>
                    </a>
                  </div>  
                   <div class="col-sm-2">
                    <a class="quick-btn" href="<?php echo base_url('inventory/Stock_report'); ?>">
                        <img src="<?php echo base_url(''); ?>assets/img/dashboard_icon/inventory.png" style="width:75px;height:70px"><br/>
                        <label class="shortclink_name">Inventory</label>
                    </a>
                  </div> 
                   
                  <div class="col-sm-2">
                    <a class="quick-btn" href="<?php echo base_url('certificate/certificate'); ?>">
                        <img src="<?php echo base_url(''); ?>assets/img/dashboard_icon/exams.png" style="width:75px;height:70px;"><br/>
                        <label class="shortclink_name"> Certificate</label>
                    </a>
                </div>
                </div>
              </div>
          </div>
      </div>
  </div> 
    
    
     <!--<div class="row">-->
<!--        <div class="col-lg-2 col-xs-6">
			<a class="quick-btn" href="#">
				<img src="<?php echo base_url(''); ?>assets/AdminLTE/dist/img/icon/dash-communication.png" ><br/>
				<span> Communication</span>
				<span class="label label-danger">2</span>
			</a>
        </div>
         ./col 
        <div class="col-lg-2 col-xs-6">
			<a class="quick-btn" href="<?php // echo base_url('admission/student'); ?>">
				<img src="<?php // echo base_url(''); ?>assets/AdminLTE/dist/img/icon/dash-student.png" ><br/>
				<span> Stud Management</span>
				<span class="label label-success">2</span>
			</a>
        </div>
         ./col 
        <div class="col-lg-2 col-xs-6">
			<a class="quick-btn" href="<?php // echo base_url('hr/payroll/salary_structure'); ?>">
				<img src="<?php // echo base_url(''); ?>assets/AdminLTE/dist/img/icon/dash-hr.png" ><br/>
				<span> Hr Management</span>
				<span class="label label-warning">2</span>
			</a>
        </div>
         ./col 
        <div class="col-lg-2 col-xs-6">
			<a class="quick-btn" href="<?php // echo base_url('account/ledger'); ?>">
				<img src="<?php // echo base_url(''); ?>assets/AdminLTE/dist/img/icon/dash-account.png" ><br/>
				<span> Accounts</span>
				<span class="label btn-metis-4">2</span>
			</a>
        </div>
        <div class="col-lg-2 col-xs-6">
			<a class="quick-btn" href="<?php // echo base_url('inventory/Goods'); ?>">
				<img src="<?php // echo base_url(''); ?>assets/AdminLTE/dist/img/icon/dash-inventory.png" ><br/>
				<span> Inventory</span>
				<span class="label label-success">2</span>
			</a>
        </div>
        <div class="col-lg-2 col-xs-6">
			<a class="quick-btn" href="<?php // echo base_url('library/books'); ?>">
				<img src="<?php // echo base_url(''); ?>assets/AdminLTE/dist/img/icon/dash-library.png" ><br/>
				<span> Library</span>
				<span class="label label-warning">2</span>
			</a>
        </div>	

        <div class="col-lg-2 col-xs-6">
			<a class="quick-btn" href="#">
				<img src="<?php // echo base_url(''); ?>assets/AdminLTE/dist/img/icon/dash-attendance.png" ><br/>
				<span> Attendance</span>
				<span class="label label-danger">2</span>
			</a>
        </div>
         ./col 
        <div class="col-lg-2 col-xs-6">
			<a class="quick-btn" href="<?php // echo base_url('academics/Exam_schedule'); ?>">
				<img src="<?php // echo base_url(''); ?>assets/AdminLTE/dist/img/icon/dash-exam.png" ><br/>
				<span> Examination</span>
				<span class="label label-success">2</span>
			</a>
        </div>
         ./col 
        <div class="col-lg-2 col-xs-6">
			<a class="quick-btn" href="#">
				<img src="<?php // echo base_url(''); ?>assets/AdminLTE/dist/img/icon/dash-hostel.png" ><br/>
				<span> Hostel</span>
				<span class="label label-warning">2</span>
			</a>
        </div>-->
        <!-- ./col -->
<!--        <div class="col-sm-2 col-lg-2 col-xs-4">
			<a class="quick-btn" href="<?php echo base_url('feepayment/class_fee'); ?>">
				<img src="<?php echo base_url(''); ?>assets/AdminLTE/dist/img/icon/fee-structure.PNG" style="box-shadow: 3px 5px 3px 0px #ddd"><br/>
				<label style="    color: #005cb7;"> Class Fee</label>
				<span class="label btn-metis-4">2</span>
			</a>
        </div>
        <div class="col-sm-2 col-lg-2 col-xs-4">
			<a class="quick-btn" href="<?php echo base_url('feepayment/collection/Offline_payment'); ?>">
				<img src="<?php echo base_url(''); ?>assets/AdminLTE/dist/img/icon/fee-collect.PNG" style="box-shadow: 3px 5px 3px 0px #ddd"><br/>
				<label style="    color: #005cb7;"> Fee Collect</label>
				<span class="label btn-metis-4">2</span>
			</a>
        </div>
        <div class="col-sm-2 col-lg-2 col-xs-4">
			<a class="quick-btn" href="<?php echo base_url('feepayment/report/fee_summary'); ?>">
				<img src="<?php echo base_url(''); ?>assets/AdminLTE/dist/img/icon/fee-report.png" style="box-shadow: 3px 5px 3px 0px #ddd"><br/>
				<label style="    color: #005cb7;"> Fee Report</label>
				<span class="label btn-metis-4">2</span>
			</a>
        </div>-->
<!--        <div class="col-lg-2 col-xs-6">
			<a class="quick-btn" href="<?php // echo base_url('masters/programme'); ?>">
				<img src="<?php // echo base_url(''); ?>assets/AdminLTE/dist/img/icon/dash-course.png" ><br/>
				<span> Course</span>
				<span class="label label-success">2</span>
			</a>
        </div>
        <div class="col-lg-2 col-xs-6">
			<a class="quick-btn" href="#">
				<img src="<?php // echo base_url(''); ?>assets/AdminLTE/dist/img/icon/dash-calendar.png" ><br/>
				<span> Calender</span>
				<span class="label label-warning">2</span>
			</a>
        </div>	
        <div class="col-lg-2 col-xs-6">
			<a class="quick-btn" href="<?php // echo base_url('hr/staff/employees'); ?>">
				<img src="<?php // echo base_url(''); ?>assets/AdminLTE/dist/img/icon/dash-staff.png" ><br/>
				<span> Staff Management</span>
				<span class="label label-warning">2</span>
			</a>
        </div>
        <div class="col-lg-2 col-xs-6">
			<a class="quick-btn" href="<?php // echo base_url('academics/faculty_subject_allo'); ?>">
				<img src="<?php // echo base_url(''); ?>assets/AdminLTE/dist/img/icon/dash-academics.png" ><br/>
				<span> Academics</span>
				<span class="label label-warning">2</span>
			</a>
        </div>
        <div class="col-lg-2 col-xs-6">
			<a class="quick-btn" href="#">
				<img src="<?php // echo base_url(''); ?>assets/AdminLTE/dist/img/icon/setting.svg" width="64"><br/>
				<span>Profile Settings</span>
			</a>
        </div>		-->
        <!-- ./col -->
      <!--</div>-->
    <br>
    <br>

  
    <div class="row" style="display:none;">

        <div class="col-lg-8 col-md-8">
            <div class="panel panel-default box box-solid">
                <div class="panel-heading box-header" style="background:#FF6666 ;padding: 5px 15px;color:white">
                    <label> <h4 class="box-title" style="color:white;">Transaction Overview </h4></label>
                    <!-- tools box -->
                    <div class="pull-right box-tools">
                        <button type="button" class="btn btn-success btn-sm" data-widget="collapse" style="border-radius: 15px;padding: 2px 7px;background: #E60000"><i class="fa fa-minus"></i>
                        </button>

                    </div>

                </div>  
                <ul class="nav nav-tabs">
                    <?php if($this->session->userdata('school_id')!=9){ ?>
                    <li ><a data-toggle="tab" href="#tabular" >Tabular data</a></li>
                    <?php } ?>
                    <li class="active"><a data-toggle="tab" href="#linechartdiv" >Payment Analytics 1</a></li>
                    <li><a data-toggle="tab" href="#barchartdiv" id="abarchart">Payment Analytics 2</a></li>
                    <li><a data-toggle="tab" href="#payanalydiv" id="apaychart">Payment Trends 1</a></li>
                    <li><a data-toggle="tab" href="#payanalydiv1" id="apaychart1">Payment Trends 2</a></li>
 
                </ul>
                <div class="panel-body box-footer text-black  " >
                    <div class="tab-content">
                        <div class="table-responsive tab-pane fade" id="tabular">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                            Month
                                        </th>
                                        <th>
                                            Total Collection
                                        </th>
                                        <th>
                                            Offline Collection
                                        </th>
                                        <th>
                                            Offline Transaction Count
                                        </th>
                                        <th>
                                            Online Collection
                                        </th>
                                        <th>
                                            Online Transaction Count
                                        </th>

                                    </tr>
                                </thead>

                                <tbody id="amount_det" style="text-align: right">
                                    <?php
                                    $arr=array('1'=>4,'2'=>5, '3'=>6, '4'=>7, '5'=>8, '6'=>9, '7'=>10, '8'=>11, '9'=>12, '10'=>1, '11'=>2, '12'=>3);
                                    $offline_arr = $online_arr=$success_pay=$failure_pay=$visiting_pay=$halfsuccess = array();
                                    for ($j = 1; $j <= $school['mnth']; $j++) {
                                        $yearmn=($j >= 1 && $j <= 9)?$school['session_start_yr']:$school['session_end_yr'];
                                        $amount=dash_per_month_amount($school['yearquery'],$arr[$j],$yearmn,$school['strquery3']);                     
                                        $offline_arr[] = $amount[0]->amt;
                                        $online_arr[] = $amount[0]->amnt;
                                        $payment_analytics= dash_payment_analytics($school['yearquery'],$arr[$j],$yearmn);
                                        $success_pay[] = $payment_analytics[0]->success_count;
                                        $failure_pay[] = $payment_analytics[0]->failure_count;
                                        $visiting_pay[] = $payment_analytics[0]->visiting_count;
                                        $halfsuccess[] = $payment_analytics[0]->hcount;
                                        $total=$amount[0]->amnt+$amount[0]->amt;
                                        ?>
                                        <tr>
                                            <td> <?php
                                                if ($school['mnth'] >= 1 && $school['mnth'] <= 9) {
                                                    echo date("M", mktime(0, 0, 0, ($j + 3), 10));
                                                } else {
                                                    echo date("M", mktime(0, 0, 0, ($j - 9), 10));
                                                }
                                                ?>  </td>
                                            <td> <?php
                                                if ( $total!= 0) {
                                                    echo '&#8377; ' . number_format($amount[0]->amnt+$amount[0]->amt);
                                                } else {
                                                    echo ' ';
                                                }
                                                ?> </td>
                                            <td> <?php
                                            if ($amount[0]->amt != '' || $amount[0]->amt != 0) {
                                                echo '&#8377; ' . number_format($amount[0]->amt);
                                            } else {
                                                echo ' ';
                                            }
                                                ?> </td>
                                            <td> <?php echo $amount[0]->off_cnt ?></td>
                                            <td> <?php
                                            if ($amount[0]->amnt != '' || $amount[0]->amnt != 0) {
                                                echo '&#8377; ' . number_format($amount[0]->amnt);
                                            } else {
                                                echo ' ';
                                            }
                                            ?> </td>
                                            <td> <?php echo $amount[0]->on_cnt ?></td>

                                        </tr>
<?php } ?>  
                                </tbody>



                            </table>
                        </div>
                        <div class="chart tab-pane fade in active" id="linechartdiv">
                            <canvas id="lineChart" style="height:250px"></canvas>
                        </div>
                        <div class="chart1 tab-pane fade" id="barchartdiv">
                            <canvas id="barChart" style="height:250px;"></canvas>
                        </div>
                        <div class="chart2 tab-pane fade" id="payanalydiv">
                            <canvas id="payanalyChart" style="height:650px;"></canvas>
                           
                        </div>
                        <div class="chart4 tab-pane fade" id="payanalydiv1">
                            
                            <canvas id="linepayanalyChart" style="height:650px;"></canvas>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <div class="col-lg-4 col-md-4">
            <div class="panel panel-default box box-solid">
                <div class="panel-heading box-header" style="background:#2ACAFF;padding: 5px 15px">
                    <label> <h4 class="box-title" style="color:white">Defaulter Overview</h4> </label>
                    <div class="pull-right box-tools">
                         <a type="button" onclick="defaulters();" class="btn btn-success btn-sm" style="border-radius: 15px;padding: 2px 7px;background: #0099CC" title="View Deatils"> <i class="fa fa-list"></i>
                        </a>
                        <button type="button" class="btn btn-success btn-sm" data-widget="collapse" style="border-radius: 15px;padding: 2px 7px;background: #0099CC"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="panel-body box-footer text-black" >
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th> Type  </th>  
                                    <th> Count </th>  
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td> Annual </td>
                                    <td> <?php echo $school['defaulter_ann'] ?> </td>
                                </tr>

                                <tr>
                                    <td> Monthly </td>
                                    <td> <?php echo $school['defaulter_mon'] ?> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="chart3">
                            <canvas id="pieChart" style="height:250px"></canvas>
                    </div>
                </div>

            </div>
        </div>
    </div>  
</section>
    <section class="content">
    <div class="col-md-8">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo get_phrase('calendar'); ?></h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">              
               <div id='calendar'></div> 
           </div>
       </div>
   </div>
  <div class="col-md-4">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo get_phrase('noticeboard'); ?></h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>            
        </div>
        <div class="box-body">
            <ul class="timeline">
                <?php
                $this->db->order_by('create_timestamp', 'desc');
                $this->db->limit('15');
                $notices = $this->db->get('noticeboard')->result_array();

                $lastdate = '';

                foreach ($notices as $row):
                    $rowdate = date('Y-m-d', $row['create_timestamp']);
                    $rowdatedisp = date('l, jS F Y', $row['create_timestamp']);
                    $rowtimedisp = date('H:i:s', $row['create_timestamp']);
                    if ($rowdate != $lastdate) {
                        $lastdate = $rowdate;
                        ?>
                       
                        <li class="time-label">
                            <span class="bg-red">
                                <?= $rowdatedisp ?>
                            </span>
                        </li>
                        <?php
                    }
                    ?>
                    <li>
                        <i class="fa fa-envelope bg-blue"></i>
                        <div class="timeline-item">
                            <span class="time"><i class="fa fa-clock-o"></i> <?= $rowtimedisp ?></span>

                            <h3 class="timeline-header"><?php echo $row['notice_title']; ?></h3>

                            <div class="timeline-body">
                                <?php echo $row['notice']; ?>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>    
</div> 
</section>

<script src="<?php echo base_url(''); ?>assets/AdminLTE/bower_components/chart.js/Chart.bundle.min.js"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>-->
<script>

    var lineChartData = {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec", "Jan", "Feb", "Mar"],
        datasets: [
            {
                label: "Offline",
                fillColor: "rgba(220,220,220,0.2)",
                strokeColor: "rgba(220,220,220,1)",
                pointColor: "rgba(220,220,220,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: <?php echo json_encode($offline_arr); ?>

            },
            {
                label: "Online",
                fillColor: "rgba(151,187,205,0.2)",
                strokeColor: "rgba(151,187,205,1)",
                pointColor: "rgba(151,187,205,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(151,187,205,1)",
                data: <?php echo json_encode($online_arr); ?>
            }
        ]

    }
//Line Chart
    new Chart(document.getElementById("lineChart"), {
        type: 'line',
        data: {
            labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec", "Jan", "Feb", "Mar"],
            datasets: [{
                    data: <?php echo json_encode($offline_arr); ?>,
                    label: "Offline",
                    borderColor: "#3e95cd",
                    borderWidth:2,
                    fill: false
                }, {
                    data: <?php echo json_encode($online_arr); ?>,
                    label: "Online",
                    borderColor: "#8e5ea2",
                    borderWidth:2,
                    fill: false
                }
            ]
        },
        options: {
            title: {
                display: true,
                text: 'Monthly Amount Collection'
            }
        }
    });

    $('#abarchart').click(function () {

        new Chart(document.getElementById("barChart"), {
            type: 'bar',
            data: {
                labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec", "Jan", "Feb", "Mar"],
                datasets: [{
                        data: <?php echo json_encode($offline_arr); ?>,
                        label: "Offline",
                        fill:false,
                        borderColor: "rgba(255, 159, 64,1)",
                        backgroundColor: "rgba(255, 159, 64, 0.2)",
                        borderWidth:3
                    
                    }, {
                        data: <?php echo json_encode($online_arr); ?>,
                        label: "Online",
                        fill:false,
                        borderColor: "rgba(75, 192, 192,1)",
                        backgroundColor: "rgba(75, 192, 192, 0.2)",
                        borderWidth:3
                       
                    }
                ]
            },
            options: {
//                legend: {display: false},
                title: {
                    display: true,
                    text: 'Monthly Amount Collection'
                }
            }
        });


    });



// Pie chart for defaulter

    new Chart(document.getElementById("pieChart"), {
        type: 'pie',
        data: {
          labels: ["Annual", "Monthly"],
          datasets: [{
            label: "Defaulters",
//            backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
            backgroundColor: ["#3e95cd", "#3cba9f"],
            data: ['<?php echo $school['defaulter_ann'];?>','<?php echo $school['defaulter_mon'];?>']
          }]
        },
        options: {
          title: {
            display: false,
            text: 'Defaulters'
          }
        }
    });
    
    
        
  $('#apaychart').click(function () {  
    new Chart(document.getElementById("payanalyChart"), {
    type: 'radar',
    data: {
      labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec", "Jan", "Feb", "Mar"],
      datasets: [
        {
          label: "Success",
          fill: true,
          backgroundColor: "rgba(75, 192, 192,0.2)",
          borderColor: "rgba(75, 192, 192,1)",
          borderWidth:2,
          pointBorderColor: "#fff",
          pointBackgroundColor: "rgba(75, 192, 192,1)",
          data: <?php echo json_encode($success_pay); ?>
        }, {
          label: "failure",
          fill: true,
          backgroundColor: "rgba(255,99,132,0.2)",
          borderColor: "rgba(255,99,132,1)",
          borderWidth:2,
          pointBorderColor: "#fff",
          pointBackgroundColor: "rgba(255,99,132,1)",
          pointBorderColor: "#fff",
          data: <?php echo json_encode($failure_pay); ?>
        }, {
          label: "Gateway Visiting",
          fill: true,
          backgroundColor: "rgba(54, 162, 235,0.2)",
          borderColor: "rgba(54, 162, 235,1)",
          borderWidth:2,
          pointBorderColor: "#fff",
          pointBackgroundColor: "rgba(54, 162, 235,1)",
          pointBorderColor: "#fff",
          data: <?php echo json_encode($visiting_pay); ?>
        }, {
          label: "Partial Success",
          fill: true,
          backgroundColor: "rgba(247, 141, 49,0.2)",
          borderColor: "rgba(247, 141, 49,1)",
          borderWidth:2,
          pointBorderColor: "#fff",
          pointBackgroundColor: "rgba(247, 141, 49,1)",
          pointBorderColor: "#fff",
          data: <?php echo json_encode($halfsuccess); ?>
        }
        
      ]
    },
    options: {
      title: {
        display: true,
        text: 'Payment Trends Radar Chart'
      }
    }
});

});

$('#apaychart1').click(function () { 
new Chart(document.getElementById("linepayanalyChart"), {
  type: 'line',
  data: {
    labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec", "Jan", "Feb", "Mar"],
    datasets: [{ 
        data: <?php echo json_encode($success_pay); ?>,
        label: "Success",
       borderColor: "rgb(75, 192, 192)",
       backgroundColor:"rgba(75, 192, 192,0.1)",
        borderWidth:2,
        
      }, { 
        data: <?php echo json_encode($failure_pay); ?>,
        label: "Failure",
        borderColor: "rgb(159, 104, 186)",
        backgroundColor:"rgba(159, 104, 186,0.1)",
        borderWidth:2,
        
      }, { 
        data: <?php echo json_encode($visiting_pay); ?>,
        label: "Gateway Visiting",
        borderWidth:2,
         borderColor: "rgb(244, 188, 48)",
         backgroundColor:"rgba(244, 188, 48,0.1)",
        
      }, { 
        data: <?php echo json_encode($halfsuccess); ?>,
        label: "Partial Success",
        borderWidth:2,
         borderColor: "rgb(247, 141, 49)",
         backgroundColor:"rgba(247, 141, 49,0.1)",
        
      }
    ]
  },
  options: {
    title: {
      display: true,
      text: 'Payment Trends Area Chart'
    }
  }
});




  });
  
  document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');

      var calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: [ 'dayGrid', 'list', 'googleCalendar' ],
        header: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,listYear'
      },

    displayEventTime: false, 
    // http://fullcalendar.io/docs/google_calendar/
    googleCalendarApiKey: 'AIzaSyDcnW6WejpTOCffshGDDb4neIrXVUA1EAE',
    events: 'en.usa#holiday@group.v.calendar.google.com',

    eventClick: function(arg) {
      window.open(arg.event.url, '_blank', 'width=700,height=600');
      arg.jsEvent.preventDefault();
  }

});

      calendar.render();
  });
  
  
  function defaulters()
  {
      window.location.href="<?php echo base_url('feepayment/report/defaulters');?>";
  }


</script>
