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
        $this->data['fee_data'] = $this->dbconnection->select('student', '*', '');
        $this->data['bonafied_data'] = $this->db->query('select t1.*,t2.admission_no from tc_passout as t1 join student as t2 on t1.student_id=t2.id')->result();
        $this->data['academic_session'] = $this->dbconnection->select("accedemic_session", "*", "status='Y'");
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
        $logo = 'assets/img/' . $this->session->userdata('school_id') . '.JPG';
        if ($this->school_desc[0]->school_group == 'DAV') {
            $inv_view = 'bonafied_certificate_dav';
        } else {
            $inv_view = 'bonafied_certificate1';
        }
        $size = 'A4';
        $orientation = 'potrate';
        $data = $this->db->query('select t1.*,t2.class_name,t3.session from student as t1 join class as t2 on t1.class_id=t2.id join accedemic_session as t3 on t1.student_academicyear_id=t3.id where t1.id=' . $st_admission)->result();

        $school = $this->school_desc;
        $array = array('logo' => $logo, 'school_desc' => $school, 'data' => $data,'tc_data'=>$admission);
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
          error_reporting(-1);
       ini_set('display_errors', 1);
         $id = $this->input->post('fee_paid');
         $ses_id = $this->input->post('aca_session');
         $fee_ses_name=$this->dbconnection->select('accedemic_session','session','id='.$ses_id);
         $fee_session=$fee_ses_name[0]->session;
        $college_id = $this->session->userdata('school_id');
        $logo = 'assets/img/' . $this->session->userdata('school_id') . '.JPG';
        $inv_view = 'bonafied_certificate';
        $size = 'A4';
        $orientation = 'landscape';
        if($this->session->userdata('school_id')==35)
        {
            $data = $this->db->query("select fth.student_id,fth.year,fth.total_amount,ftd.amount,ftd.fee_cat_id,group_concat(ftd.month_no) as mn,s.first_name,s.middle_name,s.last_name,s.father_name,s.mother_name,s.admission_no,s.class_id,(select class_name from class where id=s.class_id) class_name,s.section_id,(select sec_name from section where id=s.section_id) section_name,ftd.class_fee_head_id,cfd.fee_id,(select fee_name from fee_master where id=cfd.fee_id) feename,sum(fee_amount) tuition_fee,cfd.fee_amount,s.stud_category,t4.session from fee_transaction_head fth,fee_transaction_det ftd,student s,class_fee_det cfd,class_fee_head cfh,accedemic_session t4 where fth.paid_status=1 and fth.status=1 and fth.id=ftd.fee_trans_head_id and cfd.fee_cat=ftd.fee_cat_id  and fth.student_id=s.id and cfh.id=cfd.class_fee_head_id and ftd.class_fee_head_id=cfh.id and s.stud_category=cfd.stud_cat and cfd.status=1 and cfh.status='Y' and fth.student_id=$id and s.student_academicyear_id=t4.id and cfd.fee_id=14 and fth.year=$ses_id group by cfd.fee_id")->result();
            $amt=$data[0]->tuition_fee;
            echo '<pre>';

            
        }
        else{
              $data = $this->db->query("select t1.*,t2.class_name,t3.sec_name,t4.session,t5.id,t5.year,t5.student_id,t5.total_amount,group_concat(t6.month_no) as mn,sum(t6.amount) as tuition_fee from student as t1 join class as t2 on t1.class_id=t2.id join section as t3 on t1.section_id=t3.id join accedemic_session as t4 on t1.student_academicyear_id=t4.id join fee_transaction_head t5 on t1.id=t5.student_id join fee_transaction_det t6 on t6.fee_trans_head_id=t5.id and t6.stud_category=t1.stud_category where  t5.status=1 and t5.paid_status=1 and t1.id='$id' and t5.year=$ses_id and t6.fee_cat_id in(2,5) group by t5.student_id")->result();
              $amt=$data[0]->tuition_fee;
        }
         $total_amt_words = $this->convert_number_to_words($amt);
        

        $school = $this->school_desc;
        $array = array('logo' => $logo, 'school_desc' => $school,'fee_session'=>$fee_session, 'data' => $data,'total_amt_words'=> $total_amt_words);
        $this->load->view('certificate/' . $inv_view, $array);
        $html = $this->output->get_output();
        $this->load->library('pdf');
        $this->dompdf->load_html($html);
        $this->dompdf->set_paper($size, $orientation);
        $this->dompdf->render();
        $this->dompdf->stream("Certificate.pdf", array("Attachment" => FALSE));
    }

     public function convert_number_to_words($number) {
        $hyphen = '-';
        $conjunction = ' and ';
        $separator = ', ';
        $negative = 'negative ';
        $decimal = ' point ';
        $dictionary = array(
            0 => 'zero',
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine',
            10 => 'ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'fourty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety',
            100 => 'hundred',
            1000 => 'thousand',
            1000000 => 'million',
            1000000000 => 'billion',
            1000000000000 => 'trillion',
            1000000000000000 => 'quadrillion',
            1000000000000000000 => 'quintillion'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
// overflow
            trigger_error(
                    'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $negative . $this->convert_number_to_words(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens = ((int) ($number / 10)) * 10;
                $units = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . $this->convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= $this->convert_number_to_words($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return $string;
    }

    public function School_leaving_certificate() {
        $page_title = 'School Leaving Certificate ';
//$array = array('view' => 'certificate/bonafied_certificate', 'page_title' => $page_title);
        $this->data['page_name'] = 'school_leaving_certificate';
        $this->load->view('certificate/school_leaving_certificate', $this->data);
    }

    public function tc_certificate_pdf() 
    {
    	$this->load->library('M_pdf');
        $id = $this->input->post('transfer_certificate');
        $admission = $this->dbconnection->select('tc_passout', 'student_id', 'id=' . $id);
        $st_id = $admission[0]->student_id;
        $college_id = $this->session->userdata('school_id');
        $logo = 'assets/img/' . $this->session->userdata('school_id') . '.JPG';
        if ($this->school_desc[0]->school_group == 'ARMY') {
            $inv_view = 'school_leaving_certificate_army';
        }
        else if ($this->school_desc[0]->school_group == 'DAV') {
            $inv_view = 'school_leaving_certificate_dav';
        } else {
            $inv_view = 'school_leaving_certificate';
        }
        $size = 'A4';
        $orientation = 'potrate';
        $data = $this->db->query('select t1.*,t2.class_name,t3.sec_name from student as t1 join class as t2 on t1.class_id=t2.id join section as t3 on t1.section_id=t3.id where t1.id=' . $st_id)->result();

        $school = $this->school_desc;
        $array = array('logo' => $logo, 'school_desc' => $school, 'data' => $data,'tc_data'=>$admission);
       
        
        $this->m_pdf->pdf->AddPage('P','','','','',
10,//margin_left
10,//margin_right
5,//maargin_top5
5,//margin_bootm
15,
3);
        // $this->load->view('certificate/' . $inv_view, $array);
        $html=$this->load->view('certificate/' . $inv_view,$array,true);
		$pdf_html= mb_convert_encoding($html, 'UTF-8', 'UTF-8');
        $this->m_pdf->pdf->WriteHTML($pdf_html);
        $this->m_pdf->pdf->Output();
        // $html = $this->output->get_output();
        // $this->load->library('pdf');
        // $this->dompdf->load_html($html);
        // $this->dompdf->set_paper($size, $orientation);
        // $this->dompdf->render();
        // $this->dompdf->stream("Certificate.pdf", array("Attachment" => FALSE));
    }
    
    
    
    public function direct_tc_certificate_pdf() {
        $this->load->library('M_pdf');
        $id = $this->uri->segment(4);
        $admission = $this->dbconnection->select('tc_passout', '*', 'student_id=' . $id);
        $st_id = $admission[0]->student_id;
        $college_id = $this->session->userdata('school_id');
        $logo = 'assets/img/' . $this->session->userdata('school_id') . '.JPG';


         if ($this->school_desc[0]->school_group == 'ARMY') {
            $inv_view = 'school_leaving_certificate_army';
        }
        else if ($this->school_desc[0]->school_group == 'DAV') {
            $inv_view = 'school_leaving_certificate_dav';
        } else {
            $inv_view = 'school_leaving_certificate';
        }
        $size = 'A4';
        /*        $invoice_demo_no = $data_inv[0]->result_pdf_no; */
        $orientation = 'potrate';
        /* $reg_no = $this->uri->segment('4');//$reggistration_no; */
        /* $this->db->db_select('crmfeesclub_'.$this->id);
         */
        /* $stud=$this->Mymodel->get_student_byreg($reg_no);
         */
        $data = $this->db->query('select t1.*,t2.class_name,t3.sec_name from student as t1 join class as t2 on t1.class_id=t2.id join section as t3 on t1.section_id=t3.id where t1.id=' . $id)->result();
        
        $school = $this->school_desc;
        $array = array('logo' => $logo, 'school_desc' => $school, 'data' => $data,'tc_data'=>$admission);
        $this->load->view('certificate/' . $inv_view, $array);

         $this->m_pdf->pdf->AddPage('P','','','','',
10,//margin_left
10,//margin_right
5,//maargin_top5
5,//margin_bootm
15,
3);
        // $this->load->view('certificate/' . $inv_view, $array);
        $html=$this->load->view('certificate/' . $inv_view,$array,true);
        $pdf_html= mb_convert_encoding($html, 'UTF-8', 'UTF-8');
        $this->m_pdf->pdf->WriteHTML($pdf_html);
        $this->m_pdf->pdf->Output();
        // $html = $this->output->get_output();
        // $this->load->library('pdf');
        // $this->dompdf->load_html($html);
        // $this->dompdf->set_paper($size, $orientation);
        // $this->dompdf->render();
        // $this->dompdf->stream("Certificate.pdf", array("Attachment" => FALSE));
    }



        public function sls_certificate_pdf() {
        $id = $this->input->post('slc_certificate');
        $admission = $this->dbconnection->select('tc_passout', 'student_id', 'id=' . $id);
        $st_admission = $admission[0]->student_id;
        $college_id = $this->session->userdata('school_id');
        $logo = 'assets/img/' . $this->session->userdata('school_id') . '.JPG';
        $inv_view = 'slc';
        $size = 'A4';
        $orientation = 'potrate';
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


    public function fee_certificate_pdf_annual() {
       //    error_reporting(-1);
       // ini_set('display_errors', 1);
         $id = $this->input->post('fee_paid');
        $college_id = $this->session->userdata('school_id');
        $logo = 'assets/img/' . $this->session->userdata('school_id') . '.JPG';
        $inv_view = 'fee_certificate_annual';
        $size = 'A4';
        $orientation = 'landscape';

        $ann_fee_data=$this->db->query("select fth.student_id,fth.total_amount,ftd.amount,ftd.fee_cat_id,s.first_name,s.admission_no,s.class_id,(select class_name from class where id=s.class_id) class_name,s.section_id,(select sec_name from section where id=s.section_id) section_name,ftd.class_fee_head_id,cfd.fee_id,(select fee_name from fee_master where id=cfd.fee_id) feename,sum(fee_amount) tot_amt,cfd.fee_amount,s.stud_category from fee_transaction_head fth,fee_transaction_det ftd,student s,class_fee_det cfd,class_fee_head cfh where fth.paid_status=1 and fth.status=1 and fth.id=ftd.fee_trans_head_id and cfd.fee_cat=ftd.fee_cat_id  and fth.student_id=s.id and cfh.id=cfd.class_fee_head_id and ftd.class_fee_head_id=cfh.id and s.stud_category=cfd.stud_cat and cfd.status=1 and cfh.status='Y' and fth.student_id=$id group by cfd.fee_id;")->result();

         $amt=$data[0]->tot;
         $total_amt_words = $this->convert_number_to_words($amt);
        

        $school = $this->school_desc;
        $array = array('logo' => $logo, 'school_desc' => $school, 'data' => $ann_fee_data,'total_amt_words'=> $total_amt_words);
        $this->load->view('certificate/' . $inv_view, $array);
        $html = $this->output->get_output();
        $this->load->library('pdf');
        $this->dompdf->load_html($html);
        $this->dompdf->set_paper($size, $orientation);
        $this->dompdf->render();
        $this->dompdf->stream("Certificate.pdf", array("Attachment" => FALSE));
    }


    public function character_certificate_pdf() {
        $id = $this->input->post('char_certificate');
        $admission = $this->dbconnection->select('tc_passout', '*', 'id=' . $id);
        $st_admission = $admission[0]->student_id;
        $college_id = $this->session->userdata('school_id');
        $logo = 'assets/img/' . $this->session->userdata('school_id') . '.JPG';
        $inv_view = 'character_certificate';
        $size = 'A4';
        $orientation = 'potrate';
        $data = $this->db->query('select t1.*,t2.class_name,t3.session from student as t1 join class as t2 on t1.class_id=t2.id join accedemic_session as t3 on t1.student_academicyear_id=t3.id where t1.id=' . $st_admission)->result();
        $school = $this->school_desc;
        $array = array('logo' => $logo, 'school_desc' => $school, 'data' => $data,'tc_data'=>$admission);
        $this->load->view('certificate/' . $inv_view, $array);
        $html = $this->output->get_output();
        $this->load->library('pdf');
        $this->dompdf->load_html($html);
        $this->dompdf->set_paper($size, $orientation);
        $this->dompdf->render();
        $this->dompdf->stream("Certificate.pdf", array("Attachment" => FALSE));
    }

}
