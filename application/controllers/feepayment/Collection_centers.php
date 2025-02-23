<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Collection_centers extends MY_ListController
{
	public function __construct()
	{
                $this->page_code = 'collection_center';
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
//                                        $this->right_access = 'CR--';
//                                        break;
//                    default:
//                                        $this->right_access = '----';
//                                        redirect(base_url(), 'refresh');
//                }

		$this->page_title = 'Collection Centers';
		$this->rec_type = 'Collection Center';
		$this->rec_types = 'Collection Centers';
		$this->section = 'masters';
		$this->dbtable = 'collection_center';
		$this->display_columns = array('id' => 'ID', 'collection_code' => 'Collection Center Code', 'collection_desc' => 'Collection Center Description');
		$this->edit_columns = array(
				'collection_code' => array('disp' => 'Center Code', 'type' => 'text', 'required' => TRUE),
				'collection_desc' => array('disp' => 'Center Description', 'type' => 'text', 'required' => TRUE),
				);
                $this->search_columns = array(
                                'alpha_num' => array(
                                        'collection_code',
                                        'collection_desc',
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
