<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Storeitem extends CI_Controller {

	public $page_code = 'storeitem';
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
		$this->page_title = 'Store Items';
		$this->section = 'store';
		$this->page_name = 'storeitem_view';
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
		$this->data['navi'] 		= 'storeitem_view';    //'store';
		$this->data['right_access']	= $this->right_access;
		$this->data['rep_type']		= 'all';

		if ($this->var_role == 'admin') {
			$this->data['arr_store_item'] = $this->dbconnection->select('store_items', '*');
		} else {
			$str = "store_type='" . $this->var_role . "' and active='Y'";
			$this->data['arr_store_item'] = $this->dbconnection->select("store_items", "*", $str); //"store_type=". $this->var_role);
		}
		$this->load->view('index', $this->data);   
	}


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
       
		$audit = array("action" => 'Add',
				"module" => "Store Management",
				'datetime' => date("Y-m-d H:i:s"),
				'userid' => $this->session->userdata('user_id'),
				'page' => 'store_items',
				'remarks' => ''
				);
        
		$this->dbconnection->insert("auditntrail", $audit);
		echo 1;
	}


	public function update_details() {
		if ($this->right_access[2]!= 'U') {
			redirect('404');
		}
		
		$details_id = $this->uri->segment(4);
		$this->dbconnection->update('store_items', array(	
													'item_name' 	=> $this->input->post('item_name'),
													'qnty_min' 	=> $this->input->post('qnty_min'),
													'qnty_curr' 	=> $this->input->post('qnty_curr'),
													'sell_price'	=> $this->input->post('sell_price'),
													'store_type' 	=> $this->input->post('store_type'),
													'last_modified_by' 	=> $this->session->userdata('user_id'),	
													'date_modified' 	=> date()),
												array('id' => $details_id)
								);

	//Audit Trail
		$audit = array("action" => 'Update',
				"module" => "Store Management",
				'datetime' => date("Y-m-d H:i:s"),
				'userid' => $this->session->userdata('user_id'),
				'page' => 'store_items',
				'remarks' => ''
				);
		$this->dbconnection->insert("auditntrail", $audit);
		echo 1;
	}


	public function delete_details() {
		if ($this->right_access[3]!= 'D') {
			redirect('404');
		}
		$details_id = $this->uri->segment(4);
		$result = array();
		$result = $this->dbconnection->update(
			'store_items', array('active' => 'N', 'last_modified_by' => $this->session->userdata('user_id'), 'date_modified' => date()),
			array('id' => trim($this->input->post('del_id')))
			); 

//Audit Trail
		$audit = array("action" => 'Delete',
				"module" => "Store Management",
				'datetime' => date("Y-m-d H:i:s"),
				'userid' => $this->session->userdata('user_id'),
				'page' => 'items_received',
				'remarks' => 'Status set to N'
				);
		$this->dbconnection->insert("auditntrail", $audit);
		echo 1;
	}


	public function get_report() {
		if (($this->right_access[1] == 'R') != 1) {
			redirect('404');
		}
		$this->data['page_name']	= $this->page_name;
		$this->data['id'] 			= $this->id;
		$this->data['page_title'] 	= $this->page_title;
		$this->data['section'] 		= $this->section;
		$this->data['customview']	= $this->customview;
		$this->data['navi'] 		= 'storeitem_view';    //'store';
		$this->data['right_access']	= $this->right_access; 

		$this->data['arr_store_item'] = '';
		
		$val_report = $_POST['repStock']; 
		$this->data['rep_type']		= $val_report;

		if ($val_report == 'all') {
			if ($this->var_role == 'admin') {
				$strsql = "SELECT * FROM store_items WHERE active='Y'";
			} else {
				$strsql = "SELECT * FROM store_items WHERE active='Y' AND store_type='" . $this->var_role . "'";
			}
			$query = $this->db->query($strsql);
		} 
	
		if ($val_report == 'alert') {
			if ($this->var_role == 'admin') {
				$strsql = "SELECT * FROM store_items WHERE active='Y' AND qnty_alert='Y'";
			} else {
				$strsql = "SELECT * FROM store_items WHERE active='Y' AND qnty_alert='Y' AND store_type='" . $this->var_role . "'";
			}
		}
		$query = $this->db->query($strsql);
		$this->data['arr_store_item'] = $query->result(); 

		$this->load->view('index', $this->data);   
	}

}

?>