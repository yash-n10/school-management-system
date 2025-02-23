<?php
$email_info = $this->crud_model->get_email_info($current_email_id);
foreach($email_info as $row):
?>

<center>
<div class="box">
	<table class="table table-normal" style="border:0">
            	<tr>
			<td width="150">Subject</td>
			<td><b><?php echo $row['subject'];?></b></td>
		</tr>
		<tr  rowspan="4" >
			<td>Body</td>
			<td><b><?php echo $row['body'];?></b></td>
		</tr>
	
	</table>
</center>

<?php endforeach;?>