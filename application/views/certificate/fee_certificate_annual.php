<!DOCTYPE html>
<html lang="en">
<head>
<title>Certificate</title>

<style>
    
.div1
{
    position: absolute;

    margin-left:    10px;
    margin-right: 50px;
    border-color: black;
    
}

.border
{
    border: 1px solid black;
}
.terms {
  width: 90%;
  text-align: justify;
  white-space: normal;
}
a
{
  color: #5D6975;
  text-decoration: underline;
}

body
  {
  position: relative;
  width: 21cm;  
  height: 29.7cm; 
  margin: 0 auto; 
  color: #001028;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 15px; 
  font-family: Arial;
}

header {
  padding: 10px 0;
  margin-bottom: 30px;
}
  #div1{
      position: absolute;
      margin-top: 70px;
      top: 70px;
      left: 690px;
      right: 50px;
    }

    #border2{
       border-top: 1px solid  #5D6975;
        color: #5D6975;
       margin: 5px -0.5px 6px -0.5px;
    }

    #details{
      margin: 0px 0px 0px 14px;
      padding-top: 6px;
      padding-bottom: 5px;
    }

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
  page-break-inside:avoid;
}

table tr:nth-child(2n-1) td {
  background: #ffffff;
}

table th,
table td {
  text-align: center;
}

table th {
  color: #4c4949;
  border-bottom: 1px solid #C1CED9;
  white-space: nowrap;        
  font-weight: bold;
}

table td {
  padding: 7px;
  text-align: right;  
}

table { page-break-inside:auto }
tr    { page-break-inside:avoid; page-break-after:auto }

 .tabletop{
  border-top: 1px solid #ffffff;
  background: #ffffff;
}
.tableright{
  border-right: 1px solid #ffffff;
  background: #ffffff;
}
.tablevertical{
  border-left: 1px solid #ffffff;
  background: #ffffff;
}
.tablehorizontal{
  background: #ffffff;
  border-right:1px solid #ffffff; 
  border-left:1px solid #ffffff; 
  }

footer {
  color: #5D6975;
  width: 100%;
  height: 30px;
  position: absolute;
  bottom: 0;
  border-top: 1px solid #C1CED9;
  padding: 8px 0;
  text-align: center;
}
.boder{
    border: 1px solid black;
}  
</style>
<style>
table, th, td {
    border: 1px solid #5D6975;
    height:3px;
  margin: 3px -0.5px 3px -0.5px;
}
td{
height:7px;
margin: 5px -0.5px 6px -0.5px;
}
</style>
</head>

<body style="width:100%;">
    <div class="div1">
      
        <span> <span><center> <img style="padding-top:5px;padding-bottom: 5px;" src="<?php echo $_SERVER['DOCUMENT_ROOT'];?>/<?php echo $logo;?>"height="75px;"></center>
        </span>
         <center><h1><b><?php echo $school_desc[0]->description; ?> </b></h1><br>
            <?php echo $school_desc[0]->address; ?>      
                </b><br>
                 MAIL : <?php echo $school_desc[0]->email; ?> &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp; TEL : <?php echo $school_desc[0]->phone; ?><br>
                    
        </span> <br><br>
        <center><span><b><u>To Whom It May Concern</u></b></span></center><br><br><br>
        <span ><b>This is to Certify that &nbsp;&nbsp;&nbsp; <?php echo $data[0]->father_name?> &nbsp;&nbsp;&nbsp; & &nbsp;&nbsp;&nbsp; <?php echo $data[0]->mother_name?> &nbsp;&nbsp;&nbsp; have paid School Fee of their ward in this school as per details given below:-</b></span><br><br>
          
    <br><br>
    <p>Adm. No. <?php echo $data[0]->admission_no?></p><br><br>
    <p>Student Name : <?php echo $data[0]->first_name?>&nbsp;&nbsp;&nbsp;<?php echo $data[0]->middle_name?>&nbsp;&nbsp;&nbsp;<?php echo $data[0]->last_name?></p><br><br>
    <p>Class : <?php echo $data[0]->admission_no?></p><br><br>
          <table style="width: 100%;top: 10px;">
            <tr>
                <th style="text-align:center;width:10%" rowspan="2"><strong>Fee Head Name</strong></th>
                <th style="text-align:center;width:15%;" rowspan="2"><strong>Rate</strong></th>
                <th style="text-align:center;width:10%;" rowspan="2"><strong>Amount Paid</strong></th>
                <th style="text-align:center;width:10%;" rowspan="2"><strong>Study in Class</strong></th>
                <th style="text-align:center;width:15%;" rowspan="2"><strong>Academic Session</strong></th>                
                <th style="text-align:center;width:20%;" colspan="2"><strong>Amount Paid During the Period</strong></th>
                <th style="text-align:center;width:20%;" rowspan="2"><strong>Total Amount Paid</strong></th>
                   
             </tr>
             <tr>
                <th>From</th>
                <th>To</th>
                
            </tr>
            <?php $i=1;
            $month=$data[0]->mn;
            $aa=explode(',',$month);
            $first=reset($aa);
            $last=end($aa);
            if($first==1)
            {
              $aaa="April";
            }
            if($first=='2')
            {
              $aaa="May";
            }
            if($first=='3')
            {
              $aaa="June";
            }
            if($first=='4')
            {
              $aaa="Juky";
            }
            if($first=='5')
            {
              $aaa="August";
            }
            if($first=='6')
            {
              $aaa="September";
            }
             if($first=='7')
            {
              $aaa="October";
            }
             if($first=='8')
            {
              $aaa="November";
            }
             if($first=='9')
            {
              $aaa="December";
            }
             if($first=='10')
            {
              $aaa="January";
            }
              if($first=='10')
            {
              $aaa="January";
            }
            if($first=='11')
            {
              $aaa="February";
            }


             if($last==1)
            {
              $bbb="April";
            }
            if($last=='2')
            {
              $bbb="May";
            }
            if($last=='3')
            {
              $bbb="June";
            }
            if($last=='4')
            {
              $bbb="Juky";
            }
            if($last=='5')
            {
              $bbb="August";
            }
            if($last=='6')
            {
              $bbb="September";
            }
             if($last=='7')
            {
              $bbb="October";
            }
             if($last=='8')
            {
              $bbb="November";
            }
             if($last=='9')
            {
              $bbb="December";
            }
             if($last=='10')
            {
              $bbb="January";
            }
              if($last=='10')
            {
              $bbb="January";
            }
            if($last=='11')
            {
              $bbb="February";
            }

            
            ?>
            <tr>
              <td style="text-align:center;width:10%" class="tablecustomtd"><?php echo $i;?></td>
              <td style="text-align:center;width:15%" class="tablecustomtd"><?php echo $data[0]->admission_no?></td>
              <td style="text-align:center;width:10%" class="tablecustomtd"><?php echo $data[0]->first_name?>&nbsp;&nbsp;&nbsp;<?php echo $data[0]->middle_name?>&nbsp;&nbsp;&nbsp;<?php echo $data[0]->last_name?></td>
              <td style="text-align:center;width:10%" class="tablecustomtd"><?php echo $data[0]->class_name?>&nbsp;&nbsp;&nbsp;<?php echo $data[0]->sec_name?></td>
              <td style="text-align:center;width:15%" class="tablecustomtd"><?php echo $data[0]->session?></td>
              <td style="text-align:center;width:10%" class="tablecustomtd"><?php echo $aaa;?></td>            
              <td style="text-align:center;width:10%;" class="tablecustomtd"><?php echo $bbb;?></td> 
              <td style="text-align:center;width:20%" class="tablecustomtd"><?php echo $data[0]->tuition_fee; ?></td>
              
              
            </tr>
            <?php $i++;?>
              

              
        <!-- ******************* -->

          </table><br><br>
    
          <span>Tuition Fee Paid(In Words): <?php echo strtoupper($total_amt_words.' only');?></span><br><br><br>

          
    
    <span class="margin-left: 100px"><?php echo date("d/m/Y"); ?><br>Issue Date</span> <span style="margin-left: 750px">Principal Signature</span><br><br><br><br><br><br>
    <span><center><b>This is a computer-generated document. No signature is required</b></center></span>
        </div>
     
  </body>
</html>