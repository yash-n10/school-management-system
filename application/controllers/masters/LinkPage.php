<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LinkPage extends MY_ListController
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

		$this->page_title = 'Link Page';
		$this->rec_type = 'Link Page';
		$this->rec_types = 'Link Page';
		$this->section = 'masters';
		$this->dbtable = 'link_page';
		$this->display_columns = array('id' => 'ID', 'l_code' => 'Link Code','l_name'=>'Link Name','parent_node_disp'=>'Parent Link');
                $dbfetch=$this->db->query("(select id AS opt_id, l_name AS opt_disp from link_page where status='Y') union (select 0 AS opt_id, 'Primary' AS opt_disp)");
                $dbfetch=$dbfetch->result();               
		$this->edit_columns = array(
				'l_code' => array('disp' => 'Link Code', 'type' => 'text', 'required' => TRUE,'minlength' => '2', 'maxlength' => '20', 'title' => 'Must be an alphanumeric in 2-10 chars','serverRules'=>'trim|required|alpha_dash|min_length[2]|max_length[20]','save_function_php' => 'strtolower'),
				'l_name' => array('disp' => 'Link Name', 'type' => 'text', 'required' => TRUE,'minlength' => '2', 'maxlength' => '191', 'title' => 'Must be an alphanumeric in 2-191 chars','serverRules'=>'trim|required|alpha_numeric_spaces|min_length[2]|max_length[191]','save_function_php'=>'ucwords'),
				'module_id' => array('disp' => 'Under Module', 'type' => 'select', 'select_opts' => $this->dbconnection->select('module', 'id AS opt_id, m_name AS opt_disp', "status='Y'"), 'required' => TRUE,'serverRules'=>'required'),
				'parent_node' => array('disp' => 'Under Link', 'type' => 'select', 'select_opts' => $dbfetch, 'required' => TRUE,'serverRules'=>'required'),
                                'level' => array('disp' => 'Level', 'type' => 'number', 'required' => TRUE,'pattern' => '[0-9]+','serverRules'=>'trim|required|numeric'),
                                'l_icon' => array('disp' => 'Icon', 'type' => 'text', 'required' => TRUE, 'minlength' => '2', 'maxlength' => '60','serverRules'=>'trim|required|alpha_dash','save_function_php' => 'strtolower'),
                                'l_url' => array('disp' => 'Url', 'type' => 'text', 'required' => TRUE,'minlength' => '2', 'maxlength' => '60','serverRules'=>'trim|required','save_function_php' => 'strtolower'),
                                'children_status' => array('disp' => 'Has Children', 'type' => 'select', 'required' => TRUE, 'select_opts' => array((object)array('opt_id'=>'FALSE','opt_disp'=>'NO'),(object)array('opt_id'=>'TRUE','opt_disp'=>'YES')),'serverRules'=>'required'),
                                'custom_link' => array('disp' => 'Custom Link (if any)', 'type' => 'text', 'pattern' => '[a-zA-Z0-9]+', 'minlength' => '2', 'maxlength' => '60','serverRules'=>'trim|alpha_dash','save_function_php' => 'strtolower'),
                    
				);
		$this->search_columns = array(
				'alpha_num' => array(
					'l_code',
					'l_name'
					),
				'numeric' => array(
					),
				);
		$this->rec_key = 'id';
		$this->data_table = $this->dbtable . ' AS t1';
		$this->data_select = '*,(select a.l_name from link_page a where a.id=t1.parent_node) as parent_node_disp';
		$this->data_select_where = 'status="Y"';
		$this->data_delete = 'UPDATE';
		$this->data_delete_update = array('status' => '0');
	}
}
