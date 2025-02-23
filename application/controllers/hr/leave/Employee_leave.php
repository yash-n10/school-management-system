<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_leave extends CI_Controller {
    
        public $page_code = 'balance_report';
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
		$this->page_title = 'Leave Balance';
		$this->section = 'hr/leave';
		$this->page_name = 'employee_leave';
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
                $this->data['leave_type']=$this->dbconnection->select("leave_type","id,leave_type_code","status='1'");
//                print_r($this->data['leave_type']);
//                echo '<html><br></html>';
                $employee=$this->dbconnection->select("employee","id,employee_code,name,"
                        . "(select designation_desc from employee_designation where id=designation_id) as desg,"
                        . "leave_group,(select leave_group_name from leave_group where id=employee.leave_group) as leave_grp_name","status=1");
//                print_r($employee);
//                echo '<html><br></html>';
                $opening=array();
                $avail=array();
                $bal=array();
                foreach($employee as $emp) {
                    foreach($this->data['leave_type'] as $lt){
                        $employee_leave=$this->dbconnection->select("employee_leave","employee_id,leave_type_id,opening_leave,taken_leave,balance_leave","employee_id=$emp->id and leave_type_id=$lt->id");
                        if(!empty($employee_leave)){
                            $opening[$emp->id][$lt->id]=$employee_leave[0]->opening_leave;
                            $avail[$emp->id][$lt->id]=$employee_leave[0]->taken_leave;
                            $bal[$emp->id][$lt->id]=$employee_leave[0]->balance_leave;
                        } else{
                            $opening[$emp->id][$lt->id]='--';
                            $avail[$emp->id][$lt->id]='--';
                            $bal[$emp->id][$lt->id]='--';
                        }
                        
                    }
                }
                
//                print_r($employee_leave);
		$this->data['employee']=$employee;
		$this->data['employee_leave']=$employee_leave;
		$this->data['opening']=$opening;
		$this->data['avail']=$avail;
		$this->data['bal']=$bal;
                $this->load->view('index', $this->data);
	}
}
