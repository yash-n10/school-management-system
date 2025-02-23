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
					Online Test                   	</a></li>
			<li>
            	<a href="#add" data-toggle="tab"><i class="icon-plus"></i>
					 Add Online Test      	</a></li>
		</ul>
    	<!------CONTROL TABS END------->
        
	</div>
	<div class="box-content padded">
		<div class="tab-content">
            <!----TABLE LISTING STARTS--->
            <!--<div class="action-nav-normal">
                <div class="" style="width:300px;margin-left:33%">
                  <a href="#">
                  	<img src="<?php echo base_url();?>template/images/icons/ebooks.png" /><br />
                    <span>Total <?php echo count($onlinetest);?> Questions</span>
                  </a>
                </div>
            </div>-->
            <div class="tab-pane box active" id="list">
					
                <table cellpadding="0" cellspacing="0" border="0" class="dTable responsive box">
                	<thead>
                		<tr>
                    		<th><div>#</div></th>
                    		<th><div><?php echo get_phrase('classname');?></div></th>
                    		<th><div><?php echo get_phrase('subject');?></div></th>
							<th><div><?php echo get_phrase('question');?></div></th>
                            <th><div><?php echo get_phrase('option1');?></div></th>
                            <th><div><?php echo get_phrase('option2');?></div></th>
                            <th><div><?php echo get_phrase('option3');?></div></th>
                            <th><div><?php echo get_phrase('option4');?></div></th>
                            <th><div><?php echo get_phrase('ans');?></div></th>
                    		<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php $count = 1;foreach($onlinetest as $row):?>
                        <tr>
                            <td><?php echo $count++;?></td>
							<td><?php echo $row['classname']." Class";?></td>
                            <td><?php echo ucfirst($row['subject']); ?></td>
                            <td><?php echo $row['question'];?></td>
                            <td><?php echo $row['option1']; ?></td>
                            <td><?php echo $row['option2']; ?></td>
                            <td><?php echo $row['option3']; ?></td>
                            <td><?php echo $row['option4']; ?></td>
                            <td><?php echo $row['ans']; ?></td>
							<td align="center">
                            	<a data-toggle="modal" href="<?php echo base_url();?>admin/onlinetestedit/<?php echo $row['onlinetest_id'];?>" <?php /*?>onclick="modal('edit_book',<?php echo $row['ebooks_id'];?>)"<?php */?> class="btn btn-gray btn-small">
                                		<i class="icon-wrench"></i> <?php echo get_phrase('edit');?>
                                </a>
                            	<a data-toggle="modal" href="<?php echo base_url();?>admin/onlinetest/delete/<?php echo $row['onlinetest_id'];?>" onclick="return confirm('Do You wanto delete')"
                                	 class="btn btn-red btn-small">
                                		<i class="icon-trash"></i> <?php echo get_phrase('delete');?>
                                </a>
                               <?php /*?> <a data-toggle="modal" href="#modal-delete" onclick="modal_delete('<?php echo base_url();?>admin/onlinetest/delete/<?php echo $row['onlinetest_id'];?>')" class="btn btn-red btn-small">
                                		<i class="icon-trash"></i> <?php echo get_phrase('delete');?>
                                </a><?php */?>
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
                	<?php echo form_open('admin/onlinetest/create' , array('class' => 'form-horizontal validatable', 'enctype' => 'multipart/form-data', 'target'=>'_top'));?>
                    <!-- <form method="post" enctype="multipart/form-data" action="" target="_top" class="form-horizontal validatable" > -->
                        <div class="padded">
                        	
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('classname');?></label>
                                <div class="controls">
                                    <select name="classname" class="uniform validate[required]" id="classname">
                                    	<option value="">--- Select Class Name --- </option>
                                        <option value="1">1st Class</option>
                                        <option value="2">2nd Class</option>
                                        <option value="3">3rd Class</option>
                                        <option value="4">4th Class</option>
                                        <option value="5">5th Class</option>
                                        <option value="6">6th Class</option>
                                        <option value="7">7th Class</option>
                                        <option value="8">8th Class</option>
                                        <option value="9">9th Class</option>
                                        <option value="10">10th Class</option>
                                    </select>
                                </div>
                            </div>
							<div class="control-group">
                                <label class="control-label"><?php echo get_phrase('subject');?></label>
                                <div class="controls">
                                   <select name="subject" class="uniform validate[required]" id="subject">
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
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('Question');?></label>
                                <div class="controls">
                                    <input type="text" name="question" class="validate[required]"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('option1');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" name="option1" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="ans" value="1" class="validate[required]" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('option2');?></label>
                                <div class="controls">
                                    <input type="text" name="option2" class="validate[required]"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="ans"  value="2" />
                                </div>
                            </div><div class="control-group">
                                <label class="control-label"><?php echo get_phrase('option3');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" name="option3" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="ans"  value="3" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('option4');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" name="option4" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="ans"  value="4" />
                                </div>
                            </div>
                            
                            <!--<div style="float: left;left: 456px;overflow: hidden;position: absolute;z-index: 999;cursor:pointer;" onclick="return addMore();">Add More</div>-->
                            <div id="clonediv"></div>
                                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-gray"><?php echo get_phrase('add_questions');?></button>
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