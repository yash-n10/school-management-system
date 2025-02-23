
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
            <!----TABLE LISTING STARTS---><!----TABLE LISTING ENDS--->
            
            
			<!----CREATION FORM STARTS---->
		  <div class="box-content">
                	<?php echo form_open('principal/editbooks' , array('class' => 'form-horizontal validatable', 'enctype' => 'multipart/form-data', 'target'=>'_top'));?>
                        <div class="padded">
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('name');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" name="ebooks_name" value="<?php echo $result[0]->ebooks_name;?>"/>
                                </div>
                            </div>
							<input type="hidden"  name="id" value="<?php echo $result[0]->ebooks_id; ?>"/>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('books_category');?></label>
                                <div class="controls"  style="width:210px;">
                                    <select name="ebooks_category_id" class="uniform">
                                    	<?php 
										//$getdata = $this->db->get_where('ebooks_cat', array('ebooks_category_id'=>$this->uri->segment(3)))->result();
										$ebooks = $this->db->get('ebooks_cat')->result_array();
										foreach($ebooks as $row):
										?>
                                    		<option value="<?php echo $row['ebooks_category_id'];?>" <?php if($result[0]->ebooks_category_id==$row['ebooks_category_id']){ ?> selected="selected" ><?php  } ?><?php echo $row['ebooks_category_name'];?></option>
                                        <?php
										endforeach;
										?>
                                    </select>
                                </div>
                            </div>
                            
                             <div class="control-group" id="clone-div">
                                <label class="control-label"><?php echo get_phrase('Image Thumb');?></label>
                                <div class="controls"  style="width:210px;">
                                    <input type="file" class="validate[required]" name="ebook_file[]" id="imgInp"/>
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