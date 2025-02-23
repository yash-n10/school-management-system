<!DOCTYPE html>
<html>
<head>
	<title>Store Report</title>
</head>
<body>
<form action="<?php echo base_url();?>store/Report/get_data" method="post">
	<b>From Date:</b> &nbsp;<input type="date" name="from" id="from">
	<br><br>
	<b>To Date:</b> &nbsp;<input type="date" name="to" id="to">
	<br><br><input type="submit" name="submit" value="Get Report">
</form>
</body>
</html>