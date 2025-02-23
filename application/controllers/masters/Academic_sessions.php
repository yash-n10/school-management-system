<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Academic_sessions extends CI_Controller {

    public $page_code = 'academic_sessions';
    public $page_id = '';
    public $page_perm = '----';

    public function __construct() {
        parent::__construct();

        $this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");

        $this->id = $this->session->userdata('school_id');

        $this->db->db_select('crmfeesclub_' . $this->id);

        $permission = $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
        $this->page_perm = !empty($permission) ? $permission[0]->permission : '----';
        $this->right_access = $this->page_perm;

        if (strpos($this->page_perm, '----') == true) {
            redirect(base_url(''), 'refresh');
        }
        $this->page_title = 'Academic Sessions';
        $this->section = 'masters';
        $this->page_name = 'academic_session';
        $this->customview = '';
    }

    public function index() {
        if (substr($this->right_access, 1, 1) != 'R') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->data['page_name'] = $this->page_name;
        $this->data['id'] = $this->id;
        $this->data['page_title'] = $this->page_title;
        $this->data['section'] = $this->section;
        $this->data['customview'] = $this->customview;
        $this->data['navi'] = 'academic_session';
        $this->data['right_access'] = $this->right_access;
        $this->data['asession'] = $this->dbconnection->select('accedemic_session', '*', 'status="Y"');
        
        $this->data['statusname']=array('N'=>'Inactive','Y'=>'Active','P'=>'Previous','A'=>'NewAdmission');
        $this->load->view('index', $this->data);
    }

    public function save_session() {
        if (substr($this->right_access, 0, 1) != 'C') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $session = $this->input->post('session');
        $status = $this->input->post('status');
        $stdate = $this->input->post('stdate');
        $endate = $this->input->post('endate');
        $data = array(
            'session' => $session,
            'active' => $status,
            'start_date' => $stdate,
            'end_date' => $endate,
            'created_by' => $this->session->userdata('user_id'),
        );

        $this->dbconnection->insert('accedemic_session', $data);
    }

    public function update_session() {
        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $session = $this->input->post('session');
        $status = $this->input->post('status');
        $astdate = $this->input->post('astdate');
        $aendate = $this->input->post('aendate');

        $id = $this->input->post('id');
        $data = array(
            'session' => $session,
            'start_date' => $astdate,
            'end_date' => $aendate,
            'active' => $status,
            'last_modified_by' => $this->session->userdata('user_id'),
            'date_modified' => date("Y-m-d h:i:s"),
        );
        $this->dbconnection->update('accedemic_session', $data, 'id=' . $id);
    }

    public function delete_session() {
        if (substr($this->right_access, 3, 1) != 'D') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $id = $this->input->post('id');
        $data = array('status' => 'N', 'last_modified_by' => $this->session->userdata('user_id'), 'date_modified' => date("Y-m-d h:i:s"));
        $this->dbconnection->update('accedemic_session', $data, 'id=' . $id);
    }

}
