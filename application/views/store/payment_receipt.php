<!DOCTYPE html>
<html>
<head>
	<title>Payment Receipt</title>
</head>
<body>

<h1><?php echo $this->session->userdata('school_name');?></h1>
<h3>Payment Receipt</h3>
<table border="2px">
	<tr>
		<td>Admission No</td>
		<td><?php echo $admission_no;?></td>
	</tr>
	<tr>
		<td>Transacion Id</td>
		<td><?php echo $transaction_id;?></td>
	</tr>

	<tr>
		<td>Payment Date</td>
		<td><?php echo $payment_date;?></td>
	</tr>

	<tr>
		<td>Payment Mode</td>
		<td><?php echo $payment_mode;?></td>
	</tr>
</table>
</body>
</html>