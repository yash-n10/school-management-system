<div class="box">
	<div class="box-header">
    
    	<!------CONTROL TABS START------->
		<ul class="nav nav-tabs nav-tabs-left">

			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> 
					<?php echo get_phrase('mail / sms');?>
                    	</a></li>
		</ul>
    	<!------CONTROL TABS END------->
        
	</div>
	<div class="box-content padded">
		<div class="tab-content">
        	<!----EDITING FORM STARTS---->
			<div class="tab-pane box active" id="edit" style="padding: 5px">
                <div class="box-content padded">
					
                  <?php if($this->session->flashdata('msg') != ""):?>
                       <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Success!</strong> <?php echo $this->session->flashdata('msg');?>
                        </div>
                   <?php endif;?>  
                        <form method="post" action="<?php echo base_url();?>admin/sendmailsms" class="form-horizontal validatable">
                            
                                <div class="control-group">
                                    <label class="control-label"><?php echo get_phrase('Type of users *');?></label>
                                    <div class="controls">
                                    
                                    	
                                      <label class="radio">
                                        <input type="radio" name="receivertype" id="receivertype_t" value="1" checked class="cstm-rtype">
                                        Teachers 
                                        </label>
                                        <label class="radio">
                                        <input type="radio" name="receivertype" id="receivertype_s" value="2" disabled="disabled" class="cstm-rtype">
                                        Students 
                                        </label>
                                        <label class="radio">
                                        <input type="radio" name="receivertype" id="receivertype_p" value="3" class="cstm-rtype">
                                        Parents 
                                        </label>
                                        	
                                           
                                       
                                    </div>
                                </div>
                                <div id="cstm-cd">
                                <!--<div class="control-group">
                                    <label class="control-label"><?php echo get_phrase('Class *');?></label>
                                    <div class="controls">
                                    
                                    	<select class="uniform validate[required]" name="employee_department_id">
                                    <option value=""></option> 
                                    
                                    </select>
                                        	
                                           
                                       
                                    </div>
                                </div>-->
                                </div>
                                <div class="control-group">
                                    <label class="control-label"><?php echo get_phrase('Send as *');?></label>
                                    <div class="controls">
                                    
                                    	
                                      <label class="radio">
                                        <input type="radio" name="receivermethod" id="receivertype_s" value="1" checked class="cstm-rmthd">
                                        SMS 
                                        </label>
                                        
                                        <label class="radio">
                                        <input type="radio" name="receivermethod" id="receivertype_m" value="2" class="cstm-rmthd">
                                        EMail 
                                        </label>
                                        	
                                           
                                       
                                    </div>
                                </div>
                                <div id="cstm-cdmt" style="display:none">
                                
                                <div class="control-group">
                                    <label class="control-label"><?php echo get_phrase('Message Title *');?></label>
                                    <div class="controls">
                                    
                                    	<input type="text" class="validate[required]" name="smmsgt" id="smmsgt" placeholder="Message Title"/>
                                        	
                                           
                                       
                                    </div>
                                </div>
                                
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label"><?php echo get_phrase('Message Content *');?></label>
                                    <div class="controls">
                                    
                                    <textarea name="smmsg" class="validate[required]" rows="6" columns="4" placeholder="Message Content"></textarea>
                                        	
                                           
                                       
                                    </div>
                                </div>
                                <div class="control-group">
<div class="controls">
                                 <button type="submit" class="btn btn-blue"><?php echo get_phrase('send sms / mail');?></button>
                                 </div>
                                 </div>
                        </form>
					
                </div>
			</div>
            <!----EDITING FORM ENDS--->
            
		</div>
	</div>
</div>
<script>

$('.cstm-rtype').on('click',function(){
	//alert($(this).val());
	
	var rtype = $(this).val();
	
	if(rtype == 3 || rtype == 2 ){
		
		$.ajax({
						type: 'POST',
						url: '<?php echo base_url(); ?>admin/getClass/',
						success: function(data) {
							//alert(data);
							
							$( "#cstm-cd" ).text('').append(data);
							
						}
			});
	} else {
		
		$( "#cstm-cd" ).text('');
	}
	
});

$('.cstm-rmthd').on('click',function(){
	
	var rmthd = $(this).val();
	//alert(rmthd);
	if(rmthd == 2){
		$("#cstm-cdmt").show();
		//$('#receivertype_s').removeAttr('disabled','');
		
	} else {
		$("#cstm-cdmt").hide();
		//$('#receivertype_s').attr('disabled','disabled');
	}
	
});

</script>