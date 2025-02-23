<form id="form_id">
<table class='table'>
  <tr>
    <th>Product</th>
    <th>Batch</th>
    <th>Order Qty</th>
    <th>Qty</th>
    <th>RestQty</th>
    <th>UQC</th>
    <th>Amount</th>
    <th>Total Amount</th>
  </tr>
  <?php
    if($product)
	{
		$i = 1;
		foreach($product as $data)
		{
  ?>
  <tr id="tr_<?php echo $i; ?>">
    <input type='hidden' value="<?php echo $data->id; ?>" name='upd_id[]'>
    <td><input type="text" id="pro_<?php echo $i; ?>" value="<?php echo $data->proname; ?>" readonly></td>
	<input type="hidden" name="pro[]" id="proid_<?php echo $i; ?>" value="<?php echo $data->pro_id; ?>" readonly>
    <td><input type="text" name="batch[]" id="batch_<?php echo $i; ?>" onclick="btch(this)" autocomplete="off" required></td>
    <td><input type="text" name="ordqty[]" id="ordqty_<?php echo $i; ?>" value="<?php echo $data->balqty; ?>" readonly style="width:50px;"></td>
    <td><input type="text" name="qty[]" id="qty_<?php echo $i; ?>" oninput="qty(this)" required style="width:50px;"></td>
    <td><input type="text" name="restqty[]" id="restqty_<?php echo $i; ?>" style="width:50px;"></td>
    <td><input type="text" name="quc[]" id="uqc_<?php echo $i; ?>" value="<?php echo $data->uqcname; ?>" readonly></td>
    <td><input type="text" name="price[]" id="price_<?php echo $i; ?>" style="width:150px;"></td>
    <td><input type="text" name="total_price[]" id="totprice_<?php echo $i; ?>" style="width:150px;"></td>
	<td><i class="fa fa-window-close" style="color:red; cursor:pointer; font-size:15px;" onclick="closee(<?php echo $i; ?>)"></i></td>
  </tr>
  <?php
        $i++;  
		}
	}
  ?>
   <tr>
    <td colspan='9' align="center"><button type='button' class='btn btn-success' onclick='product_issue()'>Issue</button></td>
   </tr>
</table>
</form>