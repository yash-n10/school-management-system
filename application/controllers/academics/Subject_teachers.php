<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Subject_teachers extends MY_ListController {


    
    public function __construct() {
        $this->page_code = 'teacher_subjects_alloc';
        
        parent::__construct();
        
// print_r($this->session->userdata());
        $this->page_title = 'Subject Teachers';
        $this->rec_type = 'Subject Teacher';
        $this->rec_types = 'Subject Teachers';
        $this->section = 'academic';
        $this->dbtable = 'class_subject_teacher';
        $this->display_columns = array('class_id_disp' => 'Class', 'section_id_disp' => 'Section', 'subject_id_disp' => 'Subject', 'teacher_id_disp' => 'Teacher');
        $this->academic_session=$this->dbconnection->select("accedemic_session","max(id) as fin_year","active='Y'");
        $this->edit_columns = array(
            'class_id' => array('disp' => 'Class', 'type' => 'select', 'select_opts' => $this->dbconnection->select('class', 'id AS opt_id, class_name AS opt_disp', 'status="Y"'), 'required' => TRUE),
            'section_id' => array('disp' => 'Section', 'type' => 'select', 'select_opts' => $this->dbconnection->select('section', 'id AS opt_id, sec_name AS opt_disp', 'status="Y"'), 'required' => TRUE),
            'subject_id' => array('disp' => 'Subject', 'type' => 'select', 'select_opts' => $this->dbconnection->select('subject', 'id AS opt_id, name AS opt_disp', 'status=1'), 'required' => TRUE),
            'teacher_id' => array('disp' => 'Teacher', 'type' => 'select', 'select_opts' => $this->dbconnection->select('employee', 'id AS opt_id, name AS opt_disp', 'status=1 and category_id=1')),

            // 'teacher_id' => array('disp' => 'Teacher', 'type' => 'select', 'select_opts' => $this->dbconnection->select('employee', 'id AS opt_id, name AS opt_disp', 'status=1 and category_id=1'), 'required' => TRUE),
        );
        $this->extra_add_columns = array('created_by'=>$this->session->userdata('user_id'),'academic_year_id'=> $this->academic_session[0]->fin_year);
                $this->extra_edit_columns = array('modified_by'=>$this->session->userdata('user_id'),'date_modified'=>date('Y-m-d H:i:s'));

        $this->search_columns = array(
            'alpha_num' => array(
            ),
            'numeric' => array(
            ),
        );
        $this->rec_key = 'id';
        $this->data_table = $this->dbtable . ' AS t1';
        $this->data_select = 'id, ' .
                'class_id, (SELECT class_name FROM class WHERE id=t1.class_id) AS class_id_disp, ' .
                'section_id, (SELECT sec_name FROM section WHERE id=t1.section_id) AS section_id_disp, ' .
                'subject_id, (SELECT name FROM subject WHERE id=t1.subject_id) AS subject_id_disp, ' .
                'teacher_id, (SELECT name FROM employee WHERE id=t1.teacher_id) AS teacher_id_disp, ';
        if ($this->session->userdata('login_type') == 'teacher') {

            $data = $this->dbconnection->select('user', '*', 'id=' . $this->session->userdata('user_id'));
            $tid = $data[0]->employee_id;
            $this->data_select_where = 'status=1 AND academic_year_id='.$this->academic_session[0]->fin_year.' AND teacher_id=' . $tid;
        } else {
            $this->data_select_where = 'status=1 AND academic_year_id='.$this->academic_session[0]->fin_year;
        }
        $this->data_select_order = 'class_id_disp ASC, section_id_disp ASC, subject_id_disp ASC, teacher_id_disp ASC';
        $this->data_delete = 'UPDATE';
        $this->data_delete_update = array('status' => '0');
    }

}
