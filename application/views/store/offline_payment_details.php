<!DOCTYPE html>
<html>
<head>
	<title>Payment</title>
</head>
<style>
.button {
  background-color: #4CAF50;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  /*cursor: pointer;*/
}
input[type=text] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=submit] {
  width: 100%;
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}
div {
 
}
</style>
<body>
<div class="col-md-12" style=" border-radius: 5px;background-color: #f2f2f2; padding: 20px;">
<h1>Payment</h1>
<a class="button">TOTAL UNPAID AMOUNT <br> <?php echo $amount; ?></a>
<br><br>
<div class="row">
<form method="POST" action="<?php echo base_url();?>/store/Offline_payment/submit">
Enter The amount you want to pay:<br> <input type="number" name="amount" id="amount" value="<?php echo $amount;?>" required >
<br>
Challan No<input type="text" name="challan_no" id="challan_no">
<br>
<input type="hidden" name="student_id" id="student_id" value="<?php echo $student_id;?>">
<br>
<div class="col-md-4">	
<input type="submit" name="Pay">
</div>
</form>
</div>
</div>
<div class="col-md-12" > <h1>Transaction History</h1>
<?php 

$query=$this->db->query("SELECT * FROM store_transaction where student_id='$student_id' and paid_status=1");
$query=$query->result();
?>
<style type="text/css">
  .table {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

.table td, .table th {
  border: 1px solid #ddd;
  padding: 8px;
}

.table tr:nth-child(even){background-color: #f2f2f2;}

.table tr:hover {background-color: #ddd;}

.table th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}

</style>
<table class='table'>
<tr>
<th>Sl.No</th>
<th>Transaction Id</th>
<th>Amount</th>
<th>Download Receipt</th>
</tr>
<?php
$count=0;
foreach ($query as $key) {
  ?>
<tr>

<td><?php echo $count + 1;?></td>
<td><?php echo $key->transaction_id ;?></td>
<td><?php echo $key->total_amount;?></td>
<td><a href="<?php echo base_url();?>store/Payment/payment_receipt/<?php echo $key->id;?>">Click Here</a></td>

</tr>
<?php 
$count++;
}
?>
</table>
</div>
<div class="col-md-12" ><h1>Bill History</h1></div>
<table class='table'>
	<tr>
	<th>Sl no</th>
	<th>Bill No</th>
	<th>Bill Date</th>
	<th>Bill Amount</th>
	<th>Download Bill</th>
	</tr>

<?php 
// print_r($this->session->userdata());die();
$user_name= $this->session->userdata('user_name');
$admission_no=explode('-',$user_name)[1];
// print_r($admission_no);
$query2=$this->db->query("SELECT * FROM store_bill_hdr where admission_no='$admission_no'");
$query2=$query2->result();
$count=0;
foreach ($query2 as $key) {
		?>
<tr>
	<td><?php echo $count + 1;?></td>

	<td><?php echo $key->id;?></td>

	<td><?php echo $key->bill_date;?></td>

	<td><?php echo $key->bill_amt;?></td>

	<td><a href="<?php echo base_url();?>store/Payment/bill/<?php echo $key->id;?>">Click Here</a></td>
</tr>
<?php
$count++; 
}
?>
</table>
<!-- <?php echo $amount; ?> -->
</body>
</html>