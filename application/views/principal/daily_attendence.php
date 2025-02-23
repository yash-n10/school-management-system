<div class="box">

	<div class="box-header">

    

    	<!------CONTROL TABS START------->

		<ul class="nav nav-tabs nav-tabs-left">

			<li class="active">

            	<a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> 

					<?php echo get_phrase('manage_daily_attendence');?>

                    	</a></li>

		</ul>

    	<!------CONTROL TABS END------->

        

	</div>

	<div class="box-content padded">

            <!----TABLE LISTING STARTS--->

            <div class="tab-pane  <?php if(!isset($edit_data) && !isset($personal_profile) && !isset($academic_result) )echo 'active';?>" id="list">

				<center>

                <?php $attributes = array('name' => 'daily_attendence_frm'); echo form_open('principal/daily_attendence_view', $attributes);?>

                <table border="0" cellspacing="0" cellpadding="0" class="table table-normal box">

                	<tr>

                        <td><?php echo get_phrase('select_class');?></td>
						<td><?php echo get_phrase('select_date');?></td>
                        <td>&nbsp;</td>

                	</tr>

                	<tr>

                       

                        <td>

                        	<select name="class_id" id="class_id" class=""   style="float:left;">

                                <option value=""><?php echo get_phrase('select_a_class');?></option>

                                <?php 
								$classes = $this->db->get('class')->result_array();

                                foreach($classes as $row):

                                ?>

                                    <option value="<?php echo $row['class_id'];?>"

                                        <?php if($class_id == $row['class_id'])echo 'selected';?>>

                                            <?php echo $row['name'].'-'.$row['name_numeric']; ?></option>

                                <?php

                                endforeach;

                                ?>

                            </select>

                        </td>
                        
                        	
                        
                        <td>
                        	
                            <input type="text" name="daily_attendence_date" id="daily_attendence_date" class="datepicker fill-up" value="<?php if(isset($daily_attendence_date)) { echo date("m/d/Y",strtotime($daily_attendence_date)); } ?>">
                        
                        
                        </td>
                        
                        <td>

                        	<input type="hidden" name="operation" value="selection" />
							
                    		<input type="submit" value="<?php echo get_phrase('manage_attendence');?>" class="btn btn-normal btn-gray" />
							<input type="button" value="<?php echo get_phrase('view_attendence');?>" class="btn btn-blue" onclick="javascript:getAttendenceView();" />
                        </td>
                        
						
                       

                        

                	</tr>

                </table>

                </form>

                </center>

                

                

               
		<?php if(!empty($ad_data)) { ?>
        
        <div id="" class="pull-right">
        
        <a href="javascript:void(0);" class="btn btn-info custom-tam-table-btns" id="custom-tam-ssmsa">Send SMS to Absenties</a>
        	
        
        </div>
        
		
        <table class="table table-normal box" >

                   <tbody>

                        <tr>
                        	
                            <th><?php echo get_phrase('roll no');?></th>
                            <th><?php echo get_phrase('student');?></th>
                        	
                            <th><?php echo get_phrase('PRESENT');?></th>
                            <th><?php echo get_phrase('ABSENT');?></th>
                        </tr>
					
                    
		
		<?php foreach($ad_data as $ad_data_view) {?>
        
        
        		<tr>
                
                	<td><?php echo $ad_data_view->sroll ?></td>
                	<td><?php echo $ad_data_view->sname ?></td>
                    <td><?php //echo $ad_data_view->present_flag ?>
                    
                    	<input type="radio" name="daily_att_val_<?php echo $ad_data_view->daily_attendence_id ?>" id="daily_att_id_p_<?php echo $ad_data_view->daily_attendence_id ?>" value="P" <?php if($ad_data_view->present_flag=='P') echo "checked";  ?> class="da_mod_cls" data-ad-id="<?php echo $ad_data_view->daily_attendence_id ?>" data-ad-type="P" >  </td>
                        
                     <td>   <input type="radio" name="daily_att_val_<?php echo $ad_data_view->daily_attendence_id ?>" id="daily_att_id_a_<?php echo $ad_data_view->daily_attendence_id ?>" value="A" <?php if($ad_data_view->present_flag=='A') echo "checked";  ?> class="da_mod_cls"  data-ad-id="<?php echo $ad_data_view->daily_attendence_id ?>" data-ad-type="A"></td>
                    
                   
                    
                </tr>
        
                

		<?php } ?>
        	</tbody>
            </table>
        
        <?php } ?>
			</div>

            <!----TABLE LISTING ENDS--->

            

		</div>

	</div>

</div>







<script type="text/javascript">

  function show_subjects(class_id)

  {

      for(i=0;i<=100;i++)

      {



          try

          {

              document.getElementById('subject_id_'+i).style.display = 'none' ;

	  		  document.getElementById('subject_id_'+i).setAttribute("name" , "temp");

          }

          catch(err){}

      }

      document.getElementById('subject_id_'+class_id).style.display = 'block' ;

	  document.getElementById('subject_id_'+class_id).setAttribute("name" , "subject_id");

  }

 function getAttendenceView(){
	 var cid = document.getElementById('class_id').value;
	 var dad = document.getElementById('daily_attendence_date').value;
	 if(cid==''){
		 alert('Please select class!');
		 document.getElementById('class_id').focus();
		 return false;
	 }
	 if(dad==''){
		 alert('Please select date!');
		 document.getElementById('daily_attendence_date').focus();
		 return false;
	 }
	 document.daily_attendence_frm.action = "<?php echo base_url() ?>principal/daily_attendence_reason";
	 document.daily_attendence_frm.submit();
 }

$('.da_mod_cls').on('click',function(){
	var adid = $(this).data('ad-id');
	var adtype = $(this).data('ad-type');
	
	
	
	 $.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>principal/daily_attn_update',
							data: { adiid:adid ,adttype:adtype },
							success: function(data) {
								
								if(data == 'true'){
									
									if(adtype=='P'){
										
										alert('Record updated to PRESENT');
										
									} else if(adtype=='A') {
										
										alert('Record updated to ABSENT');
									}
									
									
								} else {
									
									alert('An error occured while change record, please try again !');
								}
								
							}
				  });
	
	
});

$('#custom-tam-ssmsa').on('click',function(e){
	
	var smsclassid = $('#class_id').val();
	var smsdate = $('#daily_attendence_date').val();
	
	$('#custom-tam-model-body').text('');
	
	if(smsclassid == ''){
		$( "#custom-tam-model-body" ).append('<div class="alert"><strong>Pleace select class !</strong></div>');
	}
	if(smsdate ==''){
		$( "#custom-tam-model-body" ).append('<div class="alert"><strong>Please select date !</strong></div>');
	}
	else
	{
		
	
	

	
		$.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>principal/daily_attn_count',
							data: { smscid:smsclassid ,smsdt:smsdate },
							success: function(data) {
								
								if(data=='true'){
									 $( "#custom-tam-model-body" ).append('<div class="alert alert-info"><strong>Are you sure!</strong> Send SMS to absenties for selected class and date. </div><div><button class="btn btn-danger" id="sms-tam-absenties" value="Send SMS">Send</button></div>');
									
								} else if(data=='false') {
									
									 $( "#custom-tam-model-body" ).append('<div class="alert"><strong>No absenties found!</strong> No absenties for selected class and date. </div>');
								}
								
								
								
							}
				  });
	
	
	}
	
				e.preventDefault();
				$('#custom-tam-model').modal('show');

});

$(document).on('click','#sms-tam-absenties',function(){
	
	var smsclassid = $('#class_id').val();
	var smsdate = $('#daily_attendence_date').val();
	
	$( "#custom-tam-model-body" ).text('').append('<img title="<?php echo base_url(); ?>template/images/ajax-loader.gif" src="<?php echo base_url(); ?>template/images/ajax-loader.gif">');
	
	$.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>principal/sendsmsabsenties',
							data: { smscid:smsclassid ,smsdt:smsdate },
							success: function(data) {
								
								if(data!=''){
									
									$( "#custom-tam-model-body" ).text('').append('<div class="alert alert-success"><strong>SMS Send Successfully!</strong></div>');
								}
								
								
								}
				  });
	
});


</script> 