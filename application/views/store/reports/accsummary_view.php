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

</style>
<div class="form-group has-feedback">
	<div class="box">
<!--		<div class="box-body">
				<form name="frm_repaccount" class="form-inline" method="post" action="<?php echo base_url('account/trail_balance'); ?>">
					<div class="col-lg-12" style="text-align:left;">
						 <span style="color:#00acee; font-weight:bold; ">List a report type:</span>
						<input type="text" name="repyear" value="0">
						<span>&nbsp;year(s)</span>
					</div>
                
					<div class="form-group col-md-5 col-sm-3 col-md-offset-1" style="margin-top: 15px;">
						<input type="submit" class="btn btn-primary" value="Search" name="submit1">
					</div>
				</form>
		</div>
-->
			
		<div class="box-body">
				<div class="table-responsive">
					<table id="tbl_account" class="table table-bordered table-striped dTable nogap">
						<thead style="background:#99ceff;">
							<tr>
								<th>S.No</th>
								<th style="border-bottom:0px; width:15%; text-align:center;">Admission No.</th>
								<th style="border-bottom:0px; width:21%; text-align:center;">Name</th>
								<th style="border-bottom:0px; width:16%; text-align:center;">Total Amount Charged</th>
								<th style="border-bottom:0px; width:16%; text-align:center;">Total Amount Paid</th>
								<th style="border-bottom:0px; width:16%; text-align:center;">Outstanding Amount</th>
								<th style="border-bottom:0px; width:16%; text-align:center;">Wallet</th>
							</tr>
						</thead>

						<tbody>
							<?php 
							if(isset($arr_store_item) && count($arr_store_item) > 0) {
								$dues = 0;
								$paid = 0;
								$overdue = 0;
								$wallet = 0;
								$i=1;
								foreach ($arr_store_item as $arritem) { 
									if (is_null ($arritem->tot_amt_charged) == false) 
										$dues = $arritem->tot_amt_charged;
									else
										$dues = 0;

									if (is_null ($arritem->tot_amt_paid) == false) 
										$paid = $arritem->tot_amt_paid;
									else
										$paid = 0;
									
								       if ($dues > $paid) {
										$overdue = ($dues - $paid);
										$wallet = "";
									}
									if ($paid >= $dues) {
										$wallet = ($paid - $dues);
										$overdue = "";
									}
								?>
  
									<tr class="nogap">
										<td><?php echo $i;?></td>
										<td style="text-align:center;"><?php echo $arritem->admission_no; ?></td>
										<td ><?php echo $arritem->fullname; ?></td>
										<td style="text-align:right; padding-right:20px; "><?php echo number_format($dues,2); ?></td>
										<td style="text-align:right; padding-right:20px; "><?php echo number_format($paid,2); ?></td>
										<td style="text-align:right; padding-right:20px; "><?php echo number_format($overdue,2); ?></td>                                    
										<td style="text-align:right; padding-right:20px; "><?php echo number_format($wallet,2); ?></td>
								</tr>
								<?php $i++; }
							}
							?>
						</tbody>

						<tfoot>
						</tfoot>
					</table>
				</div>	
		</div>
       </div>
</div>

<script>

    $(document).ready(function () {

     //    $('#tbl_account').DataTable({
     //        dom: 'Bfrtip',
     //        buttons: [
     //            {
					// paging: true,
				 //    searching: true,
     //                extend: 'collection',
     //                text: 'Export',
     //                buttons: [
     //                    'excel',
     //                    'csv',
     //                    'pdf',
     //                    'print'
     //                ]
     //            }
     //        ]
     //    });
    });

</script>
