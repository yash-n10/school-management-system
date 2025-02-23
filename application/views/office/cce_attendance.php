<div class="box"> 
  <div class="row-fluid">
    <div class="span12">
      <div class="custom-tam-hr-frm">
        <div class="row-fluid">
          <div class="span4 offset3">
            <div class="control-group">
              <div class="controls">
                <center>
                  <div class="box">
                    <div class="box-header"> <span class="title"> <i class="icon-info-sign"></i> Please select a class to manage exam scheme.</span> </div>
                    <div class="box-content padded tam-custom-border1"> <br />
                      <select name="class_id" onchange="window.location='<?php echo base_url(); ?>admin/cce_attendance/'+this.value">
                        <option value=""><?php echo get_phrase('select_a_class'); ?></option>
                        <?php
						$classes = $this->db->get('class')->result_array();
						foreach ($classes as $row):
							?>
                        <option value="<?php echo $row['class_id']; ?>"
                            <?php if ($class_id == $row['class_id']) echo 'selected'; ?>> <?php echo $row['name'].'-'.$row['name_numeric']; ?></option>
                        <?php
                        endforeach;
                        ?>
                      </select>
                      
                      <!--<hr />--> 
                      
                       
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
      <?php if($class_id){  //print_r($student_data);?>
      <button class="btn btn-info tam-custom-mar-btn-10" id="max_attendance">Set Max Attendance</button>
                 <?php foreach($student_data as $student_data_view) {
						
						$verify_data = array('attendance_class_id' =>$class_id ,'attendance_student_id' => $student_data_view['student_id'] );
						
						$query = $this->db->get_where('cce_attendance',$verify_data);
						
						if($query->num_rows() < 1) $this->db->insert('cce_attendance' , $verify_data);
				 }
				 
				 $qry = $this->db->get('cce_max_attendance');
			
					$data = $qry->row_array();
					
					extract($data);
				 
				  ?>
      
      		<form class="form-horizontal validatable" method="post" action="<?php echo base_url(); ?>admin/cce_attendance_ins/" >
     		<div class="" >
            <table cellpadding="0" cellspacing="0" border="1" class="table">
            		<tr>
                    	<th>S No</th>
                        <th>Student Name</th>
                        <th>Term 1 (Present/Total)</th>
                        <th>Term 2 (Present/Total)</th>
                    </tr>
                    <?php $sno = 1; foreach($student_data as $student_data_view) {
						
						
						$verify_data = array('attendance_class_id' =>$class_id ,'attendance_student_id' => $student_data_view['student_id'] );
						
						$query = $this->db->get_where('cce_attendance',$verify_data);
						
						$attendance = $query->result_array();
						
						foreach($attendance as $attendance_view){
					?>
                    
                    <tr>
                    	<td><?php echo $sno; ?></td>
                        <td><?php echo $student_data_view['name']; ?></td>
                        <td><input type="number" name="term1attendance[]" id="term1attendance_<?php echo $sno; ?>" value="<?php echo $attendance_view['attendance_term1_present'] ?>" max="<?php echo $max_attendance_term1; ?>" min="0" /> / <?php echo $max_attendance_term1; ?></td>
                        <td><input type="number" name="term2attendance[]" id="term2attendance_<?php echo $sno; ?>" value="<?php echo $attendance_view['attendance_term2_present'] ?>" max="<?php echo $max_attendance_term2; ?>" min="0"/> / <?php echo $max_attendance_term2; ?></td>
                    </tr>
                    <input type="hidden" id="attendance_id_<?php echo $sno; ?>" name="attendance_id[]" value="<?php echo $attendance_view['attendance_id'] ?>" />
                    <?php $sno++; } } ?>
            </table>
      		</div>
            <input type="hidden" id="hid_cid" value="<?php echo $class_id ?>" name="hid_cid" />
            <input type="submit" value="Update" id="sbt_update" name="sbt_update" class="btn btn-success" />
            </form>
      <?php } else { ?>
      <script>

                        $(document).ready(function() {

                            function ask()

                            {
                                Growl.info({title:"Select a class to manage cce attendance",text:" "});
                            }

                            setTimeout(ask, 500);

                        });

                    </script>
      <?php } ?>
      <!----TABLE LISTING ENDS---> 
      
    </div>
  </div>
</div>

<script>

$('#max_attendance').on('click',function(e){
	
	$.ajax({
			type: 'POST',
			url: '<?php echo base_url(); ?>admin/cce_max_attendance/gdata',
			success: function(data) {
				
				 $('#custom-tam-model').text('').append(data);
	
			}
	});
	
	e.preventDefault();
	$('#custom-tam-model').modal('show');
});

$(document).on('click','#updatebtn',function(e){
	
	var mat1 = $('#mat1').val();
	
	var mat2 = $('#mat2').val();
	
	if(mat1.trim()==''){
		$('#sms-feedback').text('').append('<div class="alert alert-danger"><strong>Please enter max attendance for term 1!</strong> </div>');
		$('#mat1').focus();
		return true;
	} if(mat2.trim()==''){
		$('#sms-feedback').text('').append('<div class="alert alert-danger"><strong>Please enter max attendance for term 2 !</strong> </div>');
		$('#mat2').focus();
		return true;
	} 
	
	$('#sms-overlay').show();
	$.ajax({
			type: 'POST',
			url: '<?php echo base_url(); ?>admin/cce_max_attendance/udata',
			data:$( '#atd-frm' ).serialize(),
			success: function(data) {
			
				if(data == 'true'){
					$('#sms-feedback').text('').append('<div class="alert alert-success"><strong>Max attendance updated successfully!</strong> </div>');
					$('#atd-frm,#sms-overlay').hide();
					location.reload();
				} else {
					
					$('#sms-feedback').text('').append('<div class="alert alert-danger"><strong>An error while updated max attendance!</strong> Please try again. </div>');
					$('#sms-overlay').hide();
				}

						
			}
	});
	
});

</script>
