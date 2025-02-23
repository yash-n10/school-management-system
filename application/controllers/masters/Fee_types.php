<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fee_types extends MY_ListController
{
	public function __construct()
	{
		parent::__construct();

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

		$this->page_title = 'Fees';
		$this->rec_type = 'Fees';
		$this->rec_types = 'Fees';
		$this->section = 'masters';
		$this->dbtable = 'fee_master';
		$this->display_columns = array('id' => 'ID', 'fee_name' => 'Fee Name', 'fee_cat_id_disp' => 'Fee Category');

		// Fee Category Restrictions
		if ($this->school[0]->fee_type1==1) $fee_cat1 = 2; else $fee_cat1 = 5;
		if ($this->school[0]->fee_type2==3) $fee_cat2 = 4; else $fee_cat2 = 1;
		$fee_cat3 = 3;
		$fee_cat4 = 6;//transport fee category 

		$this->edit_columns = array(
				'fee_name' => array('disp' => 'Fee Name', 'type' => 'text', 'required' => TRUE),
				'fee_cat_id' => array('disp' => 'Fee Category', 'type' => 'select', 'select_opts' => $this->dbconnection->select('crmfeesclub.fee_category', 'id AS opt_id, fee_cat_name AS opt_disp', "id in ($fee_cat1,$fee_cat2,$fee_cat3,$fee_cat4)"), 'required' => TRUE),
				);
		$this->search_columns = array(
				'alpha_num' => array(
					'fee_name',
					),
				'numeric' => array(
					),
				);
		$this->rec_key = 'id';
		$this->data_table = $this->dbtable . ' AS t1';
		$this->data_select = 'id, fee_name, fee_cat_id, (SELECT fee_cat_name FROM crmfeesclub.fee_category WHERE id=t1.fee_cat_id) AS fee_cat_id_disp';
		$this->data_select_where = 'status="1"';
		$this->data_delete = 'UPDATE';
		$this->data_delete_update = array('status' => '0');
	}
}
