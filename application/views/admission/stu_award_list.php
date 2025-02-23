<div class="form-group has-feedback">
	<div class="box">
		<div class="box-body">
			<div class="row" style="margin-bottom: 10px;">  
				<div class="col-md-12">
					<form name="tc_cft" method="post" action="<?php echo base_url();?>admission/StudentPrint/award_list">
						<div class="col-md-12">Award List</div><br><br>                
						<div class="box-body">
							<div class="col-lg-2">
								<label>Class </label>
								<select class="form-control" name="class_list" id="class_list">
									<option>Select</option>
									<?php foreach ($aclass as $class) { ?>
									<option value="<?php echo $class->id; ?>" <?php echo set_select('class_list', $class->id); ?>><?php echo $class->class_name; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-lg-2">
								<label>Section </label>
								<select class="form-control" name="section_list" id="section_list">
									<option>Select</option>
									<?php foreach ($asection as $sec) { ?>
									<option value="<?php echo $sec->id; ?>" <?php echo set_select('section_list', $sec->id); ?>><?php echo $sec->sec_name; ?></option>
										<?php } ?>
								</select>
							</div>
							<div class="col-lg-4">
								<input type="submit" class="btn btn-info" value='Award List'>
							</div>

						</div>
					</form>
				</div>
			</div>
		</div>
	</div>


</div>