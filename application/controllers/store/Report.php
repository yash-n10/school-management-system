<?php
/**
 * 
 */
class Report extends CI_Controller
{
	public $page_code = 'store_payment_report';
    public $page_id = '';
    public $page_perm = '----';
	function __construct()
	{
	parent::__construct();
                
              $this->page_id 	= $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");
             
              $this->id			= $this->session->userdata('school_id');
		$this->db->db_select('crmfeesclub_'.$this->id); 

              $permission 		= $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
              $this->page_perm	= !empty($permission) ? $permission[0]->permission : '----';
              $this->right_access = $this->page_perm;

		$var_grouptype 	= $this->dbconnection->select("user_group", "group_type", "id={$this->session->userdata('user_group_id')}"); 
		$this->var_role 	= !empty($var_grouptype) ? $var_grouptype[0]->group_type : '----';

		if (strpos($this->page_perm, '----') == true) {
			redirect(base_url(''), 'refresh');
              }

		$this->page_title = 'Store Report';
		$this->section = 'store';
		$this->page_name = 'report'; 
		$this->customview = '';		
	}
	public function index()
	{
		if (($this->right_access[1] == 'R') != 1) {
			redirect('404');
		}
	
		$this->data['page_name'] 	= $this->page_name;
		$this->data['id'] 			= $this->id;
		$this->data['page_title'] 	= $this->page_title;
		$this->data['section'] 		= $this->section;
		$this->data['customview'] 	= $this->customview;
		$this->data['right_access'] 	= $this->right_access;
		$this->data['get_role']		= $this->var_role; 
		$this->load->view('index',$this->data);
	}
	public function get_data()
	{
		$from=$this->input->post('from');
		$from=$from.' 00:00:00';
		$to=$this->input->post('to');
		$to=$to.' 23:59:59';
		$query=$this->db->query("SELECT * FROM store_transaction where payment_date<='$to' and payment_date>='$from' and paid_status=1");
		$query=$query->result();
		// echo "<pre>";print_r($query);die();

		$this->data['page_name'] 	= 'report_data';
		$this->data['id'] 			= $this->id;
		$this->data['page_title'] 	= $this->page_title;
		$this->data['section'] 		= $this->section;
		$this->data['customview'] 	= $this->customview;
		$this->data['right_access'] 	= $this->right_access;
		$this->data['get_role']		= $this->var_role; 
		$this->data['query']		= $query; 
		$this->load->view('index',$this->data);	
	}
}
?>