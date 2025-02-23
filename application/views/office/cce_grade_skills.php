<div class="box">
	<div class="box">
		<div class="row-fluid">	
			<div class="alert alert-danger" id="validate_date2" style="display:none;" > 
								<button class="close" data-dismiss="alert">&times;</button>
								<span>Grade Skill Name Already Existed</span>
			</div> 
		</div>
	</div>
			
	<div class="row-fluid" id="success_updates" >	
                        <div class="control-group">
							<?php if($this->session->flashdata('msg')=="succesfully created indicator" || $this->session->flashdata('msg')=="succesfully updated indicator") {?>
							<div class="alert alert-success">  
												<button class="close" data-dismiss="alert">&times;</button>
												<?php echo $this->session->flashdata('msg'); ?>
											 </div> 							
							<?php } ?>
							<?php if($this->session->flashdata('msg')=="succesfully deleted indicator") {?>
							<div class="alert alert-danger"> 
												<button class="close" data-dismiss="alert">&times;</button>
												<?php echo $this->session->flashdata('msg'); ?>
											 </div> 							
							<?php } ?>
							<?php if($this->session->flashdata('msg')=="indicator already existed") {?>
							<div class="alert alert-warning">  
												<button class="close" data-dismiss="alert">&times;</button>
												<?php echo $this->session->flashdata('msg'); ?>
											 </div> 							
							<?php } ?>
                        </div>                        
	</div>
	<div class="row-fluid">
        
        		<div class="span12">
                		<div class="custom-tam-hr-frm">
                	    <form class="form-horizontal validatable" method="post" action="<?php echo base_url(); ?>admin/grade_skills_mapping/create/">
						
						<div class="row-fluid">
                        <div class="span5">
							<div class="control-group">
								<label class="control-label" for="fee_category"><?php echo get_phrase('select_grade_set');?></label>
								<div class="controls">									
									<select name="grade_set_name" id="grade_set_name" class="validate[required]" >
								<option value=""><?php echo get_phrase('select_grade_set');?></option>
								<?php 							
								foreach($gradesets as $row):
								?>
									<option value="<?php echo $row['set_id'];?>">
											<?php echo $row['set_name'];?></option>
								<?php
								endforeach;
								?>
							</select>
								</div>
							</div>
                        </div>
						</div>
						
					   <div class="row-fluid">
                        <div class="span5">
                        <div class="control-group">
                        <label class="control-label" for="fee_category"><?php echo get_phrase('category_name');?></label>
                        <div class="controls">                        
						<select class="validate[required]" id="category_name" name="category_name">
							<option value="">Select Category</option>
							<?php foreach($category as $list){ ?>
								<option value="<?php echo $list['cce_id']; ?>"><?php echo $list['category']; ?></option>
							<?php } ?>
						</select>  
						<span id="val_fc_id"></span>
                        </div>
                        </div>
                        </div> 																		
                        </div>  

						<div class="row-fluid" id="skill_names_load" style="display:none;">
                        <div class="span10" >
							<div class="control-group">
								<label class="control-label" for="fee_category"><?php echo get_phrase('Skills');?></label>
								<div id="parent_skill">
								</div>								
							</div>
                        </div>
						</div>
				
						
                        <div class="row-fluid">
                        
                        <div class="span6">
                        <div class="control-group">
                        <div class="controls">
                        <button type="submit" class="btn btn-lightblue" onclick="return validate_skills()"><?php echo get_phrase('add_indicator');?></button>                       
                        </div>
                        </div>
                        </div>
                        </div>
                        
                        </form>
                        </div>
                
                </div>
        
        </div>
		
	
	<div class="box-content padded">
		<div class="tab-content">            
            <!----TABLE LISTING STARTS--->
            <div class="tab-pane box active" id="list">
				
                <table cellpadding="0" cellspacing="0" border="1" class="table responsive">
                	<thead>
                		<tr>
                    		<th><div><?php echo get_phrase('si_no');?></div></th>                    		
                    		<th><div><?php echo get_phrase('skill_name');?></div></th>							
							<th><div><?php echo get_phrase('grade_set');?></div></th>
                    		<th><div><?php echo get_phrase('');?></div></th>
						</tr>
					</thead>
                    <tbody>
						<input type="hidden" value="<?php echo $no_rows; ?>" id="new_no_rows" />
                    	<?php $count = 1;foreach($gradeskills as $row):?>
                        <tr>
							<td><?php echo $count;?></td>
							<form action="<?php echo base_url(); ?>admin/grade_skills_mapping/up_date/" method="post">							
							<td><?php echo $row['sname'];?>
								<input type="hidden" value="<?php echo $row['skill_name']; ?>" id="<?php echo $count.'01'; ?>" /></td>														
							<td><span id="<?php echo $count.'0'; ?>"><?php echo $row['setname'];?></span>
								<input type="hidden" value="<?php echo $row['grade_skill_id']; ?>"  name="edit_grade_skill_id" id="<?php echo $count.'1'; ?>" />	
																		
									<select class="validate[required]" style="display:none;" name="edit_grade_skill_name" id="<?php echo $count.'2'; ?>" >
								<option value=""><?php echo get_phrase('select_grade_set');?></option>
								<?php 							
								foreach($gradesets as $row2):
								?>
									<option value="<?php echo $row2['set_id'];?>" <?php if($row['grade_set']==$row2['set_name']){ echo 'selected';} ?>>
											<?php echo $row2['set_name'];?></option>
								<?php
								endforeach;
								?>
								</select>
														
							</td>
							<td align="center">
								<div class="row-fluid">                        
									<div class="span4">
									<div class="control-group">
										<div class="controls">
											<button type="submit" id="<?php echo $count.'31'; ?>" style="display:none;" class="btn btn-lightblue"><?php echo get_phrase('update');?></button>
											<a data-toggle="modal" id="<?php echo $count.'3'; ?>"  onclick="update(<?php echo $count; ?>,<?php echo $no_rows; ?>)" class="btn btn-gray btn-small">
											<i class="icon-wrench"></i> <?php echo get_phrase('edit');?>
											</a>
										</div>
									</div>
									</div>
									<div class="span4">
									<div class="control-group">
										<div class="controls">
											<button type="button" id="<?php echo $count.'41'; ?>" style="display:none;" class="btn btn-lightblue" onclick="close_cce(<?php echo $count; ?>)"><?php echo get_phrase('cancel');?></button>
											<a data-toggle="modal" id="<?php echo $count.'4'; ?>" href="#modal-delete" onclick="modal_delete('<?php echo base_url();?>admin/grade_skills_mapping/delete/<?php echo $row['grade_skill_id'];?>')" class="btn btn-red btn-small">
                                		<i class="icon-trash"></i> <?php echo get_phrase('delete');?>
										</a>
										</div>
									</div>
									</div>
									</div>                            									                  
								
        					</td>
							</form>
                        </tr>
                        <?php $count++; endforeach;?>
                    </tbody>
                </table>
			</div>
            <!----TABLE LISTING ENDS--->
            
		</div>
	</div>
</div>

<script>
function update(x,y){
	for(i=1;i<=y;i++)
	{
		if(i==x)
			{
				document.getElementById(i+'2').style.display="block";
				document.getElementById(i+'0').style.display="none";
				document.getElementById(i+'3').style.display="none";
				document.getElementById(i+'4').style.display="none";
				document.getElementById(i+'31').style.display="block";
				document.getElementById(i+'41').style.display="block";
			}
		else
			{
				document.getElementById(i+'2').style.display="none";
				document.getElementById(i+'0').style.display="block";
				document.getElementById(i+'3').style.display="block";
				document.getElementById(i+'4').style.display="block";
				document.getElementById(i+'31').style.display="none";
				document.getElementById(i+'41').style.display="none";
			}
	}
	//alert(y);
}
function close_cce(x)
{
	document.getElementById(x+'2').style.display="none";
	document.getElementById(x+'0').style.display="block";
	document.getElementById(x+'3').style.display="block";
	document.getElementById(x+'4').style.display="block";
	document.getElementById(x+'31').style.display="none";
	document.getElementById(x+'41').style.display="none";
	//alert(x);
}

function validate_skills()
{
	skills_rows=document.getElementById('no_rows_skills').value;
	data_rows=document.getElementById('new_no_rows').value;
	var k=0;
	for(i=1;i<=data_rows;i++)
	{
		var l=0;
		for(j=1;j<skills_rows;j++)
		{
			
			if(document.getElementById('check'+j).checked)
			{
				if((document.getElementById(i+'01').value)==(document.getElementById('check'+j).value))
				{
					k++;
				}
				l++;
			}
		}
	}	
	if(k==l)
	{
		document.getElementById('validate_date2').style.display="block";
		document.getElementById('success_updates').style.display="none";
		return false;
	}
	
}

</script>

<script>
$('#category_name').on('change',function(){
	
	
	
	var fc_id = $(this).val();	
	
	//alert(fc_id);
	$('#val_fc_id').append('<img title="<?php echo base_url(); ?>template/images/loading.gif" src="<?php echo base_url(); ?>template/images/loading.gif">');
	
	
		
		
		$.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>admin/cce_grade_skills_dynamic/',
							data: { get_fc_id:fc_id },
							success: function(data) {
								//alert(data);
								
								$('#val_fc_id').text('');
								$('#selected_skill').text('');
								document.getElementById('skill_names_load').style.display="block";							
								$('#parent_skill').text('').append(data);
								
							}
				  });
	
	
});
$('#parent_skill').on('change',function(){
	var fc_id = $(this).val();
	$('#selected_skill').text(fc_id);
	//document.getElementById('selected_skill').innerHTML=fc_id;		
});


</script>