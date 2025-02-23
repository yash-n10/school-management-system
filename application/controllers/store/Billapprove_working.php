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

              //  $this->academic_session=array();
              //  $this->school_desc	= $this->dbconnection->select("school","*", "id=".$this->id." and status = 1");
              //  $this->schools	  	= $this->dbconnection->select("school","*",'status = 1');
              //  $this->bank			= $this->dbconnection->select("bank","*");
                
  /*              if ($this->id !=0 ) {
                    $this->db->db_select('crmfeesclub_'.$this->id);                 
                    $this->academic_session=$this->dbconnection->select("accedemic_session","max(id) as fin_year","active='Y'");
                } */
                
                $permission = $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
                $this->page_perm = !empty($permission) ? $permission[0]->permission : '----';
                $this->right_access = $this->page_perm;

                if (strpos($this->page_perm, '----') == true) {
                    redirect(base_url(''), 'refresh');
                }

		$this->page_title = 'Bill Process';
		$this->section = 'store';
		$this->page_name = 'billapprove_view';
		$this->customview = '';
	}

	public function index()
	{
	//	print_r(($this->right_access[1] == 'R')); die();
		if (($this->right_access[1] == 'R') != 1) {
			redirect('404');
		}
	
		$this->data['page_name'] 	= $this->page_name;
		$this->data['id'] 			= $this->id;
		$this->data['page_title'] 	= $this->page_title;
		$this->data['section'] 		= $this->section;
		$this->data['customview'] 	= $this->customview;
		$this->data['navi'] 		= 'billapprove_view';    //'store';
//print_r($this->data['page_name'] ); print_r($this->data['navi'] ); die();
		$this->data['right_access'] 	= $this->right_access;

		$this->data['fetch_student'] 	= $this->dbconnection->select('student', 'id, admission_no, first_name, middle_name, last_name', 'status=1');
//print_r(count($this->data['fetch_student']) ); print_r($this->data['navi'] ); die();

 
       //       if($this->session->userdata('login_type')=='admin'|| $this->session->userdata('login_type')=='principal'||$this->session->userdata('login_type')=='hr') {
	//		$this->data['session_student_id']='';
                     $this->data['bills_approve'] = $this->dbconnection->select_order('bills_approve','*,'
					. '(select admission_no from student where admission_no=bills_approve.student_enrol_id) as adm_no,'
					. '(select first_name from student where admission_no=bills_approve.student_enrol_id) as student_fname,'
					. '(select middle_name from student where admission_no=bills_approve.student_enrol_id) as student_midname,'
					. '(select last_name from student where admission_no=bills_approve.student_enrol_id) as student_lname,'
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

	public function add_details() {
		
		if ($this->right_access[0]  != 'C') {
			redirect('404');
		}
			
		$result = $this->dbconnection->insert('bills_approve', array(
				'student_enrol_id' 		=> $this->input->post('student_enrol_id'),                          
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
				'student_enrol_id' 		=> $this->input->post('student_enrol_id'),                          
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
		$q=$this->dbconnection->insert('bills_approve', $data);
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

	public function update_details() {
  //      if(! $this->input->is_ajax_request()  || substr($this->right_access, 0, 1) != 'C') {
		if($this->right_access[0]  != 'U') {
			redirect('404');
		}
		
		$details_id = $this->uri->segment(4);
		$this->dbconnection->update('store_items', array(	
													'student_enrol_id' 	=> $this->input->post('student_enrol_id'),
													'bill_date' 	=> $this->input->post('bill_date'),
													'approve1_comment' 	=> $this->input->post('approve1_comment'),
													'approved1_by'	=> $this->input->post('approved1_by'),
													'last_modified_by' 	=> $this->session->userdata('user_id'),	
													'date_modified' 	=> date()),
												array('id' => $details_id)
								);
  }
  
/*		$data=array(
				'student_enrol_id' 		=> $this->input->post('student_enrol_id'),                          
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
		$q=$this->dbconnection->insert('bills_approve', $data);
		$leave_apply_id = $this->dbconnection->get_last_id();  */

	public function update() {
		if(! $this->input->is_ajax_request() || substr($this->right_access, 2, 1) != 'U') {
			redirect('404');
		}
		$data=array(
				'student_enrol_id' 		=> $this->input->post('student_enrol_id'),                          
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
		
		$q=$this->dbconnection->update('bills_approve',$data,"id=$param2");
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
}
