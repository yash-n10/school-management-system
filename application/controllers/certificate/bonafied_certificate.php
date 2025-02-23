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
  /*padding: 2px 10px;*/
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

/*.tablecustomtd {
  border-bottom:1px solid #ffffff;
  background: #ffffff;
}*/
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

<body style="width:100%;border-style: double;">
    <div class="div1" >
      
        <span> <span><center> <img style="padding-top:5px;padding-bottom: 5px;" src="<?php echo $_SERVER['DOCUMENT_ROOT'];?>/<?php echo $logo;?>"height="75px;"></center>
        </span>
         <center>
          <h1><b><?php echo $school_desc[0]->description; ?> </b></h1>
          <!-- <h1><b><?php echo $school_desc[0]->description; ?> </b></h1> -->
          <br>
            <?php echo $school_desc[0]->address; ?>      
                </b><br>
                 MAIL : <?php echo $school_desc[0]->email; ?> &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp; TEL : <?php echo $school_desc[0]->phone; ?><br>
                    
        </span> <br><br>
        <center><span><b><u><i style="font-family:italic">To Whom It May Concern</i></u></b></span></center><br><br><br>
        <span ><b>This is to Certify that &nbsp;&nbsp;&nbsp; <?php echo $data[0]->father_name?> &nbsp;&nbsp;&nbsp; & &nbsp;&nbsp;&nbsp; <?php echo $data[0]->mother_name?> &nbsp;&nbsp;&nbsp; have paid the Tuition Fee of their ward in our school as per details given below:-</b></span><br><br><br>
          
    <br><br>
          <table style="width: 100%;top: 10px;">
            <tr>
                <!-- <th style="text-align:center;width:10%" rowspan="2"><strong>S No.</strong></th> -->
                <th style="text-align:center;width:15%;" rowspan="2"><strong>Adm. No</strong></th>
                <th style="text-align:center;width:10%;" rowspan="2"><strong>Ward Name</strong></th>
                <th style="text-align:center;width:10%;" rowspan="2"><strong>Class</strong></th>
                <th style="text-align:center;width:15%;" rowspan="2"><strong>Academic Session</strong></th>                
                <th style="text-align:center;width:15%;" rowspan="2"><strong>Tuition Fees</strong></th>                
                <th style="text-align:center;width:20%;" colspan="2"><strong>Amount Paid During the Period</strong></th>
                <th style="text-align:center;width:20%;" rowspan="2"><strong>Total Tution Fee Paid</strong></th>
                   
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
              $aaa="April-2020";
            }
            if($first=='2')
            {
              $aaa="May-2020";
            }
            if($first=='3')
            {
              $aaa="June-2020";
            }
            if($first=='4')
            {
              $aaa="July-2020";
            }
            if($first=='5')
            {
              $aaa="August-2020";
            }
            if($first=='6')
            {
              $aaa="September-2020";
            }
             if($first=='7')
            {
              $aaa="October-2020";
            }
             if($first=='8')
            {
              $aaa="November-2020";
            }
             if($first=='9')
            {
              $aaa="December-2020";
            }
             if($first=='10')
            {
              $aaa="January-2021";
            }
              if($first=='11')
            {
              $aaa="February-2021";
            }
            if($first=='12')
            {
              $aaa="March-2021";
            }


             if($last==1)
            {
              $bbb="April-2020";
            }
            if($last=='2')
            {
              $bbb="May-2020";
            }
            if($last=='3')
            {
              $bbb="June-2020";
            }
            if($last=='4')
            {
              $bbb="July-2020";
            }
            if($last=='5')
            {
              $bbb="August-2020";
            }
            if($last=='6')
            {
              $bbb="September-2020";
            }
             if($last=='7')
            {
              $bbb="October-2020";
            }
             if($last=='8')
            {
              $bbb="November-2020";
            }
             if($last=='9')
            {
              $bbb="December-2020";
            }
             if($last=='10')
            {
              $bbb="January-2021";
            }
              if($last=='11')
            {
              $bbb="February-2021";
            }
            if($last=='12')
            {
              $bbb="March-2021";
            }

            
            ?>
            <tr>
              <!-- <td style="text-align:center;width:10%" class="tablecustomtd"><?php //echo $i;?></td> -->
              <td style="text-align:center;width:15%" class="tablecustomtd"><?php echo $data[0]->admission_no?></td>
              <td style="text-align:center;width:10%" class="tablecustomtd"><?php echo $data[0]->first_name?>&nbsp;&nbsp;&nbsp;<?php echo $data[0]->middle_name?>&nbsp;&nbsp;&nbsp;<?php echo $data[0]->last_name?></td>
              <td style="text-align:center;width:10%" class="tablecustomtd"><?php echo $data[0]->class_name?>&nbsp;&nbsp;&nbsp;<?php echo $data[0]->sec_name?></td>
              <td style="text-align:center;width:15%" class="tablecustomtd"><?php echo $data[0]->session?></td>
              <td style="text-align:center;width:15%" class="tablecustomtd"><?php echo $data[0]->tuition_fee/$last;?></td>
              <td style="text-align:center;width:10%" class="tablecustomtd"><?php echo $aaa;?></td>            
              <td style="text-align:center;width:10%;" class="tablecustomtd"><?php echo $bbb;?></td> 
              <td style="text-align:center;width:20%" class="tablecustomtd"><?php echo $data[0]->tuition_fee; ?>.00</td>
              
              
            </tr>
            <?php $i++;?>
              

              
        <!-- ******************* -->

          </table><br><br>
    
          <span>Tuition Fee Paid(In Words): <?php echo strtoupper($total_amt_words.' only');?></span><br><br><br>

          
  
    <p><span ><?php echo date("d/m/Y"); ?><br>ISSUE DATE</span><span style="margin-left: 300px">DEALING CLERK</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PRINCIPAL



    <!-- <span style="margin-left: 750px;">PRINCIPAL </span> -->

    <p><br><br><br>
    <!-- <span><center><b>This is a computer-generated document. No signature is required</b></center></span> -->
        </div>
     
  </body>
</html>