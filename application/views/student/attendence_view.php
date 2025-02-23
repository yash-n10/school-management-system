<div class="box">
    <div class="box-header">
        <!------CONTROL TABS START------->

        <ul class="nav nav-tabs nav-tabs-left">
            <li class="active">
                <a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> 
                    <?php echo get_phrase('attendence_view'); ?>
                </a>
            </li>
        </ul>

        <!------CONTROL TABS END------->
    </div>
    <div class="box-content padded">
		<div class="tab-content">
            <!----TABLE LISTING STARTS--->
            <style type="text/css">   
			#container {
				height: 400px; 
				min-width: 310px; 
				max-width: 800px;
				margin: 0 auto;
			}
            </style>
            <script>
            var total_present_days = <?php echo $present_day; ?>; 
            var total_working_days = <?php echo $work_day; ?>; 
            
           </script>
		<script src="http://code.highcharts.com/highcharts.js"></script>
		<script src="http://code.highcharts.com/highcharts-3d.js"></script>
		<script src="http://code.highcharts.com/modules/exporting.js"></script>
		<script>
			$(function () {
				$('#container').highcharts({
			
					chart: {
						type: 'column',
						options3d: {
							enabled: true,
							alpha: 15,
							beta: 15,
							viewDistance: 25,
							depth: 40
						},
						marginTop: 80,
						marginRight: 40
					},
					credits: {
							  enabled: false
						},
					title: {
						text: ''
					},
			
					xAxis: {
						categories: ['JAN', 'FEB', 'MARCH', 'APPRIL', 'MAY','JUNE','JULY','AUGUST','SEPTEMBER','OCTOBER','NOVEMBER','DECEMBER']
					},
			
					yAxis: {
						allowDecimals: false,
						min: 0,
						title: {
							text: 'Number of days'
						}
					},
			
					tooltip: {
						headerFormat: '<b>{point.key}</b><br>',
						pointFormat: '<span style="color:{series.color}">\u25CF</span> {series.name}: {point.y} / {point.stackTotal}'
					},
			
					plotOptions: {
						column: {
							stacking: 'normal',
							depth: 20
						}
					},
			
					series: [{
							name: 'Total Working Days',
							data: total_working_days ,
							stack: 'male'
						}, {
							name: 'Total Present Days',
							data: total_present_days,
							stack: 'female'
						}
						]
				});
			});
		</script>
		<div id="container" style="height: 400px"></div>
            <!----TABLE LISTING ENDS--->
            </div>
	</div>
</div>

   