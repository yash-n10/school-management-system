
        <?php
           $class_name_results=$this->db->get_where('class', array(
           																 'class_id' => $class_id
        									))->result_array();	
		   $class_name=$class_name_results['0']['name'];
		   
		   $student_name_results=$this->db->get_where('student', array(
           																 'student_id' => $student_id
        									))->result_array();	
		   $student_name=$student_name_results['0']['name'];
		  
		  $class_wise_fee_query="SELECT fee_category,fee_amount from WHERE class=$class_id";
				
						
                        $class_wise_fee_results=$this->db->get_where('class_wise_fees', array(
           																 'class' => $class_id
        									))->result_array();
						
						$fees_category_wise_results=array();
						$specifyamnt=0;
						foreach ($class_wise_fee_results as $class_wise_fee_result) {
							$specifyamnt+=$class_wise_fee_result['fee_amount'];
							$fees_category_wise_results[$class_wise_fee_result['fee_category']]=$class_wise_fee_result['fee_amount'];
						}


						$fees_categorys = $this->db->get('fees_category')->result_array();
						
						
						$fees_category_names=array();
						$feetablenames=array();
						foreach ($fees_categorys as $fees_category) {
							$fees_category_names[$fees_category['fees_category_id']]=$fees_category['fees_category_name'];
							$feetablenames[]=$fees_category['fees_category_name'];
						}
						
						
						$student_wise_pay_results=array();
						foreach ($feetablenames as $feetablename) {
							
							 $feetablenametrim=str_replace(" ", "_", $feetablename);
							 $student_paid_amounts_results=$this->db->get_where($feetablenametrim, array(
           																 'class_id' => $class_id
        									))->result_array();
											
							foreach ($student_paid_amounts_results as $student_paid_amounts_result) {
								
									if(!empty($student_wise_pay_results[$feetablename][$student_paid_amounts_result['student_id']])){
										$student_wise_pay_results[$feetablename][$student_paid_amounts_result['student_id']]=$student_wise_pay_results[$feetablename][$student_paid_amounts_result['student_id']]+$student_paid_amounts_result['amount'];
									}else{
										$student_wise_pay_results[$feetablename][$student_paid_amounts_result['student_id']]=$student_paid_amounts_result['amount'];
									}
									
							}				
						}
						
		  ?>
		 
      
               		
                
         <div class="tab-pane box active" id="edit" style="padding: 5px">
    <div class="box-content">
      
        <?php echo form_open('principal/class_wise_fees/do_update/'.$row['fee_amount_id'] , array('class' => 'form-horizontal validatable','target'=>'_top'));?>
            <div class="padded">
               				<div class="control-group">
                               
	                            <div class="control-group">
	                                <label class="control-label"><?php echo get_phrase('Class:');?></label>
	                                <div class="controls">
	                                    <?php echo $class_name;?>
	                                </div>
	                            </div>
                
                
                			</div>
                			<div class="control-group">
                               
	                            <div class="control-group">
	                                <label class="control-label"><?php echo get_phrase('Student Name:');?></label>
	                                <div class="controls">
	                                    <?php echo $student_name;?>
	                                </div>
	                            </div>
                
                
                			</div>
                			<?php foreach ($fees_category_wise_results as $key=>$fees_category_wise_result) {?>
               			<div class="control-group">
                               
	                                <table>
	                                	<tr>
	                                		<td style="color:black">
	                                			 <?php echo get_phrase($fees_category_names[$key]).": ";?>
	                                		</td>
	                                		<td>
	                                			 <?php echo $fees_category_wise_result;?>
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		
	                                		<td style="color:black">
	                                			 <?php echo get_phrase("Paid: ");?>
	                                		</td>
	                                		<td>
	                                			 <?php 
	                                			 if(!empty($student_wise_pay_results[$fees_category_names[$key]][$student_id])){
	                                			 	echo "&nbsp;&nbsp;".$student_wise_pay_results[$fees_category_names[$key]][$student_id];
	                                			 }else{
	                                			 	echo "&nbsp;&nbsp;"."0";
	                                			 }
	                                			 ?>
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		<td style="color:black">
	                                			 <?php echo get_phrase("Due: ");?>
	                                		</td>
	                                		<td>
	                                			 <?php 
	                                			 if(!empty($student_wise_pay_results[$fees_category_names[$key]][$student_id])){
	                                			 	echo "&nbsp;&nbsp;".($fees_category_wise_result-$student_wise_pay_results[$fees_category_names[$key]][$student_id]);
	                                			 }else{
	                                			 	echo "&nbsp;&nbsp;".$fees_category_wise_result;
	                                			 }
	                                			 ?>
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		
	                                		<td>
	                                			 <input id="feeamnt_<?php echo $key;?>" style="width:70px;" type="text" value="0" />
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		<td>&nbsp;
	                                			
	                                		</td>
	                                		<td style="color:black">
	                                			<a data-toggle="modal" href="#modal-form" onclick="saveFeesModule(
	                                			'<?php echo $fees_category_names[$key];?>',<?php echo $key;?>,<?php echo $class_id;?>,<?php echo $student_id;?>)" class="btn btn-gray btn-small">

                                           Save
                                        </a>
	                                		</td>
	                                	</tr>
	                                </table>
                
                
                			</div>
					<?php } ?>			
            </div>
            <input type="hidden" id="hiddenBaseUrl" value="<?php echo base_url(); ?>principal/save_student_fees" />
        </form>
        
    </div>
</div>

<script>
	function saveFeesModule(feetype,feecatid,class_id,student_id){
		var amount=$("#feeamnt_"+feecatid).val();
			var url=$('#hiddenBaseUrl').val();
    		$.post(url, {feetype:feetype,feecatid:feecatid,class_id:class_id,student_id:student_id,amount:amount},
			function(data){
				window.parent.location = window.parent.location;
				//window.location='<?php echo base_url(); ?>principal/manage_student_fees/'+student_id;
			});
	}
</script>
           
       
       
 