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
		
//		print_r($this->var_role); die();
		
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
//		$this->data['navi'] 		= 'accsummary_view';    //'store';
		$this->data['right_access']	= $this->right_access;

		$strsql = "SELECT sab.*, concat(std.first_name,' ',std.middle_name, ' ', std.last_name)  AS fullname,  "
						. "SUM(sab.amt_charged)  AS 'tot_amt_charged', SUM(sab.amt_paid) AS 'tot_amt_paid' "
						. "FROM student_acc_book sab, student std "
						. "WHERE sab.admission_no = std.admission_no GROUP BY sab.admission_no";
		$query = $this->db->query($strsql);
		$this->data['arr_store_item'] = $query->result();

		$this->load->view('index', $this->data);   
	}


	public function stu_acc_details() {
	//** This function is called from the ACCOUNT DETAILS button to rediect to another page  **
        
		if (substr($this->right_access, 0, 1) != 'C') {
			redirect('404');
		}

		$usr_name = explode("-", $this->session->userdata('user_name'));

		$this->data['page_name'] 	= 'accstupassbook_view';
		$this->data['id'] 			= $this->id;
		$this->data['page_title'] 	= 'Account Details';
		$this->data['section'] 		= 'store/reports';
		$this->data['customview'] 	= '';
		$this->data['right_access'] 	= $this->right_access;

		$str = "admission_no='" . $usr_name[1] . "'";
		$this->data['arr_stu_account'] = $this->dbconnection->select("student_acc_book", "*", $str);

		$this->load->view('index', $this->data);
	}

/*
	public function add_details() {
		if ($this->right_access[0]  != 'C') {
			redirect('404');
		}

		$result = $this->dbconnection->insert('store_items', array(
													'item_name' 	=> $this->input->post('item_name'),
													'qnty_min' 	=> $this->input->post('qnty_min'),
													'qnty_curr' 	=> $this->input->post('qnty_curr'),
													'sell_price'	=> $this->input->post('sell_price'),
													'store_type' 	=> $this->input->post('store_type'),
													'created_by' 	=> $this->session->userdata('user_id'),
													'date_created' => date()
												)
										);
											//		'store_type' 	=> $this->store_cat,
       
		$audit = array("action" => 'Add',
				"module" => "Store Management",
				'datetime' => date("Y-m-d H:i:s"),
				'userid' => $this->session->userdata('user_id'),
				'page' => 'store_items',
				'remarks' => ''
				);
        
		$this->dbconnection->insert("auditntrail", $audit);
		echo 1;
	}  */
}

?>