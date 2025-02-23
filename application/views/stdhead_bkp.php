<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?php include 'application/views/includes.php';?>
  <title><?php echo $page_title;?> | <?php echo $system_title;?></title>

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url(''); ?>/assets/AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(''); ?>/assets/AdminLTE/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url(''); ?>/assets/AdminLTE/bower_components/Ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url(''); ?>/assets/AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(''); ?>/assets/AdminLTE/plugins/datatables-plugins/buttons.dataTables.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(''); ?>/assets/AdminLTE/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url(''); ?>/assets/AdminLTE/dist/css/skins/skin-yellow-light.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php echo base_url(''); ?>/assets/AdminLTE/bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo base_url(''); ?>/assets/AdminLTE/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo base_url(''); ?>/assets/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url(''); ?>/assets/AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo base_url(''); ?>/assets/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  
  <link rel="stylesheet" href="<?php echo base_url(''); ?>/assets/AdminLTE/plugins/timepicker/bootstrap-timepicker.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <!-- jQuery 3 -->
  <script src="<?php echo base_url(''); ?>/assets/AdminLTE/bower_components/jquery/dist/jquery.min.js"></script>
  
  <!-- Select2 -->
  <link href="<?php echo base_url(''); ?>/assets/AdminLTE/bower_components/select2/dist/css/select2_4.0.6.min.css" rel="stylesheet" />
  
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/calendar/core/main.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/calendar/daygrid/main.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/calendar/list/main.min.css">
   <style>
   .stickyheader {
    position: fixed;
    top: 0;
    width: 100%;
    box-shadow: 0 5px 5px 0 rgba(0,0,0,0.16), 0 6px 10px 0 rgba(0,0,0,0.12);
  }
  
  .content-wrapper {
      padding-top: 50px;
      min-height: 610px !important;
  }
  @media (max-width:767px){.content-wrapper{padding-top: 100px}}
  #myNav{
        padding-bottom:2%;
  }
  #myNav:hover{
      overflow-y:auto !important;
  }
  /*@media (max-height:650px){#myNav{height:350px;}}*/
  .skin-yellow-light .sidebar-menu>li.active {
      list-style-position: inside;border-left: 3px solid #f39c12;
  }
  .skin-yellow-light .sidebar-menu>li:hover>a, .skin-yellow-light .sidebar-menu>li.active>a{
      color: #d38000;
      text-shadow: 0px 1px 0px grey;
  }
  .skin-yellow-light .sidebar-menu .treeview-menu>li.active>a span, .skin-yellow-light .sidebar-menu .treeview-menu>li>a span:hover {
      color: #da8b0b;
      text-shadow: 0px 1px 0px grey;
  }
  .sidebar-menu>li>a>.fa, .sidebar-menu>li>a>.glyphicon, .sidebar-menu>li>a>.ion{
      color:#005cb3;
      text-shadow:0px 0px 0px;
  }
  
  
    .btn-add{
      background-color: #0ea1ea !important;
    border-color: #00a1f1;
    color:#fff;
  }
/*  .btn-add.focus, .btn-add:focus, .btn-add:hover {
    color: #fff;
    text-decoration: none;
    border-color: #0873a9;
    background-color: #0d8bca !important;
}*/
.btn-export{
    color: #fff;
    background-color: #ed6b75;
    border-color: #ea5460;
}
.btn-import{
    color: #fff;
    background-color: #f39c13;
    border-color: #ea5460;
}
.a-edit{
    color:green;padding: 0px 8px;
}

.a-delete{
    color:red;padding: 0px 8px;
}

.a-view{
    color:#00bfff;padding: 0px 8px;
}
.form-group {
    margin-bottom: 15px;
    margin-top: 15px;
}
  </style>
  		<!-- Adsense Auto-Ads starts here-->
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<script>
				 (adsbygoogle = window.adsbygoogle || []).push({
					  google_ad_client: "ca-pub-9085674872653712",
					  enable_page_level_ads: true
				 });
			</script>
		<!-- Adsense Auto-Ads endss here-->
                
                <!-- Facebook Pixel Code -->
					<script>
					  !function(f,b,e,v,n,t,s)
					  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
					  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
					  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
					  n.queue=[];t=b.createElement(e);t.async=!0;
					  t.src=v;s=b.getElementsByTagName(e)[0];
					  s.parentNode.insertBefore(t,s)}(window, document,'script',
					  'https://connect.facebook.net/en_US/fbevents.js');
					  fbq('init', '1515071985294916');
					  fbq('track', 'PageView');
					</script>
					<noscript><img height="1" width="1" style="display:none"
					  src="https://www.facebook.com/tr?id=1515071985294916&ev=PageView&noscript=1"
					/></noscript>
			<!-- End Facebook Pixel Code -->
</head>
<body class="hold-transition skin-yellow-light sidebar-mini">
<div class="wrapper">

  <header class="main-header stickyheader">
    <!-- Logo -->
    <a href="<?php echo base_url(''); ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>F<span style="color:#2ecc71;">C</span></b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>FEES<span style="color:#2ecc71;">CLUB</span></b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-user"></i>
              <span class="hidden-xs"><?php echo $this->session->userdata('user_name'); ?>
			  
			  </span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <p>
                  <?php echo $this->session->userdata('user_name'); ?>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                   <div class="pull-left">
                  <a href="<?php echo base_url();?>Test/profile" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?php $l=$this->session->userdata('logintype'); echo base_url('/'.$l.'/logout');?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
