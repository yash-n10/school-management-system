<link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url();?>template/images/fc-icons/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url();?>template/images/fc-icons/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url();?>template/images/fc-icons/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url();?>template/images/fc-icons/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url();?>template/images/fc-icons/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url();?>template/images/fc-icons/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url();?>template/images/fc-icons/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url();?>template/images/fc-icons/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url();?>template/images/fc-icons/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192" href="<?php echo base_url();?>template/images/fc-icons/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url();?>template/images/fc-icons/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url();?>template/images/fc-icons/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url();?>template/images/fc-icons/favicon-16x16.png">
<link rel="manifest" href="<?php echo base_url();?>template/images/fc-icons/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="<?php echo base_url();?>template/images/fc-icons/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
<?php
//////////LOADING SYSTEM SETTINGS FOR ALL PAGES AND ACCOUNTS/////////

$system_name	=	$this->db->get_where('settings' , array('type'=>'system_name'))->row();
// print_r($system_name);die();
$system_title	=	$this->db->get_where('settings' , array('type'=>'system_title'))->row();

// $system_name	=	$this->db->get_where('settings' , array('type'=>'system_name'))->row()->description;
// // print_r($system_name);die();
// $system_title	=	$this->db->get_where('settings' , array('type'=>'system_title'))->row()->description;
?>