<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class StudentPrint extends CI_Controller {
    
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

    public function index() {

        $this->data['page_title'] = 'Student Record Print';
        $this->data['section'] = 'admission';
        $this->data['page_name'] = 'stu_award_list';
        $this->data['customview'] = '';
        $this->data['aclass'] = $this->dbconnection->select("class", "class_name,id", "status='Y'");
        $this->data['asection'] = $this->dbconnection->select("section", "sec_name,id", "status='Y'");
        $this->load->view('index', $this->data);
    }

    public function award_list()
    {
        $class_id = $this->input->post('class_list');
        $section_id = $this->input->post('section_list');

        $school_desc = $this->school_desc;
        $logo = 'assets/img/' . $this->session->userdata('school_id') . '.JPG';

        $inv_view = 'award_list_print';
        $size = 'A4';
        $orientation = 'potrate';
        $data = $this->db->query('select admission_no,first_name,middle_name,last_name,roll,class_id,(select class_name from class where id=student.class_id) as class_name,section_id,(select sec_name from section where id=student.section_id) as section_name from student where class_id="' . $class_id.'" and section_id="'.$section_id.'" and status="Y" order by roll asc')->result();
        
        $array = array('logo' => $logo, 'school_desc' => $school_desc, 'data' => $data);
        $this->load->view('admission/' . $inv_view, $array);
        $html = $this->output->get_output();
        $this->load->library('pdf');
        $this->dompdf->load_html($html);
        $this->dompdf->set_paper($size, $orientation);
        $this->dompdf->render();
        $this->dompdf->stream("Certificate.pdf", array("Attachment" => FALSE));

}


}
