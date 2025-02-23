<div class="box">

	<div class="box-header">

    

    	<!------CONTROL TABS START------->

		<ul class="nav nav-tabs nav-tabs-left">

			<li class="active">

            	<a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> 

					<?php echo get_phrase('view_daily_attendence');?>

                    	</a></li>

		</ul>

    	<!------CONTROL TABS END------->

        

	</div>

	<div class="box-content padded">

            <!----TABLE LISTING STARTS--->

            <div class="tab-pane  <?php if(!isset($edit_data) && !isset($personal_profile) && !isset($academic_result) )echo 'active';?>" id="list">

				<center>

                <?php $attributes = array('name' => 'daily_attendence_frm'); echo form_open('admin/daily_staff_attendence_view', $attributes);?>

                <table border="0" cellspacing="0" cellpadding="0" class="table table-normal box">

                	<tr>

                        <td><?php echo get_phrase('select_class');?></td>
						<td><?php echo get_phrase('select_date');?></td>
                        <td>&nbsp;</td>

                	</tr>

                	<tr>

                       

                        <td>

                        	<select name="class_id" id="class_id" class=""   style="float:left;">

                                <option value=""><?php echo get_phrase('select_a_class');?></option>
								<option <?php if($class_id=="teaching"){echo 'selected';} ?>  value="teaching">Teaching Staff</option>
								<option <?php if($class_id=="nonteaching"){echo 'selected';} ?>  value="nonteaching">Non Teaching Staff</option>

                            </select>

                        </td>
                        
                        	
                        
                        <td>
                        	
                          <input type="text" name="daily_attendence_date" id="daily_attendence_date" class="datepicker fill-up" value="<?php if(isset($daily_attendence_date)) { echo date("m/d/Y",strtotime($daily_attendence_date)); } ?>">
                        
                        
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

                

                

               
		<?php if(!empty($ad_data)) { ?>
		
        <table class="table table-normal box" id="example" >

                    <tbody>

                        <tr>
                        	
                            <th><?php echo get_phrase('roll no');?></th>
                            <th><?php echo get_phrase('student');?></th>
                        	
                            <th><?php echo get_phrase('status');?></th>
                            <th><?php echo get_phrase('reason');?></th>
                        </tr>
                    
		
		<?php foreach($ad_data as $ad_data_view) {?>
        
        
        		<tr>
                
                	<td><?php echo $ad_data_view->staff_id ?></td>
                	<td><?php echo $ad_data_view->sname ?></td>
                    <td>
                    
                    	<?php if($ad_data_view->present_flag=='P') { echo "PRESENT";  ?> 
                        
                      <?php } else if($ad_data_view->present_flag=='A') { echo "ABSENT"; }  ?></td>
                    <td>
                    
                    	<?php if($ad_data_view->reason_for_absent!='') { echo $ad_data_view->reason_for_absent ;  ?> 
                        
                      <?php } else  { echo "N/A"; }  ?></td>
                   
                    
                </tr>
        
                

		<?php } ?>
        	</tbody>
            </table>
        
        <?php } ?>
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
	 var dad = document.getElementById('daily_attendence_date').value;
	 if(cid==''){
		 alert('Please select class!');
		 document.getElementById('class_id').focus();
		 return false;
	 }
	 if(dad==''){
		 alert('Please select date!');
		 document.getElementById('daily_attendence_date').focus();
		 return false;
	 }
	 document.daily_attendence_frm.action = "<?php echo base_url() ?>admin/daily_attendence_reason";
	 document.daily_attendence_frm.submit();
 }



</script> 
<!--<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>template/TableTools/css/dataTables.tableTools.css">
<script src="<?php echo base_url(); ?>template/js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js" ></script>
<script type="text/javascript" src="<?php echo base_url(); ?>template/TableTools/js/dataTables.tableTools.js"></script>
<script>
$(document).ready(function() {
   $('#example').DataTable( {
		dom: 'T<"clear">lfrtip',
		tableTools: {
			"sSwfPath": "<?php echo base_url(); ?>template/TableTools/swf/copy_csv_xls_pdf.swf"
		}
	});
});
</script>-->
