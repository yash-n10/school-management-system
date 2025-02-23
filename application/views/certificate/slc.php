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
            
            <table style="width:100%">
                <tbody>
                    <tr>
                        <th align="left"><img src="<?php echo $_SERVER['DOCUMENT_ROOT'];?>/<?php echo $logo;?>" height="95px;"></th>
                        <th align="center"><h2 style="text-transform: uppercase;"><b><?php echo $school_desc[0]->description; ?></b></h2><br>
                            <h3><b> <?php echo $school_desc[0]->address; ?></b>     </h3>  
                                        <br>
                                    <span>MAIL : <?php echo $school_desc[0]->email; ?> &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp; TEL : <?php echo $school_desc[0]->phone; ?><br><br>
                                    </span>
                        </th><br>                                
                        <th align="right" width="30%"></th>
                    </tr>
                </tbody>
            </table>
            <h1><u><center><b>SCHOOL LEAVING CERTIFICATE</b></center></u></h1><br>

            
            <!--<br><br><center><span class="boder" style="font-size: 10px;"><b>SCHOOL LEAVING CERTIFICATE</b></span></center><br>-->
            
            
        </div>
        
        <table style="width:100%">
                <tbody>
                    <tr>
                        <th align="left" style="padding-left: 50px"><span >SLC.No.: 123456789456</span></th>
                        <th></th>
                        <th align="right" style="padding-right: 110px"><span >Adm.No : <?php echo $data[0]->admission_no?> </span></th><br><br> 

                    </tr>
                </tbody>
            </table><br>
        
        <div class="row">

        <!--<span style="padding-left: 100px">Registration.No :&nbsp;&nbsp;&nbsp;<?php echo $data[0]->admission_no?></span><span style="padding-left: 70px">Board's Roll No :-------------------</span><br><br><br><br>-->
        <span style="padding-left: 50px">01. Candidate Name           :</span>&nbsp;&nbsp;&nbsp;<span style="font-family:cursive"><?php echo $data[0]->first_name?>&nbsp;&nbsp;&nbsp;<?php echo $data[0]->middle_name?>&nbsp;&nbsp;&nbsp;<?php echo $data[0]->last_name?></span><br><br>
        <span style="padding-left: 50px">02.Father's Name            :</span>&nbsp;&nbsp;&nbsp;<span><?php echo $data[0]->father_name?></span><br><br>
        <span style="padding-left: 50px">03. Mother's Name :</span>&nbsp;&nbsp;&nbsp;<span><?php echo $data[0]->mother_name?></span><br><br>
        <span style="padding-left: 50px">04. Present Address :</span>&nbsp;&nbsp;&nbsp;<span><?php echo $data[0]->address?></span><br><br>
        <span style="padding-left: 50px">05. Date of birth  as recorded in the Admission Register (in Figure)  :</span>&nbsp;&nbsp;&nbsp;<span><?php echo $data[0]->dob?></span><br><span style="padding-left: 60px">& in words :</span><span><br><br>
        <span style="padding-left: 50px">06. Year of passing Senior Secondary Annual/Compartmental Exam of the CBSE Board Year :</span>&nbsp;&nbsp;&nbsp;<span>----------------------</span>
        <span style="padding-left: 50px">07. Divison (In words) :</span>&nbsp;&nbsp;&nbsp;<span>------------------------------------------</span><br><br>
        <span style="padding-left: 50px">08. Admission No. :</span>&nbsp;&nbsp;&nbsp;<span>---------------------------------</span><br><br>
        <span style="padding-left: 50px">09. Weather failed, in the same class :</span>&nbsp;&nbsp;&nbsp;<span>-------------------------------</span><br><br>
        <span style="padding-left: 50px">10. Subject Taken </span><br><br>
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
        <span style="padding-left: 50px">Class Teacher</span><span style="padding-left: 210px">Checked by</span><span style="padding-left: 200px">Principal</span><br>
        <span style="padding-left: 300px"></span>
    </div>
</body>
</html>