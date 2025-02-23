<style>
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

<div class="form-group has-feedback">
	<div class="box">
		<div class="box-body">
			<div class="col-lg-12">
				<?php if(substr($right_access,0,1)=='C'){?>
					<div class="col-lg-12" style="text-align:right;">
						<a type="button" class="btn btn-add" title="Add fees" style="float:right; font-weight:bold; " href="<?php echo site_url('store/addfee/add_bill');?>">
							<i class="fa fa-plus fa-lg"></i>&nbsp;&nbsp;Add fees</a>

					</div>
				<?php }?>
			</div>
		</div>
			
		<div class="box-body">
	              <form id='frmdetails' role="form" method="POST">
				<div class="table-responsive">
					<table id="itemdetailslist" class="table table-bordered table-striped dTable">
						<thead style="background:#99ceff;">
							<tr>
								<th style="border-bottom:0px; width:5%;">Sl.No</th>
								<th style="border-bottom:0px; width:7%;">Date Created</th>
								<th style="border-bottom:0px; width:7%;">Admission No.</th>
								<th style="border-bottom:0px; width:15%;">Student Name</th>
								<th style="border-bottom:0px; width:11%;">Fee Amount</th>
								<th style="border-bottom:0px; width:19%;">Type</th>
							</tr>
						</thead>

						<tbody style="font-size:12px;">
							<?php 
							if(isset($arr_acc_book) && count($arr_acc_book) > 0) {
								$i=1;
								foreach ($arr_acc_book as $arritem) { 
							?>
								<tr>
									<td><?php echo $i;?></td>
									<td><?php echo $arritem->entry_date; ?></td>
									<td><?php echo $arritem->admission_no; ?></td>      
									<td><?php echo $arritem->student_fname . '  ' . $arritem->student_midname . '  ' . $arritem->student_lname; ?></td>                                         
									<td style="cell-padding:none; height:20px; text-align:right; padding-right:20px;" ><?php echo number_format($arritem->amt_charged,2); ?></td>                                         
									<td><?php echo $arritem->entry_type; ?></td>                                         
								</tr>
								<?php $i++; }
							}
							?>
						</tbody>

						<tfoot>
						</tfoot>
					</table>
				</div>	
			</form>
		</div>
       </div>
</div>