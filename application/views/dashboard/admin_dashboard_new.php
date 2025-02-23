

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
<script>
	new WOW().init();
</script>

<style>
	.btn-app {        
		min-width: 97px;
		height: 76px;
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
			margin-top: -15px;
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
// $a = array();
// foreach ($this->session->userdata('sch_modules') as $r) {
// 	array_push($a, $r->modules);
// };
?>
<div class="row">
	<div class="col-md-12">
		<span class=""><i class="fa fa-graduation-cap" style="font-size:50px; float:left; padding-right:15px; color: #001f4d;"></i> </span> 
		<!-- <span class="" style="font-size:30px; color: #990000;"><?php echo 'Welcome ,' . ' ' . $student_name; ?></span> -->
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

					<a class="btn btn-app bg-red">
						<i class="fa fa-inr"></i> Payment
					</a>
					<a class="btn btn-app bg-aqua">
						<i class="fa fa-calendar-minus-o"></i> Student
					</a>
					<a href="" class="btn btn-app bg-yellow">
						<i class="fa fa-repeat"></i> Teaching Staff
					</a>
					<a class="btn btn-app bg-green">
						<i class="fa fa-book"></i> Library
					</a>
					<a class="btn btn-app bg-purple">
						<i class="fa fa-save"></i> Marks
					</a> 
					<a class="btn btn-app bg-red">
						<span class="badge bg-green">2</span>
						<i class="fa fa-barcode"></i> Class Routine
					</a>
					<a class="btn btn-app bg-aqua">
						<span class="badge bg-yellow">3</span>
						<i class="fa fa-bullhorn"></i>Student Daily<br> Attendance 
					</a>

					<a class="btn btn-app bg-yellow">
						<span class="badge bg-purple">5</span>
						<i class="fa fa-truck"></i> Transport
					</a>
					<a class="btn btn-app bg-green">
						<span class="badge bg-teal">7</span>
						<i class="fa fa-inbox"></i> Hostal
					</a> 
					<a class="btn btn-app bg-purple">
						<span class="badge bg-teal">7</span>
						<i class="fa fa-inbox"></i> Mail/ SMS
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
					<div class="box box-info">
						<div class="box-header with-border">
							<h3 class="box-title text-center">Admin Profile</h3>                                          
						</div>  
						<div class="box-body box-profile">
							<img class="profile-user-img img-responsive img-circle" src="<?php echo base_url();?>assets/false_images/user3-128x128.jpg" alt="User profile picture">

							<h3 class="profile-username text-center" style="margin-bottom:0px;color:#990000">Nina Mcintire</h3>
							<!-- <p class="text-muted text-center" style="margin-bottom:0px;"><span>Admission No.</span>123456</p> -->
							<p class="text-muted text-center">Software Engineer</p>

							<ul class="list-group list-group-unbordered" style="margin-bottom: 3px;">                                
								<li class="list-group-item" style="padding: 6px 15px;">
									<b>Reporting Person</b> <a class="pull-right">Abhinay  Mishra</a>
								</li>   
								<li class="list-group-item" style="padding: 6px 15px;">
									<b>Contact No.</b> <a class="pull-right">8093314514</a>
								</li>                                               
							</ul>
						</div>
					</div>       
				</div>                                               
			</div>             
		</div>
	</div>

	<div class="row">
		<div class="col-md-8">          
			<div class="box box-info">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab_1" data-toggle="tab">Announcements</a></li>
						<li><a href="#tab_2" data-toggle="tab">Class Wise Announcements</a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab_1">
							<ul class="products-list product-list-in-box">
								<li class="item">                           
									<div class="product-info">
										<a href="javascript:void(0)" class="product-title">Entire Disputed Land Goes to Hindus for Ram Mandir, Muslims to Get 5 Acres of Alternate Land 
											<span class="pull-right"><div class="element"></div></span></a>
											<span class="product-description">
												<span>Saturday, 11<sup>th</sup> Nov 2019</span> TO <span>Sunday, 12<sup>th</sup> Nov 2019 </span>
											</span>
										</div>
									</li>
									<li class="item">                               
										<div class="product-info">
											<a href="javascript:void(0)" class="product-title">अयोध्या प्रकरण पर माननीय सर्वोच्च न्यायालय द्वारा दिया गया फैसला ऐतिहासिक है। इस फैसले से देश का सामाजिक ताना-बाना और मजबूत होगा।
												<span class="label label-info pull-right"></span></a>
												<span class="product-description">
													<span>Saturday, 11<sup>th</sup> Nov 2019</span> TO <span>Sunday, 12<sup>th</sup> Nov 2019 </span>
												</span>
											</div>
										</li>                                    
										<li class="item">                                   
											<div class="product-info">
												<a href="javascript:void(0)" class="product-title">Gandhi Jayanti <span
													class="label label-danger pull-right"></span></a>
													<span class="product-description">
														<span>Wednesday, 02nd October 2019</span> TO <span>Wednesday, 02nd October 2019 </span>
													</span>
												</div>
											</li>                                   
										</ul>
									</div>
									<!-- /.tab-pane -->
									<style>
										.nav>li>a {										  
										    padding: 10px 13px!important;
										}
									</style>
	<div class="tab-pane" id="tab_2">
		<div class="nav-tabs-custom" style="margin-top: -10px;">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#tab_3" data-toggle="tab">class I</a></li>
				<li><a href="#tab_4" data-toggle="tab">class II</a></li>
				<li><a href="#tab_5" data-toggle="tab">class III</a></li>
				<li><a href="#tab_6" data-toggle="tab">class IV</a></li>
				<li><a href="#tab_7" data-toggle="tab">class V</a></li>
				<li><a href="#tab_8" data-toggle="tab">class VI</a></li>
				<li><a href="#tab_9" data-toggle="tab">class VII</a></li>
				<li><a href="#tab_10" data-toggle="tab">class VIII</a></li>
				<li><a href="#tab_11" data-toggle="tab">class IX</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab_3">
					<ul class="products-list product-list-in-box">
						<li class="item">                           
							<div class="product-info">
								<a href="javascript:void(0)" class="product-title">B. R. Amedkar Jayanti
									<span class="pull-right"><div class="element"></div></span></a>
									<span class="product-description">
										<span>Sunday, 14th April 2019</span> TO <span>Sunday, 14th April 2019 </span>
									</span>
								</div>
							</li>
							<li class="item">                               
								<div class="product-info">
									<a href="javascript:void(0)" class="product-title">Diwali And Chhat
										<span class="label label-info pull-right"></span></a>
										<span class="product-description">
											<span>Monday, 28th October 2019</span> TO <span>Saturday, 2nd November 2019 </span>
										</span>
									</div>
								</li>                                
							</ul>
						</div>
						<!-- /.tab-pane -->
						<div class="tab-pane" id="tab_4">
							<ul class="products-list product-list-in-box">
								<li class="item">                           
									<div class="product-info">
										<a href="javascript:void(0)" class="product-title">Abhinay MIshra Jayanti
											<span class="pull-right"><div class="element"></div></span></a>
											<span class="product-description">
												<span>Sunday, 14th April 2019</span> TO <span>Sunday, 14th April 2019 </span>
											</span>
										</div>
									</li>
									<li class="item">                               
										<div class="product-info">
											<a href="javascript:void(0)" class="product-title">Dushara
												<span class="label label-info pull-right"></span></a>
												<span class="product-description">
													<span>Monday, 28th October 2019</span> TO <span>Saturday, 2nd November 2019 </span>
												</span>
											</div>
										</li> 

									</ul>
								</div>
								<div class="tab-pane" id="tab_5">
									<ul class="products-list product-list-in-box">
										<li class="item">                           
											<div class="product-info">
												<a href="javascript:void(0)" class="product-title">MIshra Jayanti
													<span class="pull-right"><div class="element"></div></span></a>
													<span class="product-description">
														<span>Sunday, 14th April 2019</span> TO <span>Sunday, 14th April 2019 </span>
													</span>
												</div>
											</li>
											<li class="item">                               
												<div class="product-info">
													<a href="javascript:void(0)" class="product-title">Dushara
														<span class="label label-info pull-right"></span></a>
														<span class="product-description">
															<span>Monday, 28th October 2019</span> TO <span>Saturday, 2nd November 2019 </span>
														</span>
													</div>
												</li> 

											</ul>
										</div>
										<div class="tab-pane" id="tab_6">
											<ul class="products-list product-list-in-box">
												<li class="item">                           
													<div class="product-info">
														<a href="javascript:void(0)" class="product-title">Jayanti
															<span class="pull-right"><div class="element"></div></span></a>
															<span class="product-description">
																<span>Sunday, 14th April 2019</span> TO <span>Sunday, 14th April 2019 </span>
															</span>
														</div>
													</li>
													<li class="item">                               
														<div class="product-info">
															<a href="javascript:void(0)" class="product-title">Dushara
																<span class="label label-info pull-right"></span></a>
																<span class="product-description">
																	<span>Monday, 28th October 2019</span> TO <span>Saturday, 2nd November 2019 </span>
																</span>
															</div>
														</li> 

													</ul>
												</div>
												<div class="tab-pane" id="tab_7">
													<ul class="products-list product-list-in-box">
														<li class="item">                           
															<div class="product-info">
																<a href="javascript:void(0)" class="product-title">AYODHYA MANDIR
																	<span class="pull-right"><div class="element"></div></span></a>
																	<span class="product-description">
																		<span>Sunday, 14th April 2019</span> TO <span>Sunday, 14th April 2019 </span>
																	</span>
																</div>
															</li>
															<li class="item">                               
																<div class="product-info">
																	<a href="javascript:void(0)" class="product-title">Dushara
																		<span class="label label-info pull-right"></span></a>
																		<span class="product-description">
																			<span>Monday, 28th October 2019</span> TO <span>Saturday, 2nd November 2019 </span>
																		</span>
																	</div>
																</li> 

															</ul>
														</div>
														<div class="tab-pane" id="tab_8">
													<ul class="products-list product-list-in-box">
														<li class="item">                           
															<div class="product-info">
																<a href="javascript:void(0)" class="product-title">AYODHYA MANDIR SOLVE
																	<span class="pull-right"><div class="element"></div></span></a>
																	<span class="product-description">
																		<span>Sunday, 14th April 2019</span> TO <span>Sunday, 14th April 2019 </span>
																	</span>
																</div>
															</li>
															<li class="item">                               
																<div class="product-info">
																	<a href="javascript:void(0)" class="product-title">Dushara
																		<span class="label label-info pull-right"></span></a>
																		<span class="product-description">
																			<span>Monday, 28th October 2019</span> TO <span>Saturday, 2nd November 2019 </span>
																		</span>
																	</div>
																</li> 

															</ul>
														</div>
														<div class="tab-pane" id="tab_9">
													<ul class="products-list product-list-in-box">
														<li class="item">                           
															<div class="product-info">
																<a href="javascript:void(0)" class="product-title">BABRI MASJID DWADHSTH
																	<span class="pull-right"><div class="element"></div></span></a>
																	<span class="product-description">
																		<span>Sunday, 14th April 2019</span> TO <span>Sunday, 14th April 2019 </span>
																	</span>
																</div>
															</li>
															<li class="item">                               
																<div class="product-info">
																	<a href="javascript:void(0)" class="product-title">Dushara
																		<span class="label label-info pull-right"></span></a>
																		<span class="product-description">
																			<span>Monday, 28th October 2019</span> TO <span>Saturday, 2nd November 2019 </span>
																		</span>
																	</div>
																</li> 

															</ul>
														</div>
														<div class="tab-pane" id="tab_10">
															<ul class="products-list product-list-in-box">
																<li class="item">                           
																	<div class="product-info">
																		<a href="javascript:void(0)" class="product-title">JIWANSATHI
																			<span class="pull-right"><div class="element"></div></span></a>
																			<span class="product-description">
																				<span>Sunday, 14th April 2019</span> TO <span>Sunday, 14th April 2019 </span>
																			</span>
																		</div>
																	</li>
																<li class="item">                               
																	<div class="product-info">
																		<a href="javascript:void(0)" class="product-title">Dushara
																		<span class="label label-info pull-right"></span></a>
																		<span class="product-description">
																			<span>Monday, 28th October 2019</span> TO <span>Saturday, 2nd November 2019 </span>
																		</span>
																	</div>
																</li> 
															</ul>
														</div>
														<div class="tab-pane" id="tab_11">
													<ul class="products-list product-list-in-box">
														<li class="item">                           
															<div class="product-info">
																<a href="javascript:void(0)" class="product-title">CHL MERE BHAI
																	<span class="pull-right"><div class="element"></div></span></a>
																	<span class="product-description">
																		<span>Sunday, 14th April 2019</span> TO <span>Sunday, 14th April 2019 </span>
																	</span>
																</div>
															</li>
															<li class="item">                               
																<div class="product-info">
																	<a href="javascript:void(0)" class="product-title">Dushara
																		<span class="label label-info pull-right"></span></a>
																		<span class="product-description">
																			<span>Monday, 28th October 2019</span> TO <span>Saturday, 2nd November 2019 </span>
																		</span>
																	</div>
																</li> 

															</ul>
														</div>


													</div>
													<!-- /.tab-content -->
												</div> 
											</div>


																		</div>
																		<!-- /.tab-content -->
																	</div>         
																</div>            
															</div>
															<div class="col-md-4">  
																<div class="row">                               
																	<div class="col-md-12">   
																		<div class="box box-info">
																			<div class="box-header with-border">
																				<h3 class="box-title text-center">Student Profile</h3>                                          
																			</div>  
																			<div class="box-body box-profile">
																				<img class="profile-user-img img-responsive img-circle" src="<?php echo base_url();?>assets/false_images/user3-128x128.jpg" alt="User profile picture">

																				<h3 class="profile-username text-center" style="margin-bottom:0px;color:#990000">Nina Mcintire</h3>
																				<p class="text-muted text-center" style="margin-bottom:0px;"><span>Admission No.</span>123456</p>
																				<p class="text-muted text-center">Software Engineer</p>

																				<ul class="list-group list-group-unbordered" style="margin-bottom: 3px;">
																					<li class="list-group-item" style="padding: 6px 15px;">
																						<b>Mother's Name</b> <a class="pull-right">Kriti Mishra</a>
																					</li>
																					<li class="list-group-item" style="padding: 6px 15px;">
																						<b>Father's Name</b> <a class="pull-right">Abhinay  Mishra</a>
																					</li>                                      
																				</ul>
																			</div>
																		</div>       
																	</div>                                               
																</div>             
															</div>
														</div>

														

														<div class="row">
															<div class="row">
		<div class="col-md-6">          
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Teacher Birthday</h3>
				</div>
				<div class="box-body" style="padding-left: 18px;">
					<marquee behavior="alternate">
						<div class="col-md-3"> 
							<img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(30).jpg" class="img-thumbnail" alt="Responsive Image" style="width: 95px;border-radius: 50%;">
							<figcaption style="margin-left:30px;">Name</figcaption>							
						</div>
						<div class="col-md-3"> <img src="assets/false_images/user3-128x128.jpg" class="img-thumbnail" alt="Responsive Image" style="width: 95px;border-radius: 50%;margin-left:10px;">
							<figcaption style="margin-left:30px;">Name</figcaption>	
						</div>
						<div class="col-md-3"><img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(30).jpg" class="img-thumbnail" alt="Responsive Image" style="width: 95px; border-radius: 50%;margin-left:10px;">
							<figcaption style="margin-left:30px;">Name</figcaption>	
						</div>
						
					</marquee>
					               
				</div>    
			</div>            
		</div>
		
		<div class="col-md-6">  
			<div class="row">                               
				<div class="col-md-12">   
					<div class="box box-info">
						<div class="box-header with-border">
							<h3 class="box-title text-center">Student Birthday</h3>                                          
						</div>  
						<div class="box-body" style="padding-left: 18px;">
							<marquee direction = "right">
								<div class="col-md-3"> 
									<img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(30).jpg" class="img-thumbnail" alt="Responsive Image" class="" style="width: 95px;border-radius: 50%;">
									<figcaption style="margin-left:30px;">Name</figcaption>							
								</div>
								<div class="col-md-3"> <img src="assets/false_images/user3-128x128.jpg" class="img-thumbnail" alt="Responsive Image" style="width: 95px;border-radius: 50%;margin-left:10px;">
									<figcaption style="margin-left:30px;">Name</figcaption>	
								</div>
								<div class="col-md-3"><img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(30).jpg" class="img-thumbnail" alt="Responsive Image" style="width: 95px; border-radius: 50%;margin-left:10px;">
									<figcaption style="margin-left:30px;">Name</figcaption>	
								</div>
								<div class="col-md-3"><img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(30).jpg" class="img-thumbnail" alt="Responsive Image" style="width: 95px; border-radius: 50%;margin-left:10px;">
									<figcaption style="margin-left:30px;">Name</figcaption>	
								</div>
							</marquee>					               
						</div>   
					</div>       
				</div>                                               
			</div>             
		</div>
	</div>
</div>
</section>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>  
<script type="text/javascript">
//    google.charts.load("visualization","1.1", {packages: ['corechart']});
google.charts.load("current", {packages: ['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
	var jsonData = $.ajax({
		url: "<?php echo base_url('Dashboard/result_graph'); ?>",
		dataType: "json",
		async: false
	}).responseText;

// Create our data table out of JSON data loaded from server. 
var data = new google.visualization.DataTable(jsonData);
// Instantiate and draw our chart, passing in some options. 
var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
chart.draw(data);

var barchart = new google.visualization.BarChart(document.getElementById('bar_chart_div'));
barchart.draw(data);
}


</script>


