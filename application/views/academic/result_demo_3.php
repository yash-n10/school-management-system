<?php
foreach ($result as $value) {
    
}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
		.table {
			width: 100%;
			max-width: 100%;
			margin-bottom: 0px; 
		}
		tr 
		{
			line-height: 15px;
			min-height: 15px;
			height: 15px;
		}
		.table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th 
		{
		    border: 1px solid black;
		}
		.p-5
		{
			height: 130px;
			width:100%; 
		}
		.earning
		{
			width:100%; 
		}
		.col-xs-12
		{
			width: 100%;
		}
		.col-md-6
		{
			width: 50%;
		}
		.col-md-8
		{
			width: 60%;
		}
		.col-md-4
		{
			width: 40%;
		}
		.earning .col-md-6
		{
			height: 250px;
		}

	
	</style>
</head>
<body>
	<div class="">
		<?php  $school_id=$school_data[0]->id; ?>
            <div class="" style="text-align: center;">
                <img src="assets/img/<?php echo $school_id.'.JPG';?>" style="height:100px">
                
            </div>
	  	<div class="row p-5">
            <div class="" style="width: 100%;position: absolute;">
                <center><h1><?php echo $school_data[0]->description;?></h1>
                <p class="font-weight-bold" style="margin: 0 0 1px;"><?php echo $school_data[0]->address;?></p>
                <p class="font-weight-bold" style="margin: 0 0 1px;">Affiliation No. XXXXXXX</p></center>
                <br>
                <p style="margin: 0 0 1px;"><span>Phone No.: <?php echo $school_data[0]->phone;?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span>Email Id: <?php echo $school_data[0]->email;?></span></p> 
                <p style="margin: 0 0 1px;"><span>Web: www.example.com</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span>CBSE Affiliation No.: 3530244</span></p> 

            </div>
            
        </div>
    </div>
    <br><br><br>
    <p class="font-weight-bold" style="text-align:center; font-size:20px;"><b><i>PERFORMANCE PROFILE</i></b></p>
    <p class="font-weight-bold" style="text-align:center">Class <?php echo $student_data[0]->class_name; ?> (Session: <?php echo $session; ?>)</p>
    <p class="font-weight-bold" style="text-align:center"><strong>CONTINUOUS AND COMPREHENSIVE EVALUATION</strong><br>
	(Issued by School as per the directives of Central Board of Secondary Education, Delhi) </p>



    	<div class="detail">					
		<table border="0" width="100%">						
		<!-- <table class="table table-bordered">						 -->
			<thead>
				<tr>
					<td colspan="4" style="padding: 8px;text-align:center;background-color:#002147;color:#fff;"><b>Student Profile</b></td>	
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Student Name</td>
					<td><?php echo ucwords(strtolower($student_data[0]->first_name .' '.$student_data[0]->middle_name.' '.$student_data[0]->last_name)); ?></td>								
					<td>Admission No</td>								
					<td><?php echo $student_data[0]->admission_no;?></td>								
				</tr>
				<tr>
					<td>Father Name</td>
					<td><?php echo ucwords(strtolower($student_data[0]->father_name));?></td>
					<td>Mother Name</td>
					<td><?php echo $student_data[0]->mother_name;?></td>								
				</tr>
				<tr>
					<td>Class</td>
					<td><?php echo $student_data[0]->class_name;?></td>
					<td>Section</td>
					<td><?php echo $student_data[0]->sec_name;?></td>								
				</tr>
				<tr>
					<td>Roll No</td>
					<td><?php echo $student_data[0]->roll;?></td>
					<td>D.O.B</td>
					<td><?php echo $student_data[0]->dob;?></td>								
				</tr>							
			</tbody>
		</table>
	</div> 
	<br>

	<div class="detail">					
		<table border="0" width="100%">						
			<thead>
				<tr>
					<td colspan="4" style="padding: 8px;text-align:center;background-color:#002147;color:#fff;"><b>Health Status</b></td>	
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Height</td>
					<td>160 cm</td>								
					<td>Weight</td>								
					<td>55 kg</td>								
				</tr>
				<tr>
					<td>Blood Group</td>
					<td>B +</td>
					<td>Vision</td>
					<td>(L) 6/6 (R) N6</td>								
				</tr>
				<tr>
					<td>Teeth</td>
					<td>normal</td>
					<td>Oral Hygiene</td>
					<td>GOOD</td>								
				</tr>						
			</tbody>
		</table>
	</div> 
<br>


	<div class="detail">					
		<table border="0" width="100%">						
			<thead>
				<tr>
					<td colspan="4" style="padding: 8px;text-align:center;background-color:#002147;color:#fff;"><b>Attendance</b></td>	
				</tr>
			</thead>
			<thead>
				<tr>
					<th style="text-align: left;">Attendance</th>	
					<th style="text-align: left;">Term1</th>	
					<th style="text-align: left;">Term2</th>	
				</tr>
			</thead>
			<tbody>
				<tr>
					<td style="text-align: left;">Total attendance of the student:</td>
					<td style="text-align: left;">100 days</td>								
					<td style="text-align: left;">150 days</td>																
				</tr>
				<tr>
					<td style="text-align: left;">Total working days: </td>
					<td style="text-align: left;">101 days</td>
					<td style="text-align: left;">150 days</td>							
				</tr>						
			</tbody>
		</table>
	</div> 
	<br>
		<p>Signature </p>
	 <p><span style="text-align: left">Class Teacher:----------------</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="text-align: center">Principal:------------------</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="text-align: right">Parent:------------------</span></p>

	 <br><br><br><br><br><br><br>


	 	<p><center><b>PART - 1 ACADEMIC PERFORMANCE : SCHOLASTIC AREAS</b></center></p>
	  	<div class="earning" style="margin-top: 10px;">
   		<div class="col-xs-12">					
			<div class="col-md-12" style="width: 100%;position: absolute;">
				<table class="table table-bordered" style="width:99%">						
					<thead>
						<tr>
							<th colspan="7" style="padding: 5px;text-align:center;background-color:#002147;color:#fff;">Term 1</th>
						</tr>
					</thead>
					<thead>
	                  <tr>
	                    <th scope="col">Subjects</th>
	                    <th scope="col">Unit Test</th>
	                    <th scope="col">Class Records</th>
	                    <th scope="col">Subject Enrichment</th>
	                    <th scope="col">Theory Exam</th>
	                    <th scope="col">Marks Obtained</th>
	                    <th scope="col">GR</th>
	                  </tr>
	                </thead>

	                 <tbody>
                         <?php $i = 1;
                          foreach ($result as $data) { ?>
                      <tr class="table-active">
                        <td scope="row"><?php echo $data->subjectname; ?></td>
                        <td><?php echo $data->periodic_test; ?></td>
                        <td><?php echo $data->note_book; ?></td>
                        <td><?php echo $data->sub_enrichment; ?></td>
                        <td><?php echo $data->written_exam; ?></td>
                        <td><?php echo $data->mark_obtained; ?></td>
                        <td><?php // echo $data->subjectname; ?></td>
                      </tr>
                       <?php $i++; } ?>
                    </tbody>
					
				</table>
			</div>



		</div>
			
							 
		</div> 
		<br><br><br><br><br>
		<br>
		<?php if ($exam_type=='TERM2') { ?>
		<div class="ctcc">
   		<div class="col-xs-12">					
			<div class="col-md-8" style="width: 100%;position: absolute;">
				<table class="table table-bordered">						
					<thead>
						<tr>
							<th colspan="7" style="padding: 5px;text-align:center;background-color:#002147;color:#fff;">Term 2</th>
						</tr>
					</thead>
					<thead>
	                  <tr>
	                    <th scope="col">Subjects</th>
	                    <th scope="col">Unit Test</th>
	                    <th scope="col">Class Records</th>
	                    <th scope="col">Subject Enrichment</th>
	                    <th scope="col">Theory Exam</th>
	                    <th scope="col">Marks Obtained</th>
	                    <th scope="col">GR</th>
	                  </tr>
	                </thead>

	                 <tbody>
                         <?php $i = 1;
                          foreach ($result as $data) { ?>
                      <tr class="table-active">
                        <td scope="row"><?php echo $data->subjectname; ?></td>
                        <td><?php echo $data->periodic_test; ?></td>
                        <td><?php echo $data->note_book; ?></td>
                        <td><?php echo $data->sub_enrichment; ?></td>
                        <td><?php echo $data->written_exam; ?></td>
                        <td><?php echo $data->mark_obtained; ?></td>
                        <td><?php // echo $data->subjectname; ?></td>
                      </tr>
                       <?php $i++; } ?>
                    </tbody>
					
				</table>
			</div>


			
		</div>
			
							 
		</div> 
	<?php } ?>

		<br><br><br>
		<table class="table table-bordered" style="width:100%">
			<thead>
						<tr>
							<th colspan="3" style="padding: 5px;text-align:center;background-color:#002147;color:#fff;">Co-Scholastic</th>
						</tr>
					</thead>
		 <!--  <tr>
		    <th></th>
		    <th></th> 
		    <th></th>
		  </tr> -->
		  <tr>
		    <td><b>Part 2 A : Life Skills</b></td>
		    <td><b>Term 1</b></td>
		    <td ><b>Term 2</b></td>
		  </tr>

		   <tr>
		    <td>i. Thinking Skills </td>
		    <td></td>
		    <td></td>
		  </tr>
		  <tr>
		    <td>ii. Social Skills</td>
		    <td></td>
		    <td></td>
		  </tr>
		  <tr >
		    <td>iii. Emotional Skills </td>
		    <td></td>
		    <td></td>
		  </tr>

		  <tr>
		    <td colspan="3"><b>2B: Work Education</b> </td>
		    <!-- <td></td>
		    <td></td> -->
		  </tr>

		   <tr>
		    <td>Work Education</td>
		    <td></td>
		    <td></td>
		  </tr>

		  <tr>
		    <td colspan="3"><b>2C: Visual and Performing Arts </b></td>
		    <!-- <td></td>
		    <td></td> -->
		  </tr>

		   <tr>
		    <td>Visual and Performing Arts</td>
		    <td></td>
		    <td></td>
		  </tr>

		  <tr>
		    <td colspan="3"><b>2D: Attitudes and Values </b></td>
		    <!-- <td></td>
		    <td></td>
 -->		  </tr>

		  <!--  <tr>
		    <td>Attitudes and Values</td>
		    <td></td>
		    <td></td>
		  </tr> -->

		   <tr>
		    <td>i. Towards Teachers</td>
		    <td></td>
		    <td></td>
		  </tr>

		   <tr>
		    <td>ii. Towards School mates</td>
		    <td></td>
		    <td></td>
		  </tr>


		   <tr>
		    <td>iii. Towards School Programmes & Environment</td>
		    <td></td>
		    <td></td>
		  </tr>


		   <tr>
		    <td>iv. Value Systems </td>
		    <td></td>
		    <td></td>
		  </tr>

		   
		</table>

		<table class="table table-bordered" style="width:100%">
			<thead>
						<tr>
							<th colspan="3" style="padding: 5px;text-align:center;background-color:#002147;color:#fff;">Co-Scholastic Activities</th>
						</tr>
					</thead>

		<tr>
		    <td><b>3A: Co-Scholastic Activities</b></td>
		    <td><b>Term 1</b></td>
		    <td><b>Term 2</b></td>

		  </tr>

		  <tr>
		    <td>i. Literary and Creative Skills </td>
		    <td></td>
		    <td></td>
		  </tr>

		   <tr>
		    <td>ii. Information and Communication Technology(ICT) </td>
		    <td></td>
		    <td></td>
		  </tr>

		   <tr>
		    <td><b>3B: Health and Physical Education</b></td>
		    <td></td>
		    <td></td>
		  </tr>

		  <tr>
		    <td>i. Sports / Indigenous Sports</td>
		    <td></td>
		    <td></td>
		  </tr>


		  <tr>
		    <td>ii. Yoga </td>
		    <td></td>
		    <td></td>
		  </tr>
		</table>
   	</div>  

        
        
        
    </body>
</html>