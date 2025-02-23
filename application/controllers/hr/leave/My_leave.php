<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_leave extends CI_Controller {

        public $page_code = 'my_leave';
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
		$this->page_name = 'my_leave';
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
		$getempid=$this->dbconnection->select("user","employee_id","id=".$this->session->userdata('user_id'));
                $this->data['employee_id']=$getempid[0]->employee_id;
                $getempgrp=$this->dbconnection->select("employee","leave_group","id=".$getempid[0]->employee_id);
                $leavegrp= !empty($getempgrp) ?  $getempgrp[0]->leave_group: 0;
                $this->data['query']=$this->dbconnection->select('employee_leave','*,(select leave_type_code from leave_type where id=leave_type_id) as leave_type_name','employee_id='.$getempid[0]->employee_id);
                $this->data['query_grp']=$this->dbconnection->select('leave_entitlement','leave_id,total_allowed,(select leave_type_code from leave_type where id=leave_id) as leave_type_name','leave_group_id='.$leavegrp.' and allowed="Y"');
		$this->load->view('index', $this->data);
	}
}
