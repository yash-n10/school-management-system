<!DOCTYPE html>
<html lang="en">
<head>
<title>Certificate</title>
<style>
    .boder
    { 
        border: 1px solid black !important;
        font-weight:500px;
    }
 </style>
</head>

<body style="width:100%; font-size: 10px;">
    <div class="boder row">
        <div class="row">

            <div class="">
                <div class="" style="width: 20%;position: absolute;">
                    <?php  $school_id=$school_desc[0]->id; ?>
                    <div class="" style="text-align: center;">
                        <img src="<?php echo $_SERVER['DOCUMENT_ROOT'];?>/<?php echo $logo;?>" style="height:100px">
                    </div>
                </div>
                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <div class="" style="width: 80%;position: absolute;">
                    <center><h1><?php echo $school_desc[0]->description;?></h1>
                    <p class="font-weight-bold" style="margin: 0 0 1px;"><?php echo $school_desc[0]->vision;?></p><br>
                     <span>MAIL : <?php echo $school_desc[0]->email; ?> &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp; TEL : <?php echo $school_desc[0]->phone; ?><br><br>
                                    </span>                  
                </div>
            </div>

            <div  style="margin-top: 90px;">
            <h1><u><center><b>TRANSFER CERTIFICATE</b></center></u></h1><br>
            <table style="width:100%">
                <tbody>
                    <tr>
                        <th align="left" style="padding-left: 50px"><span >Affiliation No.: --------------------</span></th>
                        <th></th>
                        <th align="right" style="padding-right: 50px"><span >School Code : -------------------- </span></th><br><br> 

                    </tr>
                </tbody>
            </table><br>
            
            <!--<br><br><center><span class="boder" style="font-size: 10px;"><b>SCHOOL LEAVING CERTIFICATE</b></span></center><br>-->
            
            
        </div>
        
        <table style="width:100%">
                <tbody>
                    <tr>
                        <th align="left" style="padding-left: 50px"><span >TC.No.: </span></th>
                        <th></th>
                        <th align="right" style="padding-right: 110px"><span >Adm.No : <?php echo $data[0]->admission_no?> </span></th><br><br> 

                    </tr>
                </tbody>
            </table><br>
        
        <div class="row">

        <!--<span style="padding-left: 100px">Registration.No :&nbsp;&nbsp;&nbsp;<?php echo $data[0]->admission_no?></span><span style="padding-left: 70px">Board's Roll No :-------------------</span><br><br><br><br>-->
        <span style="padding-left: 50px">01. Name of the Pupil           :</span>&nbsp;&nbsp;&nbsp;<span style="font-family:cursive"><?php echo $data[0]->first_name?>&nbsp;&nbsp;&nbsp;<?php echo $data[0]->middle_name?>&nbsp;&nbsp;&nbsp;<?php echo $data[0]->last_name?></span><br><br>
        <span style="padding-left: 50px">02.(a)Mother's Name            :</span>&nbsp;&nbsp;&nbsp;<span><?php echo $data[0]->mother_name?></span><br><br>
        <span style="padding-left: 60px">(b)Father's Name                :</span>&nbsp;&nbsp;&nbsp;<span><?php echo $data[0]->father_name?></span><br><br>
        <span style="padding-left: 50px">03. Nationality :</span>&nbsp;&nbsp;&nbsp;<span>INDIAN</span><span style="padding-left: 100px">04. Weather S.C or S.T :</span><span>-------------------------------</span><br><br>
        <span style="padding-left: 50px">05. Date of first admission in school is :</span>&nbsp;&nbsp;&nbsp;<span><?php echo $data[0]->admission_date ?></span><span style="padding-left: 150px">In Class :</span>&nbsp;&nbsp;&nbsp;<span><?php echo $data[0]->class_name?>&nbsp;&nbsp;&nbsp;<?php echo $data[0]->sec_name?></span><br><br>
        <span style="padding-left: 50px">06. Date of birth (in Christian Era) as recorded in the Admission Register (in Figure)  :</span>&nbsp;&nbsp;&nbsp;<span><?php echo $data[0]->dob?></span><br><span style="padding-left: 60px">& in words :</span><span>---------------------------------------</span><br><br>
        <span style="padding-left: 50px">07. Class in which the pupil :</span>&nbsp;&nbsp;&nbsp;<span>------------------------------------------</span><br><br>
        <span style="padding-left: 50px">08. School/Board Annual Examination Last Taken With Result :</span>&nbsp;&nbsp;&nbsp;<span>---------------------------------</span><br><br>
        <span style="padding-left: 50px">09. Weather failed, in the same class :</span>&nbsp;&nbsp;&nbsp;<span>-------------------------------</span><br><br>
        <span style="padding-left: 50px">10. Subject Studied </span><br><br>
        <span style="padding-left: 85px">(a).Compulsory</span><span style="padding-left: 20px">(1)</span><span>-------------------------------</span><span style="padding-left: 20px">(4)</span><span>-------------------------------</span><br><br> 
        <span style="padding-left: 170px">(2)</span><span>-------------------------------</span><span style="padding-left: 20px">(5)</span><span>-------------------------------</span><br><br>
        <span style="padding-left: 170px">(3)</span><span>-------------------------------</span><span style="padding-left: 20px">(6)</span><span>-------------------------------</span><br><br>    
        <span style="padding-left: 80px">(b). Optional</span><span style="padding-left: 20px">(1)</span>&nbsp;&nbsp;&nbsp;<span>-------------------------------</span><br><br>
        <span style="padding-left: 50px">11. Weather qualified for promotion to higher Class :</span>&nbsp;&nbsp;&nbsp;<span>-------------------------------</span><span style="padding-left:  5px">If so, to which higher class(in figure)</span><span>--------------------------------------------------</span><br><br>
        <span style="padding-left: 70px">(in words)</span>&nbsp;&nbsp;&nbsp;<span>------------------------------------</span><br><br>
        <span style="padding-left: 50px">12. Month upto which the pupil has paid school due :</span>&nbsp;&nbsp;&nbsp;<span>----------------------------</span><br><br>
        <span style="padding-left: 50px">13. Any fee concession availed of :</span><span>---------------------------------</span><span style="padding-left: 5px;">If so the nature of such concession</span><span>-----------------</span><br><br>
        <span style="padding-left: 50px">14. Total No of School Working Days :</span><span>----------------------------------</span><br><br>
        <span style="padding-left: 50px;">15.Total No of Days Present  :</span><span>------------------</span><br><br>
        <span style="padding-left: 50px">16. Weather NCC cadet/Boy/Girl Guide(Give Details) :</span><span>------------------------------------------------------------------------------------------------------------------------</span><br><br>
        <span style="padding-left: 50px">17. Games played/extra curricular activities in which the the pupil took part(mention achievement there in) :</span><span>--------------------------------------------------------</span><br><br>
        <span style="padding-left: 50px">18. General Conduct                      :</span><span>----------------------------------------------------------------------------------------------------------------------------------------------------------------</span><br><br>
        <span style="padding-left: 50px">19. Date of application for certificate  :</span><span>----------------------------------------------------------------------------------------------------------------------------------------------</span><br><br>
        <span style="padding-left: 50px">19. Date of issue of certificate         :</span><span>-----------------------------------------------------------------------------------------------------------------------------------------------------</span><br><br>
        <span style="padding-left: 50px">18. Reasons for leaving the school       :</span><span>-------------------------------------------------------------------------------------------------------------------------------------------------</span><br><br>
        <span style="padding-left: 50px">18. Any other  Remarks                   :</span><span>---------------------------------------------------------------------------------------------------------------------------------------------------------------</span><br><br><br><br>
         <span style="padding-left: 30px">Prepared By</span><span style="padding-left: 100px">Class Teacher</span><span style="padding-left: 160px">Checked by</span><span style="padding-left: 140px">Principal</span><br>
        <span style="padding-left: 300px"></span>
    </div>
</body>
</html>