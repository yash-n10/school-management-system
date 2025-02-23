<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reconciliation extends CI_Controller {

	public $page_code = 'certificate';
	public $page_id = '';
	public $page_perm = '----';

	public function __construct() {
		parent::__construct();
		$this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");
        // error_reporting(-1);
        // ini_set('display_errors', 1);

		$this->id = $this->session->userdata('school_id');

		$this->school_desc = $this->dbconnection->select("school", "*", "id=" . $this->id . " and status = 1");

		if ($this->id != 0) {
			$this->db->db_select('crmfeesclub_' . $this->id);
		}
	}

    // public function index() {

    //     $this->data['page_title'] = 'Student Record Print';
    //     $this->data['section'] = 'admission';
    //     $this->data['page_name'] = 'stu_award_list';
    //     $this->data['customview'] = '';
    //     $this->data['aclass'] = $this->dbconnection->select("class", "class_name,id", "status='Y'");
    //     $this->data['asection'] = $this->dbconnection->select("section", "sec_name,id", "status='Y'");
    //     $this->data['academic_sessions'] = $this->dbconnection->select("accedemic_session", "id,session", "status='Y'");
    //     echo $this->sb->last_query();die;
    //     $this->load->view('index', $this->data);
    // }

	public function reconciliation_list()
	{
    	$this->db->select('admission_no,first_name,middle_name,last_name,dob,gender,stud_category,category.cat_name');
		$this->db->join("tc_passout",'tc_passout.academic_year_id = student.student_academicyear_id','left');
		$this->db->join("category",'category.id = student.stud_category');
		
		if(isset($_POST['rec_class_list']) && $_POST['rec_class_list'] != "")
		{
			$rec_class_list = $_POST['rec_class_list'];
			$this->db->where('student.class_id ='.$rec_class_list);
		}

		if(isset($_POST['rec_academic_session_list']) && $_POST['rec_academic_session_list'] != "")
		{
			$this->db->where('student.student_academicyear_id ='.$_POST['rec_academic_session_list']);
		}

		if(isset($_POST['rec_section_list']) && $_POST['rec_section_list'] != "")
		{
			$this->db->where('student.section_id ='.$_POST['rec_section_list']);
		}

		if(isset($_POST['rec_month']) && $_POST['rec_month'] != "")
		{
			$rec_month = $_POST['rec_month'];
			$this->db->where('MONTH(tc_passout.date) < '.$rec_month);
		}

		$student_data = $this->db->get('student')->result();
		// echo count($student_data);
		// echo "<pre>";
		//  echo $this->db->last_query();
		// die(" : File Path : ".__FILE__.": Line number : ".__LINE__);

  //       // $array = array('logo' => $logo, 'school_desc' => $school_desc, 'data' => $data);
  //       // $this->load->view('admission/' . $inv_view, $array);
  //       // $html = $this->output->get_output();
  //       // $this->load->library('pdf');
  //       // $this->dompdf->load_html($html);
  //       // $this->dompdf->set_paper($size, $orientation);
  //       // $this->dompdf->render();
  //       // $this->dompdf->stream("Certificate.pdf", array("Attachment" => FALSE));

	}


}
