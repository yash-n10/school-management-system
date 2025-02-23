<div class="tab-pane box active" id="edit" style="padding: 5px">
    <div class="box-content">
        <?php foreach($edit_data as $row):?>
        <?php echo form_open('admin/dormitory/do_room_update/'.$row['room_id'] , array('class' => 'form-horizontal validatable','target'=>'_top'));?>
            <div class="padded">
                <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('dormitory_name');?></label>
                                <div class="controls">
                                    <select name="dormitory_id" id="dormitory_id" class="uniform" style="width:100%;">
                                        <?php 
                                        $dormitories = $this->db->get('dormitory')->result_array();

                                            foreach ($dormitories as $row2):
                                        ?>
                                            <option value="<?php echo $row2['dormitory_id'];?>"
                                                <?php if($row['dormitory_id'] == $row2['dormitory_id'])echo 'selected';?>>
                                                    <?php echo $row2['name'];?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                            </div>
                <div class="control-group">
                    <label class="control-label"><?php echo get_phrase('room_name');?></label>
                    <div class="controls">
                        <input type="text" class="" name="name" value="<?php echo $row['name'];?>" id="room_name"/>
                        <input type="hidden" class="" name="rname_hid" value="<?php echo $row['name'];?>" id="rname_hid"/>
                        <span id="val_rname_inc"></span>
                    </div>
                </div>
                <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('max_students');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" placeholder="Maximum students allowed" name="max_students" value="<?php echo $row['max_students'];?>"/>
                                </div>
                            </div>
                <div class="control-group">
                    <label class="control-label"><?php echo get_phrase('description');?></label>
                    <div class="controls">
                        <input type="text" class="" name="description" value="<?php echo $row['description'];?>"/>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-gray"><?php echo get_phrase('edit_room');?></button>
            </div>
        </form>
        <?php endforeach;?>
    </div>
</div>
<script>
$('#room_name').on('change',function(){
	 	var rname_val =  $(this).val();
		var prv_rname_val =  $('#rname_hid').val();
		var d_id = $('#dormitory_id').val();
		
		$('#val_rname_inc').append('<img title="<?php echo base_url(); ?>template/images/loading.gif" src="<?php echo base_url(); ?>template/images/loading.gif">');
		
		$.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>admin/rmname_chk/',
							data: { chkrnameval:rname_val, chkprvrnameval:prv_rname_val,chkdid:d_id  },
							success: function(data) {
								//alert(data);
								
								if(data=='true'){
									$("#val_rname_inc").text('').attr("class","label label-warning").text( "'"+ rname_val +" ' already exists try another !" );
									$('#room_name').val(prv_rname_val).focus();
								} else {
									$("#val_rname_inc").removeAttr("class").text('').attr("class","label label-success").text( "'"+ rname_val +"' available !" );
									
								}
								
							}
				  });
  });
  $('#dormitory_id').on('change',function(){
	  $('#room_name').val('').focus();
	  $("#val_rname_inc").text('');
  });
</script>