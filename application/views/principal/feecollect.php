<style>
#custom-payment-block{
	border:3px solid #cdcdcd;
	padding:10px;
	position:relative;
}
#custom-payment-block h1{
	color:#000;
}
#custom-payment-block #results{
	margin-bottom:15px;
}
#custom-tam-pay-overlay{
	display:none;
	position:absolute;
	background-color:#000;
	top:0;
	bottom:0;
	width:96.5%;
	opacity:0.5;
	text-align:center;
}
#custom-tam-pay-overlay img{
	opacity:1;
	position:relative;
	top:40%;
	
}
.custom-tam-main-select-block,.custom-tam-table-fee{
	padding:5px 20px;
	-webkit-box-shadow: 0px 0px 3px 1px rgba(0,0,0,0.75);
	-moz-box-shadow: 0px 0px 3px 1px rgba(0,0,0,0.75);
	box-shadow: 0px 0px 3px 1px rgba(0,0,0,0.75);
	margin-bottom:20px;
}
.custom-tam-table-fee{
	padding:5px;
}
.custom-tam-main-select-block .form-horizontal{
	padding-top:15px;
}
.custom-tam-main-select-block .form-horizontal .controls{
	margin-left: 0;
}
.custom-tam-main-select-block .form-horizontal .control-label{
	width:auto;
	padding-right:10px;
}

label.error {  
	color: #FB3A3A;
    display: inline-block;
	margin:2px 0;
    padding-left: 5px;
    text-align: left;
	}

</style>

<div class="box">
	<div class="box-content padded">
    
    
    	<div class="custom-tam-main-select-block">
    	<div class="row-fluid form-horizontal">
        
        		<div class="span6">
                		
                       
                        <div class="control-group">
                        <label class="control-label" for="fee_collect_class_id"><?php echo get_phrase('class');?></label>
                        <div class="controls">
                        	<select name="fee_collect_class_id" id="fee_collect_class_id" class="span8 validate[required]" >
                            	<option value="">--- select class ---</option>
                               	
                                <?php if(!empty($class_data)) { foreach($class_data as $class_data_view){ ?>
                              	
                                	<option value="<?php echo $class_data_view->class_id ?>"><?php echo $class_data_view->name.'-'.$class_data_view->name_numeric ?></option>
                                
                                <?php } } ?>
                                
                            </select>
                            <span id="val_fc_class_id"></span>
                        </div>
                        </div>
               </div>
               <div class="span6">
                        
                        <div class="control-group">
                        <label class="control-label" for="fee_collect_roll"><?php echo get_phrase('student');?></label>
                        <div class="controls">
                        	<select name="fee_collect_roll" id="fee_collect_roll" class="span8 validate[required]" >
                            	<option value="">--- select class first---</option>
                            </select>
                            
                        </div>
                        </div>
                        
                       
                        
                
                </div>
                
                
        
        </div>
        </div>
        <div class="row-fluid">
        
        		<div class="span12">
                
                	<div id="custom-fee-collect-data">
                    
                    
                    </div>
                
                </div>
                
        </div>
        
       <!---<div class="row-fluid">
        	
            <div class="span6 offset3">
            
                		<div id="custom-payment-block" style="display:none;">
                        	<div id="custom-tam-pay-overlay">
                            	<img src="<?php echo base_url();?>template/images/ajax-loader-2.gif" alt="" />
                            </div>
                        	<div id="results"></div>
                        	<form id="fee_collect_frm" name="fee_collect_frm" method="post">
                        	<div class="control-group">
                            <label class="control-label" for="fee_collect_roll"><?php echo get_phrase('total_amount');?></label>
                            <div class="controls">
                               
                               <h1>&#8377; <span id="process_payment_amount_text">0</span>/-</h1>
                                
                            </div>
                            </div>
                        
                        	<div class="control-group">
                            <label class="control-label" for="fee_collect_roll"><?php echo get_phrase('amount_to_be_collected');?></label>
                            <div class="controls">
                               
                               <input type="text" class="span12" name="process_payment_amount" id="process_payment_amount" value="" />
                               
                               <input type="hidden" class="span12" name="process_payment_amount_hid" id="process_payment_amount_hid" value="" />
                                
                            </div>
                            </div>
                            
                            <div class="control-group">
                            <label class="control-label" for="process_payment_late_charge"><?php echo get_phrase('late_charges');?></label>
                            <div class="controls">
                               
                               <input type="text" class="span12" id="process_payment_late_charge" name="process_payment_late_charge"  />
                                
                            </div>
                            </div>
                            
                            <div class="control-group">
                            <label class="control-label" for="process_payment_mode"><?php echo get_phrase('payment_mode');?></label>
                            <div class="controls">
                                <select name="process_payment_mode" id="process_payment_mode" class="span12 validate[required]" >
                                    <option value="0">Cash</option>
                                    <option value="1">Cheque</option>
                                </select>
                                
                            </div>
                            </div>
                            
                            <div id="custom-tam-cheque-info" style="display:none;">
                            
                            <div class="control-group">
                            <label class="control-label" for="process_payment_cheque_number"><?php echo get_phrase('cheque_number');?></label>
                            <div class="controls">
                               
                               <input type="text" class="span12" id="process_payment_cheque_number" name="process_payment_cheque_number"  />
                                
                            </div>
                            </div>
                            
                            <div class="control-group">
                            <label class="control-label" for="process_payment_cheque_date"><?php echo get_phrase('cheque_date');?></label>
                            <div class="controls">
                               
                               <input type="text" class="span12" id="process_payment_cheque_date" name="process_payment_cheque_date" class="datepicker fill-up"  />
                                
                            </div>
                            </div>
                            
                            <div class="control-group">
                            <label class="control-label" for="process_payment_bank_name"><?php echo get_phrase('bank_name');?></label>
                            <div class="controls">
                               
                               <input type="text" class="span12" id="process_payment_bank_name" name="process_payment_bank_name"  />
                                
                            </div>
                            </div>
                            
                            </div>
                            
                            <div class="control-group">
                            <label class="control-label" for="process_payment_remarks"><?php echo get_phrase('remarks');?></label>
                            <div class="controls">
                                
                                <textarea class="span12" class="5" name="process_payment_remarks" id="process_payment_remarks" style="resize:none"></textarea>
                                
                            </div>
                            </div>
                            
                            <div class="form-actions">
                                <input type="submit" name="" value="Collect" id="" class="btn btn-success">
                                <input type="hidden" name="process_payment_class_id" id="process_payment_class_id" value="" />
                                <input type="hidden" name="process_payment_roll_id" id="process_payment_roll_id" value="" />
                                <input type="hidden" name="process_payment_particular_id" id="process_payment_particular_id" value="" />
                            </div>
                        	</form>
                       	</div>
                </div>
                
                
            
        </div>
        
        
		
	</div>
</div>-->

<script>

$('#fee_collect_class_id').on('change',function(){
	
	var fcollect_cid = $(this).val();
	
	
	$('#val_fc_class_id').append('<img title="<?php echo base_url(); ?>template/images/loading.gif" src="<?php echo base_url(); ?>template/images/loading.gif">');
	
	
	$.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>principal/fee_collect_get_student/',
							data: { get_fcollect_cid:fcollect_cid },
							success: function(data) {
								//alert(data);
								
								$('#val_fc_class_id').text('');
									
								$('#fee_collect_roll').text('').append(data);
								
							}
				  });
	
});

$('#fee_collect_roll').on('change',function(){
	
	var roll_id = $('#fee_collect_roll').val();
	
	if(roll_id ==''){
		alert('please select student');
		return false;
	}
	
	call_data_load();
	$('#results').text('');
	
});

$(document).on('click','.custom-fee-pay-btn',function(e){
	
	$('#results').text('');
	
	var paybtnid = $(this).data('pay-val-id');
	
	var payamount_val = $('#hid_payamount_'+paybtnid).val();
	
	var payparticular_val = $('#hid_payamount_particular_'+paybtnid).val();
	
	var pay_class_id = $('#hid_payamount_class').val();
	
	var pay_roll_id = $('#hid_payamount_roll').val();
	
	
	$('#process_payment_amount_text').text(payamount_val);
	
	$('#process_payment_amount').val(payamount_val);
	
	$('#process_payment_amount_hid').val(payamount_val);
	
	$('#process_payment_class_id').val(pay_class_id);
	
	$('#process_payment_roll_id').val(pay_roll_id);
	
	$('#process_payment_particular_id').val(payparticular_val);
	
	
	
	 e.preventDefault();

        $("body, html").animate({ 
            scrollTop: $( $('#custom-payment-block') ).offset().top 
        }, 600);
	
});

$(document).on('change','#process_payment_mode',function(){
	
	var mode_val = $(this).val();
	
	if(mode_val == 1){
		
		$('#custom-tam-cheque-info').show(1000);
		
	} else {
		
		$('#custom-tam-cheque-info').hide(1000);
	}
	
});

function call_data_load(){
	
	
	
	$('#custom-tam-overlay').show();
	
	
	var class_id = $('#fee_collect_class_id').val();
	
	var roll_id = $('#fee_collect_roll').val(); 
	
	
	$.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>principal/fee_collect_get_data/',
							data: { get_fcollect_cid:class_id,get_fcollect_rollid:roll_id },
							success: function(data) {
								
								
								//alert(data);
								
								$('#custom-fee-collect-data').text('').append(data);
								
								$('#custom-payment-block').show();
								
								$('#custom-tam-overlay').hide();
								
								
							}
				  });
	
	$('#fee_collect_frm')[0].reset();
	$('#process_payment_amount_text').text('0');
	
	$('#custom-tam-cheque-info').hide();
	
	
	

	
}

$(document).on('click','#custom-tam-greceipt',function (event) {
    event.preventDefault();
    window.open($(this).attr("href"), "popupWindow", "width=1024,height=600,scrollbars=yes");
});




$(document).on('click','.custom-fee-pay-his-btn',function(e){
	
	
	
	var paybtnid = $(this).data('pay-his-id');
	
	var payparticular_val = $('#hid_payamount_particular_'+paybtnid).val();
	
	var pay_class_id = $('#hid_payamount_class').val();
	
	var pay_roll_id = $('#hid_payamount_roll').val();
	
	$('#custom-tam-model-body-pay-his').text('');
	
	
		$.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>principal/fee_pay_history/',
							data: { sid:pay_roll_id , pid:payparticular_val },
							success: function(data) {
								//alert(data);
								
								
									
								$('#custom-tam-model-body-pay-his').text('').append(data);
								
							}
				  });
	
	
	
	
	 e.preventDefault();
	 
	 $('#custom-tam-model-pay-his').modal('show');

	
});

</script>

<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		
		$.validator.addMethod('lessThanEqual', function(value, element, param) {
			return this.optional(element) || parseFloat(value) <= parseFloat($(param).val());
		}, "The value must be less than or equal to total amount");
		$("#fee_collect_frm").validate({
			debug: false,
			rules: {
				process_payment_amount: { 
				required:true,
				number: true,
				lessThanEqual:'#process_payment_amount_hid'
			   }
			},
			
			messages: {
				process_payment_amount: {
					required:'Please enter amount to be collected',
					number:'Please enter valid amount only (numbers)'
				}
			},
			
			submitHandler: function(form) {
				// do other stuff for a valid form
				$('#custom-tam-pay-overlay').show();
				
				$.post('<?php echo base_url(); ?>principal/fee_collect_process_data/', $("#fee_collect_frm").serialize(), function(data) {
					
					var bln = data.split('#')[0];
					
					if(bln =='true'){
						
						receipt_id = data.split('#')[2];
						
					$('#results').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Payment done successfully!</strong></div>');
					$('#fee_collect_frm')[0].reset();
					$('#process_payment_amount_text').text('0');
					call_data_load();
					call_open_receipt(receipt_id);
					} else if(bln =='false') {
						
						$('#results').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Payment not processed!</strong></div>');
						
					}
					
					$('#process_payment_amount').val('');
	
					$('#process_payment_amount_hid').val('');
					
					$('#process_payment_class_id').val('');
					
					$('#process_payment_roll_id').val('');
					
					$('#process_payment_particular_id').val('');
					$('#custom-tam-pay-overlay').hide();
					
				});
				
			}
		});
	});
	
	function call_open_receipt(receipt_id){
		
		var url = '<?php echo base_url(); ?>principal/generatereceipt/'+receipt_id;
		
		window.open( url , "popupWindow", "width=1024,height=600,scrollbars=yes");
	}
	</script>
