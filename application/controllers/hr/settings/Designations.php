<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Designations extends MY_ListController
{
	public function __construct()
	{
                $this->page_code = 'hr_designation';
		parent::__construct();

//		switch($this->session->userdata('login_type')){
//                    case 'appadmin':
//                                        $this->right_access = 'CRUD';
//                                        break;
//                    case 'admin':
//                                        $this->right_access = 'CRUD';
//                                        break;
//                    case 'principal':
//                                        $this->right_access = '-R--';
//                                        break;
//                    case 'hr':
//                                        $this->right_access = 'CRUD';
//                                        break;
//                    default:
//                                        $this->right_access = '----';
//                                        redirect(base_url(), 'refresh');
//                }
                
                $this->academic_session=array();
                if ($this->id !=0 ) {                
                    $this->academic_session=$this->dbconnection->select("accedemic_session","max(id) as fin_year","active='Y'");
                }
                
		$this->page_title = 'Designations';
		$this->rec_type = 'Designation';
		$this->rec_types = 'Designations';
		$this->section = 'hr/staff';
		$this->dbtable = 'employee_designation';
		$this->display_columns = array('id' => 'ID', 'designation_desc' => 'Designation Name', 
				);
		$this->edit_columns = array(
				'designation_desc' => array('disp' => 'Designation Name', 'type' => 'text', 'required' => TRUE),
				);
                $this->extra_add_columns = array('created_by'=>$this->session->userdata('user_id'),'academic_year_id'=> $this->academic_session[0]->fin_year);
                $this->extra_edit_columns = array('modified_by'=>$this->session->userdata('user_id'),'date_modified'=>date('Y-m-d H:i:s'));

		$this->search_columns = array(
				'alpha_num' => array(
					'designation_desc',
					),
				'numeric' => array(
					),
				);
		$this->rec_key = 'id';
		$this->data_table = $this->dbtable . ' AS t1';
		$this->data_select = 'id, designation_desc';
		$this->data_select_where = 'status=1';
		$this->data_delete = 'UPDATE';
		$this->data_delete_update = array('status' => '0');
	}
}
