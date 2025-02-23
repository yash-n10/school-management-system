<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Types extends MY_ListController {

    public function __construct() {
        $this->page_code = 'inventory_types';
        parent::__construct();


        $this->page_title = 'Types';
        $this->rec_type = 'Type';
        $this->rec_types = 'Types';
        $this->section = 'inventory';
        $this->dbtable = 'inventory_types';
        $this->display_columns = array('id' => 'ID', 'inventory_type_description' => 'Description', 'parent_disp' => 'Parent', 'quantity_unit' => 'Qty. Unit');
        $this->edit_columns = array(
            'inventory_type_description' => array('disp' => 'Type Description', 'type' => 'text', 'required' => TRUE),
            'parent' => array('disp' => 'Parent Type', 'type' => 'select', 'select_opts' => $this->dbconnection->select('inventory_brands', 'id AS opt_id, brand_name AS opt_disp')),
            'quantity_unit' => array('disp' => 'Qty. Unit', 'type' => 'text'),
        );
        $this->search_columns = array(
            'alpha_num' => array(
                'inventory_type_description',
            ),
            'numeric' => array(
            ),
        );
        $this->rec_key = 'id';
        $this->data_table = $this->dbtable . ' AS t1';
        $this->data_select = 'id, inventory_type_description, parent, (SELECT brand_name FROM inventory_brands AS t2 WHERE t2.id=t1.parent) AS parent_disp, quantity_unit';
    }

}
