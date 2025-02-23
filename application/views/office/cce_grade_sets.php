
<div class="box">

	

	<div class="box-header">
    
    	<!------CONTROL TABS START------->
		<ul class="nav nav-tabs nav-tabs-left">
			<li class="active" >
            	<a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> 
					<?php echo get_phrase('grades');?>
                    	</a></li>
			<li >
            	<a href="#add" data-toggle="tab"><i class="icon-plus"></i>
					<?php echo get_phrase('grade_sets');?>
                    	</a></li>
		</ul>
    	<!------CONTROL TABS END------->
        
	</div>
	<div class="box-content padded">
		<div class="row-fluid">
			<div class="control-group">
			<div class="alert alert-warning" id="validate_date1" style="display:none;" > 
						<button class="close" data-dismiss="alert">&times;</button>
						<span>Please Select Valid Start-Date and End-Date</span>
			</div>
			<div class="alert alert-danger" id="validate_date2" style="display:none;" > 
						<button class="close" data-dismiss="alert">&times;</button>
						<span>Grade Set Name Already Existed</span>
			</div> 
			</div>
		
                        <div class="control-group" id="success_updates">
							<?php if($this->session->flashdata('msg')=="succesfully created grade set" || $this->session->flashdata('msg')=="succesfully updated grade set") {?>
							<div class="alert alert-success">   
												<button class="close" data-dismiss="alert">&times;</button>
												<?php echo $this->session->flashdata('msg'); ?>
											 </div> 							
							<?php } ?>
							<?php if($this->session->flashdata('msg')=="succesfully deleted grade set") {?>
							<div class="alert alert-danger">                   
												<button class="close" data-dismiss="alert">&times;</button>
												<?php echo $this->session->flashdata('msg'); ?>
											 </div> 							
							<?php } ?>
							<?php if($this->session->flashdata('msg')=="grade set already existed") {?>
							<div class="alert alert-warning">     
												<button class="close" data-dismiss="alert">&times;</button>
												<?php echo $this->session->flashdata('msg'); ?>
											 </div> 							
							<?php } ?>
                        </div>
        
	</div>
		<div class="tab-content">
            <!----TABLE LISTING STARTS--->
            <div class="tab-pane box active" id="list">
                          
                <div class="box-content">
						<?php echo form_open('admin/cce_grade_sets/create_grade' , array('class' => 'form-horizontal validatable','target'=>'_top'));?>
							<div class="padded">
													
							 <div class="control-group">
									<label class="control-label"><?php echo get_phrase('select_grade_set_name');?></label>
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
							   
							   
							   
							 <div class="control-group">
									<table border='1'>
										<tr>
											<td><input type="text" id="grade_name" name="grade_name" size="3" class="validate[required]" placeholder="grade_name" />&nbsp;</td>
											<td>&nbsp;<input type="text" id="lower_bound" name="lower_bound" size="3" class="validate[required]" placeholder="lower_bound" />&nbsp;</td>
											<td>&nbsp;<input type="text" id="upper_bound" name="upper_bound" size="3" class="validate[required]" placeholder="upper_bound" />&nbsp;</td>
											<td>&nbsp;<input type="text" id="grade_points" name="grade_points" size="35" class="validate[required]" placeholder="grade_points" />&nbsp;</td>											
											<td>&nbsp;<button type="submit" onclick="return validate_grade();" class="btn btn-gray"><?php echo get_phrase('add_grade_set');?></button></td>
										</tr>
									</table>
										
										
								</div>							
						</form>                
					</div>                
				</div>
				
				<div class="padded">
				<span id="custom-tam-p-stn"></span>
				
					</div>
				
			</div>
			
            <!----TABLE LISTING ENDS--->




<!----CREATION FORM STARTS---->
				<div class="tab-pane box" id="add" style="padding: 5px">
					<div class="box-content">
						<?php echo form_open('admin/cce_grade_sets/set_create' , array('class' => 'form-horizontal validatable','target'=>'_top'));?>
							<div class="padded">

							 <div class="control-group">
									<label class="control-label"><?php echo get_phrase('grade_set_name');?></label>
									<div class="controls">
										<input type="text" id="grade_setname" name="grade_setname" class="validate[required]" placeholder="Enter Set Name" />
									</div>
								</div>

							<div class="form-actions">
								<button onclick="return check_gradeset(<?php echo $no_rows; ?>)" type="submit" class="btn btn-gray"><?php echo get_phrase('grade_set');?></button>
							</div>
						</form>                
					</div>   
					
					<div class="padded">
				<table cellpadding="0" cellspacing="0" class="table responsive" border='1' >
                	<thead>
                		<tr>
                    		<th><div><?php echo get_phrase('si_no');?></div></th>
                    		<th><div><?php echo get_phrase('grade_set_id');?></div></th>
                    		<th><div><?php echo get_phrase('grade_set_name');?></div></th>
                    		<th><div><?php echo get_phrase('');?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php $count = 1;foreach($gradesets as $row):?>
                        <tr >
							<td><?php echo $count;?></td>
							<td><?php echo $row['set_id'];?></td>
							<form action="<?php echo base_url(); ?>admin/cce_grade_sets/up_date_sets/" method="post">
							<td>	
								<span id="<?php echo $count.'0'; ?>"><?php echo $row['set_name'];?></span>
								<input type="hidden" value="<?php echo $row['set_name'];?>" id="<?php echo $count.'old'; ?>" />
								<input type="hidden" value="<?php echo $row['set_id']; ?>" name="set_id" id="<?php echo $count.'1'; ?>" />								
								<input type="text" value="<?php echo $row['set_name']; ?>" style="display:none;" name="edit_category" id="<?php echo $count.'2'; ?>" />
								
							</td>							
							<td>
								<div class="row-fluid">                        
									<div class="span3">
									<div class="control-group">
										<div class="controls">
											<button type="submit" id="<?php echo $count.'31'; ?>" style="display:none;" class="btn btn-lightblue" onclick="return check_gradeset_edit(<?php echo $count; ?>,<?php echo $no_rows; ?>) " ><?php echo get_phrase('update');?></button>
											<a data-toggle="modal" id="<?php echo $count.'3'; ?>"  onclick="update(<?php echo $count; ?>,<?php echo $no_rows; ?>)" class="btn btn-gray btn-small">
											<i class="icon-wrench"></i> <?php echo get_phrase('edit');?>
											</a>
										</div>
									</div>
									</div>
									<div class="span3">
									<div class="control-group">
										<div class="controls">
											<button type="button" id="<?php echo $count.'41'; ?>" style="display:none;" class="btn btn-lightblue" onclick="close_cce(<?php echo $count; ?>)"><?php echo get_phrase('cancel');?></button>
											<a data-toggle="modal" id="<?php echo $count.'4'; ?>" href="#modal-delete" onclick="modal_delete('<?php echo base_url();?>admin/cce_grade_sets/set_delete/<?php echo $row['set_id'];?>')" class="btn btn-red btn-small">
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
				</div>
				<!----CREATION FORM ENDS--->
				
						  
			</div>
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
function check_gradeset(rows)
{
	check=document.getElementById('grade_setname').value;
	for(i=1;i<=rows;i++)
	{
		if(check==document.getElementById(i+'old').value)
		{
			document.getElementById('validate_date2').style.display="block";
			document.getElementById('success_updates').style.display="none";
			return false;
		}
	}	
	
}

function check_gradeset_edit(p,rows)
{
	check=document.getElementById(p+'2').value;
	for(i=1;i<=rows;i++)
	{
		if(p != i)
		{
			if(check==document.getElementById(i+'old').value)
			{
				document.getElementById(p+'2').value=document.getElementById(p+'old').value;
				document.getElementById('validate_date2').style.display="block";
				document.getElementById('success_updates').style.display="none";
				return false;
			}
		}
	}	
}

 $('#grade_set_name').on('change',function(){
	  
	  var p_cid = $(this).val();
	//alert(p_cid);
	
	$.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>admin/sets_dynamic_data/',
							data: { get_p_cid:p_cid },
							success: function(data) {
								//alert(data);
								$('#custom-tam-p-stn').text('').append(data);
								
							}
				  });
  });
  
  function validate_grade()
  {
	check=document.getElementById('grade_name').value;
	rows=document.getElementById('total_rows').value;
	for(i=1;i<=rows;i++)
	{		
		if(check.toLowerCase()==(document.getElementById(i+'value').value).toLowerCase())
		{
			document.getElementById('validate_date2').style.display="block";
			document.getElementById('success_updates').style.display="none";
			return false;
		}		
	}
  }
  function confirmation()
  {
	if(confirm('Are Sure you want to delete'))
		return true;
	else
		return false;
  }
  function update_start(up_id)
  {
	rows=document.getElementById('total_rows').value;
	for(i=1;i<=rows;i++){
		if(i==up_id){
			document.getElementById(i+'01').style.display="block";
			document.getElementById(i+'02').style.display="block";
			document.getElementById(i+'03').style.display="block";
			document.getElementById(i+'11').style.display="none";
			document.getElementById(i+'12').style.display="none";
			document.getElementById(i+'13').style.display="none";
			document.getElementById(i+'edit').style.display="none";
			document.getElementById(i+'delete').style.display="none";
			document.getElementById(i+'cancel').style.display="block";
			document.getElementById(i+'update').style.display="block";
		}
		else{
			document.getElementById(i+'01').style.display="none";
			document.getElementById(i+'02').style.display="none";
			document.getElementById(i+'03').style.display="none";
			document.getElementById(i+'11').style.display="block";
			document.getElementById(i+'12').style.display="block";
			document.getElementById(i+'13').style.display="block";
			document.getElementById(i+'edit').style.display="block";
			document.getElementById(i+'delete').style.display="block";
			document.getElementById(i+'cancel').style.display="none";
			document.getElementById(i+'update').style.display="none";
		}
	}
  }
  function close_row(row_id)
  {	
	document.getElementById(row_id+'01').style.display="none";
	document.getElementById(row_id+'02').style.display="none";
	document.getElementById(row_id+'03').style.display="none";
	document.getElementById(row_id+'11').style.display="block";
	document.getElementById(row_id+'12').style.display="block";
	document.getElementById(row_id+'13').style.display="block";
	document.getElementById(row_id+'edit').style.display="block";
	document.getElementById(row_id+'delete').style.display="block";
	document.getElementById(row_id+'cancel').style.display="none";
	document.getElementById(row_id+'update').style.display="none";
  }
  function update_lower(row_id)
  { 
  document.getElementById(row_id+'011').value=document.getElementById(row_id+'01').value;
  document.getElementById(row_id+'021').value=document.getElementById(row_id+'02').value;
  document.getElementById(row_id+'031').value=document.getElementById(row_id+'03').value;
	/*y=document.getElementById(row_id+'01').value;	
	x=document.getElementById(row_id+'01').value;
	y+x;
	document.getElementById(row_id+'011').value=x;*/
	//alert(x);
	//document.getElementById('grade_name').value
  }

</script>