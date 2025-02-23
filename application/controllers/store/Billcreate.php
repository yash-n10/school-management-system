<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Billcreate extends CI_Controller {
	public $page_code = 'billcreate';
       public $page_id = '';
       public $page_perm = '----';
        
	public function __construct() {
		parent::__construct();
                
              $this->page_id 	= $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");
             
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

		$this->page_title = 'Bills';
		$this->section = 'store';
		$this->page_name = 'billlist_view'; //'billcreate_view';
		$this->customview = '';
	}

	public function index() {
		if (($this->right_access[1] == 'R') != 1) {
			redirect('404');
		}
	
		$this->data['page_name'] 	= $this->page_name;
		$this->data['id'] 			= $this->id;
		$this->data['page_title'] 	= $this->page_title;
		$this->data['section'] 		= $this->section;
		$this->data['customview'] 	= $this->customview;
		$this->data['navi'] 		= 'billlist_view';
		$this->data['right_access'] 	= $this->right_access;

		$this->data['fetch_student'] 	= $this->dbconnection->select('student', 'id, admission_no, first_name, middle_name, last_name', 'status=1');

		if ($this->var_role == 'admin') {
			$this->data['store_bill_hdr'] = $this->dbconnection->select_order('store_bill_hdr','*,'
						. '(select admission_no from student where admission_no=store_bill_hdr.admission_no) as adm_no,'
						. '(select first_name from student where admission_no=store_bill_hdr.admission_no) as student_fname,'
						. '(select middle_name from student where admission_no=store_bill_hdr.admission_no) as student_midname,'
						. '(select last_name from student where admission_no=store_bill_hdr.admission_no) as student_lname,'
						. 'bill_date, date_approved1, approved1_by, approve1_comment, approved2_by, date_approved2,'
						. 'approve2_comment, approved3_by, date_approved3, approve3_comment, final_status, final_comment', 'status=1', 'id', 'ASC');
		} else {
	              $this->data['store_bill_hdr'] = $this->dbconnection->select_order('store_bill_hdr','*,'
					. '(select admission_no from student where admission_no=store_bill_hdr.admission_no) as adm_no,'
					. '(select first_name from student where admission_no=store_bill_hdr.admission_no) as student_fname,'
					. '(select middle_name from student where admission_no=store_bill_hdr.admission_no) as student_midname,'
					. '(select last_name from student where admission_no=store_bill_hdr.admission_no) as student_lname,'
					. 'bill_date, date_approved1, approved1_by, approve1_comment, approved2_by, date_approved2,'
					. 'approve2_comment, approved3_by, date_approved3, approve3_comment, final_status,approved4_by,date_approved4, approver4_comment, final_comment', 'status=1 AND store_type = "' . $this->var_role . '"', 'id', 'ASC');

		}
		$this->load->view('index', $this->data);
	}

	
	public function generate_bill() {
	//** This function is called from the GENERATE BILL button to rediect to another page  **
        
		if (substr($this->right_access, 0, 1) != 'C') {
			redirect('404');
		}

		$this->data['page_name'] 	= 'billcreate_view';
		$this->data['id'] 			= $this->id;
		$this->data['page_title'] 	= 'Create Bill';
		$this->data['section'] 		= 'store';
		$this->data['customview'] 	= '';
		$this->data['right_access'] 	= $this->right_access;

		if ($this->var_role == 'admin') {
			$this->data['arr_items'] = $this->dbconnection->select('store_items', '*');
		} else {
			$str = "store_type='" . $this->var_role . "' and active='Y'";
			$this->data['arr_items'] = $this->dbconnection->select("store_items", "*", $str);
		}


		if ($this->var_role == 'admin') {
			$str = " active='Y'";
			$this->data['arr_store_item'] = $this->dbconnection->select('store_items', '*',$str,'item_name');
		} else {
			$str = "store_type='" . $this->var_role . "' and active='Y'";
			$this->data['arr_store_item'] = $this->dbconnection->select("store_items", "*", $str,'item_name');
		}
		$this->data['employee']=$this->dbconnection->select('employee','employee_code,name','status=1');
		$this->data['fetch_student'] 	= $this->dbconnection->select('student', 'id, admission_no, first_name, middle_name, last_name', 'status=1');
		$this->load->view('index', $this->data);
	}


/*	public function save() {
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
                
                
	}  */


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
 

	public function update() {
		if(! $this->input->is_ajax_request() || substr($this->right_access, 2, 1) != 'U') {
			redirect('404');
		}
		$data=array(
				'admission_no' 		=> $this->input->post('student_enrol_id'),                          
				'academic_year_id' 	=> $this->input->post('academic_year_id'),                                                                                 
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
				'modified_by' 			=> $this->session->userdata('user_id'),  
				'date_modified' 		=> date('Y:m:d H:i:s'),  
			   );
		
		$q=$this->dbconnection->update('store_bill_hdr',$data,"id=$param2");
              if($q){
                        $audit = array(
                                        "action" => 'Add Store Bill',
                                        "module" => "Leave Module",
                                        'datetime' => date("Y-m-d H:i:s"),
                                        'userid' => $this->session->userdata('user_id'),
                                        'student_id' => 0,
                                        'page' => 'Billapprove',
                                        'remarks' => 'Updation of Leave Application of ID:'.$param2,
                                    );
                        $this->dbconnection->insert("auditntrail", $audit);
              }
	}


	public function get_student_information() {
		// if(! $this->input->is_ajax_request()) {
		// 	redirect('404');
		// }

		$student_admno=$this->input->post('code');
		// $student_admno='staff-1';
		$staff=explode('-',$student_admno);
		if($staff[0]=='staff'){
			$student_admno=$staff[1];
		// $this->dbconnection->fetch_information('employee','employee_code',$student_admno,'name');
		$query=$this->dbconnection->select('employee','name as first_name',"employee_code='$student_admno'");
		// $query=$query->result();
		$query=$query[0];
		$query->middle_name='';
		$query->last_name='';
		// print_r($query);die();
		// $query="x,[middle_name]=>'',[last_name]=>''"
		echo json_encode([$query]);
		}
		else{
		$this->dbconnection->fetch_information('student','admission_no',$student_admno,'first_name','middle_name','last_name');
		}
	}


	public function get_item_information() {
		if(! $this->input->is_ajax_request()) {
			redirect('404');
		}
		$store_items_info = $this->uri->segment(4);
		$this->dbconnection->fetch_information('store_items','id',$store_items_info,'qnty_curr', 'sell_price', 'disc_amt');
	}

       
	public function fetch_billitem_details() {
		if(! $this->input->is_ajax_request()) {
			redirect('404');
		}
              $bill_id=$this->input->post('bill_id');
//			console.log( $bill_id);die();

		$query = $this->dbconnection->select_join('store_bill_details','store_bill_details.*, store_items.item_name','bill_id=' . $bill_id,'store_items','store_bill_details.item_id = store_items.id'); //,$join_type=''	
 //               $query=$this->dbconnection->select('store_bill_details','*','bill_id=' . $bill_id); // 'id=' . $this->input->post('pro')
              $return='';
		$tr_id = 0;
              $return .='<table class="table table-bordered table-striped" id="toapprove_bill_details_tbl">';
              $return .='<thead><tr><th>Item Name</th><th>Regular Price</th><th>Discount (in Rs.)</th><th>Sell Price</th><th>Qty Sold</th><th>Amount (in Rs.)</th></tr></thead>';
              $return .='<tbody>';
              foreach($query as $row) {
			$tr_id++;
//                    $return .='<tr style="background-color: #f9f9f9;">';
			$return .='<tr style="padding:0px;" id="tr_"' . $tr_id . '>';
			$return .='<td style="padding:0px;"><input type="text" name="pro' . $tr_id . '" id="pro_' . $tr_id . '" class="form-control" value="' . $row->item_name . '" readonly><input type="hidden" name="bill_detail_id[]" value='.$row->id.' /></td>';
			$return .='<td style="padding:0px; "><input type="number" style= "text-align:right;" min="0" oninput="validity.valid||(value=&quot;&quot;);" name="sprice_bill_detail[]" id="sprice_' . $tr_id . '" class="form-control" onchange="updData(id,value);" value=' . $row->reg_price . '></td>'; 
			$return .='<td style="padding:0px;"><input type="number"  style= "text-align:right;" step="0.01" min="0" oninput="validity.valid||(value=&quot;&quot;);" name="disc_bill_detail[]" id="disc_' . $tr_id . '" class="form-control" onchange="updDatadisc(id,value);" value=' . $row->disc_amt . '></td>';
                     $return .='<td style="padding:0px;"><input type="number"  style= "text-align:right;" name="fprice_bill_detail[]" id="fprice_' . $tr_id . '" class="form-control" value="' . $row->sell_price . '" readonly></td>';
                     $return .='<td style="padding:0px;"><input type="number"  style= "text-align:right;" name="qty' . $tr_id . '" id="qty_' . $tr_id . '" class="form-control" value="' . $row->item_qty . '" readonly></td>';
                     $return .='<td style="padding:0px;"><input type="number"  style= "text-align:right;" name="total_bill_detail[]"id="total_' . $tr_id . '" class="form-control total" value="' . $row->item_amt . '" readonly></td>';
			// $return .='<td style="padding:0px;"><button type="submit" name="submit' . $tr_id . '" id="submit_' . $tr_id . '" class="form-control"  onclick="save(id,value);" value="' . $row->id . '" >Go</td>';
                     $return .='</tr>';
              }
              $return .='</tbody></table>';
              echo $return;
       }


	public function fetch_billitem_details_vu() {
		if(! $this->input->is_ajax_request()) {
			redirect('404');
		}
              $bill_id=$this->input->post('bill_id');
		$query = $this->dbconnection->select_join('store_bill_details','store_bill_details.*, store_items.item_name','bill_id=' . $bill_id,'store_items','store_bill_details.item_id = store_items.id'); //,$join_type=''	

              $return='';
		$tr_id = 0;
              $return .='<table class="table table-bordered table-striped" id="toapprove_bill_details_tbl">';
              $return .='<thead><tr><th>Item Name</th><th>Regular Price</th><th>Discount (in Rs.)</th><th>Sell Price</th><th>Qty Sold</th><th>Amount (in Rs.)</th></tr></thead>';
              $return .='<tbody>';
              foreach($query as $row) {
			$tr_id++;
			$return .='<tr style="padding:0px;" id="tr_"' . $tr_id . '>';
			$return .='<td style="padding:0px;"><input type="text" name="pro' . $tr_id . '" id="pro_' . $tr_id . '" class="form-control" value="' . $row->item_name . '" readonly></td>';
			$return .='<td style="padding:0px;"><input type="text" style= "text-align:right;" name="sprice' . $tr_id . '" id="sprice_' . $tr_id . '" class="form-control" value=' . $row->reg_price . ' readonly></td>'; 
			$return .='<td style="padding:0px;"><input type="text" style= "text-align:right;" name="disc' . $tr_id . '" id="disc_' . $tr_id . '" class="form-control" value=' . $row->disc_amt . ' readonly></td>';
                     $return .='<td style="padding:0px;"><input type="text" style= "text-align:right;" name="fprice' . $tr_id . '" id="fprice_' . $tr_id . '" class="form-control" value="' . $row->sell_price . '" readonly></td>';
                     $return .='<td style="padding:0px;"><input type="text" style= "text-align:right;" name="qty' . $tr_id . '" id="qty_' . $tr_id . '" class="form-control" value="' . $row->item_qty . '" readonly></td>';
                     $return .='<td style="padding:0px;"><input type="text" style= "text-align:right;" name="total' . $tr_id . '" id="total_' . $tr_id . '" class="form-control" value="' . $row->item_amt . '" readonly></td>';
                     $return .='</tr>';
              }
              $return .='</tbody></table>';
              echo $return;
       }

       
	public function fetch_item_details() {
        	$item_id = $this->input->post("item_id");
		$query = $this->db->get_where("store_items",array("id"=>$item_id))->result_array();
		
		if(!empty($query[0])) {
			echo(json_encode($query[0]));
		} else {
			echo 0;
		}	
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
						'store_type'		=> strtoupper($this->var_role),
						'created_by' 		=> $this->session->userdata('user_id')   //$_SERVER['REMOTE_ADDR']
					);
					$this->dbconnection->insert('store_bill_hdr', $fieldhdr);
					$bill_id = $this->db->insert_id();
				}
				
				$field = array(
						'bill_id'			=> $bill_id,
						'item_id'			=> $this->input->post('pro')[$i],
						'reg_price'		=> $this->input->post('sprice')[$i],
						'disc_amt'		=> $this->input->post('disc')[$i],
						'sell_price'		=> $this->input->post('fprice')[$i],
						'item_qty' 		=> $this->input->post('qty')[$i],
						'item_amt' 		=> $this->input->post('total')[$i],
						'created_by' 		=> $this->session->userdata('user_id') 
					);

				$bill_amount = $bill_amount + ($this->input->post('total')[$i]); 
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
						$this->dbconnection->update('store_items', array('qnty_curr' 	=> $old_qnty - $this->input->post('qty')[$i],'qnty_alert' 	=> 'Y'), array('id' => $this->input->post('pro')[$i]));
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
						'amt_charged'		=> $bill_amount,
						'entry_type'		=> 'Store Bill',
						'entry_num'		=> $bill_id,
						'entry_date'		=> $this->input->post('bill_date'),
						'approved'		=> 'N'
//						'remarks' 		=> 'Bill No. : ' . $bill_id
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

		
	public function updateRecs() {
	//** This function is call from BILLLLIST_VIEW page to update the bill records **
		
		// if ($this->right_access[0] != 'U') {
		// 	redirect('404');
		// }
		
		$bill_id 		= $_POST['bill_id_hidden'];
		$bill_detail_id = $_POST['bill_detail_id'];
		$upate_regular_price = $_POST['sprice_bill_detail'];
		$upate_discount	= $_POST['disc_bill_detail'];
		$upate_sell_price 	= $_POST['fprice_bill_detail'];
		$upate_total_price	= $_POST['total_bill_detail'];
		$grand_total = $_POST['bill_amount'];

		for($i=0; $i < count($bill_detail_id); $i++)
		{
			$array_data = array();
			$array_data = array(
					'reg_price'	=>$upate_regular_price[$i],
					'disc_amt'	=>$upate_discount[$i],
					'sell_price'	=>$upate_sell_price[$i],
					'item_amt'	=>$upate_total_price[$i],
				);
			$this->dbconnection->update('store_bill_details',$array_data,array('id'=>$bill_detail_id[$i]));
		}

		$array_data2 = array();
		$array_data2 = array(
					'bill_amt'				=> $grand_total,
					'approved1_by'		=> '',
					'date_approved1'		=> '',
					'approve1_comment'	=> '',
					'approved2_by'		=> '',
					'date_approved2'		=> '',
					'approve2_comment'	=> '',
					'approved3_by'		=> '',
					'date_approved3'		=> '',
					'approve3_comment'	=> '',
					'final_status'			=>'Sent for Approval',
					'date_modified'		=>date("Y-m-d H:i:s")
			);

		$response= $this->dbconnection->update('store_bill_hdr',$array_data2,array('id'=>$bill_id));

		if($response==1)
		{
			return redirect(base_url('store/billcreate'));
		}



		$bill_amount = 0;

		$detid= $this->input->post('detid');

		

	//Audit Trail
		$audit = array("action" => 'Update',
				"module" => "Store Management",
				'datetime' => date("Y-m-d H:i:s"),
				'userid' => $this->session->userdata('user_id'),
				'page' => 'Store_Bill_Hdr',
				'remarks' => ''
				);
		$this->dbconnection->insert("auditntrail", $audit);
		echo 1;

	}

}
