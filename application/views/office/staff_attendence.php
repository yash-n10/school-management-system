<div class="box">

	<div class="box-header">

    

    	<!------CONTROL TABS START------->

		<ul class="nav nav-tabs nav-tabs-left">

			<li class="active">

            	<a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> 

					<?php echo get_phrase('manage_staff_attendence');?>

                    	</a></li>

		</ul>

    	<!------CONTROL TABS END------->

        

	</div>

	<div class="box-content padded">

            <!----TABLE LISTING STARTS--->

            <div class="tab-pane  <?php if(!isset($edit_data) && !isset($personal_profile) && !isset($academic_result) )echo 'active';?>" id="list">

				<center>

                <?php $attributes = array('name' => 'myform'); echo form_open('admin/staffattendence', $attributes);?>

                <table border="0" cellspacing="0" cellpadding="0" class="table table-normal box">

                	<tr>

                        <td><?php echo get_phrase('select_department');?></td>

                        <td>&nbsp;</td>
                        
                        <td>&nbsp;</td>

                	</tr>

                	<tr>

                       

                        <td>

                        	<select name="department_id" id="department_id" class=""   style="float:left;">

                                <option value=""><?php echo get_phrase('select_department');?></option>

                                <?php 

                                $departments = $this->db->get('departments')->result_array();

                                foreach($departments as $row):

                                ?>

                                    <option value="<?php echo $row['department_id'];?>"

                                        <?php if($department_id == $row['department_id'])echo 'selected';?>>

                                            <?php echo $row['department_name'];?></option>

                                <?php

                                endforeach;

                                ?>

                            </select>

                        </td>
                        
						<td>

                        	<select name="month" class="" >

                                <option value=""><?php echo get_phrase('select_month');?></option>

                                <?php 

                                $days = $this->db->get('workingdays')->result_array();

                                foreach($days as $row4):

                                ?>

                                    <option value="<?php echo $row4['work_id'];?>"

                                        <?php if($month == $row4['work_id'])echo 'selected';?>>

                                            <?php echo $row4['month'];?></option>

                                <?php

                                endforeach;

                                ?>

                            </select>


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

                

                

                <br /><br />

                

                

                <?php if($department_id >0 && $month > 0):?>

                <?php 

						////CREATE THE MARK ENTRY ONLY IF NOT EXISTS////

						$teachers	=	$this->crud_model->get_dep_teachers($department_id);

						foreach($teachers as $row):

							$verify_data	=	array(	'department_id' => $department_id , 
							
							                            'month' => $month ,

														'user_id' => $row['teacher_id']);

							$query = $this->db->get_where('staff_attendence' , $verify_data);

							

							if($query->num_rows() < 1)

								$this->db->insert('staff_attendence' , $verify_data);

						 endforeach;

				?>
				<?php 
				
				  $verify_data1	=	array('work_id' => $month );
				 
				 $query = $this->db->get_where('workingdays', $verify_data1);
				 
				 $total	=	$query->result_array();
                 echo form_open('admin/staffattendence');
							foreach($total as $row5): 
				?>
                <div align="center"><b><?php echo get_phrase('Total_Working_Days');?></b><b> <input type="number" value="<?php echo $row5['total_days'];?>" name="totaldays"  /></b>
				<input type="hidden" name="working" value="days" />
				<input type="hidden" name="department_id" value="<?php echo $department_id;?>" />
				<input type="hidden" name="month" value="<?php echo $month; ?>" />

                                	<button type="submit" class="btn btn-normal btn-gray"> Update</button>
				</div><br />
				<?php endforeach; ?>
				</form>
                <?php echo form_open('admin/staffattendence');?>
                <table class="table table-normal box" >

                    <thead>

                        <tr>
							<td><?php echo get_phrase('employee_code');?></td>
                            <td><?php echo get_phrase('employee_name');?></td>
                            <td><?php echo get_phrase('Total_Presented_Days');?></td>

                        </tr>

                    </thead>

                    <tbody>

                    	

                        <?php 

						$teachers	=	$this->crud_model->get_dep_teachers($department_id);

						foreach($teachers as $row):

						

							$verify_data	=	array(	'department_id' => $department_id ,
							                            
														'month' => $month ,

														'user_id' => $row['teacher_id']);

														

							$query = $this->db->get_where('staff_attendence' , $verify_data);							 

							$attendence	=	$query->result_array();

							foreach($attendence as $row2):

							?>

                            

							<tr>
								<td align="right">

									<?php echo $row['employee_code'];?>

								</td>
								<td>

									<?php echo $row['name'];?>

								</td>

								<td>

									 <input type="number" value="<?php echo $row2['present'];?>" name="present[]"  min="0" max="<?php echo $row5['total_days'];?>" />
                                    <input type="hidden" name="atten_id[]" value="<?php echo $row2['attendence_id'];?>" />                                 
								</td>
							 </tr>

                             </form>

                         	<?php 

							endforeach;

						 endforeach;

						 ?>

                    <tr>
                        <td></td>
						<td></td>
                        <td style="border:none;">

                            <input type="hidden" name="department_id" value="<?php echo $department_id;?>" />

                            <input type="hidden" name="month" value="<?php echo $month;?>" />

                            <input type="hidden" name="operation" value="update" />

                            <button type="submit" class="btn btn-normal btn-gray"> Update All Data</button>

                        </td>
                        
                    </tr>
                    
                </tbody>

            </table>
            <?php endif;?>

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
	 var cid = document.getElementById('department_id').value;
	 
	 if(cid==''){
		 alert('Please select department!');
		 document.getElementById('department_id').focus();
		 return false;
	 }
	 
	 document.myform.action = "<?php echo base_url() ?>admin/staffattendenceview";
	 document.myform.submit();
 }

</script> 