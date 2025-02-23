<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Staff_attendance extends CI_Controller {
    
    public $page_code = 'attendance_staff';
    public $page_id = '';
    public $page_perm = '----';

    public function __construct() {
        parent::__construct();

        $this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");


        $this->id = $this->session->userdata('school_id');
        $this->school_desc = $this->dbconnection->select("school", "*", "id=" . $this->id . " and status = 1");
        $this->schools = $this->dbconnection->select("school", "*", 'status = 1');


        if ($this->id != 0)
            $this->db->db_select('crmfeesclub_' . $this->id);
        
        $permission = $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
        $this->page_perm = !empty($permission) ? $permission[0]->permission : '----';
        $this->right_access = $this->page_perm;

        if (strpos($this->page_perm, '----') == true) {
            redirect(base_url(''), 'refresh');
        }
        
        $this->page_title = 'Staff Attendance';
        $this->section = 'attendance';
        $this->page_name = 'staff_attendance';
        $this->customview = '';
    }

    public function index() {
        
        if (substr($this->right_access, 1, 1) != 'R') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->data['page_name'] = $this->page_name;
        $this->data['page_title'] = $this->page_title;
        $this->data['section'] = $this->section;
        $this->data['customview'] = $this->customview;
        $this->load->view('index', $this->data);
    }

    public function load_staff() {

        $task = $this->input->post('task');
        $adate = $this->input->post('date');
        $this->data['task'] = $task;
        if ($task == 'add') 
        {
            $this->data['fetch_staff'] = $this->dbconnection->select("employee", "id,employee_code as empl_code,name as emp_name", "status=1");
        } 
        else 
        {
            $this->data['fetch_staff'] = $this->dbconnection->select("staff_attendance", "id,emp_no,emp_name,(select employee_code from employee where id=emp_no) as empl_code,attendance", "date='$adate'");

        }

        $this->load->view("attendance/upload_staff", $this->data);
    }

    public function save_staff_attendance() {
        
        /*if (substr($this->right_access, 0, 1) == 'C') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }*/
        $date1 = $this->input->post('attendance_date_staff');

        $inputall = $this->input->post();
        
        foreach ($inputall['astaff_id'] as $val1 => $s) {
            $data = array(
                'emp_no' => $s,
                'emp_name' => $this->dbconnection->Get_namme("employee", "id", "$s", "name"),
                'attendance' => $inputall['attendance'][$s],
                'date' => $date1,
                'remarks' => $inputall['rem'][$val1],
            );
            //print_r($data);
            $this->dbconnection->insert("staff_attendance", $data);
        }
        //echo 1;
    }

    public function validate_staff_attendance() {
        $fetch_staff_attendance = array();
        $adate = $this->input->post('date');
//		            echo $date;
        $fetch_staff_attendance = $this->dbconnection->select("staff_attendance", "count(id) as cnt", "date='$adate'");
        echo count($fetch_staff_attendance);
        if ($fetch_staff_attendance[0]->cnt > 0) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function update_staff_attendance() {
        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $date = $this->input->post('attendance_date_staff');
        $inputall = $this->input->post();
        foreach ($inputall['astaff_id'] as $val1 => $s) {
            $data = array(
                'attendance' => $inputall[attendance][$s],
            );
            $this->dbconnection->update("staff_attendance", $data, array('id' => $s));
        }
        echo 1;
    }

}
