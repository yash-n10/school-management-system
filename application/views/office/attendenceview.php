<div class="box">

	<div class="box-header">

    

    	<!------CONTROL TABS START------->

		<ul class="nav nav-tabs nav-tabs-left">

			<li class="active">

            	<a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> 

					<?php echo get_phrase('view_attendence');?>

                    	</a></li>

		</ul>

    	<!------CONTROL TABS END------->

        

	</div>

	<div class="box-content padded">

            <!----TABLE LISTING STARTS--->

            <div class="tab-pane  <?php if(!isset($edit_data) && !isset($personal_profile) && !isset($academic_result) )echo 'active';?>" id="list">

				<center>

                <?php $attributes = array('name' => 'myform'); echo form_open('admin/attendence', $attributes);?>

                <table border="0" cellspacing="0" cellpadding="0" class="table table-normal box">

                	<tr>

                        <td><?php echo get_phrase('select_class');?></td>

                        <td>&nbsp;</td>

                	</tr>

                	<tr>

                       

                        <td>

                        	<select name="class_id" id="class_id" class=""   style="float:left;">

                                <option value=""><?php echo get_phrase('select_a_class');?></option>

                                <?php 

                                $classes = $this->db->get('class')->result_array();

                                foreach($classes as $row):

                                ?>

                                    <option value="<?php echo $row['class_id'];?>"

                                        <?php if($class_id == $row['class_id'])echo 'selected';?>>

                                            Class <?php echo $row['name'];?></option>

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
					
                    <?php //print_r($attendence_data); ?>
                     <div id="dataTables">
                    <table class="dTable responsive" >

                    <thead>

                        <tr>
                        	<!--<th><div><?php echo get_phrase('s_no');?></div></th>-->
                            <th><div><?php echo get_phrase('roll_no');?></div></th>
                            <th><div><?php echo get_phrase('month');?></div></th>
							
                            <th><div><?php echo get_phrase('student');?></div></th>
							
                            <th><div><?php echo get_phrase('total_working_days');?></div></th>
                            <th><div><?php echo get_phrase('total_presented_days');?></div></th>
                            <th><div><?php echo get_phrase('total_absent_days');?></div></th>

                

                        </tr>

                    </thead>

                    <tbody>
                    
                    		<?php $sno=1; foreach($attendence_data as $attendence_data_view){ ?>
                            <tr>
                            <!--<td align="right"><?php echo $sno; ?></td>-->
                            <td align="right"><?php echo $attendence_data_view->rno; ?></td>
                            <td><?php 
									$month = $attendence_data_view->month;
									$tempDate = mktime(0, 0, 0, $month, 1, 1900); 
							
							        echo date("m",$tempDate).' - '.date("F",$tempDate) ; ?></td>
                    		
                            <td><?php echo $attendence_data_view->sname; ?></td>
							
                            <td align="right"><?php echo $attendence_data_view->tdays; ?></td>
                            <td align="right"><?php echo $attendence_data_view->present; ?></td>
                            <td align="right"><?php echo ($attendence_data_view->tdays - $attendence_data_view->present); ?></td>
                            </tr>
                            <?php $sno++; } ?>
                    </tbody>
                    </table>
					</div>
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
	 var cid = document.getElementById('class_id').value;
	 
	 if(cid==''){
		 alert('Please select class!');
		 document.getElementById('class_id').focus();
		 return false;
	 }
	 document.myform.action = "<?php echo base_url() ?>admin/attendenceview";
	 document.myform.submit();
 }

</script> 