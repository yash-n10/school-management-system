<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_categories extends MY_ListController
{
	public function __construct()
	{
                $this->page_code = 'student_category';
		parent::__construct();

		

		$this->page_title = 'Fee Student Categories';
		$this->rec_type = 'Student Category';
		$this->rec_types = 'Student Categories';
		$this->section = 'masters';
		$this->dbtable = 'category';
		$this->display_columns = array('id' => 'ID', 'cat_code' => 'Category Code', 'cat_name' => 'Category Name');
		$this->edit_columns = array(
				'cat_code' => array('disp' => 'Category Code', 'type' => 'text', 'required' => TRUE),
				'cat_name' => array('disp' => 'Category Name', 'type' => 'text', 'required' => TRUE),
				);
		$this->search_columns = array(
				'alpha_num' => array(
					'cat_code',
					'cat_name',
					),
				'numeric' => array(
					),
				);
		$this->rec_key = 'id';
		$this->data_table = $this->dbtable . ' AS t1';
		$this->data_select = '*';
		$this->data_select_where = 'status="Y"';
		$this->data_delete = 'UPDATE';
		$this->data_delete_update = array('status' => 'N');
	}
}
