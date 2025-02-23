<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Offline_payment extends CI_Controller {

	public $page_code = 'store_offline_payment';
	public $page_id = '';
	public $page_perm = '----';
	public $group_type='';

	public function __construct() {
		parent::__construct();

		$this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");

		$this->id = $this->session->userdata('school_id');
		$this->db->db_select('crmfeesclub_' . $this->id);

		$permission = $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
		$this->page_perm = !empty($permission) ? $permission[0]->permission : '----';
		$this->right_access = $this->page_perm;
		
		$var_grouptype = $this->dbconnection->select("user_group", "group_type", "id={$this->session->userdata('user_group_id')}"); 
		$this->var_role = !empty($var_grouptype) ? $var_grouptype[0]->group_type : '----';
		
//		print_r($this->var_role); die();
		
		if (strpos($this->page_perm, '----') == true) {
			redirect(base_url(''), 'refresh');
		}
		$this->page_title = 'Offline Payment Collection';
		$this->section = 'store';
		$this->page_name = 'offline_payment';
		$this->customview = '';
	}
	

	public function index() {
		if (($this->right_access[1] == 'R') != 1) {
			redirect('404');
		}
		$this->data['page_name']	= $this->page_name;
		$this->data['id'] 			= $this->id;
		$this->data['page_title'] 	= $this->page_title;
		$this->data['section'] 		= $this->section;
		$this->data['customview']	= $this->customview;
		$this->data['right_access']	= $this->right_access;

		// $usr_name = explode("-", $this->session->userdata('user_name'));
		// $str = "admission_no='" . $usr_name[1] . "'";
	
		// $this->data['arr_stu_account'] = $this->dbconnection->select("student_acc_book", "*", $str);
		$this->load->view('index', $this->data);
		
	}
	public function details()
	{
		$admission_no=$this->input->post('admission_no');
		$student_data	= $this->db->query("SELECT * FROM student where admission_no='$admission_no'");
		$student_data	= $student_data->result();
		$student_data	= $student_data[0];
		$strsql = "SELECT admission_no, SUM(amt_charged) AS 'tot_amt_charged', SUM(amt_paid) AS 'tot_amt_paid', approved, status "
						. "FROM student_acc_book "
						. "GROUP BY admission_no, approved "
						. "HAVING status = 'Y' AND approved = 'Y' AND admission_no = '" . $admission_no . "'"; 
		$outstanding = $this->db->query($strsql);
		$outstanding=$outstanding->result();
		$outstanding=$outstanding[0];
		$outstanding=$outstanding->tot_amt_charged;
		
		$strsql = "SELECT admission_no, SUM(amt_charged) AS 'tot_amt_charged', SUM(amt_paid) AS 'tot_amt_paid', approved, status "
						. "FROM student_acc_book "
						. "GROUP BY admission_no, approved "
						. "HAVING status = 'Y' AND approved = 'N' AND admission_no = '" . $admission_no . "'"; 
		$unbilled	= $this->db->query($strsql);
		$unbilled	= $unbilled->result();
		$unbilled	= $unbilled[0];
		$unbilled=$unbilled->tot_amt_charged;
		
		$student_id=$this->db->query("SELECT id from student where admission_no='$admission_no'");
		$student_id=$student_id->result();
		$student_id=$student_id[0];
		$student_id=$student_id->id;
		// print_r($student_id);

		$strsql 		= "SELECT * FROM store_transaction where student_id='" . $student_id . "' and paid_status=1";
		$trans_hist 	= $this->db->query($strsql);
		
		$data['amount']	= $outstanding->tot_amt_charged - $outstanding->tot_amt_paid;
		$data['unbilled']	= $unbilled->tot_amt_charged;
		$data['trans_hist'] = $trans_hist->result();
		$data['page_title']	= $this->page_title ;
		$data['section']	= $this->section ;
		$data['page_name']= 'offline_payment_details';
		$data['student_id']	= $student_id;
		$this->load->view('index',$data);

	}
	public function submit()
	{
		// print_r($this->input->post());
		$amount=$this->input->post('amount');
		$student_id=$this->input->post('student_id');
		$paid_by=$this->session->userdata('user_id');
		$challan_no=$this->input->post('challan_no');
		// print_r($paid_by);die();
		$query=$this->db->query("INSERT INTO store_transaction(student_id,request_status,response_status,total_amount,paid_by,remarks,status,paid_status,mode) VALUES('$student_id',1,1,'$amount','$paid_by','$challan_no',1,1,'Challan')");
		if ($query) {
			redirect('store/Offline_payment');
		}
		else{
			print_r($query);
		}
	}
}

?>