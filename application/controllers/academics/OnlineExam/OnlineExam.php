<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OnlineExam extends CI_Controller {
    public function __construct() {
        $this->page_code = 'assignment_homework';

        parent::__construct();

        $this->id = $this->session->userdata('school_id');
        if ($this->id != 0) {
            $this->db->db_select('crmfeesclub_' . $this->id);
            $this->academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year,start_date,end_date,session", "status='Y' and active='Y'");
        }

        $this->page_title = 'Exam List';
        $this->section = 'academic/OnlineExam';
        $this->page_name = 'onlineexam';
        $this->customview = '';
    }

    public function index() {
        // if (substr($this->right_access, 1, 1) != 'R') {
        //     redirect('404');
        // }
        $this->data['page_name'] = $this->page_name;
        $this->data['page_title'] = $this->page_title;
        $this->data['section'] = $this->section;
        $this->data['customview'] = $this->customview;
        $this->load->view('index', $this->data);
    }

     public function add() {
        error_reporting(-1);
        ini_set('display_errors', 1);
        $this->db->db_debug=TRUE;
        $this->data = [
            'question_1' => '',
            'question_2' => '',
            'question_3' => '',
            'question_4' => '',
            'question_5' => '',
            'question_6' => '',
            'question_7' => '',
            'question_8' => '',
            'question_9' => '',
            'question_10' => '',
            'question_11' => '',
            'question_12' => '',
            'question_13' => '',
            'question_14' => '',
            'question_15' => '',
            'question_16' => '',
            'question_17' => '',
            'question_18' => '',
            'question_19' => '',
            'question_20' => '',
            'question_21' => '',
            'question_22' => '',
            'fetch_class' => $this->dbconnection->select("class", "id,class_name", "status='Y'"),
            'fetch_subject' => $this->dbconnection->select("subject", "id,name", "status='1'"),
            'fetch_exam' => $this->dbconnection->select("exam", "id,name", "status=1"),
            'task'=>'SAVE',
            'page_name' => 'add_online_exam',
            'page_title' => $this->page_title,
            'section' => $this->section,
            'customview' => $this->customview,
        ];


        // print_r($this->data);
        // die();

        $this->load->view('index', $this->data);
    }
}
