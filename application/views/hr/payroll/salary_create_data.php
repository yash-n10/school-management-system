
<div class="box">
	<div class="box-body">
        <div class="col-lg-12">
            <div class="row">
            	<div class="table-responsive">
					<table class="table table-hover table-bordered display" id="dataa">
						<thead class="thead-dark">
							<tr>
								<th rowspan="2">Sl.No.</th>
								<th rowspan="2">Employee Name</th>
								<th rowspan="2">Employee ID</th>
								<th rowspan="2">Designation</th>
								<th rowspan="2">Paid Days</th>
								<th colspan="<?php echo count($saltype1_count);?>" style="text-align: center;">EARNING</th>
								<th rowspan="2">TOTAL EARNINGS</th>
								<th colspan="<?php echo count($saltype2_count);?>" style="text-align: center;">DEDUCTION</th>
								<th rowspan="2">TOTAL DEDUCTIONS</th>
								<th colspan="<?php echo count($saltype4_count);?>" style="text-align: center;">CTC</th>
								<th rowspan="2">TOTAL CTC</th>
								<th rowspan="2">NET PAY</th>
							</tr>
							<tr>
								<?php 
								foreach($saltype as $r) 
								{
									$type = $r->salary_typ;
							        if($type==1) 
							        {
							    ?>
							        <th><?php echo $r->salary_name;?></th>
							    <?php 
									}
								}
								foreach($saltype as $r) 
								{
									$type = $r->salary_typ;
									if($type==2) 
									{
							    ?>
							        <th> <?php echo  $r->salary_name;?></th>
							    <?php 
									}
								}
								foreach($saltype as $r) 
								{
									$type = $r->salary_typ;
									if($type==3) 
									{
							    ?>
							        <th> <?php echo $r->salary_name;?></th>
							    <?php 
									}
									if($type==4) 
									{
							    ?>
							        <th> <?php echo $r->salary_name;?></th>
							    <?php 
									}
									
								}
								?>
							</tr>
						</thead>
						<tbody>
							<?php 
							$i=1;
							foreach($employee as $emp_val)
							{
								$emp_id = $emp_val->id;

								$salary_group_id = $emp_val->salary_group_id;
								$pd=$this->db->query("SELECT count(*) as count FROM staff_attendance WHERE emp_no=$emp_id AND MONTH(date)=$month AND attendance='P'")->result();
							?>
							<tr>
								<td><?php echo $i;?></td>
								<td><?php echo ucwords($emp_val->name);?></td>
								<td><?php echo $emp_val->employee_code;?></td>
								<td><?php echo $emp_val->designation_desc;?></td>
								<td>
									<?php 
										$attendance = $pd[0]->count;
										echo $tot_day = $attendance+$sunday;
									?>
								</td>

								<?php 
								$am='';
								foreach($saltype as $r) 
								{
							        if($r->salary_typ==1) 
							        {
							    ?>
							        <td>
							        	<?php
							        		$sal_id =  $r->id;
							        		$amt = $this->db->query("SELECT amount FROM salary_entitlement WHERE salary_group_id=$salary_group_id AND salary_id =$sal_id AND status='Y'")->result();
							        		$earning = $amt[0]->amount;							        		
							        		echo $earning_amt = round(($earning/$days)*$tot_day);							        		
							        		$am += $earning_amt;
							        	?>
							        </td>
							    <?php 
									}
								}
								?>

								<td><?php echo $am;?></td>

								<?php 
								$de_am ='';
								foreach($saltype as $r) 
								{
							        if($r->salary_typ==2) 
							        {
							    ?>
							        <td>
							        	<?php
							        		$sal_id =  $r->id;
							        		$amt = $this->db->query("SELECT amount FROM salary_entitlement WHERE salary_group_id=$salary_group_id AND salary_id =$sal_id AND status='Y'")->result();
							        		$deduction = $amt[0]->amount;
							        		echo $deduction_amt = round(($deduction/$days)*$tot_day);
							        		$de_am += $deduction_amt;
							        	?>
							        </td>
							    <?php 
									}
								}
								?>

								<td><?php echo $de_am;?></td>

								<?php 
								$ctc_am='';
								foreach($saltype as $r) 
								{
									$ty = $r->salary_typ;
							        if($ty==3) 
							        {
							    ?>
							        <td>
							        	<?php
							        		$sal_id =  $r->id;
							        		$amt = $this->db->query("SELECT amount FROM salary_entitlement WHERE salary_group_id=$salary_group_id AND salary_id =$sal_id AND status='Y'")->result();
							        		$ctc = $amt[0]->amount;
							        		echo $ctc_amt = round(($ctc/$days)*$tot_day);
							        		$ctc_am += $ctc_amt;
							        	?>
							        </td>
							    <?php 
									}
									if($ty==4) 
							        {
							    ?>
							        <td>
							        	<?php
							        		$sal_id =  $r->id;
							        		$amt = $this->db->query("SELECT amount FROM salary_entitlement WHERE salary_group_id=$salary_group_id AND salary_id =$sal_id AND status='Y'")->result();
							        		$ctc = $amt[0]->amount;
							        		echo $ctc_amt = round(($ctc/$days)*$tot_day);
							        		$ctc_am += $ctc_amt;
							        	?>
							        </td>
							    <?php 
									}
								}
								?>

								<td><?php echo $ctc_am+$am;?></td>
								<td><?php echo $am-$de_am;?></td>
							</tr>
							<?php 
							$i++;
							}
							?>
						</tbody>
					</table>
				</div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function() 
	{
	    $('#dataa').DataTable({
	        dom: 'Bfrtip',
	        buttons: [
	            'excel',
	            {
	                extend: 'pdfHtml5',
	                title: 'Salary Statement',
	                orientation: 'landscape',
	                pageSize: 'A2'
	            }
	        ]
	    } );
	} );
</script>

