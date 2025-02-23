<div class="col-md-12" style="height:300px; overflow-y:auto;">

    <table id="student_upload" class="table table-bordered table-striped header-fixed" style="width:100%">
        <thead>
            <tr style="background-color:#dcedc8;">
                <th> SNo</th>
                <th> Admission No</th>
                <th> Student Name</th>
                <th> Attendance</th>
                <th>Period</th>
                <th> Remarks</th>
            </tr>
        </thead>
        <tbody>

                   <?php $i=1; foreach($fetch_student as $stud) { ?>
                <tr> 
                       <input type="hidden" value="<?php echo $stud->id?>" name="astud_id[]">
            <td><?php echo $i; ?></td>
                       <td><?php echo $stud->admission_no;?> </td>
                       <td><?php echo $stud->name;?></td> 
                       <td><label  class="radio-inline"><input type="radio" name="attendance[<?php echo $stud->id?>]" id="attend<?php echo $stud->id?>" value="P" class="rad" <?php if($task=='edit' && $stud->attendance=='P'){ echo 'checked="checked"';} if($task=='add'){echo 'checked="checked"';}?>>Present</label>
                           <label  class="radio-inline"><input type="radio"  name="attendance[<?php echo $stud->id?>]" id="attend1<?php echo $stud->id?>" value="A" class="rad" <?php if($task=='edit' && $stud->attendance=='A'){ echo 'checked="checked"';} ?>>Absent</label>
                           <label  class="radio-inline"><input type="radio" name="attendance[<?php echo $stud->id?>]" id="attend2<?php echo $stud->id?>" value="H" class="rad" <?php if($task=='edit' && $stud->attendance=='H'){ echo 'checked="checked"';}?>>Holiday</label>
                           <BR>
                           Preiods Present:
                          <?php $num=$this->db->query("SELECT id from class_periods")->num_rows();
                           $j = 1;
                           while($j<$num+1){
                            ?>
                            <label><?php echo $j;?></label>
                             <input type="checkbox" id="<?php echo $stud->admission_no; ?>_<?php echo $j?>" name="period[]" value="Period<?php echo $j?>" checked>
                            
                            <?php
                            $j++;
                           }
                           ?>
</td>
                       <td><textarea name="rem[]" class="form-control"><?php if($task=='edit'){ echo $stud->remarks;}?></textarea></td>
            </tr>
                   <?php $i++; } ?>
        </tbody>
    </table>
<!--      <input type="button" class="btn btn-success" id="save_attendance" value="Save Attendance">-->
</div> 



<script>
    $(document).ready(function () {

        var table = $('#student_upload').DataTable({
            "scrollX": true,
            "scrollY": "300px",
            "scrollCollapse": true,
            "paging": false,
            "searching": true

        });


    });


</script>