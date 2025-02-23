<div class="form-group has-feedback">
	<div class="box box-primary">
		<div class="panel-heading" style="padding: 0px 8px;border-bottom: 0px;">
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#student_report" style="font-weight:bold">Student Report</a></li>
				<li class=""><a data-toggle="tab" href="#award_list" style="font-weight:bold">Award List</a></li>          
				<li class=""><a data-toggle="tab" href="#reconciliation_list" style="font-weight:bold">Reconciliation List</a></li>          

			</ul>
		</div>

		<div class="panel-body">
			<div class="tab-content">
				<div class="tab-pane fade active in" id="student_report">
					<div class="col-sm-12" style="padding-top:1%;text-align:center">
						<form name="frmstudent_report" action="<?php echo base_url('admission/student_report') ?>" method="post">
							<div class="box-body">
								<div class="col-lg-2">
									<label>Class </label>
									<select class="form-control" name="class_list" id="class_list">
										<option <?php echo set_select('class_list', 'all', TRUE) ?>>All</option>
										<?php foreach ($aclass as $class) { ?>
											<option value="<?php echo $class->id; ?>" <?php echo set_select('class_list', $class->id); ?>><?php echo $class->class_name; ?></option> 
										<?php } ?>
									</select>
								</div>
								<div class="col-lg-2">
									<label>Section </label>
									<select class="form-control" name="section_list" id="section_list">
										<option <?php echo set_select('section_list', 'all', TRUE) ?>>All</option>
										<?php foreach ($asection as $sec) { ?>
											<option value="<?php echo $sec->id; ?>" <?php echo set_select('section_list', $sec->id); ?>><?php echo $sec->sec_name; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-lg-2">
									<label>Fee Category </label>
									<select class="form-control" name="fee_category" id="fee_category">
										<option <?php echo set_select('section_list', 'all', TRUE) ?>>All</option>
										<?php foreach ($feecategory as $fee) { ?>
											<option value="<?php echo $fee->id; ?>" <?php echo set_select('section_list', $fee->id); ?>><?php echo $fee->cat_name; ?></option>
										<?php } ?>
									</select>
								</div>
								<br>

								<div class="col-lg-8">
									<div class='col-sm-12'>
										<label class="checkbox-inline"><input type="checkbox" name="optradio[1]" value='1' <?php echo set_checkbox('optradio[1]', '1',true); ?>>Admission No</label>
										<label class="checkbox-inline"><input type="checkbox" name="optradio[2]" value='2' <?php echo set_checkbox('optradio[2]', '2',true); ?>>Student Name</label>
										<label class="checkbox-inline"><input type="checkbox" name="optradio[3]"  value='3'<?php echo set_checkbox('optradio[3]', '3'); ?>>Roll</label>
										<label class="checkbox-inline"><input type="checkbox" name="optradio[4]" value='4' <?php echo set_checkbox('optradio[4]', '4'); ?>>Father's Name</label>
										<label class="checkbox-inline"><input type="checkbox" name="optradio[5]" value='5' <?php echo set_checkbox('optradio[5]', '5'); ?>>Mother's Name</label>
									</div>
									<div class='col-sm-12'>    

										<label class="checkbox-inline"><input type="checkbox" name="optradio[6]" value='6' <?php echo set_checkbox('optradio[6]', '6'); ?>>Guardian's Name</label>
										<label class="checkbox-inline"><input type="checkbox" name="optradio[7]" value='7' <?php echo set_checkbox('optradio[7]', '7'); ?>>Contact No</label>
										<label class="checkbox-inline"><input type="checkbox" name="optradio[8]" value='8' <?php echo set_checkbox('optradio[8]', '8'); ?>>Email Address</label>
										<?php if($this->session->userdata('school_id')==43){
											?>
											<label class="checkbox-inline"><input type="checkbox" name="optradio[9]" value='9' <?php echo set_checkbox('optradio[9]', '9'); ?>>Hostel Name</label>
											<label class="checkbox-inline"><input type="checkbox" name="optradio[10]" value='10' <?php echo set_checkbox('optradio[10]', '10'); ?>>Sets</label>
											<label class="checkbox-inline"><input type="checkbox" name="optradio[11]" value='11' <?php echo set_checkbox('optradio[11]', '11'); ?>>Head Master</label>
											<label class="checkbox-inline"><input type="checkbox" name="optradio[12]" value='12' <?php echo set_checkbox('optradio[12]', '12'); ?>>Colour House</label>
											<label class="checkbox-inline"><input type="checkbox" name="optradio[13]" value='13' <?php echo set_checkbox('optradio[13]', '13'); ?>>Akash/ETC</label>
											<label class="checkbox-inline"><input type="checkbox" name="optradio[14]" value='14' <?php echo set_checkbox('optradio[14]', '14'); ?>>Bottle</label>
											<label class="checkbox-inline"><input type="checkbox" name="optradio[15]" value='15' <?php echo set_checkbox('optradio[15]', '15'); ?>>Pl House</label>
											<label class="checkbox-inline"><input type="checkbox" name="optradio[16]" value='16' <?php echo set_checkbox('optradio[16]', '16'); ?>>Medium</label>
											<label class="checkbox-inline"><input type="checkbox" name="optradio[17]" value='17' <?php echo set_checkbox('optradio[17]', '17'); ?>>Reg No</label>
											<label class="checkbox-inline"><input type="checkbox" name="optradio[18]" value='18' <?php echo set_checkbox('optradio[18]', '18'); ?>>Category</label>

										<?php }?>


									</div>
								</div>

							</div>
							<div class="box-body">
								<div class='col-lg-12' style="text-align: center">
									<input type="submit" class="btn btn-info" value='View Report'>
								</div>
							</div>
						</form>
						<div class="box">
							<div class="box-body">
								<form id='frmclass' role="form" method="POST">
									<div class="table-responsive">
										<table id="datalist" class="table table-bordered table-striped">
											<thead>
												<tr>
													<th>S.No.</th>
													<?php foreach ($col as $value) {?>
														<th><?=$value;?></th>
													<?php }?>
													<th>Fee Category</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$i=1;
												foreach ($stud_report as $r) {
													$catt=$r->stud_category;
													$feecatname=$this->dbconnection->select("category", "cat_name", 'id='.$catt);
													$catname=$feecatname[0]->cat_name;
													?>
													<tr>
														<td><?php echo $i;?></td>
														<?php foreach ($col as $key => $value1) {?>
															<td><?=$r->$key;?></td>
														<?php }?>
														<td><?php echo $catname; ?></td>
													</tr>
													<?php $i++;}?>
												</tbody>
											</table>
										</div>
									</form>
								</div>
							</div>
						</div>

					</div>
					<div class="tab-pane fade in" id="award_list">
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

					<div class="tab-pane fade in" id="reconciliation_list">
						<div class="col-md-12">
							<form name="rec_form_list" id="rec_form_list" method="post" action="<?php echo base_url();?>admission/Reconciliation/reconciliation_list">
								<div class="col-md-12">Reconciliation List</div><br><br>                
								<div class="box-body">
									<div class="col-lg-2">
										<label>Class </label>
										<select class="form-control" name="rec_class_list" id="rec_class_list">
											<option value="">Select</option>
											<?php foreach ($aclass as $class) { ?>
												<option value="<?php echo $class->id; ?>" <?php echo set_select('rec_class_list', $class->id); ?>><?php echo $class->class_name; ?></option>
											<?php } ?>
										</select>
									</div>

									<div class="col-lg-2">
										<label>Section </label>
										<select class="form-control" name="rec_section_list" id="rec_section_list">
											<option value="">Select</option>
											<?php foreach ($asection as $sec) { ?>
												<option value="<?php echo $sec->id; ?>" <?php echo set_select('section_list', $sec->id); ?>><?php echo $sec->sec_name; ?></option>
											<?php } ?>
										</select>
									</div>

									<div class="col-lg-2">
										<label>Academic Session </label>
										<select class="form-control" name="rec_academic_session_list" id="rec_academic_session_list">
											<option value="">Select</option>
											<?php foreach ($academic_sessions as $academic_sessions_value) 
											{ ?>
												<option value="<?php echo $academic_sessions_value->id; ?>" <?php echo set_select('rec_academic_session_list', $academic_sessions_value->id); ?>><?php echo $academic_sessions_value->session; ?></option>
											<?php } ?>
										</select>
									</div>

									<div class="col-lg-2">
										<label>Month </label>
										<select class="form-control" name="rec_month" id="rec_month">
											<option value="">Select</option>
											<option value='1'>January</option>
											<option value='2'>February</option>
											<option value='3'>March</option>
											<option value='4'>April</option>
											<option value='5'>May</option>
											<option value='6'>June</option>
											<option value='7'>July</option>
											<option value='8'>August</option>
											<option value='9'>September</option>
											<option value='10'>October</option>
											<option value='11'>November</option>
											<option value='12'>December</option>
										</select>
									</div>
								</div>
								<div class="col-lg-4">
									<input type="submit" class="btn btn-info" id="rec_btn" value='Reconciliation List '>
								</div>
							</form>
						</div>
					</div>
					<div>
						<div class="box-body">
							<div class="table-responsive">
								<table id="reconciliation_report" class="table table-bordered table-striped">									
									<thead>
										<tr>
											<th>S.No.</th>
											<th>S.No.</th>
											<th>S.No.</th>
											<th>S.No.</th>
											<th>S.No.</th>
											<th>S.No.</th>
											<th>S.No.</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<th>S.No.</th>
											<th>S.No.</th>
											<th>S.No.</th>
											<th>S.No.</th>
											<th>S.No.</th>
											<th>S.No.</th>
											<th>S.No.</th>
										</tr>
									</tbody>
								
								</table> 
							</div>
						</div>	
					</div>
				</div>

				<script>
					$(document).ready(function ()
					{
						var table=$('#datalist').DataTable(
						{
							dom: 'Bfrtip',
							"destroy": true,
							"processing": true,
							buttons: [
							{
								extend: 'collection',
								text: 'Export',
								className: 'red',
								buttons: [

								{
									extend: 'excel',
									title: 'Student Report for Class: '+$('#class_list :selected').text()+' and Section: '+$('#section_list :selected').text(),
								},
								{

									extend: 'csv',
									title: 'Student Report for Class: '+$('#class_list :selected').text()+' and Section: '+$('#section_list :selected').text(),
								},
								{
									footer: true,
									extend: 'pdf',
									pageSize: 'A4',
									title: 'Student Report for Class: '+$('#class_list :selected').text()+' and Section: '+$('#section_list :selected').text(),
								},
								{
									footer: true,
									extend: 'print',
									pageSize: 'A4',
									title: 'Student Report for Class: '+$('#class_list :selected').text()+' and Section: '+$('#section_list :selected').text(),
								},

								]
							}

						});
					});
				</script>

				<!-- Reconciliation Student List -->

				<script type="text/javascript">
					$("#rec_form_list").submit(function(e) {
                    e.preventDefault(); // avoid to execute the actual submit of the form.
                    var form = $(this);
                    var url = form.attr('action');
                    
                    $.ajax({
                    	type: "POST",
                    	url: url,
                           data: form.serialize(), // serializes the form's elements.
                           success: function(data)
                           {
                           	console.log(data);
                               // show response from the php script.
                           }
                       });
                });
            </script>