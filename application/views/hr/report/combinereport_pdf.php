<!DOCTYPE html>
<html>
<head>
	<title>Bifurcated Admn Charges</title>
</head>
<body>
<h3><?php print_r($name->description);?></h3>
<h4><?php print_r($name->address);?></h4>
ADMINISTRATIVE CHARGES FOR THE MONTH OF :<?php echo $month;?>

<table border='3px'>
	
	<tr>
		<th>Sl.no</th>
		<th>Name of the Employee</th>
		<th>Designation</th>
		<th>Payable <br>amount of <br>Pay Matrix<br>(A)</th>
		<th>Grade Pay(B)</th>
		<th>DA @12% <br>(C)</th>
		<th>Total Amount<br>(A + B + C)</th>
		<th>Admn Charges</th>
		<th>Gratuity</th>
		<th>Leave Encash</th>
		<th>EDLI</th>
		
	</tr>
	<!-- NEW LOOP -->
	<?php 
	foreach ($query as $key) {
		?>
	<tr>
		<!-- ID -->
		<td><?php echo $key->id;?></td>
		<!-- NAME -->
		<td><?php echo $key->name;?></td>
		<?php
		$designation_id = $key->designation_id;
		$designation= $this->db->query("SELECT * FROM employee_designation where  id ='$designation_id'");
		$designation=$designation->result();
		$designation=$designation[0];
		?>
		<!-- DESIGNATION -->
		<td><?php echo $designation->designation_desc;?></td>
		

		<?php 
		$emp_id = $key->employee_code;
		$group=$this->db->query("SELECT id from salary_group WHERE salary_group_name='$emp_id'")->result();
		$group=$group[0]->id;
		//PAY === BASIC
		$pay=$this->db->query("SELECT amount FROM salary_entitlement where salary_group_id ='$group' and salary_id = 1");
		$pay=$pay->result();
		$pay=$pay[0]->amount;
		//PAY 2 === gratuity
		$pay2=$this->db->query("SELECT amount FROM salary_entitlement where salary_group_id ='$group' and salary_id = 9");
		$pay2=$pay2->result();
		$pay2=$pay2[0]->amount;
		$da=$pay * 12/100;
		$pay_7_percent=$pay * 7/100;
		// PAY 3 === LEAVE ENCASH
		$pay3=$this->db->query("SELECT amount FROM salary_entitlement where salary_group_id ='$group' and salary_id = 10");
		$pay3=$pay3->result();
		$pay3=$pay3[0]->amount;
		//PAY 4 === EDLI
		$pay4=$this->db->query("SELECT amount FROM salary_entitlement where salary_group_id ='$group' and salary_id = 11");
		$pay4=$pay4->result();
		$pay4=$pay4[0]->amount;
		?>
		<!-- BASIC -->
		<td><?php echo $pay;?></td>
		<!-- GRADE PAY -->
		<td>0.00</td>
		<!-- GRADE PAY -->
		<td><?php echo $da;?></td>
		<!-- TOTAL AMOUNT -->
		<td><?php echo $pay + $da;?></td>
		
		<!-- ADMN CHARGES -->
		<td><?php echo $pay_7_percent;?></td>
		
		<!-- GRATUITY -->
		<td><?php echo $pay2;?></td>
		<!-- LEAVE ENCASH -->
		<td><?php echo $pay2;?></td>
		<!-- EDLI -->
		<td><?php echo $pay2;?></td>

	</tr>


		<?php
	}
	?>
</table>
</body>
</html>