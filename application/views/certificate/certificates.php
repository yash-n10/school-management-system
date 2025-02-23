<div class="form-group has-feedback">
	<div class="box">
		<div class="box-body">
			<div class="row" style="margin-bottom: 10px;">  
				<div class="col-md-12">
					<form name="tc_cft" method="post" action="<?php echo base_url();?>tc_certificate_pdf">
						<div class="col-md-12">Transfer Certificate</div><br><br>                
							<div class="row">
								<div class="col-md-1"></div>
								<div class="col-md-2">
									<label style="text-align: center;"><b>Admission No</b></label>
								</div>
								<div class="col-md-3">
									<select name="transfer_certificate" id="transfer_certificate" class="form-control">
										<option value="">Select Admission No</option>
										<?php foreach ($tc_data as $tc) { ?>
										<option value="<?php echo $tc->id; ?>"> <?php echo $tc->admission_no; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-3"> 
									<input type="submit" class="btn btn-warning" id="tc_gen" value="Generate">
								</div>
							</div><br><br>
						<!-- 	<div class="row">
								<div class="col-md-12">
									<table id="buslist" class="table table-bordered table-striped table-responsive">
										<thead>
											<tr>
												<th> April</th>
												<th> May </th>
												<th> June </th>
												<th> July </th>
												<th> August </th>
												<th> September</th>
												<th> October</th>
												<th> November</th>
												<th> December</th>
												<th> January</th>
												<th> February</th>
												<th> March</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td> 	  
											</tr>
										</tbody>
									</table>
								</div> 
							</div>  -->
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="box">
			<div class="box-body">
				<div class="row">
					<div class="col-md-12">Fee Payment Certificate (Tuition)</div><br><br>
				</div>
				<form name="fee_cft" method="post" action="<?php echo base_url();?>fee_certificate_pdf">
					<div class="row">
						<div class="col-md-1"></div>
						<div class="col-md-1">
							<label>Session</label>
						</div>
						<div class="col-md-3">
							<select name="aca_session" id="aca_session" class="form-control" required="">
								<option value="">Select Session</option>
								<?php foreach ($academic_session as $ses) { ?>
								<option value="<?php echo $ses->id; ?>"> <?php echo $ses->session ; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-md-1">
							<label>Adm. No.</label>
						</div>
						<div class="col-md-3">
							<select name="fee_paid" id="fee_paid" class="form-control" required="">
								<option value="">Select Admission No</option>
								<?php foreach ($fee_data as $fee) { ?>
								<option value="<?php echo $fee->id; ?>"> <?php echo $fee->admission_no ; ?></option>
								<?php } ?>
							</select>
						</div>
						
						<div class="col-md-3">
							<input type="submit" class="btn btn-warning" id="fee_gen" value="Generate"> 
						</div>
					</div> 
				</form>
			</div>
	</div><br><br>
	<div class="box">
		<div class="box-body">
			<div class="row">
				<div class="col-md-12">Bonafied Certificate</div><br><br>
			</div>
			<form name="bfd_cft" method="post" action="<?php echo base_url();?>certificate_pdf">
				<div class="row">
					<div class="col-md-1"></div>
					<div class="col-md-2">
						<label>Admission no</label>
					</div>
					<div class="col-md-3">
						<select name="bonafied_certificate" id="bonafied_certificate" class="form-control">
							<option value="0">Select Admission No</option>
							<?php foreach ($bonafied_data as $bonafied) { ?>
							<option value="<?php echo $bonafied->id; ?>"> <?php echo $bonafied->admission_no; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="col-md-6">
						<input type="submit" class="btn btn-warning" id="bnfd_gen"  value="Generate"> 
					</div>
				</div> 
			</form>
		</div>
	</div>
	<div class="box">
		<div class="box-body">
			<div class="row" style="margin-bottom: 10px;">  
				<div class="col-md-12">
				<form name="slc_cft" method="post" action="<?php echo base_url();?>certificate/Certificate/sls_certificate_pdf">
					<div class="col-md-12">School Leaving Certificate</div><br><br>                
						<div class="row">
							<div class="col-md-1"></div>
							<div class="col-md-2">
								<label style="text-align: center;"><b>Admission No</b></label>
							</div>
							<div class="col-md-3">
								<select name="slc_certificate" id="slc_certificate" class="form-control">
								<option value="0">Select Admission No</option>
								<?php foreach ($bonafied_data as $bonafied) { ?>
								<option value="<?php echo $bonafied->id; ?>"> <?php echo $bonafied->admission_no; ?></option>
								<?php } ?>
								</select>
							</div>
							<div class="col-md-3"> 
								<input type="submit" class="btn btn-warning" id="slc_gen" value="Generate">
							</div>
						</div><br> 
				</form>
				</div>
			</div>
		</div>
	</div>

	<?php if($this->session->userdata('school_id')==29) { ?>
	<div class="box">
		<div class="box-body">
			<div class="row" style="margin-bottom: 10px;">  
				<div class="col-md-12">
					<form name="char_cft" method="post" action="<?php echo base_url();?>certificate/Certificate/character_certificate_pdf">
						<div class="col-md-12">Character Certificate</div><br><br>                
							<div class="row">
								<div class="col-md-1"></div>
								<div class="col-md-2">
									<label style="text-align: center;"><b>Admission No</b></label>
								</div>
								<div class="col-md-3">
									<select name="char_certificate" id="char_certificate" class="form-control">
										<option value="0">Select Admission No</option>
										<?php foreach ($bonafied_data as $bonafied) { ?>
										<option value="<?php echo $bonafied->id; ?>"> <?php echo $bonafied->admission_no; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-3"> 
									<input type="submit" class="btn btn-warning" id="char_cert" value="Generate">
								</div>
							</div><br> 
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
</div>