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
					<?php echo get_phrase('add_book');?>
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
                  	<img src="<?php echo base_url();?>template/images/icons/ebooks.png" /><br />
                    <span>Total <?php echo count($ebooks);?> books</span>
                  </a>
                </div>
            </div>
            <div class="tab-pane box active" id="list">
					
                <table cellpadding="0" cellspacing="0" border="0" class="dTable responsive box">
                	<thead>
                		<tr>
                    		<th><div>#</div></th>
                    		<th><div><?php echo get_phrase('Thumbnail');?></div></th>
                    		<th><div><?php echo get_phrase('book_name');?></div></th>
							<th><div><?php echo get_phrase('book_category');?></div></th>
                    		<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php $count = 1;foreach($ebooks as $row):?>
                        <tr>
                            <td><?php echo $count++;?></td>
							<td><img src="<?php echo $this->crud_model->get_image_url('ebook', $row['ebooks_id']); ?>" class="avatar-medium" /><div class="avatar"></div></td>
							<td><?php echo $row['ebooks_name'];?></td>
                            <td><?php $getdata = $this->db->get_where('ebooks_cat', array('ebooks_category_id'=>$row['ebooks_category_id']))->result(); echo $getdata[0]->ebooks_category_name; //echo $this->crud_model->get_type_name_by_id('books_category',$row['books_category_id'],'books_category_name');?></td>
							<td align="center">
                            	<a data-toggle="modal" href="<?php echo base_url();?>admin/editbooks/<?php echo $row['ebooks_id'];?>" <?php /*?>onclick="modal('edit_book',<?php echo $row['ebooks_id'];?>)"<?php */?> class="btn btn-gray btn-small">
                                		<i class="icon-wrench"></i> <?php echo get_phrase('edit');?>
                                </a>
                            	<a data-toggle="modal" href="#modal-delete" onclick="modal_delete('<?php echo base_url();?>admin/ebooks/delete/<?php echo $row['ebooks_id'];?>')"
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
                	<?php echo form_open('admin/ebooks/create' , array('class' => 'form-horizontal validatable', 'enctype' => 'multipart/form-data', 'target'=>'_top'));?>
                        <div class="padded">
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('name');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" name="ebooks_name"/>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('books_category');?></label>
                                <div class="controls"  style="width:210px;">
                                    <select name="ebooks_category_id" class="uniform">
                                    	<?php 
										$ebooks = $this->db->get('ebooks_cat')->result_array();
										foreach($ebooks as $row):
										?>
                                    		<option value="<?php echo $row['ebooks_category_id'];?>"><?php echo $row['ebooks_category_name'];?></option>
                                        <?php
										endforeach;
										?>
                                    </select>
                                </div>
                            </div>
                            
                             <div class="control-group" id="clone-div">
                                <label class="control-label"><?php echo get_phrase('Image Thumb');?></label>
                                <div class="controls"  style="width:210px;">
                                    <input type="file" class="validate[required]" name="ebook_file[]" id="imgInp"/>
                                </div>
                               
                            </div> 
                            <div style="float: left;left: 456px;overflow: hidden;position: absolute;z-index: 999;cursor:pointer;" onclick="return addMore();">Add More</div>
                            <div id="clonediv"></div>
                             <div class="control-group" >
                                <label class="control-label"><?php echo get_phrase('Pdf File');?></label>
                                <div class="controls" style="width:210px;">
                                    <input type="file" class="validate[required]" name="pdf_file" id="imgInp"/>
                                </div>
                            </div>

                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-gray"><?php echo get_phrase('add_book');?></button>
                        </div>
                    </form>                
                </div>                
			</div>
			<!----CREATION FORM ENDS--->
            
		</div>
	</div>
</div>
<script>

    function readURL(input) {

        if (input.files && input.files[0]) {

            var reader = new FileReader();

            

            reader.onload = function (e) {

                $('#blah').attr('src', e.target.result);

            }

            

            reader.readAsDataURL(input.files[0]);

        }

    }

    

    $("#imgInp").change(function(){

        readURL(this);

    });
function addMore(){
  $( "#clone-div" ).clone().appendTo( "#clonediv" ).append("<div onclick='$(this).parent().remove();' style='left:456px;cursor:pointer;position: absolute;'>Remove</div>");
  $(this).append("Helo");
}
</script>