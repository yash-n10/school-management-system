<div class="box">
	<div class="box-content padded">
    
        <div class="row-fluid">
        	<div class="span12">
            <?php //print_r($placement_data) ?>
            	    <table class="table table-bordered">
                    		<thead>
                            	<tr>
                                	<th>Title</th>
                                    <th>Date</th>
                                    <th>Company</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($placement_data)) { foreach($placement_data as $placement_data_view) { ?>
                            	<tr>
                                	<td><?php echo $placement_data_view->placement_title ?></td>
                                    <td><?php echo $placement_data_view->placement_date ?></td>
                                    <td><?php echo $placement_data_view->placement_company ?></td>
                                   
                                </tr>
                            <?php } } ?>    
                            </tbody>
                    </table>
            
            </div>
        </div>
		
	</div>
</div>