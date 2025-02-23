<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leave_application extends CI_Controller 
{
        public $page_code = 'leave_apply';
        public $page_id = '';
        public $page_perm = '----';
        
	public function __construct() 
        {
		parent::__construct();
                
                $this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");
             
                $this->id=$this->session->userdata('school_id');
                $this->academic_session=array();
                $this->school_desc=$this->dbconnection->select("school","*", "id=".$this->id." and status = 1");
                $this->schools=$this->dbconnection->select("school","*",'status = 1');
                $this->bank=$this->dbconnection->select("bank","*");
                
                if ($this->id !=0 ) {
                    $this->db->db_select('crmfeesclub_'.$this->id);                 
                    $this->academic_session=$this->dbconnection->select("accedemic_session","max(id) as fin_year","active='Y'");
                }
                
                $permission = $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
                $this->page_perm = !empty($permission) ? $permission[0]->permission : '----';
                $this->right_access = $this->page_perm;

                if (strpos($this->page_perm, '----') == true) {
                    redirect(base_url(''), 'refresh');
                }

		$this->page_title = 'Leave Application';
		$this->section = 'hr/leave';
		$this->page_name = 'leave_application';
		$this->customview = '';
	}

	public function index()
	{
            
                if (substr($this->right_access, 1, 1) != 'R') {
        //            redirect(base_url(), 'refresh');
                    redirect('404');
                }
		$this->data['page_name'] = $this->page_name;
		$this->data['page_title'] = $this->page_title;
		$this->data['section'] = $this->section;
		$this->data['customview'] = $this->customview;
		$this->data['right_access'] = $this->right_access;
		$this->data['fetch_employee'] = $this->dbconnection->select('employee','id,employee_code','status=1');
		$this->data['fetch_designation'] = $this->dbconnection->select('employee_designation','id,designation_desc','status=1');
		$this->data['fetch_leave_type'] = $this->dbconnection->select('leave_type','id,leave_type_code,loss_of_pay','status=1');
                if($this->session->userdata('login_type')=='admin'|| $this->session->userdata('login_type')=='principal'||$this->session->userdata('login_type')=='hr') {
                    $this->data['session_employee_id']='';
                    $this->data['leave_apply_approve'] = $this->dbconnection->select_order('leave_apply_approve','*,'
					. '(select employee_code from employee where id=leave_apply_approve.emp_id) as emp_code,'
					. '(select name from employee where id=leave_apply_approve.emp_id) as emp_name,'
					. '(select designation_id from employee where id=leave_apply_approve.emp_id) as emp_desg,'
					. '(select leave_type_code from leave_type where id=leave_type_id) as leave_id,'
					. '(select user_name from user where id=created_by) as applied_by,'
					. '(select user_name from user where id=approved_by) as approved','status=1','id','ASC');
                } else{
                    
                    $getempid=$this->dbconnection->select("user","employee_id","id=".$this->session->userdata('user_id'));
                    $this->data['session_employee_id']=$getempid[0]->employee_id;
                    $this->data['leave_apply_approve'] = $this->dbconnection->select_order('leave_apply_approve','*,'
					. '(select employee_code from employee where id=leave_apply_approve.emp_id) as emp_code,'
					. '(select name from employee where id=leave_apply_approve.emp_id) as emp_name,'
					. '(select designation_id from employee where id=leave_apply_approve.emp_id) as emp_desg,'
					. '(select leave_type_code from leave_type where id=leave_type_id) as leave_id,'
					. '(select user_name from user where id=created_by) as applied_by,'
					. '(select user_name from user where id=approved_by) as approved','status=1 and emp_id='.$getempid[0]->employee_id,'id','ASC');   
                }

		$this->load->view('index', $this->data);
	}

	public function save() {
        if(! $this->input->is_ajax_request()  || substr($this->right_access, 0, 1) != 'C') {
			redirect('404');
		}
		$data=array(
				'emp_id' => $this->input->post('employee_code'),                          
				'from_date' => $this->input->post('applicable_from'),                                                                                 
				'to_date' => $this->input->post('applicable_to'),                                                                                 
				'no_of_days' => $this->input->post('nodays'),                                                                                 
				'leave_type_id' => $this->input->post('leave_type'),                                                                                 
				'reason' => $this->input->post('reason'),                                                                                 
//				'remarks' => $this->input->post('remarks'), 
                'academic_year_id'=> $this->academic_session[0]->fin_year,
				'created_by' => $this->session->userdata('user_id'),  

			   );
		$q=$this->dbconnection->insert('leave_apply_approve', $data);
		$leave_apply_id = $this->dbconnection->get_last_id();
                
                if($q){
                    
                        $audit = array(
                                        "action" => 'Add Leave Application',
                                        "module" => "Leave Module",
                                        'datetime' => date("Y-m-d H:i:s"),
                                        'userid' => $this->session->userdata('user_id'),
                                        'student_id' => 0,
                                        'page' => 'leave_application',
                                        'remarks' => 'Creation of Leave Applicaion of ID:'.$leave_apply_id,
                                    );
                        $this->dbconnection->insert("auditntrail", $audit);
                }
                
                
	}

	public function update() {
		if(! $this->input->is_ajax_request() || substr($this->right_access, 2, 1) != 'U') {
			redirect('404');
		}
		$data=array(
				'emp_id' => $this->input->post('employee_code'),                          
				'from_date' => $this->input->post('applicable_from'),                                                                                 
				'to_date' => $this->input->post('applicable_to'),                                                                                 
				'no_of_days' => $this->input->post('nodays'),                                                                                 
				'leave_type_id' => $this->input->post('leave_type'),                                                                                 
				'reason' => $this->input->post('reason'),                                                                                 
//				'remarks' => $this->input->post('remarks'),                                                                                 
				'modified_by' => $this->session->userdata('user_id'),  
				'date_modified' => date('Y:m:d H:i:s'),  

			   );
		$q=$this->dbconnection->update('leave_apply_approve',$data,"id=$param2");
                if($q){
                    
                        $audit = array(
                                        "action" => 'Update Leave Application',
                                        "module" => "Leave Module",
                                        'datetime' => date("Y-m-d H:i:s"),
                                        'userid' => $this->session->userdata('user_id'),
                                        'student_id' => 0,
                                        'page' => 'leave_application',
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
                                                'page' => 'leave_application',
                                                'remarks' => 'Deletion of Leave Application of ID:'.$val,
                                            );
                                $this->dbconnection->insert("auditntrail", $audit);
                        }
                        
                }
	}

	public function get_employee_information()
	{
		if(! $this->input->is_ajax_request()) {
			redirect('404');
		}

		$employee_id=$this->input->post('code');
		$this->dbconnection->fetch_information('employee','id',$employee_id,'name','designation_id');

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
