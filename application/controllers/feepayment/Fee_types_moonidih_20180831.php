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

		$this->page_title = 'Fee Types';
		$this->rec_type = 'Fee Type';
		$this->rec_types = 'Fee Types';
		$this->section = 'masters';
		$this->dbtable = 'fee_master';
                $this->stdview='feepayment/fee_types';
		$this->display_columns = array('id' => 'ID', 'fee_name' => 'Fee Name', 'fee_cat_id_disp' => 'Fee Category');

		// Fee Category Restrictions
		if ($this->school[0]->fee_type1==1) $fee_cat1 = 2; else $fee_cat1 = 5;
		if ($this->school[0]->fee_type2==3) $fee_cat2 = 4; else $fee_cat2 = 1;
		$fee_cat3 = 3;
                if ($this->school[0]->transport_fee=='YES') $fee_cat4 = ',6'; else $fee_cat4 = '';
		

		$this->edit_columns = array(
				'fee_name' => array('disp' => 'Fee Name', 'type' => 'text', 'required' => TRUE),
				'fee_cat_id' => array('disp' => 'Fee Category', 'type' => 'select', 'select_opts' => $this->dbconnection->select('crmfeesclub.fee_category', 'id AS opt_id, fee_cat_name AS opt_disp', "id in ($fee_cat1,$fee_cat2,$fee_cat3 $fee_cat4)"), 'required' => TRUE),
				'month_set' => array('disp' => 'Applicable Month', 'type' => 'checkbox', 'select_opts' => array((object)array('opt_id'=>'1','opt_disp'=>'Apr'),(object)array('opt_id'=>'2','opt_disp'=>'May'),(object)array('opt_id'=>'3','opt_disp'=>'Jun'),(object)array('opt_id'=>'4','opt_disp'=>'July'),(object)array('opt_id'=>'5','opt_disp'=>'Aug'),(object)array('opt_id'=>'6','opt_disp'=>'Sep'),(object)array('opt_id'=>'7','opt_disp'=>'Oct'),(object)array('opt_id'=>'8','opt_disp'=>'Nov'),(object)array('opt_id'=>'9','opt_disp'=>'Dec'),(object)array('opt_id'=>'10','opt_disp'=>'Jan'),(object)array('opt_id'=>'11','opt_disp'=>'Feb'),(object)array('opt_id'=>'12','opt_disp'=>'Mar')), 'required' => TRUE),
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
        
        
        
        public function add()
	{
		if (! $this->input->is_ajax_request() || $this->read_only) {
//			redirect('404');
                        show_404();
		}
		$data = array();
		foreach ($this->edit_columns as $col => $colparams) {
			if (isset($colparams['save_function'])) {
				$data[$col] = $colparams['save_function'] . '(' . trim($this->input->post($col)) . ')';
			}elseif($colparams['type']=='checkbox'){
                            
                        }else {
				$data[$col] = trim($this->input->post($col));
			}
		}
                if(isset ($this->extra_add_columns)) {
                        foreach ($this->extra_add_columns as $colk => $colv) {
                                $data[$colk] = $colv;
                        }
                }
		$result = $this->dbconnection->insert($this->dbtable, $this->security->xss_clean($data));
                $this->dbtablelastid=$this->dbconnection->get_last_id();
		//Audit Trail
		$audit = array("action"=> 'Add',
				"module" => $this->page_title,
				"page" => basename(__FILE__, '.php'),
				'datetime' => date("Y-m-d H:i:s"),
				'userid' => $this->session->userdata('user_id'),
				'remarks' => 'ID:'.$this->dbtablelastid,
				'ip_address' => $_SERVER['REMOTE_ADDR'],
				);
		$this->dbconnection->insert("auditntrail",$audit);
		echo 1;
	}
        
        
        
        
}
