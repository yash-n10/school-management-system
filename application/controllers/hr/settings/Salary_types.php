<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salary_types extends MY_ListController
{
        public $page_code = 'salary_types';
        public $page_id = '';
        public $page_perm = '----';
        
	public function __construct()
	{
                $this->page_code = 'salary_types';
		parent::__construct();

		
                
                $this->academic_session=array();
                if ($this->id !=0 ) {                
                    $this->academic_session=$this->dbconnection->select("accedemic_session","max(id) as fin_year","active='Y'");
                }
                
		$this->page_title = 'Salary Types';
		$this->rec_type = 'Salary Type';
		$this->rec_types = 'Salary Types';
		$this->section = 'hr/payroll';
		$this->dbtable = 'salary_type';
		$this->display_columns = array('id' => 'ID', 'salary_code' => 'Salary Code', 'salary_name' => 'Salary Name', 'salary_typ_disp' => 'Earning/Deduction','wages_type' => 'Wages type',
                    'percent_or_amt' => '%/Amt'
				);
		$this->edit_columns = array(
				'salary_code' => array('disp' => 'Salary Code', 'type' => 'text', 'required' => TRUE, 'maxlength' => 20),
				'salary_name' => array('disp' => 'Salary Name', 'type' => 'text', 'required' => TRUE, 'maxlength' => 40),
				'salary_typ' => array('disp' => 'Earning/Deduction', 'type' => 'select','required' => TRUE, 'select_opts' => array(
							(object) array('opt_id' => '1', 'opt_disp' => 'Earning'),
							(object) array('opt_id' => '2', 'opt_disp' => 'Deduction (Employee Contribution)'),
							(object) array('opt_id' => '3', 'opt_disp' => 'Deduction (Employer Contribution)'),
							(object) array('opt_id' => '4', 'opt_disp' => 'CTC'),
							),'serverRules' => 'required',
                                    ),
                                'wages_type' => array('disp' => 'Wages Type', 'type' => 'select','required' => TRUE, 'select_opts' => array(
							(object) array('opt_id' => 'GROSS', 'opt_disp' => 'GROSS'),
							(object) array('opt_id' => 'BA+DA', 'opt_disp' => 'Basic + DA'),
							(object) array('opt_id' => 'BA+DA+HRA+TA+SA', 'opt_disp' => 'Basic + DA + HRA + TA + SA'),
                            (object) array('opt_id' => 'BA', 'opt_disp' => 'Basic'),
                            (object) array('opt_id' => 'FIXED', 'opt_disp' => 'FIXED'),
							),'serverRules' => 'required'
                                    ),
                                'percent_or_amt' =>array('disp' => '%/Amt', 'type' => 'number',  'maxlength' => 10, 'step'=>"0.001",'serverRules' => 'trim|required'),   
						);
                $this->extra_add_columns = array('created_by'=>$this->session->userdata('user_id'),'academic_year_id'=> $this->academic_session[0]->fin_year);
                $this->extra_edit_columns = array('last_modified_by'=>$this->session->userdata('user_id'),'last_date_modified'=>date('Y-m-d H:i:s'));

		$this->search_columns = array(
				'alpha_num' => array(
					'salary_code',
					'salary_name',
					),
				'numeric' => array(  
                                        
					),
				);
		$this->rec_key = 'id';
		$this->data_table = $this->dbtable . ' AS t1';
		$this->data_select = 'id, salary_code, salary_name, salary_typ, (CASE salary_typ WHEN 1 THEN "Earning" WHEN 2 THEN "Deduction (Employee Contribution)" WHEN 3 THEN "Deduction (Employer Contribution)" WHEN 4 THEN "CTC" END) AS salary_typ_disp,wages_type,percent_or_amt';
		$this->data_select_where = 'status=1';
		$this->data_delete = 'UPDATE';
		$this->data_delete_update = array('status' => '0');
	}
}
