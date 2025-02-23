<div class="tab-pane box active" id="edit" style="padding: 5px">
    <div class="box-content">
        <?php foreach($edit_data as $row):?>
        <?php echo form_open('principal/transport/do_update/'.$row['transport_id'] , array('class' => 'form-horizontal validatable','target'=>'_top'));?>
            <div class="padded">
                <div class="control-group">
                    <label class="control-label"><?php echo get_phrase('route_name');?></label>
                    <div class="controls">
                        <input type="text" class="validate[required]" name="route_name" value="<?php echo $row['route_name'];?>"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"><?php echo get_phrase('number_of_vehicle');?></label>
                    <div class="controls">
                        <input type="text" class="" name="number_of_vehicle" value="<?php echo $row['number_of_vehicle'];?>"/>
                    </div>
                </div>
                <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('start_point');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" placeholder="Start Point" name="start_point" value="<?php echo $row['start_point'];?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('start_time');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" placeholder="Start Time" name="start_time" value="<?php echo $row['start_time'];?>"/>
                                </div>
                            </div>
                <!--<div class="control-group">
                    <label class="control-label"><?php echo get_phrase('description');?></label>
                    <div class="controls">
                        <input type="text" class="" name="description" value="<?php echo $row['description'];?>"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"><?php echo get_phrase('route_fare');?></label>
                    <div class="controls">
                        <input type="text" class="" name="route_fare" value="<?php echo $row['route_fare'];?>"/>
                    </div>
                </div>-->
                 <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('seating_capacity');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" placeholder="Seating Capacity" name="seating_capacity" value="<?php echo $row['seating_capacity'];?>"/>
                                </div>
                            </div>
                  <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('driver_name');?></label>
                                <div class="controls">
                                    <input type="text" class="" name="driver_name" value="<?php echo $row['driver_name'];?>"/>
                                </div>
                            </div>
                 <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('driver_phone_no');?></label>
                                <div class="controls">
                                    <input type="text" class="" name="driver_phone_no" value="<?php echo $row['driver_phone_no'];?>"/>
                                </div>
                            </div>
                 
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('driver_address');?></label>
                                <div class="controls">
                                    <textarea class="" name="driver_address" style="resize:none" cols="5" rows="10"><?php echo $row['driver_address'];?></textarea>
                                </div>
                            </div>
                
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-gray"><?php echo get_phrase('edit_transport');?></button>
            </div>
        </form>
        <?php endforeach;?>
    </div>
</div>