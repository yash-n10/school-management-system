<!DOCTYPE html>
<html>
<head>
<title>Certificate</title>
<style>
    .sublinhar{
text-decoration: underline;
}
.center {
text-align: center
}
.esquerda {
text-align: justify;
}
.overline {
text-decoration: overline;
}
.quebra_linha{
display: block;
}
    .boder
    { 
        border: 1px solid black !important;
        font-weight:500px;
    }

  body {
    /*font-family: gargi, dejvu sans, sans-serif;*/
  }
 </style>
</head>

<body style="width:100%; font-size: 10px;margin-left: 30px !important;">
    <div class="boder row">
        <div class="row" style="">
            
            <table style="width:100%">
                <tbody>
                    <tr>
                        <th align="left" width="20%"><img src="<?php echo $_SERVER['DOCUMENT_ROOT'];?>/<?php echo $logo;?>" height="95px;"></th>
                        <th align="center" width="70%"><h2 style="text-transform: uppercase;"><b><?php echo $school_desc[0]->description; ?></b></h2><br>
                            <h3><b> <?php echo $school_desc[0]->address; ?></b>     </h3>  
                                        <br>
                                    <span>MAIL : <?php echo $school_desc[0]->email; ?> &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp; TEL : <?php echo $school_desc[0]->phone; ?><br><br>
                                    </span>
                        </th><br>                                
                        <th align="right" width="10%"></th>
                    </tr>
                </tbody>
            </table>
             <p style="text-align: center;font-size: 18px;border-radius: 20px;border: 2px solid black;font-weight: bold"> BONAFIDE CERTIFICATE</p><br>
            <table style="width:100%">
                <tbody>
                    <tr>
                        <th align="center"><u>To Whom It May Concern</u></th>
                    </tr>
                    <tr>
                        <th style="font-size: 22px!important;line-height: 60px"><p class="esquerda"><i>This is to Certify that &nbsp; Master/Miss <span class="sublinhar negrito"><?php echo $data[0]->first_name. ' '. $data[0]->middle_name. ' '. $data[0]->last_name; ?> </span><br>  S/O/D/O <span class="sublinhar negrito"><?php echo $data[0]->father_name?> </span> &nbsp; & &nbsp; <span class="sublinhar negrito"><?php echo $data[0]->mother_name?> </span><br> &nbsp; admission no. <span class="sublinhar negrito"><?php echo $data[0]->admission_no; ?></span> Class <span class="sublinhar negrito"><?php echo $data[0]->class_name; ?></span>  is a bonafide  student of this school for the session  <span class="sublinhar negrito"><?php echo $data[0]->admission_date; ?> </span> to <span class="sublinhar negrito"><?php echo date("d/m/Y"); ?></span></i></p></th>
                    </tr>
                </tbody>
            </table>
            <p style="font-weight: bold">
                                <i>To the best of my knowledge he/she bears a Good moral character.</i>
                            </p>
                            <p style="font-weight: bold">
                                <i>I wish him/her every success in life.</i>
                            </p>
                             <table style="width:100%">
                            <tbody>
                                <tr>
                                    <th align="left">ISSUE DATE <?php echo date("d/m/Y"); ?></th>
                                    <th align="center" width="80%"> DEALING CLERK
                                    </th>                            
                                    <th align="right" width="10%">PRINCIPAL</th>
                                </tr>
                            </tbody>
                        </table>
            
        </div>
        

            

</body>
</html>