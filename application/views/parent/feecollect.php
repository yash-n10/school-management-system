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
#info-std-blk{
	font-size:16px;
}
</style>

<div class="box">
	<div class="box-content padded">
    
    <div class="custom-tam-table-fee">
    	<div class="row-fluid">
        
        	<div id="info-std-blk">
            	<?php extract($stddata); ?>
                	<div class="span3 offset3">
                    	Name :  <?php echo ucfirst($name); ?>
                    </div>
                    <div class="span3">
                    	Roll No :  <?php echo $roll; ?>
                    </div>
           </div>
          </div>
    	</div>
        <div class="row-fluid">
        
        
        		<div class="span12">
                
                
                	<div id="custom-fee-collect-data">
                    	
                        	<div class="row-fluid">
        
        		<div class="span12">
                
                	<?php $i=1; ///print_r($stddata); ?>
                    <?php if(!empty($class_roll_data)) extract($class_roll_data); $ci =& get_instance();  $ci->load->model('fee_model');  ?>
                    <div class="custom-tam-table-fee">
                    <table class="table table-bordered">
                    	<tr>
                        	<th>S.No</th>
                        	<th>Class</th>
                            <th>Category</th>
                        	<th>Particular</th>
                            <th>Amount</th>
                        	<th>Discount</th>
                            <th>Paid Amount</th>
                            <th>Payable Amount</th>
                            <th>Actions</th>
                        </tr>
                        
                        <?php if(!empty($fcollectclassdata)) { foreach($fcollectclassdata as $fcollectclassdata_view){ ?>
                        <tr>
                        
                        <?php
						
							$fc_perid = $fcollectclassdata_view->fee_particular_id;
							
							
							
							$fp_payamount = $ci->fee_model->getSumPaid($fc_perid,$fc_class_id,$fc_roll_id);
							
							if($fp_payamount !=''){
								
								$fppaidamount =$fp_payamount;
							} else {
								$fppaidamount = 0.00;
							}
							
							
						
						
						 $fpamount = $fcollectclassdata_view->fee_particular_amount;
							  $fdisamount = $fcollectclassdata_view->fee_particular_discount;
							  
							  $fpayamount = ($fpamount - $fdisamount ) - ($fppaidamount);
						 ?>
                        	<td><?php echo $i; ?></td>
                        	<td><?php echo $fcollectclassdata_view->cname.' - '.$fcollectclassdata_view->nname  ?></td>
                            <td><?php echo $fcollectclassdata_view->fee_category ?></td>
                            <td><?php echo $fcollectclassdata_view->fee_particular_name ?></td>
                            <td><?php echo $fpamount ?></td>
                            <td><?php echo $fdisamount ?></td>
                            <td><?php echo $fppaidamount?></td>
                            <td><?php echo  number_format($fpayamount,2); ?></td>
                            <td>
                            
                            
                            <button class="btn btn-small btn-info custom-fee-pay-btn" name="paybutton" id="paybutton_<?php echo $i; ?>" value="" data-pay-val-id="<?php echo $i; ?>" <?php  echo "disabled";  ?>>Pay</button>
                         
                            <button class="btn btn-small btn-success custom-fee-pay-his-btn" name="payhisbutton" id="payhisbutton_<?php echo $i; ?>" value="" data-pay-his-id="<?php echo $i; ?>"  <?php  if($fp_payamount == 0) { echo "disabled";} ?>>View Pay History</button>
                           
                            
                             <input type="hidden" name="hid_payamount_<?php echo $i; ?>" id="hid_payamount_<?php echo $i; ?>" value="<?php echo $fpayamount; ?>">
                             <input type="hidden" name="hid_payamount_particular_<?php echo $i; ?>" id="hid_payamount_particular_<?php echo $i; ?>" value="<?php echo $fc_perid; ?>">
                            
                            
                            </td>
                            
                        </tr>
                    	<?php $i++; } } ?>
                        
                        <?php if(!empty($fcollectrolldata)) { foreach($fcollectrolldata as $fcollectrolldata_view){ ?>
                        <tr>
                        
                        
                         <?php 
						 	
							  $fc_perid = $fcollectrolldata_view->fee_particular_id;
							
							
							
								$fp_payamount = $ci->fee_model->getSumPaid($fc_perid,$fc_class_id,$fc_roll_id);
								
								if($fp_payamount !=''){
									
									$fppaidamount =$fp_payamount;
								} else {
									$fppaidamount = 0.00;
								}
							
							
							
						      $fpamount = $fcollectrolldata_view->fee_particular_amount;
							  $fdisamount = $fcollectrolldata_view->fee_particular_discount;
							  
							  $fpayamount = ($fpamount - $fdisamount ) - ($fppaidamount);
						 ?>
                        	<td><?php echo $i; ?></td>
                        	<td><?php echo $fcollectrolldata_view->cname.' - '.$fcollectrolldata_view->nname  ?></td>
                            <td><?php echo $fcollectrolldata_view->fee_category ?></td>
                            <td><?php echo $fcollectrolldata_view->fee_particular_name ?></td>
                             <td><?php echo $fpamount ?></td>
                            <td><?php echo $fdisamount ?></td>
                            <td><?php echo $fppaidamount?></td>
                            <td><?php echo  number_format($fpayamount,2); ?></td>
                            <td>
                            
                            <button class="btn btn-small btn-info custom-fee-pay-btn" name="paybutton" id="paybutton_<?php echo $i; ?>" value="" data-pay-val-id="<?php echo $i; ?>" <?php  echo "disabled"; ?>>Pay</button>
                         
                            <button class="btn btn-small btn-success custom-fee-pay-his-btn" name="payhisbutton" id="payhisbutton_<?php echo $i; ?>" value="" data-pay-his-id="<?php echo $i; ?>"  <?php  if($fp_payamount == 0) { echo "disabled";} ?>>View Pay History</button>
                            
                             <input type="hidden" name="hid_payamount_<?php echo $i; ?>" id="hid_payamount_<?php echo $i; ?>" value="<?php echo $fpayamount; ?>">
                             <input type="hidden" name="hid_payamount_particular_<?php echo $i; ?>" id="hid_payamount_particular_<?php echo $i; ?>" value="<?php echo $fc_perid; ?>">
                            
                            </td>
                        </tr>
                    	<?php $i++; } } ?>
                        
                        
                        <?php if(!empty($fcollectalldata)) { foreach($fcollectalldata as $fcollectalldata_view){ ?>
                        <tr>
                        
                        	 <?php 
							 
							 $fc_perid = $fcollectalldata_view->fee_particular_id;
							
							
							
								$fp_payamount = $ci->fee_model->getSumPaid($fc_perid,$fc_class_id,$fc_roll_id);
								
								if($fp_payamount !=''){
									
									$fppaidamount =$fp_payamount;
								} else {
									$fppaidamount = 0.00;
								}
							
							 
							  $fpamount = $fcollectalldata_view->fee_particular_amount;
							  $fdisamount = $fcollectalldata_view->fee_particular_discount;
							  
							  $fpayamount = ($fpamount - $fdisamount ) - ($fppaidamount);
							 ?>
                        	<td><?php echo $i; ?></td>
                        	<td><?php echo $fcollectalldata_view->cname.' - '.$fcollectalldata_view->cname  ?></td>
                            <td><?php echo $fcollectalldata_view->fee_category ?></td>
                            <td><?php echo $fcollectalldata_view->fee_particular_name ?></td>
                            <td><?php echo $fpamount ?></td>
                            <td><?php echo $fdisamount ?></td>
                            <td><?php echo $fppaidamount?></td>
                            <td><?php echo  number_format($fpayamount,2); ?></td>
                            <td>
                            
                            <button class="btn btn-small btn-info custom-fee-pay-btn" name="paybutton" id="paybutton_<?php echo $i; ?>" value="" data-pay-val-id="<?php echo $i; ?>" <?php  echo "disabled";   ?>>Pay</button>
                         
                            <button class="btn btn-small btn-success custom-fee-pay-his-btn" name="payhisbutton" id="payhisbutton_<?php echo $i; ?>" value="" data-pay-his-id="<?php echo $i; ?>"  <?php  if($fp_payamount == 0) { echo "disabled";} ?>>View Pay History</button>
                            
                             <input type="hidden" name="hid_payamount_<?php echo $i; ?>" id="hid_payamount_<?php echo $i; ?>" value="<?php echo $fpayamount; ?>">
                             <input type="hidden" name="hid_payamount_particular_<?php echo $i; ?>" id="hid_payamount_particular_<?php echo $i; ?>" value="<?php echo $fc_perid; ?>">
                            
                            
                            </td>
                        </tr>
                    	<?php $i++; } } ?>
                        
                         <?php if(!empty($fcollectstandarddata)) { foreach($fcollectstandarddata as $fcollectstandarddata_view){ ?>
                        <tr>
                        
                        	 <?php 
							 
							 	 $fc_perid = $fcollectstandarddata_view->fee_particular_id;
							
							
							
								$fp_payamount = $ci->fee_model->getSumPaid($fc_perid,$fc_class_id,$fc_roll_id);
								
								if($fp_payamount !=''){
									
									$fppaidamount =$fp_payamount;
								} else {
									$fppaidamount = 0.00;
								}
							
							 
							 
							 $fpamount = $fcollectstandarddata_view->fee_particular_amount;
							  $fdisamount = $fcollectstandarddata_view->fee_particular_discount;
							  
							$fpayamount = ($fpamount - $fdisamount ) - ($fppaidamount);
							 ?>
                        	<td><?php echo $i; ?></td>
                        	<td><?php echo $fcollectstandarddata_view->cname.' - '.$fcollectstandarddata_view->nname  ?></td>
                            <td><?php echo $fcollectstandarddata_view->fee_category ?></td>
                            <td><?php echo $fcollectstandarddata_view->fee_particular_name ?></td>
                            <td><?php echo $fpamount ?></td>
                            <td><?php echo $fdisamount ?></td>
                            <td><?php echo $fppaidamount?></td>
                            <td><?php echo  number_format($fpayamount,2); ?></td>
                            <td>
                            
                           <button class="btn btn-small btn-info custom-fee-pay-btn" name="paybutton" id="paybutton_<?php echo $i; ?>" value="" data-pay-val-id="<?php echo $i; ?>" <?php echo "disabled";   ?>>Pay</button>
                         
                            <button class="btn btn-small btn-success custom-fee-pay-his-btn" name="payhisbutton" id="payhisbutton_<?php echo $i; ?>" value="" data-pay-his-id="<?php echo $i; ?>"  <?php  if($fp_payamount == 0) { echo "disabled";} ?>>View Pay History</button>
                            
                            <input type="hidden" name="hid_payamount_<?php echo $i; ?>" id="hid_payamount_<?php echo $i; ?>" value="<?php echo $fpayamount; ?>">
                            <input type="hidden" name="hid_payamount_particular_<?php echo $i; ?>" id="hid_payamount_particular_<?php echo $i; ?>" value="<?php echo $fc_perid; ?>">
                            
                            
                            </td>
                        </tr>
                    	<?php $i++; } } ?>
                    </table>
                    	<input type="hidden" name="hid_payamount_class" id="hid_payamount_class" value="<?php echo $fc_class_id ?>"  />
                        <input type="hidden" name="hid_payamount_roll" id="hid_payamount_roll" value="<?php echo $fc_roll_id ?>"  />
                </div>
                </div>
        
        </div>
                    
                    </div>
                
                </div>
                
        </div>
        
        
        
        
		
	</div>
</div>

<script>





$(document).on('click','.custom-fee-pay-his-btn',function(e){
	
	
	
	var paybtnid = $(this).data('pay-his-id');
	
	var payparticular_val = $('#hid_payamount_particular_'+paybtnid).val();
	
	var pay_class_id = $('#hid_payamount_class').val();
	
	var pay_roll_id = $('#hid_payamount_roll').val();
	
	$('#custom-tam-model-body-pay-his').text('');
	
	
		$.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>parents/fee_pay_history/',
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

