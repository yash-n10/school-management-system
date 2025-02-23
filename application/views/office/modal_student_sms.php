<script>
$(document).ready(function() {
    var text_max = 130;
    $('#rem_chars').html(text_max + ' characters remaining');

    $('#msg_content').keyup(function() {
        var text_length = $('#msg_content').val().length;
        var text_remaining = text_max - text_length;

        $('#rem_chars').html(text_remaining + ' characters remaining');
    });
});
</script>

<?php
$student_info	=	$this->crud_model->get_student_info($current_student_id);

foreach($student_info as $row):?>
<center>
<div class="st_sms_form form-horizontal padded">
<div class = "box">
		<div class="">
            <div class="title custom-tam-profile-block">
                
                    <div>
                        <img src="<?php echo $this->crud_model->get_image_url('student' , $row['student_id']);?>"/>
                    </div>
                    <div>
                        <h4><?php echo $row['name'];?></h4>
                    </div>
                
            </div>
        </div>




<?php echo form_open('admin/sendtoparent/ind_sms');?>


	<div class="control-group">
		<label class="control-label">Mobile No:</label>
		<div class="controls">
			<input type="text" name="par_num" value="<?php echo $row['parent_phone1'];?>">
		</div>
	</div>
	
	<div class="control-group">
	
		<label class="control-label">Student Name</label>
			<div class="controls">
				<input type="text" name="st_name" value="<?php echo "Regarding:".$row['name'];?>">
			</div>
	</div>

	<div class="control-group">
	
		<label class="control-label">Message:</label>

		<div class="controls">
			<textarea name="custom_message" id="msg_content" maxlength="130"></textarea><br/><span id="rem_chars"></span>
		</div>
	</div>
	
	<div>
		<input class="btn btn-red" type="submit" value="send" name="custom_email">
	</div>


</form>

</div>
</div>
<center>
<?php endforeach;?>
