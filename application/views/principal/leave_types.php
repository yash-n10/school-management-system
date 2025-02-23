<div class="box">
	<div class="box-content padded">
    
    	<div class="row-fluid">
        
        		<div class="span12">
                		<div class="custom-tam-hr-frm">
                	    <form class="form-horizontal validatable" method="post" action="<?php echo base_url(); ?>principal/ltypeinsert">
                        <div class="row-fluid">
                        <div class="span6">
                        <div class="control-group">
                        <label class="control-label" for="leave_type_title"><?php echo get_phrase('leave_type_title');?></label>
                        <div class="controls">
                        <input type="text" class="validate[required]" id="leave_type_title" name="leave_type_title" placeholder="Please enter title">
                        </div>
                        </div>
                        </div>
                        <div class="span6">
                        <div class="control-group">
                        <label class="control-label" for="leave_type_code"><?php echo get_phrase('leave_type_code');?></label>
                        <div class="controls">
                        <input type="text" class="validate[required]" id="leave_type_code" name="leave_type_code" placeholder="Please enter code">
                        </div>
                        </div>
                        </div>
                        </div>
                        <div class="row-fluid">
                        <div class="span6">
                        <div class="control-group">
                        <label class="control-label" for="leave_type_max_days"><?php echo get_phrase('max_days_allowed');?></label>
                        <div class="controls">
                        	<input type="number" min="1"  name="leave_type_max_days" id="leave_type_max_days" class="validate[required]" placeholder="Please enter max days" value="1" />
                               
                        </div>
                        </div>
                        </div>
                        <div class="span6">
                        <div class="control-group">
                        <label class="control-label" for="leave_type_status"><?php echo get_phrase('leave_type_status');?></label>
                        <div class="controls">
                        	<select name="leave_type_status" id="leave_type_status" class="uniform validate[required]">
							<option value="">-- Time Table Status --&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        </div>
                        </div>
                        </div>
                        <div class="row-fluid">
                        <div class="span6">
                        <div class="control-group">
                        <label class="control-label" for="half_allow_status"><?php echo get_phrase('half_allow_status');?></label>
                        <div class="controls">
                        	<label class="radio inline">
                            <input type="radio" name="half_allow_status" id="half_allow_status_y" value="Y"> yes
                            </label>
                            <label class="radio inline">
                            <input type="radio" name="half_allow_status" id="half_allow_status_n" value="N" checked="checked"> no
                            </label>
                        </div>
                        </div>
                        </div>
                        <div class="span6">
                        <div class="control-group">
                        <div class="controls">
                        
                        <button type="submit" class="btn btn-lightblue"><?php echo get_phrase('add_leave_type');?></button>
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
            <?php //print_r($ltype_data) ?>
            	    <table class="table table-bordered">
                    		<thead>
                            	<tr>
                                	<th>Title</th>
                                    <th>Code</th>
                                    <th>Max Days</th>
                                    <th>Status</th>
                                    <th>Allow Half Leave <small>(Y-YES / N-NO)</small></th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($ltype_data)) { foreach($ltype_data as $ltype_data_view) { ?>
                            	<tr>
                                	<td><?php echo $ltype_data_view->leave_type_title ?></td>
                                    <td><?php echo $ltype_data_view->leave_type_code ?></td>
                                    <td><?php echo $ltype_data_view->leave_type_max_days ?></td>
                                    <td><?php echo ucfirst($ltype_data_view->leave_type_status) ?></td>
                                    <td><?php echo $ltype_data_view->leave_type_half_allow ?></td>
                                    <td><a href="<?php echo base_url();?>principal/ltypeedit/<?php echo $ltype_data_view->leave_type_id ?>">Edit</a></td>
                                    <td><a data-toggle="modal" href="#modal-delete" onclick="modal_delete('<?php echo base_url();?>principal/ltypedelete/<?php echo $ltype_data_view->leave_type_id ?>')">Delete</a></td>
                                </tr>
                            <?php } } ?>    
                            </tbody>
                    </table>
            
            </div>
        </div>
		
	</div>
</div>