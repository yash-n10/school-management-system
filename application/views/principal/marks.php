<div class="box">

	<div class="box-header">

    

    	<!------CONTROL TABS START------->

		<ul class="nav nav-tabs nav-tabs-left">

			<li class="active">

            	<a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> 

					<?php echo get_phrase('manage_marks');?>

                    	</a></li>

		</ul>

    	<!------CONTROL TABS END------->

        

	</div>

	<div class="box-content padded">

            <!----TABLE LISTING STARTS--->

            <div class="tab-pane  <?php if(!isset($edit_data) && !isset($personal_profile) && !isset($academic_result) )echo 'active';?>" id="list">

				<center>
    
                <?php 
                    $attributes = array('id' => 'manageMarksForm');
                    echo form_open('principal/marks', $attributes);
                ?>

                <table border="0" cellspacing="0" cellpadding="0" class="table table-normal box">

                	<tr>

                        <td><?php echo get_phrase('select_exam');?></td>

                        <td><?php echo get_phrase('select_class');?></td>

                        <td><?php echo get_phrase('select_subject');?></td>

                        <td>&nbsp;</td>

                	</tr>

                	<tr>

                        <td>

                        	<select name="exam_id" class=""  style="float:left;">

                                <option value=""><?php echo get_phrase('select_an_exam');?></option>

                                <?php 

                                $exams = $this->db->get('exam')->result_array();

                                foreach($exams as $row):

                                ?>

                                    <option value="<?php echo $row['exam_id'];?>"

                                        <?php if($exam_id == $row['exam_id'])echo 'selected';?>>

                                            <?php echo $row['name'];?></option>

                                <?php

                                endforeach;

                                ?>

                            </select>

                        </td>

                        <td>

                        	<select name="class_id" class=""  onchange="show_subjects(this.value)"  style="float:left;">

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

                        	<!-----SELECT SUBJECT ACCORDING TO SELECTED CLASS--------->

							<?php 

                                $classes	=	$this->crud_model->get_classes(); 

                                foreach($classes as $row): ?>

                                

                                <select name="<?php if($class_id == $row['class_id'])echo 'subject_id';else echo 'temp';?>" 

                                      id="subject_id_<?php echo $row['class_id'];?>" 

                                          style="display:<?php if($class_id == $row['class_id'])echo 'block';else echo 'none';?>;" class=""  style="float:left;">

                                  

                                    <option value="">Subject of class <?php echo $row['name'];?></option>

                                    

                                    <?php 

                                    $subjects	=	$this->crud_model->get_subjects_by_class($row['class_id']); 

                                    foreach($subjects as $row2): ?>

                                    <option value="<?php echo $row2['subject_id'];?>"

                                        <?php if(isset($subject_id) && $subject_id == $row2['subject_id'])

                                                echo 'selected="selected"';?>><?php echo $row2['name'];?>

                                    </option>

                                    <?php endforeach;?>

                                    

                                    

                                </select> 

                            <?php endforeach;?>

                            

                            

                            <select name="temp" id="subject_id_0" 

                              style="display:<?php if(isset($subject_id) && $subject_id >0)echo 'none';else echo 'block';?>;" class="" style="float:left;">

                                    <option value="">Select a class first</option>

                            </select>

                        </td>

                        <td>

                        	<input type="hidden" name="operation" value="selection" />

                    		<input type="submit" value="<?php echo get_phrase('manage_marks');?>" class="btn btn-normal btn-gray" />
                            <input type="button" value="<?php echo get_phrase('view_marks');?>" id="cstm_vwmarks" class="btn btn-normal btn-blue" />
                            <script>
							$('#cstm_vwmarks').on('click',function(){
								
								document.getElementById('manageMarksForm').action="principal/marksview";
								document.getElementById('manageMarksForm').submit();
							});
							</script>

                        </td>

                	</tr>

                </table>

                </form>

                </center>

                

                

                <br /><br />

                

                

                <?php if($exam_id >0 && $class_id >0 && $subject_id >0 ):?>

                <?php 

						////CREATE THE MARK ENTRY ONLY IF NOT EXISTS////

						$students	=	$this->crud_model->get_students($class_id);

						foreach($students as $row):

							$verify_data	=	array(	'exam_id' => $exam_id ,

														'class_id' => $class_id ,

														'subject_id' => $subject_id , 

														'student_id' => $row['student_id']);

							$query = $this->db->get_where('mark' , $verify_data);

							

							if($query->num_rows() < 1)

								$this->db->insert('mark' , $verify_data);

						 endforeach;

				?>
                <?php echo form_open('principal/marks');?>
                <table class="table table-normal box" >

                     <tbody>

                        <tr>
							<td><?php echo get_phrase('roll no');?></td>
                            <td><?php echo get_phrase('student');?></td>

                            <td><?php echo get_phrase('mark_obtained');?>(out of <?php echo $grand_total ?>)</td>

                           

                            <td><?php echo get_phrase('comment');?></td>

                 

                        </tr>

                    

                   

                    	

                        <?php 

						$students	=	$this->crud_model->get_students($class_id);

						foreach($students as $row):

						

							$verify_data	=	array(	'exam_id' => $exam_id ,

														'class_id' => $class_id ,

														'subject_id' => $subject_id , 

														'student_id' => $row['student_id']);

														

							$query = $this->db->get_where('mark' , $verify_data);							 

							$marks	=	$query->result_array();

							foreach($marks as $row2):

							?>

                            

							<tr>
								<td align="right">

									<?php echo $row['roll'];?>

								</td>
								<td>

									<?php echo $row['name'];?>

								</td>

								<td>

									 <input type="number" value="<?php echo $row2['mark_obtained'];?>" name="mark_obtained[]"   min="0" max="<?php echo $grand_total ?>" />

												

								</td>

                               

								<td>

									<textarea name="comment[]"><?php echo $row2['comment'];?></textarea>
                                    <input type="hidden" name="mark_id[]" value="<?php echo $row2['mark_id'];?>" />

								</td>

                                

							 </tr>

                             </form>

                         	<?php 

							endforeach;

						 endforeach;

						 ?>

                     
                    <tr>
                        <td></td>

                        <td style="border:none;></td>
                        <td style="border:none;></td>
                        <td style="border:none;></td>
                        <td style="border:none;></td>
                        <td style="border:none;">

                            <input type="hidden" name="exam_id" value="<?php echo $exam_id;?>" />

                            <input type="hidden" name="class_id" value="<?php echo $class_id;?>" />

                            <input type="hidden" name="subject_id" value="<?php echo $subject_id;?>" />              

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

</script> 