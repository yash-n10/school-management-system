<div class="box">
	<div class="box-header">
    
    	<!------CONTROL TABS START------->
		<ul class="nav nav-tabs nav-tabs-left">

			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> 
					<?php echo get_phrase('phrase_list');?>
                    	</a></li>
			<li>
            	<a href="#add" data-toggle="tab"><i class="icon-plus"></i>
					<?php echo get_phrase('add_phrase');?>
                    	</a></li>
			<li class="">
            	<a href="#add_lang" data-toggle="tab"><i class="icon-plus"></i> 
					<?php echo get_phrase('add_language');?>
                    	</a></li>
		</ul>
    	<!------CONTROL TABS END------->
        
	</div>
	<div class="box-content padded">
		<div class="tab-content">
            
            <!----TABLE LISTING STARTS--->
            <div class="tab-pane box active" id="list">
				
                <table cellpadding="0" cellspacing="0" border="0" class="table responsive table-normal">
                	<thead>
                		<tr>
                    		<th><div>#</div></th>
                    		<th><div><?php echo get_phrase('phrase');?></div></th>
                            <?php
								$fields = $this->db->list_fields('language');
								foreach($fields as $field)
								{
									 if($field == 'phrase_id' || $field == 'phrase')continue;
									?>
                                    <th><div><?php echo ucwords($field);?> <button type="submit" class="btn btn-default"><i class="icon-ok-sign"></i></button></div></th>
                                    <?php
								}
							?>
                    		
						</tr>
					</thead>
                    <tbody>
                    	<?php 
						$count = 1;
						foreach($language_phrases as $row)
						{
							$phrase_id	=	$row['phrase_id'];
							?>
							<tr>
								<td><?php echo $count++;?></td>
                                <td><?php echo $row['phrase'];?></td>
								<?php
								$fields = $this->db->list_fields('language');
								foreach($fields as $field)	//$field : english,spanish etc
								{
									if($field == 'phrase_id' || $field == 'phrase')continue;
									?>
                                    <td valign="top">
										<?php $phrase	=	$this->db->get_where('language',array('phrase_id'=>$phrase_id))->row()->$field;?>
                                        <form method="post" action="<?php echo base_url();?>teacher/manage_language/do_update/<?php echo $phrase_id;?>">
                                        	<input type="hidden" name="language" 	value="<?php echo $field;?>" />
                                        	<input type="text" name="phrase" 	value="<?php echo $phrase;?>" style="margin-top:10px;" />
                                        	<button type="submit" class="btn btn-default"><i class="icon-ok-sign"></i></button>
                                        </form>
                                    </td>
                                    <?php
								}
								?>

							</tr>
							<?php 
						}
						?>
                    </tbody>
                </table>
			</div>
            <!----TABLE LISTING ENDS--->
            
            
			<!----PHRASE CREATION FORM STARTS---->
			<div class="tab-pane box" id="add" style="padding: 5px">
                <div class="box-content">
                    <form method="post" action="<?php echo base_url();?>teacher/manage_language/add_phrase/" class="form-horizontal validatable">
                        <div class="padded">
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('phrase');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" name="phrase"/>
                                </div>
                            </div>
                            
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-blue"><?php echo get_phrase('add_phrase');?></button>
                        </div>
                    </form>                
                </div>                
			</div>
			<!----PHRASE CREATION FORM ENDS--->
            
        	<!----ADD NEW LANGUAGE---->
			<div class="tab-pane box" id="add_lang" style="padding: 5px">
                <div class="box-content">
                    <form method="post" action="<?php echo base_url();?>teacher/manage_language/add_language/" class="form-horizontal validatable">
                        <div class="padded">
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('language');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" name="language"/>
                                </div>
                            </div>
                            
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-blue"><?php echo get_phrase('add_language');?></button>
                        </div>
                    </form> 
                </div>
			</div>
            <!----LANGUAGE ADDING FORM ENDS--->
            
		</div>
	</div>
</div>