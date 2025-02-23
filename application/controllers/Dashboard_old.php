<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct() 
        {
		parent::__construct();

		if (empty($this->session->userdata('user_id'))) {
			redirect('/login');
		}

		$this->total_school=$this->dbconnection->select("school","count(*) as cnt","status=1");
		$this->school1=$this->dbconnection->select('school','*','id = '.$this->session->userdata('school_id'));
               
               
		$this->id=$this->session->userdata('school_id');

		if ($this->id !=0) {
                    
			$this->db->db_select('crmfeesclub_'.$this->id);
			$this->user= $this->dbconnection->select('user','*','id = '.$this->session->userdata('user_id'));
			$this->total_user=$this->dbconnection->select("user","count(*) as users");
                        
		} else {
			$this->user= $this->dbconnection->select('user','*','id = '.$this->session->userdata('user_id'));
			$this->total_user=$this->dbconnection->select("user","count(*) as users"); 
		}
		$this->page_title = 'Dashboard';
		$this->section = '';
		$this->page_name = 'dashboard';
		$this->customview = '';
	}

	/*     * *default functin, redirects to login page if no principal logged in yet** */

	public function index()
        {
		$count = 0;
		$count_reg = 0;
		$login_type = $this->session->userdata('login_type');
		if ($this->session->userdata('user_group_id') == 1) {
			$school_query = $this->dbconnection->select("school","*","status=1");

			foreach ($school_query as $obj_sch) {
				$this->db->db_select('crmfeesclub_'.$obj_sch->id);
				$student_query=$this->dbconnection->select("student","*","status='Y'");
				$student_registered_query=$this->dbconnection->select("student","*","status='Y' and registered_status=1");
				$count=$count+count($student_query);
				$count_reg=$count_reg+count($student_registered_query);
			}
		}
		$this->id=$this->session->userdata('school_id');
                if($this->id !=0) {
                    $this->db->db_select('crmfeesclub_'.$this->id);
                            
                } else{
                    $this->db->db_select('crmfeesclub');
                            
                }

		$this->data['page']= 'dashboard';
		$this->data['user'] = $this->user ;

		$total_school = $this->total_school;
		$this->data['total_school'] = $total_school[0]->cnt;

		if ($this->session->userdata('user_group_id') == 3 || $this->session->userdata('user_group_id') == 2) {  // Group 3 = School, Group 2 = Supervisor
			$this->data['school1'] = $this->school1;
			$this->data['school_name']=$this->data['school1'][0]->description;
			$this->data['school_address']=$this->data['school1'][0]->address;

			$this->data['tot_stud']= $this->dbconnection->select("student","count(admission_no) as students"," status='Y'");
			$this->data['total_students']= $this->data['tot_stud'][0]->students;

			$this->data['tot_stud_reg']= $this->dbconnection->select("student","count(admission_no) as students_reg","status='Y' and registered_status=1");
			$this->data['total_registered']= $this->data['tot_stud_reg'][0]->students_reg;

			$this->data['school'] = $this->school_dashboard(); //for fetching class wise
		} else {
			$this->data['total_students']= $count;
			$this->data['total_registered']= $count_reg;
		}

		$total_users = $this->total_user;
		$this->data['total_users'] = $total_users[0]->users;

		$this->data['page_name'] = $this->page_name;;
		$this->data[$login_type.'_message'] =  0;
		$this->data['page_title'] = $this->page_title;
		$this->data['section'] = $this->section;
		$this->data['customview'] = $this->customview;
           
		$this->load->view('index',$this->data);
	}

	public function change_password(){
		$user_id = $this->session->userdata('user_id');
		$password = $_POST['change_password'];

		$salt= $this->generateRandomString();
		$encryption = $this->dbconnection->select('encrypt','*');
		$value = rand(0,count($encryption)-1);
		$encryption_id = $encryption[$value]->id;
		$encryption_type = $encryption[$value]->encryption_type;

		$password = $encryption_type($password.$salt);

		$data = array(
				'password' => $password,
				'salt' => $salt,
				'encrypt_id' => $encryption_id,
				'change_password' => 1,
				'last_date_modified' => date('Y-m-d H:i:s'),
				'last_modified_by' => $this->session->userdata('user_id')
			     );
		$user = $this->dbconnection->update('user',$data,'id ='.$user_id);
		header("Location: ".site_url("dashboard"));
	}

	public function generateRandomString($length = 25) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}


	private function school_dashboard()
        {
		$date = date("Y-m");
                $month_year = explode('-',$date);
                $month = $month_year[1];
                
                if ($month >= 1 and $month <= 3) {
                    $new_month = $month + 9;
                } else {
                    $new_month=$month - 3;
                }
                
		$school = array();
                
                $school['total_paid_admin'] = 0;
                $school['total_paid_cc'] = 0;
                $school['total_paid'] = 0;
                
                $school['total_paid_admin_annual'] = 0;
                $school['total_paid_cc_annual'] = 0;
                $school['total_paid_annual'] = 0;
                
                $school['total_amount_admin'] = 0;
                $school['total_amount_cc'] = 0;
                $school['total_amount_admin_ann'] = 0;
                $school['total_amount_cc_ann'] = 0;
		$ann_total = 0;
		$ann_total1 = 0;
		$mon_total = 0;
		$mon_total1 = 0;
		$oclass = $this->dbconnection->select("class","id,class_name","status='Y'");
		foreach ($oclass as $key) {
			//total student
			$total_cl_stud= $this->dbconnection->select("student","count(admission_no) as students","status='Y' and class_id=$key->id");
			$school['class'][$key->class_name]['total_class_student']=$total_cl_stud[0]->students;

			$total_cl_stud_reg= $this->dbconnection->select("student","count(admission_no) as students_reg","status='Y' and registered_status=1 and class_id=$key->id");
			$school['class'][$key->class_name]['registered']=$total_cl_stud_reg[0]->students_reg;

			/*------------------ monthly payment  ----------------------*/
			$monthly=0;

			$fetch_paid=$this->dbconnection->select("fee_trans_det","id,amount","student_id in (select adm.id from student adm where adm.class_id=$key->id) and month_no=$new_month and paid_status=1 and payment_method!='Cash'");
			foreach ($fetch_paid as $cnt3) {
				$mon_total=$mon_total+$cnt3->amount;
				$monthly++;
			}
			$school['class'][$key->class_name]['cc']=$monthly;
			$monthly1=0;

			$fetch_paid1=$this->dbconnection->select("fee_trans_det","id,amount","student_id in (select adm.id from student adm where adm.class_id=$key->id) and month_no=$new_month and paid_status=1 and payment_method='Cash'");
			foreach ($fetch_paid1 as $cnt4) {
				$mon_total1=$mon_total1+$cnt4->amount;
				$monthly1++;
			}
			$school['class'][$key->class_name]['admin']=$monthly1;

			/*--------------  Annual   -------------------*/
			$annual=0;

			$fetch_paid_annual=$this->dbconnection->select("fee_trans_det","id,amount","student_id in (select adm.id from student adm where adm.class_id=$key->id) and paid_status=1 and year=2017 and month_no=0 and payment_method!='Cash'");
			foreach ($fetch_paid_annual as $cnt1) {
				$ann_total=$ann_total+$cnt1->amount;
				$annual++;
			}

			$school['class'][$key->class_name]['cc_ann']=$annual;

			$annual1=0;
			$fetch_paid1_ann=$this->dbconnection->select("fee_trans_det","id,amount","student_id in (select adm.id from student adm where adm.class_id=$key->id) and paid_status=1 and year=2017 and month_no=0 and payment_method='Cash'");
			foreach ($fetch_paid1_ann as $cnt2) {   
				$ann_total1=$ann_total1+$cnt2->amount;
				$annual1++;
			}
			$school['class'][$key->class_name]['admin_ann']=$annual1;

			$school['total_paid_admin']=$school['total_paid_admin']+$school['class'][$key->class_name]['admin'];
			$school['total_paid_cc']=$school['total_paid_cc']+$school['class'][$key->class_name]['cc'];
			$school['total_paid_admin_annual']=$school['total_paid_admin_annual']+$school['class'][$key->class_name]['admin_ann'];
			$school['total_paid_cc_annual']=$school['total_paid_cc_annual']+$school['class'][$key->class_name]['cc_ann'];

		}
		$school['total_paid']=$school['total_paid_admin']+$school['total_paid_cc'];
		$school['total_paid_annual']=$school['total_paid_admin_annual']+$school['total_paid_cc_annual'];
		$school['total_paid_annual_amount']=$ann_total1+$ann_total;
		$school['total_paid_monthly_amount']=$mon_total+$mon_total1;

		$school['total_amount_admin']=$mon_total1;
		$school['total_amount_cc']=$mon_total;
		$school['total_amount_admin_ann']=$ann_total1;
		$school['total_amount_cc_ann']=$ann_total;

		return $school;
	}
}
