<div class="box">
	<div class="box-header">
    
    	<!------CONTROL TABS START------->
		<ul class="nav nav-tabs nav-tabs-left">
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> 
					<?php echo get_phrase('things_to_do');?>
                    	</a></li>
		</ul>
    	<!------CONTROL TABS END------->
        
	</div>
	<div class="box-content padded">
    
    	
    
		<div class="tab-content">
        
        
            	<div class="pull-right custom-tam-table-btns">
                	
                    	<a href="<?php echo base_url() ?>admin/taskadd" class="btn btn-small btn-lightblue"><?php echo get_phrase('add_new_thing');?></a>
                
                </div>
            
          
            <!----TABLE LISTING STARTS--->
            <div class="tab-pane box active" id="list">
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
                            <td align="right"><?php echo $count++;?></td>
							<td><?php echo $tasks_data_view->task_title ?></td>
							<td><?php echo $tasks_data_view->task_description ?></td>
							<td><?php echo date("d-m-Y",strtotime($tasks_data_view->task_start_date)) ?></td>
							<td><?php echo date("d-m-Y",strtotime($tasks_data_view->task_end_date)) ?></td>
							<td>
                            <span class="label label-<?php if($tasks_data_view->task_status=='ongoing')echo 'green';else echo 'dark-red';?>"><?php echo get_phrase($tasks_data_view->task_status); ?></span>
                            </td>
                            <td class="center"><a href="<?php echo base_url() ?>admin/taskedit/<?php echo $tasks_data_view->task_id ?>" class="btn btn-small btn-lightblue"><i class="icon-wrench"></i> Edit</a>
                            
                            <a  data-toggle="modal" href="#modal-delete" onclick="modal_delete('<?php echo base_url(); ?>admin/taskdelete/<?php echo $tasks_data_view->task_id ; ?>')" class="btn btn-red btn-small">

                                                            <i class="icon-trash"></i> <?php echo get_phrase('delete'); ?>

                                                        </a>
                            
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
			</div>
            <!----TABLE LISTING ENDS--->
		</div>
	</div>
</div>