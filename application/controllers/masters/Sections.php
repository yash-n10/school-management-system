<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sections extends MY_ListController
{
	public function __construct()
	{
                $this->page_code = 'sections';
		parent::__construct();

		// Access Control
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
//                    case 'office':
//                                        $this->right_access = 'CR--';
//                                        break;
//                    default:
//                                        $this->right_access = '----';
//                                        redirect(base_url(), 'refresh');
//                }

		$this->page_title = 'Sections';
		$this->rec_type = 'Section';
		$this->rec_types = 'Sections';
		$this->section = 'masters';
		$this->dbtable = 'section';
		$this->display_columns = array('id' => 'ID', 'sec_name' => 'Section Name');
		$this->edit_columns = array(
				'sec_name' => array('disp' => 'Section Name', 'type' => 'text', 'required' => TRUE),
				);
		$this->search_columns = array(
				'alpha_num' => array(
					'sec_name',
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
