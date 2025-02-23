<?php 
error_reporting(0);

?>

<!DOCTYPE HTML>
<html>
	<head>
		<title><?php echo $page_title; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="UTF-8" />

		<link rel="stylesheet" href="<?php echo base_url();?>assets_login/css/style.css" type="text/css" media="all" />
		<link href="<?php echo base_url();?>assets_login/css/font-awesome.min.css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">

		<style type="text/css">
			.error {
				color: red;
				margin: 0px 0px 6px 0px;
				font-size:12px;
			}
    
			.sub-main-w3 form {
				background: #fff !important;
				margin: -2.5em 2.5em -1em;
				-webkit-box-shadow: 0px 0px 0px 0px rgba(16,16,16,.18);
				-moz-box-shadow: 0px 0px 0px 0px rgba(16,16,16,.18);
				box-shadow: 0px 0px 0px 0px rgba(16,16,16,.18);
			}
  
		</style>
  
		<script>
			setTimeout(function() {
				$('.hide').fadeOut('fast');
				}, 5000);
		</script>
	</head>

	<body>
		<div class="main-bg"> 
			<h1><img src="<?php echo base_url();?>assets/AdminLTE/dist/img/fclogo.png"></h1>
    
			<div class="sub-main-w3">
				<div class="bg-content-w3pvt">
						<!--  <div class="top-content-style" style="background:#010d6d;">
								<img src="<?php echo base_url();?>assets/img/8.JPG" alt="FC" style="width: 23%;" />
							</div> -->
					<form action="<?php echo base_url("login/submitLogin") ?>" method="post" id="login">
						<p class="legend">Login Here <!--<span class="fa fa-hand-o-down"></span>--></p>
						<p style="color:red; font-size:14px;" id='error_msg' class="hide"><?php echo $msg; ?></p>
           
						<?php 
							$id=$this->uri->segment(3);
							if($id=='err') {
								echo '<span style="color:red;font-size:12px;" id="error_mdsg" class="hide">Wrong School Code! Please try again. </span>';
							} else {echo '';} ?>
						
						<div class="input">
							<input type="text" placeholder="UserId (SchoolCode-AdmissionNo)" name="username" id="username" />
							<span class="fa fa-user" style="color:#010d6d;"></span>
						</div>
							<!-- <label>dsf</label> -->
						<div class="input">
							<input type="password" placeholder="Password" name="password" required />
							<span class="fa fa-unlock" style="color:#010d6d;"></span>
						</div>
						<button type="submit" class="btn submit" style="background:#010d6d; font-family:calibri">
							<span class="fa fa-sign-in" title="login">&nbsp;&nbsp;Login</span>
						</button>
					</form>
         
		 <!-- <p style='text-align: center;color:white'><a style="text-align:center;font-weight:bold;color:white;" href="<?php echo base_url('Recreate_password/reset_password') ?>">Forgot password?</a></p> -->
					
					<!-- <a href="#" class="bottom-text-w3ls" style="margin-top:10px; vertical-align:middle; ">
						<span style="color: #1cc7d0; vertical-align:middle; ">
							<img src="<?php echo base_url();?>assets_login/images/whatspp.png" style="width:22px; margin-top:0px;">
						</span>

					</a> -->
				</div>
			</div>   
    
			<div class="copyright">
				<h2><span style="font-size: 11px">&copy; 2019 | All rights reserved | Design & Developed by</span>
					<a href="http:www.mildtrix.com" target="_blank" style="color:#e99f06; font-weight:bold;">Mildtrix Business Solution Pvt Ltd</a>
				</h2>
			</div>
		</div>

		<script src="<?php echo base_url();?>assets_login/js/jquery.min.js"></script>
		<script src="<?php echo base_url();?>assets_login/js/jquery.validate.min.js"></script>
		<script src="<?php echo base_url();?>assets_login/js/additional-methods.min.js"></script>

		<script>
			$('#login').validate({
				rules: {
						username: {required: true,},
						password: {required: true,}
				}
			})
		</script> 
	</body>
</html>