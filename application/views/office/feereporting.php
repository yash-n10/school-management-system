<style>

.custom-tam-main-select-block,.custom-tam-table-fee{
	padding:5px 20px;
	-webkit-box-shadow: 0px 0px 3px 1px rgba(0,0,0,0.75);
	-moz-box-shadow: 0px 0px 3px 1px rgba(0,0,0,0.75);
	box-shadow: 0px 0px 3px 1px rgba(0,0,0,0.75);
	margin-bottom:20px;
}

.custom-tam-main-select-block .form-horizontal{
	padding-top:15px;
}
.custom-tam-main-select-block .form-horizontal .controls{
	margin-left: 0;
}
.custom-tam-main-select-block .form-horizontal .control-label{
	width:auto;
	padding-right:10px;
}
.pinfo{
	text-align:center;
	padding:15px;
	font-weight:700;
	color:#333;
}

label.error {  
	color: #FB3A3A;
    display: inline-block;
	margin:2px 0;
    padding-left: 5px;
    text-align: left;
	}
	
#feereport_dtable tfoot th{
	padding:0;
}
#feereport_dtable tfoot th select{
	width:100% !important;
	height:30px;
}
</style>

<div class="box">
	<div class="box-content padded">
    
    
    	<div class="custom-tam-main-select-block">
    	<div class="row-fluid form-horizontal">
        	<form action="" method="post" name="" id="" class="validatable" >
            
            <?php if(!empty($sel_data)) @extract($sel_data); ?>
        		<div class="span5">
                		
                       
                        <div class="control-group">
                        <label class="control-label" for="fee_report_class_id"><?php echo get_phrase('class');?></label>
                        <div class="controls">
                        	<select name="fee_report_class_id" id="fee_report_class_id" class="span8 validate[required]" >
                            	<option value="">--- select class ---</option>
                               	
                                <?php if(!empty($class_data)) { foreach($class_data as $class_data_view){ ?>
                              	
                                	<option value="<?php echo $class_data_view->class_id ?>" <?php if($class_data_view->class_id == $rcid) echo "selected"; ?>><?php echo $class_data_view->name.'-'.$class_data_view->name_numeric ?></option>
                                
                                <?php } } ?>
                                
                            </select>
                            <span id="val_fc_class_id"></span>
                        </div>
                        </div>
               </div>
               <div class="span5">
                        
                        <div class="control-group">
                        <label class="control-label" for="fee_report_particular"><?php echo get_phrase('particular');?></label>
                        <div class="controls">
                        	<select name="fee_report_particular" id="fee_report_particular" class="span8 validate[required]" >
                            	<option value="">--- select class first---</option>
                            </select>
                            
                        </div>
                        </div>
                        
                       
                        
                
                </div>
                <div class="span2">
                	<button type="submit" class="btn btn-info">Submit</button>
                </div>
                </form>
                
        
        </div>
        </div>
        <?php if(!empty($ptr_data)) { ?>
        <div class="custom-tam-main-select-block">
        
        <div class="row-fluid">
        
        <?php //print_r($student_data);
					 @extract($ptr_data); $ci =& get_instance();  $ci->load->model('fee_model');
					 
					 $fperiod_data = $ci->fee_model->getfeeperiod($fee_particular_id);
					 
					 @extract($fperiod_data);
					 
					 $pamount = $fee_particular_amount;
					 
					 $pdiscount = $fee_particular_discount;
					 
					 $payamount = ($pamount - $pdiscount);
					 
					  ?>
        
        		<div class="span3">
                	<div class="pinfo"><?php echo $fcategory.' - '.$fee_particular_name ; ?></div>
                </div>
                <div class="span3">
                	<div class="pinfo">Start Date: <?php echo date("d-m-Y",strtotime($fee_period_sdate)); ?></div>
                </div>
                <div class="span3">
                	<div class="pinfo">End Date: <?php echo date("d-m-Y",strtotime($fee_period_edate)); ?></div>
                </div>
                <div class="span3">
                	<div class="pinfo">Due Date: <?php echo date("d-m-Y",strtotime($fee_period_ddate)); ?></div>
                </div>
                
        </div>
        
        </div>
        <div class="row-fluid">
        	<div class="span12">
            	<div class="pinfo">
                	<button class="btn btn-success" id="custom-sms-unpaid">Send SMS Unpaid Members</button>
                </div>
            </div>
        </div>
        <?php } ?>
        <div class="row-fluid">
        
        		<div class="span12">
                
                	
                     <form id="unpaid_sms_mul_fm" name="unpaid_sms_mul_fm" method="post">
                    <table cellpadding="0" cellspacing="0" border="0" class="responsive" id="feereport_dtable">

                                        <thead>

                                            <tr>
    
                                                <th><div><?php echo get_phrase('roll'); ?></div></th>
        
                                                <th><div><?php echo get_phrase('student_name'); ?></div></th>
        
                                                <th><div title="After discount applied"><?php echo get_phrase('payable_amount*'); ?></div></th>
        
                                                <th><div><?php echo get_phrase('paid_amount'); ?></div></th>
        
                                                <th><div><?php echo get_phrase('due_amount'); ?></div></th>
                                                
                                                <th><div><?php echo get_phrase('payment_status'); ?></div></th>
                                               
    
                                            </tr>

                                        </thead>
                                        
                                        <tfoot>
                                            <tr>
                                                 <th><?php echo get_phrase('roll'); ?></th>
                                            
                                                 <th><?php echo get_phrase('student_name'); ?></th>
                                            
                                                 <th><?php echo get_phrase('payable_amount*'); ?></th>
                                            
                                                 <th><?php echo get_phrase('paid_amount'); ?></th>
                                            
                                                 <th><?php echo get_phrase('due_amount'); ?></th>
                                                                                    
                                                 <th><?php echo get_phrase('payment_status'); ?></th>
                                            </tr>
                                        </tfoot>

                                        <tbody>
                                        
                                        
                                        <?php foreach($student_data as $student_data_view) { 
										
										$fp_payamount = $ci->fee_model->getSumPaid($fee_particular_id,$student_data_view->class_id,$student_data_view->student_id);
							
										if($fp_payamount !=''){
											
											$fppaidamount =$fp_payamount;
										} else {
											$fppaidamount = 0;
										}
										
										$dueamount = ($payamount - $fppaidamount);
										
										
										
										?>
                                        	
                                        	<tr>
                                            	
                                                <td align="right"><?php echo $student_data_view->roll ?></td>
                                                
                                                <td><?php echo $student_data_view->name ?></td>
                                                
                                                <td align="right"><?php echo $payamount; ?></td>
                                                
                                                <td align="right"><?php echo $fppaidamount; ?></td>
                                                
                                                <td align="right"><?php echo $dueamount; ?>
                                                
                                                
                                                 <?php if($dueamount != 0) {  ?> <input type="checkbox" checked="checked" value="<?php echo $student_data_view->student_id ?>" name="smem[]" style="display:none" />  <?php } ?>
                                                
                                                </td>
                                                
                                                <td align="center"> <?php if($dueamount == 0) echo "Paid";
														   else echo "Unpaid"; ?></td>
                                            
                                            </tr>
                                           
                                          
                                            
                                        <?php } ?>
                                        
                                        </tbody>

                    </table>
                    
                    <input type="hidden" value="<?php echo $fcategory.' - '.$fee_particular_name ; ?>" name="hid_pname" id="hid_pname" />
                    <input type="hidden" value="<?php echo date("d-m-Y",strtotime($fee_period_ddate)); ?>" name="hid_pddate" id="hid_pddate" />
                    </form>
                    
                    
                
                </div>
                
        </div>
        
        
        
        
		
	</div>
</div>

<script>

$('#fee_report_class_id').on('change',function(){
	
	var report_cid = $(this).val();
	
	$('#val_fc_class_id').append('<img title="<?php echo base_url(); ?>template/images/loading.gif" src="<?php echo base_url(); ?>template/images/loading.gif">');
	
	
	call_pter(report_cid);
	
});

function call_pter(report_cid){
	
	$.ajax({
							type: 'POST',
							url: '<?php echo base_url(); ?>office/fee_report_get_particular/',
							data: { get_report_cid:report_cid },
							success: function(data) {
								//alert(data);
								
								$('#val_fc_class_id').text('');
									
								$('#fee_report_particular').text('').append(data);
								
							}
				  });
	
}

$('#custom-sms-unpaid').on('click',function(e){
	
	 $('#custom-tam-model-body-sms-unpaid').text('');
			  
			  var opts = document.getElementsByName('smem[]');
             var val_pass=false;	
			for(var i=0; i < opts.length; i++) {
				  if(opts[i].checked) {var val_pass=true;}
			}
			
			
			if(val_pass){
				$.ajax({
						type: 'POST',
						url: '<?php echo base_url(); ?>office/send_sms_unpaid_mem/',
						data: $( "#unpaid_sms_mul_fm" ).serialize(),
						success: function(data) {
							if(data !=''){
							
							$( "#custom-tam-model-body-sms-unpaid" ).append( '<p>SMS Send Successfully!</p>');
							}
						}
					});
			}
	         else {
				 $( "#custom-tam-model-body-sms-unpaid" ).append('<p>Unpaid Users Not Found!</p>' );
			 }
	
	e.preventDefault();
	$('#custom-tam-model-sms-unpaid').modal('show');
	
});

</script>
<script src="<?php echo base_url(); ?>template/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>template/js/jquery.dataTables.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>template/css/dataTables.tableTools.css">
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>template/js/dataTables.tableTools.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>template/js/dataTables.bootstrap.js"></script>
<script>var $j = jQuery.noConflict(true);</script>
<script>
$(document).ready(function() {
	
	$('#custom-tam-overlay').show();
	
	var table = $j('#feereport_dtable').DataTable({
		dom: 'T<"clear">lfrtip',
		 tableTools: {
            "sSwfPath": "<?php echo base_url(); ?>template/swf/copy_csv_xls_pdf.swf",
			"aButtons": [
            {
                "sExtends": "copy",
				"bFooter": false,
				 "oSelectorOpts": {
					page: 'current'
				}
            },
            {
                "sExtends": "csv",
				"bFooter": false,
				 "oSelectorOpts": {
					page: 'current'
				}
            },
            {
                "sExtends": "pdf",
				"bFooter": false,
				 "oSelectorOpts": {
					page: 'current'
				}
            },
            {
                "sExtends": "print",
				"bFooter": false,
				 "oSelectorOpts": {
					page: 'current'
				 }
            },
        ]
        }
	});
	
	$j("#feereport_dtable tfoot th").each( function ( i ) {
		
        var select = $j('<select><option value="">All</option></select>')
            .appendTo( $j(this).empty() )
            .on( 'change', function () {
                var val = $j(this).val();
 
                table.column( i )
                    .search( val ? '^'+$j(this).val()+'$' : val, true, false )
                    .draw();
            } );
 
        table.column( i ).data().unique().sort().each( function ( d, j ) {
            select.append( '<option value="'+d+'">'+d+'</option>' )
        } );
    } );
	
} );

$(window).load(function(){
	
	
	var report_cid = $('#fee_report_class_id').val();
	
	call_pter(report_cid);
	
	$('#custom-tam-overlay').hide();
	
});
</script>
