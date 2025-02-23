<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {
        parent::__construct();
        $this->load->library('encryption');
    }

    public function index() {
        $this->data['page'] = 'register';
        $this->data['schools'] = $this->dbconnection->select('school', '*');
        $this->data['states'] = $this->dbconnection->select('states', '*', "country_id=1");
        $this->data['page_title'] = 'FeesClub ERP Registration';
        $this->load->view('login/register', $this->data);
    }

    public function step2($id = 0, $status = '') {
        error_reporting(-1);
        ini_set('display_errors', 1);
        $this->db->db_debug=TRUE;
        $this->data['page'] = 'register-step2';
        $this->data['school_id'] = $id;
        $this->data['status'] = $this->encryption->decrypt($status);
        $this->data['page_title'] = 'FeesClub ERP Registration';
        $this->load->view('login/register', $this->data);
    }

    public function select_city() {
        $cities = $this->dbconnection->select('cities', '*', "city_state = '" . $_POST['state'] . "'");
        $return = '';
        $return .= '<select class="form-control" id="school_city" name="school_city" onchange="select_school()" required>';
        $return .= "<option value=''>- Select City -</option>";
        foreach ($cities as $city) {
            $return .= "<option value='" . $city->id . "'>" . $city->city_name . "</option>";
        }
        $return .= '</select>';

        echo $return;
    }

    public function select_school() {

        $schools = $this->dbconnection->select('school', '*', "city_id = '" . $_POST['city'] . "'");
        $school_prospects = $this->dbconnection->select('school_prospects', '*', "city_id = '" . $_POST['city'] . "' AND school_id IS NULL");
        $return = '';
        $return .= '<select class="form-control" id="school_name" name="school_name" required>';
        $return .= "<option value=''>- Select School -</option>";
        foreach ($schools as $school) {
            $return .= "<option value='" . $school->id . "'>" . $school->description . "</option>";
        }
        foreach ($school_prospects as $school) {
            $return .= "<option value='prospect'>" . $school->description . "</option>";
        }

        $return .= '</select>';
        echo $return;
    }

    public function check_admission() {
//		$admission = $this->dbconnection->select('admission','*',"admission_no = '".$_POST['admission_no']."' AND status = 0 AND school_id = '".$_POST['school']."'");	
//		echo count($admission);
        $this->db->db_select('crmfeesclub_' . $_POST['school']);
        $query = $this->dbconnection->select("student", "count(admission_no) as admission", "registered_status=1 and  admission_no='" . $_POST['admission_no'] . "'");
//                 $row=$query[0]->admission;
        $count_regs = $query[0]->admission;
////                 $count_regs=$row->admission;
        if ($count_regs > 0) {
            $status = 1; /* --for registered- student--- */
        } else {
            $query = $this->dbconnection->select("student", "count(admission_no) as admission", "admission_no='" . $_POST['admission_no'] . "' and status='Y'");
//                    $row=$query[0]->admission;
            $count_regs1 = $query[0]->admission;
//                    $count_regs1=$row->admission;
            if ($count_regs1 > 0) {
                $status = 2; /* --for admited but not registered--- */
            } else {
                $status = 0; /* --for not admited --- */
            }
        }
        echo $status;
    }

    public function check_fname() {

        $this->db->db_select('crmfeesclub_' . $_POST['school']);
        $query = $this->db->query("select count(first_name) as name from student where first_name='" . $_POST['first_name'] . "' and registered_status=1  and school_id=" . $_POST['school'] . " and admission_no='" . $_POST['admission_no'] . "'");
        $row = $query->row();
        $count_regs = $row->name;
        if ($count_regs > 0) {
            $status = 1; /* --for registered- student--- */
        } else {
            $query = $this->db->query("select count(first_name) as name from student where first_name='" . $_POST['first_name'] . "' and status='Y' and school_id=" . $_POST['school'] . " and admission_no='" . $_POST['admission_no'] . "'");
            $row = $query->row();
            $count_regs1 = $row->name;

            if ($count_regs1 > 0) {
                $status = 2; /* --for admited but not registered--- */
            } else {
                $status = 0; /* --for not admited --- */
            }
        }
        echo $status;



//		$fname = $this->dbconnection->select_join('admission','*',"admission_no = '".$_POST['admission_no']."' AND admission.status = 1 AND admission.school_id = '".$_POST['school']."' AND student.first_name = '".$_POST['first_name']."'",'student','admission.student_id = student.id','INNER');	
//		echo count($fname);
    }

    public function check_lname() {
//		$lname = $this->dbconnection->select_join('admission','*',"admission_no = '".$_POST['admission_no']."' AND admission.status = 0 AND admission.school_id = '".$_POST['school']."' AND student.last_name = '".$_POST['last_name']."'",'student','admission.student_id = student.id','INNER');	
//		echo count($lname);

        $this->db->db_select('crmfeesclub_' . $_POST['school']);
        $query = $this->db->query("select count(last_name) as lname from student where last_name='" . $_POST['last_name'] . "' and registered_status=1  and school_id=" . $_POST['school'] . " and admission_no='" . $_POST['admission_no'] . "'");
        $row = $query->row();
        $count_regs = $row->lname;
        if ($count_regs > 0) {
            $status = 1; /* --for registered- student--- */
        } else {
            $query = $this->db->query("select count(last_name) as lname from student where last_name='" . $_POST['last_name'] . "' and status='Y' and school_id=" . $_POST['school'] . " and admission_no='" . $_POST['admission_no'] . "'");
            $row = $query->row();
            $count_regs1 = $row->lname;
            if ($count_regs1 > 0) {
                $status = 2; /* --for admited but not registered--- */
            } else {
                $status = 0; /* --for not admited --- */
            }
        }
        echo $status;
    }

    public function register_student() {
        if ($this->input->post('school_name') == 'prospect') {
            $this->data['status'] = "Sorry, your school has not yet upgraded to FeesClub.";
            $this->load->view('login/register', $this->data);
        }
        $school_id = $this->input->post('school_name');
        $school = $this->dbconnection->select('school', 'school_code', 'id=' . $school_id);
        $admission_no = isset($_POST['admission_no']) ? $_POST['admission_no'] : '0';
//                echo $school_id.'<br/>';
        if ($school_id != 0) {
//                        $default['hostname'] = 'localhost';
//                        $config['username'] = 'root';
//                        $config['password'] = 'antigravity';
//                        $config['database'] = 'crmfeesclub_'.$school_id;
//                        $config['dbdriver'] = 'mysqli';
//                        $config['dbprefix'] = '';
//                        $config['pconnect'] = FALSE;
//                        $config['db_debug'] = TRUE;
//                        $config['cache_on'] = FALSE;
//                        $config['cachedir'] = '';
//                        $config['char_set'] = 'utf8';
//                        $config['dbcollat'] = 'utf8_general_ci';
//                        $this->db=$this->load->database($config,TRUE);
            $this->db->db_select('crmfeesclub_' . $school_id);
            /* --------------------------------------------------------- */
        }

//                echo '$admission_no='.$admission_no.'<br/>';
        if ($admission_no != '0') {
            $admission = $this->dbconnection->select('student', '*', "admission_no='$admission_no' AND registered_status=0");
        }
//                echo count($admission);
        if (count($admission) > 0) {
            /* CREATE USER */
//			$password_default = 'feesclub123';
            $password_default = $this->input->post('confirm_password');
            $salt = $this->generateRandomString();
//			$encryption = $this->dbconnection->select('encrypt','*');
//			$value = rand(0,count($encryption)-1);
//			$encryption_id = $encryption[$value]->id;
            $encryption_id = 2;
            $hashoptions = array(); // No options currently, but, we could add in future
            $pwhash = password_hash($password_default, PASSWORD_DEFAULT, $hashoptions);
//		

            $password = md5($password_default . $salt);
//			$username = strtolower(str_replace(' ', '', $_POST['first_name']).'.'.str_replace(' ', '', $_POST['last_name']));
            $data = array(
//				'user_name' => $username,
                'user_name' => $school[0]->school_code . '-' . $this->input->post('admission_no'),
                'password' => $password,
                'salt' => $salt,
                'pw_hash' => $pwhash,
                'encrypt_id' => $encryption_id,
                'user_group_id' => 4,
                'status' => 1,
                'student_id' => $admission[0]->id,
                'created_by' => 0,
                'change_password' => 1,
                'last_date_modified' => date('Y-m-d H:i:s'),
                'last_modified_by' => 0
            );
            $user = $this->dbconnection->insert('user', $data);
            $user_id = $this->db->insert_id();
            $data = array(
                'registered_status' => 1
            );
            $update_admission = $this->dbconnection->update('student', $data, 'id =' . $admission[0]->id);

            $this->data['page'] = 'login-student';
            $this->data['page_title'] = 'Login Proceed';
            $this->data['username'] = $school[0]->school_code . '-' . $this->input->post('admission_no');
            $this->data['password'] = $password_default;
            $this->load->view('login/login_student', $this->data);
//			header("Location: ".site_url("login/student/".$school[0]->school_code.'-'.$this->input->post('admission_no')."/".$password_default));
        } else {
            $status = $this->encryption->encrypt('failed');
            header("Location: " . site_url("register/step2/" . $school_id . "/" . $status));
        }
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

    public function check_user() {
//            echo 'hello';
        $user_name = $this->input->post('user');
//            echo $user_name;
        if ($usercnt = $this->dbconnection->select('user', 'count(*) as cnt', "user_name='$user_name'")) {
            echo $usercnt[0]->cnt;
        } else {
            echo 0;
        }

//            
    }

}
