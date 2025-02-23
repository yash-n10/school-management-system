<div class="box">
	<div class="box-header">
    	<!------CONTROL TABS START------->
		<ul class="nav nav-tabs nav-tabs-left">
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> 
					<?php echo get_phrase('daily_attendence');?>
                    	</a></li>
		</ul>
    	<!------CONTROL TABS END------->
	</div>
	<div class="box-content padded">
		<div class="tab-content">
            <!----TABLE LISTING STARTS--->
            <div class="tab-pane box active" id="list">
            <div class="row-fluid">
            <div class="span8 offset2">
            <div id="tam-daily-calendar"></div>
            </div>
            </div>
				
                
			</div>
            <!----TABLE LISTING ENDS--->
		</div>
	</div>
</div>
<style>

</style>
<script>

	$(document).ready(function() {

		$('#tam-daily-calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				//right: 'month,agendaWeek,agendaDay'
			},
			defaultDate: '2014-09-12',
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			events: [
			<?php if(!empty($ad_data)) foreach($ad_data as $ad_data_view) {
				
					$fg = $ad_data_view->present_flag;
					if($fg == 'A') {  $flag = "Absent" ; $cls = "custom-tam-absent";} else {$flag = "Present"; $cls = "custom-tam-present";}
				  ?>
				{
					title: '<?php echo $flag ?>',
					start: '<?php echo $ad_data_view->present_date ?>',
					className : '<?php echo $cls;  ?>'
				},
			<?php } ?>
			
			]
		});
		
	});

</script>