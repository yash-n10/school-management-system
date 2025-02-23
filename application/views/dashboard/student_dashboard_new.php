<style>
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
			margin-top: -38px;
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

	.card {
		background-color:#fff;
		border:none;
		border-radius:.625rem;
		box-shadow:0 .46875rem 2.1875rem rgba(90,97,105,.1),0 .9375rem 1.40625rem rgba(90,97,105,.1),0 .25rem .53125rem rgba(90,97,105,.12),0 .125rem .1875rem rgba(90,97,105,.1)
	}
	.card>.list-group:first-child .list-group-item:first-child {
		border-top-left-radius:.625rem;
		border-top-right-radius:.625rem
	}
	.card>.list-group:last-child .list-group-item:last-child {
		border-bottom-right-radius:.625rem;
		border-bottom-left-radius:.625rem
	}
	.card .list-group-item {
		padding:.8125rem 1.875rem
	}
	.card .card-text {
		margin-bottom:1.5625rem
	}
	.card a:hover {
		text-decoration:none
	}
	.card-small {
		box-shadow:0 2px 0 rgba(90,97,105,.11),0 4px 8px rgba(90,97,105,.12),0 10px 10px rgba(90,97,105,.06),0 7px 70px rgba(90,97,105,.1)
	}
	.card-small .card-body,
	.card-small .card-footer,
	.card-small .card-header {
		padding:1rem 1rem
	}
	.card-body {
		padding:1.875rem
	}
	.card-body>p:last-child {
		margin-bottom:0
	}
	.card-title {
		font-weight:500;
		margin-bottom:.75rem
	}
	.card-subtitle {
		margin-top:-1.09375rem
	}
	.card-link {
		font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif
	}
	.card-link+.card-link {
		margin-left:1.875rem
	}
	.card-header {
		padding:1.09375rem 0.875rem;
		background-color:#fff;
		border-bottom:none
	}
	.card-header:first-child {
		border-radius:.625rem .625rem 0 0;
	}
	.card-footer {
		padding:1.09375rem 1.875rem;
		background-color:#fff;
		border-top:none
	}
	.card-footer:last-child {
		border-radius:0 0 .625rem .625rem
	}
	.card-header-tabs {
		margin-bottom:-1rem;
		border-bottom:0
	}
	.card-header-tabs .nav-link,
	.card-header-tabs .nav-link:hover {
		border-bottom:transparent
	}
	.card-header-pills {
		margin-right:-.9375rem;
		margin-left:-.9375rem
	}
	.card-header-pills:hover {
		background:0 0
	}
	.card-img-overlay {
		padding:1.875rem 2.1875rem;
		background:rgba(90,97,105,.5);
		border-radius:.625rem
	}
	.card-img-overlay .card-title {
		color:#fff
	}
	.card-img {
		border-radius:.625rem
	}
	.card-img-top {
		border-top-left-radius:.625rem;
		border-top-right-radius:.625rem
	}
	.card-img-bottom {
		border-bottom-right-radius:.625rem;
		border-bottom-left-radius:.625rem
	}
	.card-deck .card {
		margin-bottom:.9375rem
	}
	.card-group>.card {
		box-shadow:0 .46875rem 2.1875rem rgba(90,97,105,.1),0 .9375rem 1.40625rem rgba(90,97,105,.1),0 .25rem .53125rem rgba(90,97,105,.12),0 .125rem .1875rem rgba(90,97,105,.1)
	}
	.card-group>.card:last-child .card-body,
	.card-group>.card:last-child .card-footer {
		border-right:none
	}
	.card-group .card-body,
	.card-group .card-footer {
		border-right:1px solid #e7e9ea
	}
	.card-columns .card {
		margin-bottom:2.1875rem
	}	
</style>
<?php
$a = array();
foreach ($this->session->userdata('sch_modules') as $r) {
	array_push($a, $r->modules);
};
?>
<div class="row">
	<div class="col-md-12">
		<span class=""><i class="fa fa-graduation-cap" style="font-size:50px; float:left; padding-right:15px; color: #001f4d;"></i> </span> 
		<span class="" style="font-size:30px; color: #990000;"><?php echo 'Welcome ,' . ' ' . $student_name; ?></span>
	</div>
</div>
<section class="content">
	<div class="row">
		<div class="col-md-4">			
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">My Favorites</h3>
				</div>
				<div class="box-body" style="padding-left: 18px;">
					<?php if (in_array('library', $a)) { ?>
						<a class="btn btn-app bg-purple" title="View Books" href="<?php echo base_url(); ?>Student/student_view_ncert">
							<i class="fa fa-book"></i> Books PDF
						</a>
					<?php } else { ?>
						<a class="btn btn-app bg-purple">
							<i class="fa fa-book"></i> Books PDF
						</a>
					<?php } ?>
					<?php if (in_array('academics', $a)) { ?>
					<a class="btn btn-app bg-green" title="View Notes" href="<?php echo base_url(); ?>Student/student_notes">
						<span class="badge bg-teal"></span>
						<i class="fa fa-inbox"></i> Notes
					</a>	
				<?php } else { ?>	
					<a class="btn btn-app bg-green">
						<span class="badge bg-teal">7</span>
						<i class="fa fa-inbox"></i> Hostel
					</a>
				<?php } ?>
				<?php if (in_array('academics', $a)) { ?>
						<a class="btn btn-app bg-yellow" title="View Homework" href="<?php echo base_url(); ?>student/assignments">
							<i class="fa fa-tasks"></i> Assignment
						</a>
					<?php } else { ?>
						<a href="" class="btn btn-app bg-yellow">
							<i class="fa fa-repeat"></i> Assignment
						</a>
					<?php } ?>
					
					<?php if (in_array('academics', $a)) { ?>
						<a class="btn btn-app bg-red" title="Video Tutorial" href="<?php echo base_url(); ?>Student/view_tutorial">
							<i class="fa fa-music"></i> Video Tutorial
						</a>
					<?php } else { ?>
						<a class="btn btn-app bg-aqua">
							<i class="fa fa-calendar-minus-o"></i> Class Routine
						</a>
					<?php } ?>
					
					
					<?php if (in_array('attendence', $a)) { ?>
						<a class="btn btn-app bg-purple" href="<?php echo base_url(); ?>student/attendence">
							<i class="fa fa-save"></i> Attendance
						</a>
					<?php } else { ?>
						<a class="btn btn-app bg-purple">
							<i class="fa fa-save"></i> Attendance
						</a>
					<?php } ?>
					<?php if (in_array('academics', $a)) { ?>
						<a class="btn btn-app bg-aqua" href="<?php echo base_url(); ?>student/upcexam">
							<span class="badge bg-yellow"></span>
							<i class="fa fa-bullhorn"></i>Exams 
						</a>
					<a class="btn btn-app bg-aqua" href="<?php echo base_url(); ?>student/marks">
						<span class="badge bg-green"></span>
						<i class="fa fa-barcode"></i> Results
					</a>
				<?php } else { ?>
					<a class="btn btn-app bg-red">
						<span class="badge bg-yellow">3</span>
						<i class="fa fa-bullhorn"></i>Exams 
					</a>
					<a class="btn btn-app bg-aqua">
						<span class="badge bg-green">2</span>
						<i class="fa fa-barcode"></i> Results
					</a>
				<?php } ?>
				<?php if (in_array('transport', $a)) { ?>
					<a class="btn btn-app bg-yellow" href="<?php echo base_url(); ?>student/transport">
						<span class="badge bg-purple">5</span>
						<i class="fa fa-truck"></i> Transport
					</a>
				<?php } else { ?>
					<a class="btn btn-app bg-yellow">
						<span class="badge bg-purple">5</span>
						<i class="fa fa-truck"></i> Transport
					</a>
				<?php } ?>

				<?php if (in_array('fee_management', $a)) { ?>
						<a class="btn btn-app bg-red" href="<?php echo base_url(); ?>payment">
							<i class="fa fa-inr"></i> Payment
						</a>
					<?php } else { ?>
						<a class="btn btn-app bg-red" href="#">
							<i class="fa fa-inr"></i> Payment
						</a>
					<?php } ?>
						
			</div>			
			</div>

			<!-- <div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Attendance</h3>					
				</div>
				<div class="box-body">					
					<div class="row">					
						<div class="col-sm-6">
							<span><h3 style="margin-left: 33px;margin-top:-7px">Monthly</h3></span>
							<div class="progress blue">
								<span class="progress-left">
									<span class="progress-bar"></span>
								</span>
								<span class="progress-right">
									<span class="progress-bar"></span>
								</span>
								<div class="progress-value">90%</div>
							</div>
						</div>
						<div class="col-sm-6">
							<span><h3 style="margin-left: 33px;margin-top:-7px">Yearly</h3></span>
							<div class="progress yellow">
								<span class="progress-left">
									<span class="progress-bar"></span>
								</span>
								<span class="progress-right">
									<span class="progress-bar"></span>
								</span>
								<div class="progress-value">75%</div>
							</div>
						</div>
					</div>
				</div>
			</div> -->

			<!-- <div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Holiday List</h3>				
				</div>        			
				<div class="box-body" >
					<ul class="products-list product-list-in-box" style="overflow: auto">
						<?php
						function dateDiffInDays($rowdate1, $rowdate)  
						{ 
							$diff = strtotime($rowdate1) - strtotime($rowdate); 
							return abs(round($diff / 86400)); 
						} 
						$this->db->order_by('id', 'desc');
						$this->db->limit('5');
						$holiday = $this->db->get('holiday')->result_array();

						$lastdate = '';

						foreach ($holiday as $row):
			                	// print_r($row);
							$rowdate = $row['holiday_date_from'];
							$rowdate1 = $row['holiday_date_to'];

							$dayy=dateDiffInDays($rowdate1, $rowdate); 

							?>
							<li class="item">							
								<div class="product-info">
									<a href="javascript:void(0)" class="product-title"><?php echo $row['holiday_name']; ?>
									<span class="label label-warning pull-right">
										<?php 
										if($dayy==0)
										{
											echo 1;
										}
										else {
											echo $dayy;
										}
										?>
									Days</span></a>
									<span class="product-description">
										<?php echo $row['remarks']; ?>
									</span>
								</div>
							</li>
						<?php endforeach; ?>								
					</ul>
				</div>
			</div> -->
			<?php if($birthday) { ?>
				<div class="box box-solid">
					<div class="box-header with-border">
						<h3 class="box-title">Happy Birthday</h3>
					</div>

					<div class="box box-widget widget-user">
						<div class="widget-user-header bg-aqua-active">
							<h3 class="widget-user-username"><?php echo $birthday[0]->first_name; ?> <?php echo $birthday[0]->middle_name; ?> <?php echo $birthday[0]->last_name; ?></h3>
							<h5 class="widget-user-desc"><?php echo $birthday[0]->class_name; ?> - <?php echo $birthday[0]->sec_name; ?></h5>
						</div>
						<div class="widget-user-image">
							<img class="img-circle" src="<?php echo base_url();?>assets/false_images/birth.jpg" alt="User Avatar">
						</div>
						<div class="box-footer">
							<div class="row">
								<div class="col-sm-12 border-right">
									<div class="description-block">
										<span class="description-text">Wishing you a very HAPPY BIRTHDAY <?php echo $birthday[0]->first_name; ?></span>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>

			<?php } else if($this->session->userdata('school_id')==8){ 
				$image_video=$tutorial[0]->image_video;	
				$title=$tutorial[0]->title;
				$video_url=$tutorial[0]->video_url;
				$subject_name=$tutorial[0]->subject_name;	?>
					<div class="card" style="height: 270px;">
						<div class="card-header" style="background-color:#2393bb;color:#fff;text-align:center;">TAKE TODAY'S LESSON</div>
						<div class="card-body" style="background-image:url('<?php echo base_url();?>tutorial_image/<?php echo $image_video; ?>');background-repeat:no-repeat;background-position:center;background-color:rgba(255,255,255,0)">
							<p class="card-text" style="margin-bottom: 0.5625rem;"> 
								<!-- <span class="card-text" style=""><?php echo $title; ?></span> -->
								<a href="#" class="subscribe-btn" id="checkValidation" style="margin-left:60px!important;"> <img src="https://www.abc2india.com/dashboard/users/images/xplay_new.png.pagespeed.ic.kO7ILZnXyo.png" class="imgcc" alt="" data-pagespeed-url-hash="3681255850" onload="pagespeed.CriticalImages.checkImageForCriticality(this);" ></a>
							</p><center>
								<a href="<?php echo base_url()?>Student/view_tutorial" class="btn btn-primary blinkbutton">CLICK HERE TO PLAY</a>

							</center>
							<p></p>

						</div>
					</div>
				<?php } else { ?>
					<div class="box box-solid" style="height:250px;">
						<div class="box-header with-border">
							<!-- <h3 class="box-title">HAPPY MAKAR SANKRANTI <span style="color:red"><?php echo $student_name ; ?></span></h3> -->
						</div>

						<div class="box box-widget widget-user" style="background:url(<?php echo base_url();?>assets/false_images/stayhome.png); background-size:cover;height:282px;" >
							<div class="widget-user-header" >
								<h3 class="widget-user-username"></h3>
								<h5 class="widget-user-desc"></h5>
							</div>
						</div>

					</div>
				<?php } ?>
			</div>
			<div class="col-md-8">	
				<div class="row">
					<div class="col-md-7">
						<div class="box box-info">
							<div class="box-header with-border">
								<h3 class="box-title">Announcements</h3>	
							</div>        			
							<div class="box-body">
								<ul class="products-list product-list-in-box">
									<?php
									$this->db->order_by('create_timestamp', 'desc');
									$this->db->limit('5');
									$notices = $this->db->get('noticeboard')->result_array();

									$lastdate = '';
									foreach ($notices as $row):
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

										<li class="item">							
											<div class="product-info">
												<a href="javascript:void(0)" class="product-title"><?php echo $row['notice_title']; ?>
												<span class="label label-warning pull-right"><img src="<?php echo base_url()?>assets/false_images/new-gif-image.gif" style="width: 29px;"></span></a>
												<span class="product-description">
													<span><?php echo $day; ?>, <?php echo $datee; ?><sup>th</sup> <?php echo $mon; ?> <?php echo $year;?></span>
												</span>
											</div>
										</li>
									<?php endforeach; ?>							
								</ul>
							</div>								
						</div>
					</div>
					<div class="col-md-5 cc_profile">	
						<div class="box box-info">
							<div class="box-header with-border">
								<h3 class="box-title text-center">Student Profile</h3>											
							</div>  
							<div class="box-body box-profile">
								<img class="profile-user-img img-responsive img-circle" src="<?php echo base_url();?>assets/false_images/user.jpg" alt="User profile picture">

								<h3 class="profile-username text-center" style="margin-bottom:0px;color:#990000"><?php echo $student_name ?></h3>
								<p class="text-muted text-center" style="margin-bottom:0px;"><span>Admission No.</span><?php echo $adm ?></p>
								<p class="text-muted text-center"><?php echo $clas ?> <?php echo $sec ?></p>

								<ul class="list-group list-group-unbordered" style="margin-bottom: 3px;">
									<li class="list-group-item" style="padding: 6px 15px;">
										<b>Mother's Name</b> <a class="pull-right"><?php echo $mother ?></a>
									</li>
									<li class="list-group-item" style="padding: 6px 15px;">
										<b>Father's Name</b> <a class="pull-right"><?php echo $father ?></a>
									</li>	
									<li class="list-group-item" style="padding: 6px 15px;">
										<b>Contact No.</b> <a class="pull-right"><?php echo $contact ?></a>
									</li>												
								</ul>
							</div>
						</div>			
					</div>
				</div>	


						<?php if (in_array('academics', $a)) { ?>
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Home Work</h3>

					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
						<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
					</div>
				</div>
				<div class="box-body">
					<div class="table-responsive">
						<table class="table no-margin">
							<thead>
								<tr>
									<th>Assign Date</th>
									<th>Subject</th>
									<th>Submission Date</th>
									<th>Homework</th>
									<th>Attachment</th>
								</tr>
							</thead>
							<tbody>
								<?php 

								$i=1;
								foreach($homework as $value){
									?>
									<tr>
										<td><?php echo $value->doa;?></td>
										<td><?php echo $value->name;?></td>
										<td><?php echo $value->dos;?></td>
										<td>
											<?php echo $value->description;?>
										</td>


										<?php if($value->attachment==''){?>
											<td><div class="sparkbar" data-color="#00a65a" data-height="20"><span class="label label-warning">No Attachment</span></div></td>
										<?php }else{?>
											<td><div class="sparkbar" data-color="#00a65a" data-height="20"><span class="label label-success"><a href="<?php echo base_url();?>/homework/<?php echo $value->attachment;?>" style="color:white" target="_blank"><i class="fa fa-eye"></i> View Attachment</a></span></div>
											</td>
										<?php } ?>
									</tr>
									<?php 
									$i++;
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="box-footer clearfix">
					<a href="<?php echo base_url();?>/student/assignments" class="btn btn-sm btn-default btn-flat pull-right">View All Homework</a>
				</div>
			</div>
		<?php } else { ?>
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Home Work</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
						<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
					</div>
				</div>
				<div class="box-body">
					<div class="table-responsive">
						<table class="table no-margin">
							<thead>
								<tr>
									<th>Assign Date</th>
									<th>Subject</th>
									<th>Submission Date</th>
									<th>Homework</th>
									<th>Attachment</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="box-footer clearfix">
					<a href="#" class="btn btn-sm btn-default btn-flat pull-right">View All Homework</a>
				</div>
			</div>
		<?php } ?>


				<?php if (in_array('academics', $a)) { ?>					
					<div class="box box-info">								
						<div class="nav-tabs-custom">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#tab_1" data-toggle="tab">Class Routines</a></li>
								<li><a href="#tab_2" data-toggle="tab">Today Class Routine</a></li>

							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="tab_1">
									<div class="table-responsive" style="padding: 6px;font-size: 12px;">
										<table class="table no-margin table-bordered">
											<thead>
												<tr>
													<th style="font-size:13px;font-weight:600">Time Day</th>
													<?php for($k=0; $k<$period; $k++) { ?>
														<th style="font-size:13px;font-weight:600"><?php echo $start[$k].":".$start_min[$k]."-".$end[$k].":".$end_min[$k]; ?></th>
													<?php } ?>      
												</tr>
											</thead>
											<tbody>
												<?php for($i=0; $i<$cnt; $i++) { ?>
													<tr>

														<td><?php echo ucwords($day[$i]); ?> <span style="color:#159dff;font-weight:600">Faculty</span></td>

														<?php for($j=0; $j<$count; $j++) { ?>
															<td><?php if(isset($day_subject[$i][$j])) { echo $day_subject[$i][$j]; } else { echo ' ';}?><span class="badge bg-red"><?php if(isset($tchr_nam[$i][$j])) { echo $tchr_nam[$i][$j] ; } else { 
																echo 'N/A';
															} ?></span> </td>
														<?php } ?>    
													</tr>    
												<?php  } ?>             
											</tbody>
										</table>
									</div>	
								</div>
								<div class="tab-pane" id="tab_2">
									<div class="table-responsive" style="padding: 6px;font-size: 12px;">
										<table class="table no-margin table-bordered">
											<thead>
												<tr>
													<th style="font-size:13px;font-weight:600">Time Day</th>
													<?php for($k=0; $k<$period; $k++) { ?>
														<th style="font-size:13px;font-weight:600"><?php echo $start[$k].":".$start_min[$k]."-".$end[$k].":".$end_min[$k]; ?></th>
													<?php } ?>  
												</tr>
											</thead>
											<tbody>
												<tr>
													<td><?php echo $today; ?></td>
													<?php foreach ($todaysrou as $datas) {  ?>
														<td><?php if ($datas['subject_id'] == '0') { echo 'Break';
													} else { echo $datas['subjectname']; } ?>
													<span class="badge bg-red"><?php if ($datas['assignedteacher']) { echo "(" . $datas['assignedteacher'] . ")";
												} else {
													if ($datas['teachername']) {
														echo "(" . $datas['teachername'] . ")";
													} else {
														echo 'N/A';
													}
												} ?></span> </td>
											<?php } ?>   
										</tr>         
									</tbody>
								</table>
							</div>	
						</div>


					</div>
				</div>	
				<div class="box-footer clearfix">
					<a href="<?php echo base_url();?>/student/class_routine" class="btn btn-sm btn-default btn-flat pull-right">View Routine</a>
				</div>							
			</div>
		<?php } else { ?>
			<div class="box box-info">								
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab_1" data-toggle="tab">Class Routines</a></li>
						<li><a href="#tab_2" data-toggle="tab">Today Class Routine</a></li>

					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab_1">
							<div class="table-responsive" style="padding: 6px;font-size: 12px;">
								<table class="table no-margin table-bordered">
									<thead>
										<tr>
											<th style="font-size:13px;font-weight:600">Time Day</th>											 
											<th style="font-size:13px;font-weight:600"></th>   
										</tr>
									</thead>
									<tbody>
										<tr>

											<td></td>
											<td></td>  
										</tr>               
									</tbody>
								</table>
							</div>	
						</div>
						<div class="tab-pane" id="tab_2">
							<div class="table-responsive" style="padding: 6px;font-size: 12px;">
								<table class="table no-margin table-bordered">
									<thead>
										<tr>
											<th style="font-size:13px;font-weight:600">Time Day</th>
											<th style="font-size:13px;font-weight:600"></th>

										</tr>
									</thead>
									<tbody>
										<tr>
											<td></td>
											<td></td>
										</tr>         
									</tbody>
								</table>
							</div>	
						</div>


					</div>
				</div>	
				<div class="box-footer clearfix">
					<a href="#" class="btn btn-sm btn-default btn-flat pull-right">View Routine</a>
				</div>							
			</div>
		<?php } ?>

	</div>
</div>
</section>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>  
<script type="text/javascript">
google.charts.load("current", {packages: ['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
	var jsonData = $.ajax({
		url: "<?php echo base_url('Dashboard/result_graph'); ?>",
		dataType: "json",
		async: false
	}).responseText;
var data = new google.visualization.DataTable(jsonData);
var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
chart.draw(data);

var barchart = new google.visualization.BarChart(document.getElementById('bar_chart_div'));
barchart.draw(data);
}


</script>


