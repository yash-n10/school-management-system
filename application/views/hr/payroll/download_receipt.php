<?php
	

	$totalctctamt=0;
    $totalerntamt=0;
    $totaldedamt=0;
    $erncamt=0;
    $dedcamt=0;
    foreach($earning_sal1 as $r1)
    {               
        if($r1->salary_typ==4) 
        {
            $ctcamt=$r1->sal_amt;
            $totalctctamt=$totalctctamt + $ctcamt;
        }
    }

    foreach($earning_sal1 as $r1)
    {               
        if($r1->salary_typ==1) 
        {
            $erncamt=$r1->sal_amt;
            $totalerntamt=$totalerntamt + $erncamt;
        }
    }

    foreach($earning_sal1 as $r1)
    {               
        if($r1->salary_typ==2) 
        {
            $dedcamt=$r1->sal_amt;
            $totaldedamt=$totaldedamt + $dedcamt;
        }
    }

    $pfemployer = round(($sal_head[0]->pf_employer/$salary[0]->working_days)*$salary[0]->paid_days);
	$esicemployer = round(($sal_head[0]->medical_employer/$salary[0]->working_days)*$salary[0]->paid_days);
	$gross = round(($sal_head[0]->gross_salary));
	
	$earning = round(($totalerntamt/$salary[0]->working_days)*$salary[0]->paid_days);
	$totaldedamt = round(($totaldedamt/$salary[0]->working_days)*$salary[0]->paid_days);
	$ctc_amt_actual = $pfemployer+$gross+$totalctctamt+$esicemployer;
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css"> -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
		.table {
			width: 100%;
			max-width: 100%;
			margin-bottom: 0px; 
		}
		/*.col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 
		{
			position: relative;
			min-height: 1px;
			padding-right: 0px;
			padding-left: 0px;
		}*/
		tr 
		{
			line-height: 15px;
			min-height: 15px;
			height: 15px;
		}
		/*.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th 
		{
			padding: 8px;
			line-height: 0.498571;
			vertical-align: top;
			border-top: 1px solid #ddd;
		}
		.table-bordered 
		{
		    border: 1px solid #002147;
		}*/
		.table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th 
		{
		    border: 1px solid black;
		}
		.p-5
		{
			height: 130px;
			width:100%; 
		}
		.earning
		{
			width:100%; 
		}
		.col-xs-12
		{
			width: 100%;
		}
		.col-md-6
		{
			width: 50%;
		}
		.col-md-8
		{
			width: 60%;
		}
		.col-md-4
		{
			width: 40%;
		}
		.earning .col-md-6
		{
			height: 250px;
		}
	</style>
</head>
<body>
	<div class="">
	  	<div class="row p-5">
            <div class="" style="width: 100%;position: absolute;">
                <p class="font-weight-bold mb-1"><h3><?php echo $school[0]->description;?></h3></p>
                <p class="font-weight-bold" style="margin: 0 0 1px;"><?php echo $school[0]->address;?></p>
                <p class="font-weight-bold" style="margin: 0 0 1px;"><?php echo $school[0]->vision;?></p><!-- 
                <p class="font-weight-bold">Jharkhand,831015</p> -->
            </div>

            <div class="" style="width: 95%;text-align: right;">
                <p class="font-weight-bold mb-1"><h4>Pay Slip</h4></p>	
                <p class="text-muted" style="margin: 0 0 1px;"><span>Contact No - </span><?php echo $school[0]->phone;?></p>
                <p class="text-muted"><span>Email Id - </span><?php echo $school[0]->email;?></p>
            </div>
        </div>
    </div>
	<div class="detail">					
		<table class="table table-bordered">						
			<thead>
				<tr>
					<td colspan="4" style="padding: 19px;text-align:center"><strong>Pay Slip for the Month of NOVEMBER'19</strong></td>	
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Employee Code</td>
					<td><?php echo $fetch_detail[0]->employee_code;?></td>								
					<td>Aadhar No</td>								
					<td><?php echo $fetch_detail[0]->aadhar_id;?></td>								
				</tr>
				<tr>
					<td>Employee Name</td>
					<td><?php echo ucwords(strtolower($fetch_detail[0]->name));?></td>
					<td>PF No.</td>
					<td><?php echo $fetch_detail[0]->pf_accnt;?></td>								
				</tr>
				<tr>
					<td>Employee Category</td>
					<td><?php echo $this->dbconnection->Get_namme('employee_category', 'id', $fetch_detail[0]->category_id, 'category_desc');?></td>
					<td>ESI No</td>
					<td><?php echo $fetch_detail[0]->esi_accnt;?></td>								
				</tr>
				<tr>
					<td>Employee Designation</td>
					<td><?php echo $this->dbconnection->Get_namme('employee_designation', 'id', $fetch_detail[0]->designation_id, 'designation_desc');?></td>
					<td>Bank Account</td>
					<td><?php echo $fetch_detail[0]->bank_accnt_no;?></td>								
				</tr>							
			</tbody>
		</table>
	</div>  
   	<div class="earning" style="margin-top: 10px;">
   		<div class="col-xs-12">					
			<div class="col-md-6" style="width: 50%;position: absolute;">
				<table class="table table-bordered" style="width:99%">						
					<thead>
						<tr>
							<th colspan="3" style="text-align:center;background-color:#002147;color:#fff;">Earnings</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							foreach($earning_sal as $r)
        					{	
        						if($r->salary_typ==1) 
            					{
        				?>
								<tr>							
									<td colspan="2"><?php echo $r->salary_code;?></td>		
									<td><?php echo round(($r->sal_amt/$salary[0]->working_days)*$salary[0]->paid_days);?></td>		
								</tr>
						<?php
								}
							}
						?>
						<tr>
							<td colspan="2"><b>Total Earning </b></td>									
							<td style="text-align:left;"><?php echo round(($totalerntamt/$salary[0]->working_days)*$salary[0]->paid_days);?></td>
						</tr>															
					</tbody>
				</table>
			</div>
			
			<div class="col-md-6" style="margin-left:348px;width:50%;float: right;">
				<table class="table table-bordered">						
					<thead>
						<tr>						
							<th colspan="3" style="text-align:center;background-color:#002147;color:#fff;">Deduction</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							foreach($earning_sal as $r)
        					{	
        						if($r->salary_typ==2) 
            					{
        				?>
								<tr>							
									<td colspan="2"><?php echo $r->salary_code;?></td>		
									<td><?php echo round(($r->sal_amt/$salary[0]->working_days)*$salary[0]->paid_days);?></td>		
								</tr>
						<?php
								}
							}
						?>
						
						<tr>
							<td  colspan="2"><b>Total Deduction </b></td>									
							<td style="text-align:left;"><?php echo round(($totaldedamt/$salary[0]->working_days)*$salary[0]->paid_days);?></td>
						</tr>

					</tbody>
				</table>
			</div>					 
		</div> 
   	</div>   
		
   	<div class="ctcc">
   		<div class="col-xs-12">					
			<div class="col-md-8" style="width: 60%;position: absolute;">
				<table class="table table-bordered">						
					<thead>
						<tr>
							<th colspan="4" style="text-align:center;background-color:#002147;color:#fff;">COST TO COMPANY</th>
						</tr>
					</thead>
				</table>
				<div class="col-md-6" style="width:50%;position: absolute;">
					<table class="table table-bordered">						
					<tbody>
						<?php
						foreach($earning_sal as $r)
        				{
        					if($r->salary_typ==4) 
            				{
						?>
						<tr>
							<td><?php echo $r->salary_code;?></td>	
							<td><?php echo round($r->sal_amt);?></td>		
						</tr>
						<?php
							}
						}
						?>
						<tr>
							<td colspan=""><b>CTC/month</b>	</td>			
							<td colspan=""><b><?php echo $ctc_amt_actual;?></b>	</td>			
						</tr>
																		
					</tbody>
				</table>
				</div>
				<div class="col-md-6" style="margin-left:210px;width:50%;float: right;">
					<table class="table table-bordered">	
					<tbody>
						<?php
						foreach($earning_sal as $r)
        				{
        					if($r->salary_typ==3) 
            				{
						?>
						<tr>
							<td><?php echo $r->salary_name;?></td>	
							<td><?php echo round($r->sal_amt);?></td>		
						</tr>
						<?php
							}
						}
						?>
						<tr>
							<td colspan="2">&nbsp;</td>			
						</tr>
						<tr>
												
							<td colspan="2">&nbsp;</td>					
						</tr>
						<tr>
										
							<td style="border-left:0px solid;"><b>CTC/year</b></td>											
							<td><?php echo $ctc_amt_actual*12;?></td>									
						</tr>
																		
					</tbody>
				</table>
				</div>
				
			</div>
			<div class="col-md-4" style="width: 40%;margin-left: 420px;">
				<table class="table table-bordered">						
					<thead>
						<tr style="text-align:center;background-color:#002147;color:#fff;">						
							<th colspan="3">Header</th>						
						</tr>
					</thead>
					<tbody>
						<tr>							
							<td colspan="2">Total Working Days</td>		
							<td><?php echo $salary[0]->working_days;?></td>								
						</tr>
						<tr>							
							<td colspan="2">Absent Days</td>		
							<td><?php echo $salary[0]->absent_days;?></td>								
						</tr>
						<tr>							
							<td colspan="2">No. Leaves Approved</td>		
							<td><?php echo $salary[0]->total_leave_approved;?></td>								
						</tr>
						<tr>							
							<td colspan="2">No. of Paid Days</td>		
							<td><?php echo $salary[0]->paid_days;?></td>								
						</tr>
						<tr>							
							<td colspan="2">Reimbursement Amount</td>		
							<td><?php echo round(($salary[0]->remburse_amt));?></td>								
						</tr>
						<tr>							
							<td colspan="2"><strong>Net Salary Payable</strong></td>		
							<td><strong><?php echo $salary[0]->amount_paid;?></strong></td>								
						</tr>	
					</tbody>
				</table>
			</div>					 
		</div>
	</div>

	<div class="msg">
		<div class="row" style="padding:10px;">
			<div class="col-xs-12" style="margin-bottom: 10px;">	</div>
			<div class="col-xs-12" style="margin-top:20px;padding:8px;margin-bottom:5px;font-size:12px"><p><span>*</span> Please feel free to contact us at : school accounts office for any query/complaint regarding your salary. Verbal conversation will not be entertained.</p>
				<p style="margin-top:-5px;"><span>*</span> This is system generated slip, signature not required.</p>
			</div>
		</div>
	</div>
</div>

</body>
</html>