<div class="box">
	<div class="row-fluid">
			<div class="control-group">
			<div class="alert alert-warning" id="validate_date1" style="display:none;" > 
						<button class="close" data-dismiss="alert">&times;</button>
						<span>Please Select Valid Start-Date and End-Date</span>
			</div>
			<div class="alert alert-danger" id="validate_date2" style="display:none;" > 
						<button class="close" data-dismiss="alert">&times;</button>
						<span>Term Already Existed</span>
			</div> 
			</div>
		
                        <div class="control-group" id="success_updates">
							<?php if($this->session->flashdata('msg')=="succesfully created term" || $this->session->flashdata('msg')=="succesfully updated term") {?>
							<div class="alert alert-success">   
												<button class="close" data-dismiss="alert">&times;</button>
												<?php echo $this->session->flashdata('msg'); ?>
											 </div> 							
							<?php } ?>
							<?php if($this->session->flashdata('msg')=="succesfully deleted term") {?>
							<div class="alert alert-danger">                   
												<button class="close" data-dismiss="alert">&times;</button>
												<?php echo $this->session->flashdata('msg'); ?>
											 </div> 							
							<?php } ?>
							<?php if($this->session->flashdata('msg')=="term already existed") {?>
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
                	    <form class="form-horizontal validatable" method="post" action="<?php echo base_url(); ?>admin/cce_assessment_term/create/">
                        <div class="row-fluid">
                        <div class="span5">
                        <div class="control-group">
                        <label class="control-label" for="fee_category"><?php echo get_phrase('term_name');?></label>
                        <div class="controls">                        
							<input type="text" placeholder="Term Name" name="term_name" id="term_name" class="validate[required]" />
                        </div>
                        </div>
                        </div> 																		
                        </div>  
						
						<div class="row-fluid">
                        <div class="span5">
                        <div class="control-group">
                        <label class="control-label" for="fee_category"><?php echo get_phrase('term_start_date');?></label>
                        <div class="controls">                        
							<input type="text" onclick="hide_warning()" onchange="validate_date()" class="datepicker fill-up validate[required]" placeholder="Term Start Date" name="term_start_date" id="term_start_date" class="validate[required]" />
                        </div>
                        </div>
                        </div> 																		
                        </div> 
						
						<div class="row-fluid">
                        <div class="span5">
                        <div class="control-group">
                        <label class="control-label" for="fee_category"><?php echo get_phrase('term_end_date');?></label>
                        <div class="controls">                        
							<input type="text" onclick="hide_warning()" onchange="validate_date()" class="datepicker fill-up validate[required]" placeholder="Term End Date" name="term_end_date"  id="term_end_date" class="validate[required]" />
                        </div>
                        </div>
                        </div> 																		
                        </div> 

						
                        <div class="row-fluid">
                        
                        <div class="span6">
                        <div class="control-group">
                        <div class="controls">
                        <button type="submit" class="btn btn-lightblue"><?php echo get_phrase('add_assessement');?></button>                       
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
				
                <table cellpadding="0" cellspacing="0" border="1" class="table">
                	<thead>
                		<tr>
                    		<th><div><?php echo get_phrase('si_no');?></div></th>                    		
                    		<th><div><?php echo get_phrase('term_name');?></div></th>
							<th><div><?php echo get_phrase('term_start_date');?></div></th>
							<th><div><?php echo get_phrase('term_end_date');?></div></th>
                    		<th><div><?php echo get_phrase('');?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php $count = 1;foreach($assessment as $row):?>						
                        <tr>
							<td><?php echo $count;?></td>
							<form action="<?php echo base_url(); ?>admin/cce_assessment_term/up_date/" method="post">							
							<td><span id="<?php echo $count.'00'; ?>"><?php echo $row['term_name'];?></span>
								<input id="<?php echo $count.'old'; ?>" type="hidden" value="<?php echo $row['term_name']; ?>"/>
								<input type="hidden" value="<?php echo $row['term_id']; ?>" name="term_id" />
								<input onclick="hide_warning()" id="<?php echo $count.'01'; ?>" type="text" value="<?php echo $row['term_name']; ?>" name="term_name" style="display:none;" />
							</td>														
							<td><span id="<?php echo $count.'11'; ?>"><?php echo date('d M,Y', $row['term_start_date']); ?></span>								
								<input type="text" onclick="hide_warning()" onchange="validate_date1(<?php echo $count; ?>)" class="datepicker validate[required]" value="<?php echo date('m/d/Y', $row['term_start_date']); ?>" style="display:none;" name="term_start_date1" id="<?php echo $count.'12'; ?>" />
							</td>
							<td><span id="<?php echo $count.'21'; ?>"><?php echo date('d M,Y', $row['term_end_date']); ?></span>								
								<input type="text" onclick="hide_warning()" onchange="validate_date1(<?php echo $count; ?>)" class="datepicker validate[required]" value="<?php echo date('m/d/Y', $row['term_end_date']); ?>" style="display:none;" name="term_end_date1" id="<?php echo $count.'22'; ?>" />
							</td>
							<td align="center">
								<div class="row-fluid">                        
									<div class="span4">
									<div class="control-group">
										<div class="controls">
											<button type="submit" id="<?php echo $count.'31'; ?>" style="display:none;" class="btn btn-lightblue" onclick="return check_existing(<?php echo $count; ?>,<?php echo $no_rows; ?>)"><?php echo get_phrase('update');?></button>
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
											<a data-toggle="modal" id="<?php echo $count.'4'; ?>" href="#modal-delete" onclick="modal_delete('<?php echo base_url();?>admin/cce_assessment_term/delete/<?php echo $row['term_id'];?>')" class="btn btn-red btn-small">
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
				document.getElementById(i+'00').style.display="none";
				document.getElementById(i+'11').style.display="none";
				document.getElementById(i+'21').style.display="none";
				document.getElementById(i+'01').style.display="block";
				document.getElementById(i+'12').style.display="block";
				document.getElementById(i+'22').style.display="block";
				document.getElementById(i+'3').style.display="none";
				document.getElementById(i+'4').style.display="none";
				document.getElementById(i+'31').style.display="block";
				document.getElementById(i+'41').style.display="block";
			}
		else
			{
				document.getElementById(i+'00').style.display="block";
				document.getElementById(i+'11').style.display="block";
				document.getElementById(i+'21').style.display="block";
				document.getElementById(i+'01').style.display="none";
				document.getElementById(i+'12').style.display="none";
				document.getElementById(i+'22').style.display="none";
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
	document.getElementById(x+'00').style.display="block";
	document.getElementById(x+'11').style.display="block";
	document.getElementById(x+'21').style.display="block";
	document.getElementById(x+'01').style.display="none";
	document.getElementById(x+'12').style.display="none";
	document.getElementById(x+'22').style.display="none";
	document.getElementById(x+'3').style.display="block";
	document.getElementById(x+'4').style.display="block";
	document.getElementById(x+'31').style.display="none";
	document.getElementById(x+'41').style.display="none";
	//alert(x);
}

function validate_date()
{
	x=document.getElementById('term_start_date').value;
	y=document.getElementById('term_end_date').value;	
	var parts =x.split('/');
	var mydate1 = new Date(parts[2],parts[0]-1,parts[1]);
	var parts =y.split('/');
	var mydate2 = new Date(parts[2],parts[0]-1,parts[1]);

	if(x && y)
	{
		if(mydate1>mydate2)
		{
			//alert('please select valid dates');
			document.getElementById('term_start_date').value='';
			document.getElementById('term_end_date').value='';
			document.getElementById('validate_date1').style.display="block";
		}
	}
	
}

function validate_date1(m)
{
	x=document.getElementById(m+'12').value;
	y=document.getElementById(m+'22').value;	
	var parts =x.split('/');
	var mydate1 = new Date(parts[2],parts[0]-1,parts[1]);
	var parts =y.split('/');
	var mydate2 = new Date(parts[2],parts[0]-1,parts[1]);

	if(x && y)
	{
		if(mydate1>mydate2)
		{
			document.getElementById('validate_date1').style.display="block";
			document.getElementById('validate_date2').style.display="none";
			document.getElementById('success_updates').style.display="none";
		}
	}
	
}

function hide_warning()
{
	document.getElementById('validate_date1').style.display="none";
	document.getElementById('validate_date2').style.display="none";
}

function check_existing(p,r)
{
	x=document.getElementById(p+'old').value;
	y=document.getElementById(p+'01').value;	
	for(i=1;i<=r;i++)
	{
		if( i != p)
		{
			if(y.toLowerCase()==document.getElementById(i+'old').value.toLowerCase())
			{
				document.getElementById(p+'01').value=document.getElementById(p+'old').value;
				document.getElementById('validate_date1').style.display="none";
				document.getElementById('validate_date2').style.display="block";
				document.getElementById('success_updates').style.display="none";
				return false;
			}
		}			
	}	
	
}

</script>
