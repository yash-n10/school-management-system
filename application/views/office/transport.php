<style>
.custom-tam-main-select-block, .custom-tam-table-fee {
	padding:5px 20px;
	-webkit-box-shadow: 0px 0px 3px 1px rgba(0,0,0,0.75);
	-moz-box-shadow: 0px 0px 3px 1px rgba(0,0,0,0.75);
	box-shadow: 0px 0px 3px 1px rgba(0,0,0,0.75);
	margin-bottom:20px;
}
.custom-tam-table-fee {
	padding:5px;
}
.custom-tam-main-select-block .form-horizontal {
	padding-top:15px;
}
.custom-tam-main-select-block .form-horizontal .controls {
	margin-left: 0;
}
.custom-tam-main-select-block .form-horizontal .control-label {
	width:auto;
	padding-right:10px;
}
table#DataTables_Table_0 thead tr th {
	height:65px;
}
table#DataTables_Table_0 .sorting > div:after, table#DataTables_Table_0 .sorting_asc > div:after, table#DataTables_Table_0 .sorting_desc > div:after {
	top:-15px;
}
#main_body {
	//-webkit-filter:blur(0) !important;
}
</style>

<?php	if($this->session->userdata('academic_year')==""){ ?>
	<center>

        <div class="span4" style="float:none !important;">

            <div class="box">

                <div class="box-header">

                    <span class="title"> <i class="icon-info-sign"></i> Please select a class to manage student.</span>

                </div>

                <div class="box-content padded tam-custom-border1">

                    <br />

                    <select name="class_id" onchange="window.location='<?php echo base_url(); ?>admin/transport/'+this.value">

                        <option value=""><?php echo get_phrase('select_a_session'); ?></option>

					<?php
					$academicyear = $this->db->get('academicyear')->result_array();

					foreach ($academicyear as $row):
						?>

                            <option value="<?php echo $row['academic_id']; ?>"

                            <?php if ($this->session->userdata('academic_year') == $row['academic_id']){ echo 'selected';}?>>

                                <?php echo $row['session_name']; ?></option>

                            <?php
                        endforeach;
                        ?>

                    </select>

                    <!--<hr />-->

                  

                </div>

            </div>

        </div>

    </center>
	<?php }else{ ?>
<div class="box">
<div class="box-header"> 
  
  <!------CONTROL TABS START------->
  <ul class="nav nav-tabs nav-tabs-left">
    <li class="active"> <a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> <?php echo get_phrase('transport_list');?> </a></li>
    <li> <a href="#add" data-toggle="tab"><i class="icon-plus"></i> <?php echo get_phrase('add_transport');?> </a></li>
    <li> <a href="#route" data-toggle="tab"><i class="icon-plus"></i> <?php echo get_phrase('route_data');?> </a></li>
    <li> <a href="#addstnd" data-toggle="tab"><i class="icon-plus"></i> <?php echo get_phrase('add_students');?> </a></li>
  </ul>
  <!------CONTROL TABS END-------> 
  
</div>
<div class="box-content padded">
  <div class="tab-content" > 
	
	<center class="custom-tam-cng-sel-block">
	
	<select name="class_id" onchange="window.location='<?php echo base_url(); ?>admin/transport/'+this.value">

                        <option value=""><?php echo get_phrase('select_a_session'); ?></option>

					<?php
					$academicyear = $this->db->get('academicyear')->result_array();

					foreach ($academicyear as $row):
						?>

                            <option value="<?php echo $row['academic_id']; ?>"

                            <?php if ($this->session->userdata('academic_year') == $row['academic_id']){ echo 'selected';}?>>

                                <?php echo $row['session_name']; ?></option>

                            <?php
                        endforeach;
                        ?>

                    </select>
	</center>
	
    <!----TABLE LISTING STARTS--->
    <div class="tab-pane box <?php if(!isset($edit_data))echo 'active';?>" id="list">
      <table cellpadding="0" cellspacing="0" border="0" class="dTable responsive">
        <thead>
          <tr>
            <th><div>S.No</div></th>
            <th><div><?php echo get_phrase('route_name');?></div></th>
            <th><div><?php echo get_phrase('drivername');?></div></th>
            <th><div><?php echo get_phrase('driver_phone_no');?></div></th>
            <th><div><?php echo get_phrase('number_of_vehicle');?></div></th>
            <th><div><?php echo get_phrase('start_point');?></div></th>
            <th><div><?php echo get_phrase('start_time');?></div></th>
            <th><div><?php echo get_phrase('seating_capacity');?></div></th>
            <!--<th><div><?php //echo get_phrase('description');?></div></th>
                    		<th><div><?php //echo get_phrase('route_fare');?></div></th>-->
            
            <th><div><?php echo get_phrase('driver_address');?></div></th>
            <th><div><?php echo get_phrase('options');?></div></th>
          </tr>
        </thead>
        <tbody>
          <?php $count = 1;foreach($transports as $row):?>
          <tr>
            <td><?php echo $count++;?></td>
            <td><?php echo $row['route_name'];?></td>
            <td><?php echo $row['driver_name'];?></td>
            <td><?php echo $row['driver_phone_no'];?></td>
            <td><?php echo $row['number_of_vehicle'];?></td>
            <td><?php echo $row['start_point'];?></td>
            <td><?php echo $row['start_time'];?></td>
            <td><?php echo $row['seating_capacity'];?></td>
            <!--<td><?php //echo $row['description'];?></td>
							<td><?php //echo $row['route_fare'];?></td>-->
            
            <td><?php echo $row['driver_address'];?></td>
            <td align="center"><a data-toggle="modal" href="#modal-form" onclick="modal('add_pickups',<?php echo $row['transport_id'];?>)" class="btn btn-gray btn-small"> <i class="icon-wrench"></i> <?php echo get_phrase('add/view_pickups');?> </a> <a data-toggle="modal" href="#modal-form" onclick="modal('edit_transport',<?php echo $row['transport_id'];?>)" class="btn btn-gray btn-small"> <i class="icon-wrench"></i> <?php echo get_phrase('edit');?> </a> <a data-toggle="modal" href="#modal-delete" onclick="modal_delete('<?php echo base_url();?>admin/transport/delete/<?php echo $row['transport_id'];?>')" class="btn btn-red btn-small"> <i class="icon-trash"></i> <?php echo get_phrase('delete');?> </a></td>
          </tr>
          <?php endforeach;?>
        </tbody>
      </table>
    </div>
    <!----TABLE LISTING ENDS---> 
    
    <!----CREATION FORM STARTS---->
    <div class="tab-pane box" id="add" style="padding: 5px">
      <div class="box-content"> <?php echo form_open('admin/transport/create' , array('class' => 'form-horizontal validatable','target'=>'_top'));?>
        <div class="padded">
          <div class="control-group">
            <label class="control-label"><?php echo get_phrase('route_name');?></label>
            <div class="controls">
              <input type="text" class="validate[required]" placeholder="Route Name" name="route_name"/>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label"><?php echo get_phrase('number_of_vehicle');?></label>
            <div class="controls">
              <input type="text" class="validate[required]" placeholder="Vehicle Number" name="number_of_vehicle"/>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label"><?php echo get_phrase('start_point');?></label>
            <div class="controls">
              <input type="text" class="validate[required]" placeholder="Start Point" name="start_point"/>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label"><?php echo get_phrase('start_time');?></label>
            <div class="controls">
              <input type="text" class="validate[required]" placeholder="Start Time" name="start_time"/>
            </div>
          </div>
          <!-- <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('description');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" placeholder="Vehicle Description" name="description"/>
                                </div>
                            </div>--> 
          <!-- <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('route_fare');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" placeholder="Route Fare" name="route_fare"/>
                                </div>
                            </div>-->
          <div class="control-group">
            <label class="control-label"><?php echo get_phrase('seating_capacity');?></label>
            <div class="controls">
              <input type="text" class="validate[required]" placeholder="Seating Capacity" name="seating_capacity"/>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label"><?php echo get_phrase('driver_name');?></label>
            <div class="controls">
              <input type="text" class="validate[required]" placeholder="Driver Name" name="driver_name"/>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label"><?php echo get_phrase('driver_phone_no');?></label>
            <div class="controls">
              <input type="text" class="validate[required]" placeholder="Driver Phone Number" name="driver_phone_no"/>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label"><?php echo get_phrase('driver_address');?></label>
            <div class="controls">
              <textarea class="validate[required]" placeholder="Driver Address" name="driver_address" style="resize:none" cols="5" rows="5"></textarea>
            </div>
          </div>
        </div>
        <div class="form-actions">
          <button type="submit" class="btn btn-gray"><?php echo get_phrase('add_transport');?></button>
        </div>
        </form>
      </div>
    </div>
    <!----CREATION FORM ENDS---> 
    
    <!----TABLE LISTING STARTS--->
    <div class="tab-pane box " id="route">
      <div class="custom-tam-main-select-block">
        <div class="row-fluid form-horizontal">
          <div class="span6 offset3">
            <div class="control-group">
              <label class="control-label"><?php echo get_phrase('route_name');?></label>
              <div class="controls">
                <select class="validate[required]" name="rdata_id" id="rdata_id">
                  <option value="">---- select route ----</option>
                  <?php foreach($transports as $rdata) { ?>
                  <option value="<?php echo $rdata['transport_id'] ?>"><?php echo $rdata['route_name'] ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span12">
            <div id="custom-route-data"> </div>
          </div>
        </div>
      </div>
    </div>
    <!----TABLE LISTING ENDS---> 
    
    <!----ADD Students STARTS---->
    <div class="tab-pane box" id="addstnd" style="padding: 5px">
      <div class="box-content"> <?php echo form_open('admin/transport/assign_student' , array('class' => 'form-horizontal validatable','target'=>'_top'));?>
        <div class="padded">
          <div class="control-group">
            <label class="control-label"><?php echo get_phrase('route_name');?></label>
            <div class="controls">
              <select class="validate[required]" name="route_id" id="route_id">
                <option value="">---- select route ----</option>
                <?php foreach($transports as $tdata) { ?>
                <option value="<?php echo $tdata['transport_id'] ?>"><?php echo $tdata['route_name'] ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label"><?php echo get_phrase('pickup_address');?></label>
            <div class="controls">
              <select class="validate[required]" name="pa_id" id="pa_id">
                <option value="">---- select route first ----</option>
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

                                            foreach ($classes as $row):
                                        ?>
                <option value="<?php echo $row['class_id']; ?>"> <?php echo $row['name'].'-'.$row['name_numeric']; ?> </option>
                <?php  endforeach; ?>
              </select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label"><?php echo get_phrase('student_name-Roll_no'); ?></label>
            <div class="controls" id="custom-tam-p-stn"> 
              
              <!--SELECT Student ACCORDING TO SELECTED CLASS --> 
              
            </div>
          </div>
          <div class="form-actions">
            <button type="submit" class="btn btn-gray"><?php echo get_phrase('add_students');?></button>
          </div>
          </form>
        </div>
      </div>
      <!----ADD Students ENDS---> 
      
    </div>
  </div>
  </div>
</div>
</div>
<script>
$('#route_id').on('change',function(){
	
	var rid = $(this).val();
	
	if(rid!=''){
		
		$.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>admin/getpoints/',
							data: { route_id:rid },
							success: function(data) {
								//alert(data);
								
								$('#pa_id').text('').append(data);
								
							}
				  });
		
	}
	
});
 $('#class_id').on('change',function(){
	  
	  var p_cid = $(this).val();
	
	
	$.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>admin/ppnt_stn_data/',
							data: { get_p_cid:p_cid },
							success: function(data) {
								//alert(data);
								$('#custom-tam-p-stn').text('').append(data);
								
							}
				  });
  });
  
  $('#rdata_id').on('change',function(){
	  
	  var rdid = $(this).val();
	  
	  //$('#custom-tam-overlay').show();
	  
	  $.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>admin/get_route_data/',
							data: { route_id:rdid },
							success: function(data) {
								
								
								//alert(data);
								
								$('#custom-route-data').text('').append(data);
								
								
								//$('#custom-tam-overlay').hide();
								
								
							}
	 });
	  
  });

  
</script> 
<?php } ?>