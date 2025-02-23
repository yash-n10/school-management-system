<style>
.info-box-text {
		color: #fff;
}
.btn-app {        
		min-width: 120px;
		height: 82px;
		font-size: 15px;
}
.external:hover {
		-moz-transform: scale(1.1);
		-webkit-transform: scale(1.1);
		transform: scale(1.1);
}
.box {
		box-shadow: 1px 1px 1px 1px #80ffff;
}
.products-list .product-info {
		margin-left: 0px; 
}
.nav-tabs-custom>.nav-tabs>li.active {
		border-top-color: #dd4b39;
}
@media (min-width: 992px) {
		.cc_profile {      
			margin-top: -55px;
		}
		.reportdiv {
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

.nogap {
		padding-top: 0px;
		padding-right: 10px;
		padding-bottom: 0px;
		padding-left: 5px;
		margin-top: 1px;
		margin-right: 0px;
		margin-bottom: 1px;
		margin-left: 0px;
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
		<span class=""><i class="fa fa-graduation-cap" style="font-size:30px; float:left; padding-right:15px; color: #663d00;"></i> </span> 
		<span class="" style="font-size:25px; color:#663d00;text-transform:capitalize; font-weight:bold;"><?php echo 'Welcome,' . ' ' . $student_name . ' !'; ?></span>
	</div>
</div>

<section class="content">    
	<div class="row">
		<div class="col-md-8">          
			<div class="box box-info">
				<div class="box-header with-border" style="background-color: #ccffff;">   
					<h5 class="box-title" style="color:#00c0ee; font-weight:bold;">My Favorites</h5>
				</div>
				<div class="box-body" style="padding-left: 18px;">
					<?php if (in_array('store', $a)) { ?>
						<a class="btn btn-app bg-aqua" href="<?php echo base_url('store/payment'); ?>">
							<i class="fa fa-inr"></i> Payments
						</a>
					<?php } ?>
<!--					<?php if (in_array('communication', $a)) { ?>
						<a class="btn btn-app bg-aqua" href="<?php echo base_url('communication/Mailsms'); ?>">
							<i class="fa fa-inbox"></i> Mail/ SMS
						</a> 
					<?php } ?>          -->         
				</div>              
			</div>            
		</div>
		<div class="col-md-4">  
			<div class="row">                               
				<div class="col-md-12" style="height:100px;"> <!-- cc_profile">  -->
					<div class="box box-info">
						<div class="box-header with-border" style="background-color: #ccffff;">
							<h5 class="box-title" style="color:#00c0ee; font-weight:bold;">My Profile</h5>											
						</div>  
						<div class="box-body box-profile">
							<img class="profile-user-img img-responsive img-circle" src="<?php echo base_url();?>assets/false_images/user.jpg" alt="User profile picture">
							<h3 class="profile-username text-center" style="margin-bottom:0px;color:#990000;"><?php echo $student_name ?></h3>
							<p class="text-muted text-center" style="margin-bottom:0px;"><span>Admission No. : </span><?php echo $adm ?></p>
							<p class="text-muted text-center"><span>Class: </span><?php echo $clas ?> <?php echo $sec ?></p>

							<ul class="list-group list-group-unbordered" style="margin-bottom: 3px;">
								<li class="list-group-item" style="padding: 7px 15px;">
									<b>Mother's Name : </b> <a class="pull-right"><?php echo $mother ?></a>
								</li>
								<li class="list-group-item" style="padding: 7px 15px;">
									<b>Father's Name : </b> <a class="pull-right"><?php echo $father ?></a>
								</li>	
								<li class="list-group-item" style="padding: 7px 15px;">
									<b>Contact No. : </b> <a class="pull-right"><?php echo $contact ?></a>
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
				<div class="box-header with-border" style="background-color: #ccffff;">
					<h5 class="box-title" style="color:#00c0ee; font-weight:bold;" >Account Summary</h5>
				</div>
				<div class="box-body">
					<div class="table-responsive">
						<table class="table table-bordered no-margin">
							<thead style="background:#99ceff;">
								<tr>
									<th style="border-bottom:0px; width:20%; text-align:center;">Total Amount Charged</th>
									<th style="border-bottom:0px; width:20%; text-align:center;">Total Amount Paid</th>
									<th style="border-bottom:0px; width:20%; text-align:center;">Outstanding Amount</th>
									<th style="border-bottom:0px; width:20%; text-align:center;">Wallet</th>
									<th style="border-bottom:0px; width:20%; text-align:center;">Action</th>
								</tr>
							</thead>

							<tbody style="font-size:13px;">
								<?php 
								if(isset($student_pay) && count($student_pay) > 0) {
									$dues = 0;
									$paid = 0;
									$overdue = 0;
									$wallet = 0;
									
									foreach ($student_pay as $arritem) {
										if($arritem->approved == 'N') {
											$unbilled = $arritem->tot_amt_charged;
										}
										else {
											if (is_null ($arritem->tot_amt_charged) == false) 
												$dues = $arritem->tot_amt_charged;

											if (is_null ($arritem->tot_amt_paid) == false) 
												$paid = $arritem->tot_amt_paid;
									
											if ($dues > $paid) {
												$overdue = ($dues - $paid);
												$wallet = "";
											}
											if ($paid >= $dues) {
												$wallet = ($paid - $dues);
												$overdue = "";
											}
									?>
											<tr>
												<td valign="middle" style="cell-padding:none; height:20px; text-align:right; padding-right:20px; "><?php echo number_format($dues,2); ?></td>
												<td valign="middle" style="cell-padding:none; height:20px; text-align:right; padding-right:20px; "><?php echo number_format($paid,2); ?></td>
												<td valign="middle" style="cell-padding:none; height:20px; text-align:right; padding-right:20px; "><?php echo number_format($overdue,2); ?></td>                                    
												<td valign="middle" style="cell-padding:none; height:20px; text-align:right; padding-right:20px; "><?php echo number_format($wallet,2); ?></td>
												<td style="cell-padding:none; text-align:center;"><a class="btn bg-aqua nogap" href="<?php echo base_url('store/accstudent'); ?>">Passbook</a>
												</td>                                         
											</tr>
										<?php }
									}
								}
								?>
							</tbody>
						</table>
						<br/>
						<p style="font-size:13px;">You also have unapproved billed amount of <span style="font-size:13px; font-weight: bold">Rs <?php echo number_format($unbilled,2); ?> </span>
					</div>
				</div>
			</div>           
		</div>
	</div>
</section>