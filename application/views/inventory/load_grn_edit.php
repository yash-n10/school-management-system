       <form id='formEdit'>
	   <div class='table-responsive'>
		<table class='table'>
		  <tr>
            <td><b>Bill No.</b> <input type="text" id="inv_no" value='<?php echo $inv_no; ?>' name='inv_no'></td> 		  
		    <td>
			  <b>Voucher Type</b>
			  <select name='voucher_type' id="voucher_type" onchange="cal_all()">
				<?php
				  foreach($voucher as $data)
				  {
				?>
			    <option value="<?php echo $data->is_igst; ?>"<?php if($voucher_type == $data->is_igst){echo "selected";}?>><?php echo $data->voucher_name; ?></option>
				<?php
				  }
				?>
			  </select>
			</td>
			
			
		    <td colspan='10' align='right' onchange="discount()"><b>Discount Setting</b> <input type="radio" name="dic" value="rs" style='cursor:pointer' checked <?php if($discount_type == 'rs'){echo "checked";}?>> <i class="fa fa-inr"></i>&nbsp;
		    <input type="radio" name="dic" value="per" style='cursor:pointer' <?php if($discount_type == 'per'){echo "checked";}?>> <i class="fa fa-percent"></i></td>
		  </tr>
		</table>
		<table class="table" id="myTable"><!-- not add extra tr -->
		  <tr>
		    <th>Product</th>
			<th>Batch No.</th>
			<th>Mfg Date</th>
			<th>Expiry Date</th>
			<th>Size</th>
			<th>Colour</th>
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
		  
			$i = 1;
			foreach($grn_fet as $data)
			{
		  ?>
		  <tr id='tr_<?php echo $i; ?>'>
		    <input type="hidden" name="upd_id[]" value="<?php echo $data->id; ?>">
		    <input type="hidden" name="hidden_recqty[]" value="<?php echo $data->recqty; ?>">
		    <input type="hidden" id='hiddenblnqty_<?php echo $i; ?>' value="<?php echo $data->ordqty; ?>">
			
		    <td><input type="text"  id="pro_<?php echo $i; ?>" value="<?php echo $data->prname; ?>" readonly style="cursor:not-allowed"></td>
			
			<input type="hidden"  name='pro[]' value="<?php echo $data->pro; ?>" readonly style="cursor:not-allowed">
			
			<td><input type="text"  name='batch[]' id="batch_<?php echo $i; ?>" value="<?php echo $data->batch; ?>"></td>
			
			<td><input type="text"  name='mfg_date[]' id="pro_<?php echo $i; ?>" value="<?php echo $data->mfg_date; ?>" readonly style="cursor:not-allowed"></td>
			
			<td><input type="text"  name='exp_date[]' id="pro_<?php echo $i; ?>" value="<?php echo $data->exp_date; ?>" readonly style="cursor:not-allowed"></td>
			
			<td><input type="text"  name='size[]' id="pro_<?php echo $i; ?>" value="<?php echo $data->size; ?>"></td>
			
			<td><input type="text"  name='color[]' id="pro_<?php echo $i; ?>" value="<?php echo $data->color; ?>"></td>
			
		    <td><input type="text" name='uqc[]' id="uqc_<?php echo $i; ?>" value="<?php echo $data->uqc; ?>" readonly style="width:100px;"></td>
			
		    <td><input type="text"  name='ordqty[]' id="ordqty_<?php echo $i; ?>" value="<?php echo $data->ordqty; ?>" readonly style="width:50px;"></td>
			
		    <td><input  type="text"  value='<?php echo $data->recqty; ?>' name='recqty[]' id="recqty_<?php echo $i; ?>" oninput="rec_qty(this)" style="width:50px;"></td>
			
		    <td><input type="text"  name='blnqty[]' id="blnqty_<?php echo $i; ?>" value="<?php echo $data->blnqty; ?>" readonly style="width:50px;"></td>
			
			<td><input type="text"  name='rate[]' value='<?php echo $data->rate; ?>' id="rate_<?php echo $i; ?>" oninput="basic_amt(this)" style="width:50px;"></td>
			
			<td><input  name='gstrate[]' value="<?php echo $data->gstrate; ?>" type="text" id="gstrate_<?php echo $i; ?>" readonly style="width:50px;"></td>
			
			<td>
			  <select name='taxtype[]' id='taxtype_<?php echo $i; ?>' onchange="basic_amt(this)">
			    <option value='inclusive' <?php if($data->taxtype == 'inclusive'){ echo "selected"; }?>>Inclusive</option>
			    <option value='exclusive' <?php if($data->taxtype == 'exclusive'){ echo "selected"; }?>>Exclusive</option>
			  </select>
			</td>
			
			<td style="display:none;"><input type="hidden"  id="hiddenbasicamt_<?php echo $i; ?>"></td>
			
			<td><input type="text"  name='basicamt[]' value='<?php echo $data->basicamt; ?>' id="basicamt_<?php echo $i; ?>" style="width:50px;"></td>
			
			
			<td style="width:120px;"><div class="input-group"><input type="text" name='discount[]' value='<?php echo $data->discount; ?>' id="discount_<?php echo $i; ?>" oninput="basic_amt(this)" style="width:50px;"> <span class="input-group-addon">₹</span></div></td>
			
			
			<td><input type="text" name='gstamt[]' value='<?php echo $data->gstamt; ?>' id="gstamt_<?php echo $i; ?>" style="width:50px;"></td>
			
			<td><input type="text" name='finalamt[]' value='<?php echo $data->finalamt; ?>' id="finalamt_<?php echo $i; ?>" style="width:50px;"></td>
			
			<td><i class="fa fa-window-close" style="color:red; cursor:pointer; font-size:15px;" onclick='closee(<?php echo $i; ?>)'></i></td>
		  </tr>
		  <?php	
		  $i++;
				
			}
		  ?>
		  
		</table>
	</div>
	
	<div class='row'>
	  <div class='col-sm-12'>
		<div class='col-sm-6'></div>
		<div class='col-sm-6' style='text-align:right'>
		   <label>Basic Total<label>&nbsp;&nbsp;&nbsp; 
		   <input type="text" value='<?php echo $basictotal; ?>' name='basictotal' id="basictotal">
		</div>
	  </div>
	</div>
	
	<div class='row'>
	  <div class='col-sm-12'>
		<div class='col-sm-6'></div>
		<div class='col-sm-6' style='text-align:right'>
		   <label>Basic CGST<label>&nbsp;&nbsp;&nbsp; 
		   <input type="text" value='<?php echo $gst_c; ?>' name='gst_c' id="gst_c">
		</div>
	  </div>
	</div>
	
	<div class='row'>
	  <div class='col-sm-12'>
		<div class='col-sm-6'></div>
		<div class='col-sm-6' style='text-align:right'>
		   <label>Basic SGST<label>&nbsp;&nbsp;&nbsp; 
		   <input type="text" value='<?php echo $gst_s; ?>' name='gst_s' id="gst_s">
		</div>
	  </div>
	</div>
	
	<div class='row'>
	  <div class='col-sm-12'>
		<div class='col-sm-6'></div>
		<div class='col-sm-6' style='text-align:right'>
		   <label>Basic IGST<label>&nbsp;&nbsp;&nbsp; 
		   <input type="text" value='<?php echo $gst_i; ?>' name='gst_i' id="gst_i">
		</div>
	  </div>
	</div>
	
	<div class='row'>
	  <div class='col-sm-12'>
		<div class='col-sm-6'></div>
		<div class='col-sm-6' style='text-align:right'>
		   <label>NET Total<label>&nbsp;&nbsp;&nbsp; 
		   <input type="text" value='<?php echo $nettotal; ?>' name='nettotal' id="nettotal">
		</div>
	  </div>
	</div>
	
	<div class='row'>
	  <div class='col-sm-12'>
		<div class='col-sm-2'></div>
		<div class='col-sm-8' style='text-align:center'>
		   <a onclick='submit_edit()' class='btn btn-success'>Update</a>
		</div>
		<div class='col-sm-2'></div>
	  </div>
	</div>
    </form>
<script>
  function discount()
  {
	  $("#rs").hide();
	  $("#pr").hide();
	  var dic = $('input[name=dic]:checked').val();
	  if(dic == 'per')
	  { 
		$(".input-group-addon").text('%'); 
	  }
	  else
	  {
		$(".input-group-addon").text('₹');   
	  }
	 cal_all()
  }
  
  function rec_qty(valu)
  {
	
	 var nw = valu.id;
	 var dist = nw.split("_")
	 var finid = dist[1];
	 var ordqty = Number($("#hiddenblnqty_"+finid).val());
	 var recqty = Number($("#recqty_"+finid).val());
	 
	 if(ordqty < recqty)
	 {
		 alert('wrong input');
		 $("#recqty_"+finid).val('');
	 }
	 else
	 {
		var cal = Number(ordqty)-Number(recqty);
	    $("#blnqty_"+finid).val(cal);
	 }
	 basic_amt(valu);
  }
  
  function basic_amt(vall)
  { 
			
	  var nw = vall.id;
	  
	 var dist = nw.split("_");
	 var finid = dist[1];
	 var recqty = Number($("#recqty_"+finid).val());
	 var rate = Number($("#rate_"+finid).val());
	 var cal = Number(recqty * rate);	 
	 $("#hiddenbasicamt_"+finid).val(cal);
	 var hiddenbasicamt = $("#hiddenbasicamt_"+finid).val();
	 var gstrate = $("#gstrate_"+finid).val();
	 var basicamt = $("#basicamt_"+finid).val();	
	 var discount = $("#discount_"+finid).val();
	 var discamt=discount;
	 var disctyp=$('input[name=dic]:checked').val();
	 if(disctyp=='rs')
	 {
		discount=(Number(discount)*100)/Number(hiddenbasicamt);
	 }
	 else
	 {
		discamt=(Number(hiddenbasicamt)*Number(discount))/100;
	 }
	 var taxtype = $('#taxtype_'+finid).find(":selected").val();
	 if(taxtype == 'inclusive')
	 {	
				
		var inital_amount = Number(hiddenbasicamt) - Number(discamt);
		var gst_cal_rate = Number(gstrate);
		var gst_am1 = inital_amount * 100;
		var gst_am2 = gst_cal_rate + 100;
		var net_cal_amount = gst_am1 / gst_am2;
		var gst_amount = inital_amount - net_cal_amount;
		$("#gstamt_"+finid).val(gst_amount.toFixed(2));
		$("#basicamt_"+finid).val(net_cal_amount.toFixed(2));                             
		$("#finalamt_"+finid).val(inital_amount.toFixed(2));
	 }
	 else
	 {
		var recqty = $("#recqty_"+finid).val();
		var rate = $("#rate_"+finid).val();
		var cal = Number(recqty * rate);
		$("#basicamt_"+finid).val(cal.toFixed(2));
		var ba = $("#basicamt_"+finid).val();
		var val1 = hiddenbasicamt-discamt;
		$("#basicamt_"+finid).val(val1.toFixed(2));
		var val2 = $("#gstrate_"+finid).val();
		var val3 = Number(val1 * val2 / 100)
		$("#gstamt_"+finid).val(val3.toFixed(2));
		var gstamt = $("#gstamt_"+finid).val();
		var val4 = Number(val1) + Number(gstamt);
		$("#finalamt_"+finid).val(val4.toFixed(2));
	 }
	  cal_all();
  }
  function cal_all()
  {
	var tigst=0;
	var tbasic=0;
	var tnettotal=0;
	var rowCount = $('#myTable tr').length;
	var i=0;
	for(i=1;i<rowCount;i++)
	 {
	 var rowid="rate_"+i;
	 var nw = rowid;	  
	 var dist = nw.split("_");
	 var finid = dist[1];
	 var recqty = Number($("#recqty_"+finid).val());
	 var rate = Number($("#rate_"+finid).val());
	 var cal = Number(recqty * rate);	 
	 $("#hiddenbasicamt_"+finid).val(cal.toFixed(2));
	 var hiddenbasicamt = $("#hiddenbasicamt_"+finid).val();
	 var gstrate = $("#gstrate_"+finid).val();
	 var basicamt = $("#basicamt_"+finid).val();	
	 var discount = $("#discount_"+finid).val();
	 var discamt=discount;
	 var disctyp=$('input[name=dic]:checked').val();
	 if(disctyp=='rs')
	 {
		discount=(Number(discount)*100)/Number(hiddenbasicamt);
	 }
	 else
	 {
		discamt=(Number(hiddenbasicamt)*Number(discount))/100;
	 }
	 var taxtype = $('#taxtype_'+finid).find(":selected").val();
	 if(taxtype == 'inclusive')
	 {	
				
		var inital_amount = Number(hiddenbasicamt) - Number(discamt);
		var gst_cal_rate = Number(gstrate);
		var gst_am1 = inital_amount * 100;
		var gst_am2 = gst_cal_rate + 100;
		var net_cal_amount = gst_am1 / gst_am2;
		var gst_amount = inital_amount - net_cal_amount;
		$("#gstamt_"+finid).val(gst_amount.toFixed(2));
		$("#basicamt_"+finid).val(net_cal_amount.toFixed(2));                             
		$("#finalamt_"+finid).val(inital_amount.toFixed(2));
		tigst += Number(gst_amount);
		tbasic += Number(net_cal_amount);
		tnettotal += Number(inital_amount.toFixed(2));
	 }
	 else
	 {
		var recqty = $("#recqty_"+finid).val();
		var rate = $("#rate_"+finid).val();
		var cal = Number(recqty * rate);
		$("#basicamt_"+finid).val(cal.toFixed(2));
		var ba = $("#basicamt_"+finid).val();
		var val1 = hiddenbasicamt-discamt;
		$("#basicamt_"+finid).val(val1.toFixed(2));
		var val2 = $("#gstrate_"+finid).val();
		var val3 = Number(val1 * val2 / 100)
		$("#gstamt_"+finid).val(val3.toFixed(2));
		var gstamt = $("#gstamt_"+finid).val();
		var val4 = Number(val1) + Number(gstamt);
		$("#finalamt_"+finid).val(val4.toFixed(2));
		tigst += Number(val3);
		tbasic += Number(val1);
		tnettotal += Number(val4);
								
	 }
	 var gsttype = $('#voucher_type').find(":selected").val();
		 if(gsttype=="YES")
		 {
			 $("#basictotal").val(tbasic.toFixed(2));
			 $("#gst_c").val(0);
			 $("#gst_s").val(0);
			 $("#gst_i").val(tigst.toFixed(2));
			 $("#nettotal").val(tnettotal.toFixed(2));
		 }
		 else
		 {
			 var cgst=Number(tigst.toFixed(2))/2;
			 $("#basictotal").val(tbasic.toFixed(2));
			 $("#gst_c").val(cgst.toFixed(2));
			 $("#gst_s").val(cgst.toFixed(2));
			 $("#gst_i").val(0);
			 $("#nettotal").val(tnettotal.toFixed(2));
		 }
	 }
  }	
function closee(cls_id)
{
  var close_id = cls_id;
  $("#tr_"+close_id).hide();
  $("#pro_"+close_id).attr('disabled',true);
  $("#uqc_"+close_id).attr('disabled',true);
  $("#ordqty_"+close_id).attr('disabled',true);
  $("#recqty_"+close_id).val(0);
  $("#recqty_"+close_id).attr('disabled',true);
  $("#blnqty_"+close_id).attr('disabled',true);
  $("#rate_"+close_id).val(0);
  $("#rate_"+close_id).attr('disabled',true);
  $("#gstrate_"+close_id).attr('disabled',true);
  $("#taxtype_"+close_id).attr('disabled',true);
  $("#basicamt_"+close_id).val(0);
  $("#basicamt_"+close_id).attr('disabled',true);
  $("#discount_"+close_id).attr('disabled',true);
  $("#gstamt_"+close_id).val(0);
  $("#gstamt_"+close_id).attr('disabled',true);
  $("#finalamt_"+close_id).val(0);
  $("#finalamt_"+close_id).attr('disabled',true);
  cal_all();
}

function submit_edit()
{
	$.ajax({
		url: "<?php echo base_url('inventory/Grn/edit_save'); ?>",
		type: "post",
		data: $('#formEdit').serialize(),
		success: function(data)
		{
			alert("Update Successfully");
			location.reload();
		}
	});
}
</script>	
	