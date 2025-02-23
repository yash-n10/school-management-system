
    
    	<div class="row-fluid">
        
        		<div class="span12">
                
                	<?php $i=1; //print_r($fcollectstandarddata); ?>
                    <?php if(!empty($class_roll_data)) extract($class_roll_data); $ci =& get_instance();  $ci->load->model('fee_model');  ?>
                    <div class="custom-tam-table-fee">
                    <table class="table table-bordered">
                    	<tr>
                        	<th></th>
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
                        	<td><?php echo $fcollectclassdata_view->cname.' - '.$fcollectclassdata_view->nname ?></td>
                            <td><?php echo $fcollectclassdata_view->fee_category ?></td>
                            <td><?php echo $fcollectclassdata_view->fee_particular_name ?></td>
                            <td><?php echo $fpamount ?></td>
                            <td><?php echo $fdisamount ?></td>
                            <td><?php echo $fppaidamount?></td>
                            <td><?php echo  number_format($fpayamount,2); ?></td>
                            <td>
                            
                            
                            <button class="btn btn-small btn-info custom-fee-pay-btn" name="paybutton" id="paybutton_<?php echo $i; ?>" value="" data-pay-val-id="<?php echo $i; ?>" <?php if($fpayamount == 0) { echo "disabled";  } ?>>Pay</button>
                         
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
                            
                            <button class="btn btn-small btn-info custom-fee-pay-btn" name="paybutton" id="paybutton_<?php echo $i; ?>" value="" data-pay-val-id="<?php echo $i; ?>" <?php if($fpayamount == 0) { echo "disabled";  } ?>>Pay</button>
                         
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
                        	<td><?php echo $fcollectalldata_view->cname.' - '.$fcollectalldata_view->nname  ?></td>
                            <td><?php echo $fcollectalldata_view->fee_category ?></td>
                            <td><?php echo $fcollectalldata_view->fee_particular_name ?></td>
                            <td><?php echo $fpamount ?></td>
                            <td><?php echo $fdisamount ?></td>
                            <td><?php echo $fppaidamount?></td>
                            <td><?php echo  number_format($fpayamount,2); ?></td>
                            <td>
                            
                            <button class="btn btn-small btn-info custom-fee-pay-btn" name="paybutton" id="paybutton_<?php echo $i; ?>" value="" data-pay-val-id="<?php echo $i; ?>" <?php if($fpayamount == 0) { echo "disabled";  } ?>>Pay</button>
                         
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
                            
                           <button class="btn btn-small btn-info custom-fee-pay-btn" name="paybutton" id="paybutton_<?php echo $i; ?>" value="" data-pay-val-id="<?php echo $i; ?>" <?php if($fpayamount == 0) { echo "disabled";  } ?>>Pay</button>
                         
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
        
        
        
        
		
	

