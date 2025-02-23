  <?php
  foreach ($invoice_data as $value) 
  {
    $exam_name      = $value->exam_name;
  }

  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
  <title>Attendance Sheet</title>

  <style>
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
    font-size: 12px; 
    font-family: Arial;
  }

  header {
    padding: 10px 0;
    margin-bottom: 30px;
  }

  #borderr {
    margin: 0px 0px 0px -18px;
    
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
    /*border-bottom: 1px solid #C1CED9;*/
    white-space: nowrap;        
    font-weight: bold;
  }

  table td {
    padding: 7px;
    text-align: right;  
  }

  table { page-break-inside:auto }
  tr    { page-break-inside:avoid; page-break-after:auto }

  .tablecustomtd {
    /*border-bottom:1px solid #ffffff;*/
    background: #ffffff;
  }
   .tabletop{
    border-top: 1px solid #ffffff;
    background: #ffffff;
  }
  .tableright{
    /*border-right: 1px solid #ffffff;*/
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
      <div class="row">
        <div class="col-md-12" id="borderr">
           <table border="0">
            <tr>
              <th colspan="3">    
          <?php  $school_id=$school_data[0]->id; ?>
              <img src="assets/img/<?php echo $school_id;?>.JPG" height="70px;">
                         </th>
                <td><span><h1 style="position: static;width: 700px;padding-bottom: 2px;padding-top: 2px;"><center><?php echo $school_data[0]->description;?></center></h1></span><br></td>
                <td></td>
             
            </tr>
          </table>
         
          <div style="border :0px">
            <table style="width: 100%;" style="border :none">
              <tr style="border :none">
                <th colspan="4" style="text-align: left;" class="tablecustomtd tableright"><b>Email</b> : <?php echo $school_data[0]->email;?></th>
                <th colspan="4" style="text-align: left;" class="tablecustomtd"> Mobile : <?php echo $school_data[0]->phone;?></th>             
              </tr>
                  <!-- upper row -->
          <!-- ******************* -->

            </table>
          </div>  
             <div>
                    <p style='font-size: 16px'><left><b>Attendance Sheet</b> </left></p>
                    <p style='text-align: left; font-size: 16px'><b>Exam Name :<?php echo $value->exam_name;?></b></p>
          </div>
            
             <div>
            <table style="width: 100%;border :none">
              <tr style="border :none">
                  <th style="text-align:center;width:1%">S<br>No.</th>
                  <th colspan="4" style="text-align: left;" class="tablecustomtd tableright">Class</th>          
                  <th colspan="4" style="text-align: left;" class="tablecustomtd tableright">Section</th>          
                  <th colspan="4" style="text-align: left;" class="tablecustomtd tableright">Roll No.</th>          
                  <th colspan="4" style="text-align: left;" class="tablecustomtd tableright">Student Name</th>          
                  <th colspan="4" style="text-align: left;" class="tablecustomtd tableright">Student Signature</th>          
              </tr>
              <?php $i=1; foreach($invoice_data as $data)
          { ?>
              <tr>
                  <td style="text-align:center;width:3%" class="tablecustomtd"><?php echo $i;?></td>
                  <td colspan="4" style="text-align: left;"><?php echo $data->class_name;?></td>
                  <td colspan="4" style="text-align: left;"><?php echo $data->sec_name;?></td>
                  <td colspan="4" style="text-align: left;"><?php echo $data->roll ?></td>
                  <td colspan="4" style="text-align: left;"><?php echo $data->first_name;?> <?php echo $data->middle_name;?> <?php echo $data->last_name;?></td>
                  <td colspan="4" style="text-align: left;"></td>
              </tr>
                      <?php $i++; }?>
                  <!-- upper row -->
          <!-- ******************* -->

            </table>
          </div>
          <br><br><br>
          <p><span style="text-align: left">Invigilator Signature 1 :-----------------------------</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="text-align: right">Invigilator Signature 2 :-----------------------------</span></p>

          <br><br><br><br>
          <?php 
            if(function_exists('date_default_timezone_set')) {
              date_default_timezone_set("Asia/Kolkata");
            }

            $date = date("d/m/Y");
            $date1 =  date("H:i a");?>
          <p>Date of Print : <?php echo $date; ?></p>
        </div>
     </div>
    </body>
  </html>