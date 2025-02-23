<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Test extends CI_Controller {

    function __construct() {

        parent::__construct();
        // error_reporting(~E_NOTICE);
        // error_reporting(-1);
        // ini_set('display_errors', 1);
        // $this->db->db_debug = TRUE;
        $this->load->model('Mymodel');
        

        $this->id = $this->session->userdata('school_id');
        $user=$this->session->userdata('user_id');
        $this->user_group_id = $this->session->userdata('user_group_id');

         $user_id    = $this->session->userdata('user_id');
        $user = $this->dbconnection->select('user', '*', 'id='.$this->session->userdata('user_id'));
        $this->student_id=$user[0]->student_id;
        if ($this->id != 0) {
            $this->db->db_select('crmfeesclub_' . $this->id);
            $this->academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year,start_date,end_date,session", "status='Y' and active='Y'", '', '', array('id'));
        }
    }

    /*     * *default functin, redirects to login page if no admin logged in yet** */

    public function index() {
      error_reporting(0);
        $page_data['page_name'] = 'teacher_dashboard';
        $page_data['page_title'] = 'Dashboard';
        $page_data['section'] = 'dashboard';
        $page_data['customview'] = '';

        $page_data['employee'] = $this->dbconnection->select('employee', '*,(select designation_desc from employee_designation where id=designation_id) as designation_name,(select department_desc from employee_department where id=department_id) as department_name,(select category_desc from employee_category where id=category_id) as category_name,(select leave_group_name from leave_group where id=employee.leave_group) as leave_group', 'status="Y"');
        $this->load->view('index', $page_data);
    }
    

    public function profile() {
        $this->load->model('dbconnection');
        // error_reporting(0);
        // ini_set('display_errors', 1);
        $page_data['page_title'] = 'Profile';
        $page_data['section'] = 'dashboard';
        $page_data['customview'] = '';
        $user_id    = $this->session->userdata('user_id');
        $user = $this->dbconnection->select('user', '*', 'id='.$this->session->userdata('user_id'));
//        print_r($user);
     
      if($this->session->userdata('user_group_id')==4)
      {

        $page_data['indication'] = 'student';
        $page_data['page_name'] = 'studprofile';
        $page_data['stud']= $this->db->query("select id,admission_no,dob,father_name,class_id,mother_name,student_aadhar,phone,gender,CONCAT(first_name,' ',middle_name,' ',last_name) as name,address,(select class_name from class where id=class_id) as class,(select sec_name from section where id=section_id) as section,(select cat_name from category where id=stud_category) as stud_cat,phone,email_address,dob,photo,father_phone,mother_phone from student as emp where id={$user[0]->student_id}")->result();       
        
      }
      else{
        $page_data['indication'] = 'employee';
        $page_data['page_name'] = 'profile';
         $page_data['emp']= $this->db->query("select * from employee where id={$user[0]->employee_id }")->result();
         // print_r($this-> $page_data);
      }
   
        $this->load->view('index', $page_data);
    }

    public function save()
    {
        //echo 'hi';
    }
    public  function chkoldpass()
    {
        $uname=$this->session->userdata('user_name');
        $oldpasss=$this->dbconnection->Get_namme("user","id","{$this->session->userdata('user_id')}","pw_hash");
       // echo $rr= password_verify($this->input->post('oldpass'), $oldpasss);
        if (password_verify($this->input->post('oldpass'), $oldpasss)) {
            echo '1';
        }
        else {
            echo 0;
        }
              
    } 
   

    public function passupdate()
    {   
        $uname=$this->session->userdata('user_name');
        $user_id=$this->session->userdata('user_id');
      if($this->user_group_id!=4)
{
        $user = $this->dbconnection->select('user', 'employee_id', 'id='.$this->session->userdata('user_id'));
     
      }
      else{
         $user = $this->dbconnection->select('user', 'student_id', 'id='.$this->session->userdata('user_id'));
      }
        if($this->user_group_id==4)
      {
        //student table
        $stud=$this->dbconnection->select('student','*','id='.$user[0]->student_id);
        $email=$stud[0]->email_address;
         $phone=$stud[0]->phone;
       
      }
      else {
        //employee table
        $emp=$this->dbconnection->select('employee','*','id='.$user[0]->employee_id);
        $phone=$emp[0]->phone_no;
        $email=$emp[0]->email;
      }
        $oldpass=$this->input->post('oldpass');
        $send_address=$this->input->post('send_address');
        $rand=rand(100000,999999);
        // $new_pass=$this->input->post('new_pass');
        $hashoptions  = array(); // No options currently, but, we could add in future
        $new_pass     = password_hash($this->input->post('new_pass'), PASSWORD_DEFAULT, $hashoptions); // Generate new hash
        $ip = $_SERVER['REMOTE_ADDR'];
        $data=array(
            'req_user_id'=>$user_id,
            'old_password'=>$oldpass,
            'new_password'=>$new_pass,
            'email_phone'=>$send_address,
            'accademic_year'=>$this->academic_session[0]->fin_year,
            'created_ip'=>$ip,
            'created_by'=>$this->session->userdata('user_id'),
            'otp'=>$rand,
            'is_expired'=>0,
        );
        
       if($send_address=='phone'){
       // $this->send_bulksmsind($phone,$rand);
        $msg=$rand;
        $s=$this->send_bulksmsind($phone,$msg);
    
         
            $data1 = array(
                'from_user' =>$this->session->userdata('user_name'),//username
                'to_user' => $this->session->userdata('user_id'), //id student id ya employee
                'to_number' => $phone,
                'message_content' => $msg,
                'response' => $s['responseCode'],
                'msg_id' =>  $s['msgid'],
                'sent_ts' => date('Y-m-d H:i:s'), 
                'send_ip' => $this->input->ip_address(),
                'created_by' => $this->session->userdata('user_id'),
            );
            $this->dbconnection->insert('messages', $this->security->xss_clean($data1));
      
       }
       else if($send_address=='email') {
           $this->mail($email,$rand);
              $data2 = array(
                    'from_user' => $this->session->userdata('user_name'),
                    'to_user' => $this->session->userdata('user_id'),
                    'subject' => $rand,
                    'message_content' => 'Request for change password',
                    'attachment' => '',
                    'type'=>'change_password',
                    'sent_ts' => date('Y-m-d H:i:s'),
                    'send_ip' => $this->input->ip_address(),
                    'created_by' => $this->session->userdata('user_id'),
                );
                $this->dbconnection->insert('mail', $this->security->xss_clean($data2));
       
       }
       else {
         echo '';
       }
        $this->dbconnection->insert('change_password_log', $data);

        $last_id=$this->dbconnection->get_last_id();
        $this->session->set_userdata('change_pwd_req_id',$last_id);
       echo '1';
          // $this->send_bulksmsind($this->input->post('contact'),$rand);
           // $this->mail($this->input->post('contact'),$rand,$email);
          // mail();
    }   

    public function otpresend()
    {

        $uname=$this->session->userdata('user_name'); 
        $user_id=$this->session->userdata('user_id');
        
       // $user = $this->dbconnection->select('user', 'college_id', 'id='.$this->session->userdata('user_id')); 
         if($this->user_group_id!=4)
      {
        $user = $this->dbconnection->select('user', 'employee_id', 'id='.$this->session->userdata('user_id'));
     
      }
      else{
         $user = $this->dbconnection->select('user', 'student_id', 'id='.$this->session->userdata('user_id'));
      }
        if($this->user_group_id==4)
        {
          //student table
          $stud=$this->dbconnection->select('student','*','id='.$user[0]->student_id);
          $email=$stud[0]->email_address;
          $phone=$stud[0]->phone;
        }
        else 
        {
          //employee table
          $emp=$this->dbconnection->select('employee','*','id='.$user[0]->employee_id);
          $phone=$emp[0]->phone_no;
          $email=$emp[0]->email;
        }

       // $email=$this->input->post('email');
       // $phone=$this->input->post('contact');
      $rand=rand(100000,999999);
      $getrow= $this->dbconnection->select('change_password_log','*',"req_user_id='$user_id' AND otp_verify='' AND is_expired=0","id","DESC");
      $req_user_id=$getrow[0]->req_user_id;
      $accademic_year=$getrow[0]->accademic_year;
      $old_password=$getrow[0]->old_password;
      $new_password=$getrow[0]->new_password;
      $send_address=$getrow[0]->email_phone;
      $ip = $_SERVER['REMOTE_ADDR'];
      $data=array(
            'req_user_id'=>$req_user_id,
            'old_password'=>$old_password,
            'new_password'=>$new_password,
            'email_phone'=>$send_address,
            'accademic_year'=>$this->academic_session[0]->fin_year,
            'created_ip'=>$ip,
            'created_by'=>$this->session->userdata('user_id'),
            'otp'=>$rand,
            'is_expired'=>0,
        );
      if($send_address=='phone'){
        
        // $this->send_bulksmsind($phone,$rand);
        $msg=$rand;
        $s=$this->send_bulksmsind($phone,$msg);
    
         
            $data1 = array(
                'from_user' =>$this->session->userdata('user_name'),//username
                'to_user' => $this->session->userdata('user_id'), //id student id ya employee
                'to_number' => $phone,
                'message_content' => $msg,
                'response' => $s['responseCode'],
                'msg_id' =>  $s['msgid'],
                'sent_ts' => date('Y-m-d H:i:s'), 
                'send_ip' => $this->input->ip_address(),
                'created_by' => $this->session->userdata('user_id'),
            );
            $this->dbconnection->insert('messages', $this->security->xss_clean($data1));
        //message table entry

      }
      else if($send_address=='email') {
        $this->mail($email,$rand);
            $data2 = array(
                    'from_user' => $this->session->userdata('user_name'),
                    'to_user' => $this->session->userdata('user_id'),
                    'subject' => $rand,
                    'message_content' => 'Request for change password',
                    'attachment' => '',
                    'type'=>'change_password',
                    'sent_ts' => date('Y-m-d H:i:s'),
                    'send_ip' => $this->input->ip_address(),
                    'created_by' => $this->session->userdata('user_id'),
                );
                $this->dbconnection->insert('mail', $this->security->xss_clean($data2));

      }
      else 
      {
        echo '';
      }
      
      $this->dbconnection->insert('change_password_log', $data);
      $last_id=$this->dbconnection->get_last_id();
      $this->session->set_userdata('change_pwd_req_id',$last_id);
      echo '1';
    }

     public  function chkotp()
    {
        // $user_id=$this->input->post('user_id');
        // $uname=$this->input->post('uname');
        $uname=$this->session->userdata('user_name');
        $user_id=$this->session->userdata('user_id');
        $cnf_otp=$this->input->post('cnf_otp');
        $data= array(
                'req_user_id' =>$user_id ,
                'otp'=>$cnf_otp,
            );
        // $counts = $this->dbconnection->count('change_password_log',$data,"id={$this->session->userdata('change_pwd_req_id')} AND is_expired!=1 AND NOW() <= DATE_ADD(date_created, INTERVAL 24 HOUR)");
         $counts = $this->dbconnection->count('change_password_log',"req_user_id=$user_id AND otp=$cnf_otp AND  id={$this->session->userdata('change_pwd_req_id')} AND is_expired!=1 AND DATE_ADD(date_created, INTERVAL 2 MINUTE) >= NOW()");
        echo $counts;
        

        // $counts = $this->dbconnection->count('change_password_log',$data,"id={$this->session->userdata('change_pwd_req_id')}");
       
              
    } 

        function otpsave()
        {
            $uname=$this->session->userdata('user_name');
            $id=$this->session->userdata('user_id');
            // $uname=$this->input->post('uname');
            // $id=$this->input->post('user_id');
            $cnf_otp=$this->input->post('cnf_otp');
            $ip = $_SERVER['REMOTE_ADDR'];
            $data=array(
                'otp_verify'=>'Y', 
                'is_expired'=>1, 
            );           
            $this->dbconnection->update('change_password_log',$data,"id={$this->session->userdata('change_pwd_req_id')}");
          $get= $this->dbconnection->select('change_password_log','*',"id={$this->session->userdata('change_pwd_req_id')}");
          
          $new_password=$get[0]->new_password;
          $req_user_id=$get[0]->req_user_id;
          $getvalue_change_pass=$this->dbconnection->select('user','change_password','id='.$this->session->userdata('user_id')); 
          $chg_pass=$getvalue_change_pass[0]->change_password;

          $datas=array(
             'pw_hash'=> $new_password,
             'change_password'=>$chg_pass+1,
          );
         
           $this->dbconnection->update('user',$datas,"id='$req_user_id'");
           echo '1';


            //$this->input->update('user',)

        }

    function send_bulksmsind($phone,$rand)
   {
       $contact = urlencode ($phone);
       $msg = urlencode ($rand);
       $sender='MILDRX';
       $url = "http://sms.bulksmsind.in/sendSMS?username=mildrix&message=$msg&sendername=$sender&smstype=TRANS&numbers=$contact&apikey=08052465-9d8d-4913-b6d1-f3f58a817623";
           // http://sms.bulksmsind.in/sendSMS?username=mildrix&message=sss&sendername=MILDRX&smstype=TRANS&numbers=8093314514&apikey=08052465-9d8d-4913-b6d1-f3f58a817623
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $json= json_decode($response);
        $arr['responseCode']=$json[0]->responseCode;
        $arr['msgid']=$json[1]->msgid;
        return $arr;
   }
   function mail($email,$rand)
   {
 
            $email = urlencode ($email);
             $msg = urlencode ($rand);
            $to      ="email";
            $subject = "College erp";
            $headers = "From: College erp" . "\r\n" .
            $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>THE United Club</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <style>
      .font{
        font-family: "open sans", sans-serif;
      }
    </style>
</head>
<body style="margin:0; padding:10px 0 0 0;" bgcolor="#F8F8F8">
<table align="center" cellpadding="0" cellspacing="0" width="95%%">
    <tr>
        <td align="center">
            <table align="center" cellpadding="0" cellspacing="0" width="600"
                   style="border-collapse: separate; border-spacing: 2px 5px; box-shadow: 1px 0 1px 1px #B8B8B8;"
                   bgcolor="#FFFFFF">

                  <tr>
                    <td>
                        <table cellpadding="0" cellspacing="0" width="100%%" style="padding:6px 10px 0px 10px;">
                           
                                <tr>
                                    <td align="left"><strong>Email</strong>: </td>
                                    <td align="left">Your otp is:'.$msg.'</td>
                                </tr>
                                
                        </table>
                    </td>
                </tr>
                        </table>
                    </td>
                </tr>
              

                 
            </table>

        </td>
    </tr>
</table>
</body>
</html>';
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: collegeerpfc@gmail.com' . "\r\n";
            $headers .= 'bcc: akm9135@gmail.com' . "\r\n";
            if (mail($to, $subject, $message, $headers)) {
                // echo 'sent';
            } else {
                // echo 'not sent';
            }
   }

   public function updatestuprofile()
   {
        $sch_id=$this->session->userdata('school_id');
        echo $student_id=$this->input->post('student_id');
        $photoimg_name=$_FILES['upload_data']['name'];
        $pic_img_name=$sch_id.'_'.$student_id.'_'.time();
        $fileExt = pathinfo($photoimg_name, PATHINFO_EXTENSION);
        $photoimg_upload_name=$pic_img_name;
        $config['upload_path'] = 'assets/Schools_Photos/student_pic';
        $config['allowed_types'] = 'jpg|png|jpeg|pdf|msword';
        $config['file_name'] =$photoimg_upload_name;
        $config['overwrite'] = false;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if($this->upload->do_upload('photo'))
        {  
          $uploadData_1 = $this->upload->data();
          $image = $uploadData_1['file_name'];           
        $new_name = $sch_id.'_'.$student_id.'_'.time().$uploadData_1['file_ext'];            

            $data=  array(
                'father_name' => $this->input->post('father_name'),
                'mother_name' => $this->input->post('mother_name'),
                'father_phone' => $this->input->post('father_phone'),
                'mother_phone' => $this->input->post('mother_phone'),
                'address' => $this->input->post('address'),
                'permanent_address' => $this->input->post('permanent_address'),
                'gender' => $this->input->post('gender'),
                'email_address' => $this->input->post('email'),
                'photo' => $new_name,
            );           
        }
        else
        {
            $data=  array(
                'father_name' => $this->input->post('father_name'),
                'mother_name' => $this->input->post('mother_name'),
                'father_phone' => $this->input->post('father_phone'),
                'mother_phone' => $this->input->post('mother_phone'),
                'address' => $this->input->post('address'),
                'permanent_address' => $this->input->post('permanent_address'),
                'gender' => $this->input->post('gender'),
                'email_address' => $this->input->post('email'),
            );             
        }
        
        $result = $this->dbconnection->update('student',$data,'id='.$student_id);
        header("Location: " . base_url("Test/profile"));
   }
}    
