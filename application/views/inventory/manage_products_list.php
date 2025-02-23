<style>
* {box-sizing: border-box}
body {font-family: "Lato", sans-serif;}

/* Style the tab */
.tab {
    float: left;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
    width: 20%;
    height: auto;
}

/* Style the buttons inside the tab */
.tab button {
    display: block;
    background-color: #f3dcdf;
    color: black;
    padding: 10px 16px;
    width: 100%;
    border: none;
    outline: none;
    text-align: left;
    cursor: pointer;
    transition: 0.3s;
    font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
    background-color: #f7f1d7;
}

/* Create an active/current "tab button" class */
.tab button.active {
    background-color: #f7f1d7;
}

/* Style the tab content */
.tabcontent {
    float: left;
    padding: 0px 12px;
    border: 1px solid #ccc;
    width: 80%;
    border-left: none;
    height: auto;
}
</style>

<div class="form-group has-feedback">
  <div class="box box-primary">
    <div class="box-body">
       
        
      
    </div>
    <div class="box-body">
        <div class="tab">
		  <button class="tablinks" onclick="openCity(event, 'London')" id="defaultOpen">ITEM CATEGORY</button>
		  <button class="tablinks" onclick="openCity(event, 'Paris')">ITEM GROUP</button>
		  <button class="tablinks" onclick="openCity(event, 'Tokyo')">ITEM COMPANY</button>
		  <button class="tablinks" onclick="openCity(event, 'product')">PRODUCT</button>
		</div>

		<div id="London" class="tabcontent">
		  <h3>CATEGORY  <a href="<?php echo base_url('inventory/Manage_products/red'); ?>" target="_blank"><i class="fa fa-list" style="cursor:pointer" title="VIWE LIST" onclick="cat_view()"></i></a></h3><hr />
		  <form action="<?php echo base_url('inventory/Manage_products/save')?>" method="post">
		  <table class='table'>
		    <tr>
			  <th>Category</th>
			  <td><input type="text" class="form-control" name="cat"><span style="color:red"><?php echo form_error('cat'); ?><span></td>
		    </tr>
			<tr>
			  <th>GST</th>
			  <td>
			    <select class="form-control" name="gst">
				  <option value="">Select</option>
				  <?php
				    if($gst_rate)
					{
						foreach($gst_rate as $rate)
						{
				  ?>
				  <option value="<?php echo $rate->id; ?>"><?php echo $rate->gstrate_type; ?></option>
				  <?php
				  		
						}
					}
				  ?>
			    </select>
				<span style="color:red"><?php echo form_error('gst'); ?><span>
			  </td>
			  <tr>
			    <td colspan='2' align='center'><input type="submit" name="save" value="submit" class="btn btn-default"></td>
			  </tr>
		    </tr>
		  </table>
		  </form>
		</div>

		<div id="Paris" class="tabcontent">
		  <h3>Group <a href="<?php echo base_url('inventory/Manage_products/group'); ?>" target="_blank"><i class="fa fa-list" style="cursor:pointer" title="VIWE LIST"></i></a></h3>
		   <table class='table'>
		    <tr>
			  <th>Category</th>
			  <td>
			    <select id="cat" class="form-control">
				  <option value="">Select</option>
				  <?php
				    if($cat)
					{
						foreach($cat as $data)
						{
				  ?>
				  <option value="<?php echo $data->id; ?>"><?php echo $data->cat_name; ?></option>
				  <?php
				    		
						}
					}
				  ?>
			    </select>
				<span id="error-cat"></span>
			  </td>
		    </tr>
			<tr>
			  <th>Group Name</th>
			  <td>
			    <input type="text" id="group_name" class="form-control">
				<span id="error-group_name"></span>
			  </td>
			  <tr>
			    <td colspan='2' align='center'><button class='btn btn-default' onclick="save_group()">Submit</button></td>
			  </tr>
		    </tr>
		  </table>
		</div>

		
		
		
		
		
		
		
		
		<div id="Tokyo" class="tabcontent">
		  <h3>Company <a href="<?php echo base_url('inventory/Manage_products/company'); ?>" target="_blank"><i class="fa fa-list" style="cursor:pointer" title="VIWE LIST"></i></a></h3>
		  <table class='table'>
		    <tr>
			  <th>Category</th>
			  <td>
			    <select id="cat_comp" class="form-control">
				  <option value="">Select</option>
				  <?php
				    if($cat)
					{
						foreach($cat as $data)
						{
				  ?>
				  <option value="<?php echo $data->id; ?>"><?php echo $data->cat_name; ?></option>
				  <?php
				    		
						}
					}
				  ?>
			    </select>
			  </td>
		    </tr>
			<tr>
			  <th>Group Name</th>
			  <td>
			    <select id="group_comp" class="form-control">
				  <option value="">Select</option>
				  <?php
				    if($grp)
					{
						foreach($grp as $data)
						{
				  ?>
				  <option value="<?php echo $data->id; ?>"><?php echo $data->group_name; ?></option>
				  <?php
				  		
						}
					}
				  ?>
			    </select>
				<span id="error-group_comp"></span>
			  </td>
			</tr>
			<tr>
			  <th>Company</th>
			  <td><input type="text" name="company" class="form-control" id="company"><span id="error-company"></span></td>
			</tr>
			<tr>
			    <td colspan='2' align='center'><button class='btn btn-default' onclick="save_comp()">Submit</button></td>
			</tr>
		    </tr>
		  </table>
		</div>
		
		
		
		
		
		
		
		
		<div id="product" class="tabcontent">
		  <h3>Product <a href="<?php echo base_url('inventory/Manage_products/product'); ?>" target="_blank"><i class="fa fa-list" style="cursor:pointer" title="VIWE LIST"></i></a></h3>
		  <form id="form">
		  <table class='table'>
		    <tr>
			  <th>Select Category</th>
			  <td>
			   <select class="form-control" name="pro_cat" id="pro_cat">
			     <option value="">Select</option>
			     <?php
				    if($cat)
					{
						foreach($cat as $data)
						{
				  ?>
				  <option value="<?php echo $data->id; ?>"><?php echo $data->cat_name; ?></option>
				  <?php
				    		
						}
					}
				  ?>
			   </select>
			   <span id="error-pro_cat"></span>
			 </td>
			 
			 <th>Purchase UQC</th>
			  <td>
			   <select class="form-control" name="pur_uqc" id="pur_uqc" onchange="pur_uqcc()">
			     <option value="">Select</option>
				 <?php
				   if($uqc)
				   {
					   foreach($uqc as $data)
					   {
				 ?>
			     <option value="<?php echo $data->id; ?>"><?php echo $data->name; ?></option>
				 <?php
				 	   
					   }
				   }
				 ?>
			   </select>
			   <span id="error-pur_uqc"></span>
			 </td>
		    </tr>
			
			<tr>
			  <th>Select Group</th>
			  <td>
			   <select class="form-control" name="pro_grp" id="pro_grp">
			     <option value="">Select</option>
			     <?php
				    if($grp)
					{
						foreach($grp as $data)
						{
				  ?>
				  <option value="<?php echo $data->id; ?>"><?php echo $data->group_name; ?></option>
				  <?php
				  		
						}
					}
				  ?>
			   </select>
			    <span id="error-pro_grp"></span>
			 </td>
			 
			 <th>Use Alternate Sale UQC?</th>
			  <td onclick="radio()">
			  <input type="radio" name="rad" value="Y"> Yes &nbsp;
			  <input type="radio" name="rad" value="N" checked> NO
			 </td>
		    </tr>
			
			<tr>
			  <th>Select Company</th>
			  <td>
			   <select class="form-control" name="pro_comp" id="pro_comp">
			     <option value="">Select</option>
				 <?php
				   if($comp)
				   {
					   foreach($comp as $data)
					   {
				 ?>
			     <option value="<?php echo $data->id; ?>"><?php echo $data->com_name; ?></option>
				 <?php
				 	   
					   }
				   }
				 ?>
			   </select>
			   <span id="error-pro_comp"></span>
			 </td>
			 
			 <th style="display:none;" class="hs">Stock UQC</th>
			  <td style="display:none;" class="hs">
			   <select class="form-control" name="stk_uqc" id="stk_uqc" onchange="st_uqq()">
			     <option value="">Select</option>
				 <?php
				   if($uqc)
				   {
					   foreach($uqc as $data)
					   {
				 ?>
			     <option value="<?php echo $data->id; ?>"><?php echo $data->name; ?></option>
				 <?php
				 	   
					   }
				   }
				 ?>
			   </select>
			   <span id="error-stk_uqc"></span>
			 </td>
		    </tr>
			
			<tr>
			  <th>Product</th>
			  <td><input type="text" name="pro" id="pro" class='form-control'><span id="error-pro"></span></td>
			 
			 <th style="display:none;" class="hs">1 <span id="eq"></span> =</th>
			  <td style="display:none;" class="hs"><input type="text" name="ult_sale" id="ult_sale"> <span id="eua"> &nbsp;&nbsp;&nbsp;&nbsp;</span></td>
		    </tr>
			
			<tr>
			  <th>HSN</th>
			  <td><input type="text" name="hsn" id="hsn" class="form-control"><span id="error-hsn"></span></td>
			 
			 <th>Description</th>
			  <td><input type="text" name="desc" id="desc" class="form-control"><span id="error-desc"></span></td>
		    </tr>
			
			<tr>
			  <th>GST Rate</th>
			  <td>
			    <select class="form-control" name="gst_rate" id="gst_rate">
			     <option value="">Select</option>
				 <?php
				   if($gst_rate)
				   {
					   foreach($gst_rate as $data)
					   {
				 ?>
			     <option value="<?php echo $data->id; ?>"><?php echo $data->gstrate_type; ?></option>
				 <?php
				 	   
					   }
				   }
				 ?>
			   </select>
			   <span id="error-gst_rate"></span>
			  </td>
			 
			 <th>Quantity Limit</th>
			  <td><input type="text" name="qty_limit" id="qty_limit" class='form-control'><span id="error-qty_limit"></span></td>
		    </tr>
			
			<tr>
			  <th>TAX Type</th>
			  <td>
			    <select class='form-control' name="tax_type" id="tax_type">
				  <option value="">Select</option>
				  <option value="exclusive">Exclusive</option>
				  <option value="inclusive">Inclusive</option>
			    </select>
				<span id="error-tax_type"></span>
			  </td>
			</tr>
		  </table>
		  
		  <div class="table-responsive">
		  <table class="table table-responsive">
		    <tr>
			  <th>Batch</th>
			  <th>Mfg. Date</th>
			  <th>Exp. Date</th>
			  <th>Size</th>
			  <th>Color</th>
			  <th>Actual MRP</th>
			  <th>Op. Qty</th>
			  <th>Price</th>
			  <th>Taxable Price</th>
		    </tr>
			
			<tr>
			  <td><input type="text" name="batch" id="batch"></td>
			  <td><input type="date" name="mfg_date" id="mfg_date" ></td>
			  <td><input type="date" name="exp_date" id="exp_date" ></td>
			  <td><input type="text" name="size" id="size" ></td>
			  <td><input type="text" name="color" id="color" ></td>
			  <td><input type="text" name="actual_mrp" id="actual_mrp" ></td>
			  <td><input type="text" name="op_qty" id="op_qty" ></td>
			  <td><input type="text" name="price" id="price" ></td>
			  <td><input type="text" name="tax_price" id="tax_price" ></td>
			</tr>
			<tr>
			  <td colspan='10' align="center"><button type="button" class='btn btn-success' onclick="pro_save()">SUBMIT</button></td>
			</tr>
		  </table>
		  </form>
		</div>
		
		</div>
	</div>   
    </div>
</div>

<script>
    
$(function ()
{
    var table=$('#period').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true
    });
            $('#searchhead th input').on('keyup change', function () {
//            if ( this.search() !== this.value ) {
//                this
//                    .search( this.value )
//                    .draw();
//            }
            var i = $(this).attr('data-column');
            var v = $(this).val();
            table.columns(i).search(v).draw();
        });
		<?php if ($this->session->flashdata('successmsg')) { ?>
            $('#myMsgModal').modal('show');
        <?php }?>
});


$('#class').on('change keyup',function(){
  var value = $(this).val();
  $.ajax({
      url : "<?php echo site_url('academics/homework/Add_homework/GetSection')?>",
      type: "POST",
      data: {id:value},
      success: function(data)
      {         
        $('#section').empty();
        $("#section").append(data);
      },        
  });
});


function openCity(evt, cityName) 
{
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}
document.getElementById("defaultOpen").click();

function save_group()
{
	var cat = $("#cat").val();
	var group_name = $("#group_name").val();
	
	$.ajax({
		url: "<?php echo base_url('inventory/Manage_products/save_grop'); ?>",
		type: "post",
		data: {cat:cat,group_name:group_name},
		dataType: "json",
		success: function(data)
		{
			if(data.success == 'Y')
			{
				alert('Added Successfully');
				$("select#cat").prop('selectedIndex', 0);
				location.reload();
			}
			else
			{
				$.each(data.error, function(key, value){
					if(value)
					{
						$("#error-" +key).html(value);
						$("#error-" +key).css('color','red');
					}
				});
			}
		}
	});
}

function save_comp()
{
	var cat_comp = $("#cat_comp").val();
	var group_comp = $("#group_comp").val();
	var company = $("#company").val();
	
	$.ajax({
		url: "<?php echo base_url('inventory/Manage_products/comp_save'); ?>",
		type: "post",
        data: {cat_comp:cat_comp,group_comp:group_comp,company:company},
		dataType: "json",
		success: function(data)
		{
			if(data.success == 'Y')
			{
				alert("success");
				location.reload();
			}
			else
			{
				$.each(data.error, function(key, value){
					if(value)
					{
						$("#error-" +key).html(value);
						$("#error-" +key).css('color','red');
					}
				});
			}
		}
	});
}

function radio()
{
	var rad = $('input[name=rad]:checked').val();
	if(rad == 'Y')
	{
		$(".hs").show();
	}
	else
	{
		$(".hs").hide();
	}
}

function pur_uqcc()
{
	var uqc = $("#pur_uqc option:selected").text();
	$("#eq").text(uqc);
}

function st_uqq()
{
	var uqc = $("#pur_uqc option:selected").text();
	$("#eua").text(uqc);
}

function pro_save()
{	
	$.ajax({
		url: "<?php echo base_url('inventory/Manage_products/pro_save'); ?>",
		type: "post",
		data: $("#form").serialize(),
		dataType: "json",
		success: function(data)
		{
			if(data.success == 'Y')
			{
				alert('success');
				location.reload();
			}
			else
			{
				$.each(data.error, function(key, value){
					if(value)
					{
						$("#error-" +key).html(value);
						$("#error-" +key).css('color','red');
					}
				});
			}
		}
	});
	
	
}
</script>