<?php if($class_id != ""):?>

<div class="box">

	<div class="box-header">

    

    	<!------CONTROL TABS START------->

		<ul class="nav nav-tabs nav-tabs-left">

			<li class="active">

            	<a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> 

					<?php echo get_phrase('student_list'); ?>

                    	</a></li>

			

		</ul>

    	<!------CONTROL TABS END------->

        

	</div>
<?php
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
						
						
						$classes = $this->db->get('class')->result_array();
						
						
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
?>
	<div class="box-content">

		<div class="tab-content">

            <!----TABLE LISTING STARTS--->

            <div class="tab-pane  active" id="list">

				<center>

                	<br />

                	<select name="class_id" onchange="window.location='<?php echo base_url(); ?>admin/manage_student_fees/'+this.value">

                    	<option value=""><?php echo get_phrase('select_a_class'); ?></option>

						<?php 
						
						
						
						
                        foreach($classes as $row):

                        ?>

                            <option value="<?php echo $row['class_id']; ?>"

                            	<?php
	if ($class_id == $row['class_id'])
		echo 'selected';
?>>

                                	Class <?php echo $row['name']; ?></option>

                        <?php endforeach; ?>

                    </select>

                    <br /><br />

					<?php if($class_id	==	''):?>

                        <div id="ask_class" class="  alert alert-info  " style="width:300px;">

                            <i class="icon-info-sign"></i> Please select a class to manage fees.

                        </div>

                        <script>
							$(document).ready(function() {

								function shake() {

									$("#ask_class").effect("shake");

								}

								setTimeout(shake, 500);

							});

						</script>

                        <br /><br />

                    <?php endif; ?>

                <?php if($class_id	!=	''):?>

                

                    <div class="action-nav-normal">

                        <div class=" action-nav-button" style="width:300px;">

                          <a href="#" title="Users">

                            <img src="<?php echo base_url(); ?>template/images/icons/user.png" />

                            <span>Total <?php echo count($students); ?> students</span>

                          </a>

                        </div>

                    </div>

                </center>

                <div class="box">

      				<div class="box-content">

                		<div id="dataTables">

                        <table cellpadding="0" cellspacing="0" border="0" class="dTable responsive ">

                            <thead>

                                <tr>

                                    <th><div><?php echo get_phrase('roll'); ?></div></th>

                                    <th width="80"><div><?php echo get_phrase('photo'); ?></div></th>

                                    <th><div><?php echo get_phrase('student_name'); ?></div></th>
                                    

                                    <th class="span3"><div><?php echo get_phrase('address'); ?></div></th>

                                    <th><div><?php echo get_phrase('email'); ?></div></th>
                                    
                                     <th><div><?php echo get_phrase('fees_specify'); ?></div></th>
  									<th><div><?php echo get_phrase('paid_amount'); ?></div></th>
  									<th><div><?php echo get_phrase('due_amount'); ?></div></th>
                                    <th><div><?php echo get_phrase('options'); ?></div></th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php $count = 1;foreach($students as $row):?>

                                <tr>

                                    <td class="span1"><?php echo $row['roll']; ?></td>

                                    <td><div class="avatar"><img src="<?php echo $this -> crud_model -> get_image_url('student', $row['student_id']); ?>" class="avatar-medium" /></div></td>

                                    <td><?php echo $row['name']; ?></td>
									
									
                                    <td><?php echo $row['address']; ?></td>

                                    <td><?php echo $row['email']; ?></td>
                                    <td><table>
                                    	
                                 <?php
									foreach ($fees_category_wise_results as $key=>$fees_category_wise_result) {?>
                                    	<tr>
                                    		<td>
                                    			<?php echo get_phrase($fees_category_names[$key]).": ".$fees_category_wise_result;?>
                                    		</td>
                                    	</tr>
                                    	<?php
                                    	
									}?>
									<tr>
                                    		<td>
                                    			 <?php echo "Total fee: ".$specifyamnt."<br/>";?>
                                    		</td>
                                    	</tr>
                                    </table>
									
										
									 </td>
									  <td><table>
                                    	
                                 <?php
                                 $totalpaid=0;
									foreach ($fees_category_wise_results as $key=>$fees_category_wise_result) {?>
                                    	<tr>
                                    		<td>
                                    			<?php
                                    			
                                    			 if(!empty($student_wise_pay_results[$fees_category_names[$key]][$row['student_id']])){
	                                			 	$paidamount=$student_wise_pay_results[$fees_category_names[$key]][$row['student_id']];
	                                			 }else{
	                                			 	$paidamount=0;
	                                			 }
												 $totalpaid+=$paidamount;
                                    			 echo get_phrase($fees_category_names[$key]).": <strong style='color:black'>".$paidamount;?>
                                    		</td>
                                    	</tr>
                                    	<?php
                                    	
									}?>
									<tr>
                                    		<td>
                                    			 <?php echo "Total paid fee: ".$totalpaid."<br/>";?>
                                    		</td>
                                    	</tr>
                                    </table>
									
										
									 </td>
									 <td><table>
                                    	
                                 <?php
                                 $totaldueamount=0;
									foreach ($fees_category_wise_results as $key=>$fees_category_wise_result) {?>
                                    	<tr>
                                    		<td>
                                    			<?php
                                    			
                                    			 if(!empty($student_wise_pay_results[$fees_category_names[$key]][$row['student_id']])){
	                                			 	$dueamount=$fees_category_wise_result-$student_wise_pay_results[$fees_category_names[$key]][$row['student_id']];
	                                			 }else{
	                                			 	$dueamount=$fees_category_wise_result;
	                                			 }
												 $totaldueamount+=$dueamount;
                                    			 echo get_phrase($fees_category_names[$key]).": <strong style='color:black'>".$dueamount."</strong>";?>
                                    		</td>
                                    	</tr>
                                    	<?php
                                    	
									}?>
									<tr>
                                    		<td>
                                    			 <?php echo "Total due fee: ".$totaldueamount."<br/>";?>
                                    		</td>
                                    	</tr>
                                    </table>
									
										
									 </td>
                                    <td align="center">

                                        <a  data-toggle="modal" href="#modal-form" onclick="modal('edit_student_fees',<?php echo $row['student_id']; ?>,<?php echo $class_id; ?>)" class="btn btn-gray btn-small">

                                            <i class="icon-wrench"></i> <?php echo get_phrase('Add Pay'); ?>

                                        </a>

                                       

 
                                    </td>

                                </tr>

                                <?php $count++; endforeach; ?>

                            </tbody>

                        </table>

                		</div>

                    </div>

                </div>

                <?php endif; ?>

			</div>

            <!----TABLE LISTING ENDS--->

            

            

			

			
            
			
            

		</div>

	</div>

</div>

<?php endif; ?>

<?php if($class_id == ""):?>

<center>

<div class="span4" style="float:none !important;">

    <div class="box">

		<div class="box-header">

			<span class="title"> <i class="icon-info-sign"></i> Please select a class to manage fees.</span>
            
		</div>

		<div class="box-content padded tam-custom-border1">

            <br />

            <select name="class_id" onchange="window.location='<?php echo base_url(); ?>admin/manage_student_fees/'+this.value">

                <option value=""><?php echo get_phrase('select_a_class'); ?></option>

                <?php 

                $classes = $this->db->get('class')->result_array();

                foreach($classes as $row):

                ?>

                    <option value="<?php echo $row['class_id']; ?>"

                        <?php
	if ($class_id == $row['class_id'])
		echo 'selected';
?>>

                            Class <?php echo $row['name']; ?></option>

                <?php endforeach; ?>

            </select>

            

            <script>
				$(document).ready(function() {

					function ask() {

						Growl.info({
							title : "Select a class to manage student",
							text : " "
						});

					}

					setTimeout(ask, 500);

				});

            </script>

		</div>

    </div>

</div>

</center>

<?php endif; ?>

<script>
	function readURL(input) {

		if (input.files && input.files[0]) {

			var reader = new FileReader();

			reader.onload = function(e) {

				$('#blah').attr('src', e.target.result);

			}

			reader.readAsDataURL(input.files[0]);

		}

	}


	$("#imgInp").change(function() {

		readURL(this);

	});

</script>