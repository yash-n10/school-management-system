<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Courses extends MY_ListController
{
	public function __construct()
	{
                $this->page_code = 'courses';
                
		parent::__construct();
		
		$this->page_title = 'Courses';
		$this->rec_type = 'Course';
		$this->rec_types = 'Courses';
		$this->section = 'masters';
		$this->dbtable = 'course';
		$this->display_columns = array('id' => 'ID', 'course_name' => 'Course Name', 'course_code' => 'Course Code');
		$this->edit_columns = array(
				'course_name' => array('disp' => 'Course Name', 'type' => 'text', 'required' => TRUE),
				'course_code' => array('disp' => 'Course Code', 'type' => 'text', 'required' => TRUE),
				);
                $this->search_columns = array(
                                'alpha_num' => array(
                                        'course_code',
                                        'course_name',
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
