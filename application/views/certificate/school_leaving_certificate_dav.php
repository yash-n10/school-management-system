<!DOCTYPE html>
<html lang="UTF-8">
<head>
<title>Certificate</title>
<style>
    .boder
    { 
        border: 2px solid black !important;
        font-weight:bold;
        border-style:double;
        border-width:10px;  

    }
    /*@font-face {
    src: url("http://experimenting.in/css3/webfonts/hindifontsdemo/gargi.ttf") format('truetype');
    font-family: "gargi";
  }*/
  table>tr>th{
    margin-bottom: 20px;
    line-height: 5px;
    height: 30px;
    font-size:14px;
  }
  tr{
    margin-bottom: 50px !important;
    padding-bottom: 50px !important;
    line-height: 50px !important;
    height: 30px !important;

  }
  /*p,span, td,b { font-family: freeserif;}*/
  body {
    font-weight:bold !important;
    font-size: 14px;
    /*font-family: mangal;*/
    


}
.hindi {
    font-family: mangal;
}
.sublinhar{
text-decoration: underline;
font-family: freeserif;
width: 2000px !important;

  /*font-style: italic;*/
}

 </style>
</head>

<body style="width:100%; font-size: 13px;margin-left: 30px !important;font-family: freeserif;">
    <div class="boder row">
        <div class="row" style="">
            <table style="width:100%">
                <tbody>
                    <tr>
                        <th align="left" width="20%"><img src="<?php echo $_SERVER['DOCUMENT_ROOT'];?>/<?php echo $logo;?>" height="95px;"></th>
                        <th align="center" width="70%" ><h2 style="text-transform: uppercase;"><b style="font-size: 30px;"><?php echo $school_desc[0]->description; ?></b></h2><br>
                        <h3><b> <?php echo $school_desc[0]->address; ?></b>     </h3><br>
                        <span><b>Session : (<?php print_r($tc_data[0]->session_name); ?>)  </b> </span>
                        </th><br>                                
                        <th align="right" width="10%"></th>
                    </tr>
                </tbody>
            </table>
                <p style="text-align: center;font-size: 18px;border-radius: 20px;border: 2px solid black;font-weight: bold;"><img src="<?php echo base_url()?>assets/tc_images/4.png" height="4%" width="18%" style="margin-bottom:-7px;"> / TRANSFER CERTIFICATE</p>
            <table style="width:100%">
                <tbody>
                    <tr>
                        <th align="left" width="20%"><span >School No.: <?php echo $school_desc[0]->school_no; ?></span></th>
                        <th width="50%"></th>
                        <th align="right" width="25%"><span>TC. No. DAVBAR/<?php echo $tc_data[0]->session_name;?>/<?php echo $tc_data[0]->tc_number;?> </span></th>
                        <th width="5%"></th>
                    </tr>
                </tbody>
            </table>
            <table style="width:100%">
                <tbody>
                    <tr>
                        <th align="left" width="30%"><span>Affiliation No.: <?php echo $school_desc[0]->affiliation_no; ?></span></th>
                        <th align="center" width="30%"><span>Renewed Upto: <?php echo $school_desc[0]->renewed_upto; ?></span></th>
                        <th align="right" width="35%"><span>Status of School : Senior Secondary </span></th>
                        <th align="right" width="5%"></th>
                    </tr>
                </tbody>
            </table>
            <table style="width:100%">
                <tbody>
                    <tr>
                        <th align="left" width="30%"><span>Adm No. :&nbsp;&nbsp;&nbsp; <?php echo $data[0]->admission_no?> </span></th>
                        <th align="center" width="30%"><span>Registration No.<?php echo $tc_data[0]->registration_no;?></span></th>                            
                        <th align="right" width="35%"><span>Board Roll No.<?php echo $tc_data[0]->board_roll;?></span></th>
                        <th width="5%"></th>
                    </tr>
                </tbody>
            </table>
        </div>
        <table style="width:100%">
            <tr>
                <th width="30%" style="text-align: left">01. <img src="<?php echo base_url()?>assets/tc_images/5.png"  width="8%">/Student Name :</th>
                <th width="70%;" colspan="3" style="border-bottom:  1px solid;text-align: left" ><?php echo $data[0]->first_name?>&nbsp;&nbsp;&nbsp;<?php echo $data[0]->middle_name?>&nbsp;&nbsp;&nbsp;<?php echo $data[0]->last_name?></th>
            </tr>
            <tr style="margin-bottom: 50px !important;height: 50px;line-height: 50px;">
                <th width="30%" style="text-align: left">02.<img src="<?php echo base_url()?>assets/tc_images/mn.png"  width="7%" >/Mother's Name :</th>
                <th width="70%;" colspan="3" style="border-bottom:  1px solid;text-align: left" ><?php echo $data[0]->mother_name?></th>
            </tr>
            <tr>
                <th width="30%" style="text-align: left">03. <img src="<?php echo base_url()?>assets/tc_images/fn.png"  width="7%">/Father's Name :</th>
                <th width="70%;" colspan="3" style="border-bottom:  1px solid;text-align: left" ><?php echo $data[0]->father_name?></th>
            </tr>
            <tr>
                <th width="30%" style="text-align: left">04. <img src="<?php echo base_url()?>assets/tc_images/6.png" height="2%" width="5%" style="margin-top:-10px;">/Nationality :</th>
                <th width="70%;" colspan="3" style="border-bottom:  1px solid;text-align: left" >INDIAN</th>
            </tr>
            <tr>
                <th width="40%" style="text-align: left">05.Whether the pupil belongs to SC/ST/OBC Category:</th>
                <th width="60%;" colspan="3" style="border-bottom:  1px solid;text-align: left" ><?php echo $tc_data[0]->caster_category?></th>
            </tr>
             <?php   
                        $originalDate = $tc_data[0]->date_of_adm;
                        $newDatedob = date("d-m-Y", strtotime($originalDate));
                ?>
            <tr>
                <th  style="text-align: left">06. Date of first admission in school is :</th>
                <th  style="border-bottom:  1px solid;text-align: left" ><?php echo $newDatedob;?></th>
                <th colspan="2" style="text-align: left ;border-bottom:  1px solid;"><span style="border-bottom:0px solid">Class</span> :  <?php echo $tc_data[0]->first_class;?> </th>                
            </tr>
             <?php   
                        $dobadm = $tc_data[0]->dob_adm;
                        $newdobadm = date("d-m-Y", strtotime($dobadm));
                ?>
            <tr>
                <th width="40%" style="text-align: left">07. Date cf Birth according to Admission Register :</th>
                <th width="60%;" colspan="3" style="border-bottom:  1px solid;text-align: left" > <?php echo $newdobadm?></th>
            </tr>
            <tr>
                <th width="40%" style="text-align: left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;In Words :</th>
                <th width="60%;" colspan="3" style="border-bottom:  1px solid;text-align: left" ><?php echo $tc_data[0]->dob_word;?></th>
            </tr>
            <tr>
                <th width="45%" style="text-align: left">08. <img src="<?php echo base_url()?>assets/tc_images/failed.png" height="1%" width="18%" style="margin-top:-10px;">/Whether failed, in the same class :</th>
                <th width="60%;" colspan="3" style="border-bottom:  1px solid;text-align: left" ><?php echo $tc_data[0]->failed_in_class;?></th>
            </tr>
            <tr>
                <th width="45%" style="text-align: left">09. <img src="<?php echo base_url()?>assets/tc_images/lastcls.png" height="1%" width="18%" style="margin-top:-10px;">/Class in which the pupil last studied :</th>
                <th width="60%;" colspan="3" style="border-bottom:  1px solid;text-align: left" ><?php echo $data[0]->class_name?></th>
            </tr>
            <tr>
                <th width="45%" style="text-align: left">10. School/Board Annual Examination Last Taken With Result :</th>
                <th width="60%;" colspan="3" style="border-bottom:  1px solid;text-align: left" ><?php echo $tc_data[0]->schl_borad;?></th>
            </tr>

              <tr>
                <th style="text-align: left" >11. <img src="<?php echo base_url()?>assets/tc_images/vishay.png" height="1%" width="8%" style="margin-top:-10px;">/Subjects Studied </th>
                <th colspan="2" style="border-bottom:  1px solid;text-align: left" >(1)&nbsp;&nbsp;<?php echo $tc_data[0]->sub1;?></th>
                <th style="border-bottom:  1px solid;text-align: left" >(4)&nbsp;&nbsp;<?php echo $tc_data[0]->sub4;?></th>
            </tr>

            <tr><th></th>
                <th colspan="2" style="border-bottom:  1px solid;text-align: left" >(2)&nbsp;&nbsp;<?php echo $tc_data[0]->sub2;?></th>
                <th  style="border-bottom:  1px solid;text-align: left" >(5)&nbsp;&nbsp;<?php echo $tc_data[0]->sub5;?></th>
            </tr>
            <tr><th style="text-align: left" ></th>
                <th colspan="2" style="border-bottom:  1px solid;text-align: left" >(3)&nbsp;&nbsp;<?php echo $tc_data[0]->sub3;?></th>
                <th style="border-bottom:  1px solid;text-align: left" >(6)&nbsp;&nbsp;<?php echo $tc_data[0]->sub6;?></th>
            </tr>
              <tr>
                <th  style="text-align: left">12. Whether qualified for promotion to higher Class :</th>
                <th colspan="3" style="border-bottom:  1px solid;text-align: left" ><?php echo $tc_data[0]->promotion_clas;?></th>    
            </tr>
            <tr>
                <th width="45%" style="text-align: left">&nbsp;&nbsp;If so, to which higher class(in figure) :</th>
                <th width="60%;" colspan="3" style="border-bottom:  1px solid;text-align: left" ><?php echo $tc_data[0]->prom_cls_yes ;?></th>
            </tr>
             <tr>
                <th width="45%" style="text-align: left">13. Month upto which the pupil has paid school due :</th>
                <th width="60%;" colspan="3" style="border-bottom:  1px solid;text-align: left" ><?php echo $tc_data[0]->fee_due;?></th>
            </tr>
             <tr>
                <th  style="text-align: left">14. Any fee concession availed of :</th>
                <th colspan="3" style="border-bottom:  1px solid;text-align: left" ><?php echo $tc_data[0]->fee_consession;?></th>
            </tr>
            <tr>
                <th width="45%" style="text-align: left">&nbsp;&nbsp;If so the nature of such concession:</th>
                <th width="60%;" colspan="3" style="border-bottom:  1px solid;text-align: left" ><?php echo $tc_data[0]->fee_consession_nature;?></th>
            </tr>
             <tr>
                <th width="45%" style="text-align: left">15. Total No of School Working Days :</th>
                <th width="60%;" colspan="3" style="border-bottom:  1px solid;text-align: left" ><?php echo $tc_data[0]->working_days ;?></th>
            </tr>
             <tr>
                <th width="45%" style="text-align: left">16. Total No of Days Present  :</th>
                <th width="60%;" colspan="3" style="border-bottom:  1px solid;text-align: left" ><?php echo $tc_data[0]->days_present;?></th>
            </tr>
            <tr>
                <th width="45%" style="text-align: left">17. Whether NCC cadet/Boy/Girl Guide(Give Details) :</th>
                <th width="60%;" colspan="3" style="border-bottom:  1px solid;text-align: left" ><?php echo $tc_data[0]->ncc_caded;?></th>
            </tr>
            <tr>
                <th width="45%" style="text-align: left">18. Games played/extra curricular activities in which the pupil took part(mention achievement there in) :</th>
                <th width="60%;" colspan="3" style="border-bottom:  1px solid;text-align: left" ><?php echo $tc_data[0]->curricular;?></th>
            </tr>
            <tr>
                <th width="45%" style="text-align: left">19. <img src="<?php echo base_url()?>assets/tc_images/samanya.png" height="1%" width="8%" style="margin-top:-10px;">/General Conduct </th>
                <th width="60%;" colspan="3" style="border-bottom:  1px solid;text-align: left" ><?php echo $tc_data[0]->general_conduct;?></th>
            </tr>
            <?php   
                $apdate = $tc_data[0]->date;
                $newdate = date("d-m-Y", strtotime($apdate));
            ?>
            <?php   
                $isdate = $tc_data[0]->date_created;
                $newdateis = date("d-m-Y", strtotime($isdate));
            ?>
             <tr>
                <th width="45%" style="text-align: left">20. Date of application for certificate  :</th>
                <th width="60%;" colspan="3" style="border-bottom:  1px solid;text-align: left" ><?php if($data[0]->class_name=='XII' or $data[0]->class_name=='X'){echo "31-03-2021";}else{echo $newdate;}?></th>
            </tr>
             <tr>
                <th width="45%" style="text-align: left">21.<img src="<?php echo base_url()?>assets/tc_images/1.png" height="1%" width="15%" style="margin-top:-10px;">/Date of issue of certificate :</th>
                <th width="60%;" colspan="3" style="border-bottom:  1px solid;text-align: left" ><?php if($data[0]->class_name=='XII' or $data[0]->class_name=='X'){echo "09-08-2021";}else{echo $newdateis;}?></th>
            </tr>
             <tr>
                <th width="45%" style="text-align: left">22. <img src="<?php echo base_url()?>assets/tc_images/2.png" height="1%" width="10%" style="margin-top:-10px;">/Reasons for leaving the school  :</th>
                <th width="60%;" colspan="3" style="border-bottom:  1px solid;text-align: left" ><?php echo $tc_data[0]->reason;?></th>
            </tr>
            <tr>
                <th width="45%" style="text-align: left">23. <img src="<?php echo base_url()?>assets/tc_images/3.png" height="1%" width="8%" style="margin-top:-10px;">/Any other  Remarks :</th>
                <th width="60%;" colspan="3" style="border-bottom:  1px solid;text-align: left" ><?php echo $tc_data[0]->remarks;?></th>
            </tr>
        </table>
        <br>
        <table style="width:100%">
        <tbody>
            <tr>
                <th align="left" width="30%"><p>Class Teacher</p></th>
                <th align="center" width="50%"><p>Checked by</p><p style="font-size: 8px;">(Name & Designation)</p>
                </th>                            
                <th align="right" width="15%"><p>PRINCIPAL</p></th>
                <th align="right" width="5%"></th>
            </tr>
        </tbody>
    </table>

    <br>
    <p><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Note: If this T.C is issued by the officiating/Incharge Principal, in varibly countersigned by the Manager-V.M.C</b></p>
     
    </div>
</body>
</html>