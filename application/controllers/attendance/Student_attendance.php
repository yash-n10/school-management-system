<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Student_attendance extends CI_Controller {
    
    public $page_code = 'attendance_student';
    public $page_id = '';
    public $page_perm = '----';


    
    public function __construct() {
        parent::__construct();

        $this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");

        $this->id = $this->session->userdata('school_id');
        $this->school_desc = $this->dbconnection->select("school", "*", "id=" . $this->id . " and status = 1");
        $this->schools = $this->dbconnection->select("school", "*", 'status = 1');
        // $this->user = $this->dbconnection->select('user', '*', 'id = ' . $this->session->userdata('user_id'));
            

        if ($this->id != 0)
            $this->db->db_select('crmfeesclub_' . $this->id);
        $user_id = $this->session->userdata('user_id');
            $this->user = $this->dbconnection->select('user', '*', 'id='.$this->session->userdata('user_id'));
            // print_r($this->user);
            $this->stud_id = $this->user[0]->student_id;
            $this->employee_id = $this->user[0]->employee_id;
        $permission = $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
        $this->page_perm = !empty($permission) ? $permission[0]->permission : '----';
        $this->right_access = $this->page_perm;

        if (strpos($this->page_perm, '----') == true) {
            redirect(base_url(''), 'refresh');
        }

        $this->dualpermission = $this->dbconnection->select("dual_permission", "authorise_person3,permission", "link_code=$this->page_id");
        $this->page_perm = !empty($this->dualpermission) ? $this->dualpermission[0]->permission : '----';
        $this->person = !empty($this->dualpermission) ? $this->dualpermission[0]->authorise_person3 : '';


        $this->sms_setting=$this->dbconnection->select('sms_notification','*',"link_code=$this->page_id");

        $this->dual_right_access = $this->page_perm;

        $this->page_title = 'Student Attendance';
        $this->section = 'attendance';
        // $this->page_name = 'student_attendance_register';
        $this->page_name = 'student_attendance';
        $this->customview = '';



        $this->admission_csv_columns = array(
            array('field' => 'admission_no', 'human_name' => 'Admission Number'), //0
            array('field' => 'first_name', 'human_name' => 'First Name'), //1
            array('field' => 'middle_name', 'human_name' => 'Middle Name'), //2
            array('field' => 'last_name', 'human_name' => 'Last Name'), //3
            array('field' => 'class_id', 'human_name' => 'Class'), //4
            array('field' => 'section_id', 'human_name' => 'Section'), //5
            array('field' => 'roll', 'human_name' => 'Roll Number'), //6
            array('field' => 'Month', 'human_name' => 'Month'), //7
            array('field' => 'date', 'human_name' => 'Date'), //8

        );
    }

    public function index() {

          error_reporting(-1);
        ini_set('display_errors', 1);
        $this->db->db_debug=TRUE;
        if (substr($this->right_access, 1, 1) != 'R') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->data['page_name'] = $this->page_name;
        $this->data['page_title'] = $this->page_title;
        $this->data['section'] = $this->section;
        $this->data['customview'] = $this->customview;
        $this->data['class'] = $this->dbconnection->select("class", "id,class_name", "status='Y'");
        $this->data['classsection'] = $this->dbconnection->select("section", "id,sec_name", "status='Y'");
        $this->data['school_data']=$this->school_desc;
        $this->data['sms_set']=$this->sms_setting;
        $this->data['class_data']=$this->db->query("select ct.teacher_id,ct.class_id,ct.section_id,c.id,c.class_name,s.id,s.sec_name from class_teachet_alloc ct,class c,section s where ct.status=1 and c.status='Y' and ct.class_id=c.id and ct.section_id=s.id and ct.teacher_id=".$this->employee_id)->result();

// echo "<pre>";print_r($this->data);
//         die();

        $this->load->view('index', $this->data);
    }

    public function load_student() {
        $task = $this->input->post('task');
        $aclass = $this->input->post('class');
        $asection = $this->input->post('section');
        $adate = $this->input->post('date');
        $this->data['task'] = $task;
        if ($task == 'add') {
            $this->data['fetch_student'] = $this->dbconnection->select("student", "id,admission_no, concat(first_name,' ',middle_name,' ',last_name) as name", "class_id=$aclass and section_id=$asection and status='Y'");
        } else {
            $this->data['fetch_student'] = $this->dbconnection->select("student_attendance", "*,(select concat(first_name,' ',middle_name,' ',last_name) from student where id=student_id) as name", "student_id in (select id from student where class_id=$aclass and section_id=$asection and status='Y') and date='$adate'");

            
        }

        $this->load->view("attendance/upload_student", $this->data);
    }

    public function save_stud_attendance() {

          error_reporting(-1);
        ini_set('display_errors', 1);
        $this->db->db_debug=TRUE;
        
        $aclass = $this->input->post('cls');
        $asection = $this->input->post('sec');
        $date = $this->input->post('attendance_date');
        $d = date_parse_from_format("Y-m-d", $date);
        $inputall = $this->input->post();
        $mon=$d["month"];
         $day=$d["day"];
        $num=$this->db->query("SELECT id from class_periods")->num_rows();
        $j = 1;
         $period= array();
        while($j<$num+1){
       $check =$this->input->post($j);
       if (isset($check)) {
         $period[] = $this->input->post($j); 
        
        }
        else{

        }
       $j++;
        }
       

        // $period=11; 
        $period = json_encode($period);
         $datahead =  array(
            'class_id' => $aclass, 
            'section_id' => $asection, 
            'month' => $mon, 
            
        );

        $this->dbconnection->insert("stud_mnthly_att_head", $datahead);
        $head_id=$this->db->insert_id();
            foreach ($inputall['astud_id'] as $val => $r) {
                $datadetail = array(
                    'mnthly_att_head_id' => $head_id,
                    'atten_date' =>$day,
                    'stud_id' => $r,
                    'adm_no' =>$this->dbconnection->Get_namme("student", "id", "$r", "admission_no"),
                    'roll' =>  $this->dbconnection->Get_namme("student", "id", "$r", "roll"),
                    'attendance' => $inputall['attendance'][$r],
                    'periods'=>$period
                );
                $this->dbconnection->insert("stud_mnthly_att_detail", $datadetail);
            }
        echo 1;
        
        // $aclass = $this->input->post('class');
        // $asection = $this->input->post('section');
        // $date = $this->input->post('attendance_date');
        // $inputall = $this->input->post();
        // foreach ($inputall['astud_id'] as $val => $r) {
        //     $data = array(
        //         'student_id' => $r,
        //         'admission_no' => $this->dbconnection->Get_namme("student", "id", "$r", "admission_no"),
        //         'attendance' => $inputall['attendance'][$r],
        //         'date' => $date,
        //         'remarks' => $inputall['rem'][$val],
        //     );
        //     $this->dbconnection->insert("student_attendance", $data);
        // }
        // echo 1;
    }


    public function save_stud_attendance_sms() {
           error_reporting(-1);
        ini_set('display_errors', 1);
        $this->db->db_debug=TRUE;
        $this->load->helper('sms_helper');

        $aclass = $this->input->post('cls');
        $asection = $this->input->post('sec');
        $date = $this->input->post('attendance_date');
        $d = date_parse_from_format("Y-m-d", $date);
        $inputall = $this->input->post();
        $mon=$d["month"];
        $day=$d["day"];

        switch ($this->session->userdata('school_id')) {
            case 26 : $sender = 'MOUNTC';
            $sms_gy = 'send_smstomountc';
            break;
        case 5 : $sender = 'VVSJSR';
            $sms_gy = 'send_bulksmsind_vv';
            break;
        default : $sender = 'MILDRX';
            $sms_gy = 'send_bulksmsind';
            break;
        }

        $datahead =  array(
            'class_id' => $aclass, 
            'section_id' => $asection, 
            'month' => $mon, 
        );
      
        $this->dbconnection->insert("stud_mnthly_att_head", $datahead);
        $head_id=$this->db->insert_id();
            foreach ($inputall['astud_id'] as $val => $r) {
               
               
                

                $datadetail = array(
                    'mnthly_att_head_id' => $head_id,
                    'atten_date' =>$day,
                    'stud_id' => $r,
                    'adm_no' =>$this->dbconnection->Get_namme("student", "id", "$r", "admission_no"),
                    'roll' =>  $this->dbconnection->Get_namme("student", "id", "$r", "roll"),
                    'attendance' => $inputall['attendance'][$r],
                );
                $school_name=$this->school_desc[0]->description;
            
                $this->dbconnection->insert("stud_mnthly_att_detail", $datadetail);
                }
                
                $this->user_details = $this->dbconnection->select("user", "*", "id={$this->session->userdata('user_id')}");

                foreach ($inputall['astud_id'] as $val => $r) {
                  $stud_name=$this->dbconnection->select("student","concat(first_name,' ',middle_name,' ',last_name) as name","status='Y' AND id=".$r);
                   $name=$stud_name[0]->name;
                   if($this->sms_setting[0]->activity=='ALL_ABSENT')
                   {
                    $msg="Dear Parents, Your ward $name is absent today. Kindly send a leave application/medical certificate as per the school policy. Regards $school_name";
                   }
                    else{
                        $msg="Dear Parents, Your ward $name is present today. Regards $school_name";
                    }
                    $phone=$this->dbconnection->Get_namme("student", "id", "$r", "phone");
                   if($this->sms_setting[0]->activity=='ALL_ABSENT')
                   {
                        if($inputall['attendance'][$r]=='A')
                           {
                             $s = $sms_gy($phone, $msg, $sender);
                             $data = array(
                            'from_user' => $this->user_details[0]->user_name,
                            'to_user' => $this->dbconnection->Get_namme("student", "id", "$r", "admission_no"),
                            'to_number' => $this->dbconnection->Get_namme("student", "id", "$r", "phone"),
                            'message_content' => $msg,
                            'type' => '',
                            'response' => $s['responseCode'],
                            'msg_id' => $s['msgid'],
                            'sent_ts' => date('Y-m-d H:i:s'),
                            'send_ip' => $this->input->ip_address(),
                            'created_by' => $this->session->userdata('user_id'),
                            );

                            $this->dbconnection->insert('messages', $this->security->xss_clean($data));
                           
                           }
                   }
                   else
                   {
                        if($inputall['attendance'][$r]=='P')
                           {
                             $s = $sms_gy($phone, $msg, $sender);
                             $data = array(
                            'from_user' => $this->user_details[0]->user_name,
                            'to_user' => $this->dbconnection->Get_namme("student", "id", "$r", "admission_no"),
                            'to_number' => $this->dbconnection->Get_namme("student", "id", "$r", "phone"),
                            'message_content' => $msg,
                            'type' => '',
                            'response' => $s['responseCode'],
                            'msg_id' => $s['msgid'],
                            'sent_ts' => date('Y-m-d H:i:s'),
                            'send_ip' => $this->input->ip_address(),
                            'created_by' => $this->session->userdata('user_id'),
                            );

                            $this->dbconnection->insert('messages', $this->security->xss_clean($data));
                           
                           }
                   }
                   
                }
                $dataupdate = array(
                    'sms' => 'YES', 
                );
                $this->dbconnection->update('stud_mnthly_att_head',$dataupdate,'id='.$head_id);

            
        echo 1;

    }

    public function validate_attendance() {
        $fetch_attendance = array();
        $class = $this->input->post('class');
        $section = $this->input->post('section');
        $date = $this->input->post('date');
        $fetch_attendance = $this->dbconnection->select("student_attendance", "count(id) as cnt", "date='$date' and student_id in (select id from student where class_id=$class and section_id=$section)");
        if ($fetch_attendance[0]->cnt > 0) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function update_stud_attendance() {
        
        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $aclass = $this->input->post('class');
        $asection = $this->input->post('section');
        $date = $this->input->post('attendance_date');
        $inputall = $this->input->post();
        foreach ($inputall['astud_id'] as $val => $r) {
            $data = array(
                'attendance' => $inputall['attendance'][$r],
            );
            $this->dbconnection->update("student_attendance", $data, array('id' => $r));
        }
        echo 1;
    }

    public function register_stu() {

        $this->data['page_name'] = 'student_attendance_register';
        $this->data['page_title'] = 'Student Attendence Monthly';
        $this->data['section'] = 'attendance';
        $this->data['customview'] = '';
        $this->data['class'] = $this->dbconnection->select("class", "id,class_name", "status='Y'");
        $this->data['classsection'] = $this->dbconnection->select("section", "id,sec_name", "status='Y'");
        $this->load->view('index', $this->data);
    }

    public function load_student_register() {

        $year=$this->input->post('year');
        $month=$this->input->post('month');
        $this->data['each_sunday'] = array();
        $aclass = $this->input->post('class');
        $asection = $this->input->post('section');
        $this->data['yr'] = $this->input->post('year');
        $this->data['month'] = $this->input->post('month');
        $this->data['total_days'] = $this->input->post('total_days');
        $this->data['total_off_days'] = $this->input->post('total_sun');
        $this->data['each_sunday'] = $this->input->post('weekend');
        $this->data['total_work'] = $this->input->post('total_work');
        $this->data['fetch_stud_attendance_report'] = $this->dbconnection->select("student", "id,admission_no,class_id,section_id,roll,concat(first_name,' ',middle_name,' ',last_name) as name", "class_id=$aclass and section_id=$asection and status='Y'");
        // print_r($datastu);
        // die();
        $this->load->view('attendance/upload_attendance_student_register', $this->data);
    }


    public function save_stud_attendance_monthly() {
        error_reporting(-1);
        ini_set('display_errors', 1);
        $this->db->db_debug=TRUE;
        $class = $this->input->post('cls');
        $section = $this->input->post('sec');
        $inputall = $this->input->post();
        $mon = $this->input->post('mon');
        $total_days = $this->input->post('total_days');
        $atten_date = $this->input->post('atten_date');
        $attendance = $this->input->post('attendance');
       
        $datahead =  array(
            'class_id' => $class, 
            'section_id' => $section, 
            'month' => $mon, 
        );

        //code for dual permission goes here
            if (count($this->dualpermission) > 0) {

                $datahead['status'] = 'P';
            }
        //code for dual permission end here

        $this->dbconnection->insert("stud_mnthly_att_head", $datahead);
      $head_id=$this->db->insert_id();
    
     $prod_matrix = $_POST['attendance'];
      //echo  "<pre>";
     // print_r($prod_matrix);
    
    foreach($prod_matrix as $prodid => $product)
    {
        $prodid;
      // echo "<br>";
        foreach ($product as $paramid => $value)
        {

            $datadetail = array(
                     // 'mnthly_att_head_id' =>1,
                    'mnthly_att_head_id' => $head_id,
                    'atten_date' =>$prodid,
                    'stud_id' => $paramid,
                    'adm_no' =>$this->dbconnection->Get_namme("student", "id", "$paramid", "admission_no"),
                    'roll' =>  $this->dbconnection->Get_namme("student", "id", "$paramid", "roll"),
                    'attendance' => $value
                );

         // print_r($datadetail);
            
                $this->dbconnection->insert("stud_mnthly_att_detail", $datadetail);
            //     echo 'st-id: '.$paramid;
            // echo "<br>";
            // echo 'attt: '.$value;
             //   $i++;
        }
       
    }
    
    }

    public function approve_attendance() {
        // if (!$this->input->is_ajax_request() || substr($this->dual_right_access != 'C')) {
        //     show_404();
        // }
        $id=$this->input->post('head_id');
        $data = array(
            'status' => 'Y',
        );
        $this->dbconnection->update("stud_mnthly_att_head", $data, array('id' => $id));
    }

    public function download_format() {
        $this->load->helper('download');
        $fh = fopen('php://memory', 'w');
        fputcsv($fh, array_column($this->admission_csv_columns, 'human_name'));
        fseek($fh, 0);
        $csv = stream_get_contents($fh);
        $school_code=$this->session->userdata('school_code');
        force_download('FCLB-'.$school_code.'-Attendance-Format.csv', $csv);
    }

    public function send_atten_sms() {
        $page_data['page_name'] = 'send_atten_sms_list';
        $page_data['page_title'] = 'Send SMS';
        $page_data['section'] = 'attendance';
        $page_data['customview'] = '';
        $page_data['smsdata'] = $this->dbconnection->select("messages", "*", "created_by={$this->session->userdata('user_id')}");
        $this->load->view('index', $page_data);
    }


     public function compose_sms() {
        // if (substr($this->right_access, 0, 1) != 'C') {
        //     redirect('404');
        // }
        $page_data['page_name'] = 'composesms_atten';
        $page_data['page_title'] = 'Compose SMS';
        $page_data['section'] = 'attendance';
        $page_data['customview'] = '';
        $this->load->view('index', $page_data);
    }


    public function import_atten_stu() {
//         if (substr($this->right_access, 1, 1) != 'R') {
// //            redirect(base_url(), 'refresh');
//             redirect('404');
//         }
        $this->data['page_name'] = 'import_attendance_student';
        $this->data['page_title'] = 'Import';
        $this->data['section'] = 'attendance';
        $this->data['customview'] = '';
        $this->data['class'] = $this->dbconnection->select("class", "id,class_name", "status='Y'");
        $this->data['classsection'] = $this->dbconnection->select("section", "id,sec_name", "status='Y'");
        $this->load->view('index', $this->data);
    }

    public function load_student_import() {

        $year=$this->input->post('year');
        $month=$this->input->post('month');
        $this->data['each_sunday'] = array();
        $aclass = $this->input->post('class');
        $asection = $this->input->post('section');
        $this->data['yr'] = $this->input->post('year');
        $this->data['month'] = $this->input->post('month');
        $this->data['total_days'] = $this->input->post('total_days');
        $this->data['total_off_days'] = $this->input->post('total_sun');
        $this->data['each_sunday'] = $this->input->post('weekend');
        $this->data['total_work'] = $this->input->post('total_work');
        $this->data['fetch_stud_attendance_report'] = $this->dbconnection->select("student", "id,admission_no,class_id,section_id,roll,concat(first_name,' ',middle_name,' ',last_name) as name", "class_id=$aclass and section_id=$asection and status='Y'");
        $this->load->view('attendance/import_attendance_student_register', $this->data);
    }

public function import_csv_attendnce() {
        //  error_reporting(-1);
        // ini_set('display_errors', 1);
        // $this->db->db_debug=TRUE;
        $class = $this->input->post('cls');
        $section = $this->input->post('sec');
        $mon = $this->input->post('mon');

        $query=$this->db->query("select * from stud_mnthly_att_head where class_id='$class' and section_id='$section' and month='$mon' and status='Y'")->result();
        // print_r($query);
        // die();
        if($query)
        {
            $this->session->set_flashdata('Success', 'Attendance Already Captured of this Month');
            redirect('attendance/Student_attendance/import_atten_stu');
        }
        else{


        $datahead =  array(
            'class_id' => $class, 
            'section_id' => $section, 
            'month' => $mon, 
        );

       
        $this->dbconnection->insert("stud_mnthly_att_head", $datahead);
        $head_id=$this->db->insert_id();
            $handle = fopen($_FILES['attendance_upload']['tmp_name'], "r");
            fgetcsv($handle); // Read and discard header row

            while (($row = fgetcsv($handle, 10000, ",")) !== FALSE) {
                $rowarr = array();
                   // echo '<pre>';
                   // print_r($row);die();
                    $s=$row[0];
                    $stid=$row[1];
                    $ad_no=$row[2];
                    $name=$row[3];
                    $rool=$row[4];
                   
                    
                    $totalcount=count($row);
                    $dat=$totalcount -5;
                     $i=1;
                     for($d=5;$d<$totalcount;$d++)
                     {

                     $persent=$row[$d];
                     $datadetail = array(
                    // 'mnthly_att_head_id' =>1,
                    'mnthly_att_head_id' => $head_id,
                    'atten_date' =>$i,
                    'stud_id' => $stid,
                    'adm_no' =>$this->dbconnection->Get_namme("student", "id", "$stid", "admission_no"),
                    'roll' =>  $this->dbconnection->Get_namme("student", "id", "$stid", "roll"),
                    'attendance' => $persent
                      );
                    $this->dbconnection->insert("stud_mnthly_att_detail", $datadetail);
                    //print_r($datadetail);
                    
                    
                      $i++;
                     }
                
                 // echo '</pre>';


}

$this->session->set_flashdata('Success', 'Attendance Import Successfully');
redirect('attendance/Student_attendance/import_atten_stu');
}
}

//--------------------------Manual SMS Send-------------------------//

 public function send_atten_sms_manual() {
           error_reporting(-1);
        ini_set('display_errors', 1);
        $this->db->db_debug=TRUE;
        $this->load->helper('sms_helper');

        $aclass = $this->input->post('sms_class');
        $asection = $this->input->post('sms_section');
        $message = $this->input->post('message');
        $send_to = $this->input->post('send_to');
        $date = $this->input->post('date_sms');
        $d = date_parse_from_format("Y-m-d", $date);
        $inputall = $this->input->post();
        $mon=$d["month"];
        $day=$d["day"];

        switch ($this->session->userdata('school_id')) {
            case 26 : $sender = 'MOUNTC';
            $sms_gy = 'send_smstomountc';
            break;
        case 5 : $sender = 'VVSJSR';
            $sms_gy = 'send_bulksmsind_vv';
            break;
        default : $sender = 'MILDRX';
            $sms_gy = 'send_bulksmsind';
            break;
        }    

        $fetch_attendance=$this->db->query("select sh.id,sh.class_id,sh.section_id,sh.month,sd.atten_date,sd.attendance,sd.stud_id from stud_mnthly_att_head sh,stud_mnthly_att_detail sd where sh.id=sd.mnthly_att_head_id and sh.status='Y' and sh.class_id='$aclass' and sh.section_id='$asection' and sh.month='$mon' and sd.atten_date='$day'")->result();      
        $shid=$fetch_attendance[0]->id;
        if(!empty($fetch_attendance))
        {
           
            $this->user_details = $this->dbconnection->select("user", "*", "id={$this->session->userdata('user_id')}");

                foreach ($fetch_attendance as $val) {
                  $stud_name=$this->dbconnection->select("student","concat(first_name,' ',middle_name,' ',last_name) as name","status='Y' AND id=".$val->stud_id);
                   $name=$stud_name[0]->name;
                   if($send_to=='ALL_ABSENT')
                   {
                    $msg="Dear Parents, Your ward $name is absent today. Kindly send a leave application/medical certificate as per the school policy. Regards $school_name";
                   }
                   else if($send_to=='ALL_PRESENT')
                   {
                        $msg="Dear Parents, Your ward $name is present today. Regards $school_name";
                   }
                    else{
                        $msg="Dear Parents,$message. Regards $school_name";
                    }
                    $phone=$this->dbconnection->Get_namme("student", "id", "$val->stud_id", "phone");
                   if($send_to=='ALL_ABSENT')
                   {
                        if($inputall['attendance'][$val->stud_id]=='A')
                           {
                             $s = $sms_gy($phone, $msg, $sender);
                             $data = array(
                            'from_user' => $this->user_details[0]->user_name,
                            'to_user' => $this->dbconnection->Get_namme("student", "id", "$val->stud_id", "admission_no"),
                            'to_number' => $this->dbconnection->Get_namme("student", "id", "$val->stud_id", "phone"),
                            'message_content' => $msg,
                            'type' => '',
                            'response' => $s['responseCode'],
                            'msg_id' => $s['msgid'],
                            'sent_ts' => date('Y-m-d H:i:s'),
                            'send_ip' => $this->input->ip_address(),
                            'created_by' => $this->session->userdata('user_id'),
                            );

                            $this->dbconnection->insert('messages', $this->security->xss_clean($data));
                           
                           }
                   }
                   else if($send_to=='ALL_PRESENT')
                   {
                        if($inputall['attendance'][$val->stud_id]=='P')
                           {
                             $s = $sms_gy($phone, $msg, $sender);
                             $data = array(
                            'from_user' => $this->user_details[0]->user_name,
                            'to_user' => $this->dbconnection->Get_namme("student", "id", "$val->stud_id", "admission_no"),
                            'to_number' => $this->dbconnection->Get_namme("student", "id", "$val->stud_id", "phone"),
                            'message_content' => $msg,
                            'type' => '',
                            'response' => $s['responseCode'],
                            'msg_id' => $s['msgid'],
                            'sent_ts' => date('Y-m-d H:i:s'),
                            'send_ip' => $this->input->ip_address(),
                            'created_by' => $this->session->userdata('user_id'),
                            );

                            $this->dbconnection->insert('messages', $this->security->xss_clean($data));
                           
                           }
                   }

                   else
                   {
                             $s = $sms_gy($phone, $msg, $sender);
                             $data = array(
                            'from_user' => $this->user_details[0]->user_name,
                            'to_user' => $this->dbconnection->Get_namme("student", "id", "$val->stud_id", "admission_no"),
                            'to_number' => $this->dbconnection->Get_namme("student", "id", "$val->stud_id", "phone"),
                            'message_content' => $msg,
                            'type' => '',
                            'response' => $s['responseCode'],
                            'msg_id' => $s['msgid'],
                            'sent_ts' => date('Y-m-d H:i:s'),
                            'send_ip' => $this->input->ip_address(),
                            'created_by' => $this->session->userdata('user_id'),
                            );

                            $this->dbconnection->insert('messages', $this->security->xss_clean($data));
                   }
                   
                }
                $updatedata = array(
                    'sms' => 'YES',
                     );
                $this->dbconnection->update('stud_mnthly_att_head',$updatedata,'id='.$shid);
            
         } 
        else{
            echo 1;
           
       }
                
    }

//--------------------------Manual SMS End--------------------------//

}
