<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php //print_r($result);exit; ?>
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
<!--<div class="box">
  <div class="box-content padded">
  <div class="tab-content"  style="overflow-y: hidden;">-->
            <!----TABLE LISTING STARTS---><!----TABLE LISTING ENDS--->
            <h3 class="custom-tam-title">
                        <i class="icon-pushpin"></i>Previous Question Papers Edit</h3>
            
			<!----CREATION FORM STARTS---->
		  <div class="box-content">
                	<?php echo form_open('admin/editpaper' , array('class' => 'form-horizontal validatable', 'enctype' => 'multipart/form-data', 'target'=>'_top'));?>
                        <div class="padded">
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('name');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" name="title" value="<?php echo $result[0]->title;?>"/>
                                </div>
                            </div>
                            
							<input type="hidden"  name="id" value="<?php echo $result[0]->paperid; ?>" />
                             <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('classname');?></label>						
							
                                <div class="controls">
                                    <select name="classname" class="uniform validate[required]">
                                    	<option value="">--- Select Class Name --- </option>
                                       <?php
                                            $classes = $this->db->get('class')->result_array();

                                            foreach ($classes as $rownew):
                                        ?>

                                            <option value="<?php echo $rownew['class_id']; ?>" <?php if($rownew['class_id']==$result[0]->classname){ echo 'selected';} ?>>

                                                <?php echo $rownew['name'].'-'.$rownew['name_numeric']; ?>

                                            </option>

                                            <?php  endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('subject');?></label>
                                <div class="controls">
                                   <select name="subject" class="uniform validate[required]">
                                    	<option value="">--- Select Subject Name --- </option>
                                        <option value="telugu" <?php if($result[0]->subject=='telugu'){ ?> selected="selected"<?php } ?>>Telugu</option>
                                        <option value="hindi" <?php if($result[0]->subject=='hindi'){ ?> selected="selected"<?php } ?>>Hindi</option>
                                        <option value="english" <?php if($result[0]->subject=='english'){ ?> selected="selected"<?php } ?>>English</option>
                                        <option value="maths" <?php if($result[0]->subject=='maths'){ ?> selected="selected"<?php } ?>>Maths</option>
                                        <option value="science" <?php if($result[0]->subject=='science'){ ?> selected="selected"<?php } ?>>Science</option>
                                        <option value="social" <?php if($result[0]->subject=='social'){ ?> selected="selected"<?php } ?>>Social</option>
                                  </select>
                                </div>
                            </div>
                            <div class="control-group" id="clone-div">
                                <label class="control-label"><?php echo get_phrase('Papers Upload');?></label>
                                <div class="controls"  style="width:210px;">
                                    <input type="file" class="" name="book_file" id="imgInp"/><?php //
							$explode=explode(".",$result[0]->book_file);
							if($explode[1]=='pdf'){?>
                            <img src="<?php echo base_url();?>uploads/pdf.jpg"class="avatar-medium" /><br /><?php echo $result[0]->book_file; ?>
							<?php }else if($explode[1]=='doc' || $explode[1]=='docx'){?>
                            <img src="<?php echo base_url();?>uploads/word.jpg"class="avatar-medium" /><br /><?php echo $result[0]->book_file; ?>
							<?php }else if($explode[1]=='xlsx'){?>
							<img src="<?php echo base_url();?>uploads/excel.jpg"class="avatar-medium" /><br /><?php echo $result[0]->book_file; ?>
							<?php }else{?>
                            <img src="<?php echo base_url();?>uploads/ebook_image/<?php echo $result[0]->book_file; ?>"class="avatar-medium" /><br  /><?php echo $result[0]->book_file; ?>
							<?php }?>
                                </div>
                               
                            </div>
                            <!--<div style="float: left;left: 456px;overflow: hidden;position: absolute;z-index: 999;cursor:pointer;" onclick="return addMore();">Add More</div>
                            <div id="clonediv"></div>
                             <div class="control-group" >
                                <label class="control-label"><?php //echo get_phrase('Pdf File');?></label>
                                <div class="controls" style="width:210px;">
                                    <input type="file" class="validate[required]" name="pdf_file" id="imgInp"/>
                                </div>
                            </div>-->

                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-gray"><?php echo get_phrase('Update');?></button>
                        </div>
                    </form>                
                </div>
			<!----CREATION FORM ENDS--->
            
	<!--	</div>
	</div>
</div>-->
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
function addMore(){
  $( "#clone-div" ).clone().appendTo( "#clonediv" ).append("<div onclick='$(this).parent().remove();' style='left:456px;cursor:pointer;position: absolute;'>Remove</div>");
  $(this).append("Helo");
}
</script>
<script type="text/javascript">
function checkfile(sender) {
    var validExts = new Array(".xlsx", ".xls", ".doc","pdf");
    var fileExt = sender.value;
    fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
    if (validExts.indexOf(fileExt) < 0) {
      alert("Invalid file selected, valid files are of " +validExts.toString() + " types.");
      return false;
    }
    else return true;
	}

	/*function checkfile() {
	var uploadcontrol = //document.getElementById('fileStatus').value;
	//Regular Expression for fileupload control.
	var reg = /^(([a-zA-Z]:)|(\\{2}\w+)\$?)(\\(\w[\w].*))+(.doc|.docx|.DOC|.DOCX)$/;
	if (uploadcontrol.length > 0)
	{
	//Checks with the control value.
	if (reg.test(uploadcontrol))
	{
	return true;
	}
	else
	{
	//If the condition not satisfied shows error message.
	alert("Only .doc, docx files are allowed!");
	return false;
	}
	}
	} //End of function validate.*/

<!-- Begin

// -->
</script>
