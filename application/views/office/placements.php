<div class="box">
	<div class="box-content padded">
    
    	<div class="row-fluid">
        
        		<div class="span12">
                		<div class="custom-tam-hr-frm">
                	    <form class="form-horizontal validatable" method="post" action="<?php echo base_url(); ?>admin/placementinsert">
                        <div class="row-fluid">
                        <div class="span6">
                        <div class="control-group">
                        <label class="control-label" for="placement_title"><?php echo get_phrase('title');?></label>
                        <div class="controls">
                        <input type="text" class="validate[required]" id="placement_title" name="placement_title" placeholder="Please enter title">
                        </div>
                        </div>
                        </div>
                        <div class="span6">
                        <div class="control-group">
                        <label class="control-label" for="placement_date"><?php echo get_phrase('date');?></label>
                        <div class="controls">
                        <input type="text" class="datepicker fill-up validate[required]" id="placement_date" name="placement_date" placeholder="Please enter date">
                        </div>
                        </div>
                        </div>
                        </div>
                        <div class="row-fluid">
                        <div class="span6">
                        <div class="control-group">
                        <label class="control-label" for="placement_company"><?php echo get_phrase('company');?></label>
                        <div class="controls">
                        	<input type="text" name="placement_company" id="placement_company" class="validate[required]" placeholder="Please enter company" />
                               
                        </div>
                        </div>
                        </div>
                        <div class="span6">
                        <div class="control-group">
                        <label class="control-label" for="placement_description"><?php echo get_phrase('description');?></label>
                        <div class="controls">
                        	<textarea name="placement_description" id="placement_description" class="validate[required]" style="resize:none;"></textarea>
                        </div>
                        </div>
                        </div>
                        </div>
                        <div class="row-fluid">
                        <div class="span6">
                        <div class="control-group">
                        <label class="control-label" for="placement_status"><?php echo get_phrase('placement_status');?></label>
                        <div class="controls">
                        	<select name="placement_status" id="placement_status" class="validate[required]">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        </div>
                        </div>
                        <div class="span6">
                        <div class="control-group">
                        <div class="controls">
                        
                        <button type="submit" class="btn btn-lightblue"><?php echo get_phrase('add_placement');?></button>
                        </div>
                        </div>
                        </div>
                        </div>
                        
                        </form>
                        </div>
                
                </div>
        
        </div>
        
        <div class="row-fluid">
        	<div class="span12">
            <?php //print_r($placement_data) ?>
            	    <table class="table table-bordered">
                    		<thead>
                            	<tr>
                                	<th>Title</th>
                                    <th>Date</th>
                                    <th>Company</th>
                                    <th>Status</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($placement_data)) { foreach($placement_data as $placement_data_view) { ?>
                            	<tr>
                                	<td><?php echo $placement_data_view->placement_title ?></td>
                                    <td><?php echo $placement_data_view->placement_date ?></td>
                                    <td><?php echo $placement_data_view->placement_company ?></td>
                                    <td><?php echo ucfirst($placement_data_view->placement_status) ?></td>
                                    <td><a href="<?php echo base_url();?>admin/placementedit/<?php echo $placement_data_view->placement_id ?>">Edit</a></td>
                                    <td><a data-toggle="modal" href="#modal-delete" onclick="modal_delete('<?php echo base_url();?>admin/placementdelete/<?php echo $placement_data_view->placement_id ?>')">Delete</a></td>
                                </tr>
                            <?php } } ?>    
                            </tbody>
                    </table>
            
            </div>
        </div>
		
	</div>
</div>