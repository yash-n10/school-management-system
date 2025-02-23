<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Brands extends MY_ListController
{
	public function __construct()
	{
                $this->page_code = 'brands';
                
		parent::__construct();

		

		$this->page_title = 'Brands';
		$this->rec_type = 'Brand';
		$this->rec_types = 'Brands';
		$this->section = 'inventory';
		$this->dbtable = 'inventory_brands';
		$this->display_columns = array('id' => 'ID', 'brand_name' => 'Name', 'brand_website' => 'Website');
		$this->edit_columns = array(
				'brand_name' => array('disp' => 'Name', 'type' => 'text', 'required' => TRUE),
				'brand_website' => array ('disp' => 'Website', 'type' => 'text', 'required' => TRUE),
				);
		$this->search_columns = array(
				'alpha_num' => array(
					'brand_name',
					),
				'numeric' => array(
					),
				);
		$this->rec_key = 'id';
		$this->data_table = $this->dbtable . ' AS t1';
		$this->data_select = '*';
	}
}
