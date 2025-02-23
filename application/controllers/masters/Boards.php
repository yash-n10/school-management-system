<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Boards extends MY_ListController
{
	public function __construct()
	{
                $this->page_code = 'boards';
		parent::__construct();

		
		$this->page_title = 'Boards';
		$this->rec_type = 'Board';
		$this->rec_types = 'Boards';
		$this->section = 'masters';
		$this->dbtable = 'board';
		$this->display_columns = array('id' => 'ID', 'board' => 'Board Name');
		$this->edit_columns = array(
				'board' => array('disp' => 'Board Name', 'type' => 'text', 'required' => TRUE),
				);
                $this->search_columns = array(
                                'alpha_num' => array(
                                        'board',
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
