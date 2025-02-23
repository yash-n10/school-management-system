<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Subject_teachers_ruchi extends MY_ListController {

    
    public function __construct() {

        $this->page_code = 'teacher_subjects_alloc';
        
        parent::__construct();

        // $this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");
        $this->id = $this->session->userdata('school_id');
        // $this->school_desc = $this->dbconnection->select("school", "*", "id=" . $this->id . " and status = 1");
        // $this->schools = $this->dbconnection->select("school", "*", 'status = 1');

        $this->academic_session=array();
        if ($this->id != 0) {
            $this->db->db_select('crmfeesclub_' . $this->id);
        
                          
                    $this->academic_session=$this->dbconnection->select("accedemic_session","max(id) as fin_year","active='Y'");
                }


        $this->page_title = 'Subject Teachers';
        $this->section = 'academic';
        $this->page_name = 'subject_teachers';
        $this->customview = '';
    }

    public function index() {

        $this->data['page_name'] = $this->page_name;
        $this->data['page_title'] = $this->page_title;
        $this->data['section'] = $this->section;
        $this->data['customview'] = $this->customview;

        $this->data['selectdata'] = $this->db->query("select t1.id, t1.class_id, (SELECT class_name FROM class WHERE id=t1.class_id) AS class_id_disp,t1.section_id, (SELECT sec_name FROM section WHERE id=t1.section_id) AS section_id_disp, t1.subject_id, (SELECT name FROM subject WHERE id=t1.subject_id) AS subject_id_disp, t1.teacher_id, (SELECT name FROM employee WHERE id=t1.teacher_id) AS teacher_id_disp from class_subject_teacher_test t1 where t1.status=1 AND t1.academic_year_id=2")->result();

        $this->data['asession'] = $this->dbconnection->select('accedemic_session', '*', 'status="Y" and active="Y"');

        $this->load->view('index', $this->data);
    }
    public function add_form()
    {
        $this->data['page_name'] = 'add_subject_teachers';
        $this->data['page_title'] = 'Assign Subject Teacher';
        $this->data['section'] = $this->section;
        $this->data['customview'] = $this->customview;

        $this->data['classes'] = $this->dbconnection->select('class', '*', 'status="Y"');
        $this->data['sect'] = $this->dbconnection->select('section', '*', 'status="Y"');
        $this->data['subjects'] = $this->dbconnection->select('subject', '*', 'status=1');
        $this->data['teacher'] = $this->dbconnection->select('employee', '*', 'status=1 and category_id=1');

        $this->data['selectdata'] = $this->db->query("select t1.id, t1.class_id, (SELECT class_name FROM class WHERE id=t1.class_id) AS class_id_disp,t1.section_id, (SELECT sec_name FROM section WHERE id=t1.section_id) AS section_id_disp, t1.subject_id, (SELECT name FROM subject WHERE id=t1.subject_id) AS subject_id_disp, t1.teacher_id, (SELECT name FROM employee WHERE id=t1.teacher_id) AS teacher_id_disp from class_subject_teacher_test t1 where t1.status=1 AND academic_year_id=2")->result();

        $this->load->view('index', $this->data);

    }

    public function saveclass_sub_teacher() {

        error_reporting('E_All');
        ini_set('display_errors', '1');
        $this->db->debug=TRUE;
        $updateid = $this->input->post('updateid');
        $field = array(
            'status' => '0'
        );
        $this->dbconnection->update('class_subject_teacher_test', $field, 'academic_year_id=' . $updateid);
        // $i=1;
        // $class = $this->input->post('class');

       
        // print_r($class);
        // die();
        foreach ($this->input->post('class') as $key => $value) 
        {
            $data = array(
                'class_id' => $this->input->post('class')[$key],
                'section_id' => $this->input->post('sec')[$key],
                'teacher_id' => $this->input->post('teacher')[$key],
                'subject_id' => $this->input->post('subject')[$key],
                'academic_year_id' => $updateid,
                'status' => '1',
                'date_created' => date("Y-m-d H:i:s"),
                'created_by' => $this->session->userdata('user_id'),
            );          
             
            $this->dbconnection->insert('class_subject_teacher_test', $data);
            
            // echo $i;
            // echo '--';
            // echo $this->input->post('class')[$key];
            // echo '<br>';
            // $i++;    
            $this->session->set_flashdata('successmsg', "Successfully Created Record");
        }
        // die();
        echo json_encode(['success' => 'Record added successfully.']);
    }


        public function add_subject_teachers() {

        $id = $this->input->post('formdata');

        $data = array(
            'page_name' => 'add_subject_teachers',
            'page_title' => 'Assign Subject Teacher',
            'section' => $this->section,
            'customview' => $this->customview,
            'task' => 'add',
            'updateid' => $id,
            'academic_name' => $this->dbconnection->Get_namme('accedemic_session', 'id', $id, 'session'),
            'classes' => $this->dbconnection->select('class', '*', 'status="Y"'),
            'sect' => $this->dbconnection->select('section', '*', 'status="Y"'),
            'subjects' => $this->dbconnection->select('subject', '*', 'status=1'),
            'teacher' => $this->dbconnection->select('employee', '*', 'status=1 and category_id=1'),

            'selectdata' => $this->db->query("select t1.id, t1.class_id, (SELECT class_name FROM class WHERE id=t1.class_id) AS class_id_disp,t1.section_id, (SELECT sec_name FROM section WHERE id=t1.section_id) AS section_id_disp, t1.subject_id, (SELECT name FROM subject WHERE id=t1.subject_id) AS subject_id_disp, t1.teacher_id, (SELECT name FROM employee WHERE id=t1.teacher_id) AS teacher_id_disp from class_subject_teacher_test t1 where status=1 AND academic_year_id=$id")->result(),

        );

        $this->load->view('index', $data);
    }

}