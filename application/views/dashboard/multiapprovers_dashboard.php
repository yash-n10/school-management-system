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
		<span class=""><i class="fa fa-user-circle-o" style="font-size:30px; float:left; padding-right:15px; color: #663d00;"></i> </span> 
		<span class="" style="font-size:25px; color:#663d00;text-transform:capitalize; font-weight:bold;"><?php echo 'Welcome,' . ' ' . $user_name . ' !'; ?></span>
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
						<a class="btn btn-app bg-green" href="<?php echo base_url('store/billapprove'); ?>">
							<i class="fa fa-check-square-o"></i> Approve Bills
						</a>
					<?php } ?>
					<?php if (in_array('communication', $a)) { ?>
						<a class="btn btn-app bg-aqua" href="<?php echo base_url('communication/Mailsms'); ?>">
							<i class="fa fa-inbox"></i> Mail/ SMS
						</a> 
					<?php } ?>                   
				</div>              
			</div>            
		</div>
		<div class="col-md-4">  
			<div class="row">                               
				<div class="col-md-12" style="height:100px;"> <!-- cc_profile">  -->
					<div class="box box-info">
						<div class="box-header with-border" style="background-color: #ccffff;">
							<h5 class="box-title" style="color:#00c0ee; font-weight:bold;" >Announcements</h5>
						</div>
						<div class="box-body">
							<div class="direct-chat-messages">
								<marquee class="marq" direction="up" loop="" scrollamount="2" onmouseover="this.stop();" onmouseout="this.start();"> 
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
				<div class="box-header with-border" style="background-color: #ccffff;">
					<h5 class="box-title" style="color:#00c0ee; font-weight:bold;" >Bills to Approve</h5>
				</div>
				<div class="box-body">
					<div class="table-responsive">
						<table class="table table-bordered no-margin">
							<thead style="background:#99ceff;">
								<tr>
									<th style="border-bottom:0px; text-align:center; width:8%;">Bill ID</th>
									<th style="border-bottom:0px; text-align:center; width:12%;">Bill Date</th>
									<th style="border-bottom:0px; text-align:center; width:10%;">Amount</th>
									<th style="border-bottom:0px; text-align:center; width:15%;">Admission No.</th>
									<th style="border-bottom:0px; text-align:center; width:20%;">Student Name</th>
									<th style="border-bottom:0px; text-align:center; width:30%;">Status</th>
								</tr>
							</thead>

							<tbody style="font-size:12px;">
								<?php 
								if(isset($store_bill_appr) && count($store_bill_appr) > 0) {
									foreach ($store_bill_appr as $arritem) { 
								?>
									<tr>
										<td><?php echo $arritem->id; ?></td> 
										<td style="text-align:center; "><?php echo $arritem->bill_date; ?></td>                                         
										<td style="text-align:right; "><?php echo number_format($arritem->bill_amt, 2); ?></td>                                         
										<td style="text-align:center; "><?php echo $arritem->admission_no; ?></td>                                         
										<td><?php echo $arritem->student_fname . '  ' . $arritem->student_midname . ' ' . $arritem->student_lname; ?></td>                                         
										<td><?php echo $arritem->final_status; ?></td>                                         
									</tr>
									<?php }
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>           
		</div>
	</div>
</section>