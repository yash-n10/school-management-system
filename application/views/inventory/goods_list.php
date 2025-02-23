<div class="form-group has-feedback">
  <div class="box box-primary">
   <div class="box-body">
     <div class="col-sm-12">
		 <div class="box-body">
		 <form id='fm'>
		    <table class='table'>
			   <tr>
			     <th style="text-align:right">Vendor</th>
			     <td style="width:170px;">
				   <select class='form-control' name='vendor' id='vendor' onchange='vendorr(this.value)' required>
				    <option value=''>Select</option>
					<?php
					  if($vendor)
					  {
						  foreach($vendor as $data)
						  {
					?>
				    <option value='<?php echo $data->id; ?>'><?php echo $data->ledger_name; ?></option>
					<?php	  
						  }
					  }
					?>
				   </select>
				 </td>
			   </tr>
			   
			   <tr>
			     <th style="text-align:right">Order Number</th>
			     <td>
				   <select id="vw_ord" name='vw_ord' class='form-control' required>
				     <option value="">Select</option>
				   </select>
				 </td>
			   </tr>
			   
			   <tr>
			     <td colspan='2' align='right'><button type='button' class='btn btn-warning btn-xs' onclick='view()'>VIEW</button></td>
			   </tr>
		    </table>
			<div id="view_tbl">
					
					
			</div>
			</div>
			</form>
			
			
			
   </div>
  </div>  
</div>
</div>
</div>
 

<script>
  function vendorr(val)
  {
	 var vendor_id = val;
	 $.ajax({
		 url: "<?php echo base_url('inventory/Goods/fet_order'); ?>",
		 type: "post",
		 data: {vendor_id:vendor_id},
		 success: function(data)
		 {
			 $("#vw_ord").html(data);
		 }
	 });
  }
  
  function view()
  { 
    var vendor = $("#vendor").val();
	var ord_no = $("#vw_ord").val();
	if(vendor != '' && ord_no != '')
	{
		$.ajax({
			url: "<?php echo base_url('inventory/Goods/order'); ?>",
			type: "post",
			data: {ord_no:ord_no},
			success: function(data)
			{
				$("#view_tbl").html(data);
			}
		});
	}
	else
	{
		alert('select first');
	}
  }
  
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
  
  function submit3()
  {
	  if(!$('#fm')[0].checkValidity()){
		  $(this).show();
		  $("#fm")[0].reportValidity();
		  return false;
	  }else{
	  $.ajax({
		  url: "<?php echo base_url('inventory/Goods/submit_grn'); ?>",
		  type: "post",
		  data: $('#fm').serialize(),
		  dataType: "json",
		  success: function(data)
		  {
			  if(data.success == 'Y')
			  {
				  alert('Added Successfully');
				  location.reload();
			  }
			  else
			  {
				  $.each(data.error, function(key, value){
					  if(value)
					  {
						  $("#"+key).css('border','1px solid red');
						  var row = $("#myTable tr").length-1;
						  for(var i=1; i<=row; i++)
						  {
							$("#"+key+"_"+i).css('border','1px solid red');  
						  }
					  }
				  });
			  }
		  }
	  });
	  }
  }
  
  function closee(cls_id)
  {
	  var close_id = cls_id;
	  $("#tr_"+close_id).hide();
	  $("#pro_"+close_id).attr('disabled',true);
	  $("#batch_"+close_id).attr('disabled',true);
	  $("#mfg_"+close_id).attr('disabled',true);
	  $("#exp_"+close_id).attr('disabled',true);
	  $("#size_"+close_id).attr('disabled',true);
	  $("#color_"+close_id).attr('disabled',true);
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
	  $("#tr_"+close_id).remove();
	  cal_all();
  }
</script>