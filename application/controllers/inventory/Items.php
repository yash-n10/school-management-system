<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Items extends MY_ListController {

    public function __construct() {
        
        $this->page_code = 'items';
        parent::__construct();


        $this->page_title = 'Items';
        $this->rec_type = 'Item';
        $this->rec_types = 'Items';
        $this->section = 'inventory';
        $this->dbtable = 'inventory_items';
        $this->display_columns = array('id' => 'ID', 'upc' => 'UPC', 'serial_number' => 'Serial Number', 'inventory_type' => 'Type', 'inventory_brand_disp' => 'Brand', 'inventory_model_disp' => 'Model',
            'status' => 'Status', 'current_loc_disp' => 'Location', 'current_qty' => 'Quantity',
        );
        $this->edit_columns = array(
            'upc' => array('disp' => 'UPC', 'type' => 'text'),
            'serial_number' => array('disp' => 'Serial Number', 'type' => 'text'),
            'inventory_type' => array('disp' => 'Type', 'type' => 'select', 'select_opts' => $this->dbconnection->select('inventory_types', 'id AS opt_id, inventory_type_description AS opt_disp')),
            'inventory_brand' => array('disp' => 'Brand', 'type' => 'select', 'select_opts' => $this->dbconnection->select('inventory_brands', 'id AS opt_id, brand_name AS opt_disp')),
            'inventory_model' => array('disp' => 'Model', 'type' => 'select', 'select_opts' => $this->dbconnection->select('inventory_models', 'id AS opt_id, model_number AS opt_disp')),
            'status' => array('disp' => 'Status', 'type' => 'select', 'select_opts' => array(
                    (object) array('opt_id' => 'stock', 'opt_disp' => 'Stock'),
                    (object) array('opt_id' => 'issued', 'opt_disp' => 'Issued'),
                    (object) array('opt_id' => 'disposed', 'opt_disp' => 'Disposed'),
                ),
            ),
            'normal_loc' => array('disp' => 'Normal Location', 'type' => 'select', 'select_opts' => $this->dbconnection->select('locations', 'id AS opt_id, location_description AS opt_disp')),
            'current_loc' => array('disp' => 'Current Location', 'type' => 'select', 'select_opts' => $this->dbconnection->select('locations', 'id AS opt_id, location_description AS opt_disp')),
            'parent' => array('disp' => 'Parent Item', 'type' => 'select', 'select_opts' => $this->dbconnection->select('inventory_items', 'id AS opt_id, id AS opt_disp')),
            'purchase_date' => array('disp' => 'Purch. Date', 'type' => 'date'),
            'warranty_expiry' => array('disp' => 'Warranty Expiry', 'type' => 'date'),
            'original_qty' => array('disp' => 'Original Qty.', 'type' => 'number'),
            'current_qty' => array('disp' => 'Current Qty.', 'type' => 'number'),
            'last_verified' => array('disp' => 'Last Verified', 'type' => 'date'),
        );
        $this->search_columns = array(
            'alpha_num' => array(
                'upc',
                'serial_number',
            ),
            'numeric' => array(
            ),
        );
        $this->rec_key = 'id';
        $this->data_table = $this->dbtable . ' AS t1';
        $this->data_select = 'id, upc, serial_number, ' .
                'inventory_type, (SELECT inventory_type_description FROM inventory_types AS t2 WHERE t2.id=t1.inventory_type) AS inventory_type_disp, ' .
                'inventory_brand, (SELECT brand_name FROM inventory_brands AS t2 WHERE t2.id=t1.inventory_brand) AS inventory_brand_disp, ' .
                'inventory_model, (SELECT model_name FROM inventory_models AS t2 WHERE t2.id=t1.inventory_model) AS inventory_model_disp, ' .
                'status, status AS status_disp, ' .
                'normal_loc, (SELECT location_description FROM locations AS t2 WHERE t2.id=t1.normal_loc) AS normal_loc_disp, ' .
                'current_loc, (SELECT location_description FROM locations AS t2 WHERE t2.id=t1.current_loc) AS current_loc_disp, ' .
                'parent, (SELECT inventory_type_description FROM inventory_types AS t2 WHERE t2.id=t1.parent) AS parent_disp, ' .
                'purchase_date, warranty_expiry, original_qty, current_qty, last_verified';
    }

}
