
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Invoice</title>

	<style>

	body {
		position: relative;
		width: 21cm;  
		height: 29.7cm; 
		margin: 0 auto; 
		color: #001028;
		background: #FFFFFF; 
		font-family: "Times New Roman", Times, serif; 
		font-size: 12px; 
		font-family: Times New Roman;
	}

	header {
		padding: 10px 0;
		margin-bottom: 30px;
	}
   
	table {
		width: 100%;
		/*border-collapse: collapse;*/
		border-collapse:fixed;
		border-spacing: 0;
		margin-bottom: 20px;
		page-break-inside:avoid;
	}

	table tr:nth-child(2n-1) td {
		background: #ffffff;
	}

	table th, table td {
		text-align: center;
	}

	table th {
		/*padding: 2px 10px;*/
		color: #4c4949;
		border-bottom: 1px solid #C1CED9;
		white-space: wrap;        
		/*white-space: nowrap;        */
		/*font-weight: bold;*/
	}

	/*table td {
		padding: 7px;
		text-align: right;  
	}*/

	table { page-break-inside:auto }
	tr    { page-break-inside:avoid; page-break-after:auto }

	.tablebottom {
		border-bottom:1px solid #ffffff;
		background: #ffffff;
	}
	
	.tabletop{
		border-top: 1px solid #ffffff;
		background: #ffffff;
	}

	.tableright{
		border-right: 1px solid #ffffff;
		background: #ffffff;
	}
	
	.tablevertical{
		border-left: 1px solid #ffffff;
		background: #ffffff;
	}
	
	.tablehorizontal{
		background: #ffffff;
		border-right:1px solid #ffffff; 
		border-left:1px solid #ffffff; 
	}
	
	.allborder{
		background: #ffffff;
		border-right:1px solid #ffffff; 
		border-left:1px solid #ffffff;
		border-bottom:1px solid #ffffff;
		border: 1px solid #ffffff;
	}

	footer {
		color: #5D6975;
		width: 100%;
		height: 30px;
		position: absolute;
		bottom: 0;
		border-top: 1px solid #C1CED9;
		padding: 8px 0;
		text-align: center;
	}
    
	</style>

	<style>
		table, th, td {
			border: 1px solid #5D6975;
			margin: 3px -0.5px 3px -0.5px;
		}

	</style>
	</head>

	<body style="width:100%;">
		<br>
    
		<table style="width: 100%;">
			<tr>
				<td class="tableright"> <img style="padding-top:5px;padding-bottom: 5px;" src="<?php if(file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$logo)){echo $_SERVER['DOCUMENT_ROOT'].'/'.$logo;}?>"height="75px;"> </td>
				<td colspan="2" style="text-align: left;" class="tablevertical "> <span style="position: static;width: 100px;font-size: 16px;"><b> <?php echo $school_desc[0]->description; ?> </b>  </span>
					<span style="position: static;width: 100px;"> <br> <?php echo $school_desc[0]->vision; ?> <br> <?php echo $school_desc[0]->address; ?> 
						<br><b>Email : </b><?php echo $school_desc[0]->email; ?> &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp; <b>Tel : </b><?php echo $school_desc[0]->phone; ?>
					</span>
				</td>
				<td class="tabletop tablebottom " > <span style="color: white"></span> </td> <!-- space b/w 2 table -->
				<td class="tableright"> <img style="padding-top:5px;padding-bottom: 5px;" src="<?php if(file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$logo)){echo $_SERVER['DOCUMENT_ROOT'].'/'.$logo;}?>"height="75px;"> </td>
				<td colspan="2" style="text-align: left;" class="tablevertical "> <span style="position: static;width: 100px;font-size: 16px;">  <b> <?php echo $school_desc[0]->description; ?> </b>  </span>
					<span style="position: static;width: 100px;"> <br>  <?php echo $school_desc[0]->vision; ?> <br>  <?php echo $school_desc[0]->address; ?> 
						<br><b>Email : </b><?php echo $school_desc[0]->email; ?> &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp; <b>Tel : </b><?php echo $school_desc[0]->phone; ?>
					</span>
				</td>
			</tr>

			<tr>
				<th colspan="2" style="text-align: left;font-size: 14px;padding-left: 5px;border-right:0px"><b>Payment Details</b></th>
				<th style='border-left:0px'>( Office Copy )</th>
				<th class="tabletop tablebottom"></th>
				<th colspan="2" style="text-align: left;font-size: 14px;padding-left: 5px;border-right:0px"><b>Payment Details</b></th>
				<th style='border-left:0px'>( Student Copy )</th>
			</tr>
		
			<?php if($this->session->userdata('school_id')==35) { ?>
			<?php if($q[0]->collection_centre=='FCLB') { ?>
          
			<tr>
				<th colspan="2" style="text-align: left;padding-left: 5px;" class="tableright tablebottom">Transaction Id : <span style="color: #585858;font-weight: 10px;"> <?php echo $q[0]->transaction_id; ?> </span> </th>
				<th style="text-align: left;" class="tablevertical tablebottom">Date : <span style="color: #585858;font-weight: 10px;"> <?php echo $q[0]->payment_date; ?></span></th>
				<th class="tabletop tablebottom"></th>
				<th colspan="2" style="text-align: left;padding-left: 5px;" class="tableright tablebottom">Transaction Id : <span style="color: #585858;font-weight: 10px;"> <?php echo $q[0]->transaction_id; ?> </span> </th>
				<th style="text-align: left;" class="tablevertical tablebottom">Date : <span style="color: #585858;font-weight: 10px;"> <?php echo $q[0]->payment_date; ?></span></th>
			</tr>
			
			<?php } else {
				$c_code=$q[0]->collection_centre;
				$countername=$this->dbconnection->Get_namme("collection_center", "collection_code", "$c_code", "collection_desc");
			?>
        
			<tr>
        		<th colspan="2" style="text-align: left;padding-left: 5px;" class="tableright tablebottom">Counter : <span style="color: #585858;font-weight: 10px;"> <?php echo $countername; ?> </span> </th>
				<th style="text-align: left;" class="tablevertical tablebottom">Date : <span style="color: #585858;font-weight: 10px;"> <?php echo $q[0]->payment_date; ?> </span> </th>
				<th class="tabletop tablebottom"></th>
				<th colspan="2" style="text-align: left;padding-left: 5px;" class="tableright tablebottom">Counter : <span style="color: #585858;font-weight: 10px;"> <?php echo $countername; ?> </span> </th>
				<th style="text-align: left;" class="tablevertical tablebottom">Date : <span style="color: #585858;font-weight: 10px;">: <?php echo $q[0]->payment_date; ?> </span> </th>
			</tr>
        
			<?php } ?>
			<!--   <tr>
        
        <th colspan="2" style="text-align: left;padding-left: 5px;" class="tableright tablebottom">Transaction Id : <span style="color: #585858;font-weight: 10px;"> <?php echo $q[0]->transaction_id; ?> </span> </th>
        <th style="text-align: left;" class="tablevertical tablebottom">Date : <span style="color: #585858;font-weight: 10px;"> <?php echo $q[0]->payment_date; ?> </span> </th>
        <th class="tabletop tablebottom"></th>
        <th colspan="2" style="text-align: left;padding-left: 5px;" class="tableright tablebottom">Transaction Id : <span style="color: #585858;font-weight: 10px;"> <?php echo $q[0]->transaction_id; ?> </span> </th>
        <th style="text-align: left;" class="tablevertical tablebottom">Date : <span style="color: #585858;font-weight: 10px;"> <?php echo $q[0]->payment_date; ?> </span> </th>
      </tr> -->
			<?php } else { ?>
			<tr>
				<th colspan="2" style="text-align: left;padding-left: 5px;" class="tableright tablebottom">Transaction Id : <span style="color: #585858;font-weight: 10px;"> <?php echo $q[0]->transaction_id; ?> </span> </th>
				<th style="text-align: left;" class="tablevertical tablebottom">Date : <span style="color: #585858;font-weight: 10px;"> <?php echo $q[0]->payment_date; ?> </span> </th>
				<th class="tabletop tablebottom"></th>
				<th colspan="2" style="text-align: left;padding-left: 5px;" class="tableright tablebottom">Transaction Id : <span style="color: #585858;font-weight: 10px;"> <?php echo $q[0]->transaction_id; ?> </span> </th>
				<th style="text-align: left;" class="tablevertical tablebottom">Date : <span style="color: #585858;font-weight: 10px;"> <?php echo $q[0]->payment_date; ?> </span> </th>
			</tr>
			<?php } ?>
    <!--   <tr>
        <th colspan="2" style="text-align: left;padding-left: 5px;" class="tableright tablebottom">Transaction Id : <span style="color: #585858;font-weight: 10px;"> <?php echo $q[0]->transaction_id; ?> </span> </th>
        <th style="text-align: left;" class="tablevertical tablebottom">Date : <span style="color: #585858;font-weight: 10px;"> <?php echo $q[0]->payment_date; ?> </span> </th>
        <th class="tabletop tablebottom"></th>
        <th colspan="2" style="text-align: left;padding-left: 5px;" class="tableright tablebottom">Transaction Id : <span style="color: #585858;font-weight: 10px;"> <?php echo $q[0]->transaction_id; ?> </span> </th>
        <th style="text-align: left;" class="tablevertical tablebottom">Date : <span style="color: #585858;font-weight: 10px;"> <?php echo $q[0]->payment_date; ?> </span> </th>
      </tr> -->
			<tr>
				<th colspan="2" style="text-align: left;padding-left: 5px;" class="tableright tabletop tablebottom">Receipt No. : <span style="color: #585858;font-weight: 10px;"> <?php echo $q[0]->receipt_no; ?> </span> </th>
				<th style="text-align: left;" class="tablevertical tabletop tablebottom">Mode : <span style="color: #585858;font-weight: 10px;"> <?php echo $q[0]->mode; ?> </span> </th>
				<th class="tabletop tablebottom"></th>
				<th colspan="2" style="text-align: left;padding-left: 5px;" class="tableright tabletop tablebottom">Receipt No.<span style="color: #585858;font-weight: 10px;"> <?php echo $q[0]->receipt_no; ?> </span> </th>
				<th style="text-align: left;" class="tablevertical tabletop tablebottom">Mode : <span style="color: #585858;font-weight: 10px;"> <?php echo $q[0]->mode; ?> </span> </th>
			</tr>
			<tr>
				<th colspan="2" style="text-align: left;padding-left: 5px;" class="tableright tabletop tablebottom">Admission No. : <span style="color: #585858;font-weight: 10px;"> <?php echo $student[0]->admission_no; ?> </span> </th>
				<th style="text-align: left;" class="tablevertical tabletop tablebottom">Roll : <span style="color: #585858;font-weight: 10px;"> <?php echo $student[0]->roll; ?> </span> </th>
				<th class="tabletop tablebottom"></th>
				<th colspan="2" style="text-align: left;padding-left: 5px;" class="tableright tabletop tablebottom">Admission No. : <span style="color: #585858;font-weight: 10px;"> <?php echo $student[0]->admission_no; ?> </span> </th>
				<th style="text-align: left;" class="tablevertical tabletop tablebottom">Roll : <span style="color: #585858;font-weight: 10px;"> <?php echo $student[0]->roll; ?> </span> </th>
			</tr>
			<tr>
				<th colspan="2" style="text-align: left;padding-left: 5px;" class="tableright tabletop tablebottom">Name : <span style="color: #585858;font-weight: 10px;"> <?php echo $student[0]->name; ?> </span> </th>
				<th style="text-align: left;" class="tablevertical tabletop tablebottom">Class : <span style="color: #585858;font-weight: 10px;"> <?php echo $student[0]->class_name; ?> <?php echo $student[0]->sec_name; ?> </span> </th>
				<th class="tabletop tablebottom"></th>
				<th colspan="2" style="text-align: left;padding-left: 5px;" class="tableright tabletop tablebottom">Name : <span style="color: #585858;font-weight: 10px;"> <?php echo $student[0]->name; ?> </span> </th>
				<th style="text-align: left;" class="tablevertical tabletop tablebottom">Class : <span style="color: #585858;font-weight: 10px;"> <?php echo $student[0]->class_name; ?> <?php echo $student[0]->sec_name; ?> </span> </th>
			</tr>
			<tr>
				<th colspan="2" style="text-align: left;padding-left: 5px;" class="tableright tabletop tablebottom">Father's Name : <span style="color: #585858;font-weight: 10px;"> <?php echo $student[0]->father_name; ?> </span> </th>
				<th style="text-align: left;" class="tablevertical tabletop tablebottom"> </th>
				<th class="tabletop tablebottom"></th>
				<th colspan="2" style="text-align: left;padding-left: 5px;" class="tableright tabletop tablebottom">Father's Name : <span style="color: #585858;font-weight: 10px;"> <?php echo $student[0]->father_name; ?> </span> </th>
				<th style="text-align: left;" class="tablevertical tabletop tablebottom"> </th>
			</tr>
			<tr>
                <th style="text-align: left;padding-left: 5px;" class="tableright  tabletop tablebottom" >Category : <span style="color: #585858;font-weight: 10px;"> <?php echo $student[0]->cat_name; ?> </span> </th>
				<th style="text-align: left;" class="tablevertical tabletop tablebottom " colspan="2">Fee Paid : <span style="color: #585858;font-weight: 10px;"> <?php echo $fee_paid; ?> </span> </th>
				<th class="tabletop tablebottom"></th>
				<th style="text-align: left;padding-left: 5px;" class="tableright  tabletop tablebottom" >Category : <span style="color: #585858;font-weight: 10px;"> <?php echo $student[0]->cat_name; ?> </span> </th>
				<th style="text-align: left;" class="tablevertical tabletop tablebottom " colspan="2">Fee Paid : <span style="color: #585858;font-weight: 10px;"> <?php echo $fee_paid; ?> </span> </th>
			</tr>


      
			<tr>
				<th colspan="2">Fees Name</th>
				<th >Amount (Rs.)</th>
				<th class="tabletop tablebottom"></th>
           		<th colspan="2">Fees Name</th>
				<th>Amount (Rs.)</th>
			</tr>
        
			<?php $total = 0; $l=0;    
			foreach ($monthly_fee as $obj) {
				$total = $total + $obj->fee_amount;$l++; ?>
       
			<tr>
				<th class=" tablebottom tabletop" colspan="2" style="text-align: left;padding-left: 10px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $obj->fee_name; ?> </span> </th>
				<th class=" tablebottom tabletop" style="text-align:right; padding-right: 50px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $obj->fee_amount; ?> </span> </th>
				<th class="tabletop tablebottom"></th>
				<th class=" tablebottom tabletop" colspan="2" style="text-align: left;padding-left: 10px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $obj->fee_name; ?> </span> </th>
				<th class=" tablebottom tabletop" style="text-align:right; padding-right: 50px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $obj->fee_amount; ?> </span> </th>
			</tr>
			<?php } ?>
		
			<?php if($transport_fee>0) {
				$total = $total + $transport_fee;$l++; ?>
					
				<tr>
					<th class=" tablebottom tabletop" colspan="2" style="text-align: left;padding-left: 10px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo 'Transport Fees'; ?> </span> </th>
					<th class=" tablebottom tabletop" style="text-align:right; padding-right: 50px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $transport_fee; ?> </span> </th>
					<th class="tabletop tablebottom"></th>
					<th class=" tablebottom tabletop" colspan="2" style="text-align: left;padding-left: 10px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo 'Transport Fees'; ?> </span> </th>
					<th class=" tablebottom tabletop" style="text-align:right; padding-right: 50px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $transport_fee; ?> </span> </th>
				</tr>
			<?php } ?>
        
			<?php if(($school_desc[0]->school_group)!='ARMY') {
				foreach ($annual_fee as $obj) {
					$total = $total + $obj->fee_amount;$l++; ?>
					<tr>
						<th class=" tablebottom tabletop" colspan="2" style="text-align: left;padding-left: 10px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $obj->fee_name; ?> </span> </th>
						<th class=" tablebottom tabletop" style="text-align:right; padding-right: 50px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $obj->fee_amount; ?> </span> </th>
						<th class="tabletop tablebottom"></th>
						<th class=" tablebottom tabletop" colspan="2" style="text-align: left;padding-left: 10px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $obj->fee_name; ?> </span> </th>
						<th class=" tablebottom tabletop" style="text-align:right; padding-right: 50px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $obj->fee_amount; ?> </span> </th>
					</tr>
				<?php } 

			} else {
				foreach($annual_fee as $obj_pdf) {
					$rest_month = (12-$start_fee_month)+1;
					$fee_amount = $obj_pdf->fee_amount;
					$fee_id     = $obj_pdf->fee_id;
					if($fee_id==10 || $fee_id==16) {
						$fee = $fee_amount;
					} else {
						$fee = ($fee_amount/12)*$rest_month;
					}
					$total = $total +$fee;$l++;
					?>     
					<tr>
						<th class="tablebottom tabletop" colspan="2" style="text-align: left;padding-left: 10px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $obj_pdf->fee_name; ?> </span> </th>
						<th class="tablebottom tabletop" style="text-align:right; padding-right: 50px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $fee; ?> </span> </th>
						<th class="tabletop tablebottom"></th>
						<th class="tablebottom tabletop" colspan="2" style="text-align: left;padding-left: 10px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $obj_pdf->fee_name; ?> </span> </th>
						<th class="tablebottom tabletop" style="text-align:right; padding-right: 50px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $fee; ?> </span> </th>
					</tr>
				<?php }           
			} ?>
      
			<?php 
			foreach ($one_fee as $obj) {
				$total = $total + $obj->fee_amount;$l++; ?>
			
				<tr>
					<th class="tablebottom tabletop" colspan="2" style="text-align: left;padding-left: 10px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $obj->fee_name; ?> </span> </th>
					<th class="tablebottom tabletop" style="text-align:right; padding-right: 50px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $obj->fee_amount; ?> </span> </th>
					<th class="tabletop tablebottom"></th>
					<th class="tablebottom tabletop" colspan="2" style="text-align: left;padding-left: 10px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $obj->fee_name; ?> </span> </th>
					<th class="tablebottom tabletop" style="text-align:right; padding-right: 50px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $obj->fee_amount; ?> </span> </th>
				</tr>
			<?php } ?>
      
			<?php 	
			foreach ($other_fee as $obj) {
				$total = $total + $obj->fee_amount;$l++; ?>
		
				<tr>
					<th class="tablebottom tabletop" colspan="2" style="text-align: left;padding-left: 10px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $obj->fee_name; ?> </span> </th>
					<th class="tablebottom tabletop" style="text-align:right; padding-right: 50px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $obj->fee_amount; ?> </span> </th>
					<th class="tabletop tablebottom tabletop"></th>
					<th class="tablebottom tabletop" colspan="2" style="text-align: left;padding-left: 10px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $obj->fee_name; ?> </span> </th>
					<th class="tablebottom tabletop" style="text-align:right; padding-right: 50px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $obj->fee_amount; ?> </span> </th>
					</tr>
			<?php } ?>
      
			<?php 
			foreach ($instant_fee as $obj) {
				$total = $total + $obj->fee_amount;$l++; ?>
				<tr>
					<th class="tablebottom tabletop" colspan="2" style="text-align: left;padding-left: 10px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $obj->fee_name; ?> </span> </th>
					<th class="tablebottom tabletop" style="text-align:right; padding-right: 50px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $obj->fee_amount; ?> </span> </th>
					<th class="tabletop tablebottom tabletop"></th>
					<th class="tablebottom tabletop" colspan="2" style="text-align: left;padding-left: 10px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $obj->fee_name; ?> </span> </th>
					<th class="tablebottom tabletop" style="text-align:right; padding-right: 50px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $obj->fee_amount; ?> </span> </th>
				</tr>
			<?php } ?>
       
			<?php 
       // if($fine_fee!=0) { 
			foreach ($fine_fee as $obj) {
				$total = $total + $obj->fee_amount;$l++; 
				if($obj->fee_amount>0) { ?>
					<tr>
						<th class="tablebottom tabletop" colspan="2" style="text-align: left;padding-left: 10px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $obj->fee_name; ?> </span> </th>
						<th class="tablebottom tabletop" style="text-align:right; padding-right: 50px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $obj->fee_amount; ?> </span> </th>
						<th class="tabletop tablebottom"></th>
						<th class="tablebottom tabletop" colspan="2" style="text-align: left;padding-left: 10px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $obj->fee_name; ?> </span> </th>
						<th class="tablebottom tabletop" style="text-align:right; padding-right: 50px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $obj->fee_amount; ?> </span> </th>
					</tr>
				<?php }  
			} ?>
      
			<?php 
			if(!empty($readmsnfine_fee)) {
				$total = $total + $readmsnfine_fee[0]->fee_amount;$l++; ?>
			
				<tr>
					<th class="tablebottom tabletop" colspan="2" style="text-align: left;padding-left: 10px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $readmsnfine_fee[0]->fee_name; ?> </span> </th>
					<th class="tablebottom tabletop" style="text-align:right; padding-right: 50px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $readmsnfine_fee[0]->fee_amount; ?> </span> </th>
					<th class="tabletop tablebottom"></th>
					<th class="tablebottom tabletop" colspan="2" style="text-align: left;padding-left: 10px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $readmsnfine_fee[0]->fee_name; ?> </span> </th>
					<th class="tablebottom tabletop" style="text-align:right; padding-right: 50px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $readmsnfine_fee[0]->fee_amount; ?> </span> </th>
				</tr>
			<?php }   ?>
      
			<?php 
			foreach ($half_fee as $obj) {
				$total = $total + $obj->fee_amount;$l++; ?>
				<tr>
					<th class="tablebottom tabletop" colspan="2" style="text-align: left;padding-left: 10px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $obj->fee_name; ?> </span> </th>
					<th class="tablebottom tabletop" style="text-align:right; padding-right: 50px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $obj->fee_amount; ?> </span> </th>
					<th class="tabletop tablebottom"></th>
					<th class="tablebottom tabletop" colspan="2" style="text-align: left;padding-left: 10px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $obj->fee_name; ?> </span> </th>
					<th class="tablebottom tabletop" style="text-align:right; padding-right: 50px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $obj->fee_amount; ?> </span> </th>
				</tr>
			<?php }   ?>

			<?php 
			if($this->session->userdata('school_id')==35) {
				if($discount>0) { 
					$total = $total;
					$l++; ?>
       		<!-- <tr>
	          <th class=" tablebottom tabletop" colspan="2" style="text-align: left;padding-left: 10px;"> <span style="color: #585858;font-weight: 10px;"> <?php //echo 'Fine Waiver  (-)'; ?> </span> </th>
	          <th class=" tablebottom tabletop" style="text-align:right; padding-right: 50px;"> <span style="color: #585858;font-weight: 10px;"> <?php// echo $discount; ?> </span> </th>
	          <th class="tabletop tablebottom"></th>
	          <th class=" tablebottom tabletop" colspan="2" style="text-align: left;padding-left: 10px;"> <span style="color: #585858;font-weight: 10px;"> <?php //echo 'Fine Waiver  (-)'; ?> </span> </th>
	          <th class=" tablebottom tabletop" style="text-align:right; padding-right: 50px;"> <span style="color: #585858;font-weight: 10px;"> <?php //echo $discount; ?> </span> </th>
      		</tr>  -->
				<?php }
			} else{ 
				if($discount>0) {
						 $total = $total;
				//	$total = $total - $discount;
					$l++; ?>
					
					<tr>
						<th class="tablebottom tabletop" colspan="2" style="text-align: left;padding-left: 10px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo 'Fine Waiver (-)'; ?> </span> </th>
						<th class="tablebottom tabletop" style="text-align:right; padding-right: 50px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $discount; ?> </span> </th>
						<th class="tabletop tablebottom"></th>
						<th class="tablebottom tabletop" colspan="2" style="text-align: left;padding-left: 10px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo 'Fine Waiver (-)'; ?> </span> </th>
						<th class="tablebottom tabletop" style="text-align:right; padding-right: 50px;"> <span style="color: #585858;font-weight: 10px;"> <?php echo $discount; ?> </span> </th>
					</tr> 
				<?php }
			} ?>

			<?php if($l<30) { 
				for($k=0;$k<30-$l;$k++) {?>
					<tr>
						<th class=" tablebottom tabletop" colspan="2" style="text-align: left;padding-left: 10px;"> <span style="color: #585858;font-weight: 10px;"> <?php // echo 'Instant Discount'; ?> </span> </th>
						<th class=" tablebottom tabletop" style="text-align:right; padding-right: 50px;"> <span style="color: #585858;font-weight: 10px;"> <?php // echo $discount; ?> </span> </th>
						<th class="tabletop tablebottom"></th>
						<th class=" tablebottom tabletop" colspan="2" style="text-align: left;padding-left: 10px;"> <span style="color: #585858;font-weight: 10px;"> <?php // echo 'Instant Discount'; ?> </span> </th>
						<th class=" tablebottom tabletop" style="text-align:right; padding-right: 50px;"> <span style="color: #585858;font-weight: 10px;"> <?php // echo $discount; ?> </span> </th>
					</tr> 
				<?php }
			}?>
      
			<tr>
				<th colspan="2" class="tableright">Total </th>
				<th class="tablevertical" style="text-align:right; padding-right: 50px;">Rs. <span style="color: #585858;font-weight: 10px;"> <?php echo  $total; ?> </span> </th>
				<th class="tabletop tablebottom"> </th>
				<th colspan="2" class="tableright">Total </th>
				<th class="tablevertical" style="text-align:right; padding-right: 50px;">Rs. <span style="color: #585858;font-weight: 10px;"> <?php echo  $total; ?> </span> </th>
			</tr>
			<tr>
				<th class="tableright" style="text-align: left;">Amount (in words) :  </th>
				<th colspan="2" class="tablevertical" style="text-align: left;"> <span style="color: #585858;font-weight: 10px;">Rs. <?php echo strtoupper($this->numbertowords->convert_number($total) . ' only'); ?> </span> </th>
				<th class="tabletop tablebottom"></th>
				<th class="tableright" style="text-align: left;">Amount (in words) :  </th>
				<th colspan="2" class="tablevertical" style="text-align: left;"> <span style="color: #585858;font-weight: 10px;">Rs. <?php echo strtoupper($this->numbertowords->convert_number($total) . ' only'); ?> </span> </th>
			</tr>
			<tr>
				<th valign="bottom" style="text-align:right;height:20px;padding-right: 20px;" colspan="3" class="tablebottom">Authorised Sign.</th>
				<th class="tabletop tablebottom"></th>
				<th valign="bottom" style="text-align:right;height:20px;padding-right: 20px;" colspan="3" class="tablebottom" >Authorised Sign.</th>
				</tr>
			<tr>
				<th style="text-align:left;height:20px;padding-right: 20px;" colspan="3" class="tablebottom tabletop" > <br> <span style="color: #3d5897;font-weight: 10px;"> Powered by : <b> Mildtrix Business Solution Pvt Ltd. </b> </span>
					<br><br> <span> <b> *This is computer generated receipt. It does not require any seal and signature. </b> </span>
				</th>
				<th class="tabletop tablebottom"></th>
				<th style="text-align:left;height:20px;padding-right: 20px;" colspan="3" class="tablebottom tabletop" > <br> <span style="color: #3d5897;font-weight: 10px;"> Powered by : <b> Mildtrix Business Solution Pvt Ltd. </b> </span>
					<br><br> <span> <b> *This is computer generated receipt. It does not require any seal and signature. </b> </span>
				</th>
			</tr>
		</table>
	</body>
</html>