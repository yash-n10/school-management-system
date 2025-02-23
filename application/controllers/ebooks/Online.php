<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Online extends CI_Controller {
    
    public $page_code = 'online_class';
    public $page_id = '';
    public $page_perm = '----';
    
    public function __construct() {
        parent::__construct();

        $this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");

        $this->id = $this->session->userdata('school_id');
        if ($this->id != 0) {
            $this->db->db_select('crmfeesclub_' . $this->id);
        }
        
        $permission = $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
        $this->page_perm = !empty($permission) ? $permission[0]->permission : '----';
        $this->right_access = $this->page_perm;

        if (strpos($this->page_perm, '----') == true) {
            redirect(base_url(''), 'refresh');
        }

        $this->academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year,start_date,end_date,session", "status='Y' and active='Y'", '', '', array('id'));
    }

    public function index() {
//         if (substr($this->right_access, 1, 1) != 'R') {
// //            redirect(base_url(), 'refresh');
//             redirect('404');
//         }
        $this->data['page_name'] = 'online';
        $this->data['page_title'] = 'Online Class';
        $this->data['section'] = 'ebooks';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->data['employee'] = $this->dbconnection->select("employee", "*", "status='1'");
        $this->load->view('index', $this->data);
    }

}
