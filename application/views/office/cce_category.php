<div class="box">
	<br>
	<div class="row-fluid">
				
        		<div class="span12">
                		<div class="custom-tam-hr-frm">
                	    <form class="form-horizontal validatable" method="post" action="<?php echo base_url(); ?>admin/cce_category/create/">
                        <div class="row-fluid">
                        <div class="span5">
                        <div class="control-group">
                        <label class="control-label" for="fee_category"><?php echo get_phrase('fee_category');?></label>
                        <div class="controls">
                        <input type="text" class="validate[required]" id="add_category" name="add_category" placeholder="Please enter fee category">
                        <span id="val_fc_val"></span>						 
                        </div>
                        </div>
                        </div> 
						<div class="span3">
						<div class="control-group" id="validate_date2" style="display:none;">
						<div class="alert alert-danger"  > 
									<button class="close" data-dismiss="alert">&times;</button>
									<span>Assessment Name Already Existed</span>
						</div> 
						</div>
                        <div class="control-group" id="success_updates">
							
							<?php if($this->session->flashdata('msg')=="succesfully created category" || $this->session->flashdata('msg')=="succesfully updated category") {?>
							<div class="alert alert-success">   
												<button class="close" data-dismiss="alert">&times;</button>
												<?php echo $this->session->flashdata('msg'); ?>
											 </div> 							
							<?php } ?>
							<?php if($this->session->flashdata('msg')=="succesfully deleted category") {?>
							<div class="alert alert-danger"> 
												<button class="close" data-dismiss="alert">&times;</button>
												<?php echo $this->session->flashdata('msg'); ?>
											 </div> 							
							<?php } ?>
							<?php if($this->session->flashdata('msg')=="category already existed") {?>
							<div class="alert alert-warning">      
												<button class="close" data-dismiss="alert">&times;</button>
												<?php echo $this->session->flashdata('msg'); ?>
											 </div> 							
							<?php } ?>
                        </div>
                        </div> 
						
                        </div>                      
                        <div class="row-fluid">
                        
                        <div class="span6">
                        <div class="control-group">
                        <div class="controls">
                        <button type="submit" class="btn btn-lightblue" onclick="return validate_terms();"><?php echo get_phrase('add_category');?></button>                       
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
				<!--<input type="text" value="<?php echo $no_rows; ?>" id="total_rows"  />-->
                <table cellpadding="0" cellspacing="0" border="1" class="table">
                	<thead>
                		<tr>
                    		<th><div><?php echo get_phrase('si_no');?></div></th>
                    		<th><div><?php echo get_phrase('category_id');?></div></th>
                    		<th><div><?php echo get_phrase('Category Name');?></div></th>
                    		<th><div><?php echo get_phrase('');?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php $count = 1;foreach($category as $row):?>
                        <tr>
							<td><?php echo $count;?></td>
							<td><?php echo $row['cce_id'];?></td>
							<form action="<?php echo base_url(); ?>admin/cce_category/up_date/" method="post">
							<td>	
								<span id="<?php echo $count.'0'; ?>"><?php echo $row['category'];?></span>
								<input id="<?php echo $count.'old'; ?>" type="hidden" value="<?php echo $row['category']; ?>"/>
								<input type="text" value="<?php echo $row['cce_id']; ?>" style="display:none;" name="edit_category_id" id="<?php echo $count.'1'; ?>" />								
								<input type="text" value="<?php echo $row['category']; ?>" style="display:none;" name="edit_category" id="<?php echo $count.'2'; ?>" />
								
							</td>							
							<td align="center">
								<div class="row-fluid">                        
									<div class="span3">
									<div class="control-group">
										<div class="controls">
											<button type="submit" id="<?php echo $count.'31'; ?>" style="display:none;" onclick="return check_existing(<?php echo $count; ?>,<?php echo $no_rows; ?>)" class="btn btn-lightblue"><?php echo get_phrase('update');?></button>
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
											<a data-toggle="modal" id="<?php echo $count.'4'; ?>" href="#modal-delete" onclick="modal_delete('<?php echo base_url();?>admin/cce_category/delete/<?php echo $row['cce_id'];?>')" class="btn btn-red btn-small">
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

function validate_terms()
{
	x=document.getElementById('add_category').value;
	rows=document.getElementById('total_rows').value;	
	for(i=1;i<=rows;i++)
	{
		if(x==document.getElementById(i+'old').value)
		{
			document.getElementById('validate_date2').style.display="block";
			document.getElementById('success_updates').style.display="none";
			return false;
		}
	}
}

function check_existing(p,r)
{
	x=document.getElementById(p+'old').value;
	y=document.getElementById(p+'2').value;	
	for(i=1;i<=r;i++)
	{		
		if( i != p)
		{
			if(y.toLowerCase()==document.getElementById(i+'old').value.toLowerCase())
			{
				document.getElementById(p+'2').value=document.getElementById(p+'old').value;				
				document.getElementById('validate_date2').style.display="block";
				document.getElementById('success_updates').style.display="none";
				return false;
			}
		}			
	}	
	
}

</script>