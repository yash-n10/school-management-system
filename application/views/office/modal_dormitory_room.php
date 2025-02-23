<?php
$students	=	$this->crud_model->get_room_students($droom_id);
//echo "<pre>";print_r($students);exit;
?>
    <center>
        <?php if($students) { ?>
        <table class="table table-normal dormitory-list">
            
                <tr>
                    <th style="color:#fff;"><?php echo get_phrase('roll_no');?></th>
                    <th style="color:#fff;"><?php echo get_phrase('student_name');?></th>
                    <th style="color:#fff;"><?php echo get_phrase('parent_phone_no');?></th>
                    <th style="color:#fff;"><?php echo get_phrase('class');?></th>
                    <th style="color:#fff;"><?php echo get_phrase('room_name');?></th>
                </tr>
            
                <?php foreach ($students as $row): ?>
                <?php $class = $this->crud_model->get_class_name($row['class_id']);?>
                <?php $room = $this->crud_model->get_room_name($row['dormitory_room_number']);?>
                    <tr>
                        <td><?php echo $row['roll']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['parent_phone1']; ?></td>
                        <td><?php echo $class; ?></td>
                        <td><?php echo $room; ?></td>
                    </tr>
                <?php endforeach; ?>
            
            
        </table>
        <?php } else { ?>
        	<p>No one is allocated to this room</p>
        <?php } ?>
    </div>
	</center>