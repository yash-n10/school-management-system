<?php include 'stdhead.php';?>
<?php include 'navigation.php';?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <!-- <h1><?php echo $page_title; ?></h1> -->
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('/dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo $page_title; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <?php
		if (isset($stdview)) {
			include $stdview . '.php';
		} elseif (isset($customview) && $customview != '') {
			include $customview . '.php';
		} else {
			switch ($section . '-' . $page_name) {
				case '-dashboard':
					include 'dashboard/index.php';
					break;
				default:
					// Workaround the fact that file_exists doesn't look in include path
					if (@file_get_contents($section . '/' . $page_name . '.php', true, null, 0, 1)) {
						include $section . '/' . $page_name . '.php';
					} else {
						echo $section . '/' . $page_name . '.php' . " not found relative to " . getcwd() . "\n";
					}
					break;
			}
		}
	?>
    </section>
  </div>
<?php include 'modal_hidden.php';?>
<?php include 'stdfoot.php';?>
<script>
//      $('a').click( function(){
//          alert('hi');
//          window.location.reload();
//      });
var uri ='<?php echo $this->uri->segment(1);?>';
if(uri!='settings'){
    $('select').select2({width:'100%',theme: "classic"});
}

/*---------------------------- To set the Navigation scrollable on exceeding the height  --------------------*/
//    var scheight=($("body").height());// to get the height including scrollable
    var schoolheadht=$('.sidebar .user-panel').height();
    var headerht=$('.wrapper .stickyheader').height();
    var scheight=document.body.clientHeight-(Number(schoolheadht)+Number(headerht)+35); //to get the height excluding scrollable
//    alert(scheight);
    $("#myNav").height(scheight);
/*--------------------------------------------------------------------------------------------------------------*/    
</script>