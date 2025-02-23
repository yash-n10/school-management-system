<!DOCTYPE html>
<html>
<head>
	<title>Transaction_Update</title>
</head>
<body>
<form action="<?php echo base_url();?>/new/Transaction/update" method="POST">
	ENTER SCHOOL ID <input type="number" name="school" id='school'>
	ENTER TRANSACTION ID<input type="number" name="transaction" id='transaction' >
<br>
	<input type="submit" name="submit">
</form>
</body>
</html>