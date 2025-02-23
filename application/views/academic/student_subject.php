<div class="box">
    <div class="box-body">   
        <table cellpadding="0" cellspacing="0" border="2"  class="table table-striped table-bordered" id="subjlist">
        	<thead>
        		<tr>
            		<th><div>S.No.</div></th>
            		<th><div><?php echo get_phrase('subject_name');?></div></th>
                   <!--  <th><div><?php echo get_phrase('class');?></div></th>
            		<th><div><?php echo get_phrase('section');?></div></th> -->
            		<th><div><?php echo get_phrase('teacher');?></div></th>
				</tr>
			</thead>
            <tbody>
            	<?php $count = 1;
                foreach($subjects as $row):

                ?>
                <tr>
                    <td><?php echo $count++;?></td>
					<td><?php echo $row->name;?></td>
                  <!--   <td><?php echo $row->class_name;?></td>
					<td><?php echo $row->sec_name;?></td> -->
					<td><?php $teacher = $row->teacher_name; if($teacher){echo $teacher;} else{echo '--N/A--';}?></td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>   
</div>

<script>
$(function ()
{
    $('#subjlist').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true
    });
});
</script>