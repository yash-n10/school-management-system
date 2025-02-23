<!DOCTYPE html>
<html>
<head>
	<title>Admncharges</title>
</head>
<body>
<form action="<?php echo base_url();?>hr/report/Admncharges/pdf" method="POST">
<h3>Select Month</h3><select name="month" id="month" style="width:20% !important;">
    	<option value="APRIL">APRIL</option>
    	<option value="MAY">MAY</option>
    	<option value="JUNE">JUNE</option>
    	<option value="JULY">JULY</option>
    	<option value="AUGUST">AUGUST</option>
    	<option value="SEPTEMBER">SEPTEMBER</option>
    	<option value="OCTOBER">OCTOBER</option>
    	<option value="NOVEMBER">NOVEMBER</option>
    	<option value="DECEMBER">DECEMBER</option>
    	<option value="JANUARY">JANUARY</option>
    	<option value="FEBRUARY">FEBRUARY</option>
    	<option value="MARCH">MARCH</option>

  </select>
<input type="submit" value="Get report">
</form>
</body>
</html>