<div class="box">
	<div class="box-header">
    
    	<!-- CONTROL TABS START-->
		<ul class="nav nav-tabs nav-tabs-left">
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> 
					<?php echo get_phrase('dormitory_list');?>
                    	</a></li>
			<li>
            	<a href="#add" data-toggle="tab"><i class="icon-plus"></i>
					<?php echo get_phrase('add_dormitory');?>
                    	</a></li>
           <li>
                <a href="#rooms_list" data-toggle="tab"><i class="icon-align-justify"></i> 
                    <?php echo get_phrase('rooms_list');?>
                        </a></li>
            <li>
                <a href="#add_room" data-toggle="tab"><i class="icon-plus"></i>
                    <?php echo get_phrase('add_room');?>
                        </a></li>
            <li>
                <a href="#add_student" data-toggle="tab"><i class="icon-plus"></i>
                    <?php echo get_phrase('add_student');?>
                        </a></li>
		</ul>
    	<!-- CONTROL TABS END -->
        
	</div>
	<div class="box-content padded">
		<div class="tab-content">
            <!-- TABLE LISTING STARTS -->
            <div class="tab-pane box <?php if(!isset($edit_data))echo 'active';?>" id="list">
                <table cellpadding="0" cellspacing="0" border="0" class="dTable responsive">
                	<thead>
                		<tr>
                    		<th><div>#</div></th>
                    		<th><div><?php echo get_phrase('dormitory_name');?></div></th>
                    		<th><div><?php echo get_phrase('number_of_room');?></div></th>
                    		<th><div><?php echo get_phrase('description');?></div></th>
                    		<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php $count = 1;foreach($dormitories as $row):?>
                        <tr>
                            <td><?php echo $count++;?></td>
							<td><?php echo $row['name'];?></td>
							<td><?php echo $row['number_of_room'];?></td>
							<td><?php echo $row['description'];?></td>
							<td align="center">
                                <a  data-toggle="modal" href="#modal-form" onclick="modal('dormitory_profile',<?php echo $row['dormitory_id']; ?>)" class="btn btn-lightblue btn-small">

                                    <i class="icon-user"></i> <?php echo get_phrase('view'); ?>

                                </a>
                            	<a data-toggle="modal" href="#modal-form" onclick="modal('edit_dormitory',<?php echo $row['dormitory_id'];?>)" class="btn btn-gray btn-small">
                                		<i class="icon-wrench"></i> <?php echo get_phrase('edit');?>
                                </a>
                            	<a data-toggle="modal" href="#modal-delete" onclick="modal_delete('<?php echo base_url();?>admin/dormitory/delete/<?php echo $row['dormitory_id'];?>')" class="btn btn-red btn-small">
                                		<i class="icon-trash"></i> <?php echo get_phrase('delete');?>
                                </a>
        					</td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
			</div>
            <!-- TABLE LISTING ENDS -->
            
            
			<!-- CREATION FORM STARTS -->
			<div class="tab-pane box" id="add" style="padding: 5px">
                <div class="box-content">
                	<?php echo form_open('admin/dormitory/create' , array('class' => 'form-horizontal validatable','target'=>'_top'));?>
                        <div class="padded">
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('dormitory_name');?></label>
                                <div class="controls">
                                    
                                    <input type="text" class="validate[required]" placeholder="Dormitory Name" name="name" id="dormitory_name"/>
                                    
                                    <span id="val_dname_inc"></span>
                                    
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('number_of_rooms');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" placeholder="No of Rooms" onkeypress="return isNumber1(event)" name="number_of_room"/>
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('description');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" placeholder="Description" name="description"/>
                                </div>

                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-gray"><?php echo get_phrase('add_dormitory');?></button>
                        </div>
                    </form>                
                </div>                
			</div>
			<!-- CREATION FORM ENDS -->

            <!-- TABLE LISTING STARTS -->
            <div class="tab-pane box" id="rooms_list">
                <table cellpadding="0" cellspacing="0" border="0" class="dTable responsive">
                    <thead>
                        <tr>
                            <th><div>#</div></th>
                            <th><div><?php echo get_phrase('dormitory_name');?></div></th>
                            <th><div><?php echo get_phrase('room_name');?></div></th>
                            <th><div><?php echo get_phrase('max_students');?></div></th>
                            <th><div><?php echo get_phrase('description');?></div></th>
                            <th><div><?php echo get_phrase('options');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1;foreach($rooms as $row):?>
                        <?php $dormitory_details = $this->db->get_where('dormitory', array(
                        'dormitory_id' => $row['dormitory_id']
                    ))->result_array();?>
                        <tr>
                            <td><?php echo $count++;?></td>
                            <td><?php echo $dormitory_details[0]['name'];?></td>
                            <td><?php echo $row['name'];?></td>
                            <td><?php echo $row['max_students'];?></td>
                            <td><?php echo $row['description'];?></td>
                            <td align="center">
                                <a  data-toggle="modal" href="#modal-form" onclick="modal('dormitory_room',<?php echo $row['room_id']; ?>)" class="btn btn-lightblue btn-small">

                                    <i class="icon-user"></i> <?php echo get_phrase('view'); ?>

                                </a>
                                <a data-toggle="modal" href="#modal-form" onclick="modal('edit_room',<?php echo $row['room_id'];?>)" class="btn btn-gray btn-small">
                                        <i class="icon-wrench"></i> <?php echo get_phrase('edit');?>
                                </a>
                                <a data-toggle="modal" href="#modal-delete" onclick="modal_delete('<?php echo base_url();?>admin/dormitory/delete_room/<?php echo $row['room_id'];?>')" class="btn btn-red btn-small">
                                        <i class="icon-trash"></i> <?php echo get_phrase('delete');?>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
            <!-- TABLE LISTING ENDS -->

            <!-- CREATION ROOM FORM STARTS -->
            <div class="tab-pane box" id="add_room" style="padding: 5px">
                <div class="box-content">
                    <?php echo form_open('admin/dormitory/create_room' , array('class' => 'form-horizontal validatable','target'=>'_top'));?>
                        <div class="padded">
                            <div class="control-group">

                                <label class="control-label"><?php echo get_phrase('dormitory_name'); ?></label>

                                <div class="controls">

                                    <select name="dormitory_id" id="dormitory_rid" class="uniform" style="width:100%;">

                                        <?php
                                            $dormitories = $this->db->get('dormitory')->result_array();

                                            foreach ($dormitories as $row):
                                        ?>

                                            <option value="<?php echo $row['dormitory_id']; ?>">

                                                <?php echo $row['name']; ?>

                                            </option>

                                            <?php  endforeach; ?>
                                    </select>

                                </div>

                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('room_name');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" placeholder="Room Name" name="name" id="room_name"/>
                                    <span id="val_rname_inc"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('max_students');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" placeholder="Maximum students allowed" name="max_students"/>
                                </div>
                            </div>                        
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('description');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required" placeholder="Description" name="description"/>
                                </div>

                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-gray"><?php echo get_phrase('add_room');?></button>
                        </div>
                    </form>                
                </div>                
            </div>
            <!-- CREATION FORM ENDS -->

            <!-- Assigning Student FORM STARTS -->
            <div class="tab-pane box" id="add_student" style="padding: 5px">
                <div class="box-content">
                    <?php echo form_open('admin/dormitory/assign_student' , array('class' => 'form-horizontal validatable','target'=>'_top'));?>
                        <div class="padded">
                        
                        	<div class="control-group">

                                <label class="control-label"><?php echo get_phrase('dormitory_name'); ?></label>

                                <div class="controls">

                                    <select name="dormitory_id" class="uniform" style="width:100%;" id="dormitory_id">
                                            <option value=""><?php echo get_phrase('select_a_dormitory');?></option>
                                        <?php
                                            $dormitories = $this->db->get('dormitory')->result_array();

                                            foreach ($dormitories as $row):
                                        ?>

                                            <option value="<?php echo $row['dormitory_id']; ?>">

                                                <?php echo $row['name']; ?>

                                            </option>

                                            <?php  endforeach; ?>
                                    </select>

                                </div>

                            </div>
                            <div class="control-group">

                                <label class="control-label"><?php echo get_phrase('room_number'); ?></label>

                                <div class="controls">

                                    <!--SELECT Room ACCORDING TO SELECTED Dormitory -->

                                    <?php 

                                        $dormitories    =   $this->crud_model->get_dormitories(); 

                                        foreach($dormitories as $row):

                                    ?>
                                    <select name="temp" id="room_id_<?php echo $row['dormitory_id'];?>" style="display: none;" class="room_id">

                                  

                                    <option value="">Room of dormitory <?php echo $row['name'];?></option>
                                    <?php 

                                        $rooms   =   $this->crud_model->get_rooms_by_dormitory($row['dormitory_id']); 

                                        foreach($rooms as $row2): 
                                    ?>                                    
                       
                                    <option value="<?php echo $row2['room_id'];?>"

                                        <?php if(isset($room_id) && $room_id == $row2['room_id'])

                                                echo 'selected="selected"';?>><?php echo $row2['name'];?>

                                    </option>


                                    <?php endforeach; ?> 
                                    </select> 

                                    <?php endforeach;?>
                                    <select name="temp" id="room_id_0" 

                                        style="display:<?php if(isset($room_id) && $room_id >0)echo 'none';else echo 'block';?>;" class="room_id" style="float:left;">

                                        <option value="">Select a dormitory first</option>

                                    </select>
                                </div>

                            </div>
                            <div class="control-group">

                                <label class="control-label"><?php echo get_phrase('student_class'); ?></label>

                                <div class="controls">

                                    <select name="class_id" class="uniform" id="class_id" style="width:100%;">

                                        <option value=""><?php echo get_phrase('select_a_class');?></option>
                                        <?php
                                            $classes = $this->db->get('class')->result_array();

                                            foreach ($classes as $row32):
                                        ?>

                                            <option value="<?php echo $row32['class_id']; ?>">

                                                <?php echo $row32['name'].'-'.$row32['name_numeric']; ?>

                                            </option>

                                            <?php  endforeach; ?>

                                    </select>

                                </div>

                            </div>
                            <div class="control-group">

                                <label class="control-label"><?php echo get_phrase('student_name'); ?></label>

                                <div class="controls" id="custom-tam-dmtry-stn">									
                                    <!--SELECT Student ACCORDING TO SELECTED CLASS -->

                                </div>

                            </div>
                            <!--<div class="control-group">
                                <label class="control-label"><?php echo get_phrase('hostel_number');?></label>
                                <div class="controls">
                                    <input type="text" name="hostel_number"/>
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('hostel_fees');?></label>
                                <div class="controls">
                                    <input type="text" class="" name="hostel_fees"/>
                                </div>

                            </div>-->
                        </div>
                        <div class="form-actions">
                            <button type="submit" onclick="return validate_size();" class="btn btn-gray"><?php echo get_phrase('add_student');?></button>
                        </div>
                    </form>                
                </div>                
            </div>
            <!-- Assigning Student FORM ENDS -->
		</div>
	</div>
</div>
<script type="text/javascript">

  $(document).ready(function()
    {
        
        $('#class_id').change(function(){


            var class_id = $('#class_id').val();
            if(class_id != '' && class_id != 0)
            {
                var student_id  = '#student_id_'+class_id;
                $('.student_id').css('display','none').attr('name','temp');
                $(student_id).css('display','block').attr('name','student_id');
                $('#student_id_0').css('display','none');
            }
        });
        
        $('#dormitory_id').change(function(){


            var dormitory_id = $('#dormitory_id').val();
            if(dormitory_id != '' && dormitory_id != 0)
            {
                var room_id  = '#room_id_'+dormitory_id;
                $('.room_id').css('display','none').attr('name','temp');
                $(room_id).css('display','block').attr('name','dormitory_room_number');
                $('#room_id_0').css('display','none');
            }
			
			
        });
		
  });
  
  $('#class_id').on('change',function(){
	  
	  var der_cid = $(this).val();
	//var dormitory_id = $('#dormitory_id').val();
	var room_id  = $('.room_id').val();
//alert(room_id);		
	
	$.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>admin/dor_stn_data/',
							data: { get_der_cid:der_cid,get_der_rid:room_id },
							success: function(data) {
								//alert(data);															
									
								$('#custom-tam-dmtry-stn').text('').append(data);
								
							}
				  });
  });
  $('#dormitory_name').on('change',function(){
	 	var dname_val =  $(this).val();
		
		$('#val_dname_inc').append('<img title="<?php echo base_url(); ?>template/images/loading.gif" src="<?php echo base_url(); ?>template/images/loading.gif">');
		
		$.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>admin/dryname_chk/',
							data: { chkdnameval:dname_val, chkprvdnameval:'' },
							success: function(data) {
								//alert(data);
								
								if(data=='true'){
									$("#val_dname_inc").text('').attr("class","label label-warning").text( "'"+ dname_val +" ' already exists try another !" );
									$('#dormitory_name').val('').focus();
								} else {
									$("#val_dname_inc").removeAttr("class").text('').attr("class","label label-success").text( "'"+ dname_val +"' available !" );
									
								}
								
							}
				  });
  });
  
   $('#room_name').on('change',function(){
	 	var rname_val =  $(this).val();
		var d_id = $('#dormitory_rid').val();
		
		$('#val_rname_inc').append('<img title="<?php echo base_url(); ?>template/images/loading.gif" src="<?php echo base_url(); ?>template/images/loading.gif">');
		
		$.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>admin/rmname_chk/',
							data: { chkrnameval:rname_val, chkprvrnameval:'',chkdid:d_id  },
							success: function(data) {
								//alert(data);
								
								if(data=='true'){
									$("#val_rname_inc").text('').attr("class","label label-warning").text( "'"+ rname_val +" ' already exists try another !" );
									$('#room_name').val('').focus();
								} else {
									$("#val_rname_inc").removeAttr("class").text('').attr("class","label label-success").text( "'"+ rname_val +"' available !" );
									
								}
								
							}
				  });
  });
  $('#dormitory_rid').on('change',function(){
	  $('#room_name').val('').focus();
	  $("#val_rname_inc").text('');
  });


  function isNumber1(evt)
		{
			evt = (evt) ? evt : window.event;
				var charCode = (evt.which) ? evt.which : evt.keyCode;
				if (charCode > 31 && (charCode < 48 || charCode > 57)) {
					return false;
				}
				return true;
		}
	function validate_size()
	{
		j=0;
		var x=document.getElementById("max_students12").value;
		var y=document.getElementById("check_size").value;
		var z=document.getElementById("dty_student_id_"+j).value;
		//document.getElementById('remember').checked
		
		for(i=0;i<y;i++)
		{			
			if(document.getElementById("dty_student_id_"+i).checked)
				j++;			
		}
		if(j>x)
		{
			alert('students exceeded maximum size');
			return false;
		}
	}

</script> 