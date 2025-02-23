<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php //print_r($result[0]->ebooks_category_id);exit; 
//$getdata = $this->db->get_where('previousquestionpapers', array('subject' => $this->uri->segment(3),'classname'=>$this->uri->segment(4)))->result_array();
?>
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
    <style>
			/*.container {
				margin-top: 110px;
			}
			.error {
				color: #B94A48;
			}
			.form-horizontal {
				margin-bottom: 0px;
			}
			.hide{display: none;}*/
		</style>
    
<body>
	<div id="main_body">
		<?php include 'header.php';?>
        <?php 
		include 'navigation.php';?>
        <div class="main-content">
            <div class="container-fluid padded">

                    <div class="container-fluid">
            <div class="row-fluid">
                <div class="area-top clearfix">
                    <div class="pull-left header">
                        <h3 class="title">
                        <i class="icon-pushpin"></i>
                        <?php echo get_phrase('Online Test Results');?></h3>
                    </div>

                </div>
            </div>
        
        <!--------FLASH MESSAGES Nulled by vokey--->
        
		<!---->
        
        
                    <!--<div class="container-fluid padded tam-custom-border1"> -->
                    <div>
                
                

    <center>
<?php echo form_open('student/onlinetest' , array('class' => 'form-horizontal validatable', 'enctype' => 'multipart/form-data', 'target'=>'_top'));?>
        <div class="span6 offset3">

            <div class="box">

                <div class="box-header">

                    <span class="title"> <i class="icon-info-sign"></i> Online Test Result.</span>

                </div>
				
                <div class="box-content padded tam-custom-border1">

                    <p><br>
                      <!--<hr />-->
                      
                      <script>

                        /*$(document).ready(function() {

                            function ask()

                            {

                                Growl.info({title:"Select a class name and subject to view the papers",text:" "});

                            }

                            setTimeout(ask, 500);

                        });*/

                      </script>
                      <?php 
					  	$right_answer=0;
						$wrong_answer=0;
						$unanswered=0; 
					//print_r($_POST);exit;
					   $keys=array_keys($_POST);
					   $order=join(",",$keys);
					 
					   $sql = 'select onlinetest_id,ans from onlinetest where onlinetest_id IN ('.$order.')  ORDER BY FIELD(onlinetest_id,'.$order.')';
        				$response = $this->db->query($sql);
					  
						   foreach($response->result_array() as $result){
							  
						   		if($result['ans']==$_POST[$result['onlinetest_id']]){
								   $right_answer++;
							   }else if($_POST[$result['onlinetest_id']]==10){
								   $unanswered++;
							   }
							   else{
								   $wrong_answer++;
							   }
						   } 
					  	
					  ?>
                    </p>
                    <div id="tam-custom-result-block">
                    <p>Total no. of right answers  <span class="answer answer-success"><?php echo $right_answer;?></span></p>
                    <p>Total no. of wrong answers <span class="answer answer-warning"><?php echo $wrong_answer;?></span></p>
                    <p>Total no. of Unanswered Questions  <span class="answer answer-important"><?php echo $unanswered;?></span></p>
                    <p>Total no. of Questions  <span class="answer answer-info"><strong><?php echo count($response->result_array());?></strong></span></p>
                    </div>
                  <!-- <div class="form-actions">
                            <button type="submit" class="btn btn-gray"><?php //echo get_phrase('back');?></button>
                        </div>--> 
                </div>

            </div>

        </div>
</form>
    </center>
<div class="box">
<script type="text/javascript">
function getValue(){
    subject2=document.getElementById('subject2').value;
	classname2=document.getElementById('classname2').value;
	if(classname2!='' && subject2!=''){
	 window.location="student/questionpaper/"+subject2+"/"+classname2
	}
}
</script>
<?php //if($this->uri->segment(3)!='' && $this->uri->segment(4)!=''){?>
<?php if(!empty($_POST)){?>
                            <div class="box-content">

<?php //if(!empty($this->uri->segment(4))){?>
<?php  //} ?>
            </div>
                            <?php } ?>
                        </div>

<script>

    function readURL(input) {

        if (input.files &amp;&amp; input.files[0]) {

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
<script type="text/javascript">
	
		$('.cont').addClass('hide');
		count=$('.questions').length;
		 $('#question'+1).removeClass('hide');

		 $(document).on('click','.next',function(){

		     element=$(this).attr('id');
		     last = parseInt(element.substr(element.length - 1));
		     nex=last+1;
		     $('#question'+last).addClass('hide');

		     $('#question'+nex).removeClass('hide');
		 });

		 $(document).on('click','.previous',function(){
             element=$(this).attr('id');
             last = parseInt(element.substr(element.length - 1));
             pre=last-1;
             $('#question'+last).addClass('hide');

             $('#question'+pre).removeClass('hide');
         });

		</script>
</script>

            </div> 
</div></div></div></div>
                    <div style="clear:both;color:#aaa; padding:20px;">
    	
                        		<center>&copy; 2013, N-gurukul</center>
  </div>        </div>
