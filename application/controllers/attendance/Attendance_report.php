<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance_report extends CI_Controller {

    public $page_code = 'attendance_report';
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
        
        $this->page_title = 'Attendance Report';
        $this->section = 'attendance';
        $this->page_name = 'attendance_report';
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
        $this->data['class'] = $this->dbconnection->select("class", "id,class_name", "status='Y'");
        $this->data['classsection'] = $this->dbconnection->select("section", "id,sec_name", "status='Y'");
        $this->data['session'] = $this->dbconnection->select("accedemic_session", "id,session", "status='Y'");
        $this->load->view('index', $this->data);
    }

    public function load_student_report() {
        $this->data['each_sunday'] = array();
        $aclass = $this->input->post('class');
        $asection = $this->input->post('section');
        $this->data['yr'] = $this->input->post('year');
        $this->data['month'] = $this->input->post('month');
        $this->data['total_days'] = $this->input->post('total_days');
        $this->data['total_off_days'] = $this->input->post('total_sun');
        $this->data['each_sunday'] = $this->input->post('weekend');
        $this->data['total_work'] = $this->input->post('total_work');
        $this->data['fetch_stud_attendance_report'] = $this->dbconnection->select("student", "id,admission_no,concat(first_name,' ',middle_name,' ',last_name) as name", "class_id=$aclass and section_id=$asection and status='Y'");
//		$this->load->view('index', $this->data);
        $this->load->view('attendance/upload_attendance_student', $this->data);
    }

    public function load_staff_report() {
        $this->data['each_sunday'] = array();
        $this->data['yr'] = $this->input->post('year');
        $this->data['month'] = $this->input->post('month');
        $this->data['total_days'] = $this->input->post('total_days');
        $this->data['total_off_days'] = $this->input->post('total_sun');
        $this->data['each_sunday'] = $this->input->post('weekend');
        $this->data['total_work'] = $this->input->post('total_work');
        $this->data['fetch_staff_attendance_report'] = $this->dbconnection->select("employee", "id,employee_code,name", "status=1");
//		$this->load->view('index', $this->data);
        $this->load->view('attendance/upload_attendance_staff', $this->data);
    }

}
