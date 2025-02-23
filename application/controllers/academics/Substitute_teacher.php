<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Substitute_teacher extends CI_Controller {

    public $page_code = 'substitute_teacher';
    public $page_id = '';
    public $page_perm = '----';

    public function __construct() {
        parent::__construct();


        $this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");
        $this->id = $this->session->userdata('school_id');
        $this->school_desc = $this->dbconnection->select("school", "*", "id=" . $this->id . " and status = 1");
        $this->schools = $this->dbconnection->select("school", "*", 'status = 1');

        $this->academic_session=array();
        if ($this->id != 0) {
            $this->db->db_select('crmfeesclub_' . $this->id);
        
                          
                    $this->academic_session=$this->dbconnection->select("accedemic_session","max(id) as fin_year","active='Y'");
                }

        $permission = $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
        $this->page_perm = !empty($permission) ? $permission[0]->permission : '----';
        $this->right_access = $this->page_perm;

        if (strpos($this->page_perm, '----') == true) {
            redirect(base_url(''), 'refresh');
        }

        $this->page_title = 'Substitute Teachers';
        $this->section = 'academic';
        $this->page_name = 'substitute_teacher_ak';
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

        $this->data['classes'] = $this->dbconnection->select('class', '*', 'status="Y"');
        $this->data['section1'] = $this->dbconnection->select('section', '*', 'status="Y"');
        $this->data['subjects'] = $this->dbconnection->select('subject', '*', 'status=1');
        $this->data['teacher'] = $this->dbconnection->select('employee', '*', 'status=1 and category_id=1');

        $this->data['assignteacher'] = $this->dbconnection->selectasteacher();

        $this->load->view('index', $this->data);
    }


    public function GetSection() {
        $id = $this->input->post('id');
        $data = $this->dbconnection->select('class', 'section', 'status="Y" and id=' . $id);
        $sec = $data[0]->section;
        $sectionfetch = explode("-", $sec);
        foreach ($sectionfetch as $val) {

            $sec_name = $this->dbconnection->select("section", "*", "id=$val");
            foreach ($sec_name as $value) {
                echo "<option value='$value->id'>$value->sec_name</option>";
            }
        }
    }

    public function GetSubject() {
        $cid = $this->input->post('cid');
        $sid = $this->input->post('sid');
        $day = $this->input->post('day');
        $datas = $this->dbconnection->GetSubjectName($cid, $sid, $day);
        $count = count($datas);
        if ($count == '0') {
            echo "<option value=''>No Subject Assigned</option>";
        } else {
            foreach ($datas as $vall) {
                $stime = $vall[time_start];
                $smin = $vall[time_start_min];
                $etime = $vall[time_end];
                $emin = $vall[time_end_min];
                $cid = $vall[crid];
                $pname = $vall[pname];
                $cpid = $vall[cpid];
                $subid = $vall[id];
                if ($stime) {
                    echo "<option value='$cpid'>$vall[name] (Period: $pname)</option>";
                    // echo "<option value='$cid'>$vall[name] ($stime:$smin - $etime:$emin)</option>";
                } else {
                    echo "<option value='$subid'>$vall[name]</option>";
                }
            }
        }
    }
    public function GetTeacher() {
        $subjectid = $this->input->post('subjectid');        
        $sectionset = $this->input->post('sectionset');      
        $class_set = $this->input->post('class_set');
        $day = $this->input->post('day');
        $datas = $this->dbconnection->GetSubjectTeacherSubs($subjectid, $sectionset, $class_set,$day);
        $count = count($datas);
        if ($count == '0') {
            echo "<option value=''>No Teacher is Available</option>";
        } else {
            foreach ($datas as $vall) {
                $name = $vall[name];
                $teacher_id = $vall[teacher_id];

                 echo "<option value='$teacher_id'>$name</option>";
               
            }
        }
        // print_r($datas);
        // die();
       
        
    }

    public function save() {
        if (substr($this->right_access, 0, 1) != 'C') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $result = $this->dbconnection->insert('class_substitute_routine', array(
            'date' => $this->input->post('date'),
            'day' => $this->input->post('day'),
            'class_routine_id' => $this->input->post('routid'),
            'teacher_id' => $this->input->post('tid'),
            'remarks' => $this->input->post('remarks'),
            'academic_year_id'=>$this->academic_session[0]->fin_year,
            'created_by' => $this->session->userdata('user_id')
                )
        );


        $audit = array("action" => 'Add',
            "module" => "Daily Routine Module",
            'datetime' => date("Y-m-d H:i:s"),
            'userid' => $this->session->userdata('user_id'),
            'remarks' => ''
        );
        $this->dbconnection->insert("auditntrail", $audit);
        echo 1;
    }

    public function delete_routine() {
        if (substr($this->right_access, 3, 1) != 'D') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $id = $this->input->post('id');
        $data = array(
            'status' => 0,
        );
        $this->dbconnection->update("class_substitute_routine", $data, "id=$id");

        $audit = array("action" => 'Delete',
            "module" => "Delete Daily Routine Module",
            'datetime' => date("Y-m-d H:i:s"),
            'userid' => $this->session->userdata('user_id'),
            'remarks' => ''
        );
        $this->dbconnection->insert("auditntrail", $audit);
        echo 1;
    }

    public function view_routine() {
        $id = $this->input->post('id');
        $datas = $this->dbconnection->selectasteacherById($id);
        echo $data = json_encode($datas);
    }

    public function update() {
        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $data = array(
            'date' => $this->input->post('date'),
            'day' => $this->input->post('day'),
            'class_routine_id' => $this->input->post('routid'),
            'teacher_id' => $this->input->post('tid'),
            'remarks' => $this->input->post('remarks'),
            'last_date_modified' => date('Y-m-d H:i:s'),
            'last_modified_by' => $this->session->userdata('user_id'),
        );
        $where = "id=" . $this->input->post('id');
        $result = $this->dbconnection->update('class_substitute_routine', $data, $where);

        $audit = array("action" => 'Update',
            "module" => "Substitute Teacher",
            'datetime' => date("Y-m-d H:i:s"),
            'userid' => $this->session->userdata('user_id'),
            'remarks' => ''
        );
        $this->dbconnection->insert("auditntrail", $audit);
        echo 1;
    }

     public function abhi_index() {
        if (substr($this->right_access, 1, 1) != 'R') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->data['page_name'] = 'substitute_teacher';
        $this->data['page_title'] = $this->page_title;
        $this->data['section'] = $this->section;
        $this->data['customview'] = $this->customview;

        $this->data['classes'] = $this->dbconnection->select('class', '*', 'status="Y"');
        $this->data['section1'] = $this->dbconnection->select('section', '*', 'status="Y"');
        $this->data['subjects'] = $this->dbconnection->select('subject', '*', 'status=1');
        $this->data['teacher'] = $this->dbconnection->select('employee', '*', 'status=1 and category_id=1');

        $this->data['assignteacher'] = $this->dbconnection->selectasteacher();

        $this->load->view('index', $this->data);
    }

}
