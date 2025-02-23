<div class="box">
	<div class="box-header">
    
    	<!------CONTROL TABS START------->
		<ul class="nav nav-tabs nav-tabs-left">
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> 
					<?php echo get_phrase('dormitory_list');?>
                    	</a></li>
		</ul>
    	<!------CONTROL TABS END------->
        
	</div>
	<div class="box-content padded">
		<div class="tab-content">
            <!----TABLE LISTING STARTS--->
            <div class="tab-pane box <?php if(!isset($edit_data))echo 'active';?>" id="list">
				<?php if(!empty($dormitories)) { extract($dormitories); } ?>
                <table cellpadding="0" cellspacing="0" border="0" class="dTable responsive">
                	<thead>
                		<tr>
                    		<th><div><?php echo get_phrase('dormitory_name');?></div></th>
                    		<th><div><?php echo get_phrase('number_of_room');?></div></th>
                    		<th><div><?php echo get_phrase('student_name');?></div></th>
                            <th><div><?php echo get_phrase('roll_no');?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	
                        <tr>
							<td><?php echo $dname;?></td>
							<td><?php echo $rname;?></td>
							<td><?php echo $sname;?></td>
                            <td><?php echo $sroll;?></td>
                        </tr>
                       
                    </tbody>
                </table>
			</div>
            <!----TABLE LISTING ENDS--->
		</div>
	</div>
</div>