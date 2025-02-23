<div class="box">
	<div class="box-header">
    
    	<!------CONTROL TABS START------->
		<ul class="nav nav-tabs nav-tabs-left">
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> 
					<?php echo get_phrase('tasks_view');?>
                    	</a></li>
		</ul>
    	<!------CONTROL TABS END------->
        
	</div>
	<div class="box-content padded">
		<div class="tab-content">
            <!----TABLE LISTING STARTS--->
            <div class="tab-pane box" id="list">
                <table cellpadding="0" cellspacing="0" border="0" class="dTable responsive">
                	<thead>
                		<tr>
                    		<th><div>#</div></th>
                    		<th><div><?php echo get_phrase('title');?></div></th>
                    		<th><div><?php echo get_phrase('description');?></div></th>
                    		<th><div><?php echo get_phrase('start_date');?></div></th>
                    		<th><div><?php echo get_phrase('end_date');?></div></th>
                    		<th><div><?php echo get_phrase('status');?></div></th>
                    		<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php $count = 1;foreach($tasks_data as $tasks_data_view):?>
                        <tr>
                            <td><?php echo $count++;?></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>
								<span class="label label-<?php if($row['status']=='paid')echo 'green';else echo 'dark-red';?>"><?php echo $row['status'];?></span>
							</td>
							<td><a href="<?php echo base_url() ?>student/taskedit/<?php ?>" class="btn btn-lightblue"><i class="icon-edit"></i> Edit</a></td>
							
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
			</div>
            <!----TABLE LISTING ENDS--->
		</div>
	</div>
</div>