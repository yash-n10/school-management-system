<div class="box">
	<div class="box-header">
    
    	<!------CONTROL TABS START------->
		<ul class="nav nav-tabs nav-tabs-left">
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> 
					<?php echo get_phrase('book_list');?>
                    	</a></li>

		</ul>
    	<!------CONTROL TABS END------->
        
	</div>
	<div class="box-content padded">
		<div class="tab-content">
            <!----TABLE LISTING STARTS--->
            <div class="tab-pane box <?php if(!isset($edit_data))echo 'active';?>" id="list">
				
                <table cellpadding="0" cellspacing="0" border="0" class="table responsive">
                	<thead>
                		<tr>
                    		<th><div>#</div></th>
                    		<th><div><?php echo get_phrase('book_name');?></div></th>
                    		<th><div><?php echo get_phrase('author');?></div></th>
                    		<th><div><?php echo get_phrase('description');?></div></th>
                    		<th><div><?php echo get_phrase('class');?></div></th>
                            <th><div><?php echo get_phrase('book_category');?></div></th>
                            <th><div><?php echo get_phrase('rest_qty');?></div></th>
                    		<th><div><?php echo get_phrase('status');?></div></th>
                            
						</tr>
					</thead>
                    <tbody>
                    	<?php $count = 1;foreach($books as $row):?>
                        <tr>
                            <td><?php echo $count++;?></td>
							<td><?php echo $row['title'];?></td>
							<td><?php echo $row['author'];?></td>
							<td><?php echo $row['description'];?></td>
							<td><?php //echo $this->crud_model->get_type_name_by_id('class',$row['class_id']);?></td>
                            <td><?php //echo $this->crud_model->get_type_name_by_id('books_category',$row['books_category_id'],'books_category_name');?></td>
                            <td><?php echo $row['rest_qty'];?></td>
							<td><span class="label label-<?php if($row['rest_qty']!='0')echo 'success';else echo 'danger';?>"><?php echo $row['rest_qty'];?></span></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
			</div>
            <!----TABLE LISTING ENDS--->
		</div>
	</div>
</div>