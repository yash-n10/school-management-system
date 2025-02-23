       <div class='table-responsive'>
		<table class='table'>
		  <tr>
            <td><b>Bill No.</b> <input type="text" id="inv_no" name='inv_no' required = "required"></td> 		  
		    <td>
			  <b>Voucher Type</b>
			  <select name='voucher_type' id="voucher_type" onchange="cal_all()">
				<?php
				  foreach($voucher as $data)
				  {
				?>
			    <option value="<?php echo $data->is_igst; ?>"><?php echo $data->voucher_name; ?></option>
				<?php
				  }
				?>
			  </select>
			</td>
			
			
		    <td colspan='10' align='right' onchange="discount()"><b>Discount Setting</b> <input type="radio" name="dic" value="rs" style='cursor:pointer' checked> <i class="fa fa-inr"></i>&nbsp;
		    <input type="radio" name="dic" value="per" style='cursor:pointer'> <i class="fa fa-percent"></i></td>
		  </tr>
		</table>
		<table class="table" id="myTable"><!-- not add extra tr -->
		  <tr>
		    <th>Product</th>
		    <th>Batch</th>
		    <th>Mfg. Date</th>
		    <th>Exp. Date</th>
		    <th>Size</th>
		    <th>Color</th>
		    <th>UQC</th>
		    <th>Order Qty</th>
		    <th>Received Qty</th>
		    <th>Balance Qty</th>
		    <th>Rate</th>
		    <th>GST Rate</th>
		    <th>TAX Type</th>
		    <th style="display:none;">hidden</th>
		    <th>Basic Amount</th>
			<th>Discount</th>
		    <th>GST Amount</th>
		    <th>Final Amount</th>
		    <th></th>
		  </tr>
		  <?php
		    if($ord)
			{
				$i = 1;
				foreach($ord as $data)
				{
		  ?>
		  <tr id='tr_<?php echo $i; ?>'>
		    <input type="hidden" name="upd_id[]" value="<?php echo $data->id; ?>">
		    <input type="hidden" name="hidden_recqty[]" value="<?php echo $data->received_qty; ?>">
		    <input type="hidden" id='hiddenblnqty_<?php echo $i; ?>' value="<?php echo $data->bal_qty; ?>">
		    <td><input type="text" id="pro_<?php echo $i; ?>" value="<?php echo $data->proname; ?>" readonly style="cursor:not-allowed"></td>
			
			<input type="hidden"  name='pro[]' value="<?php echo $data->id; ?>" readonly style="cursor:not-allowed">
			
			<td><input type="text"  name='batch[]' id="batch_<?php echo $i; ?>" style="width:50px;" required="required"></td>
			
			<td><input type="date"  name='mfg_date[]' id="mfg_<?php echo $i; ?>"></td>
			
			<td><input type="date"  name='exp_date[]' id="exp_<?php echo $i; ?>"></td>
			
			<td><input type="text"  name='size[]' id="size_<?php echo $i; ?>" style="width:50px;"></td>
			
			<td><input type="text"  name='color[]' id="color_<?php echo $i; ?>" style="width:50px;"></td>
			
		    <td><input type="text" name='uqc[]' id="uqc_<?php echo $i; ?>" value="<?php echo $data->uqcname; ?>" readonly style="width:100px;"></td>
			
		    <td><input type="text"  name='ordqty[]' id="ordqty_<?php echo $i; ?>" value="<?php echo $data->bal_qty; ?>" readonly style="width:50px;"></td>
			
		    <td><input  type="text"  name='recqty[]' id="recqty_<?php echo $i; ?>" oninput="rec_qty(this)" style="width:50px;"required = "required"></td>
			
		    <td><input type="text"  name='blnqty[]' id="blnqty_<?php echo $i; ?>" value="<?php echo $data->bal_qty; ?>" readonly style="width:50px;"></td>
			
			<td><input type="text"  name='rate[]' id="rate_<?php echo $i; ?>" oninput="basic_amt(this)" style="width:50px;"required = "required"></td>
			
			<td><input  name='gstrate[]' value="<?php echo $data->gstper; ?>" type="text" id="gstrate_<?php echo $i; ?>" readonly style="width:50px;"></td>
			
			<td>
			  <select name='taxtype[]' id='taxtype_<?php echo $i; ?>' onchange="basic_amt(this)">
			    <option value='inclusive' <?php if($data->taxtype == 'inclusive'){ echo "selected"; }?>>Inclusive</option>
			    <option value='exclusive' <?php if($data->taxtype == 'exclusive'){ echo "selected"; }?>>Exclusive</option>
			  </select>
			</td>
			
			<td style="display:none;"><input type="hidden"  id="hiddenbasicamt_<?php echo $i; ?>"></td>
			
			<td><input type="text"  name='basicamt[]' id="basicamt_<?php echo $i; ?>" style="width:50px;"></td>
			
			
			<td style="width:120px;"><div class="input-group"><input type="text" name='discount[]' id="discount_<?php echo $i; ?>" oninput="basic_amt(this)" style="width:50px;"> <span class="input-group-addon">₹</span></div></td>
			
			
			<td><input type="text" name='gstamt[]' id="gstamt_<?php echo $i; ?>" style="width:50px;"></td>
			
			<td><input type="text" name='finalamt[]' id="finalamt_<?php echo $i; ?>" style="width:50px;"></td>
			
			<td><i class="fa fa-window-close" style="color:red; cursor:pointer; font-size:15px;" onclick='closee(<?php echo $i; ?>)'></i></td>
		  </tr>
		  <?php	
		  $i++;
				}
			}
		  ?>
		  
		</table>
	</div>
	
	<div class='row'>
	  <div class='col-sm-12'>
		<div class='col-sm-6'></div>
		<div class='col-sm-6' style='text-align:right'>
		   <label>Basic Total<label>&nbsp;&nbsp;&nbsp; 
		   <input type="text" name='basictotal' id="basictotal">
		</div>
	  </div>
	</div>
	
	<div class='row'>
	  <div class='col-sm-12'>
		<div class='col-sm-6'></div>
		<div class='col-sm-6' style='text-align:right'>
		   <label>Basic CGST<label>&nbsp;&nbsp;&nbsp; 
		   <input type="text" name='gst_c' id="gst_c">
		</div>
	  </div>
	</div>
	
	<div class='row'>
	  <div class='col-sm-12'>
		<div class='col-sm-6'></div>
		<div class='col-sm-6' style='text-align:right'>
		   <label>Basic SGST<label>&nbsp;&nbsp;&nbsp; 
		   <input type="text" name='gst_s' id="gst_s">
		</div>
	  </div>
	</div>
	
	<div class='row'>
	  <div class='col-sm-12'>
		<div class='col-sm-6'></div>
		<div class='col-sm-6' style='text-align:right'>
		   <label>Basic IGST<label>&nbsp;&nbsp;&nbsp; 
		   <input type="text" name='gst_i' id="gst_i">
		</div>
	  </div>
	</div>
	
	<div class='row'>
	  <div class='col-sm-12'>
		<div class='col-sm-6'></div>
		<div class='col-sm-6' style='text-align:right'>
		   <label>NET Total<label>&nbsp;&nbsp;&nbsp; 
		   <input type="text" name='nettotal' id="nettotal">
		</div>
	  </div>
	</div>
	
	<div class='row'>
	  <div class='col-sm-12'>
		<div class='col-sm-2'></div>
		<div class='col-sm-8' style='text-align:center'>
		   <button type="button" onclick='submit3()' class='btn btn-success'>Submit</button>
	
		</div>
		<div class='col-sm-2'></div>
	  </div>
	</div>