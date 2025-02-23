<div class="box">
       <div class="box-header">
        <!------CONTROL TABS START------->

        <ul class="nav nav-tabs nav-tabs-left">
            <li class="active">
                <a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> 
                    <?php echo get_phrase('teacher_contact'); ?>
                </a>
            </li>
        </ul>

        <!------CONTROL TABS END------->
    </div>
    <div class="box-content padded">
		<div class="tab-content">
            <!----TABLE LISTING STARTS--->
            <div class="tab-pane box <?php if(!isset($edit_data))echo 'active';?>" id="list">
                <table cellpadding="0" cellspacing="0" border="0" class="dTable responsive">
                	<thead>
                		<tr>
                                    <th><div>#</div></th>
                                    <th><div><?php echo get_phrase('subject_name');?></div></th>
                                    <th><div><?php echo get_phrase('class');?></div></th>
                                    <th><div><?php echo get_phrase('teacher');?></div></th>
                                    <th><div>Options</div></th>
				</tr>
					</thead>
                    <tbody>
                    	<?php $count = 1;foreach($subjects as $row):
                        $subject_name = $row['name'];
                        $class_name = $this->crud_model->get_type_name_by_id('class',$row['class_id']);
                        $student_name = $student_name;
                        ?>
                        <tr>
                            <td><?php echo $count++;?></td>
                                <td><?php echo $row['name'];?></td>
                                <td><?php echo $this->crud_model->get_type_name_by_id('class',$row['class_id']);?></td>
                                <td><?php echo $this->crud_model->get_type_name_by_id('teacher',$row['teacher_id']);?></td>
                                 <td>
                                     <a data-toggle="modal" href="#modal-form" onclick="modal('teacher_enquiry','<?php echo $row['teacher_id']; ?>',<?php echo $row['subject_id']; ?>)" class="btn btn-default btn-small">
                                      <?php echo get_phrase('Techer_enquiry');?>
                                      </a>
                                      <a  href="<?php echo base_url().'parents/teacher_replay' ?>" class="btn btn-default btn-small">
                                      <?php echo get_phrase('Techer_reply');?>
                                      </a>
                                 </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
                
            </div>
            <!----TABLE LISTING ENDS--->
            </div>
<!----CREATION FORM STARTS---->
	</div>
</div>

