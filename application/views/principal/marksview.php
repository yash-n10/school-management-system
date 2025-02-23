<div class="box">

	<div class="box-header">

    

    	<!------CONTROL TABS START------->

		<ul class="nav nav-tabs nav-tabs-left">

			<li class="active">

            	<a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> 

					<?php echo get_phrase('view_marks');?>

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
                    echo form_open('principal/marks',$attributes);
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

                            

                            

                            <!--<select name="temp" id="subject_id_0" 

                              style="display:<?php if(isset($subject_id) && $subject_id >0)echo 'none';else echo 'block';?>;" class="" style="float:left;">

                                    <option value="">Select a class first</option>

                            </select>-->

                        </td>

                        <td>

                        	<input type="hidden" name="operation" value="selection" />

                    		<input type="submit" value="<?php echo get_phrase('manage_marks');?>" class="btn btn-normal btn-gray" />
							
                            <input type="button" value="<?php echo get_phrase('view_marks');?>" id="cstm_vwmarks" class="btn btn-normal btn-gray" />
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

               
                
            
            
            			<table cellpadding="0" cellspacing="0" border="0" class="responsive" id="teacher_dtable">
             					<thead>
                                    <tr>
                                        <th><div><?php echo get_phrase('roll no');?></div></th>
                                        <th><div><?php echo get_phrase('student');?></div></th>
                                        <th><div><?php echo get_phrase('mark_obtained');?>(out of <?php echo $grand_total ?>)</div></th>
                                        <th><div><?php echo get_phrase('comment');?></div></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
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

								<td align="right">

									 <?php echo $row2['mark_obtained'];?>

												

								</td>

                               

								<td>

									<?php echo $row2['comment'];?>

								</td>

                                

							 </tr>

                             </form>

                         	<?php 

							endforeach;

						 endforeach;

						 ?>
              					</tbody>
                       </table>
            
            
            
            <?php endif;?>
            
            <?php if($exam_id >0 && $class_id>0 && $subject_id =='') : ?>
            
           <table cellpadding="0" cellspacing="0" border="0" class="responsive" id="teacher_dtable">
             					<thead>
                                    <tr>
                                        <th><div><?php echo get_phrase('roll no');?></div></th>
                                        <th><div><?php echo get_phrase('student');?></div></th>
                                         <?php
										
										$this->db->where('class_id',$class_id);
										$subdata = $this->db->get_where('subject');	
										$subjects	=	$subdata->result_array();
										foreach($subjects as $subjectview):
										 ?>
                                         <th><div><?php echo $subjectview['name'];?></div></th>
                                        <?php endforeach; ?>
                                        
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                 <?php 

						$students	=	$this->crud_model->get_students($class_id);

						foreach($students as $row):

						

							/*$verify_data	=	array(	'exam_id' => $exam_id ,

														'class_id' => $class_id ,

														'subject_id' => $subject_id , 

														'student_id' => $row['student_id']);

														

							$query = $this->db->get_where('mark' , $verify_data);							 

							$marks	=	$query->result_array();

							foreach($marks as $row2):*/

							?>

                            

							<tr>
								<td align="right">

									<?php echo $row['roll'];?>

								</td>
								<td>

									<?php echo $row['name'];?>

								</td>

								<?php
										
										$this->db->where('class_id',$class_id);
										$subdata = $this->db->get_where('subject');	
										$subjects	=	$subdata->result_array();
										foreach($subjects as $subjectview):
										 ?>
                                         <td align="right">
                                         
										 
										 <?php 
                                         $verify_data	=	array(	'exam_id' => $exam_id ,

														'class_id' => $class_id ,

														'subject_id' => $subjectview['subject_id'] , 

														'student_id' => $row['student_id']);

														

							$query1 = $this->db->get_where('mark' , $verify_data);							 

							$marks1	=	$query1->result_array();
//echo $this->db->last_query();
							foreach($marks1 as $row2):
							
							?>
                               <?php echo $row2['mark_obtained'];?>/<?php echo $grand_total ?>          
                                         
                                         
                                         </td>
                                        <?php endforeach;  endforeach; ?>

                                

							 </tr>

                             </form>

                         	<?php 

							//endforeach;

						 endforeach;

						 ?>
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
<script src="<?php echo base_url(); ?>template/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>template/js/jquery.dataTables.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>template/css/dataTables.tableTools.css">
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>template/js/dataTables.tableTools.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>template/js/dataTables.bootstrap.js"></script>
<script>var $j = jQuery.noConflict(true);</script>
<script>
$(document).ready(function() {
    $j('#teacher_dtable').DataTable( {
		dom: 'T<"clear">lfrtip',
		 tableTools: {
            "sSwfPath": "<?php echo base_url(); ?>template/swf/copy_csv_xls_pdf.swf",
			"aButtons": [
            {
                "sExtends": "copy",
                "mColumns": [0, 1, 2, 3]
            },
            {
                "sExtends": "csv",
                "mColumns": [0, 1, 2, 3]
            },
            {
                "sExtends": "pdf",
                "mColumns": [0, 1, 2, 3]
            },
            {
                "sExtends": "print",
                "mColumns": [0, 1, 2, 3]
            },
        ]
        }
	} );
} );
</script>