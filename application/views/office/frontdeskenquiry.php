<?php //print_r($departments) ?>

<div class="box">
	<div class="box-header">
    
    	<!------CONTROL TABS START------->
		<ul class="nav nav-tabs nav-tabs-left">
        <li class="active"> <a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> <?php echo get_phrase('front_desk_enquiry');?> </a></li>
        <li> <a href="#add" data-toggle="tab" onclick="GetTime()"><i class="icon-plus"></i> <?php echo get_phrase('add_enquiry');?> </a></li>
      </ul>
    	<!------CONTROL TABS END------->
        
	</div>
	<div class="box-content padded">
		<div class="tab-content">
            <!----TABLE LISTING STARTS--->
            <div class="tab-pane  active" id="list">
            		<!--<div class="action-nav-normal">
                        <div class="" style="width:300px;margin-left:33%;">
                          <a href="#" title="Users">
                            <img src="<?php //echo base_url();?>template/images/icons/staff.png" /><br>
                            <span>Total <?php //echo count($staffs);?> staffs</span>
                          </a>
                        </div>
                    </div>-->
                    <div class="box">
                        <div class="box-content">
                      <form method="post" action="<?php echo base_url();?>admin/frontdeskenquiry/" class="form-horizontal validatable" enctype="multipart/form-data" name="getfrm">
                        <input type="text" class="datepicker fill-up validate[required]" name="edate"  value="<?php echo $edate ?>"/>
                        <button class="btn btn-info" type="button" onclick="fsub()">Get Enquiries</button>
                       </form>
                       <script>
					   function fsub(){
						   document.getfrm.submit();
					   }
					   </script>
                        
                            <div id="dataTables">
                            <table cellpadding="0" cellspacing="0" border="0" class="responsive" id="frontdeskenquiry_dtable">
                                <thead>
                                    <tr>
                                        <th><div><?php echo get_phrase('S.No');?></div></th>
                                        <th><div><?php echo get_phrase('visited_id');?></div></th>
                                        <th><div><?php echo get_phrase('name');?></div></th>
                                        <th><div><?php echo get_phrase('date');?></div></th>
                                        <th><div><?php echo get_phrase('time');?></div></th>
                                        <th><div><?php echo get_phrase('phone');?></div></th>
                                        <th><div><?php echo get_phrase('purpose');?></div></th>
                                        <th><div><?php echo get_phrase('meet_person');?></div></th>
                                        <th><div><?php echo get_phrase('Address');?></div></th>
                                        <!--<th><div><?php echo get_phrase('options');?></div></th>-->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $count = 1;foreach($frontdeskenquiry_data as $row):?>
                                    <tr>
                                        <td><?php echo $count;?></td>
                                        <td><?php echo $row['visit_id'];?></td>
                                        <td><?php echo $row['name'];?></td>
                                        <td><?php echo date('d/m/Y', strtotime($row['visit_date']));?></td>
                                        <td><?php echo $row['visit_intime'];?></td>
                                        <td><?php echo $row['phone'];?></td>
                                        <td><?php echo $row['purpose'];?></td>
                                        <td><?php echo $row['meetperson'];?></td>
                                        <td><?php echo $row['address'];?></td>
                                        <!--<td align="center">
                                        
                                        
                                            <a  data-toggle="modal" href="#modal-form" onclick="modal('staff_id_card',<?php //echo $row['staff_id']; ?>)" class="btn btn-red btn-small">

                                                            <i class="icon-credit-card"></i> <?php //echo get_phrase('id_card'); ?>

                                                        </a>
                                            <a data-toggle="modal" href="#modal-form" onclick="modal('staff_profile',<?php //echo $row['staff_id'];?>)"
                                                 class="btn btn-green btn-small">
                                                    <i class="icon-user"></i> <?php //echo get_phrase('profile');?>
                                            </a>
                                            <a data-toggle="modal" href="#modal-form" onclick="modal('edit_staff',<?php //echo $row['staff_id'];?>)"	class="btn btn-gray btn-small">
                                                    <i class="icon-wrench"></i> <?php //echo get_phrase('edit');?>
                                            </a>
                                            <a data-toggle="modal" href="#modal-delete" onclick="modal_delete('<?php //echo base_url();?>admin/staff/delete/<?php //echo $row['staff_id'];?>')"
                                                 class="btn btn-red btn-small">
                                                    <i class="icon-trash"></i> <?php //echo get_phrase('delete');?>
                                            </a>
                                        </td>-->
                                    </tr>
                                    <?php $count++; endforeach;?>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
			</div>
            <!----TABLE LISTING ENDS--->
            
            
			<!----CREATION FORM STARTS---->
			<div class="tab-pane box" id="add" style="padding: 5px">
                <div class="box-content">
                	 <form method="post" action="<?php echo base_url();?>admin/frontdeskenquiry/create/" class="form-horizontal validatable" enctype="multipart/form-data">
                    
                        <div class="padded">
                        	 <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('time');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" name="ptime" id="ptime" placeholder="time" value="<?php echo date('H:i') ?>" readonly="readonly"/>
                                </div>
                            </div>
                            <script>
							function getDateTime() {
								var now     = new Date(); 
								var year    = now.getFullYear();
								var month   = now.getMonth()+1; 
								var day     = now.getDate();
								var hour    = now.getHours();
								var minute  = now.getMinutes();
								var second  = now.getSeconds(); 
								if(month.toString().length == 1) {
									var month = '0'+month;
								}
								if(day.toString().length == 1) {
									var day = '0'+day;
								}   
								if(hour.toString().length == 1) {
									var hour = '0'+hour;
								}
								if(minute.toString().length == 1) {
									var minute = '0'+minute;
								}
								if(second.toString().length == 1) {
									var second = '0'+second;
								}   
								//var dateTime = year+'-'+month+'-'+day+' '+hour+':'+minute+':'+second;   
								// return dateTime;
								 
								 var time = hour+':'+minute+':'+second;   
								 return time;
							}
							function GetTime(){
								//var dt = new Date();
							   // var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
								//alert(time);
								var time =  getDateTime();
								document.getElementById('ptime').value = time;
							}
							</script>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('name');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" name="firstname" placeholder="First Name"/>
                                    <input type="text" class="" name="lastname" placeholder="Last Name" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('phone');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" name="phone" placeholder="Phone"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('purpose_to_visit');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" name="purpose" placeholder="Purpose"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('meet_person');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" name="mperson" placeholder="Meet Person"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo get_phrase('coming_from');?></label>
                                <div class="controls">
                                    <input type="text" class="validate[required]" name="cfrom" placeholder="Came from - Place"/>
                                </div>
                            </div>
                            <div class="control-group">

                                <label class="control-label"><?php echo get_phrase('present_address'); ?></label>

                                <div class="controls">

                                    <textarea name="address" class="validate[required]" rows="6" columns="4" placeholder="Present Address"></textarea>

                                </div>

                            </div>

                            
                            
                            
                            
                            
                            
                            
                            
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-gray"><?php echo get_phrase('add_enquiry');?></button>
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
	
	
	
	$('#emp_code_val').on('change',function(){
		
		var tcode = $(this).val();
		
		$('#val_emp_code_img').append('<img title="<?php echo base_url(); ?>template/images/loading.gif" src="<?php echo base_url(); ?>template/images/loading.gif">');
		
		$.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>admin/schcodecheck/',
							data: { chkcode:tcode },
							success: function(data) {
								//alert(data);
								
								if(data=='true'){
									$("#val_emp_code_img").text('').attr("class","label label-warning").text( "'"+ tcode +" ' already register try another !" );
									$("#emp_code_val").val('').focus();
								} else {
									$("#val_emp_code_img").removeAttr("class").text('').attr("class","label label-success").text( "'"+ tcode +"' available !" );
									
								}
								
							}
				  });
		
	});
	
	$('#staff_uname_val').on('change',function(){
		
		var temail = $(this).val();
		
		 if (!validateEmail(temail)) {
			$("#val_uname_img").removeAttr("class").attr("class","label label-warning").text('').text('Please enter valid email!'); 
			$("#staff_uname_val").val('').focus();
			return false;
         }
		
		$('#val_uname_img').append('<img title="<?php echo base_url(); ?>template/images/loading.gif" src="<?php echo base_url(); ?>template/images/loading.gif">');
		
		$.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>admin/schemailcheck/',
							data: { chkmail:temail },
							success: function(data) {
								//alert(data);
								
								if(data=='true'){
									$("#val_uname_img").text('').attr("class","label label-warning").text( "'"+ temail +" ' already register try another !" );
									$("#staff_uname_val").val('').focus();
								} else {
									$("#val_uname_img").removeAttr("class").text('').attr("class","label label-success").text( "'"+ temail +"' available !" );
									
								}
								
							}
				  });
		
	});
	
	$('#staff_email_val').on('change',function(){
		
		var temail = $(this).val();
		
		 if (!validateEmail(temail)) {
			$("#val_email_img").removeAttr("class").attr("class","label label-warning").text('').text('Please enter valid email!'); 
			$("#staff_email_val").val('').focus();
			return false;
        }
		
		$('#val_email_img').append('<img title="<?php echo base_url(); ?>template/images/loading.gif" src="<?php echo base_url(); ?>template/images/loading.gif">');
		
		$.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>admin/schtemailcheck/',
							data: { chkmail:temail },
							success: function(data) {
								//alert(data);
								
								if(data=='true'){
									$("#val_email_img").text('').attr("class","label label-warning").text( "'"+ temail +" ' already register try another !" );
									$("#staff_email_val").val('').focus();
								} else {
									$("#val_email_img").removeAttr("class").text('').attr("class","label label-success").text( "'"+ temail +"' available !" );
									
								}
								
							}
				  });
		
	});
	
	
	
	
// Function that validates email address through a regular expression.
function validateEmail(temail) {
	  var filter =  /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
    
   if (filter.test(temail)) {
        return true;
    }
    else {
        return false;
    }
}
</script>

<script src="<?php echo base_url(); ?>template/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>template/js/jquery.dataTables.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>template/css/dataTables.tableTools.css">
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>template/js/dataTables.tableTools.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>template/js/dataTables.bootstrap.js"></script>
<script>var $j = jQuery.noConflict(true);</script>
<script>
$(document).ready(function() {
    $j('#frontdeskenquiry_dtable').DataTable( {
		dom: 'T<"clear">lfrtip',
		 tableTools: {
            "sSwfPath": "<?php echo base_url(); ?>template/swf/copy_csv_xls_pdf.swf",
			"aButtons": [
            {
                "sExtends": "copy",
                "mColumns": [0, 1, 2, 3, 4, 5, 6, 7, 8]
            },
            {
                "sExtends": "csv",
                "mColumns": [0, 1, 2, 3, 4, 5, 6, 7, 8]
            },
            {
                "sExtends": "pdf",
                "mColumns": [0, 1, 2, 3, 4, 5, 6, 7, 8]
            },
            {
                "sExtends": "print",
                "mColumns": [0, 1, 2, 3, 4, 5, 6, 7, 8]
            },
        ]
        }
	} );
} );
</script>