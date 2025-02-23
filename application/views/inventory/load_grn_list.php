

<table class="table" id="myTable">
  <tr>
	<th>Sl No.</th>
	<th>Invoice No.</th>
	<th>Product</th>
	<th>UQC</th>
	<th>Order Qty</th>
	<th>Received Qty</th>
	<th>Balance Qty</th>
	<th>Rate</th>
	<th>GST Rate</th>
	<th>TAX Type</th>
	<th>Basic Amount</th>
	<th>Discount</th>
	<th>GST Amount</th>
	<th>Final Amount</th>
  </tr>
  <?php
    if($grn_fet)
	{
		foreach($grn_fet as $data)
		{
  ?>
  <tr>
    <td>1</td>
    <td><?php echo $data->inv_no; ?></td>
    <td><?php echo $data->pro; ?></td>
    <td><?php echo $data->uqc; ?></td>
    <td><?php echo $data->ordqty; ?></td>
    <td><?php echo $data->recqty; ?></td>
    <td><?php echo $data->blnqty; ?></td>
    <td><?php echo $data->rate; ?></td>
    <td><?php echo $data->gstrate; ?></td>
    <td><?php echo $data->taxtype; ?></td>
    <td><?php echo $data->basicamt; ?></td>
    <td><?php echo $data->discount; ?></td>
    <td><?php echo $data->gstamt; ?></td>
    <td><?php echo $data->finalamt; ?></td>
  </tr>
  <?php
		}
	}
  ?>
</table>
</div>