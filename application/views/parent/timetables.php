<div class="box">
	<div class="box-content padded">
    
        <div class="row-fluid">
        	<div class="span12">
            <div id="tam-timetable" class="accordion tam-timetable-accordion">
                
                <?php if(!empty($timetable_view)) { $tc=1; foreach($timetable_view as $timetable_view_list){  ?>
                <div class="accordion-group">
                  <div class="accordion-heading">
                    <a href="#collapse_<?php echo $timetable_view_list['timetable_id'] ?>" data-parent="#tam-timetable" data-toggle="collapse" class="accordion-toggle">
                     <?php echo $timetable_view_list['timetable_title'] ?>
                    <span style="float:right;">Added on <?php echo date("d-F-Y",strtotime($timetable_view_list['timetable_modified_date'])); ?></span></a>
                  </div>
                  <div class="accordion-body <?php if($tc==1) echo "in"; ?> collapse" id="collapse_<?php echo $timetable_view_list['timetable_id'] ?>">
                    <div class="accordion-inner">
                     <?php echo $timetable_view_list['timetable_content'] ?>
                    </div>
                  </div>
                </div>
                <?php $tc++; } } ?>
                
              </div>
            
           
            	    
            
            </div>
        </div>
		
	</div>
</div>