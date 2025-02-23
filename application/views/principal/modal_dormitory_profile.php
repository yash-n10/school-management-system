<?php
$students	=	$this->crud_model->get_dormitory_students($dormitory_id);
//echo "<pre>";print_r($students);exit;
?>
    <center>
        <?php if($students) { ?>
        <table class="table table-normal dormitory-list">
            
                <tr>
                    <!--<th><?php echo get_phrase('hostel_number');?></th>-->
                    <th style="color:#fff;"><?php echo get_phrase('roll_no');?></th>
                    <th style="color:#fff;"><?php echo get_phrase('student_name');?></th>
                    <th style="color:#fff;"><?php echo get_phrase('parent_phone_no');?></th>
                    <th style="color:#fff;"><?php echo get_phrase('class');?></th>
                    <th style="color:#fff;"><?php echo get_phrase('room_name');?></th>
                    <!--<th><?php echo get_phrase('hostel_fees');?></th>-->
                </tr>
            
                <?php foreach ($students as $row): ?>
                <?php $class = $this->crud_model->get_class_name($row['class_id']);?>
                <?php $room = $this->crud_model->get_room_name($row['dormitory_room_number']);?>
                    <tr>
                        <!--<td><?php //echo $row['hostel_number']; ?></td>-->
                        <td><?php echo $row['roll']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['parent_phone1']; ?></td>
                        <td><?php echo $class; ?></td>
                        <td><?php echo $room; ?></td>
                        <!--<td><?php //echo $row['hostel_fees']; ?></td>-->
                    </tr>
                <?php endforeach; ?>
            
            
        </table>
        <?php } ?>
    </div>
	</center>