
<link href="<?php echo base_url();?>template/css/bootstrap-select.min.css" media="screen" rel="stylesheet" type="text/css" />

<div class="box">
	<div class="box-header">
    
    	<!------CONTROL TABS START------->
		<ul class="nav nav-tabs nav-tabs-left">
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> 
					<?php echo get_phrase('book_list');?>
                    	</a></li>
			<li>
            	<a href="#add" data-toggle="tab"><i class="icon-plus"></i>
					<?php echo get_phrase('issue_books');?>
                    	</a></li>
		</ul>
    	<!------CONTROL TABS END------->
        
	</div>
	<div class="box-content padded">
		<div class="tab-content">
            <!----TABLE LISTING STARTS--->
            <div class="action-nav-normal">
                <div class="" style="width:300px;margin-left:33%">
                  <a href="#">
                  	<img src="<?php echo base_url();?>template/images/icons/book.png" /><br />
                    <span>Total <?php echo count($books);?> books</span>
                  </a>
                </div>
            </div>
            <div class="tab-pane box active" id="list">
					
                <table cellpadding="0" cellspacing="0" border="0" class="dTable responsive box">
                	<thead>
                		<tr>
                    		<th><div>#</div></th>
                    		<th><div><?php echo get_phrase('book_name');?></div></th>
                    		<th><div><?php echo get_phrase('author');?></div></th>
                    		<th><div><?php echo get_phrase('description');?></div></th>
                    		<th><div><?php echo get_phrase('price');?></div></th>
                    		<th><div><?php echo get_phrase('class');?></div></th>
							<th><div><?php echo get_phrase('book_category');?></div></th>
                    		<th><div><?php echo get_phrase('status');?></div></th>
                            <th><div><?php echo get_phrase('no_of_copies');?></div></th>
                    		<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php $count = 1;foreach($books as $row):?>
                        <tr>
                            <td><?php echo $count++;?></td>
							<td><?php echo $row['name'];?></td>
							<td><?php echo $row['author'];?></td>
							<td><?php echo $row['description'];?></td>
							<td><?php echo $row['price'];?></td>
							<td><?php echo $this->crud_model->get_type_name_by_id('class',$row['class_id']);?></td>
                            <td><?php echo $this->crud_model->get_type_name_by_id('books_category',$row['books_category_id'],'books_category_name');?></td>
							<td><span class="label label-<?php if($row['status']=='available')echo 'green';else echo 'dark-red';?>"><?php echo $row['status'];?></span></td>
                            <td><?php echo $row['no_of_copies'];?></td>
							<td align="center">
                            	<a data-toggle="modal" href="#modal-form" onclick="modal('edit_book',<?php echo $row['book_id'];?>)" class="btn btn-gray btn-small">
                                		<i class="icon-wrench"></i> <?php echo get_phrase('edit');?>
                                </a>
                            	<a data-toggle="modal" href="#modal-delete" onclick="modal_delete('<?php echo base_url();?>principal/book/delete/<?php echo $row['book_id'];?>')"
                                	 class="btn btn-red btn-small">
                                		<i class="icon-trash"></i> <?php echo get_phrase('delete');?>
                                </a>
        					</td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
			</div>
            <!----TABLE LISTING ENDS--->
            
            
			<!----CREATION FORM STARTS---->
			<div class="tab-pane box" id="add" style="padding: 5px">
                <div class="box-content">
               <?php //print_r($avlbooks); ?>
                	<?php echo form_open('principal/book/create' , array('class' => 'form-horizontal validatable','target'=>'_top'));?>
                        <div class="padded">
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('book');?></label>
                                <div class="controls">
                                    <select id="book_no" name="book_no" class="selectpicker" style="width:100%;" data-live-search="true">
                                    	<option value="">--- Select book ---</option>
                                        <?php foreach($avlbooks as $avlbooks_view) { ?>
                                        <option value="<?php echo $avlbooks_view->book_id ?>"><?php echo $avlbooks_view->name." - ".$avlbooks_view->book_id ; ?></option>
                                    	<?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div id="custom-bookissue-binfo">
                            	
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('issue_user_type');?></label>
                                <div class="controls">
                                    <select id="issue_user_type" name="issue_user_type" class="uniform" style="width:100%;">
                                    	<option value="">--- Select type ---</option>
                                       	<option value="student">Student</option>
                                        <option value="teacher">teacher</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('user');?></label>
                                <div class="controls">
                                    <select id="user_id" name="user_id" class="selectpicker" style="width:100%;" data-live-search="true" data-size="10">
                                    	<option value="">--- Select user type first ---</option>
                                        
                                    </select>
                                </div>
                            </div>
                            
                            
                            
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-gray"><?php echo get_phrase('issue_book');?></button>
                        </div>
                    </form>                
                </div>                
			</div>
			<!----CREATION FORM ENDS--->
            
		</div>
	</div>
</div>
<script>
$('#book_no').on('change',function(){
	
	var bookid = $(this).val();
	$.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>principal/getbookinfo',
							data: { bkid:bookid },
							success: function(data) {
								$( "#custom-bookissue-binfo" ).text('').append(data);
								}
				  });
	
});
$('#issue_user_type').on('change',function(){
	var usertype = $(this).val();
	$.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>principal/getuserinfo',
							data: { utype:usertype },
							success: function(data) {
								//alert(data);
								$('#user_id').text('').append(data);
								
								 $('#user_id').selectpicker('refresh');
								 $('#user_id').selectpicker('render');
								}
				  });
});

</script>