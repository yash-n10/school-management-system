<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
    
    public $page_code = 'settings_users';
    public $page_id = '';
    public $page_perm = '----';
    
    public function __construct() {
        parent::__construct();


        $this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");


        $this->id = $this->session->userdata('school_id');
        $this->user_group_id = $this->session->userdata('user_group_id');

        $this->school = $this->dbconnection->select('school', '*', 'status=1');
        if ($this->id != 0)
            $this->db->db_select('crmfeesclub_' . $this->id);
        if ($this->user_group_id == 3) {//for school
            $this->user_groups = $this->dbconnection->select('user_group', 'id,group_type', "id not in(1,2)");
        } else if ($this->user_group_id == 2) {// for supervisor
            $this->user_groups = $this->dbconnection->select('user_group', 'id,group_type', "id not in(1)");
        } else { // for administrator
            $this->user_groups = $this->dbconnection->select('user_group', '*');
        }
        
        $permission = $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
        $this->page_perm = !empty($permission) ? $permission[0]->permission : '----';
        $this->right_access = $this->page_perm;

        if (strpos($this->page_perm, '----') == true) {
            redirect(base_url(''), 'refresh');
        }
        

        $this->page_name  = 'users';
        $this->page_title = 'Users';
        $this->section    = 'settings';
        $this->customview = '';
    }

    
    public function index($param = '', $param2 = '') {
        
        if (substr($this->right_access, 1, 1) != 'R') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        
        $this->data['page']       = 'user';
        $this->data['page_name']  = $this->page_name;
        $this->data['page_title'] = $this->page_title;
        $this->data['section']    = $this->section;
        $this->data['customview'] = $this->customview;
        
        if ($param == 'fetch') {
            $this->db->db_select('crmfeesclub_' . $param2);
        }

        $user_group = $this->session->userdata('user_group_id');
        $user_id    = $this->session->userdata('user_id');

        if ($user_group == 3) {//for school
            
            $this->data['user_groups'] = $this->user_groups;
            $school_id                 = $this->session->userdata('school_id');
            $this->data['users']       = $this->dbconnection->select('user', 'id,user_name,user_group_id,student_id,employee_id,contact_no,email,status', "user_group_id=4 or id=$user_id");
                    
        } else if ($user_group == 2) {// for supervisor
            
            $this->data['user_groups'] = $this->user_groups;
            $school_id                 = $this->session->userdata('school_id');
            $this->data['users']       = $this->dbconnection->select('user', 'id,user_name,user_group_id,student_id,employee_id,contact_no,email,status', "user_group_id not in(1,2) or id=$user_id");
                   
        } else { // for administrator
            
            $this->data['user_groups'] = $this->user_groups;
            $this->data['users']       = $this->dbconnection->select('user', 'id,user_name,user_group_id,student_id,employee_id,contact_no,email,status', '');
        }
        $this->data['user_grp_id']   = $user_group;
        $this->data['schools']       = $this->school;
        $this->data['students']      = $this->dbconnection->select('student', 'id,email_address');

        $this->data['task']          = 'add';
        $this->data['school_select'] = $param2;
        $this->data['right_access']  = $this->right_access;

        $this->load->view('index', $this->data);
    }

    public function get_userinfo_dropdown() {
        
        $user_group = $this->input->post('user_group');
        
        if ($this->input->post('school_id') != '') {
            $this->db->db_select('crmfeesclub_' . $this->input->post('school_id'));
        }
        
        if ($user_group == 4) {

            $qry = $this->dbconnection->select_order('student', 'id,admission_no,CONCAT(first_name," ",middle_name," ",last_name) as name', 'status = "Y"', 'name', 'ASC');
            $return = '';
            $return .= '<label for="userinfo" class="col-sm-3 control-label" id="userinfo_lbl">Student Info:</label>';
            $return .= '<div class="col-sm-9" id="div_userinfo_select">';
            $return .= '<select class="form-control" id="userinfo" name="userinfo">';
            $return .= "<option value='0'>- Select Student -</option>";
            foreach ($qry as $row) {

                $return .= "<option value='" . $row->id . "'>" .$row->admission_no . " " . $row->name . "</option>";
            }
            $return .= '</select>';
            $return .= '</div>';
            echo $return;
        } else {

            $qry = $this->dbconnection->select_order('employee', 'id,employee_code,name', 'status=1 ', 'name', 'ASC');
            $return = '';
            $return .= '<label for="userinfo" class="col-sm-3 control-label" id="userinfo_lbl">Employee Info:</label>';
            $return .= '<div class="col-sm-9" id="div_userinfo_select">';
            $return .= '<select class="form-control" id="userinfo" name="userinfo">';
            $return .= "<option value='0'>- Select Employee -</option>";
            foreach ($qry as $row) {

                $return .= "<option value='" . $row->id . "'>" . $row->employee_code . "  " . $row->name . "</option>";
            }
            $return .= '</select>';
            $return .= '</div>';
            echo $return;
        }
    }

    
    public function add_user() {
        
        if (substr($this->right_access, 0, 1) != 'C') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }

        $hashoptions  = array(); // No options currently, but, we could add in future
        $pwhash       = password_hash($this->input->post('Password'), PASSWORD_DEFAULT, $hashoptions); // Generate new hash
        $salt         = $this->generateRandomString();
        $password     = md5($this->input->post('Password') . $salt);
        $user_name    = $this->input->post('user_name');
        $contact_no   = $this->input->post('contact_no');
        $email        = $this->input->post('email');
        $usergroup    = $this->input->post('user_group');
        $school_code  = $this->input->post('school_code');
        
        $student_id   = 0;
        $employee_id   = 0;

            
        if($usergroup==4) {
            $student_id  = $this->input->post('userinfo');
        } else{
            $employee_id = $this->input->post('userinfo');
        }

        if($usergroup!=1 && $this->session->userdata('user_group_id') == 1) {
            
            $this->db->db_select('crmfeesclub_' . $this->input->post('school'));
            $created_by = '0';//admin created 
            
        } else {
            
            $created_by  = $this->session->userdata('user_id');
            
        }
            
     

        $data = array(
            'user_name'           => $school_code . $user_name,
            'password'            => $password,
            'salt'                => $salt,
            'pw_hash'             => $pwhash,
            'student_id'          => $student_id,
            'employee_id'         => $employee_id,
            'contact_no'          => $contact_no,
            'email'               => $email,
            'user_group_id'       => $usergroup,
            'status'              => 1,
            'created_by'          => $created_by,

        );
        $user = $this->dbconnection->insert('user', $data);

        if($user){
                $audit = array("action" => 'Add User',
                    "module"     => "User Module",
                    'datetime'   => date("Y-m-d H:i:s"),
                    'userid'     => $this->session->userdata('user_id'),
                    'student_id' => 0,
                    'page'       => 'User',
                    'remarks'    => ''
                );
                $this->dbconnection->insert("auditntrail", $audit);
//                $this->session->set_flashdata('user_message', get_phrase('user_created'));
//                header("Location: " . base_url("settings/users"));
                echo "<script>alert('Successfully User Created')  ; window.location.href='".base_url('settings/users')."';</script>";
                
        } else {
//            $this->session->set_flashdata('user_message', get_phrase('error_occured'));
                echo "<script>alert(' User Not  Created')  ; window.location.href='".base_url('settings/users')."';</script>";
        }
        
    }

    
    public function edit_user() {
        
        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        
        $username    = $this->input->post('user_name');
        $contact_no  = $this->input->post('contact_no');
        $email       = $this->input->post('email');
        $usergroup   = $this->input->post('user_group');
        $school_code = $this->input->post('school_code');
//        echo $username.' '.$school_code.' '.$this->input->post('school');
        $user_id     = $this->encrypt->decode($this->input->post('edit_user_id'));
        $student_id  = 0;
        $employee_id = 0;

            
        if($usergroup==4) {
            $student_id  = $this->input->post('userinfo');
        } else{
            $employee_id = $this->input->post('userinfo');
        }

        if($usergroup!=1 && $this->session->userdata('user_group_id') == 1) {
            
            $this->db->db_select('crmfeesclub_' . $this->input->post('school'));
            $modified_by = '0';//admin created 
            
        } else {
            
            $modified_by = $this->session->userdata('user_id');
            
        }

        $data = array(
            'user_name'          => $school_code.$username,
            'student_id'         => $student_id,
            'employee_id'        => $employee_id,
            'contact_no'         => $contact_no,
            'email'              => $email,
            'user_group_id'      => $usergroup,
            'last_modified_by'        => $modified_by,
            'last_date_modified' => date('Y-m-d H:i:s'),

        );
        $user = $this->dbconnection->update('user', $data, 'id =' . $user_id);

//Audit Trail
        if($user){
                $audit = array("action" => 'Update User',
                "module"     => "User Module",
                'datetime'   => date("Y-m-d H:i:s"),
                'userid'     => $this->session->userdata('user_id'),
                'page'       => 'User',
                'remarks'    => ''
            );
            $this->dbconnection->insert("auditntrail", $audit);
//                $this->session->set_flashdata('user_message', get_phrase('user_created'));
//                header("Location: " . base_url("settings/users"));
            echo "<script>alert('Successfully User Updated')  ; window.location.href='".base_url('settings/users')."';</script>";
        }else {
//            $this->session->set_flashdata('user_message', get_phrase('error_occured'));
                echo "<script>alert(' User Not  Updated')  ; window.location.href='".base_url('settings/users')."';</script>";
        }

    }

    public function delete_user() {
        if (substr($this->right_access, 3, 1) != 'D') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        
        $user_id   = $this->encrypt->decode($this->input->post('delete_user_id'));
        $usergroup = $this->input->post('delete_user_group');
        
        
        if($usergroup!=1 && $this->session->userdata('user_group_id') == 1) {
            
            $this->db->db_select('crmfeesclub_' . $this->input->post('school'));
            $modified_by = '0';//admin created 
            
        } else {
            
            $modified_by = $this->session->userdata('user_id');
            
        }
//Audit Trail
        $outage    = $this->dbconnection->update('user',"status=0 and last_date_modified='".date("Y-m-d H:i:s")."' and last_modified_by=$modified_by",'id =' . $user_id);
        if($outage){
            $audit = array("action" => 'Delete User',
                "module"   => "User Module",
                'datetime' => date("Y-m-d H:i:s"),
                'userid'   => $this->session->userdata('user_id'),
                'page'     => 'User',
                'remarks'  => ''
            );
            $this->dbconnection->insert("auditntrail", $audit);
            echo "<script>alert('Successfully User Deleted')  ; window.location.href='".base_url('settings/users')."';</script>";
        }else {
                echo "<script>alert(' User Not  Deleted')  ; window.location.href='".base_url('settings/users')."';</script>";
        }

    }

    public function change_password() {
        
        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $user_id       = $this->encrypt->decode($this->input->post('change_user_id'));
        $user_group_id = $this->input->post('change_user_group');
        $hashoptions   = array(); // No options currently, but, we could add in future
        $pwhash        = password_hash($this->input->post('change_re_password'), PASSWORD_DEFAULT, $hashoptions); // Generate new hash
        $salt          = $this->generateRandomString();
        $password      = md5($this->input->post('change_re_password') . $salt);
        
        if($user_group_id!=1 && $this->session->userdata('user_group_id') == 1) {
            
            $this->db->db_select('crmfeesclub_' . $this->input->post('school'));
            $modified_by = '0';//admin created 
            
        } else {
            
            $modified_by = $this->session->userdata('user_id');
            
        }
        
        $data = array(
            'pw_hash'            => $pwhash,
            'password'           => $password,
            'salt'               => $salt,
            'change_password'    => 1,
            'last_date_modified' => date('Y-m-d H:i:s'),
            'last_modified_by'   => $modified_by
        );
        $user = $this->dbconnection->update('user', $data, 'id ="' . $user_id . '"');


//Audit Trail
        if($user){
            $audit = array("action" => 'Change User Password',
                "module" => "User Module",
                'datetime' => date("Y-m-d H:i:s"),
                'userid' => $modified_by,
                'page' => 'Student',
                'remarks' => 'Change Password'
            );
            $this->dbconnection->insert("auditntrail", $audit);     
            echo "<script>alert('Changed Password Successfully')  ; window.location.href='".base_url('settings/users')."';</script>";
        } else {
            echo "<script>alert('Password is not Saved')  ; window.location.href='".base_url('settings/users')."';</script>";
        }

    }

    
    public function check_user() {

        $user_name = $this->input->post('user');
        $school_code = rtrim($this->input->post('school_code'),'-');
        if ($this->id == 0 && $school_code!='@') {
            $school_id = $this->dbconnection->select('school', 'id', "school_code='$school_code'");
            $this->db->db_select('crmfeesclub_' . $school_id[0]->id);
        }
        if ($usercnt = $this->dbconnection->select('user', 'count(*) as cnt', "user_name='$school_code-$user_name'")) {
            echo $usercnt[0]->cnt;
        } else {
            echo 0;
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

}
