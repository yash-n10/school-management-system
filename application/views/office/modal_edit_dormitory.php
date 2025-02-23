<div class="tab-pane box active" id="edit" style="padding: 5px">
    <div class="box-content">
        <?php foreach($edit_data as $row):?>
        <?php echo form_open('admin/dormitory/do_update/'.$row['dormitory_id'] , array('class' => 'form-horizontal validatable','target'=>'_top'));?>
            <div class="padded">
                <div class="control-group">
                    <label class="control-label"><?php echo get_phrase('dormitory_name');?></label>
                    <div class="controls">
                        <input type="text" class="validate[required]" name="name" value="<?php echo $row['name'];?>" id="dormitory_name"/>
                        <input type="hidden" id="dname_hid" name="dname_hid" value="<?php if(isset($row['name'])) echo $row['name']; ?>" />
                        <span id="val_dname_inc"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"><?php echo get_phrase('number_of_room');?></label>
                    <div class="controls">
                        <input type="text" class="" name="number_of_room" value="<?php echo $row['number_of_room'];?>"/>
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
                <button type="submit" class="btn btn-gray"><?php echo get_phrase('edit_dormitory');?></button>
            </div>
        </form>
        <?php endforeach;?>
    </div>
</div>

<script>
 $('#dormitory_name').on('change',function(){
	 
	
	 	var dname_val =  $(this).val();
		var prv_dname_val =  $('#dname_hid').val();
		
		$('#val_dname_inc').append('<img title="<?php echo base_url(); ?>template/images/loading.gif" src="<?php echo base_url(); ?>template/images/loading.gif">');
		
		$.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>admin/dryname_chk/',
							data: { chkdnameval:dname_val, chkprvdnameval:prv_dname_val },
							success: function(data) {
								//alert(data);
								
								if(data=='true'){
									$("#val_dname_inc").text('').attr("class","label label-warning").text( "'"+ dname_val +" ' already exists try another !" );
									$('#dormitory_name').val(prv_dname_val).focus();
								} else {
									$("#val_dname_inc").removeAttr("class").text('').attr("class","label label-success").text( "'"+ dname_val +"' available !" );
									
								}
								
							}
				  });
  });
</script>