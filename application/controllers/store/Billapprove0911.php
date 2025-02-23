<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Billapprove extends CI_Controller 
{
       public $page_code = 'billapprove';
       public $page_id = '';
       public $page_perm = '----';
        
	public function __construct() 
	{
		parent::__construct();
                
              $this->page_id 	= $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");
             
              $this->id			= $this->session->userdata('school_id');
		$this->db->db_select('crmfeesclub_'.$this->id); 

              $permission 		= $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
              $this->page_perm	= !empty($permission) ? $permission[0]->permission : '----';
              $this->right_access = $this->page_perm;

		$var_grouptype 	= $this->dbconnection->select("user_group", "group_type", "id={$this->session->userdata('user_group_id')}"); 
		$this->var_role 	= !empty($var_grouptype) ? $var_grouptype[0]->group_type : '----';

		if (strpos($this->page_perm, '----') == true) {
			redirect(base_url(''), 'refresh');
              }

		$this->page_title = 'Approve Bill';
		$this->section = 'store';
		$this->page_name = 'billlistapprove_view'; 
		$this->customview = '';
	}


	public function index()
	{
		if (($this->right_access[1] == 'R') != 1) {
			redirect('404');
		}
	
		$this->data['page_name'] 	= $this->page_name;
		$this->data['id'] 			= $this->id;
		$this->data['page_title'] 	= $this->page_title;
		$this->data['section'] 		= $this->section;
		$this->data['customview'] 	= $this->customview;
		$this->data['right_access'] 	= $this->right_access;

		$this->data['fetch_student'] 	= $this->dbconnection->select('student', 'id, admission_no, first_name, middle_name, last_name', 'status=1');

              $this->data['store_bill_hdr'] = $this->dbconnection->select_order('store_bill_hdr','*,'
					. '(select admission_no from student where admission_no=store_bill_hdr.admission_no) as adm_no,'
					. '(select first_name from student where admission_no=store_bill_hdr.admission_no) as student_fname,'
					. '(select middle_name from student where admission_no=store_bill_hdr.admission_no) as student_midname,'
					. '(select last_name from student where admission_no=store_bill_hdr.admission_no) as student_lname,'
					. 'bill_date, date_approved1, approved1_by, approve1_comment, approved2_by, date_approved2,'
					. 'approve2_comment, approved3_by, date_approved3, approve3_comment, final_status, final_comment', 'status="Y" AND final_status="Sent for Approval"', 'id', 'ASC');
 
		$this->load->view('index', $this->data);
	}

	
	public function approve_bill() {
	//** This function is called from the APPROVE button to rediect to another page  **
        
		if (substr($this->right_access, 2, 1) != 'U') {
			redirect('404');
		}

		$this->data['page_name'] 	= 'billapprove_view'; //$this->page_name;
		$this->data['id'] 			= $this->id;
		$this->data['page_title'] 	= 'Approve Bill'; //$this->page_title;
		$this->data['section'] 		= 'store'; //$this->section;
		$this->data['customview'] 	= ''; //$this->customview;
		$this->data['right_access'] 	= $this->right_access;

		$this->data['fetch_student'] 	= $this->dbconnection->select('student', 'id, admission_no, first_name, middle_name, last_name', 'status=1');


		if ($this->var_role == 'admin') {
			$this->data['arr_store_item'] = $this->dbconnection->select('store_items', '*');
		} else {
			$str = "store_type='" . $this->var_role . "' and active='Y'";
			$this->data['arr_store_item'] = $this->dbconnection->select("store_items", "*", $str);
		}

		$this->load->view('index', $this->data);
	}



	public function update_details() {
		
		if(! $this->input->is_ajax_request() || substr($this->right_access, 2, 1) != 'U') {
			redirect('404');
		}

		$bill_hdr_id = $this->uri->segment(4);
		
		if (($this->input->post('comm_appr1') == 'Approved') || ($this->input->post('comm_appr1') == 'Rejected'))
			$user_appr1 = $this->session->userdata('user_id');
		else
			$user_appr1 = '';

		if (($this->input->post('comm_appr2') == 'Approved') || ($this->input->post('comm_appr2') == 'Rejected'))
			$user_appr2 = $this->session->userdata('user_id');
		else
			$user_appr2 = '';

		if (($this->input->post('comm_appr3') == 'Approved') || ($this->input->post('comm_appr3') == 'Rejected'))
			$user_appr3 = $this->session->userdata('user_id');
		else
			$user_appr3 = '';

		if (($this->input->post('comm_appr1') == 'Rejected') || ($this->input->post('comm_appr2') == 'Rejected') ||  ($this->input->post('comm_appr3') == 'Rejected'))
			$final_status = 'Rejected';
		elseif (($this->input->post('comm_appr1') == 'Approved') && ($this->input->post('comm_appr2') == 'Approved') && ($this->input->post('comm_appr3') == 'Approved'))
			$final_status = 'Approved';
		else
			$final_status = 'Sent for Approval';

/*		$this->dbconnection->update('store_items', array(	
															'qnty_curr' 	=> $old_qnty - $this->input->post('qty')[$i],
															'qnty_alert' 	=> 'Y'),
															array('id' => $this->input->post('pro')[$i])
*/
		$this->dbconnection->update('store_bill_hdr', array(	
													'date_approved1' 		=> $this->input->post('date_appr1'),
													'approve1_comment' 	=> $this->input->post('comm_appr1'),
													'approved1_by'		=> $user_appr1,
													'date_approved2' 		=> $this->input->post('date_appr2'),
													'approve2_comment' 	=> $this->input->post('comm_appr2'),
													'approved2_by' 		=> $user_appr2,
													'date_approved3' 		=> $this->input->post('date_appr3'),
													'approve3_comment' 	=> $this->input->post('comm_appr3'),
													'approved3_by' 		=> $user_appr3, 
													),
												array('id' => $bill_hdr_id)
								);

/*		$data=array(
				'date_approved1' 		=> $this->input->post('date_appr1'),                                           
				'approve1_comment' 	=> $this->input->post('comm_appr1'),  
				'approved1_by' 		=> $user_appr1,           
				'date_approved2' 		=> $this->input->post('date_appr2'),
				'approve2_comment' 	=> $this->input->post('comm_appr2'),
				'approved2_by' 		=> $user_appr2,
				'date_approved3' 		=> $this->input->post('date_appr3'),
				'approve3_comment' 	=> $this->input->post('comm_appr3'),
				'approved3_by' 		=> $user_appr3,

				'final_status' 			=> $final_status,
				'final_comment' 		=> $this->input->post('remarks')
			   );
		
		$q=$this->dbconnection->update('store_bill_hdr', $data, "id=$bill_hdr_id");
*/		
   /*           if($q){
                        $audit = array(
                                        "action" => 'Update Bill Approval',
                                        "module" => "Bill Approval",
                                        'datetime' => date("Y-m-d H:i:s"),
                                        'userid' => $this->session->userdata('user_id'),
                                        'student_id' => 0,
                                        'page' => 'Billapprove',
                                        'remarks' => 'Updation of Leave Application of ID:'.$bill_hdr_id,
                                    );
                        $this->dbconnection->insert("auditntrail", $audit);
                }
              */  
		echo 1;
	}


	public function get_student_information()
	{
		if(! $this->input->is_ajax_request()) {
			redirect('404');
		}

		$student_admno=$this->input->post('code');
		$this->dbconnection->fetch_information('student','admission_no',$student_admno,'first_name','middle_name','last_name');
	}

        
//** This function is BillListApprove_view to polulate bill details **
	public function fetch_billitem_details() {
               if(! $this->input->is_ajax_request()) {
			redirect('404');
		}

              $bill_id=$this->input->post('bill_id');
		$query = $this->dbconnection->select_join('store_bill_details','store_bill_details.*, store_items.item_name','bill_id=' . $bill_id,'store_items','store_bill_details.item_id = store_items.id'); //,$join_type=''	

              $return='';
              $return .='<table class="table table-bordered table-striped" id="toapprove_bill_details_tbl">';
              $return .='<thead><tr><th>Item Name</th><th>Regular Price</th><th>Discount (in Rs.)</th><th>Sell Price</th><th>Qty Sold</th><th>Amount (in Rs.)</th></tr></thead>';
              $return .='<tbody>';
			  
              foreach($query as $row) {
			$return .='<tr style="padding:2px 0px 2px 0px;">';
			$return .='<td style="padding:2px 0px 2px 10px;">' . $row->item_name . '</td>';
			$return .='<td style="padding:2px 10px 2px 0px; text-align:right;">' . $row->reg_price . '</td>';
			$return .='<td style="padding:2px 10px 2px 0px; text-align:right;">' . $row->disc_amt . '</td>';
			$return .='<td style="padding:2px 10px 2px 0px; text-align:right;">' . $row->sell_price . '</td>';
			$return .='<td style="padding:2px 10px 2px 0px; text-align:right;">' . $row->item_qty . '</td>';
			$return .='<td style="padding:2px 10px 2px 0px; text-align:right;">' . $row->item_amt . '</td>';
                     $return .='</tr>';
                }
                $return .='</tbody></table>';
                echo $return;
        }

}
