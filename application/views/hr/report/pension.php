<!DOCTYPE html>
<html>
<head>
	<title>Pension</title>
</head>
<body>
<form action="<?php echo base_url();?>hr/report/Pension/pdf" method="POST">
<h3>Select Month</h3><select name="month" id="month" style="width:20% !important;">
    	<option value="4">APRIL</option>
    	<option value="5">MAY</option>
    	<option value="6">JUNE</option>
    	<option value="7">JULY</option>
    	<option value="8">AUGUST</option>
    	<option value="9">SEPTEMBER</option>
    	<option value="10">OCTOBER</option>
    	<option value="11">NOVEMBER</option>
    	<option value="12">DECEMBER</option>
    	<option value="1">JANUARY</option>
    	<option value="2">FEBRUARY</option>
    	<option value="3">MARCH</option>

  </select>
<input type="submit" value="Get report">
</form>
</body>
</html>