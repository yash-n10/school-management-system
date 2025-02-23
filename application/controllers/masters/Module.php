<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Module extends MY_ListController
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

		$this->page_title = 'Modules';
		$this->rec_type = 'Module';
		$this->rec_types = 'Sections';
		$this->section = 'masters';
		$this->dbtable = 'module';
		$this->display_columns = array('id' => 'ID', 'm_code' => 'Module Code','m_name'=>'Module Name');
		$this->edit_columns = array(
				'm_code' => array('disp' => 'Module Code', 'type' => 'text', 'required' => TRUE,'pattern' => '[a-zA-Z0-9]+', 'minlength' => '2', 'maxlength' => '20', 'title' => 'Must be an alphanumeric in 2-10 chars','serverRules'=>'trim|required|alpha_dash|min_length[2]|max_length[20]','save_function_php' => 'strtolower'),
				'm_name' => array('disp' => 'Module Name', 'type' => 'text', 'required' => TRUE, 'pattern' => '[a-zA-Z0-9]+', 'minlength' => '2', 'maxlength' => '191', 'title' => 'Must be an alphanumeric in 2-191 chars','serverRules'=>'trim|required|alpha_numeric_spaces|min_length[2]|max_length[191]','save_function_php'=>'ucwords'),
//				'priority' => array('disp' => 'Priority', 'type' => 'number', 'required' => TRUE, 'pattern' => '[0-9]+', 'minlength' => '2', 'maxlength' => '191', 'title' => 'Must be an valid number','serverRules'=>'trim|required|numeric|min_length[2]|max_length[191]'),
				);
		$this->search_columns = array(
				'alpha_num' => array(
					'm_code',
					'm_name'
					),
				'numeric' => array(
                                    'priority'
					),
				);
		$this->rec_key = 'id';
		$this->data_table = $this->dbtable . ' AS t1';
		$this->data_select = '*';
		$this->data_select_where = 'status="Y"';
		$this->data_delete = 'UPDATE';
		$this->data_delete_update = array('status' => 'N','last_date_modified'=>date('Y-m-d H:i:s'),'last_modified_by'=>$this->session->userdata('user_id'),'ip'=>$_SERVER['REMOTE_ADDR']);
	}
}
