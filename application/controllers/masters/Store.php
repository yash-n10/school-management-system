<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store extends MY_ListController
{
	public function __construct()
	{
                $this->page_code = 'master_store';
                
		parent::__construct();
		
		$this->page_title = 'Stores';
		$this->rec_type = 'Store';
		$this->rec_types = 'Store';
		$this->section = 'masters';
		$this->dbtable = 'store';
		$this->display_columns = array('id' => 'ID', 'store_name' => 'Store Name','storekeeper'=>'Store Keeper');
		$this->edit_columns = array(
				'store_name' => array('disp' => 'Store Name', 'type' => 'text', 'required' => TRUE),
				'storekeeper' => array('disp' => 'Store Keeper', 'type' => 'text', 'required' => TRUE),
				);
                $this->search_columns = array(
                                'alpha_num' => array(
                                        'store_name',
                                        'storekeeper',
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
