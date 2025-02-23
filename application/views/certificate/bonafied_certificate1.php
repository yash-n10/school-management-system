<!DOCTYPE html>
<html lang="en">
<head>
<title>Certificate</title>
<style>
 .div2
{
    position: absolute;
    margin-top: 50px;
    margin-left: 10px;
    margin-right: 10px;
    
}   
.div1
{
    position: absolute;
    margin-top: 100px;
    margin-left: 60px;
    margin-right: 100px;
    
}

.border
{
    border: 1px solid black;
}
    
</style>
</head>

<body >
  
        
    <div class="div1 border">
        
        <center><span style="font-size: 10px"><img style="padding-top:5px;padding-bottom: 5px;" src="<?php echo $_SERVER['DOCUMENT_ROOT'];?>/<?php echo $logo;?>"height="75px;"> </center>
         <center><b><?php echo $school_desc[0]->description; ?>        
                </b><br>
                 <?php echo $school_desc[0]->address; ?><br>
                  MAIL : <?php echo $school_desc[0]->email; ?> &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp; TEL : <?php echo $school_desc[0]->phone; ?></center>
        </span> <br><br>
     
        <center><span style="border:1px solid"><b>BONAFIDE CERTIFICATE </b></span></center><br><br>
     <center><span><b><u>TO WHOMSOEVER IT MAY CONCERN</u></b></span></center><br><br><br><br>
     <span style="font-size: 10; margin-left: 100px;"><b>&nbsp;&nbsp;&nbsp;  This is to Certify that Master/Miss ................................................<?php echo $data[0]->first_name; ?> <?php echo $data[0]->middle_name; ?> <?php echo $data[0]->last_name; ?>....................<br><br>
             &nbsp;&nbsp;&nbsp;Son/Daughter of Sri &nbsp;&nbsp;&nbsp;...................................<?php echo $data[0]->father_name; ?>.......................................................<br><br>&nbsp;&nbsp;&nbsp;
                Was a student of our school &nbsp;&nbsp;&nbsp;Admission no &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.........<?php echo $data[0]->admission_no; ?>............. Class&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;..........<?php echo $data[0]->class_name; ?>......<br><br>
             &nbsp;&nbsp;&nbsp;is a bonafide student of this school for the session ...........<?php echo $data[0]->session; ?>............<br><br>
             <!-- &nbsp;&nbsp;&nbsp; To the best of my knowledge he/she bears a Good moral character.<br><br>
             &nbsp;&nbsp;&nbsp;I wish him/here every success in  life.</b></span><br><br> -->
             <br><br><br><br><br><br>
                              <span style="margin-left: 50px">Issue Date : <?php echo date('d-m-Y'); ?></span>
                              <!-- <span style="margin-left: 150px">Signature</span> -->
                              <span style="margin-left: 200px">Principle Signature</span>




    
    </div> 
    
  </body>
</html>