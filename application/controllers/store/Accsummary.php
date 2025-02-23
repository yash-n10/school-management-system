<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Accsummary extends CI_Controller {

	public $page_code = 'accsummary';
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
		
		if (strpos($this->page_perm, '----') == true) {
			redirect(base_url(''), 'refresh');
		}
		$this->page_title = 'Account Summary';
		$this->section = 'store/reports';
		$this->page_name = 'accsummary_view';
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
		$this->data['right_access']	= $this->right_access;

		$strsql = "SELECT sab.admission_no, concat(std.first_name,' ',std.middle_name, ' ', std.last_name)  AS fullname,  "
						. "SUM(sab.amt_charged)  AS 'tot_amt_charged', SUM(sab.amt_paid) AS 'tot_amt_paid', sab.approved, sab.status "
						. "FROM student_acc_book sab, student std "
						. "WHERE sab.admission_no = std.admission_no GROUP BY sab.admission_no, sab.approved "
						. "HAVING sab.status = 'Y' AND sab.approved = 'Y'"; 

/*		$strsql = "SELECT sab.*, concat(std.first_name,' ',std.middle_name, ' ', std.last_name)  AS fullname,  "
						. "SUM(sab.amt_charged)  AS 'tot_amt_charged', SUM(sab.amt_paid) AS 'tot_amt_paid' "
						. "FROM student_acc_book sab, student std "
						. "WHERE sab.admission_no = std.admission_no GROUP BY sab.admission_no"; */
		$query = $this->db->query($strsql);
		$this->data['arr_store_item'] = $query->result();

		$this->load->view('index', $this->data);   
	}
}

?>