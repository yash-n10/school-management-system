<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Certificate extends CI_Controller {
    
    public $page_code = 'certificate';
    public $page_id = '';
    public $page_perm = '----';
    
    public function __construct() {
        parent::__construct();

//        error_reporting(-1);
//        ini_set('display_errors', 1);       
// Access Control
        $this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");


        $this->id = $this->session->userdata('school_id');

        $this->school_desc = $this->dbconnection->select("school", "*", "id=" . $this->id . " and status = 1");

        if ($this->school_desc[0]->fee_type1 == 1) {
            $this->fee_cat1 = 2;
        } else {
            $this->fee_cat1 = 5;
        }

        if ($this->school_desc[0]->fee_type2 == 3) {
            $this->fee_cat2 = 4;
        } else {
            $this->fee_cat2 = 1;
        }
        $this->bank_name = $this->dbconnection->select("bank", "bank_code", "");

//            $this->month=$this->session->userdata('act_year_from');
        if ($this->id != 0) {
            $this->db->db_select('crmfeesclub_' . $this->id);
//                $this->academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year", "active='Y'");
        }

        $permission = $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
        $this->page_perm = !empty($permission) ? $permission[0]->permission : '----';
        $this->right_access = $this->page_perm;

        if (strpos($this->page_perm, '----') == true) {
            redirect(base_url(''), 'refresh');
        }
        
        $this->academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year,start_date,end_date,session", "status='Y' and active='Y'");
        $fetch_startyr = isset($this->academic_session[0]->start_date) ? explode('-', $this->academic_session[0]->start_date) : array('0');
        $this->session_start_yr = reset($fetch_startyr);

        $this->page_title = 'Certificate';
        $this->section = 'certificate/Certificate';
        $this->page_name = '';
        $this->customview = '';
    }

    public function index() {
        
        if (substr($this->right_access, 1, 1) != 'R') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->data['page_title'] = 'Certificate';
        $this->data['section'] = 'certificate';
        $this->data['page_name'] = 'certificates';
        $this->data['customview'] = '';
        $this->data['tc_data'] = $this->db->query('select t1.*,t2.admission_no from tc_passout as t1 join student as t2 on t1.student_id=t2.id where t1.status="TC"')->result();
        $this->data['fee_data'] = $this->dbconnection->select('student', '*', 'status="Y"');
        $this->data['bonafied_data'] = $this->db->query('select t1.*,t2.admission_no from tc_passout as t1 join student as t2 on t1.student_id=t2.id where t1.status="PASS"')->result();
        $this->load->view('index', $this->data);
    }

    public function Bonafied_certificate() {
        $page_title = 'Bonafied Certificate ';
//$array = array('view' => 'certificate/bonafied_certificate', 'page_title' => $page_title);
        $this->data['page_name'] = 'bonafied_certificate';
        $this->load->view('certificate/bonafied_certificate', $this->data);
    }

    public function certificate_pdf() {
        $id = $this->input->post('bonafied_certificate');
        $admission = $this->dbconnection->select('tc_passout', 'student_id', 'id=' . $id);
        $st_admission = $admission[0]->student_id;
        $college_id = $this->session->userdata('school_id');
        /* 		$reggistration_no = ;
          $college_id = $this->id; */
        /* $data = $this->dbconnection->select('collegefclb.college', '*', 'id=' . $college_id); */
        $logo = 'assets/img/' . $this->session->userdata('school_id') . '.JPG';
        /*        $pdf_id = $data[0]->result_pdf_id;
          $data_inv = $this->dbconnection->select('collegefclb.result_pdf', '*', 'id=' . $pdf_id); */
        $inv_view = 'bonafied_certificate1';
        $size = 'A4';
        /*        $invoice_demo_no = $data_inv[0]->result_pdf_no; */
        $orientation = 'potrate';
        /* $reg_no = $this->uri->segment('4');//$reggistration_no; */
        /* $this->db->db_select('crmfeesclub_'.$this->id);
         */
        /* $stud=$this->Mymodel->get_student_byreg($reg_no);
         */
        $data = $this->db->query('select t1.*,t2.class_name,t3.session from student as t1 join class as t2 on t1.class_id=t2.id join accedemic_session as t3 on t1.student_academicyear_id=t3.id where t1.id=' . $st_admission)->result();

        $school = $this->school_desc;
        $array = array('logo' => $logo, 'school_desc' => $school, 'data' => $data);
        $this->load->view('certificate/' . $inv_view, $array);
        $html = $this->output->get_output();
        $this->load->library('pdf');
        $this->dompdf->load_html($html);
        $this->dompdf->set_paper($size, $orientation);
        $this->dompdf->render();
        $this->dompdf->stream("Certificate.pdf", array("Attachment" => FALSE));
    }

    public function Bonafied_certificate1() {
        $page_title = 'Bonafied Certificate ';
//$array = array('view' => 'certificate/bonafied_certificate', 'page_title' => $page_title);
        $this->data['page_name'] = 'bonafied_certificate1';
        $this->load->view('certificate/bonafied_certificate1', $this->data);
    }

    public function fee_certificate_pdf() {
        $id = $this->input->post('fee_paid');
//$admission =$this->dbconnection->select('tc_passout','student_id','id='.$id);
//$st_admission=$admission[0]->student_id;
        $college_id = $this->session->userdata('school_id');
        /* 		$reggistration_no = ;
          $college_id = $this->id; */
        /* $data = $this->dbconnection->select('collegefclb.college', '*', 'id=' . $college_id); */
        $logo = 'assets/img/' . $this->session->userdata('school_id') . '.JPG';
        /*        $pdf_id = $data[0]->result_pdf_id;
          $data_inv = $this->dbconnection->select('collegefclb.result_pdf', '*', 'id=' . $pdf_id); */
        $inv_view = 'bonafied_certificate';
        $size = 'A4';
        /*        $invoice_demo_no = $data_inv[0]->result_pdf_no; */
        $orientation = 'landscape';
        /* $reg_no = $this->uri->segment('4');//$reggistration_no; */
        /* $this->db->db_select('crmfeesclub_'.$this->id);
         */
        /* $stud=$this->Mymodel->get_student_byreg($reg_no);
         */
        $data = $this->db->query('select t1.*,t2.class_name,t3.sec_name,t4.session    from student as t1 join class as t2 on t1.class_id=t2.id join section as t3 on t1.section_id=t3.id join accedemic_session as t4 on t1.student_academicyear_id=t4.id  where t1.id=' . $id)->result();

        $school = $this->school_desc;
        $array = array('logo' => $logo, 'school_desc' => $school, 'data' => $data);
        $this->load->view('certificate/' . $inv_view, $array);
        $html = $this->output->get_output();
        $this->load->library('pdf');
        $this->dompdf->load_html($html);
        $this->dompdf->set_paper($size, $orientation);
        $this->dompdf->render();
        $this->dompdf->stream("Certificate.pdf", array("Attachment" => FALSE));
    }

    public function School_leaving_certificate() {
        $page_title = 'School Leaving Certificate ';
//$array = array('view' => 'certificate/bonafied_certificate', 'page_title' => $page_title);
        $this->data['page_name'] = 'school_leaving_certificate';
        $this->load->view('certificate/school_leaving_certificate', $this->data);
    }

    public function tc_certificate_pdf() {
        $id = $this->input->post('transfer_certificate');
        $admission = $this->dbconnection->select('tc_passout', 'student_id', 'id=' . $id);
        $st_id = $admission[0]->student_id;
        $college_id = $this->session->userdata('school_id');
        /* 		$reggistration_no = ;
          $college_id = $this->id; */
        /* $data = $this->dbconnection->select('collegefclb.college', '*', 'id=' . $college_id); */
        $logo = 'assets/img/' . $this->session->userdata('school_id') . '.JPG';
        /*        $pdf_id = $data[0]->result_pdf_id;
          $data_inv = $this->dbconnection->select('collegefclb.result_pdf', '*', 'id=' . $pdf_id); */
        $inv_view = 'school_leaving_certificate';
        $size = 'A4';
        /*        $invoice_demo_no = $data_inv[0]->result_pdf_no; */
        $orientation = 'potrate';
        /* $reg_no = $this->uri->segment('4');//$reggistration_no; */
        /* $this->db->db_select('crmfeesclub_'.$this->id);
         */
        /* $stud=$this->Mymodel->get_student_byreg($reg_no);
         */
        $data = $this->db->query('select t1.*,t2.class_name,t3.sec_name from student as t1 join class as t2 on t1.class_id=t2.id join section as t3 on t1.section_id=t3.id where t1.id=' . $st_id)->result();

        $school = $this->school_desc;
        $array = array('logo' => $logo, 'school_desc' => $school, 'data' => $data);
        $this->load->view('certificate/' . $inv_view, $array);
        $html = $this->output->get_output();
        $this->load->library('pdf');
        $this->dompdf->load_html($html);
        $this->dompdf->set_paper($size, $orientation);
        $this->dompdf->render();
        $this->dompdf->stream("Certificate.pdf", array("Attachment" => FALSE));
    }

}
