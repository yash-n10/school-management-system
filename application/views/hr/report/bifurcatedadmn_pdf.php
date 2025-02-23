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
		<th>Centre for<br>Acad.<br>Excellence<br>2%</th>
		<th>Financial<br>Mgmt.<br>Services<br>1%</th>
		<th>Estate<br>Mgmt.<br>Services<br>1%</th>
		<th>Retainership &<br>Legal<br>Services<br>1%</th>
		<th>Statutory<br>Mgmt.<br>Services<br>1%</th>
		<th>Org. &<br>Co-ordination<br>Services<br>1%</th>
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
		$pay=$this->db->query("SELECT amount FROM salary_entitlement where salary_group_id ='$group' and salary_id = 1");
		$pay=$pay->result();
		$pay=$pay[0]->amount;
		$da=$pay * 12/100;
		$pay_7_percent=$pay * 7/100;
		$pay_2_percent=$pay * 2/100;
		$pay_1_percent=$pay * 1/100;
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
		<!-- 2% -->
		<td><?php echo $pay_2_percent?></td>
		<!-- 1% -->
		<td><?php echo $pay_1_percent?></td>
		<!-- 1% -->
		<td><?php echo $pay_1_percent?></td>
		<!-- 1% -->
		<td><?php echo $pay_1_percent?></td>
		<!-- 1% -->
		<td><?php echo $pay_1_percent?></td>
		<!-- 1% -->
		<td><?php echo $pay_1_percent?></td>

	</tr>


		<?php
	}
	?>
</table>
</body>
</html>