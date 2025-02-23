<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
        <div class="container-fluid padded">

          <div class="container-fluid">
            <div class="row-fluid">
                <div class="area-top clearfix">
                    <div class="pull-left header">
                        <h3 class="title">
                        <i class="icon-pushpin"></i>
                        <?php echo get_phrase('Online Test');?></h3>
                    </div>

                </div>
            </div>
        
        <!--------FLASH MESSAGES Nulled by vokey--->
        
		<!---->
        
        
                    <!--<div class="container-fluid padded tam-custom-border1"> -->
                    <div>
    <center>
    <?php if(empty($_POST)){?>
<?php echo form_open('student/onlinetest' , array('class' => 'form-horizontal validatable', 'enctype' => 'multipart/form-data', 'target'=>'_top'));?>
		<div class="row-fluid">
        <div class="span4 offset4">
            <div class="box">
                <div class="box-header">
                    <span class="title"> <i class="icon-info-sign"></i> Online Test.</span>
                </div>
                <div class="box-content padded tam-custom-border1">
                    <div class="tam-custom-mar-btn-10">
                      
                      <select name="classname" id="classname" class="tam-custom-select">
                      	<option value="">--- Select Class --- </option>
                        <option value="1" <?php if($_POST['classname']=='1'){?> selected="selected" <?php } ?>>1st Class</option>
                        <option value="2" <?php if($_POST['classname']=='2'){?> selected="selected" <?php } ?>>2nd Class</option>
                        <option value="3" <?php if($_POST['classname']=='3'){?> selected="selected" <?php } ?>>3rd Class</option>
                        <option value="4" <?php if($_POST['classname']=='4'){?> selected="selected" <?php } ?>>4th Class</option>
                        <option value="5" <?php if($_POST['classname']=='5'){?> selected="selected" <?php } ?>>5th Class</option>
                        <option value="6" <?php if($_POST['classname']=='6'){?> selected="selected" <?php } ?>>6th Class</option>
                        <option value="7" <?php if($_POST['classname']=='7'){?> selected="selected" <?php } ?>>7th Class</option>
                        <option value="8" <?php if($_POST['classname']=='8'){?> selected="selected" <?php } ?>>8th Class</option>
                        <option value="9" <?php if($_POST['classname']=='9'){?> selected="selected" <?php } ?>>9th Class</option>
                        <option value="10" <?php if($_POST['classname']=='10'){?> selected="selected" <?php } ?>>10th Class</option>
                      </select>
                      
                    </div>
                    <div class="tam-custom-mar-btn-10">
                      <select name="subject" id="subject" class="tam-custom-select">
                         <option value=''>--- Select Subject Name --- </option>
                        <option value="telugu" <?php if($_POST['subject']=='telugu'){?> selected="selected" <?php } ?>>Telugu</option>
                        <option value="hindi" <?php if($_POST['subject']=='hindi'){?> selected="selected" <?php } ?>>Hindi</option>
                        <option value="english" <?php if($_POST['subject']=='english'){?> selected="selected" <?php } ?>>English</option>
                        <option value="maths" <?php if($_POST['subject']=='maths'){?> selected="selected" <?php } ?>>Maths</option>
                        <option value="science" <?php if($_POST['subject']=='science'){?> selected="selected" <?php } ?>>Science</option>
                        <option value="social" <?php if($_POST['subject']=='social'){?> selected="selected" <?php } ?>>Social</option>
                      </select>
                    </div>
                   <div>
                            <button type="submit" class="btn btn-gray"><?php echo get_phrase('start_test');?></button>
                  </div> 
                </div>
            </div>
        </div>
        </div>
</form>
<?php }  ?>
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

<?php if(!empty($_POST)){ if(empty($onlinetest)){?>
	<div class="row-fluid">
    	<div class="span6 offset3">
            <div class="alert alert-error">
            <strong>No Questions Found!</strong> <br />No questions found for selected class and subject, please try again.
            <p>
            <a href="<?php base_url();?>student/onlinetest" class="btn btn-info btn-small">Go Back</a>
            </p>
            </div>
        </div>
    </div>

					<?php } else{ ?>
                            <div class="box-content">

                                <div id="dataTables">
                    <?php echo form_open('student/result' , array('class' => 'form-horizontal validatable form-horizontal', 'enctype' => 'multipart/form-data', 'target'=>'_top','method'=>'post','id'=>'login'));?>
					<?php 
                    $rows = count($onlinetest);//mysql_num_rows($res);
					$i=1;
					foreach($onlinetest as $result){
					?>
					<?php if($rows==1){?>
                    <div id='question<?php echo $i;?>' class='cont'>
		<div class="leftside_testseries" id="leftside_testseries">
			<div>
			
			<div class="viewquestion">
				
				
			</div>
            
			<div class="viewanswer">
            	<div>
					<p id="questionText qname<?php echo $i;?>" class="questions"> <?php echo $i?>.<?php echo $result['question'];?></p>
				</div>
			
			
            
				<div>
					<div>
						<p id="questionText" ><input type="radio" value="1" id='radio1_<?php echo $result['onlinetest_id'];?>' name='<?php echo $result['onlinetest_id'];?>'/><?php echo $result['option1'];?></p>
					</div>
					<div>
						<p id="questionText"><input type="radio" value="2" id='radio1_<?php echo $result['onlinetest_id'];?>' name='<?php echo $result['onlinetest_id'];?>'/><?php echo $result['option2'];?></p>
					</div>
                    <div>
                    	<p id="questionText"><input type="radio" value="3" id='radio1_<?php echo $result['onlinetest_id'];?>' name='<?php echo $result['onlinetest_id'];?>'/><?php echo $result['option3'];?></p>
                    </div>
                    <div>
                    	<p id="questionText"><input type="radio" value="4" id='radio1_<?php echo $result['onlinetest_id'];?>' name='<?php echo $result['onlinetest_id'];?>'/><?php echo $result['option4'];?></p>
                    </div>
                    <div>
                    	<p id="questionText"><input type="radio" checked='checked' style='display:none' value="10" id='radio1_<?php echo $result['onlinetest_id'];?>' name='<?php echo $result['onlinetest_id'];?>'/></p>
                    </div>
				</div>
				
				
					</div>
			</div>
		
		<div class="questionsnavigation">
			
            
                
                    <button id='next<?php echo $i;?>' class='next btn btn-success' type='submit' style="margin-left: 559px;">Finish</button>
		</div>
		</div>
    </div>
    <div class="rightside_testseries">
    
    <div><span>Total Marks</span><span><?php echo $rows;?></span></div>
		<div><span>Subject</span><span><?php echo ucfirst($_POST['subject']);?></span></div>
      </div>
      
      <div id="custom-goto-test"><a class="btn btn-danger" id="tam-custom-cl-test">Cancel Test</a></div>	
		
                    <?php } else{?>
                    <?php if($i==1){?>  
                    
                    <div class="textboxplain innerAssessment">
		
		<div id="liveTestSeriesBody" class="textboxplain_testseries">
		
		<div class="page-content">
		<div class="contentArea"><!--Questions displaying area-->
        <div id='question<?php echo $i;?>' class='cont'>
		<div class="leftside_testseries" id="leftside_testseries">
			<div>
			
			<div class="viewquestion">
				
			</div>
            <?php //if($rows=='1')?>
			<div class="viewanswer">
            	<div>
					<p id="questionText qname<?php echo $i;?>" class="questions"> <?php echo $i?>.<?php echo $result['question'];?></p>
				</div>
			
			
            
				<div><?php /*?><p class='questions' id="qname<?php echo $i;?>"> <?php echo $i?>.<?php echo $result['question'];?></p><?php */?>
					<div>
						<p id="questionText"><input type="radio" value="1" id='radio1_<?php echo $result['onlinetest_id'];?>' name='<?php echo $result['onlinetest_id'];?>'/><?php echo $result['option1'];?></p>
					</div>
					<div>
						<p id="questionText"><input type="radio" value="2" id='radio1_<?php echo $result['onlinetest_id'];?>' name='<?php echo $result['onlinetest_id'];?>'/><?php echo $result['option2'];?></p>
					</div>
                    <div>
                    	<p id="questionText"><input type="radio" value="3" id='radio1_<?php echo $result['onlinetest_id'];?>' name='<?php echo $result['onlinetest_id'];?>'/><?php echo $result['option3'];?></p>
                    </div>
                    <div>
                    	<p id="questionText"><input type="radio" value="4" id='radio1_<?php echo $result['onlinetest_id'];?>' name='<?php echo $result['onlinetest_id'];?>'/><?php echo $result['option4'];?></p>
                    </div>
                    <div>
                    	<p id="questionText"><input type="radio" checked='checked' style='display:none' value="10" id='radio1_<?php echo $result['onlinetest_id'];?>' name='<?php echo $result['onlinetest_id'];?>'/></p>
                    </div>
				</div>
				</div>
			</div>
		
		<div class="questionsnavigation">
			
            <a id="nextQuestion next<?php echo $i;?>" onclick="renderNextQuestion();return false;" class="go-to-next next btn btn-small btn-info" href="javascript:void(0)">Next</a>
           <?php /*?> <button id='next<?php echo $i;?>' class='next btn btn-success' type='button'>Next</button><?php */?>
		</div>
		</div>
    </div>
    
    <?php  }elseif($i<1 || $i<$rows){ ?>
    	<div id='question<?php echo $i;?>' class='cont'>
		<div class="leftside_testseries" id="leftside_testseries">
			<div>
			
			<div class="viewquestion">
				
				
			</div>
            
			<div class="viewanswer">
            	<div>
					<p id="questionText qname<?php echo $i;?>" class="questions" > <?php echo $i?>.<?php echo $result['question'];?></p>
				</div>
			
			
				<div><?php /*?><p class='questions' id="qname<?php echo $i;?>"> <?php echo $i?>.<?php echo $result['question'];?></p><?php */?>
					<div>
						<p id="questionText"><input type="radio" value="1" id='radio1_<?php echo $result['onlinetest_id'];?>' name='<?php echo $result['onlinetest_id'];?>'/><?php echo $result['option1'];?></p>
					</div>
					<div>
						<p id="questionText"><input type="radio" value="2" id='radio1_<?php echo $result['onlinetest_id'];?>' name='<?php echo $result['onlinetest_id'];?>'/><?php echo $result['option2'];?></p>
					</div>
                    <div>
                    	<p id="questionText"><input type="radio" value="3" id='radio1_<?php echo $result['onlinetest_id'];?>' name='<?php echo $result['onlinetest_id'];?>'/><?php echo $result['option3'];?></p>
                    </div>
                    <div>
                    	<p id="questionText"><input type="radio" value="4" id='radio1_<?php echo $result['onlinetest_id'];?>' name='<?php echo $result['onlinetest_id'];?>'/><?php echo $result['option4'];?></p>
                    </div>
                    <div>
                    	<p id="questionText"><input type="radio" checked='checked' style='display:none' value="10" id='radio1_<?php echo $result['onlinetest_id'];?>' name='<?php echo $result['onlinetest_id'];?>'/></p>
                    </div>
				</div>
				
				</div>
			</div>
		
		<div class="questionsnavigation">
			
           
            <a id="previousQuestion pre<?php echo $i;?>" onclick="renderPreviousQuestion();return false;" class="go-to-previous previous btn btn-small btn-info" href="javascript:void(0)">Previous</a>
            <a id="nextQuestion next<?php echo $i;?>" onclick="renderNextQuestion();return false;" class="go-to-next next btn btn-small btn-info" href="javascript:void(0)">Next</a>
		</div>
		</div>
    </div>
    
    <?php  }elseif($i==$rows){ ?>
    
    <div id='question<?php echo $i;?>' class='cont'>
		<div class="leftside_testseries" id="leftside_testseries">
			<div>
			
			<div class="viewquestion">
				
				
			</div>
            
			<div class="viewanswer">
            	<div>
					<p id="questionText qname<?php echo $i;?>" class="questions" > <?php echo $i?>.<?php echo $result['question'];?></p>
				</div>
			
			
            
				<div><?php /*?><p class='questions' id="qname<?php echo $i;?>"> <?php echo $i?>.<?php echo $result['question'];?></p><?php */?>
					<div>
						<p id="questionText"><input type="radio" value="1" id='radio1_<?php echo $result['onlinetest_id'];?>' name='<?php echo $result['onlinetest_id'];?>'/><?php echo $result['option1'];?></p>
					</div>
					<div>
						<p id="questionText"><input type="radio" value="2" id='radio1_<?php echo $result['onlinetest_id'];?>' name='<?php echo $result['onlinetest_id'];?>'/><?php echo $result['option2'];?></p>
					</div>
                    <div>
                    	<p id="questionText"><input type="radio" value="3" id='radio1_<?php echo $result['onlinetest_id'];?>' name='<?php echo $result['onlinetest_id'];?>'/><?php echo $result['option3'];?></p>
                    </div>
                    <div>
                    	<p id="questionText"><input type="radio" value="4" id='radio1_<?php echo $result['onlinetest_id'];?>' name='<?php echo $result['onlinetest_id'];?>'/><?php echo $result['option4'];?></p>
                    </div>
                    <div>
                    	<p id="questionText"> <input type="radio" checked='checked' style='display:none' value="10" id='radio1_<?php echo $result['onlinetest_id'];?>' name='<?php echo $result['onlinetest_id'];?>'/></p>
                    </div>
				</div>
				
				</div>
			</div>
		
		<div class="questionsnavigation">
			
            
             <a id="previousQuestion pre<?php echo $i;?>" onclick="renderPreviousQuestion();return false;"  href="javascript:void(0)"></a>&nbsp;                  
                    <button id='next<?php echo $i;?>' class='next btn btn-success' type='submit'>Finish</button>
		</div>
		</div>
    </div>
    <?php ?>
		<!--Questions displaying area--> <!--Questions list area-->
		<div class="rightside_testseries">
        
		<div><span>Total Marks</span><span><?php echo $rows;?></span></div>
		<div><span>Subject</span><span><?php echo ucfirst($_POST['subject']);?></span></div>
        
		
		</div>
        
        <div id="custom-goto-test"><a class="btn btn-danger" id="tam-custom-cl-test">Cancel Test</a></div>	
        
		<!--<div class="doneText">I'm Done.</div>
		<a style="margin-bottom:25px;" onclick="submitAssessment()" class="submit-test">Submit My Test</a>
		</div>-->
		<!--Questions list area--></div>
		</div>
		</div>
		</div>
		</div>
	
</div>
                    
                    
                           
                    
					<?php } $i++;} }?>

				</form>
            </div>

                            </div>
                            <?php } ?>
                         		
                           <?php } ?>
                        </div>
                        
                        
<!-- Modal -->
<div id="custom-tam-model" class="modal hide fade" tabindex="-1" role="dialog">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="custom-tam-mode">Are you sure !</h3>
</div>
<div class="modal-body">
<div id="custom-tam-model-body"><div class="alert"><strong>Do you want to cancel test !</strong></div></div>
</div>
<div class="modal-footer">
<button class="btn btn-success btn-small" data-dismiss="modal" aria-hidden="true">No</button>
<a href="<?php base_url();?>student/onlinetest" class="btn btn-danger btn-small">Yes</a>
</div>
</div>

<script>

    /*function readURL(input) {

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
*/


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
  
  <div style="" class="lnVideoContent" id="iFrameDiv">
<div>
<div>
	<div id="instructions" class="textboxplain margin20" style="display: none;">
       
        <div style="border: 0 none;" class="page-content">
          <div class="contentArea">
            <div class="instructionbody">
            	<div class="instructionbox">
                	<h2>Instructions:</h2>
                    <div class="instructionList">
                     <ul>
                     	<li>There are 20 questions in the test. Each question has only 1 correct answer and carries 1 mark</li>
                        <li>You have 30 minutes to complete the test. After this time, the test will be automatically submitted</li>
                        <li>There is no negative marking for wrong answers</li>
                        <li>You can appear in the test only once so start the test only when you are ready</li>
                        <li>You can review/edit the answers before final submission. Click <span style="font-style:italic;">"I'm Done. Submit My Test"</span> to submit the test</li>
                     </ul>
                    </div>
                    <div class="allThebest">All the best!</div>
                </div>
                <div class="startTest_btn">
                	<a onclick="startTest();" class="blue_btn startTest_btn_img">Start Test</a>
                </div> 
            </div>
          </div>
        </div>
  </div>
</div>
		
		
		
		
		
		
		
		

<style type="text/css">
ul.questioncount li {
    color: #fff;
    cursor: pointer;
    float: left;
    font-size: 16px;
    font-weight: 400;
    height: 42px;
    line-height: 40px;
    margin-bottom: 2px;
    margin-right: 2px;
    padding: 0 !important;
    text-align: center;
    width: 51px;
}ul.questioncount li.answered {
    background: none repeat scroll 0 0 #4d95ef;
    border: 1px solid #2666b5;
}.textboxplain {
    border: 0 none !important;
    border-radius: 0 !important;
    box-shadow: none !important;
    padding: 0 !important;
    width: 1000px !important;
}.innerAssessment {
    width: 1000px !important;
}.innerAssessment {
    background: none repeat scroll 0 0 rgba(0, 0, 0, 0) !important;
    border: 0 none !important;
    box-shadow: none !important;
    margin: 0 !important;
    padding: 0 !important;
    width: 1000px;
}.textboxplain_testseries {
    margin-bottom: 20px;
}.textboxplain_testseries {
    float: left;
    width: 1000px;
}.page-content {
    float: left;
    padding-bottom: 15px;
    width: 1000px;
}.contentArea {
    margin-top: 0 !important;
}
.contentArea {
    margin-top: 50px;
    width: 1000px !important;
}.contentArea {
    margin: 8px auto 15px 4px !important;
}
.contentArea {
    float: left;
    height: auto;
    margin-top: 15px;
    width: 1000px;
}.lnVideoContent {
    margin: 0 auto;
    padding: 0;
    width: auto;
}.lnTitle {
    border-bottom: 1px solid #ffe169 !important;
    color: #6c6c6c;
    font-size: 16px;
    font-weight: 400;
}.lnTitle {
    clear: both;
    color: #444;
    font-size: 14px;
    font-weight: 400;
    height: 45px;
    line-height: 45px;
    padding-left: 38px;
}.leftside_testseries {
width: 65%;
height: auto;
float: left;
background: #FFFFFF;
border: 0 none;
border-radius: 5px;
-webkit-box-shadow: 0px 0px 5px 3px rgba(205,205,205,1);
-moz-box-shadow: 0px 0px 5px 3px rgba(205,205,205,1);
box-shadow: 0px 0px 5px 3px rgba(205,205,205,1);
float: left;
margin: 0 10px 0 0;
min-height: 97px;
font-family: 'Lato', sans-serif;
font-size: 13px;
padding: 0px;
}.page-content-header {
width: 655px !important;
margin-bottom: 5px;
}.page-content-header {
width: 1000px;
height: 30px;
float: left;
font-family: 'Lato', sans-serif;
font-size: 13px;
color: #0060ac;
}.page-content-header h3 {
padding-left: 30px;
}.page-content-header h3 {
padding-left: 36px;
padding-top: 8px;
}.viewquestion, .viewanswer, .objective, .viewquestion_toogle, .viewanswer_toogle {
width: 585px;
height: auto;
float: left;
padding: 10px 30px;
line-height: 30px;
}.viewquestion p {
color: #3c3c3c;
font-weight: 400;
width: 530px;
padding-left: 10px;
line-height: 20px;
margin-top: 6px;
}.viewquestion span, .viewquestion p, .objective p {
float: left;
font-weight: bold;
font-family: 'Lato', sans-serif !important;
font-size: 13px !important;
font-weight: bold;
color: #444 !important;
}.viewanswer {
background: #fff;
}.questionsnavigation {
width: 100%;
height: auto;
float: left;
padding-top: 20px;
padding-bottom: 20px;
border-top: 1px solid #dbdbdb;
}.rightside_testseries {
-webkit-box-shadow: 0px 0px 5px 3px rgba(205,205,205,1);
-moz-box-shadow: 0px 0px 5px 3px rgba(205,205,205,1);
box-shadow: 0px 0px 5px 3px rgba(205,205,205,1);
width: 25%;
height: auto;
float: left;
margin-left: 10px;
border: 1px solid #ccc;
border-top: none;
background: #FFFFFF;
border: 0 none;
border-radius: 5px;
float: left;
margin: 0 0 0 15px;
min-height: 97px;
font-family: 'Lato', sans-serif;
font-size: 13px;
padding: 6px 20px;
}.count-time {
text-align: left;
padding: 0;
width: 100px !important;
margin: 0px 0px 5px 0px;
}ul.questioncount {
width: 275px;
height: auto;
float: left;
margin-top: 7px;
}ol, ul {
list-style-type: none;
}.legends {
float: left;
margin-top: 4px;
margin-left: 12px;
width: 275px;
}.doneText {
font-size: 10px;
color: #888;
text-align: center;
margin-bottom: 8px;
margin-top: 8px;
float: left;
width: 250px;
}.submit-test {
background: #57a64a;
border: 1px solid #498e3d;
width: 200px;
height: 15px;
float: left;
margin-top: 0px;
margin-left: 15px;
margin-bottom: 32px;
cursor: pointer;
color: #fff;
text-transform: uppercase;
font-weight: 400;
padding: 8px;
text-align: center;
border-radius: 4px;
}.legends h3 {
color: #3b3b3b;
font-size: 14px;
font-weight: bold;
float: left;
width: 100%;
padding-bottom: 15px;
}.legends ul li {
float: left;
margin-bottom: 10px;
width: 130px;
}.answered {
background: #4d95ef;
border: 1px solid #2666b5;
padding: 6px;
color: #fff;
width: 20px;
text-align: center;
float: left;
}.legends ul li p {
float: left;
margin-left: 10px;
font-size: 12px;
color: #444444;
padding-top: 6px;
}.unAnswered {
background: #F3F3F3;
border: 1px solid #D9D9D9;
padding: 6px;
color: #444;
width: 20px;
text-align: center;
float: left;
}.selectedAnswered {
background: #fac90f;
border: 1px solid #e9aa00;
padding: 6px;
color: #444;
width: 20px;
text-align: center;
float: left;
}ul.questioncount li.selectedanswer {
background: #fac90f;
border: 1px solid #D9D9D9;
color: #444;
}ul.questioncount li {
width: 51px;
height: 42px;
float: left;
text-align: center;
font-size: 16px;
color: #fff;
font-weight: 400;
padding: 0px !important;
margin-right: 2px;
margin-bottom: 2px;
cursor: pointer;
line-height: 40px;
}.count-time h4 {
color: #444444;
font-size: 13px;
font-weight: bold;
}.count-time p {
color: #e92c2c;
font-size: 26px;
font-weight: bold;
padding-top: 4px;
}.rightside_testseries h2 {
color: #444444;
font-size: 13px;
width: auto;
text-align: left;
padding-bottom: 5px;
}.rightside_testseries h2 span {
font-weight: 700;
font-size: 26px;
line-height: 25px;
}.page-content-header span {
color: #444;
}.moreLink {
color: #1261D6;
text-decoration: none;
font-weight: 400;
text-align: right;
}.viewanswer p {
color: #888;
font-size: 13px;
font-weight: bold;
float: left;
width: 480px;
}.go-to-previous {
margin-left: 25px;
width: 50px;
border-radius: 5px 5px 5px 5px;
-moz-border-radius: 5px 5px 5px 5px;
-webkit-border-radius: 5px 5px 5px 5px;
border: 0px solid #000000;
}.go-to-next {
float: right;
margin-right: 30px;
width: 30px;
border-radius: 5px 5px 5px 5px;
-moz-border-radius: 5px 5px 5px 5px;
-webkit-border-radius: 5px 5px 5px 5px;
border: 0px solid #000000;
}ul.questioncount li.unanswered {
background: #F3F3F3;
border: 1px solid #d9d9d9;
color: #888888;
}
#custom-goto-test{
	float:right;
	width:22%;
	margin-top:30px;
}
</style>

<script>
$('#tam-custom-cl-test').on('click',function(e){
		e.preventDefault();
		$('#custom-tam-model').modal('show');
});
</script>