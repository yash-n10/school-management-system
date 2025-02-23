<!DOCTYPE html>
<html>
<head>
	<title>Receipt Cancel</title>
</head>
<body>
	<h1>Receipt Cancel Page	</h1>
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
<b>Receipt No</b><input type="text" name="receipt_no" id="receipt_no">
<input type="submit" name="submit" value="submit">
</form>
</body>
</html>