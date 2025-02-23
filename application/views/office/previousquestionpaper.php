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
<div class="box-header">
    
    	<!------CONTROL TABS START------->
		<ul class="nav nav-tabs nav-tabs-left">
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> 
					Previous Question Papers                    	</a></li>
			<li>
            	<a href="#add" data-toggle="tab"><i class="icon-plus"></i>
					Previous Question Papers Add        	</a></li>
		</ul>
    	<!------CONTROL TABS END------->
        
	</div>
	<div class="box-content padded">
		<div class="tab-content">
            <!----TABLE LISTING STARTS--->
           <!-- <div class="action-nav-normal">
                <div class="" style="width:300px;margin-left:33%">
                  <a href="#">
                  	<img src="<?php echo base_url();?>template/images/icons/ebooks.png" /><br />
                    <span>Total <?php echo count($ebooks);?> Papers</span>
                  </a>
                </div>
            </div>-->
            <div class="tab-pane box active" id="list">
					
                <table cellpadding="0" cellspacing="0" border="0" class="dTable responsive box">
                	<thead>
                		<tr>
                    		<th><div>#</div></th>
                    		<th><div><?php echo get_phrase('title');?></div></th>
                    		<th><div><?php echo get_phrase('class_name');?></div></th>
							<th><div><?php echo get_phrase('subject');?></div></th>
                            <th><div><?php echo get_phrase('paper');?></div></th>
                    		<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php $count = 1;foreach($ebooks as $row):?>
                        <tr>
                            <td><?php echo $count++;?></td>
							<td><?php  echo ucfirst($row['title']);?></td>
							<td><?php
									$total_classes = $this->db->get('class')->result_array();
									foreach($total_classes as $findclass){ if($findclass['class_id']==$row['classname'])echo $findclass['name'].'-'.$findclass['name_numeric']; }							?></td>
                            <td><?php echo ucfirst($row['subject']); ?><?php //$getdata = $this->db->get_where('ebooks_cat', array('ebooks_category_id'=>$row['ebooks_category_id']))->result(); echo $getdata[0]->ebooks_category_name; //echo $this->crud_model->get_type_name_by_id('books_category',$row['books_category_id'],'books_category_name');?></td>
                            <td><a href="<?php echo base_url();?>/uploads/ebook_image/<?php echo $row['book_file']; ?>" target="_blank">
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
                            
							<td align="center">
                            	<a data-toggle="modal" href="<?php echo base_url();?>admin/editpaper/<?php echo $row['paperid'];?>" <?php /*?>onclick="modal('edit_book',<?php echo $row['ebooks_id'];?>)"<?php */?> class="btn btn-gray btn-small">
                                		<i class="icon-wrench"></i> <?php echo get_phrase('edit');?>
                                </a>
                            	<a data-toggle="modal" href="<?php echo base_url();?>admin/previousquestionpapers/delete/<?php echo $row['paperid'];?>" onclick="return confirm('Do You wanto delete')"
                                	 class="btn btn-red btn-small">
                                		<i class="icon-trash"></i> <?php echo get_phrase('delete');?>
                                </a>
        					</td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
			</div>
            <!----TABLE LISTING ENDS--->
            
            
			<!----CREATION FORM STARTS---->
			<div class="tab-pane box" id="add" style="padding: 5px">
                <div class="box-content">
                	<?php echo form_open('admin/previousquestionpapers/create' , array('class' => 'form-horizontal validatable', 'enctype' => 'multipart/form-data', 'target'=>'_top','name'=>'form'));?>
                    <!-- <form method="post" enctype="multipart/form-data" action="" target="_top" class="form-horizontal validatable" > -->
                        <div class="padded">
                        	<div class="control-group">
                                <label class="control-label"><?php echo get_phrase('Title');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" name="title"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('classname');?></label>
                                <div class="controls">
                                    <select name="classname" class="uniform validate[required]">
                                    	<option value="">-- Select Class --</option>
                                        <?php
                                            $classes = $this->db->get('class')->result_array();

                                            foreach ($classes as $row):
                                        ?>

                                            <option value="<?php echo $row['class_id']; ?>">

                                                <?php echo $row['name'].'-'.$row['name_numeric']; ?>

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
                                        <option value="telugu">Telugu</option>
                                        <option value="hindi">Hindi</option>
                                        <option value="english">English</option>
                                        <option value="maths">Maths</option>
                                        <option value="science">Science</option>
                                        <option value="social">Social</option>
                                  </select>
                                </div>
                            </div>
                            <?php /*?><div class="control-group">
                                <label class="control-label"><?php echo get_phrase('books_category');?></label>
                                <div class="controls"  style="width:210px;">
                                    <select name="ebooks_category_id" class="uniform">
                                    	<?php 
										$ebooks = $this->db->get('ebooks_cat')->result_array();
										foreach($ebooks as $row):
										?>
                                    		<option value="<?php echo $row['ebooks_category_id'];?>"><?php echo $row['ebooks_category_name'];?></option>
                                        <?php
										endforeach;
										?>
                                    </select>
                                </div>
                            </div><?php */?>
                            
                             <div class="control-group" id="clone-div">
                                <label class="control-label"><?php echo get_phrase('Papers Upload');?></label>
                                <div class="controls"  style="width:210px;">
                                    <input type="file" class="validate[required] error" name="book_file[]" id="imgInp fileStatus" onchange="return checkfile(this);" />
                                </div>
                               
                            </div> 
                          <!--  <div style="float: left;left: 456px;overflow: hidden;position: absolute;z-index: 999;cursor:pointer;" onclick="return addMore();">Add More</div>-->
                            <div id="clonediv"></div>
                                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-gray"><?php echo get_phrase('add_papers');?></button>
                        </div>
                    </form>                
                </div>                
			</div>
			<!----CREATION FORM ENDS--->
            
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
function addMore(){
  $( "#clone-div" ).clone().appendTo( "#clonediv" ).append("<div onclick='$(this).parent().remove();' style='left:456px;cursor:pointer;position: absolute;'>Remove</div>");
  $(this).append("Helo");
}
</script>

<script type="text/javascript">
function checkfile(sender) {
    var validExts = new Array(".xlsx", ".xls", ".doc",".docx",".pdf");
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


  