<!DOCTYPE html>
<html>
<head>
	<title>Bill</title>
</head>
<body>
	<h1><?php echo $this->session->userdata('school_name');?></h1>

<?php
$store=$this->db->query("SELECT * from store_bill_hdr where id='$id'");
$store=$store->result();
?>
<h1><?php echo $store[0]->store_type;?></h1>
<b>Bill no:</b><?php echo $id;?>
<br>
<b>Date:</b><?php echo $store[0]->bill_date;?>
<br><br>
<table border="2px">
	<tr>
		<td>S.no</td>
		<td>Item Name</td>
		<td>Quantity</td>
		<td>Price</td>
		<td>Discount</td>
		<td>Sell Price</td>
	</tr>
<?php
$bill_details=$this->db->query("SELECT * FROM store_bill_details where bill_id='$id'");
$bill_details=$bill_details->result();
$count=0;
$total=0;
foreach ($bill_details as $key) {
?>
<tr>
	<td><?php echo $count +1;?></td>
<?php 
$itemname=$this->db->query("SELECT item_name FROM store_items where id='$key->item_id' ");
$itemname=$itemname->result();
$itemname=$itemname[0];
?>
	<td><?php echo $itemname->item_name;?></td>
	<td><?php echo $key->item_qty;?></td>
	<td><?php echo $key->reg_price;?></td>
	<td><?php echo $key->disc_amt;?></td>
	<td><?php echo $key->sell_price;?></td>
</tr>
<?php
$count++;
$total=$total+ $key->sell_price;
}
?>
</table>
<h3>Total Amount :<?php echo $total;?></h3>
</body>
</html>