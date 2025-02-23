<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="https://css-tricks.com/examples/BlurredText/js/jquery.lettering.js"></script>
  <style>
    table, th, td {
      /*border: 1px solid black;*/
      /*border-collapse: collapse;*/
    }
     table, th
     {
      font-size:12px;      
     }
     table, td, th {
    border: 1px solid #010d6d;
    text-align:center;
  }

  </style>
  <style>  
    #leftbox { 
      float:left;                  
      width:50%; 
      height:280px; 
    } 
    #middlebox{ 
      float:left;
      width:50%; 
      height:280px; 
    } 
    #table2{
      border:1px solid;
      border-collapse:separate; 
    }

    h1{ 
      color:green; 
      text-align:center; 
    } 
  </style>  
</head>
<body style="border:1px solid">
  <div class="" style="margin-left:5px;color:#010d6d" >
    <div class="">
      <div class="" style="text-align: center;">
        <h1 style="color:#010d6d"><?php echo $school_data[0]->description;?></h1>
        <!-- <img src="assets/img/vv_name.png" style="width:760px;"> -->
        <p class="font-weight-bold" style="margin: 20px 0 1px 0;">Affiliation No. XXXXXXX</p>
        <img src="assets/img/5.JPG" style="width:80px;margin: 2px 0 50px 50px;">               
      </div>
    </div>
    <div class="" style="width:500px">                
      <form>
       <center> 
        <fieldset align="center>" style="margin-left:190px;">
         <legend align="center">Report Card:</legend>
         <right>(Session :<?php echo $session; ?>)</right>
       </fieldset>
     </center>
   </form>
 </div><br><br>

 <div class="" style="width:700px">     
   <h3>STUDENT'S PROFILE</h3>           
   <form>
    <p> <a>Name of the student:<input type="text" value='<?php echo ucwords(strtolower($student_data[0]->first_name .' '.$student_data[0]->middle_name.' '.$student_data[0]->last_name)); ?>' style="width:450px;border:0px solid;margin-left:30px" ></a></p>
    
    <p><a>Class: <input type="text" size="10" value="<?php echo $student_data[0]->class_name;?>" style="width:120px;border:0px solid"></a><a> Sec: <input type="text" size="10" value="<?php echo $student_data[0]->sec_name;?>" style="border:0px solid;width:70px"></a>Roll: <input type="text" size="10" value="<?php echo $student_data[0]->roll;?>" style="width:266px;border:0px solid"></p>
    
    <p><a>Admission No: <input type="text" size="10" style="width:486px;border:0px solid;margin-left:60px" value="<?php echo $student_data[0]->admission_no;?>"></a></p>
    
    <p><a>Date of Birth: <input type="text" size="10" value="<?php echo $student_data[0]->dob;?>" style="width:495px;border:0px solid;margin-left:70px"></a></p>
    
    <p><a>Mother's Name: <input type="text" size="10" style="width:480px;border:0px solid;margin-left:55px" value="<?php echo $student_data[0]->mother_name;?>"></a></p>
    
    <p><a>Father's Name: <input type="text" size="10" style="width:490px;border:0px solid;margin-left:60px" value="<?php echo ucwords(strtolower($student_data[0]->father_name));?>"></a></p>
    
    <p><a>Residential Address: <input type="text" size="10" value="<?php echo $student_data[0]->address;?>" style="width:520px;border:0px solid;margin-left:30px"></a></p>
    <p><a>Telephone No.: <input type="text" size="10" style="width:489px;border:0px solid;margin-left:60px" value="<?php echo $student_data[0]->phone;?>"></a></p>

  </form>
</div>	     	
</div><br><br><br><br><br><br>

<div class="" style="color:#010d6d;width:100%">
	




</div>
<br><br><br>
<div id = "boxes"> 


  <div id = "leftbox"> 
   <div style="color:#010d6d">
    <center><h3>PUPIL'S PROGRESS</h3>  </center>
    <table style="width:98%;border-collapse: collapse;">
      <tr>
        <th colspan="2">Subject</th>
        <th>First Term</th> 
        <th>Second Term</th>
        <th>Overall Grade</th>
      </tr>

      <?php $i = 1;
      foreach ($result as $data) { ?>
        <tr>
          <td colspan="2">English</td>
          <td>50</td>
          <td>80</td>
          <td>50</td>
        </tr>
        <?php $i++; } ?>
        <tr>
          <td colspan="2">Hindi</td>
          <td>50</td>
          <td>80</td>
          <td>94</td>
        </tr>
        <tr>
          <td colspan="2">Maths</td>
          <td>50</td>
          <td>80</td>
          <td>80</td>
        </tr>
      </table>
    </div>
  </div>  

  <div id = "middlebox"> 
    <div style="color:#010d6d">
      <center><h3>PERSONALITY DEVELOPEMNT</h3>  </center>
      <table style="width:100%;" id="table2">
        <tr>
          <th style="border:0px"></th>
          <th style="border:0px">First Term</th> 
          <th style="border:0px">Second Term</th>
        </tr>

        <?php $i = 1;
        foreach ($result as $data) { ?>
          <tr>
            <td style="border:0px">Regularity in attendance</td>
            <td style="border:0px"></td>
            <td style="border:0px"></td>
          </tr>
          <?php $i++; } ?>
          <tr style="border:0px">
            <td>Cleanliness</td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>Regularity in work</td>
            <td></td>
            <td></td>
          </tr> 
          <tr>
            <td>Behaviour in School</td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>Parent Coperation</td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>Grades :<br>
              A+ -  (91-100)<br>
              A -   (81-90)<br>
              B -   (71-80)<br>
              C -   (61-70)<br>
              D -   (51-60)<br>
              IR - Improvement Reuired<br>
            </td>
            <td>Teacher</td>
            <td>Teacher</td>
          </tr>
          <tr>
            <td><br><br>School Reopens<br><br><br>
              On ..............<br><br>
              At ...............
            </td>
            <td>Principal<br><br><hr><br>Parents</td>
            <td>Principal<br><br><hr><br>Parents</td>
          </tr>
        </table>
      </div> 
    </div> 


  </div> 
</body>
</html>