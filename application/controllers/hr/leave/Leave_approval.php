<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leave_approval extends CI_Controller 
{
        public $page_code = 'leave_approve';
        public $page_id = '';
        public $page_perm = '----';
        
	public function __construct() 
        {
		parent::__construct();
                
                $this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");
               
                $this->id=$this->session->userdata('school_id');
                $this->school_desc=$this->dbconnection->select("school","*", "id=".$this->id." and status = 1");
                $this->schools=$this->dbconnection->select("school","*",'status = 1');
                $this->bank=$this->dbconnection->select("bank","*");
                
                if ($this->id != 0) $this->db->db_select('crmfeesclub_'.$this->id);

                $permission = $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
                $this->page_perm = !empty($permission) ? $permission[0]->permission : '----';
                $this->right_access = $this->page_perm;

                if (strpos($this->page_perm, '----') == true) {
                    redirect(base_url(''), 'refresh');
                }
        
		$this->page_title = 'Leave Approval';
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
                $getempid=$this->dbconnection->select("user","employee_id","id=".$this->session->userdata('user_id'));
                $this->data['session_employee_id']=$getempid[0]->employee_id;
		$this->data['leave_apply_approve'] = $this->dbconnection->select_order('leave_apply_approve','*,'
					. '(select employee_code from employee where id=leave_apply_approve.emp_id) as emp_code,'
					. '(select name from employee where id=leave_apply_approve.emp_id) as emp_name,'
					. '(select designation_id from employee where id=leave_apply_approve.emp_id) as emp_desg,'
					. '(select leave_type_code from leave_type where id=leave_type_id) as leave_id,'
					. '(select user_name from user where id=created_by) as applied_by,'
					. '(select user_name from user where id=approved_by) as approved','status=1','id','ASC');

		$this->load->view('index', $this->data);
	}


	public function approve() { //to approve or reject
		if(! $this->input->is_ajax_request() || substr($this->right_access, 0, 1) != 'C' || substr($this->right_access, 2, 1) != 'U' || substr($this->right_access, 3, 1) != 'D') {
			redirect('404');
		}
                $approve_leave=$this->input->post('approve_leave');
		$data=array(                 
                                'leave_status'=>$this->input->post('status'),
                                'approve_comment'=>$this->input->post('comment'), 
				'date_approved' => date('Y:m:d H:i:s'), 
                                'approved_by' => $this->session->userdata('user_id'),  

			   );
		$q=$this->dbconnection->update('leave_apply_approve',$data,"id=$approve_leave");
                
                if($q){

                                $audit = array(
                                                "action" => 'Leave Approve',
                                                "module" => "Leave Module",
                                                'datetime' => date("Y-m-d H:i:s"),
                                                'userid' => $this->session->userdata('user_id'),
                                                'student_id' => 0,
                                                'page' => 'leave_application',
                                                'remarks' => ' Leave '. $this->input->post('status').' of ID:'.$approve_leave,
                                            );
                                $this->dbconnection->insert("auditntrail", $audit);
                        }
                if($this->input->post('status')=='APPROVED') {
                    $no_of_days=$this->input->post('toapprove_nodays');
                    $this->db->set('taken_leave','taken_leave+'.$no_of_days,FALSE);
                    $this->db->set('balance_leave','balance_leave-'.$no_of_days,FALSE);
                    $this->db->where('employee_id', $this->input->post('toapprove_employee_code'));
                    $this->db->where('leave_type_id', $this->input->post('toapprove_leave_type'));
                    $q1=$this->db->update('employee_leave');
                    
                    if($q1){

                                $audit = array(
                                                "action" => 'Employee Leave deduction',
                                                "module" => "Leave Module",
                                                'datetime' => date("Y-m-d H:i:s"),
                                                'userid' => $this->session->userdata('user_id'),
                                                'student_id' => 0,
                                                'page' => 'leave_application',
                                                'remarks' => ' Deduction of Employee Leave of Leave applyID:'.$approve_leave,
                                            );
                                $this->dbconnection->insert("auditntrail", $audit);
                        }
//                    $this->dbconnection->update('employee_leave',array('taken_leave'=>'`taken_leave`+1','balance_leave'=>'`balance_leave`-1'),"employee_id=".$this->input->post('toapprove_employee_code')." and leave_type_id=".$this->input->post('toapprove_leave_type'));
                }
	}
        
        public function cancel() { //cancel -> approve or reject
            
		if(! $this->input->is_ajax_request() || substr($this->right_access, 3, 1) != 'D') {
			redirect('404');
		}
                $approve_leave=$this->input->post('approve_leave');
		$data=array(                 
                                'leave_status'=>$this->input->post('status'),
                                'remarks'=>$this->input->post('comment'), 
				'date_approved' => date('Y:m:d H:i:s'), 
                                'approved_by' => $this->session->userdata('user_id'),  

			   );
		$q=$this->dbconnection->update('leave_apply_approve',$data,"id=$approve_leave");
                if($q){

                                $audit = array(
                                                "action" => 'Leave Cancel',
                                                "module" => "Leave Module",
                                                'datetime' => date("Y-m-d H:i:s"),
                                                'userid' => $this->session->userdata('user_id'),
                                                'student_id' => 0,
                                                'page' => 'leave_application',
                                                'remarks' => ' Leave '. $this->input->post('status').' of ID:'.$approve_leave,
                                            );
                                $this->dbconnection->insert("auditntrail", $audit);
                        }
                
                    $no_of_days=$this->input->post('toapprove_nodays');
                    $this->db->set('taken_leave','taken_leave-'.$no_of_days,FALSE);
                    $this->db->set('balance_leave','balance_leave+'.$no_of_days,FALSE);
                    $this->db->where('employee_id', $this->input->post('toapprove_employee_code'));
                    $this->db->where('leave_type_id', $this->input->post('toapprove_leave_type'));
                    $q1=$this->db->update('employee_leave');
                    if($q1){

                                $audit = array(
                                                "action" => 'Employee Leave deduction',
                                                "module" => "Leave Module",
                                                'datetime' => date("Y-m-d H:i:s"),
                                                'userid' => $this->session->userdata('user_id'),
                                                'student_id' => 0,
                                                'page' => 'leave_application',
                                                'remarks' => ' Deduction of Employee Leave of Leave applyID:'.$approve_leave,
                                            );
                                $this->dbconnection->insert("auditntrail", $audit);
                        }
//                    $this->dbconnection->update('employee_leave',array('taken_leave'=>'`taken_leave`+1','balance_leave'=>'`balance_leave`-1'),"employee_id=".$this->input->post('toapprove_employee_code')." and leave_type_id=".$this->input->post('toapprove_leave_type'));
               
	}
        
        public function fetch_leave_details() {
                if(! $this->input->is_ajax_request()) {
			redirect('404');
		}
                $emp_id=$this->input->post('empl_id');
                $leave_type=$this->input->post('leave_type');
                $query=$this->dbconnection->select('employee_leave','*,(select leave_type_code from leave_type where id=leave_type_id) as leave_type_name','employee_id='.$emp_id.' and leave_type_id='.$leave_type);
                $return='';
                $return .='<table class="table table-bordered table-striped" id="toapprove_leave_details_tbl">';
                $return .='<thead><tr><td colspan="4" style="text-align:center;font-size: 18px;border-bottom:1px solid grey">Leave Details</td></tr><tr><th>Leave Type</th><th>Opening Leave</th><th>Taken Leave</th><th>Available Leave</th></tr></thead>';
                $return .='<tbody>';
                foreach($query as $row) {
//                    $return .='<tr style="background-color: #f9f9f9;">';
                    $return .='<tr>';
                    $return .='<td>'.$row->leave_type_name.'</td>';
                    $return .='<td id="op_leave">'.$row->opening_leave.'</td>';
                    $return .='<td>'.$row->taken_leave.'</td>';
                    $return .='<td id="bal_leave">'.$row->balance_leave.'</td>';
                    $return .='</tr>';
                }
                $return .='</tbody></table>';
                echo $return;
        }


}
