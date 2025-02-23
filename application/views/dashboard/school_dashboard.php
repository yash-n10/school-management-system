<style>
    .panel , .box{
        box-shadow: 3px 3px 3px 2px #aaa;
    }
    /*    tr:nth-child(odd) {background-color: #f2f2f2;}*/
</style>


<!-- Main content -->
<div class="row" style="margin-bottom:20px;">
    <div class="col-md-12">
        <span class=""><i class="fa fa fa-user" style="font-size:50px; float:left; padding-right:15px; color: #001f4d;"></i> </span> 
        <span class="" style="font-size:30px; color: #990000;"><?php echo 'Welcome ,' . ' ' . $user_name; ?></span>
    </div>
</div>
<section class="content">
    <!-- Info boxes -->

    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-9 col-xs-12">
            <div class="panel panel-default" style="border-top:2px solid #3c8dbc;">

                <div class="panel-body">
                    <!--<div class="content-group-sm svg-center position-relative" id="hours-available-progress">-->
                    <!--                                                        <svg height="80" width="80" style=" margin: auto;text-align: center;">
                    <g transform="translate(38,38)">
                    <path style="fill: rgb(240, 98, 146);" d="M0,38A38,38 0 1,1 0,-38A38,38 0 1,1 0,38M0,36A36,36 0 1,0 0,-36A36,36 0 1,0 0,36Z" class="d3-progress-background"></path>
                    <path d="M2.326828918379971e-15,-38A38,38 0 1,1 -34.38342799370878,16.179613079472677L-32.57377388877674,15.328054496342538A36,36 0 1,0 2.204364238465236e-15,-36Z" style="fill: rgb(240, 98, 146); stroke: rgb(240, 98, 146);" filter="url(#blur)" class="d3-progress-foreground"></path>
                    <path d="M2.326828918379971e-15,-38A38,38 0 1,1 -34.38342799370878,16.179613079472677L-32.57377388877674,15.328054496342538A36,36 0 1,0 2.204364238465236e-15,-36Z" style="fill: rgb(240, 98, 146); fill-opacity: 1;" class="d3-progress-front"></path>
                    </g>
                    <circle cx="40" cy="40" r="35" stroke="pink" stroke-width="2" fill="transparent" />
                    </svg>-->
                    <!--<i class="fa fa-graduation-cap fa-5x" style="top:34px;font-size: 32px;position: absolute;left: 37%;margin-left: -9%;"></i>-->
                    <div class="row" style="padding-bottom:5%">
                        <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">
                            <span class="info-box-text" style="color: #3c8dbc;font-weight: bold;font-size: 15px; text-align: center">Total Students</span>
                        </div>                                                    
                    </div>

                    <div class="row">
                        <div class="col-sm-6 col-lg-6 col-md-6 col-xs-6">
                            <i class="fa fa-graduation-cap" style="font-size: 50px;color: lightskyblue;"></i>
                        </div>
                        <div class="col-sm-6 col-lg-6 col-md-6 col-xs-6" >

                            <h2 class="no-margin" style="font-size:35px;text-align: right"><?php echo $total_students; ?></h2>
                        </div>
                    </div>


                    <!--</div>-->
                </div>
            </div>

        </div>


        <div class="col-lg-3 col-md-6 col-sm-9 col-xs-12">
            <div class="panel panel-default" style="border-top:2px solid #3c8dbc;">

                <div class="panel-body">

                    <div class="row" style="padding-bottom:5%">
                        <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">
                            <span class="info-box-text" style="color: #3c8dbc;font-weight: bold;font-size: 15px; text-align: center">Total Registered Students </span>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-lg-6 col-md-6 col-xs-6">
                            <i class="fa fa-users" style="font-size: 50px;color: lightskyblue;"></i>
                        </div>
                        <div class="col-sm-6 col-lg-6 col-md-6 col-xs-6" >

                            <h2 class="no-margin" style="font-size:35px;text-align: right"><?php echo $total_registered; ?></h2>
                        </div>
                    </div>


                    <!--</div>-->
                </div>
            </div>

        </div>

        <div class="clearfix visible-sm-block"></div>




    </div>
<!--    <div class="row">

        <div class="col-lg-8 col-md-8">
            <div class="panel panel-default box box-solid">
                <div class="panel-heading box-header" style="background:#FF6666 ;padding: 5px 15px;color:white">
                    <label> <h4 class="box-title" style="color:white;">Transaction Overview </h4></label>
                     tools box 
                    <div class="pull-right box-tools">
                        <button type="button" class="btn btn-success btn-sm" data-widget="collapse" style="border-radius: 15px;padding: 2px 7px;background: #E60000"><i class="fa fa-minus"></i>
                        </button>

                    </div>

                </div>  
                <ul class="nav nav-tabs">
                    <li ><a data-toggle="tab" href="#tabular" >Tabular data</a></li>
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
                                    $offline_arr = $online_arr=$success_pay=$failure_pay=$visiting_pay=$halfsuccess = array();
                                    for ($j = 1; $j <= $school['mnth']; $j++) {

                                        $offline_arr[] = $school['offline'][$j];
                                        $online_arr[] = $school['online'][$j];
                                        $success_pay[] = $school['success_payment_cnt'][$j];
                                        $failure_pay[] = $school['failure_payment_cnt'][$j];
                                        $visiting_pay[] = $school['visiting_payment_cnt'][$j];
                                        $halfsuccess[] = $school['halfsuccess_payment_cnt'][$j];
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
                                                if ($school['total'][$j] != 0) {
                                                    echo '&#8377; ' . number_format($school['total'][$j]);
                                                } else {
                                                    echo ' ';
                                                }
                                                ?> </td>
                                            <td> <?php
                                            if ($school['offline'][$j] != '' || $school['offline'][$j] != 0) {
                                                echo '&#8377; ' . number_format($school['offline'][$j]);
                                            } else {
                                                echo ' ';
                                            }
                                                ?> </td>
                                            <td> <?php echo $school['offline_cnt'][$j] ?></td>
                                            <td> <?php
                                            if ($school['online'][$j] != '' || $school['online'][$j] != 0) {
                                                echo '&#8377; ' . number_format($school['online'][$j]);
                                            } else {
                                                echo ' ';
                                            }
                                            ?> </td>
                                            <td> <?php echo $school['online_cnt'][$j] ?></td>

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

    </div>    -->
    <div class="row">


    </div>

    <div class="row">
        <div class="col-lg-8 col-md-8">
            <div class="panel panel-default box box-solid">
                <div class="panel-heading box-header" style="background:#47d1d1;padding: 5px 15px">
                    <label><h4 class="box-title" style="color:white">Class Wise Transaction Overview for <?php echo $school['mon']; ?></h4>  </label>
                    <!-- tools box -->
                    <div class="pull-right box-tools">
                        <button type="button" class="btn btn-success btn-sm" data-widget="collapse" style="border-radius: 15px;padding: 2px 7px;background: #019191"><i class="fa fa-minus"></i>
                        </button>
                        <!--                                      <button type="button" class="btn btn-success btn-sm" data-widget="remove" style="border-radius: 15px;padding: 2px 7px;"><i class="fa fa-times"></i>
                        </button>-->
                    </div>
                    <!-- /. tools -->

                </div>
                <ul class="nav nav-tabs">
                    <li ><a data-toggle="tab" href="#classtabular" >Tabular data</a></li>
                    <li ><a data-toggle="tab" href="#classstrengthgraph" >Strength Graph</a></li>
                    <li><a data-toggle="tab" href="#lineclasschartdiv" id="alineclasschart">Payment Analytics 1</a></li>
                    <li class="active"><a data-toggle="tab" href="#barclasschartdiv" id="abarclasschart">Payment Analytics 2</a></li>
         

                </ul>
                <div class="panel-body box-footer text-black" >
                    <div class="tab-content">
                        <div class="table-responsive tab-pane fade" id="classtabular">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Class Name</th>
                                        <th>Total Student</th>
                                        <th>Offline Collection </th>
                                        <th>Offline Count</th>
                                        <th>Online Collection</th>
                                        <th>Online Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $classoffline_arr = $classonline_arr=$classstrength=array();
                                    foreach ($school['class'] as $name => $details) { 
                                        $classoffline_arr[]=$details['offline_amnt'];
                                        $classonline_arr[]=$details['online_amnt'];
                                        $classstrength[]=$details['total_class_student'];
                                        ?>
                                        <tr>
                                            <td> <?php echo $name; ?></td>
                                            <td><?php echo isset($details['total_class_student']) ? $details['total_class_student'] : '0'; ?></td>
                                            <td> <?php echo isset($details['offline_amnt']) ? '&#8377; ' . $details['offline_amnt'] : '0 '; ?></td>
                                            <td> <?php echo isset($details['offline_cunt']) ? $details['offline_cunt'] : '0'; ?></td>
                                            <td><?php echo isset($details['online_amnt']) ? '&#8377; ' . $details['online_amnt'] : '0 '; ?></td>
                                            <td><?php echo isset($details['online_cunt']) ? $details['online_cunt'] : '0'; ?></td>
                                        </tr>  
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="chart tab-pane fade " id="classstrengthgraph">
                            <canvas id="classstrengthChart" style="height:350px"></canvas>
                        </div>
                        <div class="chart tab-pane fade " id="lineclasschartdiv">
                            <canvas id="classlineChart" style="height:250px"></canvas>
                        </div>
                        <div class="chart1 tab-pane fade in active" id="barclasschartdiv">
                            <canvas id="classbarChart" style="height:250px;"></canvas>
                        </div>
                    </div>
                    
                </div>


            </div>
        </div>


        <div class="col-lg-4 col-md-4">
            <div class="panel panel-default box box-solid">
                <div class="panel-heading box-header" style="background:#FF4D70;padding: 5px 15px">
                    <label><h4 class="box-title" style="color:white">Class Wise Defaulter</h4> </label>
                    <div class="pull-right box-tools">
                        <button type="button" class="btn btn-success btn-sm" data-widget="collapse" style="border-radius: 15px;padding: 2px 7px;background:#ce0029"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <ul class="nav nav-tabs">
                    <li ><a data-toggle="tab" href="#classdefaultertabular" id="aclassdefaultabular">Tabular data</a></li>
                    <li class="active"><a data-toggle="tab" href="#classdefaultergraph"  id="aclassdefaulgraph">Graphical data</a></li>

                </ul>
                <div class="panel-body box-footer text-black" >
                    <div class="tab-content">
                        <div class="table-responsive tab-pane fade" id="classdefaultertabular">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th> Class  </th>  
                                        <th> Monthly </th>  
                                        <th> Annual </th>  
                                    </tr>
                                </thead>
                                <tbody>
    <?php 
    $class_name_arr=$class_mondefaul_arr=$class_anndefaul_arr=array();
        foreach ($school['class'] as $name => $details) { 
            $class_name_arr[]=$name;
            $class_mondefaul_arr[]=$details['defaulter'];
            $class_anndefaul_arr[]=$details['ann1_defaulter'];
            ?>
                                        <tr>
                                            <td> <?php echo $name; ?></td> 
                                            <td> <?php echo $details['defaulter']; ?> </td>
                                            <td> <?php echo $details['ann1_defaulter']; ?> </td>
                                        </tr>
    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="chart4 tab-pane fade in active" id="classdefaultergraph">
                                <canvas id="classdefaulChart" style="height:800px"></canvas>
                                <canvas id="classdefaulChart1" style="height:800px"></canvas>
                        </div>
                    </div>
                    
                </div>

            </div>
        </div>

    </div>
    <!-- /.row -->
</section>
<section class="content">
    <!-- /.col -->
    <div class="col-md-3">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo get_phrase('noticeboard'); ?></h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
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
                            <!-- timeline time label -->
                            <li class="time-label">
                                <span class="bg-red">
        <?= $rowdatedisp ?>
                                </span>
                            </li>
                            <!-- /.timeline-label -->

        <?php
    }
    ?>
                        <!-- timeline item -->
                        <li>
                            <!-- timeline icon -->
                            <i class="fa fa-envelope bg-blue"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fa fa-clock-o"></i> <?= $rowtimedisp ?></span>

                                <h3 class="timeline-header"><?php echo $row['notice_title']; ?></h3>

                                <div class="timeline-body">
    <?php echo $row['notice']; ?>
                                </div>
                            </div>
                        </li>
                        <!-- END timeline item -->
<?php endforeach; ?>
                </ul>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo get_phrase('calendar'); ?></h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                Calendar goes here
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</section>
<script src="<?php echo base_url(''); ?>assets/AdminLTE/bower_components/chart.js/Chart.bundle.min.js"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>-->
<script>

//    var randomScalingFactor = function(){ return Math.round(Math.random()*100)};



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

//	window.onload = function(){
//		var ctx = document.getElementById("lineChart").getContext("2d");
//		window.myLine = new Chart(ctx).Line(lineChartData, {
//			responsive: true
//		});
//            };  


//Line Chart
//    new Chart(document.getElementById("lineChart"), {
//        type: 'line',
//        data: {
//            labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec", "Jan", "Feb", "Mar"],
//            datasets: [{
//                    data: <?php // echo json_encode($offline_arr); ?>,
//                    label: "Offline",
//                    borderColor: "#3e95cd",
//                    borderWidth:2,
//                    fill: false
//                }, {
//                    data: <?php // echo json_encode($online_arr); ?>,
//                    label: "Online",
//                    borderColor: "#8e5ea2",
//                    borderWidth:2,
//                    fill: false
//                }
//            ]
//        },
//        options: {
//            title: {
//                display: true,
//                text: 'Monthly Amount Collection'
//            }
//        }
//    });


//                var barGraph = new Chart(ctx, {
//				type: 'bar',
//				data: chartdata
//			});


//    $('#abarchart').click(function () {
////            alert('hi');
//////            barGraph.removeData();
////            var ctx1 = document.getElementById("barChart").getContext("2d");
//////            ctx1.removeData();
////		var barGraph = new Chart(ctx1).Bar(lineChartData, {
////			responsive: true
////		});
//
//        new Chart(document.getElementById("barChart"), {
//            type: 'bar',
//            data: {
//                labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec", "Jan", "Feb", "Mar"],
//                datasets: [{
//                        data: <?php // echo json_encode($offline_arr); ?>,
//                        label: "Offline",
//                        fill:false,
//                        borderColor: "rgba(255, 159, 64,1)",
//                        backgroundColor: "rgba(255, 159, 64, 0.2)",
//                        borderWidth:3
//                    
//                    }, {
//                        data: <?php // echo json_encode($online_arr); ?>,
//                        label: "Online",
//                        fill:false,
//                        borderColor: "rgba(75, 192, 192,1)",
//                        backgroundColor: "rgba(75, 192, 192, 0.2)",
//                        borderWidth:3
//                       
//                    }
//                ]
//            },
//            options: {
////                legend: {display: false},
//                title: {
//                    display: true,
//                    text: 'Monthly Amount Collection'
//                }
//            }
//        });
//
//
//    });



// Pie chart for defaulter

//    new Chart(document.getElementById("pieChart"), {
//        type: 'pie',
//        data: {
//          labels: ["Annual", "Monthly"],
//          datasets: [{
//            label: "Defaulters",
////            backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
//            backgroundColor: ["#3e95cd", "#3cba9f"],
//            data: ['<?php // echo $school['defaulter_ann'];?>','<?php // echo $school['defaulter_mon'];?>']
//          }]
//        },
//        options: {
//          title: {
//            display: false,
//            text: 'Defaulters'
//          }
//        }
//    });
    
    
    
    
//  $('#apaychart').click(function () {  
//    new Chart(document.getElementById("payanalyChart"), {
//    type: 'radar',
//    data: {
//      labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec", "Jan", "Feb", "Mar"],
//      datasets: [
//        {
//          label: "Success",
//          fill: true,
//          backgroundColor: "rgba(75, 192, 192,0.2)",
//          borderColor: "rgba(75, 192, 192,1)",
//          borderWidth:2,
//          pointBorderColor: "#fff",
//          pointBackgroundColor: "rgba(75, 192, 192,1)",
//          data: <?php echo json_encode($success_pay); ?>
//        }, {
//          label: "failure",
//          fill: true,
//          backgroundColor: "rgba(255,99,132,0.2)",
//          borderColor: "rgba(255,99,132,1)",
//          borderWidth:2,
//          pointBorderColor: "#fff",
//          pointBackgroundColor: "rgba(255,99,132,1)",
//          pointBorderColor: "#fff",
//          data: <?php echo json_encode($failure_pay); ?>
//        }, {
//          label: "Gateway Visiting",
//          fill: true,
//          backgroundColor: "rgba(54, 162, 235,0.2)",
//          borderColor: "rgba(54, 162, 235,1)",
//          borderWidth:2,
//          pointBorderColor: "#fff",
//          pointBackgroundColor: "rgba(54, 162, 235,1)",
//          pointBorderColor: "#fff",
//          data: <?php echo json_encode($visiting_pay); ?>
//        }, {
//          label: "Partial Success",
//          fill: true,
//          backgroundColor: "rgba(247, 141, 49,0.2)",
//          borderColor: "rgba(247, 141, 49,1)",
//          borderWidth:2,
//          pointBorderColor: "#fff",
//          pointBackgroundColor: "rgba(247, 141, 49,1)",
//          pointBorderColor: "#fff",
//          data: <?php echo json_encode($halfsuccess); ?>
//        }
//        
//      ]
//    },
//    options: {
//      title: {
//        display: true,
//        text: 'Payment Trends Radar Chart'
//      }
//    }
//});
//
//});

//$('#apaychart1').click(function () { 
//new Chart(document.getElementById("linepayanalyChart"), {
//  type: 'line',
//  data: {
//    labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec", "Jan", "Feb", "Mar"],
//    datasets: [{ 
//        data: <?php echo json_encode($success_pay); ?>,
//        label: "Success",
//       borderColor: "rgb(75, 192, 192)",
//       backgroundColor:"rgba(75, 192, 192,0.1)",
//        borderWidth:2,
//        
//      }, { 
//        data: <?php echo json_encode($failure_pay); ?>,
//        label: "Failure",
//        borderColor: "rgb(159, 104, 186)",
//        backgroundColor:"rgba(159, 104, 186,0.1)",
//        borderWidth:2,
//        
//      }, { 
//        data: <?php echo json_encode($visiting_pay); ?>,
//        label: "Gateway Visiting",
//        borderWidth:2,
//         borderColor: "rgb(244, 188, 48)",
//         backgroundColor:"rgba(244, 188, 48,0.1)",
//        
//      }, { 
//        data: <?php echo json_encode($halfsuccess); ?>,
//        label: "Partial Success",
//        borderWidth:2,
//         borderColor: "rgb(247, 141, 49)",
//         backgroundColor:"rgba(247, 141, 49,0.1)",
//        
//      }
//    ]
//  },
//  options: {
//    title: {
//      display: true,
//      text: 'Payment Trends Area Chart'
//    }
//  }
//});
//
//
//
//
//  });
    
    
    
    new Chart(document.getElementById("classdefaulChart"), {
    type: 'doughnut',
    data: {
      labels: <?php echo json_encode($class_name_arr); ?>,
      datasets: [
        {
          label: "Monthly Defaulters",
          backgroundColor: ["#3e95cd","#8e5ea2","#3cba9f","#e8c3b9","#c45850","#ff0000","#ff8000","#ff6666","#4000BF","#B2004C","#FFB594","#00FFFF","#FF0080","#00FF80","#C21460","#FCCC1A"],
          data: <?php echo json_encode($class_mondefaul_arr); ?>
        }
      ]
    },
    options: {
    legend: {display: false},
      title: {
        display: true,
        text: 'Monthly Defaulters'
      }
    }
});
    
    
  new Chart(document.getElementById("classdefaulChart1"), {
    type: 'doughnut',
    data: {
      labels: <?php echo json_encode($class_name_arr); ?>,
      datasets: [
        {
          label: "Annual Defaulters",
          backgroundColor: ["#FCCC1A","#C21460", "#00FF80","#FF0080","#00FFFF","#FFB594","#B2004C","#4000BF","#ff6666","#ff8000","#ff0000","#c45850","#e8c3b9","#3cba9f","#8e5ea2","#3e95cd"],
          data: <?php echo json_encode($class_anndefaul_arr); ?>
        }
      ]
    },
    options: {
    legend: {display: false},
      title: {
        display: true,
        text: 'Annual Defaulters'
      }
    }
});



    new Chart(document.getElementById("classlineChart"), {
        type: 'line',
        data: {
            labels: <?php echo json_encode($class_name_arr); ?>,
            datasets: [{
                    data: <?php echo json_encode($classoffline_arr); ?>,
                    label: "Offline",
                    borderColor: "#2382e0",
                    borderWidth:2,
                    fill: false
                }, {
                    data: <?php echo json_encode($classonline_arr); ?>,
                    label: "Online",
                    borderColor: "#f4496b",
                    borderWidth:2,
                    fill: false
                }
            ]
        },
        options: {
            title: {
                display: true,
                text: "<?php echo $school['mon']; ?> Amount Collection"
            }
        }
});


        new Chart(document.getElementById("classbarChart"), {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($class_name_arr); ?>,
                datasets: [{
                        data: <?php echo json_encode($classoffline_arr); ?>,
                        label: "Offline",
                        fill:false,
                        borderColor: "rgba(142, 94, 162,1)",
                        backgroundColor: "rgba(142, 94, 162, 0.2)",
                        borderWidth:3
                    
                    }, {
                        data: <?php echo json_encode($classonline_arr); ?>,
                        label: "Online",
                        fill:false,
                        borderColor: "rgba(255,102,102,1)",
                        backgroundColor: "rgba(255,102,102, 0.2)",
                        borderWidth:3
                       
                    }
                ]
            },
            options: {
//                legend: {display: false},
                title: {
                    display: true,
                    text: "<?php echo $school['mon']; ?> Amount Collection"
                }
            }
        });



        new Chart(document.getElementById("classstrengthChart"), {
            type: 'horizontalBar',
            data: {
              labels: <?php echo json_encode($class_name_arr); ?>,
              datasets: [
                {
                  label: "Total Students",
                  backgroundColor: ["#3e95cd","#8e5ea2","#3cba9f","#e8c3b9","#c45850","#ff0000","#ff8000","#ff6666","#4000BF","#B2004C","#FFB594","#00FFFF","#FF0080","#00FF80","#C21460","#FCCC1A"],
                  data: <?php echo json_encode($classstrength); ?>
                }
              ]
            },
            options: {
                scales: {
                    yAxes: [{
                        barPercentage: 0.25,
                        gridLines: {
                            display:false
                        }
                    }]
                },
              legend: { display: false },
              title: {
                display: true,
                text: 'Student Strength'
              }
            }
        });

</script>
