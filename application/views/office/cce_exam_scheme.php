<div class="box"> 
  <div class="row-fluid">
    <div class="span12">
      <div class="custom-tam-hr-frm">
        <div class="row-fluid">
          <div class="span4 offset3">
            <div class="control-group">
              <div class="controls">
                <center>
                  <div class="box">
                    <div class="box-header"> <span class="title"> <i class="icon-info-sign"></i> Please select a class to manage exam scheme.</span> </div>
                    <div class="box-content padded tam-custom-border1"> <br />
                      <select name="class_id" onchange="window.location='<?php echo base_url(); ?>admin/examscheme/'+this.value">
                        <option value=""><?php echo get_phrase('select_a_class'); ?></option>
                        <?php
						$classes = $this->db->get('class')->result_array();
						foreach ($classes as $row):
							?>
                        <option value="<?php echo $row['class_id']; ?>"
                            <?php if ($class_id == $row['class_id']) echo 'selected'; ?>> <?php echo $row['name'].'-'.$row['name_numeric']; ?></option>
                        <?php
                        endforeach;
                        ?>
                      </select>
                      
                      <!--<hr />--> 
                      
                       
                    </div>
                  </div>
                </center>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="box-content padded">
  
  <style>
  
  </style>
    <div class="tab-content"> 
      <!----TABLE LISTING STARTS--->
      <?php if($class_id){  //print_r($termdata);?>
      <div class="accordion" id="examscheme_panel">
      
      <?php $sn=1; foreach($termdata as $termdataview) { ?>
        <div class="accordion-group">
          <div class="accordion-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#examscheme_panel" href="#collapse_<?php echo $termdataview['term_id']; ?>"> <?php echo $termdataview['term_name']; ?></a> </div>
          <div id="collapse_<?php echo $termdataview['term_id']; ?>" class="accordion-body collapse <?php if($sn==1) echo "in" ?>">
            <div class="accordion-inner"> 
            
            	<?php
						 $ci =& get_instance();
						$ci->db->where('term_name',$termdataview['term_id']);
						$qry = $ci->db->get('cce_assessment_assign');
						
						$assdata = $qry->result_array();
						
						foreach($assdata as $assdataview){ ?>
							
							
                            <div class="assn-title">
                            	<span>
                                	<?php echo $assdataview['assessement_name']; ?>
                                </span>
                                <span>
                                	<a href="javascript:;" data-assn-id="<?php echo $assdataview['assessement_id']; ?>" class="btn btn-danger cstm-add-tst btn-mini" data-assn-nm="<?php echo $assdataview['assessement_name']; ?>">Add New</a>
                                </span>
                            </div>
                            <div class="sup"></div>
                            <?php
								
								   // $ci =& get_instance();
									$ci->db->where('test_assessement_id',$assdataview['assessement_id']);
									$ci->db->where('test_class_id',$class_id);
									$ci->db->where('test_delete',0);
									$tstqry = $ci->db->get('cce_tests');
									
									$tstdata = $tstqry->result_array();
									
									$sno=1;
									foreach($tstdata as $tstdataview) {
							
							 ?>
                           
                                	<div class="tst-blk">
                                    <span><?php echo $sno; ?>.</span>
                                    <span><?php echo $tstdataview['test_name']; ?></span>
                                    <span class="cstm-del-tst" data-tstid="<?php echo $tstdataview['test_id']; ?>" data-tstnm="<?php echo $tstdataview['test_name']; ?>"> x </span>
                                    </div>
                            
                            <?php  $sno++; } ?>
                            
                            <?php
						}
				
				 ?>
                
            
            
            </div>
          </div>
        </div>
      <?php $sn++; } ?>
        
      </div>
      <input type="hidden" id="hid_cid" value="<?php echo $class_id ?>" name="hid_cid" />
      <?php } else { ?>
      <script>

                        $(document).ready(function() {

                            function ask()

                            {
                                Growl.info({title:"Select a class to manage exam scheme",text:" "});
                            }

                            setTimeout(ask, 500);

                        });

                    </script>
      <?php } ?>
      <!----TABLE LISTING ENDS---> 
      
    </div>
  </div>
</div>
<script>
$('.cstm-add-tst').on('click',function(e){
	var assnmtid = $(this).data('assn-id');
	
	var assnmtnm = $(this).data('assn-nm');
	
	var cid = $('#hid_cid').val();
	
	//alert(cid);
	
	$('#custom-tam-model').text('').append('<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h3 id="custom-tam-mode">Add Test to '+ assnmtnm +'</h3></div><div class="modal-body"><div id="tst-overlay" style="display:none;"><img src="<?php echo base_url() ?>/template/images/ajax-loader-2.gif"></div><div id="tst-feedback"></div><form class="form-horizontal" method="post" action="#" id="test-ad-frm" style="margin-top:25px;"><div class="control-group"><label class="control-label" for="">Test Name</label><div class="controls"><input type="text" name="test_name" id="test_name" ></div></div><div class="control-group"><div class="controls"><input type="hidden" value="'+assnmtid+'" id="asmntid" name="asmntid"><input type="hidden" value="'+cid+'" id="asmntcid" name="asmntcid"><button type="button" class="btn btn-success" id="adtstbtn">Add Test</button></div></div></form></div><div class="modal-footer"><button class="btn btn-success btn-small" data-dismiss="modal" aria-hidden="true">Close</button></div>');
	e.preventDefault();
	$('#custom-tam-model').modal('show');
});

$(document).on('click','#adtstbtn',function(e){
	
	var test_name = $('#test_name').val();
	
	if(test_name.trim()==''){
		$('#tst-feedback').text('').append('<div class="alert alert-danger"><strong>Please enter test name!</strong> </div>');
		return true;
	}
	
	$('#tst-overlay').show();
	$.ajax({
			type: 'POST',
			url: '<?php echo base_url(); ?>admin/cce_add_test_data',
			data:$( '#test-ad-frm' ).serialize(),
			success: function(data) {
			
				if(data == 'true'){
					$('#tst-feedback').text('').append('<div class="alert alert-success"><strong>Added test successfully!</strong> </div>');
					$('#test-ad-frm,#tst-overlay').hide();
					//setTimeout('hidemodel()', 3000);
					location.reload();
				} else {
					
					$('#tst-feedback').text('').append('<div class="alert alert-danger"><strong>An error while adding test!</strong> Please try again. </div>');
					$('#tst-overlay').hide();
				}

						
			}
	});
	
});

$('.cstm-del-tst').on('click',function(e){

 var tid = $(this).data('tstid');	
  var tnm = $(this).data('tstnm');	
 
 $('#custom-tam-model').text('').append('<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h3 id="custom-tam-mode">Are you sure !</h3></div><div class="modal-body">Do you want to delete '+tnm+'</div><div class="modal-footer"><button class="btn btn-info btn-small" id="del-test" value="'+tid+'">Ok</button><button class="btn btn-success btn-small" data-dismiss="modal" aria-hidden="true">Cancel</button></div>');
	e.preventDefault();
	$('#custom-tam-model').modal('show');

});

$(document).on('click','#del-test',function(){
	var tid =  $(this).val();	
	//alert(tid);
	
	$.ajax({
			type: 'POST',
			url: '<?php echo base_url(); ?>admin/cce_del_test_data',
			data:{ t_id : tid },
			success: function(data) {
			
				if(data == 'true'){
					$('#custom-tam-model').modal('hide');
					
					alert('Test deleted successfully!');
					
					location.reload();
				} else {
					
					$('#custom-tam-model').modal('hide');
					
					alert('An error occured while deleting test, Please try again!');
				}

						
			}
	});
	
});

</script>