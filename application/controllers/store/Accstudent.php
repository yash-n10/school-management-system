<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accstudent extends CI_Controller {

	public $page_code = 'accstudent';
	public $page_id = '';
	public $page_perm = '----';
	public $group_type='';

	public function __construct() {
		parent::__construct();

		$this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");

		$this->id = $this->session->userdata('school_id');
		$this->db->db_select('crmfeesclub_' . $this->id);

		$permission = $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
		$this->page_perm = !empty($permission) ? $permission[0]->permission : '----';
		$this->right_access = $this->page_perm;
		
		$var_grouptype = $this->dbconnection->select("user_group", "group_type", "id={$this->session->userdata('user_group_id')}"); 
		$this->var_role = !empty($var_grouptype) ? $var_grouptype[0]->group_type : '----';
		
//		print_r($this->var_role); die();
		
		if (strpos($this->page_perm, '----') == true) {
			redirect(base_url(''), 'refresh');
		}
		$this->page_title = 'Student Passbook';
		$this->section = 'store';
		$this->page_name = 'accstudent_view';
		$this->customview = '';
	}
	

	public function index() {
		if (($this->right_access[1] == 'R') != 1) {
			redirect('404');
		}
		
		$this->data['page_name']	= $this->page_name;
		$this->data['id'] 			= $this->id;
		$this->data['page_title'] 	= $this->page_title;
		$this->data['section'] 		= $this->section;
		$this->data['customview']	= $this->customview;
		$this->data['navi'] 		= 'accsummary_view';    //'store';
		$this->data['right_access']	= $this->right_access;

		$usr_name = explode("-", $this->session->userdata('user_name'));
		$str = "admission_no='" . $usr_name[1] . "'";
	
		$this->data['arr_stu_account'] = $this->dbconnection->select("student_acc_book", "*", $str);

		$this->load->view('index', $this->data);
	}
}

?>