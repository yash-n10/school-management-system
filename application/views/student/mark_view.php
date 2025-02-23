<div class="box">
    <div class="box-header">
        <!------CONTROL TABS START------->

        <ul class="nav nav-tabs nav-tabs-left">
            <li class="active">
                <a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> 
                    <?php echo get_phrase('mark_view'); ?>
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
                
                var total_obtain_mark = <?php echo $mark; ?>; 
                var subject = <?php echo $subject_obtain; ?>; 
                var subject_total = <?php echo $subject_total; ?>;
                if(parseInt(subject_total)<30)
                {
                    var less=2;
                }
                else
                 {
var less=0;
                  }
                var title  ='<?php if(!empty($chart_title)){ echo get_phrase($chart_title. " "."Chart View"); } else { echo 'General Mark Views of All Exam' ; } ?>';
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
                            text:title
                        },
			
                        xAxis: {
                            categories: subject
                        },
			
                        yAxis: {
                            allowDecimals: false,
                            min: 0,
                            max:(parseInt(subject_total)-parseInt(less)),
                            title: {
                                text: 'Total Marks'
                            }
                        },
			
                        tooltip: {
                            headerFormat: '<b>{point.key}</b><br>',
                            pointFormat: '<span style="color:{series.color}">\u25CF</span> {series.name}: {point.y} / {point.stackTotal}'
                        },
			
                        plotOptions: {
                            column: {
                                stacking: 'normal',
                                depth: 10
                            }
                        },
			
                        series: [
                            {
                                name: 'Total  marks',
                                data: subject_total,
                                stack: 'male'
                            }, 
                            {
                                name: 'Total obtain marks',
                                data: total_obtain_mark,
                                stack: 'female'
                            }, 
                        ]
                    });
                });
            </script>
            <?php echo form_open('student/view_mark_chart'); ?>
            <table border="0" cellspacing="0" cellpadding="0" class="table table-normal box">
                <tr>
                    <td><?php echo get_phrase('select_exam'); ?></td>
                    <td>&nbsp;</td>
                </tr>

                <tr>
                    <td>
                        <select name="exam_id" class=""  style="float:left;">
                            <option value=""><?php echo get_phrase('select_an_exam'); ?></option>
                            <?php
                            $exams = $this->db->get('exam')->result_array();
                            foreach ($exams as $row):
                                ?>
                            <option value="<?php echo $row['exam_id']; ?>"
                            <?php if ($exam_id == $row['exam_id']) echo 'selected'; ?>>
                            <?php echo $row['name']; ?></option>
                            <?php
                            endforeach;
                            ?>
                        </select>
                    </td>
                    <td>
                        <input type="submit" value="<?php echo get_phrase('view_charts'); ?>" class="btn btn-normal btn-gray" />
                    </td>
                </tr>
            </table>
            </form>
            <div id="container" style="height: 400px"></div>
            <!----TABLE LISTING ENDS--->
        </div>
    </div>
</div>