<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php //print_r($result[0]->ebooks_category_id);exit; 
$getdata = $this->db->get_where('previousquestionpapers', array(
                    'subject' => $this->uri->segment(3),'classname'=>$this->uri->segment(4)
                ))->result_array();
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
                        <?php echo get_phrase('Previous Question Papers');?></h3>
                    </div>

                </div>
            </div>
        
        <!--------FLASH MESSAGES Nulled by vokey--->
        
		<!---->
        
        
                    <div class="container-fluid padded">
                
                

    <center>

        <div style="float:none !important;" class="span4">

            <div class="box">

                <div class="box-header">

                    <span class="title"> <i class="icon-info-sign"></i> Please select a category of Previous Question Papers.</span>

                </div>
				
                <div class="box-content padded tam-custom-border1">

                    <p><br>
                      <span class="controls">
                      <select name="classname2" id="classname2" class="uniform" onchange="return getValue()">
                        <option value=''>--- Select Class Name --- </option>
                        <!--<option value="1" <?php if($this->uri->segment(4)=='1'){?> selected="selected" <?php } ?>>1st Class</option>
                        <option value="2" <?php if($this->uri->segment(4)=='2'){?> selected="selected" <?php } ?>>2nd Class</option>
                        <option value="3" <?php if($this->uri->segment(4)=='3'){?> selected="selected" <?php } ?>>3rd Class</option>
                        <option value="4" <?php if($this->uri->segment(4)=='4'){?> selected="selected" <?php } ?>>4th Class</option>
                        <option value="5" <?php if($this->uri->segment(4)=='5'){?> selected="selected" <?php } ?>>5th Class</option>
                        <option value="6" <?php if($this->uri->segment(4)=='6'){?> selected="selected" <?php } ?>>6th Class</option>
                        <option value="7" <?php if($this->uri->segment(4)=='7'){?> selected="selected" <?php } ?>>7th Class</option>
                        <option value="8" <?php if($this->uri->segment(4)=='8'){?> selected="selected" <?php } ?>>8th Class</option>
                        <option value="9" <?php if($this->uri->segment(4)=='9'){?> selected="selected" <?php } ?>>9th Class</option>
                        <option value="10" <?php if($this->uri->segment(4)=='10'){?> selected="selected" <?php } ?>>10th Class</option>
                        <option value="">-- Select Class --</option>-->
                                        <?php
                                            $classes = $this->db->get('class')->result_array();

                                            foreach ($classes as $row):
                                        ?>

                                            <option value="<?php echo $row['class_id']; ?>" <?php if($this->uri->segment(4)==$row['class_id']){?> selected="selected" <?php } ?>>

                                                <?php echo $row['name'].'-'.$row['name_numeric']; ?>

                                            </option>

                                            <?php  endforeach; ?>
                      </select>
                      </span><!--<hr />-->
                      
                      <script>

                        $(document).ready(function() {

                            function ask()

                            {

                                Growl.info({title:"Select a class name and subject to view the papers",text:" "});

                            }

                            setTimeout(ask, 500);

                        });

                      </script>
                      
                    </p>
                    <p><span class="controls">
                      <select name="subject2" id="subject2" class="uniform"  onchange="return getValue()">
                        <option value=''>--- Select Subject Name --- </option>
                        <option value="telugu" <?php if($this->uri->segment(3)=='telugu'){?> selected="selected" <?php } ?>>Telugu</option>
                        <option value="hindi" <?php if($this->uri->segment(3)=='hindi'){?> selected="selected" <?php } ?>>Hindi</option>
                        <option value="english" <?php if($this->uri->segment(3)=='english'){?> selected="selected" <?php } ?>>English</option>
                        <option value="maths" <?php if($this->uri->segment(3)=='maths'){?> selected="selected" <?php } ?>>Maths</option>
                        <option value="sience" <?php if($this->uri->segment(3)=='science'){?> selected="selected" <?php } ?>>Science</option>
                        <option value="social" <?php if($this->uri->segment(3)=='social'){?> selected="selected" <?php } ?>>Social</option>
                      </select>
                    </span></p>
                </div>

            </div>

        </div>

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
<?php if($this->uri->segment(3)!='' && $this->uri->segment(4)!=''){?>

                            <div class="box-content">

<?php //if(!empty($this->uri->segment(4))){?>

                                <div id="dataTables">



                                    <table cellpadding="0" cellspacing="0" border="0" class="dTable responsive ">



                	<thead>

                		<tr>

                    		<th><div>#</div></th>                   		

                    		<th><div><?php echo get_phrase('class_name');?></div></th>

                    		<th><div><?php echo get_phrase('subject');?></div></th>
                            <th><div><?php echo get_phrase('paper'); ?></div></th>

                    		<!-- <th><div><?php //echo get_phrase('options');?></div></th> -->



						</tr>

					</thead>

                                        <tbody>



                    	<?php $count = 1;

                    	

                    	foreach($getdata as $row):?>

                        <tr>

                            <td><?php echo $count++;?></td>

                            <td><?php echo $row['classname']." Clsss"; ?><?php /*?><img src="<?php //echo $this->crud_model->get_image_url('ebook', $row['ebooks_id']); ?>" class="avatar-medium" /><div class="avatar"></div><?php */?></td>

							<td><?php echo $row['subject'];?></td>
							<td>
                             <a href="<?php echo base_url();?>/uploads/ebook_image/<?php echo $row['book_file']; ?>" target="_blank">
                            <?php //
							$explode=explode(".",$row['book_file']);
							if($explode[1]=='pdf'){?>
                            <img src="<?php echo base_url();?>uploads/pdf.jpg"class="avatar-medium" />
							<?php }else if($explode[1]=='doc' || $explode[1]=='docx'){?>
                            <img src="<?php echo base_url();?>uploads/word.jpg"class="avatar-medium" />
							<?php }else if($explode[1]=='xlsx'){?>
							<img src="<?php echo base_url();?>uploads/excel.jpg"class="avatar-medium" />
							<?php }else{?>
                            <img src="<?php echo base_url();?>uploads/ebook_image/<?php echo $row['book_file']; ?>"class="avatar-medium" />
							<?php }?>
                           <?php //echo $this->crud_model->get_image_url('previousquestionpapers', $row['books_file']); ?> <div class="avatar"></div></a></td>
                           <!--  <td><a href="<?php //echo $this->crud_model->get_pdf_url('pdf', $row['ebooks_id']); ?>">View Book</a></td> -->

                        </tr>

                        <?php endforeach;?>



                                        </tbody>



                                    </table>



                                </div>

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

</script>            </div> 
</div></div></div></div>
                    <div style="clear:both;color:#aaa; padding:20px;">
    	
                        		<center>&copy; 2013, N-gurukul</center>
  </div>        </div>
