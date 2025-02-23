<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pro_issued_report extends CI_Controller {
    
    public $page_code = 'stock_issue';
    public $page_id = '';
    public $page_perm = '----';
    
    public function __construct() {
        parent::__construct();
        // $this->db->db_debug=TRUE;
        //  error_reporting(-1);
        //  ini_set('display_errors', 1);
        $this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");

//         $accesspermission = $this->dbconnection->select('collegefclb.user_group_permission', 'permission', "status='Y' AND link_code='$link_code' AND user_group_id=".$this->session->userdata('user_group_id')); 
//
//        $tt=$this->right_access= $this->right_access = (count($accesspermission)==0 || empty($accesspermission[0]->permission)) ? '----':$accesspermission[0]->permission;
//
//        if($this->right_access=='----') {
//            redirect(base_url(), 'refresh');
//         }
        
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
        if (substr($this->right_access, 1, 1) != 'R') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        // error_reporting(-1);
        $this->load->model('Mymodel', 'm');
        $this->data['page_name'] = 'pro_iss_rep_list';
        $this->data['page_title'] = 'Product Issued';
        $this->data['section'] = 'inventory';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->data['employee'] = $this->dbconnection->select("employee", "*", "status='1'");
        // $this->data['product_issued'] = $this->m->product_issued();
        $this->load->view('index', $this->data);
    }

}
