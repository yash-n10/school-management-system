<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php //print_r($result[0]->ebooks_category_id);exit; ?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
        <script type="text/javascript" src="<?php echo base_url();?>template/install/jquery.min.js"></script>
        <?php echo $this->dynamic_load->load_files('header'); ?>
	
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<script>
			var urls = '<?php 
						echo json_encode(
								array('base_url' => base_url(),
									'backend_url' => backend_view(),
									'assets' => array( 'base' => asset_url(),
										'js' => asset_url('js'),
										'css' => asset_url('css'),
										'img' => asset_url('img')
									)
								)
							)
						?>';
		</script>
            <?php include 'includes.php';?>
        <title><?php echo $page_title;?> | <?php echo $system_title;?></title>
       

    </head>
    
    
<body>
	<div id="main_body">
		<?php include 'header.php';?>
        <?php 
		include 'navigation.php';?>
        <div class="main-content">
            <?php include 'page_info.php';?>
            <div class="container-fluid padded">
<div class="box">
  <div class="box-content padded">
  <div class="tab-content">
            <!----TABLE LISTING STARTS--->
            <div class="action-nav-normal">
                <div class="" style="width:300px;margin-left:33%">
                  <a href="#">
                  	<img src="<?php echo base_url();?>uploads/icon-poll.png" /><br />
                  </a>
                </div>
            </div>
            <div class="tab-pane box active" id="list"></div>
            <!----TABLE LISTING ENDS--->
            
            
			<!----CREATION FORM STARTS---->
			<?php echo ucfirst($poll[0]->poll_question)."(".$polling_lists_count.")<div style='clear:both;'></div>";?>
			<!----CREATION FORM ENDS--->
            <?php foreach ($polling_lists as $list):
			echo "<div style='float:left; width:100%;'><div style='float: left;width: 20%;'>".$list['poll_answer'] ." (".$list['polling_count'].")</div><div style='border:1px solid gold;float:left; width:70%; height:10px;'><div style='background: none repeat scroll 0 0 blue;float: left;height: 10px;width: ".$list['polling_count']."%;'></div></div>
			<div style='clear:both;'></div>
			";
			endforeach;?>
            <div></div>
            
	</div>
	</div>
</div>
<script>

    function readURL(input) {

        if (input.files && input.files[0]) {

            var reader = new FileReader();

            

            reader.onload = function (e) {

                $('#blah').attr('src', e.target.result);

            }

            

            reader.readAsDataURL(input.files[0]);

        }

    }

    

    $("#imgInp").change(function(){

        readURL(this);

    });

</script>