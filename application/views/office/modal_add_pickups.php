<style>
.input_fields_wrap .add_field_button,.remove_field{
	margin:5px;
}
.input_fields_wrap input[type='text']{
	margin-bottom:5px;
}
@media print
{    
    .no-print, .no-print *
    {
        display: none !important;
    }
}
</style>

<div class="tab-pane box active" id="edit" style="padding: 5px">
    <div class="box-content">
      <?php echo form_open('admin/transport/add_pickups/'.$route_id , array('class' => 'form-horizontal validatable','target'=>'_top'));?>
       <div class="input_fields_wrap no-print">
            <button class="add_field_button btn btn-success pull-right">Add More Addresses</button>
            <div><input type="text" name="pickuppoint[]" class="span2 validate[required]" placeholder="Pickup Address"> <input type="text" name="pickuplmark[]" class="span2 validate[required]" placeholder="Pickup Landmark"> <input type="text" name="pickuptime[]" class="span2 validate[required]" placeholder="Pickup Time"></div>
       </div>
       
        <div class="form-actions no-print">
                <button type="submit" class="btn btn-gray"><?php echo get_phrase('add_pickups');?></button>
            </div>
        </form>
       
       
       <table cellpadding="0" cellspacing="0" border="0" class="dTable">
                	<thead>
                		<tr>
                    		<th><div>S.No</div></th>
                    		<th><div><?php echo get_phrase('pickup_point');?></div></th>
                    		<th><div><?php echo get_phrase('landmark');?></div></th>
                            <th><div><?php echo get_phrase('time');?></div></th>
                            <th><div><?php echo get_phrase('actions');?></div></th>
						</tr>
					</thead>
                    <tbody>
                    <?php $s=1; foreach($points_data as $points_view) { ?>
                    	
                        <tr>
                        	<td><?php echo $s ?></td>
                            <td><?php echo $points_view->ppoint ?></td>
                            <td><?php echo $points_view->plmark ?></td>
                            <td><?php echo $points_view->ptime ?></td>
                            <td><a data-pid="<?php echo $points_view->pid ?>" class="btn btn-red btn-small btn-rm-ppoint"><i class="icon-trash"></i> <?php echo get_phrase('delete');?></a></td>
                        </tr>
                    
                    <?php $s++; } ?>
                    </tbody>
                </table>
       
    </div>
</div>

<script>
$(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div><hr><input type="text" name="pickuppoint[]" class="span2 validate[required]" placeholder="Pickup Point"> <input type="text" name="pickuplmark[]" class="span2 validate[required]" placeholder="Pickup Landmark"> <input type="text" name="pickuptime[]" class="span2 validate[required]" placeholder="Pickup Time"><a href="#" class="remove_field btn btn-small btn-danger pull-right">Remove</a></div>'); //add input box
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});


$('.btn-rm-ppoint').on('click',function(){
	
	var r = confirm("Are you sure!");
	
	if (r == true) {
		
		var pid = $(this).data('pid');
		
		$.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>admin/del_tpoint/',
							data: { pid_val:pid  },
							success: function(data) {
								//alert(data);
								if(data=='true'){
									//alert('record deleted successfully!');
								window.location.reload(); 
								} else {
									alert('An error occured while delete,please try again!');
								}
							}
				  });
	} 
	
});


</script>