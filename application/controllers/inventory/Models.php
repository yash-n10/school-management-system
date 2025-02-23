<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Models extends MY_ListController
{
	public function __construct()
	{
		parent::__construct();
                $this->page_code = 'models';


		$this->page_title = 'Models';
		$this->rec_type = 'Model';
		$this->rec_types = 'Models';
		$this->section = 'inventory';
		$this->dbtable = 'inventory_models';
		$this->display_columns = array('id' => 'ID', 'brand_disp' => 'Brand', 'model_number' => 'Model No.', 'model_name' => 'Name');
		$this->edit_columns = array(
				'brand' => array('disp' => 'Brand', 'type' => 'select', 'select_opts' => $this->dbconnection->select('inventory_brands', 'id AS opt_id, brand_name AS opt_disp'), 'required' => TRUE),
				'model_number' => array ('disp' => 'Model No.', 'type' => 'text', 'required' => TRUE),
				'model_name' => array('disp' => 'Name', 'type' => 'text', 'required' => TRUE),
				'model_description' => array('disp' => 'Description', 'type' => 'text', 'required' => TRUE),
				'model_qty_type' => array('disp' => 'Quantity Unit', 'type' => 'text', 'required' => TRUE),
				);
		$this->search_columns = array(
				'alpha_num' => array(
					'model_number',
					'model_name',
					'model_description',
					),
				'numeric' => array(
					),
				);

		$this->rec_key = 'id';
		$this->data_table = $this->dbtable . ' AS t1';
		$this->data_select = 'id, brand, (SELECT brand_name FROM inventory_brands AS t2 WHERE t2.id=t1.brand) AS brand_disp, model_number, model_name, model_description, model_qty_type';
	}
}
