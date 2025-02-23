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
            <table style="width:100%">
                <tbody>
                    <tr>
                        <th align="left" style="padding-left: 50px"><span >Affiliation No.: --------------------</span></th>
                        <th></th>
                        <th align="right" style="padding-right: 50px"><span >School Code : -------------------- </span></th>

                    </tr>
                </tbody>
            </table>
            
            <!--<br><br><center><span class="boder" style="font-size: 10px;"><b>SCHOOL LEAVING CERTIFICATE</b></span></center><br>-->
            
            
        </div>
        
        <table style="width:100%">
                <tbody>
                    <tr>
                        <th align="left" style="padding-left: 50px"><span >TC.No.: ____________________</span></th>
                        <th></th>
                        <th align="right" style="padding-right: 110px"><span >Adm.No : <?php echo $data[0]->admission_no?> </span></th><br><br> 

                    </tr>
                </tbody>
            </table><br>
            


        <div class="row">

        <!--<span style="padding-left: 100px">Registration.No :&nbsp;&nbsp;&nbsp;<?php echo $data[0]->admission_no?></span><span style="padding-left: 70px">Board's Roll No :-------------------</span><br><br><br><br>-->
        <span style="padding-left: 50px;">01. Student Name           :</span> <span style="font-family:cursive;padding-right: 110px"><?php echo $data[0]->first_name?>&nbsp;&nbsp;&nbsp;<?php echo $data[0]->middle_name?>&nbsp;&nbsp;&nbsp;<?php echo $data[0]->last_name?></span><br><br>
        <span style="padding-left: 50px">02. Mother's Name            :</span> <span><?php echo $data[0]->mother_name?></span><br><br>
        <span style="padding-left: 50px">03. Father's Name /Guardian Name               :</span>&nbsp;&nbsp;&nbsp;<span><?php echo $data[0]->father_name?></span><br><br>
        <span style="padding-left: 50px">04. Nationality :</span>&nbsp;&nbsp;&nbsp;<span>INDIAN</span><br><br>
        <span style="padding-left: 50px">05. Whether the pupil belongs to Schedule Caste or Schedule Tribe or :</span><span>-------------------------------</span><br><br>
        <span style="padding-left: 50px">06. Date of first admission in school is :</span>&nbsp;&nbsp;&nbsp;<span><?php echo $data[0]->admission_date ?></span><br><br>
        <span style="padding-left: 50px">07. Date cf Birth according to Admission & Withdrawal Register(in figures)  :</span>&nbsp;&nbsp;&nbsp;<span><?php echo $data[0]->dob?></span><br><br>
        <span style="padding-left: 50px">08. Date cf Birth according to Admission & Withdrawal Register(in words)  :</span>&nbsp;&nbsp;&nbsp;<span>---------------------------------------</span><br><br>
        <span style="padding-left: 50px">09. Class in which the pupil last studied :</span>&nbsp;&nbsp;&nbsp;<span><?php echo $data[0]->class_name?>&nbsp;&nbsp;&nbsp;<?php echo $data[0]->sec_name?></span><br><br>
        <span style="padding-left: 50px">10. School/Board Annual Examination Last Taken With Result :</span>&nbsp;&nbsp;&nbsp;<span>---------------------------------</span><br><br>
        <span style="padding-left: 50px">11. Weather failed, in the same class :</span>&nbsp;&nbsp;&nbsp;<span>-------------------------------</span><br><br>
        <span style="padding-left: 50px">12. Subject Studied </span><br><br>
        <span style="padding-left: 85px">(a).Compulsory</span><span style="padding-left: 20px">(i)</span><span>-------------------------------</span><span style="padding-left: 20px">(iv)</span><span>-------------------------------</span><br><br> 
        <span style="padding-left: 170px">(ii)</span><span>-------------------------------</span><span style="padding-left: 20px">(v)</span><span>-------------------------------</span><br><br>
        <span style="padding-left: 170px">(iii)</span><span>-------------------------------</span><span style="padding-left: 20px">(vi)</span><span>-------------------------------</span><br><br>    
        <!--<span style="padding-left: 80px">(b). Optional</span><span style="padding-left: 20px">(1)</span>&nbsp;&nbsp;&nbsp;<span>-------------------------------</span><br><br>-->
        <span style="padding-left: 50px">13. Weather qualified for promotion to higher Class :</span>&nbsp;&nbsp;&nbsp;<span>-------------------------------</span><span style="padding-left:  5px">If so, to which higher class(in figure)</span><span>--------------------------------------------------</span><br><br>
        <span style="padding-left: 50px">14. Month upto which the pupil has paid school due :</span>&nbsp;&nbsp;&nbsp;<span>----------------------------</span><br><br>
        <span style="padding-left: 50px">13. Any fee concession availed of :</span><span>---------------------------------</span><span style="padding-left: 5px;">If so the nature of such concession</span><span>-----------------</span><br><br>
        <span style="padding-left: 50px">14. Total No of School Working Days :</span><span>----------------------------------</span><br><br>
        <span style="padding-left: 50px">15. Total No of Days Present  :</span><span>------------------</span><br><br>
        <span style="padding-left: 50px">16. Weather NCC cadet/Boy/Girl Guide(Give Details) :</span><span>------------------------------------------------------------------------------------------------------------------------</span><br><br>
        <span style="padding-left: 50px">17. Games played/extra curricular activities in which the the pupil took part(mention achievement there in) :</span><span>--------------------------------------------------------</span><br><br>
        <span style="padding-left: 50px">18. General Conduct                      :</span><span>----------------------------------------------------------------------------------------------------------------------------------------------------------------</span><br><br>
        <span style="padding-left: 50px">19. Date of application for certificate  :</span><span>----------------------------------------------------------------------------------------------------------------------------------------------</span><br><br>
        <span style="padding-left: 50px">19. Date of issue of certificate         :</span><span>-----------------------------------------------------------------------------------------------------------------------------------------------------</span><br><br>
        <span style="padding-left: 50px">18. Reasons for leaving the school       :</span><span>-------------------------------------------------------------------------------------------------------------------------------------------------</span><br><br>
        <span style="padding-left: 50px">18. Any other  Remarks                   :</span><span>---------------------------------------------------------------------------------------------------------------------------------------------------------------</span><br><br><br><br><br><br>
        <span style="padding-left: 50px">Class Teacher</span><span style="padding-left: 210px">Checked by</span><span style="padding-left: 200px">Principal</span><br>
        <span style="padding-left: 300px">(Name & Designation)</span><br><br>
    </div>
</body>
</html>