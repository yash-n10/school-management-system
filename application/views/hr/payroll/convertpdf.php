<?php
session_start();
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;


include('connection.php');

$login_id=$_SESSION['id'];
$sql=mysqli_query($con, "select * from job_application where login_id='$login_id'");
$op = mysqli_fetch_array($sql);
// print_r($op);

      $dompdf = new Dompdf();
      $html = '<!DOCTYPE html>
      <meta charset="UTF-8">
     
      <html>
      <body>
      <center><img src="images/logo11.png" style="width:350px;height:110px;"></center>
      <table border="1" width="100%" style="border-collapse:collapse" class="table table-bordered">
        <tr style="align:center;">
          <th colspan="4" ><center> <h4><b> <span style="color:black;">JOB APPLICATION</span></b></h4></center></th>
        </tr>
        <tr>
          <th colspan="2" align="left">Candidate Name</th>
          <td colspan="2">'.$op['cand_name'].'</td>
        </tr>
        <tr>
          <th colspan="2" align="left">Image</th>
          <td colspan="2"><img id="logo" src="./'.$op['img'].'" width="120" height="120" ></td>
        </tr>
        <tr>
          <th colspan="2" align="left">Gender</th>
          <td colspan="2">'.$op['gender'].'</td>
        </tr>
        <tr>
          <th colspan="2" align="left">Category</th>
          <td colspan="2">'.$op['cat'].'</td>
        </tr>
        <tr>
          <th colspan="2" align="left">Date of birth</th>
          <td colspan="2">'.$op['dob'].'</td>
        </tr>
        <tr>
          <th colspan="2" align="left">Class applied for :</th>
          <td colspan="2">'.$op['class_applied1'].','.$op['class_applied2'].','.$op['class_applied3'].','.$op['class_applied4'].','.$op['class_applied5'].'</td>
        </tr>

        <tr>
          <th colspan="2" align="left">Martial Status</th>
          <td colspan="2">'.$op['martial_status'].'</td>
        </tr>

        <tr>
          <th colspan="2" align="left">Email</th>
          <td colspan="2">'.$op['email'].'</td>
        </tr>
        <tr>
          <th colspan="2" align="left">Contact</th>
          <td colspan="2">'.$op['mobile'].'</td>
        </tr>

        <tr>
          <th colspan="2" align="left">Aadhaar No.</th>
          <td colspan="2">'.$op['uid'].'</td>
        </tr>
                <tr>
          <th colspan="2" align="left">Permanent Address</th>
          <td colspan="2">'.$op['permanent_add'].'</td>
        </tr>


        <tr>
            <th colspan="4" >Matric Details</th>
          </tr>
         <tr>
           <th>Year</th>
           <th>Board</th>
           <th>Marks</th>
           <th>Subject</th>
        </tr>
        <tr>
           <td>'.$op['mat_year'].'</td>
           <td>'.$op['mat_board'].'</td>
           <td>'.$op['mat_marks'].'</td>
           <td>'.$op['mat_subject'].'</td>
        </tr>

        <tr>
            <th colspan="4" >Intermediate Details</th>
          </tr>
         <tr>
           <th>Year</th>
           <th>Board</th>
           <th>Marks</th>
           <th>Subject</th>
        </tr>
        <tr>
           <td>'.$op['inter_year'].'</td>
           <td>'.$op['inter_board'].'</td>
           <td>'.$op['inter_marks'].'</td>
           <td>'.$op['inter_subject'].'</td>
        </tr>

        <tr>
            <th colspan="4" >Graduation Details</th>
          </tr>
         <tr>
           <th>Year</th>
           <th>Board</th>
           <th>Marks</th>
           <th>Subject</th>
        </tr>
        <tr>
           <td>'.$op['grad_year'].'</td>
           <td>'.$op['grad_board'].'</td>
           <td>'.$op['grad_marks'].'</td>
           <td>'.$op['grad_subject'].'</td>
        </tr>

        <tr>
            <th colspan="4">Post Graduation Details</th>
          </tr>
         <tr>
           <th>Year</th>
           <th>Board</th>
           <th>Marks</th>
           <th>Subject</th>
        </tr>
        <tr>
           <td>'.$op['pg_year'].'</td>
           <td>'.$op['pg_board'].'</td>
           <td>'.$op['pg_marks'].'</td>
           <td>'.$op['pg_subject'].'</td>
        </tr>


        <tr>
           <th colspan="2" align="left">B.Ed</th>
           <td colspan="2">'.$op['b_ed'].'</td>
          </tr>

        <tr>
            <th colspan="4" >B.Ed Details</th>
          </tr>
         <tr>
           <th>Year</th>
           <th>Board</th>
           <th>Marks</th>
           <th>Subject</th>
        </tr>
        <tr>
           <td>'.$op['bed_year'].'</td>
           <td>'.$op['bed_board'].'</td>
           <td>'.$op['bed_marks'].'</td>
           <td>'.$op['bed_subject'].'</td>
        </tr>

        <tr>
           <th colspan="2" align="left">Computer Knowledge</th>
           <td colspan="2">'.$op['comp'].'</td>
          </tr>
          <tr>
         <th colspan="2" align="left">Additional Qualification</th>
         <td colspan="2">'.$op['otherquali'].'</td>
       </tr>

       <tr>
         <th colspan="2" align="left">Current Designation & Place Of Work</th>
         <td colspan="2">'.$op['desig'].'</td>
       </tr>
      <tr>
                <th colspan="4">Experience Detail</th>  
            </tr>
            <tr>
                <th>Organisation</th>
                <th>Year</th>
                <th>Place</th>
                <th>Designation</th>
            </tr>
            <tr>
         <td>'.$op['past_exp'].'</td>
         <td>'.$op['year'].'</td>
         <td>'.$op['place'].'</td>
         <td>'.$op['c_desig'].'</td>
      </tr>


      </table>

      ';

  $dompdf->loadHtml($html);

  $dompdf->setPaper('A4','portrait');

  /* Render the HTML as PDF */
  $dompdf->render();

 $output = $dompdf->output();
 $application_form=$dompdf->stream("job/applicant_form/$login_id");
 // $application_form="job/applicant_form/$login_id";

send_email($from='',$to='',$subject='',$application_form,$incoming='',$outgoing='','JobApllication.pdf');


 function send_email($from='',$to='',$subject='',$attachment='',$incoming='',$outgoing='',$application='') {
  require("class.phpmailer.php");
  require("class.smtp.php"); 

  $mail = new PHPMailer();
  $mail->IsMail();                    
  $mail->From = "vivekjsr83@yahoo.in";                  // set mailer to use SMTP
  // $mail->From = "recruitment@vivekvidyalayajsr.org";                  // set mailer to use SMTP
  // $mail->From = "vivek_admin@vivekvidyalayajsr.org";
  $mail->FromName = "FeesClub";

  // $mail->AddAddress("prashant3kumar@gmail.com", "Alam");
  // $mail->AddAddress("alamsayeed42@gmail.com", "Alam");
  $mail->AddAddress("ruchirani24may@gmail.com", "Ruchi Rani");
  $mail->AddAddress("avinay.kumar@mildtrix.com", "Avinay");
  // $mail->AddAddress("vivekjsr83@yahoo.in", "Vivek Vidyalaya");
  //   $mail->AddAddress("nitishkumar19@gmail.com", "Nitish");
  //   $mail->AddAddress("viceprincipalvv@gmail.com", "Vice Principal");
  //   $mail->AddAddress("ankur.s@tatamotors.com", "Ankur Sinha");

  $mail->WordWrap = 50;                                 // set word wrap to 50 characters
  $mail->IsHTML(true);                                  // set email format to HTML
  $mail->Subject =$application;
  $mail->Body = "Plz check the attachment";

  if ($attachment != '') {
    $mail->AddStringAttachment($attachment,$application, 'base64', 'application/pdf');  
  }

  if (!$mail->Send()) {
    echo "notsent";
    echo "Mailer Error: " . $mail->ErrorInfo;
    die();
    exit;
  }

  echo "success";
}

?>