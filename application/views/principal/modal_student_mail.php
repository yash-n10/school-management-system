<?php
$student_info	=	$this->crud_model->get_student_info($current_student_id);

foreach($student_info as $row):?>

<center>
<div class="st_mail_form form-horizontal padded">
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


<?php echo form_open('principal/sendtoparent/mail');?>

	<div class="control-group">
		<label class="control-label">Mail Id:</label>
		<div class="controls">
			<input type="text" name="custom_mail" value="<?php echo $row['parent_email'];?>">
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label">Subject:</label>
		<div class="controls">
			<input type="text" name="custom_sub" value="">
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label">Message:</label>
		<div class="controls">
			<textarea name="pre_message">
			Dear Parent, 
			This mail is regarding <?php echo $row['parent_email'];?>
			<?php echo $row['parent_email'];?>
			<?php echo $row['parent_email'];?>
			</textarea>
		</div>
	</div>
	
          <!---          
	<div class="control-group">
		<label class="control-label">Message:</label>
		<div class="controls">
			<textarea name="custom_message"></textarea>
		</div>
	</div>
          --->          

	<div>
		<input type="submit" value="send" class="btn btn-red" name="custom_email">
	</div>

</form>

</div>
</div>
</center>
<?php endforeach;?>