<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leave_type extends CI_Controller 
{

        public $page_code = 'leave_type';
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
                
		$this->page_title = 'Leave Type';
		$this->section = 'hr/settings';
		$this->page_name = 'leave_type';
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
		$this->data['fetch_leave'] = $this->dbconnection->select('leave_type', '*', 'status != 0');

		$this->load->view('index', $this->data);
	}

	public function save() {
            
            if (substr($this->right_access, 0, 1) != 'C') {
    //            redirect(base_url(), 'refresh');
                redirect('404');
            }
		$data=array(
				'leave_type_code'   => $this->input->post('leave_type_code'),                          
				'leave_type_name'   => $this->input->post('leave_type_name'),                          
				'loss_of_pay'       => $this->input->post('loss_of_pay'),                          
				'half_days_allow'   => $this->input->post('half_days_allow'),                          
				'academic_year_id'   => $this->academic_session[0]->fin_year,                          
				'created_by'        => $this->session->userdata('user_id'),  
			   );

		$this->dbconnection->insert('leave_type', $data);
                $last_id = $this->dbconnection->get_last_id();
                if($q){
                    
                        $audit = array(
                                        "action" => 'Add Leave Type',
                                        "module" => "Leave Module",
                                        'datetime' => date("Y-m-d H:i:s"),
                                        'userid' => $this->session->userdata('user_id'),
                                        'student_id' => 0,
                                        'page' => 'leave_type',
                                        'remarks' => 'Creation of Leave Type of ID:'.$last_id,
                                    );
                        $this->dbconnection->insert("auditntrail", $audit);
                }
                
	}

	public function update($param2) {
            
            if (substr($this->right_access, 2, 1) != 'U') {
    //            redirect(base_url(), 'refresh');
                redirect('404');
            }
		$data=array(
				'leave_type_code' => $this->input->post('leave_type_code'),                          
				'leave_type_name' => $this->input->post('leave_type_name'),                          
				'loss_of_pay' => $this->input->post('loss_of_pay'),                          
				'half_days_allow' => $this->input->post('half_days_allow'),
//                                'academic_year_id'   => $this->academic_session[0]->fin_year,
				'date_modified'=>date('Y-m-d H:i:s'),
				'modified_by' => $this->session->userdata('user_id'),  
			   );

		$this->db->where('id', $param2);
		$q=$this->db->update('leave_type', $data);  
                
                if($q){
                    
                        $audit = array(
                                        "action" => 'Update Leave Type',
                                        "module" => "Leave Module",
                                        'datetime' => date("Y-m-d H:i:s"),
                                        'userid' => $this->session->userdata('user_id'),
                                        'student_id' => 0,
                                        'page' => 'leave_type',
                                        'remarks' => 'Updation of Leave Type of ID:'.$param2,
                                    );
                        $this->dbconnection->insert("auditntrail", $audit);
                }
                
	}

	public function delete() {
            
            if (substr($this->right_access, 3, 1) != 'D') {
    //            redirect(base_url(), 'refresh');
                redirect('404');
            }
		$class_id_string = $this->input->post('leave_type_id_string');
		foreach ($class_id_string as $val) {
			$q=$this->dbconnection->update('leave_type', array('status' => 0, 'modified_by' => $this->session->userdata('user_id'), 'date_modified' => date('Y-m-d H:i:s')), 'id=' . $val);
                        if($q){

                                $audit = array(
                                                "action" => 'Delete Leave Type',
                                                "module" => "Leave Module",
                                                'datetime' => date("Y-m-d H:i:s"),
                                                'userid' => $this->session->userdata('user_id'),
                                                'student_id' => 0,
                                                'page' => 'leave_type',
                                                'remarks' => 'Deletion of Leave Type of ID:'.$val,
                                            );
                                $this->dbconnection->insert("auditntrail", $audit);
                        }
                        
		}
	}
}

