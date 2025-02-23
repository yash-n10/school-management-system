<div class="box">

	<div class="box-header">

    

    	<!------CONTROL TABS START------->

		<ul class="nav nav-tabs nav-tabs-left">

			<li class="active">

            	<a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> 

					<?php //echo get_phrase('manage_marks');?>
                    <?php echo get_phrase('view_marks');?>

                    	</a></li>

		</ul>

    	<!------CONTROL TABS END------->

        

	</div>

	<div class="box-content padded">

            <!----TABLE LISTING STARTS--->

            <div class="tab-pane  <?php if(!isset($edit_data) && !isset($personal_profile) && !isset($academic_result) )echo 'active';?>" id="list">

				<center>

                <?php echo form_open('parents/marks');?>

                <table border="0" cellspacing="0" cellpadding="0" class="table table-normal box">

                	<tr>

                        <td><?php echo get_phrase('select_exam');?></td>

                        <!--<td><?php echo get_phrase('select_subject');?></td>-->

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

                        <!--<td>-->

                        	<!-----SELECT SUBJECT ACCORDING TO SELECTED CLASS--------->

                                <!--<select name="subject_id" >

                                    <option value=""><?php echo get_phrase('select_subject');?></option>

                                    <?php 

                                    $subjects	=	$this->crud_model->get_subjects_by_class($class_id); 

                                    foreach($subjects as $row2): ?>

                                    <option value="<?php echo $row2['subject_id'];?>"

                                        <?php if(isset($subject_id) && $subject_id == $row2['subject_id'])

                                                echo 'selected="selected"';?>><?php echo $row2['name'];?>

                                    </option>

                                    <?php endforeach;?>

                                    

                                    

                                </select>--> 

                            

                            

                        <!--</td>-->

                        <td>

                        	<input type="hidden" name="class_id" value="<?php echo $class_id;?>" />

                        	<input type="hidden" name="operation" value="selection" />

                    		<input type="submit" value="<?php echo get_phrase('view_marks');?>" class="btn btn-normal btn-gray" />

                        </td>

                	</tr>

                </table>

                </form>

                </center>

                

                

                <br /><br />
				<?php if(!empty($marks_data)) { ?>
                <table class="table table-normal box" >

                    <tbody>

                        <tr>

                           <!-- <td><?php echo get_phrase('student');?></td>-->
                            <td><?php echo get_phrase('subject'); ?></td>

                            <td><?php echo get_phrase('mark_obtained');?>(out of <?php echo $grand_total ?>)</td>
                            
                            <td><?php echo get_phrase('result');?></td>

                            <td><?php echo get_phrase('comment');?></td>

                        </tr>


                    
                    		<?php foreach($marks_data as $marks_data_view): ?>
                            <tr>
                            	<td> <?php echo $marks_data_view->name ?></td>
                                <td> <?php echo $marks_data_view->mark_obtained ?></td>
                                
                                <td> <?php  if( $marks_data_view->mark_obtained > $pass_mark ) { echo "<span class='label label-green'>Pass</span>"; } else { echo "<span class='label label-red'>Fail</span>"; } ?></td>
                                
                                <td> <?php echo $marks_data_view->comment ?></td>
                            </tr>
                			<?php endforeach; ?>
                	</tbody>

                  </table>

                <? } ?>

                

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