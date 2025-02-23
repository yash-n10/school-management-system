<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Addqty extends CI_Controller {

	public $page_code = 'addqty';
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
		$this->page_title = 'Add Item Quantities';
		$this->section = 'store';
		$this->page_name = 'addqty_view';
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
		$this->data['navi'] 		= 'addqty_view';    //'store';
		$this->data['right_access']	= $this->right_access;
// print_r($this->var_role);die();

		if ($this->var_role == 'admin') {
			$query=$this->db->query("SELECT item_name FROM store_items group by item_name ");
			$this->data['arr_store_item'] = $query->result();
		} else {
			$role=$this->var_role;
			$query=$this->db->query("SELECT item_name FROM store_items where store_type='$role' group by item_name ");
			// $str = "store_type='" . $this->var_role . "' and active='Y'";
			$this->data['arr_store_item'] = $query->result();
		}


		// if ($this->var_role == 'admin') {
		// 	$this->data['arr_store_item'] = $this->dbconnection->select('store_items', '*');
		// } else {
		// 	$str = "store_type='" . $this->var_role . "' and active='Y'";
		// 	$this->data['arr_store_item'] = $this->dbconnection->select("store_items", "*", $str);
		// }
		// echo"<pre>";
		// print_r($this->data);die;
		// $option ='';
		// //echo $data->id; echo $data->item_name;echo "<br>";
		// foreach ($this->data['arr_store_item'] as $data) {
		// 	$option .='<option value="'.$data->id.'">'.$data->item_name.'</option>';
		// }
		// $this->data['set_opt'] = $option;
		//die();
			// echo "<pre>";print_r($this->data['arr_store_item']);die();
		$this->load->view('index', $this->data);   
	
//		$this->data['arr_store_item'] = $this->dbconnection->select('store_items', '*'); 
//		$this->load->view('index', $this->data);   
	
	}

	public function saveRecs() {
	//** This function is call from ADDQTY_VIEW page to save the records **
		
		if ($this->right_access[0] != 'C') {
			redirect('404');
		}

		if (count($this->input->post('pro')) == 0) {
			echo 0;
	
		} else {
			for ($i = 0; $i < count($this->input->post('pro')); $i++) {
				$field = array(
						'store_item_id'	=> $this->input->post('pro')[$i],
						'date_received' 	=> $this->input->post('date_received')[$i],
						'item_qnty' 		=> $this->input->post('qty')[$i],
						'created_by' 		=> $this->session->userdata('user_id')   //$_SERVER['REMOTE_ADDR']
					);

				$this->dbconnection->insert('store_items_received', $field);
				$last_id = $this->db->insert_id();
		
			//** This part of code updates QNTY_CURR & ALERT columns in STORE_ITEMS table for each new record in STORE_ITEMS_RECEIVED table **
			
				// $prev_qnty = $this->dbconnection->select('store_items', 'qnty_min, qnty_curr, qnty_alert', 'item_name=' . $this->input->post('pro')[$i]);
				// foreach ($prev_qnty as $row) {
				// 	$old_qnty = $row->qnty_curr;
				// 	$old_min  = $row->qnty_min;
				// 	$old_alert = $row->qnty_alert;
				// }

				$item_name=$this->input->post('pro')[$i];
				$qnty_current=$this->input->post('qty')[$i];
				$sell_price=$this->input->post('rate')[$i];
				$receipt_date=$this->input->post('date_received')[$i];
				$receipt_no=$this->input->post('receipt_no')[$i];
				$supplier=$this->input->post('supplier_invoice')[$i];
				$work_order=$this->input->post('work_order')[$i];
				$amount=$this->input->post('amount')[$i];
				$supplier_invoice=$this->input->post('supplier_invoice')[$i];
				$store=$this->input->post('store')[$i];
				$discount_percent=$this->input->post('disc_pct')[$i];
				$discount_amount=$this->input->post('disc_amt')[$i];
				$unit=$this->input->post('unit')[$i];

				$query=$this->db->query("INSERT INTO store_items (item_name,qnty_curr,sell_price,receipt_data,receipt_no,supplier,amount,work_order,supplier_invoice,store_type,disc_pct,disc_amt,active,unit) VALUES('$item_name','$qnty_current','$sell_price','$receipt_date','$receipt_no','$supplier','$amount','$work_order','$supplier_invoice','$store','$discount_percent','$discount_amount','Y','$unit')");
				if($query){
					$a=1;
				}
				else{
					$a=0;
				}



				// if ($old_alert == 'N') {    // (ENUM 'N') = 2
				// 	$this->dbconnection->update('store_items', array('qnty_curr' 	=> $old_qnty + $this->input->post('qty')[$i]), array('id' => $this->input->post('pro')[$i]));
				// }
				// else {
				
				// 	if ($old_min >= ($old_qnty + $this->input->post('qty')[$i])) {
				// 		$this->dbconnection->update('store_items', array('qnty_curr' 	=> $old_qnty + $this->input->post('qty')[$i]), array('id' => $this->input->post('pro')[$i]));
				// 	} else {
				// 		$this->dbconnection->update('store_items', array(	
				// 											'qnty_curr' 	=> $old_qnty + $this->input->post('qty')[$i],
				// 											'qnty_alert' 	=> 'N'),
				// 											array('id' => $this->input->post('pro')[$i])
				// 							);
				// 	}
				// }
			//** STORE_ITEMS update --> ends here
			}
		}
		
	//Audit Trail
		$audit = array("action" => 'Insert',
				"module" => "Store Management",
				'datetime' => date("Y-m-d H:i:s"),
				'userid' => $this->session->userdata('user_id'),
				'page' => 'items_received',
				'remarks' => ''
				);
		$this->dbconnection->insert("auditntrail", $audit);
		// echo 1;
	
		echo $a;
	}

}

?>