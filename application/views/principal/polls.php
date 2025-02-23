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
					Opinion Polls</a></li>
			<li>
            	<a href="#add" data-toggle="tab"><i class="icon-plus"></i>
					Opinion Polls Add        	</a></li>
		</ul>
    	<!------CONTROL TABS END------->
        
	</div>
	<div class="box-content padded">
		<div class="tab-content">
            <!----TABLE LISTING STARTS--->
            <div class="action-nav-normal">
                <div class="" style="width:300px;margin-left:33%">
                  <a href="#">
                  	<img src="<?php echo base_url();?>uploads/icon-poll.png" /><br />
                    <span>Total <?php echo count($polling);?> Polls</span>
                  </a>
                </div>
            </div>
            <div class="tab-pane box active" id="list">
					
                <table cellpadding="0" cellspacing="0" border="0" class="dTable responsive box">
                	<thead>
                		<tr>
                    		<th><div>#</div></th>
                    		<th><div><?php echo get_phrase('classname');?></div></th>
                    		<th><div><?php echo get_phrase('question');?></div></th>
                            
                            <th><div><?php echo get_phrase('Action');?></div></th>
                           </tr>
					</thead>
                    <tbody>
                    	<?php $count = 1;foreach($polling as $rows):?>
                        <tr>
                           <td><?php echo $count++;?></td>
							<td><?php  
							if($rows->poll_class=='0'){
								echo $rows->poll_parent_name;
							}else{
							echo $rows->poll_class." Class";
							}?></td>
							<td><?php echo ucfirst($rows->poll_question);?></td>
                            <td align="center">
                            	<a data-toggle="modal" href="<?php echo base_url()."admin/viewpoll/".$rows->poll_id?>" class="btn btn-gray btn-small">
                                		<i class="icon-wrench"></i> <?php echo get_phrase('View');?>
                                </a>
                            	<a data-toggle="modal" href="<?php echo base_url();?>admin/onlinetest/delete/<?php echo $rows->poll_id;?>" onclick="confirm('Do You wanto delete')"
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
                	<?php echo form_open('admin/polls' , array('class' => 'form-horizontal validatable', 'enctype' => 'multipart/form-data', 'target'=>'_top'));?>
                    <!-- <form method="post" enctype="multipart/form-data" action="" target="_top" class="form-horizontal validatable" > -->
                        <div class="padded">
                        	<div class="control-group">
                                <label class="control-label"><?php echo get_phrase('classname');?></label>
                                <div class="controls">
                                     <select name="parentname" class="uniform validate[required]" onchange="return getVal(this.value)">
                                    	<option value="">--- Select Poll Category --- </option>
                                         <option value="parent">Parent</option>
										 <option value="teacher">Teacher</option>
										 <option value="student">Student</option>
                                    </select>
                                </div>
                            </div>
							<div class="control-group" style="display:none;" id="show_div_stu">
                                <label class="control-label"><?php echo get_phrase('classname');?></label>
                                <div class="controls">
                                     <select name="classname" class="uniform validate[required]">
                                    	<option value="">--- Select Class Name --- </option>
                                         <?php foreach ($student_class as $class):?>
										 <option value="<?php echo $class->class_id?>"><?php echo $class->name." ".$class->name_numeric?> </option>
										 <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                        	<div class="control-group">
                            <label class="control-label"><?php echo get_phrase('Polls Question');?></label>
                                <div class="controls">
                                   <input type="text" name="question" class="validate[required]" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('Poll Option');?></label>
                                <div class="controls">
                                   <input type="text" name="option[]" class="validate[required]" />&nbsp;&nbsp;&nbsp;&nbsp; </div>
                            <div style=" float: left; left: 450px; position: absolute;" onclick="return addMore();">Add More</div></div>
                            <div class="control-group" id="polls">
                          <label class="control-label"><?php echo get_phrase('Poll Option');?></label>
                                <div class="controls">
                                   <input type="text" name="option[]" class="validate[required]" />&nbsp;&nbsp;&nbsp;&nbsp; </div>
                            </div>
                            <div id="pollslist"></div>
                            <!-- <div class="control-group">
                                <label class="control-label"><?php //echo get_phrase('ans');?></label>
                                <div class="controls">
                                   <input type="text" name="ans" class="validate[required]" />
                                </div>
                            </div>-->
                              
                            
                            <div id="clonediv"></div>
                                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-gray"><?php echo get_phrase('add_question');?></button>
                        </div>
                    </form>                
                </div>                
			</div>
			<!----CREATION FORM ENDS--->
            
		</div>
	</div>
</div>
<script>
   function getVal(val){
	   if(val=='student'){
		   document.getElementById("show_div_stu").style.display='block';
	   }else{
	   document.getElementById("show_div_stu").style.display='none';
	   }
   }
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
  $( "#polls" ).clone().appendTo( "#pollslist" ).append("<div onclick='$(this).parent().remove();' style='left:456px;cursor:pointer;position: absolute;'>Remove</div>");
}
</script>