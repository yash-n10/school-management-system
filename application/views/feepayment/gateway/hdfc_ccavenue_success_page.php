<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		
		<style>
			body{
				font-family: Verdana, sans-serif;
				font-size: 12px;
			}
			
			.wrapper{
				width: 980px;
				margin: 0 auto;	
			}
            
			table { }
			
			tr{ padding: 5px; }
			
			td{ padding:5px; }
            
			input{ padding:5px;	}
			
			h3 {
				background: lightcyan;
				margin: 0px !important;
				height: 36px;
				color: darkgreen;  
			}
			
			.button-wrapper {
				height: 50px;
				display: flex;
				align-items: center; 
				justify-content: center; 
				border-bottom: 1px solid grey;
			}
			
			.alert-success {
				color: #3c763d;
				background-color: #dff0d8;
				border-color: #d6e9c6;
			}
			
			.alert {
				padding: 15px;
				border: 1px solid transparent;
				border-radius: 4px;
			}
			
			table th {
				width: 23%;
				text-align: left;
			}
		</style>   
	</head>

	<body style="background:ghostwhite">
		<center>
			<div style="width:60%;border:1px solid grey;background: floralwhite;">
				<?php echo $trans_id; ?>
				<?php if($ERROR!=NULL || $ERROR!='') { ?>
				<div class="alert alert-danger" style="background:red; color:white; border-bottom:1px solid grey;">
					<i class="fa fa-lg fa-exclamation-triangle" style="font-size:3.333333em;" aria-hidden="true"></i>
						<strong style="font-size:2.333333em;"><?php echo $ERROR;?></strong>  
				</div>
            
				<table style="width:100%;padding-left: 2%;margin-top: 2%;">
					<tr>
						<td colspan="2" style="margin-top:5%; padding-top:8%; text-align:center; font-size: initial;">
							<a href="<?php echo base_url('payment');?>" class="alert-link">Go to Home Page</a>
						</td>
					</tr>
					<tr>
						<!--<td colspan="2" style="text-align: center;"><?php // require_once(APPPATH . "includes/copyright.php"); ?></td>-->
						<td colspan="2" style="text-align:center;">&copy; <?=date('Y')?> Mildtrix Business Solution Pvt .Ltd </td>
					</tr>
				</table>
            
				<?php } else { 
					if($statusCode=='S'){?>
						<div class="alert alert-success" style="border-bottom:1px solid grey;">
							<i class="fa fa-lg fa-check-circle" style="font-size:3.333333em;" aria-hidden="true"></i>
							<strong style="font-size:2.333333em;">Transaction Successful</strong>  
						</div>
                    
					<?php } 
					else { ?>
						<div class="alert alert-danger" style="background:red;color: white;border-bottom:1px solid grey;">
							<i class="fa fa-lg  fa-exclamation-triangle" style="font-size:3.333333em;" aria-hidden="true"></i>
							<strong style="font-size:2.333333em;">Transaction Failure</strong>  
						</div>
					<?php } ?>

                    <!--<form action="testTxnStatus.php" method="POST">-->

					<table style="width:100%; padding-left: 2%; margin-top: 2%;">
						<tr>
							<th><label for="transactionID">Transaction Id </label></th>
							<td>: <?php echo $txnRefNo;?></td>                                
						</tr>
						<tr> 
							<th><label for="MerchantRefNo">Merchant Ref No. </label></th>
							<td>: <?php echo $orderId;?></td>                                
						</tr>
						<tr>
							<th><label for="paymentID">Payment Id </label></th>
							<td>: <?php echo $payment_id;?></td>                                
						</tr>
						<tr>
							<th><label for="amount">Amount Paid To School </label></th>
							<td>: <?php echo 'INR ' . $amount;?></td>
						</tr>
						<tr>
							<!-- Transaction status description-->
							<th><label for="statusDesc">Status Desc </label></th>
							<td>: <?php echo $statusDesc;?></td>
						</tr>	
						<tr>	<!-- Transaction date time-->
							<th><label for="txnReqDate">Transaction Request Date </label></th>
							<td>: <?php echo $txnReqDate;?></td>
						</tr>
						<tr> 
							<td colspan="2" style="margin-top:5%; padding-top:8%; text-align:center; font-size:initial;">
								<a href="<?php echo base_url('');?>" class="alert-link">Go to Home Page</a>
							</td>
						</tr>
						<tr>
							<td colspan="2" style="text-align:center; font-weight:bolder; color:red;">NOTE :  Please don't Go Back OR Refresh It</td> 
						</tr>
						<tr >
									<!--<td colspan="2" style="text-align: center;"><?php // require_once(APPPATH . "includes/copyright.php"); ?></td>-->
							<td colspan="2" style="text-align:center;">&copy; <?=date('Y')?> Mildtrix Business Solution Pvt .Ltd </td>
						</tr>
						<!-- Authzcode-->          
					</table>
					
					<!--</form>-->
				<?php } ?>
			</div>
		</center>
	</body>
</html>