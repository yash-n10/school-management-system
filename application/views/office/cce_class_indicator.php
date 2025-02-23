<div class="box">
	<br>
	<div class="row-fluid">
				
        		<div class="span12">
                		<div class="custom-tam-hr-frm">
                	    
                        <div class="row-fluid">
                        <div class="span8">
                        <div class="control-group">                        
                        <div class="controls">
                        <center>

        <div class="span12" style="float:none !important;">

            <div class="box">

                <div class="box-header">

                    <span class="title"> <i class="icon-info-sign"></i> Please select a class to manage student.</span>

                </div>

                <div class="box-content padded tam-custom-border1">

                    <br />					
                    <select name="class_id" onchange="window.location='<?php echo base_url(); ?>admin/cce_class_indicator/'+this.value">
                        <option value=""><?php echo get_phrase('select_a_class'); ?></option>
						<?php
						$classes = $this->db->get('class')->result_array();
						foreach ($classes as $row):
							?>
                            <option value="<?php echo $row['class_id']; ?>"
                            <?php if ($class_id == $row['class_id']) echo 'selected'; ?>>
                                <?php echo $row['name'].'-'.$row['name_numeric']; ?></option>
                            <?php
                        endforeach;
                        ?>
                    </select>

                    <!--<hr />-->

                    <script>

                        $(document).ready(function() {

                            function ask()

                            {
                                Growl.info({title:"Select a class to manage Class Indicator",text:" "});
                            }

                            setTimeout(ask, 500);

                        });

                    </script>

                </div>

            </div>

        </div>

    </center>						 
                        </div>
                        </div>
                        </div> 						
						
                        </div>                                                                                           
                        </div>
                
                </div>
        
        </div>
		
	
	<div class="box-content padded">
		<div class="tab-content">            
            <!----TABLE LISTING STARTS--->
			<?php if($class_id){ ?>
            <div class="tab-pane box active" id="list">				
				<form action="<?php echo base_url(); ?>admin/cce_class_indicator/<?php echo $class_id; ?>/update/" method="post">
				<table cellpadding="0" cellspacing="0" border="1" class="table">                	
				<?php
				    $this->db->select('cce_class_indicator.*,cce_category.category as cname');
					$this->db->where('class',$class_id);
					$this->db->group_by('category_name');
					$this->db->join('cce_category','cce_category.cce_id = cce_class_indicator.category_name');
					$categories=$this->db->get('cce_class_indicator')->result_array();					
					foreach($categories as $category)
					{			
						echo '<tr><td colspan="4"><h2 style="color:#666;">'.$category['cname'].'</h2></td></tr>';
						$this->db->where('class',$class_id);
						$this->db->select('cce_class_indicator.*,cce_skills.skill_name as sname');
						$this->db->join('cce_skills','cce_skills.skill_id = cce_class_indicator.skill_name');
						$this->db->where('cce_class_indicator.category_name',$category['category_name']);
						$this->db->group_by('skill_name');
						$skills=$this->db->get('cce_class_indicator')->result_array();
						foreach($skills as $skill)
						{
							echo '<tr><td colspan="4"><h3 style="color:#666;">'.$skill['sname'].'</h3></td></tr>';
							$this->db->where('class',$class_id);
							$this->db->join('cce_indicators','cce_indicators.indicator_id = cce_class_indicator.indicator_name');
							$this->db->where('cce_class_indicator.category_name',$category['category_name']);
							$this->db->where('skill_name',$skill['skill_name']);							
							$indicators=$this->db->get('cce_class_indicator')->result_array();																					
							foreach($indicators as $indicator)
							{?>
							
								<tr>
								<td><?php echo $skill['sname']; ?> </td>
								<td><?php echo $indicator['indicator_name']; ?> </td>
								<td><input type="checkbox" value="<?php echo $indicator['ci_id']; ?>" name="checked_data[]" <?php if($indicator['indicator_checked']) echo 'checked'; ?>  /></td>
								<td><select name="checked_grade[]">
									<option value="A<?php echo '*'.$indicator['ci_id']; ?>" <?php if($indicator['indicator_grade']=='A') echo 'selected'; ?>>A</option>
									<option value="B<?php echo '*'.$indicator['ci_id']; ?>" <?php if($indicator['indicator_grade']=='B') echo 'selected'; ?>>B</option>
									<option value="C<?php echo '*'.$indicator['ci_id']; ?>" <?php if($indicator['indicator_grade']=='C') echo 'selected'; ?>>C</option>
									<option value="D<?php echo '*'.$indicator['ci_id']; ?>" <?php if($indicator['indicator_grade']=='D') echo 'selected'; ?>>D</option>
								</select></td></tr>
							
							<?php
							}
							
				  }
					}?>
                    
                </table>
				<button type="submit" class="btn btn-lightblue" ><?php echo get_phrase('update');?></button>
				</form>
               
			</div>
			<?php } ?>
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