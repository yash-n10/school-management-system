<div class="box">
	<div class="box-header">
    
    	<!------CONTROL TABS START------->
		<ul class="nav nav-tabs nav-tabs-left">

			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="icon-tasks"></i> 
					<?php echo get_phrase('thing_add');?>
                    	</a></li>
		</ul>
    	<!------CONTROL TABS END------->
        
	</div>
	
</div>


<!--password-->
<div class="box">
	
	<div class="box-content padded">
		<div class="tab-content">
        <div class="pull-right custom-tam-table-btns">
                	
                    	<a href="<?php echo base_url() ?>principal/tasks" class="btn btn-small btn-lightblue"><?php echo get_phrase('view_things');?></a>
                
                </div>
        	<!----EDITING FORM STARTS---->
			<div class="tab-pane box active" id="list" style="padding: 5px">
                <div class="box-content padded">
					
                        
                        <?php echo form_open('principal/taskinsert' , array('class' => 'form-horizontal validatable'));?>
                                <div class="control-group">
                                    <label class="control-label"><?php echo get_phrase('title');?></label>
                                    <div class="controls">
                                        <input type="text" class="validate[required]" name="task_title" id="task_title" value="" placeholder="Please enter task title"/>
                                    </div>
                                </div>
                                  <div class="control-group">
                                    <label class="control-label"><?php echo get_phrase('description');?></label>
                                    <div class="controls">
                                        <textarea cols="5" style="resize:none;" name="task_description" id="task_description" placeholder="Please enter task description"></textarea>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label"><?php echo get_phrase('start date');?></label>
                                    <div class="controls">
                                        <input type="text" class="datepicker fill-up validate[required]" name="task_start_date" id="task_start_date" value="" placeholder="Please enter task start date"/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label"><?php echo get_phrase('end date');?></label>
                                    <div class="controls">
                                        <input type="text" class="datepicker fill-up validate[required]" name="task_end_date" id="task_end_date" value="" placeholder="Please enter task end date"/>
                                        
                                        <p id="dateError"></p>
                                        
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label"><?php echo get_phrase('status');?></label>
                                    <div class="controls">
                                       <select name="task_status" id="task_status">
                                       		<option value="upcoming">Upcoming</option>
                                            <option value="ongoing">Ongoing</option>
                                            <option value="completed">Completed</option>
                                       </select>
                                    </div>
                                </div>
                                <div class="form-actions">
                            		<button type="submit" class="btn btn-lightblue"><?php echo get_phrase('add thing');?></button>
                        		</div>
                        </form>
					
                </div>
			</div>
            <!----EDITING FORM ENDS--->
            
		</div>
	</div>
</div>
<script>

$( "#task_start_date,#task_end_date" ).change(function() {
		var srtDt=$('#task_start_date').val();
		var enDt=$('#task_end_date').val();
		if(srtDt!='' && enDt!=''){
		 $.ajax({
							type: 'POST',
							url: '<?php echo base_url() ?>principal/datecompare/',
							data: { startDate:srtDt ,endDate:enDt },
							success: function(data) {
								//alert(data);
								if(data=='false'){
									$('#dateError').text('Please select end date must be later than start date');
									$('#dateError').css('color','#CC0000');
									$('#dateError').css('padding','5px 0');
									$('#task_end_date').val('');
								} 
							}
				  });
		}
});
$( "#task_start_date,#task_end_date" ).focus(function() {
		$('#dateError').text('');
});

</script>