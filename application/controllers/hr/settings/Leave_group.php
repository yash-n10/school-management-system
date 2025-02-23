<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leave_group extends CI_Controller 
{
        public $page_code = 'leave_group';
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

		$this->page_title = 'Leave Groups';
		$this->section = 'hr/settings';
		$this->page_name = 'leave_group';
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
		$this->data['fetch_leave'] = $this->dbconnection->select('leave_group','*','status=1');

		$this->load->view('index', $this->data);
	}

	public function add() {
            
                if (substr($this->right_access, 0, 1) != 'C') {
        //            redirect(base_url(), 'refresh');
                    redirect('404');
                }
		$this->data['page_name'] = 'add_leave_group';
		$this->data['page_title'] = $this->page_title;
		$this->data['section'] = $this->section;
		$this->data['customview'] = $this->customview;

		$this->data['task'] = 'Save';
		$this->data['leavegroup_id'] = '';
		$this->data['leavegrp_name'] = '';
		$this->data['applicable_from'] = '';
		$this->data['fetch_leave'] = $this->dbconnection->select('leave_type','id,leave_type_code','status=1');

		$this->load->view('index', $this->data);
	}

	public function edit($param2 = '') {
            
                if (substr($this->right_access, 2, 1) != 'U') {
        //            redirect(base_url(), 'refresh');
                    redirect('404');
                }
		$leavegrp=$this->dbconnection->select('leave_group','leave_group_name,applicable_from',"id=$param2");

		$this->data['page_name'] = 'add_leave_group';
		$this->data['page_title'] = $this->page_title;
		$this->data['section'] = $this->section;
		$this->data['customview'] = $this->customview;

		$this->data['task'] = 'Update';
		$this->data['leavegroup_id'] = $param2;
		$this->data['leavegrp_name'] = $leavegrp[0]->leave_group_name;
		$this->data['applicable_from'] = $leavegrp[0]->applicable_from;
		$this->data['title'] = 'Leave Group';
		$this->data['fetch_leave'] = $this->dbconnection->select('leave_type',"*,(select allowed from leave_entitlement where leave_id=leave_type.id and leave_group_id=$param2) allowed,(select total_allowed from leave_entitlement where leave_id=leave_type.id and leave_group_id=$param2) total_allowed,(select total_allowed_per_month from leave_entitlement where leave_id=leave_type.id and leave_group_id=$param2) total_allowed_per_month,(select carry_frwd from leave_entitlement where leave_id=leave_type.id and leave_group_id=$param2) carry_frwd,(select max_carry_frwd from leave_entitlement where leave_id=leave_type.id and leave_group_id=$param2) max_carry_frwd,(select convrt_to_amount from leave_entitlement where leave_id=leave_type.id and leave_group_id=$param2) convrt_to_amount,(select amount from leave_entitlement where leave_id=leave_type.id and leave_group_id=$param2) amount","status=1");

		$this->load->view('index', $this->data);
	}

	public function save() {
		if(! $this->input->is_ajax_request() || substr($this->right_access, 0, 1) != 'C') {
			redirect('404');
		}
		$data=array(
				'leave_group_name' => $this->input->post('leavegrp_name'),                          
				'applicable_from' => $this->input->post('applicable_from'),                                                                                 
				'academic_year_id'   => $this->academic_session[0]->fin_year,                                                                                  
				'created_by' => $this->session->userdata('user_id'),  
			   );
		$q=$this->dbconnection->insert('leave_group', $data);
		$leave_group_id = $this->dbconnection->get_last_id();
		$this->generate_leave_entitlement($leave_group_id);
                
                if($q){
                    
                        $audit = array(
                                        "action" => 'Add Leave Group',
                                        "module" => "Leave Module",
                                        'datetime' => date("Y-m-d H:i:s"),
                                        'userid' => $this->session->userdata('user_id'),
                                        'student_id' => 0,
                                        'page' => 'add_leave_group',
                                        'remarks' => 'Creation of Leave Group of ID:'.$leave_group_id,
                                    );
                        $this->dbconnection->insert("auditntrail", $audit);
                }
	}

	public function update($param2) {
		if(! $this->input->is_ajax_request() || substr($this->right_access, 2, 1) != 'U') {
			redirect('404');
		}
		$data=array(
				'leave_group_name' => $this->input->post('leavegrp_name'),                          
				'applicable_from' => $this->input->post('applicable_from'),                                                                                 
				'modified_by' => $this->session->userdata('user_id'),  
				'date_modified' => date('Y-m-d H:i:s'),  

			   );
		$this->db->where('id', $param2);
		$q=$this->db->update('leave_group', $data);
		$leave_group_id = $param2;
                
                if($q){
                    
                        $audit = array(
                                        "action" => 'Update Leave Group',
                                        "module" => "Leave Module",
                                        'datetime' => date("Y-m-d H:i:s"),
                                        'userid' => $this->session->userdata('user_id'),
                                        'student_id' => 0,
                                        'page' => 'leave_group',
                                        'remarks' => 'Updation of Leave Group of ID:'.$param2,
                                    );
                        $this->dbconnection->insert("auditntrail", $audit);
                }
		$q1=$this->dbconnection->delete('leave_entitlement',"leave_group_id=$leave_group_id");
                if($q1){
                    
                        $audit = array(
                                        "action" => 'Deletion of  Leave Entitlement',
                                        "module" => "Leave Module",
                                        'datetime' => date("Y-m-d H:i:s"),
                                        'userid' => $this->session->userdata('user_id'),
                                        'student_id' => 0,
                                        'page' => 'add_leave_group',
                                        'remarks' => 'Deletion of Leave Etitlement of Leave group ID:'.$param2,
                                    );
                        $this->dbconnection->insert("auditntrail", $audit);
                }
		$this->generate_leave_entitlement($leave_group_id);
	}

	public function delete() {
		if(! $this->input->is_ajax_request() || substr($this->right_access, 3, 1) != 'D') {
			redirect('404');
		}
		$leave_group_id_string = $this->input->post('leave_group_id_string');
		foreach ($leave_group_id_string as $val) {
			$q1=$this->dbconnection->update('leave_group',array('status'=>0,'modified_by'=>$this->session->userdata('user_id'),'date_modified'=>date('Y-m-d H:i:s')),'id='.$val);                       
		
                        if($q1){
                    
                                $audit = array(
                                                "action" => 'Deletion of  Leave Entitlement',
                                                "module" => "Leave Module",
                                                'datetime' => date("Y-m-d H:i:s"),
                                                'userid' => $this->session->userdata('user_id'),
                                                'student_id' => 0,
                                                'page' => 'add_leave_group',
                                                'remarks' => 'Deletion of Leave Etitlement of ID:'.$val,
                                            );
                                $this->dbconnection->insert("auditntrail", $audit);
                        }
                }
	}

	private function generate_leave_entitlement($leave_group_id) {

		$inputall=$this->input->post();
		for ($i=0; $i<count($inputall['leave_id']); $i++) {
			$data_grid=array(
					'leave_group_id'=>$leave_group_id,
					'leave_id'=>$inputall['leave_id'][$i],
					'total_allowed'=>$inputall['total_allowed'][$i],
					'total_allowed_per_month'=>$inputall['total_allowed_per_month'][$i],
					'allowed'=>$inputall['allowed'][$i],
					'carry_frwd'=>$inputall['carry_frwd'][$i],
					'max_carry_frwd'=>$inputall['max_carry_frwd'][$i],
					'convrt_to_amount'=>$inputall['convert_to_amt'][$i],
					'amount'=>$inputall['amount'][$i],
					);

			$q=$this->dbconnection->insert('leave_entitlement', $data_grid);
                        $last_id = $this->dbconnection->get_last_id();
                        if($q){
                    
                                $audit = array(
                                                "action" => 'Insertion of  Leave Entitlement',
                                                "module" => "Leave Module",
                                                'datetime' => date("Y-m-d H:i:s"),
                                                'userid' => $this->session->userdata('user_id'),
                                                'student_id' => 0,
                                                'page' => 'add_leave_group',
                                                'remarks' => 'Insertion of Leave Etitlement of ID:'.$last_id,
                                            );
                                $this->dbconnection->insert("auditntrail", $audit);
                        }
		}
	}
}
