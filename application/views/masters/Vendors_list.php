<div class="form-group has-feedback">
  <div class="box box-primary">
    <div class="box-body">
       <div class="col-lg-12" style="text-align:right;">
          <a class="btn btn-add" data-toggle="modal" data-target="#myModal" title="Add Paper Category">
            <i class="fa fa-plus-circle fa-lg"></i>&nbsp;
          </a>

        </div>
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">Add Vendor</h3>
              </div>
              <div class="modal-body">
			   
				  <div class="row">
					<div class="col-sm-6">
					  <label>Vendor Type</label>
					  <select class="form-control" id="vendor_type" onchange="ven_type(this.value)">
					    <option value="">Select</option>
					    <option value="1">Registerd</option>
					    <option value="2">Unregistered</option>
					  </select>
					  <span id="error-vendor_type"></span>
					</div>
					<div class="col-sm-6">
					<label>Vendor Name</label>
					  <input type="text" class="form-control" id="vendor_name">
					  <span id="error-vendor_name"></span>
					</div>
				  </div>
				  
				  <div class="row" style="display:none;" id="view_b2b_type">
					<div class="col-sm-6">
					  <label>B2B Type</label>
					  <select class="form-control" id="b2b_type">
					    <option value="">Select</option>
					    <option value="1">Regular</option>
					    <option value="2">Composite</option>
					  </select>
					</div>
					<div class="col-sm-6">
					  <label>GSTIN</label>
					  <input type="text" class="form-control" id="gstin">
					</div>
				  </div>
				  
				  <div class="row">
					<div class="col-sm-6">
					  <label>Email</label>
					  <input type="email" class="form-control" id="email">
					  <span id="error-email"></span>
					</div>
					<div class="col-sm-6">
					<label>Phone No.</label>
					  <input type="text" class="form-control" id="phone">
					  <span id="error-phone"></span>
					</div>
				  </div>
				  
				  <div class="row">
					<div class="col-sm-6">
					  <label>Address</label>
					  <textarea class="form-control" id="address" rows='1'></textarea>
					  <span id="error-address"></span>
					</div>
					<div class="col-sm-6">
					<label>City</label>
					  <input type="text" class="form-control" id="city">
					  <span id="error-city"></span>
					</div>
				  </div>
				  
				  <div class="row">
					<div class="col-sm-6">
					  <label>State</label>
					  <select class="form-control" id="state">
					    <option value="">Select</option>
						<?php
						  if($state)
						  {
							  foreach($state as $states)
							  {
						?>
						<option value="<?php echo $states->id; ?>"><?php echo $states->state_name; ?></option>
						<?php
								  
							  }
						  }
						?>
					  </select>
					  <span id="error-state"></span>
					</div>
					<div class="col-sm-6">
					<label>ZIP Code</label>
					  <input type="text" class="form-control" id="zip_code">
					  <span id="error-zip_code"></span>
					</div>
				  </div>
				  
				  <div class="row">
					<div class="col-sm-6">
					  <label>Adhaar No</label>
					  <input type="text" class="form-control" id="adhaar_no">
					  <span id="error-adhaar_no"></span>
					</div>
					<div class="col-sm-6">
					<label>PAN No.</label>
					  <input type="text" class="form-control" id="pan_no">
					  <span id="error-pan_no"></span>
					</div>
				  </div>
				  
				  <div class="row">
					<div class="col-sm-6">
					  <label>Bank Name</label>
					  <input type="text" class="form-control" id="bank_name">
					  <span id="error-bank_name"></span>
					</div>
					<div class="col-sm-6">
					<label>Account No.</label>
					  <input type="text" class="form-control" id="acc_no">
					  <span id="error-acc_no"></span>
					</div>
				  </div>
				  
				  <div class="row">
					<div class="col-sm-6">
					  <label>Opening Date</label>
					  <input type="date" class="form-control" id="op_date">
					  <span id="error-op_date"></span>
					</div>
					<div class="col-sm-6">
						<label>Opening Amount</label>
						<div class="row">
							<div class='col-sm-6'>
							  <select class='form-control' id="dr_cr">
								<option value="">Select</option>
								<option value="1">DR</option>
								<option value="2">CR</option>
							  </select>
							  <span id="error-dr_cr"></span>
							</div>
							<div class='col-sm-6'>
							   <input type="text" class="form-control" id="op_amt" placeholder="Rs.">
							   <span id="error-op_amt"></span>
							</div>
						</div>
					</div>
				  </div>
				  
				  
				  <div class="row">
					<div class="col-sm-6">
					  <label>Credit Limit</label>
					  <input type="text" class="form-control" id="credit_limit">
					  <span id="error-credit_limit"></span>
					</div>
					<div class="col-sm-6">
					<label>Credit Days</label>
					  <input type="text" class="form-control" id="credit_days">
					  <span id="error-credit_days"></span>
					</div>
				  </div>
			             
              </div>
              <div class="modal-footer">
                  <a id="butt" class="btn btn-success" onclick="savee()">SAVE</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
      <!--Edit Modal-->
        <div id="EditModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title" id="modal-title">Update Vendor</h3>
              </div>
                <form id="form_edit" class="form-horizontal" method="post" style="width:90%;margin-left:5%;">    
					  <div class="modal-body">
									 
						<div id="datas">
						
					 
						</div>
						
						
					  
					  </div>
					  <div class="modal-footer">
						  <a id="butt_update" class="btn btn-success" onclick="update()">UPDATE</a>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					  </div>
                </form> 
            </div>
          </div>
        </div>
      <!-- End Edit Modal-->
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="period">
                <thead style="background:#99ceff;">
                  <tr>
                      <th style="border-bottom:0px">S.No.</th>
                      <th style="border-bottom:0px">Vendor Name</th>
                      <th style="border-bottom:0px">Address</th>
                      <th style="border-bottom:0px">City</th>
                      <th style="border-bottom:0px">Phone</th>
                      <th style="border-bottom:0px"> Action</th>
                  </tr>
                </thead>
                <thead style="background: #cce6ff">
                  <tr id="searchhead">

                      <th style="border-bottom:2px solid darkcyan;border-top:0px">
                          <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="0"/>
                      </th>
                      <th style="border-bottom:2px solid darkcyan;border-top:0px">
                          <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="1"/>
                      </th>
                      <th style="border-bottom:2px solid darkcyan;border-top:0px">
                          <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="2"/>
                      </th>
					  <th style="border-bottom:2px solid darkcyan;border-top:0px">
                          <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="3"/>
                      </th>
					  <th style="border-bottom:2px solid darkcyan;border-top:0px">
                          <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="4"/>
                      </th>
					  

                      <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                  </tr>
              </thead>
          
          <tbody>
            <?php 
              $i = '1';
              foreach($ledger as $val){
			  if($val->status == 'Y')
			  {
            ?>
              <tr>
                <td><?php echo $i;?></td>
                <td><?php echo $val->ledger_name?></td>
                <td><?php echo $val->address?></td>
                <td><?php echo $val->city?></td>
                <td><?php echo $val->phone?></td>
                <td><span><a class="btn a-edit" title="Edit" onclick="edit(<?php echo $val->id;?>,'<?php echo $val->ledger_name;?>',<?php echo $val->party_type; ?>,<?php echo $val->b2b_type; ?>,'<?php echo $val->opening_date; ?>','<?php echo $val->opening_balance; ?>','<?php echo $val->cr_dr; ?>','<?php echo $val->address; ?>','<?php echo $val->city; ?>','<?php echo $val->zip_code; ?>','<?php echo $val->state; ?>','<?php echo $val->phone; ?>','<?php echo $val->email; ?>','<?php echo $val->bank_name; ?>','<?php echo $val->account_number; ?>','<?php echo $val->gst_no; ?>','<?php echo $val->uid_no; ?>','<?php echo $val->pan_no; ?>',<?php echo $val->credit_limit; ?>,<?php echo $val->credit_days; ?>)"><i class="fa fa-edit"></i> </a></span>
                    <span><a class="btn a-delete" title="Delete" onclick="deletes(<?php echo $val->id; ?>)"><i class="fa fa-trash"></i> </a></span></td>
              </tr>
			  <?php $i++;} }?>
          </tbody>
        </table>
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

function savee()
{
    var vendor_type = $("#vendor_type").val();
    var vendor_name = $("#vendor_name").val();
    var b2b_type = $("#b2b_type").val();
    var gstin = $("#gstin").val();
    var email = $("#email").val();
    var phone = $("#phone").val();
    var address = $("#address").val();
    var city = $("#city").val();
    var state = $("#state").val();
    var zip_code = $("#zip_code").val();
    var adhaar_no = $("#adhaar_no").val();
    var pan_no = $("#pan_no").val();
    var bank_name = $("#bank_name").val();
    var acc_no = $("#acc_no").val();
    var op_date = $("#op_date").val();
    var dr_cr = $("#dr_cr").val();
    var op_amt = $("#op_amt").val();
    var credit_limit = $("#credit_limit").val();
    var credit_days = $("#credit_days").val();
	$.ajax({
		url: "<?php echo base_url('masters/Vendors/save'); ?>",
		type: "post",
		data: {vendor_type:vendor_type,vendor_name:vendor_name,b2b_type:b2b_type,gstin:gstin,email:email,phone:phone,address:address,city:city,state:state,zip_code:zip_code,adhaar_no:adhaar_no,pan_no:pan_no,bank_name:bank_name,acc_no:acc_no,op_date:op_date,dr_cr:dr_cr,op_amt:op_amt,credit_limit:credit_limit,credit_days:credit_days},
		dataType: "json",
		success: function(data)
		{
			if(data.success == 'Y')
			{
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

function deletes(id)
{
  var r = confirm("Are you sure you want to Delete?");
  if (r == true) 
  { 
	  var del_id = id;
	  $.post('<?php echo base_url('masters/Vendors/del'); ?>',{del_id:del_id},function(data){
		  alert('Data Deleted Successfully');
		  location.reload();
	  });
  }
}

function edit(id,ledger_name,party_type,b2b_type,opening_date,opening_balance,cr_dr,address,city,zip_code,state,phone,email,bank_name,account_number,gst_no,uid_no,pan_no,credit_limit,credit_days)
{
  $.ajax({
	  url: "<?php echo base_url('masters/Vendors/edit'); ?>",
	  type: "post",
	  data: {id:id,ledger_name:ledger_name,party_type:party_type,b2b_type:b2b_type,opening_date:opening_date,opening_balance:opening_balance,cr_dr:cr_dr,address:address,city:city,zip_code:zip_code,state:state,phone:phone,email:email,bank_name:bank_name,account_number:account_number,gst_no:gst_no,uid_no:uid_no,pan_no:pan_no,credit_limit:credit_limit,credit_days:credit_days},
	  success: function(data)
	  {
		  $("#datas").html(data);
		  $("#EditModal").modal('show');
	  }
  });
}


function update()
{
	var vendor_type_edt = $("#vendor_type_edt").val();
	var vendor_name_edt = $("#vendor_name_edt").val();
	var b2b_type_edt = $("#b2b_type_edt").val();
	var gstin_edt = $("#gstin_edt").val();
	var email_edt = $("#email_edt").val();
	var phone_edt = $("#phone_edt").val();
	var address_edt = $("#address_edt").val();
	var city_edt = $("#city_edt").val();
	var state_edt = $("#state_edt").val();
	var zip_code_edt = $("#zip_code_edt").val();
	var adhaar_no_edt = $("#adhaar_no_edt").val();
	var pan_no_edt = $("#pan_no_edt").val();
	var bank_name_edt = $("#bank_name_edt").val();
	var acc_no_edt = $("#acc_no_edt").val();
	var op_date_edt = $("#op_date_edt").val();
	var op_amt_edt = $("#op_amt_edt").val();
	var dr_cr_edt = $("#dr_cr_edt").val();
	var credit_limit_edt = $("#credit_limit_edt").val();
	var credit_days_edt = $("#credit_days_edt").val();
	var upd_id = $("#upd_id").val();
	
	
	$.ajax({
		url: "<?php echo base_url('masters/Vendors/update'); ?>",
		type: "post",
		data: {vendor_type_edt:vendor_type_edt,vendor_name_edt:vendor_name_edt,b2b_type_edt:b2b_type_edt,gstin_edt:gstin_edt,email_edt:email_edt,phone_edt:phone_edt,address_edt:address_edt,city_edt:city_edt,state_edt:state_edt,zip_code_edt:zip_code_edt,adhaar_no_edt:adhaar_no_edt,pan_no_edt:pan_no_edt,bank_name_edt:bank_name_edt,acc_no_edt:acc_no_edt,op_date_edt:op_date_edt,op_amt_edt:op_amt_edt,dr_cr_edt:dr_cr_edt,credit_limit_edt:credit_limit_edt,credit_days_edt:credit_days_edt,upd_id:upd_id},
		success: function(data)
		{
			alert('Update Successfully');
		    location.reload();
		}
	});
}

function ven_type(vt)
{
	var vendor_type = vt;
	if(vendor_type == 1)
	{
		$("#view_b2b_type").show(200);
	}
	else
	{
		$("#view_b2b_type").hide(200);
	}
}
</script>