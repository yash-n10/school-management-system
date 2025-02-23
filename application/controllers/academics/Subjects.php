<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subjects extends MY_ListController
{
	public function __construct()
	{
                $this->page_code = 'subjects';
		parent::__construct();

	
                $this->academic_session=$this->dbconnection->select("accedemic_session","max(id) as fin_year","active='Y'");
		$this->page_title = 'Subjects';
		$this->rec_type = 'Subject';
		$this->rec_types = 'Subjects';
		$this->section = 'academic';
		$this->dbtable = 'subject';
		$this->display_columns = array('id' => 'ID', 'name' => 'Subject Name');
		$this->edit_columns = array(
				'name' => array('disp' => 'Subject Name', 'type' => 'text', 'required' => TRUE,'duplication_check' => TRUE),
				);
                $this->extra_add_columns = array('created_by'=>$this->session->userdata('user_id'),'academic_year_id'=> $this->academic_session[0]->fin_year);
                $this->extra_edit_columns = array('modified_by'=>$this->session->userdata('user_id'),'date_modified'=>date('Y-m-d H:i:s'));

		$this->search_columns = array(
				'alpha_num' => array(
					'name',
					),
				'numeric' => array(
					),
				);
		$this->rec_key = 'id';
		$this->data_table = $this->dbtable . ' AS t1';
		$this->data_select = '*';
		$this->data_select_where = 'status="1"';
		$this->data_delete = 'UPDATE';
		$this->data_delete_update = array('status' => 'N');
	}
}
