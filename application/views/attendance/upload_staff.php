<div class="col-md-12" style="height:300px; overflow-y:scroll">
    <table id="staff_upload" class="table table-bordered table-striped header-fixed" style="width:100%">
         <thead>
             <tr style="background-color:#dcedc8;">
                  <th> SNo</th>
                  <th> Employee Code</th>
                  <th> Employee Name</th>
                  <th> Attendance</th>
                  <th> Remarks</th>
             </tr>
         </thead>
         <tbody>
                
             <?php $i=1; foreach($fetch_staff as $staff) 
             { 
              ?>
             <tr> 
                 <input type="hidden" value="<?php echo $staff->id?>" name="astaff_id[]">
                 <td><?php echo $i; ?></td>
                 <td><?php echo $staff->empl_code;?> </td>
                 <td><?php echo $staff->emp_name;?></td> 
                 <td><label  class="radio-inline"><input type="radio" name="attendance[<?php echo $staff->id?>]" id="attend<?php echo $staff->id?>" value="P" class="rad" <?php if($task=='edit' && $staff->attendance=='P'){ echo 'checked="checked"';} if($task=='add'){echo 'checked="checked"';}?>>Present</label>
                     <label  class="radio-inline"><input type="radio"  name="attendance[<?php echo $staff->id?>]" id="attend1<?php echo $staff->id?>" value="A" class="rad" <?php if($task=='edit' && $staff->attendance=='A'){ echo 'checked="checked"';} ?>>Absent</label>
                     <label  class="radio-inline"><input type="radio" name="attendance[<?php echo $staff->id?>]" id="attend3<?php echo $staff->id?>" value="HF" class="rad" <?php if($task=='edit' && $staff->attendance=='HF'){ echo 'checked="checked"';} ?>>Half Day</label>
                     <label  class="radio-inline"><input type="radio" name="attendance[<?php echo $staff->id?>]" id="attend4<?php echo $staff->id?>" value="H" class="rad" <?php if($task=='edit' && $staff->attendance=='H'){ echo 'checked="checked"';} ?>>Holiday</label>
                 </td>
                 <td><textarea name="rem[]" class="form-control"><?php if($task=='edit'){ echo $staff->remarks;}?></textarea></td>
             </tr>
             <?php $i++; } ?>
         </tbody>
      </table>
</div> 
  

<script>
    $(document).ready(function () {

        var table = $('#staff_upload').DataTable({
            "scrollX": true,
            "scrollY": "300px",
            "scrollCollapse": true,
            "paging": false,
            "searching": true

        });


    });


</script>
