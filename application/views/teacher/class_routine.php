<div class="box">
	<div class="box-header">
    
    	<!------CONTROL TABS START------->
		<ul class="nav nav-tabs nav-tabs-left">
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> 
					<?php echo get_phrase('class_routine_list');?>
                    	</a></li>
		</ul>
    	<!------CONTROL TABS END------->
        
	</div>
	<div class="box-content padded">
		<div class="tab-content">
            
            <!----TABLE LISTING STARTS--->
            <div class="tab-pane  <?php if(!isset($edit_data))echo 'active';?>" id="list">
				<div class="accordion" id="accordion2">
                	<?php 
					$toggle = true;
					$classes = $this->db->get('class')->result_array();
					foreach($classes as $row):
						?>
                            <div class="accordion-group">
                                <div class="accordion-heading">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse<?php echo $row['class_id'];?>">
                                        <i class="icon-rss icon-1x"></i> Class <?php echo $row['name'];?>
                                    </a>
                                </div>
                                <div id="collapse<?php echo $row['class_id'];?>" class="accordion-body collapse <?php if($toggle){echo 'in';$toggle=false;}?>">
                                    <div class="accordion-inner">
                                        <table cellpadding="0" cellspacing="0" border="0"  class="table table-normal">
                                            <tbody>
                                                <?php 
                                                for($d=1;$d<=7;$d++):
                                                
                                                if($d==1)$day='sunday';
                                                else if($d==2)$day='monday';
                                                else if($d==3)$day='tuesday';
                                                else if($d==4)$day='wednesday';
                                                else if($d==5)$day='thursday';
                                                else if($d==6)$day='friday';
                                                else if($d==7)$day='saturday';
                                                ?>
                                                <tr class="gradeA">
                                                    <td width="100"><?php echo strtoupper($day);?></td>
                                                    <td>
                                                    	<?php
														$this->db->order_by("time_start", "asc");
														$this->db->where('day' , $day);
														$this->db->where('class_id' , $row['class_id']);
														$routines	=	$this->db->get('class_routine')->result_array();
														foreach($routines as $row2):
                                                        $this->db->where('subject_id', $row2['subject_id']);
                                                        $teacher = $this->db->get('subject')->result_array();
                                                        $teacher_id = $teacher[0]['teacher_id'];
                                                        $this->db->where('teacher_id', $teacher_id);
                                                        $teacher_details = $this->db->get('teacher')->result_array();
                                                        $teacher_name = $teacher_details[0]['name'];
														?>
														<div class="btn-group">
															<button class="btn btn-gray btn-normal" >
                                                            	<?php echo $this->crud_model->get_subject_name_by_id($row2['subject_id']);?>
																<?php echo '('.$row2['time_start'].':'.$row2['time_start_min'].'-'.$row2['time_end'].':'.$row2['time_end_min'].')';?><br/>
                                                                <?php echo '('.strtoupper($teacher_name).')';?>
                                                            </button>
														</div>
														<?php endforeach;?>

                                                    </td>
                                                </tr>
                                                <?php endfor;?>
                                                
                                            </tbody>
                                        </table>
                                        
                                    </div>
                                </div>
                            </div>
						<?php
					endforeach;
					?>
  				</div>
			</div>
            <!----TABLE LISTING ENDS--->
            
		</div>
	</div>
</div>
