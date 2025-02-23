<style>
    tr.highlight {
        background-color: #dff0d8 !important;
        border-color: #d6e9c6 !important;
        font-weight:bold !important;
        /*color:darkgreen !important;*/
    }
</style>
<div class="box">
        <div class="box-body" >

            
            <div class="panel  panel-success">
                <div class="panel-heading" style="padding: 5px 15px;background-color: #c7eab9"><i class="glyphicon glyphicon-time">  </i> <b> <span style="color:black"> Payment History</span></b></div>
<!--                <div class="panel-body">
                    <div class="col-sm-6">
                        <form name="transactionform" action="" method="post">
                            <table class="table">
                                <tr>
                                    <td>Accedemic Session</td>
                                    <td>
                                        <select class="form-control" name="acedemic_session" required>
                                            <option value="" <?php // echo set_select('acedemic_session', '', TRUE) ?>>Choose</option>
                                            <?php // foreach($acedemic_session as $ac){?>
                                            <option value="<?php // echo $ac->id;?>" <?php // echo set_select('acedemic_session', "$ac->id"); ?>><?php // echo $ac->session;?></option>
                                            <?php // }?>
                                        </select>
                                        
                                    <td><input type="submit" class="btn btn-info"></td>
                                </tr>
                               
                            </table>
                        </form>
                    </div>
                </div>-->
                <div class="panel-body" style="padding:0px">

                    
                    <div class="table-responsive">
                        <table id="list1" class="table table-bordered table-striped" style="width:100%">
                            <thead style="border-bottom: 1px solid black !important">
                                <tr style="background: white;">
                                    <th>Payment date</th>
                                    <th>Description</th>
                                    <th>Total Amount</th>

                                    <th>Remarks</th>
                                    <th>Receipt No</th>
                                    <th>Payment Id</th>
                                    
                                    <th>Status</th>
                                    <th>E-receipt</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total_paid = 0;
                                $month = array(1 => "April", 2 => "May", 3 => "June", 4 => "July", 5 => "August", 6 => "September", 7 => "October", 8 => "Novemeber", 9 => "December", 10 => "January", 11 => "February", 12 => "March");
                                $cnt = 0;
                                foreach ($transaction_history->result() as $payment) {
                                    $cnt++;

                                    if ($payment->paid_status != 0) {
                                        $total_paid = $total_paid + $payment->total_amount;
                                    }

                                    $fe_desc = explode(',', $payment->fee);
                                    $str = '';
                                    foreach ($fe_desc as $index => $value) {
                                        if ($value == 2) {
                                            if ($payment->m > 1) {

                                                $month_var = $payment->from_month + $payment->m - 1;
                                                $str .= $payment->m . " Months Fees (" . $month[$payment->from_month] . " to " . $month[$month_var] . "),";
                                            } else {
                                                $str .= $payment->m . " Month Fees (" . $month[$payment->from_month] . "),";
                                            }
                                        } else if ($value == 1) {
                                            $str .= ' Annual Fees,';
                                        } else if ($value == 3) {
                                            $str .= ' Other Fees,';
                                        } else if ($value == 4) {
                                            $str .= ' Half-Yearly Fees,';
                                        } else if ($value == 6) {
                                            $str .= ' Transport Fees,';
                                        } else if ($value == 0) {
                                            if ($payment->d > 1) {
                                                $str .= ' ' . $payment->d . ' Months Fine,';
                                            } else {
                                                $str .= ' ' . $payment->d . ' Month Fine,';
                                            }
                                        } else if ($value == 11) {
                                            
                                                $str .= 'Re-Admission-Fine,';
                                            
                                        }
                                    }
                                    $str = rtrim($str, ',');
                                    ?>
                                    <?php if(($this->id==29 && $payment->id==82791) ||($this->id==29 && $payment->id==82865) || ($this->id==29 && $payment->id==82409) || ($this->id==29 && $payment->id==83175) || ($this->id==29 && $payment->id==83173)) { ?>
                                    <tr>
                                        <td><?php echo date('Y-m-d', strtotime($payment->payment_date)); ?></td>
                                        <td><?php echo $str; ?></td>
                                        <td><?php echo $payment->total_amount . ' INR'; ?></td>
                                        <td><?php echo $payment->remarks. ' (' . $payment->response_message . ')'; ?></td>
                                        <td><?php echo $payment->receipt_no; ?></td>
                                        <td><?php echo $payment->payment_id; ?></td>
                                        
                                        <td><?php
                                    if ($payment->chargeback_status && $payment->paid_status == 0) {
                                        echo 'You Have Done ChargeBack (UNPAID)';
                                    } else if ($payment->paid_status == 0) {
                                        echo 'UNPAID';
                                    } else {
                                        echo 'PAID';
                                    }
                                    ?></td>
                                        <td></td>
                                    </tr> 
                                    <?php } else { ?>
                                        <tr <?php if ($payment->response_code == '0' && $payment->paid_status == 1) { ?> title="Click to get E-receipt" onclick="get_pdfdet(<?php echo $payment->id ?>);" style="color:darkgreen" <?php }else{ ?> style="color:red" <?php }?>>
                                        <td><?php echo date('Y-m-d', strtotime($payment->payment_date)); ?></td>
                                        <td><?php echo $str; ?></td>
                                        <td><?php echo $payment->total_amount . ' INR'; ?></td>
                                        <td><?php echo $payment->remarks. ' (' . $payment->response_message . ')'; ?></td>
                                        <td><?php echo $payment->receipt_no; ?></td>
                                        <td><?php echo $payment->payment_id; ?></td>
                                        
                                        <td><?php
                                    if ($payment->chargeback_status && $payment->paid_status == 0) {
                                        echo 'You Have Done ChargeBack (UNPAID)';
                                    } else if ($payment->paid_status == 0) {
                                        echo 'UNPAID';
                                    } else {
                                        echo 'PAID';
                                    }
                                    ?></td>
                                        <td><?php if ($payment->response_code == '0' && $payment->paid_status == 1) { ?>   <a href="#" title="Click to get E-receipt"  onclick="get_pdfdet(<?php echo $payment->id ?>);" class="form-contrrol">Download</a> <?php } ?></td>
                                    </tr> 
                                    <?php } ?>
<?php }
?>
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="modal-footer">
                    <b>TOTAL PAID AMOUNT : <?php echo $total_paid; ?> INR</b>
                </div>
            </div>
        </div>
</div>





<!--<div class="box">
	<div class="box-header">
    
    	----CONTROL TABS START-----
		<ul class="nav nav-tabs nav-tabs-left">
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> 
					<?php // echo get_phrase('view_payment');?>
                    	</a></li>
		</ul>
    	----CONTROL TABS END-----
        
	</div>
	<div class="box-content padded">
		<div class="tab-content">            
            --TABLE LISTING STARTS-
            <div class="tab-pane box active" id="list">
				
                <table cellpadding="0" cellspacing="0" border="0" class="dTable responsive">
                	<thead>
                		<tr>
                    		<th><div>#</div></th>
                    		<th><div><?php // echo get_phrase('time');?></div></th>
                    		<th><div><?php // echo get_phrase('amount');?></div></th>
                    		<th><div><?php // echo get_phrase('payment_type');?></div></th>
                    		<th><div><?php // echo get_phrase('transaction_id');?></div></th>
                    		<th><div><?php // echo get_phrase('invoice_id');?></div></th>
                    		<th><div><?php // echo get_phrase('patient');?></div></th>
                    		<th><div><?php // echo get_phrase('method');?></div></th>
                    		<th><div><?php // echo get_phrase('description');?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php 
//						$count = 1;
//						foreach($payments as $row):
							?>
							<tr>
								<td><?php // echo $count++;?></td>
								<td><?php // echo $row['timestamp'];?></td>
								<td><?php // echo $row['amount'];?></td>
								<td><?php // echo $row['payment_type'];?></td>
								<td><?php // echo $row['transaction_id'];?></td>
								<td><?php // echo $row['invoice_id'];?></td>
                                <td><?php // echo $this->crud_model->get_type_name_by_id('patient',$row['patient_id'],'name');?></td>
								<td><?php // echo $row['method'];?></td>
								<td><?php // echo $row['description'];?></td>
							</tr>
							<?php 
//						endforeach;
						?>
                    </tbody>
                </table>
			</div>
            --TABLE LISTING ENDS-
		</div>
	</div>
</div>-->
<script>
    $(document).ready(function ()
    {

        var table = $('#list1').DataTable({
            "scrollX": true,
            "scrollY": "300px",
            "scrollCollapse": true,
            "paging": false,
            "order": [[0, "desc"]]
        });

        $('#list1 tbody').on('click', 'td', function () {
            var colIdx = table.cell(this).index().row;
//            alert(colIdx);
            $('.highlight').removeClass('highlight');
            $(table.row(colIdx).nodes()).addClass('highlight');
        });
    });
    
    function get_pdfdet(trans_id)
    {

        $('#monthly_pay1').load('<?php echo base_url('payment/btn_download_pop_load'); ?>' + '/' + 'dwld_no', {trans_id: trans_id});
        $("#transaction_det1").modal('show');


    }
</script>
<div class="modal fade" id="transaction_det1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="monthly_pay1">

        </div>
    </div>
</div>    