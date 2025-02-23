<!DOCTYPE html>
<html>
<head>
	<title>Admncharges</title>
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
		<th>Payable <br>amount of <br>Pay Matrix</th>
		<th>Grade Pay</th>
		<th>Total</th>
		
		<th>7% of PM</th>
	</tr>
	<!-- NEW LOOP -->
	<?php 
	foreach ($query as $key) {
		?>
	<tr>
		<td><?php echo $key->id;?></td>
		<td><?php echo $key->name;?></td>
		<?php
		$designation_id = $key->designation_id;
		$designation= $this->db->query("SELECT * FROM employee_designation where  id ='$designation_id'");
		$designation=$designation->result();
		$designation=$designation[0];
		?>
		<td><?php echo $designation->designation_desc;?></td>
		<?php 
		$emp_id = $key->employee_code;
		$group=$this->db->query("SELECT id from salary_group WHERE salary_group_name='$emp_id'")->result();
		$group=$group[0]->id;
		$pay=$this->db->query("SELECT amount FROM salary_entitlement where salary_group_id ='$group' and salary_id = 1");
		$pay=$pay->result();
		$pay=$pay[0]->amount;
		$pay_7_percent=$pay * 7/100;
		?>
		<td><?php echo $pay;?></td>
		<td>0.00</td>
		<td><?php echo $pay;?></td>
		<td><?php echo $pay_7_percent;?></td>

	</tr>


		<?php
	}
	?>
</table>
</body>
</html>