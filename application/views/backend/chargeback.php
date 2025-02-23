<!DOCTYPE html>
<html>
<head>
	<title>Receipt Cancel</title>
</head>
<body>
	<h1>Chargeback Page	</h1>
<form action="receipt_cancel" method="POST">
<b>School Id:</b><select name='school_id' id="school_id">
	<?php
	foreach ($school_list as $key) {
		?>
		<option value="<?php echo $key->id;?>"><?php echo $key->description;?></option>
	<?php

}
	?>
</select>
<br><br>
<b>Transaction Id</b><input type="text" name="transaction_id" id="transaction_id">
<b>Remarks</b><input type="text" name="remarks" id="remarks">
<input type="submit" name="submit" value="submit">
</form>
</body>
</html>