<div class="container-fluid padded">
                
                













<div style="float:none !important;" class="span11">
    <div class="box">
		<div class="box-header">
			<span class="title"> <i class="icon-info-sign"></i> Please select a class to send SMS.</span>
		</div>
		<div class="box-content padded tam-custom-border1">
		<script type="text/javascript">
		function getRoll(){
			exam_ids=document.getElementById("exam_ids").value;
			rollnumber=document.getElementById("rollnumber").value;
			if(exam_ids!=''){
			  document.getElementById("exam_id").disabled=true;
			  document.getElementById("exam_id").value='';
			  document.getElementById("class_id").disabled=true;
			  document.getElementById("class_id").value='';
			  document.getElementById("subject_id").disabled=true;
			  document.getElementById("subject_id").value='';
			}else if(rollnumber!='' && rollnumber!='0'){
			  document.getElementById("exam_id").disabled=true;
			  document.getElementById("exam_id").value='';
			  document.getElementById("class_id").disabled=true;
			  document.getElementById("class_id").value='';
			  document.getElementById("subject_id").disabled=true;
			  document.getElementById("subject_id").value='';
			}else{
				document.getElementById("exam_id").disabled=false;
			    document.getElementById("class_id").disabled=false;
			    document.getElementById("subject_id").disabled=false;
			}
		}
		function getRoll1(){
			    exam_id=document.getElementById("exam_id").value;
			    class_id=document.getElementById("class_id").value;
			    subject_id=document.getElementById("subject_id").value;
			if(exam_id!=''){
				document.getElementById("exam_ids").disabled=true;
				document.getElementById("rollnumber").disabled=true;
				document.getElementById("exam_ids").value='';
				document.getElementById("rollnumber").value='';
			}else if(class_id!=''){
			  document.getElementById("exam_ids").disabled=true;
				document.getElementById("rollnumber").disabled=true;
				document.getElementById("exam_ids").value='';
				document.getElementById("rollnumber").value='';
			}else if(subject_id!=''){
			  document.getElementById("exam_ids").disabled=true;
				document.getElementById("rollnumber").disabled=true;
				document.getElementById("exam_ids").value='';
				document.getElementById("rollnumber").value='';
			}else{
				document.getElementById("exam_ids").disabled=false;
				document.getElementById("rollnumber").disabled=false;
			}
		}
		</script>
		<form method="post" action ="">
		   <select name="exam_ids" id="exam_ids" onchange="return getRoll()">
                <option value="">Select Test</option>
				<?php foreach ($exam as $exams){?>
                                    <option value="<?php echo $exams['exam_id'];?>" <?php if($_POST['exam_ids']==$exams['exam_id']){?> selected="selected"<?php } ?>><?php echo $exams['name'];?></option>
				<?php } ?>
                            </select>
							<input type="text" name="rollnumber" id="rollnumber" placeholder="Roll Number.." onkeyup="return getRoll()" onkeydown="return getRoll()" value="<?php echo $_POST['rollnumber'];?>"/>
		   <br/>
		   (OR)
            <br>
            <select name="exam_id" id="exam_id"  onchange="return getRoll1()">
                <option value="">Select Test</option>
				<?php foreach ($exam as $exams){?>
                                    <option value="<?php echo $exams['exam_id'];?>" <?php if($_POST['exam_id']==$exams['exam_id']){?> selected="selected"<?php } ?>><?php echo $exams['name'];?></option>
				<?php } ?>
                            </select>
			<select name="class_id" id="class_id"  onchange="return getRoll1()"> 
                <option value="">Select A Class</option>
				<?php foreach ($class as $classes){?>
                                    <option value="<?php echo $classes['class_id'];?>" <?php if($_POST['class_id']==$classes['class_id']){?> selected="selected"<?php } ?>><?php echo $classes['name'];?></option>
				<?php } ?>
                            </select>
            <!--<hr />-->
           
			<select  name="subject_id" id="subject_id"  onchange="return getRoll1()">
                <option value="">Select Subject</option>
                               <?php foreach ($subject as $value){?>
                                    <option value="<?php echo $value['subject_id'];?>" <?php if($_POST['subject_id']==$value['subject_id']){?> selected="selected"<?php } ?>><?php echo $value['name'];?></option>
				<?php } ?>
                                    
                            </select> <input type="submit" value="GO" class="btn btn-gray"/>
							</form>
            <!--<hr />-->
            <script>
                $(document).ready(function() {
                    function ask()
                    {
                        Growl.info({title:"Select a class to send SMS",text:" "});
                    }
                    setTimeout(ask, 500);
      
                });
				
            </script>
			
			<?php 
			//echo "ff".count($marks);
			if(!empty($_POST) && count($marks)>0){?>
			<script type="text/javascript">
 window.onload = function () {
var chart = new CanvasJS.Chart("chartContainer",
{
title:{
text: "<?php echo $class_name[$_POST['class_id']];?> Mark List"
},
animationEnabled: true,
axisY: {
title: "Marks "
},
legend: {
verticalAlign: "bottom",
horizontalAlign: "center"
},
theme: "theme2",
data: [
{
type: "column",
showInLegend: true,
legendMarkerColor: "grey",
legendText: "Student vise marks graph",
dataPoints: [
<?php foreach ($marks as $markslist){?>
<?php if($markslist['subject_id']){?>
{y: <?php echo $markslist['mark_obtained'];?>, label: "R<?php echo $markslist['roll'];?>(<?php echo $subjectsall[$markslist['subject_id']];?>)"},
<?php }else{ ?>
{y: <?php echo $markslist['mark_obtained'];?>, label: "R<?php echo $markslist['roll'];?>"},
<?php }} ?>
]
}
]
});
chart.render();
}
</script>
           <script type="text/javascript" src="<?php echo base_url();?>/template/min/?f=zeesms_raj/template/js/canvasjs.min.js"></script>
			</div>
    </div>
	<div style="height: 300px; width: 100%;" id="chartContainer">  </div>
			<?php }else{?>
			NO GRAPH FOUND...
			<?php } ?>
	
</div>




            </div>
        
        
        
        
		
	

