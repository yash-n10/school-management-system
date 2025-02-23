<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Syllabus extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->page_title = 'Syllabus';
        $this->section = 'academic';
        $this->page_name = 'syllabus';
        $this->customview = '';
    }


    public function index() {

        $this->data['page_name'] = $this->page_name;
        $this->data['page_title'] = $this->page_title;
        $this->data['section'] = $this->section;
        $this->data['customview'] = $this->customview;

        $this->data['class'] = $this->dbconnection->select('class', '*', 'status="Y"');
        $this->data['sec'] = $this->dbconnection->select('section', '*', 'status="Y"');
        $this->data['subject'] = $this->dbconnection->select('section', '*', 'status=1');

        $this->load->view('index', $this->data);
    }

    public function save() {

            $data=  array(
                'class_id' => $this->input->post('class_id'),
                'section_id' => $this->input->post('section_id'),
                'subject_id' => $this->input->post('subject_id'),
                'module_id' => $this->input->post('module_id'),
                'topic' => $this->input->post('topic'),
                'time_period' => $this->input->post('time_period'),
            );
           
        $result = $this->dbconnection->insert('syllabus',$data);

        $lastid = $this->dbconnection->get_last_id();
        $audit = array("action" => 'Add Syllabus',
            "module" => $this->uri->segment(1),
            "page" => basename(__FILE__, '.php'),
            'datetime' => date("Y-m-d H:i:s"),
            'userid' => $this->session->userdata('user_id'),
            'remarks' => 'ID:' . $lastid,
            'ip_address' => '',
        );
        $this->dbconnection->insert("auditntrail", $audit);
        echo 1;
    }

}