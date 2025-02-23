<div class="box">

	<div class="box-header">

    

    	<!------CONTROL TABS START------->

		<ul class="nav nav-tabs nav-tabs-left">

			<li class="active">

            	<a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> 

					<?php echo get_phrase('monthly_attendence');?>

                    	</a></li>

		</ul>

    	<!------CONTROL TABS END------->

        

	</div>

	<div class="box-content padded">

            <!----TABLE LISTING STARTS--->

            <div class="tab-pane  <?php if(!isset($edit_data) && !isset($personal_profile) && !isset($academic_result) )echo 'active';?>" id="list">

				

                

              
					
                    <?php //print_r($attendence_data); ?>
                     <div id="dataTables">
                    <table class="dTable responsive" >

                    <thead>

                        <tr>
                        	<!--<th><div><?php echo get_phrase('s_no');?></div></th>-->
                            <th><div><?php echo get_phrase('employee_code');?></div></th>
                            <th><div><?php echo get_phrase('month');?></div></th>
							
                            <th><div><?php echo get_phrase('employee_name');?></div></th>
							
                            <th><div><?php echo get_phrase('total_working_days');?></div></th>
                            <th><div><?php echo get_phrase('total_presented_days');?></div></th>
                            <th><div><?php echo get_phrase('total_absent_days');?></div></th>

                

                        </tr>

                    </thead>

                    <tbody>
                    
                    		<?php $sno=1; foreach($attendence_data as $attendence_data_view){ ?>
                            <tr>
                            <!--<td align="right"><?php echo $sno; ?></td>-->
                            <td align="right"><?php echo $attendence_data_view->ecode; ?></td>
                            <td><?php 
									$month = $attendence_data_view->month;
									$tempDate = mktime(0, 0, 0, $month, 1, 2000); 
							
							        echo date("m",$tempDate).' - '.date("F",$tempDate) ; ?></td>
                    		
                            <td><?php echo $attendence_data_view->tname; ?></td>
							
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