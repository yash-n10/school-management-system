<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Recreate_password extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('captcha');
    }

    public function reset_password() {
        $contact_no = '';

        $vals = array(
            'word' => rand(100000, 900000),
            'img_path' => $_SERVER['DOCUMENT_ROOT'].'/assets/captcha/',
            'img_url' => base_url(). 'assets/captcha/',
            'font_path' => $_SERVER['DOCUMENT_ROOT']. '/assets/AdminLTE/fonts/glyphicons-halflings-regular.ttf',
            'img_width' => '150',
            'img_height' => 30,
            'expiration' => 60,
            'word_length' => 6,
            'font_size' => 20,
            'img_id' => 'Imageid',
            'pool' => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
            // White background and border, black text and red grid
            'colors' => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(0, 0, 0),
                'grid' => array(255, 40, 40)
            ),
           
        );

        $cap = create_captcha($vals);
        $this->session->set_userdata('captchaWord', $cap['word']);
        $this->data['page'] = 'reset_password';
        $this->data['cap'] = $cap;
        $this->data['error'] = '';
        $this->data['page_title'] = 'FeesClub ERP Reset Password';

        $this->load->view('login/reset_password', $this->data);
    }

    public function verify() {
//        $number=$this->session->userdata('ran');        
//        $otp_sess= $this->session->userdata('ran',md5($ran));
        $otp_sess = $this->session->userdata('ran', $ran);
        $otp_post = $this->input->post('txt_otp_val');
//        $otp_val=$this->input->post('otp');
//        echo $otp_post.'<br/>';
//        echo $otp_val.'<br/>';
        if (md5($otp_post) == $otp_sess) {
            $this->load->view('login/change_password');
        } else {
            echo 0;
        }
    }

    public function send_otp() {
    	error_reporting(0);
        $user_id = $this->input->post('user_name');
        // echo $user_id.'<br>';
        $school_code_arr = explode('-', $user_id);
        $error='';
     	// $school =1;
     	$school =$this->db->query("SELECT id,school_code,description FROM crmfeesclub.school WHERE school_code = '$school_code_arr[0]' AND status=1")->result();
       // $school = $this->dbconnection->select("crmfeesclub.school", "id,school_code", "school_code=" . $school_code_arr[0] . " and status=1");
        if (count($school) == 1) {
            $school_id = $school[0]->id;
            $school_name = $school[0]->description;
            $school_code = $school[0]->school_code;
            // echo  $school_id;die();
            // $this->db->db_select('crmfeesclub_' . $school_id);
            $user=$this->db->query("SELECT * FROM crmfeesclub_$school_id.user WHERE user_name='$user_id'")->result();
            // $user = $this->dbconnection->select("crmfeesclub_".$school_id."user", "id","password","salt","pw_hash","user_name","user_group_id","student_id","email", "user_name=".$user_id." and status=1");
            echo $user[0]->id;die();
            if (count($user) == 1) {
                
                
//                if($user[0]->email=='' || $user[0]->email==NULL){
//                    $error='Email is not attached with this username';
//                }else{
                    $config=Array(
                        'protocol'=>'smtp',
                        'smtp_host'=>'ssl://smtp.gmail.com',
                        'smtp_port' => 465,
                        'smtp_user' => '', 
                        'smtp_pass' => '', 
                        'mailtype' => 'text',
                        'charset' => 'iso-8859-1',
                        'wordwrap' => TRUE
                    );

                  $this->load->library('email',$config);


                    $this->email->from('');
                    $this->email->to('narayanyash10@gmail.com');
                    $this->email->subject("Feesclub Password Reset");
                    $this->email->message('Password Reset');
                    $this->email->set_newline("\r\n");
          //          $this->email->_set_date();
//                     $this->email->attach('fpdf/Invoice8.pdf');
                    $e=$this->email->send();
                    echo $this->email->print_debugger();
                   if($e)
                    {
                    echo 'Email sent.';    
                    }
                   else
                   {
                    show_error($this->email->print_debugger());  
                   }
//                }
                    
                
            }else{
                $error='No Such User is Present';
            }
        } else {
            $error='Username is Invalid';
        }
        echo $error;


    }

//  public function send_otp()
//   {
//        $string = '<pushsms><Title>Test XML</Title></pushsms>';
//        $headers = array(
//            "Content-type: text/xml",
//            "Connection: close",
//        );
//
//
//        $xmlData = '
//        <pushsms>
//        <username>Jagan@mildtrix.com</username>
//        <password>Inspiron6411</password>
//        <senderid>SMSIND</senderid>
//        <messages>
//        <message pno="9507679379" msg="Test sms from 9507679379. Thanks for choosing our service - 9507679379">
//        </message>
//        <message pno="9709236992" msg="Test sms from 9709236992. Thanks for choosing our service - 9709236992">
//        </message>
//        </messages>
//        </pushsms>';
//        $post = 'xmlstring='. urlencode($xmlData);
//        $url = "http://smsc.biz/xmlapi/send";
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_POST ,1);
//        curl_setopt($ch, CURLOPT_POSTFIELDS ,$post);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER ,1);
//        $data = curl_exec($ch);
//        curl_close($ch);
//        echo $data;
////                $data=array('number'=>$ran);
////                $this->load->view('forgot_password/otp_verify',$data);
//    }




    public function change_password() {
        $user_id = $this->session->userdata('user_id');
        $password = $_POST['change_re_password'];

        $salt = $this->generateRandomString();
        $encryption = $this->dbconnection->select('encrypt', '*');
        $value = rand(0, count($encryption) - 1);
        $encryption_id = $encryption[$value]->id;
        $encryption_type = $encryption[$value]->encryption_type;

        $password = $encryption_type($password . $salt);

        $data = array(
            'password' => $password,
            'salt' => $salt,
            'encrypt_id' => $encryption_id,
            'change_password' => 1,
            'last_date_modified' => date('Y-m-d H:i:s'),
            'last_modified_by' => ''
        );
        $user = $this->dbconnection->update('user', $data, 'user_name ="' . $user_id . '"');


        $id = $this->dbconnection->select('user', '*', 'user_name="' . $user_id . '"');

//Audit Trail
        $audit = array("action" => 'Reset User Password',
//          "module" => "Student Module",
            'datetime' => date("Y-m-d H:i:s"),
            'userid' => $id[0]->id,
            'school_id' => $id[0]->school_id,
            'student_id' => $id[0]->student_id,
            'page' => 'Student',
            'remarks' => 'Change Password'
        );
        $this->dbconnection->insert("auditntrail", $audit);

        header("Location: " . site_url("Login"));
    }

    public function generateRandomString($length = 25) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
