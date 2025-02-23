<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loctypes extends MY_ListController
{
	public function __construct()
	{
		parent::__construct();

		// Access Control
		switch($this->session->userdata('login_type')){
                    case 'appadmin':
                                        $this->right_access = 'CRUD';
                                        break;
                    case 'admin':
                                        $this->right_access = 'CRUD';
                                        break;
                    case 'principal':
                                        $this->right_access = '-R--';
                                        break;
                    case 'office':
                                        $this->right_access = 'CR--';
                                        break;
                    default:
                                        $this->right_access = '----';
                                        redirect(base_url(), 'refresh');
                }

		$this->page_title = 'Location Types';
		$this->rec_type = 'Location Type';
		$this->rec_types = 'Location Types';
		$this->section = 'masters';
		$this->dbtable = 'location_types';
		$this->display_columns = array('id' => 'ID', 'type_name' => 'Name', 'type_level' => 'Level');
		$this->edit_columns = array(
				'type_name' => array('disp' => 'Name', 'type' => 'text', 'required' => TRUE),
				'type_level' => array ('disp' => 'Level', 'type' => 'number', 'required' => TRUE),
				);
                $this->search_columns = array(
                                'alpha_num' => array(
                                        'type_name',
                                        ),
                                'numeric' => array(
                                        ),
                                );
		$this->rec_key = 'id';
		$this->data_table = $this->dbtable . ' AS t1';
		$this->data_select = '*';
		$this->data_select_where = '';
	}
}
