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
  
   <link rel="stylesheet" href="<?php echo base_url(''); ?>/assets/AdminLTE/dist/css/skins/skin-yellow-light.min.css">


   <link rel="stylesheet" href="<?php echo base_url(''); ?>/assets/AdminLTE/plugins/timepicker/bootstrap-timepicker.min.css">

   
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

<!-- jQuery 3 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
<script src="<?php echo base_url(); ?>/assets/AdminLTE/bower_components/jquery/dist/jquery.min.js"></script>


<!-- Select2 -->
<link href="<?php echo base_url(''); ?>/assets/AdminLTE/bower_components/select2/dist/css/select2_4.0.6.min.css" rel="stylesheet" />


<style>
 .stickyheader {
  position: fixed;
  top: 0;
  width: 100%;
}
.box-title{
  letter-spacing:0.5px;
  font-size:18px!important; color: #990000;text-transform:capitalize;
}

.content-wrapper {
  padding-top: 50px;    
  /*background: url(<?php echo base_url()?>assets/AdminLTE/dist/img/bgimg.jpg);*/
  background-repeat: no-repeat;
  background-size: cover;
  background-color:#ffffff;
}
.main-sidebar {
 background-repeat: no-repeat;
 background-size: cover;
 
}
@media (max-width:767px){.content-wrapper{padding-top: 100px}}
#myNav{
  padding-bottom:2%;
}
#myNav:hover{
  overflow-y:auto !important;
}
.skin-yellow-light .sidebar-menu>li.active {
  list-style-position: inside;border-left: 3px solid #f39c12;
}
.skin-yellow-light .sidebar-menu>li:hover>a, .skin-yellow-light .sidebar-menu>li.active>a{
  color: #000000;

}
.pagination > .active > a, .pagination > .active > a:focus, .pagination > .active > a:hover, .pagination > .active > span, .pagination > .active > span:focus, .pagination > .active > span:hover{
  background-color: #00c6f7!important;
}

      .skin-yellow-light .sidebar-menu .treeview-menu>li>a
      {
        color: #000000;
      }
      .skin-yellow-light .sidebar a
      {
        color: #000000;
      }
      .sidebar-menu>li>a>.fa, .sidebar-menu>li>a>.glyphicon, .sidebar-menu>li>a>.ion{
        color:#005cb3;
        text-shadow:0px 0px 0px;
      } 
      .btn-add{
       background-color: #00c6f7 !important;
       border-color: #00a1f1;
       color:#fff;
     }
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

    .sidebar-menu>li>a>.fa, .sidebar-menu>li>a>.glyphicon, .sidebar-menu>li>a>.ion {
      color: #00c6f7;
      text-shadow: 0px 0px 0px;
    }
    .skin-yellow-light .user-panel>.info, .skin-yellow-light .user-panel>.info>a {
      color: #ffffff;
    }
    .user-panel {
      position: relative;
      width: 100%;
      padding: 0px;
      overflow: hidden;
    }
    .stickysidebar {
      position: fixed!important;
      background-color: #00c6f7!important;
    }
    .stickyheader{
      background-color: #00c6f7!important;
    }
    ul#myNav{
      border-radius:8px;
    }
    .user-panel.jumbotron{    
      border-radius: 8px;  
    }
    section.sidebar {
      padding: 0px 9px;   
    }
    .jumbotron {
      padding-top: 3px;
      padding-bottom: 30px;
      margin-bottom: 30px;
      color: inherit;
      background-color: #ffffff!important;
    }
    li.user-header{
      background-color: #010d6d!important;
    }
    li.active {   
      border-radius: 7px!important;
    }
    i.fa.fa-angle-left.pull-right {
      color: beige;
    }
    .active>a>#ico
    {
      background-color: #00c6f7;
      border-radius: 11px;
      color: #fff;
      padding:5px 18px 5px 5px;
      width: 24px!important;

    }
    thead{
      background-color: #00c6f7!important;
      color: #fff;
      font-size: small;
    }
    #searchhead
    {
    	 background-color:  #fff!important;
    }
    .active>a>.nav-title
    {
      background-color: #00c6f7;
      padding: 5px 63% 5px 4px;
      color: #fff;
      border-radius: 5px 3px 5px 5px;

    }
    .fc-unthemed td.fc-today {
      background: #010d6d!important;
      color: white!important;
      font-weight: 900;
      font-size: 24px;
      font-weight: bold;
    }
    .info-box-text{
      color:#010d6d;
      font-weight: bold;
      font-size: 15px;
      text-align: center;
    }
    .shortclink_name
    {
      color:#010d6d;
      text-align:center;
    }
    .school_head{
      font-size:30px; 
      color: #990000;
      text-transform: capitalize;
    }
    .card-header
    {
      padding: 0.75rem 1.25rem;
      margin-bottom: 0;
      background-color:#010d6d;
      border-bottom: 1px solid rgba(0, 0, 0, 0.125);
      color:#fff;
    }

    .skin-yellow-light .sidebar-menu .treeview-menu>li.active>a, .skin-yellow-light .sidebar-menu .treeview-menu>li>a:hover {
      color: #000; 
      background-color: #f4f4f5!important;
    }
    .panel-success>.panel-heading {
    color: #00c6f7 !important;
    background-color: #ffffff!important;
}

  </style>
  <!-- Adsense Auto-Ads starts here-->
  <!-- <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> -->
<!--   <script>
   (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-9085674872653712",
    enable_page_level_ads: true
  });
</script> -->
<!-- Adsense Auto-Ads endss here-->
</head>
<body class="hold-transition skin-yellow-light sidebar-mini">
  <div class="wrapper" style="background-color: #ffffff!important;">

    <header class="main-header stickyheader">
        <a href="<?php echo base_url(''); ?>" class="logo">
          <span class="logo-mini"><b>F<span style="color:#2ecc71;">C</span></b></span>
          <span class="logo-lg"><img src="<?php echo base_url()?>assets/AdminLTE/dist/img/fclogo.png" style="height: 35px;width:73%"></span>
        </a>
         <nav class="navbar navbar-static-top">
          <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>

          <div class="navbar-custom-menu">
               <ul class="nav navbar-nav">
           	<?php if ($this->session->userdata('school_id')==43)
               	{
               		$logofile = 'assets/img/' . $this->session->userdata('school_id') . '2.JPG';
               		//2.jpg because nrs have 2 logos .
                
               	?>
               	          <li class="dropdown messages-menu"><img width='50px' height="50px" style='' src="<?php echo base_url() . $logofile ?>"></li>

               <?php  }?>
          <li class="dropdown messages-menu">
          	<?php if($this->session->userdata('user_group_id')==4) {?>
            <a href="<?php echo base_url()?>Test/profile" class="dropdown-toggle" title="Edit Profile">
              <i class="fa fa-user"></i> <?php echo $this->session->userdata('user_name'); ?>
            </a>    
            <?php } else { ?>
            	<a class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-user"></i> <?php echo $this->session->userdata('user_name'); ?>
              <!-- <span class="label label-success">4</span> -->
            </a>
            <?php } ?>        
          </li>
          <style>
            .navbar-nav>.notifications-menu>.dropdown-menu, .navbar-nav>.messages-menu>.dropdown-menu, .navbar-nav>.tasks-menu>.dropdown-menu{
              width: 168px!important;
            }
            .dropdown-menu {                  
                  background-color: #010d6d!important;
              }
              .navbar-nav>.notifications-menu>.dropdown-menu>li .menu>li>a {
                color: #f6f6f6;}
                .navbar-nav>.notifications-menu>.dropdown-menu>li .menu>li>a:hover {
                  color: #fff;
                  background-color:#0a1db3cc; 
              }
              .content-header {
                position: relative;
                padding: 1px 15px 0 15px;
            }
            .content-header>.breadcrumb {             
              top: -7px;             
            }
            .products-list .product-description {              
              color: #6d6b6b;
            }
          </style>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="<?php $l=$this->session->userdata('logintype'); echo base_url('/'.$l.'/logout');?>">
              <i class="fa fa-sign-out" aria-hidden="true"></i> Sign out              
            </a>
           
          </li>  
          
        </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
