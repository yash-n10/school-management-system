<!DOCTYPE html>
<html>
<head>
	<title>Report</title>
</head>
<body>
<table class="table table-bordered table-striped">
	<tr>
		<th>Sl.no</th>
		<th>Admission No</th>
		<th>Amount</th>
		<th>Payment Date</th>
		<th>Transaction Id</th>
		<th>Payment Method</th>
	</tr>
	<tbody  id="annual_load_td">
	<?php
	$i=1;
	foreach ($query as $key) {
	 ?>
	<tr>
		<th><?php echo $i;?></th>
		<?php 
		$admission_no=$this->db->query("SELECT admission_no FROM student where id='$key->student_id'");
		$admission_no=$admission_no->result();
		$admission_no=$admission_no[0]->admission_no;
		
		?>
		<th><?php print_r($admission_no); ?></th>
		<th><?php echo $key->total_amount;?></th>
		<th><?php echo $key->payment_date;?></th>
		<th><?php echo $key->transaction_id;?></th>
		<th><?php echo $key->payment_method;?></th>
	</tr>
<?php $i++;}?>
</tbody>
</table>
</body>
</html>