<!DOCTYPE html>
<html>
<head>
	<title>TRANSACTION_UPDATE</title>
</head>
<body>
<form method="POST" action="<?php echo base_url();?>/new/Transaction/updated">

ID	<input type="text" id = "id" value="<?php echo $query2->id;?>">
<br>
STUDENT ID	<input type="text" id = "student_id" value="<?php echo $query2['student_id'];?>">
<br>
REQUEST STATUS	<input type="text" id = "request_id" value="<?php echo $query2['request_id'];?>">
<br>
RESPONSE STATUS	<input type="text" id = "response_status" value="<?php echo $query2['response_status'];?>">
<br>
CHARGEBACK STATUS	<input type="text" id = "chargeback_status" value="<?php echo $query2['chargeback_status'];?>">
<br>
TOTAL AMOUNT	<input type="text" id = "total_amount" value="<?php echo $query2['total_amount'];?>">
<br>
DISCOUNT AMOUNT	<input type="text" id = "discount_amount" value="<?php echo $query2['discount_amount'];?>">
<br>
YEAR	<input type="text" id = "year" value="<?php echo $query2['year'];?>">
<br>
PAYMENT DATE	<input type="text" id = "paymet_date" value="<?php echo $query2['paymet_date'];?>">
<br>
TRANSACTION ID 	<input type="text" id = "transaction_id" value="<?php echo $query2['transaction_id'];?>">
<br>
RESPONSE CODE	<input type="text" id = "response_code" value="<?php echo $query2['response_code'];?>">
<br>
PAYMENT METHOD	<input type="text" id = "payment_method" value="<?php echo $query2['payment_method'];?>">
<br>
RESPONSE MESSAGE	<input type="text" id = "response_message" value="<?php echo $query2['response_message'];?>">
<br>
REMARKS	<input type="text" id = "remarks" value="<?php echo $query2['remarks'];?>">
<br>
STATUS	<input type="text" id = "status" value="<?php echo $query2['status'];?>">
<br>
PAID STATUS	<input type="text" id = "paid_status" value="<?php echo $query2['paid_status'];?>">
<br>
RECEIPT NUMBER	<input type="text" id = "receipt_no" value="<?php echo $query2['receipt_no'];?>">
<br>
MODE	<input type="text" id = "mode" value="<?php echo $query2['mode'];?>">
<br>
CHEQUE NO	<input type="text" id = "cheque_no" value="<?php echo $query2['cheque_no'];?>">
<br>
CHEQUE DATE	<input type="text" id = "cheque_date" value="<?php echo $query2['cheque_date'];?>">
<br>
CHEQUE STATUS	<input type="text" id = "cheque_status" value="<?php echo $query2['cheque_status'];?>">
<br>
POS NO	<input type="text" id = "pos_no" value="<?php echo $query2['pos_no'];?>">
<br>
BANK NAME	<input type="text" id = "bank_name" value="<?php echo $query2['bank_name'];?>">
<br>
COLLETION CENTER	<input type="text" id = "collection_center" value="<?php echo $query2['collection_center'];?>">
<input type="submit" name="update">
</form>
</body>
</html>