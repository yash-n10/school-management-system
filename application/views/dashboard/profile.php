<style>
.form-group{margin-bottom: 10px;} 
fieldset { 
	border: solid 1px #a6a6a6 !important;
	padding: 0 10px 10px 10px;
	border-bottom: none;
	/*    border-radius: 8px;*/
	border-top-left-radius: 25px;
	border-bottom-left-radius: 25px;
	border-top: 2px solid #29a3a3 !important;
}
legend{
	width: auto !important;
	padding:0 10px;
	border: none;
	font-size: 14px;
	font-variant: small-caps;
	letter-spacing: 1px;
	text-decoration: underline;
}
.form-control{
	padding: 6px 5px !important;
	color:darkblue
}
.error-block {
	font-size: 12px;
	color: red;
}
.error-block >p {
	margin: 3px;
}
coll {
	margin-left: 40px;
}

</style>

<link href="<?php echo e(base_url("assets/AdminLTE/plugins/bootstrap-fileinput/bootstrap-fileinput.css")); ?>" rel="stylesheet" type="text/css" />
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<div class="panel  panel-default"> 
	<div class="panel-body">
		<form enctype="multipart/form-data" id="studentdetails" action="" method="post">

			<div class="col-sm-12 col-md-12">

				<div class="row">
					<div class="col-sm-11">

						<div class="panel with-nav-tabs panel-default">
							<div class="panel-heading" style="background-color: #ffffff;border-color:#ffffff;">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#tab1default" data-toggle="tab">Personal</a></li>
									<li><a href="#tab3default" data-toggle="tab">Change password</a></li>
									<!-- <li><a href="#tabs" data-toggle="tab">Change password</a></li> -->
								</ul>
							</div>
							<div class="panel-body">
								<div class="tab-content" id="tab_panell">
								<?php if(!empty($emp)){?>
									<div class="tab-pane fade in active" id="tab1default">
										<div class="col-md-12" style="text-align: right;margin-bottom: 10px">
											<!-- <a class="btn btn-success btn-sm" onclick="showdiv()"><i class="fa fa-edit"></i> Edit</a> -->
										</div>
									

										
										<div class="col-md-9">
											<div class="form-group row">
												<label for="Name" class="col-sm-2 col-form-label">Name</label>
												<div class="col-sm-10"><?php echo $emp[0]->name;?></div>
											</div>
											<div class="form-group row">
												<label for="Joining" class="col-sm-2 col-form-label">Joining Date</label>
												<div class="col-sm-10"><?php echo $emp[0]->doj;?></div>
											</div>
											<div class="form-group row">
												<label for="Gender" class="col-sm-2 col-form-label">Gender</label>
												<div class="col-sm-10">
													<?php  if($emp[0]->gender=='F'){  echo 'Female'; } else if($emp[0]->gender=='M') { echo 'Male';
												} else { }?> </div>
											</div>
											<div class="form-group row">
												<label for="Department" class="col-sm-2 col-form-label">Phone No.</label>
												<div class="col-sm-10"><?php echo $emp[0]->phone_no;?></div>
											</div>
											<div class="form-group row">
												<label for="Department" class="col-sm-2 col-form-label">Department</label>
												<div class="col-sm-10">
													<?php // echo $emp[0]->department_name;?>  
												</div>
											</div>
											<div class="form-group row">
												<label for="Category" class="col-sm-2 col-form-label">Category</label>
												<div class="col-sm-4">
													<select name="category" class="form-control" style="pointer-events: none;" disabled>
														<option value="1" <?php if($emp[0]->category_id=='1'){ echo 'selected';}?>>Teaching Staff</option>
														<option value="2" <?php if($emp[0]->category_id=='2'){ echo 'selected';}?>>Non-Teaching Staff</option>
													</select>
												</div>
												<div class="col-sm-6"></div>
											</div>
											<div class="form-group row">
												<label for="Birth" class="col-sm-2 col-form-label">Date of Birth</label>
												<div class="col-sm-10"><?php echo $emp[0]->dob;?></div>
											</div>
											<div class="form-group row">
												<label for="aadhar" class="col-sm-2 col-form-label">Aadhaar No.</label>
												<div class="col-sm-10"><?php echo $emp[0]->aadhar_id;?></div>
											</div>
											<div class="form-group row">
												<label for="martial" class="col-sm-2 col-form-label">Martial Status</label>
												<div class="col-sm-10"><?php echo $emp[0]->martial_status;?></div>
											</div>
											<div class="form-group row">
												<label for="email" class="col-sm-2 col-form-label">Email</label>
												<div class="col-sm-10"><?php echo $emp[0]->email;?></div>
											</div>
											<div class="form-group row">
												<label for="qualification" class="col-sm-2 col-form-label">Qualification</label>
												<div class="col-sm-10"><?php echo $emp[0]->qualification;?></div>
											</div>
											<div class="form-group row">
												<label for="address" class="col-sm-2 col-form-label">Address</label>
												<div class="col-sm-10">
													<textarea name="address" class="form-control" readonly=""><?php echo $emp[0]->address;?></textarea>
												</div>
											</div>

										</div>
										<div class="col-md-3">
											<div class="fileinput-new thumbnail" style="width: 136px; height:136px;border: 1px solid #ddd;">
												<?php if($emp[0]->photo) { ?>
													<img src="<?php echo e(base_url('/assets/img/pic/'.basename($emp[0]->photo)))?>" alt="Employee Pic" />                                             
												<?php }else{?>
													<img src="<?php echo e(base_url("assets/img/red_user.png")) ?>" alt="" />
												<?php }?>
											</div>
										</div>

											
									</div>
									<div class="col-md-12" id="editdiv" style="display:none">
										<div class="col-md-12" style="text-align: right;margin-bottom: 10px"><a class="btn btn-primary btn-sm" onclick="divpersonal_inf_close()"><i class="fa fa-edit"></i> Back</a></div>
										
									<div class="col-md-3">

										<div class="fileinput fileinput-new" data-provides="fileinput" style="margin-top: 12px;">
											<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;border: 1px solid #ddd;">

												<img src="<?php echo e(base_url("assets/img/red_user.png")) ?>" alt="" /> 


											</div>
											<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
											<div>
												<button class="btn red btn-outline-info btn-file">
													<span class="fileinput-new"> Select image </span>
													<span class="fileinput-exists"> Change </span>
													<input type="file" name="photo" id="photo"> 
													<span class="error-block"></span>
												</button>

												<a href="javascript:;" class="btn red fileinput-exists btn-danger" data-dismiss="fileinput"> Remove </a>
												<!--<a href="javascript:;" class="btn red fileinput-exists btn-success"> Upload </a>-->
											</div>
										</div>
									</div>
								</div>
<?php } else {
echo 'you dont have account in employee';
	}?>
								<div class="tab-pane fade" id="tab3default">
									<!-- <form action="<?php echo base_url('test/passupdate')?>" method="post" id="chgpass"> -->
									<form method="post" id="chgpass">
										<div class="progress" id="progress_per" style="display:none">
										  <div class="progress-bar progress-bar-striped progress-bar-animated active" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width:30%;height:15px;"></div>
									</div>	

									
									
										<div class="form-group row">
											<label for="oldpassword" class="col-sm-2 col-form-label">Old Password</label>
											<div class="col-sm-5"><input type="password" id="oldpass" name="oldpass" class="form-control" onchange="chkoldpass()" required></div>
											<div class="col-sm-5"></div>
										</div>
										<div class="form-group row" style="display:none" id="sent_add">
											<label for="oldpassword" class="col-sm-2 col-form-label">Send otp</label>
											<?php
											$number=123;
											$number=11;
											$number=111;
											$number=011;
											
											$email_dis = $emp[0]->email;
											$phone_no_dis = $emp[0]->phone_no;
											if(($phone_no_dis=='') && ($email_dis==''))
											{
												?>
											<div class="col-sm-5">
												<input type="radio" name="send_address" value="phone" disabled="">Phone</br>
												<input type="radio" name="send_address" value="email" disabled="">Email
											</div>
												<?php 
											}
											else if(($phone_no_dis=='') && ($email_dis!=''))
											{
												?>
											<div class="col-sm-5">
												<input type="radio" name="send_address" value="phone" disabled="">Phone</br>
												<input type="radio" name="send_address" value="email">Email
											</div>
												<?php
											}
											else if(($phone_no_dis!='') && ($email_dis==''))
											{
												?>
											<div class="col-sm-5">
												<input type="radio" name="send_address" value="phone">Phone </br>
												<input type="radio" name="send_address" value="email" disabled="">Email
											</div>
												<?php
											}
											else if(($phone_no_dis=='9876543210') || ($phone_no_dis=='1234567890') || ($phone_no_dis=='0123456789'))
											{
												?>	
											<div class="col-sm-5">
												<input type="radio" name="send_address" value="phone" disabled="">Phone <span style="color:red">Please Enter valid number</span></br>
												<input type="radio" name="send_address" value="email">Email
											</div>
												<?php 
											}												
											else 
											{
												?>
											<div class="col-sm-5">
												<input type="radio" name="send_address" value="phone">Phone </br>
												<input type="radio" name="send_address" value="email">Email
											</div>
												<?php	
											} 
												?>
											
										</div>


										<div class="form-group row">
											<label for="newpassword" class="col-sm-2 col-form-label">New password</label>
											<div class="col-sm-5"><input type="password" id="new_pass" name="new_pass" class="form-control" required></div>  
											<div class="col-sm-5"></div>                                         
										</div>
										<div class="form-group row">
											<label for="cnfpassword" class="col-sm-2 col-form-label">Confirm password</label>
											<div class="col-sm-5"><input type="password" id="cnf_pass" name="cnf_pass" class="form-control" required></div>  
											<div class="col-sm-5"></div>      

										</div>
										<span class="" id="divvaldatepassword" style="display:none;color:red">Please enter same value</span>
										<div class="form-group row">
											<div class="col-sm-4"> </div>
											<!-- <input type="submit" name="" value="Submit" class="btn btn-success" onclick="sendotp()"> -->
											<!-- <a class="btn btn-success" id="otpsub" onclick="senddata()">Submit</a> -->
											<a class="btn btn-success" id="otpsub" onclick="senddata()">Submit</a>
										</div>
									</form>
									<span id="passerror" style="color:red;display:none">Your password is not match</span>
									<span id="passcnf"></span>
									<span class="" id="divvaldate" style="display:none;color:red">Please enter all fields</span>
									
								</div>
							</div>
							<div style="display:none" id="otp_sa">
								<div class="progress" style="height: 15px;">
								  <div class="progress-bar progress-bar-striped progress-bar-animated active" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;height:15px;"></div>
								</div>
								<!-- <form action="<?php echo base_url('test/otpsave') ?>" method="post"> -->
								<form method="post">
									<div class="form-group row">
									
										<label for="cnfpassword" class="col-sm-2 col-form-label">Enter your otp</label>
										<div class="col-sm-5"><input type="text" id="cnf_otp" name="cnf_otp" class="form-control"  required="" onchange="chkotp()">
										</div> 
										<!-- <div id="cone">Time left = <span id="countdown" class="countdown"></span></div>  -->
										<!-- <div id="cone">Time left = <span id="time">02:00</span> minutes!</div> -->
										<div id="cone"><p>Time left = <span id="time" class="time">2:00</span></p> </div>
										 
									</div>
										<span id="otperror" style="color:red;display:none">Your otp is not match</span>
										<span class="" id="divotp" style="display:none;color:red">Please enter otp</span>
										
									<div class="form-group row">
											<div class="col-sm-4"> </div>
											<!-- <input type="submit" name="" id="otpsub" value="Submit" class="btn btn-success"> -->
											<!-- <a class="btn btn-success"  onclick="otpsavee()">Submit</a> -->
										<input type="button" class="btn btn-success" id="otpsavs" value="Submit" onclick="otpsavee()">
										<!-- <input type="button" class="btn btn-success" id="resends" value="Resend" style="display:;" onclick="resendd()"> -->
										<a id="resends" style="display:;" onclick="resendd()">Resend</a>

									</div>
								</form>
							</div>


							<div style="display:none" id="thankyou" style="height: 15px;">	
							<div class="progress">
								  <div class="progress-bar progress-bar-striped progress-bar-animated active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%;height:15px;"></div>
							</div>							
								<div class="col-sm-6 col-md-6 col-md-offset-3">
						            <div class="alert alert-success">
						                <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
						                    ×</button> -->
						               <span class="glyphicon glyphicon-ok"></span> <strong>Congratulations</strong>
						                <hr class="message-inner-separator">
						                <p> Your password successfully changed.</p>
						            </div>
						        </div>
							</div>
						</div>
					</div>


				</div>

			</div>



			<div class="row" style="padding-top:2%">
				<div class="col-lg-12" style="text-align:center"> 
					<a href="<?php echo base_url();?>"><button type="button" class="btn btn-primary" style="width: 120px;font-family: sans-serif;float:left" id="back" ><i class="fa fa-arrow-left"> </i> Back</button></a>


				</div>
			</div>

		</div>
	</form>
</div>
</div>
<script>
	function showdiv()
	{
		$('#tab1default').hide();
		$('#editdiv').show();
	}
	function divpersonal_inf_close()
	{
		$('#tab1default').show();
		$('#editdiv').hide();
	}

	function chkoldpass()
	{
		
		var oldpass=$('#oldpass').val();       
		$.ajax({
			type:'POST',
			data:{oldpass:oldpass},
			url:'<?php echo base_url();?>test/chkoldpass',
			success:function(data)
			{
					console.log(data);
					if(data==1)
					{
						$('#passerror').hide();
						$("#new_pass").attr("readonly", false); 
						$("#cnf_pass").attr("readonly", false); 
						$("#sent_add").show(); 
						$("#progress_per").show(); 
						$('#otpsub').prop('disabled', false);
						$('#divvaldate').hide();
	                	//$('#otpsub').attr('disabled','disabled');
	            }
	            else {         
	            	$('#passerror').show();
	            	$("#new_pass").attr("readonly", true); 
	            	$("#cnf_pass").attr("readonly", true); 
	            	$("#sent_add").hide(); 
	            	$("#progress_per").hide();
	            	$('#otpsub').prop('disabled', true);
	            	$('#divvaldate').hide();
	                //$('#otpsub').attr('disabled','disabled');

	           }
      		}
  			 });
	}

		function chkotp()
		{
			// var user_id=$('#user_id').val();
			// var uname=$('#uname').val();
			var cnf_otp=$('#cnf_otp').val();       
			$.ajax({
				type:'POST',
				// data:{user_id:user_id,uname:uname,cnf_otp:cnf_otp},
				data:{cnf_otp:cnf_otp},
				url:'<?php echo base_url();?>test/chkotp',
				success:function(data)
				{
					console.log(data);
					if(data==1)
					{
						$('#otperror').hide();
						$('#otpsavs').prop('disabled', false);
            	}
		            else {         
		            	$('#otperror').show();            	
		            	$('#otpsavs').prop('disabled', true);
		           }
       			}
   			});

		}

		$('#chgpass').validate({
			rules: {
				oldpass: {
					required: true,            
				},
				new_pass: {
					required: true,
					minlength: 6

				}, 
				cnf_pass: {
					required: true,
					minlength: 6,
					equalTo : "#new_pass"
				},
			}

		});

		function senddata()
		{

			
			var check = true;
	        $("input:radio[name=send_address]").each(function(){
	            var name = $(this).attr("name");
	            if($("input:radio[name=send_address]:checked").length == 0){
	                check = false;
	            }
	        });
	        
	        if(check){
	           	var oldpass=$('#oldpass').val();
				var new_pass=$('#new_pass').val();
				var cnf_pass=$('#cnf_pass').val();
				var send_address=$("input[name=send_address]:checked").val();
				if($('#oldpass').val()=='' || $('#new_pass').val()=='' || $('#cnf_pass').val()=='' )
				{
					$('#divvaldate').show();
				}
				else if ($('#new_pass').val()!=$('#cnf_pass').val())
				{
					$('#divvaldatepassword').show();
				}
				else
				{
					$('#divvaldate').hide();
					$('#divvaldatepassword').hide();
					$.ajax({
							type:'POST',
							data:{oldpass:oldpass,send_address:send_address,new_pass:new_pass},
							url:'<?php echo base_url();?>test/passupdate',
							success:function(data)
							{
		                    console.log(data);
		                    if(data==1)
		                    {
		                        $('#tab_panell').hide();                       
		                        $('#otp_sa').show();
		                         ontime();
		                    }
		                    else {         
		                    	
		                    	$('#tab_panell').show();
		                    	$('#otp_sa').hide();
		                    }
		                }
		            });
				}
	        }
	        else
	        {
	            alert('Please select one option in SEND OTP.');
	        }
			
			
			
            
		}

		function otpsavee()
		{

			// var user_id=$('#user_id').val();
			// var uname=$('#uname').val();
			var cnf_otp=$('#cnf_otp').val();
			$.ajax({
					type:'POST',
					// data:{user_id:user_id,uname:uname,cnf_otp:cnf_otp},
					data:{cnf_otp:cnf_otp},
					url:'<?php echo base_url();?>test/otpsave',
					success:function(data)
					{
                    //console.log(data);
                    if(data==1)
                    {
                        // alert('hi');
                        $('#tab_panell').hide();
                        $('#otp_sa').hide();
                        $('#thankyou').show();
                        $('#divotp').show();
                    }
                    else {         
                    	
                    	$('#tab_panell').show();
                    	$('#otp_sa').hide();
                    	$('#thankyou').hide();
                    	$('#divotp').hide();
                    }
                }
            });
		}

		function resendd()
		{
			// var user_id=$('#user_id').val();
			// var uname=$('#uname').val();
			// var email=$('#email').val();
			// var contact=$('#contact').val();
			
			$.ajax({
					type:'POST',
					url:'<?php echo base_url();?>test/otpresend',
					success:function(data)
					{
                    console.log(data);
                    if(data==1)
                    {
                        // alert('hi');
                        $('#tab3default').hide();
                        $('#cone').hide();
                        $('#time').text('2:00');
                        ontime();
                        $('#cone').show();
                        // $('#otp_sa').hide();
                        // $('#thankyou').show();
                    }
                    else {         
                    	
                    	$('#tab3default').show();
                    	// $('#otp_sa').hide();
                    	// $('#thankyou').hide();
                    }
                }
            });
		}




		function ontime(){
			
					var interval;
				  	clearInterval(interval);
				  	interval = setInterval( function() {
				      var timer = $('.time').html();

				      timer = timer.split(':');
				      var minutes = timer[0];
				      var seconds = timer[1];
				      seconds -= 1;
				      if (minutes < 0)
				      {
				      	return;
				      }
				      else if ((seconds < 0) && (minutes != 0)) 
				      {
				          minutes -= 1;
				          seconds = 59;
				      }
				      else if ((seconds < 10) && (length.seconds != 2))
				      {
					      seconds = '0' + seconds;
					  }
				      $('.time').html(minutes + ':' + seconds);
				      if ((minutes == 0) && (seconds == 0)) 
				      {
				      	clearInterval(interval);
				      }
				  }, 1000);
				
		}

			
//  $('#otpsavs').prop('disabled', true);
// $('#resend').show();
		
		
			
	</script>
	<script src="<?php echo e(base_url("assets/AdminLTE/plugins/bootstrap-fileinput/bootstrap-fileinput.js")); ?>"></script>

