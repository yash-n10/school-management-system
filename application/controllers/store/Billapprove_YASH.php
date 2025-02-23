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
                
              $this->page_id 		= $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");
             
              $this->id			= $this->session->userdata('school_id');
		$this->db->db_select('crmfeesclub_'.$this->id); 

              $permission = $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
              $this->page_perm = !empty($permission) ? $permission[0]->permission : '----';
              $this->right_access = $this->page_perm;

		$var_grouptype = $this->dbconnection->select("user_group", "group_type", "id={$this->session->userdata('user_group_id')}"); 
		$this->var_role = !empty($var_grouptype) ? $var_grouptype[0]->group_type : '----';

                if (strpos($this->page_perm, '----') == true) {
                    redirect(base_url(''), 'refresh');
                }

		$this->page_title = 'Approve Bill';
		$this->section = 'store';
		$this->page_name = 'billlistapprove_view'; //'billapprove_view';
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
//		$this->data['navi'] 		= 'billlistapprove_view';    //'store';
		$this->data['right_access'] 	= $this->right_access;

		$this->data['fetch_student'] 	= $this->dbconnection->select('student', 'id, admission_no, first_name, middle_name, last_name', 'status=1');

 
       //       if($this->session->userdata('login_type')=='admin'|| $this->session->userdata('login_type')=='principal'||$this->session->userdata('login_type')=='hr') {
	//		$this->data['session_student_id']='';
                     $this->data['store_bill_hdr'] = $this->dbconnection->select_order('store_bill_hdr','*,'
					. '(select admission_no from student where admission_no=store_bill_hdr.admission_no) as adm_no,'
					. '(select first_name from student where admission_no=store_bill_hdr.admission_no) as student_fname,'
					. '(select middle_name from student where admission_no=store_bill_hdr.admission_no) as student_midname,'
					. '(select last_name from student where admission_no=store_bill_hdr.admission_no) as student_lname,'
					. 'bill_date, date_approved1, approved1_by, approve1_comment, approved2_by, date_approved2,'
					. 'approve2_comment, approved3_by, date_approved3, approve3_comment, final_status, final_comment', 'status=1', 'id', 'ASC');
        /*        } /* else{
                    
                    $getempid=$this->dbconnection->select("user","employee_id","id=".$this->session->userdata('user_id'));
                    $this->data['session_employee_id']=$getempid[0]->employee_id;
                    $this->data['leave_apply_approve'] = $this->dbconnection->select_order('leave_apply_approve','*,'
					. '(select employee_code from employee where id=leave_apply_approve.emp_id) as emp_code,'
					. '(select name from employee where id=leave_apply_approve.emp_id) as emp_name,'
					. '(select designation_id from employee where id=leave_apply_approve.emp_id) as emp_desg,'
					. '(select leave_type_code from leave_type where id=leave_type_id) as leave_id,'
					. '(select user_name from user where id=created_by) as applied_by,'
					. '(select user_name from user where id=approved_by) as approved','status=1 and emp_id='.$getempid[0]->employee_id,'id','ASC');   
                } */

		$this->load->view('index', $this->data);
	}
	
	public function generate_bill() {
	//** This function is called from the GENERATE BILL button to rediect to another page  **
        
		if (substr($this->right_access, 0, 1) != 'C') {
			redirect('404');
		}

		$this->data['page_name'] 	= 'billlistapprove_view'; //$this->page_name;
		$this->data['id'] 			= $this->id;
		$this->data['page_title'] 	= 'Generate Bill'; //$this->page_title;
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



	public function add_details() {
		
		if ($this->right_access[0]  != 'C') {
			redirect('404');
		}
			
		$result = $this->dbconnection->insert('store_bill_hdr', array(
				'admission_no' 		=> $this->input->post('student_enrol_id'),                          
//				'academic_year_id' 	=> $this->input->post('academic_year_id'), 
				'bill_date' 			=> $this->input->post('bill_date'),  
	/*			'date_approved1' 		=> $this->input->post('date_approved1'),                                                                                 
				'approved1_by' 		=> $this->input->post('approved1_by'),                                                                                 
				'approve1_comment' 	=> $this->input->post('approve1_comment'),                                                                                 
				'date_approved2' 		=> $this->input->post('date_approved2'),                                                                                 
				'approved2_by' 		=> $this->input->post('approved2_by'),                                                                                 
				'approve2_comment' 	=> $this->input->post('approve2_comment'),                                                                                 
				'date_approved3' 		=> $this->input->post('date_approved3'),                                                                                 
				'approved3_by' 		=> $this->input->post('approved3_by'),                                                                                 
				'approve3_comment' 	=> $this->input->post('approve3_comment'),                                                                                 
				'final_status' 			=> $this->input->post('final_status'),                                                                                 
				'final_comment' 		=> $this->input->post('final_comment'),                 */                                                                
//				'approve1_comment' => $this->input->post('approve1_comment'),                                                                                 
//				'reason' => $this->input->post('reason'),                                                                                 
//				'remarks' => $this->input->post('remarks'), 
//				'academic_year_id'=> $this->academic_session[0]->fin_year,
				'created_by' => $this->session->userdata('user_id'),  
				'date_created' => date()
				)
		);
       
		$audit = array("action" => 'Add',
				"module" => "Store Management",
				'datetime' => date("Y-m-d H:i:s"),
				'userid' => $this->session->userdata('user_id'),
				'page' => 'bills_approve',
				'remarks' => ''
				);
        
		$this->dbconnection->insert("auditntrail", $audit);
		echo 1;
	}

	public function save() {
  //      if(! $this->input->is_ajax_request()  || substr($this->right_access, 0, 1) != 'C') {
		if($this->right_access[0]  != 'C') {
			redirect('404');
		}
		$data=array(
				'admission_no' 		=> $this->input->post('student_enrol_id'),                          
//				'academic_year_id' 	=> $this->input->post('academic_year_id'), 
				'bill_date' 			=> $this->input->post('bill_date'),  
				'date_approved1' 		=> $this->input->post('date_approved1'),                                                                                 
				'approved1_by' 		=> $this->input->post('approved1_by'),                                                                                 
				'approve1_comment' 	=> $this->input->post('approve1_comment'),                                                                                 
				'date_approved2' 		=> $this->input->post('date_approved2'),                                                                                 
				'approved2_by' 		=> $this->input->post('approved2_by'),                                                                                 
				'approve2_comment' 	=> $this->input->post('approve2_comment'),                                                                                 
				'date_approved3' 		=> $this->input->post('date_approved3'),                                                                                 
				'approved3_by' 		=> $this->input->post('approved3_by'),                                                                                 
				'approve3_comment' 	=> $this->input->post('approve3_comment'),                                                                                 
				'final_status' 			=> $this->input->post('final_status'),                                                                                 
				'final_comment' 		=> $this->input->post('final_comment'),                                                                                 
//				'approve1_comment' => $this->input->post('approve1_comment'),                                                                                 
//				'reason' => $this->input->post('reason'),                                                                                 
//				'remarks' => $this->input->post('remarks'), 
				'academic_year_id'=> $this->academic_session[0]->fin_year,
				'created_by' => $this->session->userdata('user_id'),  

			   );
		$q=$this->dbconnection->insert('store_bill_hdr', $data);
		$leave_apply_id = $this->dbconnection->get_last_id();
                
		if($q){
                    
                        $audit = array(
                                        "action" => 'Add Store Bill ',
                                        "module" => "Leave Module",
                                        'datetime' => date("Y-m-d H:i:s"),
                                        'userid' => $this->session->userdata('user_id'),
                                        'student_id' => 0,
                                        'page' => 'Billapprove',
                                        'remarks' => 'Creation of Leave Applicaion of ID:'.$leave_apply_id,
                                    );
                        $this->dbconnection->insert("auditntrail", $audit);
                }
                
                
	}
//THIS FUNCTION IS NOT IN USE 
	public function update_details() {
  //      if(! $this->input->is_ajax_request()  || substr($this->right_access, 0, 1) != 'C') {
		if($this->right_access[0]  != 'U') {
			redirect('404');
		}
		
		$details_id = $this->uri->segment(4);
		$this->dbconnection->update('store_items', array(	
													'admission_no' 	=> $this->input->post('student_enrol_id'),
													'bill_date' 	=> $this->input->post('bill_date'),
													'approve1_comment' 	=> $this->input->post('approve1_comment'),
													'approved1_by'	=> $this->input->post('approved1_by'),
													'last_modified_by' 	=> $this->session->userdata('user_id'),	
													'date_modified' 	=> date()),
												array('id' => $details_id)
								);
  }
  
/*		$data=array(
				'admission_no' 		=> $this->input->post('admission_no'),                          
//				'academic_year_id' 	=> $this->input->post('academic_year_id'), 
				'bill_date' 			=> $this->input->post('bill_date'),  
				'date_approved1' 		=> $this->input->post('date_approved1'),                                                                                 
				'approved1_by' 		=> $this->input->post('approved1_by'),                                                                                 
				'approve1_comment' 	=> $this->input->post('approve1_comment'),                                                                                 
				'date_approved2' 		=> $this->input->post('date_approved2'),                                                                                 
				'approved2_by' 		=> $this->input->post('approved2_by'),                                                                                 
				'approve2_comment' 	=> $this->input->post('approve2_comment'),                                                                                 
				'date_approved3' 		=> $this->input->post('date_approved3'),                                                                                 
				'approved3_by' 		=> $this->input->post('approved3_by'),                                                                                 
				'approve3_comment' 	=> $this->input->post('approve3_comment'),                                                                                 
				'final_status' 			=> $this->input->post('final_status'),                                                                                 
				'final_comment' 		=> $this->input->post('final_comment'),                                                                                 
//				'approve1_comment' => $this->input->post('approve1_comment'),                                                                                 
//				'reason' => $this->input->post('reason'),                                                                                 
//				'remarks' => $this->input->post('remarks'), 
				'academic_year_id'=> $this->academic_session[0]->fin_year,
				'created_by' => $this->session->userdata('user_id'),  

			   );
		$q=$this->dbconnection->insert('store_bill_hdr', $data);
		$leave_apply_id = $this->dbconnection->get_last_id();  */

	public function update_load($id) {
		if(substr($this->right_access, 2, 1) != 'U') {
			redirect('404');
		}
		
		$bill_details=$this->db->query("SELECT * FROM store_bill_hdr where id='$id'");
		$bill_details=$bill_details->result();
		$bill_details=$bill_details[0];
		// echo "<pre>";print_r($bill_details);
		// print_r($bill_details->id);die();

		$this->data['bill_id']=$bill_details->id;
		$this->data['admission_no']=$bill_details->admission_no;
		$this->data['bill_date']=$bill_details->bill_date;
		$this->data['bill_amt']=$bill_details->bill_amt;
		$this->data['date_approved1']=$bill_details->date_approved1;
		$this->data['approved1_by']=$bill_details->approved1_by;
		$this->data['approve1_comment']=$bill_details->approve1_comment;
		$this->data['approved2_by']=$bill_details->approved2_by;
		$this->data['date_approved2']=$bill_details->date_approved2;
		$this->data['approve2_comment']=$bill_details->approve2_comment;
		$this->data['approved3_by']=$bill_details->approved3_by;
		$this->data['date_approved3']=$bill_details->date_approved3;
		$this->data['approve3_comment']=$bill_details->approve3_comment;
		$this->data['final_status']=$bill_details->final_status;
		$this->data['final_comment']=$bill_details->final_comment;

		$this->data['page_name'] 	= 'billsapprove_edit_load'; //$this->page_name;
		$this->data['id'] 			= $this->id;
		$this->data['page_title'] 	= 'Approve Bill'; //$this->page_title;
		$this->data['section'] 		= 'store'; //$this->section;
		$this->data['customview'] 	= ''; //$this->customview;
		$this->data['right_access'] 	= $this->right_access;
		$this->load->view('index',$this->data);
		// $q=$this->dbconnection->update('store_bill_hdr',$data,"id=$param2");
              // if($q){
              //           $audit = array(
              //                           "action" => 'Add Store Bill',
              //                           "module" => "Store Module",
              //                           'datetime' => date("Y-m-d H:i:s"),
              //                           'userid' => $this->session->userdata('user_id'),
              //                           'student_id' => 0,
              //                           'page' => 'Billapprove',
              //                           'remarks' => 'Updation of Bill of ID:'.$param2,
              //                       );
              //           $this->dbconnection->insert("auditntrail", $audit);
              //   }
                
	}

	public function delete() {
		if(! $this->input->is_ajax_request() || substr($this->right_access, 3, 1) != 'D') {
			redirect('404');
		}
		$apply_id_string=$this->input->post('apply_id_string');
		foreach ($apply_id_string as $val) {
			$q=$this->dbconnection->update('leave_apply_approve',array('status'=>0,'modified_by'=>$this->session->userdata('user_id'),'date_modified'=>date('Y-m-d H:i:s')),'id='.$val);                       
		
                        if($q){

                                $audit = array(
                                                "action" => 'Delete Leave Application',
                                                "module" => "Leave Module",
                                                'datetime' => date("Y-m-d H:i:s"),
                                                'userid' => $this->session->userdata('user_id'),
                                                'student_id' => 0,
                                                'page' => 'Billapprove',
                                                'remarks' => 'Deletion of Leave Application of ID:'.$val,
                                            );
                                $this->dbconnection->insert("auditntrail", $audit);
                        }
                        
                }
	}

	public function get_student_information()
	{
		if(! $this->input->is_ajax_request()) {
			redirect('404');
		}

		$student_admno=$this->input->post('code');
		$this->dbconnection->fetch_information('student','admission_no',$student_admno,'first_name','middle_name','last_name');
	}

	public function get_item_information()
	{
		if(! $this->input->is_ajax_request()) {
			redirect('404');
		}

		$store_items_info=$this->input->post('dataitem');
		$this->data['get_store_item'] = $this->dbconnection->select('store_items', '*');
	//	$this->dbconnection->fetch_information('store_items','id',$store_items_info,'qnty_curr', 'sell_price', 'disc_amt');
	}

	public function fetch_data_edit_time()
	{
		if(! $this->input->is_ajax_request()) {
			redirect('404');
		}

		$apply_id=$this->input->post('id');
		$this->dbconnection->fetch_information('leave_apply_approve','id',$apply_id,'remarks','reason');

	}
        
	public function fetch_leave_details() {
                if(! $this->input->is_ajax_request()) {
			redirect('404');
		}
                
                $query=array();
                $emp_id=$this->input->post('empl_id');                
                $query=$this->dbconnection->select('employee_leave','*,(select leave_type_code from leave_type where id=leave_type_id) as leave_type_name','employee_id='.$emp_id);
                $return='';
                $return .='<table class="table table-bordered table-striped" id="toapply_leave_details_tbl">';
                $return .='<thead><tr><td colspan="4" style="text-align:center;font-size: 18px;border-bottom:1px solid grey">Leave Details</td></tr><tr><th>Leave Type</th><th>Opening Leave</th><th>Taken Leave</th><th>Available Leave</th></tr></thead>';
                $return .='<tbody>';
                $cnt=0;
                foreach($query as $row) {
//                    $return .='<tr style="background-color: #f9f9f9;">';
                    $return .='<tr>';
                    $return .='<td>'.$row->leave_type_name.'</td>';
                    $return .='<td id="op_leave">'.$row->opening_leave.'</td>';
                    $return .='<td>'.$row->taken_leave.'</td>';
                    $return .='<td id="bal_leave_'.$row->leave_type_id.'">'.$row->balance_leave.'</td>';
                    $return .='</tr>';
                    $cnt++;
                }
                $return .='</tbody></table>';
                
                $d=array($return,$cnt);
                echo json_encode($d);
        }

	public function saveRecs() {
	//** This function is call from BILLCREATE_VIEW page to save the records **
		
		if ($this->right_access[0] != 'C') {
			redirect('404');
		}

		if (count($this->input->post('pro')) == 0) {
			echo 0;
		} else {
			$bill_amount = 0;
			for ($i = 0; $i < count($this->input->post('pro')); $i++) {
				if ($i == 0){
					$fieldhdr = array(
						'admission_no'	=> $this->input->post('admission_no'),
						'bill_date'		=> $this->input->post('bill_date'),
						'created_by' 		=> $this->session->userdata('user_id')   //$_SERVER['REMOTE_ADDR']
					);
					$this->dbconnection->insert('store_bill_hdr', $fieldhdr);
					$bill_id = $this->db->insert_id();
				}
				
				$field = array(
						'bill_id'			=> $bill_id,
						'item_id'			=> $this->input->post('pro')[$i],
						'item_qty' 		=> $this->input->post('qty')[$i],
						'created_by' 		=> $this->session->userdata('user_id') 
					);

				$bill_amount = $bill_amount + 3;
				$this->dbconnection->insert('store_bill_details', $field);
				$last_id = $this->db->insert_id();

			//** This part of code updates QNTY_CURR & ALERT columns in STORE_ITEMS table for each new record in STORE_ITEMS_RECEIVED table **
			
				$prev_qnty = $this->dbconnection->select('store_items', 'qnty_min, qnty_curr, qnty_alert', 'id=' . $this->input->post('pro')[$i]);
				foreach ($prev_qnty as $row) {
					$old_qnty = $row->qnty_curr;
					$old_min  = $row->qnty_min;
					$old_alert = $row->qnty_alert;
				}

				if ($old_alert == 'Y') {    // (ENUM 'N') = 2
					$this->dbconnection->update('store_items', array('qnty_curr' 	=> $old_qnty - $this->input->post('qty')[$i]), array('id' => $this->input->post('pro')[$i]));
				}
				else {
				
					if ($old_min >= ($old_qnty - $this->input->post('qty')[$i])) {
						$this->dbconnection->update('store_items', array('qnty_curr' 	=> $old_qnty - $this->input->post('qty')[$i]), array('id' => $this->input->post('pro')[$i]));
					} else {
						$this->dbconnection->update('store_items', array(	
															'qnty_curr' 	=> $old_qnty - $this->input->post('qty')[$i],
															'qnty_alert' 	=> 'Y'),
															array('id' => $this->input->post('pro')[$i])
											);
					}
				}
			//** STORE_ITEMS update --> ends here
			}
		
			$this->dbconnection->update('store_bill_hdr', array('bill_amt'	=> $bill_amount), array('id' => $bill_id));  	// to update BILL_AMT in STORE_BILL_HDR table 
			
			$fieldacc = array(
						'admission_no'	=> $this->input->post('admission_no'),
						'amt_charged'		=> $this->input->post('bill_amount'),
						'remarks' 		=> 'Bill No. : ' . $bill_id
					);
			$this->dbconnection->insert('student_acc_book', $fieldacc);	//to insert a record in STUDENT_ACC_BOOK table for accounting purpose and reporting

		}
		
	//Audit Trail
		$audit = array("action" => 'Insert',
				"module" => "Store Management",
				'datetime' => date("Y-m-d H:i:s"),
				'userid' => $this->session->userdata('user_id'),
				'page' => 'Store_Bill_Hdr',
				'remarks' => ''
				);
		$this->dbconnection->insert("auditntrail", $audit);
		echo 1;
	}
	
	public function fetch_bill_items() {
              if(! $this->input->is_ajax_request()) {
			redirect('404');
		}
              $bill_id	= $this->input->post('bill_id');
  //            $leave_type=$this->input->post('leave_type');
              $query	= $this->dbconnection->select('store_bill_details', '*', 'employee_id=' . $bill_id);
              $return	= '';
              $return 	.= '<table class="table table-bordered table-striped" id="toapprove_bill_details_tbl">';
              $return 	.= '<thead><tr><td colspan="6" style="text-align:center;font-size: 18px;border-bottom:1px solid grey">Bill Items</td></tr><tr><th>Item Name</th><th>Regular Price</th><th>Discount</th><th>Sell Price</th><th>Qty Received</th><th>Amount</th></tr></thead>';
              $return 	.= '<tbody>';
              
		foreach($query as $row) {
//                    $return .='<tr style="background-color: #f9f9f9;">';
			$return .='<tr>';
			$return .='<td id="item_id">' . $row->item_id . '</td>';
			$return .='<td id="reg_price">' . $row->reg_price . '</td>';
			$return .='<td id="disc_amt">' . $row->disc_amt . '</td>';
			$return .='<td id="sell_price">' . $row->sell_price . '</td>';
			$return .='<td id="item_qty">' . $row->item_qty . '</td>';
			$return .='<td id="item_amt">' . $row->item_amt . '</td>';
			$return .='</tr>';
              }
              $return .= '</tbody></table>';
              echo $return;
        }

        public function fetch_bill_details()
        {
        	if(! $this->input->is_ajax_request()) {
			redirect('404');
		}

		$student_admno=$this->input->post('code');
		$this->dbconnection->fetch_information('store_bill_hdr','admission_no',$student_admno,'*');
        }
        public function update()
        {
			$bill_id=$this->input->post('bill_id');
			$adm_no=$this->input->post('adm_no');
			$date=$this->input->post('date');
			$amount=$this->input->post('amount');
			$date1=$this->input->post('date1');
			$approver1=$this->input->post('approver1');
			$comment1=$this->input->post('comment1');
			$date2=$this->input->post('date2');
			$approver2=$this->input->post('approver2');
			$comment2=$this->input->post('comment2');
			$date3=$this->input->post('date3');
			$approver3=$this->input->post('approver3');
			$comment3=$this->input->post('comment3');
			$final_status=$this->input->post('final_status');
			$final_comment=$this->input->post('final_comment');

			$update=$this->db->query("UPDATE store_bill_hdr SET admission_no='$adm_no',bill_date='$date',bill_amt='$amount',date_approved1='$date1',approved1_by='$approver1',approve1_comment='$comment1',date_approved2='$date2',approved2_by='$approver2',approve2_comment='$comment2',date_approved3='$date3',approved3_by='$approver3',approve3_comment='$comment3',final_status='$final_status',final_comment='$final_comment' WHERE id='$bill_id' ");
			if ($update) {
			redirect('store/Billapprove');
			}
        }
}
