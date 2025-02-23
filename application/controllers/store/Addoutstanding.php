<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Addoutstanding extends CI_Controller {

	public $page_code = 'addoutstanding';
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

		$var_grouptype = $this->dbconnection->select("user_group", "group_type", "id={$this->session->userdata('user_group_id')}"); 
		$this->var_role = !empty($var_grouptype) ? $var_grouptype[0]->group_type : '----';

		if (strpos($this->page_perm, '----') == true) {
			redirect(base_url(''), 'refresh');
		}
		$this->page_title = 'Initial Outstandings';
		$this->section = 'store';
		$this->page_name = 'outstandinglist_view';
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

             $this->data['arr_acc_book'] = $this->dbconnection->select_order('student_acc_book','*,'
					. '(select admission_no from student where admission_no=student_acc_book.admission_no) as adm_no,'
					. '(select first_name from student where admission_no=student_acc_book.admission_no) as student_fname,'
					. '(select middle_name from student where admission_no=student_acc_book.admission_no) as student_midname,'
					. '(select last_name from student where admission_no=student_acc_book.admission_no) as student_lname,'
					. '1', 'remarks="Initial Outstandings" AND status="Y"', 'adm_no', 'ASC'); 
		$this->load->view('index', $this->data);   
	}


	public function add_bill() {
	//** This function is called from the ADD OUTSTANDINGS button to rediect to another page  **
        
		if (substr($this->right_access, 0, 1) != 'C') {
			redirect('404');
		}

		$this->data['page_name'] 	= 'addoutstanding_view'; 
		$this->data['id'] 			= $this->id;
		$this->data['page_title'] 	= 'Add Outstandings'; 
		$this->data['section'] 		= 'store';
		$this->data['customview'] 	= ''; 
		$this->data['right_access'] 	= $this->right_access;

		$this->data['arr_students'] 	= $this->dbconnection->select('student', 'id, admission_no, first_name, middle_name, last_name', 'status=1');

		$this->load->view('index', $this->data);   
	}


	public function saveRecs() {
	//** This function is call from addoutstanding_VIEW page to save the records **
		
		if ($this->right_access[0] != 'C') {
			redirect('404');
		}

		if (count($this->input->post('pro')) == 0) {
			echo 0;
	
		} else {
			for ($i = 0; $i < count($this->input->post('pro')); $i++) {
				$field = array(
						'admission_no'	=> $this->input->post('pro')[$i],
						'entry_date' 		=> $this->input->post('date_received')[$i],
						'amt_charged'		=> $this->input->post('qty')[$i],
						'approved'		=> 'Y',
						'remarks'		=> 'Initial Outstandings',
						'entry_type'		=> 'Initial Outstandings',
						'status'=>'Y'
		//				'created_by' 		=> $this->session->userdata('user_id')   //$_SERVER['REMOTE_ADDR']
					);

				$this->dbconnection->insert('student_acc_book', $field);
				$last_id = $this->db->insert_id();
		
			}
		}
		
	//Audit Trail
		$audit = array("action" => 'Insert',
				"module" => "Outstandings",
				'datetime' => date("Y-m-d H:i:s"),
				'userid' => $this->session->userdata('user_id'),
				'page' => 'Add Outstandings',
				'remarks' => 'One-time'
				);
		$this->dbconnection->insert("auditntrail", $audit);
		echo 1;
	}

}

?>