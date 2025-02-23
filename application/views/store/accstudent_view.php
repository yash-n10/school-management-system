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
					<table name="datalist" id="datalist" class="table table-bordered table-striped dTable">
						<thead style="background:#99ceff;">
							<tr>
								<th style="border-bottom:0px; width:10%; text-align:center;">Date</th>
								<th style="border-bottom:0px; width:20%; text-align:center;">Entry Type</th>
								<th style="border-bottom:0px; width:10%; text-align:center;">Entry No.</th>
								<th style="border-bottom:0px; width:16%; text-align:center;">Amount Charged</th>
								<th style="border-bottom:0px; width:16%; text-align:center;">Amount Paid</th>
								<th style="border-bottom:0px; width:28%; text-align:center;">Remarks</th>
							</tr>
						</thead>

						<tbody>
							<?php 
							if(isset($arr_stu_account) && count($arr_stu_account) > 0) {
								foreach ($arr_stu_account as $arritem) { 
							?>
  
								<tr>
									<td style="cell-padding:none; height:20px; text-align:center; "><?php echo $arritem->entry_date; ?></td>
									<td style="cell-padding:none; height:20px; text-align:left; padding-left:10px; "><?php echo $arritem->entry_type; ?></td>
									<td style="cell-padding:none; height:20px; text-align:left; padding-left:10px; "><?php echo $arritem->entry_no; ?></td>
									<td style="cell-padding:none; height:20px; text-align:right; padding-right:20px; "><?php echo number_format($arritem->amt_charged,2); ?></td>
									<td style="cell-padding:none; height:20px; text-align:right; padding-right:20px; "><?php echo number_format($arritem->amt_paid,2); ?></td>
									<td style="cell-padding:none; height:20px; text-align:left; padding-right:20px; "><?php echo $arritem->remarks; ?></td>                                    
								</tr>
								<?php }
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

/*	$(document).ready(function () {
        var table=$('#datalist').DataTable({
            dom: 'Bfrtip',
            "destroy": true,
            "processing": true,
//                            buttons: [

 //   $(document).ready(function () {
   //     $('#datalist').DataTable({
     //       dom: 'Bfrtip',
            buttons: [
                {
//					paging: true,
                    extend: 'collection',
                    text: 'Export',
                    buttons: [
                        'excel',
                        'csv',
                        'pdf',
                        'print'
                    ]
                }
            ]
        });
    });
*/
</script>
