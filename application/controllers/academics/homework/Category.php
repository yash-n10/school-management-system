<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends MY_ListController {

    public $page_code = 'assignment_category';
    public $page_id='';
    public $page_perm='----';

    public function __construct() {
        
        $this->page_code='assignment_category';
        parent::__construct();
        
        
//        switch ($this->session->userdata('login_type')) {
//            case 'appadmin':
//                $this->right_access = 'CRUD';
//                break;
//            case 'admin':
//                $this->right_access = 'CRUD';
//                break;
//            case 'principal':
//                $this->right_access = 'CR--';
//                break;
//            case 'teacher':
//                $this->right_access = '-R--';
//                break;
//            default:
//                $this->right_access = '----';
//                redirect(base_url(), 'refresh');
//        }
        $this->id = $this->session->userdata('school_id');

        
        
//        if ($this->id != 0)
//            $this->db->db_select('crmfeesclub_' . $this->id);
                
        
        $this->page_title = 'Category';
        $this->section = 'academic';
        $this->page_name = 'category';
        $this->customview = '';
    }

    public function index() {
        
        if(substr($this->right_access, 1,1)!='R') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }


        $this->data['page_name'] = $this->page_name;
        $this->data['page_title'] = $this->page_title;
        $this->data['section'] = $this->section;
        $this->data['customview'] = $this->customview;
        $this->data['right_access']  = $this->right_access;
        $this->data['category'] = $this->dbconnection->select('assignment_category', '*', 'status="Y"');
        $this->load->view('index', $this->data);
    }

    public function Add_category() {
        
        if(substr($this->right_access, 0,1)!='C') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }

        $result = $this->dbconnection->insert('assignment_category', array(
            'name' => $this->input->post('name'),
            'slug' => $this->input->post('slug'),
            'created_by' => $this->session->userdata('user_id'),
                )
        );
        $lastid = $this->dbconnection->get_last_id();
        $audit = array("action" => 'Add Assignment Category',
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

    public function Delete_category() {
        
        if(substr($this->right_access, 3,1)!='D') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        
        $id = $this->input->post('id');
        $data = array(
            'status' => N,
        );
        $this->dbconnection->update("assignment_category", $data, "id=$id");

        $audit = array("action" => 'Delete Assignment Category',
            "module" => $this->uri->segment(1),
            "page" => basename(__FILE__, '.php'),
            'datetime' => date("Y-m-d H:i:s"),
            'userid' => $this->session->userdata('user_id'),
            'remarks' => 'ID:' . $id,
            'ip_address' => '',
        );
        $this->dbconnection->insert("auditntrail", $audit);
    }

    public function Update_category() {
        
        if(substr($this->right_access, 2,1)!='U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        
        $id = $this->input->post('id');
        $data = array(
            'name' => $this->input->post('name'),
            'slug' => $this->input->post('slug'),
            'last_date_modified' => date("Y-m-d H:i:s"),
            'last_modified_by' => $this->session->userdata('user_id'),
        );
        $where = "id=" . $this->input->post('id');
        $result = $this->dbconnection->update('assignment_category', $data, $where);

        $audit = array("action" => 'Update Assignment Category',
            "module" => $this->uri->segment(1),
            "page" => basename(__FILE__, '.php'),
            'datetime' => date("Y-m-d H:i:s"),
            'userid' => $this->session->userdata('user_id'),
            'remarks' => 'ID:' . $id,
            'ip_address' => '',
        );
        $this->dbconnection->insert("auditntrail", $audit);

        echo 1;
    }

}
