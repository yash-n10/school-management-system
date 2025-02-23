<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Departments extends MY_ListController
{
	public function __construct()
	{
                $this->page_code = 'hr_department';
		parent::__construct();

		
                $this->academic_session=array();
                if ($this->id !=0 ) {                
                    $this->academic_session=$this->dbconnection->select("accedemic_session","max(id) as fin_year","active='Y'");
                }
                
		$this->page_title = 'Departments';
		$this->rec_type = 'Department';
		$this->rec_types = 'Departments';
		$this->section = 'hr/staff';
		$this->dbtable = 'employee_department';
		$this->display_columns = array('id' => 'ID', 'department_desc' => 'Department Name', 
				);
		$this->edit_columns = array(
				'department_desc' => array('disp' => 'Department Name', 'type' => 'text', 'required' => TRUE),
				);
                $this->extra_add_columns = array('created_by'=>$this->session->userdata('user_id'),'academic_year_id'=> $this->academic_session[0]->fin_year);
                $this->extra_edit_columns = array('modified_by'=>$this->session->userdata('user_id'),'date_modified'=>date('Y-m-d H:i:s'));
		$this->search_columns = array(
				'alpha_num' => array(
					'department_desc',
					),
				'numeric' => array(
					),
				);
		$this->rec_key = 'id';
		$this->data_table = $this->dbtable . ' AS t1';
		$this->data_select = 'id, department_desc';
		$this->data_select_where = 'status=1';
		$this->data_delete = 'UPDATE';
		$this->data_delete_update = array('status' => '0');
	}
}
