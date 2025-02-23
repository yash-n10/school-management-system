<style>
.info-box-text {
	color: #fff;
}
.btn-app {        
	min-width: 120px;
	height: 82px;
	font-size: 15px;
}
.external:hover
{
	-moz-transform: scale(1.1);
	-webkit-transform: scale(1.1);
	transform: scale(1.1);
}
.box{
	box-shadow: 3px 3px 3px 2px #aaa;
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
<?php
// echo "<pre>";print_r($this->session->userdata('sch_modules'));die();
$a = array();
foreach ($this->session->userdata('sch_modules') as $r) {
	array_push($a, $r->modules);
};
// echo "<pre>";print_r($a);die();
?>
<div class="row">
	<div class="col-md-12">
		<span class=""><i class="fa fa-graduation-cap" style="font-size:50px; float:left; padding-right:15px; color: #001f4d;"></i> </span> 
		<span class="" style="font-size:30px; color: #990000;text-transform:capitalize;"><?php echo 'Welcome ,' . ' ' . $user_name; ?></span>
	</div>
</div>
<section class="content">    
	<div class="row">
		<div class="col-md-8">          
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">My Favorites</h3>
				</div>
				<div class="box-body" style="padding-left: 18px;">
					<?php if (in_array('fee_management', $a)) { ?>
						<a class="btn btn-app bg-red" href="<?php echo base_url('feepayment/collection/Offline_payment'); ?>">
							<i class="fa fa-inr"></i> Collect Fee
						</a>
					<?php } ?>
					<a class="btn btn-app bg-aqua" href="<?php echo base_url('admission/student'); ?>">
						<i class="fa fa-calendar-minus-o"></i> Student
					</a>
					<a class="btn btn-app bg-yellow" href="<?php echo base_url('hr/staff/employees'); ?>">
						<i class="fa fa-repeat"></i>  Staff
					</a>
					<?php if (in_array('library', $a)) { ?>
						<a class="btn btn-app bg-green" href="<?php echo base_url('library/Lib_card'); ?>">
							<i class="fa fa-book"></i> Library
						</a>
					<?php } ?>
					<?php if (in_array('academics', $a)) { ?>

						<a class="btn btn-app bg-purple" href="<?php echo base_url('academics/homework/add_homework'); ?>">
							<i class="fa fa-save"></i> Homework
						</a> 
					<?php } ?>
					<?php if (in_array('academics', $a)) { ?>
						<a class="btn btn-app bg-yellow" href="<?php echo base_url('academics/class_routines'); ?>">
							<!-- <span class="badge bg-green">2</span> -->
							<i class="fa fa-barcode"></i> Class Routine
						</a>
					<?php } ?>
					<?php if (in_array('attendence', $a)) { ?>
						<a class="btn btn-app bg-green" href="<?php echo base_url('attendance/Student_attendance'); ?>">
							<!-- <span class="badge bg-yellow">3</span> -->
							<i class="fa fa-bullhorn"></i>Student Daily<br> Attendance 
						</a>
					<?php }?>
					<?php if (in_array('academics', $a)) { ?>
						<a class="btn btn-app bg-red" href="<?php echo base_url('ebooks/notes'); ?>">
							<!-- <span class="badge bg-purple">5</span> -->
							<i class="fa fa-book"></i> Notes
						</a>
					<?php } ?>
					<?php if (in_array('academics', $a)) { ?>
						<a class="btn btn-app bg-purple" href="<?php echo base_url('ebooks/Ncert'); ?>">
							<!-- <span class="badge bg-teal">7</span> -->
							<i class="fa fa-book"></i> E-Books
						</a> 
					<?php } ?>
					<?php if (in_array('communication', $a)) { ?>
						<a class="btn btn-app bg-aqua" href="<?php echo base_url('communication/Mailsms'); ?>">
							<!-- <span class="badge bg-teal">7</span> -->
							<i class="fa fa-inbox"></i> Mail/ SMS
						</a> 
					<?php } ?>                   
				</div>              
				<div class="box-footer text-center">
					<a href="javascript:void(0)" class="uppercase">View All </a>
				</div>          
			</div>            
		</div>
		<div class="col-md-4">  
			<div class="row">                               
				<div class="col-md-12 cc_profile">  
					<div class="box box-info">
						<div class="box-header with-border">
							<h3 class="box-title">Announcements</h3>
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
												<span class="direct-chat-name pull-left"><?php echo $day; ?></span>
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
					<h3 class="box-title">Tabular Data</h3>
				</div>
				<div class="box-body">
					<div class="table-responsive">
						<table class="table table-bordered no-margin">
							<thead>
								<tr>
									<th>Month</th>
									<th>Total Collection</th>
									<th>Offline Collection</th>
									<th>Offline Transaction Count</th>
									<th>Online Collection</th>
									<th>Online Transaction Count</th>
								</tr>
							</thead> 	
							<tbody>
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
										<td style="text-align:center;"> <?php echo $amount[0]->off_cnt ?></td>
										<td> <?php
										if ($amount[0]->amnt != '' || $amount[0]->amnt != 0) {
											echo '&#8377; ' . number_format($amount[0]->amnt);
										} else {
											echo ' ';
										}
										?> </td>
										<td style="text-align:center;"> <?php echo $amount[0]->on_cnt ?></td>

									</tr>
								<?php } ?>  
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
								<span class="info-box-icon"><i class="fa fa-users"></i></span>
								<div class="info-box-content">
									<span class="info-box-text" style="text-align:right;">Total Students : <?php  echo $total_students;?></span>
									<span class="info-box-number">Active Session :  <?php  echo $total_active_student;?></span>

									<div class="progress">
										<div class="progress-bar" style="width: 50%"></div>
									</div>
									<!-- <span class="progress-description">
										Active Session :  <?php  echo $total_active_student;?>
									</span> -->
									<span class="progress-description">
										Previous Session :  <?php  echo $total_prev_student;?>
									</span>
								</div>
							</div>
							<!-- <div class="info-box bg-green">
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
							</div> -->

							<div class="info-box bg-green accordion" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" id="accordionExample" style="cursor:pointer">
								<span class="info-box-icon"><i class="fa fa-calendar"></i></span>
								<div class="info-box-content">									
									<span class="info-box-text" style="text-align:center;font-size: x-large;margin: 10px 0px 0px -13px;">Attendance <i class="fa fa-angle-double-down" style="font-size:32px;margin-top:10px;"></i></span>

								</div>
								
							</div>
							<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
								<div class="card-body">
									<table class="table">
										<thead>
											<tr>
												<th>Class</th>
												<th>Sec</th>
												<th>Capture</th>
												<th>SMS</th>
											</tr>
										</thead>
										<tbody style="color:black;background-color: white!important">
											<?php foreach($attendance_data as $val) { 
												$send_sms=$val->sms;
												if($send_sms=='YES')
												{
													$show='<i class="fa fa-check" style="color:green"></i>';
												}
												else{
													$show='<i class="fa fa-close" style="color:red"></i>';
												}
												?>
												<tr>
													<td><?php echo $val->class_name; ?></td>
													<td><?php echo $val->section_name; ?></td>
													<td>YES</td>
													<td><?php echo $show; ?></td>
												</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
							
							<div class="">
								<div class="box box-info">
									<div class="box-header with-border" style="background-color:#dd4b39 ">
										<h3 class="box-title" style="color:#fff;">Defaulter Overview</h3>
									</div>
									<div class="box-body" style="padding:2px;">
										<div class="table-responsive">
											<table class="table no-margin">
												<thead>
													<tr>
														<th>Type</th>
														<th>Count</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>Annual</td>
														<td><?php echo $school['defaulter_ann'] ?></td>
													</tr>
													<tr>
														<td>Monthly</td>
														<td><?php echo $school['defaulter_mon'] ?></td>
													</tr>
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
</section>



