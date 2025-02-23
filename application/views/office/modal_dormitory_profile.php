<?php
$students	=	$this->crud_model->get_dormitory_students($dormitory_id);
//echo "<pre>";print_r($students);exit;
?>
    <center>
        <?php if($students) { ?>
        <table class="table table-normal dormitory-list">
            
                <tr>
					<th style="color:#fff;"><?php echo get_phrase('dormitory_id');?></th>
                    <th style="color:#fff;"><?php echo get_phrase('dormitory_name');?></th>
                    <th style="color:#fff;"><?php echo get_phrase('number_of_rooms');?></th>
                    <th style="color:#fff;"><?php echo get_phrase('description');?></th>                   
                </tr>
            
                <?php foreach ($students as $row): ?>
                <?php $class = $this->crud_model->get_class_name($row['class_id']);?>
                <?php $room = $this->crud_model->get_room_name($row['dormitory_room_number']);?>
                    <tr>
                        <!--<td><?php //echo $row['hostel_number']; ?></td>-->
                        <td><?php echo $row['dormitory_id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['number_of_room']; ?></td>
                        <td><?php echo $row['description']; ?></td>                       
                    </tr>
                <?php endforeach; ?>
            
            
        </table>
        <?php } ?>
    </div>
	</center>