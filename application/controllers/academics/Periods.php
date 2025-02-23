<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Periods extends CI_Controller {

    public $page_code = 'periods';
    public $page_id = '';
    public $page_perm = '----';

    public function __construct() {
        parent::__construct();
        
//                error_reporting(-1);
//                ini_set('display_errors',1);
//                $this->db->db_debug=TRUE;
        $this->id=$this->session->userdata('school_id');
        $this->academic_session=array();
        if ($this->id !=0 ) {                
            $this->academic_session=$this->dbconnection->select("accedemic_session","max(id) as fin_year","active='Y'");
        }

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
        $this->page_title = 'Periods';
        $this->section = 'academic';
        $this->page_name = 'periods';
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
        $this->data['right_access'] = $this->right_access;
        $this->data['customview'] = $this->customview;

        /* $this->data['classes']=$this->dbconnection->select('class','*','status="Y"');
          $this->data['section1']=$this->dbconnection->select('section','*','status="Y"');
          $this->data['subjects']=$this->dbconnection->select('subject','*','status=1');
          $this->data['teacher']=$this->dbconnection->select('employee','*','status=1 and category_id=1');
         */
        $this->data['periods'] = $this->dbconnection->select('class_periods', '*', 'status=1');
//$this->data['assignteacher']=$this->dbconnection->selectasteacher();

        $this->load->view('index', $this->data);
    }

    public function add() {
        if (substr($this->right_access, 0, 1) != 'C') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $name = $this->input->post('name');
        $start_hr = $this->input->post('start_hr');
        $start_mi = $this->input->post('start_mi');
        $end_ht = $this->input->post('end_ht');
        $end_mi = $this->input->post('end_mi');
        $breakyesno = !empty($this->input->post('isbreak'))?$this->input->post('isbreak'):'NO';

        $data = array(
            'name' => $name,
            'time_start' => $start_hr,
            'time_start_min' => $start_mi,
            'time_end' => $end_ht,
            'time_end_min' => $end_mi,
            'break_yes_no' => $breakyesno,
            'academic_year_id'=>$this->academic_session[0]->fin_year,
            'date_created'=>date('Y-m-d H:i:s'),
            'created_by'=>$this->session->userdata('user_id')
        );

        $this->dbconnection->insert('class_periods', $data);
    }

    public function deletes() {
        if (substr($this->right_access, 3, 1) != 'D') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $id = $this->input->post('id');
        $table = 'class_periods';
        $data = array('status' => 0);
        $where = id . "=$id";
        $this->dbconnection->update($table, $data, $where);
    }

    public function updates() {
        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $c_id = $this->uri->segment(4);
        $data['name'] = $this->input->post('p_name');
        $data['time_start'] = $this->input->post('time_start');
        $data['time_start_min'] = $this->input->post('time_start_min');
        $data['time_end'] = $this->input->post('time_end');
        $data['time_end_min'] = $this->input->post('time_end_min');
        $data['break_yes_no'] = !empty($this->input->post('isbreak'))?$this->input->post('isbreak'):'NO';
        $data['date_modified']=date('Y-m-d H:i:s');
        $data['modified_by']=$this->session->userdata('user_id');
        $table = 'class_periods';
        $this->dbconnection->update($table, $data, 'id=' . $c_id);
//window.location.href = "base_url('')";
        redirect('academics/periods', 'refresh');
    }

}
