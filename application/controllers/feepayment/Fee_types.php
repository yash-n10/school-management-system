<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fee_types extends MY_ListController
{
	public function __construct()
	{
		$this->page_code = 'fee_types';
		parent::__construct();

//		switch($this->session->userdata('login_type')){
//                    case 'appadmin':
//                                        $this->right_access = 'CRUD';
//                                        break;
//                    case 'admin':
//                                        $this->right_access = 'CRUD';
//                                        break;
//                    case 'principal':
//                                        $this->right_access = '-R--';
//                                        break;
//                    case 'office':
//                                        $this->right_access = 'CR--';
//                                        break;
//                    default:
//                                        $this->right_access = '----';
//                                        redirect(base_url(), 'refresh');
//                }

		$this->page_title = 'Fees';
		$this->rec_type = 'Fees';
		$this->rec_types = 'Fees';
		$this->section = 'feepayment';
		$this->dbtable = 'fee_master';
		$this->stdview='feepayment/fee_types';
		$this->display_columns = array('id' => 'ID', 'fee_name' => 'Fee Name', 'fee_cat_id_disp' => 'Fee Category');

		// Fee Category Restrictions
		if ($this->school[0]->fee_type1==1) $fee_cat1 = 2; else $fee_cat1 = 5;
		if ($this->school[0]->fee_type2==3) $fee_cat2 = 4; else $fee_cat2 = 1;
		if ($this->school[0]->onetime=='YES') $fee_cat9 = ',9,10'; else $fee_cat9='';
		$fee_cat3 = 3;
		$fee_cat12 = 12;
		if ($this->school[0]->transport_fee=='YES') $fee_cat4 = ',6'; else $fee_cat4 = '';
		
		$fee_cat8 = ',8';
		$this->edit_columns = array(
			'fee_name' => array('disp' => 'Fee Name', 'type' => 'text', 'required' => TRUE),
			'fee_cat_id' => array('disp' => 'Fee Category', 'type' => 'select', 'select_opts' => $this->dbconnection->select('crmfeesclub.fee_category', 'id AS opt_id, fee_cat_name AS opt_disp', "id in ($fee_cat1,$fee_cat2,$fee_cat3,$fee_cat12 $fee_cat4 $fee_cat8 $fee_cat9)"), 'required' => TRUE),
			'month_set' => array('disp' => 'Applicable Month', 'type' => 'checkbox', 'select_opts' => array((object)array('opt_id'=>'1','opt_disp'=>'Apr'),(object)array('opt_id'=>'2','opt_disp'=>'May'),(object)array('opt_id'=>'3','opt_disp'=>'Jun'),(object)array('opt_id'=>'4','opt_disp'=>'July'),(object)array('opt_id'=>'5','opt_disp'=>'Aug'),(object)array('opt_id'=>'6','opt_disp'=>'Sep'),(object)array('opt_id'=>'7','opt_disp'=>'Oct'),(object)array('opt_id'=>'8','opt_disp'=>'Nov'),(object)array('opt_id'=>'9','opt_disp'=>'Dec'),(object)array('opt_id'=>'10','opt_disp'=>'Jan'),(object)array('opt_id'=>'11','opt_disp'=>'Feb'),(object)array('opt_id'=>'12','opt_disp'=>'Mar')), 'required' => TRUE),
			'fee_type' => array('disp' => 'Fee Type', 'type' => 'radio', 'select_opts' => array((object)array('opt_id'=>'REFUND','opt_disp'=>'Refundable'),(object)array('opt_id'=>'NONREFUND','opt_disp'=>'Non-Refundable')), 'required' => TRUE),
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
		$this->data_select = 'id, fee_name, fee_cat_id,fee_type, (SELECT fee_cat_name FROM crmfeesclub.fee_category WHERE id=t1.fee_cat_id) AS fee_cat_id_disp,month_set';
		$this->data_select_where = 'status="1"';
		$this->data_delete = 'UPDATE';
		$this->data_delete_update = array('status' => '0');
	}



	public function add()
	{
		if (! $this->input->is_ajax_request() || $this->read_only || substr($this->right_access, 0, 1) != 'C') {
//			redirect('404');
			show_404();
		}



		$data = array(
			'fee_name'=>trim($this->input->post('fee_name')),
			'fee_cat_id'=>$this->input->post('fee_cat_id'),
			'month_set'=>$this->input->post('month_applicable'),
			'fee_type'=>$this->input->post('fee_type'),
			'date_created'=>date('Y-m-d H:i:s'),
			'created_by'=>$this->session->userdata('user_id')
		);
		
		$result = $this->dbconnection->insert($this->dbtable, $this->security->xss_clean($data));
		$this->dbtablelastid=$this->dbconnection->get_last_id();
		//Audit Trail
		$audit = array("action"=> 'Add',
			"module" => $this->page_title,
			"page" => basename(__FILE__, '.php'),
			'datetime' => date("Y-m-d H:i:s"),
			'userid' => $this->session->userdata('user_id'),
			'remarks' => 'ID:'.$this->dbtablelastid,
			'ip_address' =>$this->input->ip_address()
		);
		$this->dbconnection->insert("auditntrail",$audit);
		echo 1;
	}

	public function update($id)
	{
//		$id = $this->uri->segment(4);
		if (!$this->input->is_ajax_request() || $this->read_only || substr($this->right_access, 2, 1) != 'U') {
			redirect('404');
		}

		$data = array(
			'fee_name'=>trim($this->input->post('fee_name')),
			'fee_cat_id'=>$this->input->post('fee_cat_id'),
			'month_set'=>$this->input->post('month_applicable'),
			'fee_type'=>$this->input->post('fee_type'),
			'last_date_modified'=>date('Y-m-d H:i:s'),
			'modified_by'=>$this->session->userdata('user_id')
		);

		$this->updateind=$this->dbconnection->update($this->dbtable, $this->security->xss_clean($data), array('id'=> $id));

		//Audit Trail
		$audit = array("action"=> 'Update',
			"module" => $this->page_title,
			"page" => basename(__FILE__, '.php'),
			'datetime' => date("Y-m-d H:i:s"),
			'userid' => $this->session->userdata('user_id'),
			'remarks' => 'ID:'.$id,
			'ip_address' => $this->input->ip_address()
		);
		$this->dbconnection->insert("auditntrail",$audit);

		echo 1;

	}


	public function importTextBookList()
	{

		if(isset($_FILES['excle_file']['name']))
		{  
			$path=$_FILES['excle_file']['tmp_name'];
			$object=PHPExcel_IOfactory::load($path);
			foreach ($object->getWorksheetIterator() as $worksheet)
			{ 
				$h_row=$worksheet->getHighestRow();
				$h_column=$worksheet->getHighestColumn();
				for($row=2;$row<=$h_row;$row++)
				{   
					$fee_name=$worksheet->getCellByColumnAndRow(0,$row)->getValue();
					$fee_cat_name=$worksheet->getCellByColumnAndRow(1,$row)->getValue();
					$fee_Cat_data =$this->dbconnection->get('fee_master')->result();

					$fee_type=$worksheet->getCellByColumnAndRow(2,$row)->getValue();
					$data=$this->dbconnection->get('fee_master')->result();
					foreach ($data as $result) 
					{
						//print_r($result);
						
						if(($result['company_name']==$company) &&($result['domain_name']==$d_name) &&($result['first_name']==$first_name))
						{
							$skip=1;
						}
					}
					if($company!="" && $d_name!="")
					{
						$data=array(
							'company_name'=>$company,
							'domain_name'=>$d_name,
							'first_name'=>$first_name,
							'middle_name'=>$middle_name,
							'last_name'=>$last_name,
							'created_at'=>date('Y-m-d H:i:s'),
						);
						$a=$this->main->Insert_data('company',$data);
					}
				}
			}
		} 
	}



}
