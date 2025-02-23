<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grades extends MY_ListController
{
	public function __construct()
	{
                $this->page_code = 'exam_grade';
		parent::__construct();

		$this->page_title = 'Grades';
		$this->rec_type = 'Grade';
		$this->rec_types = 'Grades';
		$this->section = 'academic';
		$this->dbtable = 'grade';
		$this->display_columns = array('id' => 'ID', 'name' => 'Grade Name', 'mark_from' => 'Marks From', 'mark_upto' => 'Marks Upto', 'grade_point' => 'Grade Point', 'remarks' => 'Remarks');
		$this->edit_columns = array(
				'name' => array('disp' => 'Grade Name', 'type' => 'text', 'required' => TRUE),
				'mark_from' => array('disp' => 'Mark From', 'type' => 'number', 'required' => TRUE),
				'mark_upto' => array('disp' => 'Mark Upto', 'type' => 'number', 'required' => TRUE),
				'grade_point' => array('disp' => 'Grade Point', 'type' => 'text', 'required' => TRUE),
				'remarks' => array('disp' => 'Remarks', 'type' => 'text', 'required' => TRUE),
				);
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
